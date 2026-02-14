<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$sections = $sections ?? [];
$givingIntro = $sections['giving_intro']['content'] ?? null;
$givingWays = $sections['giving_ways']['content'] ?? null;
$paypalEmail = $paypalEmail ?? 'give@thelighthouseglobal.org';
$paypalUrl = $paypalUrl ?? '';
?>
<section class="section giving-page" data-animate>
    <div class="page-hero page-hero--giving">
        <div class="container">
            <h1 class="page-hero-title">Giving & Partnership</h1>
            <p class="page-hero-sub">Your generosity advances the kingdom</p>
        </div>
    </div>

    <div class="container giving-content">
        <div class="giving-intro">
            <h2 class="about-section-title">Partner With Us</h2>
            <div class="about-story-body">
                <?= nl2br(htmlspecialchars($givingIntro ?? 'Giving is an act of worship and a covenant partnership in advancing God\'s kingdom. Your generosity supports teaching and discipleship, leadership development, outreach and missions, and ministry operations. Thank you for investing in what God is doing through Lighthouse.')) ?>
            </div>
        </div>

        <div class="giving-pillars">
            <div class="about-pillar stagger-item">
                <div class="about-pillar-icon" aria-hidden="true">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3 class="about-pillar-title">Teaching & Discipleship</h3>
                <p class="about-pillar-text">Resources for growing in the Word and walking with Christ.</p>
            </div>
            <div class="about-pillar stagger-item">
                <div class="about-pillar-icon" aria-hidden="true">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3 class="about-pillar-title">Leadership Development</h3>
                <p class="about-pillar-text">Equipping leaders for ministry and marketplace impact.</p>
            </div>
            <div class="about-pillar stagger-item">
                <div class="about-pillar-icon" aria-hidden="true">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                </div>
                <h3 class="about-pillar-title">Outreach & Missions</h3>
                <p class="about-pillar-text">Taking the light to communities and nations.</p>
            </div>
        </div>

        <div class="giving-ways">
            <h2 class="about-section-title">Ways to Give</h2>
            <div class="giving-options">
                <div class="giving-option stagger-item">
                    <h3>Online (Stripe)</h3>
                    <p>Give securely via credit or debit card. Configured in admin settings.</p>
                    <a href="<?= $baseUrl ?>/" class="btn btn-accent">Give Online</a>
                </div>
                <div class="giving-option stagger-item">
                    <h3>PayPal</h3>
                    <p>Send directly to <?= htmlspecialchars($paypalEmail) ?></p>
                    <?php if (!empty($paypalUrl)): ?>
                    <a href="<?= htmlspecialchars($paypalUrl) ?>" target="_blank" rel="noopener" class="btn btn-watch">Give via PayPal</a>
                    <?php else: ?>
                    <a href="mailto:<?= htmlspecialchars($paypalEmail) ?>?subject=Giving%20Inquiry" class="btn btn-watch">Contact to Give</a>
                    <?php endif; ?>
                </div>
                <div class="giving-option stagger-item">
                    <h3>In Person</h3>
                    <p>Offerings are received during Sunday and Thursday services.</p>
                </div>
            </div>
        </div>

        <p class="giving-note"><?= nl2br(htmlspecialchars($givingWays ?? 'For bank transfers or other giving methods, please contact us at ' . $paypalEmail . '.')) ?></p>

        <div class="about-cta">
            <a href="<?= $baseUrl ?>/contact" class="btn btn-accent">Contact Us</a>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Give - Lighthouse Global Church';
$pageDescription = 'Partner with Lighthouse through giving. Support teaching, leadership, and missions.';
require APP_PATH . '/views/layouts/main.php';
?>
