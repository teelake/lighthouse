<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1>Events & Experiences</h1>
        <?php foreach ($events ?? [] as $e): ?>
        <article style="margin: 1rem 0; padding: 1rem; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <h3><?= htmlspecialchars($e['title']) ?></h3>
            <p><?= htmlspecialchars($e['description']) ?></p>
            <a href="<?= $baseUrl ?>/events/<?= htmlspecialchars($e['slug']) ?>">Details →</a>
        </article>
        <?php endforeach; ?>
        <?php if (empty($events)): ?>
        <p>Events will appear here. Manage from admin.</p>
        <?php endif; ?>
        <a href="<?= $baseUrl ?>/">← Back to Home</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
