<?php
$p     = $post ?? [];
$error = $_GET['error'] ?? null;
?>
<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url('prayer-wall') ?>" class="admin-back-link">← Prayer Wall</a>
            <h2>Edit Prayer</h2>
        </div>
    </div>
    <?php if ($error === 'empty_title'): ?>
    <div class="alert alert-error" style="margin-bottom: 1.5rem;">Please enter a title or subject for your prayer.</div>
    <?php elseif ($error === 'empty'): ?>
    <div class="alert alert-error" style="margin-bottom: 1.5rem;">Please enter your prayer point.</div>
    <?php endif; ?>
    <form method="post" action="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '')) ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="pw-edit-title">
                Subject / Title
                <span class="pw-char-hint">(<span id="pw-title-count"><?= mb_strlen($p['title'] ?? '') ?></span>/100)</span>
            </label>
            <input
                type="text"
                id="pw-edit-title"
                name="title"
                maxlength="100"
                required
                placeholder="e.g. Prayer for healing, Breakthrough needed…"
                value="<?= htmlspecialchars($p['title'] ?? '') ?>"
                oninput="document.getElementById('pw-title-count').textContent = this.value.length"
            >
        </div>
        <div class="form-group">
            <label for="pw-edit-request">
                Your Prayer Point
                <span class="pw-char-hint">(<span id="pw-word-count">0</span>/500 words)</span>
            </label>
            <textarea id="pw-edit-request" name="request" class="rich-editor" rows="6" required style="min-height: 180px;"><?= htmlspecialchars($p['request'] ?? '') ?></textarea>
        </div>
        <div class="form-group pw-anon-check">
            <input type="checkbox" id="pw-anonymous" name="is_anonymous" value="1" <?= ($p['is_anonymous'] ?? 0) ? 'checked' : '' ?>>
            <label for="pw-anonymous">Post anonymously — your name will not be shown</label>
        </div>
        <div style="display:flex; gap: 0.75rem; flex-wrap: wrap;">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="<?= admin_url('prayer-wall') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

<script>
(function () {
    function countWords(str) {
        return str.trim() ? str.trim().split(/\s+/).length : 0;
    }
    var MAX_WORDS = 500;
    var wordCountEl = document.getElementById('pw-word-count');
    if (!wordCountEl) return;
    var pollInterval = setInterval(function () {
        var editorRoot = document.querySelector('#pw-edit-request').closest('.form-group').querySelector('.ql-editor');
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
