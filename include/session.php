<?php
class Session {
    private static $instance = null;
    private $sessionName = 'CARGO_SESSION';
    private $sessionLifetime = 1800; // 30 minutes
    private $sessionPath = '/';
    private $sessionDomain = '';
    private $sessionSecure = true;
    private $sessionHttpOnly = true;
    private $sessionSameSite = 'Strict';

    private function __construct() {
        // Set session name
        session_name($this->sessionName);

        // Set session cookie parameters
        session_set_cookie_params([
            'lifetime' => $this->sessionLifetime,
            'path' => $this->sessionPath,
            'domain' => $this->sessionDomain,
            'secure' => $this->sessionSecure,
            'httponly' => $this->sessionHttpOnly,
            'samesite' => $this->sessionSameSite
        ]);

        // Start session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Regenerate session ID periodically
        $this->regenerateSession();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function regenerateSession() {
        // Regenerate session ID every 5 minutes
        if (!isset($_SESSION['last_regeneration']) || 
            time() - $_SESSION['last_regeneration'] > 300) {
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        }
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public function has($key) {
        return isset($_SESSION[$key]);
    }

    public function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function clear() {
        session_unset();
    }

    public function destroy() {
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(), '', time() - 3600, $this->sessionPath, 
                 $this->sessionDomain, $this->sessionSecure, $this->sessionHttpOnly);
    }

    public function setFlash($key, $value) {
        $_SESSION['flash'][$key] = $value;
    }

    public function getFlash($key, $default = null) {
        $value = $_SESSION['flash'][$key] ?? $default;
        unset($_SESSION['flash'][$key]);
        return $value;
    }

    public function hasFlash($key) {
        return isset($_SESSION['flash'][$key]);
    }

    public function setUser($user) {
        $this->set('user', $user);
        $this->set('last_activity', time());
    }

    public function getUser() {
        return $this->get('user');
    }

    public function isLoggedIn() {
        return $this->has('user');
    }

    public function checkTimeout() {
        if ($this->isLoggedIn()) {
            $lastActivity = $this->get('last_activity');
            if (time() - $lastActivity > $this->sessionLifetime) {
                $this->destroy();
                return false;
            }
            $this->set('last_activity', time());
        }
        return true;
    }

    public function setRememberMe($userId) {
        $token = bin2hex(random_bytes(32));
        $expires = time() + (30 * 24 * 60 * 60); // 30 days

        // Store token in database
        $db = Database::getInstance();
        $db->insert('remember_tokens', [
            'user_id' => $userId,
            'token' => $token,
            'expires' => date('Y-m-d H:i:s', $expires)
        ]);

        // Set cookie
        setcookie('remember_token', $token, $expires, $this->sessionPath, 
                 $this->sessionDomain, $this->sessionSecure, $this->sessionHttpOnly);
    }

    public function checkRememberMe() {
        if (isset($_COOKIE['remember_token'])) {
            $token = $_COOKIE['remember_token'];
            $db = Database::getInstance();
            
            $result = $db->fetch(
                "SELECT user_id FROM remember_tokens WHERE token = ? AND expires > NOW()",
                [$token],
                's'
            );

            if ($result) {
                $userId = $result['user_id'];
                $user = $db->fetch(
                    "SELECT * FROM users WHERE id = ?",
                    [$userId],
                    'i'
                );

                if ($user) {
                    $this->setUser($user);
                    return true;
                }
            }

            // Clear invalid token
            setcookie('remember_token', '', time() - 3600, $this->sessionPath, 
                     $this->sessionDomain, $this->sessionSecure, $this->sessionHttpOnly);
        }
        return false;
    }

    public function clearRememberMe() {
        if (isset($_COOKIE['remember_token'])) {
            $token = $_COOKIE['remember_token'];
            $db = Database::getInstance();
            
            $db->delete(
                'remember_tokens',
                'token = ?',
                [$token],
                's'
            );

            setcookie('remember_token', '', time() - 3600, $this->sessionPath, 
                     $this->sessionDomain, $this->sessionSecure, $this->sessionHttpOnly);
        }
    }
}

// Example usage:
/*
$session = Session::getInstance();

// Set session data
$session->set('user_id', 1);
$session->set('username', 'john');

// Get session data
$userId = $session->get('user_id');
$username = $session->get('username');

// Set flash message
$session->setFlash('success', 'Operation completed successfully');

// Get flash message
$message = $session->getFlash('success');

// Check if user is logged in
if ($session->isLoggedIn()) {
    $user = $session->getUser();
}

// Set remember me
$session->setRememberMe($userId);

// Check remember me
$session->checkRememberMe();

// Clear remember me
$session->clearRememberMe();

// Destroy session
$session->destroy();
*/
?> 