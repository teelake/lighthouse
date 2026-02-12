<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error | Lighthouse Global Church</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Outfit', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f8fafc; text-align: center; padding: 2rem; }
        h1 { color: #1a5f4a; }
        p { color: #64748b; }
        a { color: #1a5f4a; font-weight: 600; }
    </style>
</head>
<body>
    <div>
        <h1>Something went wrong</h1>
        <p>We're sorry. Please try again later.</p>
        <a href="<?= defined('BASE_URL') ? rtrim(BASE_URL,'/') . '/' : '/' ?>">Return Home</a>
    </div>
</body>
</html>
