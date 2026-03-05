<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$post    = $post ?? [];
$author  = $author ?? 'A friend';
$title   = $title ?? 'Prayer Request';
$dateStr = !empty($post['created_at']) ? date('F j, Y \a\t g:i A', strtotime($post['created_at'])) : '';
?>
<?php $prayerHeroImg = page_hero_image('prayer'); ?>
<section class="section prayer-page" data-animate>
    <div class="page-hero page-hero--prayer<?= page_hero_classes($prayerHeroImg) ?>"<?= page_hero_style($prayerHeroImg) ?>>
        <div class="container">
            <h1 class="page-hero-title">Prayer Wall</h1>
            <p class="page-hero-sub">Share prayer needs. Pray with others. Open to everyone.</p>
        </div>
    </div>

    <div class="container prayer-content">
        <div class="prayer-view-wrap">
            <a href="<?= $baseUrl ?>/prayer" class="prayer-view-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                Back to Prayer Wall
            </a>

            <article class="prayer-view-card">
                <header class="prayer-view-header">
                    <h2 class="prayer-view-title"><?= htmlspecialchars($title) ?></h2>
                    <div class="prayer-view-meta">
                        <span class="prayer-view-author">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <?= htmlspecialchars($author) ?>
                        </span>
                        <?php if ($dateStr): ?>
                        <span class="prayer-view-date">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <?= $dateStr ?>
                        </span>
                        <?php endif; ?>
                        <?php if (!empty($post['is_anonymous'])): ?>
                        <span class="prayer-view-anon-badge">Anonymous</span>
                        <?php endif; ?>
                    </div>
                </header>

                <div class="prayer-view-body">
                    <?= rich_content($post['request'] ?? '') ?: nl2br(htmlspecialchars($post['request'] ?? '')) ?>
                </div>
            </article>

            <div class="prayer-view-cta">
                <p>Moved to pray? Join us on the wall.</p>
                <a href="<?= $baseUrl ?>/prayer" class="btn btn-primary">Go to Prayer Wall</a>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle       = $pageTitle ?? 'Prayer Wall | Lighthouse Global Church';
$pageDescription = $pageDescription ?? 'Read and pray along with this prayer shared on the Lighthouse Global Church Prayer Wall.';
require APP_PATH . '/views/layouts/main.php';
?>
