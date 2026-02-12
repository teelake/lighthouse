<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($this->post('email', ''));
            $password = $this->post('password', '');
            if (!$email || !$password) {
                return $this->render('admin/auth/login', ['error' => 'Please enter email and password']);
            }
            $user = (new User())->findAll(['email' => $email, 'is_active' => 1])[0] ?? null;
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                $this->redirect('/admin');
            }
            return $this->render('admin/auth/login', ['error' => 'Invalid credentials']);
        }
        $this->render('admin/auth/login');
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/admin/login');
    }
}
