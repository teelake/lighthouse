<?php
$d = $data ?? [];
$key = $section['section_key'] ?? '';
?>
<div class="admin-card">
    <a href="<?= admin_url('sections') ?>" class="admin-back-link">← Sections</a>
    <h2>Edit <?= htmlspecialchars($section['title'] ?? $section['section_key']) ?></h2>
    <form method="post" action="<?= admin_url('sections/' . htmlspecialchars($section['section_key'])) ?>">
        <?= csrf_field() ?>
        <?php if ($key === 'hero_config'): ?>
        <div class="form-group"><label>Tagline</label><input type="text" name="tagline" value="<?= htmlspecialchars($d['tagline'] ?? '') ?>"></div>
        <div class="form-group"><label>Pillars (one per line)</label><textarea name="pillars"><?= htmlspecialchars(implode("\n", $d['pillars'] ?? ['Welcome','Worship','Word'])) ?></textarea></div>
        <div class="form-group"><label>Background Image URL</label><input type="url" name="bg_image" value="<?= htmlspecialchars($d['bg_image'] ?? '') ?>"></div>
        <div class="form-group"><label>Watch CTA URL</label><input type="text" name="cta_watch_url" value="<?= htmlspecialchars($d['cta_watch_url'] ?? '/media') ?>"></div>
        <div class="form-group"><label>Visit CTA URL</label><input type="text" name="cta_visit_url" value="<?= htmlspecialchars($d['cta_visit_url'] ?? '/im-new') ?>"></div>
        <?php elseif ($key === 'gather_config'): ?>
        <div class="form-group"><label>Section Title</label><input type="text" name="section_title" value="<?= htmlspecialchars($d['section_title'] ?? '') ?>"></div>
        <div class="form-group"><label>Section Subtitle</label><input type="text" name="section_sub" value="<?= htmlspecialchars($d['section_sub'] ?? '') ?>"></div>
        <div class="form-group"><label>Sunday Title</label><input type="text" name="sunday_title" value="<?= htmlspecialchars($d['sunday_title'] ?? 'Sunday') ?>"></div>
        <div class="form-group"><label>Sunday Description</label><textarea name="sunday_desc"><?= htmlspecialchars($d['sunday_desc'] ?? '') ?></textarea></div>
        <div class="form-group"><label>Thursday Title</label><input type="text" name="thursday_title" value="<?= htmlspecialchars($d['thursday_title'] ?? 'Thursday') ?>"></div>
        <div class="form-group"><label>Thursday Description</label><textarea name="thursday_desc"><?= htmlspecialchars($d['thursday_desc'] ?? '') ?></textarea></div>
        <?php elseif ($key === 'lights_config'): ?>
        <div class="form-group"><label>Headline</label><input type="text" name="headline" value="<?= htmlspecialchars($d['headline'] ?? '') ?>"></div>
        <div class="form-group"><label>Image URL</label><input type="url" name="image" value="<?= htmlspecialchars($d['image'] ?? '') ?>"></div>
        <?php elseif ($key === 'prayer_wall_config'): ?>
        <div class="form-group"><label>Eyebrow</label><input type="text" name="eyebrow" value="<?= htmlspecialchars($d['eyebrow'] ?? '') ?>"></div>
        <div class="form-group"><label>Headline</label><input type="text" name="headline" value="<?= htmlspecialchars($d['headline'] ?? '') ?>"></div>
        <div class="form-group"><label>Description</label><textarea name="description" class="rich-editor"><?= htmlspecialchars($d['description'] ?? '') ?></textarea></div>
        <?php elseif ($key === 'newsletter_config'): ?>
        <div class="form-group"><label>Eyebrow</label><input type="text" name="eyebrow" value="<?= htmlspecialchars($d['eyebrow'] ?? '') ?>"></div>
        <div class="form-group"><label>Title</label><input type="text" name="title" value="<?= htmlspecialchars($d['title'] ?? '') ?>"></div>
        <div class="form-group"><label>Note</label><textarea name="note" class="rich-editor"><?= htmlspecialchars($d['note'] ?? '') ?></textarea></div>
        <?php elseif ($key === 'whats_on_config'): ?>
        <div class="form-group"><label>Sunday Title</label><input type="text" name="sunday_title" value="<?= htmlspecialchars($d['sunday_title'] ?? 'Sunday') ?>"></div>
        <div class="form-group"><label>Sunday Description</label><textarea name="sunday_desc"><?= htmlspecialchars($d['sunday_desc'] ?? '') ?></textarea></div>
        <div class="form-group"><label>Thursday Title</label><input type="text" name="thursday_title" value="<?= htmlspecialchars($d['thursday_title'] ?? 'Thursday') ?>"></div>
        <div class="form-group"><label>Thursday Description</label><textarea name="thursday_desc"><?= htmlspecialchars($d['thursday_desc'] ?? '') ?></textarea></div>
        <?php endif; ?>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= admin_url('sections') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
