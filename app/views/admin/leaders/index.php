<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
        <h2 style="margin: 0;">Leadership</h2>
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
                <a href="<?= admin_url('leaders/' . $l['id'] . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                <form method="post" action="<?= admin_url('leaders/' . $l['id'] . '/delete') ?>" style="display:inline;" onsubmit="return confirm('Delete this leader?');">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($leaders)): ?><tr><td colspan="5">No leaders yet. <a href="<?= admin_url('leaders/create') ?>">Add one</a></td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
