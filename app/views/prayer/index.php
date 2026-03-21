<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$sections = $sections ?? [];
$prayerIntro = ($sections['prayer_intro'] ?? [])['content'] ?? null;
$posts = $posts ?? [];
$authors = $authors ?? [];
$page = (int)($page ?? 1);
$totalPages = (int)($totalPages ?? 1);
$total = (int)($total ?? 0);
$perPage = (int)($perPage ?? 12);
$submitted = isset($_GET['submitted']);
$error = $_GET['error'] ?? null;
$buildQuery = function ($overrides = []) {
    $q = array_merge($_GET, $overrides);
    $q = array_filter($q);
    return $q ? '?' . http_build_query($q) : '';
};
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
        <?php if ($submitted): ?>
        <div class="prayer-success" role="alert">
            <p>Thank you. Your prayer has been posted to the wall. Our church family will pray with you.</p>
        </div>
        <?php endif; ?>
        <?php if ($error === 'csrf'): ?>
        <div class="prayer-msg prayer-msg--error" role="alert"><p>Invalid request. Please try again.</p></div>
        <?php elseif ($error === 'empty_title'): ?>
        <div class="prayer-msg prayer-msg--error" role="alert"><p>Please enter a title or subject for your prayer.</p></div>
        <?php elseif ($error === 'empty'): ?>
        <div class="prayer-msg prayer-msg--error" role="alert"><p>Please enter your prayer.</p></div>
        <?php elseif ($error === 'post'): ?>
        <div class="prayer-msg prayer-msg--error" role="alert"><p>Something went wrong. Please try again.</p></div>
        <?php endif; ?>

        <div class="prayer-grid prayer-grid--wall">
            <div class="prayer-wall-card prayer-submit-card">
                <h2 class="about-section-title">Post a Prayer</h2>
                <div class="prayer-desc"><?= rich_content($prayerIntro ?? 'Share your prayer need with the church family. Members and visitors alike can post—openly or anonymously. We stand with you in prayer.') ?></div>
                <form class="prayer-wall-form" action="<?= $baseUrl ?>/prayer/submit" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="prayer-title">
                            Subject / Title *
                            <span class="prayer-char-hint">(<span id="prayer-title-count">0</span>/100)</span>
                        </label>
                        <input
                            type="text"
                            id="prayer-title"
                            name="title"
                            maxlength="100"
                            required
                            placeholder="e.g. Prayer for healing, Breakthrough needed…"
                            oninput="document.getElementById('prayer-title-count').textContent = this.value.length"
                        >
                    </div>
                    <div class="form-group">
                        <label for="prayer-request">
                            Your prayer *
                            <span class="prayer-char-hint">(<span id="prayer-word-count">0</span>/500 words)</span>
                        </label>
                        <div class="prayer-quill-wrap">
                            <textarea id="prayer-request" name="request" class="rich-editor prayer-quill-editor" rows="4" required placeholder="Share your prayer need..." style="min-height: 160px;"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="prayer-name">Your name (optional)</label>
                        <input type="text" id="prayer-name" name="name" maxlength="255" placeholder="Leave blank for anonymous">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" id="prayer-anonymous" name="is_anonymous" value="1">
                        <label for="prayer-anonymous">Post anonymously (your name won't be shown)</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Post to Wall</button>
                </form>
            </div>

            <div class="prayer-wall-posts">
                <h2 class="about-section-title">Prayer Wall</h2>
                <?php if (empty($posts)): ?>
                <p class="prayer-note">No prayers yet. Be the first to post above!</p>
                <?php else: ?>
                <div class="prayer-wall-list">
                    <?php foreach ($posts as $p):
                        $author  = ($p['is_anonymous'] ?? 0) ? 'Anonymous' : (trim($p['author_name'] ?? '') ?: ($authors[$p['user_id'] ?? 0] ?? 'A friend'));
                        $title   = trim($p['title'] ?? '');
                        $rawText = strip_tags($p['request'] ?? '');
                        $excerpt = mb_strlen($rawText) > 180 ? mb_substr($rawText, 0, 180) . '…' : $rawText;
                        $dateStr = date('M j, Y', strtotime($p['created_at'] ?? 'now'));
                    ?>
                    <a href="<?= $baseUrl ?>/prayer/<?= (int)$p['id'] ?>" class="prayer-wall-item">
                        <?php if ($title): ?>
                        <h3 class="prayer-wall-item-title"><?= htmlspecialchars($title) ?></h3>
                        <?php endif; ?>
                        <p class="prayer-wall-item-excerpt"><?= htmlspecialchars($excerpt) ?></p>
                        <div class="prayer-wall-item-footer">
                            <p class="prayer-wall-item-meta"><?= htmlspecialchars($author) ?> · <?= $dateStr ?></p>
                            <span class="prayer-wall-read-more">Read prayer →</span>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php if ($totalPages > 1): ?>
                <nav class="prayer-pagination" aria-label="Prayer wall pagination">
                    <div class="prayer-pagination-info">Showing <?= (($page - 1) * $perPage) + 1 ?>–<?= min($page * $perPage, $total) ?> of <?= $total ?></div>
                    <ul class="prayer-pagination-links">
                        <?php if ($page > 1): ?><li><a href="<?= $baseUrl ?>/prayer<?= $buildQuery(['page' => $page - 1]) ?>" class="prayer-pagination-link">← Prev</a></li><?php endif; ?>
                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                        <li><?php if ($i === $page): ?><span class="prayer-pagination-current" aria-current="page"><?= $i ?></span><?php else: ?><a href="<?= $baseUrl ?>/prayer<?= $buildQuery(['page' => $i]) ?>" class="prayer-pagination-link"><?= $i ?></a><?php endif; ?></li>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?><li><a href="<?= $baseUrl ?>/prayer<?= $buildQuery(['page' => $page + 1]) ?>" class="prayer-pagination-link">Next →</a></li><?php endif; ?>
                    </ul>
                </nav>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.min.js"></script>
<script>
(function() {
    // Quill rich editor + word counter
    if (typeof Quill === 'undefined') return;
    var ta = document.getElementById('prayer-request');
    if (!ta) return;
    var wrap = ta.closest('.prayer-quill-wrap');
    if (!wrap) return;
    var div = document.createElement('div');
    div.className = 'quill-editor-wrap prayer-quill-editor-wrap';
    div.style.minHeight = '160px';
    wrap.insertBefore(div, ta);
    ta.style.display = 'none';
    var quill = new Quill(div, {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'blockquote'],
                ['clean']
            ]
        }
    });
    var wordCountEl = document.getElementById('prayer-word-count');
    var MAX_WORDS = 500;
    function countWords(str) { return str.trim() ? str.trim().split(/\s+/).length : 0; }
    quill.on('text-change', function() {
        ta.value = quill.root.innerHTML;
        if (wordCountEl) {
            var words = countWords(quill.getText());
            wordCountEl.textContent = words;
            wordCountEl.style.color = words > MAX_WORDS ? '#b91c1c' : '';
        }
    });
    document.querySelector('.prayer-wall-form').addEventListener('submit', function() {
        ta.value = quill.root.innerHTML;
    });
})();
</script>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Prayer - Lighthouse Global Church';
$pageDescription = 'Share prayer needs on the Prayer Wall. Post openly or anonymously. We stand with you in prayer.';
require APP_PATH . '/views/layouts/main.php';
?>
