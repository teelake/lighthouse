<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1><?= htmlspecialchars($group['title']) ?></h1>
        <p><?= nl2br(htmlspecialchars($group['description'] ?? '')) ?></p>
        <a href="<?= $baseUrl ?>/small-groups">← All Small Groups</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
