<div class="admin-card">
    <a href="<?= admin_url('testimonials') ?>" class="admin-back-link">← Testimonials</a>
    <h2><?= $testimonial ? 'Edit Testimonial' : 'Add Testimonial' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $testimonial ? admin_url('testimonials/' . $testimonial['id']) : admin_url('testimonials') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Quote</label>
            <textarea name="quote" class="rich-editor" required style="min-height: 120px;"><?= htmlspecialchars($testimonial['quote'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label>Author Name</label>
            <input type="text" name="author_name" value="<?= htmlspecialchars($testimonial['author_name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Author Photo URL</label>
            <input type="url" name="author_photo" value="<?= htmlspecialchars($testimonial['author_photo'] ?? '') ?>">
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
