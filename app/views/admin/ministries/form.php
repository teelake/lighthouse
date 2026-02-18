<!DOCTYPE html>
<html><body>
<a href="<?= rtrim(BASE_URL,'/') ?>/admin/ministries">← Ministries</a>
<form method="post" action="<?= $ministry ? rtrim(BASE_URL,'/').'/admin/ministries/'.$ministry['id'] : rtrim(BASE_URL,'/').'/admin/ministries' ?>">
<input name="title" value="<?= htmlspecialchars($ministry['title'] ?? '') ?>" placeholder="Title" required><br>
<input name="tagline" value="<?= htmlspecialchars($ministry['tagline'] ?? '') ?>" placeholder="Tagline"><br>
<textarea name="description" class="rich-editor"><?= htmlspecialchars($ministry['description'] ?? '') ?></textarea><br>
<button type="submit">Save</button>
</form></body></html>
