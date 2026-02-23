<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$sections = $sections ?? [];
$prayerIntro = ($sections['prayer_intro'] ?? [])['content'] ?? null;
$submitted = isset($_GET['submitted']);
?>
<?php $prayerHeroImg = page_hero_image('prayer'); ?>
<section class="section prayer-page" data-animate>
    <div class="page-hero page-hero--prayer<?= page_hero_classes($prayerHeroImg) ?>"<?= page_hero_style($prayerHeroImg) ?>>
        <div class="container">
            <h1 class="page-hero-title">Prayer</h1>
            <p class="page-hero-sub">We stand with you in prayer</p>
        </div>
    </div>

    <div class="container prayer-content">
        <?php if ($submitted): ?>
        <div class="prayer-success" role="alert">
            <p>Thank you. Your prayer request has been received. Our team will pray with you.</p>
        </div>
        <?php endif; ?>

        <div class="prayer-grid">
            <div class="prayer-submit-card" style="max-width: 560px;">
                <h2 class="about-section-title">Submit a Prayer Request</h2>
                <div class="prayer-desc"><?= rich_content($prayerIntro ?? 'Share your prayer need with us. You can request prayer openly or anonymously. Our pastoral team and prayer intercessors will pray with you.') ?></div>
                <form class="prayer-form" action="<?= $baseUrl ?>/prayer/submit" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="prayer-name">Your name (optional)</label>
                        <input type="text" id="prayer-name" name="name" placeholder="Leave blank for anonymous">
                    </div>
                    <div class="form-group">
                        <label for="prayer-email">Email (optional)</label>
                        <input type="email" id="prayer-email" name="email" placeholder="For follow-up if needed">
                    </div>
                    <div class="form-group">
                        <label for="prayer-request">Prayer request *</label>
                        <textarea id="prayer-request" name="request" rows="5" required placeholder="Share your prayer need..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-watch">Submit Request</button>
                </form>
                <p class="prayer-note" style="margin-top: 1.5rem;">Church members can access the <a href="<?= (function_exists('admin_url') ? admin_url('login') : $baseUrl . '/admin/login') ?>?redirect=<?= urlencode(defined('ADMIN_PATH') ? ADMIN_PATH . '/prayer-wall' : 'admin/prayer-wall') ?>">Prayer Wall</a> in the member dashboard—a digital space to post prayer points and pray with other members. <a href="<?= (function_exists('admin_url') ? admin_url('login') : $baseUrl . '/admin/login') ?>?redirect=<?= urlencode(defined('ADMIN_PATH') ? ADMIN_PATH . '/prayer-wall' : 'admin/prayer-wall') ?>">Sign in</a> as a member to participate.</p>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Prayer - Lighthouse Global Church';
$pageDescription = 'Submit a prayer request. We stand with you in prayer.';
require APP_PATH . '/views/layouts/main.php';
?>
