<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1>About The Lighthouse Global Ministry</h1>
        <p>Content managed from admin. Coming soon.</p>
        <a href="<?= $baseUrl ?>/">← Back to Home</a>
    </div>
</section>
<?php
$content = ob_get_clean();
require APP_PATH . '/views/layouts/main.php';
?>
