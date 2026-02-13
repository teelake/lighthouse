<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $slide ? 'Edit' : 'Add' ?> Glimpse Slide - Admin</title>
</head>
<body style="font-family: sans-serif; margin: 0; padding: 2rem;">
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin/glimpse">← Glimpse</a>
    <h1><?= $slide ? 'Edit' : 'Add' ?> Glimpse Slide</h1>
    <form method="post" action="<?= $slide ? rtrim(BASE_URL,'/').'/admin/glimpse/'.$slide['id'] : rtrim(BASE_URL,'/').'/admin/glimpse' ?>">
        <p><label>Image URL</label><br><input name="image_url" value="<?= htmlspecialchars($slide['image_url'] ?? '') ?>" required style="width:100%;max-width:500px;"></p>
        <p><label>Label</label><br><input name="label" value="<?= htmlspecialchars($slide['label'] ?? '') ?>" required></p>
        <p><label>Row</label><br>
            <select name="row">
                <option value="1" <?= ($slide['row'] ?? 1) == 1 ? 'selected' : '' ?>>1 (top, scrolls left)</option>
                <option value="2" <?= ($slide['row'] ?? 1) == 2 ? 'selected' : '' ?>>2 (bottom, scrolls right)</option>
            </select>
        </p>
        <p><label>Sort Order</label><br><input type="number" name="sort_order" value="<?= (int)($slide['sort_order'] ?? 0) ?>" min="0"></p>
        <button type="submit">Save</button>
    </form>
</body>
</html>
