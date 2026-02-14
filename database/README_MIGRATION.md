# Homepage Admin Migration

To enable full homepage content management, run the migration:

**Option A – Fresh install:** Run the full `schema.sql` (it now includes the new tables and seed data).

**Option B – Existing database:** Run migrations in order:

```bash
mysql -u your_user -p thelwcwm_db < database/migrations/001_homepage_sections.sql
mysql -u your_user -p thelwcwm_db < database/migrations/002_about_leadership.sql
```

## What's New

### Database

- **glimpse_slides** – Scrolling image cards (row 1 = left scroll, row 2 = right scroll)
- **homepage_moments** – Moments carousel slides (small + wide image per slide)
- **content_sections** – New keys: `hero_config`, `gather_config`, `lights_config`, `prayer_wall_config`, `newsletter_config`, `whats_on_config`
- **settings** – New keys: `map_embed_url`, `prayer_wall_image`, `newsletter_device_image`, `service_sunday`, `service_thursday`

### Admin Routes

- `/admin/glimpse` – Glimpse section slides
- `/admin/moments` – Moments carousel
- `/admin/testimonials` – Voice section testimonials
- `/admin/settings/homepage` – Map embed, images, service times
- `/admin/sections` – Content sections (including new config sections)
