# Chức năng Mua Khóa Học & Thanh Toán VNPay

## Tổng quan

Ứng dụng sử dụng cổng thanh toán **VNPay** (Việt Nam) để xử lý thanh toán khóa học trực tuyến. Flow:

1. User click "Mua khóa học" → redirect tới `PurchaseController`
2. Kiểm tra đăng nhập, nếu chưa đăng nhập → quay lại trang login
3. Tạo đơn hàng + thanh toán trong database
4. Tạo URL thanh toán VNPay → redirect user tới VNPay
5. User thanh toán thành công trên VNPay
6. VNPay callback tới `PaymentCallbackController` để cập nhật trạng thái
7. User được redirect về app → được access khóa học

## Database Schema

```sql
-- Bảng đơn hàng
don_hang (id, user_id, tong_tien, trang_thai, ngay_tao, ngay_cap_nhat)

-- Chi tiết đơn hàng (khóa học trong đơn)
chi_tiet_don (id, don_hang_id, khoa_hoc_id, gia_ban, ngay_tao)

-- Thông tin thanh toán
thanh_toan (id, don_hang_id, phuong_thuc, ma_giao_dich, trang_thai, gia_tri, mota, ngay_tao, ngay_cap_nhat)

-- Đăng ký khóa học (user sở hữu khóa học)
dang_ky_khoa_hoc (id, user_id, khoa_hoc_id, dang_ky_luc, hoan_thanh_luc, tien_do, trang_thai)
```

Để chạy migration:
```bash
mysql -u root -p webhoctap < docs/payment_schema.sql
```

## Components

### 1. Models

- **`Order`** (`models/Order.php`)
  - `create(userId, totalPrice)` → tạo đơn hàng
  - `addItem(orderId, courseId, price)` → thêm khóa học vào đơn
  - `getItems(orderId)` → lấy danh sách khóa học
  - `updateStatus(orderId, status)` → cập nhật trạng thái (pending, completed, failed, cancelled)

- **`Enrollment`** (`models/Enrollment.php`)
  - `enroll(userId, courseId)` → đăng ký user cho khóa học
  - `isEnrolled(userId, courseId)` → kiểm tra user đã mua chưa
  - `getCoursesByUser(userId)` → lấy danh sách khóa học của user
  - `updateProgress(userId, courseId, progress)` → cập nhật tiến độ học

- **`Payment`** (`models/Payment.php`)
  - `create(orderId, method, amount)` → tạo bản ghi thanh toán
  - `updateTransactionId(paymentId, transactionId)` → ghi lại mã giao dịch từ VNPay
  - `updateStatus(paymentId, status, description)` → cập nhật trạng thái thanh toán

### 2. Services

- **`VNPayService`** (`services/VNPayService.php`)
  - `createPaymentUrl(orderId, amount, orderInfo)` → tạo URL thanh toán VNPay
  - `verifyReturn(vnpParams)` → xác minh callback từ VNPay (kiểm tra chữ ký)
  - `fromEnvironment()` → khởi tạo từ biến môi trường

### 3. Controllers

- **`PurchaseController`** (`controllers/PurchaseController.php`)
  - Action `checkout`: tạo đơn + redirect VNPay
  - Action `success`: xử lý sau khi VNPay redirect user về (user view)
  - Action `cancel`: user hủy thanh toán

- **`PaymentCallbackController`** (`controllers/PaymentCallbackController.php`)
  - Callback từ VNPay (background IPN)
  - Xác minh chữ ký + cập nhật database

## Cấu hình VNPay

### Bước 1: Tạo tài khoản VNPay

1. Đăng ký tài khoản business tại https://vnpayment.vn
2. Lấy thông tin:
   - **TMN Code** (Mã cửa hàng)
   - **Secret Key** (Khóa bí mật)

### Bước 2: Cập nhật `.env`

```env
VNPAY_TMN_CODE=YOUR_TMN_CODE
VNPAY_SECRET_KEY=YOUR_SECRET_KEY
VNPAY_URL=https://sandbox.vnpayment.vn/paygate  # Sandbox (test)
# Hoặc production: https://api.vnpayment.vn/paygate
VNPAY_RETURN_URL=http://localhost/webhoctap/controllers/PurchaseController.php?action=success
```

### Bước 3: Cấu hình Redirect URI trên VNPay Admin

- **Return URL** (user redirect): `http://localhost/webhoctap/controllers/PurchaseController.php?action=success`
- **Notify URL** (callback): `http://localhost/webhoctap/controllers/PaymentCallbackController.php`
- **Sandbox / Production**: Chọn sandbox để test, production khi deploy

## Cách sử dụng

### Từ trang khóa học

```html
<a href="../controllers/PurchaseController.php?action=checkout&course_id=<?php echo $courseId; ?>" 
   class="btn btn-primary">Mua khóa học</a>
```

### Flow hoàn chỉnh

1. **User click nút "Mua khóa học"**
   ```
   GET /controllers/PurchaseController.php?action=checkout&course_id=5
   ```

2. **Server tạo đơn hàng**
   ```php
   $orderId = $orderModel->create($userId, $coursePrice);
   $orderModel->addItem($orderId, $courseId, $coursePrice);
   $paymentId = $paymentModel->create($orderId, 'vnpay', $coursePrice);
   ```

3. **Redirect tới VNPay**
   ```php
   $paymentUrl = $vnpayService->createPaymentUrl($orderId, $coursePrice, 'Khóa React');
   header('Location: ' . $paymentUrl);
   ```

4. **User thanh toán trên VNPay** (ngoài ứng dụng)

5. **VNPay callback** (background)
   ```
   POST /controllers/PaymentCallbackController.php?vnp_ResponseCode=00&vnp_TxnRef=...
   ```
   - Xác minh chữ ký
   - Cập nhật `don_hang.trang_thai = 'completed'`
   - Cập nhật `thanh_toan.trang_thai = 'success'`
   - Tạo enrollment cho user

6. **User redirect (user view)**
   ```
   GET /controllers/PurchaseController.php?action=success&vnp_ResponseCode=00&vnp_TxnRef=...
   ```
   - Tương tự như callback (do VNPay redirect user)
   - User thấy trang "Thanh toán thành công"

## Bảo mật

- ✅ Chữ ký HMAC SHA512: xác minh mọi request từ VNPay
- ✅ Session validation: kiểm tra `state` hoặc user_id để tránh forging
- ✅ Webhook logging: lưu callback để audit
- ✅ HTTPS (production): bắt buộc để trao đổi dữ liệu nhạy cảm

## Lỗi phổ biến & Cách fix

| Lỗi | Nguyên nhân | Cách fix |
|-----|-----------|---------|
| "Chữ ký không hợp lệ" | Secret key sai hoặc tham số bị thay đổi | Kiểm tra VNPAY_SECRET_KEY, tắt proxy/cache |
| "Không tìm thấy đơn hàng" | Order ID không tồn tại | Kiểm tra txnRef format, database consistency |
| Callback không xử lý | PaymentCallbackController không được gọi | Kiểm tra VNPAY_NOTIFY_URL hoặc firewall |
| User không được access khóa học | Enrollment chưa được tạo | Kiểm tra callback/success controller logic |

## Testing

### Sandbox (Test)

- URL: `https://sandbox.vnpayment.vn/paygate`
- Thẻ test:
  - Visa: `4111111111111111` | Exp: `07/25` | OTP: `123456`
  - MasterCard: `5555555555554444` | Exp: `07/25` | OTP: `123456`

### Test flow

```bash
1. Khởi động server (XAMPP)
2. Mở: http://localhost/webhoctap/pages/course-detail.php?id=1
3. Click "Mua khóa học"
4. Chọn thẻ test, nhập OTP
5. Kiểm tra database: don_hang.trang_thai = 'completed'
6. Kiểm tra enrollments: user được thêm vào khóa học
```

## Todo

- [ ] Thêm payment retry logic (nếu callback thất bại)
- [ ] Thêm invoice generation & email
- [ ] Thêm refund flow
- [ ] Support thêm cổng: Stripe, PayPal
- [ ] Dashboard admin: xem order, doanh thu, refund
- [ ] User my-courses page: hiển thị khóa học đã mua

