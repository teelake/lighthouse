<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1>Media & Teachings</h1>
        <p>Explore sermons, teachings, and worship experiences.</p>
        <?php if (!empty($media)): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; margin-top: 2rem;">
            <?php foreach ($media as $m): ?>
            <a href="<?= $baseUrl ?>/media/<?= htmlspecialchars($m['slug']) ?>" style="display: block; padding: 1rem; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                <h3><?= htmlspecialchars($m['title']) ?></h3>
                <p><?= htmlspecialchars($m['media_type']) ?> · <?= htmlspecialchars($m['published_at'] ?? '') ?></p>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p>Media will appear here. Manage from admin.</p>
        <?php endif; ?>
        <a href="<?= $baseUrl ?>/">← Back to Home</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
