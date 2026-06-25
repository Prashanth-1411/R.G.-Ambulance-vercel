<?php
/**
 * AJAX handler for services modal
 */
require_once __DIR__ . '/../../includes/functions.php';
header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? '';

try {
    switch ($action) {
        case 'get_service':
            $title = $_GET['title'] ?? '';
            if (empty($title)) throw new Exception('Title required');
            
            $stmt = db()->prepare("SELECT s.*, GROUP_CONCAT(sf.feature ORDER BY sf.sort_order ASC SEPARATOR '||') as features 
                FROM services s LEFT JOIN service_features sf ON s.id = sf.service_id 
                WHERE s.title = ? AND s.status = 1 GROUP BY s.id LIMIT 1");
            $stmt->execute([$title]);
            $service = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($service && $service['features']) {
                $service['features'] = explode('||', $service['features']);
            }
            
            echo json_encode(['success' => true, 'data' => $service]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Unknown action']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
