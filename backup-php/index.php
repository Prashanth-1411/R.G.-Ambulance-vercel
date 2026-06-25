<?php
// ============================================
// Home Page - R.G. Ambulance Service
// ============================================
require_once __DIR__ . '/includes/functions.php';

// Get SEO
$seo = getSEOMeta('home');

// Get page content
$page = db()->prepare("SELECT * FROM pages WHERE page_name = ? AND status = 1");
$page->execute(['home']);
$pageContent = $page->fetch();

// Get hero slides
$heroSlides = db()->query("SELECT * FROM hero_slides WHERE status = 1 ORDER BY sort_order ASC LIMIT 1")->fetchAll();

// Get statistics
$statistics = db()->query("SELECT * FROM statistics WHERE status = 1 ORDER BY sort_order ASC")->fetchAll();

// Get featured sections
$featuredSections = db()->query("SELECT * FROM featured_sections WHERE status = 1 ORDER BY sort_order ASC")->fetchAll();

// Get ambulance services (featured)
$ambulanceServices = db()->prepare("SELECT s.*, GROUP_CONCAT(sf.feature ORDER BY sf.sort_order ASC SEPARATOR '||') as features 
    FROM services s LEFT JOIN service_features sf ON s.id = sf.service_id 
    WHERE s.service_type = 'ambulance' AND s.status = 1 AND s.is_featured = 1 
    GROUP BY s.id ORDER BY s.sort_order ASC LIMIT 4");
$ambulanceServices->execute();
$ambServiceList = $ambulanceServices->fetchAll();

// Get funeral services (featured)
$funeralServices = db()->prepare("SELECT s.*, GROUP_CONCAT(sf.feature ORDER BY sf.sort_order ASC SEPARATOR '||') as features 
    FROM services s LEFT JOIN service_features sf ON s.id = sf.service_id 
    WHERE s.service_type = 'funeral' AND s.status = 1 AND s.is_featured = 1 
    GROUP BY s.id ORDER BY s.sort_order ASC LIMIT 3");
$funeralServices->execute();
$funServiceList = $funeralServices->fetchAll();

// Get testimonials
$testimonials = db()->prepare("SELECT * FROM testimonials WHERE is_approved = 1 AND rating = 5 ORDER BY sort_order ASC LIMIT 3");
$testimonials->execute();
$testimonialList = $testimonials->fetchAll();

// Get service areas
try {
    $serviceAreas = db()->query("SELECT name, slug FROM service_areas WHERE is_active = 1 ORDER BY name ASC")->fetchAll();
} catch (Exception $e) {
    $serviceAreas = [];
}

$phone = getSetting('phone_primary') ?: '+91 95516 63530';
$whatsapp = getSetting('whatsapp') ?: '+91 87784 81556';
$email = getSetting('email') ?: 'ebenezer.r@rgambulanceservice.com';

// Get about heading/content
$aboutPage = db()->prepare("SELECT * FROM pages WHERE page_name = 'about' AND status = 1");
$aboutPage->execute();
$aboutData = $aboutPage->fetch();

$aboutHeading = $aboutData['heading'] ?? 'Why Healthcare Providers & Families Trust Us';
$aboutContent = $aboutData['content'] ?? 'In medical emergencies, every second counts. We maintain the highest standards of safety, clinical expertise, and response velocity.';

$servicesPage = db()->prepare("SELECT * FROM pages WHERE page_name = 'services' AND status = 1");
$servicesPage->execute();
$servicesData = $servicesPage->fetch();

$servicesHeading = $servicesData['heading'] ?? 'Professional Emergency Services';
$servicesContent = $servicesData['content'] ?? 'Equipped with certified medical gear and designed for safety, comfort, and absolute compliance.';

include __DIR__ . '/header.php';
?>

<style>
/* Inline hero shape styles to avoid conflicts */
.hero-shape { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.15; mix-blend-mode: multiply; }
</style>

<!-- ===== HERO SLIDER ===== -->
<section class="hero-section">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="hero-shape hero-shape-3"></div>
    <div class="hero-grid"></div>
    
    <div class="container position-relative" style="z-index: 10;">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="hero-badge">
                    <span class="pulse-dot"></span>
                    24/7 Emergency Medical Response
                </div>
                
                <h1 class="hero-title mt-4">
                    <?php if (!empty($heroSlides[0]['title'])): ?>
                        <?= e($heroSlides[0]['title']) ?>
                    <?php else: ?>
                        Your Lifeline in <span class="text-gradient">Medical Emergencies</span>
                    <?php endif; ?>
                </h1>
                
                <p class="hero-subtitle mt-4">
                    <?php if (!empty($heroSlides[0]['subtitle'])): ?>
                        <?= e($heroSlides[0]['subtitle']) ?>
                    <?php else: ?>
                        Rapid response ICU ambulances with advanced life-support equipment. Available 24/7 across Chennai and all major routes.
                    <?php endif; ?>
                </p>
                
                <div class="hero-actions d-flex flex-wrap gap-3 mt-5">
                    <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="btn-premium">
                        <i class="fas fa-phone-alt me-2"></i> Call 24/7 Hotline
                    </a>
                    <a href="#booking-sec" class="btn-outline-premium">
                        <i class="fas fa-calendar-alt me-2"></i> Book a Vehicle
                    </a>
                </div>
                
                <div class="hero-stats mt-5">
                    <span class="hero-stat"><i class="fas fa-check-circle"></i> ISO 9001:2015 Certified</span>
                    <span class="hero-stat"><i class="fas fa-check-circle"></i> Govt. Approved</span>
                    <span class="hero-stat"><i class="fas fa-star text-gold"></i> 4.9/5 Patient Rating</span>
                </div>
            </div>
            
            <div class="col-lg-5 d-none d-lg-block">
                <div class="hero-image-wrap position-relative">
                    <div class="position-relative">
                        <div class="position-absolute" style="inset: 0; background: linear-gradient(135deg, var(--brand-500), var(--brand-700)); border-radius: 24px; filter: blur(60px); opacity: 0.2;"></div>
                        <div class="position-relative rounded-4 overflow-hidden border border-white border-opacity-10 shadow">
                            <img src="<?= BASE_URL ?>/assets/images/ambulance-hero.jpg" alt="ICU Ambulance Fleet" class="w-100" style="height: 500px; object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 end-0" style="background: linear-gradient(to top, rgba(16,42,67,0.8), transparent); height: 50%;"></div>
                        </div>
                        <div class="position-absolute" style="bottom: -1rem; left: -1rem;">
                            <div class="glass-dark px-4 py-3 rounded-4 shadow">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(52,211,153,0.1);">
                                        <i class="fas fa-truck-medical text-emerald-400" style="color: #34d399; font-size: 1.25rem;"></i>
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
    </div>
    
    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4" style="z-index: 10;">
        <div class="mouse-scroll">
            <div class="mouse-scroll-wheel"></div>
        </div>
    </div>
</section>

<!-- ===== STATISTICS BANNER ===== -->
<section class="bg-white border-bottom" style="border-color: rgba(0,0,0,0.05) !important;">
    <div class="container py-4">
        <div class="row g-4 justify-content-center">
            <?php if (!empty($statistics)): ?>
            <?php foreach ($statistics as $stat): ?>
            <div class="col-6 col-lg-3">
                <div class="stat-item">
                    <?php if ($stat['icon']): ?>
                    <div class="stat-icon">
                        <i class="fas fa-<?= e($stat['icon']) ?>"></i>
                    </div>
                    <?php endif; ?>
                    <span class="stat-number" data-target="<?= (int)$stat['value'] ?>" data-suffix="<?= e($stat['suffix']) ?>">
                        <?= (int)$stat['value'] ?><?= e($stat['suffix']) ?>
                    </span>
                    <span class="stat-label"><?= e($stat['label']) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-6 col-lg-3">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-award"></i></div>
                    <span class="stat-number" data-target="12">12+</span>
                    <span class="stat-label">Years of Experience</span>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-truck-medical"></i></div>
                    <span class="stat-number" data-target="34">34+</span>
                    <span class="stat-label">Active Medical Vehicles</span>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-heartbeat"></i></div>
                    <span class="stat-number" data-target="8200">8200+</span>
                    <span class="stat-label">Patients Safely Transferred</span>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <span class="stat-number" data-target="100">100%</span>
                    <span class="stat-label">Service Locations</span>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ===== ABOUT / WHY CHOOSE US ===== -->
<section class="bg-white fade-section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="section-header text-start" data-aos="fade-right">
                    <div class="section-label"><i class="fas fa-info-circle"></i> About Us</div>
                    <h2 class="section-title"><?= e($aboutHeading) ?></h2>
                    <p class="section-subtitle"><?= e($aboutContent) ?></p>
                </div>
                
                <div class="feature-stagger">
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="50">
                        <div class="feature-icon"><i class="fas fa-clock"></i></div>
                        <div class="feature-text">
                            <h4>Rapid Dispatch Stations</h4>
                            <p>Ambulances positioned at strategic hubs across the city. Dispatch begins within 2 minutes of call confirmation.</p>
                        </div>
                    </div>
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="feature-icon"><i class="fas fa-stethoscope"></i></div>
                        <div class="feature-text">
                            <h4>Full ICU Capabilities</h4>
                            <p>Equipped with mechanical ventilators, defibrillators, cardiac monitors, and infusion pumps — a mobile ICU on wheels.</p>
                        </div>
                    </div>
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="150">
                        <div class="feature-icon"><i class="fas fa-users"></i></div>
                        <div class="feature-text">
                            <h4>Certified Medical Staff</h4>
                            <p>Critical care paramedics, emergency nurses, and experienced drivers who undergo regular clinical skill assessments.</p>
                        </div>
                    </div>
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="feature-icon"><i class="fas fa-heart text-danger"></i></div>
                        <div class="feature-text">
                            <h4>Dignified Funeral Care</h4>
                            <p>Compassionate handling of final journeys with AC hearse vans, deceased preservation, and full ritual support.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="position-relative" data-aos="fade-left">
                    <div class="position-absolute" style="top: -1.5rem; left: -1.5rem; width: 96px; height: 96px; background: rgba(59,130,246,0.1); border-radius: 24px;"></div>
                    <div class="position-absolute" style="bottom: -1.5rem; right: -1.5rem; width: 128px; height: 128px; background: rgba(255,193,7,0.1); border-radius: 24px;"></div>
                    <div class="position-relative rounded-4 overflow-hidden shadow">
                        <img src="<?= BASE_URL ?>/assets/images/about-fleet.jpg" alt="ICU Ambulance Fleet" class="w-100" style="height: 500px; object-fit: cover;">
                        <div class="position-absolute" style="inset: 0; background: linear-gradient(to top, rgba(16,42,67,0.6), transparent);"></div>
                        <div class="position-absolute bottom-0 start-0 end-0 p-4">
                            <div class="glass-dark p-4 rounded-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="premium-gradient d-flex align-items-center justify-content-center rounded-3" style="width: 56px; height: 56px; box-shadow: var(--shadow-glow);">
                                        <i class="fas fa-building text-white" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div>
                                        <p class="text-white fw-bold mb-0" style="font-family: var(--font-display);">R.G. Ambulance Service</p>
                                        <p class="text-white-50 small mb-0">Est. 2014 • ISO Certified</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== SERVICES OVERVIEW ===== -->
<section class="bg-navy-light fade-section position-relative overflow-hidden">
    <div class="position-absolute inset-0 split-pattern opacity-25" style="background-image: linear-gradient(45deg, rgba(0,0,0,0.03) 25%, transparent 25%), linear-gradient(-45deg, rgba(0,0,0,0.03) 25%, transparent 25%), linear-gradient(45deg, transparent 75%, rgba(0,0,0,0.03) 75%), linear-gradient(-45deg, transparent 75%, rgba(0,0,0,0.03) 75%); background-size: 20px 20px;"></div>
    
    <div class="container position-relative" style="z-index: 10;">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label"><i class="fas fa-cog"></i> Our Services</div>
            <h2 class="section-title"><?= e($servicesHeading) ?></h2>
            <p class="section-subtitle"><?= e($servicesContent) ?></p>
        </div>
        
        <div class="row g-4 mt-4">
            <!-- Ambulance Services -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="premium-card p-5 h-100 d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="premium-gradient d-flex align-items-center justify-content-center rounded-3" style="width: 56px; height: 56px; box-shadow: var(--shadow-glow);">
                            <i class="fas fa-ambulance text-white" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold fs-4 mb-0" style="color: var(--navy-800); font-family: var(--font-display);">Emergency Ambulance</h3>
                            <p class="small text-muted mb-0">ICU-equipped fleet • 24/7 response</p>
                        </div>
                    </div>
                    
                    <div class="flex-grow-1">
                        <?php foreach ($ambServiceList as $svc): ?>
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3 transition-hover">
                            <div class="d-flex align-items-center justify-content-center rounded-2" style="width: 40px; height: 40px; background: var(--brand-50); color: var(--brand-600); flex-shrink: 0;">
                                <i class="fas fa-arrow-right fa-sm"></i>
                            </div>
                            <span class="small fw-semibold" style="color: var(--navy-700);"><?= e($svc['title']) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <a href="<?= BASE_URL ?>/ambulance-services" class="btn-premium w-100 text-center mt-4 py-3">
                        View All Ambulance Models <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
            
            <!-- Funeral Services -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="premium-card p-5 h-100 d-flex flex-column" style="border-color: rgba(16,42,67,0.1);">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 56px; height: 56px; background: var(--navy-800); box-shadow: 0 4px 20px rgba(16,42,67,0.2);">
                            <i class="fas fa-heart text-white" style="color: var(--gold-400) !important; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold fs-4 mb-0" style="color: var(--navy-800); font-family: var(--font-display);">Dignified Funeral Care</h3>
                            <p class="small text-muted mb-0">Compassionate homage services</p>
                        </div>
                    </div>
                    
                    <div class="flex-grow-1">
                        <?php foreach ($funServiceList as $svc): ?>
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3 transition-hover">
                            <div class="d-flex align-items-center justify-content-center rounded-2" style="width: 40px; height: 40px; background: var(--navy-100); color: var(--navy-700); flex-shrink: 0;">
                                <i class="fas fa-arrow-right fa-sm"></i>
                            </div>
                            <span class="small fw-semibold" style="color: var(--navy-700);"><?= e($svc['title']) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <a href="<?= BASE_URL ?>/funeral-services" class="btn text-center mt-4 py-3 fw-bold rounded-3" style="background: var(--navy-800); color: #fff; box-shadow: 0 4px 20px rgba(16,42,67,0.2);">
                        View Homage Services <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== FLEET SHOWCASE ===== -->
<section class="bg-white fade-section position-relative overflow-hidden">
    <div class="position-absolute" style="top: 0; right: 0; width: 384px; height: 384px; background: var(--brand-50); border-radius: 50%; filter: blur(80px); opacity: 0.5;"></div>
    
    <div class="container position-relative" style="z-index: 10;">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label"><i class="fas fa-truck-medical"></i> Our Fleet</div>
            <h2 class="section-title">Our Active Fleet Gallery</h2>
            <p class="section-subtitle">Clean, fully customized emergency response and funeral transport vehicles ready for immediate deployment.</p>
        </div>
        
        <div class="row g-4 mt-4">
            <?php 
            $allServices = db()->prepare("SELECT s.*, GROUP_CONCAT(sf.feature ORDER BY sf.sort_order ASC SEPARATOR '||') as features 
                FROM services s LEFT JOIN service_features sf ON s.id = sf.service_id 
                WHERE s.service_type = 'ambulance' AND s.status = 1 
                GROUP BY s.id ORDER BY s.sort_order ASC LIMIT 4");
            $allServices->execute();
            $fleetServices = $allServices->fetchAll();
            ?>
            <?php foreach ($fleetServices as $svc): 
                $features = !empty($svc['features']) ? explode('||', $svc['features']) : [];
            ?>
            <div class="col-md-6">
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
                        <p class="text-muted small"><?= e($svc['short_description']) ?></p>
                        <?php if (!empty($features)): ?>
                        <div class="card-features">
                            <?php foreach (array_slice($features, 0, 4) as $feature): ?>
                            <span class="feature-tag"><i class="fas fa-shield-check"></i> <?= e($feature) ?></span>
                            <?php endforeach; ?>
                            <?php if (count($features) > 4): ?>
                            <span class="feature-tag">+<?= count($features) - 4 ?> more</span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <div class="d-flex gap-2 mt-4">
                            <button class="btn-premium flex-fill py-2 small" data-open-modal="serviceModal" data-service="<?= e($svc['title']) ?>">
                                <i class="fas fa-calendar-alt me-1"></i> Book Now
                            </button>
                            <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="btn flex-fill py-2 small fw-bold" style="background: #dc2626; color: #fff;">
                                <i class="fas fa-phone-alt me-1"></i> Call Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== TESTIMONIALS ===== -->
<section class="bg-navy-light fade-section position-relative overflow-hidden">
    <div class="position-absolute inset-0 split-pattern opacity-25" style="background-image: linear-gradient(45deg, rgba(0,0,0,0.03) 25%, transparent 25%), linear-gradient(-45deg, rgba(0,0,0,0.03) 25%, transparent 25%), linear-gradient(45deg, transparent 75%, rgba(0,0,0,0.03) 75%), linear-gradient(-45deg, transparent 75%, rgba(0,0,0,0.03) 75%); background-size: 20px 20px;"></div>
    
    <div class="container position-relative" style="z-index: 10;">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label"><i class="fas fa-star"></i> Testimonials</div>
            <h2 class="section-title">Verified Family Testimonials</h2>
            <p class="section-subtitle">Read stories of our clinical care support and prompt response from families who have trusted us.</p>
        </div>
        
        <div class="row g-4 mt-4">
            <?php foreach ($testimonialList as $idx => $t): 
                $initials = '';
                $parts = explode(' ', $t['name']);
                foreach ($parts as $p) $initials .= strtoupper($p[0] ?? '');
            ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= $idx * 100 ?>">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="<?= $i <= (int)$t['rating'] ? 'fas' : 'far' ?> fa-star"></i>
                        <?php endfor; ?>
                    </div>
                    <i class="fas fa-quote-left mb-3" style="color: var(--brand-200); font-size: 1.5rem;"></i>
                    <p class="testimonial-quote">"<?= e($t['content']) ?>"</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar"><?= e($initials) ?></div>
                        <div>
                            <div class="testimonial-name"><?= e($t['name'] ?? '') ?></div>
                            <span class="testimonial-position"><?= e($t['position'] ?? '') ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= BASE_URL ?>/testimonials" class="btn-outline">
                Read All Testimonials <i class="fas fa-chevron-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

<!-- ===== EMERGENCY CTA ===== -->
<section class="cta-gradient position-relative overflow-hidden">
    <div class="cta-pattern"></div>
    <div class="position-absolute top-0 start-0 w-100" style="height: 1px; background: linear-gradient(to right, transparent, rgba(255,255,255,0.2), transparent);"></div>
    
    <div class="container position-relative" style="z-index: 10;">
        <div class="row align-items-center justify-content-between g-4">
            <div class="col-lg-7" data-aos="fade-right">
                <div class="hero-badge" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: rgba(255,255,255,0.8);">
                    <span class="pulse-dot" style="background: #ef4444;"></span>
                    24/7 Rapid Emergency Support
                </div>
                <h3 class="display-4 fw-black text-white mt-3" style="font-family: var(--font-display); letter-spacing: -0.02em;">
                    Need Immediate Emergency Dispatch?
                </h3>
                <p class="text-white-50 lead" style="max-width: 560px;">
                    Our medical coordinators are online 24/7. Call our dedicated lines to dispatch a fully equipped ICU ambulance to your location immediately.
                </p>
            </div>
            
            <div class="col-lg-auto" data-aos="fade-left">
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="btn btn-light fw-black px-4 py-3 rounded-3 shadow-lg magnetic" style="color: var(--brand-600);">
                        <i class="fas fa-phone-alt me-2"></i> Call Hotline: <?= e($phone) ?>
                    </a>
                    <a href="https://wa.me/<?= e(preg_replace('/[^0-9]/', '', $whatsapp)) ?>?text=Emergency+Ambulance+Required" target="_blank" rel="noreferrer" class="btn fw-black px-4 py-3 rounded-3 shadow-lg magnetic" style="background: #25D366; color: #fff;">
                        <i class="fab fa-whatsapp me-2"></i> WhatsApp Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== BOOKING FORM ===== -->
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
                    <h2 class="display-4 fw-black text-white mt-3" style="font-family: var(--font-display); letter-spacing: -0.02em;">
                        Book Your Ambulance Now
                    </h2>
                    <p class="text-white-50 small" style="max-width: 500px; margin: 0 auto;">
                        Submit patient and route coordinates below. Our dispatch coordinator will telephone you within 3 minutes to verify standby availability.
                    </p>
                </div>
                
                <div id="bookingForm" data-aos="fade-up">
                    <form id="bookingFormSubmit" class="form-dark row g-4 p-5 rounded-4" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.1);">
                        <?= csrf_field() ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Patient / Contact Name</label>
                                <input type="text" name="name" class="form-control" required placeholder="Enter contact name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Mobile Phone Number</label>
                                <input type="tel" name="phone" class="form-control" required placeholder="Enter active phone number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Pickup Location</label>
                                <input type="text" name="pickup" class="form-control" required placeholder="e.g. Anna Nagar Central">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Destination Clinic/Hospital</label>
                                <input type="text" name="destination" class="form-control" required placeholder="e.g. Apollo Hospital Greams Road">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Service Category</label>
                                <select name="service_type" class="form-select">
                                    <option value="Ambulance">Ambulance</option>
                                    <option value="Funeral">Funeral Homage</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Target Vehicle</label>
                                <input type="text" name="service_name" class="form-control" placeholder="e.g. ICU Plus Ambulance">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Transit Date</label>
                                <input type="date" name="booking_date" class="form-control" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Special Diagnosis / Requests</label>
                                <input type="text" name="notes" class="form-control" placeholder="Ventilator, oxygen supply rates, etc.">
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn-premium w-100 py-3 magnetic">
                                <i class="fas fa-paper-plane me-2"></i> Submit Booking Request
                            </button>
                        </div>
                    </form>
                    <div id="bookingSuccess" class="text-center p-5 rounded-4 d-none" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <div class="d-flex align-items-center justify-content-center mb-4">
                            <div class="p-4 rounded-circle" style="background: rgba(16,185,129,0.2);">
                                <i class="fas fa-check-circle text-emerald-400" style="color: #34d399; font-size: 2.5rem;"></i>
                            </div>
                        </div>
                        <h3 class="text-white fw-bold" style="font-family: var(--font-display);">Booking Registration Complete</h3>
                        <p class="text-white-50 small">Our emergency response desk is reviewing your request. We will contact you shortly.</p>
                        <button onclick="resetBookingForm()" class="btn-premium mt-3">Book Another Trip</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== SERVICE COVERAGE ===== -->
<section class="bg-white fade-section position-relative overflow-hidden">
    <div class="position-absolute top-0 start-0 w-100" style="height: 1px; background: linear-gradient(to right, transparent, rgba(59,130,246,0.2), transparent);"></div>
    
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label"><i class="fas fa-map-marked-alt"></i> Coverage</div>
            <h2 class="section-title">Our Service Coverage Area</h2>
            <p class="section-subtitle">We provide active ambulance dispatch and funeral care solutions across India. Select your Chennai locality for nearby response times.</p>
        </div>
        
        <?php 
        $displayLimit = 16;
        $totalLocations = count($serviceAreas);
        ?>
        <div class="row justify-content-center mt-4" data-aos="fade-up">
            <div class="col-md-6">
                <div class="input-group mb-4">
                    <span class="input-group-text bg-transparent border-end-0" style="border-color: var(--navy-200);">
                        <i class="fas fa-map-marker-alt" style="color: var(--navy-400);"></i>
                    </span>
                    <input type="text" id="locationSearch" class="form-control border-start-0 ps-0" placeholder="Search your location..." style="border-color: var(--navy-200);">
                </div>
            </div>
        </div>
        
        <div class="row g-3 location-stagger" id="locationGrid">
            <?php foreach (array_slice($serviceAreas, 0, $displayLimit) as $loc): ?>
            <div class="col-6 col-sm-4 col-md-3 location-item" data-name="<?= e(strtolower($loc['name'])) ?>">
                <a href="<?= BASE_URL ?>/ambulance-service-in-<?= e($loc['slug']) ?>" class="location-btn">
                    <i class="fas fa-map-pin"></i>
                    <span class="truncate"><?= e($loc['name']) ?></span>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if ($totalLocations > $displayLimit): ?>
        <div class="text-center mt-4">
            <button id="toggleLocations" class="btn-outline" data-expanded="false">
                <span>Show All <?= $totalLocations ?> Chennai Locations</span>
                <i class="fas fa-chevron-down ms-1"></i>
            </button>
        </div>
        
        <div id="moreLocations" class="row g-3 mt-3 d-none">
            <?php foreach (array_slice($serviceAreas, $displayLimit) as $loc): ?>
            <div class="col-6 col-sm-4 col-md-3 location-item" data-name="<?= e(strtolower($loc['name'])) ?>">
                <a href="<?= BASE_URL ?>/ambulance-service-in-<?= e($loc['slug']) ?>" class="location-btn">
                    <i class="fas fa-map-pin"></i>
                    <span><?= e($loc['name']) ?></span>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ===== FINAL CTA ===== -->
<section class="cta-gradient position-relative overflow-hidden">
    <div class="cta-pattern"></div>
    <div class="position-absolute top-0 start-0 w-100" style="height: 1px; background: linear-gradient(to right, transparent, rgba(255,255,255,0.2), transparent);"></div>
    
    <div class="container position-relative" style="z-index: 10;">
        <div class="row align-items-center justify-content-between g-4">
            <div class="col-lg-7" data-aos="fade-right">
                <div class="hero-badge" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: rgba(255,255,255,0.8);">
                    <span class="pulse-dot" style="background: #ef4444;"></span>
                    Get in Touch
                </div>
                <h3 class="display-4 fw-black text-white mt-3" style="font-family: var(--font-display); letter-spacing: -0.02em;">
                    Questions or Special Requests?
                </h3>
                <p class="text-white-50 lead">
                    We are here to help. Reach out to us at <a href="mailto:<?= e($email) ?>" class="text-white fw-semibold"><?= e($email) ?></a>
                </p>
            </div>
            
            <div class="col-lg-auto" data-aos="fade-left">
                <div class="glass-dark p-4 rounded-4 d-flex flex-column gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="premium-gradient d-flex align-items-center justify-content-center rounded-2" style="width: 40px; height: 40px;">
                            <i class="fas fa-phone-alt text-white"></i>
                        </div>
                        <div>
                            <p class="small text-white-50 mb-0 text-uppercase fw-bold" style="font-size: 0.6875rem; letter-spacing: 0.05em;">Emergency Hotline</p>
                            <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="text-white fw-bold text-decoration-none" style="font-family: var(--font-display);"><?= e($phone) ?></a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-2" style="width: 40px; height: 40px; background: rgba(37,211,102,0.2);">
                            <i class="fab fa-whatsapp" style="color: #25D366; font-size: 1.25rem;"></i>
                        </div>
                        <div>
                            <p class="small text-white-50 mb-0 text-uppercase fw-bold" style="font-size: 0.6875rem; letter-spacing: 0.05em;">WhatsApp</p>
                            <a href="https://wa.me/<?= e(preg_replace('/[^0-9]/', '', $whatsapp)) ?>" target="_blank" class="text-white fw-bold text-decoration-none" style="font-family: var(--font-display);"><?= e($whatsapp) ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Location search
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('locationSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const q = this.value.toLowerCase().trim();
            document.querySelectorAll('.location-item').forEach(item => {
                const name = item.getAttribute('data-name');
                item.style.display = name.includes(q) ? '' : 'none';
            });
        });
    }
    
    // Toggle locations
    const toggleBtn = document.getElementById('toggleLocations');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            const more = document.getElementById('moreLocations');
            const expanded = this.getAttribute('data-expanded') === 'true';
            more.classList.toggle('d-none');
            this.setAttribute('data-expanded', !expanded);
            this.querySelector('span').textContent = expanded ? 'Show All <?= $totalLocations ?> Chennai Locations' : 'Show Fewer Localities';
            this.querySelector('i').style.transform = expanded ? '' : 'rotate(180deg)';
        });
    }
    
    // Booking form
    const bookingForm = document.getElementById('bookingFormSubmit');
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
                    document.getElementById('bookingFormSubmit').classList.add('d-none');
                    document.getElementById('bookingSuccess').classList.remove('d-none');
                } else {
                    alert(data.message || 'Something went wrong');
                }
            })
            .catch(() => {
                alert('Network error. Please try again.');
            });
        });
    }
});

function resetBookingForm() {
    document.getElementById('bookingFormSubmit').classList.remove('d-none');
    document.getElementById('bookingSuccess').classList.add('d-none');
    document.getElementById('bookingFormSubmit').reset();
}
</script>

<?php
// Service Detail Modal
include __DIR__ . '/includes/service-modal.php';
include __DIR__ . '/footer.php';
?>
