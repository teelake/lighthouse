<?php
/**
 * Reusable image upload field partial.
 * @var string $name - Form field name
 * @var string $label - Label text
 * @var string|null $currentUrl - Current image URL (for edit)
 * @var bool $required - Whether upload is required (on create)
 */
$currentUrl = $currentUrl ?? null;
$required = $required ?? false;
$accept = 'image/jpeg,image/png,image/avif,image/svg+xml';
?>
<div class="form-group">
    <label><?= htmlspecialchars($label) ?></label>
    <?php if (!empty($currentUrl)): ?>
    <div class="admin-image-preview" style="margin-bottom: 0.75rem;">
        <img src="<?= htmlspecialchars($currentUrl) ?>" alt="" style="max-width: 200px; max-height: 120px; object-fit: contain; border: 1px solid var(--adm-border); border-radius: 6px;">
        <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Current image. Upload a new one to replace.</p>
    </div>
    <?php endif; ?>
    <input type="file" name="<?= htmlspecialchars($name) ?>" accept="<?= htmlspecialchars($accept) ?>" <?= $required && !$currentUrl ? 'required' : '' ?>>
    <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">JPG, JPEG, PNG, AVIF, SVG. Max <?= defined('MAX_UPLOAD_SIZE') ? round(MAX_UPLOAD_SIZE / 1024 / 1024) : 10 ?>MB. Images are optimized automatically.</p>
</div>
