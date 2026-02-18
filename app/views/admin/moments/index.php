<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Moments Carousel</h2>
        </div>
        <a href="<?= admin_url('moments/create') ?>" class="btn btn-primary">Add Slide</a>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Homepage Moments carousel. Each slide has a small and wide image.</p>
    <?php if (empty($moments ?? [])): ?>
    <p class="admin-empty">No slides yet. <a href="<?= admin_url('moments/create') ?>">Add one</a></p>
    <?php else: ?>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Small</th><th>Wide</th><th>Order</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($moments ?? [] as $m): ?>
        <tr>
            <td><img src="<?= htmlspecialchars($m['image_small'] ?? '') ?>" alt="" class="admin-thumb"></td>
            <td><img src="<?= htmlspecialchars($m['image_wide'] ?? '') ?>" alt="" class="admin-thumb"></td>
            <td><?= (int)($m['sort_order'] ?? 0) ?></td>
            <td>
                <div class="admin-table-actions">
                    <a href="<?= admin_url('moments/' . ($m['id'] ?? '') . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                    <form method="post" action="<?= admin_url('moments/' . ($m['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this slide?');">
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
