<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'cargo');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);

// Timezone
date_default_timezone_set('UTC');

// Base URL
define('BASE_URL', 'http://localhost/cargo');

// Upload paths
define('UPLOAD_PATH', __DIR__ . '/../uploads/');
define('PHOTO_PATH', __DIR__ . '/../photo/');

// Create upload directories if they don't exist
if (!file_exists(UPLOAD_PATH)) {
    mkdir(UPLOAD_PATH, 0755, true);
}
if (!file_exists(PHOTO_PATH)) {
    mkdir(PHOTO_PATH, 0755, true);
}
?> 