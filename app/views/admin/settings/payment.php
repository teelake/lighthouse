<div class="admin-card">
    <a href="<?= admin_url('settings/general') ?>" class="admin-back-link">← General</a>
    <h2>Payment Settings</h2>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Giving and donation configuration.</p>
    <form method="post" action="<?= admin_url('settings/payment') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>PayPal Email</label>
            <input type="email" name="paypal_email" value="<?= htmlspecialchars($paypal_email ?? 'give@thelighthouseglobal.org') ?>">
        </div>
        <div class="form-group">
            <label>Stripe Public Key</label>
            <input type="text" name="stripe_public_key" value="<?= htmlspecialchars($stripe_public ?? '') ?>" placeholder="pk_...">
        </div>
        <div class="form-group">
            <label>Stripe Secret Key</label>
            <input type="password" name="stripe_secret_key" placeholder="<?= !empty($stripe_secret) ? '•••••••• (set, leave blank to keep)' : 'sk_...' ?>">
            <p class="help-text">Leave blank to keep current value.</p>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= admin_url('settings/general') ?>" class="btn btn-outline">← General</a>
        </div>
    </form>
</div>
