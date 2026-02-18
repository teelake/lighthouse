<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Testimonials</h2>
        </div>
        <a href="<?= admin_url('testimonials/create') ?>" class="btn btn-primary">Add Testimonial</a>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">The first published testimonial appears on the homepage (Voice section).</p>
    <?php if (empty($testimonials ?? [])): ?>
    <p class="admin-empty">No testimonials yet. <a href="<?= admin_url('testimonials/create') ?>">Add one</a></p>
    <?php else: ?>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Quote</th><th>Author</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($testimonials ?? [] as $t): ?>
        <tr>
            <td><?= htmlspecialchars(mb_strimwidth($t['quote'] ?? '', 0, 60, '…')) ?></td>
            <td><?= htmlspecialchars($t['author_name'] ?? '') ?></td>
            <td><?= !empty($t['is_published']) ? '<span class="admin-badge admin-badge-success">Published</span>' : '<span class="admin-badge">Draft</span>' ?></td>
            <td>
                <div class="admin-table-actions">
                    <a href="<?= admin_url('testimonials/' . ($t['id'] ?? '') . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                    <form method="post" action="<?= admin_url('testimonials/' . ($t['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this testimonial?');">
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
