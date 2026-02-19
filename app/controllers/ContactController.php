<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ContactSubmission;
use App\Models\Setting;
use App\Services\MailService;

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
        $subjectLine = $subject ?: 'General inquiry';
        try {
            (new ContactSubmission())->create([
                'name' => $name,
                'email' => $email,
                'subject' => $subjectLine,
                'message' => $message,
            ]);

            $setting = new Setting();
            $adminEmail = $setting->get('site_email', 'info@thelighthouseglobal.org');
            $mail = new MailService();

            // 1. Admin notification
            $adminSubject = 'Contact Form: ' . $subjectLine . ' (from ' . $name . ')';
            $adminHtml = $this->adminEmailBody($name, $email, $subjectLine, $message);
            $mail->send($adminEmail, 'Lighthouse Admin', $adminSubject, $adminHtml);

            // 2. User confirmation (auto-reply)
            $userSubject = 'We received your message - Lighthouse Global Church';
            $userHtml = $this->userConfirmationBody($name, $subjectLine, $setting);
            $mail->send($email, $name, $userSubject, $userHtml);

            $this->redirect(rtrim(BASE_URL ?? '/', '/') . '/contact?msg=success');
        } catch (\Exception $e) {
            $this->redirect(rtrim(BASE_URL ?? '/', '/') . '/contact?msg=error');
        }
    }

    private function adminEmailBody(string $name, string $email, string $subject, string $message): string
    {
        $esc = fn($s) => htmlspecialchars($s ?? '');
        return '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="font-family:sans-serif;line-height:1.6;color:#333;max-width:560px;">' .
            '<h2 style="color:#1a1a1a;">New Contact Form Submission</h2>' .
            '<p><strong>From:</strong> ' . $esc($name) . '<br><strong>Email:</strong> <a href="mailto:' . $esc($email) . '">' . $esc($email) . '</a><br><strong>Subject:</strong> ' . $esc($subject) . '</p>' .
            '<div style="background:#f5f5f5;padding:1rem;border-radius:8px;margin:1rem 0;"><strong>Message:</strong><br>' . nl2br($esc($message)) . '</div>' .
            '<p style="font-size:0.85rem;color:#666;">Sent from Lighthouse Global Church contact form.</p></body></html>';
    }

    private function userConfirmationBody(string $name, string $subject, Setting $setting): string
    {
        $phone = $setting->get('site_phone', '902-240-2087');
        $address = $setting->get('site_address', '980 Parkland Drive, Halifax, NS');
        return '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="font-family:sans-serif;line-height:1.6;color:#333;max-width:560px;">' .
            '<h2 style="color:#1a1a1a;">Thank you for reaching out!</h2>' .
            '<p>Hi ' . htmlspecialchars($name) . ',</p>' .
            '<p>We received your message about "<strong>' . htmlspecialchars($subject) . '</strong>" and will get back to you as soon as possible.</p>' .
            '<p>In the meantime, feel free to call us at <strong>' . htmlspecialchars($phone) . '</strong> or visit us at <strong>' . htmlspecialchars($address) . '</strong>.</p>' .
            '<p>Sunday services: 10:00 AM · Thursday: 6:00 PM</p>' .
            '<p>Blessings,<br><strong>Lighthouse Global Church</strong></p></body></html>';
    }
}
