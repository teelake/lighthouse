<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$sections = $sections ?? [];
$imNewIntro = ($sections['im_new_intro'] ?? [])['content'] ?? null;
$whatToExpect = ($sections['im_new_expect'] ?? [])['content'] ?? null;
$arrive = ($sections['im_new_arrive'] ?? [])['content'] ?? null;
$service = ($sections['im_new_service'] ?? [])['content'] ?? null;
$after = ($sections['im_new_after'] ?? [])['content'] ?? null;
$whatToExpectBullets = ($sections['im_new_what_to_expect'] ?? [])['content'] ?? null;
$registered = $_GET['registered'] ?? null;
$regError = $_GET['error'] ?? null;
$imNewIntroImage = $imNewIntroImage ?? '';
[$watchUrl, $watchExt] = watch_online_url();
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
                        <?= rich_content($imNewIntro ?? 'At LightHouse, you\'re not just welcome—you\'re celebrated. No matter where you are in life or your faith journey, there\'s a place for you here. Our vibrant, authentic community is ready to embrace you, encourage you, and walk with you every step of the way. Is this your first time? We\'d love to connect with you! Feel free to visit as often as you like—no strings attached. Just come as you are and experience a warm, inviting space where you can discover more about God and build lasting relationships.') ?>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="im-new-intro-text-only">
                <h2 class="about-section-title">We're Glad You're Here</h2>
                <div class="about-story-body">
                    <?= rich_content($imNewIntro ?? 'At LightHouse, you\'re not just welcome—you\'re celebrated. No matter where you are in life or your faith journey, there\'s a place for you here. Our vibrant, authentic community is ready to embrace you, encourage you, and walk with you every step of the way. Is this your first time? We\'d love to connect with you! Feel free to visit as often as you like—no strings attached. Just come as you are and experience a warm, inviting space where you can discover more about God and build lasting relationships.') ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <h2 class="about-section-title">What to Expect</h2>
        <div class="im-new-steps">
            <div class="brand-card stagger-item">
                <span class="brand-card-num">1</span>
                <h3 class="brand-card-title">When You Arrive</h3>
                <div class="brand-card-body"><?= rich_content($arrive ?? '<p>This is LightHouse, You are welcome! Upon arrival, you\'ll find plenty of parking spaces, and our friendly greeters will be there to guide you every step of the way. Whether it\'s your first visit or your hundredth, we want you to feel completely at ease.</p><p>If you\'re visiting with children, our team will help you check them into our secure, age-appropriate classes designed to engage and inspire young hearts. Unsure where to go? Just ask anyone wearing a "Welcome Team" badge—they\'re here to assist you!</p>') ?></div>
            </div>
            <div class="brand-card stagger-item">
                <span class="brand-card-num">2</span>
                <h3 class="brand-card-title">In The Service</h3>
                <div class="brand-card-body"><?= rich_content($service ?? '<p>Our service experience is uplifting, engaging, and designed to help you connect with God. Expect 2 to 3 hours of heartfelt worship with dynamic music and a mix of contemporary and multicultural songs reflecting our global community.</p><p>You\'ll also hear an inspiring, gospel-centered message that\'s relevant to your everyday life. Whether you\'re new to faith or have been walking with Jesus for years, you\'ll leave refreshed and equipped for the week ahead.</p><p>Feel free to participate at your comfort level—sing, clap, reflect, or simply soak it all in. We\'re here to create a space for everyone to encounter God in their unique way.</p>') ?></div>
            </div>
            <div class="brand-card stagger-item">
                <span class="brand-card-num">3</span>
                <h3 class="brand-card-title">After The Service</h3>
                <div class="brand-card-body"><?= rich_content($after ?? '<p>After the service, we\'d love for you to hang around and meet our church family! Our Connection Team is available to answer any questions and help you take your next steps, whether that\'s learning more about the church, joining a small group, or simply finding a place to belong.</p><p>Stop by the Welcome Station located near the entrance to receive a special gift as our way of saying thank you for visiting. If you\'re curious about faith, exploring your next steps, or just want to meet new friends, we\'re excited to journey with you at The LightHouse!</p>') ?></div>
            </div>
        </div>

        <?php if ($whatToExpectBullets): ?>
        <div class="im-new-expect-section">
            <h3 class="im-new-section-title">What You'll Experience</h3>
            <div class="im-new-expect-list"><?= rich_content($whatToExpectBullets) ?></div>
        </div>
        <?php endif; ?>

        <h3 class="im-new-section-title">Next Steps</h3>
        <div class="im-new-next-steps">
            <p><strong>Connect with Us</strong> — Join us for newcomers' lunch, small group registration, and getting connected. Stop by the Welcome Station after service.</p>
            <p><strong>Explore Our Ministries</strong> — Discover specific ministry pages for deeper involvement.</p>
        </div>
        <div class="im-new-next-steps-ctas">
            <a href="<?= $baseUrl ?>/contact" class="btn btn-watch btn-sm">Get Directions</a>
            <a href="<?= htmlspecialchars($watchUrl) ?>" class="btn btn-accent btn-sm"<?= $watchExt ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>Watch Media</a>
            <a href="<?= $baseUrl ?>/contact" class="btn btn-accent btn-sm">Get Connected</a>
            <a href="<?= $baseUrl ?>/services" class="btn btn-accent btn-sm">Our Gatherings</a>
            <a href="<?= $baseUrl ?>/small-groups" class="btn btn-accent btn-sm">Find a Small Group</a>
            <a href="<?= $baseUrl ?>/ministries" class="btn btn-accent btn-sm">Explore Ministries</a>
            <a href="<?= $baseUrl ?>/contact" class="btn btn-accent btn-sm">Contact Us</a>
        </div>

        <div class="im-new-faq-cta">
            <p>Have questions about parking, attire, service times, or childcare? <a href="<?= $baseUrl ?>/faq">See our FAQs</a>.</p>
        </div>

        <div class="im-new-visitor-form-section im-new-form-centered">
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
                <button type="submit" class="btn btn-primary">Submit my info</button>
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
