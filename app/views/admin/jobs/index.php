<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Jobs</h2>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="<?= admin_url('job-applications') ?>" class="btn btn-outline">Applications</a>
            <a href="<?= admin_url('jobs/create') ?>" class="btn btn-primary">Add Job</a>
        </div>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Job openings and positions.</p>
    <?php if (empty($jobs ?? [])): ?>
    <p class="admin-empty">No jobs yet. <a href="<?= admin_url('jobs/create') ?>">Add one</a></p>
    <?php else: ?>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Title</th><th>Type</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($jobs ?? [] as $j): ?>
        <tr>
            <td><?= htmlspecialchars($j['title'] ?? '') ?></td>
            <td><span class="admin-badge"><?= htmlspecialchars(job_type_label($j['type'] ?? '') ?: '—') ?></span></td>
            <td>
                <div class="admin-table-actions">
                    <a href="<?= admin_url('jobs/' . ($j['id'] ?? '') . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                    <form method="post" action="<?= admin_url('jobs/' . ($j['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this job?');">
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
