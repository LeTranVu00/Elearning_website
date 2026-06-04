<?php

class MomoService {
    private $partnerCode;
    private $accessKey;
    private $secretKey;
    private $endpoint;

    public function __construct() {
        require_once __DIR__ . '/../core/google_env.php';
        
        $this->partnerCode = getenv('MOMO_PARTNER_CODE');
        $this->accessKey = getenv('MOMO_ACCESS_KEY');
        $this->secretKey = getenv('MOMO_SECRET_KEY');
        $this->endpoint = getenv('MOMO_ENDPOINT') ?: 'https://test-payment.momo.vn/v2/gateway/api/create';
    }

    /**
     * Create Momo payment URL
     * @param int $orderId Order ID
     * @param int $amount Amount in VND
     * @param string $orderInfo Order description
     * @return array ['url' => payment_url, 'requestId' => request_id, 'orderId' => order_id]
     */
    public function createPaymentUrl($orderId, $amount, $orderInfo = 'Thanh toán khóa học') {
        $requestId = uniqid('momo_' . $orderId . '_');
        $redirectUrl = getenv('MOMO_RETURN_URL') ?: 'http://localhost/webhoctap/controllers/PurchaseController.php?action=success';
        $ipnUrl = getenv('MOMO_IPN_URL') ?: 'http://localhost/webhoctap/controllers/PaymentCallbackController.php?gateway=momo';
        
        // Build raw data for signature
        $rawData = "accessKey=" . $this->accessKey . 
                   "&amount=" . $amount . 
                   "&extraData=" . 
                   "&ipnUrl=" . $ipnUrl . 
                   "&orderId=" . $orderId . 
                   "&orderInfo=" . $orderInfo . 
                   "&partnerCode=" . $this->partnerCode . 
                   "&redirectUrl=" . $redirectUrl . 
                   "&requestId=" . $requestId . 
                   "&requestType=captureWallet";
        
        // Generate signature using HMAC-SHA256
        $signature = hash_hmac('sha256', $rawData, $this->secretKey);
        
        // Prepare request body
        $requestBody = array(
            'partnerCode' => $this->partnerCode,
            'accessKey' => $this->accessKey,
            'requestId' => $requestId,
            'amount' => (int)$amount,
            'orderId' => (string)$orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'extraData' => '',
            'requestType' => 'captureWallet',
            'signature' => $signature,
            'lang' => 'vi'
        );

        // Send request to Momo
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $responseData = json_decode($response, true);

        if ($httpCode !== 200 && empty($responseData)) {
            return [
                'success' => false,
                'message' => 'Momo request failed with code ' . $httpCode,
                'response' => $response
            ];
        }
        
        if (isset($responseData['resultCode']) && $responseData['resultCode'] != 0) {
            return [
                'success' => false,
                'message' => $responseData['message'] ?? 'Momo payment creation failed',
                'response' => $responseData
            ];
        }

        return [
            'success' => true,
            'payUrl' => $responseData['payUrl'],
            'requestId' => $requestId,
            'orderId' => $orderId
        ];
    }

    /**
     * Verify Momo return (redirect after payment)
     * @param array $momoParams Parameters from Momo redirect
     * @return array ['success' => bool, 'message' => string, 'orderId' => int, 'amount' => float, 'transactionId' => string]
     */
    public function verifyReturn($momoParams) {
        // Extract signature from params
        $signature = $momoParams['signature'] ?? '';
        
        // Build raw data for verification (same order as when creating)
        $ipnUrl = getenv('MOMO_IPN_URL') ?: 'http://localhost/webhoctap/controllers/PaymentCallbackController.php?gateway=momo';
        $redirectUrl = getenv('MOMO_RETURN_URL') ?: 'http://localhost/webhoctap/controllers/PurchaseController.php?action=success';
        
        $rawData = "accessKey=" . $this->accessKey . 
                   "&amount=" . $momoParams['amount'] . 
                   "&extraData=" . ($momoParams['extraData'] ?? '') . 
                   "&ipnUrl=" . $ipnUrl . 
                   "&orderId=" . $momoParams['orderId'] . 
                   "&orderInfo=" . ($momoParams['orderInfo'] ?? '') . 
                   "&partnerCode=" . $this->partnerCode . 
                   "&redirectUrl=" . $redirectUrl . 
                   "&requestId=" . $momoParams['requestId'] . 
                   "&requestType=" . ($momoParams['requestType'] ?? 'captureWallet');

        // Verify signature
        $computedSignature = hash_hmac('sha256', $rawData, $this->secretKey);
        
        if ($signature !== $computedSignature) {
            return [
                'success' => false,
                'message' => 'Invalid signature',
                'orderId' => (int)$momoParams['orderId'] ?? 0,
                'amount' => (float)$momoParams['amount'] ?? 0,
                'transactionId' => $momoParams['transId'] ?? ''
            ];
        }

        // Check result code
        $resultCode = (int)($momoParams['resultCode'] ?? -1);
        if ($resultCode !== 0) {
            return [
                'success' => false,
                'message' => 'Payment failed with result code ' . $resultCode,
                'orderId' => (int)$momoParams['orderId'],
                'amount' => (float)$momoParams['amount'],
                'transactionId' => $momoParams['transId'] ?? ''
            ];
        }

        return [
            'success' => true,
            'message' => 'Payment successful',
            'orderId' => (int)$momoParams['orderId'],
            'amount' => (float)$momoParams['amount'],
            'transactionId' => $momoParams['transId'] ?? '',
            'requestId' => $momoParams['requestId'] ?? ''
        ];
    }

    /**
     * Verify Momo IPN callback (server-to-server)
     * @param array $ipnData Data from Momo IPN callback
     * @return array ['success' => bool, 'message' => string]
     */
    public function verifyIPN($ipnData) {
        // Extract signature
        $signature = $ipnData['signature'] ?? '';

        // Build raw data for IPN verification
        $ipnUrl = getenv('MOMO_IPN_URL') ?: 'http://localhost/webhoctap/controllers/PaymentCallbackController.php?gateway=momo';
        $redirectUrl = getenv('MOMO_RETURN_URL') ?: 'http://localhost/webhoctap/controllers/PurchaseController.php?action=success';
        
        $rawData = "accessKey=" . $this->accessKey . 
                   "&amount=" . $ipnData['amount'] . 
                   "&extraData=" . ($ipnData['extraData'] ?? '') . 
                   "&ipnUrl=" . $ipnUrl . 
                   "&orderId=" . $ipnData['orderId'] . 
                   "&orderInfo=" . ($ipnData['orderInfo'] ?? '') . 
                   "&partnerCode=" . $this->partnerCode . 
                   "&redirectUrl=" . $redirectUrl . 
                   "&requestId=" . $ipnData['requestId'] . 
                   "&requestType=" . ($ipnData['requestType'] ?? 'captureWallet');

        // Verify signature
        $computedSignature = hash_hmac('sha256', $rawData, $this->secretKey);
        
        if ($signature !== $computedSignature) {
            return [
                'success' => false,
                'message' => 'Invalid IPN signature'
            ];
        }

        // Check result code
        $resultCode = (int)($ipnData['resultCode'] ?? -1);
        if ($resultCode !== 0) {
            return [
                'success' => false,
                'message' => 'IPN payment failed with result code ' . $resultCode
            ];
        }

        return [
            'success' => true,
            'message' => 'IPN verified',
            'orderId' => (int)$ipnData['orderId'],
            'amount' => (float)$ipnData['amount'],
            'transactionId' => $ipnData['transId'] ?? ''
        ];
    }
}
