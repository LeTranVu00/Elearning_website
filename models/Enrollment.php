<?php
/**
 * ============================================================================
 * FILE: models/Enrollment.php
 * MỤC ĐÍCH: Quản lý đăng ký khóa học (enrollments) – tạo, lấy, cập nhật tiến độ
 * ============================================================================
 */

require_once __DIR__ . '/../core/Database.php';

class Enrollment
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Đăng ký user cho 1 khóa học (sau khi thanh toán thành công)
     *
     * @param int $userId ID người dùng
     * @param int $courseId ID khóa học
     * @return bool
     */
    public function enroll(int $userId, int $courseId): bool
    {
        $sql = 'INSERT INTO dang_ky_khoa_hoc (user_id, khoa_hoc_id, trang_thai) VALUES (?, ?, "learning")';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('ii', $userId, $courseId);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Kiểm tra user đã đăng ký khóa học chưa
     *
     * @param int $userId ID người dùng
     * @param int $courseId ID khóa học
     * @return bool true nếu đã đăng ký
     */
    public function isEnrolled(int $userId, int $courseId): bool
    {
        $sql = 'SELECT id FROM dang_ky_khoa_hoc WHERE user_id = ? AND khoa_hoc_id = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('ii', $userId, $courseId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0;
    }

    /**
     * Lấy tất cả khóa học user đã đăng ký
     *
     * @param int $userId ID người dùng
     * @return array Mảng thông tin khóa học đã đăng ký
     */
    public function getCoursesByUser(int $userId): array
    {
        $sql = 'SELECT dang_ky_khoa_hoc.*, khoa_hoc.ten_khoa_hoc, khoa_hoc.gia_tien 
                FROM dang_ky_khoa_hoc 
                LEFT JOIN khoa_hoc ON dang_ky_khoa_hoc.khoa_hoc_id = khoa_hoc.id 
                WHERE dang_ky_khoa_hoc.user_id = ? 
                ORDER BY dang_ky_khoa_hoc.dang_ky_luc DESC';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $courses = [];
        while ($row = $result->fetch_assoc()) {
            $courses[] = $row;
        }

        return $courses;
    }

    /**
     * Cập nhật tiến độ khóa học
     *
     * @param int $userId ID người dùng
     * @param int $courseId ID khóa học
     * @param int $progress Tiến độ (0-100)
     * @return bool
     */
    public function updateProgress(int $userId, int $courseId, int $progress): bool
    {
        $sql = 'UPDATE dang_ky_khoa_hoc SET tien_do = ? WHERE user_id = ? AND khoa_hoc_id = ?';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('iii', $progress, $userId, $courseId);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Đánh dấu khóa học đã hoàn thành
     *
     * @param int $userId ID người dùng
     * @param int $courseId ID khóa học
     * @return bool
     */
    public function markCompleted(int $userId, int $courseId): bool
    {
        $sql = 'UPDATE dang_ky_khoa_hoc 
                SET trang_thai = "completed", tien_do = 100, hoan_thanh_luc = NOW() 
                WHERE user_id = ? AND khoa_hoc_id = ?';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('ii', $userId, $courseId);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Lấy thông tin 1 enrollment
     *
     * @param int $userId ID người dùng
     * @param int $courseId ID khóa học
     * @return array|null
     */
    public function findByUserAndCourse(int $userId, int $courseId): ?array
    {
        $sql = 'SELECT * FROM dang_ky_khoa_hoc WHERE user_id = ? AND khoa_hoc_id = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('ii', $userId, $courseId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }
}
