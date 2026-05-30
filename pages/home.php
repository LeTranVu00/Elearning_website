<?php include '../components/header.php'; ?>
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

      <!-- Video example (uncomment to use):
      <div class="carousel-slide absolute inset-0 opacity-0">
        <video autoplay muted loop class="w-full h-full object-cover">
          <source src="video-url.mp4" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-black/20"></div>
      </div> -->
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
        <p class="text-lg text-slate-600">Chọn lĩnh vực bạn muốn học</p>
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
  <section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
      <div class="mb-12 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-3">Tại sao chọn LearnCode?</h2>
        <p class="text-lg text-slate-600">Những tính năng vượt trội giúp bạn thành công</p>
      </div>
      <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-2xl bg-gradient-to-br from-indigo-50 to-indigo-100 p-8 hover:shadow-lg transition">
          <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-500 text-white">
            <i class="fa-solid fa-book-open text-xl"></i>
          </div>
          <h3 class="mb-3 text-xl font-bold text-slate-900">Nội dung chất lượng</h3>
          <p class="text-slate-700">Khóa học được thiết kế bởi chuyên gia, cập nhật thường xuyên với công nghệ mới nhất.</p>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-cyan-50 to-cyan-100 p-8 hover:shadow-lg transition">
          <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-500 text-white">
            <i class="fa-solid fa-users text-xl"></i>
          </div>
          <h3 class="mb-3 text-xl font-bold text-slate-900">Cộng đồng sôi nổi</h3>
          <p class="text-slate-700">Kết nối với hàng ngàn học viên, chia sẻ kinh nghiệm và học hỏi cùng nhau.</p>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 p-8 hover:shadow-lg transition">
          <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-500 text-white">
            <i class="fa-solid fa-chart-line text-xl"></i>
          </div>
          <h3 class="mb-3 text-xl font-bold text-slate-900">Theo dõi tiến độ</h3>
          <p class="text-slate-700">Hệ thống theo dõi chi tiết giúp bạn đạt mục tiêu nhanh hơn.</p>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100 p-8 hover:shadow-lg transition">
          <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500 text-white">
            <i class="fa-solid fa-globe text-xl"></i>
          </div>
          <h3 class="mb-3 text-xl font-bold text-slate-900">Học mọi lúc mọi nơi</h3>
          <p class="text-slate-700">Truy cập khóa học trên mọi thiết bị, học tập linh hoạt theo lịch cá nhân.</p>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-rose-50 to-rose-100 p-8 hover:shadow-lg transition">
          <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-rose-500 text-white">
            <i class="fa-solid fa-certificate text-xl"></i>
          </div>
          <h3 class="mb-3 text-xl font-bold text-slate-900">Chứng chỉ công nhận</h3>
          <p class="text-slate-700">Nhận chứng chỉ hoàn thành để bổ sung hồ sơ ngành nghề.</p>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 p-8 hover:shadow-lg transition">
          <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500 text-white">
            <i class="fa-solid fa-headset text-xl"></i>
          </div>
          <h3 class="mb-3 text-xl font-bold text-slate-900">Hỗ trợ tận tình</h3>
          <p class="text-slate-700">Đội ngũ hỗ trợ luôn sẵn sàng giải đáp và đồng hành cùng bạn.</p>
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
      <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-2xl transition duration-300">
          <div class="relative aspect-video overflow-hidden bg-slate-200">
            <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=1200&q=80" alt="React" class="h-full w-full object-cover group-hover:scale-110 transition duration-300">
            <span class="absolute left-4 top-4 rounded-full bg-primary px-3 py-1 text-xs font-semibold text-white">Trung cấp</span>
            <button class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-slate-600 hover:text-red-500 hover:bg-white transition">
              <i class="fa-regular fa-heart"></i>
            </button>
          </div>
          <div class="space-y-4 p-6">
            <div>
              <h3 class="line-clamp-2 text-lg font-bold text-slate-900 mb-2">React từ cơ bản đến nâng cao</h3>
              <p class="line-clamp-2 text-slate-600">Học React từ đầu với dự án thực tế và best practices.</p>
            </div>
            <div class="flex items-center gap-3 text-sm text-slate-600">
              <img class="h-9 w-9 rounded-full" src="https://i.pravatar.cc/80?img=6" alt="">
              <span class="font-medium">Nguyễn Văn A</span>
            </div>
            <div class="flex flex-wrap gap-4 text-sm text-slate-600">
              <span><i class="fa-solid fa-star text-amber-400"></i> <b class="text-slate-900">4.8</b> (245)</span>
              <span><i class="fa-solid fa-users"></i> 1,234</span>
              <span><i class="fa-regular fa-clock"></i> 12 giờ</span>
            </div>
            <div class="flex items-baseline justify-between pt-4 border-t border-slate-200">
              <div>
                <span class="text-2xl font-bold text-primary">1,200,000₫</span>
                <span class="ml-2 text-sm text-slate-400 line-through">2,000,000₫</span>
              </div>
            </div>
            <a href="course-detail.php" class="w-full rounded-xl bg-primary px-4 py-2.5 font-semibold text-white hover:bg-indigo-700 transition text-center block">
              Xem chi tiết
            </a>
          </div>
        </article>

        <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-2xl transition duration-300">
          <div class="relative aspect-video overflow-hidden bg-slate-200">
            <img src="https://images.unsplash.com/photo-1579468118864-1b9ea3c0db4a?w=1200&q=80" alt="JavaScript" class="h-full w-full object-cover group-hover:scale-110 transition duration-300">
            <span class="absolute left-4 top-4 rounded-full bg-cyan-500 px-3 py-1 text-xs font-semibold text-white">Cơ bản</span>
            <button class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-slate-600 hover:text-red-500 hover:bg-white transition">
              <i class="fa-regular fa-heart"></i>
            </button>
          </div>
          <div class="space-y-4 p-6">
            <div>
              <h3 class="line-clamp-2 text-lg font-bold text-slate-900 mb-2">JavaScript ES6+ hiện đại</h3>
              <p class="line-clamp-2 text-slate-600">Làm chủ JavaScript hiện đại với ES6+ và nhiều kỹ thuật mới.</p>
            </div>
            <div class="flex items-center gap-3 text-sm text-slate-600">
              <img class="h-9 w-9 rounded-full" src="https://i.pravatar.cc/80?img=7" alt="">
              <span class="font-medium">Trần Thị B</span>
            </div>
            <div class="flex flex-wrap gap-4 text-sm text-slate-600">
              <span><i class="fa-solid fa-star text-amber-400"></i> <b class="text-slate-900">4.9</b> (312)</span>
              <span><i class="fa-solid fa-users"></i> 2,156</span>
              <span><i class="fa-regular fa-clock"></i> 10 giờ</span>
            </div>
            <div class="flex items-baseline justify-between pt-4 border-t border-slate-200">
              <div>
                <span class="text-2xl font-bold text-primary">900,000₫</span>
                <span class="ml-2 text-sm text-slate-400 line-through">1,500,000₫</span>
              </div>
            </div>
            <a href="course-detail.php" class="w-full rounded-xl bg-primary px-4 py-2.5 font-semibold text-white hover:bg-indigo-700 transition text-center block">
              Xem chi tiết
            </a>
          </div>
        </article>

        <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-2xl transition duration-300">
          <div class="relative aspect-video overflow-hidden bg-slate-200">
            <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=1200&q=80" alt="Full-stack" class="h-full w-full object-cover group-hover:scale-110 transition duration-300">
            <span class="absolute left-4 top-4 rounded-full bg-emerald-500 px-3 py-1 text-xs font-semibold text-white">Nâng cao</span>
            <button class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-slate-600 hover:text-red-500 hover:bg-white transition">
              <i class="fa-regular fa-heart"></i>
            </button>
          </div>
          <div class="space-y-4 p-6">
            <div>
              <h3 class="line-clamp-2 text-lg font-bold text-slate-900 mb-2">Full-stack Web Development</h3>
              <p class="line-clamp-2 text-slate-600">Trở thành full-stack developer với MERN stack.</p>
            </div>
            <div class="flex items-center gap-3 text-sm text-slate-600">
              <img class="h-9 w-9 rounded-full" src="https://i.pravatar.cc/80?img=8" alt="">
              <span class="font-medium">Lê Văn C</span>
            </div>
            <div class="flex flex-wrap gap-4 text-sm text-slate-600">
              <span><i class="fa-solid fa-star text-amber-400"></i> <b class="text-slate-900">4.7</b> (189)</span>
              <span><i class="fa-solid fa-users"></i> 856</span>
              <span><i class="fa-regular fa-clock"></i> 40 giờ</span>
            </div>
            <div class="flex items-baseline justify-between pt-4 border-t border-slate-200">
              <div>
                <span class="text-2xl font-bold text-primary">2,500,000₫</span>
                <span class="ml-2 text-sm text-slate-400 line-through">4,000,000₫</span>
              </div>
            </div>
            <a href="course-detail.php" class="w-full rounded-xl bg-primary px-4 py-2.5 font-semibold text-white hover:bg-indigo-700 transition text-center block">
              Xem chi tiết
            </a>
          </div>
        </article>
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
  <section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
      <div class="mb-12 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-3">Đội ngũ của chúng tôi</h2>
        <p class="text-lg text-slate-600">Những người đam mê và tận tâm với sứ mệnh giáo dục</p>
      </div>
      <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
        <div class="group rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm hover:shadow-lg transition">
          <img class="mx-auto mb-4 h-24 w-24 rounded-full object-cover" src="https://i.pravatar.cc/150?img=1" alt="">
          <h3 class="text-lg font-bold text-slate-900">Nguyễn Văn A</h3>
          <p class="text-primary font-semibold mb-2">CEO & Founder</p>
          <p class="text-sm text-slate-600 mb-4">10+ năm kinh nghiệm trong công nghệ và giáo dục.</p>
          <div class="flex justify-center gap-3 pt-4 border-t border-slate-200 opacity-0 group-hover:opacity-100 transition">
            <a href="#" class="text-primary hover:text-cyan-600"><i class="fa-brands fa-linkedin"></i></a>
            <a href="#" class="text-primary hover:text-cyan-600"><i class="fa-brands fa-twitter"></i></a>
          </div>
        </div>

        <div class="group rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm hover:shadow-lg transition">
          <img class="mx-auto mb-4 h-24 w-24 rounded-full object-cover" src="https://i.pravatar.cc/150?img=2" alt="">
          <h3 class="text-lg font-bold text-slate-900">Trần Thị B</h3>
          <p class="text-cyan-600 font-semibold mb-2">CTO</p>
          <p class="text-sm text-slate-600 mb-4">Chuyên gia về công nghệ học tập và phát triển sản phẩm.</p>
          <div class="flex justify-center gap-3 pt-4 border-t border-slate-200 opacity-0 group-hover:opacity-100 transition">
            <a href="#" class="text-primary hover:text-cyan-600"><i class="fa-brands fa-linkedin"></i></a>
            <a href="#" class="text-primary hover:text-cyan-600"><i class="fa-brands fa-twitter"></i></a>
          </div>
        </div>

        <div class="group rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm hover:shadow-lg transition">
          <img class="mx-auto mb-4 h-24 w-24 rounded-full object-cover" src="https://i.pravatar.cc/150?img=3" alt="">
          <h3 class="text-lg font-bold text-slate-900">Lê Văn C</h3>
          <p class="text-emerald-600 font-semibold mb-2">Head of Education</p>
          <p class="text-sm text-slate-600 mb-4">Giáo viên cao cấp với 15+ năm kinh nghiệm đào tạo.</p>
          <div class="flex justify-center gap-3 pt-4 border-t border-slate-200 opacity-0 group-hover:opacity-100 transition">
            <a href="#" class="text-primary hover:text-cyan-600"><i class="fa-brands fa-linkedin"></i></a>
            <a href="#" class="text-primary hover:text-cyan-600"><i class="fa-brands fa-twitter"></i></a>
          </div>
        </div>

        <div class="group rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm hover:shadow-lg transition">
          <img class="mx-auto mb-4 h-24 w-24 rounded-full object-cover" src="https://i.pravatar.cc/150?img=4" alt="">
          <h3 class="text-lg font-bold text-slate-900">Phạm Thị D</h3>
          <p class="text-pink-600 font-semibold mb-2">Head of Community</p>
          <p class="text-sm text-slate-600 mb-4">Chịu trách nhiệm xây dựng và phát triển cộng đồng học tập.</p>
          <div class="flex justify-center gap-3 pt-4 border-t border-slate-200 opacity-0 group-hover:opacity-100 transition">
            <a href="#" class="text-primary hover:text-cyan-600"><i class="fa-brands fa-linkedin"></i></a>
            <a href="#" class="text-primary hover:text-cyan-600"><i class="fa-brands fa-twitter"></i></a>
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
  <section id="contact" class="py-20 text-slate-900">
    <div class="mx-auto max-w-3xl px-4 text-center lg:px-8">
      <h2 class="mb-6 text-3xl font-bold md:text-4xl">Liên hệ với chúng tôi</h2>
      <p class="mb-12 text-lg text-slate-600">Chọn cách liên hệ phù hợp với bạn</p>
      
      <div class="flex flex-col items-center justify-center gap-8 sm:flex-row">
        <!-- Email -->
        <a href="mailto:contact@learncode.vn" class="group flex flex-col items-center gap-3 transition">
          <div class="flex h-24 w-24 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 transition group-hover:bg-emerald-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-emerald-500/50">
            <i class="fa-solid fa-envelope text-4xl"></i>
          </div>
          <span class="text-sm font-semibold text-slate-900">Gmail</span>
        </a>

        <!-- Zalo -->
        <a href="https://zalo.me/0396870877" target="_blank" rel="noreferrer" class="group flex flex-col items-center gap-3 transition">
          <div class="flex h-24 w-24 items-center justify-center rounded-full bg-blue-50 text-blue-600 transition group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-500/50">
            <i class="fa-solid fa-message text-4xl"></i>
          </div>
          <span class="text-sm font-semibold text-slate-900">Zalo</span>
        </a>

        <!-- Phone -->
        <a href="tel:+84123456789" class="group flex flex-col items-center gap-3 transition">
          <div class="flex h-24 w-24 items-center justify-center rounded-full bg-cyan-50 text-cyan-600 transition group-hover:bg-cyan-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-cyan-500/50">
            <i class="fa-solid fa-phone text-4xl"></i>
          </div>
          <span class="text-sm font-semibold text-slate-900">Điện thoại</span>
        </a>
      </div>
    </div>
  </section>

  <section class="bg-slate-50 py-16">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
      <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-slate-900">Địa chỉ văn phòng</h2>
        <p class="text-slate-600 mt-2">Ghé thăm chúng tôi tại văn phòng</p>
      </div>
      <div class="flex aspect-video items-center justify-center rounded-2xl border border-slate-200 bg-white text-center shadow-sm">
        <div>
          <i class="fa-solid fa-location-dot mb-4 text-5xl text-primary"></i>
          <p class="text-lg font-bold text-slate-900">123 Đường Nguyễn Huệ</p>
          <p class="text-slate-600">Quận 1, TP. Hồ Chí Minh</p>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include '../components/footer.php'; ?>
