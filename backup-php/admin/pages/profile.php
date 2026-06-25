<?php
$page_title = 'My Profile';
require_once __DIR__ . '/../partials/header.php';

$auth = new Auth();
$user = $_SESSION['user'] ?? [];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = new CSRFToken();
    if (!$csrf->verify($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token.';
    } else {
        try {
            $name = sanitize($_POST['name'] ?? '');
            $email = sanitize($_POST['email'] ?? '');
            
            db()->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?")->execute([$name, $email, $user['id']]);
            
            if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {
                if (!password_verify($_POST['current_password'], $user['password'])) {
                    throw new Exception('Current password is incorrect');
                }
                if (strlen($_POST['new_password']) < 6) {
                    throw new Exception('New password must be at least 6 characters');
                }
                $hash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                db()->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([$hash, $user['id']]);
            }
            
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['email'] = $email;
            $success = 'Profile updated successfully.';
            logActivity($user['id'], 'updated profile', 'Profile updated');
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ti ti-user me-2"></i>My Profile</h4>
        <p class="text-muted small mb-0">Manage your account information and password.</p>
    </div>
</div>

<?php if ($success): ?>
<div class="alert alert-success bg-success bg-opacity-10 border border-success border-opacity-25 text-success small py-2"><?= e($success) ?></div>
<?php endif; ?>
<?php if ($error): ?>
<div class="alert alert-danger bg-danger bg-opacity-10 border border-danger border-opacity-25 text-danger small py-2"><?= e($error) ?></div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card-container text-center">
            <div class="avatar-circle bg-gradient mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;"><?= e(strtoupper(substr($user['name'] ?? 'A', 0, 1))) ?></div>
            <h5 class="fw-bold"><?= e($user['name'] ?? '') ?></h5>
            <p class="text-muted small"><?= e($user['email'] ?? '') ?></p>
            <span class="badge bg-primary"><?= e($user['role'] ?? 'admin') ?></span>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card-container">
            <form method="post">
                <?= csrf_field() ?>
                <div class="d-flex flex-column gap-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="<?= e($user['name'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="<?= e($user['email'] ?? '') ?>" required>
                        </div>
                    </div>
                    <hr>
                    <h6 class="fw-bold">Change Password</h6>
                    <p class="text-muted small">Leave blank if you don't want to change your password.</p>
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Current Password</label><input type="password" name="current_password" class="form-control" placeholder="Leave blank to keep"></div>
                        <div class="col-md-4"><label class="form-label">New Password</label><input type="password" name="new_password" class="form-control" placeholder="Min 6 characters"></div>
                        <div class="col-md-4"><label class="form-label">Confirm New Password</label><input type="password" name="confirm_password" class="form-control" placeholder="Repeat new password"></div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-gradient"><i class="ti ti-device-floppy me-1"></i> Update Profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
