<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Contact Report</h2>
        </div>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Messages submitted from the public contact page.</p>
    <?php if (empty($submissions ?? [])): ?>
    <p class="admin-empty">No contact submissions yet.</p>
    <?php else: ?>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Date</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th></tr></thead>
        <tbody>
        <?php foreach ($submissions ?? [] as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['created_at'] ?? '') ?></td>
            <td><?= htmlspecialchars($s['name'] ?? '') ?></td>
            <td><a href="mailto:<?= htmlspecialchars($s['email'] ?? '') ?>"><?= htmlspecialchars($s['email'] ?? '') ?></a></td>
            <td><?= htmlspecialchars($s['subject'] ?? '') ?></td>
            <td style="max-width: 240px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($s['message'] ?? '') ?>"><?= htmlspecialchars(mb_substr($s['message'] ?? '', 0, 80)) ?><?= mb_strlen($s['message'] ?? '') > 80 ? '…' : '' ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
