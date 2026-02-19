<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section ministry-detail-page">
    <div class="container">
        <a href="<?= $baseUrl ?>/ministries" class="event-detail-back">← All Ministries</a>
        <?php if (!empty($ministry['image'])): ?>
        <div class="ministry-detail-image">
            <img src="<?= htmlspecialchars(full_image_url($ministry['image'])) ?>" alt="<?= htmlspecialchars($ministry['title']) ?>" loading="eager">
        </div>
        <?php endif; ?>
        <article class="ministry-detail-body">
        <h1><?= htmlspecialchars($ministry['title']) ?></h1>
        <?php if (!empty($ministry['tagline'])): ?><div class="lead ministry-tagline"><?= rich_content($ministry['tagline']) ?></div><?php endif; ?>
        <div class="ministry-desc"><?= rich_content($ministry['description'] ?? '') ?></div>
        </article>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
