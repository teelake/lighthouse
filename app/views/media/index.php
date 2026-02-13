<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section brand-page" data-animate>
    <div class="section-title-bar">
        <div class="section-title-bar-inner">
            <h1 class="section-title">Media & Teachings</h1>
        </div>
    </div>
    <div class="container container-fluid brand-shell">
        <p class="brand-kicker">Stream & grow</p>
        <p class="brand-sub">Explore sermons, teachings, and worship experiences.</p>
        <?php if (!empty($media)): ?>
        <div class="brand-grid">
            <?php foreach ($media as $m): ?>
            <a class="brand-card brand-link-card" href="<?= $baseUrl ?>/media/<?= htmlspecialchars($m['slug']) ?>">
                <h3><?= htmlspecialchars($m['title']) ?></h3>
                <p class="brand-meta"><?= htmlspecialchars($m['media_type']) ?> · <?= htmlspecialchars($m['published_at'] ?? '') ?></p>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="brand-empty">Media will appear here. Manage from admin.</p>
        <?php endif; ?>
        <a href="<?= $baseUrl ?>/" class="brand-back">← Back to Home</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
