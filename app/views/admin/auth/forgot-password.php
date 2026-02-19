<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Lighthouse Admin</title>
    <?php
    $faviconPath = file_exists(PUBLIC_PATH . '/images/lighthouse-logo.png') ? '/public/images/lighthouse-logo.png' : (file_exists(PUBLIC_PATH . '/images/logo.png') ? '/public/images/logo.png' : null);
    if ($faviconPath): ?>
    <link rel="icon" type="image/png" href="<?= rtrim(BASE_URL, '/') . $faviconPath ?>">
    <?php else: ?>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Cpath fill='%23b08d57' d='M16 4L4 12v12h24V12L16 4z'/%3E%3Cpath fill='none' stroke='%23b08d57' stroke-width='1.5' d='M16 12v12M4 12h24'/%3E%3C/svg%3E">
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Inter', sans-serif; background: #0d0f12; padding: 1.5rem; -webkit-font-smoothing: antialiased; }
        .auth-card { background: #fff; padding: 2.25rem; border-radius: 12px; width: 100%; max-width: 400px; box-shadow: 0 24px 48px rgba(0,0,0,0.2); }
        .auth-logo { display: flex; flex-direction: column; align-items: center; margin-bottom: 1.5rem; text-align: center; }
        .auth-logo-img { max-width: 140px; max-height: 64px; object-fit: contain; }
        .auth-logo-text { margin-top: 0.75rem; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.15em; color: #b08d57; }
        h1 { margin: 0 0 0.5rem; color: #1a1a1a; font-size: 1.25rem; font-weight: 600; }
        .sub { color: #6b7280; font-size: 0.875rem; margin-bottom: 1.25rem; }
        .form-group { margin-bottom: 1.125rem; }
        label { display: block; margin-bottom: 0.375rem; font-weight: 500; color: #4a4a4a; font-size: 0.8125rem; }
        input { width: 100%; padding: 0.5625rem 0.875rem; border: 1px solid #e8e6e3; border-radius: 6px; font-size: 0.875rem; font-family: inherit; transition: border-color 0.18s; }
        input:focus { outline: none; border-color: #b08d57; }
        button { width: 100%; padding: 0.6875rem; background: #12151a; color: #fff; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.875rem; font-family: inherit; transition: background 0.18s; }
        button:hover { background: #1a1d24; }
        .error { background: #fef2f2; color: #b91c1c; padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1rem; font-size: 0.8125rem; }
        .success { background: #f0fdf4; color: #166534; padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1rem; font-size: 0.8125rem; }
        .back { display: block; margin-top: 1rem; color: #6b7280; font-size: 0.8125rem; text-decoration: none; font-weight: 500; }
        .back:hover { color: #1a1a1a; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">
            <?php
            $logoPath = file_exists(PUBLIC_PATH . '/images/lighthouse-logo.png') ? '/public/images/lighthouse-logo.png' : (file_exists(PUBLIC_PATH . '/images/logo.png') ? '/public/images/logo.png' : null);
            if ($logoPath): ?>
            <img src="<?= rtrim(BASE_URL, '/') . $logoPath ?>" alt="Lighthouse" class="auth-logo-img">
            <?php else: ?>
            <svg class="auth-logo-img" width="120" height="48" viewBox="0 0 32 32" fill="none" stroke="#b08d57" stroke-width="1.5"><path d="M16 4L4 12v12h24V12L16 4z"/><path d="M16 12v12"/><path d="M4 12h24"/></svg>
            <?php endif; ?>
            <span class="auth-logo-text">Admin</span>
        </div>
        <h1>Forgot Password</h1>
        <p class="sub">Enter your email and we'll send you a link to reset your password.</p>
        <?php if (!empty($error)): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <?php if (!empty($success)): ?><div class="success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
        <?php if (empty($success)): ?>
        <form method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autofocus value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            <button type="submit">Send Reset Link</button>
        </form>
        <?php endif; ?>
        <a href="<?= admin_url('login') ?>" class="back">← Back to login</a>
    </div>
</body>
</html>
