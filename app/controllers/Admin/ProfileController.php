<?php
namespace App\Controllers\Admin;

use App\Core\Totp;
use App\Models\User;

class ProfileController extends BaseController
{
    public function index()
    {
        $this->requireAuth();
        $user = (new User())->find($_SESSION['user_id']);
        if (!$user) {
            session_destroy();
            $this->redirectAdmin('login');
            return;
        }
        unset($user['password'], $user['two_factor_secret']);
        $this->render('admin/profile/index', [
            'user' => $user,
            'success' => $_SESSION['profile_success'] ?? null,
            'error' => $_SESSION['profile_error'] ?? null,
            'pageHeading' => 'My Profile',
            'currentPage' => 'profile',
        ]);
        unset($_SESSION['profile_success'], $_SESSION['profile_error']);
    }

    public function update()
    {
        $this->requireAuth();
        if (!csrf_verify()) {
            $this->redirectAdmin('profile');
            return;
        }
        $user = (new User())->find($_SESSION['user_id']);
        if (!$user) {
            $this->redirectAdmin('profile');
            return;
        }
        $name = trim($this->post('name', ''));
        $email = trim($this->post('email', ''));
        $errors = [];
        if (empty($name)) {
            $errors[] = 'Name is required.';
        }
        if (empty($email)) {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        } elseif ($email !== $user['email']) {
            $existing = (new User())->findAll(['email' => $email]);
            if (!empty($existing)) {
                $errors[] = 'That email is already in use.';
            }
        }
        if (!empty($errors)) {
            $_SESSION['profile_error'] = implode(' ', $errors);
            $this->redirectAdmin('profile');
            return;
        }
        (new User())->update($user['id'], [
            'name' => $name,
            'email' => $email,
        ]);
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION['profile_success'] = 'Profile updated successfully.';
        $this->redirectAdmin('profile');
    }

    public function toggle2fa()
    {
        $this->requireAuth();
        if (!csrf_verify()) {
            $this->redirectAdmin('profile');
            return;
        }
        $user = (new User())->find($_SESSION['user_id']);
        if (!$user) {
            $this->redirectAdmin('profile');
            return;
        }
        $userSafe = array_diff_key($user, ['password' => 1, 'two_factor_secret' => 1]);
        $action = $this->post('action', '');
        if ($action === 'enable') {
            $code = $this->post('code', '');
            if (!$code) {
                $secret = $_SESSION['profile_2fa_secret'] ?? Totp::generateSecret();
                $_SESSION['profile_2fa_secret'] = $secret;
                $this->render('admin/profile/index', [
                    'user' => $userSafe,
                    'pendingSecret' => $secret,
                    'pendingEmail' => $user['email'],
                    'pageHeading' => 'My Profile',
                ]);
                return;
            }
            $secret = $_SESSION['profile_2fa_secret'] ?? null;
            if (!$secret || !Totp::verify($secret, $code)) {
                unset($_SESSION['profile_2fa_secret']);
                $this->render('admin/profile/index', [
                    'user' => $userSafe,
                    'error' => 'Invalid verification code. Try again.',
                    'pageHeading' => 'My Profile',
                ]);
                return;
            }
            unset($_SESSION['profile_2fa_secret']);
            (new User())->update($user['id'], [
                'two_factor_secret' => $secret,
                'two_factor_enabled' => 1,
            ]);
        } elseif ($action === 'disable') {
            $code = $this->post('code', '');
            if (empty($user['two_factor_secret']) || !Totp::verify($user['two_factor_secret'], $code)) {
                $this->render('admin/profile/index', [
                    'user' => $userSafe,
                    'error' => 'Invalid code. Could not disable 2FA.',
                    'pageHeading' => 'My Profile',
                ]);
                return;
            }
            (new User())->update($user['id'], [
                'two_factor_secret' => null,
                'two_factor_enabled' => 0,
            ]);
        }
        $this->redirectAdmin('profile');
    }

    public function changePassword()
    {
        $this->requireAuth();
        if (!csrf_verify()) {
            $this->redirectAdmin('profile');
            return;
        }
        $current = $this->post('current_password', '');
        $new = $this->post('new_password', '');
        $user = (new User())->find($_SESSION['user_id']);
        if (!$user || !password_verify($current, $user['password'])) {
            $this->render('admin/profile/index', [
                'user' => array_diff_key($user ?? [], ['password' => 1, 'two_factor_secret' => 1]),
                'error' => 'Current password incorrect.',
                'pageHeading' => 'My Profile',
            ]);
            return;
        }
        if (strlen($new) < 6) {
            $this->render('admin/profile/index', [
                'user' => array_diff_key($user ?? [], ['password' => 1, 'two_factor_secret' => 1]),
                'error' => 'New password must be at least 6 characters.',
                'pageHeading' => 'My Profile',
            ]);
            return;
        }
        (new User())->update($user['id'], [
            'password' => password_hash($new, PASSWORD_DEFAULT),
        ]);
        $this->redirectAdmin('profile');
    }
}
