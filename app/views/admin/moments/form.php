<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $moment ? 'Edit' : 'Add' ?> Moment - Admin</title>
</head>
<body style="font-family: sans-serif; margin: 0; padding: 2rem;">
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin/moments">← Moments</a>
    <h1><?= $moment ? 'Edit' : 'Add' ?> Moment Slide</h1>
    <form method="post" action="<?= $moment ? rtrim(BASE_URL,'/').'/admin/moments/'.$moment['id'] : rtrim(BASE_URL,'/').'/admin/moments' ?>">
        <p><label>Small Image URL</label><br><input name="image_small" value="<?= htmlspecialchars($moment['image_small'] ?? '') ?>" required style="width:100%;max-width:500px;"></p>
        <p><label>Wide Image URL</label><br><input name="image_wide" value="<?= htmlspecialchars($moment['image_wide'] ?? '') ?>" required style="width:100%;max-width:500px;"></p>
        <p><label>Alt (small)</label><br><input name="alt_small" value="<?= htmlspecialchars($moment['alt_small'] ?? '') ?>"></p>
        <p><label>Alt (wide)</label><br><input name="alt_wide" value="<?= htmlspecialchars($moment['alt_wide'] ?? '') ?>"></p>
        <p><label>Sort Order</label><br><input type="number" name="sort_order" value="<?= (int)($moment['sort_order'] ?? 0) ?>" min="0"></p>
        <button type="submit">Save</button>
    </form>
</body>
</html>
