-- Core Values config for About page (backend-managed list)
INSERT INTO content_sections (section_key, title, content, extra_data, sort_order) VALUES
('core_values_config', 'Core Values', 'List of core values displayed on the About page.', '{"value_1_title":"Audacity","value_1_desc":"Faith that dares the impossible.","value_2_title":"Hospitality","value_2_desc":"Warmth, service, and belonging.","value_3_title":"Leadership","value_3_desc":"Responsibility, influence, and stewardship."}', 18)
ON DUPLICATE KEY UPDATE extra_data = VALUES(extra_data);
