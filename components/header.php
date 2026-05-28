<?php
/**
 * components/header.php
 * Layout chung: Phần đầu trang (HTML head + Navigation bar)
 *
 * Sử dụng SessionManager (OOP) thay vì session_start() thủ tục cũ.
 * File này được include ở đầu tất cả các trang trong pages/*.php
 */
require_once __DIR__ . '/../core/SessionManager.php';

// Khởi động session qua OOP - SessionManager sẽ kiểm tra trước khi start
SessionManager::start();
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LearnCode - Nen tang hoc lap trinh</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ["Poppins", "sans-serif"],
            },
            colors: {
              primary: "#4F46E5",
              secondary: "#06B6D4",
              success: "#22C55E",
              warning: "#F59E0B",
              danger: "#EF4444",
              muted: "#6B7280",
              card: "#FFFFFF",
              surface: "#F9FAFB",
            },
            boxShadow: {
              soft: "0 10px 30px rgba(15, 23, 42, 0.08)",
            },
          },
        },
      };
  </script>
  <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body class="bg-slate-50 text-slate-900 antialiased flex flex-col min-h-screen">
  <!-- Navigation Header -->
  <header class="glass-nav sticky top-0 z-50 border-b border-white/20 bg-white/80 backdrop-blur-md shadow-sm">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
      <div class="flex h-16 items-center justify-between gap-4">
        <!-- Logo -->
        <a href="home.php" class="flex items-center gap-2">
          <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-secondary text-xl font-bold text-white shadow-sm">L</div>
          <span class="hidden sm:inline text-xl font-bold text-slate-900">LearnCode</span>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center gap-1">
          <a href="home.php" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-primary transition-colors">Trang chủ</a>
          <a href="courses.php" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-primary transition-colors">Khóa học</a>
          <a href="forum.php" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-primary transition-colors">Diễn đàn</a>
          <a href="about.php" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-primary transition-colors">Giới thiệu</a>
          <a href="contact.php" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-primary transition-colors">Liên hệ</a>
        </nav>

        <!-- Search & User Menu -->
        <div class="flex items-center gap-3">
          <div class="relative hidden sm:block">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" placeholder="Tìm kiếm..." class="h-10 w-48 lg:w-64 rounded-full border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm outline-none transition-all focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20" />
          </div>

          <!-- User Auth Section -->
          <div class="flex items-center gap-2">
            <?php if(SessionManager::isLoggedIn()): ?>
                <?php /* SessionManager::get() thay cho $_SESSION['ho_ten'] */ ?>
                <a href="profile.php" class="hidden sm:block rounded-xl px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Chào, <?php echo htmlspecialchars(SessionManager::get('ho_ten', 'Bạn')); ?></a>
                <a href="../controllers/LogoutController.php" class="btn-premium rounded-xl bg-danger px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-red-700" style="background-color: #ef4444;">Đăng xuất</a>
            <?php else: ?>
                <a href="login.php" class="hidden sm:block rounded-xl px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Đăng nhập</a>
                <a href="register.php" class="btn-premium rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-indigo-700">Đăng ký</a>
            <?php endif; ?>
          </div>

          <!-- Mobile Menu Toggle -->
          <button class="md:hidden flex h-10 w-10 items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
            <i class="fa-solid fa-bars text-xl"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden border-t border-slate-200 bg-white md:hidden">
      <div class="space-y-1 p-4">
        <a href="home.php" class="block w-full rounded-lg px-4 py-3 text-left font-medium text-slate-600 hover:bg-slate-50">Trang chủ</a>
        <a href="courses.php" class="block w-full rounded-lg px-4 py-3 text-left font-medium text-slate-600 hover:bg-slate-50">Khóa học</a>
        <a href="forum.php" class="block w-full rounded-lg px-4 py-3 text-left font-medium text-slate-600 hover:bg-slate-50">Diễn đàn</a>
        <a href="about.php" class="block w-full rounded-lg px-4 py-3 text-left font-medium text-slate-600 hover:bg-slate-50">Giới thiệu</a>
        <a href="contact.php" class="block w-full rounded-lg px-4 py-3 text-left font-medium text-slate-600 hover:bg-slate-50">Liên hệ</a>
        <div class="my-2 border-t border-slate-100"></div>
        <?php if(SessionManager::isLoggedIn()): ?>
            <a href="profile.php" class="block w-full rounded-lg px-4 py-3 text-left font-medium text-slate-600 hover:bg-slate-50">Hồ sơ</a>
            <a href="../controllers/LogoutController.php" class="block w-full rounded-lg px-4 py-3 text-left font-medium text-slate-600 hover:bg-slate-50 text-red-600">Đăng xuất</a>
        <?php else: ?>
            <a href="login.php" class="block w-full rounded-lg px-4 py-3 text-left font-medium text-slate-600 hover:bg-slate-50">Đăng nhập</a>
        <?php endif; ?>
      </div>
    </div>
  </header>
  <!-- End Header -->
  <main class="flex-grow">
