<div class="admin-card">
    <a href="<?= admin_url('ministries') ?>" class="admin-back-link">← Ministries</a>
    <h2><?= $ministry ? 'Edit Ministry' : 'Add Ministry' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $ministry ? admin_url('ministries/' . $ministry['id']) : admin_url('ministries') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($ministry['title'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Tagline</label>
            <input type="text" name="tagline" value="<?= htmlspecialchars($ministry['tagline'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="rich-editor"><?= htmlspecialchars($ministry['description'] ?? '') ?></textarea>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $ministry ? 'Update' : 'Create' ?></button>
            <a href="<?= admin_url('ministries') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
