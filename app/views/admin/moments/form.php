<div class="admin-card">
    <a href="<?= admin_url('moments') ?>" class="admin-back-link">← Moments</a>
    <h2><?= $moment ? 'Edit Slide' : 'Add Slide' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $moment ? admin_url('moments/' . $moment['id']) : admin_url('moments') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Small Image URL</label>
            <input type="url" name="image_small" value="<?= htmlspecialchars($moment['image_small'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Wide Image URL</label>
            <input type="url" name="image_wide" value="<?= htmlspecialchars($moment['image_wide'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Alt (small)</label>
            <input type="text" name="alt_small" value="<?= htmlspecialchars($moment['alt_small'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Alt (wide)</label>
            <input type="text" name="alt_wide" value="<?= htmlspecialchars($moment['alt_wide'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" name="sort_order" value="<?= (int)($moment['sort_order'] ?? 0) ?>" min="0">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $moment ? 'Update' : 'Create' ?></button>
            <a href="<?= admin_url('moments') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
