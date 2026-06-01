<?php
/**
 * ============================================================================
 * FILE: models/Course.php
 * MỤC ĐÍCH: Đại diện cho thực thể "Khóa học" và thao tác với bảng khoa_hoc
 * ============================================================================
 */

require_once __DIR__ . '/../core/Database.php';

class Course
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Lấy tất cả khóa học (có filter theo danh mục nếu cần)
     * @param string|null $category Danh mục (tên danh mục hoặc null để lấy tất cả)
     * @param int $limit Số lượng khóa học trả về (mặc định 6)
     * @return array Mảng chứa các khóa học
     */
    public function getAll(?string $category = null, int $limit = 6, int $offset = 0, ?string $search = null): array
    {
        $limit = max(1, $limit);
        $offset = max(0, $offset);
        $search = trim((string)$search);
        $hasCategory = $category && $category !== 'all';
        $hasSearch = $search !== '';
        $searchTerm = '%' . $search . '%';

        $sql = 'SELECT kh.*, dm.ten_danh_muc 
                FROM khoa_hoc kh
                LEFT JOIN danh_muc_khoa_hoc dm ON kh.danh_muc_id = dm.id
                WHERE kh.trang_thai = "hien"';

        // Nếu có filter danh mục
        if ($hasCategory) {
            $sql .= ' AND dm.ten_danh_muc = ?';
        }

        if ($hasSearch) {
            $sql .= ' AND (kh.ten_khoa_hoc LIKE ? OR kh.mo_ta_ngan LIKE ? OR kh.giang_vien LIKE ? OR dm.ten_danh_muc LIKE ?)';
        }

        $sql .= ' ORDER BY kh.created_at DESC LIMIT ? OFFSET ?';

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return [];
        }

        // Bind parameters
        if ($hasCategory && $hasSearch) {
            $stmt->bind_param('sssssii', $category, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $limit, $offset);
        } elseif ($hasCategory) {
            $stmt->bind_param('sii', $category, $limit, $offset);
        } elseif ($hasSearch) {
            $stmt->bind_param('ssssii', $searchTerm, $searchTerm, $searchTerm, $searchTerm, $limit, $offset);
        } else {
            $stmt->bind_param('ii', $limit, $offset);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $courses = [];
        while ($row = $result->fetch_assoc()) {
            $courses[] = $row;
        }

        $stmt->close();
        return $courses;
    }

    public function countAll(?string $category = null, ?string $search = null): int
    {
        $search = trim((string)$search);
        $hasCategory = $category && $category !== 'all';
        $hasSearch = $search !== '';
        $searchTerm = '%' . $search . '%';

        $sql = 'SELECT COUNT(*) as total
                FROM khoa_hoc kh
                LEFT JOIN danh_muc_khoa_hoc dm ON kh.danh_muc_id = dm.id
                WHERE kh.trang_thai = "hien"';

        if ($hasCategory) {
            $sql .= ' AND dm.ten_danh_muc = ?';
        }

        if ($hasSearch) {
            $sql .= ' AND (kh.ten_khoa_hoc LIKE ? OR kh.mo_ta_ngan LIKE ? OR kh.giang_vien LIKE ? OR dm.ten_danh_muc LIKE ?)';
        }

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return 0;
        }

        if ($hasCategory && $hasSearch) {
            $stmt->bind_param('sssss', $category, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        } elseif ($hasCategory) {
            $stmt->bind_param('s', $category);
        } elseif ($hasSearch) {
            $stmt->bind_param('ssss', $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return (int)($row['total'] ?? 0);
    }

    /**
     * Lấy chi tiết một khóa học
     * @param int $id ID của khóa học
     * @return array|null Thông tin khóa học hoặc null nếu không tìm thấy
     */
    public function getById(int $id): ?array
    {
        $sql = 'SELECT kh.*, dm.ten_danh_muc 
                FROM khoa_hoc kh
                LEFT JOIN danh_muc_khoa_hoc dm ON kh.danh_muc_id = dm.id
                WHERE kh.id = ? LIMIT 1';

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $course = $result->fetch_assoc();
        $stmt->close();

        return $course;
    }

    /**
     * Lấy số sao trung bình từ bảng danh_gia_khoa_hoc
     * @param int $courseId ID khóa học
     * @return float|null Số sao trung bình hoặc null
     */
    public function getAverageRating(int $courseId): ?float
    {
        $sql = 'SELECT AVG(so_sao) as avg_rating FROM danh_gia_khoa_hoc WHERE khoa_hoc_id = ?';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('i', $courseId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row['avg_rating'] ? (float)$row['avg_rating'] : null;
    }

    /**
     * Lấy số lượng đánh giá của một khóa học
     * @param int $courseId ID khóa học
     * @return int Số lượng đánh giá
     */
    public function getRatingCount(int $courseId): int
    {
        $sql = 'SELECT COUNT(*) as count FROM danh_gia_khoa_hoc WHERE khoa_hoc_id = ?';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return 0;
        }

        $stmt->bind_param('i', $courseId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return (int)$row['count'];
    }

    /**
     * Lấy danh sách các danh mục
     * @return array Mảng chứa các danh mục
     */
    public function getCategories(): array
    {
        $sql = 'SELECT id, ten_danh_muc FROM danh_muc_khoa_hoc';
        $result = $this->conn->query($sql);

        if (!$result) {
            return [];
        }

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }

        return $categories;
    }

    /**
     * Đạo hàm cấp độ: 'co_ban' → 'Cơ bản'
     * @param string $level Mã cấp độ
     * @return string Tên cấp độ Tiếng Việt
     */
    public static function formatLevel(string $level): string
    {
        $levels = [
            'co_ban' => 'Cơ bản',
            'trung_binh' => 'Trung cấp',
            'nang_cao' => 'Nâng cao'
        ];
        return $levels[$level] ?? $level;
    }
}
