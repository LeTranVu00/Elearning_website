<?php 
include '../components/header.php';

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/Course.php';

// ============================================================================
// Bảo vệ trang: Chỉ cho phép người dùng đã đăng nhập truy cập
// ============================================================================
SessionManager::requireLogin();

// Lấy thông tin user
$userId = SessionManager::get('user_id');
$conn = Database::getConnection();

// Lấy thông tin chi tiết user
$sql = 'SELECT id, ho_ten, email, vai_tro FROM nguoi_dung WHERE id = ?';
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo 'Database error: ' . $conn->error;
    exit;
}
$stmt->bind_param('i', $userId);
$stmt->execute();
$userData = $stmt->get_result()->fetch_assoc();

if (!$userData) {
    echo 'User not found';
    exit;
}

$userRole = $userData['vai_tro'];

// Nếu là instructor, lấy danh sách khóa học quản lý
$managedCourses = [];
if ($userRole === 'instructor') {
    $sql = 'SELECT id, ten_khoa_hoc, mo_ta FROM khoa_hoc WHERE giang_vien_id = ? ORDER BY created_at DESC';
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $managedCourses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<div class="page-enter min-h-screen py-8">
      <div class="mx-auto grid max-w-7xl gap-8 px-4 lg:grid-cols-4 lg:px-8">
        <aside class="space-y-6 lg:col-span-1">
          <article class="rounded-2xl border border-slate-200 bg-white p-5">
            <div class="mb-5 text-center">
              <img class="mx-auto mb-3 h-24 w-24 rounded-full object-cover" src="https://i.pravatar.cc/200?img=<?= $userId ?>" alt="<?= htmlspecialchars($userData['ho_ten'] ?? 'User') ?>">
              <h2 class="text-xl font-bold"><?= htmlspecialchars($userData['ho_ten'] ?? 'User') ?></h2>
              <p class="text-sm text-slate-500">@<?= htmlspecialchars(strtolower(str_replace(' ', '', $userData['ho_ten'] ?? 'user'))) ?></p>
              <span class="mt-2 inline-block rounded-full bg-primary px-3 py-1 text-xs font-semibold text-white">
                <?php if ($userRole === 'instructor'): ?>
                  👨‍🏫 Giáo Viên
                <?php elseif ($userRole === 'admin'): ?>
                  👨‍💼 Quản Trị Viên
                <?php else: ?>
                  👤 Học Viên
                <?php endif; ?>
              </span>
            </div>
            <div class="space-y-2 border-t border-slate-100 pt-4 text-sm text-slate-600">
              <p><i class="fa-regular fa-envelope mr-2"></i><?= htmlspecialchars($userData['email']) ?></p>
            </div>
            <button class="mt-5 w-full rounded-xl border border-slate-200 px-4 py-2.5 font-medium hover:bg-slate-100">
              <i class="fa-solid fa-gear mr-1"></i> Chinh sua ho so
            </button>
          </article>
        </aside>

        <section class="lg:col-span-3 min-w-0">
          <div class="hide-scrollbar mb-6 overflow-x-auto">
            <div class="inline-flex gap-2 rounded-xl border border-slate-200 bg-white p-1">
              <?php if ($userRole === 'instructor'): ?>
                <button data-action="set-profile-tab" data-value="courses" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white">
                  ⚙️ Khóa học quản lý
                </button>
              <?php else: ?>
                <button data-action="set-profile-tab" data-value="courses" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white">
                  Khoa hoc cua toi
                </button>
              <?php endif; ?>
                  
                <button data-action="set-profile-tab" data-value="posts" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">
                  Bai viet cua toi
                </button>
                  
                <button data-action="set-profile-tab" data-value="achievements" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">
                  Thanh tich
                </button>
            </div>
          </div>

          <!-- Nút tạo khóa học cho giảng viên -->
          <?php if ($userRole === 'instructor'): ?>
            <div class="mb-6">
              <a href="instructor/instructor-create-course.php" class="inline-block rounded-lg bg-success px-4 py-2.5 font-medium text-white hover:bg-green-600">
                <i class="fa-solid fa-plus"></i> Tạo khóa học mới
              </a>
            </div>
          <?php endif; ?>
          
    <div class="grid gap-6 md:grid-cols-2">
      <?php if ($userRole === 'instructor' && !empty($managedCourses)): ?>
        <!-- Khóa học quản lý cho instructor -->
        <?php foreach ($managedCourses as $course): ?>
          <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-soft">
            <div class="relative aspect-video">
              <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=1200&q=80" alt="<?= htmlspecialchars($course['ten_khoa_hoc']) ?>" class="h-full w-full object-cover">
              <span class="absolute right-3 top-3 rounded-full bg-green-500 px-3 py-1 text-xs font-semibold text-white">👨‍🏫 Quản Lý</span>
            </div>
            <div class="space-y-3 p-5">
              <h3 class="line-clamp-2 text-lg font-bold"><?= htmlspecialchars($course['ten_khoa_hoc']) ?></h3>
              <p class="text-sm text-slate-500"><?= htmlspecialchars(substr($course['mo_ta'], 0, 100)) ?>...</p>
              <div class="flex gap-2">
                <a href="instructor/instructor-course.php?id=<?= $course['id'] ?>" class="flex-1 rounded-xl bg-primary px-4 py-2.5 text-center font-medium text-white hover:bg-indigo-700">
                  ✏️ Quản Lý Bài
                </a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      <?php elseif ($userRole === 'instructor' && empty($managedCourses)): ?>
        <div class="col-span-2 rounded-2xl border border-slate-200 bg-white p-8 text-center">
          <p class="text-slate-500 mb-4">📚 Bạn chưa quản lý khóa học nào</p>
          <p class="text-sm text-slate-400">Liên hệ admin để được gán khóa học</p>
        </div>
      <?php else: ?>
        <!-- Khóa học của học viên (giữ nguyên cũ) -->
        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-soft">
          <div class="relative aspect-video">
            <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=1200&q=80" alt="React tu co ban den nang cao" class="h-full w-full object-cover">
            <span class="absolute right-3 top-3 rounded-full bg-primary px-3 py-1 text-xs font-semibold text-white">65% hoan thanh</span>
          </div>
          <div class="space-y-3 p-5">
            <h3 class="line-clamp-2 text-lg font-bold">React tu co ban den nang cao</h3>
            <p class="text-sm text-slate-500">29/45 bai hoc</p>
            <div class="h-2 overflow-hidden rounded-full bg-slate-100">
              <div class="h-full bg-primary" style="width: 65%"></div>
            </div>
            <p class="text-sm text-slate-500">Hoc gan nhat: 2 gio truoc</p>
            <a href="learning.php"  class="w-full rounded-xl bg-primary px-4 py-2.5 font-medium text-white hover:bg-indigo-700">Tiep tuc hoc</a>
          </div>
        </article>
          
        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-soft">
          <div class="relative aspect-video">
            <img src="https://images.unsplash.com/photo-1579468118864-1b9ea3c0db4a?w=1200&q=80" alt="JavaScript ES6+ hien dai" class="h-full w-full object-cover">
            <span class="absolute right-3 top-3 rounded-full bg-primary px-3 py-1 text-xs font-semibold text-white">40% hoan thanh</span>
          </div>
          <div class="space-y-3 p-5">
            <h3 class="line-clamp-2 text-lg font-bold">JavaScript ES6+ hien dai</h3>
            <p class="text-sm text-slate-500">15/38 bai hoc</p>
            <div class="h-2 overflow-hidden rounded-full bg-slate-100">
              <div class="h-full bg-primary" style="width: 40%"></div>
            </div>
            <p class="text-sm text-slate-500">Hoc gan nhat: 1 ngay truoc</p>
            <a href="learning.php"  class="w-full rounded-xl bg-primary px-4 py-2.5 font-medium text-white hover:bg-indigo-700">Tiep tuc hoc</a>
          </div>
        </article>
          
        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-soft">
          <div class="relative aspect-video">
            <img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=1200&q=80" alt="Python cho Data Science" class="h-full w-full object-cover">
            <span class="absolute right-3 top-3 rounded-full bg-primary px-3 py-1 text-xs font-semibold text-white">25% hoan thanh</span>
          </div>
          <div class="space-y-3 p-5">
            <h3 class="line-clamp-2 text-lg font-bold">Python cho Data Science</h3>
            <p class="text-sm text-slate-500">16/65 bai hoc</p>
            <div class="h-2 overflow-hidden rounded-full bg-slate-100">
              <div class="h-full bg-primary" style="width: 25%"></div>
            </div>
            <p class="text-sm text-slate-500">Hoc gan nhat: 3 ngay truoc</p>
            <a href="learning.php" class="w-full rounded-xl bg-primary px-4 py-2.5 font-medium text-white hover:bg-indigo-700">Tiep tuc hoc</a>
          </div>
        </article>
      <?php endif; ?>
    </div>
  </section>
  </div>
</div>

<?php include '../components/footer.php'; ?>
