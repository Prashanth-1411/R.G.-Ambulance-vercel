<?php
/**
 * Generic CRUD helper for admin pages
 * Handles: list, create, edit, delete, toggle status
 */
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/session.php';

header('Content-Type: application/json');
$auth = new Auth();
$auth->requireLogin();
$auth->requireRole('admin');

$csrf = new CSRFToken();

$action = $_REQUEST['action'] ?? '';
$table = $_REQUEST['table'] ?? '';

$allowed_tables = [
    'services', 'service_features', 'testimonials', 'blog_posts', 'blog_categories',
    'albums', 'gallery_images', 'hero_slides', 'statistics', 'team_members', 'certificates',
    'company_timeline', 'sister_concerns', 'capabilities', 'navigation_items',
    'contact_inquiries', 'bookings', 'pages', 'seo_meta', 'notifications', 'settings', 'users'
];

if (!in_array($table, $allowed_tables)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid table']);
    exit;
}

try {
    switch ($action) {
        case 'toggle_status':
            if (!$csrf->verify($_POST['csrf_token'] ?? '')) throw new Exception('Invalid CSRF');
            $id = (int)$_POST['id'];
            $current = db()->prepare("SELECT status FROM $table WHERE id = ?")->execute([$id])->fetchColumn();
            $new = $current ? 0 : 1;
            db()->prepare("UPDATE $table SET status = ? WHERE id = ?")->execute([$new, $id]);
            logActivity($auth->getUserId(), "toggled $table", "ID: $id -> status: $new");
            echo json_encode(['success' => true, 'status' => $new]);
            break;

        case 'delete':
            if (!$csrf->verify($_POST['csrf_token'] ?? '')) throw new Exception('Invalid CSRF');
            $id = (int)$_POST['id'];
            db()->prepare("DELETE FROM $table WHERE id = ?")->execute([$id]);
            logActivity($auth->getUserId(), "deleted $table", "ID: $id");
            echo json_encode(['success' => true]);
            break;

        case 'reorder':
            if (!$csrf->verify($_POST['csrf_token'] ?? '')) throw new Exception('Invalid CSRF');
            $items = $_POST['items'] ?? [];
            foreach ($items as $item) {
                db()->prepare("UPDATE $table SET sort_order = ? WHERE id = ?")->execute([(int)$item['order'], (int)$item['id']]);
            }
            echo json_encode(['success' => true]);
            break;

        case 'get':
            $id = (int)$_REQUEST['id'];
            $stmt = db()->prepare("SELECT * FROM $table WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $row]);
            break;

        case 'list':
            $page = max(1, (int)($_GET['page'] ?? 1));
            $per_page = (int)($_GET['per_page'] ?? 50);
            $offset = ($page - 1) * $per_page;
            $order = $_GET['order'] ?? 'id DESC';
            $where = $_GET['where'] ?? '';
            
            $sql = "SELECT * FROM $table";
            if ($where) $sql .= " WHERE $where";
            $sql .= " ORDER BY $order LIMIT $per_page OFFSET $offset";
            
            $stmt = db()->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $count = db()->query("SELECT COUNT(*) FROM $table" . ($where ? " WHERE $where" : ''))->fetchColumn();
            
            echo json_encode(['success' => true, 'data' => $rows, 'total' => (int)$count, 'page' => $page, 'per_page' => $per_page]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Unknown action']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
