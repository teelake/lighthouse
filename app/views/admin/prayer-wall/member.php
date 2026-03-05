<?php
$posts         = $posts ?? [];
$users         = $users ?? [];
$posted        = $posted ?? false;
$updated       = isset($_GET['updated']);
$error         = $error ?? null;
$page          = (int)($page ?? 1);
$totalPages    = (int)($totalPages ?? 1);
$total         = (int)($total ?? 0);
$perPage       = (int)($perPage ?? 15);
$currentUserId = (int)($currentUserId ?? 0);
$buildQuery    = function ($overrides = []) {
    $q = array_merge($_GET, $overrides);
    $q = array_filter($q);
    return $q ? '?' . http_build_query($q) : '';
};
?>
<div class="admin-card pw-member-wrap">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Prayer Wall</h2>
        </div>
        <button class="btn btn-primary" onclick="document.getElementById('pw-post-form').scrollIntoView({behavior:'smooth'})">
            + Post a Prayer
        </button>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 2rem;">A sacred space for church members to share prayer points and pray together. Share openly or stay anonymous.</p>

    <?php if ($posted): ?>
    <div class="alert alert-success" style="margin-bottom: 1.5rem;">Your prayer has been posted. Thank you for sharing.</div>
    <?php endif; ?>
    <?php if ($updated): ?>
    <div class="alert alert-success" style="margin-bottom: 1.5rem;">Your prayer has been updated.</div>
    <?php endif; ?>
    <?php if ($error === 'csrf'): ?>
    <div class="alert alert-error" style="margin-bottom: 1.5rem;">Invalid request. Please try again.</div>
    <?php elseif ($error === 'empty_title'): ?>
    <div class="alert alert-error" style="margin-bottom: 1.5rem;">Please enter a title or subject for your prayer.</div>
    <?php elseif ($error === 'empty'): ?>
    <div class="alert alert-error" style="margin-bottom: 1.5rem;">Please enter your prayer point.</div>
    <?php elseif ($error === 'post'): ?>
    <div class="alert alert-error" style="margin-bottom: 1.5rem;">Something went wrong. Please try again.</div>
    <?php endif; ?>

    <!-- Prayer Wall Cards -->
    <?php if (empty($posts)): ?>
    <div class="pw-empty">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        <p>No prayer points yet. Be the first to post below!</p>
    </div>
    <?php else: ?>
    <div class="pw-card-grid">
        <?php foreach ($posts as $p): ?>
        <?php
            $isOwn   = ((int)($p['user_id'] ?? 0) === $currentUserId);
            $isAnon  = !empty($p['is_anonymous']);
            $author  = $isAnon ? 'Anonymous' : htmlspecialchars($users[$p['user_id'] ?? 0] ?? 'Member');
            $title   = htmlspecialchars($p['title'] ?? 'Prayer Request');
            $rawText = strip_tags($p['request'] ?? '');
            $excerpt = mb_strlen($rawText) > 160 ? mb_substr($rawText, 0, 160) . '…' : $rawText;
            $dateStr = date('M j, Y', strtotime($p['created_at'] ?? 'now'));
        ?>
        <div class="pw-card<?= $isOwn ? ' pw-card--own' : '' ?>">
            <div class="pw-card-body">
                <h3 class="pw-card-title"><?= $title ?></h3>
                <p class="pw-card-excerpt"><?= htmlspecialchars($excerpt) ?></p>
            </div>
            <div class="pw-card-footer">
                <div class="pw-card-meta">
                    <span class="pw-card-author">
                        <?php if ($isAnon): ?>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <?php endif; ?>
                        <?= $author ?>
                    </span>
                    <span class="pw-card-date"><?= $dateStr ?></span>
                </div>
                <div class="pw-card-actions">
                    <a href="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '')) ?>" class="pw-btn-read">
                        Pray With Them <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <?php if ($isOwn): ?>
                    <div class="pw-card-owner-actions">
                        <a href="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '') . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                        <form method="post" action="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this prayer point?');" style="margin:0;">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if ($totalPages > 1): ?>
    <nav class="job-app-pagination" style="margin-top: 2rem;" aria-label="Pagination">
        <div class="job-app-pagination-info">Showing <?= (($page - 1) * $perPage) + 1 ?>–<?= min($page * $perPage, $total) ?> of <?= $total ?></div>
        <ul class="job-app-pagination-links">
            <?php if ($page > 1): ?><li><a href="<?= admin_url('prayer-wall') ?><?= $buildQuery(['page' => $page - 1]) ?>" class="job-app-pagination-link">← Prev</a></li><?php endif; ?>
            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
            <li><?php if ($i === $page): ?><span class="job-app-pagination-current" aria-current="page"><?= $i ?></span><?php else: ?><a href="<?= admin_url('prayer-wall') ?><?= $buildQuery(['page' => $i]) ?>" class="job-app-pagination-link"><?= $i ?></a><?php endif; ?></li>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?><li><a href="<?= admin_url('prayer-wall') ?><?= $buildQuery(['page' => $page + 1]) ?>" class="job-app-pagination-link">Next →</a></li><?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
    <?php endif; ?>

    <!-- Post Form -->
    <div class="admin-card pw-post-form-card" id="pw-post-form" style="margin-top: 2.5rem;">
        <h3 class="pw-form-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            Share a Prayer Point
        </h3>
        <form method="post" action="<?= admin_url('prayer-wall/post') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="pw-title">
                    Subject / Title
                    <span class="pw-char-hint">(<span id="pw-title-count">0</span>/100)</span>
                </label>
                <input
                    type="text"
                    id="pw-title"
                    name="title"
                    maxlength="100"
                    required
                    placeholder="e.g. Prayer for healing, Breakthrough needed…"
                    oninput="document.getElementById('pw-title-count').textContent = this.value.length"
                >
            </div>
            <div class="form-group">
                <label for="pw-request">
                    Your Prayer Point
                    <span class="pw-char-hint">(<span id="pw-word-count">0</span>/500 words)</span>
                </label>
                <textarea id="pw-request" name="request" class="rich-editor" rows="5" required placeholder="Share what's on your heart…" style="min-height: 160px;"></textarea>
            </div>
            <div class="form-group pw-anon-check">
                <input type="checkbox" id="pw-anonymous" name="is_anonymous" value="1">
                <label for="pw-anonymous">Post anonymously — your name will not be shown</label>
            </div>
            <button type="submit" class="btn btn-primary">Post to Prayer Wall</button>
        </form>
    </div>
</div>

<script>
(function () {
    // Word counter for Quill editor
    function countWords(str) {
        return str.trim() ? str.trim().split(/\s+/).length : 0;
    }
    var MAX_WORDS = 500;
    var wordCountEl = document.getElementById('pw-word-count');
    if (!wordCountEl) return;

    // Poll until Quill has initialised the editor
    var pollInterval = setInterval(function () {
        var editorRoot = document.querySelector('#pw-request').closest('.form-group').querySelector('.ql-editor');
        if (!editorRoot) return;
        clearInterval(pollInterval);

        function update() {
            var words = countWords(editorRoot.innerText || '');
            wordCountEl.textContent = words;
            wordCountEl.style.color = words > MAX_WORDS ? 'var(--adm-danger, #e53e3e)' : '';
        }
        editorRoot.addEventListener('input', update);
        update();
    }, 100);
})();
</script>
