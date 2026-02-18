<div class="admin-card">
    <a href="<?= admin_url('small-groups') ?>" class="admin-back-link">← Small Groups</a>
    <h2><?= $group ? 'Edit Small Group' : 'Add Small Group' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $group ? admin_url('small-groups/' . $group['id']) : admin_url('small-groups') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($group['title'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Tagline</label>
            <input type="text" name="tagline" value="<?= htmlspecialchars($group['tagline'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Target Age</label>
            <input type="text" name="target_age" value="<?= htmlspecialchars($group['target_age'] ?? '') ?>" placeholder="e.g. Young Adults">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="rich-editor"><?= htmlspecialchars($group['description'] ?? '') ?></textarea>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $group ? 'Update' : 'Create' ?></button>
            <a href="<?= admin_url('small-groups') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
