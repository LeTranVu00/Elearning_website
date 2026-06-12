<?php
/**
 * ============================================================================
 * FILE: controllers/EnrollmentController.php
 * MỤC ĐÍCH: Xử lý logic đăng ký học trực tiếp (miễn phí)
 * ============================================================================
 */

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/SessionManager.php';
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../models/Course.php';

class EnrollmentController extends BaseController
{
    private Enrollment $enrollmentModel;
    private Course $courseModel;

    public function __construct(Enrollment $enrollmentModel, Course $courseModel)
    {
        $this->enrollmentModel = $enrollmentModel;
        $this->courseModel = $courseModel;
    }

    public function handle(): void
    {
        $action = $this->getQuery('action', 'enroll');

        if ($action === 'enroll') {
            $this->enroll();
        } else {
            $this->redirect('../pages/home.php');
        }
    }

    private function enroll(): void
    {
        // 1. Kiểm tra đăng nhập
        if (!SessionManager::isLoggedIn()) {
            SessionManager::setErrors(['❌ Vui lòng đăng nhập để bắt đầu học.']);
            $this->redirect('../pages/login.php');
        }

        // 2. Lấy ID khóa học
        $courseId = (int)$this->getQuery('course_id', 0);
        if ($courseId <= 0) {
            SessionManager::setErrors(['❌ Khóa học không hợp lệ.']);
            $this->redirect('../pages/courses.php');
        }

        // 3. Lấy thông tin khóa học
        $course = $this->courseModel->getById($courseId);
        if (!$course) {
            SessionManager::setErrors(['❌ Khóa học không tồn tại.']);
            $this->redirect('../pages/courses.php');
        }

        $userId = SessionManager::get('user_id');

        // 4. Kiểm tra user đã ghi danh chưa
        if ($this->enrollmentModel->isEnrolled($userId, $courseId)) {
            // Đã ghi danh, chuyển thẳng vào trang chi tiết khóa học / trang học
            $this->redirect('../pages/course-detail.php?id=' . $courseId);
        }

        // 5. Ghi danh
        $isEnrolled = $this->enrollmentModel->enroll($userId, $courseId);
        if (!$isEnrolled) {
            SessionManager::setErrors(['❌ Có lỗi xảy ra khi đăng ký khóa học. Vui lòng thử lại.']);
            $this->redirect('../pages/course-detail.php?id=' . $courseId);
        }

        // 6. Thông báo thành công và chuyển hướng
        SessionManager::set('purchase_success', true); // Dùng lại key này hoặc đổi tên nếu view đang phụ thuộc vào nó
        $this->redirect('../pages/course-detail.php?id=' . $courseId);
    }
}

// Khởi chạy
$conn = Database::getConnection();
(new EnrollmentController(
    new Enrollment($conn),
    new Course($conn)
))->handle();
