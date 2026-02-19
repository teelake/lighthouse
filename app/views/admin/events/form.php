<div class="admin-card">
    <a href="<?= admin_url('events') ?>" class="admin-back-link">← Events</a>
    <h2><?= $event ? 'Edit Event' : 'Add Event' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $event ? admin_url('events/' . $event['id']) : admin_url('events') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($event['title'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Image</label>
            <?php if (!empty($event['image'] ?? '')): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;">
                <img src="<?= htmlspecialchars($event['image']) ?>" alt="" style="max-width: 240px; max-height: 140px; object-fit: cover; border: 1px solid var(--adm-border); border-radius: 6px;">
                <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Current image. Upload to replace.</p>
            </div>
            <?php endif; ?>
            <input type="file" name="image" accept="image/jpeg,image/png,image/avif,image/svg+xml">
            <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">JPG, PNG, AVIF, SVG. Max <?= defined('MAX_UPLOAD_SIZE') ? round(MAX_UPLOAD_SIZE / 1024 / 1024) : 10 ?>MB. Recommended: 800×450 or similar.</p>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="rich-editor"><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="event_date" value="<?= htmlspecialchars($event['event_date'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Time</label>
            <input type="time" name="event_time" value="<?= htmlspecialchars($event['event_time'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" value="<?= htmlspecialchars($event['location'] ?? '') ?>">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $event ? 'Update' : 'Create' ?></button>
            <a href="<?= admin_url('events') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
