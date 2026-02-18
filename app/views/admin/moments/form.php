<div class="admin-card">
    <a href="<?= admin_url('moments') ?>" class="admin-back-link">← Moments</a>
    <h2><?= $moment ? 'Edit Slide' : 'Add Slide' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $moment ? admin_url('moments/' . $moment['id']) : admin_url('moments') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <?php $hasSmall = !empty($moment['image_small']); $hasWide = !empty($moment['image_wide']); ?>
        <div class="form-group">
            <label>Small Image</label>
            <?php if ($hasSmall): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;"><img src="<?= htmlspecialchars($moment['image_small']) ?>" alt="" style="max-width: 150px; max-height: 80px; object-fit: contain; border: 1px solid var(--adm-border); border-radius: 6px;"></div>
            <?php endif; ?>
            <input type="file" name="image_small" accept="image/jpeg,image/png,image/avif,image/svg+xml" <?= !$hasSmall ? 'required' : '' ?>>
            <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;"><?= $hasSmall ? 'Upload to replace.' : 'Required.' ?> JPG, JPEG, PNG, AVIF, SVG.</p>
        </div>
        <div class="form-group">
            <label>Wide Image</label>
            <?php if ($hasWide): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;"><img src="<?= htmlspecialchars($moment['image_wide']) ?>" alt="" style="max-width: 200px; max-height: 80px; object-fit: contain; border: 1px solid var(--adm-border); border-radius: 6px;"></div>
            <?php endif; ?>
            <input type="file" name="image_wide" accept="image/jpeg,image/png,image/avif,image/svg+xml" <?= !$hasWide ? 'required' : '' ?>>
            <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;"><?= $hasWide ? 'Upload to replace.' : 'Required.' ?> JPG, JPEG, PNG, AVIF, SVG.</p>
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
