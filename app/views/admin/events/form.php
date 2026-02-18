<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $event ? 'Edit' : 'Create' ?> Event - Admin</title>
</head>
<body style="font-family: sans-serif; margin: 0; padding: 2rem;">
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin/events">← Events</a>
    <h1><?= $event ? 'Edit' : 'Create' ?> Event</h1>
    <form method="post" action="<?= $event ? rtrim(BASE_URL,'/').'/admin/events/'.$event['id'] : rtrim(BASE_URL,'/').'/admin/events' ?>">
        <p><label>Title</label><br><input name="title" value="<?= htmlspecialchars($event['title'] ?? '') ?>" required></p>
        <p><label>Description</label><br><textarea name="description" class="rich-editor"><?= htmlspecialchars($event['description'] ?? '') ?></textarea></p>
        <p><label>Date</label><br><input type="date" name="event_date" value="<?= htmlspecialchars($event['event_date'] ?? '') ?>"></p>
        <p><label>Time</label><br><input type="time" name="event_time" value="<?= htmlspecialchars($event['event_time'] ?? '') ?>"></p>
        <p><label>Location</label><br><input name="location" value="<?= htmlspecialchars($event['location'] ?? '') ?>"></p>
        <button type="submit">Save</button>
    </form>
</body>
</html>
