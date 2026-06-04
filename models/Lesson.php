<?php
/**
 * ============================================================================
 * FILE: models/Lesson.php
 * MỤC ĐÍCH: Đại diện cho thực thể "Bài học" và thao tác với bảng bai_hoc & tai_lieu_bai_hoc
 * ============================================================================
 *
 * CHỨC NĂNG CHÍNH:
 * - Lấy danh sách bài học theo khóa học
 * - Tạo, cập nhật, xóa bài học
 * - Quản lý tài liệu (file, link) của bài học
 * - Tổ chức bài học theo chương
 */

require_once __DIR__ . '/../core/Database.php';

class Lesson
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    // =========================================================================
    // LẤY DANH SÁCH BÀI HỌC
    // =========================================================================

    /**
     * Lấy tất cả bài học của một khóa học
     * @param int $courseId ID của khóa học
     * @return array Mảng bài học
     */
    public function getLessonsByCourse(int $courseId): array
    {
        $sql = 'SELECT * FROM bai_hoc WHERE khoa_hoc_id = ? AND trang_thai = "hien" ORDER BY thu_tu ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $courseId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Lấy tất cả bài học của một chương
     * @param int $chapterId ID của chương
     * @return array Mảng bài học
     */
    public function getLessonsByChapter(int $chapterId): array
    {
        $sql = 'SELECT * FROM bai_hoc WHERE chuong_id = ? AND trang_thai = "hien" ORDER BY thu_tu ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $chapterId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Lấy chi tiết một bài học
     * @param int $lessonId ID của bài học
     * @return array|null Thông tin bài học hoặc null
     */
    public function getLessonById(int $lessonId): ?array
    {
        $sql = 'SELECT * FROM bai_hoc WHERE id = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $lessonId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }

    // =========================================================================
    // TẠO BÀI HỌC
    // =========================================================================

    /**
     * Tạo bài học mới
     * @param int $courseId ID khóa học
     * @param int|null $chapterId ID chương (nếu có)
     * @param string $title Tiêu đề bài học
     * @param string $content Nội dung bài học
     * @param int $order Thứ tự hiển thị
     * @return int|false ID bài học được tạo hoặc false
     */
    public function createLesson(int $courseId, ?int $chapterId, string $title, string $content, int $order = 0)
    {
        $sql = 'INSERT INTO bai_hoc (khoa_hoc_id, chuong_id, tieu_de, noi_dung, thu_tu, trang_thai, created_at) 
                VALUES (?, ?, ?, ?, ?, "hien", NOW())';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iissi', $courseId, $chapterId, $title, $content, $order);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }

    // =========================================================================
    // CẬP NHẬT BÀI HỌC
    // =========================================================================

    /**
     * Cập nhật thông tin bài học
     * @param int $lessonId ID bài học
     * @param array $data Dữ liệu cần cập nhật
     * @return bool
     */
    public function updateLesson(int $lessonId, array $data): bool
    {
        $allowed_fields = ['tieu_de', 'noi_dung', 'mo_ta_chi_tiet', 'video', 'link_video_truc_tuyen', 'trang_thai', 'thu_tu'];
        $update_parts = [];
        $params = [];
        $types = '';

        foreach ($data as $field => $value) {
            if (in_array($field, $allowed_fields)) {
                $update_parts[] = "$field = ?";
                $params[] = $value;
                $types .= 's';
            }
        }

        if (empty($update_parts)) {
            return false;
        }

        $params[] = $lessonId;
        $types .= 'i';

        $sql = 'UPDATE bai_hoc SET ' . implode(', ', $update_parts) . ', updated_at = NOW() WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }

    // =========================================================================
    // XÓA BÀI HỌC
    // =========================================================================

    /**
     * Xóa bài học
     * @param int $lessonId ID bài học
     * @return bool
     */
    public function deleteLesson(int $lessonId): bool
    {
        $sql = 'DELETE FROM bai_hoc WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $lessonId);
        return $stmt->execute();
    }

    // =========================================================================
    // QUẢN LÝ TÀI LIỆU BÀI HỌC
    // =========================================================================

    /**
     * Lấy tất cả tài liệu của một bài học
     * @param int $lessonId ID bài học
     * @return array Mảng tài liệu
     */
    public function getResourcesByLesson(int $lessonId): array
    {
        $sql = 'SELECT * FROM tai_lieu_bai_hoc WHERE bai_hoc_id = ? AND trang_thai = "hien" ORDER BY loai, thu_tu ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $lessonId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Lấy tài liệu theo loại
     * @param int $lessonId ID bài học
     * @param string $type Loại tài liệu (lecture, exercise, resource, link)
     * @return array Mảng tài liệu
     */
    public function getResourcesByType(int $lessonId, string $type): array
    {
        $sql = 'SELECT * FROM tai_lieu_bai_hoc WHERE bai_hoc_id = ? AND loai = ? AND trang_thai = "hien" ORDER BY thu_tu ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('is', $lessonId, $type);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Thêm tài liệu cho bài học
     * @param int $lessonId ID bài học
     * @param string $type Loại tài liệu (lecture, exercise, resource, link)
     * @param string $name Tên tài liệu
     * @param string|null $filePath Đường dẫn file (nếu không phải link)
     * @param string|null $url URL link (nếu là link)
     * @param string|null $description Mô tả
     * @param int|null $fileSize Kích thước file
     * @return int|false ID tài liệu được tạo hoặc false
     */
    public function addResource(int $lessonId, string $type, string $name, ?string $filePath = null, ?string $url = null, ?string $description = null, ?int $fileSize = null)
    {
        $sql = 'INSERT INTO tai_lieu_bai_hoc (bai_hoc_id, loai, ten_file, duong_dan_file, url_link, mo_ta, kich_thuoc_file, trang_thai, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, "hien", NOW())';
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('issssis', $lessonId, $type, $name, $filePath, $url, $description, $fileSize);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }

    /**
     * Cập nhật tài liệu
     * @param int $resourceId ID tài liệu
     * @param array $data Dữ liệu cần cập nhật
     * @return bool
     */
    public function updateResource(int $resourceId, array $data): bool
    {
        $allowed_fields = ['ten_file', 'duong_dan_file', 'url_link', 'mo_ta', 'trang_thai', 'thu_tu'];
        $update_parts = [];
        $params = [];
        $types = '';

        foreach ($data as $field => $value) {
            if (in_array($field, $allowed_fields)) {
                $update_parts[] = "$field = ?";
                $params[] = $value;
                $types .= 's';
            }
        }

        if (empty($update_parts)) {
            return false;
        }

        $params[] = $resourceId;
        $types .= 'i';

        $sql = 'UPDATE tai_lieu_bai_hoc SET ' . implode(', ', $update_parts) . ', updated_at = NOW() WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }

    /**
     * Xóa tài liệu
     * @param int $resourceId ID tài liệu
     * @return bool
     */
    public function deleteResource(int $resourceId): bool
    {
        $sql = 'DELETE FROM tai_lieu_bai_hoc WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $resourceId);
        return $stmt->execute();
    }

    // =========================================================================
    // QUẢN LÝ CHƯƠNG
    // =========================================================================

    /**
     * Lấy tất cả chương của một khóa học
     * @param int $courseId ID khóa học
     * @return array Mảng chương
     */
    public function getChaptersByCourse(int $courseId): array
    {
        $sql = 'SELECT * FROM chuong WHERE khoa_hoc_id = ? AND trang_thai = "hien" ORDER BY thu_tu ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $courseId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Tạo chương mới
     * @param int $courseId ID khóa học
     * @param string $title Tiêu đề chương
     * @param string|null $description Mô tả
     * @param int $order Thứ tự
     * @return int|false ID chương được tạo hoặc false
     */
    public function createChapter(int $courseId, string $title, ?string $description = null, int $order = 0)
    {
        $sql = 'INSERT INTO chuong (khoa_hoc_id, tieu_de, mo_ta, thu_tu, trang_thai, created_at) 
                VALUES (?, ?, ?, ?, "hien", NOW())';
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('issi', $courseId, $title, $description, $order);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }

    /**
     * Cập nhật chương
     * @param int $chapterId ID chương
     * @param array $data Dữ liệu cần cập nhật
     * @return bool
     */
    public function updateChapter(int $chapterId, array $data): bool
    {
        $allowed_fields = ['tieu_de', 'mo_ta', 'trang_thai', 'thu_tu'];
        $update_parts = [];
        $params = [];
        $types = '';

        foreach ($data as $field => $value) {
            if (in_array($field, $allowed_fields)) {
                $update_parts[] = "$field = ?";
                $params[] = $value;
                $types .= 's';
            }
        }

        if (empty($update_parts)) {
            return false;
        }

        $params[] = $chapterId;
        $types .= 'i';

        $sql = 'UPDATE chuong SET ' . implode(', ', $update_parts) . ', updated_at = NOW() WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }

    /**
     * Xóa chương
     * @param int $chapterId ID chương
     * @return bool
     */
    public function deleteChapter(int $chapterId): bool
    {
        $sql = 'DELETE FROM chuong WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $chapterId);
        return $stmt->execute();
    }
}
?>
