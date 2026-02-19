<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$leaders = $leaders ?? [];
?>
<?php $leadershipHeroImg = page_hero_image('leadership'); ?>
<section class="section leadership-page" data-animate>
    <div class="page-hero page-hero--leadership<?= page_hero_classes($leadershipHeroImg) ?>"<?= page_hero_style($leadershipHeroImg) ?>>
        <div class="container">
            <h1 class="page-hero-title">Our Leadership</h1>
            <p class="page-hero-sub">Shepherds who lead with heart and vision</p>
        </div>
    </div>

    <nav class="page-subnav" aria-label="About section navigation">
        <div class="container">
            <a href="<?= $baseUrl ?>/about" class="page-subnav-link">About Us</a>
            <a href="<?= $baseUrl ?>/leadership" class="page-subnav-link page-subnav-link--active">Leadership</a>
        </div>
    </nav>

    <div class="container leadership-grid-wrap">
        <?php if (!empty($leaders)): ?>
        <div class="leadership-grid">
            <?php foreach ($leaders as $leader): ?>
            <article class="leader-card stagger-item">
                <div class="leader-card-photo">
                    <img src="<?= htmlspecialchars($leader['photo'] ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400') ?>" alt="<?= htmlspecialchars($leader['name']) ?>" loading="lazy">
                </div>
                <div class="leader-card-body">
                    <h3 class="leader-card-name"><?= htmlspecialchars($leader['name']) ?></h3>
                    <p class="leader-card-title"><?= htmlspecialchars($leader['title']) ?></p>
                    <div class="leader-card-bio"><?= rich_content($leader['bio'] ?? '') ?></div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="leadership-empty">
            <p>Leadership profiles are being updated. Check back soon.</p>
            <a href="<?= $baseUrl ?>/about" class="btn btn-accent">Back to About Us</a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Our Leadership - Lighthouse Global Church';
$pageDescription = 'Meet the leadership team of Lighthouse Global Church.';
require APP_PATH . '/views/layouts/main.php';
?>
