<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
?>
<section class="section prayer-page" data-animate>
    <div class="page-hero page-hero--prayer">
        <div class="container">
            <h1 class="page-hero-title">Member Portal</h1>
            <p class="page-hero-sub">Access restricted</p>
        </div>
    </div>
    <div class="container prayer-content" style="text-align: center; padding: 4rem 1.5rem;">
        <p class="prayer-desc" style="font-size: 1.1rem;">The Prayer Wall is for church members only. If you're a member, please sign in with your member account.</p>
        <a href="<?= (function_exists('admin_url') ? admin_url('login') : $baseUrl . '/admin/login') ?>?redirect=members/prayer-wall" class="btn btn-accent" style="margin-top: 1rem;">Sign In</a>
        <p style="margin-top: 2rem;"><a href="<?= $baseUrl ?>/">Return to homepage</a></p>
    </div>
</section>
<?php
$content = ob_get_clean();
$pageTitle = 'Access Restricted';
$pageDescription = 'Member Portal - Access restricted to church members.';
require APP_PATH . '/views/layouts/members.php';
?>
