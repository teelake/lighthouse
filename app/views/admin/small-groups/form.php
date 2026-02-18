<!DOCTYPE html>
<html><body>
<a href="<?= rtrim(BASE_URL,'/') ?>/admin/small-groups">← Small Groups</a>
<form method="post" action="<?= $group ? rtrim(BASE_URL,'/').'/admin/small-groups/'.$group['id'] : rtrim(BASE_URL,'/').'/admin/small-groups' ?>">
<input name="title" value="<?= htmlspecialchars($group['title'] ?? '') ?>" placeholder="Title" required><br>
<input name="tagline" value="<?= htmlspecialchars($group['tagline'] ?? '') ?>" placeholder="Tagline"><br>
<input name="target_age" value="<?= htmlspecialchars($group['target_age'] ?? '') ?>" placeholder="Target Age"><br>
<textarea name="description" class="rich-editor"><?= htmlspecialchars($group['description'] ?? '') ?></textarea><br>
<button type="submit">Save</button>
</form></body></html>
