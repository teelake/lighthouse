<?php
/**
 * Lighthouse Global Church - Application Configuration
 */

date_default_timezone_set('America/Halifax');

define('APP_NAME', 'Lighthouse Global Church');
define('APP_VERSION', '1.0.0');
define('APP_DOMAIN', 'thelighthouseglobal.org');

if (!defined('APP_ENV')) {
    define('APP_ENV', 'production');
}

if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}
error_reporting(E_ALL);

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../helpers.php';

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 1 : 0);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Strict');

define('CSRF_TOKEN_NAME', 'csrf_token');

// Admin backend URL path
define('ADMIN_PATH', getenv('ADMIN_PATH') ?: 'admin');
define('MAX_UPLOAD_SIZE', 10485760); // 10MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
define('ALLOWED_MEDIA_TYPES', ['video/mp4', 'video/webm', 'audio/mpeg', 'audio/wav', 'audio/mp3']);
define('ITEMS_PER_PAGE', 12);
define('RATE_LIMIT_REQUESTS', 60);
define('RATE_LIMIT_WINDOW', 60);
