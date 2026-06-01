<?php

require_once __DIR__ . '/../core/GoogleOAuthConfig.php';

class GoogleOAuthService
{
    private GoogleOAuthConfig $config;

    public function __construct(GoogleOAuthConfig $config)
    {
        $this->config = $config;
    }

    public function createAuthorizationUrl(string $state): string
    {
        return $this->config->buildAuthorizationUrl($state);
    }

    public function fetchGoogleUser(string $code): ?array
    {
        $tokenData = $this->exchangeCodeForToken($code);

        if (!isset($tokenData['access_token'])) {
            return null;
        }

        $googleUser = $this->getUserInfo($tokenData['access_token']);

        if (!$this->isValidGoogleUser($googleUser)) {
            return null;
        }

        return [
            'google_id' => (string)$googleUser['sub'],
            'email' => strtolower(trim((string)$googleUser['email'])),
            'name' => trim((string)($googleUser['name'] ?? $googleUser['email'])),
            'avatar' => trim((string)($googleUser['picture'] ?? '')),
        ];
    }

    private function exchangeCodeForToken(string $code): array
    {
        return $this->postJson($this->config->getTokenEndpoint(), [
            'code' => $code,
            'client_id' => $this->config->getClientId(),
            'client_secret' => $this->config->getClientSecret(),
            'redirect_uri' => $this->config->getRedirectUri(),
            'grant_type' => 'authorization_code',
        ]);
    }

    private function getUserInfo(string $accessToken): array
    {
        return $this->getJson($this->config->getUserInfoEndpoint(), [
            'Authorization: Bearer ' . $accessToken,
        ]);
    }

    private function isValidGoogleUser(array $googleUser): bool
    {
        return !empty($googleUser['sub'])
            && !empty($googleUser['email'])
            && filter_var($googleUser['email'], FILTER_VALIDATE_EMAIL)
            && (($googleUser['email_verified'] ?? false) === true);
    }

    private function postJson(string $url, array $data): array
    {
        return $this->requestJson($url, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
        ], [
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data),
        ]);
    }

    private function getJson(string $url, array $headers = []): array
    {
        return $this->requestJson($url, [
            CURLOPT_HTTPGET => true,
            CURLOPT_HTTPHEADER => $headers,
        ], [
            'method' => 'GET',
            'header' => implode("\r\n", $headers) . "\r\n",
        ]);
    }

    private function requestJson(string $url, array $curlOptions, array $streamOptions): array
    {
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 15,
            ] + $curlOptions);
            $response = curl_exec($ch);
            curl_close($ch);
        } else {
            $context = stream_context_create(['http' => $streamOptions + ['timeout' => 15]]);
            $response = file_get_contents($url, false, $context);
        }

        if ($response === false || $response === null) {
            return [];
        }

        $decoded = json_decode($response, true);

        return is_array($decoded) ? $decoded : [];
    }
}
