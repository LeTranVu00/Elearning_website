# 📋 File Structure Summary - Tóm Tắt Cấu Trúc

**Ngày Tạo:** 27/05/2026

---

## 🗂️ Cấu Trúc File - Tóm Tắt

### 📁 ROOT LEVEL (Thư Mục Gốc)

| File/Folder | Loại | Mục Đích | Status |
|---|---|---|---|
| `index.php` | Entry Point | Redirect → pages/home.php | ✅ |
| `web_hoc_truc_tuyen.sql` | Database | MySQL schema & initial data | ✅ |
| `.htaccess` | Config | Apache URL rewriting (optional) | ⚪ |
| `.docs/` | Internal | VS Code docs (auto-generated) | ⚪ |

---

### 📁 assets/ - Tài Nguyên Tĩnh

```
assets/
├── css/
│   └── index.css          [400+ lines] - Animations, custom styles
└── js/
    └── app.js             [300+ lines] - Event listeners, interactivity
```

**Chức Năng:**
- ✅ CSS: Custom animations (fadeIn, pageEnter, slideFrom*), hover effects, responsive tweaks
- ✅ JS: Password toggle, course filter, smooth scroll, form validation client-side

---

### 📁 components/ - Reusable Components

```
components/
├── header.php             [50+ lines] - HTML head, nav bar, SessionManager init
└── footer.php             [80+ lines] - Footer links, social icons, closing tags
```

**Sử Dụng:**
- ✅ Included ở đầu tất cả pages (header.php)
- ✅ Included ở cuối tất cả pages (footer.php)
- ✅ Giảm lặp lại code

**Nội Dung Header:**
- HTML5 DOCTYPE, meta tags
- Tailwind CSS CDN
- Font Awesome CDN
- Navigation bar (logo, menu)
- SessionManager::start()

**Nội Dung Footer:**
- Footer links (Product, Company, Support)
- Social media
- Copyright
- Closing `</main>`, `</body>`, `</html>`

---

### 📁 controllers/ - Business Logic (MVC - C)

```
controllers/
├── AuthController.php     [150+ lines] - Login logic
│   └── extends BaseController
│       methods: login()
├── RegisterController.php [180+ lines] - Register logic
│   └── extends BaseController
│       methods: register()
└── LogoutController.php   [30+ lines] - Logout logic
    └── extends BaseController
        methods: logout()
```

**Pattern:** MVC Controller
**Extends:** BaseController (new OOP approach)

**AuthController - Đăng Nhập:**
- Check POST request
- Get & validate email + password
- Find user by email
- Verify password
- Check account status
- Create session
- Redirect

**RegisterController - Đăng Ký:**
- Check POST request
- Get & validate all fields
- Check email not exists
- Create user account
- Auto login
- Redirect to home

**LogoutController - Đăng Xuất:**
- Destroy session
- Redirect to login

---

### 📁 core/ - Foundation Classes

```
core/
├── Database.php           [100+ lines] - Singleton DB connection
│   pattern: Singleton
│   methods: getConnection(), closeConnection()
├── SessionManager.php     [200+ lines] - Session management
│   pattern: Static class
│   methods: start(), isLoggedIn(), login(), logout(), get(), set(), etc.
├── BaseController.php     [220+ lines] - Abstract base controller
│   pattern: Abstract class
│   methods: redirect(), jsonResponse(), getPost(), validate(), log(), etc.
└── Exceptions.php         [75+ lines] - Custom exceptions
    classes: AppException, DatabaseException, ValidationException,
             AuthenticationException, AuthorizationException
```

**Database.php - Singleton Pattern:**
- ✅ 1 kết nối duy nhất
- ✅ Singleton::getConnection() - lấy kết nối (tạo nếu chưa có)
- ✅ Set charset UTF-8 (Tiếng Việt)

**SessionManager.php - Static Class:**
- ✅ Không cần tạo object
- ✅ Gọi: SessionManager::method()
- ✅ Quản lý login/logout/session data

**BaseController.php - Abstract Base:**
- ✅ Base class cho tất cả controllers
- ✅ Phương thức chung: redirect(), getPost(), validate(), log()
- ✅ Giảm lặp code

**Exceptions.php - Custom Exceptions:**
- ✅ 5 loại exception
- ✅ Xử lý lỗi chi tiết hơn

---

### 📁 helpers/ - Utility Functions

```
helpers/
└── ValidationHelper.php   [180+ lines] - Input validation
    pattern: Static class
    methods: isValidEmail(), isStrongPassword(), isValidName(),
             isValidPhone(), sanitizeInput(), renderErrors()
```

**ValidationHelper - Static Class:**
- ✅ Email validation (RFC 5322 format)
- ✅ Password strength (8+ chars, upper, lower, digit)
- ✅ Name validation (3-255 chars, Vietnamese support)
- ✅ Phone validation (Vietnam format)
- ✅ Input sanitization (XSS prevention)
- ✅ HTML error rendering

---

### 📁 models/ - Data Layer (MVC - M)

```
models/
└── User.php               [200+ lines] - User model
    pattern: OOP Model class
    methods: __construct(), findByEmail(), findById(), emailExists(),
             create(), verifyPassword()
```

**User.php - Model:**
- ✅ Dependency injection (receive DB connection)
- ✅ CRUD operations
- ✅ Prepared statements (SQL Injection safe)
- ✅ password_hash/password_verify

**Methods:**
- `findByEmail($email)` - Find user by email
- `findById($id)` - Find user by ID
- `emailExists($email)` - Check if email exists
- `create()` - Create new user
- `verifyPassword()` - Verify password

---

### 📁 pages/ - Templates (MVC - V)

```
pages/
├── home.php               [100+ lines] - Homepage
│   Access: Public
│   Contains: Hero, statistics, featured courses, CTA
├── login.php              [150+ lines] - Login form
│   Access: Public
│   Form → AuthController.php
├── register.php           [180+ lines] - Register form
│   Access: Public
│   Form → RegisterController.php
├── courses.php            [120+ lines] - Course listings
│   Access: Public
│   Features: Search, filter, pagination
├── course-detail.php      [150+ lines] - Single course
│   Access: Public
│   Content: Course info, reviews, instructor
├── profile.php            [100+ lines] - User profile
│   Access: Protected (requireLogin)
│   Content: User info, my courses, certificates
├── admin.php              [100+ lines] - Admin dashboard
│   Access: Protected (requireAdmin)
│   Content: Statistics, user management
├── about.php              [80+ lines] - About page
│   Access: Public
│   Content: Mission, team, statistics
├── contact.php            [100+ lines] - Contact form
│   Access: Public
│   Content: Contact form, address, map
└── forum.php              [100+ lines] - Community forum
    Access: Public
    Content: Posts, filters, create post button
```

**Structure of Every Page:**
```php
<?php include '../components/header.php'; ?>
<!-- Page content here -->
<?php include '../components/footer.php'; ?>
```

**Page Protection:**
```php
// Protected pages
SessionManager::requireLogin();    // pages/profile.php
SessionManager::requireAdmin();    // pages/admin.php

// Public pages (no protection)
```

---

### 📁 setup/ - Configuration & Setup

```
setup/
└── setup_test_accounts.php [100+ lines] - Create test accounts
    Usage: Run once during setup
    Creates:
    - admin@example.com / admin123 (admin role)
    - user@example.com / user123 (user role)
    - student@example.com / student123 (user role)
```

---

### 📁 docs/ - Documentation

```
docs/
├── REFACTORING_27052026.md   [400+ lines] - OOP improvements log
│   Content: What changed, why, benefits, migration guide
├── QUICK_REFERENCE.md        [350+ lines] - Quick usage guide
│   Content: How to use new classes, examples, patterns
└── PROJECT_STRUCTURE.md      [500+ lines] - This file (detailed structure)
    Content: Every file/folder explained in detail
```

---

## 📊 File Count & Statistics

| Folder | Files | Type | Lines of Code |
|--------|-------|------|----------------|
| `assets/` | 2 | CSS, JS | ~700 |
| `components/` | 2 | PHP | ~130 |
| `controllers/` | 3 | PHP (OOP) | ~360 |
| `core/` | 4 | PHP (OOP) | ~595 |
| `helpers/` | 1 | PHP (OOP) | ~180 |
| `models/` | 1 | PHP (OOP) | ~200 |
| `pages/` | 10 | PHP (Templates) | ~1100 |
| `setup/` | 1 | PHP (Setup) | ~100 |
| `docs/` | 3 | Markdown | ~1200 |
| **TOTAL** | **27** | Mixed | **~4465** |

---

## 🎯 Quick Reference - What Goes Where?

| Need | Go To | File |
|------|-------|------|
| Add new page | `pages/` | `pages/my-page.php` |
| Add page styling | `assets/css/` | `assets/css/index.css` |
| Add page interaction | `assets/js/` | `assets/js/app.js` |
| Add validation | `helpers/` | `ValidationHelper.php` |
| Add model (DB operations) | `models/` | `models/MyModel.php` |
| Add controller (logic) | `controllers/` | `controllers/MyController.php` |
| Add exception type | `core/` | `Exceptions.php` |
| Create test data | `setup/` | `setup_my_setup.php` |
| Write documentation | `docs/` | `docs/MY_DOC.md` |
| Add HTML reusable | `components/` | `components/my-component.php` |

---

## 🔄 Data Flow Overview

```
USER REQUEST
    ↓
BROWSER (pages/*.php - View)
    ↓ Form submission
CONTROLLER (controllers/*.php)
    ↓ Validate using
HELPER (helpers/ValidationHelper.php)
    ↓ If valid, call
MODEL (models/*.php)
    ↓ Query using
DATABASE (core/Database.php via mysqli)
    ↓ Return data
CONTROLLER (Process result)
    ↓ Set session or
SESSION (core/SessionManager.php)
    ↓ Redirect to
VIEW (pages/*.php)
    ↓
USER SEES RESULT
```

---

## ✅ Best Practices Used

| Practice | Implementation |
|----------|-----------------|
| **MVC Pattern** | Model/Controller/View separated |
| **OOP** | Classes, inheritance, abstraction, interfaces |
| **Singleton** | Database connection |
| **Static Class** | SessionManager, ValidationHelper |
| **Abstract Class** | BaseController |
| **Custom Exceptions** | Error handling |
| **Prepared Statements** | SQL Injection protection |
| **Password Hashing** | password_hash/password_verify |
| **Session Protection** | SessionManager::requireLogin() |
| **Input Validation** | ValidationHelper methods |
| **XSS Prevention** | htmlspecialchars() |
| **DRY Principle** | Reusable components, base controller |
| **Dependency Injection** | Pass dependencies via constructor |
| **Naming Convention** | PascalCase for files/classes, camelCase for methods |

---

## 🚀 Getting Started

### 1. Initial Setup
```
1. Extract/clone project
2. Import web_hoc_truc_tuyen.sql to MySQL
3. Configure Database.php with your DB credentials
4. Run setup_test_accounts.php (optional - create test users)
5. Access http://localhost/webhoctap/pages/home.php
```

### 2. Login with Test Account
```
Email: admin@example.com
Password: admin123
Role: Admin
```

### 3. Add a New Feature
```
1. Create Model class (models/MyModel.php)
2. Create Controller class (controllers/MyController.php)
3. Create View file (pages/my-page.php)
4. Add validation to ValidationHelper if needed
5. Add custom exception to Exceptions.php if needed
```

---

## 📞 References

- Full structure details → `PROJECT_STRUCTURE.md`
- How to use classes → `QUICK_REFERENCE.md`
- What changed & why → `REFACTORING_27052026.md`

---

**Last Updated: 27/05/2026**  
**Project: WebHọcTrựcTuyến (LearnCode)**
