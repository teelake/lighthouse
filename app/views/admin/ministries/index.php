<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Ministries</h2>
        </div>
        <a href="<?= admin_url('ministries/create') ?>" class="btn btn-primary">Add Ministry</a>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Church ministries and service areas.</p>
    <?php if (empty($ministries ?? [])): ?>
    <p class="admin-empty">No ministries yet. <a href="<?= admin_url('ministries/create') ?>">Add one</a></p>
    <?php else: ?>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Title</th><th>Tagline</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($ministries ?? [] as $m): ?>
        <tr>
            <td><?= htmlspecialchars($m['title'] ?? '') ?></td>
            <td><?= htmlspecialchars($m['tagline'] ?? '—') ?></td>
            <td>
                <div class="admin-table-actions">
                    <a href="<?= admin_url('ministries/' . ($m['id'] ?? '') . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                    <form method="post" action="<?= admin_url('ministries/' . ($m['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this ministry?');">
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
