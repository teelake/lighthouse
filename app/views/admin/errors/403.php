<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied - Lighthouse Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'DM Sans', sans-serif; background: #f8fafc; }
        .box { text-align: center; padding: 2rem; }
        h1 { font-size: 4rem; margin: 0; color: #94a3b8; font-weight: 700; }
        p { color: #64748b; margin: 1rem 0 1.5rem; }
        a { color: #0f172a; font-weight: 600; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="box">
        <h1>403</h1>
        <p>You don't have permission to access this page.</p>
        <a href="<?= admin_url() ?>">← Back to Dashboard</a>
    </div>
</body>
</html>
