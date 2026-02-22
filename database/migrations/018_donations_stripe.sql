-- Donations (Stripe payments)
CREATE TABLE IF NOT EXISTS donations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    stripe_session_id VARCHAR(255) UNIQUE,
    amount_cents INT UNSIGNED NOT NULL,
    currency VARCHAR(3) DEFAULT 'cad',
    designation VARCHAR(100) NOT NULL,
    purpose TEXT,
    donor_name VARCHAR(255),
    donor_email VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
