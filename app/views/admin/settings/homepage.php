<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Settings - Admin</title>
</head>
<body style="font-family: sans-serif; margin: 0; padding: 2rem;">
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin">← Dashboard</a>
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin/settings/general">General</a>
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin/settings/homepage" style="font-weight:bold;">Homepage</a>
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin/settings/payment">Payment</a>
    <h1>Homepage Settings</h1>
    <form method="post" action="<?= rtrim(BASE_URL,'/') ?>/admin/settings/homepage">
        <h2>Service Times</h2>
        <p><label>Sunday Service Time</label><br><input name="service_sunday" value="<?= htmlspecialchars($service_sunday ?? '10:00 AM') ?>" style="width:100%;max-width:200px;"></p>
        <p><label>Thursday Service Time</label><br><input name="service_thursday" value="<?= htmlspecialchars($service_thursday ?? '6:00 PM') ?>" style="width:100%;max-width:200px;"></p>
        <h2>Images & Map</h2>
        <p><label>Map Embed URL</label><br><textarea name="map_embed_url" rows="4" style="width:100%;max-width:600px;"><?= htmlspecialchars($map_embed_url ?? '') ?></textarea></p>
        <p><label>Prayer Wall Image URL</label><br><input name="prayer_wall_image" value="<?= htmlspecialchars($prayer_wall_image ?? '') ?>" style="width:100%;max-width:500px;"></p>
        <p><label>Newsletter Device Image URL</label><br><input name="newsletter_device_image" value="<?= htmlspecialchars($newsletter_device_image ?? '') ?>" style="width:100%;max-width:500px;"></p>
        <button type="submit">Save</button>
    </form>
</body>
</html>
