<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$videoId = '';
if (($item['source'] ?? '') === 'youtube' && !empty($item['embed_url']) && preg_match('/(?:v=|\/embed\/|\/v\/|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $item['embed_url'], $m)) {
    $videoId = $m[1];
}
?>
<section class="section media-view-page" data-animate>
    <div class="container media-view-shell">
        <span class="media-view-tag"><?= htmlspecialchars(ucfirst($item['media_type'] ?? 'video')) ?></span>
        <h1 class="media-view-title"><?= htmlspecialchars($item['title']) ?></h1>
        <?php if (!empty($item['embed_url'])): ?>
        <div class="media-view-player">
            <?php if ($videoId): ?>
            <iframe src="https://www.youtube.com/embed/<?= htmlspecialchars($videoId) ?>" frameborder="0" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" title="<?= htmlspecialchars($item['title']) ?>"></iframe>
            <?php else: ?>
            <iframe src="<?= htmlspecialchars($item['embed_url']) ?>" frameborder="0" allowfullscreen title="<?= htmlspecialchars($item['title']) ?>"></iframe>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if (!empty($item['description'])): ?>
        <div class="media-view-desc">
            <?= nl2br(htmlspecialchars($item['description'])) ?>
        </div>
        <?php endif; ?>
        <a href="<?= $baseUrl ?>/media" class="media-back">← All Media</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
