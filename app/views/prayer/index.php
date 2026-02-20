<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$sections = $sections ?? [];
$prayerIntro = ($sections['prayer_intro'] ?? [])['content'] ?? null;
$submitted = isset($_GET['submitted']);
$posted = isset($_GET['posted']);
$wallError = $_GET['error'] ?? null;
$isLoggedIn = $isLoggedIn ?? false;
$wallPosts = $wallPosts ?? [];
$wallUsers = $wallUsers ?? [];
$loginUrl = (function_exists('admin_url') ? admin_url('login') : $baseUrl . '/admin/login') . '?redirect=' . urlencode('prayer');
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
        <?php if ($posted): ?>
        <div class="prayer-success" role="alert">
            <p>Your prayer point has been posted. Thank you for sharing.</p>
        </div>
        <?php endif; ?>
        <?php if ($wallError === 'csrf'): ?>
        <div class="prayer-msg prayer-msg--error" role="alert">
            <p>Invalid request. Please try again.</p>
        </div>
        <?php elseif ($wallError === 'empty'): ?>
        <div class="prayer-msg prayer-msg--error" role="alert">
            <p>Please enter your prayer point.</p>
        </div>
        <?php elseif ($wallError === 'post'): ?>
        <div class="prayer-msg prayer-msg--error" role="alert">
            <p>Something went wrong. Please try again.</p>
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
                <?php if ($isLoggedIn): ?>
                <form class="prayer-wall-form" action="<?= $baseUrl ?>/prayer-wall/post" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="wall-request">Post a prayer point</label>
                        <textarea id="wall-request" name="request" rows="4" required placeholder="Share a prayer point for others to pray with you..."></textarea>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" id="wall-anonymous" name="is_anonymous" value="1">
                        <label for="wall-anonymous">Post anonymously</label>
                    </div>
                    <button type="submit" class="btn btn-accent">Post to Wall</button>
                </form>
                <?php else: ?>
                <p class="prayer-note">You must be signed in to post on the Prayer Wall. <a href="<?= htmlspecialchars($loginUrl) ?>">Sign in</a> to post, or <a href="<?= $baseUrl ?>/im-new">get connected</a> if you're new.</p>
                <?php endif; ?>
            </div>
        </div>

        <div id="wall" class="prayer-wall-posts">
            <h2 class="about-section-title">Prayer Wall</h2>
            <?php if (empty($wallPosts)): ?>
            <p class="prayer-desc">No prayer points yet. <?= $isLoggedIn ? 'Be the first to post above!' : 'Sign in to post a prayer point.' ?></p>
            <?php else: ?>
            <div class="prayer-wall-list">
                <?php foreach ($wallPosts as $p): ?>
                <div class="prayer-wall-item">
                    <p class="prayer-wall-item-text"><?= nl2br(htmlspecialchars($p['request'] ?? '')) ?></p>
                    <p class="prayer-wall-item-meta"><?= ($p['is_anonymous'] ?? 0) ? 'Anonymous' : htmlspecialchars($wallUsers[$p['user_id'] ?? 0] ?? 'Member') ?> · <?= date('M j, Y', strtotime($p['created_at'] ?? 'now')) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = $pageTitle ?? 'Prayer - Lighthouse Global Church';
$pageDescription = 'Submit a prayer request or visit the Prayer Wall. We stand with you in prayer.';
require APP_PATH . '/views/layouts/main.php';
?>
