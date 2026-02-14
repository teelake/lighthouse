# Lighthouse Admin Backend

## Admin URL

**Path:** `/admin`

- Full URL example: `https://yoursite.com/admin`
- Change via the `ADMIN_PATH` environment variable or in `app/config/config.php` if needed


## Security Features

1. **2FA (Two-Factor Authentication)** — TOTP (Google Authenticator compatible)
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
   - Password: `password` (from schema.sql)
   - To set a different default (e.g. admin123), run: `php scripts/reset-admin-password.php`

3. Enable 2FA: Sign in → Profile → Enable 2FA → Scan QR with Authenticator app
