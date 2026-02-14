-- Content sections for I'm New, Services, Membership pages (admin-editable)
INSERT INTO content_sections (section_key, title, content, extra_data, sort_order) VALUES
('im_new_intro', 'I\'m New - Intro', 'At Lighthouse, you\'re not just welcome—you\'re celebrated. No matter where you are in life or your faith journey, there\'s a place for you here. Whether you\'re exploring faith for the first time or looking for a church home, we\'re here to walk with you.', NULL, 20),
('im_new_expect', 'I\'m New - Plan Visit Note', 'Join us Sunday at 10:00 AM or Thursday at 6:00 PM. We meet at Holiday Inn & Suites, 980 Parkland Drive, Halifax.', NULL, 21),
('services_intro', 'Services - Intro', 'We gather to worship, grow in the Word, and be equipped for life and leadership. Whether you prefer Sunday morning or Thursday evening, there\'s a service for you.', NULL, 22),
('membership_intro', 'Membership - Intro', 'Pharos Ministries offers structured pathways for membership, discipleship, and leadership development. Whether you\'re new to faith or ready to step into greater responsibility, our academies are designed to equip you for impact.', NULL, 23),
('membership_pharos', 'Membership - Pharos Academy', 'Become a covenant member of Lighthouse. Learn our values, vision, and commitment to one another. Membership connects you to the family and opens doors for service.', NULL, 24),
('membership_leadership', 'Membership - Leadership Academy', 'For those called to lead. Develop character, vision, and practical skills to serve in ministry and beyond.', NULL, 25),
('membership_discipleship', 'Membership - Discipleship Academy', 'Go deeper in your walk with Christ. Systematic teaching, accountability, and practical application for everyday life.', NULL, 26),
('giving_intro', 'Giving - Intro', 'Giving is an act of worship and a covenant partnership in advancing God\'s kingdom. Your generosity supports teaching and discipleship, leadership development, outreach and missions, and ministry operations. Thank you for investing in what God is doing through Lighthouse.', NULL, 27),
('giving_ways', 'Giving - Other Ways', 'For bank transfers or other giving methods, please contact us.', NULL, 28),
('prayer_intro', 'Prayer - Intro', 'Share your prayer need with us. You can request prayer openly or anonymously. Our pastoral team and prayer intercessors will pray with you.', NULL, 29)
ON DUPLICATE KEY UPDATE sort_order = VALUES(sort_order);
