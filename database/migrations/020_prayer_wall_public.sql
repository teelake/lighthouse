-- Prayer wall: public for members and non-members
-- Add author_name for guests, is_archived for admin, user_id nullable
ALTER TABLE prayer_wall
  ADD COLUMN author_name VARCHAR(255) NULL AFTER user_id,
  ADD COLUMN is_archived TINYINT(1) DEFAULT 0 AFTER is_anonymous,
  ADD COLUMN archived_at TIMESTAMP NULL AFTER is_archived,
  MODIFY COLUMN user_id INT UNSIGNED NULL;
