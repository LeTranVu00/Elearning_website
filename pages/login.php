<?php
session_start();
require_once __DIR__ . '/../config/google_config.php';
require_once __DIR__ . '/../core/Database.php';

// ========== XỬ LÝ ĐĂNG NHẬP THƯỜNG ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Xử lý đăng nhập thường ở đây
    // ... code của bạn ...
}

// ========== XỬ LÝ ĐĂNG NHẬP GOOGLE ==========

// Trường hợp 1: Bấm nút "Đăng nhập Google" -> chuyển hướng sang Google
if (isset($_GET['action']) && $_GET['action'] === 'google_login') {
    $auth_url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
        'client_id' => GOOGLE_CLIENT_ID,
        'redirect_uri' => GOOGLE_REDIRECT_URI,
        'response_type' => 'code',
        'scope' => 'email profile',
        'access_type' => 'online'
    ]);
    header('Location: ' . $auth_url);
    exit();
}

// Trường hợp 2: Google gửi code callback về
if (isset($_GET['code'])) {
    try {
        $code = $_GET['code'];
        
        // Đổi code lấy access_token
        $token_url = 'https://oauth2.googleapis.com/token';
        $post_fields = [
            'code' => $code,
            'client_id' => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'redirect_uri' => GOOGLE_REDIRECT_URI,
            'grant_type' => 'authorization_code'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $token_data = json_decode($response, true);
        
        if (!isset($token_data['access_token'])) {
            throw new Exception('Không lấy được access token');
        }
        
        // Lấy thông tin người dùng
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v2/userinfo');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token_data['access_token']]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $user_response = curl_exec($ch);
        curl_close($ch);
        
        $google_user = json_decode($user_response, true);
        
        $email = $google_user['email'];
        $ho_ten = $google_user['name'];
        $avatar = $google_user['picture'];
        
        // Xử lý database 
        $db = Database::getConnection();
        
        // Kiểm tra user tồn tại chưa
        $query = "SELECT * FROM nguoi_dung WHERE email = :email LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            // Tạo tài khoản mới
            $insert_query = "INSERT INTO nguoi_dung (ho_ten, email, avatar, vai_tro, trang_thai, mat_khau) 
                             VALUES (:ho_ten, :email, :avatar, 'user', 'hoat_dong', '')";
            $insert_stmt = $db->prepare($insert_query);
            $insert_stmt->bindParam(':ho_ten', $ho_ten);
            $insert_stmt->bindParam(':email', $email);
            $insert_stmt->bindParam(':avatar', $avatar);
            $insert_stmt->execute();
            
            // Lấy lại user vừa tạo
            $stmt = $db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        // Đăng nhập
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['ho_ten'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['vai_tro'];
        $_SESSION['user_avatar'] = $user['avatar'] ?? $avatar;
        $_SESSION['logged_in'] = true;
        
        header('Location: home.php');
        exit();
        
    } catch (Exception $e) {
        $_SESSION['login_error'] = $e->getMessage();
        header('Location: login.php');
        exit();
    }
}

// ========== HIỂN THỊ FORM LOGIN ==========
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Học trực tuyến</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 400px;
            padding: 40px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        button[type="submit"]:hover {
            background: #5a67d8;
        }
        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }
        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #ddd;
        }
        .divider::before {
            left: 0;
        }
        .divider::after {
            right: 0;
        }
        .divider span {
            background: white;
            padding: 0 10px;
            color: #999;
            font-size: 14px;
        }
        .google-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: box-shadow 0.3s;
        }
        .google-btn:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .google-btn img {
            width: 20px;
            margin-right: 10px;
        }
        .google-btn span {
            color: #555;
            font-weight: 500;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .register-link a {
            color: #667eea;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .error {
            background: #fee;
            color: #c33;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Đăng nhập</h2>
        
        <?php if (isset($_SESSION['login_error'])): ?>
            <div class="error">
                <?php 
                    echo $_SESSION['login_error'];
                    unset($_SESSION['login_error']);
                ?>
            </div>
        <?php endif; ?>
        
        <!-- Form đăng nhập thường -->
        <form method="POST" action="">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login">Đăng nhập</button>
        </form>
        
        <div class="divider">
            <span>hoặc</span>
        </div>
        
        <!-- Nút đăng nhập Google -->
        <a href="?action=google_login" class="google-btn">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google">
            <span>Đăng nhập bằng Google</span>
        </a>
        
        <div class="register-link">
            Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
        </div>
    </div>
</body>
</html>