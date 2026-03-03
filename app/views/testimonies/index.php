<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$sections = $sections ?? [];
$testimoniesIntro = ($sections['testimonies_intro'] ?? [])['content'] ?? null;
$items = $items ?? [];
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
<?php $heroImg = page_hero_image('testimonies'); ?>
<section class="section testimonies-page" data-animate>
    <div class="page-hero page-hero--testimonies<?= page_hero_classes($heroImg) ?>"<?= page_hero_style($heroImg) ?>>
        <div class="container">
            <h1 class="page-hero-title">Share Your Story</h1>
            <p class="page-hero-sub">Testimonies of faith, transformation, and God's goodness. Share yours—no login required.</p>
        </div>
    </div>

    <div class="container testimonies-content">
        <?php if ($submitted): ?>
        <div class="testimonies-success" role="alert">
            <p>Thank you. Your testimony has been submitted. It will appear on this page after review.</p>
        </div>
        <?php endif; ?>
        <?php if ($error === 'csrf'): ?>
        <div class="testimonies-msg testimonies-msg--error" role="alert"><p>Invalid request. Please try again.</p></div>
        <?php elseif ($error === 'empty'): ?>
        <div class="testimonies-msg testimonies-msg--error" role="alert"><p>Please enter your testimony.</p></div>
        <?php elseif ($error === 'post'): ?>
        <div class="testimonies-msg testimonies-msg--error" role="alert"><p>Something went wrong. Please try again.</p></div>
        <?php endif; ?>

        <div class="testimonies-grid testimonies-grid--wall">
            <div class="testimonies-submit-card">
                <h2 class="about-section-title">Share Your Testimony</h2>
                <div class="testimonies-desc"><?= rich_content($testimoniesIntro ?? 'Share how God has worked in your life. Your story can encourage others. No login required—post openly or anonymously.') ?></div>
                <form class="testimonies-form" action="<?= $baseUrl ?>/testimonies/submit" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="testimony-content">Your testimony *</label>
                        <div class="testimonies-quill-wrap">
                            <textarea id="testimony-content" name="content" class="rich-editor testimonies-quill-editor" rows="4" required placeholder="Share your story of faith, transformation, or God's goodness..." style="min-height: 180px;"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="testimony-name">Your name (optional)</label>
                        <input type="text" id="testimony-name" name="name" placeholder="Leave blank for anonymous">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" id="testimony-anonymous" name="is_anonymous" value="1">
                        <label for="testimony-anonymous">Post anonymously (your name won't be shown)</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Testimony</button>
                </form>
            </div>

            <div class="testimonies-list-wrap">
                <h2 class="about-section-title">Testimonies</h2>
                <?php if (empty($items)): ?>
                <p class="testimonies-note">No testimonies yet. Be the first to share above!</p>
                <?php else: ?>
                <div class="testimonies-list">
                    <?php foreach ($items as $t):
                        $author = ($t['is_anonymous'] ?? 0) ? 'Anonymous' : (trim($t['author_name'] ?? '') ?: 'A friend');
                    ?>
                    <article class="testimonies-item">
                        <div class="testimonies-item-text"><?= rich_content($t['content'] ?? '') ?: nl2br(htmlspecialchars($t['content'] ?? '')) ?></div>
                        <p class="testimonies-item-meta"><?= htmlspecialchars($author) ?> · <?= date('M j, Y', strtotime($t['created_at'] ?? 'now')) ?></p>
                    </article>
                    <?php endforeach; ?>
                </div>
                <?php if ($totalPages > 1): ?>
                <nav class="testimonies-pagination" aria-label="Testimonies pagination">
                    <div class="testimonies-pagination-info">Showing <?= (($page - 1) * $perPage) + 1 ?>–<?= min($page * $perPage, $total) ?> of <?= $total ?></div>
                    <ul class="testimonies-pagination-links">
                        <?php if ($page > 1): ?><li><a href="<?= $baseUrl ?>/testimonies<?= $buildQuery(['page' => $page - 1]) ?>" class="testimonies-pagination-link">← Prev</a></li><?php endif; ?>
                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                        <li><?php if ($i === $page): ?><span class="testimonies-pagination-current" aria-current="page"><?= $i ?></span><?php else: ?><a href="<?= $baseUrl ?>/testimonies<?= $buildQuery(['page' => $i]) ?>" class="testimonies-pagination-link"><?= $i ?></a><?php endif; ?></li>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?><li><a href="<?= $baseUrl ?>/testimonies<?= $buildQuery(['page' => $page + 1]) ?>" class="testimonies-pagination-link">Next →</a></li><?php endif; ?>
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
    if (typeof Quill === 'undefined') return;
    var ta = document.getElementById('testimony-content');
    if (!ta) return;
    var wrap = ta.closest('.testimonies-quill-wrap');
    if (!wrap) return;
    var div = document.createElement('div');
    div.className = 'quill-editor-wrap testimonies-quill-editor-wrap';
    div.style.minHeight = '180px';
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
    quill.on('text-change', function() { ta.value = quill.root.innerHTML; });
    document.querySelector('.testimonies-form').addEventListener('submit', function() {
        ta.value = quill.root.innerHTML;
    });
})();
</script>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Testimonies - Lighthouse Global Church';
$pageDescription = 'Share your testimony of faith. Read stories of transformation and God\'s goodness from our church family.';
require APP_PATH . '/views/layouts/main.php';
?>
