<?php
ob_start();
$baseUrl = rtrim(BASE_URL, '/');
$error   = $error ?? null;
$old     = $old ?? [];
?>
<section class="section register-page" data-animate>
    <div class="container register-container">
        <div class="register-card">
            <div class="register-brand">
                <?php
                $logoPath = file_exists(PUBLIC_PATH . '/images/lighthouse-logo.png') ? '/public/images/lighthouse-logo.png' : (file_exists(PUBLIC_PATH . '/images/logo.png') ? '/public/images/logo.png' : null);
                if ($logoPath): ?>
                <img src="<?= rtrim(BASE_URL, '/') . $logoPath ?>" alt="Lighthouse" class="register-logo">
                <?php else: ?>
                <svg class="register-logo-svg" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M24 8L8 16v16h32V16L24 8z"/><path d="M24 16v16"/><path d="M8 16h32"/></svg>
                <?php endif; ?>
            </div>

            <div class="register-heading">
                <h1 class="register-title">Join the Family</h1>
                <p class="register-sub">Create your member account and connect with Lighthouse Global Church.</p>
            </div>

            <?php if ($error): ?>
            <div class="register-alert register-alert--error" role="alert">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
            <?php endif; ?>

            <form class="register-form" method="post" action="<?= $baseUrl ?>/register" novalidate>
                <?= csrf_field() ?>
                <div class="register-form-group">
                    <label for="reg-name">Full Name <span class="register-required" aria-hidden="true">*</span></label>
                    <input
                        type="text"
                        id="reg-name"
                        name="name"
                        required
                        maxlength="255"
                        placeholder="Your full name"
                        value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                        autocomplete="name"
                    >
                </div>
                <div class="register-form-group">
                    <label for="reg-email">Email Address <span class="register-required" aria-hidden="true">*</span></label>
                    <input
                        type="email"
                        id="reg-email"
                        name="email"
                        required
                        maxlength="255"
                        placeholder="you@example.com"
                        value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                        autocomplete="email"
                    >
                </div>
                <div class="register-form-row">
                    <div class="register-form-group">
                        <label for="reg-password">Password <span class="register-required" aria-hidden="true">*</span></label>
                        <div class="register-input-wrap">
                            <input
                                type="password"
                                id="reg-password"
                                name="password"
                                required
                                minlength="8"
                                placeholder="Min. 8 characters"
                                autocomplete="new-password"
                            >
                            <button type="button" class="register-toggle-pw" aria-label="Show password" data-target="reg-password">
                                <svg class="eye-show" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-hide" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="register-form-group">
                        <label for="reg-confirm">Confirm Password <span class="register-required" aria-hidden="true">*</span></label>
                        <div class="register-input-wrap">
                            <input
                                type="password"
                                id="reg-confirm"
                                name="password_confirm"
                                required
                                minlength="8"
                                placeholder="Repeat password"
                                autocomplete="new-password"
                            >
                            <button type="button" class="register-toggle-pw" aria-label="Show confirm password" data-target="reg-confirm">
                                <svg class="eye-show" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-hide" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="register-strength" id="reg-strength" aria-live="polite">
                    <div class="register-strength-bar">
                        <div class="register-strength-fill" id="reg-strength-fill"></div>
                    </div>
                    <span class="register-strength-label" id="reg-strength-label"></span>
                </div>

                <button type="submit" class="btn btn-primary register-submit">
                    Create My Account
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                </button>
            </form>

            <div class="register-footer">
                <p>Already have an account? <a href="<?= admin_url('login') ?>">Sign in</a></p>
                <p>Just visiting? <a href="<?= $baseUrl ?>/im-new">Learn what to expect</a></p>
            </div>
        </div>

        <div class="register-benefits">
            <h2 class="register-benefits-title">Why become a member?</h2>
            <ul class="register-benefits-list">
                <li>
                    <span class="register-benefit-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><path d="M12 6v6"/><path d="M9 9h6"/></svg>
                    </span>
                    <div>
                        <strong>Prayer Wall</strong>
                        <p>Post prayer points and pray alongside your church family.</p>
                    </div>
                </li>
                <li>
                    <span class="register-benefit-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>
                    </span>
                    <div>
                        <strong>Upcoming Events</strong>
                        <p>Stay up to date with all church events and activities.</p>
                    </div>
                </li>
                <li>
                    <span class="register-benefit-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                    </span>
                    <div>
                        <strong>Ministries</strong>
                        <p>Discover and connect with the ministries available to you.</p>
                    </div>
                </li>
                <li>
                    <span class="register-benefit-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </span>
                    <div>
                        <strong>Member Dashboard</strong>
                        <p>Your personalised space to manage your church journey.</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>

<script>
(function () {
    // Toggle password visibility
    document.querySelectorAll('.register-toggle-pw').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(btn.dataset.target);
            if (!input) return;
            var isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            btn.querySelector('.eye-show').style.display = isText ? '' : 'none';
            btn.querySelector('.eye-hide').style.display = isText ? 'none' : '';
            btn.setAttribute('aria-label', isText ? 'Show password' : 'Hide password');
        });
    });

    // Password strength meter
    var pwInput = document.getElementById('reg-password');
    var fill    = document.getElementById('reg-strength-fill');
    var label   = document.getElementById('reg-strength-label');
    if (pwInput && fill && label) {
        pwInput.addEventListener('input', function () {
            var val = pwInput.value;
            var score = 0;
            if (val.length >= 8) score++;
            if (val.length >= 12) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            var pct    = Math.min(100, (score / 5) * 100);
            var levels = ['', 'Weak', 'Fair', 'Good', 'Strong', 'Very strong'];
            var colors = ['', '#ef4444', '#f97316', '#eab308', '#22c55e', '#16a34a'];
            fill.style.width  = pct + '%';
            fill.style.background = colors[score] || 'transparent';
            label.textContent = val.length ? (levels[score] || '') : '';
        });
    }

    // Confirm password match indicator
    var confirmInput = document.getElementById('reg-confirm');
    if (pwInput && confirmInput) {
        function checkMatch() {
            if (!confirmInput.value) { confirmInput.style.borderColor = ''; return; }
            confirmInput.style.borderColor = confirmInput.value === pwInput.value ? '#22c55e' : '#ef4444';
        }
        confirmInput.addEventListener('input', checkMatch);
        pwInput.addEventListener('input', checkMatch);
    }
})();
</script>
<?php
$content     = ob_get_clean();
$pageTitle   = $pageTitle ?? 'Join Us – Lighthouse Global Church';
$pageDescription = 'Create your member account at Lighthouse Global Church and connect with our community.';
require APP_PATH . '/views/layouts/main.php';
?>
