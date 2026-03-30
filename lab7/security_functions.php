<?php
// security_functions.php 

function generateCSRFToken() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCSRFToken($token) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }
    return true;
}

function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function safeGetInt($param, $default = 0) {
    if (isset($_GET[$param]) && is_numeric($_GET[$param])) {
        return (int)$_GET[$param];
    }
    return $default;
}

function safePostString($param, $default = '') {
    if (isset($_POST[$param]) && is_string($_POST[$param])) {
        return trim($_POST[$param]);
    }
    return $default;
}

function secureErrorReporting() {
    if (file_exists(__DIR__ . '/config_prod.php')) {
        error_reporting(0);
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors', 0);
        ini_set('log_errors', 1);
        ini_set('error_log', __DIR__ . '/logs/php_errors.log');
    }
}

function setSecurityHeaders() {
    header('X-XSS-Protection: 1; mode=block');
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    
    header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline';");
}

?>
