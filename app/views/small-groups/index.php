<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<?php $smallGroupsHeroImg = page_hero_image('small-groups'); ?>
<section class="section small-groups-page" data-animate>
    <div class="page-hero page-hero--small-groups<?= page_hero_classes($smallGroupsHeroImg) ?>"<?= page_hero_style($smallGroupsHeroImg) ?>>
        <div class="container">
            <h1 class="page-hero-title">Small Groups</h1>
            <p class="page-hero-sub">Connect in community</p>
        </div>
    </div>

    <div class="container small-groups-content">
        <p class="small-groups-intro">Connect with others in communities for ages 16–46. Find your people and grow together.</p>
        <?php if (!empty($groups)): ?>
        <div class="small-groups-grid">
            <?php foreach ($groups as $g): ?>
            <a href="<?= $baseUrl ?>/small-groups/<?= htmlspecialchars($g['slug']) ?>" class="ministry-card stagger-item">
                <div class="ministry-card-body">
                    <h3><?= htmlspecialchars($g['title']) ?></h3>
                    <div class="ministry-card-tagline"><?= rich_content($g['tagline'] ?? '') ?></div>
                    <span class="link-arrow">Join group →</span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="brand-empty-wrap">
            <p class="brand-empty">Small groups will appear here. Manage from admin.</p>
            <a href="<?= $baseUrl ?>/im-new" class="brand-back">← Get Connected</a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Small Groups - Lighthouse Global Church';
$pageDescription = 'Find a small group at Lighthouse. Connect in community.';
require APP_PATH . '/views/layouts/main.php';
?>
