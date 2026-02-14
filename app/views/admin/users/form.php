<div class="admin-card">
    <h2><?= $user ? 'Edit User' : 'Add User' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post">
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
        <div class="form-group">
            <label>Password <?= $user ? '(leave blank to keep)' : '' ?></label>
            <input type="password" name="password" <?= $user ? '' : 'required' ?> minlength="6">
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role">
                <option value="member" <?= (($user ?? [])['role'] ?? '') === 'member' ? 'selected' : '' ?>>Member</option>
                <option value="editor" <?= (($user ?? [])['role'] ?? '') === 'editor' ? 'selected' : '' ?>>Editor</option>
                <option value="admin" <?= (($user ?? [])['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
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
