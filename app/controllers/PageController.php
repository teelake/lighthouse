<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\AcademyRegistration;
use App\Models\ContentSection;
use App\Models\Leader;
use App\Models\Setting;
use App\Models\Faq;
use App\Services\MailService;

class PageController extends Controller
{
    public function about()
    {
        $sections = (new ContentSection())->getAllKeyed();
        $faqs = (new Faq())->findAll([], 'sort_order ASC');
        $setting = new Setting();
        $this->render('pages/about', [
            'sections' => $sections,
            'faqs' => $faqs,
            'aboutHeroImage' => $setting->get('about_hero_image', ''),
            'aboutStoryImage' => $setting->get('about_story_image', ''),
            'pageTitle' => 'About Us - Lighthouse Global Church',
        ]);
    }

    public function leadership()
    {
        $leaders = (new Leader())->findAll(['is_published' => 1], 'sort_order ASC');
        $this->render('pages/leadership', [
            'leaders' => $leaders,
            'pageTitle' => 'Our Leadership - Lighthouse Global Church',
        ]);
    }

    public function services()
    {
        $sections = (new ContentSection())->getAllKeyed();
        $setting = new Setting();
        $this->render('pages/services', [
            'pageTitle' => 'Our Gatherings - Lighthouse Global Church',
            'sections' => $sections,
            'serviceTimes' => [
                'sunday' => $setting->get('service_sunday', '10:00 AM'),
                'thursday' => $setting->get('service_thursday', '6:00 PM'),
            ],
            'address' => $setting->get('site_address', '980 Parkland Drive, Holiday Inn & Suites, Halifax, NS, Canada'),
        ]);
    }

    public function membership()
    {
        $sections = (new ContentSection())->getAllKeyed();
        $this->render('pages/membership', [
            'pageTitle' => 'Membership & Training - Lighthouse Global Church',
            'sections'  => $sections,
            'submitted' => isset($_GET['registered']),
            'error'     => $_GET['error'] ?? null,
            'oldInput'  => [],
        ]);
    }

    public function membershipRegister()
    {
        if (!csrf_verify()) {
            $this->redirect('/membership?error=csrf');
            return;
        }

        $fullName = mb_substr(trim($this->post('full_name', '')), 0, 255);
        $email    = mb_substr(trim($this->post('email', '')), 0, 255);
        $phone    = mb_substr(trim($this->post('phone', '')), 0, 50);
        $academy  = trim($this->post('academy', ''));
        $message  = mb_substr(trim($this->post('message', '')), 0, 2000);

        $valid = ['membership', 'leadership', 'discipleship'];

        if (!$fullName || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL) || !in_array($academy, $valid)) {
            $this->redirect('/membership?error=invalid#academy-signup');
            return;
        }

        try {
            (new AcademyRegistration())->create([
                'full_name' => $fullName,
                'email'     => $email,
                'phone'     => $phone ?: null,
                'academy'   => $academy,
                'message'   => $message ?: null,
            ]);
            $this->notifyAdminAcademySignup($fullName, $email, $phone, $academy, $message);
            $this->redirect('/membership?registered=1#academy-signup');
        } catch (\Throwable $e) {
            error_log('Academy registration error: ' . $e->getMessage());
            $this->redirect('/membership?error=server#academy-signup');
        }
    }

    private function notifyAdminAcademySignup(string $name, string $email, string $phone, string $academy, string $message): void
    {
        $setting  = new Setting();
        $to       = trim($setting->get('site_email', ''));
        if (!$to || !filter_var($to, FILTER_VALIDATE_EMAIL)) return;

        $label    = AcademyRegistration::$academyLabels[$academy] ?? ucfirst($academy);
        $adminUrl = function_exists('admin_url') ? admin_url('academy-registrations') : (rtrim(BASE_URL ?? '', '/') . '/admin/academy-registrations');
        $subject  = 'New Academy Sign-Up: ' . $label . ' — Lighthouse Global Church';

        $body  = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="font-family:sans-serif;line-height:1.6;color:#333;">';
        $body .= '<h2 style="margin:0 0 1rem;">New Academy Sign-Up</h2>';
        $body .= '<table style="border-collapse:collapse;width:100%;max-width:520px;">';
        $body .= '<tr><td style="padding:0.4rem 0.75rem;font-weight:600;width:130px;">Name</td><td style="padding:0.4rem 0.75rem;">' . htmlspecialchars($name) . '</td></tr>';
        $body .= '<tr style="background:#f8f8f8;"><td style="padding:0.4rem 0.75rem;font-weight:600;">Email</td><td style="padding:0.4rem 0.75rem;"><a href="mailto:' . htmlspecialchars($email) . '">' . htmlspecialchars($email) . '</a></td></tr>';
        $body .= '<tr><td style="padding:0.4rem 0.75rem;font-weight:600;">Phone</td><td style="padding:0.4rem 0.75rem;">' . ($phone ? htmlspecialchars($phone) : '—') . '</td></tr>';
        $body .= '<tr style="background:#f8f8f8;"><td style="padding:0.4rem 0.75rem;font-weight:600;">Academy</td><td style="padding:0.4rem 0.75rem;font-weight:700;color:#d4a017;">' . htmlspecialchars($label) . '</td></tr>';
        if ($message) {
            $body .= '<tr><td style="padding:0.4rem 0.75rem;font-weight:600;vertical-align:top;">Message</td><td style="padding:0.4rem 0.75rem;">' . nl2br(htmlspecialchars($message)) . '</td></tr>';
        }
        $body .= '</table>';
        $body .= '<p style="margin-top:1.5rem;"><a href="' . htmlspecialchars($adminUrl) . '" style="display:inline-block;background:#d4a017;color:#1a1a1a;padding:0.5rem 1rem;text-decoration:none;border-radius:4px;font-weight:600;">View All Registrations</a></p>';
        $body .= '<p style="color:#666;font-size:0.9rem;">— Lighthouse Global Church</p>';
        $body .= '</body></html>';

        try {
            (new MailService())->send($to, 'Lighthouse Global Church', $subject, $body);
        } catch (\Throwable $e) {
            // non-fatal
        }
    }

    public function contact()
    {
        $setting = new Setting();
        $mapUrl = $setting->get('map_embed_url', '');
        $this->render('pages/contact', [
            'pageTitle' => 'Contact Us - Lighthouse Global Church',
            'address' => $setting->get('site_address', '980 Parkland Drive, Holiday Inn & Suites, Halifax, NS, Canada'),
            'phone' => $setting->get('site_phone', '902-240-2087'),
            'email' => $setting->get('site_email', 'info@thelighthouseglobal.org'),
            'mapEmbedUrl' => $mapUrl,
            'msg' => $_GET['msg'] ?? '',
        ]);
    }

    public function faq()
    {
        $faqs = (new Faq())->findAll([], 'sort_order ASC');
        $this->render('pages/faq', ['pageTitle' => 'FAQ - Lighthouse Global Church', 'faqs' => $faqs]);
    }

    public function imNew()
    {
        $sections = (new ContentSection())->getAllKeyed();
        $setting = new Setting();
        $this->render('pages/im-new', [
            'pageTitle' => 'I\'m New - Lighthouse Global Church',
            'sections' => $sections,
            'imNewIntroImage' => $setting->get('im_new_intro_image', ''),
        ]);
    }
}
