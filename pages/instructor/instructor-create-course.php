<?php
/**
 * ============================================================================
 * FILE: pages/instructor/instructor-create-course.php
 * MỤC ĐÍCH: Form tạo khóa học mới cho giảng viên (Giao diện Tailwind CSS)
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

// Kiểm tra quyền giảng viên
$userId = SessionManager::getUserId();
$conn = Database::getConnection();
$sql = 'SELECT vai_tro FROM nguoi_dung WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user || ($user['vai_tro'] !== 'instructor' && $user['vai_tro'] !== 'admin')) {
    echo '<div class="min-h-screen flex items-center justify-center bg-slate-50"><div class="rounded-2xl bg-white p-8 shadow-xl border border-red-100 text-center"><i class="fa-solid fa-circle-xmark text-5xl text-red-500 mb-4"></i><h2 class="text-xl font-bold text-slate-800">Truy cập bị từ chối</h2><p class="text-slate-500 mt-2">Bạn không có quyền truy cập trang này.</p></div></div>';
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
        'gia' => 0,
        'gia_goc' => 0,
        'ngay_khai_giang' => $_POST['ngay_khai_giang'] ?? null,
        'lich_hoc' => $_POST['lich_hoc'] ?? null
    ];

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

<div class="min-h-screen bg-slate-50 py-10 px-4">
    <div class="mx-auto max-w-4xl">
        <!-- Header Section -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Tạo khóa học mới</h1>
                <p class="mt-2 text-sm text-slate-500">Điền đầy đủ thông tin bên dưới để bắt đầu chia sẻ kiến thức của bạn.</p>
            </div>
            <a href="instructor-courses.php" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all">
                <i class="fa-solid fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft">
            <div class="p-8">
                <!-- Alerts -->
                <?php if ($success): ?>
                    <div class="mb-8 flex items-start gap-4 rounded-2xl border border-green-200 bg-green-50 p-5 text-green-800 shadow-sm">
                        <i class="fa-solid fa-circle-check mt-1 text-2xl text-green-500"></i>
                        <div class="flex-1">
                            <strong class="block text-lg font-bold">Thành công!</strong>
                            <p class="mt-1"><?= htmlspecialchars($success) ?></p>
                            <?php if ($course_id): ?>
                                <a href="instructor-course.php?id=<?= $course_id ?>" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-green-700 transition-colors">
                                    <i class="fa-solid fa-folder-open"></i> Quản lý nội dung khóa học
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="mb-8 flex items-center gap-4 rounded-2xl border border-red-200 bg-red-50 p-5 text-red-800 shadow-sm">
                        <i class="fa-solid fa-triangle-exclamation text-2xl text-red-500"></i>
                        <div>
                            <strong class="block text-lg font-bold">Đã xảy ra lỗi!</strong>
                            <span class="mt-1 block"><?= htmlspecialchars($error) ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-6" novalidate>
                    <!-- Tên khóa học -->
                    <div>
                        <label for="ten_khoa_hoc" class="mb-2 block text-sm font-bold text-slate-700">Tên khóa học <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <i class="fa-solid fa-book text-slate-400"></i>
                            </div>
                            <input type="text" id="ten_khoa_hoc" name="ten_khoa_hoc" required minlength="5" maxlength="255" value="<?= $_POST['ten_khoa_hoc'] ?? '' ?>" class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-900 transition-all focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="Vd: Lập trình Web với PHP">
                        </div>
                        <p class="mt-2 text-xs text-slate-500">Tối thiểu 5 ký tự, tối đa 255 ký tự</p>
                    </div>

                    <!-- Mô tả ngắn -->
                    <div>
                        <label for="mo_ta_ngan" class="mb-2 block text-sm font-bold text-slate-700">Mô tả ngắn <span class="text-red-500">*</span></label>
                        <textarea id="mo_ta_ngan" name="mo_ta_ngan" required rows="2" maxlength="500" class="block w-full rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-900 transition-all focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="Mô tả ngắn gọn sức hút của khóa học này..."><?= $_POST['mo_ta_ngan'] ?? '' ?></textarea>
                        <p class="mt-2 text-xs text-slate-500">Tối đa 500 ký tự. Nội dung này sẽ hiển thị ở thẻ khóa học ngoài trang chủ.</p>
                    </div>

                    <!-- Mô tả chi tiết -->
                    <div>
                        <label for="mo_ta" class="mb-2 block text-sm font-bold text-slate-700">Mô tả chi tiết</label>
                        <textarea id="mo_ta" name="mo_ta" rows="5" class="block w-full rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-900 transition-all focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="Trình bày chi tiết bạn sẽ dạy gì, yêu cầu đầu vào, đối tượng phù hợp..."><?= $_POST['mo_ta'] ?? '' ?></textarea>
                    </div>

                    <!-- Danh mục -->
                    <div class="relative" id="categoryContainer">
                        <label for="danh_muc_id" class="mb-2 block text-sm font-bold text-slate-700">Danh mục <span class="text-red-500">*</span></label>
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <i class="fa-solid fa-folder-open text-slate-400"></i>
                                </div>
                                <select id="danh_muc_id" name="danh_muc_id" required class="block w-full appearance-none rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-10 text-sm text-slate-900 transition-all focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" <?= ($_POST['danh_muc_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['ten_danh_muc']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs"></i>
                                </div>
                            </div>
                            <button type="button" id="categoryToggle" class="flex w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-primary transition-colors focus:outline-none focus:ring-2 focus:ring-primary/20">
                                <i class="fa-solid fa-list-check"></i>
                            </button>
                        </div>

                        <!-- Dropdown quản lý danh mục -->
                        <div id="categoryDropdown" class="absolute right-0 top-full z-50 mt-2 hidden w-[360px] rounded-2xl border border-slate-200 bg-white p-4 shadow-xl">
                            <!-- Thêm danh mục -->
                            <div class="mb-4 pb-4 border-b border-slate-100">
                                <h6 class="mb-3 text-sm font-bold text-slate-800"><i class="fa-solid fa-plus text-primary mr-2"></i> Thêm danh mục</h6>
                                <div class="flex gap-2">
                                    <input type="text" id="newCategory" class="block w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-primary focus:outline-none" placeholder="Tên danh mục mới..." onkeypress="if(event.key==='Enter') addCategory(event)">
                                    <button type="button" onclick="addCategory()" class="rounded-lg bg-primary px-3 py-2 text-white hover:bg-indigo-700">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Danh sách danh mục -->
                            <div id="categoryList" class="max-h-60 overflow-y-auto space-y-2 pr-1">
                                <?php if (empty($categories)): ?>
                                    <div class="text-center text-sm text-slate-500 py-4">Chưa có danh mục</div>
                                <?php else: ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <div class="flex items-center justify-between rounded-lg bg-slate-50 p-2 text-sm border border-slate-100" id="cat-<?= $cat['id'] ?>">
                                            <span class="flex-1 truncate pr-2 font-medium text-slate-700"><?= htmlspecialchars($cat['ten_danh_muc']) ?></span>
                                            <div class="flex gap-1">
                                                <button type="button" class="flex h-7 w-7 items-center justify-center rounded bg-amber-100 text-amber-600 hover:bg-amber-200" onclick="editCategory(<?= $cat['id'] ?>, '<?= htmlspecialchars(str_replace("'", "\\'", $cat['ten_danh_muc'])) ?>', event)" title="Sửa">
                                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                </button>
                                                <button type="button" class="flex h-7 w-7 items-center justify-center rounded bg-red-100 text-red-600 hover:bg-red-200" onclick="deleteCategory(<?= $cat['id'] ?>, event)" title="Xóa">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Ngày và Lịch học -->
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="ngay_khai_giang" class="mb-2 block text-sm font-bold text-slate-700">Ngày khai giảng</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <i class="fa-solid fa-calendar-day text-slate-400"></i>
                                </div>
                                <input type="date" id="ngay_khai_giang" name="ngay_khai_giang" value="<?= $_POST['ngay_khai_giang'] ?? '' ?>" class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-900 transition-all focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
                            </div>
                        </div>

                        <div>
                            <label for="lich_hoc" class="mb-2 block text-sm font-bold text-slate-700">Lịch học</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <i class="fa-solid fa-clock text-slate-400"></i>
                                </div>
                                <input type="text" id="lich_hoc" name="lich_hoc" value="<?= $_POST['lich_hoc'] ?? '' ?>" class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-900 transition-all focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="Vd: Thứ 2,4,6 hàng tuần">
                            </div>
                        </div>
                    </div>

                    <!-- Message box -->
                    <div class="mt-6 flex items-start gap-4 rounded-2xl bg-blue-50 p-5 text-blue-800 border border-blue-100">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 shrink-0">
                            <i class="fa-solid fa-circle-info text-blue-600"></i>
                        </div>
                        <p class="text-sm leading-relaxed mt-1"><strong>Lưu ý:</strong> Khóa học sau khi được lưu sẽ hiển thị ngay lập tức trên hệ thống. Học viên có thể truy cập và học miễn phí.</p>
                    </div>

                    <!-- Nút submit -->
                    <div class="mt-8 flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                        <a href="instructor-courses.php" class="rounded-xl px-5 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                            Hủy bỏ
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-primary px-8 py-3 text-sm font-semibold text-white shadow-md hover:bg-indigo-700 transition-all hover:-translate-y-0.5 hover:shadow-lg">
                            <i class="fa-solid fa-save"></i> Tạo khóa học
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS validation overrides */
    input:invalid:focus, select:invalid:focus, textarea:invalid:focus {
        border-color: #ef4444 !important;
        --tw-ring-color: rgba(239, 68, 68, 0.2) !important;
    }
</style>

<script>
const categoryContainer = document.getElementById('categoryContainer');
const categoryToggle = document.getElementById('categoryToggle');
const categoryDropdown = document.getElementById('categoryDropdown');

// Click vào nút để hiện/ẩn dropdown
categoryToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    categoryDropdown.classList.toggle('hidden');
});

// Click ở ngoài để đóng dropdown
document.addEventListener('click', (e) => {
    if (!categoryContainer.contains(e.target)) {
        categoryDropdown.classList.add('hidden');
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
            categoryList.innerHTML = '<div class="text-center text-sm text-slate-500 py-4">Chưa có danh mục</div>';
            danh_muc_id.innerHTML = '<option value="">-- Chọn danh mục --</option>';
        } else {
            categoryList.innerHTML = data.map(cat => `
                <div class="flex items-center justify-between rounded-lg bg-slate-50 p-2 text-sm border border-slate-100" id="cat-${cat.id}">
                    <span class="flex-1 truncate pr-2 font-medium text-slate-700">${cat.ten_danh_muc}</span>
                    <div class="flex gap-1">
                        <button type="button" class="flex h-7 w-7 items-center justify-center rounded bg-amber-100 text-amber-600 hover:bg-amber-200" onclick="editCategory(${cat.id}, '${cat.ten_danh_muc.replace(/'/g, "\\'")}', event)" title="Sửa">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                        </button>
                        <button type="button" class="flex h-7 w-7 items-center justify-center rounded bg-red-100 text-red-600 hover:bg-red-200" onclick="deleteCategory(${cat.id}, event)" title="Xóa">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
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
