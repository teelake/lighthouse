<?php
$adm = admin_url();
$role = $_SESSION['user_role'] ?? 'member';
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= rtrim(BASE_URL, '/') ?>/public/css/admin.css">
</head>
<body class="admin-body admin-no-sidebar">
    <div class="admin-main">
        <header class="admin-header">
            <a href="<?= $adm ?>" class="header-logo">LIGHTHOUSE</a>
            <h1 class="page-heading"><?= htmlspecialchars($pageHeading ?? $pageTitle ?? 'Dashboard') ?></h1>
            <div class="header-actions">
                <a href="<?= rtrim(BASE_URL, '/') ?>/" target="_blank" class="header-link" title="View site">View Site</a>
                <div class="profile-dropdown">
                    <button type="button" class="profile-trigger" id="profile-trigger" aria-expanded="false" aria-haspopup="true" aria-label="Account menu">
                        <span class="profile-avatar" aria-hidden="true"><?= htmlspecialchars($initials) ?></span>
                    </button>
                    <div class="profile-menu" id="profile-menu" role="menu" aria-hidden="true">
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
    <script>
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
