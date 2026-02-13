<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moments Carousel - Admin</title>
    <style>
        body { font-family: -apple-system, sans-serif; margin: 0; padding: 1.5rem; background: #f5f5f5; }
        a { color: #1a5f4a; }
        .thumb { width: 80px; height: 50px; object-fit: cover; border-radius: 4px; }
        table { width: 100%; background: #fff; border-radius: 8px; border-collapse: collapse; }
        th, td { padding: 0.75rem; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin">← Dashboard</a>
    <h1>Moments Carousel</h1>
    <p>Manage the homepage Moments carousel slides. Each slide has a small and wide image.</p>
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin/moments/create">Add Slide</a>
    <table>
        <tr><th>Small</th><th>Wide</th><th>Order</th><th>Action</th></tr>
        <?php foreach ($moments ?? [] as $m): ?>
        <tr>
            <td><img class="thumb" src="<?= htmlspecialchars($m['image_small']) ?>" alt=""></td>
            <td><img class="thumb" src="<?= htmlspecialchars($m['image_wide']) ?>" alt=""></td>
            <td><?= (int)$m['sort_order'] ?></td>
            <td>
                <a href="<?= rtrim(BASE_URL,'/') ?>/admin/moments/<?= $m['id'] ?>/edit">Edit</a>
                <form method="post" action="<?= rtrim(BASE_URL,'/') ?>/admin/moments/<?= $m['id'] ?>/delete" style="display:inline;" onsubmit="return confirm('Delete?');">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($moments)): ?><tr><td colspan="4">No slides</td></tr><?php endif; ?>
    </table>
</body>
</html>
