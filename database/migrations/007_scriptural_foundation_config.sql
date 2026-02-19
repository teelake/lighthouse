-- Scriptural Foundation config for About page (backend-managed)
INSERT INTO content_sections (section_key, title, content, extra_data, sort_order) VALUES
('scriptural_foundation_config', 'About - Scriptural Foundation', 'Our Scriptural Foundation section on the About page.', '{"scripture_1_ref":"Isaiah 42:5–11","scripture_1_desc":"God forms His people to be a light—opening blind eyes and setting captives free.","scripture_2_ref":"Isaiah 2:2–4","scripture_2_desc":"The house of the Lord is established as a center of instruction and transformation for nations."}', 17)
ON DUPLICATE KEY UPDATE extra_data = VALUES(extra_data);
