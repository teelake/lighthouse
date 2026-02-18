<div class="admin-card">
    <a href="<?= admin_url('subscribers') ?>" class="admin-back-link">← Subscribers</a>
    <h2>Send Mass Email</h2>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">This will send the email to all <?= (int)($subscriberCount ?? 0) ?> newsletter subscribers. Configure SMTP in <a href="<?= admin_url('settings/email') ?>">Email Settings</a> first.</p>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if (!empty($success)): ?><div class="alert" style="background: #d1fae5; color: #065f46;"><?= htmlspecialchars($success) ?></div><?php endif; ?>
    <form method="post" action="<?= admin_url('subscribers/send-mass') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Subject</label>
            <input type="text" name="subject" value="<?= htmlspecialchars($subject ?? '') ?>" required placeholder="e.g. This Week at Lighthouse">
        </div>
        <div class="form-group">
            <label>Message (HTML)</label>
            <textarea name="message" class="rich-editor" rows="12" required placeholder="Compose your newsletter or announcement..."><?= htmlspecialchars($message ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <p class="help-text">Use HTML for formatting. Subscriber names can be inserted as <code>{{name}}</code> and email as <code>{{email}}</code>.</p>
        </div>
        <div class="form-actions">
            <?php $count = (int)($subscriberCount ?? 0); ?>
            <button type="submit" class="btn btn-primary" <?= $count === 0 ? 'disabled' : '' ?>>
                <?= $count === 0 ? 'No Subscribers to Send To' : 'Send to ' . $count . ' Subscriber(s)' ?>
            </button>
            <a href="<?= admin_url('subscribers') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
