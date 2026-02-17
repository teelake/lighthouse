<?php
$user = $user ?? [];
$has2fa = !empty($user['two_factor_enabled']);
?>
<div class="admin-card">
    <h2>Account</h2>
    <p style="color: var(--adm-muted); margin: 0 0 1.5rem;"><?= htmlspecialchars($user['email'] ?? '') ?> · <?= htmlspecialchars(ucfirst($user['role'] ?? 'member')) ?></p>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if (!empty($success)): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

    <h3 id="password" style="margin: 1.5rem 0 0.75rem; font-size: 1rem;">Change Password</h3>
    <form method="post" action="<?= admin_url('profile/password') ?>" style="max-width: 400px;">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Current password</label>
            <input type="password" name="current_password" required>
        </div>
        <div class="form-group">
            <label>New password</label>
            <input type="password" name="new_password" minlength="6" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>

    <h3 style="margin: 2rem 0 0.75rem; font-size: 1rem;">Two-Factor Authentication</h3>
    <?php if ($has2fa): ?>
    <p style="color: var(--adm-muted); margin-bottom: 1rem;">2FA is enabled. Your account is protected.</p>
    <form method="post" action="<?= admin_url('profile/2fa') ?>" style="max-width: 400px;">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="disable">
        <div class="form-group">
            <label>Enter your 6-digit code to disable</label>
            <input type="text" name="code" inputmode="numeric" pattern="[0-9]*" maxlength="6" placeholder="000000" required>
        </div>
        <button type="submit" class="btn btn-outline">Disable 2FA</button>
    </form>
    <?php elseif (!empty($pendingSecret)): ?>
    <p style="margin-bottom: 1rem;">Scan with Google Authenticator or similar app:</p>
    <p style="font-family: monospace; font-size: 0.9rem; margin-bottom: 1rem; word-break: break-all;"><?= htmlspecialchars($pendingSecret) ?></p>
    <p style="font-size: 0.9rem; color: var(--adm-muted); margin-bottom: 1rem;">Or use this URI: <code style="font-size: 0.8rem;"><?= htmlspecialchars(\App\Core\Totp::getUri($pendingSecret, $pendingEmail ?? '', 'Lighthouse Admin')) ?></code></p>
    <form method="post" action="<?= admin_url('profile/2fa') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="enable">
        <div class="form-group">
            <label>Enter the 6-digit code from your app</label>
            <input type="text" name="code" inputmode="numeric" pattern="[0-9]*" maxlength="6" placeholder="000000" required>
        </div>
        <button type="submit" class="btn btn-primary">Verify & Enable 2FA</button>
        <a href="<?= admin_url('profile') ?>" class="btn btn-outline">Cancel</a>
    </form>
    <?php else: ?>
    <p style="color: var(--adm-muted); margin-bottom: 1rem;">Add an extra layer of security with an authenticator app.</p>
    <form method="post" action="<?= admin_url('profile/2fa') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="enable">
        <input type="hidden" name="code" value="">
        <button type="submit" class="btn btn-accent">Enable 2FA</button>
    </form>
    <?php endif; ?>
</div>
