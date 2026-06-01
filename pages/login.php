<?php include '../components/header.php'; ?>

<section class="page-enter min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50 px-4 py-10">
  <div class="mx-auto flex min-h-[calc(100vh-10rem)] w-full max-w-5xl items-center justify-center">
    <div class="grid w-full overflow-hidden rounded-3xl border border-white/70 bg-white/75 shadow-soft backdrop-blur-xl lg:grid-cols-[1fr_0.9fr]">
      <div class="hidden bg-gradient-to-br from-primary to-secondary p-10 text-white lg:flex lg:flex-col lg:justify-between">
        <div>
          <div class="mb-8 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-2xl font-bold">L</div>
          <h1 class="mb-4 text-4xl font-bold leading-tight">Tiếp tục hành trình học tập của bạn</h1>
          <p class="text-base leading-7 text-white/85">Đăng nhập bằng Google giúp tài khoản an toàn hơn và không cần ghi nhớ thêm mật khẩu.</p>
        </div>
        <div class="grid gap-3 text-sm text-white/90">
          <div class="flex items-center gap-3 rounded-2xl bg-white/10 px-4 py-3">
            <i class="fa-solid fa-shield-halved"></i>
            Xác thực qua Google SSO
          </div>
          <div class="flex items-center gap-3 rounded-2xl bg-white/10 px-4 py-3">
            <i class="fa-solid fa-bolt"></i>
            Vào học chỉ với một lần chạm
          </div>
        </div>
      </div>

      <div class="p-6 sm:p-10">
        <div class="mb-8 text-center lg:text-left">
          <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-primary to-secondary text-2xl font-bold text-white lg:mx-0 lg:hidden">L</div>
          <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-primary">LearnCode</p>
          <h2 class="mb-2 text-3xl font-bold text-slate-900">Đăng nhập</h2>
          <p class="text-sm leading-6 text-slate-500">LearnCode chỉ sử dụng Google SSO, không lưu mật khẩu Gmail của bạn.</p>
        </div>

        <?php
        $errors = SessionManager::getErrors();
        if (!empty($errors)) {
            echo '<div class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">';
            foreach ($errors as $error) {
                echo '<p>• ' . htmlspecialchars($error) . '</p>';
            }
            echo '</div>';
        }
        ?>

        <a href="../controllers/GoogleAuthController.php" class="btn-premium flex w-full items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white px-5 py-4 font-semibold text-slate-800 shadow-sm hover:border-slate-300 hover:bg-slate-50">
          <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.1c-.22-.66-.35-1.36-.35-2.1s.13-1.44.35-2.1V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l3.66-2.84z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06L5.84 9.9C6.71 7.3 9.14 5.38 12 5.38z"/>
          </svg>
          Tiếp tục với Gmail
        </a>

        <p class="mt-5 text-center text-xs leading-5 text-slate-400">Bằng cách tiếp tục, bạn sử dụng tài khoản Google để xác thực danh tính trên LearnCode.</p>
      </div>
    </div>
  </div>
</section>

<?php include '../components/footer.php'; ?>
