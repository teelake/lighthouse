-- Remove obsolete I'm New content sections (no longer used after restructuring)
DELETE FROM content_sections WHERE section_key = 'im_new_what_to_expect';
