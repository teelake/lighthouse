<?php
namespace App\Services;

use App\Models\Setting;

class StripeService
{
    private $secretKey;
    private $lastError = '';

    public function __construct()
    {
        $this->secretKey = (new Setting())->get('stripe_secret_key', '');
    }

    public function isConfigured(): bool
    {
        return !empty($this->secretKey) && strpos($this->secretKey, 'sk_') === 0;
    }

    /**
     * Create a Checkout Session for a one-time donation.
     * Returns session URL or null on failure.
     */
    public function createCheckoutSession(
        int $amountCents,
        string $designation,
        string $purpose,
        string $donorName,
        string $donorEmail,
        string $successUrl,
        string $cancelUrl
    ): ?string {
        if (!$this->isConfigured()) {
            $this->lastError = 'Stripe is not configured.';
            return null;
        }
        if ($amountCents < 50) { // min 50 cents
            $this->lastError = 'Minimum amount is $0.50 CAD.';
            return null;
        }

        $successUrlFull = $successUrl . (strpos($successUrl, '?') !== false ? '&' : '?') . 'session_id={CHECKOUT_SESSION_ID}';
        $formData = [
            'mode' => 'payment',
            'success_url' => $successUrlFull,
            'cancel_url' => $cancelUrl,
            'line_items[0][price_data][currency]' => 'cad',
            'line_items[0][price_data][unit_amount]' => $amountCents,
            'line_items[0][price_data][product_data][name]' => 'Donation - ' . $designation,
            'line_items[0][price_data][product_data][description]' => $purpose ?: 'Thank you for your generosity.',
            'line_items[0][quantity]' => 1,
            'metadata[designation]' => $designation,
            'metadata[purpose]' => $purpose,
            'metadata[donor_name]' => $donorName,
            'metadata[donor_email]' => $donorEmail,
        ];
        if (!empty($donorEmail)) {
            $formData['customer_email'] = $donorEmail;
        }

        $ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_USERPWD => $this->secretKey . ':',
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_POSTFIELDS => http_build_query($formData),
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false) {
            $this->lastError = 'Could not connect to Stripe.';
            return null;
        }
        $data = json_decode($response, true);
        if ($httpCode >= 400) {
            $this->lastError = $data['error']['message'] ?? 'Stripe error.';
            return null;
        }
        return $data['url'] ?? null;
    }

    /**
     * Retrieve a Checkout Session and verify payment.
     */
    public function getSession(string $sessionId): ?array
    {
        if (!$this->isConfigured()) return null;
        $ch = curl_init('https://api.stripe.com/v1/checkout/sessions/' . $sessionId);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => $this->secretKey . ':',
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode !== 200 || !$response) return null;
        return json_decode($response, true);
    }

    public function getLastError(): string
    {
        return $this->lastError;
    }
}
