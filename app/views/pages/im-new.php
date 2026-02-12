<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1>Welcome Home</h1>
        <p>At Lighthouse, you're not just welcome—you're celebrated. No matter where you are in life or your faith journey, there's a place for you here.</p>
        <a href="<?= $baseUrl ?>/">← Back to Home</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
