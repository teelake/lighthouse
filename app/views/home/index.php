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

<!-- Hero -->
<section class="hero">
    <div class="hero-bg" style="background: linear-gradient(135deg, #1a5f4a 0%, #0f172a 100%);"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-headline"><?= htmlspecialchars($hero['content'] ?? 'Raising Lights That Transform Nations') ?></h1>
        <p class="hero-subheadline"><?= htmlspecialchars($subheadline['content'] ?? 'A Christ-centered, Spirit-empowered ministry equipping believers for life, leadership, and global impact.') ?></p>
        <div class="hero-ctas">
            <a href="<?= $baseUrl ?>/media" class="btn btn-primary">Watch Live</a>
            <a href="<?= $baseUrl ?>/media" class="btn btn-outline">Explore Teachings</a>
            <a href="<?= $baseUrl ?>/giving" class="btn btn-accent">Partner With Us</a>
        </div>
    </div>
</section>

<!-- Scripture Banner -->
<?php if ($scripture): ?>
<section class="scripture-banner">
    <blockquote><?= nl2br(htmlspecialchars($scripture['content'] ?? '')) ?></blockquote>
</section>
<?php endif; ?>

<!-- Who We Are -->
<section class="section who-we-are">
    <div class="container">
        <h2 class="section-title">Who We Are</h2>
        <p class="section-lead"><?= nl2br(htmlspecialchars($whoWeAre['content'] ?? '')) ?></p>
        <a href="<?= $baseUrl ?>/about" class="btn btn-primary">Learn More</a>
    </div>
</section>

<!-- Service Times -->
<section class="section service-times">
    <div class="container">
        <h2 class="section-title">Service Times</h2>
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

<!-- What's Happening / Events -->
<section class="section events-preview">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">What's Happening</h2>
            <a href="<?= $baseUrl ?>/events" class="btn btn-outline">View Events</a>
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

<!-- New Here CTA -->
<section class="section new-here">
    <div class="container">
        <h2>New Here?</h2>
        <p>Start your journey. We'd love to connect with you.</p>
        <a href="<?= $baseUrl ?>/im-new" class="btn btn-accent">Start Here</a>
    </div>
</section>

<?php
$content = ob_get_clean();
$footerCta = ($sections['footer_cta'] ?? [])['content'] ?? 'Join us. Grow with us. Shine with us.';
$pageTitle = $pageTitle ?? 'Lighthouse Global Church';
$pageDescription = $pageDescription ?? 'A Christ-centered, Spirit-empowered ministry equipping believers for life, leadership, and global impact.';
require APP_PATH . '/views/layouts/main.php';
?>
