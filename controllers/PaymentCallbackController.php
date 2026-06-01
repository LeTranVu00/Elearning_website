<?php
/**
 * ============================================================================
 * FILE: controllers/PaymentCallbackController.php
 * MỤC ĐÍCH: Xử lý callback từ Momo (IPN - Instant Payment Notification)
 * ============================================================================
 *
 * URL này được Momo gọi lại ở background sau khi thanh toán.
 * Momo sẽ POST request tới URL này với thông tin thanh toán.
 */

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/SessionManager.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../services/MomoService.php';

class PaymentCallbackController
{
    private Order $orderModel;
    private Enrollment $enrollmentModel;
    private Payment $paymentModel;
    private MomoService $momoService;

    public function __construct(
        Order $orderModel,
        Enrollment $enrollmentModel,
        Payment $paymentModel,
        MomoService $momoService
    ) {
        $this->orderModel = $orderModel;
        $this->enrollmentModel = $enrollmentModel;
        $this->paymentModel = $paymentModel;
        $this->momoService = $momoService;
    }

    /**
     * Xử lý callback từ Momo
     */
    public function handle(): void
    {
        // Momo gửi dữ liệu qua POST
        $params = $_POST;

        // Xác minh callback từ Momo
        $result = $this->momoService->verifyIPN($params);

        // Log callback (nên lưu vào database hoặc file để debug)
        $this->logCallback($params, $result);

        if (!$result['success']) {
            echo json_encode(['resultCode' => 1, 'message' => 'Xác minh thất bại']);
            exit;
        }

        $orderId = $result['orderId'];
        $transactionId = $result['transactionId'];

        // Lấy đơn hàng
        $order = $this->orderModel->findById($orderId);
        if (!$order) {
            echo json_encode(['resultCode' => 1, 'message' => 'Không tìm thấy đơn hàng']);
            exit;
        }

        // Kiểm tra nếu đơn hàng đã được xử lý rồi
        if ($order['trang_thai'] === 'completed') {
            echo json_encode(['resultCode' => 0, 'message' => 'Đơn hàng đã được xử lý']);
            exit;
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

        // Phản hồi thành công cho Momo (theo định dạng Momo: resultCode 0 = thành công)
        echo json_encode(['resultCode' => 0, 'message' => 'Xử lý thành công']);
        exit;
    }

    /**
     * Log callback từ VNPay để debug
     *
     * @param array $params Tham số nhận được
     * @param array $result Kết quả xác minh
     */
    private function logCallback(array $params, array $result): void
    {
        // Có thể lưu vào database hoặc file
        $logFile = __DIR__ . '/../logs/momo_callback.log';
        $logDir = dirname($logFile);

        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'params' => $params,
            'result' => $result,
        ];

        file_put_contents(
            $logFile,
            json_encode($logData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n\n",
            FILE_APPEND
        );
    }
}

// ============================================================================
// KHỞI CHẠY CONTROLLER
// ============================================================================
$conn = Database::getConnection();

(new PaymentCallbackController(
    new Order($conn),
    new Enrollment($conn),
    new Payment($conn),
    new MomoService()
))->handle();
