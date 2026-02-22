<?php
namespace App\Controllers\Admin;

use App\Models\User;
use App\Services\MailService;

class UserController extends BaseController
{
    public function index()
    {
        $this->requireAdmin();
        $users = (new User())->findAll([], 'name ASC');
        $flash = $_SESSION['user_create_flash'] ?? null;
        unset($_SESSION['user_create_flash']);
        $this->render('admin/users/index', [
            'users' => $users,
            'flash' => $flash,
            'pageHeading' => 'Users',
            'currentPage' => 'users',
        ]);
    }

    public function create()
    {
        $this->requireAdmin();
        $this->render('admin/users/form', ['user' => null, 'pageHeading' => 'Add User', 'currentPage' => 'users']);
    }

    public function store()
    {
        $this->requireAdmin();
        if (!csrf_verify()) {
            $this->redirectAdmin('users/create');
            return;
        }
        $email = trim($this->post('email', ''));
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->render('admin/users/form', ['user' => null, 'error' => 'Valid email is required.']);
            return;
        }
        $existing = (new User())->findAll(['email' => $email])[0] ?? null;
        if ($existing) {
            $this->render('admin/users/form', ['user' => null, 'error' => 'Email already in use.']);
            return;
        }
        $plainPassword = $this->generatePassword();
        (new User())->create([
            'email' => $email,
            'password' => password_hash($plainPassword, PASSWORD_DEFAULT),
            'name' => trim($this->post('name', '')),
            'role' => $this->post('role', 'editor'),
            'is_active' => $this->post('is_active') ? 1 : 0,
        ]);
        $name = trim($this->post('name', '')) ?: $email;
        $loginUrl = admin_url('login');
        $emailSent = $this->sendWelcomeEmail($email, $name, $plainPassword, $loginUrl);
        $_SESSION['user_create_flash'] = $emailSent
            ? "User created. Welcome email with login credentials has been sent to {$email}."
            : "User created. Could not send welcome email—ask them to use Forgot Password to set their password.";
        $this->redirectAdmin('users');
    }

    private function generatePassword(): string
    {
        $chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789';
        $len = strlen($chars);
        $password = '';
        for ($i = 0; $i < 12; $i++) {
            $password .= $chars[random_int(0, $len - 1)];
        }
        return $password;
    }

    private function sendWelcomeEmail(string $to, string $name, string $password, string $loginUrl): bool
    {
        $subject = 'Your Lighthouse Global Church Account';
        $body = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="font-family: sans-serif; line-height: 1.6; color: #333;">';
        $body .= '<h2>Welcome to Lighthouse Global Church</h2>';
        $body .= '<p>Hi ' . htmlspecialchars($name) . ',</p>';
        $body .= '<p>An account has been created for you. Here are your login credentials:</p>';
        $body .= '<p><strong>Login URL:</strong> <a href="' . htmlspecialchars($loginUrl) . '">' . htmlspecialchars($loginUrl) . '</a></p>';
        $body .= '<p><strong>Email:</strong> ' . htmlspecialchars($to) . '</p>';
        $body .= '<p><strong>Temporary password:</strong> <code style="background:#f0f0f0; padding:2px 6px; border-radius:4px;">' . htmlspecialchars($password) . '</code></p>';
        $body .= '<p>Please sign in and change your password in your profile settings.</p>';
        $body .= '<p>— Lighthouse Global Church</p>';
        $body .= '</body></html>';
        $mail = new MailService();
        return $mail->send($to, $name, $subject, $body);
    }

    public function edit()
    {
        $this->requireAdmin();
        $id = $this->params['id'] ?? 0;
        $user = (new User())->find($id);
        if (!$user) throw new \Exception('Not found', 404);
        $this->render('admin/users/form', ['user' => $user, 'pageHeading' => 'Edit User', 'currentPage' => 'users']);
    }

    public function update()
    {
        $this->requireAdmin();
        if (!csrf_verify()) {
            $this->redirectAdmin('users');
            return;
        }
        $id = $this->params['id'] ?? 0;
        $user = (new User())->find($id);
        if (!$user) throw new \Exception('Not found', 404);
        $data = [
            'name' => trim($this->post('name', '')),
            'role' => $this->post('role', 'editor'),
            'is_active' => $this->post('is_active') ? 1 : 0,
        ];
        $password = $this->post('password', '');
        if ($password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        (new User())->update($id, $data);
        $this->redirectAdmin('users');
    }

    public function delete()
    {
        $this->requireAdmin();
        if (!csrf_verify()) {
            $this->redirectAdmin('users');
            return;
        }
        $id = $this->params['id'] ?? 0;
        if ($id == $_SESSION['user_id']) {
            $this->redirectAdmin('users');
            return;
        }
        (new User())->delete($id);
        $this->redirectAdmin('users');
    }
}
