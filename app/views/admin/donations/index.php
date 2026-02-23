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
        <strong>Total received:</strong> $<?= number_format($totalAmount ?? 0, 2) ?> CAD
    </div>
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
        <?php if (empty($donations)): ?><tr><td colspan="5">No donations yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
