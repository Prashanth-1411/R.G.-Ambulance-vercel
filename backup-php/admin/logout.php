<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/session.php';
$auth = new Auth();
$auth->logout();
header('Location: ' . BASE_URL . '/admin/login.php');
exit;
