<?php
$t = $item ?? [];
$error = $_GET['error'] ?? null;
?>
<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url('testimonies') ?>" class="admin-back-link">← Online Testimonies</a>
            <h2>Edit Testimony</h2>
        </div>
    </div>
    <?php if ($error === 'empty'): ?>
    <div class="alert alert-error" style="margin-bottom: 1.5rem;">Please enter the testimony content.</div>
    <?php elseif ($error === 'maxwords'): ?>
    <div class="alert alert-error" style="margin-bottom: 1.5rem;">Testimony exceeds the maximum of <?= (int)($maxWords ?? 300) ?> words.</div>
    <?php endif; ?>
    <form method="post" action="<?= admin_url('testimonies/' . ($t['id'] ?? '')) ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="testimony-content">Testimony *</label>
            <textarea id="testimony-content" name="content" class="rich-editor" rows="4" required placeholder="Share your story..." style="width: 100%; min-height: 180px;"><?= htmlspecialchars($t['content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <div class="form-group">
            <label for="testimony-name">Author name</label>
            <input type="text" id="testimony-name" name="name" value="<?= htmlspecialchars($t['author_name'] ?? '') ?>" placeholder="Leave blank for anonymous">
        </div>
        <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
            <input type="checkbox" id="testimony-anonymous" name="is_anonymous" value="1" <?= ($t['is_anonymous'] ?? 0) ? 'checked' : '' ?>>
            <label for="testimony-anonymous" style="margin: 0;">Post anonymously (name won't be shown)</label>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="<?= admin_url('testimonies') ?>" class="btn btn-outline">Cancel</a>
    </form>
</div>
