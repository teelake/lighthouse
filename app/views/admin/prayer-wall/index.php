<?php
$requests = $requests ?? [];
$posts = $posts ?? [];
$users = $users ?? [];
$isAdmin = ($_SESSION['user_role'] ?? '') === 'admin';
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
    <h2>Prayer Wall Posts</h2>
    <p style="color: var(--adm-muted); margin: 0 0 1rem;">Member posts on the Prayer Wall.</p>
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
                    <td><?= ($p['is_anonymous'] ?? 0) ? 'Anonymous' : htmlspecialchars($users[$p['user_id'] ?? 0] ?? 'Unknown') ?></td>
                    <td>
                        <a href="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '')) ?>" class="admin-table-link"><?php $txt = $p['request'] ?? ''; echo htmlspecialchars(mb_strlen($txt) > 80 ? mb_substr($txt, 0, 80) . '...' : $txt); ?></a>
                    </td>
                    <td>
                        <div class="admin-table-actions">
                            <a href="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '')) ?>" class="btn btn-sm btn-outline">View</a>
                            <?php if ($isAdmin): ?>
                            <form method="post" action="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this post?');">
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
