<?php
$posts = $posts ?? [];
$users = $users ?? [];
$posted = $posted ?? false;
$error = $error ?? null;
?>
<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Prayer Wall</h2>
        </div>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1.5rem;">A digital space for church members to post prayer points and pray together. You can share openly or post anonymously.</p>

    <?php if ($posted): ?>
    <div class="alert alert-success" style="margin-bottom: 1.5rem;">Your prayer point has been posted. Thank you for sharing.</div>
    <?php endif; ?>
    <?php if ($error === 'csrf'): ?>
    <div class="alert alert-error" style="margin-bottom: 1.5rem;">Invalid request. Please try again.</div>
    <?php elseif ($error === 'empty'): ?>
    <div class="alert alert-error" style="margin-bottom: 1.5rem;">Please enter your prayer point.</div>
    <?php elseif ($error === 'post'): ?>
    <div class="alert alert-error" style="margin-bottom: 1.5rem;">Something went wrong. Please try again.</div>
    <?php endif; ?>

    <div class="admin-card" style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; margin: 0 0 1rem;">Post a Prayer Point</h3>
        <form method="post" action="<?= admin_url('prayer-wall/post') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="wall-request">Your prayer point</label>
                <textarea id="wall-request" name="request" rows="4" required placeholder="Share a prayer point for others to pray with you..." style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--adm-border); border-radius: var(--adm-radius-sm); font-family: inherit; font-size: 1rem;"></textarea>
            </div>
            <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" id="wall-anonymous" name="is_anonymous" value="1">
                <label for="wall-anonymous" style="margin: 0;">Post anonymously (your name won't be shown)</label>
            </div>
            <button type="submit" class="btn btn-primary">Post to Wall</button>
        </form>
    </div>

    <h3 style="font-size: 1rem; font-weight: 600; margin: 0 0 1rem;">Prayer Points</h3>
    <?php if (empty($posts)): ?>
    <p style="color: var(--adm-muted);">No prayer points yet. Be the first to post above!</p>
    <?php else: ?>
    <div style="display: flex; flex-direction: column; gap: 1rem;">
        <?php foreach ($posts as $p): ?>
        <div style="background: var(--adm-bg); padding: 1rem 1.25rem; border-radius: var(--adm-radius-sm); border: 1px solid var(--adm-border);">
            <p style="margin: 0 0 0.5rem; color: var(--adm-text); line-height: 1.6;"><?= nl2br(htmlspecialchars($p['request'] ?? '')) ?></p>
            <p style="margin: 0; font-size: 0.875rem; color: var(--adm-muted);"><?= ($p['is_anonymous'] ?? 0) ? 'Anonymous' : htmlspecialchars($users[$p['user_id'] ?? 0] ?? 'Member') ?> · <?= date('M j, Y', strtotime($p['created_at'] ?? 'now')) ?></p>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
