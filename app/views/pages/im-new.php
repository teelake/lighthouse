<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$sections = $sections ?? [];
$imNewIntro = $sections['im_new_intro']['content'] ?? null;
$whatToExpect = $sections['im_new_expect']['content'] ?? null;
?>
<section class="section im-new-page" data-animate>
    <div class="page-hero page-hero--im-new">
        <div class="container">
            <h1 class="page-hero-title">Welcome Home</h1>
            <p class="page-hero-sub">You're not just welcome—you're celebrated</p>
        </div>
    </div>

    <div class="container im-new-content">
        <div class="im-new-intro">
            <h2 class="about-section-title">We're Glad You're Here</h2>
            <div class="about-story-body">
                <?= rich_content($imNewIntro ?? 'At Lighthouse, you\'re not just welcome—you\'re celebrated. No matter where you are in life or your faith journey, there\'s a place for you here. Whether you\'re exploring faith for the first time or looking for a church home, we\'re here to walk with you.') ?>
            </div>
        </div>

        <h2 class="about-section-title">What to Expect</h2>
        <div class="im-new-steps">
            <div class="brand-card stagger-item">
                <span class="brand-card-num">1</span>
                <h3 class="brand-card-title">Welcome</h3>
                <p class="brand-card-text">From the moment you walk in, expect a warm greeting. Our team will help you find a seat, answer questions, and connect you with others.</p>
            </div>
            <div class="brand-card stagger-item">
                <span class="brand-card-num">2</span>
                <h3 class="brand-card-title">Worship & Word</h3>
                <p class="brand-card-text">Experience Spirit-led worship and practical, life-changing teaching from the Bible. Services typically run 90 minutes.</p>
            </div>
            <div class="brand-card stagger-item">
                <span class="brand-card-num">3</span>
                <h3 class="brand-card-title">Stay Connected</h3>
                <p class="brand-card-text">Visit our Connect desk after service, join a small group, or simply come again. No pressure—just genuine relationship.</p>
            </div>
        </div>

        <div class="im-new-cta-section">
            <div class="im-new-cta-card">
                <h3>Plan Your Visit</h3>
                <p><?= rich_content($whatToExpect ?? 'Join us Sunday at 10:00 AM or Thursday at 6:00 PM. We meet at Holiday Inn & Suites, 980 Parkland Drive, Halifax.') ?></p>
                <a href="<?= $baseUrl ?>/contact" class="btn btn-watch">Get Directions</a>
            </div>
            <div class="im-new-cta-card">
                <h3>Watch Online</h3>
                <p>Can't join in person? Tune in to our live streams and archived teachings from anywhere.</p>
                <a href="<?= $baseUrl ?>/media" class="btn btn-accent">Watch Media</a>
            </div>
        </div>

        <div class="about-cta">
            <a href="<?= $baseUrl ?>/services" class="btn btn-watch">Our Gatherings</a>
            <a href="<?= $baseUrl ?>/small-groups" class="btn btn-accent">Find a Small Group</a>
            <a href="<?= $baseUrl ?>/contact" class="btn btn-accent">Contact Us</a>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'I\'m New - Lighthouse Global Church';
$pageDescription = 'New to Lighthouse? Discover what to expect, plan your visit, and connect with our church family.';
require APP_PATH . '/views/layouts/main.php';
?>
