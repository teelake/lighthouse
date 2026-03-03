<?php
$requests = $requests ?? [];
$posts = $posts ?? [];
$users = $users ?? [];
$showArchived = $showArchived ?? false;
$isAdmin = ($_SESSION['user_role'] ?? '') === 'admin';
$isEditor = in_array($_SESSION['user_role'] ?? '', ['editor', 'admin']);
$page = (int)($page ?? 1);
$totalPages = (int)($totalPages ?? 1);
$total = (int)($total ?? 0);
$perPage = (int)($perPage ?? 15);
$buildQuery = function ($overrides = []) {
    $q = array_merge($_GET, $overrides);
    $q = array_filter($q);
    return $q ? '?' . http_build_query($q) : '';
};
$baseUrl = rtrim(BASE_URL ?? '', '/');
?>
<div class="admin-card">
    <h2>Prayer Requests</h2>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Form submissions from the prayer page.</p>
    <?php if (empty($requests)): ?>
        <p style="color: var(--adm-muted);">No prayer requests yet.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr><th>Date</th><th>Name</th><th>Request</th><th>Action</th></tr>
            </thead>
            <tbody>
            <?php foreach ($requests as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['created_at'] ?? '') ?></td>
                    <td><?= htmlspecialchars(($r['name'] ?? '') ?: 'Anonymous') ?></td>
                    <td>
                        <a href="<?= admin_url('prayer-wall/requests/' . ($r['id'] ?? '')) ?>" class="admin-table-link"><?php $txt = $r['request'] ?? ''; echo htmlspecialchars(mb_strlen($txt) > 80 ? mb_substr($txt, 0, 80) . '...' : $txt); ?></a>
                    </td>
                    <td>
                        <div class="admin-table-actions">
                            <a href="<?= admin_url('prayer-wall/requests/' . ($r['id'] ?? '')) ?>" class="btn btn-sm btn-outline">View</a>
                            <?php if ($isAdmin): ?>
                            <form method="post" action="<?= admin_url('prayer-wall/requests/' . ($r['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this request?');">
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
    <?php endif; ?>
</div>

<div class="admin-card">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
        <div>
            <h2>Prayer Wall</h2>
            <p style="color: var(--adm-muted); margin: 0;"><?= $showArchived ? 'Archived posts' : 'Active posts' ?> · <a href="<?= $baseUrl ?>/prayer" target="_blank" rel="noopener">View on site →</a></p>
        </div>
        <a href="<?= admin_url('prayer-wall') ?><?= $showArchived ? '' : '?archived=1' ?>" class="btn btn-outline btn-sm"><?= $showArchived ? 'View active' : 'View archived' ?></a>
    </div>
    <?php if (empty($posts)): ?>
        <p style="color: var(--adm-muted);">No prayer wall posts yet.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr><th>Date</th><th>Author</th><th>Post</th><th>Action</th></tr>
            </thead>
            <tbody>
            <?php foreach ($posts as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['created_at'] ?? '') ?></td>
                    <td><?= ($p['is_anonymous'] ?? 0) ? 'Anonymous' : htmlspecialchars(trim($p['author_name'] ?? '') ?: ($users[$p['user_id'] ?? 0] ?? 'Guest')) ?></td>
                    <td>
                        <span style="color: var(--adm-text);"><?php $txt = strip_tags($p['request'] ?? ''); echo htmlspecialchars(mb_strlen($txt) > 50 ? mb_substr($txt, 0, 50) . '...' : $txt); ?></span>
                    </td>
                    <td>
                        <div class="admin-table-actions" style="flex-wrap: wrap; gap: 0.35rem;">
                            <a href="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '')) ?>" class="btn btn-sm btn-outline">View</a>
                            <?php if ($isEditor): ?>
                            <?php if ($p['is_archived'] ?? 0): ?>
                            <form method="post" action="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '') . '/unarchive') ?>" style="display:inline;">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-outline">Unarchive</button>
                            </form>
                            <?php else: ?>
                            <form method="post" action="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '') . '/archive') ?>" onsubmit="return confirm('Archive this prayer? It will be hidden from the public wall.');" style="display:inline;">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-outline">Archive</button>
                            </form>
                            <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($isAdmin): ?>
                            <form method="post" action="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this post?');" style="display:inline;">
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
                <?php if ($page > 1): ?><li><a href="<?= admin_url('prayer-wall') ?><?= $buildQuery(['page' => $page - 1]) ?>" class="job-app-pagination-link">← Prev</a></li><?php endif; ?>
                <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <li><?php if ($i === $page): ?><span class="job-app-pagination-current" aria-current="page"><?= $i ?></span><?php else: ?><a href="<?= admin_url('prayer-wall') ?><?= $buildQuery(['page' => $i]) ?>" class="job-app-pagination-link"><?= $i ?></a><?php endif; ?></li>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?><li><a href="<?= admin_url('prayer-wall') ?><?= $buildQuery(['page' => $page + 1]) ?>" class="job-app-pagination-link">Next →</a></li><?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>
