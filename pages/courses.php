<?php include '../components/header.php'; ?>
<div class="page-enter min-h-screen overflow-x-hidden">
      <section class="bg-gradient-to-r from-primary to-secondary py-12 text-white bg-gradient-anim">
        <div class="mx-auto max-w-7xl px-4 lg:px-8 scale-in">
          <h1 class="mb-3 text-4xl font-bold text-glow">Khoa hoc</h1>
          <p class="mb-6 text-lg text-white/90">Kham pha hon 200+ khoa hoc lap trinh chat luong cao</p>
          <div class="flex max-w-3xl gap-3">
            <div class="relative flex-1">
              <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-white/60"></i>
              <input class="h-12 w-full rounded-xl border border-white/20 bg-white/10 pl-10 pr-3 text-white outline-none placeholder:text-white/60" placeholder="Tim kiem khoa hoc...">
            </div>
            <button class="rounded-xl bg-white px-5 text-primary hover:bg-white/90">
              <i class="fa-solid fa-filter mr-1"></i> Loc
            </button>
          </div>
        </div>
      </section>

      <section class="py-8">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 lg:grid-cols-4 lg:px-8">
          <aside class="space-y-6 lg:col-span-1">
            <div class="rounded-2xl border border-slate-200 bg-white p-4">
              <h3 class="mb-3 text-lg font-bold">Danh muc</h3>
              <div class="space-y-2">
                
                      <button data-action="course-filter-category" data-value="all" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left transition bg-primary text-white">
                        <span>Tat ca</span>
                        <span class="text-sm">200</span>
                      </button>
                    
                      <button data-action="course-filter-category" data-value="javascript" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left transition hover:bg-slate-100 text-slate-700">
                        <span>JavaScript</span>
                        <span class="text-sm">45</span>
                      </button>
                    
                      <button data-action="course-filter-category" data-value="python" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left transition hover:bg-slate-100 text-slate-700">
                        <span>Python</span>
                        <span class="text-sm">38</span>
                      </button>
                    
                      <button data-action="course-filter-category" data-value="react" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left transition hover:bg-slate-100 text-slate-700">
                        <span>React</span>
                        <span class="text-sm">32</span>
                      </button>
                    
                      <button data-action="course-filter-category" data-value="nodejs" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left transition hover:bg-slate-100 text-slate-700">
                        <span>Node.js</span>
                        <span class="text-sm">28</span>
                      </button>
                    
                      <button data-action="course-filter-category" data-value="typescript" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left transition hover:bg-slate-100 text-slate-700">
                        <span>TypeScript</span>
                        <span class="text-sm">25</span>
                      </button>
                    
              </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4">
              <h3 class="mb-3 text-lg font-bold">Cap do</h3>
              <div class="space-y-2">
                
                      <button data-action="course-filter-level" data-value="all" class="w-full rounded-lg px-3 py-2 text-left transition bg-primary text-white">
                        Tat ca cap do
                      </button>
                    
                      <button data-action="course-filter-level" data-value="beginner" class="w-full rounded-lg px-3 py-2 text-left transition hover:bg-slate-100 text-slate-700">
                        Co ban
                      </button>
                    
                      <button data-action="course-filter-level" data-value="intermediate" class="w-full rounded-lg px-3 py-2 text-left transition hover:bg-slate-100 text-slate-700">
                        Trung cap
                      </button>
                    
                      <button data-action="course-filter-level" data-value="advanced" class="w-full rounded-lg px-3 py-2 text-left transition hover:bg-slate-100 text-slate-700">
                        Nang cao
                      </button>
                    
              </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4">
              <h3 class="mb-3 text-lg font-bold">Gia</h3>
              <div class="space-y-2 text-slate-700">
                <button class="w-full rounded-lg px-3 py-2 text-left hover:bg-slate-100">Mien phi</button>
                <button class="w-full rounded-lg px-3 py-2 text-left hover:bg-slate-100">Duoi 1 trieu</button>
                <button class="w-full rounded-lg px-3 py-2 text-left hover:bg-slate-100">1-2 trieu</button>
                <button class="w-full rounded-lg px-3 py-2 text-left hover:bg-slate-100">Tren 2 trieu</button>
              </div>
            </div>
          </aside>

          <div class="lg:col-span-3 min-w-0">
            <div class="mb-6 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
              <div class="hide-scrollbar w-full overflow-x-auto sm:w-auto">
                <div class="inline-flex gap-2 rounded-xl border border-slate-200 bg-white p-1">
                  
                        <button data-action="set-courses-tab" data-value="all" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white">
                          Tat ca
                        </button>
                      
                        <button data-action="set-courses-tab" data-value="popular" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">
                          Pho bien
                        </button>
                      
                        <button data-action="set-courses-tab" data-value="newest" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">
                          Moi nhat
                        </button>
                      
                        <button data-action="set-courses-tab" data-value="trending" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">
                          Xu huong
                        </button>
                      
                </div>
              </div>
              <p class="text-sm text-slate-500">Hien thi 6 khoa hoc</p>
            </div>

            
                  <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    
    <article class="card-hover overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
      <div class="relative aspect-video overflow-hidden">
        <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=1200&q=80" alt="React tu co ban den nang cao" class="h-full w-full object-cover card-img-zoom">
        <span class="absolute left-3 top-3 rounded-full bg-warning px-3 py-1 text-xs font-semibold text-white"><i class="fa-solid fa-award mr-1"></i>Noi bat</span>
        <button class="absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-full bg-white/90">
          <i class="fa-regular fa-heart"></i>
        </button>
        <span class="absolute bottom-3 left-3 rounded-full bg-black/70 px-3 py-1 text-xs font-medium text-white">Trung cap</span>
      </div>
      <div class="space-y-4 p-5">
        <h3 class="line-clamp-2 text-lg font-bold">React tu co ban den nang cao</h3>
        <p class="line-clamp-2 text-sm text-slate-500">Hoc React tu dau voi du an thuc te va best practices.</p>
        <div class="flex items-center gap-2 text-sm text-slate-500">
          <img class="h-8 w-8 rounded-full" src="https://i.pravatar.cc/80?img=1" alt="">
          <span>Nguyen Van A</span>
        </div>
        <div class="flex flex-wrap gap-4 text-sm text-slate-500">
          <span><i class="fa-solid fa-star text-warning"></i> <b class="text-slate-800">4.8</b></span>
          <span><i class="fa-solid fa-users"></i> 1,234</span>
          <span><i class="fa-regular fa-clock"></i> 12 gio</span>
        </div>
        <div>
          <span class="text-2xl font-bold text-primary">1,200,000d</span>
          <span class="ml-2 text-sm text-slate-400 line-through">2,000,000d</span>
        </div>
        <a href="course-detail.php"  data-course-id="1" class="w-full rounded-xl bg-primary px-4 py-2.5 font-medium text-white btn-premium">
          Xem chi tiet
        </a>
      </div>
    </article>
  
    <article class="card-hover overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
      <div class="relative aspect-video overflow-hidden">
        <img src="https://images.unsplash.com/photo-1579468118864-1b9ea3c0db4a?w=1200&q=80" alt="JavaScript ES6+ hien dai" class="h-full w-full object-cover card-img-zoom">
        <span class="absolute left-3 top-3 rounded-full bg-warning px-3 py-1 text-xs font-semibold text-white"><i class="fa-solid fa-award mr-1"></i>Noi bat</span>
        <button class="absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-full bg-white/90">
          <i class="fa-regular fa-heart"></i>
        </button>
        <span class="absolute bottom-3 left-3 rounded-full bg-black/70 px-3 py-1 text-xs font-medium text-white">Co ban</span>
      </div>
      <div class="space-y-4 p-5">
        <h3 class="line-clamp-2 text-lg font-bold">JavaScript ES6+ hien dai</h3>
        <p class="line-clamp-2 text-sm text-slate-500">Lam chu JavaScript hien dai voi ES6+ va nhieu ky thuat moi.</p>
        <div class="flex items-center gap-2 text-sm text-slate-500">
          <img class="h-8 w-8 rounded-full" src="https://i.pravatar.cc/80?img=2" alt="">
          <span>Tran Thi B</span>
        </div>
        <div class="flex flex-wrap gap-4 text-sm text-slate-500">
          <span><i class="fa-solid fa-star text-warning"></i> <b class="text-slate-800">4.9</b></span>
          <span><i class="fa-solid fa-users"></i> 2,156</span>
          <span><i class="fa-regular fa-clock"></i> 10 gio</span>
        </div>
        <div>
          <span class="text-2xl font-bold text-primary">900,000d</span>
          <span class="ml-2 text-sm text-slate-400 line-through">1,500,000d</span>
        </div>
        <a href="course-detail.php"  data-course-id="2" class="w-full rounded-xl bg-primary px-4 py-2.5 font-medium text-white btn-premium">
          Xem chi tiet
        </a>
      </div>
    </article>
  
    <article class="card-hover overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
      <div class="relative aspect-video overflow-hidden">
        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=1200&q=80" alt="Full-stack Web Development" class="h-full w-full object-cover card-img-zoom">
        
        <button class="absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-full bg-white/90">
          <i class="fa-regular fa-heart"></i>
        </button>
        <span class="absolute bottom-3 left-3 rounded-full bg-black/70 px-3 py-1 text-xs font-medium text-white">Nang cao</span>
      </div>
      <div class="space-y-4 p-5">
        <h3 class="line-clamp-2 text-lg font-bold">Full-stack Web Development</h3>
        <p class="line-clamp-2 text-sm text-slate-500">Tro thanh full-stack developer voi MERN stack.</p>
        <div class="flex items-center gap-2 text-sm text-slate-500">
          <img class="h-8 w-8 rounded-full" src="https://i.pravatar.cc/80?img=3" alt="">
          <span>Le Van C</span>
        </div>
        <div class="flex flex-wrap gap-4 text-sm text-slate-500">
          <span><i class="fa-solid fa-star text-warning"></i> <b class="text-slate-800">4.7</b></span>
          <span><i class="fa-solid fa-users"></i> 856</span>
          <span><i class="fa-regular fa-clock"></i> 40 gio</span>
        </div>
        <div>
          <span class="text-2xl font-bold text-primary">2,500,000d</span>
          <span class="ml-2 text-sm text-slate-400 line-through">4,000,000d</span>
        </div>
        <a href="course-detail.php"  data-course-id="3" class="w-full rounded-xl bg-primary px-4 py-2.5 font-medium text-white btn-premium">
          Xem chi tiet
        </a>
      </div>
    </article>
  
    <article class="card-hover overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
      <div class="relative aspect-video overflow-hidden">
        <img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=1200&q=80" alt="Python cho Data Science" class="h-full w-full object-cover card-img-zoom">
        
        <button class="absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-full bg-white/90">
          <i class="fa-regular fa-heart"></i>
        </button>
        <span class="absolute bottom-3 left-3 rounded-full bg-black/70 px-3 py-1 text-xs font-medium text-white">Trung cap</span>
      </div>
      <div class="space-y-4 p-5">
        <h3 class="line-clamp-2 text-lg font-bold">Python cho Data Science</h3>
        <p class="line-clamp-2 text-sm text-slate-500">Phan tich du lieu va Machine Learning voi Python.</p>
        <div class="flex items-center gap-2 text-sm text-slate-500">
          <img class="h-8 w-8 rounded-full" src="https://i.pravatar.cc/80?img=4" alt="">
          <span>Pham Thi D</span>
        </div>
        <div class="flex flex-wrap gap-4 text-sm text-slate-500">
          <span><i class="fa-solid fa-star text-warning"></i> <b class="text-slate-800">4.6</b></span>
          <span><i class="fa-solid fa-users"></i> 945</span>
          <span><i class="fa-regular fa-clock"></i> 20 gio</span>
        </div>
        <div>
          <span class="text-2xl font-bold text-primary">1,800,000d</span>
          <span class="ml-2 text-sm text-slate-400 line-through">3,000,000d</span>
        </div>
        <a href="course-detail.php"  data-course-id="4" class="w-full rounded-xl bg-primary px-4 py-2.5 font-medium text-white btn-premium">
          Xem chi tiet
        </a>
      </div>
    </article>
  
    <article class="card-hover overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
      <div class="relative aspect-video overflow-hidden">
        <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1200&q=80" alt="Node.js Backend Development" class="h-full w-full object-cover card-img-zoom">
        
        <button class="absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-full bg-white/90">
          <i class="fa-regular fa-heart"></i>
        </button>
        <span class="absolute bottom-3 left-3 rounded-full bg-black/70 px-3 py-1 text-xs font-medium text-white">Trung cap</span>
      </div>
      <div class="space-y-4 p-5">
        <h3 class="line-clamp-2 text-lg font-bold">Node.js Backend Development</h3>
        <p class="line-clamp-2 text-sm text-slate-500">Xay dung REST API va backend scalable voi Node.js.</p>
        <div class="flex items-center gap-2 text-sm text-slate-500">
          <img class="h-8 w-8 rounded-full" src="https://i.pravatar.cc/80?img=5" alt="">
          <span>Hoang Van E</span>
        </div>
        <div class="flex flex-wrap gap-4 text-sm text-slate-500">
          <span><i class="fa-solid fa-star text-warning"></i> <b class="text-slate-800">4.7</b></span>
          <span><i class="fa-solid fa-users"></i> 1,089</span>
          <span><i class="fa-regular fa-clock"></i> 16 gio</span>
        </div>
        <div>
          <span class="text-2xl font-bold text-primary">1,500,000d</span>
          <span class="ml-2 text-sm text-slate-400 line-through">2,500,000d</span>
        </div>
        <a href="course-detail.php"  data-course-id="5" class="w-full rounded-xl bg-primary px-4 py-2.5 font-medium text-white btn-premium">
          Xem chi tiet
        </a>
      </div>
    </article>
  
    <article class="card-hover overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
      <div class="relative aspect-video overflow-hidden">
        <img src="https://images.unsplash.com/photo-1516116216624-53e697fedbea?w=1200&q=80" alt="TypeScript Complete Guide" class="h-full w-full object-cover card-img-zoom">
        
        <button class="absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-full bg-white/90">
          <i class="fa-regular fa-heart"></i>
        </button>
        <span class="absolute bottom-3 left-3 rounded-full bg-black/70 px-3 py-1 text-xs font-medium text-white">Trung cap</span>
      </div>
      <div class="space-y-4 p-5">
        <h3 class="line-clamp-2 text-lg font-bold">TypeScript Complete Guide</h3>
        <p class="line-clamp-2 text-sm text-slate-500">Tu JavaScript sang TypeScript voi best practices.</p>
        <div class="flex items-center gap-2 text-sm text-slate-500">
          <img class="h-8 w-8 rounded-full" src="https://i.pravatar.cc/80?img=6" alt="">
          <span>Ngo Thi F</span>
        </div>
        <div class="flex flex-wrap gap-4 text-sm text-slate-500">
          <span><i class="fa-solid fa-star text-warning"></i> <b class="text-slate-800">4.8</b></span>
          <span><i class="fa-solid fa-users"></i> 723</span>
          <span><i class="fa-regular fa-clock"></i> 14 gio</span>
        </div>
        <div>
          <span class="text-2xl font-bold text-primary">1,100,000d</span>
          <span class="ml-2 text-sm text-slate-400 line-through">1,800,000d</span>
        </div>
        <a href="course-detail.php"  data-course-id="6" class="w-full rounded-xl bg-primary px-4 py-2.5 font-medium text-white btn-premium">
          Xem chi tiet
        </a>
      </div>
    </article>
  
                  </div>
                

            <div class="mt-8 flex flex-wrap items-center justify-center gap-2">
              <button class="rounded-xl border border-slate-200 px-4 py-2 text-slate-400" disabled>Truoc</button>
              <button class="rounded-xl bg-primary px-4 py-2 font-medium text-white">1</button>
              <button class="rounded-xl border border-slate-200 px-4 py-2 hover:bg-slate-100">2</button>
              <button class="rounded-xl border border-slate-200 px-4 py-2 hover:bg-slate-100">3</button>
              <button class="rounded-xl border border-slate-200 px-4 py-2 hover:bg-slate-100">4</button>
              <button class="rounded-xl border border-slate-200 px-4 py-2 hover:bg-slate-100">Sau</button>
            </div>
          </div>
        </div>
      </section>
    </div>

<?php include '../components/footer.php'; ?>
