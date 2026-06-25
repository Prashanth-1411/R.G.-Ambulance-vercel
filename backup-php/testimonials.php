<?php
require_once __DIR__ . '/includes/functions.php';
$seo = getSEOMeta('testimonials');

$stmt = db()->query("SELECT * FROM testimonials WHERE status = 1 ORDER BY sort_order ASC, created_at DESC");
$testimonials = $stmt->fetchAll();

include __DIR__ . '/header.php';
?>

<section class="page-hero" style="min-height: 50vh;">
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="position-absolute inset-0" style="background: linear-gradient(135deg, var(--navy-900), var(--navy-800));"></div>
    <div class="hero-grid"></div>
    <div class="container position-relative" style="z-index: 10;">
        <div class="row align-items-center g-5 py-4">
            <div class="col-lg-8 mx-auto text-center">
                <span class="hero-badge"><i class="fas fa-star"></i> Patient Testimonials</span>
                <h1 class="hero-title mt-4">What Our <span class="text-gradient">Patients Say</span></h1>
                <p class="hero-subtitle mt-3">Real stories from real people we've had the privilege to serve. Their trust drives our commitment to excellence.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-5" data-aos="fade-up">
            <button class="filter-btn active" data-filter="all" data-target=".testimonialGrid"><i class="fas fa-th-large"></i> All</button>
            <button class="filter-btn" data-filter="ambulance" data-target=".testimonialGrid"><i class="fas fa-ambulance"></i> Ambulance</button>
            <button class="filter-btn" data-filter="funeral" data-target=".testimonialGrid"><i class="fas fa-dove"></i> Funeral</button>
            <button class="filter-btn" data-filter="icu" data-target=".testimonialGrid"><i class="fas fa-heartbeat"></i> ICU Transfer</button>
            <button class="filter-btn" data-filter="long" data-target=".testimonialGrid"><i class="fas fa-road"></i> Long Distance</button>
        </div>
        
        <?php if (empty($testimonials)): ?>
        <div class="text-center py-5"><h4>No testimonials yet.</h4></div>
        <?php else: ?>
        <div class="row g-4 testimonialGrid">
            <?php foreach ($testimonials as $t): 
                $rating = (int)($t['rating'] ?? 5);
            ?>
            <div class="col-md-4 filter-item" data-category="<?= e($t['category'] ?? 'ambulance') ?>">
                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star <?= $i <= $rating ? '' : 'text-muted' ?>" style="<?= $i <= $rating ? 'color: var(--gold-400);' : '' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="testimonial-text">"<?= e($t['content']) ?>"</p>
                    <div class="testimonial-author">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--brand-100); display: flex; align-items: center; justify-content: center; color: var(--brand-600); font-weight: 700; font-size: 1.2rem;">
                            <?= e(strtoupper(substr($t['name'], 0, 1))) ?>
                        </div>
                        <div>
                            <p class="fw-bold mb-0 small"><?= e($t['name']) ?></p>
                            <p class="text-muted small mb-0"><?= e($t['designation'] ?: $t['category'] ?: 'Patient') ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="cta-navy position-relative overflow-hidden">
    <div class="cta-pattern"></div>
    <div class="container position-relative" style="z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <h2 class="display-4 fw-black text-white" style="font-family: var(--font-display);">Share Your Experience</h2>
                <p class="text-white-50 small mb-4">Your feedback helps us improve and serve our community better.</p>
                <a href="<?= BASE_URL ?>/contact" class="btn-premium"><i class="fas fa-comment me-2"></i> Leave a Review</a>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
