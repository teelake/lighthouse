-- Lighthouse Global Church - Database Schema
-- Run this to create the database and tables

CREATE DATABASE IF NOT EXISTS lighthouse_church CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lighthouse_church;

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

-- Insert default content sections
INSERT INTO content_sections (section_key, title, content, sort_order) VALUES
('hero_headline', 'Hero Headline', 'Raising Lights That Transform Nations', 1),
('hero_subheadline', 'Hero Subheadline', 'A Christ-centered, Spirit-empowered ministry equipping believers for life, leadership, and global impact.', 2),
('scripture_banner', 'Scripture Banner', '"I will give You as a covenant to the people, as a light to the nations." — Isaiah 42:6', 3),
('who_we_are', 'Who We Are', 'The Lighthouse Global Ministry (Pharos Ministries) is a Spirit-led ministry commissioned to raise men and women who shine with Christ''s light—bringing transformation to lives, communities, cultures, and nations. We are a worshipping people, a teaching house, and a leadership training ground.', 4),
('footer_cta', 'Footer CTA', 'Join us. Grow with us. Shine with us.', 5);
