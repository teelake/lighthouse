<?php
// Determine the current date type from existing event data
$dateType = 'single'; // default for new events
if (isset($event)) {
    if (empty($event['event_date'])) {
        $dateType = 'tba';
    } elseif (!empty($event['event_end_date'])) {
        $dateType = 'range';
    }
}
?>
<div class="admin-card">
    <a href="<?= admin_url('events') ?>" class="admin-back-link">← Events</a>
    <h2><?= $event ? 'Edit Event' : 'Add Event' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $event ? admin_url('events/' . $event['id']) : admin_url('events') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($event['title'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Image</label>
            <?php if (!empty($event['image'] ?? '')): ?>
            <div class="admin-image-preview" style="margin-bottom: 0.75rem;">
                <img src="<?= htmlspecialchars($event['image']) ?>" alt="" style="max-width: 240px; max-height: 140px; object-fit: cover; border: 1px solid var(--adm-border); border-radius: 6px;">
                <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">Current image. Upload to replace.</p>
            </div>
            <?php endif; ?>
            <input type="file" name="image" accept="image/jpeg,image/png,image/avif,image/svg+xml">
            <p class="admin-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">JPG, PNG, AVIF, SVG. Max <?= defined('MAX_UPLOAD_SIZE') ? round(MAX_UPLOAD_SIZE / 1024 / 1024) : 10 ?>MB. Recommended: 800×450 or similar.</p>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="rich-editor"><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
        </div>

        <!-- Date Type -->
        <div class="form-group">
            <label>Date Type</label>
            <div class="event-date-type-group">
                <label class="event-date-type-option">
                    <input type="radio" name="date_type" value="tba" <?= $dateType === 'tba' ? 'checked' : '' ?>>
                    <span>
                        <strong>Coming Soon / TBA</strong>
                        <em>No date set yet — shows "Coming Soon"</em>
                    </span>
                </label>
                <label class="event-date-type-option">
                    <input type="radio" name="date_type" value="single" <?= $dateType === 'single' ? 'checked' : '' ?>>
                    <span>
                        <strong>Single Date</strong>
                        <em>Happens on one specific date</em>
                    </span>
                </label>
                <label class="event-date-type-option">
                    <input type="radio" name="date_type" value="range" <?= $dateType === 'range' ? 'checked' : '' ?>>
                    <span>
                        <strong>Date Range</strong>
                        <em>Spans multiple days (e.g. a conference or retreat)</em>
                    </span>
                </label>
            </div>
        </div>

        <!-- Single date fields -->
        <div id="event-date-single" class="event-date-fields">
            <div class="form-row-two">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="event_date" id="event_date_single" value="<?= htmlspecialchars($event['event_date'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Time <span style="font-weight:400;color:var(--adm-muted);">(optional)</span></label>
                    <input type="time" name="event_time" value="<?= htmlspecialchars($event['event_time'] ?? '') ?>">
                </div>
            </div>
        </div>

        <!-- Range date fields -->
        <div id="event-date-range" class="event-date-fields">
            <div class="form-row-two">
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="event_date_range_start" id="event_date_range_start" value="<?= htmlspecialchars($event['event_date'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="event_end_date" value="<?= htmlspecialchars($event['event_end_date'] ?? '') ?>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" value="<?= htmlspecialchars($event['location'] ?? '') ?>">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $event ? 'Update' : 'Create' ?></button>
            <a href="<?= admin_url('events') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

<style>
.event-date-type-group { display: flex; flex-direction: column; gap: 0.5rem; }
.event-date-type-option { display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.75rem 1rem; border: 1px solid var(--adm-border); border-radius: var(--adm-radius); cursor: pointer; transition: border-color 0.15s; }
.event-date-type-option:has(input:checked) { border-color: var(--adm-primary, #d4a017); background: var(--adm-primary-bg, #fffbeb); }
.event-date-type-option input[type="radio"] { margin-top: 3px; flex-shrink: 0; }
.event-date-type-option span { display: flex; flex-direction: column; gap: 0.15rem; }
.event-date-type-option strong { font-size: 0.9rem; color: var(--adm-text); }
.event-date-type-option em { font-size: 0.8rem; color: var(--adm-muted); font-style: normal; }
.event-date-fields { margin-top: 0.75rem; }
.form-row-two { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
@media (max-width: 600px) { .form-row-two { grid-template-columns: 1fr; } }
</style>

<script>
(function () {
    var radios  = document.querySelectorAll('input[name="date_type"]');
    var single  = document.getElementById('event-date-single');
    var range   = document.getElementById('event-date-range');
    var inpSingle = document.getElementById('event_date_single');
    var inpRangeStart = document.getElementById('event_date_range_start');

    function sync() {
        var val = document.querySelector('input[name="date_type"]:checked')?.value || 'single';
        single.style.display = val === 'single' ? '' : 'none';
        range.style.display  = val === 'range'  ? '' : 'none';

        // Keep the hidden panel's date input disabled so it doesn't submit
        if (inpSingle)    inpSingle.disabled    = val !== 'single';
        if (inpRangeStart) inpRangeStart.disabled = val !== 'range';
    }

    radios.forEach(function (r) { r.addEventListener('change', sync); });
    sync(); // run on load
})();
</script>
