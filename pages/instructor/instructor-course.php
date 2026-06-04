<?php
/**
 * ============================================================================
 * FILE: pages/instructor/instructor-course.php
 * MỤC ĐÍCH: Quản lý chương, bài học, tài liệu của một khóa học
 * ============================================================================
 */

require_once __DIR__ . '/../../core/SessionManager.php';
require_once __DIR__ . '/../../core/Database.php';
require_once __DIR__ . '/../../models/Lesson.php';
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../controllers/InstructorController.php';

// Kiểm tra đăng nhập
if (!SessionManager::isLoggedIn()) {
    header('Location: index.php?page=login');
    exit;
}

$userId = SessionManager::getUserId();
$courseId = (int)($_GET['id'] ?? 0);

if ($courseId <= 0) {
    echo '<div class="alert alert-danger">Khóa học không tồn tại</div>';
    exit;
}

$conn = Database::getConnection();

// Kiểm tra quyền
$sql = 'SELECT * FROM khoa_hoc WHERE id = ? AND giang_vien_id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $courseId, $userId);
$stmt->execute();
$course = $stmt->get_result()->fetch_assoc();

if (!$course) {
    echo '<div class="alert alert-danger">Bạn không có quyền quản lý khóa học này</div>';
    exit;
}

// Khởi tạo model và controller
$lessonModel = new Lesson($conn);
$courseModel = new Course($conn);
$controller = new InstructorController($lessonModel, $courseModel);

// Xử lý action
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    switch ($action) {
        case 'add_chapter':
            $title = trim($_POST['chapter_title'] ?? '');
            $description = trim($_POST['chapter_description'] ?? '');
            if (empty($title)) {
                $message = 'Tiêu đề chương không được để trống';
                $messageType = 'danger';
            } elseif ($controller->createChapterAction($courseId, $title, $description ?: null)) {
                $message = 'Thêm chương thành công';
                $messageType = 'success';
            } else {
                $message = 'Lỗi khi thêm chương';
                $messageType = 'danger';
            }
            break;

        case 'add_lesson':
            $chapterId = (int)($_POST['chapter_id'] ?? 0) ?: null;
            $lessonTitle = trim($_POST['lesson_title'] ?? '');
            $lessonContent = trim($_POST['lesson_content'] ?? '');
            
            if (empty($lessonTitle)) {
                $message = 'Tiêu đề bài học không được để trống';
                $messageType = 'danger';
            } elseif ($controller->createLessonAction($courseId, $chapterId, $lessonTitle, $lessonContent)) {
                $message = 'Thêm bài học thành công';
                $messageType = 'success';
            } else {
                $message = 'Lỗi khi thêm bài học';
                $messageType = 'danger';
            }
            break;
    }
}

// Lấy danh sách chương
$chapters = $lessonModel->getChaptersByCourse($courseId);

// Lấy tất cả bài học (không theo chương)
$allLessons = $lessonModel->getLessonsByCourse($courseId);
?>

<div class="container-fluid my-4">
    <div class="row">
        <div class="col-md-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="index.php?page=instructor-courses" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <h1 class="d-inline-block ms-3 mb-0">📖 <?= htmlspecialchars($course['ten_khoa_hoc']) ?></h1>
                </div>
            </div>

            <!-- Notification -->
            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType ?> alert-dismissible fade show">
                    <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Chương & Bài học -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">📚 Chương và Bài học</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($chapters) && empty($allLessons)): ?>
                                <p class="text-muted">Chưa có chương hoặc bài học nào</p>
                            <?php else: ?>
                                <!-- Danh sách Chương -->
                                <?php foreach ($chapters as $chapter): ?>
                                    <div class="chapter-item mb-3 p-3 border rounded">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">
                                                <i class="fas fa-folder"></i>
                                                <?= htmlspecialchars($chapter['tieu_de']) ?>
                                            </h6>
                                            <div>
                                                <a href="index.php?page=instructor-chapter-edit&id=<?= $chapter['id'] ?>" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger" onclick="deleteChapter(<?= $chapter['id'] ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <?php if ($chapter['mo_ta']): ?>
                                            <p class="text-muted small mb-2"><?= htmlspecialchars($chapter['mo_ta']) ?></p>
                                        <?php endif; ?>

                                        <!-- Bài học trong chương -->
                                        <?php
                                        $lessonsInChapter = $lessonModel->getLessonsByChapter($chapter['id']);
                                        if (!empty($lessonsInChapter)):
                                        ?>
                                            <div class="ms-3 mt-2">
                                                <?php foreach ($lessonsInChapter as $lesson): ?>
                                                    <div class="lesson-item p-2 mb-2 bg-light rounded d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <i class="fas fa-file-alt"></i>
                                                            <a href="index.php?page=instructor-lesson-edit&id=<?= $lesson['id'] ?>" class="text-decoration-none">
                                                                <?= htmlspecialchars($lesson['tieu_de']) ?>
                                                            </a>
                                                        </div>
                                                        <div>
                                                            <a href="index.php?page=instructor-lesson-edit&id=<?= $lesson['id'] ?>" class="btn btn-sm btn-info">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button class="btn btn-sm btn-danger" onclick="deleteLesson(<?= $lesson['id'] ?>)">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>

                                <!-- Bài học không thuộc chương nào -->
                                <?php
                                $lessonsWithoutChapter = array_filter($allLessons, function($lesson) {
                                    return !$lesson['chuong_id'];
                                });
                                if (!empty($lessonsWithoutChapter)):
                                ?>
                                    <div class="mt-3 pt-3 border-top">
                                        <h6 class="mb-3"><i class="fas fa-list"></i> Bài học khác</h6>
                                        <?php foreach ($lessonsWithoutChapter as $lesson): ?>
                                            <div class="lesson-item p-2 mb-2 bg-light rounded d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-file-alt"></i>
                                                    <a href="index.php?page=instructor-lesson-edit&id=<?= $lesson['id'] ?>" class="text-decoration-none">
                                                        <?= htmlspecialchars($lesson['tieu_de']) ?>
                                                    </a>
                                                </div>
                                                <div>
                                                    <a href="index.php?page=instructor-lesson-edit&id=<?= $lesson['id'] ?>" class="btn btn-sm btn-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger" onclick="deleteLesson(<?= $lesson['id'] ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Form Thêm -->
                <div class="col-lg-4">
                    <!-- Form Thêm Chương -->
                    <div class="card mb-3">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">➕ Thêm Chương Mới</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <input type="hidden" name="action" value="add_chapter">
                                
                                <div class="mb-3">
                                    <label class="form-label">Tiêu đề chương *</label>
                                    <input type="text" name="chapter_title" class="form-control" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Mô tả</label>
                                    <textarea name="chapter_description" class="form-control" rows="3" placeholder="Mô tả chương..."></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-plus"></i> Thêm chương
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Form Thêm Bài Học -->
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">➕ Thêm Bài Học Mới</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <input type="hidden" name="action" value="add_lesson">
                                
                                <div class="mb-3">
                                    <label class="form-label">Chọn chương (tùy chọn)</label>
                                    <select name="chapter_id" class="form-select">
                                        <option value="">-- Không chọn chương --</option>
                                        <?php foreach ($chapters as $chapter): ?>
                                            <option value="<?= $chapter['id'] ?>">
                                                <?= htmlspecialchars($chapter['tieu_de']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Tiêu đề bài học *</label>
                                    <input type="text" name="lesson_title" class="form-control" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Nội dung bài học</label>
                                    <textarea name="lesson_content" class="form-control" rows="4" placeholder="Nhập nội dung bài học..."></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-info w-100 text-white">
                                    <i class="fas fa-plus"></i> Thêm bài học
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteChapter(chapterId) {
    if (confirm('Bạn chắc chắn muốn xóa chương này? Tất cả bài học trong chương sẽ bị xóa!')) {
        window.location.href = 'index.php?page=instructor-chapter-delete&id=' + chapterId;
    }
}

function deleteLesson(lessonId) {
    if (confirm('Bạn chắc chắn muốn xóa bài học này?')) {
        window.location.href = 'index.php?page=instructor-lesson-delete&id=' + lessonId;
    }
}
</script>
