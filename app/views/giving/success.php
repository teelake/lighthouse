<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$amount = $amount ?? 0;
?>
<section class="section giving-success-page" data-animate>
    <div class="container giving-success-content">
        <div class="giving-success-card">
            <div class="giving-success-icon" aria-hidden="true">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <h1 class="giving-success-title">Thank You</h1>
            <p class="giving-success-amount"><?= number_format($amount, 2) ?> CAD</p>
            <p class="giving-success-message">Your gift has been received. Thank you for partnering with us in advancing God's kingdom.</p>
            <a href="<?= $baseUrl ?>/" class="btn btn-accent">Return to Home</a>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Thank You - Lighthouse Global Church';
$pageDescription = 'Thank you for your generosity.';
require APP_PATH . '/views/layouts/main.php';
?>
