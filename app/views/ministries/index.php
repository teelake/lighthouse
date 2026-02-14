<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section ministries-page" data-animate>
    <div class="page-hero page-hero--ministries">
        <div class="container">
            <h1 class="page-hero-title">Our Ministries</h1>
            <p class="page-hero-sub">Serve. Grow. Impact.</p>
        </div>
    </div>

    <div class="container ministries-content">
        <p class="ministries-intro">Discover where you can connect, serve, and grow within our church family.</p>
        <?php if (!empty($ministries)): ?>
        <div class="ministries-grid">
            <?php foreach ($ministries as $m): ?>
            <a href="<?= $baseUrl ?>/ministries/<?= htmlspecialchars($m['slug']) ?>" class="ministry-card stagger-item">
                <div class="ministry-card-body">
                    <h3><?= htmlspecialchars($m['title']) ?></h3>
                    <p><?= htmlspecialchars($m['tagline'] ?? '') ?></p>
                    <span class="link-arrow">Learn more →</span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="brand-empty-wrap">
            <p class="brand-empty">Ministries will appear here. Manage from admin.</p>
            <a href="<?= $baseUrl ?>/about" class="brand-back">← Back to About</a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Our Ministries - Lighthouse Global Church';
$pageDescription = 'Explore ministries at Lighthouse Global Church.';
require APP_PATH . '/views/layouts/main.php';
?>
