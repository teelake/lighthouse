<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Lighthouse Global Church</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Outfit', sans-serif; background: #f1f5f9; }
        .header { background: #0f172a; color: #fff; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .header a { color: #fff; text-decoration: none; }
        .main { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        h1 { color: #1a5f4a; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-top: 2rem; }
        .card { background: #fff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .card a { color: #1a5f4a; font-weight: 600; }
    </style>
</head>
<body>
    <header class="header">
        <a href="<?= rtrim(BASE_URL, '/') ?>/admin">Lighthouse Admin</a>
        <a href="<?= rtrim(BASE_URL, '/') ?>/">View Site</a>
        <a href="<?= rtrim(BASE_URL, '/') ?>/admin/logout">Logout</a>
    </header>
    <main class="main">
        <h1>Dashboard</h1>
        <p>Welcome to the content management system.</p>
        <div class="grid">
            <div class="card"><a href="<?= rtrim(BASE_URL, '/') ?>/admin/sections">Content Sections</a></div>
            <div class="card"><a href="<?= rtrim(BASE_URL, '/') ?>/admin/events">Events</a></div>
            <div class="card"><a href="<?= rtrim(BASE_URL, '/') ?>/admin/ministries">Ministries</a></div>
            <div class="card"><a href="<?= rtrim(BASE_URL, '/') ?>/admin/small-groups">Small Groups</a></div>
            <div class="card"><a href="<?= rtrim(BASE_URL, '/') ?>/admin/media">Media</a></div>
            <div class="card"><a href="<?= rtrim(BASE_URL, '/') ?>/admin/jobs">Jobs</a></div>
            <div class="card"><a href="<?= rtrim(BASE_URL, '/') ?>/admin/settings">Settings</a></div>
        </div>
    </main>
</body>
</html>
