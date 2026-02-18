<?php
$stats = isset($stats) ? $stats : [];
$upcomingEvents = isset($upcomingEvents) ? $upcomingEvents : [];
$latestNewsletter = isset($latestNewsletter) ? $latestNewsletter : [];
$latestJobApps = isset($latestJobApps) ? $latestJobApps : [];
$latestVisitors = isset($latestVisitors) ? $latestVisitors : [];
$latestPrayerRequests = isset($latestPrayerRequests) ? $latestPrayerRequests : [];
$latestPrayerPosts = isset($latestPrayerPosts) ? $latestPrayerPosts : [];
$prayerUsers = isset($prayerUsers) ? $prayerUsers : [];
$isEditor = isset($isEditor) ? $isEditor : false;
$isAdmin = isset($isAdmin) ? $isAdmin : false;

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
            <span class="dash-kpi-value"><?= (int)(isset($stats['events']) ? $stats['events'] : 0) ?></span>
            <span class="dash-kpi-label">Events</span>
        </a>
        <a href="<?= admin_url('ministries') ?>" class="dash-kpi-card">
            <span class="dash-kpi-value"><?= (int)(isset($stats['ministries']) ? $stats['ministries'] : 0) ?></span>
            <span class="dash-kpi-label">Ministries</span>
        </a>
        <a href="<?= admin_url('media') ?>" class="dash-kpi-card">
            <span class="dash-kpi-value"><?= (int)(isset($stats['media']) ? $stats['media'] : 0) ?></span>
            <span class="dash-kpi-label">Media</span>
        </a>
        <?php if ($isAdmin) { ?>
        <a href="<?= admin_url('prayer-wall') ?>" class="dash-kpi-card dash-kpi-accent">
            <span class="dash-kpi-value"><?= (int)(isset($stats['prayer_requests']) ? $stats['prayer_requests'] : 0) + (int)(isset($stats['prayer_wall']) ? $stats['prayer_wall'] : 0) ?></span>
            <span class="dash-kpi-label">Prayer</span>
        </a>
        <a href="<?= admin_url('job-applications') ?>" class="dash-kpi-card">
            <span class="dash-kpi-value"><?= (int)(isset($stats['job_applications']) ? $stats['job_applications'] : 0) ?></span>
            <span class="dash-kpi-label">Applications</span>
        </a>
        <span class="dash-kpi-card">
            <span class="dash-kpi-value"><?= (int)(isset($stats['newsletter']) ? $stats['newsletter'] : 0) ?></span>
            <span class="dash-kpi-label">Subscribers</span>
        </span>
        <?php } ?>
    </div>

    <div class="dash-layout">
        <div class="dash-main">
            <?php if ($isEditor) { ?>
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
            <?php } ?>

            <?php if ($isAdmin && (!empty($latestPrayerRequests) || !empty($latestPrayerPosts))) { ?>
            <div class="dash-widget">
                <div class="dash-widget-head">
                    <h2 class="dash-widget-title">Prayer Wall</h2>
                    <a href="<?= admin_url('prayer-wall') ?>" class="dash-widget-link">Manage</a>
                </div>
                <div class="dash-prayer-grid">
                    <?php if (!empty($latestPrayerRequests)) { ?>
                    <div class="dash-prayer-col">
                        <p class="dash-prayer-label">Recent Requests</p>
                        <ul class="dash-list">
                            <?php foreach ($latestPrayerRequests as $r) { ?>
                            <li class="dash-list-item">
                                <span class="dash-list-main" title="<?= htmlspecialchars(isset($r['request']) ? $r['request'] : '') ?>"><?= htmlspecialchars((isset($r['name']) && $r['name'] !== '') ? $r['name'] : 'Anonymous') ?></span>
                                <span class="dash-list-meta"><?= htmlspecialchars(dash_time_ago(isset($r['created_at']) ? $r['created_at'] : '')) ?></span>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php } ?>
                    <?php if (!empty($latestPrayerPosts)) { ?>
                    <div class="dash-prayer-col">
                        <p class="dash-prayer-label">Recent Posts</p>
                        <ul class="dash-list">
                            <?php foreach ($latestPrayerPosts as $p) {
                                $pid = isset($p['user_id']) ? $p['user_id'] : 0;
                                $pAuthor = (isset($p['is_anonymous']) && $p['is_anonymous']) ? 'Anonymous' : (isset($prayerUsers[$pid]) ? $prayerUsers[$pid] : '');
                            ?>
                            <li class="dash-list-item">
                                <span class="dash-list-main" title="<?= htmlspecialchars(isset($p['request']) ? $p['request'] : '') ?>"><?= htmlspecialchars($pAuthor) ?></span>
                                <span class="dash-list-meta"><?= htmlspecialchars(dash_time_ago(isset($p['created_at']) ? $p['created_at'] : '')) ?></span>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>

            <?php if ($isAdmin && !empty($latestNewsletter)) { ?>
            <div class="dash-widget">
                <div class="dash-widget-head">
                    <h2 class="dash-widget-title">Latest Newsletter Signups</h2>
                </div>
                <ul class="dash-list">
                    <?php foreach ($latestNewsletter as $n) {
                        $nName = trim((isset($n['first_name']) ? $n['first_name'] : '') . ' ' . (isset($n['last_name']) ? $n['last_name'] : ''));
                        $nDisplay = $nName !== '' ? $nName : (isset($n['email']) ? $n['email'] : '');
                    ?>
                    <li class="dash-list-item">
                        <span class="dash-list-main"><?= htmlspecialchars($nDisplay) ?></span>
                        <span class="dash-list-meta"><?= htmlspecialchars(dash_time_ago(isset($n['subscribed_at']) ? $n['subscribed_at'] : '')) ?></span>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>

            <?php if ($isAdmin && !empty($latestJobApps)) { ?>
            <div class="dash-widget">
                <div class="dash-widget-head">
                    <h2 class="dash-widget-title">Recent Applications</h2>
                    <a href="<?= admin_url('job-applications') ?>" class="dash-widget-link">View all</a>
                </div>
                <ul class="dash-list">
                    <?php foreach ($latestJobApps as $a) { ?>
                    <li class="dash-list-item">
                        <span class="dash-list-main"><?= htmlspecialchars(isset($a['name']) ? $a['name'] : '') ?></span>
                        <span class="dash-list-meta"><?= htmlspecialchars(dash_time_ago(isset($a['created_at']) ? $a['created_at'] : '')) ?></span>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>

            <?php if ($isAdmin && !empty($latestVisitors)) { ?>
            <div class="dash-widget">
                <div class="dash-widget-head">
                    <h2 class="dash-widget-title">First-Time Visitors</h2>
                </div>
                <ul class="dash-list">
                    <?php foreach ($latestVisitors as $v) {
                        $vName = trim((isset($v['first_name']) ? $v['first_name'] : '') . ' ' . (isset($v['last_name']) ? $v['last_name'] : ''));
                    ?>
                    <li class="dash-list-item">
                        <span class="dash-list-main"><?= htmlspecialchars($vName) ?></span>
                        <span class="dash-list-meta"><?= htmlspecialchars(dash_time_ago(isset($v['created_at']) ? $v['created_at'] : '')) ?></span>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>

            <?php
            $showEmpty = !$isEditor && (!$isAdmin || (empty($latestNewsletter) && empty($latestJobApps) && empty($latestVisitors) && empty($latestPrayerRequests) && empty($latestPrayerPosts)));
            if ($showEmpty) {
            ?>
            <div class="dash-widget dash-widget-empty">
                <p class="dash-empty-text">Dashboard overview. Use the sidebar to manage content.</p>
            </div>
            <?php } ?>
        </div>

        <aside class="dash-sidebar">
            <?php if (!empty($upcomingEvents)) { ?>
            <div class="dash-widget">
                <div class="dash-widget-head">
                    <h2 class="dash-widget-title">Upcoming Events</h2>
                    <a href="<?= admin_url('events') ?>" class="dash-widget-link">All</a>
                </div>
                <ul class="dash-list dash-list-events">
                    <?php foreach ($upcomingEvents as $e) { ?>
                    <li class="dash-list-item">
                        <a href="<?= admin_url('events/' . (isset($e['id']) ? $e['id'] : '') . '/edit') ?>" class="dash-list-link">
                            <span class="dash-list-main"><?= htmlspecialchars(isset($e['title']) ? $e['title'] : '') ?></span>
                            <span class="dash-list-meta"><?= htmlspecialchars(isset($e['event_date']) ? $e['event_date'] : '') ?></span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>
        </aside>
    </div>
</div>
