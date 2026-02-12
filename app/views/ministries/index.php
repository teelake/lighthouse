<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1>Our Ministries</h1>
        <?php if (!empty($ministries)): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; margin-top: 2rem;">
            <?php foreach ($ministries as $m): ?>
            <a href="<?= $baseUrl ?>/ministries/<?= htmlspecialchars($m['slug']) ?>" style="display: block; padding: 1.5rem; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                <h3><?= htmlspecialchars($m['title']) ?></h3>
                <p><?= htmlspecialchars($m['tagline'] ?? '') ?></p>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p>Ministries will appear here. Manage from admin.</p>
        <?php endif; ?>
        <a href="<?= $baseUrl ?>/">← Back to Home</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
