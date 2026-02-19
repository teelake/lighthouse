<?php
$d = $data ?? [];
$key = $section['section_key'] ?? '';
?>
<div class="admin-card">
    <a href="<?= admin_url('sections') ?>" class="admin-back-link">← Sections</a>
    <h2>Edit <?= htmlspecialchars($section['title'] ?? $section['section_key']) ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= admin_url('sections/' . htmlspecialchars($section['section_key'])) ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <?php if ($key === 'hero_config'): ?>
        <div class="form-group"><label>Tagline</label><input type="text" name="tagline" value="<?= htmlspecialchars($d['tagline'] ?? '') ?>"></div>
        <div class="form-group"><label>Pillars (one per line)</label><textarea name="pillars"><?= htmlspecialchars(implode("\n", $d['pillars'] ?? ['Welcome','Worship','Word'])) ?></textarea></div>
        <div class="form-group">
            <label>Background Image</label>
            <?php if (!empty($d['bg_image'])): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;"><img src="<?= htmlspecialchars($d['bg_image']) ?>" alt="" style="max-width: 200px; max-height: 100px; object-fit: contain; border: 1px solid var(--adm-border); border-radius: 6px;"></div>
            <?php endif; ?>
            <input type="file" name="bg_image" accept="image/jpeg,image/png,image/avif,image/svg+xml">
        </div>
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
        <div class="form-group">
            <label>Image</label>
            <?php if (!empty($d['image'])): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;"><img src="<?= htmlspecialchars($d['image']) ?>" alt="" style="max-width: 200px; max-height: 100px; object-fit: contain; border: 1px solid var(--adm-border); border-radius: 6px;"></div>
            <?php endif; ?>
            <input type="file" name="image" accept="image/jpeg,image/png,image/avif,image/svg+xml">
        </div>
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
        <?php elseif ($key === 'scriptural_foundation_config'): ?>
        <p style="color: var(--adm-muted); margin: 0 0 1rem;">Scripture blocks shown in the "Our Scriptural Foundation" section on the About page. Leave reference/description empty to hide a block.</p>
        <div class="form-group"><label>Scripture 1 Reference</label><input type="text" name="scripture_1_ref" value="<?= htmlspecialchars($d['scripture_1_ref'] ?? '') ?>" placeholder="e.g. Isaiah 42:5–11"></div>
        <div class="form-group"><label>Scripture 1 Description</label><textarea name="scripture_1_desc" rows="3"><?= htmlspecialchars($d['scripture_1_desc'] ?? '') ?></textarea></div>
        <div class="form-group"><label>Scripture 2 Reference</label><input type="text" name="scripture_2_ref" value="<?= htmlspecialchars($d['scripture_2_ref'] ?? '') ?>" placeholder="e.g. Isaiah 2:2–4"></div>
        <div class="form-group"><label>Scripture 2 Description</label><textarea name="scripture_2_desc" rows="3"><?= htmlspecialchars($d['scripture_2_desc'] ?? '') ?></textarea></div>
        <div class="form-group"><label>Scripture 3 Reference (optional)</label><input type="text" name="scripture_3_ref" value="<?= htmlspecialchars($d['scripture_3_ref'] ?? '') ?>" placeholder="e.g. Matthew 5:14"></div>
        <div class="form-group"><label>Scripture 3 Description (optional)</label><textarea name="scripture_3_desc" rows="3"><?= htmlspecialchars($d['scripture_3_desc'] ?? '') ?></textarea></div>
        <?php elseif ($key === 'core_values_config'): ?>
        <p style="color: var(--adm-muted); margin: 0 0 1rem;">Core values displayed in a grid on the About page. Each value has a title and description. Leave a row empty to hide it.</p>
        <?php for ($i = 1; $i <= 5; $i++): ?>
        <div style="padding: 1rem 0; border-bottom: 1px solid var(--adm-border);">
            <h4 style="font-size: 0.9rem; margin: 0 0 0.75rem; color: var(--adm-muted);">Value <?= $i ?></h4>
            <div class="form-group"><label>Title</label><input type="text" name="value_<?= $i ?>_title" value="<?= htmlspecialchars($d["value_{$i}_title"] ?? '') ?>" placeholder="e.g. Audacity"></div>
            <div class="form-group"><label>Description</label><input type="text" name="value_<?= $i ?>_desc" value="<?= htmlspecialchars($d["value_{$i}_desc"] ?? '') ?>" placeholder="e.g. Faith that dares the impossible."></div>
        </div>
        <?php endfor; ?>
        <?php endif; ?>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= admin_url('sections') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
