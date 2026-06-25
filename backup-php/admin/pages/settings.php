<?php
$page_title = 'Settings';
require_once __DIR__ . '/../partials/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = new CSRFToken();
    if (!$csrf->verify($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token.';
    } else {
        // Columns that can be updated
        $allowed = [
            'company_name', 'tagline', 'email', 'phone_primary', 'phone_secondary',
            'whatsapp', 'address', 'city', 'state', 'pincode', 'logo', 'favicon',
            'map_embed', 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube',
            'established_year', 'iso_certified', 'logo_width'
        ];
        $sets = [];
        $params = [];
        foreach ($allowed as $col) {
            if (isset($_POST[$col])) {
                $sets[] = "$col = ?";
                $params[] = $_POST[$col];
            }
        }
        if (!empty($sets)) {
            $params[] = 1;
            db()->prepare("UPDATE settings SET " . implode(', ', $sets) . " WHERE id = ?")->execute($params);
            $success = 'Settings updated successfully.';
            logActivity($_SESSION['user']['id'] ?? 0, 'updated settings', 'Site settings updated');
        }
    }
}

$settings = [];
$stmt = db()->query("SELECT * FROM settings WHERE id = 1");
$settings = $stmt->fetch() ?: [];
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ti ti-settings me-2"></i>Site Settings</h4>
        <p class="text-muted small mb-0">Manage global site configuration.</p>
    </div>
</div>

<?php if ($success): ?>
<div class="alert alert-success bg-success bg-opacity-10 border border-success border-opacity-25 text-success small py-2"><?= e($success) ?></div>
<?php endif; ?>
<?php if ($error): ?>
<div class="alert alert-danger bg-danger bg-opacity-10 border border-danger border-opacity-25 text-danger small py-2"><?= e($error) ?></div>
<?php endif; ?>

<form method="post">
    <?= csrf_field() ?>
    
    <div class="row g-4">
        <!-- General -->
        <div class="col-lg-6">
            <div class="card-container">
                <h6 class="fw-bold mb-3"><i class="ti ti-info-circle me-2"></i>General</h6>
                <div class="d-flex flex-column gap-3">
                    <?php foreach (['company_name' => 'Site Name', 'tagline' => 'Site Tagline', 'address' => 'Address'] as $key => $label): ?>
                    <div>
                        <label class="form-label"><?= e($label) ?></label>
                        <?php if (in_array($key, ['tagline', 'address'])): ?>
                        <textarea name="<?= e($key) ?>" class="form-control" rows="<?= $key === 'address' ? 2 : 3 ?>"><?= e($settings[$key] ?? '') ?></textarea>
                        <?php else: ?>
                        <input type="text" name="<?= e($key) ?>" class="form-control" value="<?= e($settings[$key] ?? '') ?>">
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Contact -->
        <div class="col-lg-6">
            <div class="card-container">
                <h6 class="fw-bold mb-3"><i class="ti ti-phone me-2"></i>Contact Information</h6>
                <div class="d-flex flex-column gap-3">
                    <?php foreach (['phone_primary' => 'Primary Phone', 'phone_secondary' => 'Secondary Phone', 'email' => 'Email', 'whatsapp' => 'WhatsApp Number'] as $key => $label): ?>
                    <div>
                        <label class="form-label"><?= e($label) ?></label>
                        <input type="text" name="<?= e($key) ?>" class="form-control" value="<?= e($settings[$key] ?? '') ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Social Media -->
        <div class="col-lg-6">
            <div class="card-container">
                <h6 class="fw-bold mb-3"><i class="ti ti-brand-facebook me-2"></i>Social Media</h6>
                <div class="d-flex flex-column gap-3">
                    <?php foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'twitter' => 'Twitter', 'linkedin' => 'LinkedIn', 'youtube' => 'YouTube'] as $key => $label): ?>
                    <div>
                        <label class="form-label"><?= e($label) ?></label>
                        <input type="url" name="<?= e($key) ?>" class="form-control" value="<?= e($settings[$key] ?? '') ?>" placeholder="https://">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Advanced -->
        <div class="col-lg-6">
            <div class="card-container">
                <h6 class="fw-bold mb-3"><i class="ti ti-code me-2"></i>Advanced</h6>
                <div class="d-flex flex-column gap-3">
                    <div>
                        <label class="form-label">Google Maps Embed</label>
                        <textarea name="map_embed" class="form-control" rows="4"><?= e($settings['map_embed'] ?? '') ?></textarea>
                    </div>
                    <div>
                        <label class="form-label">Google Analytics ID</label>
                        <input type="text" name="google_analytics" class="form-control" value="<?= e($settings['google_analytics'] ?? '') ?>">
                    </div>
                    <div>
                        <label class="form-label">Footer Text</label>
                        <input type="text" name="footer_text" class="form-control" value="<?= e($settings['footer_text'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <button type="submit" class="btn btn-gradient"><i class="ti ti-device-floppy me-2"></i> Save Settings</button>
    </div>
</form>

<?php include __DIR__ . '/../partials/footer.php'; ?>
