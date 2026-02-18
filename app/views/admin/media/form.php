<div class="admin-card">
    <a href="<?= admin_url('media') ?>" class="admin-back-link">← Media</a>
    <h2><?= $item ? 'Edit Media' : 'Add Media' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $item ? admin_url('media/' . $item['id']) : admin_url('media') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($item['title'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Type</label>
            <select name="media_type">
                <option value="video" <?= ($item['media_type'] ?? '') === 'video' ? 'selected' : '' ?>>Video</option>
                <option value="audio" <?= ($item['media_type'] ?? '') === 'audio' ? 'selected' : '' ?>>Audio</option>
                <option value="teaching" <?= ($item['media_type'] ?? '') === 'teaching' ? 'selected' : '' ?>>Teaching</option>
            </select>
        </div>
        <div class="form-group">
            <label>Source</label>
            <select name="source">
                <option value="youtube" <?= ($item['source'] ?? '') === 'youtube' ? 'selected' : '' ?>>YouTube</option>
                <option value="vimeo" <?= ($item['source'] ?? '') === 'vimeo' ? 'selected' : '' ?>>Vimeo</option>
                <option value="upload" <?= ($item['source'] ?? '') === 'upload' ? 'selected' : '' ?>>Upload</option>
                <option value="external" <?= ($item['source'] ?? '') === 'external' ? 'selected' : '' ?>>External</option>
            </select>
        </div>
        <div class="form-group">
            <label>Embed URL / YouTube link</label>
            <input type="url" name="embed_url" value="<?= htmlspecialchars($item['embed_url'] ?? '') ?>" placeholder="https://...">
        </div>
        <div class="form-group">
            <label>Published Date</label>
            <input type="date" name="published_at" value="<?= htmlspecialchars($item['published_at'] ?? date('Y-m-d')) ?>">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="rich-editor"><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $item ? 'Update' : 'Create' ?></button>
            <a href="<?= admin_url('media') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
