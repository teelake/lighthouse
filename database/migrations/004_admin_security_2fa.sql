-- Admin security: 2FA, login rate limiting
-- Run after schema.sql

-- Add 2FA columns to users (skip if already applied)
ALTER TABLE users ADD COLUMN two_factor_secret VARCHAR(255) NULL AFTER password;
ALTER TABLE users ADD COLUMN two_factor_enabled TINYINT(1) DEFAULT 0 AFTER two_factor_secret;

-- Login attempts for rate limiting (by IP)
CREATE TABLE IF NOT EXISTS login_attempts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    attempted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_ip_time (ip_address, attempted_at)
);

-- Ensure users has correct role enum (member, editor, admin)
ALTER TABLE users MODIFY COLUMN role ENUM('member', 'editor', 'admin') DEFAULT 'editor';
