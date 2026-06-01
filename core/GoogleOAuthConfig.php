<?php

class GoogleOAuthConfig
{
    private string $clientId;
    private string $clientSecret;
    private string $redirectUri;

    private string $authorizationEndpoint = 'https://accounts.google.com/o/oauth2/v2/auth';
    private string $tokenEndpoint = 'https://oauth2.googleapis.com/token';
    private string $userInfoEndpoint = 'https://openidconnect.googleapis.com/v1/userinfo';

    public function __construct(string $clientId, string $clientSecret, ?string $redirectUri = null)
    {
        $this->clientId = trim($clientId);
        $this->clientSecret = trim($clientSecret);
        $this->redirectUri = trim($redirectUri ?: self::buildDefaultRedirectUri());
    }

    public static function fromEnvironment(): self
    {
        // Ensure local .env loader is available when controllers are executed directly
        $envLoader = __DIR__ . '/google_env.php';
        if (is_readable($envLoader)) {
            require_once $envLoader;
        }

        return new self(
            getenv('GOOGLE_CLIENT_ID') ?: '',
            getenv('GOOGLE_CLIENT_SECRET') ?: '',
            getenv('GOOGLE_REDIRECT_URI') ?: null
        );
    }

    public function isConfigured(): bool
    {
        return $this->clientId !== '' && $this->clientSecret !== '' && $this->redirectUri !== '';
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }

    public function getTokenEndpoint(): string
    {
        return $this->tokenEndpoint;
    }

    public function getUserInfoEndpoint(): string
    {
        return $this->userInfoEndpoint;
    }

    public function buildAuthorizationUrl(string $state): string
    {
        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'prompt' => 'select_account',
        ];

        return $this->authorizationEndpoint . '?' . http_build_query($params);
    }

    private static function buildDefaultRedirectUri(): string
    {
        $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (($_SERVER['SERVER_PORT'] ?? '') === '443');
        $scheme = $isHttps ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/webhoctap/controllers'));
        $scriptDir = rtrim($scriptDir, '/');

        return $scheme . '://' . $host . $scriptDir . '/GoogleAuthController.php?action=callback';
    }
}
