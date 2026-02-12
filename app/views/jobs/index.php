<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1>Jobs at The Lighthouse</h1>
        <p>Build. Serve. Shine.</p>
        <?php if (!empty($jobs)): ?>
        <div style="margin-top: 2rem;">
            <?php foreach ($jobs as $j): ?>
            <a href="<?= $baseUrl ?>/jobs/<?= htmlspecialchars($j['slug']) ?>" style="display: block; padding: 1rem; margin: 0.5rem 0; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                <h3><?= htmlspecialchars($j['title']) ?></h3>
                <p><?= htmlspecialchars($j['type']) ?></p>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p>Job listings will appear here. Manage from admin.</p>
        <?php endif; ?>
        <a href="<?= $baseUrl ?>/">← Back to Home</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
