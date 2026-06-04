<?php
/**
 * ============================================================================
 * FILE: pages/instructor/instructor-lesson-delete.php
 * MỤC ĐÍCH: Xóa bài học
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
$lessonId = (int)($_GET['id'] ?? 0);

if ($lessonId <= 0) {
    header('Location: index.php?page=instructor-courses');
    exit;
}

$conn = Database::getConnection();

// Lấy thông tin bài học
$sql = 'SELECT b.*, kh.id as khoa_hoc_id FROM bai_hoc b 
        JOIN khoa_hoc kh ON b.khoa_hoc_id = kh.id 
        WHERE b.id = ? AND kh.giang_vien_id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $lessonId, $userId);
$stmt->execute();
$lessonData = $stmt->get_result()->fetch_assoc();

if (!$lessonData) {
    $_SESSION['error'] = 'Bài học không tồn tại hoặc bạn không có quyền xóa';
    header('Location: index.php?page=instructor-courses');
    exit;
}

$courseId = $lessonData['khoa_hoc_id'];

// Xóa bài học
$lesson = new Lesson($conn);
$controller = new InstructorController($lesson, new \Course($conn));

if ($controller->deleteLessonAction($lessonId)) {
    $_SESSION['success'] = 'Xóa bài học thành công';
} else {
    $_SESSION['error'] = 'Lỗi khi xóa bài học';
}

header('Location: index.php?page=instructor-course&id=' . $courseId);
exit;
