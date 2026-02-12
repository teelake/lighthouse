<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$hero = $sections['hero_headline'] ?? null;
$subheadline = $sections['hero_subheadline'] ?? null;
$scripture = $sections['scripture_banner'] ?? null;
$whoWeAre = $sections['who_we_are'] ?? null;
$footerCta = $sections['footer_cta'] ?? null;
$coreValues = $sections['core_values'] ?? null;
?>

<!-- Hero - Believers House style -->
<section class="hero">
    <div class="hero-bg" style="background: linear-gradient(135deg, rgba(26,95,74,0.92) 0%, rgba(15,23,42,0.9) 100%);"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-headline"><?= htmlspecialchars($hero['content'] ?? 'Raising Lights That Transform Nations') ?></h1>
        <div class="hero-pillars">
            <span>A warm WELCOME</span>
            <span>An atmosphere of WORSHIP</span>
            <span>A relevant WORD</span>
        </div>
        <div class="hero-ctas">
            <a href="<?= $baseUrl ?>/media" class="btn btn-primary">Watch Live</a>
            <a href="<?= $baseUrl ?>/giving" class="btn btn-accent">Give Here</a>
            <a href="<?= $baseUrl ?>/media" class="btn btn-outline">Explore Teachings</a>
        </div>
    </div>
</section>

<!-- New Here - prominent like Believers House -->
<section class="new-here-banner">
    <div class="container">
        <h2>New Here?</h2>
        <p>Start your journey. We'd love to connect with you.</p>
        <a href="<?= $baseUrl ?>/im-new" class="btn btn-start">Start Here</a>
    </div>
</section>

<!-- Scripture Banner -->
<?php if ($scripture): ?>
<section class="scripture-banner">
    <blockquote><?= nl2br(htmlspecialchars($scripture['content'] ?? '')) ?></blockquote>
</section>
<?php endif; ?>

<!-- ABOUT us - Believers House style -->
<section class="section who-we-are">
    <div class="container">
        <h2 class="section-title">ABOUT us</h2>
        <p class="section-lead"><?= nl2br(htmlspecialchars($whoWeAre['content'] ?? '')) ?></p>
        <a href="<?= $baseUrl ?>/about" class="btn btn-primary">Learn More</a>
    </div>
</section>

<!-- REGULAR EVENTS - Believers House style -->
<section class="section service-times">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">REGULAR EVENTS</h2>
            <a href="<?= $baseUrl ?>/events" class="btn btn-primary">See Events</a>
        </div>
        <div class="service-grid">
            <div class="service-card">
                <h3>Sunday — Catalysis</h3>
                <p class="time"><?= htmlspecialchars($serviceTimes['sunday'] ?? '10:00 AM') ?></p>
                <p class="desc">A catalytic worship experience designed to ignite faith, release clarity, and activate purpose.</p>
            </div>
            <div class="service-card">
                <h3>Thursday — The Summit</h3>
                <p class="time"><?= htmlspecialchars($serviceTimes['thursday'] ?? '6:00 PM') ?></p>
                <p class="desc">Elevation | Encounter | Empowerment. A midweek teaching and prayer gathering.</p>
            </div>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="section core-values">
    <div class="container">
        <h2 class="section-title">Core Values</h2>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">◆</div>
                <h3>Audacity</h3>
                <p>Faith that dares the impossible.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">◆</div>
                <h3>Hospitality</h3>
                <p>Warmth, service, and belonging.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">◆</div>
                <h3>Leadership</h3>
                <p>Responsibility, influence, and stewardship.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonial - Believers House style -->
<?php if (!empty($testimonials)): ?>
<section class="section testimonial-section">
    <div class="container">
        <?php $t = $testimonials[0]; ?>
        <blockquote class="testimonial-quote">"<?= htmlspecialchars($t['quote']) ?>"</blockquote>
        <cite class="testimonial-author">— <?= htmlspecialchars($t['author_name']) ?></cite>
    </div>
</section>
<?php endif; ?>

<!-- What's Happening -->
<section class="section events-preview">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">What's Happening</h2>
            <a href="<?= $baseUrl ?>/events" class="btn btn-primary">See Events</a>
        </div>
        <div class="events-grid">
            <?php foreach (array_slice($events ?? [], 0, 3) as $event): ?>
            <article class="event-card">
                <h3><?= htmlspecialchars($event['title']) ?></h3>
                <?php if (!empty($event['event_date'])): ?>
                    <p class="date"><?= date('M j, Y', strtotime($event['event_date'])) ?><?= !empty($event['event_time']) ? ' · ' . date('g:i A', strtotime($event['event_time'])) : '' ?></p>
                <?php endif; ?>
                <p><?= htmlspecialchars(mb_substr($event['description'] ?? '', 0, 100)) ?>...</p>
                <a href="<?= $baseUrl ?>/events/<?= htmlspecialchars($event['slug']) ?>" class="link">Details →</a>
            </article>
            <?php endforeach; ?>
        </div>
        <?php if (empty($events)): ?>
        <p class="no-events">Monthly Thanksgiving & Celebration Service · Quarterly Encounter Gatherings · Thrive Night · Spirit, Light & Life Conference</p>
        <a href="<?= $baseUrl ?>/events" class="btn btn-primary">View Events</a>
        <?php endif; ?>
    </div>
</section>

<!-- Newsletter - Believers House style -->
<section class="section newsletter-section">
    <div class="container">
        <h2 class="section-title">Subscribe to Our Mailing List</h2>
        <form class="newsletter-form" action="<?= $baseUrl ?>/newsletter/subscribe" method="post">
            <input type="email" name="email" placeholder="Enter your email here" required>
            <input type="text" name="first_name" placeholder="First name">
            <input type="text" name="last_name" placeholder="Last name">
            <input type="tel" name="phone" placeholder="Phone">
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>
</section>

<?php
$content = ob_get_clean();
$footerCta = ($sections['footer_cta'] ?? [])['content'] ?? 'Join us. Grow with us. Shine with us.';
$pageTitle = $pageTitle ?? 'Lighthouse Global Church';
$pageDescription = $pageDescription ?? 'A Christ-centered, Spirit-empowered ministry equipping believers for life, leadership, and global impact.';
require APP_PATH . '/views/layouts/main.php';
?>
