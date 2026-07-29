<?php
/**
 * Centralized mail (SMTP) configuration.
 *
 * PHP's built-in mail() function does NOT work inside the project's Docker
 * container (php:8.2-apache) because no MTA (sendmail/postfix) is installed
 * or configured there — mail() will always silently fail. It's also
 * unreliable on most local dev setups (XAMPP included) for the same reason.
 *
 * The fix is to send mail over real SMTP using PHPMailer instead of mail().
 * These settings are read from environment variables (same pattern as
 * config/db_config.php) so they can be supplied via docker-compose.yml in
 * Docker, or via a local .env / system environment variable when running
 * outside Docker. Sensible defaults are provided but SMTP_USER/SMTP_PASS
 * MUST be set for sending to actually work.
 */

$smtp_host      = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
$smtp_port      = getenv('SMTP_PORT') ?: 587;
// No hardcoded fallback credentials here on purpose — an old app password
// was previously committed to this file and had to be revoked. Real values
// must always come from environment variables set in Render/Docker, never
// from this source file.
$smtp_username  = getenv('SMTP_USER') ?: '';
$smtp_password  = getenv('SMTP_PASS') ?: '';
$smtp_secure    = getenv('SMTP_SECURE') ?: 'tls'; // 'tls' or 'ssl'

// Address the contact-form messages are delivered TO (the site owner).
$owner_email = getenv('OWNER_EMAIL') ?: '';
$owner_name  = getenv('OWNER_NAME') ?: 'Portfolio Contact Form';
