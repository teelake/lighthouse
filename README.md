# Lighthouse Global Church

**thelighthouseglobal.org** — A Christ-centered, Spirit-empowered ministry equipping believers for life, leadership, and global impact.

## Stack
- PHP 8.x, MySQL
- HTML, CSS, JavaScript
- Youth-focused, modern design

## Setup

### 1. Database
```bash
# Create database and run schema
mysql -u root -p < database/schema.sql
# Or import via phpMyAdmin
```

### 2. Configuration
```bash
# Copy and edit database config
cp app/config/database.example.php app/config/database.local.php
# Set your MySQL credentials in database.local.php
```

### 3. Web Server
Point document root to `public/` or use the built-in PHP server:
```bash
cd public
php -S localhost:8080
```
Then visit http://localhost:8080

### 4. Default Admin
- URL: `/admin/login`
- Email: `admin@thelighthouseglobal.org`
- Password: `password` (change immediately in production)

## Project Structure
- `app/` — Application logic (controllers, models, views)
- `public/` — Web root (CSS, JS, images, uploads)
- `database/` — Schema and migrations

## Features
- Homepage with hero, scripture, values, events
- About, Leadership, Services, Events, Media, Ministries, Small Groups
- Giving page (PayPal & Stripe configurable)
- Prayer requests, First-time visitor form, Newsletter
- Jobs/Careers with application form
- Full admin CMS for content management
