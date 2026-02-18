<?php
$adm = admin_url();
$role = $_SESSION['user_role'] ?? 'member';
$isAdmin = $role === 'admin';
$isEditor = in_array($role, ['editor', 'admin']);
$userName = $_SESSION['user_name'] ?? 'User';
$initials = trim(preg_replace('/[^A-Za-z]+/', ' ', $userName));
$initials = implode('', array_map(function($w) { return mb_substr($w, 0, 1); }, array_filter(explode(' ', $initials))));
$initials = mb_strtoupper(mb_substr($initials, 0, 2)) ?: 'U';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Dashboard') ?> - Lighthouse Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= rtrim(BASE_URL, '/') ?>/public/css/admin.css">
</head>
<body class="admin-body">
    <div class="sidebar-overlay" id="sidebar-overlay" aria-hidden="true"></div>
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
            <a href="<?= admin_url('prayer-wall') ?>" class="nav-item <?= ($currentPage ?? '') === 'prayer-wall' ? 'active' : '' ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><path d="M12 6v6"/><path d="M9 9h6"/></svg>
                Prayer Wall
            </a>
            <a href="<?= admin_url('users') ?>" class="nav-item <?= ($currentPage ?? '') === 'users' ? 'active' : '' ?>">Users</a>
            <?php endif; ?>
        </nav>
    </aside>
    <div class="admin-main">
        <header class="admin-header">
            <button class="sidebar-toggle" id="sidebar-toggle" type="button" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
            <h1 class="page-heading"><?= htmlspecialchars($pageHeading ?? $pageTitle ?? 'Dashboard') ?></h1>
            <div class="header-actions">
                <div class="profile-dropdown">
                    <button type="button" class="profile-trigger" id="profile-trigger" aria-expanded="false" aria-haspopup="true" aria-label="Account menu">
                        <span class="profile-avatar" aria-hidden="true"><?= htmlspecialchars($initials) ?></span>
                    </button>
                    <div class="profile-menu" id="profile-menu" role="menu" aria-hidden="true">
                        <a href="<?= rtrim(BASE_URL, '/') ?>/" target="_blank" role="menuitem">View Site</a>
                        <a href="<?= admin_url('profile') ?>" role="menuitem">Edit Profile</a>
                        <a href="<?= admin_url('profile') ?>#password" role="menuitem">Password Settings</a>
                        <a href="<?= admin_url('logout') ?>" role="menuitem" class="profile-menu-logout">Logout</a>
                    </div>
                </div>
            </div>
        </header>
        <main class="admin-content">
            <?= $content ?? '' ?>
        </main>
    </div>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="<?= rtrim(BASE_URL, '/') ?>/public/js/tinymce-init.js"></script>
    <script>
        (function() {
            var sidebar = document.getElementById('admin-sidebar');
            var overlay = document.getElementById('sidebar-overlay');
            var toggle = document.getElementById('sidebar-toggle');
            function open() { sidebar?.classList.add('open'); overlay?.classList.add('visible'); toggle?.classList.add('active'); }
            function close() { sidebar?.classList.remove('open'); overlay?.classList.remove('visible'); toggle?.classList.remove('active'); }
            toggle?.addEventListener('click', function() { sidebar?.classList.contains('open') ? close() : open(); });
            overlay?.addEventListener('click', close);
        })();
        (function() {
            var trigger = document.getElementById('profile-trigger');
            var menu = document.getElementById('profile-menu');
            if (!trigger || !menu) return;
            function open() { menu.setAttribute('aria-hidden', 'false'); trigger.setAttribute('aria-expanded', 'true'); menu.classList.add('open'); }
            function close() { menu.setAttribute('aria-hidden', 'true'); trigger.setAttribute('aria-expanded', 'false'); menu.classList.remove('open'); }
            trigger.addEventListener('click', function(e) { e.stopPropagation(); menu.classList.contains('open') ? close() : open(); });
            document.addEventListener('click', function() { close(); });
        })();
    </script>
</body>
</html>
