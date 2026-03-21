-- Migration 025: Remove /new and /new/public from stored URLs (production moved to root)
-- Fixes URLs from when site was at https://domain.com/new/ or similar subdirectory.
--
-- Run: mysql -u your_user -p thelwcwm_db < database/migrations/025_fix_urls_remove_new_path.sql

-- Settings table (site_logo, site_logo_light, watch_online_url, map_embed_url, image URLs, etc.)
UPDATE settings SET `value` = REPLACE(REPLACE(`value`, '/new/public/', '/'), '/new/', '/') WHERE `value` LIKE '%/new/%';

-- Content sections (extra_data JSON may contain urls, content may have links)
UPDATE content_sections SET content = REPLACE(REPLACE(content, '/new/public/', '/'), '/new/', '/') WHERE content LIKE '%/new/%';
UPDATE content_sections SET extra_data = REPLACE(REPLACE(extra_data, '/new/public/', '/'), '/new/', '/') WHERE extra_data LIKE '%/new/%';

-- Media (embed_url, file_path, thumbnail)
UPDATE media SET embed_url = REPLACE(REPLACE(embed_url, '/new/public/', '/'), '/new/', '/') WHERE embed_url LIKE '%/new/%';
UPDATE media SET file_path = REPLACE(REPLACE(file_path, '/new/public/', '/'), '/new/', '/') WHERE file_path LIKE '%/new/%';
UPDATE media SET thumbnail = REPLACE(REPLACE(thumbnail, '/new/public/', '/'), '/new/', '/') WHERE thumbnail LIKE '%/new/%';

-- Events (image)
UPDATE events SET image = REPLACE(REPLACE(image, '/new/public/', '/'), '/new/', '/') WHERE image LIKE '%/new/%';

-- Leaders (photo)
UPDATE leaders SET photo = REPLACE(REPLACE(photo, '/new/public/', '/'), '/new/', '/') WHERE photo LIKE '%/new/%';

-- Glimpse slides (image_url)
UPDATE glimpse_slides SET image_url = REPLACE(REPLACE(image_url, '/new/public/', '/'), '/new/', '/') WHERE image_url LIKE '%/new/%';

-- Homepage moments (image_small, image_wide)
UPDATE homepage_moments SET image_small = REPLACE(REPLACE(image_small, '/new/public/', '/'), '/new/', '/') WHERE image_small LIKE '%/new/%';
UPDATE homepage_moments SET image_wide = REPLACE(REPLACE(image_wide, '/new/public/', '/'), '/new/', '/') WHERE image_wide LIKE '%/new/%';

-- Ministries (image)
UPDATE ministries SET image = REPLACE(REPLACE(image, '/new/public/', '/'), '/new/', '/') WHERE image LIKE '%/new/%';

-- Small groups (image)
UPDATE small_groups SET image = REPLACE(REPLACE(image, '/new/public/', '/'), '/new/', '/') WHERE image LIKE '%/new/%';

-- Job applications (resume_path - may be full URL)
UPDATE job_applications SET resume_path = REPLACE(REPLACE(resume_path, '/new/public/', '/'), '/new/', '/') WHERE resume_path LIKE '%/new/%';

-- Navigation menu (url)
UPDATE navigation_menu SET url = REPLACE(REPLACE(url, '/new/public/', '/'), '/new/', '/') WHERE url LIKE '%/new/%';

-- Gallery (image)
UPDATE gallery SET image = REPLACE(REPLACE(image, '/new/public/', '/'), '/new/', '/') WHERE image LIKE '%/new/%';

-- Media speakers (photo)
UPDATE media_speakers SET photo = REPLACE(REPLACE(photo, '/new/public/', '/'), '/new/', '/') WHERE photo LIKE '%/new/%';

-- Testimonials (author_photo)
UPDATE testimonials SET author_photo = REPLACE(REPLACE(author_photo, '/new/public/', '/'), '/new/', '/') WHERE author_photo LIKE '%/new/%';
