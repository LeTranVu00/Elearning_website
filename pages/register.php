<?php include '../components/header.php'; ?>
<section class="page-enter min-h-screen bg-gradient-to-br from-indigo-50 via-cyan-50 to-emerald-50 px-4 py-10">
      <div class="mx-auto w-full max-w-md">
        <div class="mb-8 text-center">
          <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-secondary text-2xl font-bold text-white">L</div>
          <h1 class="mb-2 text-3xl font-bold">Tao tai khoan</h1>
          <p class="text-slate-500">Bat dau hanh trinh hoc tap cua ban</p>
        </div>

        <div class="glass-card scale-in rounded-2xl border border-slate-200 bg-white/70 p-6 shadow-soft">
          <h2 class="text-xl font-bold">Dang ky</h2>
          <p class="mb-4 text-sm text-slate-500">Dien thong tin de tao tai khoan moi</p>

          <?php
          // Hiển thị lỗi nếu có
          $errors = SessionManager::getErrors();
          if (!empty($errors)) {
              echo '<div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">';
              foreach ($errors as $error) {
                  echo '<p>• ' . htmlspecialchars($error) . '</p>';
              }
              echo '</div>';
          }
          ?>

          <!-- FORM ĐĂNG KÝ -->
          <form class="space-y-4" method="POST" action="../controllers/RegisterController.php">
            <!-- INPUT HỌ VÀ TÊN -->
            <label class="block">
              <span class="mb-1 block text-sm font-medium">Ho va ten</span>
              <div class="relative">
                <i class="fa-regular fa-user pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="ho_ten" class="h-11 w-full rounded-xl border border-slate-200 pl-9 pr-3 outline-none focus:border-primary" placeholder="Nguyen Van A" required>
              </div>
            </label>

            <!-- INPUT EMAIL -->
            <label class="block">
              <span class="mb-1 block text-sm font-medium">Email</span>
              <div class="relative">
                <i class="fa-regular fa-envelope pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="email" name="email" class="h-11 w-full rounded-xl border border-slate-200 pl-9 pr-3 outline-none focus:border-primary" placeholder="name@example.com" required>
              </div>
            </label>

            <!-- INPUT SỐ ĐIỆN THOẠI -->
            <label class="block">
              <span class="mb-1 block text-sm font-medium">So dien thoai</span>
              <div class="relative">
                <i class="fa-solid fa-phone pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="tel" name="so_dien_thoai" class="h-11 w-full rounded-xl border border-slate-200 pl-9 pr-3 outline-none focus:border-primary" placeholder="0123 456 789">
              </div>
            </label>

            <!-- INPUT MẬT KHẨU -->
            <label class="block">
              <span class="mb-1 block text-sm font-medium">Mat khau</span>
              <div class="relative">
                <i class="fa-solid fa-lock pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input id="register-password" type="password" name="password" class="h-11 w-full rounded-xl border border-slate-200 pl-9 pr-10 outline-none focus:border-primary" placeholder="••••••••" required>
                <button data-action="toggle-password" data-target="register-password" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800">
                  <i class="fa-regular fa-eye"></i>
                </button>
              </div>
            </label>

            <!-- INPUT XÁC NHẬN MẬT KHẨU -->
            <label class="block">
              <span class="mb-1 block text-sm font-medium">Xac nhan mat khau</span>
              <div class="relative">
                <i class="fa-solid fa-lock pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input id="register-confirm-password" type="password" name="confirm_password" class="h-11 w-full rounded-xl border border-slate-200 pl-9 pr-10 outline-none focus:border-primary" placeholder="••••••••" required>
                <button data-action="toggle-password" data-target="register-confirm-password" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800">
                  <i class="fa-regular fa-eye"></i>
                </button>
              </div>
            </label>

            <!-- CHECKBOX ĐIỀU KHOẢN -->
            <label class="flex items-start gap-2 text-sm text-slate-500">
              <input type="checkbox" class="mt-1 h-4 w-4 accent-primary" required>
              <span>
                Toi dong y voi
                <a href="#" class="text-primary hover:underline">Dieu khoan dich vu</a>
                va
                <a href="#" class="text-primary hover:underline">Chinh sach bao mat</a>
              </span>
            </label>

            <!-- NÚT SUBMIT -->
            <button type="submit" class="w-full rounded-xl bg-primary px-4 py-3 font-semibold text-white btn-premium">
              Tao tai khoan
            </button>
          </form>

          <div class="relative my-4">
            <div class="h-px bg-slate-200"></div>
            <span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-2 text-xs text-slate-400">hoac</span>
          </div>

          <div class="grid grid-cols-2 gap-3">
            <button class="btn-premium glass-card rounded-xl border border-slate-200 px-3 py-2 font-medium text-slate-700 hover:bg-slate-50">Google</button>
            <button class="btn-premium glass-card rounded-xl border border-slate-200 px-3 py-2 font-medium text-slate-700 hover:bg-slate-50">Facebook</button>
          </div>
        </div>

        <p class="mt-6 text-center text-sm text-slate-500">
          Da co tai khoan?
          <a href="login.php"  class="font-semibold text-primary hover:underline">Dang nhap</a>
        </p>
      </div>
    </section>

<?php include '../components/footer.php'; ?>
