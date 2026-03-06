<?php
$rows       = $rows ?? [];
$total      = (int)($total ?? 0);
$page       = (int)($page ?? 1);
$totalPages = (int)($totalPages ?? 1);
$perPage    = (int)($perPage ?? 20);
$academy    = $academy ?? '';
$labels     = \App\Models\AcademyRegistration::$academyLabels;
$buildQuery = function ($overrides = []) use ($academy) {
    $q = array_filter(array_merge(['academy' => $academy], $overrides));
    return $q ? '?' . http_build_query($q) : '';
};
?>
<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Academy Sign-Ups</h2>
        </div>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1.25rem;"><?= $total ?> registration<?= $total !== 1 ? 's' : '' ?> total.</p>

    <!-- Filter by academy -->
    <form method="get" action="<?= admin_url('academy-registrations') ?>" class="acad-reg-filters">
        <select name="academy" onchange="this.form.submit()">
            <option value="">All Academies</option>
            <?php foreach ($labels as $val => $label): ?>
            <option value="<?= $val ?>" <?= $academy === $val ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
            <?php endforeach; ?>
        </select>
        <?php if ($academy): ?>
        <a href="<?= admin_url('academy-registrations') ?>" class="btn btn-outline btn-sm">Clear</a>
        <?php endif; ?>
    </form>

    <?php if (empty($rows)): ?>
    <p class="admin-empty">No registrations yet<?= $academy ? ' for this academy' : '' ?>.</p>
    <?php else: ?>
    <table class="admin-table admin-table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Academy</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['full_name'] ?? '') ?></td>
            <td><a href="mailto:<?= htmlspecialchars($r['email'] ?? '') ?>"><?= htmlspecialchars($r['email'] ?? '') ?></a></td>
            <td><?= htmlspecialchars($r['phone'] ?? '—') ?></td>
            <td><span class="acad-badge acad-badge--<?= htmlspecialchars($r['academy'] ?? '') ?>"><?= htmlspecialchars($labels[$r['academy'] ?? ''] ?? ucfirst($r['academy'] ?? '')) ?></span></td>
            <td><?= date('M j, Y', strtotime($r['created_at'] ?? 'now')) ?></td>
            <td>
                <div class="admin-table-actions">
                    <a href="<?= admin_url('academy-registrations/' . (int)($r['id'] ?? 0)) ?>" class="btn btn-sm btn-primary">View</a>
                    <a href="mailto:<?= htmlspecialchars($r['email'] ?? '') ?>?subject=<?= rawurlencode('Re: ' . ($labels[$r['academy'] ?? ''] ?? 'Academy Sign-Up')) ?>" class="btn btn-sm btn-outline">Contact</a>
                    <form method="post" action="<?= admin_url('academy-registrations/' . (int)($r['id'] ?? 0) . '/delete') ?>" onsubmit="return confirm('Delete this registration?');" style="margin:0;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($totalPages > 1): ?>
    <nav class="job-app-pagination" style="margin-top:1.5rem;" aria-label="Pagination">
        <div class="job-app-pagination-info">Showing <?= (($page - 1) * $perPage) + 1 ?>–<?= min($page * $perPage, $total) ?> of <?= $total ?></div>
        <ul class="job-app-pagination-links">
            <?php if ($page > 1): ?><li><a href="<?= admin_url('academy-registrations') ?><?= $buildQuery(['page' => $page - 1]) ?>" class="job-app-pagination-link">← Prev</a></li><?php endif; ?>
            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
            <li><?php if ($i === $page): ?><span class="job-app-pagination-current" aria-current="page"><?= $i ?></span><?php else: ?><a href="<?= admin_url('academy-registrations') ?><?= $buildQuery(['page' => $i]) ?>" class="job-app-pagination-link"><?= $i ?></a><?php endif; ?></li>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?><li><a href="<?= admin_url('academy-registrations') ?><?= $buildQuery(['page' => $page + 1]) ?>" class="job-app-pagination-link">Next →</a></li><?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
    <?php endif; ?>
</div>
