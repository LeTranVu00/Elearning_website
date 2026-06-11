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
     * Tạo danh mục mới
     * @param string $categoryName Tên danh mục
     * @return int|false ID danh mục mới hoặc false nếu thất bại
     */
    public function createCategory(string $categoryName): int|false
    {
        $categoryName = trim($categoryName);
        
        if (strlen($categoryName) < 2) {
            return false;
        }

        // Kiểm tra danh mục có trùng không
        $sql = 'SELECT id FROM danh_muc_khoa_hoc WHERE ten_danh_muc = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param('s', $categoryName);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return false; // Trùng tên
        }
        $stmt->close();

        // Thêm danh mục
        $sql = 'INSERT INTO danh_muc_khoa_hoc (ten_danh_muc) VALUES (?)';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param('s', $categoryName);
        
        if ($stmt->execute()) {
            $categoryId = $this->conn->insert_id;
            $stmt->close();
            return $categoryId;
        }

        $stmt->close();
        return false;
    }

    /**
     * Cập nhật danh mục
     * @param int $categoryId ID danh mục
     * @param string $categoryName Tên danh mục mới
     * @return bool true nếu thành công
     */
    public function updateCategory(int $categoryId, string $categoryName): bool
    {
        $categoryName = trim($categoryName);
        
        if (strlen($categoryName) < 2) {
            return false;
        }

        $sql = 'UPDATE danh_muc_khoa_hoc SET ten_danh_muc = ? WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param('si', $categoryName, $categoryId);
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

    /**
     * Xóa danh mục (nếu không có khóa học nào sử dụng)
     * @param int $categoryId ID danh mục
     * @return bool true nếu thành công
     */
    public function deleteCategory(int $categoryId): bool
    {
        // Kiểm tra có khóa học nào sử dụng danh mục này không
        $sql = 'SELECT COUNT(*) as count FROM khoa_hoc WHERE danh_muc_id = ?';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param('i', $categoryId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($result['count'] > 0) {
            return false; // Không xóa được vì có khóa học sử dụng
        }

        // Xóa danh mục
        $sql = 'DELETE FROM danh_muc_khoa_hoc WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param('i', $categoryId);
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

    /**
     * Tạo khóa học mới (OOP - CRUD Create)
     * @param int $instructorId ID của giảng viên tạo course
     * @param array $courseData Mảng dữ liệu: ten_khoa_hoc, mo_ta_ngan, mo_ta, danh_muc_id, gia, gia_goc
     * @return int|false ID khóa học mới hoặc false nếu thất bại
     */
    public function create(int $instructorId, array $courseData): int|false
    {
        // Validate dữ liệu bắt buộc
        $required = ['ten_khoa_hoc', 'mo_ta_ngan', 'danh_muc_id', 'gia'];
        foreach ($required as $field) {
            if (empty($courseData[$field])) {
                return false;
            }
        }

        // Chuẩn bị dữ liệu
        $ten_khoa_hoc = trim($courseData['ten_khoa_hoc']);
        $mo_ta_ngan = trim($courseData['mo_ta_ngan']);
        $mo_ta = trim($courseData['mo_ta'] ?? '');
        $danh_muc_id = (int)$courseData['danh_muc_id'];
        $gia = (float)$courseData['gia'];
        $gia_goc = isset($courseData['gia_goc']) ? (float)$courseData['gia_goc'] : $gia;
        $trang_thai = 'hien'; // Khóa học mới công bố ngay
        $anh = $courseData['anh'] ?? null; // Đường dẫn ảnh nếu có
        $ngay_khai_giang = $courseData['ngay_khai_giang'] ?? null;
        $lich_hoc = $courseData['lich_hoc'] ?? null;

        // Kiểm tra khóa học có trùng tên không
        $sql = 'SELECT id FROM khoa_hoc WHERE ten_khoa_hoc = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param('s', $ten_khoa_hoc);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return false; // Trùng tên
        }
        $stmt->close();

        // Thêm khóa học vào database
        $sql = 'INSERT INTO khoa_hoc (
                    ten_khoa_hoc, 
                    mo_ta_ngan, 
                    mo_ta, 
                    danh_muc_id, 
                    gia, 
                    gia_goc, 
                    trang_thai, 
                    anh,
                    giang_vien_id,
                    giang_vien,
                    ngay_khai_giang,
                    lich_hoc,
                    created_at
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())';

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        // Lấy tên giảng viên từ database
        $nameResult = $this->conn->query('SELECT ho_ten FROM nguoi_dung WHERE id = ' . (int)$instructorId);
        $instructorName = $nameResult ? $nameResult->fetch_assoc()['ho_ten'] : '';

        $stmt->bind_param(
            'ssiddssssis',
            $ten_khoa_hoc,
            $mo_ta_ngan,
            $mo_ta,
            $danh_muc_id,
            $gia,
            $gia_goc,
            $trang_thai,
            $anh,
            $instructorId,
            $instructorName,
            $ngay_khai_giang,
            $lich_hoc
        );

        if ($stmt->execute()) {
            $courseId = $this->conn->insert_id;
            $stmt->close();
            return $courseId;
        }

        $stmt->close();
        return false;
    }

    /**
     * Cập nhật khóa học (OOP - CRUD Update)
     * @param int $courseId ID khóa học
     * @param array $updateData Mảng dữ liệu cần cập nhật
     * @return bool true nếu thành công, false nếu thất bại
     */
    public function update(int $courseId, array $updateData): bool
    {
        if (empty($updateData)) {
            return false;
        }

        $allowedFields = [
            'ten_khoa_hoc', 'mo_ta_ngan', 'mo_ta', 'danh_muc_id',
            'gia', 'gia_goc', 'muc_do', 'trang_thai', 'anh',
            'ngay_khai_giang', 'lich_hoc'
        ];

        $fields = [];
        $values = [];
        $types = '';

        foreach ($updateData as $field => $value) {
            if (in_array($field, $allowedFields)) {
                $fields[] = $field . ' = ?';
                $values[] = $value;
                // Xác định loại dữ liệu
                if (in_array($field, ['danh_muc_id'])) {
                    $types .= 'i';
                } elseif (in_array($field, ['gia', 'gia_goc'])) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
            }
        }

        if (empty($fields)) {
            return false;
        }

        $values[] = $courseId;
        $types .= 'i';

        $sql = 'UPDATE khoa_hoc SET ' . implode(', ', $fields) . ', updated_at = NOW() WHERE id = ?';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param($types, ...$values);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
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
