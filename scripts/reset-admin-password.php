<?php
/**
 * Reset admin password to admin123
 * Run from project root: php scripts/reset-admin-password.php
 * Or via web: /scripts/reset-admin-password.php (only if scripts are web-accessible)
 */
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');

$dbConfig = require APP_PATH . '/config/database.php';
if (!is_array($dbConfig)) {
    $dbConfig = require APP_PATH . '/config/database.local.php';
}
if (!is_array($dbConfig)) {
    die("Database config not found.\n");
}

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s',
    $dbConfig['host'] ?? 'localhost',
    $dbConfig['dbname'] ?? 'lighthouse_church',
    $dbConfig['charset'] ?? 'utf8mb4'
);

try {
    $pdo = new PDO($dsn, $dbConfig['username'] ?? 'root', $dbConfig['password'] ?? '', $dbConfig['options'] ?? []);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage() . "\n");
}

$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);
$email = 'admin@thelighthouseglobal.org';

$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->execute([$hash, $email]);

if ($stmt->rowCount() > 0) {
    echo "Password reset successful.\n";
    echo "Email: $email\n";
    echo "Password: $password\n";
    echo "You can now log in at /admin\n";
} else {
    echo "No user found with email: $email\n";
    echo "Make sure the admin user exists in the database.\n";
}
