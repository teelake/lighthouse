<div class="admin-card">
    <a href="<?= admin_url('glimpse') ?>" class="admin-back-link">← Glimpse</a>
    <h2><?= $slide ? 'Edit Slide' : 'Add Slide' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $slide ? admin_url('glimpse/' . $slide['id']) : admin_url('glimpse') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Image URL</label>
            <input type="url" name="image_url" value="<?= htmlspecialchars($slide['image_url'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Label</label>
            <input type="text" name="label" value="<?= htmlspecialchars($slide['label'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Row</label>
            <select name="row">
                <option value="1" <?= ($slide['row'] ?? 1) == 1 ? 'selected' : '' ?>>1 (top, scrolls left)</option>
                <option value="2" <?= ($slide['row'] ?? 1) == 2 ? 'selected' : '' ?>>2 (bottom, scrolls right)</option>
            </select>
        </div>
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" name="sort_order" value="<?= (int)($slide['sort_order'] ?? 0) ?>" min="0">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $slide ? 'Update' : 'Create' ?></button>
            <a href="<?= admin_url('glimpse') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
