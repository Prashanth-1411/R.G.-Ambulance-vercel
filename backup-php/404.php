<?php
// ============================================
// 404 Not Found
// ============================================
require_once __DIR__ . '/includes/functions.php';
$seo = getSEOMeta('404');
http_response_code(404);
include __DIR__ . '/header.php';
?>

<section class="min-vh-100 d-flex align-items-center justify-content-center bg-white">
    <div class="container text-center py-5">
        <div class="mb-4">
            <span class="display-1 fw-black" style="font-family: var(--font-display); color: var(--brand-600);">404</span>
        </div>
        <h2 class="fw-black mb-3" style="font-family: var(--font-display); color: var(--navy-900);">Page Not Found</h2>
        <p class="text-muted mb-4" style="max-width: 400px; margin: 0 auto;">The page you are looking for might have been moved or does not exist.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="<?= BASE_URL ?>" class="btn-premium"><i class="fas fa-home me-2"></i> Back to Home</a>
            <a href="<?= BASE_URL ?>/contact" class="btn-outline-premium"><i class="fas fa-headset me-2"></i> Contact Us</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
