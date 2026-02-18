<div class="admin-card">
    <a href="<?= admin_url('testimonials') ?>" class="admin-back-link">← Testimonials</a>
    <h2><?= $testimonial ? 'Edit Testimonial' : 'Add Testimonial' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $testimonial ? admin_url('testimonials/' . $testimonial['id']) : admin_url('testimonials') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Quote</label>
            <textarea name="quote" class="rich-editor" required style="min-height: 120px;"><?= htmlspecialchars($testimonial['quote'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label>Author Name</label>
            <input type="text" name="author_name" value="<?= htmlspecialchars($testimonial['author_name'] ?? '') ?>" required>
        </div>
        <?php $currentAuthorPhoto = $testimonial['author_photo'] ?? ''; ?>
        <div class="form-group">
            <label>Author Photo</label>
            <?php if (!empty($currentAuthorPhoto)): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;">
                <img src="<?= htmlspecialchars($currentAuthorPhoto) ?>" alt="" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 1px solid var(--adm-border);">
                <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Upload to replace.</p>
            </div>
            <?php endif; ?>
            <input type="file" name="author_photo" accept="image/jpeg,image/png,image/avif,image/svg+xml">
            <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">JPG, JPEG, PNG, AVIF, SVG. Max <?= defined('MAX_UPLOAD_SIZE') ? round(MAX_UPLOAD_SIZE / 1024 / 1024) : 10 ?>MB.</p>
        </div>
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" name="sort_order" value="<?= (int)($testimonial['sort_order'] ?? 0) ?>" min="0">
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_published" value="1" <?= ($testimonial['is_published'] ?? 1) ? 'checked' : '' ?>> Published</label>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $testimonial ? 'Update' : 'Create' ?></button>
            <a href="<?= admin_url('testimonials') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
