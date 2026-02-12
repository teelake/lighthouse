<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1>Contact Us</h1>
        <p>📍 <?= htmlspecialchars($address ?? '980 Parkland Drive, Holiday Inn & Suites, Halifax, NS, Canada') ?></p>
        <p>🕙 Sunday 10:00 AM · Thursday 6:00 PM</p>
        <p>📞 <?= htmlspecialchars($phone ?? '902-240-2087') ?></p>
        <p>📧 <?= htmlspecialchars($email ?? 'info@thelighthouseglobal.org') ?></p>
        <a href="<?= $baseUrl ?>/">← Back to Home</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
