<?php include '../components/header.php'; ?>
<section class="page-enter min-h-screen bg-gradient-to-br from-indigo-50 via-cyan-50 to-emerald-50 px-4 py-10">
      <div class="mx-auto w-full max-w-md">
        <div class="mb-8 text-center">
          <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-secondary text-2xl font-bold text-white">L</div>
          <h1 class="mb-2 text-3xl font-bold">Chao mung tro lai</h1>
          <p class="text-slate-500">Dang nhap de tiep tuc hoc tap</p>
        </div>

        <div class="glass-card scale-in rounded-2xl border border-slate-200 bg-white/70 p-6 shadow-soft">
          <h2 class="text-xl font-bold">Dang nhap</h2>
          <p class="mb-4 text-sm text-slate-500">Nhap thong tin tai khoan cua ban</p>

          <?php
          // ============================================================================
          // HIỂN THỊ DANH SÁCH LỖI NẾU CÓ
          // ============================================================================
          // Lấy các lỗi từ SessionManager (sử dụng getErrors thay vì $_SESSION)
          $errors = SessionManager::getErrors();
          if (!empty($errors)) {
              // Nếu có lỗi, hiển thị dưới dạng div đỏ
              echo '<div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">';
              foreach ($errors as $error) {
                  // htmlspecialchars() để tránh XSS attack
                  echo '<p>• ' . htmlspecialchars($error) . '</p>';
              }
              echo '</div>';
          }
          ?>

          <!-- FORM ĐĂNG NHẬP -->
          <!-- method="POST": Gửi dữ liệu qua POST (an toàn hơn GET) -->
          <!-- action="../controllers/AuthController.php": Gửi tới file xử lý -->
          <form class="space-y-4" method="POST" action="../controllers/AuthController.php">
            
            <!-- INPUT EMAIL -->
            <label class="block">
              <span class="mb-1 block text-sm font-medium">Email</span>
              <div class="relative">
                <i class="fa-regular fa-envelope pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <!-- name="email": Tên input để xử lý PHP -->
                <!-- type="email": Kiểm tra format email tự động -->
                <!-- required: Không được bỏ trống -->
                <input type="email" name="email" class="h-11 w-full rounded-xl border border-slate-200 pl-9 pr-3 outline-none focus:border-primary" placeholder="name@example.com" required>
              </div>
            </label>

            <!-- INPUT MẬT KHẨU -->
            <label class="block">
              <div class="mb-1 flex items-center justify-between">
                <span class="text-sm font-medium">Mat khau</span>
                <!-- Liên kết tới trang quên mật khẩu (chưa làm) -->
                <a href="forgot-password.php" type="button"  class="text-sm text-primary hover:underline">Quen mat khau?</a>
              </div>
              <div class="relative">
                <i class="fa-solid fa-lock pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <!-- type="password": Ẩn ký tự khi nhập -->
                <!-- id="login-password": Để toggle show/hide password -->
                <!-- name="password": Tên input để xử lý PHP -->
                <input id="login-password" type="password" name="password" class="h-11 w-full rounded-xl border border-slate-200 pl-9 pr-10 outline-none focus:border-primary" placeholder="••••••••" required>
                <!-- Nút show/hide password -->
                <button data-action="toggle-password" data-target="login-password" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800">
                  <i class="fa-regular fa-eye"></i>
                </button>
              </div>
            </label>

            <!-- CHECKBOX GHI NHỚ ĐĂNG NHẬP -->
            <!-- name="remember": Có thể sử dụng để set cookie remember-me -->
            <label class="flex items-center gap-2 text-sm text-slate-500">
              <input type="checkbox" name="remember" class="h-4 w-4 accent-primary">
              Ghi nho dang nhap
            </label>

            <!-- NÚT SUBMIT -->
            <button type="submit" class="w-full rounded-xl bg-primary px-4 py-3 font-semibold text-white btn-premium">
              Dang nhap
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
          Chua co tai khoan?
          <a href="register.php"  class="font-semibold text-primary hover:underline">Dang ky ngay</a>
        </p>
      </div>
    </section>

<?php include '../components/footer.php'; ?>
