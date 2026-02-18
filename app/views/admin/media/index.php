<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Media</h2>
        </div>
        <a href="<?= admin_url('media/create') ?>" class="btn btn-primary">Add Media</a>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Sermons, teachings, and media content.</p>
    <?php if (empty($media ?? [])): ?>
    <p class="admin-empty">No media yet. <a href="<?= admin_url('media/create') ?>">Add one</a></p>
    <?php else: ?>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Title</th><th>Type</th><th>Date</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($media ?? [] as $m): ?>
        <tr>
            <td><?= htmlspecialchars($m['title'] ?? '') ?></td>
            <td><span class="admin-badge"><?= htmlspecialchars($m['media_type'] ?? '—') ?></span></td>
            <td><?= htmlspecialchars($m['published_at'] ?? '—') ?></td>
            <td>
                <div class="admin-table-actions">
                    <a href="<?= admin_url('media/' . ($m['id'] ?? '') . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                    <form method="post" action="<?= admin_url('media/' . ($m['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this media?');">
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
