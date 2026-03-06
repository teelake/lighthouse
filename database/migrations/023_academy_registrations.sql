-- Academy registrations: sign-up form for Pharos Academies on the Membership page
CREATE TABLE IF NOT EXISTS academy_registrations (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name   VARCHAR(255) NOT NULL,
    email       VARCHAR(255) NOT NULL,
    phone       VARCHAR(100) NULL,
    academy     ENUM('membership','leadership','discipleship') NOT NULL,
    message     TEXT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
