<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
        <h2 style="margin: 0;">Users</h2>
        <a href="<?= admin_url('users/create') ?>" class="btn btn-primary">Add User</a>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Manage admin, editor, and member accounts.</p>
    <table class="admin-table">
        <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($users ?? [] as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><span style="text-transform: capitalize;"><?= htmlspecialchars($u['role']) ?></span></td>
            <td><?= !empty($u['is_active']) ? 'Active' : 'Inactive' ?></td>
            <td>
                <a href="<?= admin_url('users/' . $u['id'] . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                <?php if ($u['id'] != ($_SESSION['user_id'] ?? 0)): ?>
                <form method="post" action="<?= admin_url('users/' . $u['id'] . '/delete') ?>" style="display:inline;" onsubmit="return confirm('Delete this user?');">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($users)): ?><tr><td colspan="5">No users.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
