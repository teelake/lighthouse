<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section brand-page" data-animate>
    <div class="section-title-bar">
        <div class="section-title-bar-inner">
            <h1 class="section-title">About The Lighthouse</h1>
        </div>
    </div>
    <div class="container brand-shell">
        <p class="brand-kicker">Our story</p>
        <p class="brand-sub">A Christ-centered, Spirit-empowered ministry raising lights that transform nations.</p>
        <div class="brand-card">
            <p>Content for this page is managed from the admin dashboard and will be updated with the full ministry story, vision, values, and leadership profile.</p>
        </div>
        <a href="<?= $baseUrl ?>/" class="brand-back">← Back to Home</a>
    </div>
</section>
<?php
$content = ob_get_clean();
require APP_PATH . '/views/layouts/main.php';
?>
