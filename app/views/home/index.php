<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$hero = $sections['hero_headline'] ?? null;
$decodeExtra = function ($arr) {
    if (empty($arr) || !isset($arr['extra_data'])) return [];
    $ed = $arr['extra_data'];
    return is_array($ed) ? $ed : (json_decode($ed, true) ?: []);
};
$heroExtra = $decodeExtra($sections['hero_config'] ?? []);
$gatherExtra = $decodeExtra($sections['gather_config'] ?? []);
$lightsExtra = $decodeExtra($sections['lights_config'] ?? []);
$prayerExtra = $decodeExtra($sections['prayer_wall_config'] ?? []);
$newsletterExtra = $decodeExtra($sections['newsletter_config'] ?? []);
$whatsOnExtra = $decodeExtra($sections['whats_on_config'] ?? []);
$scripture = $sections['scripture_banner'] ?? null;
$whoWeAre = $sections['who_we_are'] ?? null;

$headline = $hero['content'] ?? 'Raising Lights That Transform Nations';
$heroTagline = $heroExtra['tagline'] ?? 'A Christ-centered, Spirit-empowered ministry';
$heroPillars = $heroExtra['pillars'] ?? ['Welcome', 'Worship', 'Word'];
$heroBg = !empty($heroBackgroundImage ?? '') ? $heroBackgroundImage : ($heroExtra['bg_image'] ?? 'https://images.unsplash.com/photo-1507692049790-de58290a4334?w=1920');
[$ctaWatch, $ctaWatchExternal] = watch_online_url();
$ctaVisit = ltrim($heroExtra['cta_visit_url'] ?? '/im-new', '/');
?>

<!-- 1. Hero - Lighthouse unique: centered, bold, warm gradient -->
<section class="hero hero-lighthouse">
    <div class="hero-bg" style="background-image: url('<?= htmlspecialchars($heroBg) ?>');"></div>
    <div class="hero-overlay" style="background: linear-gradient(180deg, rgba(26,26,26,0.6) 0%, rgba(26,26,26,0.85) 100%);"></div>
    <div class="hero-inner hero-centered">
        <div class="hero-content">
            <div class="hero-tagline"><?= rich_content($heroTagline) ?></div>
            <h1 class="hero-headline"><?= rich_content($headline) ?></h1>
            <div class="hero-pillars">
                <?php foreach ($heroPillars as $p): ?><span><?= htmlspecialchars($p) ?></span><?php endforeach; ?>
            </div>
            <div class="hero-ctas">
                <a href="<?= htmlspecialchars($ctaWatch) ?>" class="btn btn-watch"<?= $ctaWatchExternal ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>Watch Live</a>
                <a href="<?= $baseUrl ?>/<?= htmlspecialchars($ctaVisit) ?>" class="btn btn-accent">Plan Your Visit</a>
            </div>
        </div>
    </div>
</section>

<!-- 1.5. Glimpse - dual-row scrolling cards (top→left, bottom→right). -->
<section class="glimpse-section" aria-label="Our expressions">
    <h2 class="sr-only">Our Expressions</h2>
    <?php
    $g1 = $glimpseRow1 ?? [];
    $g2 = $glimpseRow2 ?? [];
    $renderGlimpseRow = function ($slides, $rowClass) {
        if (empty($slides)) return;
        $dupe = $slides; // duplicate for infinite scroll
        $all = array_merge($slides, $dupe);
        echo '<div class="glimpse-row ' . $rowClass . '"><div class="glimpse-track">';
        foreach ($all as $s) {
            echo '<div class="glimpse-slide"><div class="glimpse-slide-img" style="background-image: url(\'' . htmlspecialchars($s['image_url']) . '\');"></div>';
            echo '<div class="glimpse-slide-overlay"><span class="glimpse-label">' . htmlspecialchars($s['label']) . '</span></div></div>';
        }
        echo '</div></div>';
    };
    if (!empty($g1) || !empty($g2)):
        if (!empty($g1)) $renderGlimpseRow($g1, 'glimpse-row--left');
        else echo '<div class="glimpse-row glimpse-row--left"><div class="glimpse-track"></div></div>';
        if (!empty($g2)) $renderGlimpseRow($g2, 'glimpse-row--right');
        else echo '<div class="glimpse-row glimpse-row--right"><div class="glimpse-track"></div></div>';
    else:
        $fallback1 = [['image_url'=>'https://images.unsplash.com/photo-1516455590571-18256e5bb9ff?w=500','label'=>'Worship'],['image_url'=>'https://images.unsplash.com/photo-1420161900862-9a86fa1f5c79?w=500','label'=>'Community']];
        $fallback2 = [['image_url'=>'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=500','label'=>'Faith'],['image_url'=>'https://images.unsplash.com/photo-1516455590571-18256e5bb9ff?w=500','label'=>'Word']];
        $renderGlimpseRow($fallback1, 'glimpse-row--left');
        $renderGlimpseRow($fallback2, 'glimpse-row--right');
    endif;
    ?>
</section>

<!-- 2. Gather With Us -->
<section class="section gather-section" data-animate>
    <div class="section-title-bar">
        <div class="section-title-bar-inner">
            <h2 class="section-title"><?= content_text($gatherExtra['section_title'] ?? 'Gather With Us') ?></h2>
        </div>
    </div>
    <div class="container">
        <div class="section-sub"><?= rich_content($gatherExtra['section_sub'] ?? 'Join us in person or online') ?></div>
        <div class="gather-grid">
            <div class="gather-card">
                <span class="gather-day"><?= content_text($gatherExtra['sunday_title'] ?? 'Sunday') ?></span>
                <span class="gather-time"><?= htmlspecialchars($serviceTimes['sunday'] ?? '10:00 AM') ?></span>
                <div class="gather-desc"><?= rich_content($gatherExtra['sunday_desc'] ?? 'Catalysis — Worship that ignites faith') ?></div>
                <span class="gather-loc">In-Person + Online</span>
                <div class="gather-actions">
                    <a href="<?= htmlspecialchars($ctaWatch) ?>" class="btn btn-primary btn-sm"<?= $ctaWatchExternal ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>Join Online</a>
                    <a href="<?= $baseUrl ?>/im-new" class="btn btn-accent btn-sm">Plan Visit</a>
                </div>
            </div>
            <div class="gather-card">
                <span class="gather-day"><?= content_text($gatherExtra['thursday_title'] ?? 'Thursday') ?></span>
                <span class="gather-time"><?= htmlspecialchars($serviceTimes['thursday'] ?? '6:00 PM') ?></span>
                <div class="gather-desc"><?= rich_content($gatherExtra['thursday_desc'] ?? 'The Summit — Teaching & prayer') ?></div>
                <span class="gather-loc">In-Person + Online</span>
                <div class="gather-actions">
                    <a href="<?= htmlspecialchars($ctaWatch) ?>" class="btn btn-primary btn-sm"<?= $ctaWatchExternal ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>Join Online</a>
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

<!-- 3. Recent Sermons - youth-centric media cards with play overlay -->
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
            <a href="<?= $baseUrl ?>/media/<?= htmlspecialchars($item['slug']) ?>" class="sermon-card" aria-label="Watch: <?= htmlspecialchars($item['title']) ?>">
                <div class="sermon-card-img" style="background-image: url('<?= htmlspecialchars($mediaThumb($item)) ?>');">
                    <span class="sermon-card-tag"><?= htmlspecialchars($mediaTypeLabel($item['media_type'] ?? 'video')) ?></span>
                    <span class="sermon-card-play" aria-hidden="true">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    </span>
                    <div class="sermon-card-overlay">
                        <h3 class="sermon-card-title"><?= htmlspecialchars($item['title']) ?></h3>
                        <p class="sermon-card-desc"><?= rich_preview($item['description'] ?? '', 120) ?></p>
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
            <a href="<?= $baseUrl ?>/media" class="sermon-card" aria-label="Watch: <?= htmlspecialchars($demo['title']) ?>">
                <div class="sermon-card-img" style="background-image: url('<?= htmlspecialchars($demo['img']) ?>');">
                    <span class="sermon-card-tag"><?= htmlspecialchars($demo['tag']) ?></span>
                    <span class="sermon-card-play" aria-hidden="true">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    </span>
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

<!-- 4. We Raise Lights -->
<section class="section lights-section" data-animate>
    <div class="container lights-inner">
        <div class="lights-content">
            <h2 class="lights-headline"><?= nl2br(content_text($lightsExtra['headline'] ?? 'We Raise Lights That Transform Nations')) ?></h2>
            <div class="lights-body"><?= rich_content($whoWeAre['content'] ?? 'The Lighthouse Global Ministry is a Spirit-led ministry commissioned to raise men and women who shine with Christ\'s light—bringing transformation to lives, communities, cultures, and nations.') ?></div>
            <a href="<?= $baseUrl ?>/about" class="btn btn-watch">Learn More</a>
        </div>
        <div class="lights-image">
            <img src="<?= htmlspecialchars($lightsExtra['image'] ?? 'https://images.unsplash.com/photo-1532619675605-1ede6c2ed2b0?w=900') ?>" alt="Community">
        </div>
    </div>
</section>

<?php if ($scripture && !empty(trim($scripture['content'] ?? ''))): ?>
<section class="section scripture-section" data-animate>
    <div class="container">
        <blockquote><?= rich_content($scripture['content'] ?? '') ?></blockquote>
    </div>
</section>
<?php endif; ?>

<!-- 5. What's On -->
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
                <h3><?= content_text($whatsOnExtra['sunday_title'] ?? 'Sunday — Catalysis') ?></h3>
                <p class="event-time"><?= htmlspecialchars($serviceTimes['sunday'] ?? '10:00 AM') ?></p>
                <div><?= rich_content($whatsOnExtra['sunday_desc'] ?? 'A catalytic worship experience designed to ignite faith.') ?></div>
                <a href="<?= $baseUrl ?>/services" class="link-arrow">Join us →</a>
            </div>
            <div class="event-card-modern">
                <h3><?= content_text($whatsOnExtra['thursday_title'] ?? 'Thursday — The Summit') ?></h3>
                <p class="event-time"><?= htmlspecialchars($serviceTimes['thursday'] ?? '6:00 PM') ?></p>
                <div><?= rich_content($whatsOnExtra['thursday_desc'] ?? 'Elevation, encounter, empowerment. Midweek teaching.') ?></div>
                <a href="<?= $baseUrl ?>/services" class="link-arrow">Join us →</a>
            </div>
        </div>
    </div>
</section>

<!-- 6. Moments carousel -->
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
                    <?php
                    $mList = $moments ?? [];
                    if (empty($mList)) {
                        $mList = [
                            ['image_small'=>'https://images.unsplash.com/photo-1516455590571-18256e5bb9ff?w=600','image_wide'=>'https://images.unsplash.com/photo-1420161900862-9a86fa1f5c79?w=1200','alt_small'=>'Worship','alt_wide'=>'Community'],
                            ['image_small'=>'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600','image_wide'=>'https://images.unsplash.com/photo-1529070538774-1843cb3265df?w=1200','alt_small'=>'Gathering','alt_wide'=>'Ministry'],
                        ];
                    }
                    foreach ($mList as $m):
                    ?>
                    <div class="carousel-slide">
                        <div class="moments-grid">
                            <div class="moment-item"><img src="<?= htmlspecialchars($m['image_small']) ?>" alt="<?= htmlspecialchars($m['alt_small'] ?? '') ?>" loading="lazy" decoding="async"></div>
                            <div class="moment-item moment-wide"><img src="<?= htmlspecialchars($m['image_wide']) ?>" alt="<?= htmlspecialchars($m['alt_wide'] ?? '') ?>" loading="lazy" decoding="async"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="carousel-dots" role="tablist" aria-label="Carousel navigation"></div>
        </div>
    </div>
</section>

<!-- 7. Prayer Wall -->
<section class="section prayer-wall-section" data-animate>
    <div class="section-title-bar">
        <div class="section-title-bar-inner">
            <h2 class="section-title">Prayer Wall</h2>
            <a href="<?= $baseUrl ?>/prayer" class="btn btn-accent btn-sm">Go to Prayer Wall</a>
        </div>
    </div>
    <div class="prayer-wall-inner">
        <div class="prayer-wall-image">
            <img src="<?= htmlspecialchars($prayerWallImage ?? 'https://images.unsplash.com/photo-1544776193-352d25ca82cd?w=800') ?>" alt="Prayer">
        </div>
        <div class="prayer-wall-content">
            <p class="prayer-wall-eyebrow"><?= content_text($prayerExtra['eyebrow'] ?? 'Ministry') ?></p>
            <h3 class="prayer-wall-headline"><?= content_text($prayerExtra['headline'] ?? 'Pray With Us') ?></h3>
            <div class="prayer-wall-desc"><?= rich_content($prayerExtra['description'] ?? 'A digital space for church members to post prayer points and invite others to pray with them. You can share openly or post anonymously—either way, the church family stands with you in prayer.') ?></div>
            <div class="prayer-wall-ctas">
                <a href="<?= $baseUrl ?>/prayer" class="btn btn-prayer-wall btn-primary">Post a Prayer Point</a>
                <a href="<?= $baseUrl ?>/prayer" class="btn btn-prayer-wall btn-accent">Pray for Others</a>
            </div>
        </div>
    </div>
</section>

<!-- 8. Voice - testimonial carousel (cards style, black background) -->
<section class="section voice-section" data-animate>
    <div class="section-title-bar">
        <div class="section-title-bar-inner">
            <h2 class="section-title">What People Say</h2>
        </div>
    </div>
    <div class="container">
        <div class="voice-carousel" data-voice-carousel>
            <button type="button" class="carousel-btn carousel-prev" aria-label="Previous testimonial">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <button type="button" class="carousel-btn carousel-next" aria-label="Next testimonial">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
            </button>
            <div class="voice-carousel-track-wrap">
                <div class="voice-carousel-track">
                    <?php
                    $voiceItems = $testimonials ?? [];
                    if (empty($voiceItems)) {
                        $voiceItems = [['quote' => "Lighthouse is more like a family and not just a place of worship. Since I started attending, I've been shown nothing but love.", 'author_name' => 'A Lighthouse Believer', 'author_photo' => '']];
                    }
                    foreach ($voiceItems as $t):
                    ?>
                    <div class="voice-card">
                        <blockquote class="voice-quote"><?= rich_content($t['quote']) ?></blockquote>
                        <footer class="voice-author">
                            <?php if (!empty($t['author_photo'])): ?>
                            <img src="<?= htmlspecialchars($t['author_photo']) ?>" alt="" class="voice-author-photo">
                            <?php endif; ?>
                            <cite>— <?= htmlspecialchars($t['author_name']) ?></cite>
                        </footer>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="voice-carousel-dots" role="tablist" aria-label="Testimonial navigation"></div>
        </div>
    </div>
</section>

<!-- 9. Map -->
<section class="map-section" data-animate>
    <div class="map-container">
        <?php $mapSrc = !empty($mapEmbedUrl ?? '') ? $mapEmbedUrl : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2836.7857583703526!2d-63.6770046!3d44.68315439999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4b5a215128cb02df%3A0xf44bdaa2f32e4a51!2sThe%20LightHouse%20Global%20Ministries!5e0!3m2!1sen!2sng!4v1770960686185!5m2!1sen!2sng'; ?>
        <iframe src="<?= htmlspecialchars($mapSrc) ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lighthouse Global Church location map"></iframe>
    </div>
</section>

<!-- 10. Stay Connected - newsletter -->
<section class="section stay-connected-section" data-animate>
    <div class="container newsletter-showcase">
        <div class="newsletter-copy">
            <p class="newsletter-eyebrow"><?= content_text($newsletterExtra['eyebrow'] ?? 'Our Newsletter') ?></p>
            <h2 class="newsletter-title"><?= content_text($newsletterExtra['title'] ?? 'Get Ministry Updates in Your Inbox') ?></h2>
            <div class="newsletter-note"><?= rich_content($newsletterExtra['note'] ?? 'Receive event updates, teachings, community highlights, and important church announcements.') ?></div>
            <form class="newsletter-form newsletter-inline js-newsletter-form" action="<?= $baseUrl ?>/newsletter/subscribe" method="post">
                <label for="newsletter-name" class="sr-only">Full name</label>
                <input id="newsletter-name" type="text" name="name" placeholder="Full name" autocomplete="name" required aria-label="Full name">
                <label for="newsletter-email" class="sr-only">Email address</label>
                <input id="newsletter-email" type="email" name="email" placeholder="Email address" required aria-label="Email address">
                <button type="submit" class="newsletter-submit">Join Newsletter</button>
            </form>
            <p class="newsletter-trust">No spam. Unsubscribe anytime.</p>
            <p class="newsletter-status" aria-live="polite"></p>
        </div>
        <div class="newsletter-visual" aria-hidden="true">
            <div class="newsletter-device">
                <img src="<?= htmlspecialchars($newsletterDeviceImage ?? 'https://images.unsplash.com/photo-1487014679447-9f8336841d58?w=1200') ?>" alt="">
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
