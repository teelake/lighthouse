<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leadership - Admin</title>
    <style>
        body { font-family: -apple-system, sans-serif; margin: 0; padding: 1.5rem; background: #f5f5f5; }
        a { color: #1a5f4a; }
        table { width: 100%; background: #fff; border-radius: 8px; border-collapse: collapse; }
        th, td { padding: 0.75rem; border-bottom: 1px solid #eee; }
        .thumb { width: 48px; height: 48px; object-fit: cover; border-radius: 50%; }
    </style>
</head>
<body>
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin">← Dashboard</a>
    <h1>Leadership</h1>
    <p>Manage team profiles shown on the Leadership page.</p>
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin/leaders/create">Add Leader</a>
    <table>
        <tr><th>Photo</th><th>Name</th><th>Title</th><th>Order</th><th>Action</th></tr>
        <?php foreach ($leaders ?? [] as $l): ?>
        <tr>
            <td><img class="thumb" src="<?= htmlspecialchars($l['photo'] ?? '') ?>" alt=""></td>
            <td><?= htmlspecialchars($l['name']) ?></td>
            <td><?= htmlspecialchars($l['title']) ?></td>
            <td><?= (int)$l['sort_order'] ?></td>
            <td>
                <a href="<?= rtrim(BASE_URL,'/') ?>/admin/leaders/<?= $l['id'] ?>/edit">Edit</a>
                <form method="post" action="<?= rtrim(BASE_URL,'/') ?>/admin/leaders/<?= $l['id'] ?>/delete" style="display:inline;" onsubmit="return confirm('Delete?');">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($leaders)): ?><tr><td colspan="5">No leaders yet.</td></tr><?php endif; ?>
    </table>
</body>
</html>
