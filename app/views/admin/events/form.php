<div class="admin-card">
    <a href="<?= admin_url('events') ?>" class="admin-back-link">← Events</a>
    <h2><?= $event ? 'Edit Event' : 'Add Event' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $event ? admin_url('events/' . $event['id']) : admin_url('events') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($event['title'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="rich-editor"><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="event_date" value="<?= htmlspecialchars($event['event_date'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Time</label>
            <input type="time" name="event_time" value="<?= htmlspecialchars($event['event_time'] ?? '') ?>">
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
