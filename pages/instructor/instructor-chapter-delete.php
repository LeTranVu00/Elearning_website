<?php
/**
 * ============================================================================
 * FILE: pages/instructor/instructor-chapter-delete.php
 * MỤC ĐÍCH: Xóa chương (nội dung này được gọi từ AJAX/form)
 * ============================================================================
 */

require_once __DIR__ . '/../../core/SessionManager.php';
require_once __DIR__ . '/../../core/Database.php';
require_once __DIR__ . '/../../models/Lesson.php';
require_once __DIR__ . '/../../controllers/InstructorController.php';

// Kiểm tra đăng nhập
if (!SessionManager::isLoggedIn()) {
    header('Location: index.php?page=login');
    exit;
}

$userId = SessionManager::getUserId();
$chapterId = (int)($_GET['id'] ?? 0);

if ($chapterId <= 0) {
    header('Location: index.php?page=instructor-courses');
    exit;
}

$conn = Database::getConnection();

// Lấy thông tin chương
$sql = 'SELECT c.*, kh.id as khoa_hoc_id FROM chuong c 
        JOIN khoa_hoc kh ON c.khoa_hoc_id = kh.id 
        WHERE c.id = ? AND kh.giang_vien_id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $chapterId, $userId);
$stmt->execute();
$chapter = $stmt->get_result()->fetch_assoc();

if (!$chapter) {
    $_SESSION['error'] = 'Chương không tồn tại hoặc bạn không có quyền xóa';
    header('Location: index.php?page=instructor-courses');
    exit;
}

$courseId = $chapter['khoa_hoc_id'];

// Xóa chương
$lesson = new Lesson($conn);
$controller = new InstructorController($lesson, new \Course($conn));

if ($controller->deleteChapterAction($chapterId)) {
    $_SESSION['success'] = 'Xóa chương thành công';
} else {
    $_SESSION['error'] = 'Lỗi khi xóa chương';
}

header('Location: index.php?page=instructor-course&id=' . $courseId);
exit;
