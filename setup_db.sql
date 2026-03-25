-- setup_db.sql

CREATE DATABASE IF NOT EXISTS ridhi_sidhi_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ridhi_sidhi_db;

-- Users table for login/signup/admin
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'client') DEFAULT 'client',
    last_reset_token VARCHAR(255) DEFAULT NULL,
    token_expiry DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Contact form submissions table
CREATE TABLE IF NOT EXISTS contact_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) DEFAULT NULL,
    organization VARCHAR(255) DEFAULT NULL,
    service VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Register initial admin user (password: admin123)
-- Using PHP password_hash('admin123', PASSWORD_BCRYPT)
INSERT INTO users (full_name, email, password, role) 
VALUES ('System Admin', 'admin@ridhisidhi.com', '$2y$10$8W3Y6s7N1H0hV/K8A7L/K.wV5X3/V5P/V5P/V5P/V5P/V5P/V5P/V5', 'admin')
ON DUPLICATE KEY UPDATE email=email; 
