<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>First-Time Visitors</h2>
        </div>
        <a href="<?= admin_url('visitors/create') ?>" class="btn btn-primary">Add Visitor</a>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Visitors are added by staff—no public self-registration. Ensures control and data integrity.</p>
    <?php if (empty($visitors ?? [])): ?>
    <p class="admin-empty">No visitors yet. <a href="<?= admin_url('visitors/create') ?>">Add one</a></p>
    <?php else: ?>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Date</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($visitors ?? [] as $v): ?>
        <tr>
            <td><?= htmlspecialchars(trim(($v['first_name'] ?? '') . ' ' . ($v['last_name'] ?? ''))) ?></td>
            <td><a href="mailto:<?= htmlspecialchars($v['email'] ?? '') ?>"><?= htmlspecialchars($v['email'] ?? '') ?></a></td>
            <td><?= htmlspecialchars($v['phone'] ?? '—') ?></td>
            <td><?= htmlspecialchars($v['created_at'] ?? '') ?></td>
            <td>
                <div class="admin-table-actions">
                    <a href="<?= admin_url('visitors/' . ($v['id'] ?? '') . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                    <form method="post" action="<?= admin_url('visitors/' . ($v['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this visitor?');">
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
