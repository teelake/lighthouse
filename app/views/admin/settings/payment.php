<div class="admin-card">
    <a href="<?= admin_url('settings/general') ?>" class="admin-back-link">← General</a>
    <h2>Payment Settings</h2>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Giving and donation configuration.</p>
    <form method="post" action="<?= admin_url('settings/payment') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="paypal_donate_url" value="<?= htmlspecialchars($paypal_donate_url ?? '') ?>">
        <div class="form-group">
            <label>Interac e-Transfer Email (for giving)</label>
            <input type="email" name="paypal_email" value="<?= htmlspecialchars($paypal_email ?? 'give@thelighthouseglobal.org') ?>" placeholder="give@thelighthouseglobal.org">
            <p class="help-text">Email address where people send Interac e-Transfers. Shown on the giving page.</p>
        </div>
        <div class="form-group">
            <label>Stripe Public Key</label>
            <input type="text" name="stripe_public_key" value="<?= htmlspecialchars($stripe_public ?? '') ?>" placeholder="pk_...">
        </div>
        <div class="form-group">
            <label>Stripe Secret Key</label>
            <input type="password" name="stripe_secret_key" placeholder="<?= !empty($stripe_secret_is_set) ? '•••••••• (set, leave blank to keep)' : 'sk_...' ?>">
            <p class="help-text">Leave blank to keep current value.</p>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= admin_url('settings/general') ?>" class="btn btn-outline">← General</a>
            <a href="<?= admin_url('settings/email') ?>" class="btn btn-outline">Email →</a>
        </div>
    </form>
</div>
