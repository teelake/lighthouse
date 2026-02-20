-- I'm New page: Watch Online and Connect with Us sections (admin-editable)
-- Plan Your Visit uses im_new_expect (from migration 003)
INSERT INTO content_sections (section_key, title, content, extra_data, sort_order) VALUES
('im_new_watch_online', 'I\'m New - Watch Online', 'Can''t join in person? Browse our archived teachings and sermons from anywhere.', NULL, 23),
('im_new_connect', 'I\'m New - Connect with Us', 'Join us for newcomers'' lunch, small group registration, and getting connected. Stop by the Welcome Station after service.', NULL, 24)
ON DUPLICATE KEY UPDATE content = VALUES(content), sort_order = VALUES(sort_order);
