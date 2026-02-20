<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$sections = $sections ?? [];
$gatherExtra = $sections['gather_config']['extra_data'] ?? [];
$gatherExtra = is_array($gatherExtra) ? $gatherExtra : [];
$serviceTimes = $serviceTimes ?? ['sunday' => '10:00 AM', 'thursday' => '6:00 PM'];
$address = $address ?? '980 Parkland Drive, Holiday Inn & Suites, Halifax, NS, Canada';
?>
<?php $servicesHeroImg = page_hero_image('services'); ?>
<section class="section services-page services-page--v2" data-animate>
    <div class="page-hero page-hero--services<?= page_hero_classes($servicesHeroImg) ?>"<?= page_hero_style($servicesHeroImg) ?>>
        <div class="container">
            <h1 class="page-hero-title">Our Gatherings</h1>
            <p class="page-hero-sub">Worship. Word. Community.</p>
        </div>
    </div>

    <div class="container services-content">
        <div class="services-intro-block">
            <p class="services-lead"><?= rich_content($sections['services_intro']['content'] ?? 'We gather to worship, grow in the Word, and be equipped for life and leadership. Whether you prefer Sunday morning or Thursday evening, there\'s a service for you.') ?></p>
        </div>

        <div class="services-cards">
            <article class="services-card services-card--sunday stagger-item">
                <div class="services-card-inner">
                    <span class="services-card-day">Sunday</span>
                    <h2 class="services-card-title"><?= content_text($gatherExtra['sunday_title'] ?? 'Catalysis') ?></h2>
                    <div class="services-card-time"><?= htmlspecialchars($serviceTimes['sunday']) ?></div>
                    <div class="services-card-desc"><?= rich_content($gatherExtra['sunday_desc'] ?? 'A catalytic worship experience designed to ignite faith. Join us for Spirit-led praise, communion, and powerful teaching from the Word.') ?></div>
                    <a href="<?= $baseUrl ?>/im-new" class="btn btn-primary">Plan Your Visit</a>
                </div>
            </article>
            <article class="services-card services-card--thursday stagger-item">
                <div class="services-card-inner">
                    <span class="services-card-day">Thursday</span>
                    <h2 class="services-card-title"><?= content_text($gatherExtra['thursday_title'] ?? 'The Summit') ?></h2>
                    <div class="services-card-time"><?= htmlspecialchars($serviceTimes['thursday']) ?></div>
                    <div class="services-card-desc"><?= rich_content($gatherExtra['thursday_desc'] ?? 'Elevation, encounter, empowerment. Midweek teaching and prayer. A time to go deeper and be refreshed.') ?></div>
                    <a href="<?= $baseUrl ?>/im-new" class="btn btn-accent">Join Us</a>
                </div>
            </article>
        </div>

        <div class="services-bottom">
            <div class="services-location-card">
                <div class="services-location-icon" aria-hidden="true">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div>
                    <h3 class="services-location-title">Where We Meet</h3>
                    <p class="services-location-address"><?= nl2br(htmlspecialchars($address)) ?></p>
                    <a href="https://maps.google.com/?q=<?= rawurlencode($address) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-accent btn-sm">Get Directions</a>
                </div>
            </div>
            <div class="services-cta-strip">
                <?php [$watchUrl, $watchExt] = watch_online_url(); ?>
                <a href="<?= htmlspecialchars($watchUrl) ?>" class="btn btn-watch services-cta-btn"<?= $watchExt ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    Watch Online
                </a>
                <a href="<?= $baseUrl ?>/contact" class="btn btn-accent services-cta-btn">Contact Us</a>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Our Gatherings - Lighthouse Global Church';
$pageDescription = 'Join Lighthouse for Sunday Catalysis and Thursday Summit. Worship, Word, and community.';
require APP_PATH . '/views/layouts/main.php';
?>
