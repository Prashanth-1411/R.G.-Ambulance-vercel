<?php
// ============================================
// R.G. Ambulance Service - Configuration
// ============================================

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'rg_ambulance');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Site URLs
define('BASE_URL', 'http://localhost/R.G.-Ambulance-master');
define('ADMIN_URL', BASE_URL . '/admin');
define('UPLOAD_URL', BASE_URL . '/uploads');

// File Paths
define('ROOT_PATH', dirname(__DIR__));
define('UPLOAD_PATH', ROOT_PATH . '/uploads');
define('ADMIN_PATH', ROOT_PATH . '/admin');

// Upload Limits
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_EXTENSIONS', 'jpg,jpeg,png,gif,webp,pdf,doc,docx');

// Session
define('SESSION_LIFETIME', 86400); // 24 hours
define('CSRF_TOKEN_NAME', 'csrf_token');

// Pagination
define('ITEMS_PER_PAGE', 10);

// App Name
define('APP_NAME', 'R.G. Ambulance Service CMS');
