<?php
/**
 * ============================================================================
 * FILE: core/Exceptions.php
 * MỤC ĐÍCH: Định nghĩa các Custom Exceptions cho ứng dụng
 * ============================================================================
 *
 * Custom Exceptions được dùng để xác định các tình huống lỗi cụ thể
 * trong ứng dụng, giúp xử lý lỗi một cách chi tiết và rõ ràng.
 *
 * CÁCH SỬ DỤNG:
 *   try {
 *       $user = $userModel->findByEmail($email);
 *       if (!$user) {
 *           throw new ValidationException("Email không hợp lệ");
 *       }
 *   } catch (ValidationException $e) {
 *       echo "Lỗi validation: " . $e->getMessage();
 *   } catch (DatabaseException $e) {
 *       echo "Lỗi database: " . $e->getMessage();
 *   }
 */

/**
 * Exception cơ sở cho ứng dụng
 * Tất cả các exception khác kế thừa từ class này
 */
class AppException extends Exception {}

/**
 * Exception cho các lỗi liên quan đến Database
 * Được ném khi:
 * - Kết nối database thất bại
 * - Câu lệnh SQL lỗi
 * - Truy vấn không thành công
 *
 * VÍ DỤ:
 *   throw new DatabaseException("Không thể kết nối database");
 */
class DatabaseException extends AppException {}

/**
 * Exception cho các lỗi Validation (kiểm tra dữ liệu)
 * Được ném khi:
 * - Email không hợp lệ
 * - Mật khẩu không đủ mạnh
 * - Dữ liệu không đúng định dạng
 * - Dữ liệu bị trùng (email, username)
 *
 * VÍ DỤ:
 *   throw new ValidationException("Email không đúng định dạng");
 */
class ValidationException extends AppException {}

/**
 * Exception cho các lỗi Authentication (xác thực)
 * Được ném khi:
 * - Email không tồn tại
 * - Mật khẩu sai
 * - Tài khoản bị khóa
 *
 * VÍ DỤ:
 *   throw new AuthenticationException("Email hoặc mật khẩu không chính xác");
 */
class AuthenticationException extends AppException {}

/**
 * Exception cho các lỗi Authorization (phân quyền)
 * Được ném khi:
 * - Người dùng không có quyền truy cập
 * - Tài khoản không có vai trò admin
 *
 * VÍ DỤ:
 *   throw new AuthorizationException("Bạn không có quyền truy cập trang này");
 */
class AuthorizationException extends AppException {}
