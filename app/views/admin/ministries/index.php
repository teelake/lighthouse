<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Ministries</title></head><body>
<a href="<?= rtrim(BASE_URL,'/') ?>/admin">← Dashboard</a><h1>Ministries</h1>
<a href="<?= rtrim(BASE_URL,'/') ?>/admin/ministries/create">Add</a>
<ul><?php foreach ($ministries ?? [] as $m): ?><li><?= htmlspecialchars($m['title']) ?> <a href="<?= rtrim(BASE_URL,'/') ?>/admin/ministries/<?= $m['id'] ?>/edit">Edit</a></li><?php endforeach; ?></ul>
</body></html>
