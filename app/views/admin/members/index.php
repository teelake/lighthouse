<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Members</h2>
        </div>
        <a href="<?= admin_url('members/export') ?>" class="btn btn-outline">Export</a>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Church members who have registered and can access the dashboard and Prayer Wall.</p>
    <?php if (empty($members ?? [])): ?>
    <p class="admin-empty">No members yet.</p>
    <?php else: ?>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Name</th><th>Email</th><th>Status</th><th>Joined</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($members ?? [] as $m): ?>
        <tr>
            <td><?= htmlspecialchars($m['name'] ?? '') ?></td>
            <td><a href="mailto:<?= htmlspecialchars($m['email'] ?? '') ?>"><?= htmlspecialchars($m['email'] ?? '') ?></a></td>
            <td><?= !empty($m['is_active']) ? 'Active' : 'Inactive' ?></td>
            <td><?= htmlspecialchars($m['created_at'] ?? '') ?></td>
            <td><a href="<?= admin_url('users/' . ($m['id'] ?? '') . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
