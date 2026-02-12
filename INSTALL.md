# Installation

## 1. Database
Create MySQL database and import schema:
```sql
CREATE DATABASE lighthouse_church CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
Then run the SQL in `database/schema.sql` (or use phpMyAdmin/MySQL Workbench).

## 2. Config
Copy `app/config/database.example.php` to `app/config/database.local.php` and set your credentials:
```php
return [
    'host' => 'localhost',
    'dbname' => 'lighthouse_church',
    'username' => 'your_user',
    'password' => 'your_password',
    'charset' => 'utf8mb4',
    'options' => [...]
];
```

## 3. Web Server
### Option A: Apache
Point document root to the `public` folder. Enable mod_rewrite.

### Option B: PHP Built-in Server
```bash
cd public
php -S localhost:8080
```
Visit http://localhost:8080

## 4. Admin Access
- URL: `/admin/login`
- Default: admin@thelighthouseglobal.org / password
- **Change password after first login!** (Update in database: use `password_hash('your_new_password', PASSWORD_DEFAULT)`)

## 5. Logo
Place your logo PNG at `public/images/logo.png` (recommended height: 48px).
