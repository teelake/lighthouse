<!DOCTYPE html>
<html><body>
<a href="<?= rtrim(BASE_URL,'/') ?>/admin/jobs">← Jobs</a>
<form method="post" action="<?= $job ? rtrim(BASE_URL,'/').'/admin/jobs/'.$job['id'] : rtrim(BASE_URL,'/').'/admin/jobs' ?>">
<input name="title" value="<?= htmlspecialchars($job['title'] ?? '') ?>" placeholder="Title" required><br>
<select name="type"><option value="full-time">Full-Time</option><option value="part-time">Part-Time</option><option value="internship">Internship</option><option value="volunteer">Volunteer</option></select><br>
<textarea name="description"><?= htmlspecialchars($job['description'] ?? '') ?></textarea><br>
<button type="submit">Save</button>
</form></body></html>
