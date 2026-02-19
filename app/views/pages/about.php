<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$whoWeAre = $sections['who_we_are'] ?? null;
$aboutIntro = $sections['about_intro'] ?? null;
$aboutMission = $sections['about_mission'] ?? null;
$aboutVision = $sections['about_vision'] ?? null;
$aboutValues = $sections['about_values'] ?? null;
$story = ($aboutIntro['content'] ?? null) ?: ($whoWeAre['content'] ?? '');
?>
<?php
$aboutHeroImage = $aboutHeroImage ?? '';
$aboutStoryImage = $aboutStoryImage ?? '';
?>
<section class="section about-page" data-animate>
    <div class="page-hero page-hero--about<?= page_hero_classes($aboutHeroImage) ?>"<?= page_hero_style($aboutHeroImage) ?>>
        <div class="container">
            <h1 class="page-hero-title">About Us</h1>
            <p class="page-hero-sub">Raising lights that transform nations</p>
        </div>
    </div>

    <nav class="page-subnav" aria-label="About section navigation">
        <div class="container">
            <a href="<?= $baseUrl ?>/about" class="page-subnav-link page-subnav-link--active">About Us</a>
            <a href="<?= $baseUrl ?>/leadership" class="page-subnav-link">Leadership</a>
        </div>
    </nav>

    <div class="container about-content">
        <div class="about-story <?= !empty($aboutStoryImage) ? 'about-story--with-image' : '' ?>">
            <?php if (!empty($aboutStoryImage)): ?>
            <div class="about-story-grid">
                <div class="about-story-image">
                    <img src="<?= htmlspecialchars($aboutStoryImage) ?>" alt="Lighthouse Global Church" loading="lazy">
                </div>
                <div class="about-story-text">
                    <h2 class="about-section-title">Our Story</h2>
                    <div class="about-story-body">
                        <?= rich_content($story) ?>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <h2 class="about-section-title">Our Story</h2>
            <div class="about-story-body">
                <?= rich_content($story) ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="about-pillars">
            <div class="about-pillar about-pillar--mission stagger-item">
                <div class="about-pillar-icon" aria-hidden="true">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5"/></svg>
                </div>
                <h3 class="about-pillar-title">Our Mission</h3>
                <div class="about-pillar-text"><?= rich_content($aboutMission['content'] ?? 'To raise lights that transform nations.') ?></div>
            </div>
            <div class="about-pillar about-pillar--vision stagger-item">
                <div class="about-pillar-icon" aria-hidden="true">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                </div>
                <h3 class="about-pillar-title">Our Vision</h3>
                <div class="about-pillar-text"><?= rich_content($aboutVision['content'] ?? 'A Christ-centered, Spirit-empowered community.') ?></div>
            </div>
            <div class="about-pillar about-pillar--values stagger-item">
                <div class="about-pillar-icon" aria-hidden="true">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <h3 class="about-pillar-title">Our Values</h3>
                <div class="about-pillar-text"><?= rich_content($aboutValues['content'] ?? 'Worship, Word, and leadership training.') ?></div>
            </div>
        </div>

        <?php $aboutBeliefs = $sections['about_beliefs']['content'] ?? null; ?>
        <?php if (!empty(trim($aboutBeliefs ?? ''))): ?>
        <div class="about-beliefs">
            <h2 class="about-section-title">What We Believe</h2>
            <div class="about-story-body">
                <?= rich_content($aboutBeliefs) ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($faqs)): ?>
        <div class="about-faqs" id="about-faqs">
            <h2 class="about-section-title">Frequently Asked Questions</h2>
            <div class="faq-list faq-list--inline" data-faq-accordion>
                <?php foreach ($faqs as $i => $faq): ?>
                <div class="faq-item <?= $i === 0 ? 'is-open' : '' ?>">
                    <button type="button" class="faq-question" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="about-faq-<?= (int)$faq['id'] ?>" id="about-faq-q-<?= (int)$faq['id'] ?>" data-faq-toggle>
                        <?= htmlspecialchars($faq['question']) ?>
                        <span class="faq-icon" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                        </span>
                    </button>
                    <div class="faq-answer" id="about-faq-<?= (int)$faq['id'] ?>" role="region" aria-labelledby="about-faq-q-<?= (int)$faq['id'] ?>">
                        <div class="faq-answer-inner">
                            <?= rich_content($faq['answer']) ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="about-cta">
            <a href="<?= $baseUrl ?>/leadership" class="btn btn-primary">Meet Our Leadership</a>
            <a href="<?= $baseUrl ?>/im-new" class="btn btn-watch">Plan Your Visit</a>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'About Us - Lighthouse Global Church';
$pageDescription = 'Learn about Lighthouse Global Church—our mission, vision, and values as a Christ-centered, Spirit-empowered ministry.';
require APP_PATH . '/views/layouts/main.php';
?>
