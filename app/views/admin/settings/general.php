<div class="admin-card">
    <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
    <h2>General Settings</h2>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Site contact and address details.</p>
    <form method="post" action="<?= admin_url('settings/general') ?>">
        <?= csrf_field() ?>
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
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= admin_url('settings/homepage') ?>" class="btn btn-outline">Homepage →</a>
            <a href="<?= admin_url('settings/payment') ?>" class="btn btn-outline">Payment →</a>
        </div>
    </form>
</div>
