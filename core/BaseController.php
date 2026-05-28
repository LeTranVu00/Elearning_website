<?php
/**
 * ============================================================================
 * FILE: core/BaseController.php
 * MỤC ĐÍCH: Abstract Base Controller - Lớp cơ sở cho tất cả Controllers
 * ============================================================================
 *
 * 📚 GIẢI THÍCH KHÁI NIỆM OOP:
 *
 * 1. ABSTRACT CLASS (Lớp Trừu Tượng):
 *    - Không thể tạo đối tượng trực tiếp từ abstract class
 *    - Các class khác phải kế thừa (extends) nó
 *    - Dùng để định nghĩa "hợp đồng" chung cho các class con
 *
 * 2. INHERITANCE (Kế Thừa):
 *    - AuthController extends BaseController
 *    - RegisterController extends BaseController
 *    - Các Controller con kế thừa các phương thức chung từ BaseController
 *
 * 3. SINGLE RESPONSIBILITY:
 *    - BaseController chỉ chứa logic chung (redirect, response, etc)
 *    - Các Controller con chứa logic riêng (login, register, etc)
 *
 * CÁCH SỬ DỤNG:
 *   class AuthController extends BaseController {
 *       public function login(): void {
 *           // ...
 *           $this->redirect('../pages/home.php');  // Dùng phương thức chung từ BaseController
 *       }
 *   }
 */

require_once __DIR__ . '/Exceptions.php';

abstract class BaseController
{
    // =========================================================================
    // PROTECTED METHODS - Các phương thức dùng chung cho các Controller con
    // =========================================================================

    /**
     * Chuyển hướng (redirect) trang web.
     * Là wrapper tiện lợi cho header('Location: ...')
     *
     * @param string $url Đường dẫn cần chuyển hướng tới
     * @return void
     *
     * VÍ DỤ:
     *   $this->redirect('../pages/home.php');
     *   $this->redirect('/webhoctap/pages/login.php');
     */
    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit();
    }

    /**
     * Gửi JSON response (dùng cho API)
     * Thường dùng nếu ứng dụng có API endpoints
     *
     * @param mixed $data Dữ liệu cần gửi (sẽ convert thành JSON)
     * @param int $statusCode HTTP status code (200, 400, 401, 500, etc)
     * @return void
     *
     * VÍ DỤ:
     *   $this->jsonResponse(['success' => true, 'message' => 'Đăng nhập thành công'], 200);
     *   $this->jsonResponse(['error' => 'Email hoặc mật khẩu sai'], 401);
     */
    protected function jsonResponse(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit();
    }

    /**
     * Lấy request method (GET, POST, PUT, DELETE)
     *
     * @return string Phương thức HTTP
     *
     * VÍ DỤ:
     *   if ($this->getMethod() === 'POST') {
     *       // Xử lý POST request
     *   }
     */
    protected function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    /**
     * Kiểm tra có phải POST request không
     *
     * @return bool
     */
    protected function isPost(): bool
    {
        return $this->getMethod() === 'POST';
    }

    /**
     * Kiểm tra có phải GET request không
     *
     * @return bool
     */
    protected function isGet(): bool
    {
        return $this->getMethod() === 'GET';
    }

    /**
     * Lấy giá trị từ $_POST
     *
     * @param string $key Tên biến POST
     * @param mixed $default Giá trị mặc định nếu không tồn tại
     * @return mixed
     *
     * VÍ DỤ:
     *   $email = $this->getPost('email');
     *   $name = $this->getPost('name', 'Khách');
     */
    protected function getPost(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $default;
    }

    /**
     * Lấy giá trị từ $_GET
     *
     * @param string $key Tên biến GET
     * @param mixed $default Giá trị mặc định nếu không tồn tại
     * @return mixed
     */
    protected function getQuery(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }

    /**
     * Validate dữ liệu POST
     * Nếu không hợp lệ → thêm lỗi vào mảng
     *
     * @param string $field Tên field
     * @param mixed $value Giá trị cần validate
     * @param string $rule Quy tắc validation (required, email, min:3, max:100)
     * @param array &$errors Tham chiếu mảng lỗi (sẽ được update)
     * @return bool true nếu hợp lệ, false nếu không
     *
     * VÍ DỤ:
     *   $errors = [];
     *   $this->validate('email', $email, 'required|email', $errors);
     *   $this->validate('name', $name, 'required|min:3|max:255', $errors);
     *
     *   if (!empty($errors)) {
     *       SessionManager::setErrors($errors);
     *       $this->redirect('../pages/form.php');
     *   }
     */
    protected function validate(string $field, mixed $value, string $rule, array &$errors): bool
    {
        $rules = explode('|', $rule);
        $isValid = true;

        foreach ($rules as $r) {
            if ($r === 'required') {
                if (empty($value)) {
                    $errors[] = "❌ $field không được để trống";
                    $isValid = false;
                }
            } elseif (strpos($r, 'min:') === 0) {
                $min = (int)substr($r, 4);
                if (strlen($value) < $min) {
                    $errors[] = "❌ $field phải ít nhất $min ký tự";
                    $isValid = false;
                }
            } elseif (strpos($r, 'max:') === 0) {
                $max = (int)substr($r, 4);
                if (strlen($value) > $max) {
                    $errors[] = "❌ $field không được vượt quá $max ký tự";
                    $isValid = false;
                }
            } elseif ($r === 'email') {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "❌ $field không đúng định dạng email";
                    $isValid = false;
                }
            }
        }

        return $isValid;
    }

    /**
     * Log thông báo (để debug)
     * Dùng khi cần ghi lại các sự kiện trong ứng dụng
     *
     * @param string $message Thông báo cần ghi
     * @param string $level Level log (info, warning, error)
     * @return void
     *
     * VÍ DỤ:
     *   $this->log('Người dùng đăng nhập: ' . $email, 'info');
     *   $this->log('Lỗi database: ' . $error, 'error');
     */
    protected function log(string $message, string $level = 'info'): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] [$level] $message\n";
        
        // Ghi vào file logs (nếu có)
        // error_log($logMessage, 3, '../logs/app.log');
        
        // Hoặc ghi vào error_log của PHP
        error_log($logMessage);
    }
}
