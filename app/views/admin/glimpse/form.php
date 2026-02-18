<div class="admin-card">
    <a href="<?= admin_url('glimpse') ?>" class="admin-back-link">← Glimpse</a>
    <h2><?= $slide ? 'Edit Slide' : 'Add Slide' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $slide ? admin_url('glimpse/' . $slide['id']) : admin_url('glimpse') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <?php $hasImage = !empty($slide['image_url']); ?>
        <div class="form-group">
            <label>Image</label>
            <?php if ($hasImage): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;"><img src="<?= htmlspecialchars($slide['image_url']) ?>" alt="" style="max-width: 200px; max-height: 120px; object-fit: contain; border: 1px solid var(--adm-border); border-radius: 6px;"></div>
            <?php endif; ?>
            <input type="file" name="image_url" accept="image/jpeg,image/png,image/avif,image/svg+xml" <?= !$hasImage ? 'required' : '' ?>>
            <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;"><?= $hasImage ? 'Upload to replace.' : 'Required.' ?> JPG, JPEG, PNG, AVIF, SVG.</p>
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
