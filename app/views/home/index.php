<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$hero = $sections['hero_headline'] ?? null;
$scripture = $sections['scripture_banner'] ?? null;
$whoWeAre = $sections['who_we_are'] ?? null;
$footerCta = $sections['footer_cta'] ?? null;
$headline = $hero['content'] ?? 'Raising Lights That Transform Nations';
?>

<!-- 1. Hero - Lighthouse unique: centered, bold, warm gradient -->
<section class="hero hero-lighthouse">
    <div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1507692049790-de58290a4334?w=1920');"></div>
    <div class="hero-overlay" style="background: linear-gradient(180deg, rgba(26,26,26,0.6) 0%, rgba(26,26,26,0.85) 100%);"></div>
    <div class="hero-inner hero-centered">
        <div class="hero-content">
            <p class="hero-tagline">A Christ-centered, Spirit-empowered ministry</p>
            <h1 class="hero-headline"><?= htmlspecialchars($headline) ?></h1>
            <div class="hero-pillars">
                <span>Welcome</span>
                <span>Worship</span>
                <span>Word</span>
            </div>
            <div class="hero-ctas">
                <a href="<?= $baseUrl ?>/media" class="btn btn-watch">Watch Live</a>
                <a href="<?= $baseUrl ?>/im-new" class="btn btn-accent">Plan Your Visit</a>
            </div>
        </div>
    </div>
</section>

<!-- 2. Gather With Us - HOP-inspired: clear service times, Join Online + Plan Visit -->
<section class="section gather-section">
    <div class="container">
        <h2 class="section-title">Gather With Us</h2>
        <p class="section-sub">Join us in person or online</p>
        <div class="gather-grid">
            <div class="gather-card">
                <span class="gather-day">Sunday</span>
                <span class="gather-time"><?= htmlspecialchars($serviceTimes['sunday'] ?? '10:00 AM') ?></span>
                <p class="gather-desc">Catalysis — Worship that ignites faith</p>
                <span class="gather-loc">In-Person + Online</span>
                <div class="gather-actions">
                    <a href="<?= $baseUrl ?>/media" class="btn btn-primary btn-sm">Join Online</a>
                    <a href="<?= $baseUrl ?>/im-new" class="btn btn-accent btn-sm">Plan Visit</a>
                </div>
            </div>
            <div class="gather-card">
                <span class="gather-day">Thursday</span>
                <span class="gather-time"><?= htmlspecialchars($serviceTimes['thursday'] ?? '6:00 PM') ?></span>
                <p class="gather-desc">The Summit — Teaching &amp; prayer</p>
                <span class="gather-loc">In-Person + Online</span>
                <div class="gather-actions">
                    <a href="<?= $baseUrl ?>/media" class="btn btn-primary btn-sm">Join Online</a>
                    <a href="<?= $baseUrl ?>/im-new" class="btn btn-accent btn-sm">Plan Visit</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. New Here - warm welcome strip -->
<section class="section new-here-section">
    <div class="container new-here-inner">
        <div class="new-here-text">
            <h2>New Here?</h2>
            <p>Start your journey. We'd love to connect with you.</p>
        </div>
        <a href="<?= $baseUrl ?>/im-new" class="btn btn-watch">Start Here</a>
    </div>
</section>

<!-- 4. We Raise Lights - our unique branded section -->
<section class="section lights-section">
    <div class="container lights-inner">
        <div class="lights-content">
            <h2 class="lights-headline">We Raise <span class="lights-accent">Lights</span><br>That Transform <span class="lights-accent">Nations</span></h2>
            <p><?= nl2br(htmlspecialchars($whoWeAre['content'] ?? 'The Lighthouse Global Ministry is a Spirit-led ministry commissioned to raise men and women who shine with Christ\'s light—bringing transformation to lives, communities, cultures, and nations.')) ?></p>
            <a href="<?= $baseUrl ?>/about" class="btn btn-watch">Learn More</a>
        </div>
        <div class="lights-image">
            <img src="https://images.unsplash.com/photo-1532619675605-1ede6c2ed2b0?w=900" alt="Community">
        </div>
    </div>
</section>

<?php if ($scripture && !empty(trim($scripture['content'] ?? ''))): ?>
<section class="section scripture-section">
    <div class="container">
        <blockquote><?= nl2br(htmlspecialchars($scripture['content'] ?? '')) ?></blockquote>
    </div>
</section>
<?php endif; ?>

<!-- 5. What's On - events -->
<section class="section events-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">What's On</h2>
            <a href="<?= $baseUrl ?>/events" class="btn btn-accent btn-sm">View All Events</a>
        </div>
        <div class="events-grid">
            <div class="event-card-modern">
                <h3>Sunday — Catalysis</h3>
                <p class="event-time"><?= htmlspecialchars($serviceTimes['sunday'] ?? '10:00 AM') ?></p>
                <p>A catalytic worship experience designed to ignite faith.</p>
                <a href="<?= $baseUrl ?>/services" class="link-arrow">Join us →</a>
            </div>
            <div class="event-card-modern">
                <h3>Thursday — The Summit</h3>
                <p class="event-time"><?= htmlspecialchars($serviceTimes['thursday'] ?? '6:00 PM') ?></p>
                <p>Elevation, encounter, empowerment. Midweek teaching.</p>
                <a href="<?= $baseUrl ?>/services" class="link-arrow">Join us →</a>
            </div>
        </div>
    </div>
</section>

<!-- 6. Moments - gallery -->
<section class="section moments-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Moments</h2>
            <a href="<?= $baseUrl ?>/media" class="btn btn-accent btn-sm">See More</a>
        </div>
        <div class="moments-grid">
            <div class="moment-item"><img src="https://images.unsplash.com/photo-1516455590571-18256e5bb9ff?w=600" alt=""></div>
            <div class="moment-item moment-wide"><img src="https://images.unsplash.com/photo-1420161900862-9a86fa1f5c79?w=1200" alt=""></div>
        </div>
    </div>
</section>

<!-- 7. Voice - testimonial -->
<?php if (!empty($testimonials)): ?>
<section class="section voice-section">
    <div class="container">
        <?php $t = $testimonials[0]; ?>
        <blockquote class="voice-quote">"<?= htmlspecialchars($t['quote']) ?>"</blockquote>
        <cite>— <?= htmlspecialchars($t['author_name']) ?></cite>
    </div>
</section>
<?php else: ?>
<section class="section voice-section">
    <div class="container">
        <blockquote class="voice-quote">"Lighthouse is more like a family and not just a place of worship. Since I started attending, I've been shown nothing but love."</blockquote>
        <cite>— A Lighthouse Believer</cite>
    </div>
</section>
<?php endif; ?>

<!-- 8. Map -->
<section class="map-section">
    <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2839.0842128169367!2d-63.5952!3d44.6488!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4b5a2112d72a1c81%3A0x4fa5f6e2e7e3e4e5!2sHalifax%2C%20NS!5e0!3m2!1sen!2sca!4v1234567890" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</section>

<!-- 9. Stay Connected - newsletter -->
<section class="section stay-connected-section">
    <div class="container">
        <h2 class="section-title">Stay Connected</h2>
        <p class="section-sub">Subscribe for updates and inspiration</p>
        <form class="newsletter-form" action="<?= $baseUrl ?>/newsletter/subscribe" method="post">
            <input type="text" name="name" placeholder="Your name" required>
            <input type="email" name="email" placeholder="Your email" required>
            <button type="submit" class="btn btn-primary">Subscribe</button>
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
