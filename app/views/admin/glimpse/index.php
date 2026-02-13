<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glimpse Section - Admin</title>
    <style>
        body { font-family: -apple-system, sans-serif; margin: 0; padding: 1.5rem; background: #f5f5f5; }
        a { color: #1a5f4a; }
        table { width: 100%; background: #fff; border-radius: 8px; border-collapse: collapse; }
        th, td { padding: 0.75rem 1rem; text-align: left; border-bottom: 1px solid #eee; }
        .thumb { width: 60px; height: 40px; object-fit: cover; border-radius: 4px; }
        .badge { display: inline-block; padding: 0.2rem 0.5rem; background: #e2e8f0; border-radius: 4px; font-size: 0.85rem; }
    </style>
</head>
<body>
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin">← Dashboard</a>
    <h1>Glimpse Section</h1>
    <p>Manage the scrolling image cards on the homepage. Row 1 scrolls left, Row 2 scrolls right.</p>
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin/glimpse/create">Add Slide</a>

    <h2>Row 1 (top)</h2>
    <table>
        <tr><th>Image</th><th>Label</th><th>Order</th><th>Action</th></tr>
        <?php foreach ($row1 ?? [] as $s): ?>
        <tr>
            <td><img class="thumb" src="<?= htmlspecialchars($s['image_url']) ?>" alt=""></td>
            <td><?= htmlspecialchars($s['label']) ?></td>
            <td><?= (int)$s['sort_order'] ?></td>
            <td>
                <a href="<?= rtrim(BASE_URL,'/') ?>/admin/glimpse/<?= $s['id'] ?>/edit">Edit</a>
                <form method="post" action="<?= rtrim(BASE_URL,'/') ?>/admin/glimpse/<?= $s['id'] ?>/delete" style="display:inline;" onsubmit="return confirm('Delete?');">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($row1)): ?><tr><td colspan="4">No slides</td></tr><?php endif; ?>
    </table>

    <h2>Row 2 (bottom)</h2>
    <table>
        <tr><th>Image</th><th>Label</th><th>Order</th><th>Action</th></tr>
        <?php foreach ($row2 ?? [] as $s): ?>
        <tr>
            <td><img class="thumb" src="<?= htmlspecialchars($s['image_url']) ?>" alt=""></td>
            <td><?= htmlspecialchars($s['label']) ?></td>
            <td><?= (int)$s['sort_order'] ?></td>
            <td>
                <a href="<?= rtrim(BASE_URL,'/') ?>/admin/glimpse/<?= $s['id'] ?>/edit">Edit</a>
                <form method="post" action="<?= rtrim(BASE_URL,'/') ?>/admin/glimpse/<?= $s['id'] ?>/delete" style="display:inline;" onsubmit="return confirm('Delete?');">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($row2)): ?><tr><td colspan="4">No slides</td></tr><?php endif; ?>
    </table>
</body>
</html>
