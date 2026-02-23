<?php
$p = $post ?? [];
$author = $author ?? 'Unknown';
$isAdmin = $isAdmin ?? false;
$canEdit = $canEdit ?? false;
$canDelete = $isAdmin || $canEdit;
?>
<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url('prayer-wall') ?>" class="admin-back-link">← Prayer Wall</a>
            <h2>Prayer Wall Post</h2>
        </div>
        <?php if ($canDelete): ?>
        <div style="display: flex; gap: 0.5rem;">
            <?php if ($canEdit): ?>
            <a href="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '') . '/edit') ?>" class="btn btn-outline">Edit</a>
            <?php endif; ?>
            <form method="post" action="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this post?');">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
    <div style="background: var(--adm-bg); padding: 1.25rem 1.5rem; border-radius: var(--adm-radius-sm); border: 1px solid var(--adm-border);">
        <p style="margin: 0 0 0.5rem; font-size: 0.875rem; color: var(--adm-muted);"><?= htmlspecialchars($p['created_at'] ?? '') ?></p>
        <p style="margin: 0 0 1rem; font-weight: 600;"><?= htmlspecialchars($author) ?></p>
        <div style="margin: 0; line-height: 1.6;"><?= rich_content($p['request'] ?? '') ?: nl2br(htmlspecialchars($p['request'] ?? '')) ?></div>
    </div>
</div>
