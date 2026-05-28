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

      <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
          <div class="mb-16 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            
                  <article class="rounded-2xl border border-slate-200 bg-white p-5 text-center shadow-sm">
                    <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                      <i class="fa-solid fa-map-marker-alt text-xl"></i>
                    </div>
                    <h3 class="mb-2 font-bold">Dia chi van phong</h3>
                    <p class="text-sm text-slate-500">123 Duong Nguyen Hue, Quan 1, TP. Ho Chi Minh</p>
                  </article>
                
                  <article class="rounded-2xl border border-slate-200 bg-white p-5 text-center shadow-sm">
                    <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-cyan-50 text-cyan-600">
                      <i class="fa-solid fa-phone text-xl"></i>
                    </div>
                    <h3 class="mb-2 font-bold">So dien thoai</h3>
                    <a href="tel:+84123456789" class="text-sm text-slate-500 hover:text-primary">+84 123 456 789</a>
                  </article>
                
                  <article class="rounded-2xl border border-slate-200 bg-white p-5 text-center shadow-sm">
                    <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                      <i class="fa-solid fa-envelope text-xl"></i>
                    </div>
                    <h3 class="mb-2 font-bold">Email</h3>
                    <a href="mailto:contact@learncode.vn" class="text-sm text-slate-500 hover:text-primary">contact@learncode.vn</a>
                  </article>
                
                  <article class="rounded-2xl border border-slate-200 bg-white p-5 text-center shadow-sm">
                    <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-amber-50 text-amber-600">
                      <i class="fa-solid fa-clock text-xl"></i>
                    </div>
                    <h3 class="mb-2 font-bold">Gio lam viec</h3>
                    <p class="text-sm text-slate-500">Thu 2 - Thu 6: 9:00 - 18:00</p>
                  </article>
                
          </div>

          <div class="grid gap-8 lg:grid-cols-2">
            <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
              <h2 class="text-2xl font-bold">Gui tin nhan cho chung toi</h2>
              <p class="mb-4 text-sm text-slate-500">Dien thong tin ben duoi va chung toi se lien he lai voi ban som nhat.</p>

              <form data-form="contact" class="space-y-4">
                <div class="grid gap-4 md:grid-cols-2">
                  <label class="block">
                    <span class="mb-1 block text-sm font-medium">Ho</span>
                    <input class="h-11 w-full rounded-xl border border-slate-200 px-3 outline-none focus:border-primary" placeholder="Nguyen">
                  </label>
                  <label class="block">
                    <span class="mb-1 block text-sm font-medium">Ten</span>
                    <input class="h-11 w-full rounded-xl border border-slate-200 px-3 outline-none focus:border-primary" placeholder="Van A">
                  </label>
                </div>
                <label class="block">
                  <span class="mb-1 block text-sm font-medium">Email</span>
                  <input type="email" class="h-11 w-full rounded-xl border border-slate-200 px-3 outline-none focus:border-primary" placeholder="your.email@example.com">
                </label>
                <label class="block">
                  <span class="mb-1 block text-sm font-medium">So dien thoai</span>
                  <input type="tel" class="h-11 w-full rounded-xl border border-slate-200 px-3 outline-none focus:border-primary" placeholder="0123 456 789">
                </label>
                <label class="block">
                  <span class="mb-1 block text-sm font-medium">Tieu de</span>
                  <input class="h-11 w-full rounded-xl border border-slate-200 px-3 outline-none focus:border-primary" placeholder="Van de ban can ho tro">
                </label>
                <label class="block">
                  <span class="mb-1 block text-sm font-medium">Noi dung</span>
                  <textarea rows="6" class="w-full rounded-xl border border-slate-200 px-3 py-2 outline-none focus:border-primary" placeholder="Mo ta chi tiet van de hoac cau hoi cua ban..."></textarea>
                </label>
                <button type="submit" class="w-full rounded-xl bg-primary px-4 py-3 font-semibold text-white hover:bg-indigo-700">
                  <i class="fa-regular fa-paper-plane mr-1"></i> Gui tin nhan
                </button>
              </form>
            </article>

            <div class="space-y-6">
              <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-2xl font-bold">Cac cach lien he khac</h2>
                <p class="mb-4 text-sm text-slate-500">Chon phuong thuc phu hop voi ban</p>
                <div class="space-y-3">
                  
                        <button class="flex w-full items-start gap-4 rounded-xl border border-slate-200 p-4 text-left hover:bg-slate-50">
                          <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                            <i class="fa-solid fa-circle-question"></i>
                          </span>
                          <span>
                            <span class="block font-semibold">Cau hoi thuong gap</span>
                            <span class="text-sm text-slate-500">Tim cau tra loi cho cac van de pho bien.</span>
                          </span>
                        </button>
                      
                        <button class="flex w-full items-start gap-4 rounded-xl border border-slate-200 p-4 text-left hover:bg-slate-50">
                          <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-cyan-50 text-cyan-600">
                            <i class="fa-solid fa-comments"></i>
                          </span>
                          <span>
                            <span class="block font-semibold">Ho tro ky thuat</span>
                            <span class="text-sm text-slate-500">Can tro giup ve tai khoan va ky thuat.</span>
                          </span>
                        </button>
                      
                        <button class="flex w-full items-start gap-4 rounded-xl border border-slate-200 p-4 text-left hover:bg-slate-50">
                          <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                            <i class="fa-solid fa-phone"></i>
                          </span>
                          <span>
                            <span class="block font-semibold">Lien he truc tiep</span>
                            <span class="text-sm text-slate-500">Goi dien hoac chat voi doi ngu ho tro.</span>
                          </span>
                        </button>
                      
                </div>
              </article>

              <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-2 text-xl font-bold">Ket noi voi chung toi</h3>
                <p class="mb-4 text-sm text-slate-500">Theo doi tren mang xa hoi</p>
                <div class="flex flex-wrap gap-3">
                  
                        <a href="https://facebook.com/learncode" target="_blank" rel="noreferrer" class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition hover:bg-primary hover:text-white" aria-label="Facebook">
                          <i class="fa-brands fa-facebook-f"></i>
                        </a>
                      
                        <a href="https://twitter.com/learncode" target="_blank" rel="noreferrer" class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition hover:bg-primary hover:text-white" aria-label="Twitter">
                          <i class="fa-brands fa-x-twitter"></i>
                        </a>
                      
                        <a href="https://instagram.com/learncode" target="_blank" rel="noreferrer" class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition hover:bg-primary hover:text-white" aria-label="Instagram">
                          <i class="fa-brands fa-instagram"></i>
                        </a>
                      
                        <a href="https://youtube.com/learncode" target="_blank" rel="noreferrer" class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition hover:bg-primary hover:text-white" aria-label="YouTube">
                          <i class="fa-brands fa-youtube"></i>
                        </a>
                      
                </div>
              </article>

              <article class="rounded-2xl bg-gradient-to-br from-primary to-secondary p-6 text-white shadow-soft">
                <h3 class="mb-2 text-xl font-bold">Can ho tro ngay?</h3>
                <p class="mb-4 text-white/90">Lien he hotline de duoc tu van truc tiep</p>
                <p class="mb-2 text-lg font-bold"><i class="fa-solid fa-phone mr-1"></i> +84 123 456 789</p>
                <p class="text-sm text-white/80">Thu 2 - Thu 6: 9:00 - 18:00<br>Thu 7: 9:00 - 12:00</p>
              </article>
            </div>
          </div>
        </div>
      </section>

      <section class="bg-slate-50/70 py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
          <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold">Dia chi van phong</h2>
            <p class="text-slate-500">Ghe tham chung toi tai van phong</p>
          </div>
          <div class="flex aspect-video items-center justify-center rounded-2xl border border-slate-200 bg-white text-center shadow-sm">
            <div>
              <i class="fa-solid fa-location-dot mb-3 text-4xl text-primary"></i>
              <p class="text-lg font-semibold">123 Duong Nguyen Hue</p>
              <p class="text-slate-500">Quan 1, TP. Ho Chi Minh</p>
            </div>
          </div>
        </div>
      </section>
    </div>

<?php include '../components/footer.php'; ?>
