<!DOCTYPE html>
<html><body>
<a href="<?= rtrim(BASE_URL,'/') ?>/admin">← Dashboard</a><h1>Jobs</h1>
<a href="<?= rtrim(BASE_URL,'/') ?>/admin/jobs/create">Add</a>
<ul><?php foreach ($jobs ?? [] as $j): ?><li><?= htmlspecialchars($j['title']) ?> <a href="<?= rtrim(BASE_URL,'/') ?>/admin/jobs/<?= $j['id'] ?>/edit">Edit</a></li><?php endforeach; ?></ul>
</body></html>
