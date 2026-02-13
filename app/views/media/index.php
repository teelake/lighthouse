<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$mediaThumb = function ($m) {
    if (!empty($m['thumbnail'])) return $m['thumbnail'];
    $url = $m['embed_url'] ?? '';
    if (!empty($url) && preg_match('/(?:v=|\/embed\/|\/v\/|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $mat)) {
        return 'https://img.youtube.com/vi/' . $mat[1] . '/maxresdefault.jpg';
    }
    return 'https://images.unsplash.com/photo-1516455590571-18256e5bb9ff?w=600';
};
?>
<section class="section media-page" data-animate>
    <div class="section-title-bar">
        <div class="section-title-bar-inner">
            <h1 class="section-title">Media & Teachings</h1>
        </div>
    </div>
    <div class="container media-shell">
        <p class="media-kicker">Stream & grow</p>
        <p class="media-sub">Watch sermons, teachings, and worship — anytime, anywhere.</p>
        <?php if (!empty($media)): ?>
        <div class="media-grid">
            <?php foreach ($media as $m): ?>
            <a class="media-card" href="<?= $baseUrl ?>/media/<?= htmlspecialchars($m['slug']) ?>" aria-label="Watch: <?= htmlspecialchars($m['title']) ?>">
                <div class="media-card-thumb" style="background-image: url('<?= htmlspecialchars($mediaThumb($m)) ?>');">
                    <span class="media-card-tag"><?= htmlspecialchars(ucfirst($m['media_type'])) ?></span>
                    <?php if (!empty($m['duration'])): ?><span class="media-card-duration"><?= htmlspecialchars($m['duration']) ?></span><?php endif; ?>
                    <span class="media-card-play">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    </span>
                </div>
                <div class="media-card-body">
                    <h3 class="media-card-title"><?= htmlspecialchars($m['title']) ?></h3>
                    <p class="media-card-meta"><?= htmlspecialchars($m['published_at'] ?? '') ?></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="media-empty">
            <p>No media yet. Check back soon — we're adding sermons, teachings, and more.</p>
        </div>
        <?php endif; ?>
        <a href="<?= $baseUrl ?>/" class="media-back">← Back to Home</a>
    </div>
</section>
<?php $content = ob_get_clean(); require APP_PATH . '/views/layouts/main.php'; ?>
