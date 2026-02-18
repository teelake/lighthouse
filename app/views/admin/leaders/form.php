<div class="admin-card">
    <a href="<?= admin_url('leaders') ?>" class="admin-back-link">← Leadership</a>
    <h2><?= $leader ? 'Edit Leader' : 'Add Leader' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $leader ? admin_url('leaders/' . $leader['id']) : admin_url('leaders') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($leader['name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($leader['title'] ?? '') ?>" required>
        </div>
        <?php $currentPhoto = $leader['photo'] ?? ''; ?>
        <div class="form-group">
            <label>Photo</label>
            <?php if (!empty($currentPhoto)): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;">
                <img src="<?= htmlspecialchars($currentPhoto) ?>" alt="" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 1px solid var(--adm-border);">
                <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Upload to replace.</p>
            </div>
            <?php endif; ?>
            <input type="file" name="photo" accept="image/jpeg,image/png,image/avif,image/svg+xml">
            <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">JPG, JPEG, PNG, AVIF, SVG. Max <?= defined('MAX_UPLOAD_SIZE') ? round(MAX_UPLOAD_SIZE / 1024 / 1024) : 10 ?>MB.</p>
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
