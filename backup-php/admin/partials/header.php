<?php
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/session.php';
$auth = new Auth();
$auth->requireLogin();

$app_name = getSetting('app_name') ?: 'RG CMS';
$user = $_SESSION['user'] ?? [];
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title ?? 'Dashboard') ?> — <?= e($app_name) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/dist/tabler-icons.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="<?= BASE_URL ?>/admin/assets/css/admin.css?v=2" rel="stylesheet">
    <?php if (isset($extra_css)) echo $extra_css; ?>
</head>
<body>
<div id="app">
    <!-- Sidebar -->
    <?php include __DIR__ . '/sidebar.php'; ?>
    
    <!-- Main wrapper -->
    <div class="main-wrapper" id="mainWrapper">
        <!-- Top navbar -->
        <nav class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-link text-light p-0" id="sidebarToggle">
                    <i class="ti ti-menu-2 fs-5"></i>
                </button>
                <div class="search-box">
                    <i class="ti ti-search"></i>
                    <input type="text" class="form-control form-control-sm" id="globalSearch" placeholder="Search... (Ctrl+K)" style="width: 280px;">
                    <div class="search-shortcut">⌘K</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="theme-toggle" id="themeToggle" title="Toggle theme">
                    <i class="ti ti-sun"></i>
                    <i class="ti ti-moon"></i>
                </div>
                <div class="position-relative">
                    <button class="btn btn-link text-light p-0 position-relative" id="notificationBtn">
                        <i class="ti ti-bell fs-5"></i>
                        <span class="notification-dot" id="notificationDot"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end notification-dropdown" id="notificationDropdown">
                        <div class="d-flex align-items-center justify-content-between px-3 py-2 border-bottom border-secondary">
                            <h6 class="mb-0 fs-13 fw-bold">Notifications</h6>
                            <button class="btn btn-link btn-sm text-decoration-none text-muted p-0" id="markAllRead">Mark all read</button>
                        </div>
                        <div class="notification-list" id="notificationList">
                            <div class="text-center text-muted py-4 small">No new notifications</div>
                        </div>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link text-light text-decoration-none d-flex align-items-center gap-2 p-0" data-bs-toggle="dropdown">
                        <div class="avatar-circle bg-gradient"><?= e(strtoupper(substr($user['name'] ?? 'A', 0, 1))) ?></div>
                        <div class="d-none d-md-block text-start">
                            <p class="mb-0 fs-13 fw-semibold lh-1"><?= e($user['name'] ?? 'Admin') ?></p>
                            <p class="mb-0 text-muted fs-11"><?= e($user['role'] ?? 'admin') ?></p>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>/admin/pages/profile.php"><i class="ti ti-user me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>/admin/pages/settings.php"><i class="ti ti-settings me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>/admin/logout.php"><i class="ti ti-logout me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Page content -->
        <div class="page-content">
