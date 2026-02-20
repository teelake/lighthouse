<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\FirstTimeVisitor;

class VisitorController extends Controller
{
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !function_exists('csrf_verify') || !csrf_verify()) {
            $this->redirect('/im-new?error=invalid');
            return;
        }
        $firstName = trim($this->post('first_name', ''));
        $lastName = trim($this->post('last_name', ''));
        $email = trim($this->post('email', ''));
        $phone = trim($this->post('phone', ''));
        $message = trim($this->post('message', ''));

        if (!$firstName || !$lastName || !$email) {
            $this->redirect('/im-new?registered=0&error=required');
            return;
        }
        try {
            (new FirstTimeVisitor())->create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone ?: null,
                'message' => $message ?: null,
            ]);
        } catch (\Throwable $e) {
            error_log('Visitor registration error: ' . $e->getMessage());
            $this->redirect('/im-new?registered=0&error=error');
            return;
        }
        $this->redirect('/im-new?registered=1');
    }
}
