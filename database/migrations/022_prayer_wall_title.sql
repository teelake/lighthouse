-- Prayer wall: add title/subject field for prayer posts
ALTER TABLE prayer_wall
  ADD COLUMN title VARCHAR(100) NULL AFTER id;
