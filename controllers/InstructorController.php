<?php
/**
 * ============================================================================
 * FILE: controllers/InstructorController.php
 * MỤC ĐÍCH: Xử lý logic quản lý bài học/khóa học cho giảng viên
 * ============================================================================
 *
 * CHỨC NĂNG:
 * - Lấy danh sách khóa học của giảng viên
 * - Quản lý chương, bài học
 * - Upload file bài giảng, bài tập, tài liệu
 * - Quản lý link học trực tuyến
 */

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/SessionManager.php';
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Course.php';

class InstructorController extends BaseController
{
    private Lesson $lessonModel;
    private Course $courseModel;
    private string $uploadDir = __DIR__ . '/../assets/uploads/lessons/';

    public function __construct(Lesson $lessonModel, Course $courseModel)
    {
        $this->lessonModel = $lessonModel;
        $this->courseModel = $courseModel;
        
        // Tạo thư mục upload nếu chưa tồn tại
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    // =========================================================================
    // LẤY DANH SÁCH KHÓA HỌC CỦA GIẢNG VIÊN
    // =========================================================================

    /**
     * Lấy tất cả khóa học của giảng viên hiện tại
     */
    public function getMyCoursesAction()
    {
        if (!SessionManager::isLoggedIn()) {
            header('Location: index.php?page=login');
            exit;
        }

        $userId = SessionManager::getUserId();
        
        // Lấy khóa học nơi user là giảng viên
        $sql = 'SELECT * FROM khoa_hoc WHERE giang_vien_id = ? ORDER BY created_at DESC';
        $conn = Database::getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $courses;
    }

    // =========================================================================
    // QUẢN LÝ CHƯƠNG
    // =========================================================================

    /**
     * Tạo chương mới cho khóa học
     */
    public function createChapterAction(int $courseId, string $title, ?string $description = null): bool
    {
        // Kiểm tra quyền: giảng viên chỉ có thể quản lý khóa học của mình
        if (!$this->canEditCourse($courseId)) {
            return false;
        }

        return (bool)$this->lessonModel->createChapter($courseId, $title, $description);
    }

    /**
     * Cập nhật chương
     */
    public function updateChapterAction(int $chapterId, array $data): bool
    {
        // Kiểm tra quyền
        if (!$this->canEditChapter($chapterId)) {
            return false;
        }

        return $this->lessonModel->updateChapter($chapterId, $data);
    }

    /**
     * Xóa chương
     */
    public function deleteChapterAction(int $chapterId): bool
    {
        if (!$this->canEditChapter($chapterId)) {
            return false;
        }

        return $this->lessonModel->deleteChapter($chapterId);
    }

    // =========================================================================
    // QUẢN LÝ BÀI HỌC
    // =========================================================================

    /**
     * Tạo bài học mới
     */
    public function createLessonAction(int $courseId, ?int $chapterId, string $title, string $content): int|false
    {
        if (!$this->canEditCourse($courseId)) {
            return false;
        }

        // Đếm số bài học hiện tại để xác định thứ tự
        $lessons = $this->lessonModel->getLessonsByCourse($courseId);
        $order = count($lessons);

        return $this->lessonModel->createLesson($courseId, $chapterId, $title, $content, $order);
    }

    /**
     * Cập nhật bài học
     */
    public function updateLessonAction(int $lessonId, array $data): bool
    {
        if (!$this->canEditLesson($lessonId)) {
            return false;
        }

        return $this->lessonModel->updateLesson($lessonId, $data);
    }

    /**
     * Xóa bài học
     */
    public function deleteLessonAction(int $lessonId): bool
    {
        if (!$this->canEditLesson($lessonId)) {
            return false;
        }

        return $this->lessonModel->deleteLesson($lessonId);
    }

    // =========================================================================
    // UPLOAD TÀI LIỆU
    // =========================================================================

    /**
     * Upload file bài giảng/bài tập/tài liệu
     */
    public function uploadResourceAction(int $lessonId, string $type, $uploadedFile, ?string $description = null): array
    {
        // Kiểm tra quyền
        if (!$this->canEditLesson($lessonId)) {
            return ['success' => false, 'message' => 'Không có quyền chỉnh sửa bài học này'];
        }

        // Kiểm tra file
        if (!isset($uploadedFile) || $uploadedFile['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'Lỗi upload file'];
        }

        // Validate loại file
        $allowedTypes = ['lecture', 'exercise', 'resource'];
        if (!in_array($type, $allowedTypes)) {
            return ['success' => false, 'message' => 'Loại tài liệu không hợp lệ'];
        }

        // Validate size (max 50MB)
        $maxSize = 50 * 1024 * 1024;
        if ($uploadedFile['size'] > $maxSize) {
            return ['success' => false, 'message' => 'File quá lớn (tối đa 50MB)'];
        }

        // Tạo tên file an toàn
        $original_name = basename($uploadedFile['name']);
        $file_extension = pathinfo($original_name, PATHINFO_EXTENSION);
        $safe_name = 'lesson_' . $lessonId . '_' . time() . '_' . uniqid() . '.' . $file_extension;
        
        $upload_path = $this->uploadDir . $safe_name;

        // Move file
        if (!move_uploaded_file($uploadedFile['tmp_name'], $upload_path)) {
            return ['success' => false, 'message' => 'Không thể lưu file'];
        }

        // Lưu vào database
        $resourceId = $this->lessonModel->addResource(
            $lessonId,
            $type,
            $original_name,
            'assets/uploads/lessons/' . $safe_name,
            null,
            $description,
            $uploadedFile['size']
        );

        if (!$resourceId) {
            unlink($upload_path); // Xóa file nếu lưu database thất bại
            return ['success' => false, 'message' => 'Lỗi lưu thông tin file'];
        }

        return [
            'success' => true,
            'message' => 'Upload thành công',
            'resourceId' => $resourceId,
            'fileName' => $original_name
        ];
    }

    /**
     * Thêm link học trực tuyến (Zoom, Teams, v.v.)
     */
    public function addOnlineLinkAction(int $lessonId, string $url, string $description = ''): array
    {
        if (!$this->canEditLesson($lessonId)) {
            return ['success' => false, 'message' => 'Không có quyền chỉnh sửa bài học này'];
        }

        // Validate URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return ['success' => false, 'message' => 'URL không hợp lệ'];
        }

        $resourceId = $this->lessonModel->addResource(
            $lessonId,
            'link',
            'Link học trực tuyến',
            null,
            $url,
            $description ?: 'Link học trực tuyến'
        );

        if (!$resourceId) {
            return ['success' => false, 'message' => 'Lỗi thêm link'];
        }

        return [
            'success' => true,
            'message' => 'Thêm link thành công',
            'resourceId' => $resourceId
        ];
    }

    /**
     * Xóa tài liệu
     */
    public function deleteResourceAction(int $resourceId): array
    {
        // Lấy thông tin tài liệu
        $conn = Database::getConnection();
        $sql = 'SELECT * FROM tai_lieu_bai_hoc WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $resourceId);
        $stmt->execute();
        $resource = $stmt->get_result()->fetch_assoc();

        if (!$resource) {
            return ['success' => false, 'message' => 'Tài liệu không tồn tại'];
        }

        // Kiểm tra quyền
        if (!$this->canEditLesson($resource['bai_hoc_id'])) {
            return ['success' => false, 'message' => 'Không có quyền xóa tài liệu này'];
        }

        // Xóa file nếu có
        if ($resource['duong_dan_file'] && file_exists(__DIR__ . '/../' . $resource['duong_dan_file'])) {
            unlink(__DIR__ . '/../' . $resource['duong_dan_file']);
        }

        // Xóa từ database
        if ($this->lessonModel->deleteResource($resourceId)) {
            return ['success' => true, 'message' => 'Xóa tài liệu thành công'];
        }

        return ['success' => false, 'message' => 'Lỗi xóa tài liệu'];
    }

    // =========================================================================
    // KIỂM TRA QUYỀN
    // =========================================================================

    /**
     * Kiểm tra xem người dùng có thể chỉnh sửa khóa học không
     */
    private function canEditCourse(int $courseId): bool
    {
        if (!SessionManager::isLoggedIn()) {
            return false;
        }

        $userId = SessionManager::getUserId();
        $conn = Database::getConnection();
        
        $sql = 'SELECT id FROM khoa_hoc WHERE id = ? AND giang_vien_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $courseId, $userId);
        $stmt->execute();
        
        return $stmt->get_result()->num_rows > 0;
    }

    /**
     * Kiểm tra xem người dùng có thể chỉnh sửa chương không
     */
    private function canEditChapter(int $chapterId): bool
    {
        if (!SessionManager::isLoggedIn()) {
            return false;
        }

        $userId = SessionManager::getUserId();
        $conn = Database::getConnection();
        
        $sql = 'SELECT c.id FROM chuong c 
                JOIN khoa_hoc kh ON c.khoa_hoc_id = kh.id 
                WHERE c.id = ? AND kh.giang_vien_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $chapterId, $userId);
        $stmt->execute();
        
        return $stmt->get_result()->num_rows > 0;
    }

    /**
     * Kiểm tra xem người dùng có thể chỉnh sửa bài học không
     */
    private function canEditLesson(int $lessonId): bool
    {
        if (!SessionManager::isLoggedIn()) {
            return false;
        }

        $userId = SessionManager::getUserId();
        $conn = Database::getConnection();
        
        $sql = 'SELECT b.id FROM bai_hoc b 
                JOIN khoa_hoc kh ON b.khoa_hoc_id = kh.id 
                WHERE b.id = ? AND kh.giang_vien_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $lessonId, $userId);
        $stmt->execute();
        
        return $stmt->get_result()->num_rows > 0;
    }
}
?>
