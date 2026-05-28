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
        // Chỉ xử lý nếu request là POST (form được submit)
        if (!$this->isPost()) {
            // Nếu ai đó truy cập file này trực tiếp (GET) → về trang register
            $this->redirect('../pages/register.php');
        }

        // =====================================================================
        // BƯỚC 1: LẤY VÀ LÀM SẠCH DỮ LIỆU TỪ FORM
        // =====================================================================
        $hoTen            = trim($this->getPost('ho_ten', ''));
        $email            = trim($this->getPost('email', ''));
        $soDienThoai      = trim($this->getPost('so_dien_thoai', ''));
        $password         = $this->getPost('password', ''); // Không trim mật khẩu vì có thể chứa space ý định
        $confirmPassword  = $this->getPost('confirm_password', '');

        // Mảng chứa các thông báo lỗi validation
        $errors = [];

        // =====================================================================
        // BƯỚC 2: VALIDATION - Kiểm tra dữ liệu đầu vào
        // =====================================================================

        // Kiểm tra họ tên
        if (empty($hoTen)) {
            $errors[] = '❌ Họ tên không được để trống';
        } elseif (strlen($hoTen) < 3) {
            $errors[] = '❌ Họ tên phải ít nhất 3 ký tự';
        } elseif (strlen($hoTen) > 255) {
            $errors[] = '❌ Họ tên không được vượt quá 255 ký tự';
        }

        // Kiểm tra email
        if (empty($email)) {
            $errors[] = '❌ Email không được để trống';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = '❌ Email không đúng định dạng';
        } elseif ($this->userModel->emailExists($email)) {
            // Kiểm tra email có bị trùng không
            $errors[] = '❌ Email này đã được đăng ký';
        }

        // Kiểm tra số điện thoại (nếu nhập)
        if (!empty($soDienThoai)) {
            // Số điện thoại Việt: bắt đầu bằng 0, 10 chữ số
            if (!preg_match('/^0\d{9}$/', $soDienThoai)) {
                $errors[] = '❌ Số điện thoại không hợp lệ (định dạng: 0xxxxxxxxx)';
            }
        }

        // Kiểm tra mật khẩu
        if (empty($password)) {
            $errors[] = '❌ Mật khẩu không được để trống';
        } elseif (strlen($password) < 6) {
            $errors[] = '❌ Mật khẩu phải ít nhất 6 ký tự';
        } elseif (strlen($password) > 255) {
            $errors[] = '❌ Mật khẩu không được vượt quá 255 ký tự';
        }

        // Kiểm tra xác nhận mật khẩu
        if (empty($confirmPassword)) {
            $errors[] = '❌ Vui lòng xác nhận mật khẩu';
        } elseif ($password !== $confirmPassword) {
            // Hai mật khẩu phải khớp
            $errors[] = '❌ Mật khẩu xác nhận không khớp';
        }

        // Nếu có lỗi validation → quay lại trang register với thông báo lỗi
        if (!empty($errors)) {
            SessionManager::setErrors($errors);
            $this->redirect('../pages/register.php');
        }

        // =====================================================================
        // BƯỚC 3: TẠO TÀI KHOẢN MỚI (qua User Model)
        // =====================================================================
        $success = $this->userModel->create(
            $hoTen,
            $email,
            $password,
            'user' // Vai trò mặc định: 'user' (không phải admin)
        );

        // Nếu tạo tài khoản thất bại
        if (!$success) {
            $errors[] = '❌ Có lỗi xảy ra khi tạo tài khoản. Vui lòng thử lại!';
            SessionManager::setErrors($errors);
            $this->redirect('../pages/register.php');
        }

        // =====================================================================
        // BƯỚC 4: LẤY THÔNG TIN USER VỪA TẠO VÀ ĐĂNG NHẬP NGAY
        // =====================================================================
        // Tìm lấy thông tin user vừa tạo để lưu vào session
        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            // Không tìm thấy (lỗi bất thường)
            $errors[] = '❌ Không thể lấy thông tin tài khoản';
            SessionManager::setErrors($errors);
            $this->redirect('../pages/register.php');
        }

        // =====================================================================
        // BƯỚC 5: ĐĂNG NHẬP THÀNH CÔNG → Tạo Session
        // =====================================================================
        SessionManager::login($user);

        // Chuyển hướng người dùng về trang chủ sau khi đăng ký + đăng nhập thành công
        $this->redirect('../pages/home.php');
    }
}

// ============================================================================
// KHỞI CHẠY CONTROLLER
// ============================================================================
// Tạo đối tượng RegisterController và gọi phương thức register()
(new RegisterController(
    new User(Database::getConnection())
))->register();
