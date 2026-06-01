# Google SSO (Đăng nhập / Đăng ký) – Flow & Hướng dẫn

Mô tả ngắn: ứng dụng sử dụng Google OpenID Connect để cho phép người dùng đăng nhập/đăng ký bằng tài khoản Google.

1) Biến môi trường cần cấu hình

- `GOOGLE_CLIENT_ID`
- `GOOGLE_CLIENT_SECRET`
- (tuỳ chọn) `GOOGLE_REDIRECT_URI` — nếu không cấu hình sẽ dùng redirect mặc định do `GoogleOAuthConfig::buildDefaultRedirectUri()` tạo.

2) Luồng hoạt động (tóm tắt)

- Người dùng click vào nút/đường dẫn khởi tạo SSO → gọi `controllers/GoogleAuthController.php`.
- `GoogleAuthController::redirectToGoogle()` tạo `state` (lưu vào session) và chuyển hướng tới URL ủy quyền Google (do `GoogleOAuthConfig::buildAuthorizationUrl()` tạo).
- Sau khi người dùng cấp quyền, Google gọi lại `controllers/GoogleAuthController.php?action=callback` với `code` và `state`.
- Controller kiểm tra `state` (so sánh bằng `hash_equals`) để chống CSRF, sau đó gọi `GoogleOAuthService::exchangeCodeForToken()` để lấy token, rồi `getUserInfo()` lấy thông tin user từ `userinfo` endpoint.
- Nếu email hợp lệ và `email_verified` = true → map thành dữ liệu:
  - tìm user theo `google_id` (`User::findByGoogleId`)
  - nếu tồn tại → đăng nhập
  - nếu không tồn tại nhưng có user cùng `email` → gọi `User::linkGoogleAccount()` để liên kết
  - nếu không tồn tại email nào → tạo `User::createFromGoogle()` và đăng nhập
- Cuối cùng gọi `SessionManager::login($user)` (tái tạo session id để chống session-fixation) và redirect về `pages/home.php`.

3) Đăng xuất

- `controllers/LogoutController.php` gọi `SessionManager::logout()` để xóa session + cookie, rồi redirect về `pages/login.php`.

4) Những điểm cần lưu ý / khuyến nghị

- Giao diện: nút Google trên `pages/login.php` và `pages/register.php` đã là liên kết tới `../controllers/GoogleAuthController.php`, nên cùng một luồng có thể đăng nhập hoặc tự động đăng ký.
- Database: bảng `nguoi_dung` cần có `google_id` và `auth_provider`. File `web_hoc_truc_tuyen.sql` đã được cập nhật cho lần import mới.
- Xác thực token: hiện hệ thống lấy userinfo và kiểm tra `email_verified`. Đây là hợp lý, nhưng nếu cần an toàn cao hơn thì nên verify `id_token` (chữ ký JWT) bằng thư viện chính thức hoặc JWKS của Google.
- HTTPS: redirect URI phải là HTTPS trên production và khớp chính xác với cấu hình trong Google Console.
- Cơ chế dự phòng: `GoogleOAuthService` dùng `curl` nếu có, ngược lại dùng `file_get_contents`; đảm bảo server bật `curl` hoặc `allow_url_fopen`.
- Bảo mật session/cookie: đảm bảo `session.cookie_secure = true` (HTTPS), `session.cookie_httponly = true` và `SameSite` phù hợp.
- Xử lý lỗi rõ ràng: hiện đã lưu flash errors vào session (`SessionManager::setErrors`) — tốt.
- Rate limiting / logging: cân nhắc log các callback thất bại để điều tra và giới hạn tần suất gọi API nếu cần.

5) Nơi cần chỉnh nhỏ (cụ thể)

- Nếu database đã import trước đó, chạy thêm SQL:

```sql
ALTER TABLE nguoi_dung
  ADD COLUMN google_id varchar(255) DEFAULT NULL AFTER avatar,
  ADD COLUMN auth_provider enum('local','google') DEFAULT 'local' AFTER google_id,
  ADD UNIQUE KEY google_id (google_id);
```

6) Tóm tắt kết luận

- Cấu trúc hiện tại hợp lý: state CSRF, trao đổi code → token → userinfo, liên kết/tạo account, lưu session.
- Hành động nhanh bạn nên làm ngay: đảm bảo biến môi trường `GOOGLE_CLIENT_ID`/`GOOGLE_CLIENT_SECRET` đã đặt và redirect URI trong Google Console trùng với ứng dụng.

--
File này do kiểm tra nhanh code tạo tự động; cần giúp chỉnh UI hoặc verify trên môi trường dev thì báo mình.
