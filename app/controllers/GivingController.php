<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Setting;
use App\Models\ContentSection;
use App\Models\Donation;
use App\Services\StripeService;

class GivingController extends Controller
{
    public function index()
    {
        $setting = new Setting();
        $sections = (new ContentSection())->getAllKeyed();
        $stripe = new StripeService();
        $this->render('giving/index', [
            'pageTitle' => 'Give - Lighthouse Global Church',
            'paypalEmail' => $setting->get('paypal_email', 'give@thelighthouseglobal.org'),
            'paypalUrl' => $setting->get('paypal_donate_url', ''),
            'stripePublicKey' => $setting->get('stripe_public_key', ''),
            'stripeConfigured' => $stripe->isConfigured(),
            'sections' => $sections,
        ]);
    }

    public function createCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/giving');
            return;
        }
        $baseUrl = rtrim(BASE_URL ?? '', '/');
        $amount = (float) ($this->post('amount', 0));
        $designation = trim($this->post('designation', 'General'));
        $purpose = trim($this->post('purpose', ''));
        $donorName = trim($this->post('donor_name', ''));
        $donorEmail = trim($this->post('donor_email', ''));
        $amountCents = (int) round($amount * 100);
        if ($amountCents < 50) {
            $this->redirect('/giving?error=amount');
            return;
        }
        $stripe = new StripeService();
        $url = $stripe->createCheckoutSession(
            $amountCents,
            $designation,
            $purpose,
            $donorName,
            $donorEmail,
            $baseUrl . '/giving/success',
            $baseUrl . '/giving'
        );
        if ($url) {
            header('Location: ' . $url);
            exit;
        }
        $this->redirect('/giving?error=stripe');
    }

    public function success()
    {
        $sessionId = trim($this->get('session_id', ''));
        if (!$sessionId) {
            $this->redirect('/giving');
            return;
        }
        $stripe = new StripeService();
        $session = $stripe->getSession($sessionId);
        if (!$session || ($session['payment_status'] ?? '') !== 'paid') {
            $this->redirect('/giving?error=payment');
            return;
        }
        $metadata = $session['metadata'] ?? [];
        $existing = (new Donation())->findAll(['stripe_session_id' => $sessionId])[0] ?? null;
        if (!$existing) {
            $amountTotal = $session['amount_total'] ?? 0;
            (new Donation())->create([
                'stripe_session_id' => $sessionId,
                'amount_cents' => $amountTotal,
                'currency' => $session['currency'] ?? 'cad',
                'designation' => $metadata['designation'] ?? 'General',
                'purpose' => $metadata['purpose'] ?? '',
                'donor_name' => $metadata['donor_name'] ?? '',
                'donor_email' => $metadata['donor_email'] ?? '',
            ]);
        }
        $this->render('giving/success', [
            'pageTitle' => 'Thank You - Lighthouse Global Church',
            'amount' => ($session['amount_total'] ?? 0) / 100,
        ]);
    }
}
