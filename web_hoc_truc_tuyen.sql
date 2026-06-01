-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th5 24, 2026 lúc 01:41 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `web_hoc_truc_tuyen`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bai_hoc`
--

CREATE TABLE `bai_hoc` (
  `id` int(11) NOT NULL,
  `khoa_hoc_id` int(11) DEFAULT NULL,
  `tieu_de` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `noi_dung` longtext DEFAULT NULL,
  `tai_lieu` varchar(255) DEFAULT NULL,
  `thu_tu` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bai_viet_dien_dan`
--

CREATE TABLE `bai_viet_dien_dan` (
  `id` int(11) NOT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `chuyen_muc_id` int(11) DEFAULT NULL,
  `tieu_de` varchar(255) DEFAULT NULL,
  `noi_dung` longtext DEFAULT NULL,
  `anh` varchar(255) DEFAULT NULL,
  `luot_xem` int(11) DEFAULT 0,
  `trang_thai` enum('hien','an') DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bang_xep_hang`
--

CREATE TABLE `bang_xep_hang` (
  `id` int(11) NOT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `diem` int(11) DEFAULT 0,
  `cap_do` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bao_cao_bai_viet`
--

CREATE TABLE `bao_cao_bai_viet` (
  `id` int(11) NOT NULL,
  `bai_viet_id` int(11) DEFAULT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `ly_do` text DEFAULT NULL,
  `trang_thai` enum('cho_duyet','da_xu_ly') DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binh_luan_bai_viet`
--

CREATE TABLE `binh_luan_bai_viet` (
  `id` int(11) NOT NULL,
  `bai_viet_id` int(11) DEFAULT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `noi_dung` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binh_luan_khoa_hoc`
--

CREATE TABLE `binh_luan_khoa_hoc` (
  `id` int(11) NOT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `khoa_hoc_id` int(11) DEFAULT NULL,
  `noi_dung` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `don_hang`
--

CREATE TABLE `don_hang` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tong_tien` decimal(12,2) NOT NULL,
  `trang_thai` enum('pending','completed','cancelled','failed') DEFAULT 'pending',
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_don`
--

CREATE TABLE `chi_tiet_don` (
  `id` int(11) NOT NULL,
  `don_hang_id` int(11) NOT NULL,
  `khoa_hoc_id` int(11) NOT NULL,
  `gia_ban` decimal(12,2) NOT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `chi_tiet_thanh_toan` (
  `id` int(11) NOT NULL,
  `thanh_toan_id` int(11) DEFAULT NULL,
  `khoa_hoc_id` int(11) DEFAULT NULL,
  `gia` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chuyen_muc_dien_dan`
--

CREATE TABLE `chuyen_muc_dien_dan` (
  `id` int(11) NOT NULL,
  `ten_chuyen_muc` varchar(255) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dang_ky_khoa_hoc`
--

CREATE TABLE `dang_ky_khoa_hoc` (
  `id` int(11) NOT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `khoa_hoc_id` int(11) DEFAULT NULL,
  `dang_ky_luc` datetime DEFAULT current_timestamp(),
  `hoan_thanh_luc` datetime DEFAULT NULL,
  `tien_do` int(11) DEFAULT 0,
  `trang_thai` enum('dang_hoc','hoan_thanh','inactive') DEFAULT 'dang_hoc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_gia_khoa_hoc`
--

CREATE TABLE `danh_gia_khoa_hoc` (
  `id` int(11) NOT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `khoa_hoc_id` int(11) DEFAULT NULL,
  `so_sao` int(11) DEFAULT NULL,
  `noi_dung` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_muc_khoa_hoc`
--

CREATE TABLE `danh_muc_khoa_hoc` (
  `id` int(11) NOT NULL,
  `ten_danh_muc` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khoa_hoc`
--

CREATE TABLE `khoa_hoc` (
  `id` int(11) NOT NULL,
  `danh_muc_id` int(11) DEFAULT NULL,
  `ten_khoa_hoc` varchar(255) DEFAULT NULL,
  `mo_ta_ngan` text DEFAULT NULL,
  `mo_ta` longtext DEFAULT NULL,
  `anh` varchar(255) DEFAULT NULL,
  `gia` decimal(10,2) DEFAULT NULL,
  `gia_goc` decimal(10,2) DEFAULT NULL,
  `muc_do` enum('co_ban','trung_binh','nang_cao') DEFAULT NULL,
  `trang_thai` enum('hien','an') DEFAULT NULL,
  `giang_vien` varchar(255) DEFAULT NULL,
  `so_luot_danh_gia` int(11) DEFAULT 0,
  `so_hoc_vien` int(11) DEFAULT 0,
  `thoi_luong` int(11) DEFAULT 0,
  `so_bai_giang` int(11) DEFAULT 0,
  `ngay_khai_giang` date DEFAULT NULL,
  `lich_hoc` varchar(255) DEFAULT NULL,
  `gio_hoc` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lien_he`
--

CREATE TABLE `lien_he` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `noi_dung` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `luu_bai_viet`
--

CREATE TABLE `luu_bai_viet` (
  `id` int(11) NOT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `bai_viet_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `auth_provider` enum('local','google') DEFAULT 'local',
  `vai_tro` enum('admin','user') DEFAULT 'user',
  `trang_thai` enum('hoat_dong','khoa') DEFAULT 'hoat_dong',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanh_toan`
--

CREATE TABLE `thanh_toan` (
  `id` int(11) NOT NULL,
  `don_hang_id` int(11) NOT NULL,
  `phuong_thuc` enum('momo','vnpay','stripe','paypal','cod') DEFAULT 'momo',
  `ma_giao_dich` varchar(100) UNIQUE DEFAULT NULL,
  `trang_thai` enum('pending','success','failed','cancelled') DEFAULT 'pending',
  `gia_tri` decimal(12,2) NOT NULL,
  `mota` text DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thich_bai_viet`
--

CREATE TABLE `thich_bai_viet` (
  `id` int(11) NOT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `bai_viet_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thong_bao`
--

CREATE TABLE `thong_bao` (
  `id` int(11) NOT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `tieu_de` varchar(255) DEFAULT NULL,
  `noi_dung` text DEFAULT NULL,
  `da_doc` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tien_do_hoc`
--

CREATE TABLE `tien_do_hoc` (
  `id` int(11) NOT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `bai_hoc_id` int(11) DEFAULT NULL,
  `da_hoan_thanh` tinyint(1) DEFAULT 0,
  `phan_tram` int(11) DEFAULT 0,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tra_loi_binh_luan`
--

CREATE TABLE `tra_loi_binh_luan` (
  `id` int(11) NOT NULL,
  `binh_luan_id` int(11) DEFAULT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `noi_dung` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `yeu_thich_khoa_hoc`
--

CREATE TABLE `yeu_thich_khoa_hoc` (
  `id` int(11) NOT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `khoa_hoc_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bai_hoc`
--
ALTER TABLE `bai_hoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `khoa_hoc_id` (`khoa_hoc_id`);

--
-- Chỉ mục cho bảng `bai_viet_dien_dan`
--
ALTER TABLE `bai_viet_dien_dan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `chuyen_muc_id` (`chuyen_muc_id`);

--
-- Chỉ mục cho bảng `bang_xep_hang`
--
ALTER TABLE `bang_xep_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`);

--
-- Chỉ mục cho bảng `bao_cao_bai_viet`
--
ALTER TABLE `bao_cao_bai_viet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bai_viet_id` (`bai_viet_id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`);

--
-- Chỉ mục cho bảng `binh_luan_bai_viet`
--
ALTER TABLE `binh_luan_bai_viet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bai_viet_id` (`bai_viet_id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`);

--
-- Chỉ mục cho bảng `binh_luan_khoa_hoc`
--
ALTER TABLE `binh_luan_khoa_hoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `khoa_hoc_id` (`khoa_hoc_id`);

--
-- Chỉ mục cho bảng `chi_tiet_thanh_toan`
--
ALTER TABLE `chi_tiet_thanh_toan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thanh_toan_id` (`thanh_toan_id`),
  ADD KEY `khoa_hoc_id` (`khoa_hoc_id`);

--
-- Chỉ mục cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_trang_thai` (`trang_thai`);

--
-- Chỉ mục cho bảng `chi_tiet_don`
--
ALTER TABLE `chi_tiet_don`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_don_hang_id` (`don_hang_id`),
  ADD UNIQUE KEY `unique_don_khoa` (`don_hang_id`, `khoa_hoc_id`);

--
-- Chỉ mục cho bảng `chuyen_muc_dien_dan`
--
ALTER TABLE `chuyen_muc_dien_dan`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `dang_ky_khoa_hoc`
--
ALTER TABLE `dang_ky_khoa_hoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `khoa_hoc_id` (`khoa_hoc_id`);

--
-- Chỉ mục cho bảng `danh_gia_khoa_hoc`
--
ALTER TABLE `danh_gia_khoa_hoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `khoa_hoc_id` (`khoa_hoc_id`);

--
-- Chỉ mục cho bảng `danh_muc_khoa_hoc`
--
ALTER TABLE `danh_muc_khoa_hoc`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `khoa_hoc`
--
ALTER TABLE `khoa_hoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `danh_muc_id` (`danh_muc_id`);

--
-- Chỉ mục cho bảng `lien_he`
--
ALTER TABLE `lien_he`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `luu_bai_viet`
--
ALTER TABLE `luu_bai_viet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `bai_viet_id` (`bai_viet_id`);

--
-- Chỉ mục cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `google_id` (`google_id`);

--
-- Chỉ mục cho bảng `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_don_hang_id` (`don_hang_id`),
  ADD KEY `idx_ma_giao_dich` (`ma_giao_dich`),
  ADD KEY `idx_trang_thai` (`trang_thai`);

--
-- Chỉ mục cho bảng `thich_bai_viet`
--
ALTER TABLE `thich_bai_viet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `bai_viet_id` (`bai_viet_id`);

--
-- Chỉ mục cho bảng `thong_bao`
--
ALTER TABLE `thong_bao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`);

--
-- Chỉ mục cho bảng `tien_do_hoc`
--
ALTER TABLE `tien_do_hoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `bai_hoc_id` (`bai_hoc_id`);

--
-- Chỉ mục cho bảng `tra_loi_binh_luan`
--
ALTER TABLE `tra_loi_binh_luan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `binh_luan_id` (`binh_luan_id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`);

--
-- Chỉ mục cho bảng `yeu_thich_khoa_hoc`
--
ALTER TABLE `yeu_thich_khoa_hoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `khoa_hoc_id` (`khoa_hoc_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bai_hoc`
--
ALTER TABLE `bai_hoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `bai_viet_dien_dan`
--
ALTER TABLE `bai_viet_dien_dan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `bang_xep_hang`
--
ALTER TABLE `bang_xep_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `bao_cao_bai_viet`
--
ALTER TABLE `bao_cao_bai_viet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `binh_luan_bai_viet`
--
ALTER TABLE `binh_luan_bai_viet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `binh_luan_khoa_hoc`
--
ALTER TABLE `binh_luan_khoa_hoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chi_tiet_thanh_toan`
--
ALTER TABLE `chi_tiet_thanh_toan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chi_tiet_don`
--
ALTER TABLE `chi_tiet_don`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chuyen_muc_dien_dan`
--
ALTER TABLE `chuyen_muc_dien_dan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `dang_ky_khoa_hoc`
--
ALTER TABLE `dang_ky_khoa_hoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `danh_gia_khoa_hoc`
--
ALTER TABLE `danh_gia_khoa_hoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `danh_muc_khoa_hoc`
--
ALTER TABLE `danh_muc_khoa_hoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `khoa_hoc`
--
ALTER TABLE `khoa_hoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `lien_he`
--
ALTER TABLE `lien_he`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `luu_bai_viet`
--
ALTER TABLE `luu_bai_viet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `thanh_toan`
--
ALTER TABLE `thanh_toan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `thich_bai_viet`
--
ALTER TABLE `thich_bai_viet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `thong_bao`
--
ALTER TABLE `thong_bao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tien_do_hoc`
--
ALTER TABLE `tien_do_hoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tra_loi_binh_luan`
--
ALTER TABLE `tra_loi_binh_luan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `yeu_thich_khoa_hoc`
--
ALTER TABLE `yeu_thich_khoa_hoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Dữ liệu cho bảng `khoa_hoc`
--
INSERT INTO `khoa_hoc` (`id`, `danh_muc_id`, `ten_khoa_hoc`, `mo_ta_ngan`, `mo_ta`, `anh`, `gia`, `gia_goc`, `muc_do`, `giang_vien`, `so_sao`, `so_luot_danh_gia`, `so_hoc_vien`, `thoi_luong`, `trang_thai`, `created_at`, `updated_at`) VALUES
(1, 1, 'React từ cơ bản đến nâng cao', 'Học React từ đầu với dự án thực tế và best practices', 'Khóa học React toàn diện giúp bạn từ cơ bản đến nâng cao. Bạn sẽ học React Hooks, Redux, React Router, và xây dựng các dự án thực tế. Bao gồm: Setup project, Component, State & Props, Lifecycle, Hooks, Context API, Redux, Testing.', 'assets/images/react-course.jpg', 1200000.00, 2000000.00, 'co_ban', 'Nguyễn Văn A', 4.8, 245, 1234, 12, 'hien', NOW(), NOW()),
(2, 4, 'JavaScript ES6+ hiện đại', 'Làm chủ JavaScript hiện đại với ES6+ và nhiều kỹ thuật mới', 'Khóa học JavaScript hiện đại bao gồm tất cả các tính năng ES6+ mới nhất. Học về Arrow Functions, Classes, Promises, Async/Await, Destructuring, Spread Operator, Modules và nhiều hơn nữa.', 'assets/images/javascript-course.jpg', 900000.00, 1500000.00, 'trung_binh', 'Trần Thị B', 4.9, 312, 2156, 10, 'hien', NOW(), NOW()),
(3, 3, 'Full-stack Web Development', 'Trở thành full-stack developer với MERN stack', 'Khóa học Full-stack toàn diện sử dụng MongoDB, Express.js, React, Node.js. Bạn sẽ xây dựng các ứng dụng web hoàn chỉnh từ frontend đến backend, authentication, database design.', 'assets/images/fullstack-course.jpg', 2500000.00, 4000000.00, 'nang_cao', 'Lê Văn C', 4.7, 189, 856, 40, 'hien', NOW(), NOW()),
(4, 1, 'Vue.js Fundamentals', 'Tìm hiểu Vue.js từ cơ bản đến nâng cao', 'Khóa học Vue.js bao gồm: Introduction to Vue, Templates & Directives, Component Basics, Component Communication, Vue Router, Vuex, Composition API.', 'assets/images/vue-course.jpg', 899000.00, 1500000.00, 'co_ban', 'Phạm Văn D', 4.6, 156, 945, 15, 'hien', NOW(), NOW()),
(5, 2, 'Node.js & Express.js', 'Xây dựng REST API với Node.js và Express', 'Học cách xây dựng REST API mạnh mẽ với Node.js và Express.js. Bao gồm: Authentication, Authorization, Error Handling, Database Integration, Middleware, Testing.', 'assets/images/nodejs-course.jpg', 1100000.00, 1800000.00, 'trung_binh', 'Hoàng Minh E', 4.7, 198, 1078, 20, 'hien', NOW(), NOW()),
(6, 5, 'MongoDB & NoSQL Database', 'Nắm vững MongoDB và các khái niệm NoSQL', 'Khóa học MongoDB bao gồm: CRUD Operations, Schema Design, Indexing, Aggregation Framework, Transactions, Replication. Hiểu rõ về database design cho NoSQL.', 'assets/images/mongodb-course.jpg', 799000.00, 1300000.00, 'trung_binh', 'Đặng Văn F', 4.5, 142, 623, 16, 'hien', NOW(), NOW()),
(7, 1, 'HTML5 & CSS3 từ đầu', 'Nên tảng vững chắc về HTML5 và CSS3 hiện đại', 'Khóa học HTML5 & CSS3 toàn diện dành cho người mới bắt đầu. Bao gồm: Semantic HTML, CSS Flexbox, CSS Grid, Responsive Design, CSS Animations.', 'assets/images/html-css-course.jpg', 599000.00, 1000000.00, 'co_ban', 'Bùi Thị G', 4.9, 328, 2456, 18, 'hien', NOW(), NOW()),
(8, 3, 'Nextjs - React Framework hiện đại', 'Xây dựng ứng dụng React hiệu năng cao với Nextjs', 'Khóa học Nextjs bao gồm: Server-side Rendering, Static Site Generation, API Routes, Authentication, Deployment, Image Optimization, Performance.', 'assets/images/nextjs-course.jpg', 1500000.00, 2500000.00, 'nang_cao', 'Vũ Văn H', 4.8, 267, 1534, 22, 'hien', NOW(), NOW()),
(9, 4, 'TypeScript Mastery', 'Làm chủ TypeScript cho dự án production-ready', 'Khóa học TypeScript chi tiết bao gồm: Types, Interfaces, Generics, Decorators, Advanced Types, Error Handling, Project Setup cho production.', 'assets/images/typescript-course.jpg', 1050000.00, 1750000.00, 'trung_binh', 'Tạ Văn I', 4.6, 189, 812, 19, 'hien', NOW(), NOW()),
(10, 2, 'PHP & Laravel Framework', 'Phát triển web với PHP và Laravel', 'Khóa học Laravel bao gồm: Routing, Controllers, Models, Migrations, Authentication, Authorization, Testing, Deployment.', 'assets/images/laravel-course.jpg', 950000.00, 1600000.00, 'trung_binh', 'Ngô Văn J', 4.7, 213, 1456, 21, 'hien', NOW(), NOW());

--
-- Dữ liệu cho bảng `danh_muc_khoa_hoc`
--
INSERT INTO `danh_muc_khoa_hoc` (`id`, `ten_danh_muc`, `mo_ta`, `created_at`, `updated_at`) VALUES
(1, 'Lập Trình Frontend', 'Các khóa học về phát triển giao diện người dùng', NOW(), NOW()),
(2, 'Lập Trình Backend', 'Các khóa học về phát triển phía máy chủ', NOW(), NOW()),
(3, 'Lập Trình Full-Stack', 'Các khóa học kết hợp cả Frontend và Backend', NOW(), NOW()),
(4, 'JavaScript & TypeScript', 'Các khóa học về JavaScript và TypeScript', NOW(), NOW()),
(5, 'Cơ Sở Dữ Liệu', 'Các khóa học về quản lý cơ sở dữ liệu', NOW(), NOW());

--
-- Dữ liệu cho bảng `nguoi_dung`
--
INSERT INTO `nguoi_dung` (`id`, `ho_ten`, `email`, `so_dien_thoai`, `mat_khau`, `avatar`, `vai_tro`, `trang_thai`, `created_at`, `updated_at`) VALUES
(1, 'Nguyễn Văn A', 'nguyenvana@email.com', '0901234567', 'password123', 'https://i.pravatar.cc/150?img=1', 'user', 'hoat_dong', NOW(), NOW()),
(2, 'Trần Thị B', 'tranthib@email.com', '0902234567', 'password123', 'https://i.pravatar.cc/150?img=2', 'user', 'hoat_dong', NOW(), NOW()),
(3, 'Lê Văn C', 'levanc@email.com', '0903234567', 'password123', 'https://i.pravatar.cc/150?img=3', 'user', 'hoat_dong', NOW(), NOW()),
(4, 'Phạm Văn D', 'phamvand@email.com', '0904234567', 'password123', 'https://i.pravatar.cc/150?img=4', 'user', 'hoat_dong', NOW(), NOW()),
(5, 'Hoàng Minh E', 'hoangminhe@email.com', '0905234567', 'password123', 'https://i.pravatar.cc/150?img=5', 'user', 'hoat_dong', NOW(), NOW()),
(6, 'Admin User', 'admin@email.com', '0900000000', 'admin123', 'https://i.pravatar.cc/150?img=0', 'admin', 'hoat_dong', NOW(), NOW());

--
-- Dữ liệu cho bảng `dang_ky_khoa_hoc`
--
INSERT INTO `dang_ky_khoa_hoc` (`id`, `nguoi_dung_id`, `khoa_hoc_id`, `ngay_dang_ky`, `trang_thai`) VALUES
(1, 1, 1, NOW(), 'dang_hoc'),
(2, 1, 2, NOW(), 'dang_hoc'),
(3, 2, 2, NOW(), 'dang_hoc'),
(4, 2, 3, NOW(), 'dang_hoc'),
(5, 3, 1, NOW(), 'hoan_thanh'),
(6, 3, 5, NOW(), 'dang_hoc'),
(7, 4, 4, NOW(), 'dang_hoc'),
(8, 5, 8, NOW(), 'dang_hoc');

--
-- Dữ liệu cho bảng `bai_hoc`
--
INSERT INTO `bai_hoc` (`id`, `khoa_hoc_id`, `tieu_de`, `video`, `noi_dung`, `tai_lieu`, `thu_tu`, `created_at`) VALUES
(1, 1, 'React là gì và tại sao cần học', 'https://youtu.be/video1', 'React là một thư viện JavaScript dùng để xây dựng giao diện người dùng (UI) bằng cách sử dụng các component có thể tái sử dụng.', 'assets/files/lesson1.pdf', 1, NOW()),
(2, 1, 'JSX - Cú pháp của React', 'https://youtu.be/video2', 'JSX là một cú pháp mở rộng cho JavaScript cho phép bạn viết mã giống HTML trong JavaScript.', 'assets/files/lesson2.pdf', 2, NOW()),
(3, 1, 'State và Props trong React', 'https://youtu.be/video3', 'State là dữ liệu thay đổi được của component, Props là cách truyền dữ liệu từ component cha sang component con.', 'assets/files/lesson3.pdf', 3, NOW()),
(4, 2, 'Biến và Kiểu dữ liệu JavaScript', 'https://youtu.be/video4', 'JavaScript hỗ trợ các kiểu dữ liệu như: String, Number, Boolean, Object, Array, null, undefined.', 'assets/files/lesson4.pdf', 1, NOW()),
(5, 2, 'Arrow Functions - Hàm mũi tên', 'https://youtu.be/video5', 'Arrow function là cách viết hàm ngắn gọn hơn, được giới thiệu trong ES6.', 'assets/files/lesson5.pdf', 2, NOW());

--
-- Dữ liệu cho bảng `danh_gia_khoa_hoc`
--
INSERT INTO `danh_gia_khoa_hoc` (`id`, `nguoi_dung_id`, `khoa_hoc_id`, `so_sao`, `noi_dung`, `created_at`) VALUES
(1, 1, 1, 5, 'Khóa học rất tuyệt vời, giảng viên giải thích chi tiết và dễ hiểu. Tôi đã học được rất nhiều điều hữu ích.', NOW()),
(2, 2, 1, 5, 'Nội dung phong phú, các ví dụ thực tế rất giúp ích. Strongly recommend!', NOW()),
(3, 3, 1, 4, 'Tốt, nhưng mong muốn có thêm bài tập thực hành nâng cao hơn.', NOW()),
(4, 4, 2, 5, 'React cơ bản đầy đủ, từ simple đến complex. Rất thích cách giảng dạy.', NOW()),
(5, 2, 2, 4, 'Hay, nhưng tốc độ giảng có chút nhanh ở những phần cuối.', NOW());

--
-- Dữ liệu cho bảng `binh_luan_khoa_hoc`
--
INSERT INTO `binh_luan_khoa_hoc` (`id`, `nguoi_dung_id`, `khoa_hoc_id`, `noi_dung`, `created_at`) VALUES
(1, 1, 1, 'Bài học 2 hay quá, JSX khá phức tạp lúc đầu nhưng sau khi xem lại thì rõ ràng hơn.', NOW()),
(2, 2, 1, 'Ai có thể giải thích thêm về State lifting không?', NOW()),
(3, 3, 2, 'JavaScript hay quá! Từ từ học thêm Arrow function nữa.', NOW()),
(4, 4, 3, 'Khi nào giảng về optimization và performance?', NOW()),
(5, 1, 2, 'Cảm ơn bạn @Trần Thị B, mình cũng có cảm giác tương tự về phần ES6+', NOW());

--
-- Dữ liệu cho bảng `chuyen_muc_dien_dan`
--
INSERT INTO `chuyen_muc_dien_dan` (`id`, `ten_chuyen_muc`, `mo_ta`, `created_at`) VALUES
(1, 'React', 'Thảo luận về React, JSX, Hooks, Redux và các chủ đề liên quan', NOW()),
(2, 'JavaScript', 'Thảo luận về JavaScript, ES6+, Async/Await, Promises', NOW()),
(3, 'Node.js', 'Thảo luận về Node.js, Express, API Development', NOW()),
(4, 'Cơ sở dữ liệu', 'Thảo luận về MongoDB, SQL, Database Design', NOW()),
(5, 'Dự án', 'Chia sẻ các dự án và tìm kiếm sự giúp đỡ từ cộng đồng', NOW());

--
-- Dữ liệu cho bảng `bai_viet_dien_dan`
--
INSERT INTO `bai_viet_dien_dan` (`id`, `nguoi_dung_id`, `chuyen_muc_id`, `tieu_de`, `noi_dung`, `anh`, `luot_xem`, `trang_thai`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Cách tối ưu performance trong React', 'Mình vừa hoàn thành một dự án React lớn và muốn chia sẻ những kinh nghiệm về optimization. Dưới đây là những điều mình học được...', NULL, 245, 'hien', NOW(), NOW()),
(2, 2, 2, 'Giải thích về Closure trong JavaScript', 'Closure là một trong những khái niệm khó hiểu nhất trong JavaScript. Hôm nay mình sẽ cố gắng giải thích nó một cách đơn giản...', NULL, 189, 'hien', NOW(), NOW()),
(3, 3, 3, 'Best practices cho REST API với Node.js', 'Khi xây dựng REST API, có nhiều điều cần chú ý. Dựa trên kinh nghiệm của mình, đây là những best practices...', NULL, 156, 'hien', NOW(), NOW()),
(4, 4, 4, 'Thiết kế schema MongoDB cho ứng dụng e-commerce', 'Mình đang xây dựng một ứng dụng e-commerce và muốn hỏi ý kiến về cách thiết kế schema trong MongoDB...', NULL, 98, 'hien', NOW(), NOW()),
(5, 5, 5, 'Giới thiệu dự án e-learning của mình', 'Mình vừa hoàn thành một dự án e-learning platform với React, Node.js và MongoDB. Rất mong nhận được feedback từ mọi người!', NULL, 342, 'hien', NOW(), NOW());

--
-- Dữ liệu cho bảng `binh_luan_bai_viet`
--
INSERT INTO `binh_luan_bai_viet` (`id`, `bai_viet_id`, `nguoi_dung_id`, `noi_dung`, `created_at`) VALUES
(1, 1, 2, 'Cảm ơn bạn đã chia sẻ! Mối suggestion thứ 3 của bạn rất hữu ích.', NOW()),
(2, 1, 3, 'Bạn có thể làm rõ hơn về React.memo không?', NOW()),
(3, 2, 1, 'Bài viết hay! Ví dụ của bạn giúp mình hiểu rõ hơn về closure.', NOW()),
(4, 3, 4, 'Best practices này rất cần thiết. Mình sẽ áp dụng vào dự án của mình luôn.', NOW()),
(5, 5, 1, 'Dự án của bạn tuyệt vời! Có thể chia sẻ source code được không?', NOW());

--
-- Dữ liệu cho bảng `yeu_thich_khoa_hoc`
--
INSERT INTO `yeu_thich_khoa_hoc` (`id`, `nguoi_dung_id`, `khoa_hoc_id`, `created_at`) VALUES
(1, 1, 1, NOW()),
(2, 1, 2, NOW()),
(3, 2, 3, NOW()),
(4, 3, 1, NOW()),
(5, 4, 8, NOW());

--
-- Dữ liệu cho bảng `bang_xep_hang`
--
INSERT INTO `bang_xep_hang` (`id`, `nguoi_dung_id`, `diem`, `cap_do`, `updated_at`) VALUES
(1, 1, 850, 'Pro', NOW()),
(2, 2, 720, 'Advanced', NOW()),
(3, 3, 650, 'Advanced', NOW()),
(4, 4, 480, 'Intermediate', NOW()),
(5, 5, 350, 'Beginner', NOW());

--
-- Các ràng buộc cho bảng `bai_hoc`
--
ALTER TABLE `bai_hoc`
  ADD CONSTRAINT `bai_hoc_ibfk_1` FOREIGN KEY (`khoa_hoc_id`) REFERENCES `khoa_hoc` (`id`);

--
-- Các ràng buộc cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chi_tiet_don`
--
ALTER TABLE `chi_tiet_don`
  ADD CONSTRAINT `chi_tiet_don_ibfk_1` FOREIGN KEY (`don_hang_id`) REFERENCES `don_hang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chi_tiet_don_ibfk_2` FOREIGN KEY (`khoa_hoc_id`) REFERENCES `khoa_hoc` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD CONSTRAINT `thanh_toan_ibfk_1` FOREIGN KEY (`don_hang_id`) REFERENCES `don_hang` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chi_tiet_thanh_toan`
--
ALTER TABLE `chi_tiet_thanh_toan`
  ADD CONSTRAINT `chi_tiet_thanh_toan_ibfk_1` FOREIGN KEY (`thanh_toan_id`) REFERENCES `thanh_toan` (`id`),
  ADD CONSTRAINT `chi_tiet_thanh_toan_ibfk_2` FOREIGN KEY (`khoa_hoc_id`) REFERENCES `khoa_hoc` (`id`);

--
-- Các ràng buộc cho bảng `bai_viet_dien_dan`
--
ALTER TABLE `bai_viet_dien_dan`
  ADD CONSTRAINT `bai_viet_dien_dan_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`),
  ADD CONSTRAINT `bai_viet_dien_dan_ibfk_2` FOREIGN KEY (`chuyen_muc_id`) REFERENCES `chuyen_muc_dien_dan` (`id`);

--
-- Các ràng buộc cho bảng `bang_xep_hang`
--
ALTER TABLE `bang_xep_hang`
  ADD CONSTRAINT `bang_xep_hang_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`);

--
-- Các ràng buộc cho bảng `bao_cao_bai_viet`
--
ALTER TABLE `bao_cao_bai_viet`
  ADD CONSTRAINT `bao_cao_bai_viet_ibfk_1` FOREIGN KEY (`bai_viet_id`) REFERENCES `bai_viet_dien_dan` (`id`),
  ADD CONSTRAINT `bao_cao_bai_viet_ibfk_2` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`);

--
-- Các ràng buộc cho bảng `binh_luan_bai_viet`
--
ALTER TABLE `binh_luan_bai_viet`
  ADD CONSTRAINT `binh_luan_bai_viet_ibfk_1` FOREIGN KEY (`bai_viet_id`) REFERENCES `bai_viet_dien_dan` (`id`),
  ADD CONSTRAINT `binh_luan_bai_viet_ibfk_2` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`);

--
-- Các ràng buộc cho bảng `binh_luan_khoa_hoc`
--
ALTER TABLE `binh_luan_khoa_hoc`
  ADD CONSTRAINT `binh_luan_khoa_hoc_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`),
  ADD CONSTRAINT `binh_luan_khoa_hoc_ibfk_2` FOREIGN KEY (`khoa_hoc_id`) REFERENCES `khoa_hoc` (`id`);

--
-- Các ràng buộc cho bảng `chi_tiet_thanh_toan`
--
ALTER TABLE `chi_tiet_thanh_toan`
  ADD CONSTRAINT `chi_tiet_thanh_toan_ibfk_1` FOREIGN KEY (`thanh_toan_id`) REFERENCES `thanh_toan` (`id`),
  ADD CONSTRAINT `chi_tiet_thanh_toan_ibfk_2` FOREIGN KEY (`khoa_hoc_id`) REFERENCES `khoa_hoc` (`id`);

--
-- Các ràng buộc cho bảng `dang_ky_khoa_hoc`
--
ALTER TABLE `dang_ky_khoa_hoc`
  ADD CONSTRAINT `dang_ky_khoa_hoc_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`),
  ADD CONSTRAINT `dang_ky_khoa_hoc_ibfk_2` FOREIGN KEY (`khoa_hoc_id`) REFERENCES `khoa_hoc` (`id`);

--
-- Các ràng buộc cho bảng `danh_gia_khoa_hoc`
--
ALTER TABLE `danh_gia_khoa_hoc`
  ADD CONSTRAINT `danh_gia_khoa_hoc_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`),
  ADD CONSTRAINT `danh_gia_khoa_hoc_ibfk_2` FOREIGN KEY (`khoa_hoc_id`) REFERENCES `khoa_hoc` (`id`);

--
-- Các ràng buộc cho bảng `khoa_hoc`
--
ALTER TABLE `khoa_hoc`
  ADD CONSTRAINT `khoa_hoc_ibfk_1` FOREIGN KEY (`danh_muc_id`) REFERENCES `danh_muc_khoa_hoc` (`id`);

--
-- Các ràng buộc cho bảng `luu_bai_viet`
--
ALTER TABLE `luu_bai_viet`
  ADD CONSTRAINT `luu_bai_viet_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`),
  ADD CONSTRAINT `luu_bai_viet_ibfk_2` FOREIGN KEY (`bai_viet_id`) REFERENCES `bai_viet_dien_dan` (`id`);

--
-- Các ràng buộc cho bảng `thich_bai_viet`
--
ALTER TABLE `thich_bai_viet`
  ADD CONSTRAINT `thich_bai_viet_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`),
  ADD CONSTRAINT `thich_bai_viet_ibfk_2` FOREIGN KEY (`bai_viet_id`) REFERENCES `bai_viet_dien_dan` (`id`);

--
-- Các ràng buộc cho bảng `thong_bao`
--
ALTER TABLE `thong_bao`
  ADD CONSTRAINT `thong_bao_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`);

--
-- Các ràng buộc cho bảng `tien_do_hoc`
--
ALTER TABLE `tien_do_hoc`
  ADD CONSTRAINT `tien_do_hoc_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`),
  ADD CONSTRAINT `tien_do_hoc_ibfk_2` FOREIGN KEY (`bai_hoc_id`) REFERENCES `bai_hoc` (`id`);

--
-- Các ràng buộc cho bảng `tra_loi_binh_luan`
--
ALTER TABLE `tra_loi_binh_luan`
  ADD CONSTRAINT `tra_loi_binh_luan_ibfk_1` FOREIGN KEY (`binh_luan_id`) REFERENCES `binh_luan_bai_viet` (`id`),
  ADD CONSTRAINT `tra_loi_binh_luan_ibfk_2` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`);

--
-- Các ràng buộc cho bảng `yeu_thich_khoa_hoc`
--
ALTER TABLE `yeu_thich_khoa_hoc`
  ADD CONSTRAINT `yeu_thich_khoa_hoc_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`),
  ADD CONSTRAINT `yeu_thich_khoa_hoc_ibfk_2` FOREIGN KEY (`khoa_hoc_id`) REFERENCES `khoa_hoc` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
