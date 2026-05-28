<?php
/**
 * ============================================================================
 * FILE: helpers/ValidationHelper.php
 * MỤC ĐÍCH: Cung cấp các phương thức kiểm tra và xác thực dữ liệu input (OOP)
 * ============================================================================
 *
 * 📚 GIẢI THÍCH KHÁI NIỆM OOP:
 *
 * 1. STATIC CLASS:
 *    - Tất cả phương thức đều là static → không cần `new ValidationHelper()`
 *    - Gọi trực tiếp: ValidationHelper::isValidEmail($email)
 *    - Phù hợp cho các tiện ích dùng chung toàn ứng dụng.
 *
 * 2. SO SÁNH CŨ vs MỚI:
 *    - Cũ:  is_valid_email($email)           → Mới: ValidationHelper::isValidEmail($email)
 *    - Cũ:  is_strong_password($pass)        → Mới: ValidationHelper::isStrongPassword($pass)
 *    - Cũ:  is_valid_phone($phone)           → Mới: ValidationHelper::isValidPhone($phone)
 *    - Cũ:  sanitize_input($data)            → Mới: ValidationHelper::sanitizeInput($data)
 *
 * CÁCH SỬ DỤNG:
 *   require_once '../helpers/ValidationHelper.php';
 *   
 *   if (ValidationHelper::isValidEmail($email)) {
 *       echo "Email hợp lệ";
 *   }
 *   
 *   if (ValidationHelper::isStrongPassword($password)) {
 *       echo "Mật khẩu mạnh";
 *   }
 */

class ValidationHelper
{
    // =========================================================================
    // EMAIL VALIDATION
    // =========================================================================

    /**
     * Kiểm tra email có hợp lệ không
     * 
     * @param string $email Email cần kiểm tra
     * @return bool true nếu hợp lệ, false nếu không
     * 
     * VÍ DỤ:
     *   if (ValidationHelper::isValidEmail($email)) {
     *       echo "Email hợp lệ";
     *   }
     */
    public static function isValidEmail(string $email): bool
    {
        // filter_var() kiểm tra định dạng email theo chuẩn RFC 5322
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    // =========================================================================
    // PASSWORD VALIDATION
    // =========================================================================

    /**
     * Kiểm tra mật khẩu có đủ mạnh không
     * Yêu cầu:
     * - Ít nhất 8 ký tự
     * - Chứa ít nhất 1 chữ hoa
     * - Chứa ít nhất 1 chữ thường
     * - Chứa ít nhất 1 số
     * 
     * @param string $password Mật khẩu cần kiểm tra
     * @return bool true nếu mạnh, false nếu yếu
     * 
     * VÍ DỤ:
     *   if (ValidationHelper::isStrongPassword($password)) {
     *       echo "Mật khẩu mạnh";
     *   } else {
     *       echo "Mật khẩu yếu";
     *   }
     */
    public static function isStrongPassword(string $password): bool
    {
        // Kiểm tra độ dài (ít nhất 8 ký tự)
        if (strlen($password) < 8) {
            return false;
        }
        
        // Kiểm tra chứa chữ hoa (A-Z)
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }
        
        // Kiểm tra chứa chữ thường (a-z)
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }
        
        // Kiểm tra chứa số (0-9)
        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }
        
        return true;
    }

    // =========================================================================
    // NAME VALIDATION
    // =========================================================================

    /**
     * Kiểm tra tên đầy đủ có hợp lệ không
     * - Không được để trống
     * - Ít nhất 3 ký tự
     * - Tối đa 255 ký tự
     * - Chỉ chứa chữ cái, số, và một số ký tự đặc biệt
     * 
     * @param string $name Tên cần kiểm tra
     * @return bool true nếu hợp lệ, false nếu không
     */
    public static function isValidName(string $name): bool
    {
        $name = trim($name);
        
        // Kiểm tra độ dài
        if (strlen($name) < 3 || strlen($name) > 255) {
            return false;
        }
        
        // Chỉ cho phép chữ cái, số, khoảng trắng, dấu gạch ngang, dấu phẩy
        // Hỗ trợ tiếng Việt
        if (!preg_match('/^[a-zA-Z0-9\s\-,àáạảãăằắặẳẵâầấậẩẫèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]+$/u', $name)) {
            return false;
        }
        
        return true;
    }

    // =========================================================================
    // PHONE VALIDATION
    // =========================================================================

    /**
     * Kiểm tra số điện thoại có hợp lệ không
     * Format: 10 chữ số, bắt đầu từ 0 hoặc +84
     * 
     * VÍ DỤ HỢP LỆ:
     * - 0123456789
     * - +84123456789
     * 
     * @param string $phone Số điện thoại cần kiểm tra
     * @return bool true nếu hợp lệ, false nếu không
     */
    public static function isValidPhone(string $phone): bool
    {
        $phone = preg_replace('/[^0-9+]/', '', $phone);  // Loại bỏ ký tự không phải số
        
        // Kiểm tra: bắt đầu 0 có 10-11 chữ số, hoặc bắt đầu +84 có 11-12 chữ số
        if (preg_match('/^(0[0-9]{9,10}|\+84[0-9]{9,10})$/', $phone)) {
            return true;
        }
        
        return false;
    }

    // =========================================================================
    // INPUT SANITIZATION
    // =========================================================================

    /**
     * Làm sạch và escape HTML từ input
     * Tránh XSS (Cross-Site Scripting) attack
     * 
     * @param string $data Dữ liệu cần làm sạch
     * @return string Dữ liệu đã được escape
     * 
     * VÍ DỤ:
     *   $cleanName = ValidationHelper::sanitizeInput('<script>alert(1)</script>');
     *   // Kết quả: &lt;script&gt;alert(1)&lt;/script&gt;
     */
    public static function sanitizeInput(string $data): string
    {
        // trim(): Loại bỏ khoảng trắng thừa ở đầu cuối
        $data = trim($data);
        
        // stripslashes(): Loại bỏ dấu gạch chéo ngược
        $data = stripslashes($data);
        
        // htmlspecialchars(): Chuyển HTML đặc biệt ký tự thành HTML entity
        //   Ví dụ: < thành &lt;, > thành &gt;
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        
        return $data;
    }

    // =========================================================================
    // RENDER ERRORS (For Views)
    // =========================================================================

    /**
     * Lấy danh sách lỗi validation dưới dạng HTML
     * 
     * @param array $errors Mảng chứa danh sách lỗi
     * @return string HTML chứa danh sách lỗi
     */
    public static function renderErrors(array $errors): string
    {
        if (empty($errors)) {
            return '';
        }
        
        $html = '<div class="error-box" style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 15px;">';
        $html .= '<strong>❌ Có lỗi xảy ra:</strong>';
        $html .= '<ul style="margin: 10px 0; padding-left: 20px;">';
        
        foreach ($errors as $error) {
            $html .= '<li>' . htmlspecialchars($error) . '</li>';
        }
        
        $html .= '</ul>';
        $html .= '</div>';
        
        return $html;
    }
}