<div class="admin-card">
    <a href="<?= ($user ?? [])['role'] === 'member' ? admin_url('members') : admin_url('users') ?>" class="admin-back-link">← <?= (($user ?? [])['role'] ?? '') === 'member' ? 'Members' : 'Staff' ?></a>
    <h2><?= $user ? ($pageHeading ?? 'Edit User') : 'Add Staff' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $user ? admin_url('users/' . $user['id']) : admin_url('users') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars(($user ?? [])['name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars(($user ?? [])['email'] ?? '') ?>" <?= $user ? 'readonly' : 'required' ?>>
            <?php if ($user): ?><p class="help-text">Email cannot be changed.</p><?php endif; ?>
        </div>
        <?php if ($user): ?>
        <div class="form-group">
            <label>Password (leave blank to keep)</label>
            <input type="password" name="password" minlength="6">
        </div>
        <?php else: ?>
        <p class="help-text" style="margin: 0 0 1rem; color: var(--adm-muted);">A password will be auto-generated and sent to the user's email.</p>
        <?php endif; ?>
        <div class="form-group">
            <label>Role</label>
            <select name="role">
                <?php $currentRole = ($user ?? [])['role'] ?? 'editor'; ?>
                <?php if ($currentRole === 'member'): ?>
                <option value="member" selected>Member</option>
                <option value="editor">Editor</option>
                <option value="admin">Admin</option>
                <?php else: ?>
                <option value="editor" <?= $currentRole === 'editor' ? 'selected' : '' ?>>Editor</option>
                <option value="admin" <?= $currentRole === 'admin' ? 'selected' : '' ?>>Admin</option>
                <?php endif; ?>
            </select>
            <?php if ($currentRole === 'member'): ?><p class="help-text">Change to Editor or Admin to promote to staff.</p><?php endif; ?>
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_active" value="1" <?= !empty(($user ?? [])['is_active']) ? 'checked' : '' ?>> Active</label>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $user ? 'Update' : 'Create' ?></button>
            <a href="<?= admin_url('users') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
