<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Verification - Lighthouse Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Inter', sans-serif; background: #0d0f12; padding: 1.5rem; -webkit-font-smoothing: antialiased; }
        .auth-card { background: #fff; padding: 2.25rem; border-radius: 12px; width: 100%; max-width: 400px; box-shadow: 0 24px 48px rgba(0,0,0,0.2); }
        .logo { display: block; margin-bottom: 1rem; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.2em; color: #b08d57; }
        h1 { margin: 0 0 0.5rem; color: #1a1a1a; font-size: 1.25rem; font-weight: 600; letter-spacing: -0.01em; }
        .sub { color: #6b7280; font-size: 0.875rem; margin-bottom: 1.25rem; }
        .form-group { margin-bottom: 1.125rem; }
        label { display: block; margin-bottom: 0.375rem; font-weight: 500; color: #4a4a4a; font-size: 0.8125rem; }
        input { width: 100%; padding: 0.75rem 1rem; border: 1px solid #e8e6e3; border-radius: 6px; font-size: 1.125rem; letter-spacing: 0.4em; text-align: center; font-family: ui-monospace, monospace; }
        input:focus { outline: none; border-color: #b08d57; }
        button { width: 100%; padding: 0.6875rem; background: #12151a; color: #fff; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.875rem; font-family: inherit; transition: background 0.18s; }
        button:hover { background: #1a1d24; }
        .error { background: #fef2f2; color: #b91c1c; padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1rem; font-size: 0.8125rem; }
        .back { display: block; margin-top: 1rem; color: #6b7280; font-size: 0.8125rem; text-decoration: none; font-weight: 500; }
        .back:hover { color: #1a1a1a; }
    </style>
</head>
<body>
    <div class="auth-card">
        <h1>Two-Factor Authentication</h1>
        <p class="sub">Enter the 6-digit code from your authenticator app</p>
        <?php if (!empty($error)): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="post" autocomplete="off">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="code">Verification code</label>
                <input type="text" id="code" name="code" inputmode="numeric" pattern="[0-9]*" maxlength="6" placeholder="000000" required autofocus>
            </div>
            <button type="submit">Verify</button>
        </form>
        <a href="<?= admin_url('login') ?>" class="back">← Back to login</a>
    </div>
</body>
</html>
