<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section brand-page events-page" data-animate>
    <div class="page-hero page-hero--events">
        <div class="container">
            <h1 class="page-hero-title">Events & Experiences</h1>
            <p class="page-hero-sub">What's happening</p>
        </div>
    </div>
    <div class="container brand-shell">
        <p class="brand-kicker">What's happening</p>
        <p class="brand-sub">Join worship gatherings, teaching nights, and transformative community moments.</p>
        <div class="brand-grid">
        <?php foreach ($events ?? [] as $e): ?>
        <article class="brand-card">
            <h3><?= htmlspecialchars($e['title']) ?></h3>
            <p><?= rich_preview($e['description'], 160) ?></p>
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
