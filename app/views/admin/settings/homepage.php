<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Homepage Settings</h2>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="<?= admin_url('settings/general') ?>" class="btn btn-outline btn-sm">General</a>
            <a href="<?= admin_url('settings/social') ?>" class="btn btn-outline btn-sm">Social</a>
            <a href="<?= admin_url('settings/email') ?>" class="btn btn-outline btn-sm">Email</a>
            <a href="<?= admin_url('settings/payment') ?>" class="btn btn-outline btn-sm">Payment</a>
        </div>
    </div>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Service times, images, and map for the homepage.</p>
    <form method="post" action="<?= admin_url('settings/homepage') ?>" enctype="multipart/form-data">
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
        <?php
        $currentPrayer = $prayer_wall_image ?? '';
        $currentNewsletter = $newsletter_device_image ?? '';
        ?>
        <div class="form-group">
            <label>Prayer Wall Image</label>
            <?php if (!empty($currentPrayer)): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;">
                <img src="<?= htmlspecialchars($currentPrayer) ?>" alt="" style="max-width: 200px; max-height: 120px; object-fit: contain; border: 1px solid var(--adm-border); border-radius: 6px;">
                <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Current image. Upload to replace.</p>
            </div>
            <?php endif; ?>
            <input type="file" name="prayer_wall_image" accept="image/jpeg,image/png,image/avif,image/svg+xml">
            <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">JPG, JPEG, PNG, AVIF, SVG. Max <?= defined('MAX_UPLOAD_SIZE') ? round(MAX_UPLOAD_SIZE / 1024 / 1024) : 10 ?>MB.</p>
        </div>
        <div class="form-group">
            <label>Newsletter Device Image</label>
            <?php if (!empty($currentNewsletter)): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;">
                <img src="<?= htmlspecialchars($currentNewsletter) ?>" alt="" style="max-width: 200px; max-height: 120px; object-fit: contain; border: 1px solid var(--adm-border); border-radius: 6px;">
                <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Current image. Upload to replace.</p>
            </div>
            <?php endif; ?>
            <input type="file" name="newsletter_device_image" accept="image/jpeg,image/png,image/avif,image/svg+xml">
            <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">JPG, JPEG, PNG, AVIF, SVG. Max <?= defined('MAX_UPLOAD_SIZE') ? round(MAX_UPLOAD_SIZE / 1024 / 1024) : 10 ?>MB.</p>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
