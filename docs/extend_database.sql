-- ============================================================================
-- SCRIPT MỞ RỘNG DATABASE CHO CHỨC NĂNG QUẢN LÝ BÀI HỌC CỦA GIẢNG VIÊN
-- ============================================================================
-- Ngày tạo: 2026-06-03
-- Mục đích: Thêm các bảng để hỗ trợ upload file bài giảng, bài tập, link

-- ============================================================================
-- 1. BẢNG CHƯƠNG (CHAPTER) - Để tổ chức bài học thành các chương
-- ============================================================================
CREATE TABLE IF NOT EXISTS `chuong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `khoa_hoc_id` int(11) NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `thu_tu` int(11) DEFAULT 0,
  `trang_thai` enum('hien','an') DEFAULT 'hien',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `khoa_hoc_id` (`khoa_hoc_id`),
  CONSTRAINT `fk_chuong_khoa_hoc` FOREIGN KEY (`khoa_hoc_id`) REFERENCES `khoa_hoc` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 2. BẢNG TÀI LIỆU BÀI HỌC (TAI_LIEU_BAI_HOC) - Lưu các file: bài giảng, bài tập, resource
-- ============================================================================
CREATE TABLE IF NOT EXISTS `tai_lieu_bai_hoc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bai_hoc_id` int(11) NOT NULL,
  `loai` enum('lecture','exercise','resource','link') DEFAULT 'lecture',
  `ten_file` varchar(255) NOT NULL,
  `duong_dan_file` varchar(500) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `url_link` varchar(500) DEFAULT NULL,
  `kich_thuoc_file` int(11) DEFAULT NULL,
  `thu_tu` int(11) DEFAULT 0,
  `trang_thai` enum('hien','an') DEFAULT 'hien',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `bai_hoc_id` (`bai_hoc_id`),
  CONSTRAINT `fk_tai_lieu_bai_hoc_bai_hoc` FOREIGN KEY (`bai_hoc_id`) REFERENCES `bai_hoc` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 3. CẬP NHẬT BẢNG BAI_HOC - Thêm chuong_id để liên kết với chương
-- ============================================================================
ALTER TABLE `bai_hoc` ADD COLUMN `chuong_id` int(11) DEFAULT NULL AFTER `khoa_hoc_id`;
ALTER TABLE `bai_hoc` ADD KEY `chuong_id` (`chuong_id`);
ALTER TABLE `bai_hoc` ADD CONSTRAINT `fk_bai_hoc_chuong` FOREIGN KEY (`chuong_id`) REFERENCES `chuong` (`id`) ON DELETE CASCADE;

-- ============================================================================
-- 4. CẬP NHẬT BẢNG KHOA_HOC - Thêm trường để lưu ID giảng viên
-- ============================================================================
ALTER TABLE `khoa_hoc` ADD COLUMN `giang_vien_id` int(11) DEFAULT NULL AFTER `giang_vien`;
ALTER TABLE `khoa_hoc` ADD KEY `giang_vien_id` (`giang_vien_id`);
ALTER TABLE `khoa_hoc` ADD CONSTRAINT `fk_khoa_hoc_giang_vien` FOREIGN KEY (`giang_vien_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE SET NULL;

-- ============================================================================
-- 5. CẬP NHẬT BẢNG NGUOI_DUNG - Thêm trường vai trò giảng viên
-- ============================================================================
-- Nếu bảng còn có enum vai_tro, cập nhật nó
ALTER TABLE `nguoi_dung` MODIFY `vai_tro` enum('admin','user','instructor') DEFAULT 'user';

-- ============================================================================
-- 6. BẢNG TÀI LIỆU BÀI TẬP - Để lưu kết quả nộp bài
-- ============================================================================
CREATE TABLE IF NOT EXISTS `nop_bai_tap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tai_lieu_bai_tap_id` int(11) NOT NULL,
  `hoc_vien_id` int(11) NOT NULL,
  `duong_dan_file` varchar(500) DEFAULT NULL,
  `ghi_chu` text DEFAULT NULL,
  `trang_thai` enum('chua_nop','da_nop','da_cham','da_tra') DEFAULT 'chua_nop',
  `diem` int(11) DEFAULT NULL,
  `nhan_xet` text DEFAULT NULL,
  `ngay_nop` datetime DEFAULT NULL,
  `ngay_cham` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `tai_lieu_bai_tap_id` (`tai_lieu_bai_tap_id`),
  KEY `hoc_vien_id` (`hoc_vien_id`),
  CONSTRAINT `fk_nop_bai_tap_tai_lieu` FOREIGN KEY (`tai_lieu_bai_tap_id`) REFERENCES `tai_lieu_bai_hoc` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_nop_bai_tap_hoc_vien` FOREIGN KEY (`hoc_vien_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 7. CẬP NHẬT BẢNG BAI_HOC - Thêm các trường cần thiết khác
-- ============================================================================
ALTER TABLE `bai_hoc` ADD COLUMN `mo_ta_chi_tiet` longtext DEFAULT NULL AFTER `noi_dung`;
ALTER TABLE `bai_hoc` ADD COLUMN `link_video_truc_tuyen` varchar(500) DEFAULT NULL AFTER `video`;
ALTER TABLE `bai_hoc` ADD COLUMN `trang_thai` enum('hien','an') DEFAULT 'hien' AFTER `thu_tu`;

-- ============================================================================
-- HOÀN THÀNH
-- ============================================================================
-- Chạy script này bằng lệnh:
-- mysql -u root -p web_hoc_truc_tuyen < extend_database.sql
-- 
-- Hoặc import qua phpMyAdmin
