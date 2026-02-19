<div class="admin-card">
    <a href="<?= admin_url('ministries') ?>" class="admin-back-link">← Ministries</a>
    <h2><?= $ministry ? 'Edit Ministry' : 'Add Ministry' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $ministry ? admin_url('ministries/' . $ministry['id']) : admin_url('ministries') ?>" enctype="multipart/form-data">
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
            <label>Image</label>
            <?php if (!empty($ministry['image'] ?? '')): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;">
                <img src="<?= htmlspecialchars($ministry['image']) ?>" alt="" style="max-width: 240px; max-height: 140px; object-fit: cover; border: 1px solid var(--adm-border); border-radius: 6px;">
                <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Current image. Upload to replace.</p>
            </div>
            <?php endif; ?>
            <input type="file" name="image" accept="image/jpeg,image/png,image/avif,image/svg+xml">
            <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">JPG, PNG, AVIF, SVG. Recommended: 600×400 or similar.</p>
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
