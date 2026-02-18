<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Homepage Settings</h2>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="<?= admin_url('settings/general') ?>" class="btn btn-outline btn-sm">General</a>
            <a href="<?= admin_url('settings/email') ?>" class="btn btn-outline btn-sm">Email</a>
            <a href="<?= admin_url('settings/payment') ?>" class="btn btn-outline btn-sm">Payment</a>
        </div>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Service times, images, and map for the homepage.</p>
    <form method="post" action="<?= admin_url('settings/homepage') ?>">
        <?= csrf_field() ?>
        <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 0.75rem;">Service Times</h3>
        <div class="form-group">
            <label>Sunday Service Time</label>
            <input type="text" name="service_sunday" value="<?= htmlspecialchars($service_sunday ?? '10:00 AM') ?>">
        </div>
        <div class="form-group">
            <label>Thursday Service Time</label>
            <input type="text" name="service_thursday" value="<?= htmlspecialchars($service_thursday ?? '6:00 PM') ?>">
        </div>
        <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 0.75rem;">Images & Map</h3>
        <div class="form-group">
            <label>Map Embed URL</label>
            <textarea name="map_embed_url" rows="4"><?= htmlspecialchars($map_embed_url ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label>Prayer Wall Image URL</label>
            <input type="url" name="prayer_wall_image" value="<?= htmlspecialchars($prayer_wall_image ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Newsletter Device Image URL</label>
            <input type="url" name="newsletter_device_image" value="<?= htmlspecialchars($newsletter_device_image ?? '') ?>">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
