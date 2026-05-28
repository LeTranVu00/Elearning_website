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
     * Tạo tài khoản người dùng mới.
     *
     * @param string $hoTen    Họ tên đầy đủ
     * @param string $email    Email (dùng để đăng nhập)
     * @param string $password Mật khẩu PLAIN TEXT (sẽ tự động hash)
     * @param string $vaiTro   Vai trò: 'user' hoặc 'admin'
     * @return bool true nếu tạo thành công
     *
     * VÍ DỤ:
     *   $success = $userModel->create('Nguyễn Văn A', 'a@example.com', 'Pass123', 'user');
     */
    public function create(string $hoTen, string $email, string $password, string $vaiTro = 'user'): bool
    {
        // Luôn hash mật khẩu trước khi lưu vào database!
        // password_hash() dùng thuật toán bcrypt - rất an toàn
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = 'INSERT INTO nguoi_dung (ho_ten, email, mat_khau, vai_tro, trang_thai) VALUES (?, ?, ?, ?, "hoat_dong")';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        // "ssss" = 4 tham số kiểu string
        $stmt->bind_param('ssss', $hoTen, $email, $hashedPassword, $vaiTro);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Xác minh mật khẩu người dùng nhập vào có khớp với hash trong DB không.
     * Wrapper tiện lợi cho hàm password_verify() của PHP.
     *
     * @param string $plainPassword  Mật khẩu người dùng vừa nhập (chưa hash)
     * @param string $hashedPassword Hash mật khẩu lấy từ database
     * @return bool true nếu mật khẩu đúng
     */
    public function verifyPassword(string $plainPassword, string $hashedPassword): bool
    {
        // password_verify() tự động so sánh plain text với hash
        // Không bao giờ tự decrypt hash - PHP làm việc này một chiều!
        return password_verify($plainPassword, $hashedPassword);
    }
}
