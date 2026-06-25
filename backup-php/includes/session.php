<?php
// ============================================
// Session Management & Authentication
// ============================================

require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 0);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}

class Auth {
    public static function isLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }

    public static function getUserId(): ?int {
        return $_SESSION['user_id'] ?? null;
    }

    public static function user(): ?array {
        if (!self::isLoggedIn()) return null;
        
        $stmt = db()->prepare("SELECT id, name, email, role, avatar, status FROM users WHERE id = ? AND status = 1");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch() ?: null;
    }

    public static function requireLogin(): void {
        if (!self::isLoggedIn()) {
            header('Location: ' . ADMIN_URL . '/index.php');
            exit;
        }
    }

    public static function requireRole(string ...$roles): void {
        self::requireLogin();
        $user = self::user();
        if (!in_array($user['role'], $roles)) {
            http_response_code(403);
            die('Access denied. Insufficient permissions.');
        }
    }

    public static function login(string $email, string $password): bool {
        $stmt = db()->prepare("SELECT * FROM users WHERE email = ? AND status = 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            
            // Update last login
            $stmt = db()->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $stmt->execute([$user['id']]);
            
            // Log activity
            logActivity($user['id'], 'login', 'auth', 'User logged in');
            
            return true;
        }
        return false;
    }

    public static function logout(): void {
        if (self::isLoggedIn()) {
            logActivity($_SESSION['user_id'], 'logout', 'auth', 'User logged out');
        }
        $_SESSION = [];
        session_destroy();
    }

    public static function updatePassword(int $userId, string $newPassword): bool {
        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = db()->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hash, $userId]);
    }
}
