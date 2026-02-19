<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$msg = $msg ?? '';
$address = $address ?? '980 Parkland Drive, Holiday Inn & Suites, Halifax, NS, Canada';
$phone = $phone ?? '902-240-2087';
$email = $email ?? 'info@thelighthouseglobal.org';
$mapEmbedUrl = $mapEmbedUrl ?? '';
$mapSrc = !empty($mapEmbedUrl) ? $mapEmbedUrl : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2836.7857583703526!2d-63.6770046!3d44.68315439999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4b5a215128cb02df%3A0xf44bdaa2f32e4a51!2sThe%20LightHouse%20Global%20Ministries!5e0!3m2!1sen!2sng!4v1770960686185!5m2!1sen!2sng';
?>
<?php $contactHeroImg = page_hero_image('contact'); ?>
<section class="section contact-page" data-animate>
    <div class="page-hero page-hero--contact<?= page_hero_classes($contactHeroImg) ?>"<?= page_hero_style($contactHeroImg) ?>>
        <div class="container">
            <h1 class="page-hero-title">Get In Touch</h1>
            <p class="page-hero-sub">Questions? Ideas? Prayers? We'd love to hear from you</p>
        </div>
    </div>

    <div class="container contact-content">
        <div class="contact-intro">
            <p class="contact-lead">Reach out anytime—we're here to connect, answer questions, and walk alongside you.</p>
        </div>

        <div class="contact-grid">
            <div class="contact-form-card">
                <h2 class="contact-form-title">Send a Message</h2>
                <?php if ($msg === 'success'): ?>
                <div class="contact-msg contact-msg--success">
                    <span class="contact-msg-icon" aria-hidden="true">✓</span>
                    Thank you! Your message has been sent. We'll get back to you soon. Check your email for a confirmation.
                </div>
                <?php elseif ($msg === 'invalid'): ?>
                <div class="contact-msg contact-msg--error">Please fill in all required fields (name, email, and message) correctly.</div>
                <?php elseif ($msg === 'error'): ?>
                <div class="contact-msg contact-msg--error">Something went wrong. Please try again or email us directly.</div>
                <?php endif; ?>
                <form class="contact-form" action="<?= $baseUrl ?>/contact/submit" method="post">
                    <?= csrf_field() ?>
                    <div class="contact-form-row">
                        <div class="contact-form-field">
                            <label for="contact-name">Name <span aria-hidden="true">*</span></label>
                            <input type="text" id="contact-name" name="name" required maxlength="255" placeholder="Your name">
                        </div>
                        <div class="contact-form-field">
                            <label for="contact-email">Email <span aria-hidden="true">*</span></label>
                            <input type="email" id="contact-email" name="email" required maxlength="255" placeholder="your@email.com">
                        </div>
                    </div>
                    <div class="contact-form-field">
                        <label for="contact-subject">Subject</label>
                        <input type="text" id="contact-subject" name="subject" maxlength="255" placeholder="e.g. General inquiry">
                    </div>
                    <div class="contact-form-field">
                        <label for="contact-message">Message <span aria-hidden="true">*</span></label>
                        <textarea id="contact-message" name="message" required rows="5" placeholder="How can we help?"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary contact-form-submit">
                        <span>Send Message</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                    </button>
                </form>
            </div>

            <div class="contact-sidebar">
                <div class="contact-card">
                    <h3 class="contact-card-title">Reach Us</h3>
                    <div class="contact-card-rows">
                        <a href="https://maps.google.com/?q=<?= rawurlencode($address) ?>" target="_blank" rel="noopener noreferrer" class="contact-card-row">
                            <span class="contact-card-row-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            </span>
                            <div class="contact-card-row-body">
                                <span class="contact-card-row-value"><?= htmlspecialchars($address) ?></span>
                                <span class="contact-card-row-action">Get directions →</span>
                            </div>
                        </a>
                        <a href="tel:<?= preg_replace('/\D/', '', $phone) ?>" class="contact-card-row">
                            <span class="contact-card-row-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </span>
                            <div class="contact-card-row-body">
                                <span class="contact-card-row-value"><?= htmlspecialchars($phone) ?></span>
                                <span class="contact-card-row-action">Call →</span>
                            </div>
                        </a>
                        <a href="mailto:<?= htmlspecialchars($email) ?>" class="contact-card-row">
                            <span class="contact-card-row-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </span>
                            <div class="contact-card-row-body">
                                <span class="contact-card-row-value"><?= htmlspecialchars($email) ?></span>
                                <span class="contact-card-row-action">Email us →</span>
                            </div>
                        </a>
                    </div>
                    <div class="contact-card-times">
                        <span class="contact-card-times-value">Sunday 10:00 AM · Thursday 6:00 PM</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="contact-map-section">
            <h2 class="contact-map-title">Find Us</h2>
            <div class="contact-map-wrap">
                <div class="contact-map">
                    <iframe src="<?= htmlspecialchars($mapSrc) ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lighthouse Global Church location"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Contact Us - Lighthouse Global Church';
$pageDescription = 'Contact Lighthouse Global Church. Address, phone, email, and directions.';
require APP_PATH . '/views/layouts/main.php';
?>
