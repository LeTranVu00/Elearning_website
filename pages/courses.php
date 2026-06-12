<?php 
include '../components/header.php';
require_once '../core/Database.php';
require_once '../models/Course.php';

// Khởi tạo Course Model
$courseModel = new Course(Database::getConnection());

// Lấy dữ liệu khóa học
$coursesPerPage = 6;
$searchQuery = trim((string)filter_input(INPUT_GET, 'q', FILTER_UNSAFE_RAW));
$totalCourses = $courseModel->countAll(null, $searchQuery);
$totalPages = max(1, (int)ceil($totalCourses / $coursesPerPage));
$currentPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
$currentPage = min(max(1, $currentPage), $totalPages);
$offset = ($currentPage - 1) * $coursesPerPage;
$courses = $courseModel->getAll(null, $coursesPerPage, $offset, $searchQuery);

// Helper functions
function getAvatarUrl($index) {
    return 'https://i.pravatar.cc/80?img=' . ($index % 10);
}
?>
<div class="page-enter min-h-screen overflow-x-hidden bg-gradient-to-b from-slate-50 to-white">
  <section class="bg-gradient-to-r from-primary via-indigo-600 to-secondary py-16 text-white bg-gradient-anim">
    <div class="mx-auto max-w-7xl px-4 lg:px-8 scale-in">
      <h1 class="mb-4 text-5xl font-bold text-glow">Khoa học lập trình</h1>
      <p class="mb-8 text-lg text-white/90">Khám phá hơn 200+ khóa học lập trình chất lượng cao từ các giảng viên hàng đầu</p>
      <form action="courses.php" method="get" class="max-w-3xl">
        <div class="flex flex-col gap-3 rounded-2xl bg-white p-2 shadow-2xl ring-1 ring-white/30 sm:flex-row sm:items-center">
          <div class="relative flex-1">
            <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input
              type="search"
              name="q"
              value="<?php echo htmlspecialchars($searchQuery); ?>"
              class="h-14 w-full rounded-xl border-0 bg-slate-50 pl-12 pr-4 text-base font-medium text-slate-900 outline-none transition placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-primary/30"
              placeholder="Nhập tên khóa học, giảng viên hoặc chủ đề..."
            >
          </div>
          <button type="submit" class="rounded-xl bg-slate-900 px-6 py-3.5 font-semibold text-white transition hover:bg-slate-800 sm:min-w-32">
            Tìm kiếm
          </button>
        </div>
        <?php if ($searchQuery !== ''): ?>
          <div class="mt-3 flex flex-wrap items-center gap-2 text-sm text-white/90">
            <span>Đang tìm: <b><?php echo htmlspecialchars($searchQuery); ?></b></span>
            <a href="courses.php" class="rounded-full bg-white/15 px-3 py-1 font-semibold text-white transition hover:bg-white/25">Xóa tìm kiếm</a>
          </div>
        <?php endif; ?>
      </form>
    </div>
  </section>

  <section class="py-12">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
      <!-- Toolbar với nút Lọc -->
      <div class="mb-8 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
        <div class="relative">
          <button id="openFilterBtn" type="button" aria-expanded="false" aria-controls="filterDropdown" class="flex items-center gap-2 rounded-xl bg-primary px-6 py-3 font-semibold text-white transition hover:bg-indigo-700 shadow-md">
            <i class="fa-solid fa-filter"></i> Lọc
            <i class="fa-solid fa-chevron-down text-xs"></i>
          </button>

          <div id="filterDropdown" class="absolute left-0 top-full z-40 mt-3 hidden w-80 rounded-2xl border border-slate-200 bg-white p-5 shadow-2xl sm:w-[36rem]">
            <div class="grid gap-5 sm:grid-cols-3">
              <div class="space-y-3">
                <h3 class="text-sm font-bold text-slate-900">Danh mục</h3>
                <div class="space-y-2">
                  <button type="button" class="flex w-full items-center justify-between rounded-lg bg-primary px-3 py-2 text-left text-sm font-medium text-white transition hover:bg-indigo-700">
                    <span>Tất cả</span>
                    <span class="rounded-full bg-white/20 px-2 py-0.5 text-xs">200</span>
                  </button>
                  <button type="button" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-100">
                    <span>JavaScript</span>
                    <span class="text-xs text-slate-500">45</span>
                  </button>
                  <button type="button" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-100">
                    <span>Python</span>
                    <span class="text-xs text-slate-500">38</span>
                  </button>
                  <button type="button" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-100">
                    <span>React</span>
                    <span class="text-xs text-slate-500">32</span>
                  </button>
                  <button type="button" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-100">
                    <span>Node.js</span>
                    <span class="text-xs text-slate-500">28</span>
                  </button>
                </div>
              </div>

              <div class="space-y-3">
                <h3 class="text-sm font-bold text-slate-900">Cấp độ</h3>
                <div class="space-y-2">
                  <button type="button" class="w-full rounded-lg bg-primary px-3 py-2 text-left text-sm font-medium text-white transition hover:bg-indigo-700">Tất cả cấp độ</button>
                  <button type="button" class="w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-100">Cơ bản</button>
                  <button type="button" class="w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-100">Trung cấp</button>
                  <button type="button" class="w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-100">Nâng cao</button>
                </div>
              </div>


            </div>

            <div class="mt-5 flex gap-3 border-t border-slate-100 pt-4">
              <button id="applyFilterBtn" type="button" class="flex-1 rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">Áp dụng</button>
              <button id="resetFilterBtn" type="button" class="flex-1 rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">Đặt lại</button>
            </div>
          </div>
        </div>
        <p class="text-sm font-medium text-slate-600">Hiển thị <?php echo count($courses); ?> / <?php echo $totalCourses; ?> khóa học</p>
      </div>

      <!-- Grid khóa học - Full width -->
      <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <?php if (!empty($courses)): ?>
          <?php foreach ($courses as $index => $course): ?>
            <?php 
              $avgRating = $courseModel->getAverageRating($course['id']);
              $ratingCount = $courseModel->getRatingCount($course['id']);
            ?>
            <article class="card-hover group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-md hover:shadow-2xl transition-all duration-300">
              <div class="relative aspect-[16/9] overflow-hidden bg-slate-200 lg:aspect-[5/3]">
                <img src="<?php echo htmlspecialchars($course['anh']); ?>" alt="<?php echo htmlspecialchars($course['ten_khoa_hoc']); ?>" class="h-full w-full object-cover card-img-zoom group-hover:scale-110 transition-transform duration-300">

                <button class="absolute right-3 top-3 flex h-10 w-10 items-center justify-center rounded-full bg-white/95 shadow-md transition hover:bg-white hover:scale-110 text-primary">
                  <i class="fa-regular fa-heart text-lg"></i>
                </button>
                <span class="absolute bottom-3 left-3 rounded-full bg-black/70 px-3 py-1.5 text-xs font-bold text-white"><?php echo Course::formatLevel($course['muc_do']); ?></span>
              </div>
              <div class="space-y-2.5 p-5 flex flex-col flex-1">
                <h3 class="line-clamp-2 min-h-11 text-lg font-bold leading-snug text-slate-900 group-hover:text-primary transition"><?php echo htmlspecialchars($course['ten_khoa_hoc']); ?></h3>
                <p class="line-clamp-2 min-h-10 text-[15px] text-slate-600 leading-relaxed"><?php echo htmlspecialchars($course['mo_ta_ngan']); ?></p>
                
                <!-- Thông tin giảng viên -->
                <div class="flex min-h-11 items-center gap-2 pt-2 border-t border-slate-100">
                  <img class="h-8 w-8 rounded-full ring-2 ring-primary/20" src="<?php echo getAvatarUrl($index); ?>" alt="">
                  <span class="text-sm font-medium text-slate-800"><?php echo htmlspecialchars($course['giang_vien'] ?? 'Chưa xác định'); ?></span>
                </div>

                <!-- Thông tin chi tiết khóa học -->
                <div class="min-h-14 space-y-1 text-sm text-slate-600 py-1.5 border-b border-slate-100">
                  <?php if ($course['so_bai_giang']): ?>
                    <div class="flex items-center gap-1.5">
                      <i class="fa-solid fa-book text-primary"></i>
                      <span><b class="text-slate-900"><?php echo $course['so_bai_giang']; ?></b> bài</span>
                    </div>
                  <?php endif; ?>
                  
                  <?php if ($course['ngay_khai_giang']): ?>
                    <div class="flex items-center gap-1.5">
                      <i class="fa-solid fa-calendar text-primary"></i>
                      <span>Khai giảng: <b class="text-slate-900"><?php echo date('d/m', strtotime($course['ngay_khai_giang'])); ?></b></span>
                    </div>
                  <?php endif; ?>
                  
                  <?php if ($course['lich_hoc']): ?>
                    <div class="flex items-center gap-1.5">
                      <i class="fa-solid fa-clock text-primary text-xs"></i>
                      <span><?php echo htmlspecialchars($course['lich_hoc']); ?></span>
                    </div>
                  <?php endif; ?>
                </div>

                <!-- Rating và số học viên -->
                <div class="flex min-h-8 flex-wrap items-center gap-3 text-sm text-slate-600 py-1">
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-span-full text-center py-12">
            <p class="text-slate-600 text-lg">
              <?php echo $searchQuery !== '' ? 'Không tìm thấy khóa học phù hợp' : 'Chưa có khóa học nào để hiển thị'; ?>
            </p>
          </div>
        <?php endif; ?>
      </div>

      <?php if ($totalPages > 1): ?>
        <nav class="mt-10 flex flex-wrap items-center justify-center gap-2" aria-label="Phân trang khóa học">
          <?php for ($pageNumber = 1; $pageNumber <= $totalPages; $pageNumber++): ?>
            <?php
              $pageUrl = '?' . http_build_query(array_merge($_GET, ['page' => $pageNumber]));
              $isActivePage = $pageNumber === $currentPage;
            ?>
            <a
              href="<?php echo htmlspecialchars($pageUrl); ?>"
              class="flex h-11 min-w-11 items-center justify-center rounded-xl border px-4 text-sm font-semibold transition <?php echo $isActivePage ? 'border-primary bg-primary text-white shadow-md' : 'border-slate-200 bg-white text-slate-700 hover:border-primary hover:text-primary'; ?>"
              <?php echo $isActivePage ? 'aria-current="page"' : ''; ?>
            >
              <?php echo $pageNumber; ?>
            </a>
          <?php endfor; ?>
        </nav>
      <?php endif; ?>
    </div>
  </section>
</div>

<script>
  const openFilterBtn = document.getElementById('openFilterBtn');
  const filterDropdown = document.getElementById('filterDropdown');
  const applyFilterBtn = document.getElementById('applyFilterBtn');
  const resetFilterBtn = document.getElementById('resetFilterBtn');

  const closeFilter = () => {
    filterDropdown.classList.add('hidden');
    openFilterBtn.setAttribute('aria-expanded', 'false');
  };

  openFilterBtn.addEventListener('click', (event) => {
    event.stopPropagation();
    const isOpen = !filterDropdown.classList.contains('hidden');

    filterDropdown.classList.toggle('hidden', isOpen);
    openFilterBtn.setAttribute('aria-expanded', String(!isOpen));
  });

  filterDropdown.addEventListener('click', (event) => {
    event.stopPropagation();
  });

  applyFilterBtn.addEventListener('click', closeFilter);
  resetFilterBtn.addEventListener('click', closeFilter);

  document.addEventListener('click', closeFilter);
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closeFilter();
    }
  });
</script>

<?php include '../components/footer.php'; ?>
