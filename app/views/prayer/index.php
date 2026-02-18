<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$sections = $sections ?? [];
$prayerIntro = $sections['prayer_intro']['content'] ?? null;
$submitted = isset($_GET['submitted']);
?>
<section class="section prayer-page" data-animate>
    <div class="page-hero page-hero--prayer">
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
            <div class="prayer-submit-card">
                <h2 class="about-section-title">Submit a Prayer Request</h2>
                <div class="prayer-desc"><?= rich_content($prayerIntro ?? 'Share your prayer need with us. You can request prayer openly or anonymously. Our pastoral team and prayer intercessors will pray with you.') ?></div>
                <form class="prayer-form" action="<?= $baseUrl ?>/prayer/submit" method="post">
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
            </div>
            <div class="prayer-wall-card">
                <h2 class="about-section-title">Prayer Wall</h2>
                <p class="prayer-desc">A space for church members to post prayer points and invite others to pray. Share openly or anonymously.</p>
                <a href="<?= $baseUrl ?>/prayer#wall" class="btn btn-accent">Go to Prayer Wall</a>
                <p class="prayer-note">Prayer Wall posts are for members. <a href="<?= $baseUrl ?>/im-new">Get connected</a> to participate.</p>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Prayer - Lighthouse Global Church';
$pageDescription = 'Submit a prayer request or visit the Prayer Wall. We stand with you in prayer.';
require APP_PATH . '/views/layouts/main.php';
?>
