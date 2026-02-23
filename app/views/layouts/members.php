<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($pageDescription ?? 'Member Portal - Lighthouse Global Church') ?>">
    <title><?= htmlspecialchars($pageTitle ?? 'Member Portal') ?> - Lighthouse Global Church</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= rtrim(BASE_URL, '/') ?>/public/css/style.css">
</head>
<body class="members-portal">
    <a href="#main-content" class="skip-link">Skip to main content</a>
    <header class="site-header" id="site-header">
        <div class="header-inner">
            <a href="<?= rtrim(BASE_URL, '/') ?>/" class="logo">
                <?php
                $logoPath = file_exists(PUBLIC_PATH . '/images/lighthouse-logo.png') ? '/public/images/lighthouse-logo.png' : (file_exists(PUBLIC_PATH . '/images/logo.png') ? '/public/images/logo.png' : null);
                if ($logoPath): ?>
                <img class="logo-img" src="<?= rtrim(BASE_URL, '/') . $logoPath ?>" alt="Lighthouse Global Church">
                <?php else: ?>
                <span class="logo-text">LIGHTHOUSE GLOBAL CHURCH</span>
                <?php endif; ?>
            </a>
            <nav class="main-nav">
                <ul>
                    <li><a href="<?= rtrim(BASE_URL, '/') ?>/">Home</a></li>
                    <li><a href="<?= rtrim(BASE_URL, '/') ?>/members/prayer-wall" class="active">Prayer Wall</a></li>
                    <li><a href="<?= function_exists('admin_url') ? admin_url() : rtrim(BASE_URL, '/') . '/admin' ?>">Dashboard</a></li>
                    <li><a href="<?= function_exists('admin_url') ? admin_url('logout') : rtrim(BASE_URL, '/') . '/admin/logout' ?>">Sign out</a></li>
                </ul>
            </nav>
        </div>
        <div class="member-portal-banner">
            <span>Member Portal</span> — A digital space for church members
        </div>
    </header>
    <main class="main-content" id="main-content">
        <?= $content ?? '' ?>
    </main>
    <footer class="site-footer" style="margin-top: 4rem;">
        <div class="footer-inner">
            <p>&copy; <?= date('Y') ?> Lighthouse Global Church. All rights reserved.</p>
        </div>
    </footer>
    <script src="<?= rtrim(BASE_URL, '/') ?>/public/js/main.js"></script>
</body>
</html>
