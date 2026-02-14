<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section jobs-page" data-animate>
    <div class="page-hero page-hero--jobs">
        <div class="container">
            <h1 class="page-hero-title">Join Our Team</h1>
            <p class="page-hero-sub">Build. Serve. Shine.</p>
        </div>
    </div>

    <div class="container jobs-content">
        <p class="jobs-intro">Explore opportunities to serve at Lighthouse and make an impact.</p>
        <?php if (!empty($jobs)): ?>
        <div class="jobs-list">
            <?php foreach ($jobs as $j): ?>
            <a href="<?= $baseUrl ?>/jobs/<?= htmlspecialchars($j['slug']) ?>" class="job-card stagger-item">
                <div class="job-card-main">
                    <h3><?= htmlspecialchars($j['title']) ?></h3>
                    <span class="job-type"><?= htmlspecialchars($j['type'] ?? 'Full-time') ?></span>
                </div>
                <span class="link-arrow">View details →</span>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="brand-empty-wrap">
            <p class="brand-empty">Job listings will appear here. Manage from admin.</p>
            <a href="<?= $baseUrl ?>/contact" class="brand-back">← Contact Us</a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Careers - Lighthouse Global Church';
$pageDescription = 'Job opportunities at Lighthouse Global Church.';
require APP_PATH . '/views/layouts/main.php';
?>
