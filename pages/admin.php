<?php 
include '../components/header.php';

// ============================================================================
// Bảo vệ trang: Chỉ cho phép người dùng có quyền Admin truy cập
// ============================================================================
SessionManager::requireAdmin();
?>
<div class="page-enter min-h-screen py-8">
      <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <header class="mb-8">
          <h1 class="text-3xl font-bold">Admin Dashboard</h1>
          <p class="text-slate-500">Quan ly va theo doi hoat dong he thong</p>
        </header>

        
    <div class="mb-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
              <div class="mb-4 flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-indigo-50 text-primary">
                  <i class="fa-solid fa-users"></i>
                </div>
                <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">+12.5%</span>
              </div>
              <p class="text-2xl font-bold">15,234</p>
              <p class="text-sm text-slate-500">Tong nguoi dung</p>
            </article>
          
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
              <div class="mb-4 flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-indigo-50 text-primary">
                  <i class="fa-solid fa-book-open"></i>
                </div>
                <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">+8.2%</span>
              </div>
              <p class="text-2xl font-bold">234</p>
              <p class="text-sm text-slate-500">Tong khoa hoc</p>
            </article>
          
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
              <div class="mb-4 flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-indigo-50 text-primary">
                  <i class="fa-solid fa-comments"></i>
                </div>
                <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">+15.3%</span>
              </div>
              <p class="text-2xl font-bold">1,456</p>
              <p class="text-sm text-slate-500">Bai viet dien dan</p>
            </article>
          
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
              <div class="mb-4 flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-indigo-50 text-primary">
                  <i class="fa-solid fa-dollar-sign"></i>
                </div>
                <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">+23.1%</span>
              </div>
              <p class="text-2xl font-bold">2.5B VND</p>
              <p class="text-sm text-slate-500">Doanh thu</p>
            </article>
          
    </div>
  

        <div class="hide-scrollbar mb-6 overflow-x-auto">
          <div class="inline-flex gap-2 rounded-xl border border-slate-200 bg-white p-1">
            
                  <button data-action="set-admin-tab" data-value="users" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white">
                    Nguoi dung
                  </button>
                
                  <button data-action="set-admin-tab" data-value="courses" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">
                    Khoa hoc
                  </button>
                
                  <button data-action="set-admin-tab" data-value="forum" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">
                    Dien dan
                  </button>
                
                  <button data-action="set-admin-tab" data-value="reports" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100">
                    Bao cao
                  </button>
                
          </div>
        </div>

        
    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white">
      <div class="flex items-center justify-between border-b border-slate-200 p-4">
        <div>
          <h3 class="text-lg font-bold">Quan ly nguoi dung</h3>
          <p class="text-sm text-slate-500">Danh sach nguoi dung gan day</p>
        </div>
        <button class="rounded-xl bg-primary px-4 py-2 font-medium text-white hover:bg-indigo-700">
          <i class="fa-solid fa-plus mr-1"></i> Them nguoi dung
        </button>
      </div>
      <table class="w-full min-w-[780px] text-sm">
        <thead class="bg-slate-50 text-left text-slate-500">
          <tr>
            <th class="px-4 py-3">Nguoi dung</th>
            <th class="px-4 py-3">Email</th>
            <th class="px-4 py-3">Vai tro</th>
            <th class="px-4 py-3">Trang thai</th>
            <th class="px-4 py-3">Ngay tham gia</th>
            <th class="px-4 py-3">Hanh dong</th>
          </tr>
        </thead>
        <tbody>
          
                <tr class="border-t border-slate-100">
                  <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                      <img class="h-8 w-8 rounded-full" src="https://i.pravatar.cc/80?img=1" alt="Nguyen Van A">
                      <span class="font-medium">Nguyen Van A</span>
                    </div>
                  </td>
                  <td class="px-4 py-3">nguyenvana@email.com</td>
                  <td class="px-4 py-3"><span class="rounded-full border border-slate-200 px-2 py-1 text-xs">Hoc vien</span></td>
                  <td class="px-4 py-3">
                    <span class="rounded-full px-2 py-1 text-xs font-semibold bg-emerald-100 text-emerald-700">Hoat dong</span>
                  </td>
                  <td class="px-4 py-3">21/05/2026</td>
                  <td class="px-4 py-3">
                    <div class="flex items-center gap-2 text-slate-500">
                      <button class="hover:text-primary"><i class="fa-regular fa-eye"></i></button>
                      <button class="hover:text-primary"><i class="fa-regular fa-pen-to-square"></i></button>
                      <button class="hover:text-danger"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                  </td>
                </tr>
              
                <tr class="border-t border-slate-100">
                  <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                      <img class="h-8 w-8 rounded-full" src="https://i.pravatar.cc/80?img=2" alt="Tran Thi B">
                      <span class="font-medium">Tran Thi B</span>
                    </div>
                  </td>
                  <td class="px-4 py-3">tranthib@email.com</td>
                  <td class="px-4 py-3"><span class="rounded-full border border-slate-200 px-2 py-1 text-xs">Giang vien</span></td>
                  <td class="px-4 py-3">
                    <span class="rounded-full px-2 py-1 text-xs font-semibold bg-emerald-100 text-emerald-700">Hoat dong</span>
                  </td>
                  <td class="px-4 py-3">20/05/2026</td>
                  <td class="px-4 py-3">
                    <div class="flex items-center gap-2 text-slate-500">
                      <button class="hover:text-primary"><i class="fa-regular fa-eye"></i></button>
                      <button class="hover:text-primary"><i class="fa-regular fa-pen-to-square"></i></button>
                      <button class="hover:text-danger"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                  </td>
                </tr>
              
                <tr class="border-t border-slate-100">
                  <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                      <img class="h-8 w-8 rounded-full" src="https://i.pravatar.cc/80?img=3" alt="Le Van C">
                      <span class="font-medium">Le Van C</span>
                    </div>
                  </td>
                  <td class="px-4 py-3">levanc@email.com</td>
                  <td class="px-4 py-3"><span class="rounded-full border border-slate-200 px-2 py-1 text-xs">Hoc vien</span></td>
                  <td class="px-4 py-3">
                    <span class="rounded-full px-2 py-1 text-xs font-semibold bg-emerald-100 text-emerald-700">Hoat dong</span>
                  </td>
                  <td class="px-4 py-3">19/05/2026</td>
                  <td class="px-4 py-3">
                    <div class="flex items-center gap-2 text-slate-500">
                      <button class="hover:text-primary"><i class="fa-regular fa-eye"></i></button>
                      <button class="hover:text-primary"><i class="fa-regular fa-pen-to-square"></i></button>
                      <button class="hover:text-danger"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                  </td>
                </tr>
              
                <tr class="border-t border-slate-100">
                  <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                      <img class="h-8 w-8 rounded-full" src="https://i.pravatar.cc/80?img=4" alt="Pham Thi D">
                      <span class="font-medium">Pham Thi D</span>
                    </div>
                  </td>
                  <td class="px-4 py-3">phamthid@email.com</td>
                  <td class="px-4 py-3"><span class="rounded-full border border-slate-200 px-2 py-1 text-xs">Hoc vien</span></td>
                  <td class="px-4 py-3">
                    <span class="rounded-full px-2 py-1 text-xs font-semibold bg-red-100 text-red-700">Tam khoa</span>
                  </td>
                  <td class="px-4 py-3">18/05/2026</td>
                  <td class="px-4 py-3">
                    <div class="flex items-center gap-2 text-slate-500">
                      <button class="hover:text-primary"><i class="fa-regular fa-eye"></i></button>
                      <button class="hover:text-primary"><i class="fa-regular fa-pen-to-square"></i></button>
                      <button class="hover:text-danger"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                  </td>
                </tr>
              
        </tbody>
      </table>
    </div>
  
      </div>
    </div>

<?php include '../components/footer.php'; ?>
