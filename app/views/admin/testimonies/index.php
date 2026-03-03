<?php
$items = $items ?? [];
$showArchived = $showArchived ?? false;
$isAdmin = ($_SESSION['user_role'] ?? '') === 'admin';
$isEditor = in_array($_SESSION['user_role'] ?? '', ['editor', 'admin']);
$page = (int)($page ?? 1);
$totalPages = (int)($totalPages ?? 1);
$total = (int)($total ?? 0);
$perPage = (int)($perPage ?? 15);
$baseUrl = $baseUrl ?? rtrim(BASE_URL ?? '', '/');
$buildQuery = function ($overrides = []) {
    $q = array_merge($_GET, $overrides);
    $q = array_filter($q);
    return $q ? '?' . http_build_query($q) : '';
};
?>
<div class="admin-card">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
        <div>
            <h2>Online Testimonies</h2>
            <p style="color: var(--adm-muted); margin: 0;"><?= $showArchived ? 'Archived' : 'Published' ?> · <a href="<?= $baseUrl ?>/testimonies" target="_blank" rel="noopener">View on site →</a></p>
        </div>
        <a href="<?= admin_url('testimonies') ?><?= $showArchived ? '' : '?archived=1' ?>" class="btn btn-outline btn-sm"><?= $showArchived ? 'View published' : 'View archived' ?></a>
    </div>
    <?php if (empty($items)): ?>
        <p style="color: var(--adm-muted);">No testimonies yet.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr><th>Date</th><th>Author</th><th>Testimony</th><th>Action</th></tr>
            </thead>
            <tbody>
            <?php foreach ($items as $t): ?>
                <tr>
                    <td><?= htmlspecialchars($t['created_at'] ?? '') ?></td>
                    <td><?= ($t['is_anonymous'] ?? 0) ? 'Anonymous' : htmlspecialchars(trim($t['author_name'] ?? '') ?: '—') ?></td>
                    <td>
                        <span style="color: var(--adm-text);"><?php $txt = strip_tags($t['content'] ?? ''); echo htmlspecialchars(mb_strlen($txt) > 50 ? mb_substr($txt, 0, 50) . '...' : $txt); ?></span>
                    </td>
                    <td>
                        <div class="admin-table-actions" style="flex-wrap: wrap; gap: 0.35rem;">
                            <a href="<?= admin_url('testimonies/' . ($t['id'] ?? '')) ?>" class="btn btn-sm btn-outline">View</a>
                            <a href="<?= admin_url('testimonies/' . ($t['id'] ?? '') . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a>
                            <?php if ($isEditor): ?>
                            <?php if ($t['is_archived'] ?? 0): ?>
                            <form method="post" action="<?= admin_url('testimonies/' . ($t['id'] ?? '') . '/unarchive') ?>" style="display:inline;">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-outline">Unarchive</button>
                            </form>
                            <?php else: ?>
                            <form method="post" action="<?= admin_url('testimonies/' . ($t['id'] ?? '') . '/archive') ?>" onsubmit="return confirm('Archive this testimony? It will be hidden from the public page.');" style="display:inline;">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-outline">Archive</button>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($isAdmin): ?>
                            <form method="post" action="<?= admin_url('testimonies/' . ($t['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this testimony?');" style="display:inline;">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php if ($totalPages > 1): ?>
        <nav class="job-app-pagination" style="margin-top: 1.5rem;" aria-label="Pagination">
            <div class="job-app-pagination-info">Showing <?= (($page - 1) * $perPage) + 1 ?>–<?= min($page * $perPage, $total) ?> of <?= $total ?></div>
            <ul class="job-app-pagination-links">
                <?php if ($page > 1): ?><li><a href="<?= admin_url('testimonies') ?><?= $buildQuery(['page' => $page - 1]) ?>" class="job-app-pagination-link">← Prev</a></li><?php endif; ?>
                <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <li><?php if ($i === $page): ?><span class="job-app-pagination-current" aria-current="page"><?= $i ?></span><?php else: ?><a href="<?= admin_url('testimonies') ?><?= $buildQuery(['page' => $i]) ?>" class="job-app-pagination-link"><?= $i ?></a><?php endif; ?></li>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?><li><a href="<?= admin_url('testimonies') ?><?= $buildQuery(['page' => $page + 1]) ?>" class="job-app-pagination-link">Next →</a></li><?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>
