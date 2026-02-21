<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$sections = $sections ?? [];
$membershipIntro = $sections['membership_intro']['content'] ?? null;
?>
<?php $membershipHeroImg = page_hero_image('membership'); ?>
<section class="section membership-page" data-animate>
    <div class="page-hero page-hero--membership<?= page_hero_classes($membershipHeroImg) ?>"<?= page_hero_style($membershipHeroImg) ?>>
        <div class="container">
            <h1 class="page-hero-title">Membership & Training</h1>
            <p class="page-hero-sub">Pharos Academies — Equipping for life and leadership</p>
        </div>
    </div>

    <div class="container membership-content">
        <div class="membership-intro">
            <h2 class="about-section-title">Grow With Us</h2>
            <div class="about-story-body">
                <?= rich_content($membershipIntro ?? 'We believe every believer is called to grow, be discipled, and be equipped for impact.') ?>
            </div>
        </div>

        <div class="about-pillars membership-pillars">
            <div class="about-pillar stagger-item">
                <div class="about-pillar-icon" aria-hidden="true">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3 class="about-pillar-title">Pharos Membership Academy</h3>
                <div class="about-pillar-text"><?= rich_content($sections['membership_pharos']['content'] ?? 'A foundational pathway for identity, doctrine, values, and belonging.') ?></div>
            </div>
            <div class="about-pillar stagger-item">
                <div class="about-pillar-icon" aria-hidden="true">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3 class="about-pillar-title">Pharos Leadership Academy</h3>
                <div class="about-pillar-text"><?= rich_content($sections['membership_leadership']['content'] ?? 'Leadership development for ministry, marketplace, and societal influence.') ?></div>
            </div>
            <div class="about-pillar stagger-item">
                <div class="about-pillar-icon" aria-hidden="true">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><path d="M8 7h8"/></svg>
                </div>
                <h3 class="about-pillar-title">Pharos Discipleship Academy</h3>
                <div class="about-pillar-text"><?= rich_content($sections['membership_discipleship']['content'] ?? 'Deep spiritual formation focused on Christlikeness, discipline, and deployment.') ?></div>
            </div>
        </div>

        <div class="about-cta">
            <a href="<?= $baseUrl ?>/contact" class="btn btn-watch">Get In Touch</a>
            <a href="<?= $baseUrl ?>/im-new" class="btn btn-accent">I'm New</a>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Membership & Training - Lighthouse Global Church';
$pageDescription = 'Pharos Academies: Membership, Leadership, and Discipleship training at Lighthouse Global Church.';
require APP_PATH . '/views/layouts/main.php';
?>
