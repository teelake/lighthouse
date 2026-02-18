<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $testimonial ? 'Edit' : 'Add' ?> Testimonial - Admin</title>
</head>
<body style="font-family: sans-serif; margin: 0; padding: 2rem;">
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin/testimonials">← Testimonials</a>
    <h1><?= $testimonial ? 'Edit' : 'Add' ?> Testimonial</h1>
    <form method="post" action="<?= $testimonial ? rtrim(BASE_URL,'/').'/admin/testimonials/'.$testimonial['id'] : rtrim(BASE_URL,'/').'/admin/testimonials' ?>">
        <p><label>Quote</label><br><textarea name="quote" class="rich-editor" required style="width:100%;min-height:100px;"><?= htmlspecialchars($testimonial['quote'] ?? '') ?></textarea></p>
        <p><label>Author Name</label><br><input name="author_name" value="<?= htmlspecialchars($testimonial['author_name'] ?? '') ?>" required></p>
        <p><label>Author Photo URL</label><br><input name="author_photo" value="<?= htmlspecialchars($testimonial['author_photo'] ?? '') ?>"></p>
        <p><label>Sort Order</label><br><input type="number" name="sort_order" value="<?= (int)($testimonial['sort_order'] ?? 0) ?>" min="0"></p>
        <p><label><input type="checkbox" name="is_published" value="1" <?= ($testimonial['is_published'] ?? 1) ? 'checked' : '' ?>> Published</label></p>
        <button type="submit">Save</button>
    </form>
</body>
</html>
