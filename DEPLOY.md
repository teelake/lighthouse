# Deploying Lighthouse Global Church

## Option A: Dedicated Git Repo (Recommended for Server Deploy)

If you created a **separate repo** just for Lighthouse (e.g. on GitHub/GitLab):

### 1. Push to your repo
```bash
cd c:\web-projects\lighthouse
git init
git add .
git commit -m "Initial Lighthouse Global Church site"
git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO.git
git branch -M main
git push -u origin main
```

### 2. On your server (via SSH)
```bash
# Clone
cd /var/www  # or your web root
git clone https://github.com/YOUR_USERNAME/YOUR_REPO.git thelighthouseglobal
cd thelighthouseglobal

# Create database
mysql -u root -p -e "CREATE DATABASE lighthouse_church CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p lighthouse_church < database/schema.sql

# Config
cp app/config/database.example.php app/config/database.local.php
nano app/config/database.local.php   # Set host, dbname, username, password

# Permissions
chmod -R 755 .
chmod -R 775 public/uploads
```

### 3. Web server config
Point document root to the **`public`** folder:
- **Apache**: `DocumentRoot /var/www/thelighthouseglobal/public`
- **Nginx**: `root /var/www/thelighthouseglobal/public;`
- **cPanel**: Set document root to `public` subfolder

### 4. Secure
- Ensure `database.local.php` is outside web root or properly protected
- Change default admin password immediately
- Use HTTPS

---

## Option B: Deploy from Parent Repo (web-projects)

If lighthouse is inside your main web-projects repo:
```bash
cd c:\web-projects
git add lighthouse/
git commit -m "Add Lighthouse Global Church"
git push
```

On server, pull and ensure your web root includes the lighthouse folder.

---

## Subdirectory deploy (e.g. public_html/new/)
See **SUBDIRECTORY_SETUP.md**. Key steps:
1. Edit `public/.htaccess`: change `RewriteBase /` to `RewriteBase /new/public/`
2. **Create** `app/config/database.local.php` on server (copy from database.example.php, add your credentials)
3. To see errors: create empty file `DEBUG` in project root, then delete after fixing

---

## Files to NEVER commit
- `app/config/database.local.php` (contains passwords)
- `public/uploads/*` (user uploads)
- `php-error.log`

These are in `.gitignore`.
