<?php
$events = $events ?? [];
?>
<div class="admin-card">
    <h2>Welcome back</h2>
    <p style="color: var(--adm-muted); margin: 0 0 1.5rem;">Manage your church website content from here.</p>
    <div class="admin-grid">
        <a href="<?= admin_url('sections') ?>" class="admin-grid-card">
            <h3>Content Sections</h3>
            <small>Hero, Gather, Scripture, Prayer Wall, Newsletter</small>
        </a>
        <a href="<?= admin_url('glimpse') ?>" class="admin-grid-card">
            <h3>Glimpse</h3>
            <small>Homepage scrolling images</small>
        </a>
        <a href="<?= admin_url('moments') ?>" class="admin-grid-card">
            <h3>Moments</h3>
            <small>Homepage carousel slides</small>
        </a>
        <a href="<?= admin_url('leaders') ?>" class="admin-grid-card">
            <h3>Leadership</h3>
            <small>Team profiles</small>
        </a>
        <a href="<?= admin_url('testimonials') ?>" class="admin-grid-card">
            <h3>Testimonials</h3>
            <small>Voice section quotes</small>
        </a>
        <a href="<?= admin_url('events') ?>" class="admin-grid-card">
            <h3>Events</h3>
            <small>Upcoming events</small>
        </a>
        <a href="<?= admin_url('ministries') ?>" class="admin-grid-card">
            <h3>Ministries</h3>
            <small>Ministry listings</small>
        </a>
        <a href="<?= admin_url('small-groups') ?>" class="admin-grid-card">
            <h3>Small Groups</h3>
            <small>Community groups</small>
        </a>
        <a href="<?= admin_url('media') ?>" class="admin-grid-card">
            <h3>Media</h3>
            <small>Sermons & teachings</small>
        </a>
        <a href="<?= admin_url('jobs') ?>" class="admin-grid-card">
            <h3>Jobs</h3>
            <small>Job listings</small>
        </a>
        <?php if (($isAdmin ?? false)): ?>
        <a href="<?= admin_url('users') ?>" class="admin-grid-card">
            <h3>Users</h3>
            <small>User management</small>
        </a>
        <a href="<?= admin_url('settings') ?>" class="admin-grid-card">
            <h3>Settings</h3>
            <small>General, Homepage, Payment</small>
        </a>
        <?php endif; ?>
    </div>
</div>
<?php if (!empty($events)): ?>
<div class="admin-card">
    <h2>Upcoming Events</h2>
    <table class="admin-table">
        <thead><tr><th>Event</th><th>Date</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($events as $e): ?>
        <tr>
            <td><?= htmlspecialchars($e['title']) ?></td>
            <td><?= htmlspecialchars($e['event_date'] ?? '') ?></td>
            <td><a href="<?= admin_url('events/' . $e['id'] . '/edit') ?>" class="btn btn-sm btn-outline">Edit</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
