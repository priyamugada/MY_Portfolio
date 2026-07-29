<?php
/**
 * Centralized database configuration.
 *
 * Every part of the site (index1.php + all api/*.php files) now includes
 * THIS single file instead of hard-coding its own credentials.
 * Previously index1.php connected to "localhost" (XAMPP) while every
 * api/*.php file was hard-coded to a remote InfinityFree hosting database.
 * That mismatch meant "Add Project / Add Skill / Add Certification" could
 * never work on a local XAMPP install (and leaked live hosting credentials
 * in the repo). Fix: one file, one source of truth.
 *
 * Defaults below work out-of-the-box with XAMPP (root user, no password).
 * The getenv() calls let the SAME code work unchanged inside Docker
 * (see docker-compose.yml), where DB_HOST etc. are supplied as environment
 * variables pointing at the "db" container instead of "localhost".
 */

$db_host     = getenv('DB_HOST') ?: 'localhost';
$db_username = getenv('DB_USER') ?: 'root';
$db_password = getenv('DB_PASS') ?: '';
$db_name     = getenv('DB_NAME') ?: 'myportfolio';
$db_port     = getenv('DB_PORT') ?: 3306;

// Hosted MySQL providers such as Aiven require an SSL connection.
// Set DB_SSL=true as an environment variable when connecting to one of
// those (leave it unset for XAMPP/Docker local MySQL, which don't need it).
$db_ssl = filter_var(getenv('DB_SSL') ?: false, FILTER_VALIDATE_BOOLEAN);

if ($db_ssl) {
    $conn = mysqli_init();
    // No CA file supplied here, so the server certificate isn't verified —
    // this matches Aiven's "ssl-mode=REQUIRED" (encrypted, not fully verified).
    mysqli_ssl_set($conn, null, null, null, null, null);
    @mysqli_real_connect(
        $conn,
        $db_host,
        $db_username,
        $db_password,
        $db_name,
        (int) $db_port,
        null,
        MYSQLI_CLIENT_SSL
    );
} else {
    $conn = @mysqli_connect($db_host, $db_username, $db_password, $db_name, (int) $db_port);
}

if ($conn) {
    mysqli_set_charset($conn, 'utf8mb4');
}
