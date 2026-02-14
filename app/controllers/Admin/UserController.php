<?php
namespace App\Controllers\Admin;

use App\Models\User;

class UserController extends BaseController
{
    public function index()
    {
        $this->requireAdmin();
        $users = (new User())->findAll([], 'name ASC');
        $this->render('admin/users/index', [
            'users' => $users,
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
        $password = $this->post('password', '');
        if (!$email || !$password || strlen($password) < 6) {
            $this->render('admin/users/form', ['user' => null, 'error' => 'Email and password (min 6 chars) required.']);
            return;
        }
        $existing = (new User())->findAll(['email' => $email])[0] ?? null;
        if ($existing) {
            $this->render('admin/users/form', ['user' => null, 'error' => 'Email already in use.']);
            return;
        }
        (new User())->create([
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'name' => trim($this->post('name', '')),
            'role' => $this->post('role', 'editor'),
            'is_active' => $this->post('is_active') ? 1 : 0,
        ]);
        $this->redirectAdmin('users');
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
