<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonials - Admin</title>
</head>
<body style="font-family: sans-serif; margin: 0; padding: 2rem;">
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin">← Dashboard</a>
    <h1>Testimonials</h1>
    <p>The first published testimonial appears on the homepage (Voice section).</p>
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin/testimonials/create">Add Testimonial</a>
    <ul>
        <?php foreach ($testimonials ?? [] as $t): ?>
        <li>
            "<?= htmlspecialchars(mb_strimwidth($t['quote'], 0, 80, '…')) ?>" — <?= htmlspecialchars($t['author_name']) ?>
            <?= ($t['is_published'] ?? 1) ? '' : '(unpublished)' ?>
            <a href="<?= rtrim(BASE_URL,'/') ?>/admin/testimonials/<?= $t['id'] ?>/edit">Edit</a>
            <form method="post" action="<?= rtrim(BASE_URL,'/') ?>/admin/testimonials/<?= $t['id'] ?>/delete" style="display:inline;" onsubmit="return confirm('Delete?');">
                <button type="submit">Delete</button>
            </form>
        </li>
        <?php endforeach; ?>
        <?php if (empty($testimonials)): ?><li>No testimonials yet.</li><?php endif; ?>
    </ul>
</body>
</html>
