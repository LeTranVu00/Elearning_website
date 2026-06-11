<?php
/**
 * ============================================================================
 * FILE: pages/instructor/instructor-create-course.php
 * MỤC ĐÍCH: Form tạo khóa học mới cho giảng viên
 * ============================================================================
 * 
 * GIẢI THÍCH FLOW (quy trình xử lý):
 * 1. Load header & kiểm tra đăng nhập/quyền giảng viên
 * 2. Nếu POST: Gọi controller.createCourseAction() → validate & lưu DB
 * 3. Hiển thị form để điền thông tin
 * 4. Submit → tạo course (trạng thái 'ẩn' chờ admin duyệt)
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

// Kiểm tra quyền giảng viên
$userId = SessionManager::get('user_id');
$conn = Database::getConnection();
$sql = 'SELECT vai_tro FROM nguoi_dung WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user || ($user['vai_tro'] !== 'instructor' && $user['vai_tro'] !== 'admin')) {
    echo '<div class="alert alert-danger">❌ Bạn không có quyền truy cập trang này</div>';
    exit;
}

// Khởi tạo controller
$lessonModel = new Lesson($conn);
$courseModel = new Course($conn);
$controller = new InstructorController($lessonModel, $courseModel);

// Biến lưu thông báo
$success = null;
$error = null;
$course_id = null;

// Xử lý form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseData = [
        'ten_khoa_hoc' => $_POST['ten_khoa_hoc'] ?? '',
        'mo_ta_ngan' => $_POST['mo_ta_ngan'] ?? '',
        'mo_ta' => $_POST['mo_ta'] ?? '',
        'danh_muc_id' => $_POST['danh_muc_id'] ?? 0,
        'gia' => $_POST['gia'] ?? 0,
        'gia_goc' => $_POST['gia_goc'] ?? 0,
        'ngay_khai_giang' => $_POST['ngay_khai_giang'] ?? null,
        'lich_hoc' => $_POST['lich_hoc'] ?? null
    ];

    // Gọi action từ controller
    $result = $controller->createCourseAction($courseData);

    if ($result['success']) {
        $success = $result['message'];
        $course_id = $result['courseId'] ?? null;
    } else {
        $error = $result['message'];
    }
}

// Lấy danh mục khóa học
$categories = $courseModel->getCategories();
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">
                        <i class="fa-solid fa-plus"></i> Tạo khóa học mới
                    </h2>
                </div>
                <div class="card-body p-4">
                    
                    <!-- Thông báo thành công -->
                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($success) ?>
                            <?php if ($course_id): ?>
                                <div class="mt-2">
                                    <a href="instructor-course.php?id=<?= $course_id ?>" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-arrow-right"></i> Quản lý khóa học
                                    </a>
                                </div>
                            <?php endif; ?>
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

                    <!-- Form tạo khóa học -->
                    <form method="POST" novalidate>
                        <!-- Tên khóa học -->
                        <div class="mb-3">
                            <label for="ten_khoa_hoc" class="form-label fw-bold">
                                <i class="fa-solid fa-book"></i> Tên khóa học <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="ten_khoa_hoc" 
                                name="ten_khoa_hoc" 
                                required
                                placeholder="Vd: Lập trình Web với PHP"
                                minlength="5"
                                maxlength="255"
                                value="<?= $_POST['ten_khoa_hoc'] ?? '' ?>"
                            >
                            <small class="text-muted">Tối thiểu 5 ký tự, tối đa 255 ký tự</small>
                        </div>

                        <!-- Mô tả ngắn -->
                        <div class="mb-3">
                            <label for="mo_ta_ngan" class="form-label fw-bold">
                                <i class="fa-solid fa-align-left"></i> Mô tả ngắn <span class="text-danger">*</span>
                            </label>
                            <textarea 
                                class="form-control" 
                                id="mo_ta_ngan" 
                                name="mo_ta_ngan" 
                                required
                                placeholder="Mô tả ngắn gọn về nội dung khóa học"
                                rows="2"
                                maxlength="500"
                            ><?= $_POST['mo_ta_ngan'] ?? '' ?></textarea>
                            <small class="text-muted">Tối đa 500 ký tự</small>
                        </div>

                        <!-- Mô tả chi tiết -->
                        <div class="mb-3">
                            <label for="mo_ta" class="form-label fw-bold">
                                <i class="fa-solid fa-file-lines"></i> Mô tả chi tiết
                            </label>
                            <textarea 
                                class="form-control" 
                                id="mo_ta" 
                                name="mo_ta" 
                                placeholder="Nội dung chi tiết của khóa học"
                                rows="4"
                            ><?= $_POST['mo_ta'] ?? '' ?></textarea>
                        </div>

                        <!-- Danh mục -->
                        <div class="mb-3 position-relative" id="categoryContainer">
                            <label for="danh_muc_id" class="form-label fw-bold">
                                <i class="fa-solid fa-folder"></i> Danh mục <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <select 
                                    class="form-select" 
                                    id="danh_muc_id" 
                                    name="danh_muc_id" 
                                    required
                                >
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option 
                                            value="<?= $cat['id'] ?>"
                                            <?= ($_POST['danh_muc_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>
                                        >
                                            <?= htmlspecialchars($cat['ten_danh_muc']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button class="btn btn-outline-primary" type="button" id="categoryToggle">
                                    <i class="fa-solid fa-list"></i>
                                </button>
                            </div>

                            <!-- Dropdown danh mục -->
                            <div id="categoryDropdown" class="dropdown-menu shadow-lg p-3" style="min-width: 360px; display: none; position: absolute; top: 100%; left: 0; z-index: 1000; background: white; border-radius: 8px; margin-top: 5px;">
                                <!-- Thêm danh mục -->
                                <div class="mb-3 pb-3 border-bottom">
                                    <h6 class="fw-bold text-primary mb-2">
                                        <i class="fa-solid fa-plus"></i> Thêm danh mục
                                    </h6>
                                    <div class="input-group input-group-sm">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="newCategory" 
                                            placeholder="Tên danh mục mới..."
                                            minlength="2"
                                            maxlength="100"
                                            onkeypress="if(event.key==='Enter') addCategory(event)"
                                        >
                                        <button class="btn btn-primary" type="button" onclick="addCategory()">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Danh sách danh mục -->
                                <div id="categoryList" style="max-height: 250px; overflow-y: auto;">
                                    <?php if (empty($categories)): ?>
                                        <div class="text-muted text-center py-2 small">Chưa có danh mục</div>
                                    <?php else: ?>
                                        <?php foreach ($categories as $cat): ?>
                                            <div class="d-flex justify-content-between align-items-center p-2 rounded mb-2 bg-light" id="cat-<?= $cat['id'] ?>">
                                                <span class="flex-grow-1"><?= htmlspecialchars($cat['ten_danh_muc']) ?></span>
                                                <button type="button" class="btn btn-sm btn-warning me-1" onclick="editCategory(<?= $cat['id'] ?>, '<?= htmlspecialchars(str_replace("'", "\\'", $cat['ten_danh_muc'])) ?>', event)" title="Sửa">
                                                    <i class="fa-solid fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteCategory(<?= $cat['id'] ?>, event)" title="Xóa">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Giá tiền -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="gia" class="form-label fw-bold">
                                    <i class="fa-solid fa-tag"></i> Giá bán (VND) <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    id="gia" 
                                    name="gia" 
                                    required
                                    min="0"
                                    step="1000"
                                    placeholder="0"
                                    value="<?= $_POST['gia'] ?? '' ?>"
                                >
                                <small class="text-muted">Giá bán hiện tại</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gia_goc" class="form-label fw-bold">
                                    <i class="fa-solid fa-coins"></i> Giá gốc (VND)
                                </label>
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    id="gia_goc" 
                                    name="gia_goc" 
                                    min="0"
                                    step="1000"
                                    placeholder="0"
                                    value="<?= $_POST['gia_goc'] ?? '' ?>"
                                >
                                <small class="text-muted">Giá trước khi giảm (tùy chọn)</small>
                            </div>
                        </div>

                        <!-- Ngày khai giảng -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ngay_khai_giang" class="form-label fw-bold">
                                    <i class="fa-solid fa-calendar"></i> Ngày khai giảng
                                </label>
                                <input 
                                    type="date" 
                                    class="form-control" 
                                    id="ngay_khai_giang" 
                                    name="ngay_khai_giang"
                                    value="<?= $_POST['ngay_khai_giang'] ?? '' ?>"
                                >
                            </div>

                            <!-- Lịch học -->
                            <div class="col-md-6 mb-3">
                                <label for="lich_hoc" class="form-label fw-bold">
                                    <i class="fa-solid fa-clock"></i> Lịch học
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="lich_hoc" 
                                    name="lich_hoc"
                                    placeholder="Vd: Thứ 2,4,6 hàng tuần"
                                    value="<?= $_POST['lich_hoc'] ?? '' ?>"
                                >
                            </div>
                        </div>

                        <!-- Thông báo -->
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-circle-check"></i>
                            <strong>Lưu ý:</strong> Khóa học sẽ được <strong>công bố ngay</strong> và học viên có thể đăng ký.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>

                        <!-- Nút submit -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="instructor-courses.php" class="btn btn-secondary">
                                <i class="fa-solid fa-xmark"></i> Hủy
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-save"></i> Tạo khóa học
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS cho dropdown -->
<style>
    .form-control:invalid:focus,
    .form-select:invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .form-control:valid:focus,
    .form-select:valid:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
    }

    #categoryDropdown {
        border: 1px solid #dee2e6;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }

    #categoryDropdown.show {
        display: block !important;
    }
</style>

<!-- Script quản lý danh mục -->
<script>
const categoryContainer = document.getElementById('categoryContainer');
const categoryToggle = document.getElementById('categoryToggle');
const categoryDropdown = document.getElementById('categoryDropdown');

// Click vào nút để hiện/ẩn dropdown
categoryToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    categoryDropdown.classList.toggle('show');
});

// Click ở ngoài để đóng dropdown
document.addEventListener('click', (e) => {
    if (!categoryContainer.contains(e.target)) {
        categoryDropdown.classList.remove('show');
    }
});

// Prevent dropdown đóng khi click bên trong
categoryDropdown.addEventListener('click', (e) => {
    e.stopPropagation();
});

function addCategory(e) {
    if (e && e.key && e.key !== 'Enter') return;
    e && e.preventDefault();

    const input = document.getElementById('newCategory');
    const categoryName = input.value.trim();
    
    if (categoryName.length < 2) {
        alert('Tên danh mục phải có ít nhất 2 ký tự');
        return;
    }
    
    fetch('/webhoctap/api/category-action.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'create',
            name: categoryName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            reloadCategories();
        } else {
            alert('Lỗi: ' + data.message);
        }
    })
    .catch(err => alert('Lỗi: ' + err));
}

function editCategory(id, currentName, event) {
    if (event) event.stopPropagation();
    
    const newName = prompt('Sửa tên danh mục:', currentName);
    if (newName === null || newName.trim() === '') return;
    
    if (newName.trim().length < 2) {
        alert('Tên danh mục phải có ít nhất 2 ký tự');
        return;
    }
    
    fetch('/webhoctap/api/category-action.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'update',
            id: id,
            name: newName.trim()
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            reloadCategories();
        } else {
            alert('Lỗi: ' + data.message);
        }
    })
    .catch(err => alert('Lỗi: ' + err));
}

function deleteCategory(id, event) {
    if (event) event.stopPropagation();
    
    if (!confirm('Bạn chắc chắn muốn xóa danh mục này?')) return;
    
    fetch('/webhoctap/api/category-action.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'delete',
            id: id
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            reloadCategories();
        } else {
            alert('Lỗi: ' + data.message);
        }
    })
    .catch(err => alert('Lỗi: ' + err));
}

function reloadCategories() {
    fetch('/webhoctap/api/category-action.php?action=list')
    .then(response => response.json())
    .then(data => {
        const categoryList = document.getElementById('categoryList');
        const danh_muc_id = document.getElementById('danh_muc_id');
        
        // Lưu giá trị hiện tại
        const currentValue = danh_muc_id.value;
        
        if (data.length === 0) {
            categoryList.innerHTML = '<div class="text-muted text-center py-2 small">Chưa có danh mục</div>';
            danh_muc_id.innerHTML = '<option value="">-- Chọn danh mục --</option>';
        } else {
            categoryList.innerHTML = data.map(cat => `
                <div class="d-flex justify-content-between align-items-center p-2 rounded mb-2 bg-light" id="cat-${cat.id}">
                    <span class="flex-grow-1">${cat.ten_danh_muc}</span>
                    <button type="button" class="btn btn-sm btn-warning me-1" onclick="editCategory(${cat.id}, '${cat.ten_danh_muc.replace(/'/g, "\\'")}', event)" title="Sửa">
                        <i class="fa-solid fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteCategory(${cat.id}, event)" title="Xóa">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            `).join('');
            
            danh_muc_id.innerHTML = '<option value="">-- Chọn danh mục --</option>' + 
                data.map(cat => `<option value="${cat.id}" ${currentValue == cat.id ? 'selected' : ''}>${cat.ten_danh_muc}</option>`).join('');
        }
    })
    .catch(err => console.error('Lỗi:', err));
}
</script>

<?php include __DIR__ . '/../../components/footer.php'; ?>
