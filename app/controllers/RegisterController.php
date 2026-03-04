<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Services\MailService;

class RegisterController extends Controller
{
    private const MIN_PASSWORD_LENGTH = 8;
    private const RATE_LIMIT_ATTEMPTS = 5;
    private const RATE_LIMIT_WINDOW = 900; // 15 min

    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect(admin_url());
        }
        $this->render('auth/register', [
            'pageTitle' => 'Become a Member – Lighthouse Global Church',
        ]);
    }

    public function store()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect(admin_url());
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register');
            return;
        }
        if (!csrf_verify()) {
            return $this->render('auth/register', [
                'pageTitle' => 'Become a Member – Lighthouse Global Church',
                'error' => 'Invalid request. Please try again.',
            ]);
        }
        if (!$this->checkRateLimit()) {
            return $this->render('auth/register', [
                'pageTitle' => 'Become a Member – Lighthouse Global Church',
                'error' => 'Too many registration attempts. Please try again in 15 minutes.',
            ]);
        }

        $name     = trim($this->post('name', ''));
        $email    = trim($this->post('email', ''));
        $password = $this->post('password', '');
        $confirm  = $this->post('password_confirm', '');

        $old = ['name' => $name, 'email' => $email];

        if (!$name || !$email || !$password || !$confirm) {
            return $this->render('auth/register', [
                'pageTitle' => 'Become a Member – Lighthouse Global Church',
                'error' => 'All fields are required.', 'old' => $old,
            ]);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->render('auth/register', [
                'pageTitle' => 'Become a Member – Lighthouse Global Church',
                'error' => 'Please enter a valid email address.', 'old' => $old,
            ]);
        }
        if (strlen($password) < self::MIN_PASSWORD_LENGTH) {
            return $this->render('auth/register', [
                'pageTitle' => 'Become a Member – Lighthouse Global Church',
                'error' => 'Password must be at least ' . self::MIN_PASSWORD_LENGTH . ' characters.', 'old' => $old,
            ]);
        }
        if ($password !== $confirm) {
            return $this->render('auth/register', [
                'pageTitle' => 'Become a Member – Lighthouse Global Church',
                'error' => 'Passwords do not match.', 'old' => $old,
            ]);
        }

        $userModel = new User();
        $existing = $userModel->findAll(['email' => $email])[0] ?? null;
        if ($existing) {
            $this->recordAttempt();
            return $this->render('auth/register', [
                'pageTitle' => 'Become a Member – Lighthouse Global Church',
                'error' => 'An account with that email already exists. Try signing in instead.', 'old' => $old,
            ]);
        }

        try {
            $userId = $userModel->create([
                'name'      => $name,
                'email'     => $email,
                'password'  => password_hash($password, PASSWORD_DEFAULT),
                'role'      => 'member',
                'is_active' => 1,
            ]);

            $this->sendWelcomeEmail($email, $name);

            // Auto-login
            $_SESSION['user_id']    = $userId;
            $_SESSION['user_name']  = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role']  = 'member';
            if (defined('CSRF_TOKEN_NAME')) {
                $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
            }

            $this->redirect(admin_url() . '?welcome=1');
        } catch (\Throwable $e) {
            error_log('Member registration error: ' . $e->getMessage());
            return $this->render('auth/register', [
                'pageTitle' => 'Become a Member – Lighthouse Global Church',
                'error' => 'Something went wrong. Please try again.', 'old' => $old,
            ]);
        }
    }

    private function sendWelcomeEmail(string $email, string $name): void
    {
        try {
            $loginUrl = admin_url('login');
            $subject  = 'Welcome to Lighthouse Global Church!';
            $body     = '<!DOCTYPE html><html><body style="font-family:sans-serif;line-height:1.6;color:#333;max-width:520px;margin:auto;padding:2rem;">';
            $body    .= '<h2 style="color:#1a1a1a;">Welcome to Lighthouse, ' . htmlspecialchars($name) . '! 🎉</h2>';
            $body    .= '<p>We\'re thrilled to have you as a member of the Lighthouse Global Church family.</p>';
            $body    .= '<p>Your member account is ready. You can now:</p>';
            $body    .= '<ul><li>Post on the <strong>Prayer Wall</strong> and pray with others</li>';
            $body    .= '<li>View upcoming <strong>events</strong> and <strong>ministries</strong></li>';
            $body    .= '<li>Stay connected with your church family</li></ul>';
            $body    .= '<p><a href="' . htmlspecialchars($loginUrl) . '" style="display:inline-block;padding:0.65rem 1.5rem;background:#ffe100;color:#1a1a1a;font-weight:700;text-decoration:none;border-radius:6px;">Sign In to Your Dashboard</a></p>';
            $body    .= '<p style="color:#888;font-size:0.875rem;">— The Lighthouse Family</p>';
            $body    .= '</body></html>';
            (new MailService())->send($email, $name, $subject, $body, strip_tags($body));
        } catch (\Throwable $e) {
            error_log('Welcome email error: ' . $e->getMessage());
        }
    }

    private function checkRateLimit(): bool
    {
        try {
            $db    = \App\Core\Database::getInstance()->getConnection();
            $ip    = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            $since = date('Y-m-d H:i:s', time() - self::RATE_LIMIT_WINDOW);
            $stmt  = $db->prepare("SELECT COUNT(*) FROM login_attempts WHERE ip_address = ? AND attempted_at > ?");
            $stmt->execute([$ip, $since]);
            return (int) $stmt->fetchColumn() < self::RATE_LIMIT_ATTEMPTS;
        } catch (\Throwable $e) {
            return true;
        }
    }

    private function recordAttempt(): void
    {
        try {
            $db   = \App\Core\Database::getInstance()->getConnection();
            $ip   = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            $stmt = $db->prepare("INSERT INTO login_attempts (ip_address) VALUES (?)");
            $stmt->execute([$ip]);
        } catch (\Throwable $e) {
        }
    }
}
