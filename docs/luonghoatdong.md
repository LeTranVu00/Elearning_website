# Cấu trúc và luồng hoạt động của dự án Web Học Tập

Dự án này được tổ chức rất rõ ràng, tuân theo mô hình tựa như MVC (Model-View-Controller) kết hợp với các Services và Helpers bằng PHP thuần.

## 1. Cấu trúc thư mục chính

*   **`pages/`**: Nơi chứa giao diện hiển thị cho người dùng (Views).
    *   Các trang chính: `home.php` (Trang chủ), `about.php` (Giới thiệu), `contact.php` (Liên hệ), `courses.php` (Danh sách khóa học), `course-detail.php` (Chi tiết khóa học).
    *   Các trang người dùng: `login.php`, `register.php`, `profile.php`.
    *   Các trang chức năng khác: `admin.php` (Bảng điều khiển admin), `forum.php` (Diễn đàn/Thảo luận).
    *   Thư mục con `instructor/`: Chứa các trang dành riêng cho giảng viên.
*   **`controllers/`**: Chứa các file xử lý logic (Controllers), nhận dữ liệu từ người dùng (qua views) và gọi Models để xử lý dữ liệu.
    *   Xác thực: `AuthController.php`, `RegisterController.php`, `LogoutController.php`, `GoogleAuthController.php`.
    *   Chức năng: `InstructorController.php` (Logic của giảng viên).
    *   Thanh toán: `PurchaseController.php` (Xử lý mua khóa học), `PaymentCallbackController.php` (Xử lý phản hồi từ cổng thanh toán).
*   **`models/`**: Chứa các lớp tương tác trực tiếp với cơ sở dữ liệu.
    *   `User.php` (Người dùng), `Course.php` (Khóa học), `Lesson.php` (Bài học).
    *   `Order.php` (Đơn hàng), `Payment.php` (Thanh toán), `Enrollment.php` (Đăng ký học).
*   **`core/`**: Chứa các cấu hình cốt lõi của hệ thống.
    *   `Database.php`: Lớp kết nối CSDL (thường dùng PDO hoặc MySQLi).
    *   `SessionManager.php`: Quản lý session người dùng (đăng nhập, phân quyền).
    *   `BaseController.php`: Lớp Controller cơ sở chứa các hàm dùng chung.
    *   `GoogleOAuthConfig.php` & `google_env.php`: Cấu hình đăng nhập bằng Google.
    *   `Exceptions.php`: Xử lý ngoại lệ/lỗi.
*   **`services/`**: Xử lý các nghiệp vụ với bên thứ 3 (Third-party integrations).
    *   `MomoService.php` & `VNPayService.php`: Tích hợp thanh toán qua ví Momo và VNPAY.
    *   `GoogleOAuthService.php`: Tích hợp API đăng nhập Google.
*   **`components/`**: Chứa các thành phần giao diện dùng chung (để `include` vào các trang).
    *   `header.php` (Thanh điều hướng trên cùng) & `footer.php` (Chân trang).
*   **`helpers/`**: Chứa các hàm hỗ trợ độc lập.
    *   `ValidationHelper.php`: Lớp hỗ trợ kiểm tra và chuẩn hóa dữ liệu đầu vào (ví dụ kiểm tra email hợp lệ, mật khẩu đủ mạnh).
*   **`assets/`**: Chứa các tài nguyên tĩnh.
    *   `css/`, `js/`, `images/` và `uploads/` (nơi lưu trữ ảnh hoặc tài liệu người dùng tải lên).
*   **`api/`**: Nơi xử lý các request AJAX hoặc API nội bộ (hiện có `category-action.php`).

## 2. Các file quan trọng ở thư mục gốc

*   **`index.php`**: File chạy đầu tiên, hiện tại nó chỉ làm nhiệm vụ chuyển hướng (`redirect`) người dùng thẳng vào trang `pages/home.php`.
*   **`.env`**: Nơi lưu các biến môi trường nhạy cảm như thông tin kết nối Database, API Key của Momo, VNPay, Google.
*   **`web_hoc_truc_tuyen.sql`**: File backup chứa toàn bộ cấu trúc bảng và dữ liệu mẫu của CSDL.
*   **`.htaccess`**: Cấu hình server Apache (có thể dùng để viết lại URL - URL Rewriting hoặc bảo mật thư mục).

---

## 3. Luồng hoạt động cơ bản

Luồng hoạt động của web thường sẽ là:
1.  Người dùng truy cập vào trang ở `pages/`.
2.  Gửi form hoặc gọi AJAX đến `controllers/`.
3.  Controller dùng `ValidationHelper` để kiểm tra dữ liệu đầu vào.
4.  Controller gọi các hàm trong `models/` để Lấy/Thêm/Sửa/Xóa dữ liệu vào Database.
5.  Trả kết quả về cho View (hiển thị trang mới hoặc JSON nếu là AJAX).
6.  Nếu có liên quan đến thanh toán hoặc đăng nhập bên thứ 3, các Controller sẽ gọi qua `services/`.
