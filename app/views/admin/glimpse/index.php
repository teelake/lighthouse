<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Glimpse Section</h2>
        </div>
        <a href="<?= admin_url('glimpse/create') ?>" class="btn btn-primary">Add Slide</a>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Scrolling image cards on the homepage. Row 1 scrolls left, Row 2 scrolls right.</p>

    <h3 style="font-size: 0.9375rem; font-weight: 600; margin: 1.5rem 0 0.75rem; color: var(--adm-text-secondary);">Row 1 (top)</h3>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Image</th><th>Label</th><th>Order</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($row1 ?? [] as $s): ?>
        <tr>
            <td><img src="<?= htmlspecialchars($s['image_url'] ?? '') ?>" alt="" class="admin-thumb"></td>
            <td><?= htmlspecialchars($s['label'] ?? '') ?></td>
            <td><?= (int)($s['sort_order'] ?? 0) ?></td>
            <td>
                <div class="admin-table-actions">
                    <a href="<?= admin_url('glimpse/' . ($s['id'] ?? '') . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                    <form method="post" action="<?= admin_url('glimpse/' . ($s['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this slide?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($row1)): ?><tr><td colspan="4" class="admin-empty">No slides in row 1</td></tr><?php endif; ?>
        </tbody>
    </table>

    <h3 style="font-size: 0.9375rem; font-weight: 600; margin: 1.5rem 0 0.75rem; color: var(--adm-text-secondary);">Row 2 (bottom)</h3>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Image</th><th>Label</th><th>Order</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($row2 ?? [] as $s): ?>
        <tr>
            <td><img src="<?= htmlspecialchars($s['image_url'] ?? '') ?>" alt="" class="admin-thumb"></td>
            <td><?= htmlspecialchars($s['label'] ?? '') ?></td>
            <td><?= (int)($s['sort_order'] ?? 0) ?></td>
            <td>
                <div class="admin-table-actions">
                    <a href="<?= admin_url('glimpse/' . ($s['id'] ?? '') . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                    <form method="post" action="<?= admin_url('glimpse/' . ($s['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this slide?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($row2)): ?><tr><td colspan="4" class="admin-empty">No slides in row 2</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
