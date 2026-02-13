<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?= htmlspecialchars($section['title'] ?? $section['section_key']) ?> - Admin</title>
    <style>
        body { font-family: -apple-system, sans-serif; margin: 0; padding: 2rem; background: #f5f5f5; }
        .card { background: #fff; padding: 1.5rem; border-radius: 8px; max-width: 600px; }
        label { display: block; font-weight: 600; margin-top: 1rem; }
        input, textarea, select { width: 100%; max-width: 500px; padding: 0.5rem; margin-top: 0.25rem; }
        textarea { min-height: 80px; }
        button { margin-top: 1.5rem; padding: 0.5rem 1.5rem; background: #1a5f4a; color: #fff; border: none; border-radius: 6px; cursor: pointer; }
        a { color: #1a5f4a; }
    </style>
</head>
<body>
    <a href="<?= rtrim(BASE_URL,'/') ?>/admin/sections">← Sections</a>
    <h1>Edit <?= htmlspecialchars($section['title'] ?? $section['section_key']) ?></h1>
    <form method="post" action="<?= rtrim(BASE_URL,'/') ?>/admin/sections/<?= htmlspecialchars($section['section_key']) ?>">
        <div class="card">
        <?php
        $d = $data ?? [];
        $key = $section['section_key'] ?? '';
        if ($key === 'hero_config'): ?>
            <label>Tagline</label>
            <input name="tagline" value="<?= htmlspecialchars($d['tagline'] ?? '') ?>">
            <label>Pillars (one per line)</label>
            <textarea name="pillars"><?= htmlspecialchars(implode("\n", $d['pillars'] ?? ['Welcome','Worship','Word'])) ?></textarea>
            <label>Background Image URL</label>
            <input name="bg_image" value="<?= htmlspecialchars($d['bg_image'] ?? '') ?>">
            <label>Watch CTA URL</label>
            <input name="cta_watch_url" value="<?= htmlspecialchars($d['cta_watch_url'] ?? '/media') ?>">
            <label>Visit CTA URL</label>
            <input name="cta_visit_url" value="<?= htmlspecialchars($d['cta_visit_url'] ?? '/im-new') ?>">
        <?php elseif ($key === 'gather_config'): ?>
            <label>Section Title</label>
            <input name="section_title" value="<?= htmlspecialchars($d['section_title'] ?? '') ?>">
            <label>Section Subtitle</label>
            <input name="section_sub" value="<?= htmlspecialchars($d['section_sub'] ?? '') ?>">
            <label>Sunday Title</label>
            <input name="sunday_title" value="<?= htmlspecialchars($d['sunday_title'] ?? 'Sunday') ?>">
            <label>Sunday Description</label>
            <input name="sunday_desc" value="<?= htmlspecialchars($d['sunday_desc'] ?? '') ?>">
            <label>Thursday Title</label>
            <input name="thursday_title" value="<?= htmlspecialchars($d['thursday_title'] ?? 'Thursday') ?>">
            <label>Thursday Description</label>
            <input name="thursday_desc" value="<?= htmlspecialchars($d['thursday_desc'] ?? '') ?>">
        <?php elseif ($key === 'lights_config'): ?>
            <label>Headline</label>
            <input name="headline" value="<?= htmlspecialchars($d['headline'] ?? '') ?>">
            <label>Image URL</label>
            <input name="image" value="<?= htmlspecialchars($d['image'] ?? '') ?>">
        <?php elseif ($key === 'prayer_wall_config'): ?>
            <label>Eyebrow</label>
            <input name="eyebrow" value="<?= htmlspecialchars($d['eyebrow'] ?? '') ?>">
            <label>Headline</label>
            <input name="headline" value="<?= htmlspecialchars($d['headline'] ?? '') ?>">
            <label>Description</label>
            <textarea name="description"><?= htmlspecialchars($d['description'] ?? '') ?></textarea>
        <?php elseif ($key === 'newsletter_config'): ?>
            <label>Eyebrow</label>
            <input name="eyebrow" value="<?= htmlspecialchars($d['eyebrow'] ?? '') ?>">
            <label>Title</label>
            <input name="title" value="<?= htmlspecialchars($d['title'] ?? '') ?>">
            <label>Note</label>
            <textarea name="note"><?= htmlspecialchars($d['note'] ?? '') ?></textarea>
        <?php elseif ($key === 'whats_on_config'): ?>
            <label>Sunday Title</label>
            <input name="sunday_title" value="<?= htmlspecialchars($d['sunday_title'] ?? '') ?>">
            <label>Sunday Description</label>
            <input name="sunday_desc" value="<?= htmlspecialchars($d['sunday_desc'] ?? '') ?>">
            <label>Thursday Title</label>
            <input name="thursday_title" value="<?= htmlspecialchars($d['thursday_title'] ?? '') ?>">
            <label>Thursday Description</label>
            <input name="thursday_desc" value="<?= htmlspecialchars($d['thursday_desc'] ?? '') ?>">
        <?php endif; ?>
        <button type="submit">Save</button>
        </div>
    </form>
</body>
</html>
