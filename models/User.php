<?php
/**
 * ============================================================================
 * FILE: models/User.php
 * MỤC ĐÍCH: Đại diện cho thực thể "Người dùng" và thao tác với bảng nguoi_dung
 * ============================================================================
 *
 * 📚 GIẢI THÍCH KHÁI NIỆM OOP DÙNG TRONG FILE NÀY:
 *
 * 1. MODEL trong MVC:
 *    - Model là tầng chịu trách nhiệm tất cả các thao tác với DỮ LIỆU.
 *    - Mọi câu lệnh SQL (SELECT, INSERT, UPDATE, DELETE) đều phải đặt ở đây.
 *    - Controller KHÔNG được viết SQL trực tiếp → phải gọi qua Model.
 *    - Lợi ích: Nếu đổi database (MySQL → PostgreSQL), chỉ cần sửa Model,
 *      không cần đụng vào Controller hay Views.
 *
 * 2. DEPENDENCY INJECTION (Tiêm phụ thuộc):
 *    - Thay vì User tự tạo kết nối DB bên trong, ta "tiêm" (inject) kết nối
 *      vào từ bên ngoài qua constructor.
 *    - Ưu điểm: Linh hoạt, dễ test, dễ thay thế.
 *
 * 3. TYPE HINTS & RETURN TYPES (PHP 8+):
 *    - Khai báo kiểu dữ liệu rõ ràng cho tham số và giá trị trả về.
 *    - Ví dụ: `function findByEmail(string $email): ?array`
 *      → Nhận vào string, trả về array hoặc null.
 *
 * CÁCH SỬ DỤNG:
 *   require_once '../core/Database.php';
 *   require_once '../models/User.php';
 *
 *   $userModel = new User(Database::getConnection());
 *   $user = $userModel->findByEmail('test@example.com');
 */

// Cần Database để lấy kết nối
require_once __DIR__ . '/../core/Database.php';

class User
{
    // =========================================================================
    // THUỘC TÍNH CỦA CLASS
    // =========================================================================

    /**
     * @var mysqli Đối tượng kết nối database.
     * private: Chỉ các phương thức bên trong class User mới được dùng $conn này.
     */
    private mysqli $conn;

    // =========================================================================
    // CONSTRUCTOR - Phương thức khởi tạo
    // =========================================================================

    /**
     * Khởi tạo User Model với kết nối database.
     *
     * Constructor là phương thức đặc biệt, tự động chạy khi tạo đối tượng:
     *   $userModel = new User(Database::getConnection());
     *
     * @param mysqli $conn Kết nối database được "tiêm" vào từ bên ngoài
     */
    public function __construct(mysqli $conn)
    {
        // Lưu kết nối vào thuộc tính của class để các phương thức khác dùng
        $this->conn = $conn;
        // `$this` = "chính đối tượng này" (giống như 'self' trong tiếng Anh)
    }

    // =========================================================================
    // CÁC PHƯƠNG THỨC THAO TÁC DỮ LIỆU (CRUD)
    // =========================================================================

    /**
     * Tìm kiếm một người dùng trong database bằng email.
     *
     * @param string $email Email cần tìm
     * @return array|null Mảng thông tin user nếu tìm thấy, null nếu không
     *
     * VÍ DỤ:
     *   $user = $userModel->findByEmail('admin@example.com');
     *   if ($user) {
     *       echo $user['ho_ten']; // "Nguyễn Văn A"
     *   }
     */
    public function findByEmail(string $email): ?array
    {
        // Dùng Prepared Statement để tránh SQL Injection
        // ? là placeholder - sẽ được thay thế an toàn bởi bind_param
        $sql  = 'SELECT * FROM nguoi_dung WHERE email = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return null; // Không thể chuẩn bị câu SQL
        }

        // bind_param("s", $email): Gán $email vào placeholder ?
        // "s" = string (kiểu dữ liệu của tham số)
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        // Nếu tìm thấy user, trả về dữ liệu dạng mảng kết hợp
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // ['id' => 1, 'ho_ten' => '...', ...]
        }

        return null; // Không tìm thấy
    }

    /**
     * Tìm kiếm người dùng theo ID.
     *
     * @param int $id ID của người dùng cần tìm
     * @return array|null
     */
    public function findById(int $id): ?array
    {
        $sql  = 'SELECT id, ho_ten, email, vai_tro, avatar, trang_thai FROM nguoi_dung WHERE id = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return null;
        }

        // "i" = integer (kiểu số nguyên)
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    /**
     * Kiểm tra xem email đã tồn tại trong database chưa.
     * Dùng khi đăng ký tài khoản mới.
     *
     * @param string $email Email cần kiểm tra
     * @return bool true nếu email đã tồn tại
     */
    public function emailExists(string $email): bool
    {
        $sql  = 'SELECT id FROM nguoi_dung WHERE email = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0;
    }

    /**
     * Find a user by the Google account identifier returned by OpenID Connect.
     */
    public function findByGoogleId(string $googleId): ?array
    {
        $sql = 'SELECT * FROM nguoi_dung WHERE google_id = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('s', $googleId);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    public function linkGoogleAccount(int $userId, string $googleId, string $avatar = ''): bool
    {
        $sql = 'UPDATE nguoi_dung
                SET google_id = ?, auth_provider = "google", avatar = COALESCE(NULLIF(?, ""), avatar)
                WHERE id = ?';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('ssi', $googleId, $avatar, $userId);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function createFromGoogle(array $googleUser): bool
    {
        $hoTen = $googleUser['name'] ?? $googleUser['email'];
        $email = $googleUser['email'];
        $googleId = $googleUser['google_id'];
        $avatar = $googleUser['avatar'] ?? '';

        $sql = 'INSERT INTO nguoi_dung
                    (ho_ten, email, avatar, vai_tro, trang_thai, google_id, auth_provider)
                VALUES (?, ?, ?, "user", "hoat_dong", ?, "google")';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('ssss', $hoTen, $email, $avatar, $googleId);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}
