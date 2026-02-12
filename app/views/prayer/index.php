<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1>Prayer</h1>
        <p>Submit a prayer request. Prayer Wall for members.</p>
        <a href="<?= $baseUrl ?>/">← Back to Home</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
