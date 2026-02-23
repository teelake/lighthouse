<?php
$p = $post ?? [];
$error = $_GET['error'] ?? null;
?>
<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url('prayer-wall') ?>" class="admin-back-link">← Prayer Wall</a>
            <h2>Edit Prayer</h2>
        </div>
    </div>
    <?php if ($error === 'empty'): ?>
    <div class="alert alert-error" style="margin-bottom: 1.5rem;">Please enter your prayer point.</div>
    <?php endif; ?>
    <form method="post" action="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '')) ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="wall-request">Your prayer point</label>
            <textarea id="wall-request" name="request" class="rich-editor" rows="4" required placeholder="Share a prayer point for others to pray with you..." style="width: 100%; min-height: 150px;"><?= htmlspecialchars($p['request'] ?? '') ?></textarea>
        </div>
        <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
            <input type="checkbox" id="wall-anonymous" name="is_anonymous" value="1" <?= ($p['is_anonymous'] ?? 0) ? 'checked' : '' ?>>
            <label for="wall-anonymous" style="margin: 0;">Post anonymously (your name won't be shown)</label>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="<?= admin_url('prayer-wall') ?>" class="btn btn-outline">Cancel</a>
    </form>
</div>
