<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section">
    <div class="container">
        <h1><?= htmlspecialchars($item['title']) ?></h1>
        <?php if (!empty($item['embed_url'])): ?>
        <div style="aspect-ratio: 16/9; max-width: 800px; margin: 1rem 0;">
            <?php if (($item['source'] ?? '') === 'youtube'): ?>
            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?= htmlspecialchars(basename(parse_url($item['embed_url'], PHP_URL_PATH))) ?>" frameborder="0" allowfullscreen></iframe>
            <?php else: ?>
            <iframe src="<?= htmlspecialchars($item['embed_url']) ?>" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <p><?= nl2br(htmlspecialchars($item['description'] ?? '')) ?></p>
        <a href="<?= $baseUrl ?>/media">← All Media</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
