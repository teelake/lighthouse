<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Job Applications</h2>
        </div>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Applications submitted for job openings.</p>
    <?php if (empty($applications ?? [])): ?>
    <p class="admin-empty">No applications yet.</p>
    <?php else: ?>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Name</th><th>Email</th><th>Position</th><th>Date</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($applications ?? [] as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a['name'] ?? '') ?></td>
            <td><a href="mailto:<?= htmlspecialchars($a['email'] ?? '') ?>"><?= htmlspecialchars($a['email'] ?? '') ?></a></td>
            <td><?= htmlspecialchars($a['job_title'] ?? '—') ?></td>
            <td><?= htmlspecialchars($a['created_at'] ?? '') ?></td>
            <td>
                <div class="admin-table-actions">
                    <a href="mailto:<?= htmlspecialchars($a['email'] ?? '') ?>?subject=Re: <?= rawurlencode($a['job_title'] ?? '') ?> Application" class="btn btn-sm btn-outline">Contact</a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
