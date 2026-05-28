<?php include '../components/header.php'; ?>
<div class="page-enter min-h-screen overflow-x-hidden">
      <section class="bg-gradient-to-r from-primary to-secondary py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
          <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <div>
              <h1 class="text-4xl font-bold">Dien dan</h1>
              <p class="text-white/90">Chia se kien thuc va kinh nghiem lap trinh</p>
            </div>
            <a href="create-post.php"  class="rounded-xl bg-white px-5 py-2.5 font-semibold text-primary hover:bg-white/90">
              <i class="fa-solid fa-plus mr-1"></i> Tao bai viet
            </a>
          </div>
          <div class="relative max-w-2xl">
            <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-white/60"></i>
            <input class="h-12 w-full rounded-xl border border-white/20 bg-white/10 pl-10 pr-3 text-white outline-none placeholder:text-white/60" placeholder="Tim kiem bai viet...">
          </div>
        </div>
      </section>

      <section class="py-8">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 lg:grid-cols-4 lg:px-8">
          <div class="lg:col-span-3 min-w-0">
            <div class="hide-scrollbar mb-6 overflow-x-auto">
              <div class="inline-flex gap-2 rounded-xl border border-slate-200 bg-white p-1">
                
                      <button data-action="set-forum-tab" data-value="all" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white">
                        Tat ca
                      </button>
                    
                      <button data-action="set-forum-tab" data-value="trending" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">
                        Xu huong
                      </button>
                    
                      <button data-action="set-forum-tab" data-value="recent" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">
                        Moi nhat
                      </button>
                    
                      <button data-action="set-forum-tab" data-value="saved" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">
                        Da luu
                      </button>
                    
              </div>
            </div>

            <div class="space-y-4">
    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-soft">
      <div class="mb-3 flex items-center gap-3">
        <img class="h-10 w-10 rounded-full" src="https://i.pravatar.cc/150?img=1" alt="Nguyen Van D">
        <div class="min-w-0 flex-1">
          <div class="flex flex-wrap items-center gap-2">
            <p class="font-medium">Nguyen Van D</p>
            <span class="text-slate-300">•</span>
            <p class="text-sm text-slate-500">2 ngay truoc</p>
          </div>
        </div>
        <span class="rounded-full border border-slate-200 px-3 py-1 text-xs">JavaScript</span>
      </div>
      <h3 class="line-clamp-2 mb-2 text-xl font-bold">10 tips de code JavaScript hieu qua hon</h3>
      <p class="line-clamp-2 mb-3 text-slate-500">Nhung meo nho giup ban viet code JavaScript sach hon va hieu qua hon.</p>
      <div class="mb-3 flex flex-wrap gap-2">
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs">JavaScript</span><span class="rounded-full bg-slate-100 px-3 py-1 text-xs">Tips</span><span class="rounded-full bg-slate-100 px-3 py-1 text-xs">Best Practices</span>
      </div>
      <div class="flex flex-wrap items-center gap-5 text-sm text-slate-500">
        <a href="forum-detail.php"  class="hover:text-danger"><i class="fa-regular fa-heart"></i> 245</a>
        <a href="forum-detail.php"  class="hover:text-primary"><i class="fa-regular fa-comment"></i> 32</a>
        <span><i class="fa-regular fa-eye"></i> 1250</span>
        <button class="ml-auto"><i class="fa-regular fa-bookmark"></i></button>
      </div>
    </article>
  
    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-soft">
      <div class="mb-3 flex items-center gap-3">
        <img class="h-10 w-10 rounded-full" src="https://i.pravatar.cc/150?img=2" alt="Tran Thi E">
        <div class="min-w-0 flex-1">
          <div class="flex flex-wrap items-center gap-2">
            <p class="font-medium">Tran Thi E</p>
            <span class="text-slate-300">•</span>
            <p class="text-sm text-slate-500">3 ngay truoc</p>
          </div>
        </div>
        <span class="rounded-full border border-slate-200 px-3 py-1 text-xs">AI</span>
      </div>
      <h3 class="line-clamp-2 mb-2 text-xl font-bold">Tuong lai cua AI trong lap trinh</h3>
      <p class="line-clamp-2 mb-3 text-slate-500">AI dang thay doi cach chung ta viet code va phat trien phan mem.</p>
      <div class="mb-3 flex flex-wrap gap-2">
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs">AI</span><span class="rounded-full bg-slate-100 px-3 py-1 text-xs">Future</span><span class="rounded-full bg-slate-100 px-3 py-1 text-xs">Programming</span>
      </div>
      <div class="flex flex-wrap items-center gap-5 text-sm text-slate-500">
        <a href="forum-detail.php"  class="hover:text-danger"><i class="fa-regular fa-heart"></i> 189</a>
        <a href="forum-detail.php"  class="hover:text-primary"><i class="fa-regular fa-comment"></i> 28</a>
        <span><i class="fa-regular fa-eye"></i> 980</span>
        <button class="ml-auto"><i class="fa-regular fa-bookmark"></i></button>
      </div>
    </article>
  
    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-soft">
      <div class="mb-3 flex items-center gap-3">
        <img class="h-10 w-10 rounded-full" src="https://i.pravatar.cc/150?img=3" alt="Le Van F">
        <div class="min-w-0 flex-1">
          <div class="flex flex-wrap items-center gap-2">
            <p class="font-medium">Le Van F</p>
            <span class="text-slate-300">•</span>
            <p class="text-sm text-slate-500">5 ngay truoc</p>
          </div>
        </div>
        <span class="rounded-full border border-slate-200 px-3 py-1 text-xs">React</span>
      </div>
      <h3 class="line-clamp-2 mb-2 text-xl font-bold">Best practices khi lam viec voi React Hooks</h3>
      <p class="line-clamp-2 mb-3 text-slate-500">Tong hop nhung pattern can biet khi su dung React Hooks.</p>
      <div class="mb-3 flex flex-wrap gap-2">
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs">React</span><span class="rounded-full bg-slate-100 px-3 py-1 text-xs">Hooks</span><span class="rounded-full bg-slate-100 px-3 py-1 text-xs">Best Practices</span>
      </div>
      <div class="flex flex-wrap items-center gap-5 text-sm text-slate-500">
        <a href="forum-detail.php"  class="hover:text-danger"><i class="fa-regular fa-heart"></i> 312</a>
        <a href="forum-detail.php"  class="hover:text-primary"><i class="fa-regular fa-comment"></i> 45</a>
        <span><i class="fa-regular fa-eye"></i> 1580</span>
        <button class="ml-auto"><i class="fa-regular fa-bookmark"></i></button>
      </div>
    </article>
  
    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-soft">
      <div class="mb-3 flex items-center gap-3">
        <img class="h-10 w-10 rounded-full" src="https://i.pravatar.cc/150?img=4" alt="Pham Van G">
        <div class="min-w-0 flex-1">
          <div class="flex flex-wrap items-center gap-2">
            <p class="font-medium">Pham Van G</p>
            <span class="text-slate-300">•</span>
            <p class="text-sm text-slate-500">1 tuan truoc</p>
          </div>
        </div>
        <span class="rounded-full border border-slate-200 px-3 py-1 text-xs">Performance</span>
      </div>
      <h3 class="line-clamp-2 mb-2 text-xl font-bold">Toi uu performance cho ung dung web</h3>
      <p class="line-clamp-2 mb-3 text-slate-500">Cac ky thuat cai thien toc do tai trang va do muot cua UI.</p>
      <div class="mb-3 flex flex-wrap gap-2">
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs">Performance</span><span class="rounded-full bg-slate-100 px-3 py-1 text-xs">Web</span><span class="rounded-full bg-slate-100 px-3 py-1 text-xs">Optimization</span>
      </div>
      <div class="flex flex-wrap items-center gap-5 text-sm text-slate-500">
        <a href="forum-detail.php"  class="hover:text-danger"><i class="fa-regular fa-heart"></i> 156</a>
        <a href="forum-detail.php"  class="hover:text-primary"><i class="fa-regular fa-comment"></i> 21</a>
        <span><i class="fa-regular fa-eye"></i> 890</span>
        <button class="ml-auto"><i class="fa-regular fa-bookmark"></i></button>
      </div>
    </article>
  </div>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-2">
              <button class="rounded-xl border border-slate-200 px-4 py-2 text-slate-400" disabled>Truoc</button>
              <button class="rounded-xl bg-primary px-4 py-2 font-medium text-white">1</button>
              <button class="rounded-xl border border-slate-200 px-4 py-2 hover:bg-slate-100">2</button>
              <button class="rounded-xl border border-slate-200 px-4 py-2 hover:bg-slate-100">3</button>
              <button class="rounded-xl border border-slate-200 px-4 py-2 hover:bg-slate-100">Sau</button>
            </div>
          </div>

          <aside class="space-y-6 lg:col-span-1">
            <article class="rounded-2xl border border-slate-200 bg-white p-4">
              <h3 class="mb-3 text-lg font-bold">Chu de pho bien</h3>
              <div class="space-y-2">
                
                      <button class="flex w-full items-center justify-between rounded-lg p-3 text-left hover:bg-slate-50">
                        <span>
                          <span class="block font-medium">AI va Machine Learning</span>
                          <span class="text-sm text-slate-500">145 bai viet</span>
                        </span>
                        <i class="fa-solid fa-arrow-trend-up text-primary"></i>
                      </button>
                    
                      <button class="flex w-full items-center justify-between rounded-lg p-3 text-left hover:bg-slate-50">
                        <span>
                          <span class="block font-medium">Web Development</span>
                          <span class="text-sm text-slate-500">230 bai viet</span>
                        </span>
                        <i class="fa-solid fa-arrow-trend-up text-primary"></i>
                      </button>
                    
                      <button class="flex w-full items-center justify-between rounded-lg p-3 text-left hover:bg-slate-50">
                        <span>
                          <span class="block font-medium">Mobile Development</span>
                          <span class="text-sm text-slate-500">98 bai viet</span>
                        </span>
                        <i class="fa-solid fa-arrow-trend-up text-primary"></i>
                      </button>
                    
                      <button class="flex w-full items-center justify-between rounded-lg p-3 text-left hover:bg-slate-50">
                        <span>
                          <span class="block font-medium">DevOps va Cloud</span>
                          <span class="text-sm text-slate-500">156 bai viet</span>
                        </span>
                        <i class="fa-solid fa-arrow-trend-up text-primary"></i>
                      </button>
                    
                      <button class="flex w-full items-center justify-between rounded-lg p-3 text-left hover:bg-slate-50">
                        <span>
                          <span class="block font-medium">Data Science</span>
                          <span class="text-sm text-slate-500">87 bai viet</span>
                        </span>
                        <i class="fa-solid fa-arrow-trend-up text-primary"></i>
                      </button>
                    
              </div>
            </article>

            <article class="rounded-2xl border border-slate-200 bg-white p-4">
              <h3 class="mb-3 text-lg font-bold">Tags pho bien</h3>
              <div class="flex flex-wrap gap-2">
                <button class="rounded-full border border-slate-200 px-3 py-1 text-xs hover:bg-primary hover:text-white">JavaScript</button><button class="rounded-full border border-slate-200 px-3 py-1 text-xs hover:bg-primary hover:text-white">React</button><button class="rounded-full border border-slate-200 px-3 py-1 text-xs hover:bg-primary hover:text-white">Python</button><button class="rounded-full border border-slate-200 px-3 py-1 text-xs hover:bg-primary hover:text-white">Node.js</button><button class="rounded-full border border-slate-200 px-3 py-1 text-xs hover:bg-primary hover:text-white">TypeScript</button><button class="rounded-full border border-slate-200 px-3 py-1 text-xs hover:bg-primary hover:text-white">Vue.js</button><button class="rounded-full border border-slate-200 px-3 py-1 text-xs hover:bg-primary hover:text-white">CSS</button><button class="rounded-full border border-slate-200 px-3 py-1 text-xs hover:bg-primary hover:text-white">HTML</button><button class="rounded-full border border-slate-200 px-3 py-1 text-xs hover:bg-primary hover:text-white">Git</button><button class="rounded-full border border-slate-200 px-3 py-1 text-xs hover:bg-primary hover:text-white">DevOps</button>
              </div>
            </article>
          </aside>
        </div>
      </section>
    </div>

<?php include '../components/footer.php'; ?>
