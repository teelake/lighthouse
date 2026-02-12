<!DOCTYPE html>
<html><body>
<a href="<?= rtrim(BASE_URL,'/') ?>/admin">← Dashboard</a><h1>Small Groups</h1>
<a href="<?= rtrim(BASE_URL,'/') ?>/admin/small-groups/create">Add</a>
<ul><?php foreach ($groups ?? [] as $g): ?><li><?= htmlspecialchars($g['title']) ?> <a href="<?= rtrim(BASE_URL,'/') ?>/admin/small-groups/<?= $g['id'] ?>/edit">Edit</a></li><?php endforeach; ?></ul>
</body></html>
