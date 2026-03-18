<div class="admin-card">
    <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
    <h2>General Settings</h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Site contact, logo, and address details.</p>
    <form method="post" action="<?= admin_url('settings/general') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <h3 style="font-size: 1rem; font-weight: 600; margin: 0 0 0.75rem;">Site Logo</h3>
        <div class="form-group">
            <label>Logo (for light backgrounds)</label>
            <p class="admin-muted" style="font-size: 0.85rem; margin: 0 0 0.5rem;">Used when header is white (after scroll). Black/dark text on white or transparent background.</p>
            <?php if (!empty($site_logo ?? '')): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;">
                <img src="<?= htmlspecialchars($site_logo) ?>" alt="Current logo" style="max-width: 200px; max-height: 64px; object-fit: contain; border: 1px solid var(--adm-border); border-radius: 6px;">
                <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Current logo. Upload to replace.</p>
            </div>
            <?php endif; ?>
            <input type="file" name="site_logo" accept="image/jpeg,image/png,image/avif,image/svg+xml">
        </div>
        <div class="form-group" style="margin-top: 1.25rem;">
            <label>Logo – Light variant (for dark backgrounds)</label>
            <p class="admin-muted" style="font-size: 0.85rem; margin: 0 0 0.5rem;">Used when header is black (top of page). White or light-coloured text. Transparent or dark background. If not set, the main logo is auto-inverted.</p>
            <?php if (!empty($site_logo_light ?? '')): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;">
                <img src="<?= htmlspecialchars($site_logo_light) ?>" alt="Current light logo" style="max-width: 200px; max-height: 64px; object-fit: contain; border: 1px solid var(--adm-border); border-radius: 6px; background: #1a1a1a;">
                <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Current light logo. Upload to replace.</p>
            </div>
            <?php endif; ?>
            <input type="file" name="site_logo_light" accept="image/jpeg,image/png,image/avif,image/svg+xml">
        </div>
        <div class="form-group" style="margin-top: 1.25rem;">
            <label>Footer logo</label>
            <p class="admin-muted" style="font-size: 0.85rem; margin: 0 0 0.5rem;">Optional. Used only in the site footer. Can be different from the header logos (e.g. a stacked or simplified version). If not set, the light logo is used, or the main logo auto-inverted.</p>
            <?php if (!empty($site_logo_footer ?? '')): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;">
                <img src="<?= htmlspecialchars($site_logo_footer) ?>" alt="Current footer logo" style="max-width: 200px; max-height: 80px; object-fit: contain; border: 1px solid var(--adm-border); border-radius: 6px; background: #1a1a1a;">
                <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Current footer logo. Upload to replace.</p>
            </div>
            <?php endif; ?>
            <input type="file" name="site_logo_footer" accept="image/jpeg,image/png,image/avif,image/svg+xml">
        </div>
        <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 0.75rem;">Contact</h3>
        <div class="form-group">
            <label>Address</label>
            <input type="text" name="site_address" value="<?= htmlspecialchars($address ?? '980 Parkland Drive, Holiday Inn & Suites, Halifax, NS, Canada') ?>">
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="site_phone" value="<?= htmlspecialchars($phone ?? '902-240-2087') ?>">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="site_email" value="<?= htmlspecialchars($email ?? 'info@thelighthouseglobal.org') ?>">
        </div>
        <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 0.75rem;">Watch Online</h3>
        <div class="form-group">
            <label>Watch Online URL</label>
            <input type="text" name="watch_online_url" value="<?= htmlspecialchars($watch_online_url ?? '') ?>" placeholder="/media">
            <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Used for Watch Online, Watch Media, Join Online buttons site-wide. Full URL (e.g. https://youtube.com/@Channel/live) or path like /media. Leave empty for /media.</p>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= admin_url('settings/homepage') ?>" class="btn btn-outline">Homepage →</a>
            <a href="<?= admin_url('settings/page-images') ?>" class="btn btn-outline">Page Images →</a>
            <a href="<?= admin_url('settings/social') ?>" class="btn btn-outline">Social →</a>
            <a href="<?= admin_url('settings/footer') ?>" class="btn btn-outline">Footer →</a>
            <a href="<?= admin_url('settings/email') ?>" class="btn btn-outline">Email →</a>
            <a href="<?= admin_url('settings/payment') ?>" class="btn btn-outline">Payment →</a>
        </div>
    </form>
</div>
