<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - Admin</title>
</head>
<body style="font-family: sans-serif; margin: 0; padding: 2rem;">
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin">← Dashboard</a>
    <h1>Events</h1>
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin/events/create">Add Event</a>
    <ul>
        <?php foreach ($events ?? [] as $e): ?>
        <li><?= htmlspecialchars($e['title']) ?> — <a href="<?= rtrim(BASE_URL,'/') ?>/admin/events/<?= $e['id'] ?>/edit">Edit</a></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
