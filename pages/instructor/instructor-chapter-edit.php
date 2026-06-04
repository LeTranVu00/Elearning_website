<?php
/**
 * ============================================================================
 * FILE: pages/instructor/instructor-chapter-edit.php
 * MỤC ĐÍCH: Chỉnh sửa thông tin chương
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
    echo '<div class="alert alert-danger">Chương không tồn tại</div>';
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
    echo '<div class="alert alert-danger">Bạn không có quyền chỉnh sửa chương này</div>';
    exit;
}

$lesson = new Lesson($conn);
$controller = new InstructorController($lesson, new \Course($conn));

// Xử lý cập nhật
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    if ($action === 'update_chapter') {
        $title = trim($_POST['chapter_title'] ?? '');
        $description = trim($_POST['chapter_description'] ?? '');
        
        if (empty($title)) {
            $message = 'Tiêu đề chương không được để trống';
            $messageType = 'danger';
        } elseif ($controller->updateChapterAction($chapterId, [
            'tieu_de' => $title,
            'mo_ta' => $description ?: null
        ])) {
            $message = 'Cập nhật chương thành công';
            $messageType = 'success';
            $chapter['tieu_de'] = $title;
            $chapter['mo_ta'] = $description;
        } else {
            $message = 'Lỗi khi cập nhật chương';
            $messageType = 'danger';
        }
    }
}
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <a href="index.php?page=instructor-course&id=<?= $chapter['khoa_hoc_id'] ?>" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">✏️ Chỉnh sửa Chương</h5>
                </div>
                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-<?= $messageType ?> alert-dismissible fade show">
                            <?= htmlspecialchars($message) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <input type="hidden" name="action" value="update_chapter">
                        
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề chương *</label>
                            <input type="text" name="chapter_title" class="form-control" 
                                   value="<?= htmlspecialchars($chapter['tieu_de']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea name="chapter_description" class="form-control" rows="4"><?= htmlspecialchars($chapter['mo_ta'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu
                            </button>
                            <a href="index.php?page=instructor-course&id=<?= $chapter['khoa_hoc_id'] ?>" class="btn btn-secondary">
                                Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
