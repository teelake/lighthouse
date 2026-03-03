-- Online testimonies: user-submitted stories (no login required)
-- Separate from admin-curated testimonials on homepage
CREATE TABLE IF NOT EXISTS testimonies (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    author_name VARCHAR(255) NULL,
    is_anonymous TINYINT(1) DEFAULT 0,
    is_archived TINYINT(1) DEFAULT 0,
    archived_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Optional intro text for testimonies page (editable in Sections)
INSERT INTO content_sections (section_key, title, content, extra_data, sort_order) VALUES
('testimonies_intro', 'Testimonies - Intro', 'Share how God has worked in your life. Your story can encourage others. No login required—post openly or anonymously.', NULL, 30)
ON DUPLICATE KEY UPDATE sort_order = VALUES(sort_order);
