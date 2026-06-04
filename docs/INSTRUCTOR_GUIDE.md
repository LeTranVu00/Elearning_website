# 🎓 Hướng Dẫn Chức Năng Quản Lý Bài Học - Giảng Viên

## 📋 Tổng Quan

Hệ thống cho phép giảng viên quản lý toàn bộ nội dung khóa học, bao gồm:
- 📚 Tạo chương tổ chức cho khóa học
- 📝 Tạo và chỉnh sửa bài học
- ⬆️ Upload file bài giảng (PDF, PowerPoint, Video)
- 📋 Upload bài tập cho học viên
- 🔗 Chia sẻ link học trực tuyến (Zoom, Teams, Google Meet)
- 📂 Quản lý tài nguyên giáo dục

---

## 🚀 Hướng Dẫn Sử Dụng

### 1️⃣ Chuẩn Bị Cơ Sở Dữ Liệu

Trước hết, cần chạy script SQL để mở rộng database:

```bash
# Bật terminal, cd vào thư mục dự án
cd d:\xampp\htdocs\webhoctap

# Import script SQL (qua phpMyAdmin hoặc MySQL CLI)
mysql -u root -p web_hoc_truc_tuyen < docs/extend_database.sql
```

**Script này sẽ tạo:**
- ✅ Bảng `chuong` (Chương)
- ✅ Bảng `tai_lieu_bai_hoc` (Tài liệu bài học)
- ✅ Bảng `nop_bai_tap` (Nộp bài tập)
- ✅ Cập nhật các trường cần thiết trong bảng hiện có

### 2️⃣ Cập Nhật Vai Trò Người Dùng

Cập nhật vai trò của giảng viên từ `user` thành `instructor`:

```sql
UPDATE nguoi_dung SET vai_tro = 'instructor' WHERE id = YOUR_INSTRUCTOR_ID;
```

### 3️⃣ Truy Cập Tính Năng

**Giảng viên truy cập tại:**
- 📍 `index.php?page=instructor-courses` - Danh sách khóa học của giảng viên
- 📍 `index.php?page=instructor-course&id=COURSE_ID` - Quản lý một khóa học cụ thể
- 📍 `index.php?page=instructor-lesson-edit&id=LESSON_ID` - Chỉnh sửa bài học

---

## 📖 Quy Trình Tạo Bài Học

### Bước 1: Truy cập danh sách khóa học
1. Đăng nhập với tư cách giảng viên
2. Truy cập **"Quản Lý Khóa Học"** (hoặc link: `?page=instructor-courses`)
3. Click nút **"Quản Lý"** trên khóa học cần chỉnh sửa

### Bước 2: Tạo Chương (tuỳ chọn)
1. Ở phần **"➕ Thêm Chương Mới"** (bên phải màn hình)
2. Nhập **"Tiêu đề chương"** (bắt buộc)
3. Nhập **"Mô tả"** (tùy chọn)
4. Click **"Thêm chương"**

**Ví dụ:**
```
Tiêu đề: Chapter 1 - Overview
Mô tả: Giới thiệu chung về khóa học
```

### Bước 3: Tạo Bài Học
1. Ở phần **"➕ Thêm Bài Học Mới"** (bên phải màn hình)
2. **Chọn chương** (nếu muốn tổ chức theo chương)
3. Nhập **"Tiêu đề bài học"** (bắt buộc)
4. Nhập **"Nội dung bài học"** (tùy chọn, hỗ trợ HTML)
5. Click **"Thêm bài học"**

**Ví dụ:**
```
Tiêu đề: Getting Started with C++ and IDE Tools
Nội dung: 
  <h3>Mục tiêu bài học:</h3>
  <ul>
    <li>Cài đặt môi trường phát triển</li>
    <li>Viết chương trình đầu tiên</li>
  </ul>
```

### Bước 4: Upload File & Thêm Tài Liệu
1. Click vào bài học để **"Chỉnh sửa"**
2. Trên giao diện chỉnh sửa, bạn sẽ thấy:

#### 📹 Upload Bài Giảng
- **Loại:** Bài Giảng
- **File:** PDF, PowerPoint, Video (tối đa 50MB)
- **Mô tả:** "Bài giảng về Operators"
- Click **"Upload"**

#### 📝 Upload Bài Tập
- **Loại:** Bài Tập
- **File:** Đề bài, sample code
- **Mô tả:** "Lab 3.1: Implement the insertion operator"
- Click **"Upload"**

#### 📚 Upload Tài Nguyên Khác
- **Loại:** Tài Nguyên
- **File:** Sách, tài liệu tham khảo
- **Mô tả:** "Reference book: Modern C++ Design"
- Click **"Upload"**

### Bước 5: Thêm Link Học Trực Tuyến
1. Ở phần **"🔗 Thêm Link Học Trực Tuyến"** (bên phải)
2. Nhập **URL**:
   ```
   https://zoom.us/j/123456789?pwd=xxxxx
   ```
3. Nhập **Mô tả**:
   ```
   Zoom Meeting - Lớp Thứ 2 lúc 19:00
   ```
4. Click **"Thêm Link"**

---

## 📊 Cấu Trúc Thư Mục

Sau khi tạo thành công, cấu trúc sẽ như sau:

```
webhoctap/
├── assets/
│   └── uploads/
│       └── lessons/
│           ├── lesson_1_1622548800_abc123.pdf
│           ├── lesson_2_1622549000_def456.ppt
│           └── lesson_3_1622549200_ghi789.zip
├── controllers/
│   ├── InstructorController.php ✨ [MỚI]
│   └── ... (các controller khác)
├── models/
│   ├── Lesson.php ✨ [MỚI]
│   └── ... (các model khác)
├── pages/
│   ├── instructor-courses.php ✨ [MỚI]
│   ├── instructor-course.php ✨ [MỚI]
│   ├── instructor-lesson-edit.php ✨ [MỚI]
│   ├── instructor-chapter-edit.php ✨ [MỚI]
│   ├── instructor-chapter-delete.php ✨ [MỚI]
│   ├── instructor-lesson-delete.php ✨ [MỚI]
│   └── ... (các page khác)
└── docs/
    ├── extend_database.sql ✨ [MỚI]
    └── ... (tài liệu khác)
```

---

## 🗄️ Cấu Trúc Database (Mới)

### Bảng `chuong` (Chương)
```sql
CREATE TABLE chuong (
  id INT PRIMARY KEY AUTO_INCREMENT,
  khoa_hoc_id INT,           -- Khóa học chứa chương này
  tieu_de VARCHAR(255),      -- Tiêu đề chương
  mo_ta TEXT,                -- Mô tả
  thu_tu INT,                -- Thứ tự hiển thị
  trang_thai ENUM('hien','an'), -- Hiển thị/Ẩn
  created_at DATETIME,
  updated_at DATETIME
);
```

### Bảng `tai_lieu_bai_hoc` (Tài liệu Bài Học)
```sql
CREATE TABLE tai_lieu_bai_hoc (
  id INT PRIMARY KEY AUTO_INCREMENT,
  bai_hoc_id INT,            -- Bài học chứa tài liệu này
  loai ENUM('lecture','exercise','resource','link'), -- Loại tài liệu
  ten_file VARCHAR(255),     -- Tên tài liệu
  duong_dan_file VARCHAR(500), -- Đường dẫn file (nếu là file)
  url_link VARCHAR(500),     -- URL (nếu là link)
  mo_ta TEXT,                -- Mô tả
  kich_thuoc_file INT,       -- Kích thước file (bytes)
  thu_tu INT,                -- Thứ tự
  trang_thai ENUM('hien','an'),
  created_at DATETIME,
  updated_at DATETIME
);
```

---

## 🔒 Kiểm Soát Quyền

- **Giảng viên (instructor):** Chỉ có thể quản lý khóa học của chính mình
- **Admin:** Có quyền truy cập tất cả
- **Học viên (user):** Không có quyền truy cập

**Cách cập nhật vai trò:**
```sql
-- Cấp quyền giảng viên
UPDATE nguoi_dung SET vai_tro = 'instructor' WHERE id = 5;

-- Cấp quyền admin
UPDATE nguoi_dung SET vai_tro = 'admin' WHERE id = 1;

-- Cấp quyền học viên
UPDATE nguoi_dung SET vai_tro = 'user' WHERE id = 10;
```

---

## 🐛 Xử Lý Lỗi Thường Gặp

### ❌ "Bạn không có quyền quản lý khóa học này"
**Nguyên nhân:** 
- Bạn không phải là giảng viên của khóa học
- Vai trò của bạn không phải `instructor`

**Giải pháp:**
```sql
UPDATE khoa_hoc SET giang_vien_id = YOUR_USER_ID WHERE id = COURSE_ID;
UPDATE nguoi_dung SET vai_tro = 'instructor' WHERE id = YOUR_USER_ID;
```

### ❌ "Lỗi upload file"
**Nguyên nhân:**
- File quá lớn (tối đa 50MB)
- Định dạng file không được hỗ trợ
- Folder uploads không có quyền ghi

**Giải pháp:**
```bash
# Cấp quyền ghi cho thư mục uploads
chmod -R 755 assets/uploads/
```

### ❌ "Thư mục uploads không tồn tại"
**Giải pháp:**
```bash
mkdir -p assets/uploads/lessons
chmod 755 assets/uploads/lessons
```

---

## 💾 Backup Dữ Liệu

Để backup dữ liệu, chạy lệnh:

```bash
# Backup database
mysqldump -u root -p web_hoc_truc_tuyen > backup_database.sql

# Backup file uploads
xcopy assets\uploads\lessons\ backup\lessons\ /E /I
```

---

## 📞 Hỗ Trợ

Nếu gặp vấn đề, kiểm tra:
1. ✅ Database đã được mở rộng?
2. ✅ Vai trò người dùng là `instructor`?
3. ✅ Folder `assets/uploads/lessons/` có tồn tại?
4. ✅ Kiểm tra file `InstructorController.php` có lỗi gì không?
5. ✅ Xem log lỗi trong browser console

---

**Phiên bản:** v1.0  
**Ngày cập nhật:** 2026-06-03  
**Tác giả:** Copilot
