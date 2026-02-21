<?php
$filters = $filters ?? [];
$page = (int) ($page ?? 1);
$totalPages = (int) ($totalPages ?? 1);
$total = (int) ($total ?? 0);
$jobs = $jobs ?? [];
$buildQuery = function ($overrides = []) use ($filters) {
    $q = array_merge($filters, $overrides);
    $q = array_filter($q);
    return $q ? '?' . http_build_query($q) : '';
};
?>
<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Job Applications</h2>
        </div>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Applications submitted for job openings. <?= $total ?> total.</p>

    <form method="get" action="<?= admin_url('job-applications') ?>" class="job-app-filters">
        <div class="job-app-filters-row">
            <div class="job-app-filter">
                <label for="filter-job">Position</label>
                <select id="filter-job" name="job_id">
                    <option value="">All positions</option>
                    <?php foreach ($jobs as $j): ?>
                    <option value="<?= (int)($j['id'] ?? 0) ?>" <?= (($filters['job_id'] ?? '') == ($j['id'] ?? '')) ? 'selected' : '' ?>><?= htmlspecialchars($j['title'] ?? '') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="job-app-filter">
                <label for="filter-type">Engagement</label>
                <select id="filter-type" name="engagement_type">
                    <option value="">All types</option>
                    <option value="full-time" <?= ($filters['engagement_type'] ?? '') === 'full-time' ? 'selected' : '' ?>>Full-Time</option>
                    <option value="part-time" <?= ($filters['engagement_type'] ?? '') === 'part-time' ? 'selected' : '' ?>>Part-Time</option>
                    <option value="full-time-part-time" <?= ($filters['engagement_type'] ?? '') === 'full-time-part-time' ? 'selected' : '' ?>>Full-Time / Part-Time</option>
                    <option value="internship" <?= ($filters['engagement_type'] ?? '') === 'internship' ? 'selected' : '' ?>>Internship</option>
                    <option value="volunteer" <?= ($filters['engagement_type'] ?? '') === 'volunteer' ? 'selected' : '' ?>>Volunteer</option>
                </select>
            </div>
            <div class="job-app-filter">
                <label for="filter-date-from">From date</label>
                <input type="date" id="filter-date-from" name="date_from" value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>">
            </div>
            <div class="job-app-filter">
                <label for="filter-date-to">To date</label>
                <input type="date" id="filter-date-to" name="date_to" value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>">
            </div>
            <div class="job-app-filter job-app-filter-search">
                <label for="filter-search">Search</label>
                <input type="search" id="filter-search" name="search" placeholder="Name or email…" value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
            </div>
            <div class="job-app-filter-actions">
                <button type="submit" class="btn btn-primary">Apply filters</button>
                <a href="<?= admin_url('job-applications') ?>" class="btn btn-outline">Clear</a>
            </div>
        </div>
    </form>

    <?php if (empty($applications ?? [])): ?>
    <p class="admin-empty"><?= !empty($filters) ? 'No applications match your filters.' : 'No applications yet.' ?></p>
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

    <?php if ($totalPages > 1): ?>
    <nav class="job-app-pagination" aria-label="Pagination">
        <div class="job-app-pagination-info">
            Showing <?= (($page - 1) * ($perPage ?? 15)) + 1 ?>–<?= min($page * ($perPage ?? 15), $total) ?> of <?= $total ?>
        </div>
        <ul class="job-app-pagination-links">
            <?php if ($page > 1): ?>
            <li><a href="<?= admin_url('job-applications') ?><?= $buildQuery(['page' => $page - 1]) ?>" class="job-app-pagination-link" aria-label="Previous page">← Prev</a></li>
            <?php endif; ?>
            <?php
            $start = max(1, $page - 2);
            $end = min($totalPages, $page + 2);
            if ($start > 1): ?>
            <li><a href="<?= admin_url('job-applications') ?><?= $buildQuery(['page' => 1]) ?>" class="job-app-pagination-link">1</a></li>
            <?php if ($start > 2): ?><li><span class="job-app-pagination-ellipsis">…</span></li><?php endif; ?>
            <?php endif;
            for ($i = $start; $i <= $end; $i++): ?>
            <li>
                <?php if ($i === $page): ?>
                <span class="job-app-pagination-current" aria-current="page"><?= $i ?></span>
                <?php else: ?>
                <a href="<?= admin_url('job-applications') ?><?= $buildQuery(['page' => $i]) ?>" class="job-app-pagination-link"><?= $i ?></a>
                <?php endif; ?>
            </li>
            <?php endfor;
            if ($end < $totalPages): ?>
            <?php if ($end < $totalPages - 1): ?><li><span class="job-app-pagination-ellipsis">…</span></li><?php endif; ?>
            <li><a href="<?= admin_url('job-applications') ?><?= $buildQuery(['page' => $totalPages]) ?>" class="job-app-pagination-link"><?= $totalPages ?></a></li>
            <?php endif; ?>
            <?php if ($page < $totalPages): ?>
            <li><a href="<?= admin_url('job-applications') ?><?= $buildQuery(['page' => $page + 1]) ?>" class="job-app-pagination-link" aria-label="Next page">Next →</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
    <?php endif; ?>
</div>
