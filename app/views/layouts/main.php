<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($pageDescription ?? 'Lighthouse Global Church - A Christ-centered, Spirit-empowered ministry equipping believers for life, leadership, and global impact.') ?>">
    <title><?= htmlspecialchars($pageTitle ?? 'Lighthouse Global Church') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= rtrim(BASE_URL, '/') ?>/public/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="<?= rtrim(BASE_URL, '/') ?>/" class="logo">
                <?php if (file_exists(PUBLIC_PATH . '/images/logo.png')): ?>
                <img src="<?= rtrim(BASE_URL, '/') ?>/public/images/logo.png" alt="Lighthouse Global Church">
                <?php else: ?>
                <span style="font-size: 1.5rem; font-weight: 700; color: var(--color-primary);">LIGHTHOUSE GLOBAL CHURCH</span>
                <?php endif; ?>
            </a>
            <button class="nav-toggle" aria-label="Menu" type="button">
                <span></span><span></span><span></span>
            </button>
            <nav class="main-nav">
                <ul>
                    <li><a href="<?= rtrim(BASE_URL, '/') ?>/">Home</a></li>
                    <li class="has-dropdown">
                        <a href="<?= rtrim(BASE_URL, '/') ?>/about">About</a>
                        <ul class="dropdown">
                            <li><a href="<?= rtrim(BASE_URL, '/') ?>/about">About Us</a></li>
                            <li><a href="<?= rtrim(BASE_URL, '/') ?>/leadership">Leadership</a></li>
                            <li><a href="<?= rtrim(BASE_URL, '/') ?>/faq">FAQ</a></li>
                        </ul>
                    </li>
                    <li class="has-dropdown">
                        <a href="<?= rtrim(BASE_URL, '/') ?>/im-new">Connect</a>
                        <ul class="dropdown">
                            <li><a href="<?= rtrim(BASE_URL, '/') ?>/im-new">I'm New</a></li>
                            <li><a href="<?= rtrim(BASE_URL, '/') ?>/ministries">Ministries</a></li>
                            <li><a href="<?= rtrim(BASE_URL, '/') ?>/small-groups">Small Groups</a></li>
                            <li><a href="<?= rtrim(BASE_URL, '/') ?>/membership">Membership</a></li>
                        </ul>
                    </li>
                    <li class="has-dropdown">
                        <a href="<?= rtrim(BASE_URL, '/') ?>/services">Services & Events</a>
                        <ul class="dropdown">
                            <li><a href="<?= rtrim(BASE_URL, '/') ?>/services">Our Gatherings</a></li>
                            <li><a href="<?= rtrim(BASE_URL, '/') ?>/events">Events</a></li>
                        </ul>
                    </li>
                    <li><a href="<?= rtrim(BASE_URL, '/') ?>/media">Media</a></li>
                    <li><a href="<?= rtrim(BASE_URL, '/') ?>/prayer">Prayer</a></li>
                    <li><a href="<?= rtrim(BASE_URL, '/') ?>/jobs">Jobs</a></li>
                    <li><a href="<?= rtrim(BASE_URL, '/') ?>/contact">Contact</a></li>
                    <li class="give-cta"><a href="<?= rtrim(BASE_URL, '/') ?>/giving" class="btn-give">Give</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="main-content">
        <?php echo $content ?? ''; ?>
    </main>
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-cta"><?= htmlspecialchars($footerCta ?? 'Join us. Grow with us. Shine with us.', ENT_QUOTES, 'UTF-8') ?></div>
            <div class="footer-links">
                <a href="<?= rtrim(BASE_URL, '/') ?>/about">About</a>
                <a href="<?= rtrim(BASE_URL, '/') ?>/contact">Contact</a>
                <a href="<?= rtrim(BASE_URL, '/') ?>/giving">Give</a>
                <a href="<?= rtrim(BASE_URL, '/') ?>/im-new">I'm New</a>
            </div>
            <p class="copyright">&copy; <?= date('Y') ?> Lighthouse Global Church. Raising Lights. Transforming Nations.</p>
        </div>
    </footer>
    <script src="<?= rtrim(BASE_URL, '/') ?>/public/js/main.js"></script>
</body>
</html>
