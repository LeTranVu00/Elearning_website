<?php
/**
 * ============================================================================
 * FILE: core/SessionManager.php
 * MỤC ĐÍCH: Quản lý Session theo chuẩn OOP (Static Class)
 * ============================================================================
 *
 * 📚 GIẢI THÍCH KHÁI NIỆM OOP DÙNG TRONG FILE NÀY:
 *
 * 1. STATIC CLASS:
 *    - Tất cả phương thức đều là static → không cần `new SessionManager()`
 *    - Gọi trực tiếp: SessionManager::isLoggedIn(), SessionManager::get('user_id')
 *    - Phù hợp cho các tiện ích dùng chung toàn ứng dụng như Session.
 *
 * 2. SO SÁNH VỚI CODE CŨ (Procedural):
 *    - Cũ:  is_logged_in()           → Mới: SessionManager::isLoggedIn()
 *    - Cũ:  require_login()          → Mới: SessionManager::requireLogin()
 *    - Cũ:  require_admin()          → Mới: SessionManager::requireAdmin()
 *    - Cũ:  get_current_user()       → Mới: SessionManager::getCurrentUser()
 *    - Cũ:  $_SESSION['user_id']     → Mới: SessionManager::get('user_id')
 *
 * CÁCH SỬ DỤNG:
 *   require_once '../core/SessionManager.php';
 *   SessionManager::start();          // Khởi động session
 *   SessionManager::requireLogin();   // Bảo vệ trang (chặn nếu chưa đăng nhập)
 *   $user = SessionManager::getCurrentUser(); // Lấy thông tin user hiện tại
 */

class SessionManager
{
    // =========================================================================
    // KHỞI ĐỘNG SESSION
    // =========================================================================

    /**
     * Khởi động session một cách an toàn.
     * Kiểm tra trước khi start để tránh lỗi "headers already sent".
     *
     * Gọi hàm này ở đầu mỗi trang cần sử dụng Session (đã được tích hợp sẵn
     * trong components/header.php nên các trang pages/*.php không cần gọi lại).
     */
    public static function start(): void
    {
        // Chỉ start nếu session chưa được bật
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // =========================================================================
    // KIỂM TRA TRẠNG THÁI ĐĂNG NHẬP
    // =========================================================================

    /**
     * Kiểm tra người dùng hiện tại có đang đăng nhập không.
     *
     * @return bool true = đã đăng nhập, false = chưa đăng nhập
     *
     * VÍ DỤ:
     *   if (SessionManager::isLoggedIn()) {
     *       echo "Chào " . SessionManager::get('ho_ten');
     *   }
     */
    public static function isLoggedIn(): bool
    {
        // Đảm bảo session đang chạy trước khi kiểm tra
        self::start();

        // Kiểm tra user_id có tồn tại và không rỗng trong session không
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    // =========================================================================
    // BẢO VỆ TRANG (PAGE PROTECTION)
    // =========================================================================

    /**
     * Yêu cầu người dùng PHẢI đăng nhập mới được vào trang.
     * Nếu chưa đăng nhập → tự động chuyển hướng về trang login.
     *
     * CÁCH DÙNG: Đặt ở đầu file trang cần bảo vệ:
     *   SessionManager::requireLogin();
     *
     * THƯỜNG DÙNG CHO: Trang profile, trang học bài, trang thanh toán,...
     */
    public static function requireLogin(): void
    {
        self::start();

        if (!self::isLoggedIn()) {
            // Chưa đăng nhập → chuyển về trang login
            header('Location: /webhoctap/pages/login.php');
            exit(); // Dừng thực thi code phía dưới
        }
    }

    /**
     * Yêu cầu người dùng PHẢI có quyền Admin mới được vào trang.
     * Nếu không phải admin hoặc chưa đăng nhập → chuyển về trang chủ.
     *
     * CÁCH DÙNG: Đặt ở đầu file trang Admin:
     *   SessionManager::requireAdmin();
     *
     * THƯỜNG DÙNG CHO: Trang quản trị, trang quản lý khóa học,...
     */
    public static function requireAdmin(): void
    {
        self::start();

        // Kiểm tra đồng thời: đã đăng nhập VÀ có vai trò là admin
        if (!self::isLoggedIn() || self::get('vai_tro') !== 'admin') {
            header('Location: /webhoctap/pages/home.php');
            exit();
        }
    }

    // =========================================================================
    // ĐỌC / GHI / XÓA DỮ LIỆU SESSION
    // =========================================================================

    /**
     * Lấy một giá trị từ Session.
     *
     * @param string $key Tên biến session cần lấy (vd: 'user_id', 'ho_ten')
     * @param mixed $default Giá trị mặc định nếu key không tồn tại
     * @return mixed Giá trị của biến session hoặc $default
     *
     * VÍ DỤ:
     *   $userId = SessionManager::get('user_id');
     *   $name   = SessionManager::get('ho_ten', 'Khách');
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();
        // Toán tử ?? (null coalescing): trả về $_SESSION[$key] nếu tồn tại,
        // nếu không thì trả về $default
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Ghi một giá trị vào Session.
     *
     * @param string $key   Tên biến session
     * @param mixed  $value Giá trị cần lưu
     *
     * VÍ DỤ:
     *   SessionManager::set('user_id', 42);
     *   SessionManager::set('ho_ten', 'Nguyễn Văn A');
     */
    public static function set(string $key, mixed $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Xóa một biến khỏi Session.
     *
     * @param string $key Tên biến session cần xóa
     */
    public static function remove(string $key): void
    {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    // =========================================================================
    // LẤY THÔNG TIN USER HIỆN TẠI
    // =========================================================================

    /**
     * Lấy User ID hiện tại
     * 
     * @return int|null User ID hoặc null nếu chưa đăng nhập
     */
    public static function getUserId(): ?int
    {
        return self::get('user_id');
    }

    /**
     * Lấy toàn bộ thông tin của người dùng đang đăng nhập.
     *
     * @return array|null Mảng thông tin user, hoặc null nếu chưa đăng nhập.
     *
     * VÍ DỤ:
     *   $user = SessionManager::getCurrentUser();
     *   if ($user) {
     *       echo "Xin chào " . $user['ho_ten'];
     *       echo "Vai trò: " . $user['vai_tro'];
     *   }
     */
    public static function getCurrentUser(): ?array
    {
        if (!self::isLoggedIn()) {
            return null; // Trả về null nếu chưa đăng nhập
        }

        // Trả về mảng thông tin user lấy từ session
        return [
            'id'      => self::get('user_id'),
            'ho_ten'  => self::get('ho_ten'),
            'email'   => self::get('email'),
            'vai_tro' => self::get('vai_tro'),
            'avatar'  => self::get('avatar'),
        ];
    }

    // =========================================================================
    // ĐĂNG NHẬP / ĐĂNG XUẤT
    // =========================================================================

    /**
     * Lưu thông tin user vào session khi đăng nhập thành công.
     * Được gọi bởi AuthController sau khi xác thực xong.
     *
     * @param array $user Mảng dữ liệu user lấy từ database
     */
    public static function login(array $user): void
    {
        self::start();

        // Tái tạo session ID để phòng tấn công Session Fixation
        session_regenerate_id(true);

        // Lưu từng thông tin user vào session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['ho_ten']  = $user['ho_ten'];
        $_SESSION['email']   = $user['email'];
        $_SESSION['vai_tro'] = $user['vai_tro'];
        $_SESSION['avatar']  = $user['avatar'];
    }

    /**
     * Xóa toàn bộ session khi người dùng đăng xuất.
     * Được gọi bởi LogoutController.
     */
    public static function logout(): void
    {
        self::start();

        // Xóa tất cả biến session
        $_SESSION = [];

        // Xóa cookie session trên trình duyệt
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Phá hủy hoàn toàn session
        session_destroy();
    }

    /**
     * Lưu thông báo lỗi vào session để hiển thị sau khi redirect.
     * Kỹ thuật này gọi là "Flash Message" - thông báo chỉ hiện 1 lần.
     *
     * @param array $errors Mảng các thông báo lỗi
     */
    public static function setErrors(array $errors): void
    {
        self::start();
        $_SESSION['errors'] = $errors;
    }

    /**
     * Lấy và xóa thông báo lỗi từ session (dùng 1 lần rồi biến mất).
     *
     * @return array Mảng lỗi (rỗng nếu không có lỗi)
     */
    public static function getErrors(): array
    {
        self::start();
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']); // Xóa ngay sau khi lấy
        return $errors;
    }
}
