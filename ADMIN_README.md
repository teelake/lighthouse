# Lighthouse Admin Backend

## Admin URL

The admin panel uses a **custom, non-guessable URL** for security:

**Default path:** `cp-X7k9m2P4q1a3`

- Full URL example: `https://yoursite.com/cp-X7k9m2P4q1a3`
- **Bookmark this URL** — it is not linked from the public site
- Change it via the `ADMIN_PATH` environment variable or in `app/config/config.php`

## Security Features

1. **Custom admin path** — Not `/admin`; harder to guess
2. **2FA (Two-Factor Authentication)** — TOTP (Google Authenticator compatible)
3. **Role-based access:**
   - **Member** — Dashboard only (view)
   - **Editor** — Content management (sections, leaders, events, ministries, etc.)
   - **Admin** — Full access including users and settings
4. **CSRF protection** on all forms
5. **Rate limiting** on login (5 attempts per 15 min per IP)
6. **Secure sessions** — HttpOnly, SameSite

## Setup

1. Run migrations (including 004 for 2FA):
   ```bash
   mysql -u user -p database < database/migrations/004_admin_security_2fa.sql
   ```

2. Default admin login (change password immediately):
   - Email: `admin@thelighthouseglobal.org`
   - Password: `admin123`

3. Enable 2FA: Sign in → Profile → Enable 2FA → Scan QR with Authenticator app

## Changing the Admin Path

In `app/config/config.php`:
```php
define('ADMIN_PATH', 'your-custom-path-here');
```

Or set environment variable `ADMIN_PATH`.
