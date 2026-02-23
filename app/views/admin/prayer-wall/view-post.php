<?php
$p = $post ?? [];
$author = $author ?? 'Unknown';
$isAdmin = $isAdmin ?? false;
?>
<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url('prayer-wall') ?>" class="admin-back-link">← Prayer Wall</a>
            <h2>Prayer Wall Post</h2>
        </div>
        <?php if ($isAdmin): ?>
        <form method="post" action="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this post?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <?php endif; ?>
    </div>
    <div style="background: var(--adm-bg); padding: 1.25rem 1.5rem; border-radius: var(--adm-radius-sm); border: 1px solid var(--adm-border);">
        <p style="margin: 0 0 0.5rem; font-size: 0.875rem; color: var(--adm-muted);"><?= htmlspecialchars($p['created_at'] ?? '') ?></p>
        <p style="margin: 0 0 1rem; font-weight: 600;"><?= htmlspecialchars($author) ?></p>
        <p style="margin: 0; white-space: pre-wrap; line-height: 1.6;"><?= nl2br(htmlspecialchars($p['request'] ?? '')) ?></p>
    </div>
</div>
