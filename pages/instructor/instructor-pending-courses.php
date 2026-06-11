<?php
/**
 * ============================================================================
 * FILE: pages/instructor/instructor-pending-courses.php
 * MỤC ĐÍCH: Admin duyệt danh sách khóa học chờ phê duyệt của giảng viên
 * ============================================================================
 */

require_once __DIR__ . '/../../core/SessionManager.php';
require_once __DIR__ . '/../../core/Database.php';
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../models/Lesson.php';
require_once __DIR__ . '/../../controllers/InstructorController.php';
require_once __DIR__ . '/../../components/header.php';

// Kiểm tra đăng nhập
if (!SessionManager::isLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

// Kiểm tra quyền admin
$userId = SessionManager::getUserId();
$conn = Database::getConnection();
$sql = 'SELECT vai_tro FROM nguoi_dung WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user || $user['vai_tro'] !== 'admin') {
    echo '<div class="alert alert-danger">❌ Bạn không có quyền truy cập trang này</div>';
    exit;
}

// Khởi tạo controller
$lessonModel = new Lesson($conn);
$courseModel = new Course($conn);
$controller = new InstructorController($lessonModel, $courseModel);

// Xử lý action
$success = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $courseId = (int)($_POST['course_id'] ?? 0);

    if ($action === 'approve' && $courseId > 0) {
        $result = $controller->approveCourseAction($courseId);
        if ($result['success']) {
            $success = $result['message'];
        } else {
            $error = $result['message'];
        }
    } elseif ($action === 'reject' && $courseId > 0) {
        $result = $controller->rejectCourseAction($courseId);
        if ($result['success']) {
            $success = $result['message'];
        } else {
            $error = $result['message'];
        }
    }
}

// Lấy danh sách khóa học chờ duyệt
$pendingCourses = $controller->getPendingCoursesAction();
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-4">
                <h1 class="mb-2">
                    <i class="fa-solid fa-hourglass"></i> Khóa học chờ phê duyệt
                </h1>
                <p class="text-muted">
                    Danh sách khóa học được giảng viên tạo và đang chờ admin duyệt
                </p>
            </div>

            <!-- Thông báo thành công -->
            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($success) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Thông báo lỗi -->
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Danh sách khóa học -->
            <?php if (empty($pendingCourses)): ?>
                <div class="alert alert-info text-center py-5">
                    <i class="fa-solid fa-inbox" style="font-size: 3rem; color: #0d6efd;"></i>
                    <p class="mt-3 mb-0">✅ Không có khóa học nào chờ duyệt</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="25%">Tên khóa học</th>
                                <th width="20%">Giảng viên</th>
                                <th width="15%">Danh mục</th>
                                <th width="12%">Giá (VND)</th>
                                <th width="15%">Ngày tạo</th>
                                <th width="20%">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendingCourses as $course): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary">#<?= $course['id'] ?></span>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($course['ten_khoa_hoc']) ?></strong>
                                        <br>
                                        <small class="text-muted">
                                            <?= htmlspecialchars(substr($course['mo_ta_ngan'] ?? '', 0, 60)) ?>...
                                        </small>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($course['giang_vien_name'] ?? 'N/A') ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?= htmlspecialchars($course['ten_danh_muc'] ?? 'N/A') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= number_format($course['gia'], 0, '.', ',') ?? 'N/A' ?>
                                    </td>
                                    <td>
                                        <small><?= (new DateTime($course['created_at']))->format('d/m/Y H:i') ?></small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <!-- Nút xem chi tiết -->
                                            <a href="../course-detail.php?id=<?= $course['id'] ?>" 
                                               class="btn btn-outline-secondary" 
                                               title="Xem chi tiết"
                                               target="_blank">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <!-- Form phê duyệt (inline) -->
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="action" value="approve">
                                                <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                                <button type="submit" 
                                                        class="btn btn-outline-success" 
                                                        title="Phê duyệt"
                                                        onclick="return confirm('Bạn có chắc muốn phê duyệt khóa học này?');">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            </form>

                                            <!-- Form từ chối (inline) -->
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="action" value="reject">
                                                <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                                <button type="submit" 
                                                        class="btn btn-outline-danger" 
                                                        title="Từ chối"
                                                        onclick="return confirm('Bạn có chắc muốn từ chối khóa học này?');">
                                                    <i class="fa-solid fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Tóm tắt -->
                <div class="alert alert-info mt-4">
                    <i class="fa-solid fa-circle-info"></i>
                    <strong><?= count($pendingCourses) ?></strong> khóa học đang chờ phê duyệt
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f5f7fa;
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>

<?php include __DIR__ . '/../../components/footer.php'; ?>
