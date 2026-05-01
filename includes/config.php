<?php
// Prevent direct access issues
if (session_status() === PHP_SESSION_NONE) {

    // Session security (MUST be before session_start)
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);

    session_start();
}

// Absolute project root
define('ROOT_PATH', __DIR__ . '/../');

// App info
define('APP_NAME', 'EliteWear');

// Base URL
define('BASE_URL', 'http://localhost/clothing_store');

// Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'clothing_store');

// Error handling
// Log errors instead of displaying them in production
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Admin registration code (change this in production to a strong, unique value)
define('ADMIN_REG_CODE', 'change_me_in_production_' . bin2hex(random_bytes(16)));

// Placeholder image for any broken/missing assets
// using a simple external service; change to local file if desired
if (!defined('PLACEHOLDER_IMG')) {
    define('PLACEHOLDER_IMG', 'https://via.placeholder.com/600x400?text=No+Image');
}
