<?php
$stats = $stats ?? [];
$events = $events ?? [];
$isEditor = in_array($_SESSION['user_role'] ?? '', ['editor', 'admin']);
$isAdmin = $isAdmin ?? false;
?>
<!-- Analytics overview -->
<div class="dash-hero">
    <h1 class="dash-greeting">Welcome back</h1>
    <p class="dash-sub">Your content at a glance</p>
</div>

<div class="stats-grid">
    <a href="<?= admin_url('events') ?>" class="stat-card">
        <span class="stat-icon stat-events"><?= svg_icon('calendar') ?></span>
        <span class="stat-value"><?= (int)($stats['events'] ?? 0) ?></span>
        <span class="stat-label">Events</span>
    </a>
    <a href="<?= admin_url('ministries') ?>" class="stat-card">
        <span class="stat-icon stat-ministries"><?= svg_icon('heart') ?></span>
        <span class="stat-value"><?= (int)($stats['ministries'] ?? 0) ?></span>
        <span class="stat-label">Ministries</span>
    </a>
    <a href="<?= admin_url('leaders') ?>" class="stat-card">
        <span class="stat-icon stat-leaders"><?= svg_icon('users') ?></span>
        <span class="stat-value"><?= (int)($stats['leaders'] ?? 0) ?></span>
        <span class="stat-label">Leaders</span>
    </a>
    <a href="<?= admin_url('media') ?>" class="stat-card">
        <span class="stat-icon stat-media"><?= svg_icon('play') ?></span>
        <span class="stat-value"><?= (int)($stats['media'] ?? 0) ?></span>
        <span class="stat-label">Media</span>
    </a>
    <?php if ($isAdmin): ?>
    <a href="<?= admin_url('job-applications') ?>" class="stat-card stat-highlight">
        <span class="stat-icon stat-apps"><?= svg_icon('briefcase') ?></span>
        <span class="stat-value"><?= (int)($stats['job_applications'] ?? 0) ?></span>
        <span class="stat-label">Applications</span>
    </a>
    <span class="stat-card">
        <span class="stat-icon stat-newsletter"><?= svg_icon('mail') ?></span>
        <span class="stat-value"><?= (int)($stats['newsletter'] ?? 0) ?></span>
        <span class="stat-label">Subscribers</span>
    </span>
    <?php endif; ?>
</div>

<!-- Quick links -->
<div class="admin-card dash-card">
    <h2 class="card-title">Quick Links</h2>
    <div class="admin-grid dash-grid">
        <a href="<?= admin_url('sections') ?>" class="admin-grid-card">
            <span class="grid-icon"><?= svg_icon('file-text') ?></span>
            <h3>Content Sections</h3>
            <small>Hero, Gather, Scripture, Newsletter</small>
        </a>
        <a href="<?= admin_url('glimpse') ?>" class="admin-grid-card">
            <span class="grid-icon"><?= svg_icon('image') ?></span>
            <h3>Glimpse</h3>
            <small>Homepage scrolling images</small>
        </a>
        <a href="<?= admin_url('moments') ?>" class="admin-grid-card">
            <span class="grid-icon"><?= svg_icon('layers') ?></span>
            <h3>Moments</h3>
            <small>Homepage carousel</small>
        </a>
        <a href="<?= admin_url('leaders') ?>" class="admin-grid-card">
            <span class="grid-icon"><?= svg_icon('users') ?></span>
            <h3>Leadership</h3>
            <small>Team profiles</small>
        </a>
        <a href="<?= admin_url('testimonials') ?>" class="admin-grid-card">
            <span class="grid-icon"><?= svg_icon('message-circle') ?></span>
            <h3>Testimonials</h3>
            <small>Voice section quotes</small>
        </a>
        <a href="<?= admin_url('events') ?>" class="admin-grid-card">
            <span class="grid-icon"><?= svg_icon('calendar') ?></span>
            <h3>Events</h3>
            <small>Upcoming events</small>
        </a>
        <a href="<?= admin_url('ministries') ?>" class="admin-grid-card">
            <span class="grid-icon"><?= svg_icon('heart') ?></span>
            <h3>Ministries</h3>
            <small>Ministry listings</small>
        </a>
        <a href="<?= admin_url('small-groups') ?>" class="admin-grid-card">
            <span class="grid-icon"><?= svg_icon('users') ?></span>
            <h3>Small Groups</h3>
            <small>Community groups</small>
        </a>
        <a href="<?= admin_url('media') ?>" class="admin-grid-card">
            <span class="grid-icon"><?= svg_icon('play') ?></span>
            <h3>Media</h3>
            <small>Sermons & teachings</small>
        </a>
        <a href="<?= admin_url('jobs') ?>" class="admin-grid-card">
            <span class="grid-icon"><?= svg_icon('briefcase') ?></span>
            <h3>Jobs</h3>
            <small>Job listings</small>
        </a>
        <?php if ($isAdmin): ?>
        <a href="<?= admin_url('users') ?>" class="admin-grid-card">
            <span class="grid-icon"><?= svg_icon('user-check') ?></span>
            <h3>Users</h3>
            <small>User management</small>
        </a>
        <a href="<?= admin_url('settings') ?>" class="admin-grid-card">
            <span class="grid-icon"><?= svg_icon('settings') ?></span>
            <h3>Settings</h3>
            <small>General, Homepage</small>
        </a>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($events)): ?>
<div class="admin-card dash-card">
    <h2 class="card-title">Upcoming Events</h2>
    <div class="events-list">
        <?php foreach ($events as $e): ?>
        <a href="<?= admin_url('events/' . ($e['id'] ?? '') . '/edit') ?>" class="event-row">
            <span class="event-title"><?= htmlspecialchars($e['title'] ?? '') ?></span>
            <span class="event-date"><?= htmlspecialchars($e['event_date'] ?? '') ?></span>
            <span class="event-arrow">→</span>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
