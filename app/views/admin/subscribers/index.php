<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Newsletter Subscribers</h2>
        </div>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">People who have signed up for the church newsletter.</p>
    <?php if (empty($subscribers ?? [])): ?>
    <p class="admin-empty">No subscribers yet.</p>
    <?php else: ?>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Name</th><th>Email</th><th>Subscribed</th></tr></thead>
        <tbody>
        <?php foreach ($subscribers ?? [] as $s):
            $name = trim(($s['first_name'] ?? '') . ' ' . ($s['last_name'] ?? ''));
            $name = $name !== '' ? $name : '—';
        ?>
        <tr>
            <td><?= htmlspecialchars($name) ?></td>
            <td><a href="mailto:<?= htmlspecialchars($s['email'] ?? '') ?>"><?= htmlspecialchars($s['email'] ?? '') ?></a></td>
            <td><?= htmlspecialchars($s['subscribed_at'] ?? '') ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
