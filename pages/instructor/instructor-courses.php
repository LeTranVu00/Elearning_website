<?php
/**
 * ============================================================================
 * FILE: pages/instructor/instructor-courses.php
 * MỤC ĐÍCH: Hiển thị danh sách khóa học của giảng viên
 * ============================================================================
 */

require_once __DIR__ . '/../../core/SessionManager.php';
require_once __DIR__ . '/../../core/Database.php';
require_once __DIR__ . '/../../models/Lesson.php';
require_once __DIR__ . '/../../controllers/InstructorController.php';

// Kiểm tra đăng nhập
if (!SessionManager::isLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

// Kiểm tra quyền giảng viên
$userId = SessionManager::getUserId();
$conn = Database::getConnection();
$sql = 'SELECT vai_tro FROM nguoi_dung WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user || ($user['vai_tro'] !== 'instructor' && $user['vai_tro'] !== 'admin')) {
    echo '<div class="alert alert-danger">Bạn không có quyền truy cập trang này</div>';
    exit;
}

// Khởi tạo controller
$lessonModel = new Lesson($conn);
$courseModel = new \Course($conn);
$controller = new InstructorController($lessonModel, $courseModel);

// Lấy danh sách khóa học của giảng viên
$sql = 'SELECT * FROM khoa_hoc WHERE giang_vien_id = ? ORDER BY created_at DESC';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Xử lý action từ form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    if ($action === 'create_chapter') {
        $courseId = (int)$_POST['course_id'];
        $title = trim($_POST['chapter_title']);
        
        if (empty($title)) {
            $_SESSION['error'] = 'Tiêu đề chương không được để trống';
        } else {
            if ($controller->createChapterAction($courseId, $title)) {
                $_SESSION['success'] = 'Tạo chương thành công';
                header('Location: instructor-course.php?id=' . $courseId);
                exit;
            } else {
                $_SESSION['error'] = 'Lỗi khi tạo chương';
            }
        }
    }
}

// Hiển thị notification
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>📚 Quản lý khóa học của tôi</h1>
                <a href="instructor-create-course.php" class="btn btn-success btn-lg">
                    <i class="fa-solid fa-plus"></i> Tạo khóa học mới
                </a>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= htmlspecialchars($success) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Nếu chưa có khóa học -->
            <?php if (empty($courses)): ?>
                <div class="alert alert-info text-center">
                    <p>🎓 Bạn chưa có khóa học nào.</p>
                    <a href="instructor-create-course.php" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Tạo khóa học ngay
                    </a>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($courses as $course): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card shadow-sm h-100">
                                <?php if ($course['anh']): ?>
                                    <img src="<?= htmlspecialchars($course['anh']) ?>" class="card-img-top" alt="<?= htmlspecialchars($course['ten_khoa_hoc']) ?>" style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-book" style="font-size: 3rem;"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($course['ten_khoa_hoc']) ?></h5>
                                    <p class="card-text text-muted small">
                                        <?= htmlspecialchars(substr($course['mo_ta_ngan'] ?? '', 0, 100)) ?>...
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-secondary">
                                            <?php
                                            $sql = 'SELECT COUNT(*) as total FROM bai_hoc WHERE khoa_hoc_id = ?';
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bind_param('i', $course['id']);
                                            $stmt->execute();
                                            $result = $stmt->get_result()->fetch_assoc();
                                            echo $result['total'] . ' bài học';
                                            ?>
                                        </small>
                                        <span class="badge bg-primary"><?= htmlspecialchars($course['muc_do']) ?></span>
                                    </div>
                                </div>

                                <div class="card-footer bg-white border-top">
                                    <a href="instructor-course.php?id=<?= $course['id'] ?>" class="btn btn-primary btn-sm w-100 mb-2">
                                        <i class="fas fa-edit"></i> Quản lý
                                    </a>
                                    <a href="../course-detail.php?id=<?= $course['id'] ?>" class="btn btn-outline-secondary btn-sm w-100" target="_blank">
                                        <i class="fas fa-eye"></i> Xem khóa học
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 12px;
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
}
</style>
