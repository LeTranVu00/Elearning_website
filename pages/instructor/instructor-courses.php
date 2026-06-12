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
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../controllers/InstructorController.php';
require_once __DIR__ . '/../../components/header.php';

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
    echo '<div class="min-h-screen flex items-center justify-center bg-slate-50"><div class="rounded-2xl bg-white p-8 shadow-xl border border-red-100 text-center"><i class="fa-solid fa-circle-xmark text-5xl text-red-500 mb-4"></i><h2 class="text-xl font-bold text-slate-800">Truy cập bị từ chối</h2><p class="text-slate-500 mt-2">Bạn không có quyền truy cập trang này.</p></div></div>';
    exit;
}

// Khởi tạo controller
$lessonModel = new Lesson($conn);
$courseModel = new Course($conn);
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
                echo "<script>window.location.href='instructor-course.php?id=" . $courseId . "';</script>";
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

<div class="min-h-screen bg-slate-50 py-10 px-4">
    <div class="mx-auto max-w-7xl">
        <!-- Header -->
        <div class="mb-10 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary text-white shadow-md">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    Quản lý khóa học của tôi
                </h1>
                <p class="mt-2 text-slate-500">Xem và chỉnh sửa các khóa học bạn đang phụ trách.</p>
            </div>
            <a href="instructor-create-course.php" class="inline-flex items-center gap-2 rounded-xl bg-success px-5 py-3 text-sm font-semibold text-white shadow-md hover:bg-green-600 transition-all hover:-translate-y-0.5">
                <i class="fa-solid fa-plus"></i> Tạo khóa học mới
            </a>
        </div>

        <?php if ($success): ?>
            <div class="mb-8 flex items-center gap-4 rounded-2xl border border-green-200 bg-green-50 p-5 text-green-800 shadow-sm">
                <i class="fa-solid fa-circle-check text-2xl text-green-500"></i>
                <span class="font-medium"><?= htmlspecialchars($success) ?></span>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="mb-8 flex items-center gap-4 rounded-2xl border border-red-200 bg-red-50 p-5 text-red-800 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-2xl text-red-500"></i>
                <span class="font-medium"><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <?php if (empty($courses)): ?>
            <!-- Empty state -->
            <div class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-slate-300 bg-white py-20 text-center shadow-sm">
                <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-slate-50 text-4xl text-slate-300">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h3 class="mb-2 text-xl font-bold text-slate-800">Bạn chưa có khóa học nào</h3>
                <p class="mb-6 max-w-sm text-slate-500">Tạo khóa học đầu tiên của bạn để chia sẻ kiến thức với hàng ngàn học viên trên nền tảng.</p>
                <a href="instructor-create-course.php" class="inline-flex items-center gap-2 rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-md hover:bg-indigo-700 transition-all">
                    <i class="fa-solid fa-plus"></i> Tạo khóa học ngay
                </a>
            </div>
        <?php else: ?>
            <!-- Course grid -->
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($courses as $course): ?>
                    <div class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft transition-all hover:-translate-y-1 hover:shadow-lg">
                        <div class="relative h-48 overflow-hidden bg-slate-100">
                            <?php if ($course['anh']): ?>
                                <img src="<?= htmlspecialchars($course['anh']) ?>" alt="<?= htmlspecialchars($course['ten_khoa_hoc']) ?>" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <?php else: ?>
                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-slate-200 to-slate-300">
                                    <i class="fa-solid fa-book text-4xl text-slate-400"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Badges -->
                            <div class="absolute right-3 top-3 flex flex-col gap-2">
                                <span class="rounded-lg bg-white/90 backdrop-blur-sm px-2.5 py-1 text-xs font-bold text-primary shadow-sm">
                                    <?= htmlspecialchars($course['muc_do']) ?: 'Cơ bản' ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex flex-1 flex-col p-5">
                            <h3 class="mb-2 line-clamp-2 text-lg font-bold text-slate-900 group-hover:text-primary transition-colors">
                                <?= htmlspecialchars($course['ten_khoa_hoc']) ?>
                            </h3>
                            <p class="mb-4 line-clamp-2 text-sm text-slate-500">
                                <?= htmlspecialchars($course['mo_ta_ngan'] ?: 'Chưa có mô tả ngắn') ?>
                            </p>
                            
                            <div class="mt-auto flex items-center justify-between border-t border-slate-100 pt-4">
                                <div class="flex items-center gap-2 text-sm text-slate-600">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 text-primary">
                                        <i class="fa-solid fa-layer-group"></i>
                                    </div>
                                    <span class="font-medium">
                                        <?php
                                        $sql = 'SELECT COUNT(*) as total FROM bai_hoc WHERE khoa_hoc_id = ?';
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param('i', $course['id']);
                                        $stmt->execute();
                                        $result = $stmt->get_result()->fetch_assoc();
                                        echo $result['total'];
                                        ?> bài học
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 border-t border-slate-100 bg-slate-50 p-3">
                            <a href="../course-detail.php?id=<?= $course['id'] ?>" target="_blank" class="flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 border border-slate-200 hover:bg-slate-100 transition-colors">
                                <i class="fa-regular fa-eye"></i> Xem
                            </a>
                            <a href="instructor-course.php?id=<?= $course['id'] ?>" class="flex items-center justify-center gap-2 rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700 shadow-sm transition-colors">
                                <i class="fa-solid fa-pen-to-square"></i> Quản lý
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../../components/footer.php'; ?>
