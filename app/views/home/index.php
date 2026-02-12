<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$hero = $sections['hero_headline'] ?? null;
$scripture = $sections['scripture_banner'] ?? null;
$whoWeAre = $sections['who_we_are'] ?? null;
$footerCta = $sections['footer_cta'] ?? null;
$headline = $hero['content'] ?? 'Raising Lights That Transform Nations';
$headlineParts = preg_split('/\s+/', $headline, 4);
$part1 = ($headlineParts[0] ?? '') . ' ' . ($headlineParts[1] ?? '');
$part2 = ($headlineParts[2] ?? '') . ' ' . ($headlineParts[3] ?? '');
?>

<!-- 1. Hero - Believers House: full-bleed image, overlay, split headline -->
<section class="hero bh-hero">
    <div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1507692049790-de58290a4334?w=1920'); background-size: cover; background-position: center;"></div>
    <div class="hero-overlay" style="background: linear-gradient(135deg, rgba(10,10,10,0.75) 0%, rgba(0,0,0,0.85) 100%);"></div>
    <div class="hero-content">
        <h1 class="hero-headline bh-headline">
            <span class="bh-headline-line"><?= htmlspecialchars($part1) ?></span>
            <span class="bh-headline-line"><?= htmlspecialchars($part2) ?></span>
        </h1>
        <div class="hero-pillars">
            <span>A warm WELCOME</span>
            <span>An atmosphere of WORSHIP</span>
            <span>A relevant WORD</span>
        </div>
        <div class="hero-ctas">
            <a href="<?= $baseUrl ?>/media" class="btn btn-primary">WATCH LIVE</a>
            <a href="<?= $baseUrl ?>/giving" class="btn btn-accent">GIVE HERE</a>
        </div>
    </div>
</section>

<!-- 2. Welcome - Believers House: full-width image with overlay CTA -->
<section class="welcome-banner">
    <div class="welcome-bg" style="background-image: url('https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=1920');"></div>
    <div class="welcome-overlay"></div>
    <div class="welcome-content">
        <h2 class="welcome-title">New Here?</h2>
        <a href="<?= $baseUrl ?>/im-new" class="btn btn-start">Start Here</a>
    </div>
</section>

<!-- 3. Scripture Banner (optional) -->
<?php if ($scripture && !empty(trim($scripture['content'] ?? ''))): ?>
<section class="scripture-banner">
    <blockquote><?= nl2br(htmlspecialchars($scripture['content'] ?? '')) ?></blockquote>
</section>
<?php endif; ?>

<!-- 4. ABOUT us - Believers House split: left text, right image -->
<section class="about-split">
    <div class="about-text">
        <h2 class="section-title">ABOUT us</h2>
        <p><?= nl2br(htmlspecialchars($whoWeAre['content'] ?? 'The Lighthouse Global Ministry is a Spirit-led ministry commissioned to raise men and women who shine with Christ\'s light—bringing transformation to lives, communities, cultures, and nations.')) ?></p>
        <a href="<?= $baseUrl ?>/about" class="btn btn-primary">Learn More</a>
    </div>
    <div class="about-image">
        <img src="https://images.unsplash.com/photo-1532619675605-1ede6c2ed2b0?w=800" alt="Community">
    </div>
</section>

<!-- 5. REGULAR EVENTS - Believers House dark section -->
<section class="section service-times">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">REGULAR EVENTS</h2>
            <a href="<?= $baseUrl ?>/events" class="btn btn-primary">SEE EVENTS</a>
        </div>
        <div class="service-grid">
            <div class="service-card">
                <h3>Sunday — Catalysis</h3>
                <p class="time"><?= htmlspecialchars($serviceTimes['sunday'] ?? '10:00 AM') ?></p>
                <p class="desc">A catalytic worship experience designed to ignite faith, release clarity, and activate purpose.</p>
                <a href="<?= $baseUrl ?>/services" class="btn btn-primary btn-sm">DETAILS</a>
            </div>
            <div class="service-card">
                <h3>Thursday — The Summit</h3>
                <p class="time"><?= htmlspecialchars($serviceTimes['thursday'] ?? '6:00 PM') ?></p>
                <p class="desc">Elevation | Encounter | Empowerment. A midweek teaching and prayer gathering.</p>
                <a href="<?= $baseUrl ?>/services" class="btn btn-primary btn-sm">DETAILS</a>
            </div>
        </div>
    </div>
</section>

<!-- 6. PHOTOS - Believers House gallery -->
<section class="section photos-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">PHOTOS</h2>
            <a href="<?= $baseUrl ?>/media" class="btn btn-primary">MORE</a>
        </div>
        <div class="photos-grid">
            <div class="photo-item photo-tall"><img src="https://images.unsplash.com/photo-1516455590571-18256e5bb9ff?w=600" alt=""></div>
            <div class="photo-item photo-wide"><img src="https://images.unsplash.com/photo-1420161900862-9a86fa1f5c79?w=900" alt=""></div>
            <div class="photo-item"><img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600" alt=""></div>
        </div>
    </div>
</section>

<!-- 7. Testimonial - Believers House full-width quote -->
<?php if (!empty($testimonials)): ?>
<section class="section testimonial-section">
    <div class="container">
        <?php $t = $testimonials[0]; ?>
        <blockquote class="testimonial-quote">"<?= htmlspecialchars($t['quote']) ?>"</blockquote>
        <cite class="testimonial-author">— <?= htmlspecialchars($t['author_name']) ?></cite>
    </div>
</section>
<?php else: ?>
<section class="section testimonial-section">
    <div class="container">
        <blockquote class="testimonial-quote">"Lighthouse is more like a family and not just a place of worship. Since I started attending, I've been shown nothing but love."</blockquote>
        <cite class="testimonial-author">— A LIGHTHOUSE BELIEVER</cite>
    </div>
</section>
<?php endif; ?>

<!-- 8. Map section -->
<section class="map-section">
    <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2839.0842128169367!2d-63.5952!3d44.6488!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4b5a2112d72a1c81%3A0x4fa5f6e2e7e3e4e5!2sHalifax%2C%20NS!5e0!3m2!1sen!2sca!4v1234567890" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</section>

<!-- 9. Newsletter - Believers House mailing list -->
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
