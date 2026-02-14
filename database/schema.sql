-- Lighthouse Global Church - Database Schema
-- Run this to create the database and tables

CREATE DATABASE IF NOT EXISTS thelwcwm_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE thelwcwm_db;

-- Admin users
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor', 'member') DEFAULT 'editor',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Key-value settings (payment, email, social, etc.)
CREATE TABLE settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(100) NOT NULL UNIQUE,
    `value` TEXT,
    type ENUM('text', 'textarea', 'json', 'number', 'boolean') DEFAULT 'text',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Content sections (hero, scripture banner, about, etc.)
CREATE TABLE content_sections (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    section_key VARCHAR(80) NOT NULL UNIQUE,
    title VARCHAR(255),
    content TEXT,
    extra_data JSON,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Events
CREATE TABLE events (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    event_date DATE,
    event_time TIME,
    end_time TIME,
    location VARCHAR(500),
    image VARCHAR(500),
    event_type ENUM('monthly', 'quarterly', 'annual', 'weekly', 'one-time') DEFAULT 'one-time',
    is_featured TINYINT(1) DEFAULT 0,
    is_published TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Ministries
CREATE TABLE ministries (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    tagline VARCHAR(255),
    description TEXT,
    image VARCHAR(500),
    sort_order INT DEFAULT 0,
    is_published TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Small groups
CREATE TABLE small_groups (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    tagline VARCHAR(255),
    description TEXT,
    target_age VARCHAR(50),
    image VARCHAR(500),
    sort_order INT DEFAULT 0,
    is_published TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Media series (for filtering sermons)
CREATE TABLE media_series (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Media topics
CREATE TABLE media_topics (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Media speakers
CREATE TABLE media_speakers (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    photo VARCHAR(500),
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Media (sermons, teachings)
CREATE TABLE media (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    description TEXT,
    media_type ENUM('video', 'audio', 'teaching') NOT NULL,
    source ENUM('youtube', 'vimeo', 'upload', 'external') DEFAULT 'youtube',
    embed_url VARCHAR(500),
    file_path VARCHAR(500),
    thumbnail VARCHAR(500),
    series_id INT UNSIGNED,
    speaker_id INT UNSIGNED,
    topic_id INT UNSIGNED,
    published_at DATE,
    duration VARCHAR(20),
    sort_order INT DEFAULT 0,
    is_published TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_slug (slug, media_type),
    FOREIGN KEY (series_id) REFERENCES media_series(id) ON DELETE SET NULL,
    FOREIGN KEY (speaker_id) REFERENCES media_speakers(id) ON DELETE SET NULL,
    FOREIGN KEY (topic_id) REFERENCES media_topics(id) ON DELETE SET NULL
);

-- Jobs
CREATE TABLE jobs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    type ENUM('full-time', 'part-time', 'internship', 'volunteer') DEFAULT 'full-time',
    description TEXT,
    responsibilities TEXT,
    ideal_candidate TEXT,
    is_published TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Job applications
CREATE TABLE job_applications (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id INT UNSIGNED,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    message TEXT,
    resume_path VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE SET NULL
);

-- Prayer requests (form submissions)
CREATE TABLE prayer_requests (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    request TEXT NOT NULL,
    is_confidential TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Prayer wall (member posts - requires login)
CREATE TABLE prayer_wall (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED,
    request TEXT NOT NULL,
    is_anonymous TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- First-time visitors
CREATE TABLE first_time_visitors (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Newsletter subscribers
CREATE TABLE newsletter_subscribers (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- FAQs
CREATE TABLE faqs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(500) NOT NULL,
    answer TEXT NOT NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Gallery
CREATE TABLE gallery (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    image VARCHAR(500) NOT NULL,
    caption TEXT,
    album VARCHAR(100),
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Testimonials
CREATE TABLE testimonials (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    quote TEXT NOT NULL,
    author_name VARCHAR(255) NOT NULL,
    author_photo VARCHAR(500),
    sort_order INT DEFAULT 0,
    is_published TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Navigation menu items
CREATE TABLE navigation_menu (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    parent_id INT UNSIGNED DEFAULT 0,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(500),
    sort_order INT DEFAULT 0,
    is_external TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES navigation_menu(id) ON DELETE CASCADE
);

-- Insert default admin (password: admin123 - CHANGE IN PRODUCTION)
INSERT INTO users (email, password, name, role) VALUES
('admin@thelighthouseglobal.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'admin');

-- Glimpse section: scrolling image cards (row 1 = left scroll, row 2 = right scroll)
CREATE TABLE IF NOT EXISTS glimpse_slides (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    image_url VARCHAR(500) NOT NULL,
    label VARCHAR(100) NOT NULL,
    `row` TINYINT(1) DEFAULT 1 COMMENT '1=top row, 2=bottom row',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Homepage Moments carousel (small + wide images per slide)
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

-- Insert default content sections
INSERT INTO content_sections (section_key, title, content, extra_data, sort_order) VALUES
('hero_headline', 'Hero Headline', 'Raising Lights That Transform Nations', NULL, 1),
('hero_subheadline', 'Hero Subheadline', 'A Christ-centered, Spirit-empowered ministry equipping believers for life, leadership, and global impact.', NULL, 2),
('scripture_banner', 'Scripture Banner', '"I will give You as a covenant to the people, as a light to the nations." — Isaiah 42:6', NULL, 3),
('who_we_are', 'Who We Are', 'The Lighthouse Global Ministry (Pharos Ministries) is a Spirit-led ministry commissioned to raise men and women who shine with Christ''s light—bringing transformation to lives, communities, cultures, and nations. We are a worshipping people, a teaching house, and a leadership training ground.', NULL, 4),
('footer_cta', 'Footer CTA', 'Join us. Grow with us. Shine with us.', NULL, 5),
('hero_config', 'Hero Configuration', '', '{"tagline":"A Christ-centered, Spirit-empowered ministry","pillars":["Welcome","Worship","Word"],"bg_image":"https://images.unsplash.com/photo-1507692049790-de58290a4334?w=1920","cta_watch_url":"/media","cta_visit_url":"/im-new"}', 6),
('gather_config', 'Gather With Us', '', '{"section_title":"Gather With Us","section_sub":"Join us in person or online","sunday_title":"Sunday","sunday_desc":"Catalysis — Worship that ignites faith","thursday_title":"Thursday","thursday_desc":"The Summit — Teaching & prayer"}', 7),
('lights_config', 'We Raise Lights', '', '{"headline":"We Raise Lights That Transform Nations","image":"https://images.unsplash.com/photo-1532619675605-1ede6c2ed2b0?w=900"}', 8),
('prayer_wall_config', 'Prayer Wall', '', '{"eyebrow":"Ministry","headline":"Pray With Us","description":"A digital space for church members to post prayer points and invite others to pray with them. You can share openly or post anonymously—either way, the church family stands with you in prayer."}', 9),
('newsletter_config', 'Newsletter Section', '', '{"eyebrow":"Our Newsletter","title":"Get Ministry Updates in Your Inbox","note":"Receive event updates, teachings, community highlights, and important church announcements."}', 10),
('whats_on_config', 'What''s On', '', '{"sunday_title":"Sunday — Catalysis","sunday_desc":"A catalytic worship experience designed to ignite faith.","thursday_title":"Thursday — The Summit","thursday_desc":"Elevation, encounter, empowerment. Midweek teaching."}', 11)
ON DUPLICATE KEY UPDATE sort_order = VALUES(sort_order);

-- Seed glimpse_slides
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

-- Leadership team
CREATE TABLE IF NOT EXISTS leaders (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    photo VARCHAR(500),
    bio TEXT,
    sort_order INT DEFAULT 0,
    is_published TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- About page content
INSERT INTO content_sections (section_key, title, content, extra_data, sort_order) VALUES
('about_intro', 'About Page Intro', 'The Lighthouse Global Ministry (Pharos Ministries) is a Spirit-led ministry commissioned to raise men and women who shine with Christ''s light—bringing transformation to lives, communities, cultures, and nations.', NULL, 12),
('about_mission', 'Our Mission', 'To raise lights that transform nations by equipping believers for life, leadership, and global impact through worship, the Word, and intentional discipleship.', NULL, 13),
('about_vision', 'Our Vision', 'A Christ-centered, Spirit-empowered community where every believer shines as a light—transforming lives, families, communities, and nations for the glory of God.', NULL, 14),
('about_values', 'Our Values', 'We are a worshipping people, a teaching house, and a leadership training ground. We believe in the authority of Scripture, the power of the Holy Spirit, and the mandate to make disciples of all nations.', NULL, 15)
ON DUPLICATE KEY UPDATE sort_order = VALUES(sort_order);

INSERT INTO leaders (name, title, photo, bio, sort_order) VALUES
('Pastor Olabanji Afolabi', 'Lead Pastor', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400', 'Pastor Olabanji leads Lighthouse with a passion for raising leaders who impact their spheres with the light of Christ.', 1),
('Pastor Damilola Afolabi', 'Co-Lead Pastor', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400', 'Pastor Damilola co-leads the ministry with a heart for worship, discipleship, and family transformation.', 2);

-- Homepage settings
INSERT INTO settings (`key`, `value`, `type`) VALUES
('map_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2836.7857583703526!2d-63.6770046!3d44.68315439999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4b5a215128cb02df%3A0xf44bdaa2f32e4a51!2sThe%20LightHouse%20Global%20Ministries!5e0!3m2!1sen!2sng!4v1770960686185!5m2!1sen!2sng', 'text'),
('prayer_wall_image', 'https://images.unsplash.com/photo-1544776193-352d25ca82cd?w=800', 'text'),
('newsletter_device_image', 'https://images.unsplash.com/photo-1487014679447-9f8336841d58?w=1200', 'text')
ON DUPLICATE KEY UPDATE `key` = `key`;
