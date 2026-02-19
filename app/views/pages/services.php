<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$sections = $sections ?? [];
$gatherExtra = $sections['gather_config']['extra_data'] ?? [];
$gatherExtra = is_array($gatherExtra) ? $gatherExtra : [];
$serviceTimes = $serviceTimes ?? ['sunday' => '10:00 AM', 'thursday' => '6:00 PM'];
?>
<?php $servicesHeroImg = page_hero_image('services'); ?>
<section class="section services-page" data-animate>
    <div class="page-hero page-hero--services<?= page_hero_classes($servicesHeroImg) ?>"<?= page_hero_style($servicesHeroImg) ?>>
        <div class="container">
            <h1 class="page-hero-title">Our Gatherings</h1>
            <p class="page-hero-sub">Join us in person or online</p>
        </div>
    </div>

    <div class="container services-content">
        <div class="services-intro">
            <div class="services-lead"><?= rich_content($sections['services_intro']['content'] ?? 'We gather to worship, grow in the Word, and be equipped for life and leadership. Whether you prefer Sunday morning or Thursday evening, there\'s a service for you.') ?></div>
        </div>

        <div class="services-grid">
            <article class="event-card-modern services-card stagger-item">
                <div class="services-card-badge">Sunday</div>
                <h3><?= content_text($gatherExtra['sunday_title'] ?? 'Catalysis') ?></h3>
                <p class="event-time"><?= htmlspecialchars($serviceTimes['sunday']) ?></p>
                <div><?= rich_content($gatherExtra['sunday_desc'] ?? 'A catalytic worship experience designed to ignite faith. Join us for Spirit-led praise, communion, and powerful teaching from the Word.') ?></div>
                <a href="<?= $baseUrl ?>/im-new" class="link-arrow">Plan your visit →</a>
            </article>
            <article class="event-card-modern services-card stagger-item">
                <div class="services-card-badge">Thursday</div>
                <h3><?= content_text($gatherExtra['thursday_title'] ?? 'The Summit') ?></h3>
                <p class="event-time"><?= htmlspecialchars($serviceTimes['thursday']) ?></p>
                <div><?= rich_content($gatherExtra['thursday_desc'] ?? 'Elevation, encounter, empowerment. Midweek teaching and prayer. A time to go deeper and be refreshed.') ?></div>
                <a href="<?= $baseUrl ?>/im-new" class="link-arrow">Join us →</a>
            </article>
        </div>

        <div class="services-location">
            <h2 class="about-section-title">Where We Meet</h2>
            <p>Holiday Inn & Suites, 980 Parkland Drive, Halifax, NS</p>
            <a href="<?= $baseUrl ?>/contact" class="btn btn-accent">Get Directions</a>
        </div>

        <div class="about-cta">
            <a href="<?= $baseUrl ?>/media" class="btn btn-watch">Watch Online</a>
            <a href="<?= $baseUrl ?>/contact" class="btn btn-accent">Contact Us</a>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Our Gatherings - Lighthouse Global Church';
$pageDescription = 'Join Lighthouse for Sunday Catalysis and Thursday Summit. Worship, Word, and community.';
require APP_PATH . '/views/layouts/main.php';
?>
