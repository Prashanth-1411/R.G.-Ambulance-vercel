<?php
// ============================================
// Helper Functions
// ============================================

require_once __DIR__ . '/db.php';

// ===== SANITIZATION =====

function sanitize($input): string {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

function sanitizeArray(array $data): array {
    return array_map('sanitize', $data);
}

function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// ===== VALIDATION =====

function validateRequired($value): bool {
    return isset($value) && trim($value) !== '';
}

function validateEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validatePhone(string $phone): bool {
    return preg_match('/^[+]?[\d\s\-()]{7,20}$/', $phone) === 1;
}

function validateSlug(string $slug): bool {
    return preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug) === 1;
}

// ===== SLUG GENERATION =====

function createSlug(string $string): string {
    $string = strtolower(trim($string));
    $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
    $string = preg_replace('/[\s_]+/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return trim($string, '-');
}

function uniqueSlug(string $slug, string $table, string $column = 'slug', ?int $excludeId = null): string {
    $db = db();
    $original = $slug;
    $i = 1;
    while (true) {
        $sql = "SELECT id FROM {$table} WHERE {$column} = ?";
        $params = [$slug];
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        if (!$stmt->fetch()) break;
        $slug = $original . '-' . $i++;
    }
    return $slug;
}

// ===== FILE UPLOAD =====

function uploadFile(array $file, string $subfolder = 'services', array $allowed = ['jpg','jpeg','png','gif','webp','pdf']): ?string {
    if ($file['error'] !== UPLOAD_ERR_OK) return null;
    
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return null;
    
    $uploadDir = UPLOAD_PATH . '/' . $subfolder;
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    
    $filename = uniqid() . '_' . time() . '.' . $ext;
    $dest = $uploadDir . '/' . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $dest)) {
        return 'uploads/' . $subfolder . '/' . $filename;
    }
    return null;
}

function deleteFile(?string $path): void {
    if ($path && file_exists(ROOT_PATH . '/' . $path)) {
        unlink(ROOT_PATH . '/' . $path);
    }
}

function getMediaUrl(?string $path): string {
    if (!$path) return '';
    if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
    return BASE_URL . '/' . ltrim($path, '/');
}

// ===== DATE FORMATTING =====

function formatDate(?string $date, string $format = 'd M Y'): string {
    if (!$date) return '';
    $dt = new DateTime($date);
    return $dt->format($format);
}

function timeAgo(?string $date): string {
    if (!$date) return '';
    $now = new DateTime();
    $dt = new DateTime($date);
    $diff = $now->getTimestamp() - $dt->getTimestamp();
    
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . ' min ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    if ($diff < 604800) return floor($diff / 86400) . ' days ago';
    return $dt->format('d M Y');
}

// ===== RESPONSE HELPERS =====

function jsonResponse(array $data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function jsonError(string $message, int $status = 400): void {
    jsonResponse(['success' => false, 'message' => $message], $status);
}

function jsonSuccess(string $message = 'Success', array $data = []): void {
    jsonResponse(['success' => true, 'message' => $message, 'data' => $data]);
}

// ===== PAGINATION =====

function paginate(string $table, string $where = '1=1', array $params = [], int $page = 1, int $perPage = ITEMS_PER_PAGE): array {
    $db = db();
    $stmt = $db->prepare("SELECT COUNT(*) FROM {$table} WHERE {$where}");
    $stmt->execute($params);
    $total = (int) $stmt->fetchColumn();
    
    $totalPages = max(1, ceil($total / $perPage));
    $page = max(1, min($page, $totalPages));
    $offset = ($page - 1) * $perPage;
    
    return [
        'page' => $page,
        'perPage' => $perPage,
        'total' => $total,
        'totalPages' => $totalPages,
        'offset' => $offset,
    ];
}

// ===== SETTINGS =====

function getSetting(string $key): ?string {
    static $settings = null;
    if ($settings === null) {
        $stmt = db()->query("SELECT * FROM settings WHERE id = 1");
        $settings = $stmt->fetch();
    }
    return $settings[$key] ?? null;
}

function getSiteName(): string {
    return getSetting('company_name') ?? 'R.G. Ambulance Service';
}

// ===== SEO =====

function getSEOMeta(string $pageName): array {
    $stmt = db()->prepare("SELECT * FROM seo_meta WHERE page_name = ?");
    $stmt->execute([$pageName]);
    return $stmt->fetch() ?: [];
}

// ===== NAVIGATION =====

function getNavigation(): array {
    $stmt = db()->query("SELECT * FROM navigation_items WHERE status = 1 ORDER BY sort_order ASC");
    return $stmt->fetchAll();
}

// ===== ACTIVITY LOGGING =====

function logActivity(int $userId, string $action, string $module, string $description = ''): void {
    $db = db();
    $stmt = $db->prepare("INSERT INTO activity_logs (user_id, action, module, description, ip_address) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$userId, $action, $module, $description, $_SERVER['REMOTE_ADDR'] ?? '']);
}

// ===== NOTIFICATIONS =====

function createNotification(int $userId, string $title, string $message, string $type = 'info', ?string $module = null, ?int $referenceId = null): void {
    $db = db();
    $stmt = $db->prepare("INSERT INTO notifications (user_id, title, message, type, module, reference_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$userId, $title, $message, $type, $module, $referenceId]);
}

function getUnreadNotificationCount(int $userId): int {
    $stmt = db()->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
    $stmt->execute([$userId]);
    return (int) $stmt->fetchColumn();
}

// ===== TRUNCATE TEXT =====

function truncateText(string $text, int $length = 100): string {
    if (mb_strlen($text) <= $length) return $text;
    return mb_substr($text, 0, $length) . '...';
}

// ===== GET IP =====

function getIP(): string {
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

// ===== IMAGE OPTIMIZATION =====

function compressImage(string $source, string $destination, int $quality = 80): bool {
    $info = getimagesize($source);
    if (!$info) return false;
    
    switch ($info['mime']) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            imagejpeg($image, $destination, $quality);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            $pngQuality = max(0, min(9, (int)(($quality - 80) / 10)));
            imagepng($image, $destination, $pngQuality);
            break;
        case 'image/webp':
            $image = imagecreatefromwebp($source);
            imagewebp($image, $destination, $quality);
            break;
        default:
            return false;
    }
    imagedestroy($image);
    return true;
}


