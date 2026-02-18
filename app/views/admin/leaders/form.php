<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $leader ? 'Edit' : 'Add' ?> Leader - Admin</title>
</head>
<body style="font-family: sans-serif; margin: 0; padding: 2rem;">
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin/leaders">← Leadership</a>
    <h1><?= $leader ? 'Edit' : 'Add' ?> Leader</h1>
    <form method="post" action="<?= $leader ? rtrim(BASE_URL,'/').'/admin/leaders/'.$leader['id'] : rtrim(BASE_URL,'/').'/admin/leaders' ?>">
        <p><label>Name</label><br><input name="name" value="<?= htmlspecialchars($leader['name'] ?? '') ?>" required></p>
        <p><label>Title</label><br><input name="title" value="<?= htmlspecialchars($leader['title'] ?? '') ?>" required></p>
        <p><label>Photo URL</label><br><input name="photo" value="<?= htmlspecialchars($leader['photo'] ?? '') ?>" style="width:100%;max-width:500px;"></p>
        <p><label>Bio</label><br><textarea name="bio" class="rich-editor" rows="5" style="width:100%;max-width:500px;"><?= htmlspecialchars($leader['bio'] ?? '') ?></textarea></p>
        <p><label>Sort Order</label><br><input type="number" name="sort_order" value="<?= (int)($leader['sort_order'] ?? 0) ?>" min="0"></p>
        <p><label><input type="checkbox" name="is_published" value="1" <?= ($leader['is_published'] ?? 1) ? 'checked' : '' ?>> Published</label></p>
        <button type="submit">Save</button>
    </form>
</body>
</html>
