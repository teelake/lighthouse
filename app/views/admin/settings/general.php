<!DOCTYPE html>
<html><body>
<a href="<?= rtrim(BASE_URL,'/') ?>/admin">← Dashboard</a><h1>General Settings</h1>
<form method="post" action="<?= rtrim(BASE_URL,'/') ?>/admin/settings/general">
Address: <input name="site_address" value="<?= htmlspecialchars($address ?? '980 Parkland Drive, Holiday Inn & Suites, Halifax, NS, Canada') ?>"><br>
Phone: <input name="site_phone" value="<?= htmlspecialchars($phone ?? '902-240-2087') ?>"><br>
Email: <input name="site_email" value="<?= htmlspecialchars($email ?? 'info@thelighthouseglobal.org') ?>"><br>
<button type="submit">Save</button>
</form>
<a href="<?= rtrim(BASE_URL,'/') ?>/admin/settings/payment">Payment Settings →</a>
</body></html>
