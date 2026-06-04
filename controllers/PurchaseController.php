<?php
/**
 * ============================================================================
 * FILE: controllers/PurchaseController.php
 * MỤC ĐÍCH: Xử lý logic mua khóa học
 * ============================================================================
 *
 * LUỒNG:
 * 1. User click "Mua khóa học" → GET request tới controller với ?action=checkout&course_id=X
 * 2. Kiểm tra: user đã đăng nhập? đã mua khóa học này chưa?
 * 3. Tạo đơn hàng + thanh toán → lấy URL VNPay
 * 4. Redirect tới VNPay để user thanh toán
 */

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/SessionManager.php';
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../services/MomoService.php';

class PurchaseController extends BaseController
{
    private Order $orderModel;
    private Enrollment $enrollmentModel;
    private Payment $paymentModel;
    private Course $courseModel;
    private MomoService $momoService;

    public function __construct(
        Order $orderModel,
        Enrollment $enrollmentModel,
        Payment $paymentModel,
        Course $courseModel,
        MomoService $momoService
    ) {
        $this->orderModel = $orderModel;
        $this->enrollmentModel = $enrollmentModel;
        $this->paymentModel = $paymentModel;
        $this->courseModel = $courseModel;
        $this->momoService = $momoService;
    }

    /**
     * Xử lý các action khác nhau
     */
    public function handle(): void
    {
        $action = $this->getQuery('action', 'checkout');

        if ($action === 'checkout') {
            $this->checkout();
        } elseif ($action === 'success') {
            $this->success();
        } elseif ($action === 'cancel') {
            $this->cancel();
        } else {
            $this->redirect('../pages/home.php');
        }
    }

    /**
     * Trang checkout — xử lý tạo đơn hàng và redirect tới VNPay
     */
    private function checkout(): void
    {
        // Kiểm tra đăng nhập
        if (!SessionManager::isLoggedIn()) {
            SessionManager::setErrors(['❌ Vui lòng đăng nhập trước khi mua khóa học']);
            $this->redirect('../pages/login.php');
        }

        // Lấy course_id từ query string
        $courseId = (int)$this->getQuery('course_id', 0);
        if ($courseId <= 0) {
            SessionManager::setErrors(['❌ Khóa học không hợp lệ']);
            $this->redirect('../pages/courses.php');
        }

        // Lấy thông tin khóa học
        $course = $this->courseModel->getById($courseId);
        if (!$course) {
            SessionManager::setErrors(['❌ Khóa học không tồn tại']);
            $this->redirect('../pages/courses.php');
        }

        $userId = SessionManager::get('user_id');

        // Kiểm tra user đã mua khóa học này chưa
        if ($this->enrollmentModel->isEnrolled($userId, $courseId)) {
            SessionManager::setErrors(['❌ Bạn đã mua khóa học này rồi']);
            $this->redirect('../pages/course-detail.php?id=' . $courseId);
        }

        // --- TẠM THỜI BYPASS THANH TOÁN (Do cấu trúc DB chưa đồng bộ) ---
        // 1. Ghi danh (enroll) ngay lập tức
        $isEnrolled = $this->enrollmentModel->enroll($userId, $courseId);
        if (!$isEnrolled) {
            SessionManager::setErrors(['❌ Có lỗi xảy ra khi ghi danh khóa học.']);
            $this->redirect('../pages/course-detail.php?id=' . $courseId);
        }

        // 2. Lưu thông báo thành công
        SessionManager::set('purchase_success', true);
        
        // 3. Chuyển hướng về trang chủ
        $this->redirect('../pages/home.php');

        /*
        // MÃ CŨ (Đang bị lỗi do DB không có bảng don_hang)
        // Tạo đơn hàng
        $orderId = $this->orderModel->create($userId, (float)$course['gia']);
        if (!$orderId) {
            SessionManager::setErrors(['❌ Lỗi khi tạo đơn hàng']);
            $this->redirect('../pages/course-detail.php?id=' . $courseId);
        }

        // Thêm khóa học vào đơn hàng
        $this->orderModel->addItem($orderId, $courseId, (float)$course['gia']);

        // Tạo bản ghi thanh toán
        $paymentId = $this->paymentModel->create($orderId, 'manual', (float)$course['gia']);
        if (!$paymentId) {
            SessionManager::setErrors(['❌ Lỗi khi tạo thanh toán']);
            $this->redirect('../pages/course-detail.php?id=' . $courseId);
        }

        // Cập nhật trạng thái đơn hàng
        $this->orderModel->updateStatus($orderId, 'completed');

        // Cập nhật trạng thái thanh toán
        $this->paymentModel->updateStatus((int)$paymentId, 'success');
        */
    }

    /**
     * Sau khi thanh toán thành công (callback từ VNPay)
     */
    private function success(): void
    {
        // Xác minh phản hồi từ Momo
        $result = $this->momoService->verifyReturn($_GET);

        if (!$result['success']) {
            SessionManager::setErrors([$result['message']]);
            $this->redirect('../pages/home.php');
        }

        $orderId = $result['orderId'];
        $transactionId = $result['transactionId'];

        // Lấy đơn hàng
        $order = $this->orderModel->findById($orderId);
        if (!$order) {
            SessionManager::setErrors(['❌ Không tìm thấy đơn hàng']);
            $this->redirect('../pages/home.php');
        }

        // Lấy chi tiết đơn hàng (khóa học)
        $items = $this->orderModel->getItems($orderId);

        // Cập nhật trạng thái đơn hàng
        $this->orderModel->updateStatus($orderId, 'completed');

        // Lấy thanh toán
        $payment = $this->paymentModel->findByOrderId($orderId);
        if ($payment) {
            $this->paymentModel->updateTransactionId((int)$payment['id'], $transactionId);
            $this->paymentModel->updateStatus((int)$payment['id'], 'success');
        }

        // Đăng ký user cho tất cả khóa học trong đơn hàng
        $userId = (int)$order['user_id'];
        foreach ($items as $item) {
            $this->enrollmentModel->enroll($userId, (int)$item['khoa_hoc_id']);
        }

        // Lưu thông báo thành công
        SessionManager::set('purchase_success', true);
        $this->redirect('../pages/home.php');
    }

    /**
     * Người dùng hủy thanh toán
     */
    private function cancel(): void
    {
        SessionManager::setErrors(['❌ Bạn đã hủy thanh toán']);
        $this->redirect('../pages/courses.php');
    }
}

// ============================================================================
// KHỞI CHẠY CONTROLLER
// ============================================================================
$conn = Database::getConnection();

(new PurchaseController(
    new Order($conn),
    new Enrollment($conn),
    new Payment($conn),
    new Course($conn),
    new MomoService()
))->handle();
