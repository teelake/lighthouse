<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Small Groups</h2>
        </div>
        <a href="<?= admin_url('small-groups/create') ?>" class="btn btn-primary">Add Small Group</a>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Community small groups and connect groups.</p>
    <?php if (empty($groups ?? [])): ?>
    <p class="admin-empty">No small groups yet. <a href="<?= admin_url('small-groups/create') ?>">Add one</a></p>
    <?php else: ?>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Title</th><th>Tagline</th><th>Target Age</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($groups ?? [] as $g): ?>
        <tr>
            <td><?= htmlspecialchars($g['title'] ?? '') ?></td>
            <td><?= htmlspecialchars($g['tagline'] ?? '—') ?></td>
            <td><?= htmlspecialchars($g['target_age'] ?? '—') ?></td>
            <td>
                <div class="admin-table-actions">
                    <a href="<?= admin_url('small-groups/' . ($g['id'] ?? '') . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                    <form method="post" action="<?= admin_url('small-groups/' . ($g['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this small group?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
