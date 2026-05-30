<?php include '../components/header.php'; ?>
<div class="page-enter min-h-screen">
      <section class="bg-gradient-to-r from-primary to-secondary py-20 text-white">
        <div class="mx-auto max-w-3xl px-4 text-center lg:px-8">
          <h1 class="mb-5 text-4xl font-bold md:text-5xl">Lien he voi chung toi</h1>
          <p class="text-lg text-white/90">
            Chung toi luon san sang lang nghe va ho tro ban. Hay de lai thong tin va chung toi se phan hoi som nhat.
          </p>
        </div>
      </section>

      <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
          <div class="text-center">
            <p class="mb-6 text-lg text-slate-600">Chọn cách liên hệ phù hợp với bạn</p>
            <div class="flex flex-col items-center justify-center gap-8 sm:flex-row">
              <!-- Email -->
              <a href="mailto:contact@learncode.vn" class="group flex flex-col items-center gap-3 transition">
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 transition group-hover:bg-emerald-600 group-hover:text-white group-hover:shadow-lg">
                  <i class="fa-solid fa-envelope text-3xl"></i>
                </div>
                <span class="text-sm font-semibold text-slate-900">Gmail</span>
              </a>

              <!-- Zalo -->
              <a href="https://zalo.me/84123456789" target="_blank" rel="noreferrer" class="group flex flex-col items-center gap-3 transition">
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-blue-50 text-blue-600 transition group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-lg">
                  <i class="fa-solid fa-message text-3xl"></i>
                </div>
                <span class="text-sm font-semibold text-slate-900">Zalo</span>
              </a>

              <!-- Phone -->
              <a href="tel:+84123456789" class="group flex flex-col items-center gap-3 transition">
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-cyan-50 text-cyan-600 transition group-hover:bg-cyan-600 group-hover:text-white group-hover:shadow-lg">
                  <i class="fa-solid fa-phone text-3xl"></i>
                </div>
                <span class="text-sm font-semibold text-slate-900">Điện thoại</span>
              </a>
            </div>
          </div>
        </div>
      </section>
    </div>

<?php include '../components/footer.php'; ?>
