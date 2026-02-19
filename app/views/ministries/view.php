<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1><?= htmlspecialchars($ministry['title']) ?></h1>
        <?php if (!empty($ministry['tagline'])): ?><div class="lead ministry-tagline"><?= rich_content($ministry['tagline']) ?></div><?php endif; ?>
        <div class="ministry-desc"><?= rich_content($ministry['description'] ?? '') ?></div>
        <a href="<?= $baseUrl ?>/ministries">← All Ministries</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
