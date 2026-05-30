
<?php

session_start();

require_once __DIR__ . '/../config/google_config.php';
require_once __DIR__ . '/../core/Database.php';

try {

    if (!isset($_GET['code'])) {
        throw new Exception('Không nhận được mã xác thực Google');
    }

    $code = $_GET['code'];

    $token_url = 'https://oauth2.googleapis.com/token';

    $post_data = [
        'code' => $code,
        'client_id' => GOOGLE_CLIENT_ID,
        'client_secret' => GOOGLE_CLIENT_SECRET,
        'redirect_uri' => GOOGLE_REDIRECT_URI,
        'grant_type' => 'authorization_code'
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    curl_close($ch);

    $token = json_decode($response, true);

    if (!isset($token['access_token'])) {
        throw new Exception('Không lấy được Access Token');
    }

    $ch = curl_init();

    curl_setopt(
        $ch,
        CURLOPT_URL,
        'https://www.googleapis.com/oauth2/v2/userinfo'
    );

    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        [
            'Authorization: Bearer ' . $token['access_token']
        ]
    );

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $userInfo = curl_exec($ch);

    curl_close($ch);

    $googleUser = json_decode($userInfo, true);

    if (!isset($token['access_token'])) {

    echo '<pre>';
    print_r($token);
    echo '</pre>';
    exit;
    }

    $db = Database::getConnection();

    $email = $db->real_escape_string($googleUser['email']);
    $name = $db->real_escape_string($googleUser['name']);
    $avatar = $db->real_escape_string($googleUser['picture']);

    $result = $db->query(
        "SELECT * FROM nguoi_dung
         WHERE email='$email'
         LIMIT 1"
    );

    $user = $result->fetch_assoc();

    if (!$user) {

        $sql = "
            INSERT INTO nguoi_dung
            (
                ho_ten,
                email,
                mat_khau,
                avatar,
                vai_tro,
                trang_thai
            )
            VALUES
            (
                '$name',
                '$email',
                '',
                '$avatar',
                'user',
                'hoat_dong'
            )
        ";

        if (!$db->query($sql)) {
            throw new Exception($db->error);
        }

        $result = $db->query(
            "SELECT *
             FROM nguoi_dung
             WHERE email='$email'
             LIMIT 1"
        );

        $user = $result->fetch_assoc();
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['ho_ten'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_avatar'] = $user['avatar'];
    $_SESSION['logged_in'] = true;

    header('Location: home.php');
    exit();

} catch (Exception $e) {

    $_SESSION['login_error'] = $e->getMessage();

    header('Location: login.php');
    exit();
}

