# 📂 Cấu Trúc Dự Án WebHọcTrựcTuyến - Hướng Dẫn Chi Tiết

**📅 Ngày Tạo:** 27/05/2026  
**📌 Version:** 1.0  
**🎯 Mục Đích:** Giải thích chi tiết từng thư mục, file trong dự án và chức năng của chúng

---

## 📋 Mục Lục

1. [Cấu Trúc Tổng Quan](#cấu-trúc-tổng-quan)
2. [Chi Tiết Từng Thư Mục](#chi-tiết-từng-thư-mục)
3. [Chi Tiết Từng File](#chi-tiết-từng-file)
4. [Quy Tắc & Best Practices](#quy-tắc--best-practices)

---

## 📊 Cấu Trúc Tổng Quan

```
webhoctap/
├── 📁 assets/                  # Tài nguyên tĩnh (CSS, JS)
│   ├── css/index.css           # Stylesheet chính
│   └── js/app.js               # JavaScript chính
├── 📁 components/              # Component PHP tái sử dụng
│   ├── header.php              # Phần header chung
│   └── footer.php              # Phần footer chung
├── 📁 controllers/             # Xử lý logic (MVC Controller)
│   ├── AuthController.php      # Logic đăng nhập
│   ├── RegisterController.php  # Logic đăng ký
│   └── LogoutController.php    # Logic đăng xuất
├── 📁 core/                    # Các class cơ bản
│   ├── Database.php            # Kết nối database
│   ├── SessionManager.php      # Quản lý session
│   ├── BaseController.php      # Base controller
│   └── Exceptions.php          # Custom exceptions
├── 📁 helpers/                 # Hàm tiện ích
│   └── ValidationHelper.php    # Validation logic
├── 📁 models/                  # Tầng dữ liệu (MVC Model)
│   └── User.php                # Model User
├── 📁 pages/                   # Trang hiển thị (MVC View)
│   ├── home.php                # Trang chủ
│   ├── login.php               # Trang đăng nhập
│   ├── register.php            # Trang đăng ký
│   ├── courses.php             # Trang khóa học
│   ├── course-detail.php       # Chi tiết khóa học
│   ├── profile.php             # Hồ sơ người dùng
│   ├── admin.php               # Trang admin
│   ├── about.php               # Trang giới thiệu
│   ├── contact.php             # Trang liên hệ
│   └── forum.php               # Trang diễn đàn
├── 📁 setup/                   # Setup & configuration
│   └── setup_test_accounts.php # Tạo tài khoản test
├── 📁 docs/                    # Tài liệu dự án
│   ├── REFACTORING_27052026.md
│   ├── QUICK_REFERENCE.md
│   └── PROJECT_STRUCTURE.md    # File này
├── 📄 index.php                # Điểm vào chính
├── 📄 web_hoc_truc_tuyen.sql   # Database schema
└── 📄 .htaccess                # Apache config (URL rewrite)
```

---

## 🗂️ Chi Tiết Từng Thư Mục

### 1️⃣ 📁 **assets/** - Tài Nguyên Tĩnh

**Mục Đích:** Chứa tất cả các file CSS, JavaScript, hình ảnh, font tĩnh

#### 📁 **assets/css/**
| File | Mục Đích | Tác Dụng |
|------|---------|---------|
| `index.css` | Stylesheet chính | CSS tùy chỉnh cho ứng dụng (animations, custom styles) |

**Nội dung `index.css`:**
- ✅ Keyframe animations (pageEnter, fadeIn, slideFromLeft, etc.)
- ✅ Custom styles cho UI components
- ✅ Responsive design tweaks
- ✅ Transitions & hover effects
- ✅ Thêm Tailwind CSS customizations

#### 📁 **assets/js/**
| File | Mục Đích | Tác Dụng |
|------|---------|---------|
| `app.js` | JavaScript chính | Xử lý các sự kiện client-side (toggle password, filter courses, smooth scroll, etc.) |

**Nội dung `app.js`:**
- ✅ Event listeners cho các button, form
- ✅ Toggle password visibility
- ✅ Course category filter
- ✅ Smooth scroll navigation
- ✅ Form validation client-side
- ✅ Interactive UI behaviors

---

### 2️⃣ 📁 **components/** - Component PHP Tái Sử Dụng

**Mục Đích:** Chứa các phần giao diện được sử dụng lại ở nhiều trang

| File | Mục Đích | Sử Dụng Ở Đâu |
|------|---------|--------------|
| `header.php` | Layout phần đầu trang | Tất cả pages (login, register, home, courses, etc.) |
| `footer.php` | Layout phần cuối trang | Tất cả pages |

**`header.php` - Phần Đầu Trang:**
```php
// Khởi động session
SessionManager::start();

// Kiến trúc:
// 1. DOCTYPE, HTML meta tags
// 2. Tailwind CSS + Font Awesome CDN
// 3. Custom CSS (assets/css/index.css)
// 4. Navigation header
// 5. Opening <main> tag
```

**Chứa:**
- ✅ HTML DOCTYPE, meta tags (charset, viewport)
- ✅ CSS links (Font Awesome, Tailwind, custom CSS)
- ✅ Navigation bar (logo, menu, user info)
- ✅ JavaScript (Tailwind config)

**`footer.php` - Phần Cuối Trang:**
```php
// Đóng <main> tag từ header.php

// Kiến trúc:
// 1. Footer links (Brand, Product, Company, Support)
// 2. Social media links
// 3. Copyright info
// 4. JavaScript includes (app.js)
// 5. Closing </body>, </html>
```

**Chứa:**
- ✅ Footer links (Product, Company, Support)
- ✅ Social media icons
- ✅ Copyright information
- ✅ JavaScript file include (app.js)
- ✅ Closing HTML tags

---

### 3️⃣ 📁 **controllers/** - Tầng Xử Lý Logic (MVC - Controllers)

**Mục Đích:** Xử lý business logic, điều phối Model và View

| File | Mục Đích | Phương Thức |
|------|---------|-----------|
| `AuthController.php` | Xử lý đăng nhập | `login()` |
| `RegisterController.php` | Xử lý đăng ký | `register()` |
| `LogoutController.php` | Xử lý đăng xuất | `logout()` |

**`AuthController.php` - Đăng Nhập:**
```
Quy trình:
1. Kiểm tra METHOD là POST
2. Lấy email & password từ form
3. Validate (không trống, email format, password không trống)
4. Tìm user trong database (User model)
5. Xác minh mật khẩu (password_verify)
6. Kiểm tra tài khoản không bị khóa
7. Lưu session (SessionManager::login)
8. Redirect về trang chủ (hoặc quay lại login nếu lỗi)
```

**Extends:** `BaseController`
**Dependency:** `User` model, `SessionManager`

**`RegisterController.php` - Đăng Ký:**
```
Quy trình:
1. Kiểm tra METHOD là POST
2. Lấy (ho_ten, email, so_dien_thoai, password, confirm_password)
3. Validate từng field:
   - Họ tên: 3-255 ký tự
   - Email: format email hợp lệ, không trùng
   - SĐT: format Việt Nam (optional)
   - Password: min 6 ký tự
   - Password confirm: khớp password
4. Tạo tài khoản mới (User model)
5. Lấy thông tin user vừa tạo
6. Đăng nhập ngay sau khi đăng ký
7. Redirect về trang chủ
```

**Extends:** `BaseController`
**Dependency:** `User` model, `SessionManager`

**`LogoutController.php` - Đăng Xuất:**
```
Quy trình:
1. Gọi SessionManager::logout() (xóa session)
2. Redirect về trang login
```

**Extends:** `BaseController`
**Dependency:** `SessionManager`

---

### 4️⃣ 📁 **core/** - Các Class Cơ Bản

**Mục Đích:** Chứa các class nền tảng cho ứng dụng

| File | Mục Đích | Pattern |
|------|---------|---------|
| `Database.php` | Kết nối database | Singleton |
| `SessionManager.php` | Quản lý session | Static Class |
| `BaseController.php` | Base controller | Abstract Class |
| `Exceptions.php` | Custom exceptions | Exception Classes |

**`Database.php` - Singleton Pattern:**
```php
// Singleton = chỉ 1 kết nối duy nhất

Các phương thức:
✓ getConnection()      - Lấy kết nối (tạo mới nếu chưa có)
✓ closeConnection()    - Đóng kết nối

Ưu điểm:
- Tiết kiệm tài nguyên server (1 kết nối duy nhất)
- An toàn (kiểm tra lỗi kết nối)
- UTF-8 charset support (tiếng Việt)
```

**`SessionManager.php` - Static Class:**
```php
// Tất cả phương thức là static (không cần new)

Các phương thức chính:
✓ start()              - Khởi động session
✓ isLoggedIn()         - Kiểm tra đã đăng nhập?
✓ requireLogin()       - Bảo vệ trang (redirect nếu chưa login)
✓ requireAdmin()       - Bảo vệ trang admin
✓ get($key, $default)  - Lấy giá trị session
✓ set($key, $value)    - Lưu giá trị session
✓ remove($key)         - Xóa giá trị session
✓ getCurrentUser()     - Lấy thông tin user hiện tại
✓ login($user)         - Lưu user session sau khi login
✓ logout()             - Xóa session khi logout
✓ setErrors($errors)   - Lưu thông báo lỗi (flash message)
✓ getErrors()          - Lấy thông báo lỗi (xóa sau khi lấy)
```

**`BaseController.php` - Abstract Base Class:**
```php
// Lớp cơ sở cho tất cả Controllers

Các phương thức protected:
✓ redirect($url)       - Chuyển hướng trang
✓ jsonResponse($data)  - Gửi JSON response
✓ getMethod()          - Lấy HTTP method
✓ isPost(), isGet()    - Kiểm tra POST/GET
✓ getPost($key)        - Lấy dữ liệu POST an toàn
✓ getQuery($key)       - Lấy dữ liệu GET an toàn
✓ validate(...)        - Validate dữ liệu input
✓ log($message)        - Ghi log
```

**`Exceptions.php` - Custom Exceptions:**
```php
// Định nghĩa các exception riêng

Các loại:
✓ AppException              - Exception cơ sở
✓ DatabaseException         - Lỗi database
✓ ValidationException       - Lỗi validation
✓ AuthenticationException   - Lỗi xác thực
✓ AuthorizationException    - Lỗi phân quyền
```

---

### 5️⃣ 📁 **helpers/** - Hàm Tiện Ích

**Mục Đích:** Chứa các hàm/class hỗ trợ (validation, formatting, etc.)

| File | Mục Đích | Loại |
|------|---------|------|
| `ValidationHelper.php` | Validation logic | Static Class |

**`ValidationHelper.php` - Static Class:**
```php
// Tất cả phương thức là static

Các phương thức:
✓ isValidEmail($email)        - Kiểm tra email hợp lệ
✓ isStrongPassword($pass)     - Mật khẩu đủ mạnh (8+, upper, lower, digit)
✓ isValidName($name)          - Tên hợp lệ (3-255 ký, hỗ trợ TV)
✓ isValidPhone($phone)        - SĐT Việt Nam hợp lệ (0xxx hoặc +84)
✓ sanitizeInput($data)        - Làm sạch input (XSS prevention)
✓ renderErrors($errors)       - HTML danh sách lỗi
```

---

### 6️⃣ 📁 **models/** - Tầng Dữ Liệu (MVC - Models)

**Mục Đích:** Thao tác với database, CRUD operations

| File | Mục Đích | Bảng DB |
|------|---------|---------|
| `User.php` | Model User | `nguoi_dung` |

**`User.php` - User Model:**
```php
// Tầng dữ liệu cho người dùng

Các phương thức:
✓ __construct($conn)          - Khởi tạo với DB connection
✓ findByEmail($email)         - Tìm user theo email
✓ findById($id)               - Tìm user theo ID
✓ emailExists($email)         - Kiểm tra email đã tồn tại?
✓ create($hoTen, $email, ...) - Tạo user mới
✓ verifyPassword($plain, $hash) - Xác minh mật khẩu
✓ update(...)                 - Cập nhật user (có thể phát triển)
✓ delete($id)                 - Xóa user (có thể phát triển)

Sử dụng Prepared Statements (an toàn SQL Injection)
Sử dụng password_hash/password_verify
```

---

### 7️⃣ 📁 **pages/** - Tầng Hiển Thị (MVC - Views)

**Mục Đích:** HTML templates, giao diện người dùng

| File | Mục Đích | Public/Protected |
|------|---------|-----------------|
| `index.php` (root) | Điểm vào | Public |
| `home.php` | Trang chủ | Public |
| `login.php` | Trang đăng nhập | Public |
| `register.php` | Trang đăng ký | Public |
| `courses.php` | Danh sách khóa học | Public |
| `course-detail.php` | Chi tiết khóa học | Public |
| `profile.php` | Hồ sơ người dùng | Protected (requireLogin) |
| `admin.php` | Dashboard admin | Protected (requireAdmin) |
| `about.php` | Giới thiệu | Public |
| `contact.php` | Liên hệ | Public |
| `forum.php` | Diễn đàn | Public |

**`home.php` - Trang Chủ:**
```php
// Trang chủ công khai

Nội dung:
✓ Hero section (tiêu đề, CTA)
✓ Statistics (50k+ học viên, 200+ khóa)
✓ Featured courses
✓ Testimonials
✓ CTA buttons (Khám phá, Tìm hiểu thêm)

Bảo vệ: Không (public)
```

**`login.php` - Đăng Nhập:**
```php
// Trang đăng nhập

Nội dung:
✓ Form: email, password
✓ "Quên mật khẩu?" link
✓ Hiển thị lỗi nếu có
✓ Submit button
✓ Link đăng ký (untuk chuyển hướng)

Form action: POST → ../controllers/AuthController.php
Bảo vệ: Không (public, nhưng redirect nếu đã login)
```

**`register.php` - Đăng Ký:**
```php
// Trang đăng ký

Nội dung:
✓ Form: ho_ten, email, so_dien_thoai, password, confirm_password
✓ Hiển thị lỗi nếu có
✓ Checkbox điều khoản
✓ Submit button
✓ Link đăng nhập

Form action: POST → ../controllers/RegisterController.php
Bảo vệ: Không (public)
```

**`courses.php` - Danh Sách Khóa Học:**
```php
// Trang danh sách khóa học

Nội dung:
✓ Header với search & filter
✓ Category sidebar
✓ Grid courses với card
✓ Course info (tên, giáo viên, rating, giá)
✓ Pagination (nếu nhiều)

Bảo vệ: Không (public)
```

**`course-detail.php` - Chi Tiết Khóa Học:**
```php
// Trang chi tiết một khóa học

Nội dung:
✓ Thông tin khóa học (tên, mô tả, rating)
✓ Video preview
✓ Giáo viên info
✓ Nội dung khóa học (modules, lessons)
✓ Reviews
✓ Nút "Đăng ký khóa"

Bảo vệ: Không (public)
```

**`profile.php` - Hồ Sơ Người Dùng:**
```php
// Trang hồ sơ cá nhân

Nội dung:
✓ Avatar, tên, username
✓ Thông tin liên hệ
✓ Các khóa học đang học
✓ Chứng chỉ đã nhận
✓ Nút "Chỉnh sửa hồ sơ"

Bảo vệ: YES - SessionManager::requireLogin();
```

**`admin.php` - Admin Dashboard:**
```php
// Trang quản trị admin

Nội dung:
✓ Statistics (tổng user, khóa học, revenue)
✓ Chart dữ liệu
✓ Quản lý user, khóa học, orders
✓ Reports

Bảo vệ: YES - SessionManager::requireAdmin();
```

**`about.php` - Giới Thiệu:**
```php
// Trang giới thiệu công ty

Nội dung:
✓ Về LearnCode
✓ Mission & Vision
✓ Statistics (50k+ users, 200+ courses)
✓ Team members

Bảo vệ: Không (public)
```

**`contact.php` - Liên Hệ:**
```php
// Trang liên hệ

Nội dung:
✓ Form liên hệ (name, email, message)
✓ Địa chỉ, SĐT, email
✓ Map embedding (Google Maps optional)

Bảo vệ: Không (public)
```

**`forum.php` - Diễn Đàn:**
```php
// Trang diễn đàn cộng đồng

Nội dung:
✓ List bài viết
✓ Filter tab (Tất cả, My posts, etc.)
✓ Search posts
✓ Nút "Tạo bài viết"
✓ Post cards (title, author, replies, views)

Bảo vệ: Không (public)
```

---

### 8️⃣ 📁 **setup/** - Setup & Configuration

**Mục Đích:** Script khởi tạo dữ liệu test, cấu hình

| File | Mục Đích | Chạy Khi Nào |
|------|---------|------------|
| `setup_test_accounts.php` | Tạo tài khoản test | Lần đầu setup |

**`setup_test_accounts.php` - Test Accounts:**
```php
// Tạo tài khoản test để kiểm thử

Các tài khoản được tạo:
✓ Admin: admin@example.com / admin123 (vai trò: admin)
✓ User: user@example.com / user123 (vai trò: user)
✓ Student: student@example.com / student123 (vai trò: user)

Cách chạy:
1. Mở browser: http://localhost/webhoctap/setup/setup_test_accounts.php
2. Script chạy tự động
3. Thông báo "Tạo tài khoản thành công"

⚠️ CHỈ CHẠY 1 LẦN!
Sau khi chạy, xóa file hoặc disable script
```

---

### 9️⃣ 📁 **docs/** - Tài Liệu Dự Án

**Mục Đích:** Hướng dẫn, tài liệu cho developers

| File | Mục Đích |
|------|---------|
| `REFACTORING_27052026.md` | Nhật ký cải thiện OOP |
| `QUICK_REFERENCE.md` | Hướng dẫn nhanh sử dụng |
| `PROJECT_STRUCTURE.md` | File này - chi tiết cấu trúc |

---

## 📄 Chi Tiết Từng File

### 📄 Root Files

| File | Mục Đích | Nội Dung |
|------|---------|---------|
| `index.php` | Điểm vào chính | Redirect đến pages/home.php |
| `web_hoc_truc_tuyen.sql` | Database schema | Câu lệnh CREATE TABLE, INSERT data |
| `.htaccess` | Apache config | URL rewrite rules (optional) |

**`index.php` - Điểm Vào Chính:**
```php
<?php
header("Location: pages/home.php");
exit();
?>
// Redirect từ root đến trang chủ
```

**`web_hoc_truc_tuyen.sql` - Database:**
```sql
-- Schema database (MySQL)

CREATE TABLE nguoi_dung (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ho_ten VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    mat_khau VARCHAR(255),    -- hash của mật khẩu
    vai_tro ENUM('user', 'admin'),
    avatar VARCHAR(255),
    trang_thai ENUM('hoat_dong', 'khoa'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tạo bảng khóa học, lessons, enrollments, etc. (tùy từng feature)
```

---

## 🏗️ Quy Tắc & Best Practices

### 1️⃣ **MVC Pattern**
```
Models (models/)      → Dữ liệu (Database operations)
         ↓
Controllers (controllers/) → Logic (Business logic)
         ↓
Views (pages/)        → Giao diện (HTML rendering)
```

### 2️⃣ **OOP Principles**
- ✅ Encapsulation - Private/Protected/Public properties & methods
- ✅ Inheritance - Controllers extend BaseController
- ✅ Polymorphism - Override methods ở class con
- ✅ Abstraction - Abstract BaseController

### 3️⃣ **File Organization**
```
📁 assets/     → Tài nguyên tĩnh (không logic)
📁 components/ → Reusable templates
📁 controllers → Business logic
📁 core/       → Foundation classes
📁 helpers/    → Utility functions/classes
📁 models/     → Database layer
📁 pages/      → UI templates
📁 setup/      → Configuration scripts
```

### 4️⃣ **Naming Conventions**
```
Files:      PascalCase.php (User.php, AuthController.php)
Classes:    PascalCase (class User)
Methods:    camelCase (public function login())
Variables:  camelCase ($userName, $emailAddress)
Constants:  UPPER_SNAKE_CASE (const DB_HOST = '...')
```

### 5️⃣ **Security Practices**
- ✅ Prepared Statements (SQL Injection prevention)
- ✅ password_hash/password_verify (Password security)
- ✅ SessionManager::requireLogin() (Page protection)
- ✅ htmlspecialchars() (XSS prevention)
- ✅ Custom Exceptions (Error handling)

### 6️⃣ **URL Structure**
```
Public pages:     /webhoctap/pages/home.php
Login:            /webhoctap/pages/login.php
Register:         /webhoctap/pages/register.php
Profile (protected): /webhoctap/pages/profile.php
Admin (protected):   /webhoctap/pages/admin.php

Controllers:      /webhoctap/controllers/AuthController.php
Assets:           /webhoctap/assets/css/index.css
                  /webhoctap/assets/js/app.js
```

---

## 🔄 Quy Trình Dữ Liệu (Data Flow)

### Đăng Nhập (Login Flow)
```
pages/login.php (Form)
    ↓ POST email, password
controllers/AuthController.php (Logic)
    ↓ Validate input
helpers/ValidationHelper.php (Validation)
    ↓ Valid? Find user
models/User.php (Database query)
    ↓ SELECT FROM nguoi_dung
core/Database.php (Connection)
    ↓ Check password
    ↓ Create session
core/SessionManager.php (Session save)
    ↓ Redirect
pages/home.php (Success page)
```

### Đăng Ký (Register Flow)
```
pages/register.php (Form)
    ↓ POST ho_ten, email, password
controllers/RegisterController.php (Logic)
    ↓ Validate all fields
helpers/ValidationHelper.php (Validation)
    ↓ Check email exists?
models/User.php (Database query)
    ↓ INSERT new user
core/Database.php (Connection)
    ↓ Hash password
    ↓ Create session
core/SessionManager.php (Session save)
    ↓ Auto login
    ↓ Redirect
pages/home.php (Success page)
```

---

## 📊 Database Schema (Simplified)

```sql
-- Bảng người dùng
nguoi_dung {
  id: int (PK, Auto-increment)
  ho_ten: varchar(255)
  email: varchar(255) (UNIQUE)
  mat_khau: varchar(255) (hash)
  vai_tro: enum('user', 'admin')
  avatar: varchar(255)
  trang_thai: enum('hoat_dong', 'khoa')
  created_at: timestamp
}

-- Có thể mở rộng với:
khoa_hoc {
  id, ten_khoa, mo_ta, giang_vien_id, gia, ...
}

bai_hoc {
  id, khoa_hoc_id, ten_bai, noi_dung, ...
}

dang_ky_khoa {
  id, nguoi_dung_id, khoa_hoc_id, ngay_dang_ky, ...
}

-- etc.
```

---

## 💡 Tips & Recommendations

### Khi Thêm Feature Mới

1. **Tạo Model class** (nếu cần thao tác DB)
   ```php
   class Course {
       public function __construct(mysqli $conn) {}
       public function findAll(): array {}
       public function findById(int $id): ?array {}
   }
   ```

2. **Tạo Controller class** (Extend BaseController)
   ```php
   class CourseController extends BaseController {
       private Course $courseModel;
       public function __construct(Course $model) {}
       public function show(): void {}
   }
   ```

3. **Tạo View file** (pages/*.php)
   ```php
   <?php include '../components/header.php'; ?>
   <!-- HTML content -->
   <?php include '../components/footer.php'; ?>
   ```

4. **Protect pages nếu cần**
   ```php
   SessionManager::requireLogin();    // Chỉ logged-in users
   SessionManager::requireAdmin();    // Chỉ admin
   ```

### Error Handling

```php
try {
    $course = $courseModel->findById($courseId);
    if (!$course) {
        throw new ValidationException("Khóa học không tồn tại");
    }
} catch (ValidationException $e) {
    SessionManager::setErrors([$e->getMessage()]);
    $this->redirect('../pages/courses.php');
} catch (DatabaseException $e) {
    $this->log("Database error: " . $e->getMessage(), 'error');
    SessionManager::setErrors(["Lỗi hệ thống"]);
    $this->redirect('../pages/error.php');
}
```

---

## 📞 Liên Hệ & Hỗ Trợ

Để biết thêm chi tiết cụ thể về từng file/class, tham khảo:
- `REFACTORING_27052026.md` - Chi tiết cải thiện OOP
- `QUICK_REFERENCE.md` - Hướng dẫn sử dụng các classes

---

**Happy Coding! 🚀**
