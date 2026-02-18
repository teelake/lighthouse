<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url('settings/general') ?>" class="admin-back-link">← General</a>
            <h2>Email Settings</h2>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="<?= admin_url('settings/general') ?>" class="btn btn-outline btn-sm">General</a>
            <a href="<?= admin_url('settings/homepage') ?>" class="btn btn-outline btn-sm">Homepage</a>
            <a href="<?= admin_url('settings/payment') ?>" class="btn btn-outline btn-sm">Payment</a>
        </div>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Configure SMTP for sending mass emails to subscribers. Leave SMTP empty to use PHP mail() (less reliable).</p>
    <form method="post" action="<?= admin_url('settings/email') ?>">
        <?= csrf_field() ?>
        <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 0.75rem;">From Address</h3>
        <div class="form-group">
            <label>From Email</label>
            <input type="email" name="mail_from_email" value="<?= htmlspecialchars($mail_from_email ?? '') ?>" placeholder="noreply@thelighthouseglobal.org">
        </div>
        <div class="form-group">
            <label>From Name</label>
            <input type="text" name="mail_from_name" value="<?= htmlspecialchars($mail_from_name ?? 'Lighthouse Global Church') ?>">
        </div>
        <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 0.75rem;">SMTP Configuration</h3>
        <div class="form-group">
            <label>SMTP Host</label>
            <input type="text" name="smtp_host" value="<?= htmlspecialchars($smtp_host ?? '') ?>" placeholder="smtp.example.com">
        </div>
        <div class="form-group">
            <label>SMTP Port</label>
            <input type="number" name="smtp_port" value="<?= htmlspecialchars($smtp_port ?? '587') ?>" placeholder="587">
            <p class="help-text">Usually 587 (TLS) or 465 (SSL).</p>
        </div>
        <div class="form-group">
            <label>Encryption</label>
            <select name="smtp_encryption">
                <option value="tls" <?= ($smtp_encryption ?? 'tls') === 'tls' ? 'selected' : '' ?>>TLS</option>
                <option value="ssl" <?= ($smtp_encryption ?? '') === 'ssl' ? 'selected' : '' ?>>SSL</option>
                <option value="none" <?= ($smtp_encryption ?? '') === 'none' ? 'selected' : '' ?>>None</option>
            </select>
        </div>
        <div class="form-group">
            <label>SMTP Username</label>
            <input type="text" name="smtp_user" value="<?= htmlspecialchars($smtp_user ?? '') ?>">
        </div>
        <div class="form-group">
            <label>SMTP Password</label>
            <input type="password" name="smtp_pass" placeholder="<?= !empty($smtp_pass_is_set) ? '•••••••• (set, leave blank to keep)' : '' ?>">
            <p class="help-text">Leave blank to keep current password.</p>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
