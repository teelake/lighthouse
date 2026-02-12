<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($pageDescription ?? 'Lighthouse Global Church - A Christ-centered, Spirit-empowered ministry equipping believers for life, leadership, and global impact.') ?>">
    <title><?= htmlspecialchars($pageTitle ?? 'Lighthouse Global Church') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Open+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= rtrim(BASE_URL, '/') ?>/public/css/style.css">
</head>
<body>
    <!-- Social sidebar - Believers House style -->
    <aside class="social-sidebar" aria-label="Social media">
        <a href="https://facebook.com" target="_blank" rel="noopener" aria-label="Facebook"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
        <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
        <a href="https://youtube.com" target="_blank" rel="noopener" aria-label="YouTube"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
        <a href="https://twitter.com" target="_blank" rel="noopener" aria-label="Twitter"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
    </aside>
    <header class="site-header">
        <div class="header-inner">
            <a href="<?= rtrim(BASE_URL, '/') ?>/" class="logo">
                <?php
                $logoPath = file_exists(PUBLIC_PATH . '/images/lighthouse-logo.png') ? '/public/images/lighthouse-logo.png' : (file_exists(PUBLIC_PATH . '/images/logo.png') ? '/public/images/logo.png' : null);
                if ($logoPath): ?>
                <img src="<?= rtrim(BASE_URL, '/') . $logoPath ?>" alt="Lighthouse Global Church">
                <?php else: ?>
                <span class="logo-text">LIGHTHOUSE GLOBAL CHURCH</span>
                <?php endif; ?>
            </a>
            <button class="nav-toggle" aria-label="Menu" type="button">
                <span></span><span></span><span></span>
            </button>
            <nav class="main-nav">
                <ul>
                    <li><a href="<?= rtrim(BASE_URL, '/') ?>/">Home</a></li>
                    <li><a href="<?= rtrim(BASE_URL, '/') ?>/services">Services</a></li>
                    <li><a href="<?= rtrim(BASE_URL, '/') ?>/events">Events</a></li>
                    <li class="give-cta"><a href="<?= rtrim(BASE_URL, '/') ?>/giving" class="btn-give">Give</a></li>
                    <li class="has-dropdown">
                        <a href="<?= rtrim(BASE_URL, '/') ?>/im-new">Connect</a>
                        <ul class="dropdown">
                            <li><a href="<?= rtrim(BASE_URL, '/') ?>/im-new">I'm New</a></li>
                            <li><a href="<?= rtrim(BASE_URL, '/') ?>/ministries">Ministries</a></li>
                            <li><a href="<?= rtrim(BASE_URL, '/') ?>/small-groups">Small Groups</a></li>
                        </ul>
                    </li>
                    <li><a href="<?= rtrim(BASE_URL, '/') ?>/media">Media</a></li>
                    <li class="has-dropdown">
                        <a href="<?= rtrim(BASE_URL, '/') ?>/about">About</a>
                        <ul class="dropdown">
                            <li><a href="<?= rtrim(BASE_URL, '/') ?>/about">About Us</a></li>
                            <li><a href="<?= rtrim(BASE_URL, '/') ?>/leadership">Leadership</a></li>
                            <li><a href="<?= rtrim(BASE_URL, '/') ?>/contact">Contact</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="main-content">
        <?php echo $content ?? ''; ?>
    </main>
    <footer class="site-footer bh-footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <a href="<?= rtrim(BASE_URL, '/') ?>/" class="logo">
                    <?php
                    $logoPath = file_exists(PUBLIC_PATH . '/images/lighthouse-logo.png') ? '/public/images/lighthouse-logo.png' : (file_exists(PUBLIC_PATH . '/images/logo.png') ? '/public/images/logo.png' : null);
                    if ($logoPath): ?>
                    <img src="<?= rtrim(BASE_URL, '/') . $logoPath ?>" alt="Lighthouse Global Church">
                    <?php else: ?>
                    <span class="logo-text">LIGHTHOUSE GLOBAL CHURCH</span>
                    <?php endif; ?>
                </a>
                <p class="footer-tagline"><?= htmlspecialchars($footerCta ?? 'Join us. Grow with us. Shine with us.', ENT_QUOTES, 'UTF-8') ?></p>
                <p class="copyright">&copy; <?= date('Y') ?> Lighthouse Global Church</p>
            </div>
            <div class="footer-nav">
                <div class="footer-col">
                    <h4>TERMS & POLICY</h4>
                    <a href="<?= rtrim(BASE_URL, '/') ?>/contact">Privacy</a>
                    <a href="<?= rtrim(BASE_URL, '/') ?>/contact">Terms</a>
                </div>
                <div class="footer-col">
                    <h4>MINISTRIES</h4>
                    <a href="<?= rtrim(BASE_URL, '/') ?>/ministries">Ministries</a>
                    <a href="<?= rtrim(BASE_URL, '/') ?>/small-groups">Small Groups</a>
                </div>
                <div class="footer-col">
                    <h4>NEW VISITORS</h4>
                    <a href="<?= rtrim(BASE_URL, '/') ?>/im-new">I'm New</a>
                    <a href="<?= rtrim(BASE_URL, '/') ?>/services">Services</a>
                </div>
                <div class="footer-col">
                    <h4>ABOUT</h4>
                    <a href="<?= rtrim(BASE_URL, '/') ?>/about">About Us</a>
                    <a href="<?= rtrim(BASE_URL, '/') ?>/leadership">Leadership</a>
                </div>
            </div>
            <div class="footer-cta-buttons">
                <a href="<?= rtrim(BASE_URL, '/') ?>/giving" class="btn btn-watch">GIVE NOW</a>
                <a href="<?= rtrim(BASE_URL, '/') ?>/contact" class="btn btn-accent">CONTACT US</a>
                <a href="<?= rtrim(BASE_URL, '/') ?>/contact" class="btn btn-accent">GET DIRECTIONS</a>
            </div>
        </div>
    </footer>
    <script src="<?= rtrim(BASE_URL, '/') ?>/public/js/main.js"></script>
</body>
</html>
