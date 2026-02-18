<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1><?= htmlspecialchars($job['title']) ?></h1>
        <p><?= htmlspecialchars(job_type_label($job['type'] ?? '')) ?></p>
        <div class="job-desc"><?= rich_content($job['description'] ?? '') ?></div>
        <a href="<?= $baseUrl ?>/jobs">← All Jobs</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
