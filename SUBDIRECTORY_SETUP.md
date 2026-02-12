# Deploying in a Subdirectory (e.g. public_html/new/)

When the project is in `public_html/new/` (URL: yourdomain.com/new/):

## 1. Edit public/.htaccess
Change line 5 from:
```
RewriteBase /
```
To:
```
RewriteBase /new/public/
```

## 2. Edit root .htaccess
If the root .htaccess redirect doesn't work, you may need to point directly to public.
Or ensure the folder structure is: `new/index.php`, `new/public/`, etc.

## 3. Document root option (recommended)
Point your domain's document root to the `public` folder:
- Document root: `public_html/new/public`
Then the site loads from root and RewriteBase stays `/`

## 4. Create database.local.php on server
Copy database.example.php to database.local.php and add your credentials.
(This file is gitignored - you must create it manually on the server.)

## 5. See errors
Create an empty file named `DEBUG` in the project root to show error details.
Delete it when done for security.
