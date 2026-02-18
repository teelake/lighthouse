-- Add "Full-Time / Part-Time" as a separate job type option
ALTER TABLE jobs MODIFY COLUMN type ENUM('full-time', 'part-time', 'full-time-part-time', 'internship', 'volunteer') DEFAULT 'full-time';
