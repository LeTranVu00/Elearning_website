<?php
/**
 * ============================================================================
 * FILE: controllers/RegisterController.php
 * MỤC ĐÍCH: Xử lý logic đăng ký tài khoản theo chuẩn OOP
 * ============================================================================
 *
 * 📚 LUỒNG HOẠT ĐỘNG:
 *    Form register (pages/register.php)
 *      ↓ POST request (ho_ten, email, phone, password, confirm_password)
 *    RegisterController::register()
 *      ↓ Validate input
 *    Kiểm tra email đã tồn tại? (User::emailExists)
 *      ↓ Tạo tài khoản (User::create)
 *    SessionManager::login()
 *      ↓ Đăng nhập ngay sau khi đăng ký
 *    Redirect → pages/home.php
 */

// Nạp các Class cần thiết
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/SessionManager.php';
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/User.php';

class RegisterController extends BaseController
{
    // =========================================================================
    // THUỘC TÍNH
    // =========================================================================

    /**
     * @var User Đối tượng User Model - dùng để thao tác dữ liệu user.
     */
    private User $userModel;

    // =========================================================================
    // CONSTRUCTOR
    // =========================================================================

    /**
     * Khởi tạo Controller với User Model được inject từ bên ngoài.
     *
     * @param User $userModel Đối tượng User Model
     */
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    // =========================================================================
    // PHƯƠNG THỨC XỬ LÝ ĐĂNG KÝ
    // =========================================================================

    /**
     * Xử lý toàn bộ quy trình đăng ký tài khoản.
     * Chỉ chạy khi nhận được request POST từ form register.
     */
    public function register(): void
    {
        SessionManager::setErrors([
            'Hệ thống hiện chỉ hỗ trợ đăng ký bằng Google.',
        ]);
        $this->redirect('../controllers/GoogleAuthController.php');
    }
}

// ============================================================================
// KHỞI CHẠY CONTROLLER
// ============================================================================
// Tạo đối tượng RegisterController và gọi phương thức register()
(new RegisterController(
    new User(Database::getConnection())
))->register();
