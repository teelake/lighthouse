<?php
namespace App\Controllers\Admin;

use App\Models\NewsletterSubscriber;
use App\Services\MailService;

class SubscriberController extends BaseController
{
    public function index()
    {
        $this->requireAdmin();
        $subscribers = (new NewsletterSubscriber())->findAll([], 'subscribed_at DESC', 500);
        $this->render('admin/subscribers/index', [
            'subscribers' => $subscribers,
            'pageHeading' => 'Newsletter Subscribers',
            'currentPage' => 'subscribers',
        ]);
    }

    public function compose()
    {
        $this->requireAdmin();
        $model = new NewsletterSubscriber();
        $count = $model->count([]);
        $this->render('admin/subscribers/compose', [
            'subscriberCount' => $count,
            'pageHeading' => 'Send Mass Email',
            'currentPage' => 'subscribers',
        ]);
    }

    public function sendMass()
    {
        $this->requireAdmin();
        $subject = trim($this->post('subject', ''));
        $message = $this->post('message', '');
        if (!$subject || !$message) {
            $this->render('admin/subscribers/compose', [
                'subscriberCount' => (new NewsletterSubscriber())->count([]),
                'subject' => $subject,
                'message' => $message,
                'error' => 'Subject and message are required.',
                'pageHeading' => 'Send Mass Email',
                'currentPage' => 'subscribers',
            ]);
            return;
        }
        $subscribers = (new NewsletterSubscriber())->findAll([], 'subscribed_at DESC', 5000);
        if (empty($subscribers)) {
            $this->render('admin/subscribers/compose', [
                'subscriberCount' => 0,
                'error' => 'No subscribers to send to.',
                'subject' => $subject,
                'message' => $message,
                'pageHeading' => 'Send Mass Email',
                'currentPage' => 'subscribers',
            ]);
            return;
        }
        $mail = new MailService();
        $sent = 0;
        $failed = 0;
        $lastError = '';
        foreach ($subscribers as $s) {
            $email = $s['email'] ?? '';
            if (!$email) continue;
            $name = trim(($s['first_name'] ?? '') . ' ' . ($s['last_name'] ?? ''));
            $body = str_replace(['{{name}}', '{{email}}'], [$name, $email], $message);
            if ($mail->send($email, $name, $subject, $body)) {
                $sent++;
            } else {
                $failed++;
                $lastError = $mail->getLastError();
            }
        }
        $msg = "Sent to $sent subscriber(s)." . ($failed > 0 ? " $failed failed." : '');
        if ($failed > 0 && $lastError) {
            $msg .= ' Error: ' . $lastError;
        }
        $this->render('admin/subscribers/compose', [
            'subscriberCount' => count($subscribers),
            'success' => $msg,
            'pageHeading' => 'Send Mass Email',
            'currentPage' => 'subscribers',
        ]);
    }
}
