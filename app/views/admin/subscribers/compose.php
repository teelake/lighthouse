<div class="admin-card" id="mass-email-compose">
    <a href="<?= admin_url('subscribers') ?>" class="admin-back-link">← Subscribers</a>
    <h2>Send Mass Email</h2>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">This will send the email to all <?= (int)($subscriberCount ?? 0) ?> newsletter subscribers. Configure SMTP in <a href="<?= admin_url('settings/email') ?>">Email Settings</a> first.</p>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if (!empty($success)): ?><div class="alert" style="background: <?= strpos($success ?? '', 'failed') !== false ? '#fef2f2' : '#d1fae5' ?>; color: <?= strpos($success ?? '', 'failed') !== false ? '#991b1b' : '#065f46' ?>;"><?= htmlspecialchars($success) ?></div><?php endif; ?>
    <form id="mass-email-form" method="post" action="<?= admin_url('subscribers/send-mass') ?>" enctype="multipart/form-data" data-upload-url="<?= htmlspecialchars(admin_url('subscribers/upload-attachment')) ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Subject</label>
            <input type="text" name="subject" value="<?= htmlspecialchars($subject ?? '') ?>" required placeholder="e.g. This Week at Lighthouse">
        </div>
        <div class="form-group">
            <label>Message</label>
            <input id="mass-email-message" type="hidden" name="message" value="<?= htmlspecialchars($message ?? '') ?>">
            <trix-editor input="mass-email-message" class="trix-editor-compose" placeholder="Compose your newsletter or announcement... Paste or drop images to embed them inline."></trix-editor>
        </div>
        <div class="form-group">
            <p class="help-text">Format text with bold, lists, links. Paste or drop images to embed inline. Subscriber names: <code>{{name}}</code>, email: <code>{{email}}</code>.</p>
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
