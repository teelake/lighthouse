<?php
$stats = $stats ?? [];
$upcomingEvents = $upcomingEvents ?? [];
$latestNewsletter = $latestNewsletter ?? [];
$latestJobApps = $latestJobApps ?? [];
$latestVisitors = $latestVisitors ?? [];
$latestPrayerRequests = $latestPrayerRequests ?? [];
$latestPrayerPosts = $latestPrayerPosts ?? [];
$prayerUsers = $prayerUsers ?? [];
$isEditor = $isEditor ?? false;
$isAdmin = $isAdmin ?? false;

function dash_time_ago($date) {
    if (empty($date)) return '';
    $ts = is_numeric($date) ? $date : strtotime($date);
    $diff = time() - $ts;
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . 'm ago';
    if ($diff < 86400) return floor($diff / 3600) . 'h ago';
    if ($diff < 604800) return floor($diff / 86400) . 'd ago';
    return date('M j', $ts);
}
?>
<div class="dash">
    <!-- KPI row - at a glance -->
    <div class="dash-kpi">
        <a href="<?= admin_url('events') ?>" class="dash-kpi-card">
            <span class="dash-kpi-value"><?= (int)($stats['events'] ?? 0) ?></span>
            <span class="dash-kpi-label">Events</span>
        </a>
        <a href="<?= admin_url('ministries') ?>" class="dash-kpi-card">
            <span class="dash-kpi-value"><?= (int)($stats['ministries'] ?? 0) ?></span>
            <span class="dash-kpi-label">Ministries</span>
        </a>
        <a href="<?= admin_url('media') ?>" class="dash-kpi-card">
            <span class="dash-kpi-value"><?= (int)($stats['media'] ?? 0) ?></span>
            <span class="dash-kpi-label">Media</span>
        </a>
        <?php if ($isAdmin): ?>
        <a href="<?= admin_url('prayer-wall') ?>" class="dash-kpi-card dash-kpi-accent">
            <span class="dash-kpi-value"><?= (int)($stats['prayer_requests'] ?? 0) + (int)($stats['prayer_wall'] ?? 0) ?></span>
            <span class="dash-kpi-label">Prayer</span>
        </a>
        <a href="<?= admin_url('job-applications') ?>" class="dash-kpi-card">
            <span class="dash-kpi-value"><?= (int)($stats['job_applications'] ?? 0) ?></span>
            <span class="dash-kpi-label">Applications</span>
        </a>
        <span class="dash-kpi-card">
            <span class="dash-kpi-value"><?= (int)($stats['newsletter'] ?? 0) ?></span>
            <span class="dash-kpi-label">Subscribers</span>
        </span>
        <?php endif; ?>
    </div>

    <div class="dash-layout">
        <div class="dash-main">
            <?php if ($isEditor): ?>
            <div class="dash-widget">
                <div class="dash-widget-head">
                    <h2 class="dash-widget-title">Quick Add</h2>
                </div>
                <div class="dash-quick-add">
                    <a href="<?= admin_url('events/create') ?>" class="dash-quick-btn">New Event</a>
                    <a href="<?= admin_url('testimonials/create') ?>" class="dash-quick-btn">New Testimonial</a>
                    <a href="<?= admin_url('ministries/create') ?>" class="dash-quick-btn">New Ministry</a>
                    <a href="<?= admin_url('leaders/create') ?>" class="dash-quick-btn">New Leader</a>
                    <a href="<?= admin_url('media/create') ?>" class="dash-quick-btn">New Media</a>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($isAdmin && (!empty($latestPrayerRequests) || !empty($latestPrayerPosts))): ?>
            <div class="dash-widget">
                <div class="dash-widget-head">
                    <h2 class="dash-widget-title">Prayer Wall</h2>
                    <a href="<?= admin_url('prayer-wall') ?>" class="dash-widget-link">Manage</a>
                </div>
                <div class="dash-prayer-grid">
                    <?php if (!empty($latestPrayerRequests)): ?>
                    <div class="dash-prayer-col">
                        <p class="dash-prayer-label">Recent Requests</p>
                        <ul class="dash-list">
                            <?php foreach ($latestPrayerRequests as $r): ?>
                            <li class="dash-list-item">
                                <span class="dash-list-main" title="<?= htmlspecialchars($r['request'] ?? '') ?>"><?= htmlspecialchars(($r['name'] ?? '') ?: 'Anonymous') ?></span>
                                <span class="dash-list-meta"><?= htmlspecialchars(dash_time_ago($r['created_at'] ?? '')) ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($latestPrayerPosts)): ?>
                    <div class="dash-prayer-col">
                        <p class="dash-prayer-label">Recent Posts</p>
                        <ul class="dash-list">
                            <?php foreach ($latestPrayerPosts as $p): ?>
                            <li class="dash-list-item">
                                <span class="dash-list-main" title="<?= htmlspecialchars($p['request'] ?? '') ?>"><?= ($p['is_anonymous'] ?? 0) ? 'Anonymous' : htmlspecialchars($prayerUsers[$p['user_id'] ?? 0] ?? '') ?></span>
                                <span class="dash-list-meta"><?= htmlspecialchars(dash_time_ago($p['created_at'] ?? '')) ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($isAdmin && !empty($latestNewsletter)): ?>
            <div class="dash-widget">
                <div class="dash-widget-head">
                    <h2 class="dash-widget-title">Latest Newsletter Signups</h2>
                </div>
                <ul class="dash-list">
                    <?php foreach ($latestNewsletter as $n): ?>
                    <li class="dash-list-item">
                        <span class="dash-list-main"><?= htmlspecialchars(trim(($n['first_name'] ?? '') . ' ' . ($n['last_name'] ?? '')) ?: $n['email']) ?></span>
                        <span class="dash-list-meta"><?= htmlspecialchars(dash_time_ago($n['subscribed_at'] ?? '')) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <?php if ($isAdmin && !empty($latestJobApps)): ?>
            <div class="dash-widget">
                <div class="dash-widget-head">
                    <h2 class="dash-widget-title">Recent Applications</h2>
                    <a href="<?= admin_url('job-applications') ?>" class="dash-widget-link">View all</a>
                </div>
                <ul class="dash-list">
                    <?php foreach ($latestJobApps as $a): ?>
                    <li class="dash-list-item">
                        <span class="dash-list-main"><?= htmlspecialchars($a['name'] ?? '') ?></span>
                        <span class="dash-list-meta"><?= htmlspecialchars(dash_time_ago($a['created_at'] ?? '')) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <?php if ($isAdmin && !empty($latestVisitors)): ?>
            <div class="dash-widget">
                <div class="dash-widget-head">
                    <h2 class="dash-widget-title">First-Time Visitors</h2>
                </div>
                <ul class="dash-list">
                    <?php foreach ($latestVisitors as $v): ?>
                    <li class="dash-list-item">
                        <span class="dash-list-main"><?= htmlspecialchars(trim(($v['first_name'] ?? '') . ' ' . ($v['last_name'] ?? ''))) ?></span>
                        <span class="dash-list-meta"><?= htmlspecialchars(dash_time_ago($v['created_at'] ?? '')) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <?php if (!$isEditor && (!$isAdmin || (empty($latestNewsletter) && empty($latestJobApps) && empty($latestVisitors) && empty($latestPrayerRequests) && empty($latestPrayerPosts))): ?>
            <div class="dash-widget dash-widget-empty">
                <p class="dash-empty-text">Dashboard overview. Use the sidebar to manage content.</p>
            </div>
            <?php endif; ?>
        </div>

        <aside class="dash-sidebar">
            <?php if (!empty($upcomingEvents)): ?>
            <div class="dash-widget">
                <div class="dash-widget-head">
                    <h2 class="dash-widget-title">Upcoming Events</h2>
                    <a href="<?= admin_url('events') ?>" class="dash-widget-link">All</a>
                </div>
                <ul class="dash-list dash-list-events">
                    <?php foreach ($upcomingEvents as $e): ?>
                    <li class="dash-list-item">
                        <a href="<?= admin_url('events/' . ($e['id'] ?? '') . '/edit') ?>" class="dash-list-link">
                            <span class="dash-list-main"><?= htmlspecialchars($e['title'] ?? '') ?></span>
                            <span class="dash-list-meta"><?= htmlspecialchars($e['event_date'] ?? '') ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </aside>
    </div>
</div>
