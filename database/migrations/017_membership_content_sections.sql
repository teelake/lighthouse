-- Membership & Training page content sections (Pharos Academies)
-- Ensures sections exist and updates with proposed content
INSERT INTO content_sections (section_key, title, content, extra_data, sort_order) VALUES
('membership_intro', 'Membership - Intro', 'We believe every believer is called to grow, be discipled, and be equipped for impact.', NULL, 23),
('membership_pharos', 'Membership - Pharos Membership Academy', 'A foundational pathway for identity, doctrine, values, and belonging.', NULL, 24),
('membership_leadership', 'Membership - Pharos Leadership Academy', 'Leadership development for ministry, marketplace, and societal influence.', NULL, 25),
('membership_discipleship', 'Membership - Pharos Discipleship Academy', 'Deep spiritual formation focused on Christlikeness, discipline, and deployment.', NULL, 26)
ON DUPLICATE KEY UPDATE title = VALUES(title), content = VALUES(content);
