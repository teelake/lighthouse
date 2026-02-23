<?php
namespace App\Controllers\Admin;

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
