<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ContactSubmission;

class ContactController extends Controller
{
    public function submit()
    {
        if (!function_exists('csrf_verify') || !csrf_verify()) {
            $this->redirect(rtrim(BASE_URL ?? '/', '/') . '/contact?msg=error');
            return;
        }
        $name = trim($this->post('name') ?? '');
        $email = trim($this->post('email') ?? '');
        $subject = trim($this->post('subject') ?? '');
        $message = trim($this->post('message') ?? '');
        if (!$name || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$message) {
            $this->redirect(rtrim(BASE_URL ?? '/', '/') . '/contact?msg=invalid');
            return;
        }
        try {
            (new ContactSubmission())->create([
                'name' => $name,
                'email' => $email,
                'subject' => $subject ?: 'General inquiry',
                'message' => $message,
            ]);
            $this->redirect(rtrim(BASE_URL ?? '/', '/') . '/contact?msg=success');
        } catch (\Exception $e) {
            $this->redirect(rtrim(BASE_URL ?? '/', '/') . '/contact?msg=error');
        }
    }
}
