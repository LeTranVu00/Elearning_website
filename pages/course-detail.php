<?php include '../components/header.php'; ?>
<div class="page-enter min-h-screen overflow-x-hidden pb-12">
      <section class="bg-gradient-to-r from-slate-900 to-slate-700 py-10 text-white bg-gradient-anim">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 lg:grid-cols-3 lg:px-8 scale-in">
          <div class="space-y-5 lg:col-span-2">
            <div class="flex flex-wrap items-center gap-2">
              <span class="rounded-full bg-primary px-3 py-1 text-xs font-semibold">Bestseller</span>
              <span class="rounded-full border border-white/30 px-3 py-1 text-xs">Trung cấp</span>
            </div>
            <h1 class="text-4xl font-bold">React từ cơ bản đến nâng cao</h1>
            <p class="text-white/80">Học React với dự án thực tế, sử dụng hooks, context, router và cách deploy lên production.</p>
            <div class="flex flex-wrap gap-4 text-sm text-white/80">
              <span><i class="fa-solid fa-star text-warning"></i> 4.8 (1,234 đánh giá)</span>
              <span><i class="fa-solid fa-users"></i> 2,156 học viên</span>
              <span><i class="fa-regular fa-clock"></i> 12 giờ</span>
              <span><i class="fa-solid fa-book-open"></i> 45 bài học</span>
            </div>
            <div class="flex items-center gap-3">
              <img class="h-12 w-12 rounded-full object-cover" src="https://i.pravatar.cc/150?img=5" alt="Nguyễn Văn A">
              <div>
                <p class="font-semibold">Nguyễn Văn A</p>
                <p class="text-sm text-white/70">Senior Frontend Developer</p>
              </div>
            </div>
          </div>

          <aside class="card-hover overflow-hidden rounded-2xl bg-white text-slate-900 shadow-soft">
            <div class="relative aspect-video">
              <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=1200&q=80" alt="React từ cơ bản đến nâng cao" class="h-full w-full object-cover card-img-zoom">
              <button class="absolute inset-0 flex items-center justify-center bg-black/40 text-white">
                <i class="fa-regular fa-circle-play text-6xl"></i>
              </button>
            </div>
            <div class="p-6">
              <div class="space-y-3 mt-4">
                <a href="../controllers/EnrollmentController.php?action=enroll&course_id=1" class="block w-full rounded-xl bg-primary px-4 py-3 font-semibold text-white btn-premium text-center text-lg shadow-lg hover:-translate-y-1 transition duration-300">Vào học ngay</a>
              </div>
              <div class="mt-4 flex justify-center gap-6 text-sm text-slate-500">
                <button><i class="fa-regular fa-heart"></i> Yêu thích</button>
                <button><i class="fa-solid fa-share-nodes"></i> Chia sẻ</button>
              </div>
            </div>
          </aside>
        </div>
      </section>

      <section class="py-8">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 lg:grid-cols-3 lg:px-8">
          <div class="lg:col-span-2 min-w-0">
            <div class="hide-scrollbar mb-6 overflow-x-auto">
              <div class="inline-flex gap-2 rounded-xl border border-slate-200 bg-white p-1">
                <button data-action="set-course-detail-tab" data-value="overview" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white">Tổng quan</button>
                <button data-action="set-course-detail-tab" data-value="curriculum" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">Nội dung khóa học</button>
                <button data-action="set-course-detail-tab" data-value="instructor" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">Giảng viên</button>
                <button data-action="set-course-detail-tab" data-value="reviews" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">Đánh giá</button>
              </div>
            </div>
            
    <div class="space-y-6 slide-from-left">
      <article class="card-hover rounded-2xl border border-slate-200 bg-white p-6">
        <h3 class="mb-4 text-xl font-bold">Bạn sẽ học được gì</h3>
        <div class="grid gap-3 md:grid-cols-2">
          
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Hiểu rõ React và các khái niệm cốt lõi.</span>
                </div>
              
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Xây dựng ứng dụng web với React Hooks.</span>
                </div>
              
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Quản lý state với Context API.</span>
                </div>
              
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Routing với React Router.</span>
                </div>
              
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Testing và Debugging React apps.</span>
                </div>
              
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Performance optimization techniques.</span>
                </div>
              
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Best practices và design patterns.</span>
                </div>
              
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Deploy ứng dụng React lên production.</span>
                </div>
              
        </div>
      </article>

      <article class="rounded-2xl border border-slate-200 bg-white p-6">
        <h3 class="mb-4 text-xl font-bold">Yêu cầu</h3>
        <ul class="space-y-2 text-slate-700">
          <li>• Kiến thức cơ bản về HTML, CSS, JavaScript.</li><li>• Hiểu về ES6+ syntax.</li><li>• Có máy tính cài đặt Node.js.</li><li>• Đam mê học lập trình web.</li>
        </ul>
      </article>

      <article class="rounded-2xl border border-slate-200 bg-white p-6 text-slate-700">
        <h3 class="mb-4 text-xl font-bold">Mô tả khóa học</h3>
        <p class="mb-3">
          React là thư viện JavaScript phổ biến để xây dựng giao diện người dùng hiện đại.
          Khóa học này giúp bạn đi từ khái niệm nền tảng đến triển khai dự án thực tế.
        </p>
        <p class="mb-3">
          Bạn sẽ học cách tổ chức component, quản lý state, điều hướng trang và tối ưu hiệu năng.
        </p>
        <p>
          Sau khóa học, bạn có thể tự tin xây dựng ứng dụng React từ đầu và sẵn sàng cho dự án production.
        </p>
      </article>
    </div>
  
          </div>

          <aside>
            <article class="sticky top-20 rounded-2xl border border-slate-200 bg-white p-5">
              <h3 class="mb-4 text-lg font-bold">Khóa học bao gồm</h3>
              <div class="space-y-3 text-sm">
                <p><i class="fa-regular fa-clock mr-2 text-primary"></i>12 giờ video</p>
                <p><i class="fa-solid fa-book-open mr-2 text-secondary"></i>45 bài học</p>
                <p><i class="fa-solid fa-award mr-2 text-emerald-500"></i>Chứng chỉ hoàn thành</p>
                <p><i class="fa-solid fa-globe mr-2 text-warning"></i>Truy cập mọi lúc, mọi nơi</p>
              </div>
            </article>
          </aside>
        </div>
      </section>
    </div>

<?php include '../components/footer.php'; ?>
