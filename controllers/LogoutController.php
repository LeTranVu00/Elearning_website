<?php
/**
 * ============================================================================
 * FILE: controllers/LogoutController.php
 * MỤC ĐÍCH: Xử lý logic đăng xuất theo chuẩn OOP
 * ============================================================================
 *
 * 📚 GIẢI THÍCH:
 * - Class này chỉ có 1 phương thức duy nhất là logout().
 * - Ủy thác toàn bộ việc xóa session cho SessionManager::logout()
 *   → Tuân thủ nguyên tắc Single Responsibility (mỗi class chỉ làm 1 việc).
 * - Controller không tự xóa $_SESSION trực tiếp → đây là nhiệm vụ của SessionManager.
 *
 * ĐƯỢC GỌI TỪ: <a href="../controllers/LogoutController.php">Đăng xuất</a>
 */

require_once __DIR__ . '/../core/SessionManager.php';
require_once __DIR__ . '/../core/BaseController.php';

class LogoutController extends BaseController
{
    /**
     * Thực hiện đăng xuất: Xóa session và chuyển hướng về trang login.
     *
     * Quy trình:
     *   1. Gọi SessionManager::logout() để xóa toàn bộ session & cookie
     *   2. Redirect người dùng về trang đăng nhập
     */
    public function logout(): void
    {
        // Ủy thác việc xóa session cho SessionManager (Đây là OOP thuần túy!)
        // LogoutController không cần biết chi tiết $_SESSION hoạt động như thế nào
        SessionManager::logout();

        // Sau khi đăng xuất → chuyển về trang login
        $this->redirect('../pages/login.php');
    }
}

// ============================================================================
// KHỞI CHẠY CONTROLLER
// ============================================================================
(new LogoutController())->logout();
