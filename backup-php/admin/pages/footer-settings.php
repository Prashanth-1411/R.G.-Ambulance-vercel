<?php
$page_title = 'Footer Settings';
require_once __DIR__ . '/../partials/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = new CSRFToken();
    if (!$csrf->verify($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token.';
    } else {
        $allowed = [
            'company_name', 'tagline', 'footer_description', 'footer_text',
            'email', 'phone_primary', 'phone_secondary', 'phone_office',
            'whatsapp', 'address', 'city', 'state', 'pincode',
            'map_embed', 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube',
            'logo', 'favicon', 'meta_keywords', 'meta_description'
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
            $success = 'Footer settings updated successfully.';
            logActivity($_SESSION['user']['id'] ?? 0, 'updated footer settings', 'Footer settings updated');
        }
    }
}

$settings = [];
$stmt = db()->query("SELECT * FROM settings WHERE id = 1");
$settings = $stmt->fetch() ?: [];
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ti ti-layout me-2"></i>Footer Settings</h4>
        <p class="text-muted small mb-0">Manage footer content, contact details, social links, and SEO.</p>
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
    
    <ul class="nav nav-tabs nav-tabs-line mb-4" id="footerTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab"><i class="ti ti-info-circle me-1"></i>General</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab"><i class="ti ti-phone me-1"></i>Contact</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab"><i class="ti ti-share me-1"></i>Social Media</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab"><i class="ti ti-search me-1"></i>SEO</button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="general" role="tabpanel">
            <div class="card-container">
                <div class="d-flex flex-column gap-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="company_name" class="form-control" value="<?= e($settings['company_name'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tagline</label>
                            <input type="text" name="tagline" class="form-control" value="<?= e($settings['tagline'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Logo Path</label>
                            <input type="text" name="logo" class="form-control" value="<?= e($settings['logo'] ?? '') ?>" placeholder="logos/logo.png">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Favicon Path</label>
                            <input type="text" name="favicon" class="form-control" value="<?= e($settings['favicon'] ?? '') ?>" placeholder="favicons/favicon.ico">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Footer Description</label>
                        <textarea name="footer_description" class="form-control" rows="3"><?= e($settings['footer_description'] ?? '') ?></textarea>
                    </div>
                    <div>
                        <label class="form-label">Footer Copyright Text</label>
                        <input type="text" name="footer_text" class="form-control" value="<?= e($settings['footer_text'] ?? '') ?>" placeholder="© 2026 R.G. Ambulance Service. All rights reserved.">
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="contact" role="tabpanel">
            <div class="card-container">
                <div class="d-flex flex-column gap-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Primary Phone</label>
                            <input type="text" name="phone_primary" class="form-control" value="<?= e($settings['phone_primary'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Secondary Phone</label>
                            <input type="text" name="phone_secondary" class="form-control" value="<?= e($settings['phone_secondary'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Office Phone</label>
                            <input type="text" name="phone_office" class="form-control" value="<?= e($settings['phone_office'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">WhatsApp Number</label>
                            <input type="text" name="whatsapp" class="form-control" value="<?= e($settings['whatsapp'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= e($settings['email'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" value="<?= e($settings['address'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="<?= e($settings['city'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control" value="<?= e($settings['state'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pincode</label>
                            <input type="text" name="pincode" class="form-control" value="<?= e($settings['pincode'] ?? '') ?>">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Google Maps Embed</label>
                        <textarea name="map_embed" class="form-control" rows="4"><?= e($settings['map_embed'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="social" role="tabpanel">
            <div class="card-container">
                <div class="d-flex flex-column gap-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Facebook URL</label>
                            <input type="url" name="facebook" class="form-control" value="<?= e($settings['facebook'] ?? '') ?>" placeholder="https://facebook.com/...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Twitter URL</label>
                            <input type="url" name="twitter" class="form-control" value="<?= e($settings['twitter'] ?? '') ?>" placeholder="https://twitter.com/...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Instagram URL</label>
                            <input type="url" name="instagram" class="form-control" value="<?= e($settings['instagram'] ?? '') ?>" placeholder="https://instagram.com/...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">LinkedIn URL</label>
                            <input type="url" name="linkedin" class="form-control" value="<?= e($settings['linkedin'] ?? '') ?>" placeholder="https://linkedin.com/...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">YouTube URL</label>
                            <input type="url" name="youtube" class="form-control" value="<?= e($settings['youtube'] ?? '') ?>" placeholder="https://youtube.com/...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="seo" role="tabpanel">
            <div class="card-container">
                <div class="d-flex flex-column gap-3">
                    <div>
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control" value="<?= e($settings['meta_keywords'] ?? '') ?>" placeholder="ambulance, funeral, medical transport" maxlength="300">
                        <div class="form-text">Maximum 300 characters. Comma-separated keywords.</div>
                    </div>
                    <div>
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="4" maxlength="300"><?= e($settings['meta_description'] ?? '') ?></textarea>
                        <div class="form-text">Maximum 300 characters. Shown in search engine results.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-gradient"><i class="ti ti-device-floppy me-2"></i> Save Footer Settings</button>
    </div>
</form>

<?php include __DIR__ . '/../partials/footer.php'; ?>
