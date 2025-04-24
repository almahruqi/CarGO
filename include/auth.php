<?php
session_start();

// Security headers
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline';");

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['id']) && !empty($_SESSION['id']);
}

// Function to check if user is admin
function isAdmin() {
    return isLoggedIn() && $_SESSION['role'] === 'admin';
}

// Function to require login
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header('Location: /login.php');
        exit;
    }
}

// Function to require admin access
function requireAdmin() {
    if (!isAdmin()) {
        header('Location: /index.php');
        exit;
    }
}

// Function to generate CSRF token
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Function to validate CSRF token
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Function to sanitize input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to validate email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate password strength
function isPasswordStrong($password) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
}

// Function to hash password
function hashPassword($password) {
    return password_hash($password, PASSWORD_ARGON2ID);
}

// Function to verify password
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Function to log user activity
function logActivity($userId, $action, $details = '') {
    global $con;
    $ip = $_SERVER['REMOTE_ADDR'];
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $sql = "INSERT INTO user_activity (user_id, action, details, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "issss", $userId, $action, $details, $ip, $userAgent);
    mysqli_stmt_execute($stmt);
}

// Function to check for brute force attempts
function checkBruteForce($userId) {
    global $con;
    $ip = $_SERVER['REMOTE_ADDR'];
    $time = time() - 300; // 5 minutes ago
    
    $sql = "SELECT COUNT(*) as attempts FROM login_attempts WHERE user_id = ? AND ip_address = ? AND attempt_time > ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "isi", $userId, $ip, $time);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    return $row['attempts'] < 5; // Allow 5 attempts in 5 minutes
}

// Function to record login attempt
function recordLoginAttempt($userId, $success) {
    global $con;
    $ip = $_SERVER['REMOTE_ADDR'];
    $sql = "INSERT INTO login_attempts (user_id, ip_address, success) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "isi", $userId, $ip, $success);
    mysqli_stmt_execute($stmt);
}

// Function to get user's last activity
function getUserLastActivity($userId) {
    global $con;
    $sql = "SELECT last_activity FROM user WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['last_activity'];
}

// Function to update user's last activity
function updateUserLastActivity($userId) {
    global $con;
    $sql = "UPDATE user SET last_activity = CURRENT_TIMESTAMP WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
}

// Function to check session timeout
function checkSessionTimeout() {
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) { // 30 minutes
        session_unset();
        session_destroy();
        header('Location: /login.php?timeout=1');
        exit;
    }
    $_SESSION['last_activity'] = time();
}

// Function to generate secure random token
function generateSecureToken($length = 32) {
    return bin2hex(random_bytes($length));
}

// Function to validate token expiration
function isTokenExpired($tokenTime) {
    return time() - $tokenTime > 3600; // 1 hour
}

// Function to check if user is active
function isUserActive($userId) {
    global $con;
    $sql = "SELECT is_active FROM user WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['is_active'] == 1;
}

// Function to deactivate user
function deactivateUser($userId) {
    global $con;
    $sql = "UPDATE user SET is_active = 0 WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
}

// Function to activate user
function activateUser($userId) {
    global $con;
    $sql = "UPDATE user SET is_active = 1 WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
}
?> 