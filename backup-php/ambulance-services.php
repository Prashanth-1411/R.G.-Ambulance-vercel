<?php
// ============================================
// Ambulance Services Page
// ============================================
require_once __DIR__ . '/includes/functions.php';

$seo = getSEOMeta('ambulance-services');
$phone = getSetting('phone_primary') ?: '+91 95516 63530';

// Get all ambulance services
$services = db()->prepare("SELECT s.*, GROUP_CONCAT(sf.feature ORDER BY sf.sort_order ASC SEPARATOR '||') as features 
    FROM services s LEFT JOIN service_features sf ON s.id = sf.service_id 
    WHERE s.service_type = 'ambulance' AND s.status = 1 
    GROUP BY s.id ORDER BY s.sort_order ASC");
$services->execute();
$serviceList = $services->fetchAll();

include __DIR__ . '/header.php';
?>

<section class="page-hero">
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="hero-shape hero-shape-3"></div>
    <div class="position-absolute inset-0" style="background: linear-gradient(135deg, var(--navy-900), var(--navy-800), var(--navy-900));"></div>
    <div class="position-absolute inset-0" style="background: radial-gradient(ellipse at center, rgba(59,130,246,0.1) 0%, transparent 70%);"></div>
    <div class="hero-grid"></div>
    
    <div class="container position-relative" style="z-index: 10;">
        <div class="row align-items-center g-5 py-4">
            <div class="col-lg-7">
                <div class="d-flex flex-wrap gap-2">
                    <span class="hero-badge"><i class="fas fa-sparkles"></i> Premium Medical Fleet</span>
                    <span class="hero-badge" style="background: rgba(16,185,129,0.1); border-color: rgba(16,185,129,0.2); color: #34d399;">
                        <span class="pulse-dot" style="background: #34d399;"></span> 24/7 Active Dispatch
                    </span>
                </div>
                
                <h1 class="hero-title mt-4">
                    Premium ICU <span class="text-gradient">Ambulance Fleet</span>
                </h1>
                
                <p class="hero-subtitle mt-3">
                    ISO-certified emergency vehicles equipped with advanced life-support systems, staffed by critical care paramedics. Ready for immediate dispatch across all major routes.
                </p>
                
                <div class="hero-actions d-flex flex-wrap gap-3 mt-4">
                    <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="btn-premium">
                        <i class="fas fa-phone-alt me-2"></i> Call Now: <?= e($phone) ?>
                    </a>
                    <a href="#booking-sec" class="btn-outline-premium">
                        <i class="fas fa-calendar-alt me-2"></i> Book a Vehicle
                    </a>
                </div>
                
                <div class="hero-stats mt-4">
                    <span class="hero-stat"><i class="fas fa-shield-check" style="color: #34d399;"></i> ISO 9001:2015 Certified</span>
                    <span class="hero-stat"><i class="fas fa-check-circle" style="color: #34d399;"></i> Govt. Approved</span>
                    <span class="hero-stat"><i class="fas fa-star" style="color: var(--gold-400);"></i> 4.9/5 Patient Rating</span>
                </div>
            </div>
            
            <div class="col-lg-5 d-none d-lg-block">
                <div class="position-relative">
                    <div class="position-absolute" style="inset: 0; background: linear-gradient(135deg, var(--brand-500), var(--brand-700)); border-radius: 24px; filter: blur(60px); opacity: 0.2;"></div>
                    <div class="position-relative rounded-4 overflow-hidden border border-white border-opacity-10 shadow">
                        <?php if (!empty($serviceList[0]['image'])): ?>
                        <img src="<?= getMediaUrl($serviceList[0]['image']) ?>" alt="ICU Ambulance Fleet" class="w-100" style="height: 500px; object-fit: cover;">
                        <?php else: ?>
                        <div style="height: 500px; background: var(--navy-800);"></div>
                        <?php endif; ?>
                        <div class="position-absolute start-0 end-0" style="bottom: 0; background: linear-gradient(to top, rgba(16,42,67,0.8), transparent); height: 50%;"></div>
                    </div>
                    <div class="position-absolute" style="bottom: -1rem; left: -1rem; animation: float 4s ease-in-out infinite;">
                        <div class="glass-dark px-4 py-3 rounded-4 shadow">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(52,211,153,0.1);">
                                    <i class="fas fa-truck-medical" style="color: #34d399; font-size: 1.25rem;"></i>
                                </div>
                                <div>
                                    <p class="text-white fw-black fs-3 mb-0" style="font-family: var(--font-display);">34+</p>
                                    <p class="text-muted small mb-0">Active Fleet Vehicles</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4" style="z-index: 10;">
        <div class="mouse-scroll">
            <div class="mouse-scroll-wheel"></div>
        </div>
    </div>
</section>

<!-- ===== STATISTICS ===== -->
<section class="bg-white border-bottom">
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-6 col-lg-3"><div class="stat-item"><div class="stat-icon"><i class="fas fa-award"></i></div><span class="stat-number" data-target="12">12+</span><span class="stat-label">Years of Experience</span></div></div>
            <div class="col-6 col-lg-3"><div class="stat-item"><div class="stat-icon"><i class="fas fa-truck-medical"></i></div><span class="stat-number" data-target="34">34+</span><span class="stat-label">Active Medical Vehicles</span></div></div>
            <div class="col-6 col-lg-3"><div class="stat-item"><div class="stat-icon"><i class="fas fa-heartbeat"></i></div><span class="stat-number" data-target="8200">8200+</span><span class="stat-label">Patients Safely Transferred</span></div></div>
            <div class="col-6 col-lg-3"><div class="stat-item"><div class="stat-icon"><i class="fas fa-map-marker-alt"></i></div><span class="stat-number" data-target="100">100%</span><span class="stat-label">Service Coverage</span></div></div>
        </div>
    </div>
</section>

<!-- ===== SERVICES ===== -->
<section class="bg-white">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label"><i class="fas fa-ambulance"></i> Our Fleet</div>
            <h2 class="section-title">Emergency Ambulance Fleet</h2>
            <p class="section-subtitle">Seven specialized ambulance categories — each equipped and crewed for specific medical transport needs.</p>
        </div>
        
        <div class="d-flex flex-wrap justify-content-center gap-2 mt-4" data-aos="fade-up">
            <button class="filter-btn active" data-filter="all" data-target=".serviceGrid"><i class="fas fa-filter"></i> All Vehicles</button>
            <button class="filter-btn" data-filter="emergency" data-target=".serviceGrid"><i class="fas fa-ambulance"></i> Emergency</button>
            <button class="filter-btn" data-filter="critical" data-target=".serviceGrid"><i class="fas fa-heartbeat"></i> Critical Care</button>
            <button class="filter-btn" data-filter="transport" data-target=".serviceGrid"><i class="fas fa-truck"></i> Transport</button>
        </div>
        
        <?php
        $emergencyTitles = ['Basic Life Support', 'Advanced Life Support', 'Cardiac Care'];
        $criticalTitles = ['Neonatal', 'ICU Ventilator', 'Long Distance'];
        function getCategory($title, $emergency, $critical) {
            foreach ($emergency as $e) if (strpos($title, $e) !== false) return 'emergency';
            foreach ($critical as $c) if (strpos($title, $c) !== false) return 'critical';
            return 'transport';
        }
        ?>
        
        <div class="row g-4 mt-4 serviceGrid">
            <?php foreach ($serviceList as $svc): 
                $features = !empty($svc['features']) ? explode('||', $svc['features']) : [];
                $cat = getCategory($svc['title'], $emergencyTitles, $criticalTitles);
            ?>
            <div class="col-md-6 filter-item" data-category="<?= $cat ?>">
                <div class="service-card">
                    <div class="card-img">
                        <img src="<?= getMediaUrl($svc['image']) ?>" alt="<?= e($svc['title']) ?>">
                        <div class="card-img-overlay"></div>
                        <div class="position-absolute bottom-0 start-0 end-0 p-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="premium-gradient d-flex align-items-center justify-content-center rounded-2" style="width: 40px; height: 40px;">
                                    <i class="fas fa-ambulance text-white"></i>
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
                        <div class="d-flex gap-2 mt-4">
                            <button class="btn-premium flex-fill py-2 small" data-open-modal="serviceModal" data-service="<?= e($svc['title']) ?>">
                                <i class="fas fa-info-circle me-1"></i> View Details
                            </button>
                            <button class="btn flex-fill py-2 small fw-bold" style="background: #dc2626; color: #fff;" onclick="openBookingModal('<?= e($svc['title']) ?>')">
                                <i class="fas fa-calendar-alt me-1"></i> Book Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== CTA ===== -->
<section class="cta-gradient position-relative overflow-hidden">
    <div class="cta-pattern"></div>
    <div class="position-absolute top-0 start-0 w-100" style="height: 1px; background: linear-gradient(to right, transparent, rgba(255,255,255,0.2), transparent);"></div>
    
    <div class="container position-relative" style="z-index: 10;">
        <div class="row align-items-center justify-content-between g-4">
            <div class="col-lg-7" data-aos="fade-right">
                <div class="hero-badge" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: rgba(255,255,255,0.8);">
                    <span class="pulse-dot" style="background: #ef4444;"></span>
                    24/7 Rapid Emergency Response
                </div>
                <h3 class="display-4 fw-black text-white mt-3" style="font-family: var(--font-display);">
                    Immediate ICU Dispatch?
                </h3>
                <p class="text-white-50 lead">Our medical coordinators are standing by. Call our hotline for instant deployment of a fully equipped ICU ambulance to your location.</p>
            </div>
            <div class="col-lg-auto" data-aos="fade-left">
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="btn btn-light fw-black px-4 py-3 rounded-3 shadow-lg magnetic" style="color: var(--brand-600);">
                        <i class="fas fa-phone-alt me-2"></i> Call Hotline: <?= e($phone) ?>
                    </a>
                    <a href="https://wa.me/<?= e(preg_replace('/[^0-9]/', '', getSetting('whatsapp') ?: '918778481556')) ?>?text=Emergency+Ambulance+Required" target="_blank" class="btn fw-black px-4 py-3 rounded-3 shadow-lg magnetic" style="background: #25D366; color: #fff;">
                        <i class="fab fa-whatsapp me-2"></i> WhatsApp Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== BOOKING ===== -->
<section id="booking-sec" class="cta-navy position-relative overflow-hidden">
    <div class="cta-pattern"></div>
    <div class="container position-relative" style="z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5" data-aos="fade-up">
                    <div class="hero-badge" style="background: rgba(59,130,246,0.1); border-color: rgba(59,130,246,0.2); color: var(--brand-400);">
                        <span class="pulse-dot" style="background: var(--brand-400);"></span>
                        24/7 Digital Dispatch
                    </div>
                    <h2 class="display-4 fw-black text-white mt-3" style="font-family: var(--font-display);">Book Your Ambulance Now</h2>
                    <p class="text-white-50 small" style="max-width: 500px; margin: 0 auto;">Submit patient and route coordinates below. Our dispatch coordinator will telephone you within 3 minutes to verify availability.</p>
                </div>
                
                <form id="bookingPageForm" class="form-dark row g-4 p-5 rounded-4" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.1);" data-aos="fade-up">
                    <?= csrf_field() ?>
                    <div class="col-md-6">
                        <label class="form-label">Patient / Contact Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="Enter contact name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mobile Phone Number</label>
                        <input type="tel" name="phone" class="form-control" required placeholder="Enter active phone number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pickup Location</label>
                        <input type="text" name="pickup" class="form-control" required placeholder="e.g. Anna Nagar Central">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Destination Hospital</label>
                        <input type="text" name="destination" class="form-control" required placeholder="e.g. Apollo Hospital Greams Road">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Select Vehicle</label>
                        <select name="service_name" class="form-select" required>
                            <?php foreach ($serviceList as $svc): ?>
                            <option value="<?= e($svc['title']) ?>"><?= e($svc['title']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Transit Date</label>
                        <input type="date" name="booking_date" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Special Requirements</label>
                        <input type="text" name="notes" class="form-control" placeholder="Ventilator, oxygen supply, cardiac monitoring, etc.">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-premium w-100 py-3 magnetic">
                            <i class="fas fa-paper-plane me-2"></i> Submit Booking Request
                        </button>
                    </div>
                </form>
                <div id="bookingPageSuccess" class="text-center p-5 rounded-4 d-none" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <div class="p-4 rounded-circle" style="background: rgba(16,185,129,0.2);">
                            <i class="fas fa-check-circle" style="color: #34d399; font-size: 2.5rem;"></i>
                        </div>
                    </div>
                    <h3 class="text-white fw-bold" style="font-family: var(--font-display);">Booking Request Received</h3>
                    <p class="text-white-50 small">Our dispatch team is reviewing your request. We will contact you shortly.</p>
                    <button onclick="resetBookingPageForm()" class="btn-premium mt-3">Book Another Trip</button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/service-modal.php'; ?>

<script>
// Booking page form
document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('bookingPageForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'submit_booking');
            
            fetch('<?= BASE_URL ?>/admin/ajax/booking.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.classList.add('d-none');
                    document.getElementById('bookingPageSuccess').classList.remove('d-none');
                } else {
                    alert(data.message || 'Something went wrong');
                }
            })
            .catch(() => alert('Network error'));
        });
    }
});

function resetBookingPageForm() {
    const form = document.getElementById('bookingPageForm');
    form.classList.remove('d-none');
    document.getElementById('bookingPageSuccess').classList.add('d-none');
    form.reset();
}
</script>

<?php include __DIR__ . '/footer.php'; ?>
