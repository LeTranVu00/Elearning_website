-- ============================================================================
-- PAYMENT & ENROLLMENT SCHEMA
-- Các bảng liên quan đến mua khóa học và thanh toán
-- ============================================================================

-- 1. BẢNG ĐƠN HÀNG (Orders)
-- Lưu thông tin đơn mua của mỗi người dùng
CREATE TABLE IF NOT EXISTS don_hang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    tong_tien DECIMAL(12, 2) NOT NULL,  -- Tổng tiền (đơn vị: đồng)
    trang_thai ENUM('pending', 'completed', 'cancelled', 'failed') DEFAULT 'pending',
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ngay_cap_nhat TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES nguoi_dung(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_trang_thai (trang_thai)
);

-- 2. BẢNG CHI TIẾT ĐƠN HÀNG (Order Items)
-- Lưu từng khóa học trong đơn hàng
CREATE TABLE IF NOT EXISTS chi_tiet_don (
    id INT AUTO_INCREMENT PRIMARY KEY,
    don_hang_id INT NOT NULL,
    khoa_hoc_id INT NOT NULL,
    gia_ban DECIMAL(12, 2) NOT NULL,  -- Giá bán tại thời điểm mua
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (don_hang_id) REFERENCES don_hang(id) ON DELETE CASCADE,
    FOREIGN KEY (khoa_hoc_id) REFERENCES khoa_hoc(id) ON DELETE CASCADE,
    INDEX idx_don_hang_id (don_hang_id),
    UNIQUE KEY unique_don_khoa (don_hang_id, khoa_hoc_id)  -- Không mua khóa học giống nhau 2 lần trong 1 đơn
);

-- 3. BẢNG THANH TOÁN (Payments)
-- Lưu thông tin giao dịch thanh toán
CREATE TABLE IF NOT EXISTS thanh_toan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    don_hang_id INT NOT NULL,
    phuong_thuc ENUM('vnpay', 'stripe', 'paypal', 'cod') DEFAULT 'vnpay',
    ma_giao_dich VARCHAR(100) UNIQUE,  -- Transaction ID từ cổng thanh toán (VNPay, Stripe, etc)
    trang_thai ENUM('pending', 'success', 'failed', 'cancelled') DEFAULT 'pending',
    gia_tri DECIMAL(12, 2) NOT NULL,
    mota TEXT,  -- Mô tả lỗi hoặc ghi chú
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ngay_cap_nhat TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (don_hang_id) REFERENCES don_hang(id) ON DELETE CASCADE,
    INDEX idx_don_hang_id (don_hang_id),
    INDEX idx_ma_giao_dich (ma_giao_dich),
    INDEX idx_trang_thai (trang_thai)
);

-- 4. BẢNG ĐĂNG KÝ KHÓA HỌC (Enrollments)
-- Lưu thông tin user đã mua/đăng ký khóa học nào
CREATE TABLE IF NOT EXISTS dang_ky_khoa_hoc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    khoa_hoc_id INT NOT NULL,
    dang_ky_luc TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    hoan_thanh_luc TIMESTAMP NULL,  -- Khi user hoàn thành khóa học
    tien_do INT DEFAULT 0,  -- Tiến độ hoàn thành (0-100%)
    trang_thai ENUM('learning', 'completed', 'inactive') DEFAULT 'learning',
    FOREIGN KEY (user_id) REFERENCES nguoi_dung(id) ON DELETE CASCADE,
    FOREIGN KEY (khoa_hoc_id) REFERENCES khoa_hoc(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_khoa_hoc_id (khoa_hoc_id),
    UNIQUE KEY unique_user_khoa (user_id, khoa_hoc_id)  -- 1 user chỉ đăng ký 1 lần cho 1 khóa học
);

-- Ví dụ: Chèn bảng khoa_hoc nếu chưa có (tùy chỉnh theo schema thực tế của bạn)
-- CREATE TABLE IF NOT EXISTS khoa_hoc (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     ten_khoa_hoc VARCHAR(255) NOT NULL,
--     mo_ta TEXT,
--     gia_tien DECIMAL(12, 2),
--     ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );
