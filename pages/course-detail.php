<?php include '../components/header.php'; ?>
<div class="page-enter min-h-screen overflow-x-hidden pb-12">
      <section class="bg-gradient-to-r from-slate-900 to-slate-700 py-10 text-white bg-gradient-anim">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 lg:grid-cols-3 lg:px-8 scale-in">
          <div class="space-y-5 lg:col-span-2">
            <div class="flex flex-wrap items-center gap-2">
              <span class="rounded-full bg-primary px-3 py-1 text-xs font-semibold">Bestseller</span>
              <span class="rounded-full border border-white/30 px-3 py-1 text-xs">Trung cap</span>
            </div>
            <h1 class="text-4xl font-bold">React tu co ban den nang cao</h1>
            <p class="text-white/80">Hoc React voi du an thuc te, su dung hooks, context, router va cach deploy len production.</p>
            <div class="flex flex-wrap gap-4 text-sm text-white/80">
              <span><i class="fa-solid fa-star text-warning"></i> 4.8 (1,234 danh gia)</span>
              <span><i class="fa-solid fa-users"></i> 2,156 hoc vien</span>
              <span><i class="fa-regular fa-clock"></i> 12 gio</span>
              <span><i class="fa-solid fa-book-open"></i> 45 bai hoc</span>
            </div>
            <div class="flex items-center gap-3">
              <img class="h-12 w-12 rounded-full object-cover" src="https://i.pravatar.cc/150?img=5" alt="Nguyen Van A">
              <div>
                <p class="font-semibold">Nguyen Van A</p>
                <p class="text-sm text-white/70">Senior Frontend Developer</p>
              </div>
            </div>
          </div>

          <aside class="card-hover overflow-hidden rounded-2xl bg-white text-slate-900 shadow-soft">
            <div class="relative aspect-video">
              <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=1200&q=80" alt="React tu co ban den nang cao" class="h-full w-full object-cover card-img-zoom">
              <button class="absolute inset-0 flex items-center justify-center bg-black/40 text-white">
                <i class="fa-regular fa-circle-play text-6xl"></i>
              </button>
            </div>
            <div class="p-6">
              <div class="mb-5 flex items-center gap-2">
                <span class="text-3xl font-bold text-primary">1,200,000d</span>
                <span class="text-slate-400 line-through">2,000,000d</span>
                <span class="rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-600">-40%</span>
              </div>
              <div class="space-y-3">
                <button class="w-full rounded-xl bg-primary px-4 py-3 font-semibold text-white btn-premium">Mua khoa hoc</button>
                <button class="w-full rounded-xl border border-slate-200 px-4 py-3 font-semibold btn-premium text-slate-700 hover:bg-slate-100">Them vao gio hang</button>
              </div>
              <div class="mt-4 flex justify-center gap-6 text-sm text-slate-500">
                <button><i class="fa-regular fa-heart"></i> Yeu thich</button>
                <button><i class="fa-solid fa-share-nodes"></i> Chia se</button>
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
                <button data-action="set-course-detail-tab" data-value="overview" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white">Tong quan</button>
                <button data-action="set-course-detail-tab" data-value="curriculum" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">Noi dung khoa hoc</button>
                <button data-action="set-course-detail-tab" data-value="instructor" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">Giang vien</button>
                <button data-action="set-course-detail-tab" data-value="reviews" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">Danh gia</button>
              </div>
            </div>
            
    <div class="space-y-6 slide-from-left">
      <article class="card-hover rounded-2xl border border-slate-200 bg-white p-6">
        <h3 class="mb-4 text-xl font-bold">Ban se hoc duoc gi</h3>
        <div class="grid gap-3 md:grid-cols-2">
          
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Hieu ro React va cac khai niem cot loi.</span>
                </div>
              
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Xay dung ung dung web voi React Hooks.</span>
                </div>
              
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Quan ly state voi Context API.</span>
                </div>
              
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Routing voi React Router.</span>
                </div>
              
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Testing va Debugging React apps.</span>
                </div>
              
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Performance optimization techniques.</span>
                </div>
              
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Best practices va design patterns.</span>
                </div>
              
                <div class="flex items-start gap-2">
                  <i class="fa-solid fa-circle-check mt-1 text-emerald-500"></i>
                  <span>Deploy ung dung React len production.</span>
                </div>
              
        </div>
      </article>

      <article class="rounded-2xl border border-slate-200 bg-white p-6">
        <h3 class="mb-4 text-xl font-bold">Yeu cau</h3>
        <ul class="space-y-2 text-slate-700">
          <li>• Kien thuc co ban ve HTML, CSS, JavaScript.</li><li>• Hieu ve ES6+ syntax.</li><li>• Co may tinh cai dat Node.js.</li><li>• Dam me hoc lap trinh web.</li>
        </ul>
      </article>

      <article class="rounded-2xl border border-slate-200 bg-white p-6 text-slate-700">
        <h3 class="mb-4 text-xl font-bold">Mo ta khoa hoc</h3>
        <p class="mb-3">
          React la thu vien JavaScript pho bien de xay dung giao dien nguoi dung hien dai.
          Khoa hoc nay giup ban di tu khai niem nen tang den trien khai du an thuc te.
        </p>
        <p class="mb-3">
          Ban se hoc cach to chuc component, quan ly state, dieu huong trang va toi uu hieu nang.
        </p>
        <p>
          Sau khoa hoc, ban co the tu tin xay dung ung dung React tu dau va san sang cho du an production.
        </p>
      </article>
    </div>
  
          </div>

          <aside>
            <article class="sticky top-20 rounded-2xl border border-slate-200 bg-white p-5">
              <h3 class="mb-4 text-lg font-bold">Khoa hoc bao gom</h3>
              <div class="space-y-3 text-sm">
                <p><i class="fa-regular fa-clock mr-2 text-primary"></i>12 gio video</p>
                <p><i class="fa-solid fa-book-open mr-2 text-secondary"></i>45 bai hoc</p>
                <p><i class="fa-solid fa-award mr-2 text-emerald-500"></i>Chung chi hoan thanh</p>
                <p><i class="fa-solid fa-globe mr-2 text-warning"></i>Truy cap moi luc, moi noi</p>
              </div>
            </article>
          </aside>
        </div>
      </section>
    </div>

<?php include '../components/footer.php'; ?>
