<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1>Giving & Partnership</h1>
        <p>Giving is an act of worship and a covenant partnership in advancing God's kingdom.</p>
        <p>Your generosity supports: Teaching & discipleship · Leadership development · Outreach & missions · Ministry operations</p>
        <p>📧 give@thelighthouseglobal.org</p>
        <p>PayPal & Stripe configurable from admin.</p>
        <a href="<?= $baseUrl ?>/">← Back to Home</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
