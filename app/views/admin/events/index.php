<div class="admin-card">
    <div class="admin-page-header">
        <div>
            <a href="<?= admin_url() ?>" class="admin-back-link">← Dashboard</a>
            <h2>Events</h2>
        </div>
        <a href="<?= admin_url('events/create') ?>" class="btn btn-primary">Add Event</a>
    </div>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Manage church events and activities.</p>
    <?php if (empty($events ?? [])): ?>
    <p class="admin-empty">No events yet. <a href="<?= admin_url('events/create') ?>">Add one</a></p>
    <?php else: ?>
    <table class="admin-table admin-table-striped">
        <thead><tr><th>Title</th><th>Date</th><th>Location</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($events ?? [] as $e): ?>
        <tr>
            <td><?= htmlspecialchars($e['title'] ?? '') ?></td>
            <td><?= htmlspecialchars($e['event_date'] ?? '') ?></td>
            <td><?= htmlspecialchars($e['location'] ?? '—') ?></td>
            <td>
                <div class="admin-table-actions">
                    <a href="<?= admin_url('events/' . ($e['id'] ?? '') . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                    <form method="post" action="<?= admin_url('events/' . ($e['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this event?');">
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
