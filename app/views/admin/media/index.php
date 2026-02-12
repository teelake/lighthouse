<!DOCTYPE html>
<html><body>
<a href="<?= rtrim(BASE_URL,'/') ?>/admin">← Dashboard</a><h1>Media</h1>
<a href="<?= rtrim(BASE_URL,'/') ?>/admin/media/create">Add</a>
<ul><?php foreach ($media ?? [] as $m): ?><li><?= htmlspecialchars($m['title']) ?> (<?= $m['media_type'] ?>) <a href="<?= rtrim(BASE_URL,'/') ?>/admin/media/<?= $m['id'] ?>/edit">Edit</a></li><?php endforeach; ?></ul>
</body></html>
