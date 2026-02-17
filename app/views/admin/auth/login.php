<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Lighthouse Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Plus Jakarta Sans', sans-serif; background: linear-gradient(160deg, #0f172a 0%, #1e293b 50%, #0c1222 100%); padding: 1.5rem; }
        .auth-card { background: #fff; padding: 2.5rem; border-radius: 16px; width: 100%; max-width: 420px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25), 0 0 0 1px rgba(255,255,255,0.05); }
        .logo { display: block; margin-bottom: 1.75rem; font-size: 1rem; font-weight: 800; letter-spacing: 0.18em; color: #facc15; }
        h1 { margin: 0 0 1.5rem; color: #0f172a; font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #334155; font-size: 0.9rem; }
        input { width: 100%; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem; font-family: inherit; transition: border-color 0.2s; }
        input:focus { outline: none; border-color: #facc15; }
        button { width: 100%; padding: 0.85rem; background: #0f172a; color: #fff; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; font-size: 1rem; font-family: inherit; transition: background 0.2s; }
        button:hover { background: #1e293b; }
        .error { background: #fef2f2; color: #dc2626; padding: 0.9rem; border-radius: 10px; margin-bottom: 1rem; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="auth-card">
        <span class="logo">LIGHTHOUSE</span>
        <h1>Sign in to admin</h1>
        <?php if (!empty($error)): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Sign In</button>
        </form>
    </div>
</body>
</html>
