<?php
$r = $request ?? [];
$isAdmin = $isAdmin ?? false;
?>
<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url('prayer-wall') ?>" class="admin-back-link">← Prayer Wall</a>
            <h2>Prayer Request</h2>
        </div>
        <?php if ($isAdmin): ?>
        <form method="post" action="<?= admin_url('prayer-wall/requests/' . ($r['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this request?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <?php endif; ?>
    </div>
    <div style="background: var(--adm-bg); padding: 1.25rem 1.5rem; border-radius: var(--adm-radius-sm); border: 1px solid var(--adm-border);">
        <p style="margin: 0 0 0.5rem; font-size: 0.875rem; color: var(--adm-muted);"><?= htmlspecialchars($r['created_at'] ?? '') ?></p>
        <p style="margin: 0 0 1rem; font-weight: 600;"><?= htmlspecialchars(($r['name'] ?? '') ?: 'Anonymous') ?></p>
        <?php if (!empty($r['email'])): ?>
        <p style="margin: 0 0 1rem; font-size: 0.9rem;"><a href="mailto:<?= htmlspecialchars($r['email']) ?>"><?= htmlspecialchars($r['email']) ?></a></p>
        <?php endif; ?>
        <p style="margin: 0; white-space: pre-wrap; line-height: 1.6;"><?= nl2br(htmlspecialchars($r['request'] ?? '')) ?></p>
    </div>
</div>
