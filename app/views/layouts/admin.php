<?php
$adm = admin_url();
$role = $_SESSION['user_role'] ?? 'member';
$isAdmin = $role === 'admin';
$isEditor = in_array($role, ['editor', 'admin']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Dashboard') ?> - Lighthouse Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= rtrim(BASE_URL, '/') ?>/public/css/admin.css">
</head>
<body class="admin-body">
    <aside class="admin-sidebar" id="admin-sidebar">
        <div class="sidebar-brand">
            <a href="<?= $adm ?>">LIGHTHOUSE</a>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= $adm ?>" class="nav-item <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
                Dashboard
            </a>
            <?php if ($isEditor): ?>
            <div class="nav-group">Content</div>
            <a href="<?= admin_url('sections') ?>" class="nav-item <?= ($currentPage ?? '') === 'sections' ? 'active' : '' ?>">Sections</a>
            <a href="<?= admin_url('glimpse') ?>" class="nav-item <?= ($currentPage ?? '') === 'glimpse' ? 'active' : '' ?>">Glimpse</a>
            <a href="<?= admin_url('moments') ?>" class="nav-item <?= ($currentPage ?? '') === 'moments' ? 'active' : '' ?>">Moments</a>
            <a href="<?= admin_url('leaders') ?>" class="nav-item <?= ($currentPage ?? '') === 'leaders' ? 'active' : '' ?>">Leadership</a>
            <a href="<?= admin_url('testimonials') ?>" class="nav-item <?= ($currentPage ?? '') === 'testimonials' ? 'active' : '' ?>">Testimonials</a>
            <a href="<?= admin_url('events') ?>" class="nav-item <?= ($currentPage ?? '') === 'events' ? 'active' : '' ?>">Events</a>
            <a href="<?= admin_url('ministries') ?>" class="nav-item <?= ($currentPage ?? '') === 'ministries' ? 'active' : '' ?>">Ministries</a>
            <a href="<?= admin_url('small-groups') ?>" class="nav-item <?= ($currentPage ?? '') === 'small-groups' ? 'active' : '' ?>">Small Groups</a>
            <a href="<?= admin_url('media') ?>" class="nav-item <?= ($currentPage ?? '') === 'media' ? 'active' : '' ?>">Media</a>
            <a href="<?= admin_url('jobs') ?>" class="nav-item <?= ($currentPage ?? '') === 'jobs' ? 'active' : '' ?>">Jobs</a>
            <?php endif; ?>
            <?php if ($isAdmin): ?>
            <div class="nav-group">System</div>
            <a href="<?= admin_url('users') ?>" class="nav-item <?= ($currentPage ?? '') === 'users' ? 'active' : '' ?>">Users</a>
            <a href="<?= admin_url('settings') ?>" class="nav-item <?= ($currentPage ?? '') === 'settings' ? 'active' : '' ?>">Settings</a>
            <?php endif; ?>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= admin_url('profile') ?>" class="nav-item">Profile</a>
            <a href="<?= rtrim(BASE_URL, '/') ?>/" target="_blank" class="nav-item">View Site</a>
            <a href="<?= admin_url('logout') ?>" class="nav-item logout">Logout</a>
        </div>
    </aside>
    <div class="admin-main">
        <header class="admin-header">
            <button class="sidebar-toggle" id="sidebar-toggle" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
            <h1 class="page-heading"><?= htmlspecialchars($pageHeading ?? $pageTitle ?? 'Dashboard') ?></h1>
            <div class="header-actions">
                <span class="user-badge"><?= htmlspecialchars($_SESSION['user_name'] ?? '') ?> · <?= htmlspecialchars($role) ?></span>
            </div>
        </header>
        <main class="admin-content">
            <?= $content ?? '' ?>
        </main>
    </div>
    <script>
        document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
            document.getElementById('admin-sidebar').classList.toggle('open');
        });
    </script>
</body>
</html>
