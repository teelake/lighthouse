<div class="admin-card">
    <h2>Content Sections</h2>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Edit homepage and page content blocks.</p>
    <table class="admin-table">
        <thead><tr><th>Key</th><th>Title</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($sections ?? [] as $s): ?>
        <tr>
            <td><code><?= htmlspecialchars($s['section_key']) ?></code></td>
            <td><?= htmlspecialchars($s['title'] ?? '') ?></td>
            <td><a href="<?= admin_url('sections/' . htmlspecialchars($s['section_key']) . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($sections)): ?><tr><td colspan="3">No sections configured.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
