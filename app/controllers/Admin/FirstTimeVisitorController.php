<?php
namespace App\Controllers\Admin;

use App\Models\FirstTimeVisitor;

class FirstTimeVisitorController extends BaseController
{
    public function index()
    {
        $this->requireEditor();
        $visitors = (new FirstTimeVisitor())->findAll([], 'created_at DESC', 200);
        $this->render('admin/visitors/index', [
            'visitors' => $visitors,
            'pageHeading' => 'First-Time Visitors',
            'currentPage' => 'visitors',
        ]);
    }

    public function create()
    {
        $this->requireEditor();
        $this->render('admin/visitors/form', ['visitor' => null, 'pageHeading' => 'Add Visitor', 'currentPage' => 'visitors']);
    }

    public function store()
    {
        $this->requireEditor();
        if (!function_exists('csrf_verify') || !csrf_verify()) {
            $this->redirectAdmin('visitors/create');
            return;
        }
        $firstName = trim($this->post('first_name', ''));
        $lastName = trim($this->post('last_name', ''));
        $email = trim($this->post('email', ''));
        if (!$firstName || !$lastName || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->render('admin/visitors/form', [
                'visitor' => array_intersect_key($_POST, array_flip(['first_name', 'last_name', 'email', 'phone', 'message'])),
                'error' => 'First name, last name, and valid email are required.',
                'pageHeading' => 'Add Visitor',
                'currentPage' => 'visitors',
            ]);
            return;
        }
        (new FirstTimeVisitor())->create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => trim($this->post('phone', '')),
            'message' => trim($this->post('message', '')),
        ]);
        $this->redirectAdmin('visitors');
    }

    public function edit()
    {
        $this->requireEditor();
        $id = $this->params['id'] ?? 0;
        $visitor = (new FirstTimeVisitor())->find($id);
        if (!$visitor) throw new \Exception('Not found', 404);
        $this->render('admin/visitors/form', [
            'visitor' => $visitor,
            'pageHeading' => 'Edit Visitor',
            'currentPage' => 'visitors',
        ]);
    }

    public function update()
    {
        $this->requireEditor();
        if (!function_exists('csrf_verify') || !csrf_verify()) {
            $this->redirectAdmin('visitors');
            return;
        }
        $id = $this->params['id'] ?? 0;
        $visitor = (new FirstTimeVisitor())->find($id);
        if (!$visitor) throw new \Exception('Not found', 404);
        $firstName = trim($this->post('first_name', ''));
        $lastName = trim($this->post('last_name', ''));
        $email = trim($this->post('email', ''));
        if (!$firstName || !$lastName || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->render('admin/visitors/form', [
                'visitor' => array_merge($visitor, $_POST),
                'error' => 'First name, last name, and valid email are required.',
                'pageHeading' => 'Edit Visitor',
                'currentPage' => 'visitors',
            ]);
            return;
        }
        (new FirstTimeVisitor())->update($id, [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => trim($this->post('phone', '')),
            'message' => trim($this->post('message', '')),
        ]);
        $this->redirectAdmin('visitors');
    }

    public function delete()
    {
        $this->requireEditor();
        if (!function_exists('csrf_verify') || !csrf_verify()) {
            $this->redirectAdmin('visitors');
            return;
        }
        $id = $this->params['id'] ?? 0;
        (new FirstTimeVisitor())->delete($id);
        $this->redirectAdmin('visitors');
    }
}
