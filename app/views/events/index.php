<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section brand-page" data-animate>
    <div class="section-title-bar">
        <div class="section-title-bar-inner">
            <h1 class="section-title">Events & Experiences</h1>
        </div>
    </div>
    <div class="container container-fluid brand-shell">
        <p class="brand-kicker">What's happening</p>
        <p class="brand-sub">Join worship gatherings, teaching nights, and transformative community moments.</p>
        <div class="brand-grid">
        <?php foreach ($events ?? [] as $e): ?>
        <article class="brand-card">
            <h3><?= htmlspecialchars($e['title']) ?></h3>
            <p><?= htmlspecialchars($e['description']) ?></p>
            <a class="link-arrow" href="<?= $baseUrl ?>/events/<?= htmlspecialchars($e['slug']) ?>">Details →</a>
        </article>
        <?php endforeach; ?>
        </div>
        <?php if (empty($events)): ?>
        <p class="brand-empty">Events will appear here. Manage from admin.</p>
        <?php endif; ?>
        <a href="<?= $baseUrl ?>/" class="brand-back">← Back to Home</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
