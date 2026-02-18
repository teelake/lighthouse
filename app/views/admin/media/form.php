<?php
$sourcesByType = [
    'video'   => ['youtube' => 'YouTube', 'vimeo' => 'Vimeo', 'upload' => 'Upload', 'external' => 'External'],
    'audio'   => ['upload' => 'Upload', 'external' => 'External'],
    'teaching'=> ['youtube' => 'YouTube', 'vimeo' => 'Vimeo', 'upload' => 'Upload', 'external' => 'External'],
];
$currentType = $item['media_type'] ?? 'video';
$currentSource = $item['source'] ?? '';
$validSources = $sourcesByType[$currentType] ?? $sourcesByType['video'];
if (!isset($validSources[$currentSource])) {
    $keys = array_keys($validSources);
    $currentSource = $keys[0] ?? 'youtube';
}
?>
<div class="admin-card">
    <a href="<?= admin_url('media') ?>" class="admin-back-link">← Media</a>
    <h2><?= $item ? 'Edit Media' : 'Add Media' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $item ? admin_url('media/' . $item['id']) : admin_url('media') ?>" id="media-form">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($item['title'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Type</label>
            <select name="media_type" id="media-type">
                <option value="video" <?= $currentType === 'video' ? 'selected' : '' ?>>Video</option>
                <option value="audio" <?= $currentType === 'audio' ? 'selected' : '' ?>>Audio</option>
                <option value="teaching" <?= $currentType === 'teaching' ? 'selected' : '' ?>>Teaching</option>
            </select>
        </div>
        <div class="form-group">
            <label>Source</label>
            <select name="source" id="media-source">
                <?php foreach ($validSources as $val => $label): ?>
                <option value="<?= htmlspecialchars($val) ?>" <?= $currentSource === $val ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label id="embed-label">Embed URL / YouTube link</label>
            <input type="url" name="embed_url" id="embed-url" value="<?= htmlspecialchars($item['embed_url'] ?? '') ?>" placeholder="https://...">
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
<script>
(function() {
    var sourcesByType = <?= json_encode($sourcesByType) ?>;
    var typeSelect = document.getElementById('media-type');
    var sourceSelect = document.getElementById('media-source');
    var embedLabel = document.getElementById('embed-label');

    var sourcePlaceholders = {
        youtube: 'Embed URL / YouTube link',
        vimeo: 'Vimeo embed URL',
        upload: 'File path or URL',
        external: 'External URL'
    };

    function updateSourceOptions() {
        var type = typeSelect.value;
        var sources = sourcesByType[type] || sourcesByType.video;
        var currentVal = sourceSelect.value;
        var valid = Object.keys(sources).indexOf(currentVal) !== -1;
        sourceSelect.innerHTML = '';
        var firstVal = null;
        for (var val in sources) {
            var opt = document.createElement('option');
            opt.value = val;
            opt.textContent = sources[val];
            if (valid && val === currentVal) opt.selected = true;
            if (!firstVal) firstVal = val;
            sourceSelect.appendChild(opt);
        }
        if (!valid && firstVal) sourceSelect.value = firstVal;
        updateEmbedLabel();
    }

    function updateEmbedLabel() {
        var src = sourceSelect.value;
        embedLabel.textContent = sourcePlaceholders[src] || 'Embed URL / link';
    }

    typeSelect.addEventListener('change', updateSourceOptions);
    sourceSelect.addEventListener('change', updateEmbedLabel);
    updateSourceOptions();
})();
</script>
