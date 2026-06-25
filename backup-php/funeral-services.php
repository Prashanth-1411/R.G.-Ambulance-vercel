<?php
require_once __DIR__ . '/includes/functions.php';
$seo = getSEOMeta('funeral-services');
$phone = getSetting('phone_primary') ?: '+91 95516 63530';

$services = db()->prepare("SELECT s.*, GROUP_CONCAT(sf.feature ORDER BY sf.sort_order ASC SEPARATOR '||') as features 
    FROM services s LEFT JOIN service_features sf ON s.id = sf.service_id 
    WHERE s.service_type = 'funeral' AND s.status = 1 
    GROUP BY s.id ORDER BY s.sort_order ASC");
$services->execute();
$serviceList = $services->fetchAll();

include __DIR__ . '/header.php';
?>

<section class="page-hero">
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="hero-shape hero-shape-3"></div>
    <div class="position-absolute inset-0" style="background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);"></div>
    <div class="hero-grid"></div>
    <div class="container position-relative" style="z-index: 10;">
        <div class="row align-items-center g-5 py-4">
            <div class="col-lg-8 mx-auto text-center">
                <div class="d-flex justify-content-center gap-2">
                    <span class="hero-badge"><i class="fas fa-dove"></i> Compassionate Care</span>
                    <span class="hero-badge" style="background: rgba(16,185,129,0.1); border-color: rgba(16,185,129,0.2); color: #34d399;">
                        <span class="pulse-dot" style="background: #34d399;"></span> 24/7 Support
                    </span>
                </div>
                <h1 class="hero-title mt-4">
                    Dignified <span class="text-gradient">Funeral Services</span>
                </h1>
                <p class="hero-subtitle mt-3 mx-auto" style="max-width: 600px;">
                    Providing respectful and compassionate funeral transport and ceremonial services. We honor your loved ones with the dignity they deserve.
                </p>
                <div class="hero-actions d-flex flex-wrap justify-content-center gap-3 mt-4">
                    <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="btn-premium"><i class="fas fa-phone-alt me-2"></i> Call: <?= e($phone) ?></a>
                    <a href="#booking-sec" class="btn-outline-premium"><i class="fas fa-calendar-alt me-2"></i> Schedule Service</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label"><i class="fas fa-dove"></i> Our Services</div>
            <h2 class="section-title">Funeral & Ceremonial Transport</h2>
            <p class="section-subtitle">Comprehensive funeral service packages designed with respect, care, and professionalism.</p>
        </div>
        <div class="row g-4 mt-4">
            <?php foreach ($serviceList as $svc): 
                $features = !empty($svc['features']) ? explode('||', $svc['features']) : [];
            ?>
            <div class="col-md-4">
                <div class="service-card">
                    <div class="card-img">
                        <img src="<?= getMediaUrl($svc['image']) ?>" alt="<?= e($svc['title']) ?>">
                        <div class="card-img-overlay"></div>
                        <div class="position-absolute bottom-0 start-0 end-0 p-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="premium-gradient d-flex align-items-center justify-content-center rounded-2" style="width: 40px; height: 40px;">
                                    <i class="fas fa-dove text-white"></i>
                                </div>
                                <h4 class="text-white fw-bold mb-0 small" style="font-family: var(--font-display);"><?= e($svc['title']) ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small"><?= e($svc['description']) ?></p>
                        <?php if (!empty($features)): ?>
                        <div class="card-features">
                            <?php foreach ($features as $feature): ?>
                            <span class="feature-tag"><i class="fas fa-shield-check"></i> <?= e($feature) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <button class="btn-premium w-100 mt-4 py-2 small" onclick="openBookingModal('<?= e($svc['title']) ?>')">
                            <i class="fas fa-calendar-alt me-1"></i> Schedule Service
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta-navy position-relative overflow-hidden">
    <div class="cta-pattern"></div>
    <div class="container position-relative" style="z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <div class="hero-badge" style="background: rgba(59,130,246,0.1); border-color: rgba(59,130,246,0.2); color: var(--brand-400);">
                    <i class="fas fa-dove me-1"></i> Compassionate Care, Always Available
                </div>
                <h2 class="display-4 fw-black text-white mt-3" style="font-family: var(--font-display);">Schedule a Funeral Service</h2>
                <p class="text-white-50 small mb-4">Our team is available 24/7 to assist you during difficult times. Call us or fill the form below.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="btn btn-light fw-black px-4 py-3 rounded-3 shadow-lg"><i class="fas fa-phone-alt me-2"></i> <?= e($phone) ?></a>
                    <a href="#booking-sec" class="btn-outline-premium px-4 py-3"><i class="fas fa-calendar-alt me-2"></i> Book Online</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="booking-sec" class="bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-header" data-aos="fade-up">
                    <div class="section-label"><i class="fas fa-calendar-alt"></i> Booking</div>
                    <h2 class="section-title">Schedule Funeral Service</h2>
                    <p class="section-subtitle">We are here for you 24/7. Submit your request and our team will respond immediately.</p>
                </div>
                <form id="funeralBookingForm" class="form-premium mt-4" data-aos="fade-up">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Your Name</label>
                            <input type="text" name="name" class="form-control" required placeholder="Full name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" required placeholder="Contact number">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Deceased Name</label>
                            <input type="text" name="deceased_name" class="form-control" placeholder="Name of deceased">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Service Type</label>
                            <select name="service_name" class="form-select" required>
                                <?php foreach ($serviceList as $svc): ?>
                                <option value="<?= e($svc['title']) ?>"><?= e($svc['title']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Pickup Location</label>
                            <input type="text" name="pickup" class="form-control" required placeholder="Hospital / Home / Mortuary address">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Special Instructions</label>
                            <input type="text" name="notes" class="form-control" placeholder="Any specific requirements">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn-premium w-100 py-3 magnetic"><i class="fas fa-paper-plane me-2"></i> Submit Request</button>
                        </div>
                    </div>
                </form>
                <div id="funeralBookingSuccess" class="text-center p-5 d-none">
                    <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    <h4 class="mt-3 fw-bold">Request Submitted</h4>
                    <p class="text-muted small">Our team will contact you shortly.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/service-modal.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('funeralBookingForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            fd.append('action', 'submit_funeral_booking');
            fetch('<?= BASE_URL ?>/admin/ajax/booking.php', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(d => {
                    if (d.success) { this.classList.add('d-none'); document.getElementById('funeralBookingSuccess').classList.remove('d-none'); }
                    else alert(d.message || 'Error');
                });
        });
    }
});
</script>

<?php include __DIR__ . '/footer.php'; ?>
