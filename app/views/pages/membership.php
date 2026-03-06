<?php
ob_start();
$baseUrl   = rtrim(BASE_URL, '/');
$sections  = $sections ?? [];
$submitted = $submitted ?? false;
$error     = $error ?? null;
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

        <!-- Academy Sign-Up Form -->
        <div class="academy-signup-section" id="academy-signup">
            <div class="academy-signup-header">
                <span class="about-eyebrow">Take the Next Step</span>
                <h2 class="about-section-title">Sign Up for an Academy</h2>
                <p class="academy-signup-sub">Tell us which academy you'd like to join and we'll be in touch with the next steps.</p>
            </div>

            <?php if ($submitted): ?>
            <div class="academy-signup-success" role="alert">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <div>
                    <strong>You're signed up!</strong>
                    <p>Thank you. We've received your registration and will be in touch soon.</p>
                </div>
            </div>
            <?php else: ?>

            <?php if ($error === 'invalid'): ?>
            <div class="academy-signup-error" role="alert">Please fill in all required fields with a valid email and select an academy.</div>
            <?php elseif ($error === 'server'): ?>
            <div class="academy-signup-error" role="alert">Something went wrong. Please try again.</div>
            <?php elseif ($error === 'csrf'): ?>
            <div class="academy-signup-error" role="alert">Invalid request. Please try again.</div>
            <?php endif; ?>

            <form class="academy-signup-form" action="<?= $baseUrl ?>/membership/register" method="post" novalidate>
                <?= csrf_field() ?>
                <div class="academy-form-grid">
                    <div class="form-group">
                        <label for="acad-name">Full Name *</label>
                        <input type="text" id="acad-name" name="full_name" required placeholder="Your full name" value="<?= htmlspecialchars($_GET['full_name'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="acad-email">Email Address *</label>
                        <input type="email" id="acad-email" name="email" required placeholder="your@email.com" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="acad-phone">Phone Number <span class="form-optional">(optional)</span></label>
                        <input type="tel" id="acad-phone" name="phone" placeholder="+1 (000) 000-0000" value="<?= htmlspecialchars($_GET['phone'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Which Academy? *</label>
                        <div class="academy-radio-group">
                            <label class="academy-radio-item">
                                <input type="radio" name="academy" value="membership" required>
                                <span class="academy-radio-box">
                                    <strong>Pharos Membership Academy</strong>
                                    <em>Identity, doctrine, values & belonging</em>
                                </span>
                            </label>
                            <label class="academy-radio-item">
                                <input type="radio" name="academy" value="leadership">
                                <span class="academy-radio-box">
                                    <strong>Pharos Leadership Academy</strong>
                                    <em>Ministry, marketplace & societal influence</em>
                                </span>
                            </label>
                            <label class="academy-radio-item">
                                <input type="radio" name="academy" value="discipleship">
                                <span class="academy-radio-box">
                                    <strong>Pharos Discipleship Academy</strong>
                                    <em>Spiritual formation, Christlikeness & deployment</em>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group academy-form-full">
                        <label for="acad-message">Anything else you'd like us to know? <span class="form-optional">(optional)</span></label>
                        <textarea id="acad-message" name="message" rows="3" placeholder="Tell us a little about yourself…"><?= htmlspecialchars($_GET['message'] ?? '') ?></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-accent academy-signup-btn">Sign Me Up →</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Membership & Training - Lighthouse Global Church';
$pageDescription = 'Pharos Academies: Membership, Leadership, and Discipleship training at Lighthouse Global Church.';
require APP_PATH . '/views/layouts/main.php';
?>
