<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<?php $jobsHeroImg = page_hero_image('jobs'); ?>
<section class="section job-view-page" data-animate>
    <div class="page-hero page-hero--jobs<?= page_hero_classes($jobsHeroImg) ?>"<?= page_hero_style($jobsHeroImg) ?>>
        <div class="container">
            <h1 class="page-hero-title"><?= htmlspecialchars($job['title']) ?></h1>
            <p class="page-hero-sub"><?= htmlspecialchars(job_type_label($job['type'] ?? '')) ?></p>
        </div>
    </div>
    <div class="container job-view-content">
        <a href="<?= $baseUrl ?>/jobs" class="brand-back">← All Jobs</a>
        <div class="job-desc"><?= rich_content($job['description'] ?? '') ?></div>
        <a href="<?= $baseUrl ?>/jobs/<?= htmlspecialchars($job['slug']) ?>/apply" class="btn btn-watch job-apply-cta">Apply Now</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
