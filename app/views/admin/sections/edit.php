<div class="admin-card">
    <a href="<?= admin_url('sections') ?>" class="admin-back-link">← Sections</a>
    <h2>Edit <?= htmlspecialchars($section['section_key'] ?? '') ?></h2>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;"><?= htmlspecialchars($section['title'] ?? $section['section_key']) ?></p>
    <form method="post" action="<?= admin_url('sections/' . htmlspecialchars($section['section_key'])) ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Content</label>
            <textarea name="content" class="rich-editor"><?= htmlspecialchars($section['content'] ?? '') ?></textarea>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= admin_url('sections') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
