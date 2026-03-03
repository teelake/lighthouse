<?php
$t = $item ?? [];
$author = $author ?? 'Unknown';
$isAdmin = $isAdmin ?? false;
?>
<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url('testimonies') ?>" class="admin-back-link">← Online Testimonies</a>
            <h2>View Testimony</h2>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="<?= admin_url('testimonies/' . ($t['id'] ?? '') . '/edit') ?>" class="btn btn-outline">Edit</a>
            <?php if ($isAdmin): ?>
            <form method="post" action="<?= admin_url('testimonies/' . ($t['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this testimony?');">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
    <div style="background: var(--adm-bg); padding: 1.25rem 1.5rem; border-radius: var(--adm-radius-sm); border: 1px solid var(--adm-border);">
        <p style="margin: 0 0 0.5rem; font-size: 0.875rem; color: var(--adm-muted);"><?= htmlspecialchars($t['created_at'] ?? '') ?></p>
        <p style="margin: 0 0 1rem; font-weight: 600;"><?= htmlspecialchars($author) ?></p>
        <div style="margin: 0; line-height: 1.6;"><?= rich_content($t['content'] ?? '') ?: nl2br(htmlspecialchars($t['content'] ?? '')) ?></div>
    </div>
</div>
