<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?= htmlspecialchars($section['section_key']) ?> - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; margin: 0; background: #f1f5f9; }
        .header { background: #0f172a; color: #fff; padding: 1rem 2rem; }
        .header a { color: #fff; margin-right: 1rem; }
        .main { max-width: 800px; margin: 0 auto; padding: 2rem; }
        textarea { width: 100%; min-height: 150px; padding: 1rem; border-radius: 8px; border: 1px solid #e2e8f0; }
        button { padding: 0.75rem 1.5rem; background: #1a5f4a; color: #fff; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; }
    </style>
</head>
<body>
    <div class="header">
        <a href="<?= rtrim(BASE_URL,'/') ?>/admin/sections">← Sections</a>
    </div>
    <div class="main">
        <h1>Edit <?= htmlspecialchars($section['section_key']) ?></h1>
        <form method="post" action="<?= rtrim(BASE_URL,'/') ?>/admin/sections/<?= htmlspecialchars($section['section_key']) ?>">
            <div style="margin-bottom: 1rem;">
                <label><strong><?= htmlspecialchars($section['title'] ?? $section['section_key']) ?></strong></label>
                <textarea name="content" class="rich-editor"><?= htmlspecialchars($section['content'] ?? '') ?></textarea>
            </div>
            <button type="submit">Save</button>
        </form>
    </div>
</body>
</html>
