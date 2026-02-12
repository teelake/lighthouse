<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Sections - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; margin: 0; background: #f1f5f9; }
        .header { background: #0f172a; color: #fff; padding: 1rem 2rem; }
        .header a { color: #fff; margin-right: 1rem; }
        .main { max-width: 800px; margin: 0 auto; padding: 2rem; }
        table { width: 100%; background: #fff; border-radius: 8px; overflow: hidden; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #e2e8f0; }
        a { color: #1a5f4a; }
    </style>
</head>
<body>
    <div class="header">
        <a href="<?= rtrim(BASE_URL,'/') ?>/admin">← Dashboard</a>
    </div>
    <div class="main">
        <h1>Content Sections</h1>
        <table>
            <tr><th>Key</th><th>Title</th><th>Action</th></tr>
            <?php foreach ($sections ?? [] as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s['section_key']) ?></td>
                <td><?= htmlspecialchars($s['title'] ?? '') ?></td>
                <td><a href="<?= rtrim(BASE_URL,'/') ?>/admin/sections/<?= htmlspecialchars($s['section_key']) ?>/edit">Edit</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
