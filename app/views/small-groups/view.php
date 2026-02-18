<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1><?= htmlspecialchars($group['title']) ?></h1>
        <div class="group-desc"><?= rich_content($group['description'] ?? '') ?></div>
        <a href="<?= $baseUrl ?>/small-groups">← All Small Groups</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
