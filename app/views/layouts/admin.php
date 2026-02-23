<?php
$adm = admin_url();
$role = $_SESSION['user_role'] ?? 'member';
$isAdmin = $role === 'admin';
$isEditor = in_array($role, ['editor', 'admin']);
$userName = $_SESSION['user_name'] ?? 'User';
$initials = trim(preg_replace('/[^A-Za-z]+/', ' ', $userName));
$initials = implode('', array_map(function($w) { return mb_substr($w, 0, 1); }, array_filter(explode(' ', $initials))));
$initials = mb_strtoupper(mb_substr($initials, 0, 2)) ?: 'U';
$greeting = date('G') < 12 ? 'Good morning' : (date('G') < 17 ? 'Good afternoon' : 'Good evening');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? $pageHeading ?? 'Dashboard') ?> - Lighthouse Admin</title>
    <?php
    $faviconPath = file_exists(PUBLIC_PATH . '/images/lighthouse-logo.png') ? '/public/images/lighthouse-logo.png' : (file_exists(PUBLIC_PATH . '/images/logo.png') ? '/public/images/logo.png' : null);
    if ($faviconPath): ?>
    <link rel="icon" type="image/png" href="<?= rtrim(BASE_URL, '/') . $faviconPath ?>">
    <?php else: ?>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Cpath fill='%23b08d57' d='M16 4L4 12v12h24V12L16 4z'/%3E%3Cpath fill='none' stroke='%23b08d57' stroke-width='1.5' d='M16 12v12M4 12h24'/%3E%3C/svg%3E">
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= rtrim(BASE_URL, '/') ?>/public/css/admin.css">
</head>
<body class="admin-body">
    <div class="sidebar-overlay" id="sidebar-overlay" aria-hidden="true"></div>
    <aside class="admin-sidebar" id="admin-sidebar">
        <div class="sidebar-brand">
            <a href="<?= $adm ?>" class="sidebar-brand-link">
                <span class="sidebar-logo">
                    <?php
                    $logoPath = file_exists(PUBLIC_PATH . '/images/lighthouse-logo.png') ? '/public/images/lighthouse-logo.png' : (file_exists(PUBLIC_PATH . '/images/logo.png') ? '/public/images/logo.png' : null);
                    if ($logoPath): ?>
                    <img src="<?= rtrim(BASE_URL, '/') . $logoPath ?>" alt="Lighthouse" class="sidebar-logo-img">
                    <?php else: ?>
                    <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 4L4 12v12h24V12L16 4z"/><path d="M16 12v12"/><path d="M4 12h24"/></svg>
                    <?php endif; ?>
                </span>
                <span class="sidebar-brand-text">Lighthouse</span>
            </a>
            <button type="button" class="sidebar-pin" id="sidebar-pin" aria-label="Collapse sidebar" title="Collapse sidebar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= $adm ?>" class="nav-item <?= ($currentPage ?? '') === 'dashboard' ? 'active' : '' ?>" data-tooltip="Dashboard">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
                <span class="nav-text">Dashboard</span>
            </a>
            <?php if ($role === 'member'): ?>
            <a href="<?= rtrim(BASE_URL, '/') ?>/members/prayer-wall" class="nav-item" data-tooltip="Prayer Wall">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><path d="M12 6v6"/><path d="M9 9h6"/></svg>
                <span class="nav-text">Prayer Wall</span>
            </a>
            <?php endif; ?>
            <?php if ($isEditor): ?>
            <div class="nav-collapse" data-group="content">
                <button type="button" class="nav-collapse-trigger" aria-expanded="true" aria-controls="nav-content">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                    <span class="nav-group">Content</span>
                    <svg class="nav-collapse-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <div class="nav-collapse-panel" id="nav-content">
                    <a href="<?= admin_url('sections') ?>" class="nav-item <?= ($currentPage ?? '') === 'sections' ? 'active' : '' ?>" data-tooltip="Sections"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg><span class="nav-text">Sections</span></a>
                    <a href="<?= admin_url('glimpse') ?>" class="nav-item <?= ($currentPage ?? '') === 'glimpse' ? 'active' : '' ?>" data-tooltip="Glimpse"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg><span class="nav-text">Glimpse</span></a>
                    <a href="<?= admin_url('moments') ?>" class="nav-item <?= ($currentPage ?? '') === 'moments' ? 'active' : '' ?>" data-tooltip="Moments"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg><span class="nav-text">Moments</span></a>
                    <a href="<?= admin_url('leaders') ?>" class="nav-item <?= ($currentPage ?? '') === 'leaders' ? 'active' : '' ?>" data-tooltip="Leadership"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg><span class="nav-text">Leadership</span></a>
                    <a href="<?= admin_url('faqs') ?>" class="nav-item <?= ($currentPage ?? '') === 'faqs' ? 'active' : '' ?>" data-tooltip="FAQs"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg><span class="nav-text">FAQs</span></a>
                    <a href="<?= admin_url('testimonials') ?>" class="nav-item <?= ($currentPage ?? '') === 'testimonials' ? 'active' : '' ?>" data-tooltip="Testimonials"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg><span class="nav-text">Testimonials</span></a>
                    <a href="<?= admin_url('events') ?>" class="nav-item <?= ($currentPage ?? '') === 'events' ? 'active' : '' ?>" data-tooltip="Events"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg><span class="nav-text">Events</span></a>
                    <a href="<?= admin_url('ministries') ?>" class="nav-item <?= ($currentPage ?? '') === 'ministries' ? 'active' : '' ?>" data-tooltip="Ministries"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/></svg><span class="nav-text">Ministries</span></a>
                    <a href="<?= admin_url('small-groups') ?>" class="nav-item <?= ($currentPage ?? '') === 'small-groups' ? 'active' : '' ?>" data-tooltip="Small Groups"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg><span class="nav-text">Small Groups</span></a>
                    <a href="<?= admin_url('media') ?>" class="nav-item <?= ($currentPage ?? '') === 'media' ? 'active' : '' ?>" data-tooltip="Media"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg><span class="nav-text">Media</span></a>
                    <a href="<?= admin_url('jobs') ?>" class="nav-item <?= ($currentPage ?? '') === 'jobs' ? 'active' : '' ?>" data-tooltip="Jobs"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg><span class="nav-text">Jobs</span></a>
                    <a href="<?= admin_url('visitors') ?>" class="nav-item <?= ($currentPage ?? '') === 'visitors' ? 'active' : '' ?>" data-tooltip="First-Time Visitors"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M20 8v6"/><path d="M23 11h-6"/></svg><span class="nav-text">Visitors</span></a>
                </div>
            </div>
            <?php endif; ?>
            <?php if ($isAdmin): ?>
            <div class="nav-collapse" data-group="system">
                <button type="button" class="nav-collapse-trigger" aria-expanded="true" aria-controls="nav-system">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    <span class="nav-group">System</span>
                    <svg class="nav-collapse-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <div class="nav-collapse-panel" id="nav-system">
                    <a href="<?= admin_url('subscribers') ?>" class="nav-item <?= ($currentPage ?? '') === 'subscribers' ? 'active' : '' ?>" data-tooltip="Subscribers"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg><span class="nav-text">Subscribers</span></a>
                    <a href="<?= admin_url('contact-report') ?>" class="nav-item <?= ($currentPage ?? '') === 'contact-report' ? 'active' : '' ?>" data-tooltip="Contact Report"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg><span class="nav-text">Contact Report</span></a>
                    <a href="<?= admin_url('prayer-wall') ?>" class="nav-item <?= ($currentPage ?? '') === 'prayer-wall' ? 'active' : '' ?>" data-tooltip="Prayer Wall">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><path d="M12 6v6"/><path d="M9 9h6"/></svg>
                        <span class="nav-text">Prayer Wall</span>
                    </a>
                    <a href="<?= admin_url('donations') ?>" class="nav-item <?= ($currentPage ?? '') === 'donations' ? 'active' : '' ?>" data-tooltip="Donations">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        <span class="nav-text">Donations</span>
                    </a>
                    <a href="<?= admin_url('users') ?>" class="nav-item <?= ($currentPage ?? '') === 'users' ? 'active' : '' ?>" data-tooltip="Users"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg><span class="nav-text">Users</span></a>
                    <a href="<?= admin_url('settings') ?>" class="nav-item <?= ($currentPage ?? '') === 'settings' ? 'active' : '' ?>" data-tooltip="Settings"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg><span class="nav-text">Settings</span></a>
                </div>
            </div>
            <?php endif; ?>
        </nav>
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <span class="sidebar-user-avatar"><?= htmlspecialchars($initials) ?></span>
                <span class="sidebar-user-info">
                    <span class="sidebar-user-name"><?= htmlspecialchars($userName) ?></span>
                    <span class="sidebar-user-role"><?= htmlspecialchars(ucfirst($role)) ?></span>
                </span>
            </div>
        </div>
    </aside>
    <div class="admin-main">
        <header class="admin-header">
            <button class="sidebar-toggle" id="sidebar-toggle" type="button" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
            <div class="header-welcome">
                <?php if (($currentPage ?? '') === 'dashboard'): ?>
                <h1 class="page-heading"><?= htmlspecialchars($greeting) ?>, <?= htmlspecialchars(explode(' ', $userName)[0] ?? $userName) ?></h1>
                <p class="page-subheading">Here's what's happening at Lighthouse</p>
                <?php else: ?>
                <h1 class="page-heading"><?= htmlspecialchars($pageHeading ?? $pageTitle ?? 'Dashboard') ?></h1>
                <?php endif; ?>
            </div>
            <div class="header-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="search" placeholder="Search..." aria-label="Search" class="header-search-input">
            </div>
            <div class="header-actions">
                <a href="<?= rtrim(BASE_URL, '/') ?>/" target="_blank" class="header-action-btn" title="View site">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                </a>
                <div class="profile-dropdown">
                    <button type="button" class="profile-trigger" id="profile-trigger" aria-expanded="false" aria-haspopup="true" aria-label="Account menu">
                        <span class="profile-avatar"><?= htmlspecialchars($initials) ?></span>
                    </button>
                    <div class="profile-menu" id="profile-menu" role="menu" aria-hidden="true">
                        <div class="profile-menu-header">
                            <span class="profile-menu-name"><?= htmlspecialchars($userName) ?></span>
                            <span class="profile-menu-role"><?= htmlspecialchars(ucfirst($role)) ?></span>
                        </div>
                        <a href="<?= admin_url('profile') ?>" role="menuitem">Edit Profile</a>
                        <a href="<?= admin_url('profile') ?>#password" role="menuitem">Password</a>
                        <a href="<?= rtrim(BASE_URL, '/') ?>/" target="_blank" role="menuitem">View Site</a>
                        <a href="<?= admin_url('logout') ?>" role="menuitem" class="profile-menu-logout">Logout</a>
                    </div>
                </div>
            </div>
        </header>
        <main class="admin-content">
            <?= $content ?? '' ?>
        </main>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.min.js"></script>
    <script src="<?= rtrim(BASE_URL, '/') ?>/public/js/quill-init.js"></script>
    <script>
        (function() {
            var sidebar = document.getElementById('admin-sidebar');
            var overlay = document.getElementById('sidebar-overlay');
            var toggle = document.getElementById('sidebar-toggle');
            var pin = document.getElementById('sidebar-pin');
            var STORAGE = 'adm_sidebar_slim';
            function open() { sidebar?.classList.remove('slim'); sidebar?.classList.add('open'); overlay?.classList.add('visible'); toggle?.classList.add('active'); localStorage.removeItem(STORAGE); }
            function close() { sidebar?.classList.remove('open'); overlay?.classList.remove('visible'); toggle?.classList.remove('active'); }
            function toggleSlim() {
                if (sidebar?.classList.contains('slim')) {
                    sidebar.classList.remove('slim');
                    document.body.classList.remove('admin-sidebar-slim');
                    localStorage.removeItem(STORAGE);
                } else {
                    sidebar?.classList.add('slim');
                    document.body.classList.add('admin-sidebar-slim');
                    localStorage.setItem(STORAGE, '1');
                }
            }
            toggle?.addEventListener('click', function() { sidebar?.classList.contains('open') ? close() : open(); });
            overlay?.addEventListener('click', close);
            pin?.addEventListener('click', toggleSlim);
            if (sidebar && localStorage.getItem(STORAGE) === '1') { sidebar.classList.add('slim'); document.body.classList.add('admin-sidebar-slim'); }
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
        (function() {
            var STORAGE = 'adm_nav_collapsed';
            document.querySelectorAll('.nav-collapse').forEach(function(block) {
                var btn = block.querySelector('.nav-collapse-trigger');
                var panel = block.querySelector('.nav-collapse-panel');
                var group = block.getAttribute('data-group');
                var key = STORAGE + '_' + group;
                var collapsed = localStorage.getItem(key) === '1';
                function setExpanded(exp) {
                    btn.setAttribute('aria-expanded', exp ? 'true' : 'false');
                    panel.classList.toggle('collapsed', !exp);
                    block.classList.toggle('collapsed', !exp);
                    localStorage.setItem(key, exp ? '0' : '1');
                }
                if (collapsed) setExpanded(false);
                btn.addEventListener('click', function() { setExpanded(panel.classList.contains('collapsed')); });
            });
        })();
    </script>
</body>
</html>
