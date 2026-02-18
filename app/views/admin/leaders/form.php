<div class="admin-card">
    <a href="<?= admin_url('leaders') ?>" class="admin-back-link">← Leadership</a>
    <h2><?= $leader ? 'Edit Leader' : 'Add Leader' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $leader ? admin_url('leaders/' . $leader['id']) : admin_url('leaders') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($leader['name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($leader['title'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Photo URL</label>
            <input type="url" name="photo" value="<?= htmlspecialchars($leader['photo'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Bio</label>
            <textarea name="bio" class="rich-editor"><?= htmlspecialchars($leader['bio'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" name="sort_order" value="<?= (int)($leader['sort_order'] ?? 0) ?>" min="0">
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_published" value="1" <?= ($leader['is_published'] ?? 1) ? 'checked' : '' ?>> Published</label>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $leader ? 'Update' : 'Create' ?></button>
            <a href="<?= admin_url('leaders') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
