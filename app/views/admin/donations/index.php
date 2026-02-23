<?php
$filters = $filters ?? [];
$page = (int) ($page ?? 1);
$totalPages = (int) ($totalPages ?? 1);
$total = (int) ($total ?? 0);
$perPage = (int) ($perPage ?? 20);
$designations = $designations ?? [];
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
            <h2>Donations (Stripe)</h2>
        </div>
        <a href="<?= admin_url('settings/payment') ?>" class="btn btn-outline">Payment Settings</a>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Stripe donations received. Configure Stripe in <a href="<?= admin_url('settings/payment') ?>">Payment Settings</a>.</p>
    <div style="background: var(--adm-bg); padding: 1rem 1.25rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem;">
        <strong>Total received<?= !empty(array_filter($filters)) ? ' (filtered)' : '' ?>:</strong> $<?= number_format($totalAmount ?? 0, 2) ?> CAD
    </div>

    <form method="get" action="<?= admin_url('donations') ?>" class="job-app-filters">
        <div class="job-app-filters-row">
            <div class="job-app-filter">
                <label for="filter-date-from">From date</label>
                <input type="date" id="filter-date-from" name="date_from" value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>">
            </div>
            <div class="job-app-filter">
                <label for="filter-date-to">To date</label>
                <input type="date" id="filter-date-to" name="date_to" value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>">
            </div>
            <div class="job-app-filter">
                <label for="filter-designation">Designation</label>
                <select id="filter-designation" name="designation">
                    <option value="">All designations</option>
                    <?php foreach ($designations as $val => $label): ?>
                    <option value="<?= htmlspecialchars($val) ?>" <?= ($filters['designation'] ?? '') === $val ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="job-app-filter job-app-filter-search">
                <label for="filter-search">Search</label>
                <input type="search" id="filter-search" name="search" placeholder="Donor, email, purpose…" value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
            </div>
            <div class="job-app-filter-actions">
                <button type="submit" class="btn btn-primary">Apply filters</button>
                <a href="<?= admin_url('donations') ?>" class="btn btn-outline">Clear</a>
            </div>
        </div>
    </form>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Designation</th>
                <th>Donor</th>
                <th>Purpose</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($donations ?? [] as $d): ?>
        <tr>
            <td><?= date('M j, Y', strtotime($d['created_at'] ?? 'now')) ?></td>
            <td>$<?= number_format(($d['amount_cents'] ?? 0) / 100, 2) ?> <?= strtoupper($d['currency'] ?? 'cad') ?></td>
            <td><?= htmlspecialchars($d['designation'] ?? '—') ?></td>
            <td>
                <?php if (!empty($d['donor_name']) || !empty($d['donor_email'])): ?>
                <?= htmlspecialchars($d['donor_name'] ?? '') ?><?= ($d['donor_name'] && $d['donor_email']) ? ' · ' : '' ?><?= !empty($d['donor_email']) ? '<a href="mailto:' . htmlspecialchars($d['donor_email']) . '">' . htmlspecialchars($d['donor_email']) . '</a>' : '' ?>
                <?php else: ?>
                <span style="color: var(--adm-muted);">Anonymous</span>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($d['purpose'] ?? '—') ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($donations)): ?><tr><td colspan="5"><?= !empty(array_filter($filters)) ? 'No donations match your filters.' : 'No donations yet.' ?></td></tr><?php endif; ?>
        </tbody>
    </table>

    <?php if ($totalPages > 1): ?>
    <nav class="job-app-pagination" aria-label="Pagination">
        <div class="job-app-pagination-info">
            Showing <?= (($page - 1) * $perPage) + 1 ?>–<?= min($page * $perPage, $total) ?> of <?= $total ?>
        </div>
        <ul class="job-app-pagination-links">
            <?php if ($page > 1): ?>
            <li><a href="<?= admin_url('donations') ?><?= $buildQuery(['page' => $page - 1]) ?>" class="job-app-pagination-link" aria-label="Previous page">← Prev</a></li>
            <?php endif; ?>
            <?php
            $start = max(1, $page - 2);
            $end = min($totalPages, $page + 2);
            ?>
            <?php if ($start > 1): ?>
            <li><a href="<?= admin_url('donations') ?><?= $buildQuery(['page' => 1]) ?>" class="job-app-pagination-link">1</a></li>
            <?php if ($start > 2): ?><li><span class="job-app-pagination-ellipsis">…</span></li><?php endif; ?>
            <?php endif; ?>
            <?php for ($i = $start; $i <= $end; $i++): ?>
            <li>
                <?php if ($i === $page): ?>
                <span class="job-app-pagination-current" aria-current="page"><?= $i ?></span>
                <?php else: ?>
                <a href="<?= admin_url('donations') ?><?= $buildQuery(['page' => $i]) ?>" class="job-app-pagination-link"><?= $i ?></a>
                <?php endif; ?>
            </li>
            <?php endfor; ?>
            <?php if ($end < $totalPages): ?>
            <?php if ($end < $totalPages - 1): ?><li><span class="job-app-pagination-ellipsis">…</span></li><?php endif; ?>
            <li><a href="<?= admin_url('donations') ?><?= $buildQuery(['page' => $totalPages]) ?>" class="job-app-pagination-link"><?= $totalPages ?></a></li>
            <?php endif; ?>
            <?php if ($page < $totalPages): ?>
            <li><a href="<?= admin_url('donations') ?><?= $buildQuery(['page' => $page + 1]) ?>" class="job-app-pagination-link" aria-label="Next page">Next →</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>
