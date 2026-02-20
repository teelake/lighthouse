<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$sections = $sections ?? [];
$imNewIntro = $sections['im_new_intro']['content'] ?? null;
$whatToExpect = $sections['im_new_expect']['content'] ?? null;
$arrive = $sections['im_new_arrive']['content'] ?? null;
$service = $sections['im_new_service']['content'] ?? null;
$after = $sections['im_new_after']['content'] ?? null;
$_arrive = trim((string)(($sections['im_new_arrive_summary'] ?? [])['content'] ?? ''));
$arriveSummary = $_arrive !== '' ? $_arrive : 'Upon arrival, you\'ll find plenty of parking and our friendly greeters will guide you every step of the way. Our team will help with children\'s check-in—just ask anyone wearing a Welcome Team badge.';
$_service = trim((string)(($sections['im_new_service_summary'] ?? [])['content'] ?? ''));
$serviceSummary = $_service !== '' ? $_service : 'Experience 2–3 hours of heartfelt worship and an inspiring, gospel-centered message. Participate at your comfort level—sing, clap, reflect, or simply soak it all in.';
$_after = trim((string)(($sections['im_new_after_summary'] ?? [])['content'] ?? ''));
$afterSummary = $_after !== '' ? $_after : 'Hang around and meet our church family! Our Connection Team will help you take your next steps. Stop by the Welcome Station for a special gift.';
$watchOnlineCopy = $sections['im_new_watch_online']['content'] ?? 'Can\'t join in person? Browse our archived teachings and sermons from anywhere.';
$connectCopy = $sections['im_new_connect']['content'] ?? 'Join us for newcomers\' lunch, small group registration, and getting connected. Stop by the Welcome Station after service.';
$registered = $_GET['registered'] ?? null;
$regError = $_GET['error'] ?? null;
$imNewIntroImage = $imNewIntroImage ?? '';
?>
<?php $imNewHeroImg = page_hero_image('im-new'); ?>
<section class="section im-new-page" data-animate>
    <div class="page-hero page-hero--im-new<?= page_hero_classes($imNewHeroImg) ?>"<?= page_hero_style($imNewHeroImg) ?>>
        <div class="container">
            <h1 class="page-hero-title">Welcome Home</h1>
            <p class="page-hero-sub">You're not just welcome—you're celebrated</p>
        </div>
    </div>

    <div class="container im-new-content">
        <div class="im-new-intro-block <?= !empty($imNewIntroImage) ? 'im-new-intro-block--with-image' : '' ?>">
            <?php if (!empty($imNewIntroImage)): ?>
            <div class="im-new-intro-grid">
                <div class="im-new-intro-image">
                    <img src="<?= htmlspecialchars(full_image_url($imNewIntroImage)) ?>" alt="Welcome to Lighthouse" loading="lazy">
                </div>
                <div class="im-new-intro-text">
                    <h2 class="about-section-title">We're Glad You're Here</h2>
                    <div class="about-story-body">
                        <?= rich_content($imNewIntro ?? 'At Lighthouse, you\'re not just welcome—you\'re celebrated. No matter where you are in life or your faith journey, there\'s a place for you here. Whether you\'re exploring faith for the first time or looking for a church home, we\'re here to walk with you.') ?>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="im-new-intro-text-only">
                <h2 class="about-section-title">We're Glad You're Here</h2>
                <div class="about-story-body">
                    <?= rich_content($imNewIntro ?? 'At Lighthouse, you\'re not just welcome—you\'re celebrated. No matter where you are in life or your faith journey, there\'s a place for you here. Whether you\'re exploring faith for the first time or looking for a church home, we\'re here to walk with you.') ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <h2 class="about-section-title">What to Expect</h2>
        <div class="im-new-steps">
            <div class="brand-card stagger-item">
                <span class="brand-card-num">1</span>
                <h3 class="brand-card-title">When You Arrive</h3>
                <p class="brand-card-text"><?= strip_tags($arriveSummary) ?></p>
            </div>
            <div class="brand-card stagger-item">
                <span class="brand-card-num">2</span>
                <h3 class="brand-card-title">In The Service</h3>
                <p class="brand-card-text"><?= strip_tags($serviceSummary) ?></p>
            </div>
            <div class="brand-card stagger-item">
                <span class="brand-card-num">3</span>
                <h3 class="brand-card-title">After The Service</h3>
                <p class="brand-card-text"><?= strip_tags($afterSummary) ?></p>
            </div>
        </div>

        <div class="im-new-cta-section">
            <div class="im-new-cta-card stagger-item">
                <h3 class="im-new-cta-title">Plan Your Visit</h3>
                <div class="im-new-cta-body"><?= rich_content($whatToExpect ?? 'Join us Sunday at 10:00 AM or Thursday at 6:00 PM. We meet at Holiday Inn & Suites, 980 Parkland Drive, Halifax.') ?></div>
                <a href="<?= $baseUrl ?>/contact" class="btn btn-watch btn-sm">Get Directions</a>
            </div>
            <div class="im-new-cta-card stagger-item">
                <h3 class="im-new-cta-title">Watch Online</h3>
                <p><?= htmlspecialchars(strip_tags($watchOnlineCopy)) ?></p>
                <?php [$watchUrl, $watchExt] = watch_online_url(); ?>
                <a href="<?= htmlspecialchars($watchUrl) ?>" class="btn btn-accent btn-sm"<?= $watchExt ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>Watch Media</a>
            </div>
            <div class="im-new-cta-card stagger-item">
                <h3 class="im-new-cta-title">Connect with Us</h3>
                <p><?= htmlspecialchars(strip_tags($connectCopy)) ?></p>
                <a href="<?= $baseUrl ?>/contact" class="btn btn-accent btn-sm">Get Connected</a>
            </div>
        </div>

        <?php if ($arrive || $service || $after): ?>
        <div class="im-new-detail-sections">
            <?php if ($arrive): ?>
            <div class="im-new-detail">
                <h3 class="im-new-detail-title">When You Arrive</h3>
                <div class="im-new-detail-body"><?= rich_content($arrive) ?></div>
            </div>
            <?php endif; ?>
            <?php if ($service): ?>
            <div class="im-new-detail">
                <h3 class="im-new-detail-title">In The Service</h3>
                <div class="im-new-detail-body"><?= rich_content($service) ?></div>
            </div>
            <?php endif; ?>
            <?php if ($after): ?>
            <div class="im-new-detail">
                <h3 class="im-new-detail-title">After The Service</h3>
                <div class="im-new-detail-body"><?= rich_content($after) ?></div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <h3 class="im-new-section-title">Next Steps</h3>
        <div class="im-new-next-steps">
            <p><strong>Connect with Us</strong> — Join us for newcomers' lunch, small group registration, and getting connected.</p>
            <p><strong>Explore Our Ministries</strong> — Discover specific ministry pages for deeper involvement.</p>
        </div>
        <div class="about-cta">
            <a href="<?= $baseUrl ?>/services" class="btn btn-watch">Our Gatherings</a>
            <a href="<?= $baseUrl ?>/small-groups" class="btn btn-accent">Find a Small Group</a>
            <a href="<?= $baseUrl ?>/ministries" class="btn btn-accent">Explore Ministries</a>
            <a href="<?= $baseUrl ?>/contact" class="btn btn-accent">Contact Us</a>
        </div>

        <div class="im-new-faq-cta">
            <p>Have questions about parking, attire, service times, or childcare? <a href="<?= $baseUrl ?>/faq">See our FAQs</a>.</p>
        </div>

        <div class="im-new-visitor-form-section">
            <h3 class="im-new-section-title">First-Time Visitor Registration</h3>
            <p class="im-new-form-intro">We'd love to welcome you! Share your details and we'll reach out with a warm welcome and helpful next steps.</p>
            <?php if ($registered === '1'): ?>
            <div class="im-new-msg im-new-msg--success">Thank you for registering! We're excited to connect with you. Check your email for a welcome message.</div>
            <?php elseif ($regError): ?>
            <div class="im-new-msg im-new-msg--error"><?= $regError === 'required' ? 'Please fill in first name, last name, and email.' : 'Something went wrong. Please try again.' ?></div>
            <?php endif; ?>
            <form class="im-new-visitor-form" action="<?= $baseUrl ?>/visitor/register" method="post">
                <?= csrf_field() ?>
                <div class="im-new-form-row">
                    <div class="form-group">
                        <label for="visitor-first">First Name <span aria-hidden="true">*</span></label>
                        <input type="text" id="visitor-first" name="first_name" required maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="visitor-last">Last Name <span aria-hidden="true">*</span></label>
                        <input type="text" id="visitor-last" name="last_name" required maxlength="255">
                    </div>
                </div>
                <div class="form-group">
                    <label for="visitor-email">Email <span aria-hidden="true">*</span></label>
                    <input type="email" id="visitor-email" name="email" required maxlength="255">
                </div>
                <div class="form-group">
                    <label for="visitor-phone">Phone</label>
                    <input type="tel" id="visitor-phone" name="phone" maxlength="50">
                </div>
                <div class="form-group">
                    <label for="visitor-message">Message (optional)</label>
                    <textarea id="visitor-message" name="message" rows="3" placeholder="Any questions or how we can help?"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Register My Visit</button>
            </form>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'I\'m New - Lighthouse Global Church';
$pageDescription = 'New to Lighthouse? Discover what to expect, plan your visit, and connect with our church family.';
require APP_PATH . '/views/layouts/main.php';
?>
