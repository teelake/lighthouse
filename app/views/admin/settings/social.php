<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Social Media Links</h2>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="<?= admin_url('settings/general') ?>" class="btn btn-outline btn-sm">General</a>
            <a href="<?= admin_url('settings/homepage') ?>" class="btn btn-outline btn-sm">Homepage</a>
            <a href="<?= admin_url('settings/footer') ?>" class="btn btn-outline btn-sm">Footer</a>
        </div>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Configure social media URLs shown in the header and footer. Leave blank to hide a link.</p>
    <form method="post" action="<?= admin_url('settings/social') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Facebook URL</label>
            <input type="url" name="social_facebook" value="<?= htmlspecialchars($social_facebook ?? '') ?>" placeholder="https://facebook.com/yourpage">
        </div>
        <div class="form-group">
            <label>TikTok URL</label>
            <input type="url" name="social_tiktok" value="<?= htmlspecialchars($social_tiktok ?? '') ?>" placeholder="https://tiktok.com/@yourhandle">
        </div>
        <div class="form-group">
            <label>YouTube URL</label>
            <input type="url" name="social_youtube" value="<?= htmlspecialchars($social_youtube ?? '') ?>" placeholder="https://youtube.com/@yourchannel">
        </div>
        <div class="form-group">
            <label>Twitter / X URL</label>
            <input type="url" name="social_twitter" value="<?= htmlspecialchars($social_twitter ?? '') ?>" placeholder="https://x.com/yourhandle">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
