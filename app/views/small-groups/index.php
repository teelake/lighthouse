<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1>Small Groups</h1>
        <p>Connect with others in communities for ages 16–46.</p>
        <?php if (!empty($groups)): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; margin-top: 2rem;">
            <?php foreach ($groups as $g): ?>
            <a href="<?= $baseUrl ?>/small-groups/<?= htmlspecialchars($g['slug']) ?>" style="display: block; padding: 1.5rem; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                <h3><?= htmlspecialchars($g['title']) ?></h3>
                <p><?= htmlspecialchars($g['tagline'] ?? '') ?></p>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p>Small groups will appear here. Manage from admin.</p>
        <?php endif; ?>
        <a href="<?= $baseUrl ?>/">← Back to Home</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
