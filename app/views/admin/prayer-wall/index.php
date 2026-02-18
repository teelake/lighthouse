<?php
$requests = $requests ?? [];
$posts = $posts ?? [];
$users = $users ?? [];
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
                    <td><?php $txt = $r['request'] ?? ''; echo htmlspecialchars(mb_strlen($txt) > 80 ? mb_substr($txt, 0, 80) . '...' : $txt); ?></td>
                    <td>
                        <div class="admin-table-actions">
                            <form method="post" action="<?= admin_url('prayer-wall/requests/' . ($r['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this request?');">
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
                    <td><?php $txt = $p['request'] ?? ''; echo htmlspecialchars(mb_strlen($txt) > 80 ? mb_substr($txt, 0, 80) . '...' : $txt); ?></td>
                    <td>
                        <div class="admin-table-actions">
                            <form method="post" action="<?= admin_url('prayer-wall/posts/' . ($p['id'] ?? '') . '/delete') ?>" onsubmit="return confirm('Delete this post?');">
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
