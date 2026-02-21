-- Restore What to Expect bullets section (used on I'm New page)
INSERT INTO content_sections (section_key, title, content, extra_data, sort_order) VALUES
('im_new_what_to_expect', 'I\'m New - What to Expect', '<ul><li>Engaging worship experiences that blend contemporary music with heartfelt moments.</li><li>Biblically rooted messages that inspire practical application in everyday life.</li><li>Fun and safe programs for kids of all ages.</li></ul>', NULL, 22)
ON DUPLICATE KEY UPDATE content = VALUES(content), sort_order = VALUES(sort_order);
