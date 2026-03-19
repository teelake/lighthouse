<?php
$members = $members ?? [];
$search = $search ?? '';
$status = $status ?? 'all';
$page = (int)($page ?? 1);
$totalPages = (int)($totalPages ?? 1);
$total = (int)($total ?? 0);
$perPage = (int)($perPage ?? 20);
$buildQuery = function ($overrides = []) {
    $q = array_merge($_GET ?? [], $overrides);
    $q = array_filter($q);
    return $q ? '?' . http_build_query($q) : '';
};
?>
<div class="admin-card">
    <?php if (!empty($flash ?? '')): ?>
    <div class="alert alert-success" role="alert"><?= htmlspecialchars($flash) ?></div>
    <?php endif; ?>
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Members</h2>
        </div>
        <div>
            <a href="<?= admin_url('members/export') ?><?= $buildQuery() ?>" class="btn btn-outline">Export</a>
            <a href="<?= admin_url('members/create') ?>" class="btn btn-primary">Add Member</a>
        </div>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Church members who have registered and can access the dashboard and Prayer Wall.</p>
    <form method="get" action="<?= admin_url('members') ?>" class="admin-search-form" style="margin-bottom: 1.25rem; display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center;">
        <input type="search" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name or email..." style="max-width: 260px; padding: 0.5rem 0.75rem; border: 2px solid var(--adm-border); border-radius: var(--adm-radius-sm); font-size: 0.9rem;">
        <select name="status" style="padding: 0.5rem 0.75rem; border: 2px solid var(--adm-border); border-radius: var(--adm-radius-sm); font-size: 0.9rem;">
            <option value="all" <?= $status === 'all' ? 'selected' : '' ?>>All status</option>
            <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
            <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
        </select>
        <button type="submit" class="btn btn-outline btn-sm">Filter</button>
        <?php if ($search !== '' || $status !== 'all'): ?><a href="<?= admin_url('members') ?>" class="btn btn-outline btn-sm">Clear</a><?php endif; ?>
    </form>
    <?php if (empty($members)): ?>
    <p class="admin-empty"><?= $search !== '' || $status !== 'all' ? 'No members match your filters.' : 'No members yet.' ?></p>
    <?php else: ?>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Name</th><th>Email</th><th>Status</th><th>Joined</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($members as $m): ?>
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
    <?php if ($totalPages > 1): ?>
    <nav class="job-app-pagination" style="margin-top: 1.5rem;" aria-label="Pagination">
        <div class="job-app-pagination-info">Showing <?= (($page - 1) * $perPage) + 1 ?>–<?= min($page * $perPage, $total) ?> of <?= $total ?></div>
        <ul class="job-app-pagination-links">
            <?php if ($page > 1): ?><li><a href="<?= admin_url('members') ?><?= $buildQuery(['page' => $page - 1]) ?>" class="job-app-pagination-link">← Prev</a></li><?php endif; ?>
            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
            <li><?php if ($i === $page): ?><span class="job-app-pagination-current" aria-current="page"><?= $i ?></span><?php else: ?><a href="<?= admin_url('members') ?><?= $buildQuery(['page' => $i]) ?>" class="job-app-pagination-link"><?= $i ?></a><?php endif; ?></li>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?><li><a href="<?= admin_url('members') ?><?= $buildQuery(['page' => $page + 1]) ?>" class="job-app-pagination-link">Next →</a></li><?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
    <?php endif; ?>
</div>
