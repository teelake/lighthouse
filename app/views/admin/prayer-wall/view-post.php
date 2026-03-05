<?php
$p         = $post ?? [];
$author    = $author ?? 'Unknown';
$isAdmin   = $isAdmin ?? false;
$canEdit   = $canEdit ?? false;
$canDelete = $canDelete ?? ($isAdmin || $canEdit);
$title     = htmlspecialchars($p['title'] ?? 'Prayer Request');
$dateStr   = !empty($p['created_at']) ? date('F j, Y \a\t g:i A', strtotime($p['created_at'])) : '';
?>
<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url('prayer-wall') ?>" class="admin-back-link">← Prayer Wall</a>
            <h2><?= $title ?></h2>
        </div>
        <?php if ($canDelete): ?>
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <?php if ($canEdit): ?>
            <a href="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '') . '/edit') ?>" class="btn btn-outline">Edit</a>
            <?php endif; ?>
            <form method="post" action="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this prayer point?');" style="margin:0;">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
        <?php endif; ?>
    </div>

    <div class="pw-view-card">
        <div class="pw-view-meta">
            <span class="pw-view-author">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <?= htmlspecialchars($author) ?>
            </span>
            <?php if ($dateStr): ?>
            <span class="pw-view-date">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <?= $dateStr ?>
            </span>
            <?php endif; ?>
            <?php if (!empty($p['is_anonymous'])): ?>
            <span class="pw-view-anon-badge">Anonymous</span>
            <?php endif; ?>
        </div>
        <div class="pw-view-body">
            <?= rich_content($p['request'] ?? '') ?: nl2br(htmlspecialchars($p['request'] ?? '')) ?>
        </div>
    </div>
</div>
