<?php
/**
 * Global helper functions
 */
if (!function_exists('admin_url')) {
    function admin_url(string $path = ''): string
    {
        $base = rtrim(BASE_URL, '/') . '/' . (defined('ADMIN_PATH') ? ADMIN_PATH : 'admin');
        $path = ltrim($path, '/');
        return $path ? $base . '/' . $path : $base;
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        $name = defined('CSRF_TOKEN_NAME') ? CSRF_TOKEN_NAME : 'csrf_token';
        $token = $_SESSION[$name] ?? bin2hex(random_bytes(32));
        $_SESSION[$name] = $token;
        return '<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($token) . '">';
    }
}

if (!function_exists('csrf_verify')) {
    function csrf_verify(): bool
    {
        $name = defined('CSRF_TOKEN_NAME') ? CSRF_TOKEN_NAME : 'csrf_token';
        $post = $_POST[$name] ?? '';
        $session = $_SESSION[$name] ?? '';
        return $post !== '' && hash_equals($session, $post);
    }
}
