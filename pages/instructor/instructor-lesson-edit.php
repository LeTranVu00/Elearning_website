<?php
/**
 * ============================================================================
 * FILE: pages/instructor/instructor-lesson-edit.php
 * MỤC ĐÍCH: Chỉnh sửa bài học, upload file, thêm link học trực tuyến
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
    echo '<div class="alert alert-danger">Bài học không tồn tại</div>';
    exit;
}

$conn = Database::getConnection();

// Lấy thông tin bài học
$lesson = new Lesson($conn);
$lessonData = $lesson->getLessonById($lessonId);

if (!$lessonData) {
    echo '<div class="alert alert-danger">Bài học không tồn tại</div>';
    exit;
}

// Kiểm tra quyền
$sql = 'SELECT kh.id FROM khoa_hoc kh JOIN bai_hoc bh ON kh.id = bh.khoa_hoc_id 
        WHERE bh.id = ? AND kh.giang_vien_id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $lessonId, $userId);
$stmt->execute();

if ($stmt->get_result()->num_rows === 0) {
    echo '<div class="alert alert-danger">Bạn không có quyền chỉnh sửa bài học này</div>';
    exit;
}

$controller = new InstructorController($lesson, new \Course($conn));

// Xử lý action
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    switch ($action) {
        case 'update_lesson':
            $title = trim($_POST['lesson_title'] ?? '');
            $content = trim($_POST['lesson_content'] ?? '');
            
            if (empty($title)) {
                $message = 'Tiêu đề không được để trống';
                $messageType = 'danger';
            } elseif ($controller->updateLessonAction($lessonId, [
                'tieu_de' => $title,
                'noi_dung' => $content
            ])) {
                $message = 'Cập nhật bài học thành công';
                $messageType = 'success';
                
                // Cập nhật biến
                $lessonData['tieu_de'] = $title;
                $lessonData['noi_dung'] = $content;
            } else {
                $message = 'Lỗi khi cập nhật bài học';
                $messageType = 'danger';
            }
            break;

        case 'upload_resource':
            $type = $_POST['resource_type'] ?? 'lecture';
            $description = trim($_POST['resource_description'] ?? '');
            
            if (!isset($_FILES['resource_file']) || $_FILES['resource_file']['error'] === UPLOAD_ERR_NO_FILE) {
                $message = 'Vui lòng chọn file';
                $messageType = 'danger';
            } else {
                $result = $controller->uploadResourceAction($lessonId, $type, $_FILES['resource_file'], $description ?: null);
                $message = $result['message'];
                $messageType = $result['success'] ? 'success' : 'danger';
            }
            break;

        case 'add_link':
            $url = trim($_POST['link_url'] ?? '');
            $description = trim($_POST['link_description'] ?? '');
            
            if (empty($url)) {
                $message = 'URL không được để trống';
                $messageType = 'danger';
            } else {
                $result = $controller->addOnlineLinkAction($lessonId, $url, $description);
                $message = $result['message'];
                $messageType = $result['success'] ? 'success' : 'danger';
            }
            break;

        case 'delete_resource':
            $resourceId = (int)($_POST['resource_id'] ?? 0);
            $result = $controller->deleteResourceAction($resourceId);
            $message = $result['message'];
            $messageType = $result['success'] ? 'success' : 'danger';
            break;
    }
}

// Lấy khóa học
$courseData = null;
$sql = 'SELECT * FROM khoa_hoc WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $lessonData['khoa_hoc_id']);
$stmt->execute();
$courseData = $stmt->get_result()->fetch_assoc();

// Lấy danh sách tài liệu
$resources = $lesson->getResourcesByLesson($lessonId);
$lectureFiles = array_filter($resources, fn($r) => $r['loai'] === 'lecture');
$exerciseFiles = array_filter($resources, fn($r) => $r['loai'] === 'exercise');
$resourceFiles = array_filter($resources, fn($r) => $r['loai'] === 'resource');
$links = array_filter($resources, fn($r) => $r['loai'] === 'link');
?>

<div class="container-fluid my-4">
    <div class="row">
        <div class="col-md-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="index.php?page=instructor-course&id=<?= $lessonData['khoa_hoc_id'] ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <h1 class="d-inline-block ms-3 mb-0">✏️ <?= htmlspecialchars($lessonData['tieu_de']) ?></h1>
                </div>
            </div>

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php?page=instructor-courses">Khóa học của tôi</a></li>
                    <li class="breadcrumb-item"><a href="index.php?page=instructor-course&id=<?= $courseData['id'] ?>"><?= htmlspecialchars($courseData['ten_khoa_hoc']) ?></a></li>
                    <li class="breadcrumb-item active"><?= htmlspecialchars($lessonData['tieu_de']) ?></li>
                </ol>
            </nav>

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
                    <!-- Form Chỉnh sửa Bài học -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">📝 Chỉnh sửa Bài học</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <input type="hidden" name="action" value="update_lesson">
                                
                                <div class="mb-3">
                                    <label class="form-label">Tiêu đề bài học *</label>
                                    <input type="text" name="lesson_title" class="form-control" 
                                           value="<?= htmlspecialchars($lessonData['tieu_de']) ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Nội dung bài học</label>
                                    <textarea name="lesson_content" class="form-control" rows="6" 
                                              placeholder="Nhập nội dung bài học..."><?= htmlspecialchars($lessonData['noi_dung'] ?? '') ?></textarea>
                                    <small class="text-muted">Hỗ trợ HTML</small>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Lưu bài học
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Danh sách Tài liệu -->
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">📂 Tài liệu và Nội dung</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($resources)): ?>
                                <p class="text-muted">Chưa có tài liệu nào. Hãy thêm tài liệu từ phần bên cạnh.</p>
                            <?php else: ?>
                                <!-- Bài giảng -->
                                <?php if (!empty($lectureFiles)): ?>
                                    <div class="mb-4">
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-video"></i> Bài Giảng
                                        </h6>
                                        <?php foreach ($lectureFiles as $file): ?>
                                            <div class="resource-item p-3 mb-2 border rounded d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-file"></i>
                                                    <strong><?= htmlspecialchars($file['ten_file']) ?></strong>
                                                    <?php if ($file['mo_ta']): ?>
                                                        <br><small class="text-muted"><?= htmlspecialchars($file['mo_ta']) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="action" value="delete_resource">
                                                    <input type="hidden" name="resource_id" value="<?= $file['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa file này?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Bài tập -->
                                <?php if (!empty($exerciseFiles)): ?>
                                    <div class="mb-4">
                                        <h6 class="text-warning mb-3">
                                            <i class="fas fa-tasks"></i> Bài Tập
                                        </h6>
                                        <?php foreach ($exerciseFiles as $file): ?>
                                            <div class="resource-item p-3 mb-2 border rounded d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-file"></i>
                                                    <strong><?= htmlspecialchars($file['ten_file']) ?></strong>
                                                    <?php if ($file['mo_ta']): ?>
                                                        <br><small class="text-muted"><?= htmlspecialchars($file['mo_ta']) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="action" value="delete_resource">
                                                    <input type="hidden" name="resource_id" value="<?= $file['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa file này?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Tài nguyên khác -->
                                <?php if (!empty($resourceFiles)): ?>
                                    <div class="mb-4">
                                        <h6 class="text-info mb-3">
                                            <i class="fas fa-book"></i> Tài Nguyên Khác
                                        </h6>
                                        <?php foreach ($resourceFiles as $file): ?>
                                            <div class="resource-item p-3 mb-2 border rounded d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-file"></i>
                                                    <strong><?= htmlspecialchars($file['ten_file']) ?></strong>
                                                    <?php if ($file['mo_ta']): ?>
                                                        <br><small class="text-muted"><?= htmlspecialchars($file['mo_ta']) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="action" value="delete_resource">
                                                    <input type="hidden" name="resource_id" value="<?= $file['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa file này?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Link học trực tuyến -->
                                <?php if (!empty($links)): ?>
                                    <div class="mb-4">
                                        <h6 class="text-danger mb-3">
                                            <i class="fas fa-link"></i> Link Học Trực Tuyến
                                        </h6>
                                        <?php foreach ($links as $link): ?>
                                            <div class="resource-item p-3 mb-2 border rounded d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-external-link-alt"></i>
                                                    <a href="<?= htmlspecialchars($link['url_link']) ?>" target="_blank" class="ms-2">
                                                        <?= htmlspecialchars($link['url_link']) ?>
                                                    </a>
                                                    <?php if ($link['mo_ta']): ?>
                                                        <br><small class="text-muted"><?= htmlspecialchars($link['mo_ta']) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="action" value="delete_resource">
                                                    <input type="hidden" name="resource_id" value="<?= $link['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa link này?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Upload -->
                <div class="col-lg-4">
                    <!-- Upload File -->
                    <div class="card mb-3">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">⬆️ Upload File</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="upload_resource">
                                
                                <div class="mb-3">
                                    <label class="form-label">Loại tài liệu *</label>
                                    <select name="resource_type" class="form-select" required>
                                        <option value="lecture">📹 Bài Giảng</option>
                                        <option value="exercise">📝 Bài Tập</option>
                                        <option value="resource">📚 Tài Nguyên</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Chọn file *</label>
                                    <input type="file" name="resource_file" class="form-control" required 
                                           accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.txt,.jpg,.jpeg,.png">
                                    <small class="text-muted">Tối đa 50MB</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Mô tả</label>
                                    <input type="text" name="resource_description" class="form-control" 
                                           placeholder="Mô tả file (tùy chọn)">
                                </div>
                                
                                <button type="submit" class="btn btn-info w-100 text-white">
                                    <i class="fas fa-cloud-upload-alt"></i> Upload
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Thêm Link -->
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h6 class="mb-0">🔗 Thêm Link Học Trực Tuyến</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <input type="hidden" name="action" value="add_link">
                                
                                <div class="mb-3">
                                    <label class="form-label">URL *</label>
                                    <input type="url" name="link_url" class="form-control" 
                                           placeholder="https://zoom.us/... hoặc https://teams.microsoft.com/..." required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Mô tả</label>
                                    <input type="text" name="link_description" class="form-control" 
                                           placeholder="VD: Zoom Meeting - Lớp học thứ 2">
                                </div>
                                
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-plus-circle"></i> Thêm Link
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Hướng dẫn -->
                    <div class="alert alert-light mt-3">
                        <h6 class="alert-heading">💡 Hướng dẫn</h6>
                        <ul class="mb-0 small">
                            <li>Upload file bài giảng (PDF, Video, PowerPoint)</li>
                            <li>Thêm bài tập cho học viên</li>
                            <li>Chia sẻ link Zoom/Teams cho lớp học trực tuyến</li>
                            <li>Mỗi bài học có thể có nhiều file và link</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.resource-item {
    background-color: #f8f9fa;
    transition: background-color 0.2s;
}

.resource-item:hover {
    background-color: #e9ecef;
}
</style>
