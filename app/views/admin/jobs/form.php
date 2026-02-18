<div class="admin-card">
    <a href="<?= admin_url('jobs') ?>" class="admin-back-link">← Jobs</a>
    <h2><?= $job ? 'Edit Job' : 'Add Job' ?></h2>
    <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" action="<?= $job ? admin_url('jobs/' . $job['id']) : admin_url('jobs') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($job['title'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Type</label>
            <select name="type">
                <option value="full-time" <?= ($job['type'] ?? '') === 'full-time' ? 'selected' : '' ?>>Full-Time</option>
                <option value="part-time" <?= ($job['type'] ?? '') === 'part-time' ? 'selected' : '' ?>>Part-Time</option>
                <option value="internship" <?= ($job['type'] ?? '') === 'internship' ? 'selected' : '' ?>>Internship</option>
                <option value="volunteer" <?= ($job['type'] ?? '') === 'volunteer' ? 'selected' : '' ?>>Volunteer</option>
            </select>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="rich-editor"><?= htmlspecialchars($job['description'] ?? '') ?></textarea>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $job ? 'Update' : 'Create' ?></button>
            <a href="<?= admin_url('jobs') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
