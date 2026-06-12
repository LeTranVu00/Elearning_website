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

-- Bảng chi_tiet_thanh_toan đã được thay thế bởi chi_tiet_don (xem bên dưới)

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
  `vai_tro` enum('admin','user', 'instructor') DEFAULT 'user',
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
  `phuong_thuc` enum('momo','vnpay','stripe','paypal','cod','manual') DEFAULT 'momo',
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

-- (Bảng chi_tiet_thanh_toan đã bị xóa - không cần index)

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

-- (Bảng chi_tiet_thanh_toan đã bị xóa - không cần AUTO_INCREMENT)

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

-- ============================================================================
-- EXTENSION: Chức năng Quản Lý Bài Học Cho Giảng Viên
-- ============================================================================

--
-- Cấu trúc bảng cho bảng `chuong`
--
CREATE TABLE `chuong` (
  `id` int(11) NOT NULL,
  `khoa_hoc_id` int(11) NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `thu_tu` int(11) DEFAULT 0,
  `trang_thai` enum('hien','an') DEFAULT 'hien',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Cấu trúc bảng cho bảng `tai_lieu_bai_hoc`
--
CREATE TABLE `tai_lieu_bai_hoc` (
  `id` int(11) NOT NULL,
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
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Cấu trúc bảng cho bảng `nop_bai_tap`
--
CREATE TABLE `nop_bai_tap` (
  `id` int(11) NOT NULL,
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
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Cập nhật bảng `bai_hoc` - Thêm cột chuong_id
--
ALTER TABLE `bai_hoc` ADD COLUMN `chuong_id` int(11) DEFAULT NULL AFTER `khoa_hoc_id`;
ALTER TABLE `bai_hoc` ADD COLUMN `mo_ta_chi_tiet` longtext DEFAULT NULL AFTER `noi_dung`;
ALTER TABLE `bai_hoc` ADD COLUMN `link_video_truc_tuyen` varchar(500) DEFAULT NULL AFTER `video`;
ALTER TABLE `bai_hoc` ADD COLUMN `trang_thai` enum('hien','an') DEFAULT 'hien' AFTER `thu_tu`;

--
-- Cập nhật bảng `khoa_hoc` - Thêm cột giang_vien_id
--
ALTER TABLE `khoa_hoc` ADD COLUMN `giang_vien_id` int(11) DEFAULT NULL AFTER `giang_vien`;

--
-- Cập nhật bảng `nguoi_dung` - Mở rộng vai_tro để bao gồm 'instructor'
--
ALTER TABLE `nguoi_dung` MODIFY `vai_tro` enum('admin','user','instructor') DEFAULT 'user';

--
-- Chỉ mục cho bảng `chuong`
--
ALTER TABLE `chuong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `khoa_hoc_id` (`khoa_hoc_id`);

--
-- Chỉ mục cho bảng `tai_lieu_bai_hoc`
--
ALTER TABLE `tai_lieu_bai_hoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bai_hoc_id` (`bai_hoc_id`);

--
-- Chỉ mục cho bảng `nop_bai_tap`
--
ALTER TABLE `nop_bai_tap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tai_lieu_bai_tap_id` (`tai_lieu_bai_tap_id`),
  ADD KEY `hoc_vien_id` (`hoc_vien_id`);

--
-- Chỉ mục cho bảng `bai_hoc` - Thêm chỉ mục cho chuong_id
--
ALTER TABLE `bai_hoc` ADD KEY `chuong_id` (`chuong_id`);

--
-- Chỉ mục cho bảng `khoa_hoc` - Thêm chỉ mục cho giang_vien_id
--
ALTER TABLE `khoa_hoc` ADD KEY `giang_vien_id` (`giang_vien_id`);

--
-- AUTO_INCREMENT cho bảng `chuong`
--
ALTER TABLE `chuong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tai_lieu_bai_hoc`
--
ALTER TABLE `tai_lieu_bai_hoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `nop_bai_tap`
--
ALTER TABLE `nop_bai_tap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho bảng `chuong`
--
ALTER TABLE `chuong`
  ADD CONSTRAINT `fk_chuong_khoa_hoc` FOREIGN KEY (`khoa_hoc_id`) REFERENCES `khoa_hoc` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tai_lieu_bai_hoc`
--
ALTER TABLE `tai_lieu_bai_hoc`
  ADD CONSTRAINT `fk_tai_lieu_bai_hoc_bai_hoc` FOREIGN KEY (`bai_hoc_id`) REFERENCES `bai_hoc` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `nop_bai_tap`
--
ALTER TABLE `nop_bai_tap`
  ADD CONSTRAINT `fk_nop_bai_tap_tai_lieu` FOREIGN KEY (`tai_lieu_bai_tap_id`) REFERENCES `tai_lieu_bai_hoc` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_nop_bai_tap_hoc_vien` FOREIGN KEY (`hoc_vien_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `bai_hoc` - Thêm ràng buộc cho chuong_id
--
ALTER TABLE `bai_hoc`
  ADD CONSTRAINT `fk_bai_hoc_chuong` FOREIGN KEY (`chuong_id`) REFERENCES `chuong` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `khoa_hoc` - Thêm ràng buộc cho giang_vien_id
--
ALTER TABLE `khoa_hoc`
  ADD CONSTRAINT `fk_khoa_hoc_giang_vien` FOREIGN KEY (`giang_vien_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE SET NULL;
