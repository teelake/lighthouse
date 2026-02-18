<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Leadership</h2>
        </div>
        <a href="<?= admin_url('leaders/create') ?>" class="btn btn-primary">Add Leader</a>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Team profiles shown on the Leadership page.</p>
    <table class="admin-table">
        <thead><tr><th>Photo</th><th>Name</th><th>Title</th><th>Order</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($leaders ?? [] as $l): ?>
        <tr>
            <td><img src="<?= htmlspecialchars($l['photo'] ?? '') ?>" alt="" style="width: 48px; height: 48px; object-fit: cover; border-radius: 50%;"></td>
            <td><?= htmlspecialchars($l['name']) ?></td>
            <td><?= htmlspecialchars($l['title']) ?></td>
            <td><?= (int)($l['sort_order'] ?? 0) ?></td>
            <td>
                <div class="admin-table-actions">
                    <a href="<?= admin_url('leaders/' . $l['id'] . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                    <form method="post" action="<?= admin_url('leaders/' . $l['id'] . '/delete') ?>" onsubmit="return confirm('Delete this leader?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($leaders)): ?><tr><td colspan="5">No leaders yet. <a href="<?= admin_url('leaders/create') ?>">Add one</a></td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
