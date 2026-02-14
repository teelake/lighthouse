<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Totp;
use App\Models\User;
use PDO;

class AuthController extends Controller
{
    private const RATE_LIMIT_ATTEMPTS = 5;
    private const RATE_LIMIT_WINDOW = 900; // 15 min

    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect(admin_url());
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_verify()) {
                return $this->render('admin/auth/login', ['error' => 'Invalid request. Please try again.']);
            }
            if (!$this->checkRateLimit()) {
                return $this->render('admin/auth/login', ['error' => 'Too many failed attempts. Try again in 15 minutes.']);
            }
            $email = trim($this->post('email', ''));
            $password = $this->post('password', '');
            if (!$email || !$password) {
                return $this->render('admin/auth/login', ['error' => 'Please enter email and password.']);
            }
            $user = (new User())->findAll(['email' => $email, 'is_active' => 1])[0] ?? null;
            if (!$user || !password_verify($password, $user['password'])) {
                $this->recordFailedAttempt();
                return $this->render('admin/auth/login', ['error' => 'Invalid email or password.']);
            }
            $this->clearFailedAttempts();
            if (!empty($user['two_factor_enabled']) && !empty($user['two_factor_secret'])) {
                $_SESSION['auth_2fa_user_id'] = $user['id'];
                $_SESSION['auth_2fa_email'] = $user['email'];
                $this->redirect(admin_url('2fa'));
            }
            $this->completeLogin($user);
            $this->redirect(admin_url());
        }
        $this->render('admin/auth/login');
    }

    public function twoFactor()
    {
        if (!isset($_SESSION['auth_2fa_user_id'])) {
            $this->redirect(admin_url('login'));
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifyTwoFactor();
            return;
        }
        $this->render('admin/auth/2fa', ['email' => $_SESSION['auth_2fa_email'] ?? '']);
    }

    public function verifyTwoFactor()
    {
        if (!isset($_SESSION['auth_2fa_user_id'])) {
            $this->redirect(admin_url('login'));
        }
        if (!csrf_verify()) {
            $this->render('admin/auth/2fa', ['email' => $_SESSION['auth_2fa_email'] ?? '', 'error' => 'Invalid request.']);
            return;
        }
        $code = trim($this->post('code', ''));
        if (!$code) {
            $this->render('admin/auth/2fa', ['email' => $_SESSION['auth_2fa_email'] ?? '', 'error' => 'Enter your 6-digit code.']);
            return;
        }
        $userId = $_SESSION['auth_2fa_user_id'];
        $user = (new User())->find($userId);
        if (!$user || empty($user['two_factor_secret'])) {
            unset($_SESSION['auth_2fa_user_id'], $_SESSION['auth_2fa_email']);
            $this->redirect(admin_url('login'));
        }
        if (!Totp::verify($user['two_factor_secret'], $code)) {
            $this->render('admin/auth/2fa', ['email' => $user['email'], 'error' => 'Invalid or expired code. Try again.']);
            return;
        }
        unset($_SESSION['auth_2fa_user_id'], $_SESSION['auth_2fa_email']);
        $this->completeLogin($user);
        $this->redirect(admin_url());
    }

    public function logout()
    {
        session_destroy();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->redirect(admin_url('login'));
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
        } catch (\Throwable $e) { /* ignore */ }
    }

    private function clearFailedAttempts(): void
    {
        try {
            $db = \App\Core\Database::getInstance()->getConnection();
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            $db->prepare("DELETE FROM login_attempts WHERE ip_address = ?")->execute([$ip]);
        } catch (\Throwable $e) { /* ignore */ }
    }
}
