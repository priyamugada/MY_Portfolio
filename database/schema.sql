-- Database schema for MY_Portfolio
-- This file was MISSING from the original project, which is why a fresh
-- XAMPP install had no database/tables to connect to. Import this once
-- (phpMyAdmin -> Import, or the mysql CLI) before running the site.

CREATE DATABASE IF NOT EXISTS myportfolio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE myportfolio;

CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    domain_name VARCHAR(100) NOT NULL,
    title VARCHAR(150) NOT NULL,
    technologies TEXT,
    description TEXT,
    project_link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS technical_skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    programming_language VARCHAR(100) NOT NULL,
    proficiency VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS soft_skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    skills VARCHAR(100) NOT NULL,
    proficiency VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS certifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    organization VARCHAR(150) NOT NULL,
    issue_date DATE NOT NULL,
    certificate_link VARCHAR(255),
    certificate_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Optional starter data so the page isn't empty on first run.
-- Feel free to delete these rows and use the "Add" buttons on the site instead.
INSERT INTO technical_skills (programming_language, proficiency) VALUES
    ('Python', 'Advanced'),
    ('JavaScript', 'Intermediate'),
    ('Java', 'Intermediate');

INSERT INTO soft_skills (skills, proficiency) VALUES
    ('Communication', 'Advanced'),
    ('Teamwork', 'Advanced');
