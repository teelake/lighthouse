<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>FAQs</h2>
        </div>
        <a href="<?= admin_url('faqs/create') ?>" class="btn btn-primary">Add FAQ</a>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Manage frequently asked questions shown on the FAQ page and About page.</p>
    <?php if (empty($faqs ?? [])): ?>
    <p class="admin-empty">No FAQs yet. <a href="<?= admin_url('faqs/create') ?>">Add one</a></p>
    <?php else: ?>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Question</th><th>Sort</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($faqs ?? [] as $f): ?>
        <tr>
            <td><?= htmlspecialchars(mb_strimwidth($f['question'] ?? '', 0, 70, '…')) ?></td>
            <td><?= (int)($f['sort_order'] ?? 0) ?></td>
            <td>
                <div class="admin-table-actions">
                    <a href="<?= admin_url('faqs/' . ($f['id'] ?? '') . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                    <form method="post" action="<?= admin_url('faqs/' . ($f['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this FAQ?');">
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
