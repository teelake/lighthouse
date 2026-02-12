<?php
/**
 * Lighthouse Global Church
 * thelighthouseglobal.org
 * A Christ-centered, Spirit-empowered ministry
 * 
 * @package LighthouseGlobal
 */

// Detect environment
$env = getenv('APP_ENV') ?: ($_ENV['APP_ENV'] ?? 'production');
define('APP_ENV', $env);

error_reporting(E_ALL);
ini_set('display_errors', APP_ENV === 'development' ? 1 : 0);
ini_set('display_startup_errors', APP_ENV === 'development' ? 1 : 0);
ini_set('log_errors', 1);

// Define constants
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('UPLOAD_PATH', ROOT_PATH . '/public/uploads');

$errorLogFile = ROOT_PATH . '/php-error.log';
ini_set('error_log', $errorLogFile);

if (!file_exists($errorLogFile)) {
    @touch($errorLogFile);
    @chmod($errorLogFile, 0664);
}

// Error handler
set_error_handler(function($errno, $errstr, $errfile, $errline) use ($errorLogFile) {
    if (!(error_reporting() & $errno)) return false;
    $types = [E_ERROR => 'ERROR', E_WARNING => 'WARNING', E_PARSE => 'PARSE', E_NOTICE => 'NOTICE'];
    $type = $types[$errno] ?? 'UNKNOWN';
    $msg = sprintf("[%s] PHP %s: %s in %s on line %d\n", date('Y-m-d H:i:s'), $type, $errstr, $errfile, $errline);
    @file_put_contents($errorLogFile, $msg, FILE_APPEND | LOCK_EX);
    return false;
}, E_ALL);

// Exception handler
set_exception_handler(function($e) use ($errorLogFile) {
    $msg = sprintf("[%s] EXCEPTION: %s | %s | %s:%d\n%s\n", date('Y-m-d H:i:s'), get_class($e), $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTraceAsString());
    @file_put_contents($errorLogFile, $msg, FILE_APPEND | LOCK_EX);
    http_response_code(500);
    if (APP_ENV === 'development') {
        echo "<h1>Exception</h1><p>" . htmlspecialchars($e->getMessage()) . "</p><pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    } elseif (file_exists(APP_PATH . '/views/errors/500.php')) {
        require APP_PATH . '/views/errors/500.php';
    } else {
        echo "<h1>500 Error</h1><p>An error occurred. Please try again later.</p>";
    }
    exit(1);
});

// Base URL
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'thelighthouseglobal.org';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$scriptDir = dirname($scriptName);
$basePath = strpos($scriptName, '/public/') !== false ? str_replace('/public', '', $scriptDir) : $scriptDir;
$basePath = rtrim(str_replace('\\', '/', $basePath), '/');
define('BASE_URL', $protocol . '://' . $host . ($basePath !== '/' ? $basePath : ''));

// Autoloader
require_once APP_PATH . '/core/Autoloader.php';
\App\Core\Autoloader::register();

// Load config
require_once APP_PATH . '/config/config.php';

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Run application
$app = new App\Core\Application();
$app->run();
