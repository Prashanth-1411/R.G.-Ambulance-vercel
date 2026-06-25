<?php
/**
 * AJAX handler for booking operations
 */
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/csrf.php';
header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? '';

try {
    switch ($action) {
        case 'submit_booking':
            $csrf = new CSRFToken();
            if (!$csrf->verify($_POST['csrf_token'] ?? '')) throw new Exception('Invalid CSRF');
            
            $name = sanitize($_POST['name'] ?? '');
            $phone = sanitize($_POST['phone'] ?? '');
            $pickup = sanitize($_POST['pickup'] ?? '');
            $destination = sanitize($_POST['destination'] ?? '');
            $service_name = sanitize($_POST['service_name'] ?? '');
            $booking_date = $_POST['booking_date'] ?? date('Y-m-d');
            $notes = sanitize($_POST['notes'] ?? '');
            
            if (empty($name) || empty($phone) || empty($pickup) || empty($destination)) {
                throw new Exception('Please fill all required fields');
            }
            
            $stmt = db()->prepare("INSERT INTO bookings (name, phone, pickup, destination, service_name, booking_date, notes, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
            $stmt->execute([$name, $phone, $pickup, $destination, $service_name, $booking_date, $notes]);
            
            $bookingId = db()->lastInsertId();
            createNotification("New booking from $name", "booking", "/admin/pages/bookings.php?id=$bookingId");
            
            echo json_encode(['success' => true, 'message' => 'Booking submitted successfully']);
            break;

        case 'submit_funeral_booking':
            $csrf = new CSRFToken();
            if (!$csrf->verify($_POST['csrf_token'] ?? '')) throw new Exception('Invalid CSRF');
            
            $name = sanitize($_POST['name'] ?? '');
            $phone = sanitize($_POST['phone'] ?? '');
            $service_name = sanitize($_POST['service_name'] ?? '');
            $pickup = sanitize($_POST['pickup'] ?? '');
            $notes = sanitize($_POST['notes'] ?? '');
            
            if (empty($name) || empty($phone) || empty($pickup)) {
                throw new Exception('Please fill all required fields');
            }
            
            $stmt = db()->prepare("INSERT INTO bookings (name, phone, pickup, service_name, notes, booking_type, status, created_at) VALUES (?, ?, ?, ?, ?, 'funeral', 'pending', NOW())");
            $stmt->execute([$name, $phone, $pickup, $service_name, $notes]);
            
            createNotification("New funeral booking from $name", "funeral", "/admin/pages/bookings.php");
            
            echo json_encode(['success' => true, 'message' => 'Funeral service request submitted']);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Unknown action']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
