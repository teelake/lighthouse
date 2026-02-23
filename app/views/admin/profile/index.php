<?php $user = $user ?? []; ?>
<div class="admin-card">
    <h2>Account</h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if (!empty($success)): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

    <h3 style="margin: 0 0 0.75rem; font-size: 1rem;">Basic Details</h3>
    <p class="help-text" style="margin: 0 0 1rem;">Update your name and email. Use your email to sign in.</p>
    <form method="post" action="<?= admin_url('profile') ?>" style="max-width: 400px; margin-bottom: 2rem;">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>

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
</div>
