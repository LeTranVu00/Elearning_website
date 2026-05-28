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
-- Cấu trúc bảng cho bảng `chi_tiet_thanh_toan`
--

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
  `ngay_dang_ky` datetime DEFAULT current_timestamp(),
  `trang_thai` enum('dang_hoc','hoan_thanh') DEFAULT NULL
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
  `muc_do` enum('co_ban','trung_binh','nang_cao') DEFAULT NULL,
  `trang_thai` enum('hien','an') DEFAULT NULL,
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
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `tong_tien` decimal(10,2) DEFAULT NULL,
  `phuong_thuc` varchar(100) DEFAULT NULL,
  `ma_giao_dich` varchar(255) DEFAULT NULL,
  `trang_thai` enum('cho','thanh_cong','that_bai') DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
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
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`);

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
-- Các ràng buộc cho bảng `bai_hoc`
--
ALTER TABLE `bai_hoc`
  ADD CONSTRAINT `bai_hoc_ibfk_1` FOREIGN KEY (`khoa_hoc_id`) REFERENCES `khoa_hoc` (`id`);

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
-- Các ràng buộc cho bảng `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD CONSTRAINT `thanh_toan_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`);

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
