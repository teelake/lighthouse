-- Enhance job_applications for full application flow
ALTER TABLE job_applications
    ADD COLUMN first_name VARCHAR(255) NULL AFTER id,
    ADD COLUMN last_name VARCHAR(255) NULL AFTER first_name,
    ADD COLUMN age_range VARCHAR(30) NULL AFTER phone,
    ADD COLUMN engagement_type VARCHAR(50) NULL AFTER age_range,
    ADD COLUMN job_title VARCHAR(255) NULL AFTER job_id;
