<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\NewsletterSubscriber;

class NewsletterController extends Controller
{
    public function subscribe()
    {
        $name = trim($this->post('name') ?? '');
        $email = trim($this->post('email') ?? '');
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirect(rtrim(BASE_URL ?? '/', '/') . '/?newsletter=invalid');
            return;
        }
        $subscriber = new NewsletterSubscriber();
        try {
            $subscriber->create([
                'email' => $email,
                'first_name' => $name ?: null,
                'last_name' => null,
            ]);
            $this->redirect(rtrim(BASE_URL ?? '/', '/') . '/?newsletter=success');
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'Duplicate') !== false) {
                $this->redirect(rtrim(BASE_URL ?? '/', '/') . '/?newsletter=success');
            } else {
                $this->redirect(rtrim(BASE_URL ?? '/', '/') . '/?newsletter=error');
            }
        }
    }
}
