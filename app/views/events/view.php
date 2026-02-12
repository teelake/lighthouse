<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1><?= htmlspecialchars($event['title']) ?></h1>
        <p><?= nl2br(htmlspecialchars($event['description'] ?? '')) ?></p>
        <a href="<?= $baseUrl ?>/events">← All Events</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
