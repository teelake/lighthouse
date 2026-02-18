<!DOCTYPE html>
<html><body>
<a href="<?= rtrim(BASE_URL,'/') ?>/admin/media">← Media</a>
<form method="post" action="<?= $item ? rtrim(BASE_URL,'/').'/admin/media/'.$item['id'] : rtrim(BASE_URL,'/').'/admin/media' ?>">
<input name="title" value="<?= htmlspecialchars($item['title'] ?? '') ?>" placeholder="Title" required><br>
<select name="media_type"><option value="video" <?= ($item['media_type']??'')==='video'?'selected':'' ?>>Video</option><option value="audio" <?= ($item['media_type']??'')==='audio'?'selected':'' ?>>Audio</option></select>
<select name="source"><option value="youtube">YouTube</option><option value="vimeo">Vimeo</option></select><br>
<input name="embed_url" value="<?= htmlspecialchars($item['embed_url'] ?? '') ?>" placeholder="Embed URL / YouTube link"><br>
<input name="published_at" type="date" value="<?= htmlspecialchars($item['published_at'] ?? date('Y-m-d')) ?>"><br>
<textarea name="description" class="rich-editor"><?= htmlspecialchars($item['description'] ?? '') ?></textarea><br>
<button type="submit">Save</button>
</form></body></html>
