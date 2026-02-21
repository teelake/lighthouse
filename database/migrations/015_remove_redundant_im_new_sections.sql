-- Remove redundant I'm New content sections (no longer used after page restructure)
-- USED: im_new_intro, im_new_arrive, im_new_service, im_new_after, im_new_what_to_expect
DELETE FROM content_sections WHERE section_key IN (
    'im_new_expect',           -- Plan Visit Note (was in removed CTA card)
    'im_new_arrive_summary',   -- Replaced by full im_new_arrive content
    'im_new_service_summary',  -- Replaced by full im_new_service content
    'im_new_after_summary',    -- Replaced by full im_new_after content
    'im_new_watch_online',     -- Was in removed Watch Online card
    'im_new_connect'           -- Was in removed Connect with Us card
);
