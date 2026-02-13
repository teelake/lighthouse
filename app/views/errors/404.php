<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Lighthouse Global Church</title>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Source Sans 3', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #FAFAF9; text-align: center; padding: 2rem; }
        h1 { font-size: 6rem; color: #ffef6c; margin: 0; }
        p { color: #5a5a5a; font-size: 1.2rem; margin: 1rem 0; }
        a { color: #ffef6c; font-weight: 600; }
    </style>
</head>
<body>
    <div>
        <h1>404</h1>
        <p>Page not found.</p>
        <a href="<?= defined('BASE_URL') ? rtrim(BASE_URL,'/') . '/' : '/' ?>">Return Home</a>
    </div>
</body>
</html>
