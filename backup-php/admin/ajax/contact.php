<?php
/**
 * AJAX handler for contact inquiries
 */
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/csrf.php';
header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? '';

try {
    switch ($action) {
        case 'submit_contact':
            $csrf = new CSRFToken();
            $token = $_POST['csrf_token_contact'] ?? $_POST['csrf_token'] ?? '';
            if (!$csrf->verify($token)) throw new Exception('Invalid CSRF');
            
            $name = sanitize($_POST['name'] ?? '');
            $email = sanitize($_POST['email'] ?? '');
            $phone = sanitize($_POST['phone'] ?? '');
            $subject = sanitize($_POST['subject'] ?? '');
            $message = sanitize($_POST['message'] ?? '');
            
            if (empty($name) || empty($email) || empty($message)) {
                throw new Exception('Please fill all required fields');
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Invalid email address');
            }
            
            $stmt = db()->prepare("INSERT INTO contact_inquiries (name, email, phone, subject, message, status, created_at) VALUES (?, ?, ?, ?, ?, 'unread', NOW())");
            $stmt->execute([$name, $email, $phone, $subject, $message]);
            
            createNotification("New inquiry from $name", "inquiry", "/admin/pages/inquiries.php");
            
            echo json_encode(['success' => true, 'message' => 'Thank you! We will get back to you shortly.']);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Unknown action']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
