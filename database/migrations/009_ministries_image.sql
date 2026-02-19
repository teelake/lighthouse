-- Add image column to ministries for ministry photos
ALTER TABLE ministries ADD COLUMN image VARCHAR(500) NULL AFTER description;
