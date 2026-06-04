<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/SessionManager.php';
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../core/GoogleOAuthConfig.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../services/GoogleOAuthService.php';

class GoogleAuthController extends BaseController
{
    private User $userModel;
    private GoogleOAuthService $googleOAuthService;
    private GoogleOAuthConfig $googleOAuthConfig;

    public function __construct(
        User $userModel,
        GoogleOAuthService $googleOAuthService,
        GoogleOAuthConfig $googleOAuthConfig
    ) {
        $this->userModel = $userModel;
        $this->googleOAuthService = $googleOAuthService;
        $this->googleOAuthConfig = $googleOAuthConfig;
    }

    public function handle(): void
    {
        $action = $this->getQuery('action', 'redirect');

        if ($action === 'callback') {
            $this->callback();
            return;
        }

        $this->redirectToGoogle();
    }

    private function redirectToGoogle(): void
    {
        if (!$this->googleOAuthConfig->isConfigured()) {
            SessionManager::setErrors([
                'Google SSO chua duoc cau hinh. Vui long thiet lap GOOGLE_CLIENT_ID va GOOGLE_CLIENT_SECRET.',
            ]);
            $this->redirect('../pages/login.php');
        }

        $state = bin2hex(random_bytes(32));
        SessionManager::set('google_oauth_state', $state);

        $this->redirect($this->googleOAuthService->createAuthorizationUrl($state));
    }

    private function callback(): void
    {
        $code = trim((string)$this->getQuery('code', ''));
        $state = trim((string)$this->getQuery('state', ''));
        $expectedState = (string)SessionManager::get('google_oauth_state', '');
        SessionManager::remove('google_oauth_state');

        if ($code === '' || $state === '' || !hash_equals($expectedState, $state)) {
            SessionManager::setErrors(['Phien dang nhap Google khong hop le. Vui long thu lai.']);
            $this->redirect('../pages/login.php');
        }

        $googleUser = $this->googleOAuthService->fetchGoogleUser($code);

        if ($googleUser === null) {
            SessionManager::setErrors(['Khong the lay thong tin tu Google. Vui long thu lai.']);
            $this->redirect('../pages/login.php');
        }

        $user = $this->findOrCreateUser($googleUser);

        if ($user === null) {
            SessionManager::setErrors(['Khong the tao hoac dang nhap tai khoan Google.']);
            $this->redirect('../pages/login.php');
        }

        if ($user['trang_thai'] === 'khoa') {
            SessionManager::setErrors(['Tai khoan cua ban da bi khoa. Vui long lien he ho tro.']);
            $this->redirect('../pages/login.php');
        }

        SessionManager::login($user);
        
        // Redirect based on user role
        if ($user['vai_tro'] === 'instructor') {
            $this->redirect('../index.php?page=instructor-courses');
        } else {
            $this->redirect('../pages/home.php');
        }
    }

    private function findOrCreateUser(array $googleUser): ?array
    {
        $user = $this->userModel->findByGoogleId($googleUser['google_id']);

        if ($user !== null) {
            return $user;
        }

        $user = $this->userModel->findByEmail($googleUser['email']);

        if ($user !== null) {
            $this->userModel->linkGoogleAccount(
                (int)$user['id'],
                $googleUser['google_id'],
                $googleUser['avatar']
            );

            return $this->userModel->findByEmail($googleUser['email']);
        }

        if (!$this->userModel->createFromGoogle($googleUser)) {
            return null;
        }

        return $this->userModel->findByGoogleId($googleUser['google_id']);
    }
}

$config = GoogleOAuthConfig::fromEnvironment();

(new GoogleAuthController(
    new User(Database::getConnection()),
    new GoogleOAuthService($config),
    $config
))->handle();
