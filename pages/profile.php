<?php 
include '../components/header.php';

// ============================================================================
// Bảo vệ trang: Chỉ cho phép người dùng đã đăng nhập truy cập
// ============================================================================
SessionManager::requireLogin();
?>
<div class="page-enter min-h-screen py-8">
      <div class="mx-auto grid max-w-7xl gap-8 px-4 lg:grid-cols-4 lg:px-8">
        <aside class="space-y-6 lg:col-span-1">
          <article class="rounded-2xl border border-slate-200 bg-white p-5">
            <div class="mb-5 text-center">
              <img class="mx-auto mb-3 h-24 w-24 rounded-full object-cover" src="https://i.pravatar.cc/200?img=12" alt="Nguyen Van A">
              <h2 class="text-xl font-bold">Nguyen Van A</h2>
              <p class="text-sm text-slate-500">@nguyenvana</p>
              <span class="mt-2 inline-block rounded-full bg-primary px-3 py-1 text-xs font-semibold text-white">Thanh vien Premium</span>
            </div>
            <div class="space-y-2 border-t border-slate-100 pt-4 text-sm text-slate-600">
              <p><i class="fa-regular fa-envelope mr-2"></i>nguyenvana@email.com</p>
              <p><i class="fa-solid fa-phone mr-2"></i>0123 456 789</p>
              <p><i class="fa-regular fa-calendar mr-2"></i>Tham gia thang 1, 2024</p>
            </div>
            <button class="mt-5 w-full rounded-xl border border-slate-200 px-4 py-2.5 font-medium hover:bg-slate-100">
              <i class="fa-solid fa-gear mr-1"></i> Chinh sua ho so
            </button>
          </article>

          <article class="rounded-2xl border border-slate-200 bg-white p-5">
            <h3 class="mb-3 text-lg font-bold">Thong ke</h3>
            <div class="space-y-3 text-sm">
              <p class="flex items-center justify-between"><span class="text-slate-500">Khoa hoc da hoc</span><b>12</b></p>
              <p class="flex items-center justify-between"><span class="text-slate-500">Chung chi dat duoc</span><b>8</b></p>
              <p class="flex items-center justify-between"><span class="text-slate-500">Bai viet</span><b>24</b></p>
              <p class="flex items-center justify-between"><span class="text-slate-500">Diem tich luy</span><b>1,250</b></p>
            </div>
          </article>
        </aside>

        <section class="lg:col-span-3 min-w-0">
          <div class="hide-scrollbar mb-6 overflow-x-auto">
            <div class="inline-flex gap-2 rounded-xl border border-slate-200 bg-white p-1">
              
                    <button data-action="set-profile-tab" data-value="courses" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white">
                      Khoa hoc cua toi
                    </button>
                  
                    <button data-action="set-profile-tab" data-value="posts" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">
                      Bai viet cua toi
                    </button>
                  
                    <button data-action="set-profile-tab" data-value="achievements" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">
                      Thanh tich
                    </button>
                  
            </div>
          </div>
          
    <div class="grid gap-6 md:grid-cols-2">
      
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
                <a href="learning.php"  class="w-full rounded-xl bg-primary px-4 py-2.5 font-medium text-white hover:bg-indigo-700">Tiep tuc hoc</a>
              </div>
            </article>
          
    </div>
  
        </section>
      </div>
    </div>

<?php include '../components/footer.php'; ?>
