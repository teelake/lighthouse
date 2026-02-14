<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Verification - Lighthouse Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'DM Sans', sans-serif; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); }
        .card { background: #fff; padding: 2.5rem; border-radius: 16px; width: 100%; max-width: 400px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }
        h1 { margin: 0 0 0.5rem; color: #0f172a; font-size: 1.5rem; font-weight: 700; }
        .sub { color: #64748b; font-size: 0.95rem; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #334155; font-size: 0.9rem; }
        input { width: 100%; padding: 0.875rem 1rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1.25rem; letter-spacing: 0.5em; text-align: center; font-family: monospace; }
        input:focus { outline: none; border-color: #ffe100; }
        button { width: 100%; padding: 0.875rem; background: #0f172a; color: #fff; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; font-size: 1rem; transition: background 0.2s; }
        button:hover { background: #1e293b; }
        .error { background: #fef2f2; color: #dc2626; padding: 0.75rem; border-radius: 10px; margin-bottom: 1rem; font-size: 0.9rem; }
        .back { display: block; margin-top: 1rem; color: #64748b; font-size: 0.9rem; text-decoration: none; }
        .back:hover { color: #0f172a; }
    </style>
</head>
<body>
    <div class="card">
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
