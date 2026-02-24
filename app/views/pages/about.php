<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$whoWeAre = $sections['who_we_are'] ?? null;
$aboutIntro = $sections['about_intro'] ?? null;
$aboutMission = $sections['about_mission'] ?? null;
$aboutVision = $sections['about_vision'] ?? null;
$aboutValues = $sections['about_values'] ?? null;
$story = ($aboutIntro['content'] ?? null) ?: ($whoWeAre['content'] ?? '');
$aboutHeroImage = $aboutHeroImage ?? '';
$aboutStoryImage = $aboutStoryImage ?? '';
?>
<section class="section about-page about-page--hop" data-animate>
    <div class="about-hero page-hero page-hero--about<?= page_hero_classes($aboutHeroImage) ?>"<?= page_hero_style($aboutHeroImage) ?>>
        <div class="container">
            <h1 class="about-hero-title">Raising Lights</h1>
            <p class="about-hero-tagline">that transform nations</p>
        </div>
    </div>

    <nav class="about-subnav" aria-label="About section navigation">
        <div class="container">
            <a href="<?= $baseUrl ?>/about" class="about-subnav-link about-subnav-link--active">Who We Are</a>
            <a href="<?= $baseUrl ?>/leadership" class="about-subnav-link">Our Leadership</a>
            <a href="<?= $baseUrl ?>/about#about-faqs" class="about-subnav-link">FAQ</a>
        </div>
    </nav>

    <div class="about-body">
        <div class="about-story-block">
            <div class="container">
                <div class="about-story-inner <?= !empty($aboutStoryImage) ? 'about-story-inner--with-image' : '' ?>">
                    <?php if (!empty($aboutStoryImage)): ?>
                    <div class="about-story-grid">
                        <div class="about-story-image">
                            <img src="<?= htmlspecialchars($aboutStoryImage) ?>" alt="Lighthouse Global Church" loading="lazy">
                        </div>
                        <div class="about-story-text">
                            <span class="about-eyebrow">Our Story</span>
                            <h2 class="about-block-title">Learn how we became a vibrant community of faith</h2>
                            <div class="about-story-body">
                                <?= rich_content($story) ?>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="about-story-text-only">
                        <span class="about-eyebrow">Our Story</span>
                        <h2 class="about-block-title">Learn how we became a vibrant community of faith</h2>
                        <div class="about-story-body">
                            <?= rich_content($story) ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php
        $scripturalConfig = $sections['scriptural_foundation_config'] ?? null;
        $scripturalData = [];
        if (!empty($scripturalConfig['extra_data'])) {
            $scripturalData = is_string($scripturalConfig['extra_data']) ? json_decode($scripturalConfig['extra_data'], true) : $scripturalConfig['extra_data'];
        }
        $scripturalData = is_array($scripturalData) ? $scripturalData : [];
        $scriptureBlocks = [];
        for ($i = 1; $i <= 3; $i++) {
            $ref = trim($scripturalData["scripture_{$i}_ref"] ?? '');
            $desc = trim($scripturalData["scripture_{$i}_desc"] ?? '');
            if ($ref !== '' || $desc !== '') $scriptureBlocks[] = ['ref' => $ref, 'desc' => $desc];
        }
        if (empty($scriptureBlocks)) {
            $scriptureBlocks = [
                ['ref' => 'Isaiah 42:5–11', 'desc' => 'God forms His people to be a light—opening blind eyes and setting captives free.'],
                ['ref' => 'Isaiah 2:2–4', 'desc' => 'The house of the Lord is established as a center of instruction and transformation for nations.'],
            ];
        }
        ?>
        <div class="about-scriptural-block">
            <div class="container">
                <span class="about-eyebrow about-eyebrow--light">Our Foundation</span>
                <h2 class="about-scriptural-title">Our Scriptural Foundation</h2>
                <div class="about-scriptural-list">
                    <?php foreach ($scriptureBlocks as $block): ?>
                    <div class="about-scriptural-item">
                        <cite class="about-scriptural-ref"><?= htmlspecialchars($block['ref']) ?></cite>
                        <div class="about-scriptural-desc"><?= rich_content($block['desc']) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="about-pillars-block">
            <div class="container">
                <span class="about-eyebrow">Where Lights Gather</span>
                <h2 class="about-section-title">Our Pillars</h2>
                <div class="about-pillars-grid">
                    <div class="about-pillar-card about-pillar-card--mission stagger-item">
                        <div class="about-pillar-card-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5"/></svg>
                        </div>
                        <h3 class="about-pillar-card-title">Mission</h3>
                        <div class="about-pillar-card-text" style="color:white;"><?= rich_content($aboutMission['content'] ?? 'To raise lights that transform nations.') ?></div>
                    </div>
                    <div class="about-pillar-card about-pillar-card--vision stagger-item">
                        <div class="about-pillar-card-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                        </div>
                        <h3 class="about-pillar-card-title">Vision</h3>
                        <div class="about-pillar-card-text" style="color:white;"><?= rich_content($aboutVision['content'] ?? 'A Christ-centered, Spirit-empowered community.') ?></div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $coreValuesConfig = $sections['core_values_config'] ?? null;
        $coreValuesData = [];
        if (!empty($coreValuesConfig['extra_data'])) {
            $coreValuesData = is_string($coreValuesConfig['extra_data']) ? json_decode($coreValuesConfig['extra_data'], true) : $coreValuesConfig['extra_data'];
        }
        $coreValuesData = is_array($coreValuesData) ? $coreValuesData : [];
        $coreValuesList = [];
        for ($i = 1; $i <= 5; $i++) {
            $title = trim($coreValuesData["value_{$i}_title"] ?? '');
            $desc = trim($coreValuesData["value_{$i}_desc"] ?? '');
            if ($title !== '' || $desc !== '') $coreValuesList[] = ['title' => $title ?: 'Value ' . $i, 'desc' => $desc];
        }
        if (empty($coreValuesList)) {
            $coreValuesList = [
                ['title' => 'Audacity', 'desc' => 'Faith that dares the impossible.'],
                ['title' => 'Hospitality', 'desc' => 'Warmth, service, and belonging.'],
                ['title' => 'Leadership', 'desc' => 'Responsibility, influence, and stewardship.'],
            ];
        }
        ?>
        <div class="about-core-values-block">
            <div class="container">
                <span class="about-eyebrow">What We Live By</span>
                <h2 class="about-section-title">Core Values</h2>
                <div class="about-core-values-grid">
                    <?php foreach ($coreValuesList as $v): ?>
                    <div class="about-value-card stagger-item">
                        <div class="about-value-card-icon" aria-hidden="true">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                        <h3 class="about-value-card-title"><?= content_text($v['title']) ?></h3>
                        <div class="about-value-card-desc"><?= rich_content($v['desc']) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php $aboutBeliefs = $sections['about_beliefs']['content'] ?? null; ?>
        <?php if (!empty(trim($aboutBeliefs ?? ''))): ?>
        <div class="about-beliefs-block">
            <div class="container">
                <span class="about-eyebrow about-eyebrow--light">What We Stand For</span>
                <h2 class="about-beliefs-title">Our Beliefs</h2>
                <div class="about-beliefs-content">
                    <?= rich_content($aboutBeliefs) ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($faqs)): ?>
        <div class="about-faqs-block" id="about-faqs">
            <div class="container">
                <span class="about-eyebrow">Got Questions?</span>
                <h2 class="about-section-title">Frequently Asked Questions</h2>
                <div class="faq-list faq-list--hop" data-faq-accordion>
                    <?php foreach ($faqs as $i => $faq): ?>
                    <div class="faq-item faq-item--hop <?= $i === 0 ? 'is-open' : '' ?>">
                        <button type="button" class="faq-question faq-question--hop" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="about-faq-<?= (int)$faq['id'] ?>" id="about-faq-q-<?= (int)$faq['id'] ?>" data-faq-toggle>
                            <?= content_text($faq['question']) ?>
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
        </div>
        <?php endif; ?>

        <div class="about-cta-block">
            <div class="container">
                <h2 class="about-cta-title">Ready to shine with us?</h2>
                <div class="about-cta-buttons">
                    <a href="<?= $baseUrl ?>/leadership" class="btn btn-about-cta btn-about-cta--red">Meet Our Leadership</a>
                    <a href="<?= $baseUrl ?>/im-new" class="btn btn-about-cta btn-about-cta--gold">Plan Your Visit</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'About Us - Lighthouse Global Church';
$pageDescription = 'Learn about Lighthouse Global Church—our mission, vision, and values as a Christ-centered, Spirit-empowered ministry.';
require APP_PATH . '/views/layouts/main.php';
?>
