-- Homepage Sections - Migration
-- Run after schema.sql to add tables and data for manageable homepage content

-- Glimpse section: scrolling image cards (row 1 = left scroll, row 2 = right scroll)
CREATE TABLE IF NOT EXISTS glimpse_slides (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    image_url VARCHAR(500) NOT NULL,
    label VARCHAR(100) NOT NULL,
    `row` TINYINT(1) DEFAULT 1 COMMENT '1=top row (scrolls left), 2=bottom row (scrolls right)',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Homepage Moments carousel: each row = one slide (small image + wide image)
CREATE TABLE IF NOT EXISTS homepage_moments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    image_small VARCHAR(500) NOT NULL,
    image_wide VARCHAR(500) NOT NULL,
    alt_small VARCHAR(255) DEFAULT '',
    alt_wide VARCHAR(255) DEFAULT '',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Seed glimpse_slides (row 1 = top/left, row 2 = bottom/right)
INSERT INTO glimpse_slides (image_url, label, `row`, sort_order) VALUES
('https://images.unsplash.com/photo-1516455590571-18256e5bb9ff?w=500', 'Worship', 1, 1),
('https://images.unsplash.com/photo-1420161900862-9a86fa1f5c79?w=500', 'Community', 1, 2),
('https://images.unsplash.com/photo-1507692049790-de58290a4334?w=500', 'Gather', 1, 3),
('https://images.unsplash.com/photo-1529070538774-1843cb3265df?w=500', 'Ministry', 1, 4),
('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=500', 'Connect', 1, 5),
('https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=500', 'Faith', 2, 1),
('https://images.unsplash.com/photo-1516455590571-18256e5bb9ff?w=500', 'Word', 2, 2),
('https://images.unsplash.com/photo-1507692049790-de58290a4334?w=500', 'Worship', 2, 3),
('https://images.unsplash.com/photo-1517451332947-b7997297e39a?w=500', 'Fellowship', 2, 4),
('https://images.unsplash.com/photo-1529070538774-1843cb3265df?w=500', 'Serve', 2, 5);

-- Seed homepage_moments
INSERT INTO homepage_moments (image_small, image_wide, alt_small, alt_wide, sort_order) VALUES
('https://images.unsplash.com/photo-1516455590571-18256e5bb9ff?w=600', 'https://images.unsplash.com/photo-1420161900862-9a86fa1f5c79?w=1200', 'Worship', 'Community', 1),
('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600', 'https://images.unsplash.com/photo-1529070538774-1843cb3265df?w=1200', 'Gathering', 'Ministry', 2),
('https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=600', 'https://images.unsplash.com/photo-1507692049790-de58290a4334?w=1200', 'Church', 'Worship service', 3);

-- Add new content sections for homepage
INSERT INTO content_sections (section_key, title, content, extra_data, sort_order) VALUES
('hero_config', 'Hero Configuration', '', '{"tagline":"A Christ-centered, Spirit-empowered ministry","pillars":["Welcome","Worship","Word"],"bg_image":"https://images.unsplash.com/photo-1507692049790-de58290a4334?w=1920","cta_watch_url":"/media","cta_visit_url":"/im-new"}', 6),
('gather_config', 'Gather With Us', '', '{"section_title":"Gather With Us","section_sub":"Join us in person or online","sunday_title":"Sunday","sunday_desc":"Catalysis — Worship that ignites faith","thursday_title":"Thursday","thursday_desc":"The Summit — Teaching & prayer"}', 7),
('lights_config', 'We Raise Lights', '', '{"headline":"We Raise Lights That Transform Nations","image":"https://images.unsplash.com/photo-1532619675605-1ede6c2ed2b0?w=900"}', 8),
('prayer_wall_config', 'Prayer Wall', '', '{"eyebrow":"Ministry","headline":"Pray With Us","description":"A digital space for church members to post prayer points and invite others to pray with them. You can share openly or post anonymously—either way, the church family stands with you in prayer."}', 9),
('newsletter_config', 'Newsletter Section', '', '{"eyebrow":"Our Newsletter","title":"Get Ministry Updates in Your Inbox","note":"Receive event updates, teachings, community highlights, and important church announcements."}', 10),
('whats_on_config', 'What''s On', '', '{"sunday_title":"Sunday — Catalysis","sunday_desc":"A catalytic worship experience designed to ignite faith.","thursday_title":"Thursday — The Summit","thursday_desc":"Elevation, encounter, empowerment. Midweek teaching."}', 11)
ON DUPLICATE KEY UPDATE sort_order = VALUES(sort_order);

-- Settings for homepage (map, images)
INSERT INTO settings (`key`, `value`, `type`) VALUES
('map_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2836.7857583703526!2d-63.6770046!3d44.68315439999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4b5a215128cb02df%3A0xf44bdaa2f32e4a51!2sThe%20LightHouse%20Global%20Ministries!5e0!3m2!1sen!2sng!4v1770960686185!5m2!1sen!2sng', 'text'),
('prayer_wall_image', 'https://images.unsplash.com/photo-1544776193-352d25ca82cd?w=800', 'text'),
('newsletter_device_image', 'https://images.unsplash.com/photo-1487014679447-9f8336841d58?w=1200', 'text')
ON DUPLICATE KEY UPDATE `key` = `key`;
