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
        // Chỉ xử lý nếu request là POST (form được submit)
        if (!$this->isPost()) {
            // Nếu ai đó truy cập file này trực tiếp (GET) → về trang login
            $this->redirect('../pages/login.php');
        }

        // =====================================================================
        // BƯỚC 1: LẤY VÀ LÀM SẠCH DỮ LIỆU TỪ FORM
        // =====================================================================
        // trim() xóa khoảng trắng thừa ở đầu và cuối chuỗi
        // ?? '' : nếu không có dữ liệu POST thì dùng chuỗi rỗng
        $email    = trim($this->getPost('email', ''));
        $password = trim($this->getPost('password', ''));

        // Mảng chứa các thông báo lỗi validation
        $errors = [];

        // =====================================================================
        // BƯỚC 2: VALIDATION - Kiểm tra dữ liệu đầu vào
        // =====================================================================
        if (empty($email)) {
            $errors[] = '❌ Email không được để trống';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // filter_var kiểm tra định dạng email có hợp lệ không
            $errors[] = '❌ Email không đúng định dạng';
        }

        if (empty($password)) {
            $errors[] = '❌ Mật khẩu không được để trống';
        }

        // Nếu có lỗi validation → lưu lỗi vào session và quay lại trang login
        if (!empty($errors)) {
            SessionManager::setErrors($errors);
            $this->redirect('../pages/login.php');
        }

        // =====================================================================
        // BƯỚC 3: TÌM KIẾM NGƯỜI DÙNG TRONG DATABASE (qua User Model)
        // =====================================================================
        // Gọi phương thức của User Model - Controller không tự query SQL!
        $user = $this->userModel->findByEmail($email);

        // =====================================================================
        // BƯỚC 4: XÁC MINH MẬT KHẨU VÀ TRẠNG THÁI TÀI KHOẢN
        // =====================================================================
        if ($user === null) {
            // Không tìm thấy email trong database
            // Trả về thông báo chung (không tiết lộ email có tồn tại hay không)
            $errors[] = '❌ Email hoặc mật khẩu không chính xác';
        } elseif (!$this->userModel->verifyPassword($password, $user['mat_khau'])) {
            // Tìm thấy user nhưng mật khẩu sai
            $errors[] = '❌ Email hoặc mật khẩu không chính xác';
        } elseif ($user['trang_thai'] === 'khoa') {
            // Tài khoản bị khóa bởi admin
            $errors[] = '❌ Tài khoản của bạn đã bị khóa. Vui lòng liên hệ hỗ trợ.';
        }

        // Nếu có lỗi xác thực → quay lại trang login với thông báo lỗi
        if (!empty($errors)) {
            SessionManager::setErrors($errors);
            $this->redirect('../pages/login.php');
        }

        // =====================================================================
        // BƯỚC 5: ĐĂNG NHẬP THÀNH CÔNG → Tạo Session
        // =====================================================================
        // Gọi SessionManager::login() để lưu thông tin user vào session
        SessionManager::login($user);

        // Chuyển hướng người dùng về trang chủ sau khi đăng nhập thành công
        $this->redirect('../pages/home.php');
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
