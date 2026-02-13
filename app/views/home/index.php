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
<section class="section gather-section" data-animate>
    <div class="section-title-bar">
        <div class="section-title-bar-inner">
            <h2 class="section-title">Gather With Us</h2>
        </div>
    </div>
    <div class="container">
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

<?php
// Helper: media thumbnail from item (thumbnail field, YouTube embed, or fallback)
$mediaThumb = function ($item) {
    if (!empty($item['thumbnail'])) return $item['thumbnail'];
    $url = $item['embed_url'] ?? '';
    if (!empty($url) && preg_match('/(?:v=|\/embed\/|\/v\/|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m)) {
        return 'https://img.youtube.com/vi/' . $m[1] . '/maxresdefault.jpg';
    }
    return 'https://images.unsplash.com/photo-1516455590571-18256e5bb9ff?w=600';
};
$mediaTypeLabel = function ($t) {
    return ucfirst($t);
};
?>

<!-- 3. Recent Sermons - BLOG-style cards with image, pill tag, title overlay -->
<section class="section recent-sermons-section" data-animate>
    <div class="section-title-bar">
        <div class="section-title-bar-inner">
            <h2 class="section-title">Recent Sermons</h2>
            <a href="<?= $baseUrl ?>/media" class="btn btn-accent btn-sm">Watch All</a>
        </div>
    </div>
    <div class="container">
        <?php if (!empty($latestMedia)): ?>
        <div class="sermon-cards">
            <?php foreach ($latestMedia as $item): ?>
            <a href="<?= $baseUrl ?>/media/<?= htmlspecialchars($item['slug']) ?>" class="sermon-card">
                <div class="sermon-card-img" style="background-image: url('<?= htmlspecialchars($mediaThumb($item)) ?>');">
                    <span class="sermon-card-tag"><?= htmlspecialchars($mediaTypeLabel($item['media_type'] ?? 'video')) ?></span>
                    <div class="sermon-card-overlay">
                        <h3 class="sermon-card-title"><?= htmlspecialchars($item['title']) ?></h3>
                        <p class="sermon-card-desc"><?= htmlspecialchars(mb_strimwidth($item['description'] ?? '', 0, 120, '…')) ?></p>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else:
        $demoCards = [
            ['img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600', 'tag' => 'Ministry', 'title' => 'What To Do When You Feel Burned Out', 'desc' => 'Service is the overflow of discipleship. It seeks to extend God\'s grace and mercy to others for His glory and not our own.'],
            ['img' => 'https://images.unsplash.com/photo-1507692049790-de58290a4334?w=600', 'tag' => 'Teaching', 'title' => 'Raising Lights That Transform Nations', 'desc' => 'Discover how to shine with Christ\'s light—bringing transformation to lives, communities, and cultures.'],
            ['img' => 'https://images.unsplash.com/photo-1516455590571-18256e5bb9ff?w=600', 'tag' => 'Sermon', 'title' => 'Catalysis — Worship That Ignites Faith', 'desc' => 'Join us for a catalytic worship experience designed to ignite faith and draw you deeper into God\'s presence.'],
        ];
        ?>
        <div class="sermon-cards">
            <?php foreach ($demoCards as $demo): ?>
            <a href="<?= $baseUrl ?>/media" class="sermon-card">
                <div class="sermon-card-img" style="background-image: url('<?= htmlspecialchars($demo['img']) ?>');">
                    <span class="sermon-card-tag"><?= htmlspecialchars($demo['tag']) ?></span>
                    <div class="sermon-card-overlay">
                        <h3 class="sermon-card-title"><?= htmlspecialchars($demo['title']) ?></h3>
                        <p class="sermon-card-desc"><?= htmlspecialchars($demo['desc']) ?></p>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- 4. We Raise Lights - our unique branded section -->
<section class="section lights-section" data-animate>
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
<section class="section scripture-section" data-animate>
    <div class="container">
        <blockquote><?= nl2br(htmlspecialchars($scripture['content'] ?? '')) ?></blockquote>
    </div>
</section>
<?php endif; ?>

<!-- 5. What's On - events -->
<section class="section events-section" data-animate>
    <div class="section-title-bar">
        <div class="section-title-bar-inner">
            <h2 class="section-title">What's On</h2>
            <a href="<?= $baseUrl ?>/events" class="btn btn-accent btn-sm">View All Events</a>
        </div>
    </div>
    <div class="container">
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

<!-- 6. Moments - grid layout carousel (original 1fr + 1.5fr, scrollable) -->
<section class="section moments-section" data-animate>
    <div class="section-title-bar">
        <div class="section-title-bar-inner">
            <h2 class="section-title">Moments</h2>
            <a href="<?= $baseUrl ?>/media" class="btn btn-accent btn-sm">See More</a>
        </div>
    </div>
    <div class="container">
        <div class="moments-carousel" data-moments-carousel>
            <button type="button" class="carousel-btn carousel-prev" aria-label="Previous">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <button type="button" class="carousel-btn carousel-next" aria-label="Next">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
            </button>
            <div class="carousel-track-wrap">
                <div class="carousel-track">
                    <div class="carousel-slide">
                        <div class="moments-grid">
                            <div class="moment-item"><img src="https://images.unsplash.com/photo-1516455590571-18256e5bb9ff?w=600" alt="Worship"></div>
                            <div class="moment-item moment-wide"><img src="https://images.unsplash.com/photo-1420161900862-9a86fa1f5c79?w=1200" alt="Community"></div>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <div class="moments-grid">
                            <div class="moment-item"><img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600" alt="Gathering"></div>
                            <div class="moment-item moment-wide"><img src="https://images.unsplash.com/photo-1529070538774-1843cb3265df?w=1200" alt="Ministry"></div>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <div class="moments-grid">
                            <div class="moment-item"><img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=600" alt="Church"></div>
                            <div class="moment-item moment-wide"><img src="https://images.unsplash.com/photo-1507692049790-de58290a4334?w=1200" alt="Worship service"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-dots" role="tablist" aria-label="Carousel navigation"></div>
        </div>
    </div>
</section>

<!-- 7. Prayer Wall - two-column: image + content block with CTAs -->
<section class="section prayer-wall-section" data-animate>
    <div class="section-title-bar">
        <div class="section-title-bar-inner">
            <h2 class="section-title">Prayer Wall</h2>
            <a href="<?= $baseUrl ?>/prayer" class="btn btn-accent btn-sm">Go to Prayer Wall</a>
        </div>
    </div>
    <div class="prayer-wall-inner">
        <div class="prayer-wall-image">
            <img src="https://images.unsplash.com/photo-1544776193-352d25ca82cd?w=800" alt="Prayer">
        </div>
        <div class="prayer-wall-content">
            <p class="prayer-wall-eyebrow">Ministry</p>
            <h3 class="prayer-wall-headline">Pray With Us</h3>
            <p class="prayer-wall-desc">A digital space for church members to post prayer points and invite others to pray with them. You can share openly or post anonymously—either way, the church family stands with you in prayer.</p>
            <div class="prayer-wall-ctas">
                <a href="<?= $baseUrl ?>/prayer" class="btn btn-prayer-wall btn-primary">Post a Prayer Point</a>
                <a href="<?= $baseUrl ?>/prayer" class="btn btn-prayer-wall btn-accent">Pray for Others</a>
            </div>
        </div>
    </div>
</section>

<!-- 8. Voice - testimonial -->
<?php if (!empty($testimonials)): ?>
<section class="section voice-section" data-animate>
    <div class="container">
        <?php $t = $testimonials[0]; ?>
        <blockquote class="voice-quote">"<?= htmlspecialchars($t['quote']) ?>"</blockquote>
        <cite>— <?= htmlspecialchars($t['author_name']) ?></cite>
    </div>
</section>
<?php else: ?>
<section class="section voice-section" data-animate>
    <div class="container">
        <blockquote class="voice-quote">"Lighthouse is more like a family and not just a place of worship. Since I started attending, I've been shown nothing but love."</blockquote>
        <cite>— A Lighthouse Believer</cite>
    </div>
</section>
<?php endif; ?>

<!-- 9. Map -->
<section class="map-section" data-animate>
    <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2836.7857583703526!2d-63.6770046!3d44.68315439999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4b5a215128cb02df%3A0xf44bdaa2f32e4a51!2sThe%20LightHouse%20Global%20Ministries!5e0!3m2!1sen!2sng!4v1770960686185!5m2!1sen!2sng" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>

<!-- 10. Stay Connected - newsletter -->
<section class="section stay-connected-section" data-animate>
    <div class="container newsletter-showcase">
        <div class="newsletter-copy">
            <p class="newsletter-eyebrow">Our Newsletter</p>
            <h2 class="newsletter-title">Get Ministry Updates in Your Inbox</h2>
            <p class="newsletter-note">Receive event updates, teachings, community highlights, and important church announcements.</p>
            <form class="newsletter-form newsletter-inline js-newsletter-form" action="<?= $baseUrl ?>/newsletter/subscribe" method="post">
                <input type="text" name="name" placeholder="full name..." autocomplete="name" required>
                <input type="email" name="email" placeholder="email address..." required>
                <button type="submit" class="newsletter-submit">Join Newsletter</button>
            </form>
            <p class="newsletter-trust">No spam. Unsubscribe anytime.</p>
            <p class="newsletter-status" aria-live="polite"></p>
        </div>
        <div class="newsletter-visual" aria-hidden="true">
            <div class="newsletter-device">
                <img src="https://images.unsplash.com/photo-1487014679447-9f8336841d58?w=1200" alt="">
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
$footerCta = ($sections['footer_cta'] ?? [])['content'] ?? 'Join us. Grow with us. Shine with us.';
$pageTitle = $pageTitle ?? 'Lighthouse Global Church';
$pageDescription = $pageDescription ?? 'A Christ-centered, Spirit-empowered ministry equipping believers for life, leadership, and global impact.';
require APP_PATH . '/views/layouts/main.php';
?>
