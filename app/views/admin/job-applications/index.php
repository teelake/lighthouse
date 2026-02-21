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
        <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Position</th><th>Type</th><th>Age</th><th>Resume</th><th>Date</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($applications ?? [] as $a): ?>
        <?php $displayName = trim(($a['first_name'] ?? '') . ' ' . ($a['last_name'] ?? '')) ?: ($a['name'] ?? ''); ?>
        <tr>
            <td><?= htmlspecialchars($displayName) ?></td>
            <td><a href="mailto:<?= htmlspecialchars($a['email'] ?? '') ?>"><?= htmlspecialchars($a['email'] ?? '') ?></a></td>
            <td><?= htmlspecialchars($a['phone'] ?? '—') ?></td>
            <td><?= htmlspecialchars($a['job_title'] ?? '—') ?></td>
            <td><?= htmlspecialchars(engagement_type_label($a['engagement_type'] ?? '')) ?: '—' ?></td>
            <td><?= htmlspecialchars($a['age_range'] ?? '—') ?></td>
            <td><?php if (!empty($a['resume_path'])): ?><a href="<?= htmlspecialchars($a['resume_path']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline">View</a><?php else: ?>—<?php endif; ?></td>
            <td><?= htmlspecialchars($a['created_at'] ?? '') ?></td>
            <td>
                <div class="admin-table-actions">
                    <a href="<?= admin_url('job-applications/' . (int)($a['id'] ?? 0)) ?>" class="btn btn-sm btn-primary">View</a>
                    <a href="mailto:<?= htmlspecialchars($a['email'] ?? '') ?>?subject=Re: <?= rawurlencode($a['job_title'] ?? '') ?> Application" class="btn btn-sm btn-outline">Contact</a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
