<?php
/**
 * ============================================================================
 * FILE: services/VNPayService.php
 * MỤC ĐÍCH: Tích hợp cổng thanh toán VNPay
 * ============================================================================
 * 
 * Cấu hình VNPay: thêm các biến vào .env
 * VNPAY_TMN_CODE = Mã terminal (lấy từ VNPay)
 * VNPAY_SECRET_KEY = Secret key (lấy từ VNPay)
 * VNPAY_URL = https://sandbox.vnpayment.vn/paygate (sandbox) hoặc production URL
 * VNPAY_RETURN_URL = URL return sau khi thanh toán
 */

class VNPayService
{
    private string $tmnCode;
    private string $secretKey;
    private string $vnpayUrl;
    private string $returnUrl;

    public function __construct(string $tmnCode, string $secretKey, string $vnpayUrl, string $returnUrl)
    {
        $this->tmnCode = $tmnCode;
        $this->secretKey = $secretKey;
        $this->vnpayUrl = $vnpayUrl;
        $this->returnUrl = $returnUrl;
    }

    /**
     * Tạo URL thanh toán VNPay
     *
     * @param int $orderId ID đơn hàng
     * @param float $amount Số tiền (đơn vị: VND)
     * @param string $orderInfo Mô tả đơn hàng
     * @return string URL thanh toán
     */
    public function createPaymentUrl(int $orderId, float $amount, string $orderInfo = ''): string
    {
        // Chuyển tiền sang đơn vị nhỏ nhất (VND không có chữ số thập phân)
        $amountInVND = (int)($amount * 100);

        // Tạo mảng tham số
        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->tmnCode,
            "vnp_Amount" => $amountInVND,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $this->getClientIP(),
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => $orderInfo ?: "Don hang #{$orderId}",
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $this->returnUrl,
            "vnp_TxnRef" => $orderId . time(), // Mã tham chiếu duy nhất
        ];

        // Sắp xếp theo key
        ksort($inputData);

        // Tạo URL params
        $hashData = "";
        $query = "";
        foreach ($inputData as $key => $value) {
            $hashData .= '&' . urlencode($key) . "=" . urlencode((string)$value);
            $query .= urlencode($key) . "=" . urlencode((string)$value) . '&';
        }
        $hashData = ltrim($hashData, '&');

        // Ký (sign) yêu cầu
        $vnp_SecureHash = hash_hmac('sha512', $hashData, $this->secretKey);

        // URL thanh toán
        $paymentUrl = $this->vnpayUrl . "?" . $query . "vnp_SecureHash=" . $vnp_SecureHash;

        return $paymentUrl;
    }

    /**
     * Xác minh callback từ VNPay (sau khi người dùng thanh toán)
     *
     * @param array $vnpParams Tham số trả về từ VNPay ($_GET)
     * @return array ['success' => bool, 'message' => string, 'orderId' => int|null, 'amount' => float|null]
     */
    public function verifyReturn(array $vnpParams): array
    {
        // Kiểm tra response code
        if (!isset($vnpParams['vnp_ResponseCode'])) {
            return ['success' => false, 'message' => 'Không nhận được phản hồi từ VNPay'];
        }

        $responseCode = $vnpParams['vnp_ResponseCode'];

        // 00 = thành công, các code khác = thất bại
        if ($responseCode !== '00') {
            $message = $this->getResponseMessage($responseCode);
            return ['success' => false, 'message' => $message];
        }

        // Lấy secure hash từ response
        $vnpSecureHash = $vnpParams['vnp_SecureHash'] ?? '';
        unset($vnpParams['vnp_SecureHash']);
        unset($vnpParams['vnp_SecureHashType']);

        // Sắp xếp theo key và tạo hash
        ksort($vnpParams);
        $hashData = "";
        foreach ($vnpParams as $key => $value) {
            $hashData .= '&' . urlencode($key) . "=" . urlencode((string)$value);
        }
        $hashData = ltrim($hashData, '&');

        $calculatedHash = hash_hmac('sha512', $hashData, $this->secretKey);

        // Kiểm tra signature
        if (!hash_equals($vnpSecureHash, $calculatedHash)) {
            return ['success' => false, 'message' => 'Chữ ký không hợp lệ'];
        }

        // Trích xuất thông tin từ phản hồi
        $txnRef = $vnpParams['vnp_TxnRef'] ?? '';
        $amount = isset($vnpParams['vnp_Amount']) ? (float)$vnpParams['vnp_Amount'] / 100 : 0;

        // Tách orderId từ txnRef (định dạng: orderId . time())
        $orderId = (int)preg_replace('/\d{10}$/', '', $txnRef);

        return [
            'success' => true,
            'message' => 'Thanh toán thành công',
            'orderId' => $orderId,
            'amount' => $amount,
            'transactionId' => $vnpParams['vnp_TransactionNo'] ?? '',
            'bankCode' => $vnpParams['vnp_BankCode'] ?? '',
        ];
    }

    /**
     * Lấy địa chỉ IP của client
     *
     * @return string
     */
    private function getClientIP(): string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        }
        return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
    }

    /**
     * Lấy thông báo từ response code
     *
     * @param string $code Response code
     * @return string Thông báo
     */
    private function getResponseMessage(string $code): string
    {
        $messages = [
            '00' => 'Giao dịch thành công',
            '07' => 'Trừ tiền thành công. Giao dịch bị nghi ngờ (liên hệ với VNPay)',
            '09' => 'Giao dịch không thành công do: Khách hàng hủy giao dịch',
            '10' => 'Giao dịch không thành công do: Không xác thực được do lỗi Authentication',
            '11' => 'Giao dịch không thành công do: Địa chỉ IP & Tên miền không hợp lệ',
            '12' => 'Giao dịch không thành công do: Thẻ/Tài khoản bị khóa',
            '13' => 'Giao dịch không thành công do: Quý khách nhập sai mật khẩu quá số lần quy định',
            '14' => 'Giao dịch không thành công do: Chi tiết karte không đúng',
            '15' => 'Giao dịch không thành công do: Khách hàng vượt quá hạn mức',
            '21' => 'Giao dịch không thành công do: Số tiền không hợp lệ',
            '99' => 'Các lỗi khác (lỗi còn lại, không có trong danh sách mã lỗi đã liệt kê)',
        ];

        return $messages[$code] ?? 'Lỗi không xác định';
    }

    /**
     * Tạo đối tượng từ environment variables
     *
     * @return self
     */
    public static function fromEnvironment(): self
    {
        // Ensure .env loader is available
        $envLoader = __DIR__ . '/../core/google_env.php';
        if (is_readable($envLoader)) {
            require_once $envLoader;
        }

        return new self(
            getenv('VNPAY_TMN_CODE') ?: 'SANDBOX',
            getenv('VNPAY_SECRET_KEY') ?: '',
            getenv('VNPAY_URL') ?: 'https://sandbox.vnpayment.vn/paygate',
            getenv('VNPAY_RETURN_URL') ?: 'http://localhost/webhoctap/controllers/PaymentCallbackController.php'
        );
    }
}
