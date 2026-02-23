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
$isMember = isset($role) && $role === 'member';
$chartMonths = isset($chartMonths) ? $chartMonths : [];
$chartSubscribers = isset($chartSubscribers) ? $chartSubscribers : [];
$chartApplications = isset($chartApplications) ? $chartApplications : [];
$chartVisitors = isset($chartVisitors) ? $chartVisitors : [];

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
    <!-- Welcome hero (dashboard only) -->
    <div class="dash-hero">
        <div class="dash-hero-content">
            <div class="dash-hero-icon">
                <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M24 8L8 16v16h32V16L24 8z"/><path d="M24 16v16"/><path d="M8 16h32"/></svg>
            </div>
            <div>
                <h2 class="dash-hero-title">Lighthouse Admin</h2>
                <p class="dash-hero-desc">Manage your church content, events, and community from one place.</p>
            </div>
        </div>
    </div>

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
        <?php if ($isMember) { ?>
        <a href="<?= admin_url('prayer-wall') ?>" class="dash-kpi-card dash-kpi-accent">
            <span class="dash-kpi-value"><?= (int)(isset($stats['prayer_wall']) ? $stats['prayer_wall'] : 0) ?></span>
            <span class="dash-kpi-label">Prayer Wall</span>
        </a>
        <?php } ?>
        <?php if ($isAdmin) { ?>
        <a href="<?= admin_url('prayer-wall') ?>" class="dash-kpi-card dash-kpi-accent">
            <span class="dash-kpi-value"><?= (int)(isset($stats['prayer_requests']) ? $stats['prayer_requests'] : 0) + (int)(isset($stats['prayer_wall']) ? $stats['prayer_wall'] : 0) ?></span>
            <span class="dash-kpi-label">Prayer</span>
        </a>
        <a href="<?= admin_url('job-applications') ?>" class="dash-kpi-card">
            <span class="dash-kpi-value"><?= (int)(isset($stats['job_applications']) ? $stats['job_applications'] : 0) ?></span>
            <span class="dash-kpi-label">Applications</span>
        </a>
        <a href="<?= admin_url('subscribers') ?>" class="dash-kpi-card">
            <span class="dash-kpi-value"><?= (int)(isset($stats['newsletter']) ? $stats['newsletter'] : 0) ?></span>
            <span class="dash-kpi-label">Subscribers</span>
        </a>
        <a href="<?= admin_url('visitors') ?>" class="dash-kpi-card">
            <span class="dash-kpi-value"><?= (int)(isset($stats['visitors']) ? $stats['visitors'] : 0) ?></span>
            <span class="dash-kpi-label">Visitors</span>
        </a>
        <a href="<?= admin_url('donations') ?>" class="dash-kpi-card">
            <span class="dash-kpi-value">$<?= number_format($stats['donations_total'] ?? 0, 0) ?></span>
            <span class="dash-kpi-label">Donations</span>
        </a>
        <?php } ?>
    </div>

    <!-- Charts -->
    <div class="dash-charts">
        <?php if ($isAdmin && !empty($chartMonths)) { ?>
        <div class="dash-widget dash-chart-widget">
            <div class="dash-widget-head">
                <h2 class="dash-widget-title">Activity (Last 6 Months)</h2>
            </div>
            <div class="dash-chart-container">
                <canvas id="dash-activity-chart" height="220"></canvas>
            </div>
        </div>
        <?php } ?>
        <?php if ($isEditor) { ?>
        <div class="dash-widget dash-chart-widget">
            <div class="dash-widget-head">
                <h2 class="dash-widget-title">Content Overview</h2>
            </div>
            <div class="dash-chart-container dash-chart-doughnut">
                <canvas id="dash-content-chart" height="220"></canvas>
            </div>
        </div>
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
                    <a href="<?= admin_url('faqs/create') ?>" class="dash-quick-btn">New FAQ</a>
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
                    <h2 class="dash-widget-title">Latest Subscribers</h2>
                </div>
                <div class="dash-table-wrap">
                    <table class="admin-table admin-table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestNewsletter as $n) {
                                $nName = trim((isset($n['first_name']) ? $n['first_name'] : '') . ' ' . (isset($n['last_name']) ? $n['last_name'] : ''));
                                $nDisplay = $nName !== '' ? $nName : '—';
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($nDisplay) ?></td>
                                <td><a href="mailto:<?= htmlspecialchars($n['email'] ?? '') ?>"><?= htmlspecialchars($n['email'] ?? '') ?></a></td>
                                <td><?= htmlspecialchars(dash_time_ago($n['subscribed_at'] ?? '')) ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>

            <?php if ($isAdmin && !empty($latestJobApps)) { ?>
            <div class="dash-widget">
                <div class="dash-widget-head">
                    <h2 class="dash-widget-title">Latest Job Applications</h2>
                    <a href="<?= admin_url('job-applications') ?>" class="dash-widget-link">View all</a>
                </div>
                <div class="dash-table-wrap">
                    <table class="admin-table admin-table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestJobApps as $a) { ?>
                            <tr>
                                <td><?= htmlspecialchars($a['name'] ?? '') ?></td>
                                <td><?= htmlspecialchars($a['job_title'] ?? '—') ?></td>
                                <td><?= htmlspecialchars(dash_time_ago($a['created_at'] ?? '')) ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>

            <?php if ($isAdmin) { ?>
            <div class="dash-widget">
                <div class="dash-widget-head">
                    <h2 class="dash-widget-title">First-Time Visitors</h2>
                    <a href="<?= admin_url('visitors') ?>" class="dash-widget-link">Manage</a>
                </div>
                <div class="dash-table-wrap">
                    <table class="admin-table admin-table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($latestVisitors)): ?>
                            <tr><td colspan="3" class="admin-empty">No visitors yet. <a href="<?= admin_url('visitors/create') ?>">Add one</a></td></tr>
                            <?php else: foreach ($latestVisitors as $v) {
                                $vName = trim(($v['first_name'] ?? '') . ' ' . ($v['last_name'] ?? ''));
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($vName) ?></td>
                                <td><a href="mailto:<?= htmlspecialchars($v['email'] ?? '') ?>"><?= htmlspecialchars($v['email'] ?? '') ?></a></td>
                                <td><?= htmlspecialchars(dash_time_ago($v['created_at'] ?? '')) ?></td>
                            </tr>
                            <?php } endif; ?>
                        </tbody>
                    </table>
                </div>
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

<?php if ($isEditor || ($isAdmin && !empty($chartMonths))) { ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function() {
    var Chart = typeof window.Chart !== 'undefined' ? window.Chart : null;
    if (!Chart) return;

    Chart.defaults.font.family = "'DM Sans', -apple-system, sans-serif";
    Chart.defaults.color = '#64748b';

    <?php if ($isAdmin && !empty($chartMonths)) { ?>
    var activityCtx = document.getElementById('dash-activity-chart');
    if (activityCtx) {
        new Chart(activityCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($chartMonths) ?>,
                datasets: [
                    { label: 'Subscribers', data: <?= json_encode($chartSubscribers) ?>, backgroundColor: 'rgba(184,141,87,0.7)', borderColor: '#b08d57', borderWidth: 1 },
                    { label: 'Applications', data: <?= json_encode($chartApplications) ?>, backgroundColor: 'rgba(30,64,175,0.7)', borderColor: '#1e40af', borderWidth: 1 },
                    { label: 'Visitors', data: <?= json_encode($chartVisitors) ?>, backgroundColor: 'rgba(22,163,74,0.7)', borderColor: '#16a34a', borderWidth: 1 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } }
                }
            }
        });
    }
    <?php } ?>

    <?php if ($isEditor) { ?>
    var contentCtx = document.getElementById('dash-content-chart');
    if (contentCtx) {
        new Chart(contentCtx, {
            type: 'doughnut',
            data: {
                labels: ['Events', 'Ministries', 'Media'],
                datasets: [{
                    data: [<?= (int)($stats['events'] ?? 0) ?>, <?= (int)($stats['ministries'] ?? 0) ?>, <?= (int)($stats['media'] ?? 0) ?>],
                    backgroundColor: ['#b08d57', '#1e40af', '#16a34a'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }
    <?php } ?>
})();
</script>
<?php } ?>
