<div class="admin-card">
    <a href="<?= admin_url('members') ?>" class="admin-back-link">← Members</a>
    <h2>Add Member</h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= admin_url('members') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars(($member ?? [])['name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars(($member ?? [])['email'] ?? '') ?>" required>
        </div>
        <p class="help-text" style="margin: 0 0 1rem; color: var(--adm-muted);">A password will be auto-generated and sent to the member's email.</p>
        <div class="form-group">
            <label><input type="checkbox" name="is_active" value="1" <?= (empty($member) || !empty(($member ?? [])['is_active'])) ? 'checked' : '' ?>> Active</label>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Add Member</button>
            <a href="<?= admin_url('members') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
