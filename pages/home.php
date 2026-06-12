<?php
require_once '../core/Database.php';
require_once '../models/Course.php';
include '../components/header.php';

$courseModel = new Course(Database::getConnection());
$featuredCourses = $courseModel->getAll(null, 3);

function homeAvatarUrl($index) {
    return 'https://i.pravatar.cc/80?img=' . ($index % 10);
}
?>
<div class="page-enter">
  <!-- ============ 1. HERO SECTION ============ -->
  <section class="relative w-full h-screen lg:h-[600px] overflow-hidden">
    <style>
      .opacity-0 { opacity: 0 !important; }
      .opacity-100 { opacity: 1 !important; }
      .carousel-slide { transition: opacity 1s ease-in-out; }
      .carousel-slide img { display: block; }
    </style>
    <!-- Background Carousel Container -->
    <div class="hero-carousel absolute inset-0 w-full h-full">
      <!-- Slide 1: Image -->
      <div class="carousel-slide absolute inset-0 opacity-100">
        <img src="../assets/images/anh1.jpg" alt="Hero" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/30"></div>
      </div>

      <!-- Slide 2: Image -->
      <div class="carousel-slide absolute inset-0 opacity-0">
        <img src="../assets/images/anh2.jpg" alt="Hero" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/30"></div>
      </div>
    </div>

    <!-- Navigation Indicators -->
    <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 z-20 flex gap-2">
      <button class="carousel-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition active" data-index="0"></button>
      <button class="carousel-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition" data-index="1"></button>
    </div>

    <!-- Content: Centered Text -->
    <div class="relative h-full flex flex-col items-center justify-center px-4 z-10">
      <div class="text-center max-w-3xl">
        <h1 class="mb-6 text-4xl font-bold leading-tight md:text-5xl lg:text-6xl text-white text-glow slide-from-left drop-shadow-lg">
          Xem anime<br>
          <span class="text-white/95">Trở thành wibu top 1 VN</span>
        </h1>
        <p class="mb-8 text-lg md:text-xl text-white/90 leading-relaxed drop-shadow-md">
          Khám phá hơn 200+ bộ anime chất lượng cao từ các nhà sản xuất hàng đầu. Bắt đầu hành trình trở thành wibu top 1 VN ngay hôm nay.
        </p>
        <form action="courses.php" method="get" class="mx-auto mb-6 max-w-2xl">
          <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <div class="relative flex-1">
              <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-white/75"></i>
              <input
                type="search"
                name="q"
                class="h-14 w-full rounded-xl border-2 border-white bg-transparent pl-12 pr-4 text-base font-semibold text-white outline-none backdrop-blur transition placeholder:text-white/80 hover:bg-white/10 focus:bg-white/20 focus:ring-2 focus:ring-white/30"
                placeholder="Tìm khóa học bạn muốn học..."
              >
            </div>
            <button type="submit" class="rounded-xl border-2 border-white bg-transparent px-6 py-3.5 font-semibold text-white backdrop-blur transition hover:bg-white/20 sm:min-w-32">
              Tìm kiếm
            </button>
          </div>
        </form>
        <div class="flex flex-col gap-3 sm:flex-row justify-center">
          <a href="courses.php" class="btn-premium rounded-xl bg-white px-8 py-3 font-semibold text-primary shadow-lg hover:bg-white/90 transform hover:scale-105 transition">
            Khám phá khóa học <i class="fa-solid fa-arrow-right ml-2"></i>
          </a>
          <a href="#learning-path" class="btn-premium rounded-xl border-2 border-white px-8 py-3 font-semibold text-white hover:bg-white/20 backdrop-blur transition">
            Xem lộ trình học <i class="fa-solid fa-graduation-cap ml-2"></i>
          </a>
        </div>
      </div>
    </div>

    <!-- Carousel Navigation Arrows -->
    <button class="carousel-prev absolute left-4 top-1/2 transform -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/30 hover:bg-white/50 text-white transition flex items-center justify-center">
      <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button class="carousel-next absolute right-4 top-1/2 transform -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/30 hover:bg-white/50 text-white transition flex items-center justify-center">
      <i class="fa-solid fa-chevron-right"></i>
    </button>
  </section>

  <script>
    // Carousel functionality
    document.addEventListener('DOMContentLoaded', function() {
      const carousel = document.querySelector('.hero-carousel');
      const slides = carousel.querySelectorAll('.carousel-slide');
      const indicators = document.querySelectorAll('.carousel-indicator');
      const prevBtn = document.querySelector('.carousel-prev');
      const nextBtn = document.querySelector('.carousel-next');
      let currentIndex = 0;
      let autoplayInterval;

      function showSlide(index) {
        slides.forEach((slide, i) => {
          if (i === index) {
            slide.classList.remove('opacity-0');
            slide.classList.add('opacity-100');
          } else {
            slide.classList.remove('opacity-100');
            slide.classList.add('opacity-0');
          }
        });
        indicators.forEach((indicator, i) => {
          if (i === index) {
            indicator.classList.add('active');
            indicator.classList.remove('bg-white/50');
            indicator.classList.add('bg-white');
          } else {
            indicator.classList.remove('active');
            indicator.classList.add('bg-white/50');
            indicator.classList.remove('bg-white');
          }
        });
      }

      function nextSlide() {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
      }

      function prevSlide() {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(currentIndex);
      }

      function startAutoplay() {
        autoplayInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
      }

      function stopAutoplay() {
        clearInterval(autoplayInterval);
      }

      // Event listeners
      if (prevBtn) prevBtn.addEventListener('click', prevSlide);
      if (nextBtn) nextBtn.addEventListener('click', nextSlide);
      
      indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
          currentIndex = index;
          showSlide(currentIndex);
          stopAutoplay();
          startAutoplay();
        });
      });

      // Initialize
      showSlide(0);
      if (slides.length > 1) {
        startAutoplay();
      }
    });
  </script>

  <!-- ============ 2. FEATURED CATEGORIES ============ -->
  <section class="bg-slate-50 py-16">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
      <div class="mb-12 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-3">Danh mục khóa học</h2>
      </div>
      <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
        <a href="courses.php" class="group rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300">
          <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white group-hover:scale-110 transition">
            <i class="fa-solid fa-js text-xl"></i>
          </div>
          <p class="font-bold text-slate-900">JavaScript</p>
          <p class="text-sm text-slate-500 mt-1">45 khóa học</p>
        </a>
        <a href="courses.php" class="group rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300">
          <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-cyan-500 to-cyan-600 text-white group-hover:scale-110 transition">
            <i class="fa-brands fa-python text-xl"></i>
          </div>
          <p class="font-bold text-slate-900">Python</p>
          <p class="text-sm text-slate-500 mt-1">38 khóa học</p>
        </a>
        <a href="courses.php" class="group rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300">
          <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white group-hover:scale-110 transition">
            <i class="fa-brands fa-react text-xl"></i>
          </div>
          <p class="font-bold text-slate-900">React</p>
          <p class="text-sm text-slate-500 mt-1">32 khóa học</p>
        </a>
        <a href="courses.php" class="group rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300">
          <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 text-white group-hover:scale-110 transition">
            <i class="fa-brands fa-node-js text-xl"></i>
          </div>
          <p class="font-bold text-slate-900">Node.js</p>
          <p class="text-sm text-slate-500 mt-1">28 khóa học</p>
        </a>
        <a href="courses.php" class="group rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300">
          <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-red-500 to-red-600 text-white group-hover:scale-110 transition">
            <i class="fa-solid fa-code text-xl"></i>
          </div>
          <p class="font-bold text-slate-900">TypeScript</p>
          <p class="text-sm text-slate-500 mt-1">25 khóa học</p>
        </a>
        <a href="courses.php" class="group rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300">
          <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 text-white group-hover:scale-110 transition">
            <i class="fa-brands fa-vuejs text-xl"></i>
          </div>
          <p class="font-bold text-slate-900">Vue.js</p>
          <p class="text-sm text-slate-500 mt-1">20 khóa học</p>
        </a>
      </div>
    </div>
  </section>

  <!-- ============ 3. WHY CHOOSE US ============ -->
  <section id="about" class="py-24 bg-slate-50 relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
      <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-indigo-100/40 blur-3xl"></div>
      <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-cyan-100/40 blur-3xl"></div>
    </div>
    
    <div class="mx-auto max-w-7xl px-4 lg:px-8 relative z-10">
      <div class="mb-16 text-center max-w-3xl mx-auto">
        <span class="text-sm font-bold tracking-wider text-primary uppercase mb-2 block">Về Chúng Tôi</span>
        <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4">Tại sao chọn <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-cyan-500">LearnCode?</span></h2>
        <p class="text-lg text-slate-600">Chúng tôi không chỉ dạy lập trình, chúng tôi định hình sự nghiệp của bạn với phương pháp học tập tiên tiến nhất.</p>
      </div>
      
      <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <!-- Card 1 -->
        <div class="group relative rounded-3xl bg-white p-8 shadow-sm hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-slate-100 overflow-hidden">
          <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
          <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white shadow-lg shadow-indigo-200">
            <i class="fa-solid fa-gem text-2xl"></i>
          </div>
          <h3 class="mb-3 text-2xl font-bold text-slate-900">Nội dung cao cấp</h3>
          <p class="text-slate-600 leading-relaxed">Giáo trình được tinh chỉnh bởi các chuyên gia hàng đầu, bám sát thực tế doanh nghiệp.</p>
        </div>
        <!-- Card 2 -->
        <div class="group relative rounded-3xl bg-white p-8 shadow-sm hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-slate-100 overflow-hidden">
          <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
          <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500 to-cyan-600 text-white shadow-lg shadow-cyan-200">
            <i class="fa-solid fa-users-rays text-2xl"></i>
          </div>
          <h3 class="mb-3 text-2xl font-bold text-slate-900">Cộng đồng sôi nổi</h3>
          <p class="text-slate-600 leading-relaxed">Kết nối, hỏi đáp và phát triển cùng hàng ngàn lập trình viên tài năng trên toàn quốc.</p>
        </div>
        <!-- Card 3 -->
        <div class="group relative rounded-3xl bg-white p-8 shadow-sm hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-slate-100 overflow-hidden">
          <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
          <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white shadow-lg shadow-emerald-200">
            <i class="fa-solid fa-chart-line text-2xl"></i>
          </div>
          <h3 class="mb-3 text-2xl font-bold text-slate-900">Lộ trình cá nhân hóa</h3>
          <p class="text-slate-600 leading-relaxed">Hệ thống phân tích AI giúp theo dõi và đề xuất lộ trình học tối ưu nhất cho bạn.</p>
        </div>
        <!-- Card 4 -->
        <div class="group relative rounded-3xl bg-white p-8 shadow-sm hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-slate-100 overflow-hidden">
          <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-50 to-amber-100 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
          <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 text-white shadow-lg shadow-amber-200">
            <i class="fa-solid fa-laptop-code text-2xl"></i>
          </div>
          <h3 class="mb-3 text-2xl font-bold text-slate-900">Thực chiến 100%</h3>
          <p class="text-slate-600 leading-relaxed">Học qua các dự án thực tế, xây dựng portfolio ấn tượng ngay trong quá trình học.</p>
        </div>
        <!-- Card 5 -->
        <div class="group relative rounded-3xl bg-white p-8 shadow-sm hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-slate-100 overflow-hidden">
          <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-rose-50 to-rose-100 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
          <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-rose-500 to-rose-600 text-white shadow-lg shadow-rose-200">
            <i class="fa-solid fa-certificate text-2xl"></i>
          </div>
          <h3 class="mb-3 text-2xl font-bold text-slate-900">Chứng chỉ uy tín</h3>
          <p class="text-slate-600 leading-relaxed">Chứng chỉ được công nhận rộng rãi, giúp bạn tự tin ứng tuyển vào các công ty công nghệ lớn.</p>
        </div>
        <!-- Card 6 -->
        <div class="group relative rounded-3xl bg-white p-8 shadow-sm hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-slate-100 overflow-hidden">
          <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-blue-100 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
          <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-200">
            <i class="fa-solid fa-headset text-2xl"></i>
          </div>
          <h3 class="mb-3 text-2xl font-bold text-slate-900">Hỗ trợ 24/7</h3>
          <p class="text-slate-600 leading-relaxed">Đội ngũ mentor luôn sẵn sàng giải đáp mọi thắc mắc của bạn bất cứ lúc nào.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ 4. FEATURED COURSES ============ -->
  <section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
      <div class="mb-12 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center sm:items-center">
        <div>
          <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-2">Khóa học nổi bật</h2>
          <p class="text-lg text-slate-600">Những khóa học được yêu thích và đánh giá cao nhất</p>
        </div>
        <a href="courses.php" class="rounded-xl border border-primary bg-white px-6 py-2.5 font-semibold text-primary hover:bg-primary/5">
          Xem tất cả <i class="fa-solid fa-arrow-right ml-2"></i>
        </a>
      </div>
      <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <?php if (!empty($featuredCourses)): ?>
          <?php foreach ($featuredCourses as $index => $course): ?>
            <?php
              $avgRating = $courseModel->getAverageRating($course['id']);
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

                <div class="flex min-h-11 items-center gap-2 pt-2 border-t border-slate-100">
                  <img class="h-8 w-8 rounded-full ring-2 ring-primary/20" src="<?php echo homeAvatarUrl($index); ?>" alt="">
                  <span class="text-sm font-medium text-slate-800"><?php echo htmlspecialchars($course['giang_vien'] ?? 'Chưa xác định'); ?></span>
                </div>

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

                <div class="flex min-h-8 flex-wrap items-center gap-3 text-sm text-slate-600 py-1">
                  <?php if ($avgRating): ?>
                    <span class="flex items-center gap-1">
                      <i class="fa-solid fa-star text-warning text-sm"></i>
                      <b class="text-slate-900"><?php echo number_format($avgRating, 1); ?></b>
                    </span>
                  <?php endif; ?>
                  <span class="flex items-center gap-1">
                    <i class="fa-solid fa-users text-primary text-sm"></i>
                    <?php echo number_format($course['so_hoc_vien']); ?>
                  </span>
                  <?php if ($course['thoi_luong']): ?>
                    <span class="flex items-center gap-1">
                      <i class="fa-regular fa-hourglass text-primary text-sm"></i>
                      <?php echo $course['thoi_luong']; ?>h
                    </span>
                  <?php endif; ?>
                </div>

                <a href="course-detail.php?id=<?php echo $course['id']; ?>" class="w-full rounded-xl bg-primary px-4 py-2.5 font-semibold text-white btn-premium transition hover:bg-indigo-700 shadow-md hover:shadow-lg block text-center text-sm">
                  Xem chi tiết
                </a>
              </div>
            </article>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-span-full text-center py-12">
            <p class="text-slate-600 text-lg">Chưa có khóa học nổi bật để hiển thị</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- ============ 5. LEARNING PATH ============ -->
  <section id="learning-path" class="py-20 bg-gradient-to-br from-slate-50 to-slate-100">
    <div class="mx-auto max-w-4xl px-4 lg:px-8">
      <div class="mb-12 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-3">Lộ trình học tập</h2>
        <p class="text-lg text-slate-600">Từ người mới bắt đầu đến lập trình viên chuyên nghiệp</p>
      </div>
      <div class="space-y-4">
        <div class="flex gap-4 items-stretch group">
          <div class="flex flex-col items-center">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-primary to-cyan-500 text-white font-bold text-sm">1</div>
            <div class="h-12 w-1 bg-gradient-to-b from-primary to-cyan-500 group-last:hidden"></div>
          </div>
          <div class="flex-1 rounded-2xl border-2 border-primary/20 bg-white p-6 hover:border-primary hover:shadow-lg transition">
            <h3 class="text-xl font-bold text-slate-900 mb-2">Cơ bản <span class="text-sm font-normal text-slate-500">(4-6 tuần)</span></h3>
            <p class="text-slate-700">Học nền tảng HTML, CSS, JavaScript. Hiểu các khái niệm cơ bản của lập trình web.</p>
            <div class="mt-4 flex flex-wrap gap-2">
              <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-sm">HTML</span>
              <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-sm">CSS</span>
              <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-sm">JavaScript</span>
            </div>
          </div>
        </div>

        <div class="flex gap-4 items-stretch group">
          <div class="flex flex-col items-center">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-cyan-500 to-emerald-500 text-white font-bold text-sm">2</div>
            <div class="h-12 w-1 bg-gradient-to-b from-cyan-500 to-emerald-500 group-last:hidden"></div>
          </div>
          <div class="flex-1 rounded-2xl border-2 border-cyan-500/20 bg-white p-6 hover:border-cyan-500 hover:shadow-lg transition">
            <h3 class="text-xl font-bold text-slate-900 mb-2">Trung cấp <span class="text-sm font-normal text-slate-500">(6-8 tuần)</span></h3>
            <p class="text-slate-700">Thành thạo React, Node.js, làm việc với API. Xây dựng ứng dụng web thực tế.</p>
            <div class="mt-4 flex flex-wrap gap-2">
              <span class="inline-block px-3 py-1 rounded-full bg-cyan-500/10 text-cyan-600 text-sm">React</span>
              <span class="inline-block px-3 py-1 rounded-full bg-cyan-500/10 text-cyan-600 text-sm">Node.js</span>
              <span class="inline-block px-3 py-1 rounded-full bg-cyan-500/10 text-cyan-600 text-sm">APIs</span>
            </div>
          </div>
        </div>

        <div class="flex gap-4 items-stretch group">
          <div class="flex flex-col items-center">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-green-500 text-white font-bold text-sm">3</div>
            <div class="h-12 w-1 bg-gradient-to-b from-emerald-500 to-green-500 group-last:hidden"></div>
          </div>
          <div class="flex-1 rounded-2xl border-2 border-emerald-500/20 bg-white p-6 hover:border-emerald-500 hover:shadow-lg transition">
            <h3 class="text-xl font-bold text-slate-900 mb-2">Nâng cao <span class="text-sm font-normal text-slate-500">(8-12 tuần)</span></h3>
            <p class="text-slate-700">Full-stack development, database, deployment. Sẵn sàng cho việc làm chuyên nghiệp.</p>
            <div class="mt-4 flex flex-wrap gap-2">
              <span class="inline-block px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 text-sm">Full-Stack</span>
              <span class="inline-block px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 text-sm">Database</span>
              <span class="inline-block px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 text-sm">DevOps</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ 6. TESTIMONIALS ============ -->
  <section class="py-20 bg-gradient-to-br from-slate-50 to-slate-100">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
      <div class="mb-12 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-3">Phản hồi từ học viên</h2>
        <p class="text-lg text-slate-600">Những câu chuyện thành công từ cộng đồng LearnCode</p>
      </div>
      <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm hover:shadow-lg transition">
          <div class="mb-4 flex items-center gap-2">
            <div class="flex gap-1">
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
            </div>
            <span class="text-sm font-semibold text-slate-600">5.0</span>
          </div>
          <i class="fa-solid fa-quote-left text-3xl text-primary/20 mb-4 block"></i>
          <p class="mb-6 text-slate-700 italic">"Khóa học React của LearnCode thay đổi hoàn toàn sự nghiệp của tôi. Giáo viên rất giỏi và hỗ trợ tuyệt vời!"</p>
          <div class="flex items-center gap-3 pt-6 border-t border-slate-200">
            <img class="h-12 w-12 rounded-full" src="https://i.pravatar.cc/150?img=10" alt="">
            <div>
              <p class="font-bold text-slate-900">Trần Minh Anh</p>
              <p class="text-sm text-slate-500">Full-stack Developer tại Startup XYZ</p>
            </div>
          </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm hover:shadow-lg transition">
          <div class="mb-4 flex items-center gap-2">
            <div class="flex gap-1">
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
            </div>
            <span class="text-sm font-semibold text-slate-600">5.0</span>
          </div>
          <i class="fa-solid fa-quote-left text-3xl text-primary/20 mb-4 block"></i>
          <p class="mb-6 text-slate-700 italic">"Từ không biết code, giờ tôi đã có thể xây dựng các ứng dụng web hoàn chỉnh. Cảm ơn LearnCode!"</p>
          <div class="flex items-center gap-3 pt-6 border-t border-slate-200">
            <img class="h-12 w-12 rounded-full" src="https://i.pravatar.cc/150?img=11" alt="">
            <div>
              <p class="font-bold text-slate-900">Nguyễn Văn Huy</p>
              <p class="text-sm text-slate-500">Frontend Developer tại Tech Corp</p>
            </div>
          </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm hover:shadow-lg transition">
          <div class="mb-4 flex items-center gap-2">
            <div class="flex gap-1">
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
              <i class="fa-solid fa-star text-amber-400"></i>
            </div>
            <span class="text-sm font-semibold text-slate-600">5.0</span>
          </div>
          <i class="fa-solid fa-quote-left text-3xl text-primary/20 mb-4 block"></i>
          <p class="mb-6 text-slate-700 italic">"Tôi rất ấn tượng với chất lượng nội dung và cách giảng dạy của các giáo viên. Đáng đầu tư!"</p>
          <div class="flex items-center gap-3 pt-6 border-t border-slate-200">
            <img class="h-12 w-12 rounded-full" src="https://i.pravatar.cc/150?img=12" alt="">
            <div>
              <p class="font-bold text-slate-900">Phạm Thị Linh</p>
              <p class="text-sm text-slate-500">Backend Developer tại Digital Agency</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ 7. FEATURED BLOG POSTS ============ -->
  <section class="py-20 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
      <div class="mb-12 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
        <div>
          <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-2">Bài viết nổi bật</h2>
          <p class="text-lg text-slate-600">Kiến thức và kinh nghiệm từ cộng đồng</p>
        </div>
        <a href="forum.php" class="rounded-xl border border-primary bg-white px-6 py-2.5 font-semibold text-primary hover:bg-primary/5">
          Xem tất cả <i class="fa-solid fa-arrow-right ml-2"></i>
        </a>
      </div>
      <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <article class="group flex flex-col rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-lg transition">
          <div class="mb-4 flex items-center gap-3 p-6 pb-0">
            <img class="h-10 w-10 rounded-full" src="https://i.pravatar.cc/150?img=1" alt="">
            <div>
              <p class="font-semibold text-slate-900">Nguyễn Văn D</p>
              <p class="text-sm text-slate-500">2 tuần trước</p>
            </div>
          </div>
          <div class="flex-1 px-6">
            <h3 class="line-clamp-2 text-lg font-bold text-slate-900 mb-2">10 tips để code JavaScript hiệu quả hơn</h3>
            <p class="line-clamp-3 text-slate-600">Những mẹo nhỏ giúp bạn viết code sạch hơn và hiệu quả hơn.</p>
          </div>
          <div class="border-t border-slate-200 px-6 py-4">
            <div class="flex items-center justify-between text-sm text-slate-600">
              <div class="flex items-center gap-4">
                <span><i class="fa-regular fa-heart"></i> 245</span>
                <span><i class="fa-regular fa-comment"></i> 32</span>
              </div>
              <span>1,250 lượt xem</span>
            </div>
          </div>
        </article>

        <article class="group flex flex-col rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-lg transition">
          <div class="mb-4 flex items-center gap-3 p-6 pb-0">
            <img class="h-10 w-10 rounded-full" src="https://i.pravatar.cc/150?img=2" alt="">
            <div>
              <p class="font-semibold text-slate-900">Trần Thị E</p>
              <p class="text-sm text-slate-500">3 tuần trước</p>
            </div>
          </div>
          <div class="flex-1 px-6">
            <h3 class="line-clamp-2 text-lg font-bold text-slate-900 mb-2">Tương lai của AI trong lập trình</h3>
            <p class="line-clamp-3 text-slate-600">AI đang thay đổi cách chúng ta viết code và phát triển sản phẩm.</p>
          </div>
          <div class="border-t border-slate-200 px-6 py-4">
            <div class="flex items-center justify-between text-sm text-slate-600">
              <div class="flex items-center gap-4">
                <span><i class="fa-regular fa-heart"></i> 189</span>
                <span><i class="fa-regular fa-comment"></i> 28</span>
              </div>
              <span>980 lượt xem</span>
            </div>
          </div>
        </article>

        <article class="group flex flex-col rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-lg transition">
          <div class="mb-4 flex items-center gap-3 p-6 pb-0">
            <img class="h-10 w-10 rounded-full" src="https://i.pravatar.cc/150?img=3" alt="">
            <div>
              <p class="font-semibold text-slate-900">Lê Văn F</p>
              <p class="text-sm text-slate-500">1 tháng trước</p>
            </div>
          </div>
          <div class="flex-1 px-6">
            <h3 class="line-clamp-2 text-lg font-bold text-slate-900 mb-2">Best practices khi làm việc với React Hooks</h3>
            <p class="line-clamp-3 text-slate-600">Những pattern cần biết khi sử dụng Hooks trong dự án lớn.</p>
          </div>
          <div class="border-t border-slate-200 px-6 py-4">
            <div class="flex items-center justify-between text-sm text-slate-600">
              <div class="flex items-center gap-4">
                <span><i class="fa-regular fa-heart"></i> 312</span>
                <span><i class="fa-regular fa-comment"></i> 45</span>
              </div>
              <span>1,580 lượt xem</span>
            </div>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- ============ 8. TEAM SECTION ============ -->
  <section class="py-24 bg-slate-900 text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-primary/20 to-transparent pointer-events-none"></div>
    <div class="mx-auto max-w-7xl px-4 lg:px-8 relative z-10">
      <div class="mb-16 text-center max-w-3xl mx-auto">
        <span class="text-sm font-bold tracking-wider text-cyan-400 uppercase mb-2 block">Chuyên gia của chúng tôi</span>
        <h2 class="text-4xl md:text-5xl font-extrabold mb-4">Đội ngũ <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-primary">Giảng viên</span></h2>
        <p class="text-lg text-slate-300">Học hỏi trực tiếp từ những kỹ sư dày dặn kinh nghiệm đến từ các tập đoàn công nghệ hàng đầu.</p>
      </div>
      
      <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Mentor 1 -->
        <div class="group relative rounded-3xl bg-white/5 border border-white/10 overflow-hidden backdrop-blur-sm hover:-translate-y-3 transition-all duration-500">
          <div class="aspect-[4/5] overflow-hidden">
            <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&q=80" alt="Mentor">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent opacity-80 group-hover:opacity-60 transition-opacity duration-300"></div>
          </div>
          <div class="absolute bottom-0 left-0 w-full p-6 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
            <h3 class="text-2xl font-bold text-white mb-1">Tuấn Anh</h3>
            <p class="text-cyan-400 font-medium mb-3">Senior Software Engineer</p>
            <div class="flex gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary hover:text-white transition-colors"><i class="fa-brands fa-linkedin-in"></i></a>
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-cyan-500 hover:text-white transition-colors"><i class="fa-brands fa-github"></i></a>
            </div>
          </div>
        </div>
        <!-- Mentor 2 -->
        <div class="group relative rounded-3xl bg-white/5 border border-white/10 overflow-hidden backdrop-blur-sm hover:-translate-y-3 transition-all duration-500">
          <div class="aspect-[4/5] overflow-hidden">
            <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&q=80" alt="Mentor">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent opacity-80 group-hover:opacity-60 transition-opacity duration-300"></div>
          </div>
          <div class="absolute bottom-0 left-0 w-full p-6 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
            <h3 class="text-2xl font-bold text-white mb-1">Minh Hà</h3>
            <p class="text-cyan-400 font-medium mb-3">Frontend Team Lead</p>
            <div class="flex gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary hover:text-white transition-colors"><i class="fa-brands fa-linkedin-in"></i></a>
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-cyan-500 hover:text-white transition-colors"><i class="fa-brands fa-github"></i></a>
            </div>
          </div>
        </div>
        <!-- Mentor 3 -->
        <div class="group relative rounded-3xl bg-white/5 border border-white/10 overflow-hidden backdrop-blur-sm hover:-translate-y-3 transition-all duration-500 mt-0 lg:mt-8">
          <div class="aspect-[4/5] overflow-hidden">
            <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&q=80" alt="Mentor">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent opacity-80 group-hover:opacity-60 transition-opacity duration-300"></div>
          </div>
          <div class="absolute bottom-0 left-0 w-full p-6 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
            <h3 class="text-2xl font-bold text-white mb-1">Hoàng Nam</h3>
            <p class="text-cyan-400 font-medium mb-3">Cloud Architect</p>
            <div class="flex gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary hover:text-white transition-colors"><i class="fa-brands fa-linkedin-in"></i></a>
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-cyan-500 hover:text-white transition-colors"><i class="fa-brands fa-github"></i></a>
            </div>
          </div>
        </div>
        <!-- Mentor 4 -->
        <div class="group relative rounded-3xl bg-white/5 border border-white/10 overflow-hidden backdrop-blur-sm hover:-translate-y-3 transition-all duration-500 mt-0 lg:mt-8">
          <div class="aspect-[4/5] overflow-hidden">
            <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&q=80" alt="Mentor">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent opacity-80 group-hover:opacity-60 transition-opacity duration-300"></div>
          </div>
          <div class="absolute bottom-0 left-0 w-full p-6 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
            <h3 class="text-2xl font-bold text-white mb-1">Thu Thủy</h3>
            <p class="text-cyan-400 font-medium mb-3">AI Researcher</p>
            <div class="flex gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary hover:text-white transition-colors"><i class="fa-brands fa-linkedin-in"></i></a>
              <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-cyan-500 hover:text-white transition-colors"><i class="fa-brands fa-github"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ 9. FINAL CTA ============ -->
  <section class="py-20 text-slate-900 relative overflow-hidden">
    <div class="relative mx-auto max-w-4xl px-4 text-center lg:px-8">
      <h2 class="text-3xl md:text-5xl font-bold mb-4">Bắt đầu hành trình học tập</h2>
      <p class="text-xl text-slate-600 mb-8">Tham gia hàng ngàn học viên đang theo đuổi ước mơ trở thành lập trình viên chuyên nghiệp.</p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="register.php" class="rounded-xl bg-white px-8 py-4 font-bold text-primary shadow-lg hover:shadow-2xl hover:scale-105 transition inline-block">
          Đăng ký miễn phí ngay <i class="fa-solid fa-arrow-right ml-2"></i>
        </a>
        <a href="courses.php" class="rounded-xl border-2 border-slate-300 px-8 py-4 font-bold text-primary hover:bg-slate-100 transition inline-block">
          Khám phá khóa học <i class="fa-solid fa-book ml-2"></i>
        </a>
      </div>
      <p class="mt-8 text-slate-600">💡 Không cần kinh nghiệm trước đây • ✅ Học tập linh hoạt • 🎯 Chứng chỉ chính thức</p>
    </div>
  </section>

  <!-- ============ 12. CONTACT SECTION ============ -->
  <section id="contact" class="py-24 bg-white relative">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
      <div class="grid lg:grid-cols-2 gap-16 items-center">
        <!-- Contact Info -->
        <div>
          <span class="text-sm font-bold tracking-wider text-primary uppercase mb-2 block">Liên hệ</span>
          <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6">Kết nối với <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-cyan-500">LearnCode</span></h2>
          <p class="text-lg text-slate-600 mb-10">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn trên con đường chinh phục công nghệ. Đừng ngần ngại liên hệ!</p>
          
          <div class="space-y-8">
            <div class="flex items-start gap-5 group">
              <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-primary transition-all duration-300 group-hover:bg-primary group-hover:text-white group-hover:shadow-lg group-hover:shadow-primary/30">
                <i class="fa-solid fa-location-dot text-2xl"></i>
              </div>
              <div>
                <h4 class="text-xl font-bold text-slate-900 mb-1">Văn phòng chính</h4>
                <p class="text-slate-600 leading-relaxed">123 Đường Nguyễn Huệ<br>Quận 1, TP. Hồ Chí Minh</p>
              </div>
            </div>
            
            <div class="flex items-start gap-5 group">
              <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-600 transition-all duration-300 group-hover:bg-cyan-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-cyan-500/30">
                <i class="fa-solid fa-envelope text-2xl"></i>
              </div>
              <div>
                <h4 class="text-xl font-bold text-slate-900 mb-1">Email hỗ trợ</h4>
                <a href="mailto:contact@learncode.vn" class="text-slate-600 hover:text-cyan-600 transition-colors">contact@learncode.vn</a>
                <p class="text-sm text-slate-500 mt-1">Phản hồi trong vòng 24h</p>
              </div>
            </div>
            
            <div class="flex items-start gap-5 group">
              <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 transition-all duration-300 group-hover:bg-emerald-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-emerald-500/30">
                <i class="fa-solid fa-phone text-2xl"></i>
              </div>
              <div>
                <h4 class="text-xl font-bold text-slate-900 mb-1">Hotline & Zalo</h4>
                <a href="tel:+84123456789" class="text-slate-600 hover:text-emerald-600 transition-colors font-medium">0123 456 789</a>
                <p class="text-sm text-slate-500 mt-1">Thứ 2 - Thứ 6 (8:00 - 18:00)</p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Contact Form (Visual) -->
        <div class="rounded-3xl bg-white p-8 shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] border border-slate-100 relative">
          <div class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-br from-cyan-400 to-primary rounded-full blur-2xl opacity-20 pointer-events-none"></div>
          <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-gradient-to-tr from-rose-400 to-amber-400 rounded-full blur-2xl opacity-20 pointer-events-none"></div>
          
          <h3 class="text-2xl font-bold text-slate-900 mb-6 relative z-10">Gửi lời nhắn cho chúng tôi</h3>
          <form class="space-y-5 relative z-10" onsubmit="event.preventDefault(); alert('Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất!');">
            <div class="grid grid-cols-2 gap-5">
              <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700">Họ và tên</label>
                <input type="text" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20" placeholder="Nguyễn Văn A" required>
              </div>
              <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700">Số điện thoại</label>
                <input type="tel" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20" placeholder="0912..." required>
              </div>
            </div>
            <div class="space-y-2">
              <label class="text-sm font-semibold text-slate-700">Email</label>
              <input type="email" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20" placeholder="email@example.com" required>
            </div>
            <div class="space-y-2">
              <label class="text-sm font-semibold text-slate-700">Nội dung</label>
              <textarea rows="4" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20 resize-none" placeholder="Nhập tin nhắn của bạn..." required></textarea>
            </div>
            <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-primary to-cyan-500 px-6 py-4 font-bold text-white shadow-lg shadow-primary/30 transition-all hover:scale-[1.02] hover:shadow-xl hover:shadow-primary/40">
              Gửi tin nhắn <i class="fa-solid fa-paper-plane ml-2"></i>
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>

</div>

<?php include '../components/footer.php'; ?>
