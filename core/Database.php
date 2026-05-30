<?php
/**
 * ============================================================================
 * FILE: core/Database.php
 * MỤC ĐÍCH: Quản lý kết nối Database theo chuẩn OOP (Singleton Pattern)
 * ============================================================================
 *
 * 📚 GIẢI THÍCH KHÁI NIỆM OOP DÙNG TRONG FILE NÀY:
 *
 * 1. CLASS (Lớp):
 *    - Là một "bản thiết kế" (blueprint) để tạo ra các đối tượng.
 *    - Giống như bản vẽ kỹ thuật của một cái xe - bản vẽ không phải là xe,
 *      nhưng từ bản vẽ đó ta có thể sản xuất ra nhiều chiếc xe.
 *
 * 2. SINGLETON PATTERN (Mẫu thiết kế Singleton):
 *    - Đảm bảo rằng một Class chỉ được tạo ra DUY NHẤT 1 đối tượng (instance)
 *      trong toàn bộ vòng đời của ứng dụng.
 *    - Ứng dụng vào Database: Dù bạn gọi "kết nối DB" ở 10 file khác nhau,
 *      hệ thống chỉ thực sự kết nối 1 lần. Tiết kiệm tài nguyên server!
 *    - Thực hiện bằng cách: private constructor + static instance + getInstance()
 *
 * 3. STATIC METHOD/PROPERTY:
 *    - Thuộc về Class, không thuộc về một đối tượng cụ thể nào.
 *    - Gọi bằng dấu `::` thay vì `->`. Ví dụ: Database::getConnection()
 *    - Không cần tạo đối tượng (`new Database()`) trước khi gọi.
 *
 * 4. ACCESS MODIFIERS (Phạm vi truy cập):
 *    - public:  Ai cũng có thể truy cập từ bên ngoài Class.
 *    - private: Chỉ code bên TRONG Class này mới truy cập được.
 *    - protected: Class này và các Class con (kế thừa) mới truy cập được.
 *
 * CÁCH SỬ DỤNG:
 *   require_once '../core/Database.php';
 *   $conn = Database::getConnection(); // Lấy kết nối duy nhất
 */

class Database
{
    // =========================================================================
    // THUỘC TÍNH (PROPERTIES) CỦA CLASS
    // =========================================================================

    /**
     * @var string Thông tin kết nối database - được khai báo là private
     * để bên ngoài không thể đọc hay thay đổi trực tiếp.
     * Bảo mật thông tin nhạy cảm!
     */
    private static string $host = '127.0.0.1';
    private static string $user = 'root';
    private static string $pass = '';
    private static string $name = 'web_hoc_truc_tuyen';

    /**
     * @var mysqli|null Biến lưu trữ đối tượng kết nối duy nhất.
     * static: biến này thuộc về Class, được chia sẻ cho tất cả mọi lời gọi.
     * Lúc đầu = null vì chưa kết nối.
     */
    private static ?mysqli $instance = null;

    // =========================================================================
    // PRIVATE CONSTRUCTOR - Trái tim của Singleton Pattern
    // =========================================================================

    /**
     * Constructor được đặt là private để NGĂN bên ngoài tạo đối tượng
     * bằng lệnh `new Database()`.
     *
     * Bên ngoài Class muốn lấy kết nối phải dùng: Database::getConnection()
     * Đây chính là cách Singleton hoạt động!
     */
    private function __construct()
    {
        // Constructor rỗng - không làm gì cả.
        // Mục đích chỉ là để ngăn gọi `new Database()` từ bên ngoài.
    }

    // =========================================================================
    // PUBLIC STATIC METHODS - Các phương thức của Class
    // =========================================================================

    /**
     * Phương thức chính để lấy (hoặc tạo mới) kết nối database.
     *
     * LOGIC HOẠT ĐỘNG:
     *   - Lần 1 gọi: self::$instance == null → Tạo kết nối mới → Lưu vào $instance
     *   - Lần 2, 3... gọi: self::$instance đã có → Trả về kết nối CŨ luôn
     *   → Chỉ kết nối MySQL đúng 1 lần!
     *
     * @return mysqli Đối tượng kết nối MySQL có thể dùng để query ngay.
     */
    public static function getConnection(): mysqli
    {
        // Kiểm tra xem kết nối đã tồn tại chưa
        if (self::$instance === null) {
            // Chưa có kết nối → Tạo kết nối mới
            try {
                // Tạo đối tượng kết nối MySQLi
                $conn = new mysqli(
                    '127.0.0.1',
                    'root',
                    '',
                    'web_hoc_truc_tuyen',
                    3306
                );

                // Kiểm tra xem kết nối có thành công không
                if ($conn->connect_error) {
                    // Ném ra ngoại lệ (Exception) nếu kết nối thất bại
                    throw new RuntimeException(
                        '❌ Kết nối database thất bại: ' . $conn->connect_error
                    );
                }

                // Thiết lập charset UTF-8 để hỗ trợ tiếng Việt
                $conn->set_charset('utf8mb4');

                // Lưu kết nối vào biến static để tái sử dụng
                self::$instance = $conn;

            } catch (Exception $e) {
                // Nếu có lỗi bất ngờ, dừng ứng dụng và thông báo
                die('❌ Lỗi hệ thống Database: ' . $e->getMessage());
            }
        }

        // Trả về kết nối (dù là mới tạo hay đã có sẵn)
        return self::$instance;
    }

    /**
     * Đóng kết nối database khi không còn cần thiết nữa.
     * Thường được gọi ở cuối vòng đời ứng dụng (hoặc sau khi xử lý xong).
     */
    public static function closeConnection(): void
    {
        if (self::$instance !== null) {
            self::$instance->close(); // Đóng kết nối MySQL
            self::$instance = null;   // Reset về null để có thể kết nối lại nếu cần
        }
    }
}
