<?php
/**
 * ============================================================================
 * FILE: models/Order.php
 * MỤC ĐÍCH: Quản lý đơn hàng (orders) – tạo, lấy, cập nhật trạng thái
 * ============================================================================
 */

require_once __DIR__ . '/../core/Database.php';

class Order
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Tạo đơn hàng mới
     *
     * @param int $userId ID người dùng
     * @param float $totalPrice Tổng giá tiền
     * @return int|false ID đơn hàng nếu thành công, false nếu thất bại
     */
    public function create(int $userId, float $totalPrice): int|false
    {
        $sql = 'INSERT INTO don_hang (user_id, tong_tien, trang_thai) VALUES (?, ?, "pending")';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('id', $userId, $totalPrice);
        $success = $stmt->execute();
        $orderId = $stmt->insert_id;
        $stmt->close();

        return $success ? $orderId : false;
    }

    /**
     * Lấy thông tin đơn hàng theo ID
     *
     * @param int $orderId ID đơn hàng
     * @return array|null
     */
    public function findById(int $orderId): ?array
    {
        $sql = 'SELECT * FROM don_hang WHERE id = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    /**
     * Lấy tất cả đơn hàng của 1 người dùng
     *
     * @param int $userId ID người dùng
     * @return array Mảng các đơn hàng
     */
    public function findByUserId(int $userId): array
    {
        $sql = 'SELECT * FROM don_hang WHERE user_id = ? ORDER BY ngay_tao DESC';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }

        return $orders;
    }

    /**
     * Thêm khóa học vào đơn hàng
     *
     * @param int $orderId ID đơn hàng
     * @param int $courseId ID khóa học
     * @param float $price Giá khóa học
     * @return bool
     */
    public function addItem(int $orderId, int $courseId, float $price): bool
    {
        $sql = 'INSERT INTO chi_tiet_don (don_hang_id, khoa_hoc_id, gia_ban) VALUES (?, ?, ?)';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('iid', $orderId, $courseId, $price);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Lấy chi tiết khóa học trong đơn hàng
     *
     * @param int $orderId ID đơn hàng
     * @return array Mảng chi tiết khóa học
     */
    public function getItems(int $orderId): array
    {
        $sql = 'SELECT chi_tiet_don.*, khoa_hoc.ten_khoa_hoc 
                FROM chi_tiet_don 
                LEFT JOIN khoa_hoc ON chi_tiet_don.khoa_hoc_id = khoa_hoc.id 
                WHERE chi_tiet_don.don_hang_id = ?';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }

        return $items;
    }

    /**
     * Cập nhật trạng thái đơn hàng
     *
     * @param int $orderId ID đơn hàng
     * @param string $status Trạng thái mới (pending, completed, cancelled, failed)
     * @return bool
     */
    public function updateStatus(int $orderId, string $status): bool
    {
        $sql = 'UPDATE don_hang SET trang_thai = ? WHERE id = ?';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('si', $status, $orderId);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}
