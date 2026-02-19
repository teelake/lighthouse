<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Page Images</h2>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="<?= admin_url('settings/general') ?>" class="btn btn-outline btn-sm">General</a>
            <a href="<?= admin_url('settings/homepage') ?>" class="btn btn-outline btn-sm">Homepage</a>
        </div>
    </div>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Hero and content images for inner pages (Believers House style). Upload to add images; leave empty to keep gradient-only heroes.</p>
    <form method="post" action="<?= admin_url('settings/page-images') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 0.75rem;">About Page</h3>
        <div class="form-group">
            <label>About Hero Image</label>
            <p class="admin-muted" style="font-size: 0.85rem; margin: 0 0 0.5rem;">Background image for the About page hero section. Recommended: 1920×600 or wider.</p>
            <?php if (!empty($about_hero_image ?? '')): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;">
                <img src="<?= htmlspecialchars($about_hero_image) ?>" alt="" style="max-width: 320px; max-height: 120px; object-fit: cover; border: 1px solid var(--adm-border); border-radius: 6px;">
                <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Current image. Upload to replace.</p>
            </div>
            <?php endif; ?>
            <input type="file" name="about_hero_image" accept="image/jpeg,image/png,image/avif,image/svg+xml">
        </div>
        <div class="form-group">
            <label>About Story Image</label>
            <p class="admin-muted" style="font-size: 0.85rem; margin: 0 0 0.5rem;">Image beside "Our Story" (Believers House style split layout). Recommended: 600×400 or similar.</p>
            <?php if (!empty($about_story_image ?? '')): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;">
                <img src="<?= htmlspecialchars($about_story_image) ?>" alt="" style="max-width: 320px; max-height: 180px; object-fit: contain; border: 1px solid var(--adm-border); border-radius: 6px;">
                <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Current image. Upload to replace.</p>
            </div>
            <?php endif; ?>
            <input type="file" name="about_story_image" accept="image/jpeg,image/png,image/avif,image/svg+xml">
        </div>
        <h3 style="font-size: 1rem; font-weight: 600; margin: 1.5rem 0 0.75rem;">Other Inner Pages</h3>
        <div class="form-group">
            <label>Page Hero Image (Shared)</label>
            <p class="admin-muted" style="font-size: 0.85rem; margin: 0 0 0.5rem;">Optional background for Services, Contact, I'm New, Leadership, FAQ, Ministries, Events, Small Groups, Jobs, Prayer, Media, Membership. Leave empty for gradient-only.</p>
            <?php if (!empty($page_hero_image ?? '')): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;">
                <img src="<?= htmlspecialchars($page_hero_image) ?>" alt="" style="max-width: 320px; max-height: 120px; object-fit: cover; border: 1px solid var(--adm-border); border-radius: 6px;">
                <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Current image. Upload to replace.</p>
            </div>
            <?php endif; ?>
            <input type="file" name="page_hero_image" accept="image/jpeg,image/png,image/avif,image/svg+xml">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
