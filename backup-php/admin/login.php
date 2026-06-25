<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/csrf.php';

$auth = new Auth();
if ($auth->isLoggedIn()) {
    header('Location: ' . BASE_URL . '/admin/dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = new CSRFToken();
    if (!$csrf->verify($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token. Please refresh and try again.';
    } else {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        if ($auth->login($username, $password)) {
            header('Location: ' . BASE_URL . '/admin/dashboard.php');
            exit;
        } else {
            $error = 'Invalid credentials. Please try again.';
        }
    }
}

$csrf = new CSRFToken();
$token = $csrf->generate();
$app_name = getSetting('app_name') ?: 'RG Ambulance CMS';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — <?= e($app_name) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/dist/tabler-icons.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/admin/assets/css/admin.css?v=2" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1e40af, #1e3a8a, #0f172a); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { max-width: 420px; width: 100%; }
        .login-card { background: #fff; border-radius: 20px; padding: 2.5rem; box-shadow: 0 25px 60px rgba(0,0,0,0.3); }
        .login-card h4 { color: #1e293b !important; }
        .login-card .form-label { color: #334155 !important; }
        .login-card .btn-gradient { background: linear-gradient(135deg, #1e40af, #1e3a8a); }
        .login-card .btn-gradient:hover { box-shadow: 0 4px 16px rgba(30,64,175,0.4); }
        .login-card .input-group-text { background: #f8fafc; border-color: #e2e8f0; color: #94a3b8; }
        .login-card .form-control { background: #f8fafc !important; border-color: #e2e8f0 !important; color: #0f172a !important; }
        .login-card .form-control:focus { box-shadow: 0 0 0 3px rgba(30,64,175,0.15) !important; border-color: #1e40af !important; }
    </style>
</head>
<body>
    <div class="login-card text-center">
        <div class="mb-4">
            <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3" style="width: 64px; height: 64px; background: linear-gradient(135deg, #1e40af, #1e3a8a);">
                <i class="ti ti-ambulance text-white fs-2"></i>
            </div>
            <h4 class="fw-bold" style="color: #1e293b;"><?= e($app_name) ?></h4>
            <p class="small" style="color: #94a3b8;">Enter your credentials to access the panel</p>
        </div>
        
        <?php if ($error): ?>
        <div class="alert alert-danger bg-danger bg-opacity-10 border border-danger border-opacity-25 text-danger small py-2"><?= e($error) ?></div>
        <?php endif; ?>
        
        <form method="post" class="d-flex flex-column gap-3 text-start">
            <input type="hidden" name="csrf_token" value="<?= e($token) ?>">
            <div>
                <label class="form-label small fw-semibold mb-1">Username or Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-user"></i></span>
                    <input type="text" name="username" class="form-control" required placeholder="admin@rgambulanceservice.com">
                </div>
            </div>
            <div>
                <label class="form-label small fw-semibold mb-1">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-lock"></i></span>
                    <input type="password" name="password" class="form-control" required placeholder="••••••••">
                </div>
            </div>
            <button type="submit" class="btn w-100 py-2 fw-bold mt-2 text-white" style="background: linear-gradient(135deg, #1e40af, #1e3a8a); border: none;">
                <i class="ti ti-login me-2"></i> Sign In
            </button>
        </form>
        
        <p class="text-center small mt-4 mb-0" style="color: #94a3b8;">
            &copy; <?= date('Y') ?> <?= e($app_name) ?>. All rights reserved.
        </p>
    </div>
</body>
</html>
