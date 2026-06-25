<?php
// ============================================
// CSRF Protection
// ============================================

require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class CSRFToken {
    public static function generate(): string {
        if (empty($_SESSION[CSRF_TOKEN_NAME])) {
            $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
        }
        return $_SESSION[CSRF_TOKEN_NAME];
    }

    public static function verify(?string $token): bool {
        if (empty($_SESSION[CSRF_TOKEN_NAME]) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
    }

    public static function field(): string {
        return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . self::generate() . '">';
    }

    public static function regenerate(): void {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
}

function csrf_field(): string {
    return CSRFToken::field();
}

function verify_csrf(): void {
    $token = $_POST[CSRF_TOKEN_NAME] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
    if (!CSRFToken::verify($token)) {
        jsonError('Invalid CSRF token', 403);
    }
}
