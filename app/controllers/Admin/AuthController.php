<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\User;
use App\Services\MailService;

class AuthController extends Controller
{
    private const RESET_TOKEN_EXPIRY = 3600; // 1 hour
    private const RESET_RATE_LIMIT_ATTEMPTS = 5;
    private const RESET_RATE_LIMIT_WINDOW = 900; // 15 min
    private const RATE_LIMIT_ATTEMPTS = 5;
    private const RATE_LIMIT_WINDOW = 900; // 15 min

    private function logAuth(string $message, array $context = []): void
    {
        $logFile = defined('ROOT_PATH') ? ROOT_PATH . '/php-error.log' : __DIR__ . '/../../../php-error.log';
        $ctx = $context ? ' ' . json_encode($context) : '';
        @file_put_contents($logFile, sprintf("[%s] AUTH: %s%s\n", date('Y-m-d H:i:s'), $message, $ctx), FILE_APPEND | LOCK_EX);
    }

    public function login()
    {
        $redirectTo = trim($this->post('redirect', $this->get('redirect', '')));
        if (isset($_SESSION['user_id'])) {
            $this->redirect($this->resolveRedirect($redirectTo) ?? admin_url());
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
            if (!csrf_verify()) {
                $this->logAuth('Login failed: CSRF invalid');
                return $this->render('admin/auth/login', ['error' => 'Invalid request. Please try again.']);
            }
            if (!$this->checkRateLimit()) {
                $this->logAuth('Login failed: rate limit exceeded', ['ip' => $_SERVER['REMOTE_ADDR'] ?? '']);
                return $this->render('admin/auth/login', ['error' => 'Too many failed attempts. Try again in 15 minutes.']);
            }
            $email = trim($this->post('email', ''));
            $password = $this->post('password', '');
            if (!$email || !$password) {
                $this->logAuth('Login failed: missing email or password');
                return $this->render('admin/auth/login', ['error' => 'Please enter email and password.']);
            }
            $user = null;
            try {
                $user = (new User())->findAll(['email' => $email, 'is_active' => 1])[0] ?? null;
            } catch (\Throwable $e) {
                $this->logAuth('Login failed: DB error', ['email' => $email, 'error' => $e->getMessage()]);
                error_log('Admin login DB error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
                return $this->render('admin/auth/login', ['error' => 'A system error occurred. Please try again.']);
            }
            if (!$user || !password_verify($password, $user['password'] ?? '')) {
                $this->logAuth('Login failed: invalid credentials', ['email' => $email]);
                $this->recordFailedAttempt();
                return $this->render('admin/auth/login', ['error' => 'Invalid email or password.']);
            }
            $this->clearFailedAttempts();
            $this->completeLogin($user);
            $this->logAuth('Login success', ['email' => $email, 'user_id' => $user['id']]);
            $this->redirect($this->resolveRedirect($redirectTo) ?? admin_url());
            } catch (\Throwable $e) {
                $this->logAuth('Login exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                error_log('Admin login exception: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
                return $this->render('admin/auth/login', ['error' => 'An error occurred. Please try again.']);
            }
        }
        $this->render('admin/auth/login', ['redirect' => $redirectTo]);
    }

    public function logout()
    {
        session_destroy();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->redirect(admin_url('login'));
    }

    public function forgotPassword()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect(admin_url());
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_verify()) {
                return $this->render('admin/auth/forgot-password', ['error' => 'Invalid request. Please try again.']);
            }
            if (!$this->checkResetRateLimit()) {
                return $this->render('admin/auth/forgot-password', ['error' => 'Too many requests. Try again in 15 minutes.']);
            }
            $email = trim($this->post('email', ''));
            if (!$email) {
                return $this->render('admin/auth/forgot-password', ['error' => 'Please enter your email address.']);
            }

            $user = (new User())->findAll(['email' => $email, 'is_active' => 1])[0] ?? null;
            if ($user) {
                $token = bin2hex(random_bytes(32));
                $tokenHash = hash('sha256', $token);
                $expiresAt = date('Y-m-d H:i:s', time() + self::RESET_TOKEN_EXPIRY);

                try {
                    $db = \App\Core\Database::getInstance()->getConnection();
                    $db->prepare("DELETE FROM password_reset_tokens WHERE user_id = ?")->execute([$user['id']]);
                    $stmt = $db->prepare("INSERT INTO password_reset_tokens (user_id, token_hash, expires_at) VALUES (?, ?, ?)");
                    $stmt->execute([$user['id'], $tokenHash, $expiresAt]);

                    $resetUrl = rtrim(BASE_URL, '/') . '/' . (defined('ADMIN_PATH') ? ADMIN_PATH : 'admin') . '/reset-password?token=' . urlencode($token);
                    $subject = 'Reset Your Password - Lighthouse Admin';
                    $bodyHtml = '<p>Hello ' . htmlspecialchars($user['name']) . ',</p>';
                    $bodyHtml .= '<p>You requested a password reset. Click the link below to set a new password:</p>';
                    $bodyHtml .= '<p><a href="' . htmlspecialchars($resetUrl) . '" style="color:#b08d57;">Reset Password</a></p>';
                    $bodyHtml .= '<p>This link expires in 1 hour. If you did not request this, you can ignore this email.</p>';
                    $bodyHtml .= '<p>— Lighthouse Admin</p>';

                    $mail = new MailService();
                    $mail->send($user['email'], $user['name'], $subject, $bodyHtml, strip_tags($bodyHtml));
                    $this->logAuth('Password reset email sent', ['email' => $email]);
                } catch (\Throwable $e) {
                    $this->logAuth('Password reset failed', ['email' => $email, 'error' => $e->getMessage()]);
                }
                $this->recordResetAttempt();
            } else {
                $this->recordResetAttempt();
            }

            return $this->render('admin/auth/forgot-password', ['success' => 'If an account exists with that email, we\'ve sent a password reset link. Please check your inbox.']);
        }
        $this->render('admin/auth/forgot-password');
    }

    public function resetPassword()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect(admin_url());
        }
        $token = trim($this->get('token', ''));

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_verify()) {
                return $this->render('admin/auth/reset-password', ['token' => $token, 'error' => 'Invalid request. Please try again.']);
            }
            $token = trim($this->post('token', ''));
            $password = $this->post('password', '');
            $passwordConfirm = $this->post('password_confirm', '');

            if (!$token) {
                return $this->render('admin/auth/reset-password', ['token' => '', 'error' => 'Invalid or expired reset link. Please request a new one.']);
            }
            if (strlen($password) < 6) {
                return $this->render('admin/auth/reset-password', ['token' => $token, 'error' => 'Password must be at least 6 characters.']);
            }
            if ($password !== $passwordConfirm) {
                return $this->render('admin/auth/reset-password', ['token' => $token, 'error' => 'Passwords do not match.']);
            }

            $tokenHash = hash('sha256', $token);
            try {
                $db = \App\Core\Database::getInstance()->getConnection();
                $stmt = $db->prepare("SELECT prt.user_id FROM password_reset_tokens prt JOIN users u ON u.id = prt.user_id WHERE prt.token_hash = ? AND prt.expires_at > NOW() AND u.is_active = 1");
                $stmt->execute([$tokenHash]);
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                if (!$row) {
                    return $this->render('admin/auth/reset-password', ['token' => '', 'error' => 'Invalid or expired reset link. Please request a new one.']);
                }

                $userId = (int) $row['user_id'];
                (new User())->update($userId, ['password' => password_hash($password, PASSWORD_DEFAULT)]);
                $db->prepare("DELETE FROM password_reset_tokens WHERE user_id = ?")->execute([$userId]);
                $this->logAuth('Password reset completed', ['user_id' => $userId]);
                return $this->render('admin/auth/reset-password', ['success' => true]);
            } catch (\Throwable $e) {
                $this->logAuth('Password reset error', ['error' => $e->getMessage()]);
                return $this->render('admin/auth/reset-password', ['token' => $token, 'error' => 'An error occurred. Please try again.']);
            }
        }

        if (!$token) {
            return $this->render('admin/auth/reset-password', ['token' => '', 'error' => 'Invalid or missing reset token. Please use the link from your email.']);
        }
        $this->render('admin/auth/reset-password', ['token' => $token]);
    }

    private function checkResetRateLimit(): bool
    {
        try {
            $db = \App\Core\Database::getInstance()->getConnection();
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            $since = date('Y-m-d H:i:s', time() - self::RESET_RATE_LIMIT_WINDOW);
            $stmt = $db->prepare("SELECT COUNT(*) FROM password_reset_attempts WHERE ip_address = ? AND attempted_at > ?");
            $stmt->execute([$ip, $since]);
            return (int) $stmt->fetchColumn() < self::RESET_RATE_LIMIT_ATTEMPTS;
        } catch (\Throwable $e) {
            return true;
        }
    }

    private function recordResetAttempt(): void
    {
        try {
            $db = \App\Core\Database::getInstance()->getConnection();
            $stmt = $db->prepare("INSERT INTO password_reset_attempts (ip_address) VALUES (?)");
            $stmt->execute([$_SERVER['REMOTE_ADDR'] ?? '0.0.0.0']);
        } catch (\Throwable $e) {
            $this->logAuth('recordResetAttempt error', ['error' => $e->getMessage()]);
        }
    }

    private function completeLogin(array $user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }

    private function checkRateLimit(): bool
    {
        try {
            $db = \App\Core\Database::getInstance()->getConnection();
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            $since = date('Y-m-d H:i:s', time() - self::RATE_LIMIT_WINDOW);
            $stmt = $db->prepare("SELECT COUNT(*) FROM login_attempts WHERE ip_address = ? AND attempted_at > ?");
            $stmt->execute([$ip, $since]);
            return (int)$stmt->fetchColumn() < self::RATE_LIMIT_ATTEMPTS;
        } catch (\Throwable $e) {
            $this->logAuth('Rate limit check failed (skipped)', ['error' => $e->getMessage()]);
            return true; // skip rate limit if table missing
        }
    }

    private function recordFailedAttempt(): void
    {
        try {
            $db = \App\Core\Database::getInstance()->getConnection();
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            $stmt = $db->prepare("INSERT INTO login_attempts (ip_address) VALUES (?)");
            $stmt->execute([$ip]);
        } catch (\Throwable $e) {
            $this->logAuth('recordFailedAttempt error', ['error' => $e->getMessage()]);
        }
    }

    /** Resolve redirect URL - allows return to frontend (e.g. /prayer) after login */
    private function resolveRedirect(string $path): ?string
    {
        $path = trim($path);
        if ($path === '' || strpos($path, '//') !== false || preg_match('#^[a-z]+:#i', $path)) {
            return null;
        }
        $path = ltrim($path, '/');
        $base = rtrim(BASE_URL ?? '', '/');
        return $path !== '' ? $base . '/' . $path : null;
    }

    private function clearFailedAttempts(): void
    {
        try {
            $db = \App\Core\Database::getInstance()->getConnection();
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            $db->prepare("DELETE FROM login_attempts WHERE ip_address = ?")->execute([$ip]);
        } catch (\Throwable $e) {
            $this->logAuth('clearFailedAttempts error', ['error' => $e->getMessage()]);
        }
    }
}
