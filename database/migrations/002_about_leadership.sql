-- About & Leadership - Migration
-- Run to add leaders table and about page content sections

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

INSERT INTO content_sections (section_key, title, content, extra_data, sort_order) VALUES
('about_intro', 'About Page Intro', 'The Lighthouse Global Ministry (Pharos Ministries) is a Spirit-led ministry commissioned to raise men and women who shine with Christ''s light—bringing transformation to lives, communities, cultures, and nations.', NULL, 12),
('about_mission', 'Our Mission', 'To raise lights that transform nations by equipping believers for life, leadership, and global impact through worship, the Word, and intentional discipleship.', NULL, 13),
('about_vision', 'Our Vision', 'A Christ-centered, Spirit-empowered community where every believer shines as a light—transforming lives, families, communities, and nations for the glory of God.', NULL, 14),
('about_values', 'Our Values', 'We are a worshipping people, a teaching house, and a leadership training ground. We believe in the authority of Scripture, the power of the Holy Spirit, and the mandate to make disciples of all nations.', NULL, 15)
ON DUPLICATE KEY UPDATE sort_order = VALUES(sort_order);

INSERT INTO leaders (name, title, photo, bio, sort_order) VALUES
('Pastor Olabanji Afolabi', 'Lead Pastor', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400', 'Pastor Olabanji leads Lighthouse with a passion for raising leaders who impact their spheres with the light of Christ.', 1),
('Pastor Damilola Afolabi', 'Co-Lead Pastor', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400', 'Pastor Damilola co-leads the ministry with a heart for worship, discipleship, and family transformation.', 2);
