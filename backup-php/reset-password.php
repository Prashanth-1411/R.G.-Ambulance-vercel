<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/session.php';

$hash = password_hash('admin123', PASSWORD_BCRYPT);
$stmt = db()->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->execute([$hash, 'admin@rgambulanceservice.com']);
echo "Password reset to: admin123\nHash: $hash\n";
