<?php
/**
 * ============================================================================
 * FILE: controllers/AuthController.php
 * MỤC ĐÍCH: Xử lý logic đăng nhập theo chuẩn OOP
 * ============================================================================
 *
 * 📚 GIẢI THÍCH KHÁI NIỆM OOP DÙNG TRONG FILE NÀY:
 *
 * 1. CONTROLLER trong MVC:
 *    - Controller = "người điều phối" giữa Model và View.
 *    - Nhận dữ liệu từ Form (View) → Nhờ Model xử lý → Trả kết quả về View.
 *    - Controller KHÔNG tự query database, KHÔNG tự render HTML.
 *
 * 2. DEPENDENCY INJECTION qua Constructor:
 *    - Thay vì tự kết nối DB, Controller nhận sẵn Model từ bên ngoài.
 *    - `new AuthController(new User(...))` → "tiêm" User model vào.
 *
 * 3. LUỒNG HOẠT ĐỘNG:
 *    Form login (pages/login.php)
 *      ↓ POST request
 *    AuthController::login()
 *      ↓ validate input
 *    User::findByEmail() + User::verifyPassword()
 *      ↓ kết quả
 *    SessionManager::login() hoặc SessionManager::setErrors()
 *      ↓ redirect
 *    pages/home.php hoặc pages/login.php
 */

// Nạp các Class cần thiết
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/SessionManager.php';
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends BaseController
{
    // =========================================================================
    // THUỘC TÍNH
    // =========================================================================

    /**
     * @var User Đối tượng User Model - dùng để truy vấn dữ liệu người dùng.
     * private: Controller khác không thể truy cập thuộc tính này.
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
    // PHƯƠNG THỨC XỬ LÝ ĐĂNG NHẬP
    // =========================================================================

    /**
     * Xử lý toàn bộ quy trình đăng nhập.
     * Chỉ chạy khi nhận được request POST từ form login.
     */
    public function login(): void
    {
        SessionManager::setErrors([
            'Hệ thống hiện chỉ hỗ trợ đăng nhập bằng Google.',
        ]);
        $this->redirect('../controllers/GoogleAuthController.php');
    }
}

// ============================================================================
// KHỞI CHẠY CONTROLLER
// ============================================================================
// Dòng này tạo đối tượng AuthController và gọi phương thức login().
// Đây là điểm khởi đầu khi file này được trình duyệt gọi tới.
//
// Lưu ý cách tạo đối tượng: new AuthController(new User(...))
//   → Tạo User Model trước → Inject vào AuthController → Gọi login()
//   Đây chính là Dependency Injection!
(new AuthController(
    new User(Database::getConnection())
))->login();
