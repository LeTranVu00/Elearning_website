# 🎯 Quick Reference - Cách Dùng Các Class Mới

**Cập nhật:** 27/05/2026

---

## 📚 Table of Contents

1. [BaseController](#basecontroller)
2. [ValidationHelper](#validationhelper)
3. [Custom Exceptions](#custom-exceptions)
4. [Migration Guide (Cũ → Mới)](#migration-guide)

---

## BaseController

### Kế thừa BaseController
```php
require_once 'core/BaseController.php';
require_once 'core/Database.php';
require_once 'models/User.php';

class AuthController extends BaseController {
    private User $userModel;
    
    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }
    
    public function login(): void {
        // Implement logic here
    }
}
```

### Các Methods Có Sẵn

#### 1. Request Handling
```php
// Kiểm tra request type
if ($this->isPost()) { }     // POST?
if ($this->isGet()) { }      // GET?
$method = $this->getMethod(); // Lấy method

// Lấy dữ liệu từ form
$email = $this->getPost('email', '');
$id = $this->getQuery('id', 0);
```

#### 2. Redirect
```php
// Chuyển hướng trang
$this->redirect('../pages/home.php');

// Với HTTP status code
$this->jsonResponse(['success' => true], 200);
$this->jsonResponse(['error' => 'Not found'], 404);
```

#### 3. Validation
```php
$errors = [];

// Validate single field
$this->validate('email', $email, 'required|email', $errors);
$this->validate('name', $name, 'required|min:3|max:255', $errors);
$this->validate('password', $password, 'required|min:6', $errors);

// Các rule có sẵn:
// - required      (không để trống)
// - email         (định dạng email)
// - min:N         (tối thiểu N ký tự)
// - max:N         (tối đa N ký tự)
// - min:N|max:M   (kết hợp multiple rules)

if (!empty($errors)) {
    SessionManager::setErrors($errors);
    $this->redirect('../pages/form.php');
}
```

#### 4. Logging
```php
// Ghi log
$this->log('User logged in', 'info');
$this->log('Database error', 'error');
$this->log('Important event', 'warning');
```

### Ví Dụ Hoàn Chỉnh
```php
class LoginController extends BaseController {
    private User $userModel;
    
    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }
    
    public function handle(): void {
        // Chỉ accept POST
        if (!$this->isPost()) {
            $this->redirect('../pages/login.php');
        }
        
        // Lấy dữ liệu
        $email = trim($this->getPost('email', ''));
        $password = $this->getPost('password', '');
        
        // Validate
        $errors = [];
        $this->validate('email', $email, 'required|email', $errors);
        $this->validate('password', $password, 'required', $errors);
        
        if (!empty($errors)) {
            SessionManager::setErrors($errors);
            $this->redirect('../pages/login.php');
        }
        
        // Process
        $user = $this->userModel->findByEmail($email);
        if (!$user || !$this->userModel->verifyPassword($password, $user['mat_khau'])) {
            SessionManager::setErrors(['Email hoặc mật khẩu sai']);
            $this->redirect('../pages/login.php');
        }
        
        // Success
        SessionManager::login($user);
        $this->log('User ' . $email . ' logged in', 'info');
        $this->redirect('../pages/home.php');
    }
}
```

---

## ValidationHelper

### Static Methods

```php
use \ValidationHelper;

// ✅ Email validation
ValidationHelper::isValidEmail('test@example.com');  // true
ValidationHelper::isValidEmail('invalid');            // false

// ✅ Password validation (8+ chars, uppercase, lowercase, digit)
ValidationHelper::isStrongPassword('Pass123');        // false (7 chars)
ValidationHelper::isStrongPassword('Pass1234');       // true

// ✅ Name validation (3-255 chars, Vietnamese support)
ValidationHelper::isValidName('Nguyễn Văn A');        // true
ValidationHelper::isValidName('AB');                  // false (< 3 chars)

// ✅ Phone validation (Việt Nam)
ValidationHelper::isValidPhone('0912345678');         // true
ValidationHelper::isValidPhone('+84912345678');       // true

// ✅ Sanitize input (prevent XSS)
$clean = ValidationHelper::sanitizeInput('<script>alert("xss")</script>');
// Output: &lt;script&gt;alert("xss")&lt;/script&gt;

// ✅ Render errors as HTML
$errors = ['Email không hợp lệ', 'Mật khẩu quá yếu'];
echo ValidationHelper::renderErrors($errors);
```

### Sử Dụng Trong Controllers

```php
class RegisterController extends BaseController {
    public function register(): void {
        if (!$this->isPost()) {
            $this->redirect('../pages/register.php');
        }
        
        $email = $this->getPost('email', '');
        $password = $this->getPost('password', '');
        $phone = $this->getPost('phone', '');
        
        $errors = [];
        
        // Validate email format
        if (!ValidationHelper::isValidEmail($email)) {
            $errors[] = 'Email không đúng định dạng';
        }
        
        // Validate password strength
        if (!ValidationHelper::isStrongPassword($password)) {
            $errors[] = 'Mật khẩu phải có 8+ ký tự, chữ hoa, chữ thường, số';
        }
        
        // Validate phone (nếu nhập)
        if (!empty($phone) && !ValidationHelper::isValidPhone($phone)) {
            $errors[] = 'Số điện thoại không hợp lệ';
        }
        
        if (!empty($errors)) {
            SessionManager::setErrors($errors);
            $this->redirect('../pages/register.php');
        }
        
        // Sanitize trước khi lưu
        $cleanEmail = ValidationHelper::sanitizeInput($email);
        
        // Proceed...
    }
}
```

---

## Custom Exceptions

### Các Loại Exception

```php
use \AppException;
use \DatabaseException;
use \ValidationException;
use \AuthenticationException;
use \AuthorizationException;
```

### Cách Sử Dụng

```php
// Throw exception
try {
    if (!$user) {
        throw new AuthenticationException("Email không tồn tại");
    }
    
    if ($user['trang_thai'] === 'khoa') {
        throw new AuthorizationException("Tài khoản đã bị khóa");
    }
    
} catch (AuthenticationException $e) {
    // Xử lý lỗi xác thực
    SessionManager::setErrors([$e->getMessage()]);
    $this->redirect('../pages/login.php');
    
} catch (AuthorizationException $e) {
    // Xử lý lỗi phân quyền
    SessionManager::setErrors([$e->getMessage()]);
    $this->redirect('../pages/home.php');
    
} catch (DatabaseException $e) {
    // Xử lý lỗi database
    $this->log("Database error: " . $e->getMessage(), 'error');
    SessionManager::setErrors(["Lỗi hệ thống, vui lòng thử lại"]);
    $this->redirect('../pages/error.php');
    
} catch (AppException $e) {
    // Catch all app exceptions
    $this->log("App error: " . $e->getMessage(), 'error');
}
```

### Ví Dụ Với Model

```php
class User {
    private mysqli $conn;
    
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }
    
    public function findByEmail(string $email): ?array {
        try {
            $sql = 'SELECT * FROM nguoi_dung WHERE email = ? LIMIT 1';
            $stmt = $this->conn->prepare($sql);
            
            if (!$stmt) {
                throw new DatabaseException("Lỗi chuẩn bị câu SQL: " . $this->conn->error);
            }
            
            $stmt->bind_param('s', $email);
            
            if (!$stmt->execute()) {
                throw new DatabaseException("Lỗi thực thi câu SQL: " . $stmt->error);
            }
            
            $result = $stmt->get_result();
            $stmt->close();
            
            return $result->num_rows > 0 ? $result->fetch_assoc() : null;
            
        } catch (Exception $e) {
            throw new DatabaseException("Database error: " . $e->getMessage());
        }
    }
}
```

---

## Migration Guide

### Từ Old Style → New Style

#### 1. Headers & Redirect

```php
// ❌ OLD
header('Location: ../pages/home.php');
exit();

// ✅ NEW
$this->redirect('../pages/home.php');
```

#### 2. Request Method Check

```php
// ❌ OLD
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/form.php');
    exit();
}

// ✅ NEW
if (!$this->isPost()) {
    $this->redirect('../pages/form.php');
}
```

#### 3. Form Data Access

```php
// ❌ OLD
$email = $_POST['email'] ?? '';
$name = trim($_POST['name'] ?? '');

// ✅ NEW
$email = $this->getPost('email', '');
$name = trim($this->getPost('name', ''));
```

#### 4. Validation Helper

```php
// ❌ OLD
if (!is_valid_email($email)) {
    $errors[] = 'Email không hợp lệ';
}

// ✅ NEW
if (!ValidationHelper::isValidEmail($email)) {
    $errors[] = 'Email không hợp lệ';
}
```

#### 5. Exception Handling

```php
// ❌ OLD
if (!$user) {
    die('Lỗi: Không tìm thấy user');
}

// ✅ NEW
if (!$user) {
    throw new AuthenticationException('User không tồn tại');
}

try {
    // ...
} catch (AuthenticationException $e) {
    SessionManager::setErrors([$e->getMessage()]);
    $this->redirect('../pages/login.php');
}
```

---

## 📊 Tham Chiếu Nhanh

### BaseController Methods
| Method | Return | Use Case |
|--------|--------|----------|
| `redirect(string)` | void | Chuyển hướng trang |
| `jsonResponse(mixed, int)` | void | Gửi JSON |
| `getMethod()` | string | Lấy HTTP method |
| `isPost()` | bool | Kiểm tra POST |
| `isGet()` | bool | Kiểm tra GET |
| `getPost(key, default)` | mixed | Lấy POST data |
| `getQuery(key, default)` | mixed | Lấy GET data |
| `validate(...)` | bool | Validate field |
| `log(message, level)` | void | Ghi log |

### ValidationHelper Methods
| Method | Param | Return |
|--------|-------|--------|
| `isValidEmail(email)` | string | bool |
| `isStrongPassword(pass)` | string | bool |
| `isValidName(name)` | string | bool |
| `isValidPhone(phone)` | string | bool |
| `sanitizeInput(data)` | string | string |
| `renderErrors(errors)` | array | string |

### Custom Exceptions
- `AppException` - Base class
- `DatabaseException` - DB errors
- `ValidationException` - Validation errors
- `AuthenticationException` - Auth errors
- `AuthorizationException` - Permission errors

---

## 💡 Tips & Best Practices

1. **Luôn dùng BaseController methods** thay vì `$_POST`, `$_SERVER` trực tiếp
2. **Validate input** trước khi sử dụng
3. **Sanitize data** để tránh XSS attack
4. **Catch exceptions** ở controller level
5. **Log important events** để debug dễ hơn
6. **Redirect** thay vì `exit()` sau validate errors

---

## 📞 Liên Hệ

Để biết thêm chi tiết, tham khảo `REFACTORING_27052026.md`

Happy Coding! 🚀
