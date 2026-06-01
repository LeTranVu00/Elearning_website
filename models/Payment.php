<?php
/**
 * ============================================================================
 * FILE: models/Payment.php
 * MỤC ĐÍCH: Quản lý giao dịch thanh toán (payments) – tạo, cập nhật, lấy thông tin
 * ============================================================================
 */

require_once __DIR__ . '/../core/Database.php';

class Payment
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Tạo bản ghi thanh toán mới
     *
     * @param int $orderId ID đơn hàng
     * @param string $method Phương thức (vnpay, stripe, paypal, cod)
     * @param float $amount Số tiền
     * @return int|false ID thanh toán nếu thành công
     */
    public function create(int $orderId, string $method, float $amount): int|false
    {
        $sql = 'INSERT INTO thanh_toan (don_hang_id, phuong_thuc, gia_tri, trang_thai) 
                VALUES (?, ?, ?, "pending")';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('isd', $orderId, $method, $amount);
        $success = $stmt->execute();
        $paymentId = $stmt->insert_id;
        $stmt->close();

        return $success ? $paymentId : false;
    }

    /**
     * Cập nhật giao dịch ID từ cổng thanh toán (VNPay, Stripe, etc)
     *
     * @param int $paymentId ID thanh toán
     * @param string $transactionId Mã giao dịch từ cổng thanh toán
     * @return bool
     */
    public function updateTransactionId(int $paymentId, string $transactionId): bool
    {
        $sql = 'UPDATE thanh_toan SET ma_giao_dich = ? WHERE id = ?';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('si', $transactionId, $paymentId);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Cập nhật trạng thái thanh toán
     *
     * @param int $paymentId ID thanh toán
     * @param string $status Trạng thái (pending, success, failed, cancelled)
     * @param string|null $description Mô tả (lỗi nếu có)
     * @return bool
     */
    public function updateStatus(int $paymentId, string $status, ?string $description = null): bool
    {
        $sql = 'UPDATE thanh_toan SET trang_thai = ?, mota = ? WHERE id = ?';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('ssi', $status, $description, $paymentId);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Lấy thông tin thanh toán theo ID
     *
     * @param int $paymentId ID thanh toán
     * @return array|null
     */
    public function findById(int $paymentId): ?array
    {
        $sql = 'SELECT * FROM thanh_toan WHERE id = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('i', $paymentId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    /**
     * Lấy thanh toán theo mã giao dịch từ cổng
     *
     * @param string $transactionId Mã giao dịch
     * @return array|null
     */
    public function findByTransactionId(string $transactionId): ?array
    {
        $sql = 'SELECT * FROM thanh_toan WHERE ma_giao_dich = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('s', $transactionId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    /**
     * Lấy thanh toán theo ID đơn hàng
     *
     * @param int $orderId ID đơn hàng
     * @return array|null
     */
    public function findByOrderId(int $orderId): ?array
    {
        $sql = 'SELECT * FROM thanh_toan WHERE don_hang_id = ? ORDER BY ngay_tao DESC LIMIT 1';
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
}
