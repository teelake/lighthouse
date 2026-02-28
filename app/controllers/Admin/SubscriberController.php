<?php
namespace App\Controllers\Admin;

use App\Models\NewsletterSubscriber;
use App\Services\MailService;

class SubscriberController extends BaseController
{
    public function uploadAttachment()
    {
        $this->requireAdmin();
        if (!function_exists('csrf_verify') || !csrf_verify()) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid request']);
            exit;
        }
        header('Content-Type: application/json');
        $file = $_FILES['attachment'] ?? null;
        if (!$file || ($file['error'] ?? 0) !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['error' => 'No file uploaded']);
            exit;
        }
        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime, $allowed, true)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid file type']);
            exit;
        }
        if ($file['size'] > 5 * 1024 * 1024) {
            http_response_code(400);
            echo json_encode(['error' => 'File too large']);
            exit;
        }
        $ext = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'][$mime] ?? 'jpg';
        $dir = UPLOAD_PATH . '/temp/email';
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        $cid = bin2hex(random_bytes(12));
        $basename = $cid . '.' . $ext;
        $path = $dir . '/' . $basename;
        if (!move_uploaded_file($file['tmp_name'], $path)) {
            http_response_code(500);
            echo json_encode(['error' => 'Upload failed']);
            exit;
        }
        $webPath = '/public/uploads/temp/email/' . $basename;
        $url = rtrim(BASE_URL, '/') . $webPath;
        echo json_encode(['url' => $url, 'cid' => $cid]);
        exit;
    }

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
            'useTrix' => true,
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
                'useTrix' => true,
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
                'useTrix' => true,
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
            'useTrix' => true,
        ]);
    }
}
