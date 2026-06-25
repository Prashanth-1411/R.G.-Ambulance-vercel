<?php
require_once __DIR__ . '/includes/functions.php';
$seo = getSEOMeta('about');
$phone = getSetting('phone_primary') ?: '+91 95516 63530';

// Get sister concerns
$sisters = db()->query("SELECT * FROM sister_concerns WHERE status = 1 ORDER BY sort_order ASC")->fetchAll();

// Get team members
$team = db()->query("SELECT * FROM team_members WHERE status = 1 ORDER BY sort_order ASC")->fetchAll();

// Get certificates
$certificates = db()->query("SELECT * FROM certificates WHERE status = 1 ORDER BY sort_order ASC")->fetchAll();

// Get timeline
$timeline = db()->query("SELECT * FROM company_timeline WHERE status = 1 ORDER BY year ASC")->fetchAll();

// Get capabilities
$capabilities = db()->query("SELECT * FROM capabilities WHERE status = 1 ORDER BY sort_order ASC")->fetchAll();

include __DIR__ . '/header.php';
?>

<section class="page-hero" style="min-height: 50vh;">
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="hero-shape hero-shape-3"></div>
    <div class="position-absolute inset-0" style="background: linear-gradient(135deg, var(--navy-900), var(--navy-800), var(--navy-900));"></div>
    <div class="hero-grid"></div>
    <div class="container position-relative" style="z-index: 10;">
        <div class="row align-items-center g-5 py-4">
            <div class="col-lg-7">
                <span class="hero-badge"><i class="fas fa-building"></i> About Us</span>
                <h1 class="hero-title mt-4">Trusted Since <span class="text-gradient">2013</span></h1>
                <p class="hero-subtitle mt-3">R.G. Ambulance Service has been a cornerstone of emergency medical transport in Tamil Nadu, setting the benchmark for quality, speed, and compassion in pre-hospital care.</p>
                <div class="hero-actions d-flex flex-wrap gap-3 mt-4">
                    <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="btn-premium"><i class="fas fa-phone-alt me-2"></i> <?= e($phone) ?></a>
                    <a href="#story" class="btn-outline-premium"><i class="fas fa-book-open me-2"></i> Our Story</a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="position-relative">
                    <div style="background: linear-gradient(135deg, var(--brand-500), var(--brand-700)); border-radius: 24px; filter: blur(60px); opacity: 0.2; position: absolute; inset: 0;"></div>
                    <div class="position-relative rounded-4 overflow-hidden border border-white border-opacity-10">
                        <img src="https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=600&q=80" alt="About RG Ambulance" class="w-100" style="height: 450px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== STORY + MISSION ===== -->
<section id="story" class="bg-white">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="section-label"><i class="fas fa-book-open"></i> Our Story</div>
                <h2 class="section-title text-start">A Legacy of Lifesaving Excellence</h2>
                <p class="text-muted">Founded in 2013 with a single ICU ambulance, R.G. Ambulance Service has grown into one of Tamil Nadu's most trusted emergency medical transport providers. Our journey began with a simple mission — to ensure that no life is lost due to lack of timely, professional ambulance service.</p>
                <p class="text-muted">Today, we operate a fleet of 34+ modern ambulances, staffed by experienced paramedics and critical care professionals. From basic life support to fully equipped ICU mobile units, we serve across Tamil Nadu, Karnataka, Andhra Pradesh, and Pondicherry.</p>
                <div class="d-flex flex-wrap gap-4 mt-4">
                    <div><span class="fw-black fs-2" style="color: var(--brand-600);">12+</span><p class="text-muted small mb-0">Years of Service</p></div>
                    <div><span class="fw-black fs-2" style="color: var(--brand-600);">8,200+</span><p class="text-muted small mb-0">Patients Transported</p></div>
                    <div><span class="fw-black fs-2" style="color: var(--brand-600);">34+</span><p class="text-muted small mb-0">Active Fleet</p></div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-4 rounded-4" style="background: var(--brand-50);">
                            <div class="premium-gradient d-inline-flex align-items-center justify-content-center rounded-2 p-3 mb-3">
                                <i class="fas fa-bullseye text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="fw-bold">Our Mission</h5>
                            <p class="small text-muted mb-0">To provide rapid, reliable, and compassionate emergency medical transport with the highest standards of clinical care.</p>
                        </div>
                    </div>
                    <div class="col-6 mt-4">
                        <div class="p-4 rounded-4" style="background: var(--navy-50);">
                            <div class="premium-gradient d-inline-flex align-items-center justify-content-center rounded-2 p-3 mb-3">
                                <i class="fas fa-eye text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="fw-bold">Our Vision</h5>
                            <p class="small text-muted mb-0">To be the gold standard in emergency medical services across South India, combining clinical excellence with heartfelt care.</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 rounded-4" style="background: var(--brand-50);">
                            <div class="premium-gradient d-inline-flex align-items-center justify-content-center rounded-2 p-3 mb-3">
                                <i class="fas fa-heart text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="fw-bold">Our Values</h5>
                            <p class="small text-muted mb-0">Integrity, speed, clinical excellence, patient dignity, and round-the-clock availability.</p>
                        </div>
                    </div>
                    <div class="col-6 mt-4">
                        <div class="p-4 rounded-4" style="background: var(--navy-50);">
                            <div class="premium-gradient d-inline-flex align-items-center justify-content-center rounded-2 p-3 mb-3">
                                <i class="fas fa-shield-alt text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="fw-bold">Accreditations</h5>
                            <p class="small text-muted mb-0">ISO 9001:2015 Certified · Govt. Approved · Recognized by Major Hospitals</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== CAPABILITIES ===== -->
<?php if (!empty($capabilities)): ?>
<section style="background: var(--navy-50);">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label"><i class="fas fa-chart-bar"></i> Our Capabilities</div>
            <h2 class="section-title">What Sets Us Apart</h2>
        </div>
        <div class="row g-4 mt-4">
            <?php foreach ($capabilities as $cap): ?>
            <div class="col-md-3 col-6" data-aos="fade-up">
                <div class="text-center p-4 rounded-4 bg-white shadow-sm">
                    <div class="premium-gradient d-inline-flex align-items-center justify-content-center rounded-3 mb-3" style="width: 56px; height: 56px;">
                        <i class="<?= e($cap['icon'] ?: 'fas fa-check') ?> text-white" style="font-size: 1.25rem;"></i>
                    </div>
                    <h3 class="fw-black fs-1 mb-0" style="color: var(--navy-900);"><?= e($cap['value']) ?></h3>
                    <p class="small text-muted mt-1"><?= e($cap['label']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ===== TIMELINE ===== -->
<?php if (!empty($timeline)): ?>
<section class="bg-white">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label"><i class="fas fa-timeline"></i> Our Journey</div>
            <h2 class="section-title">Company Timeline</h2>
        </div>
        <div class="timeline mt-5" data-aos="fade-up">
            <?php foreach ($timeline as $t): ?>
            <div class="timeline-item <?= $t['is_highlight'] ? 'highlight' : '' ?>">
                <div class="timeline-dot"></div>
                <div class="timeline-year"><?= e($t['year']) ?></div>
                <div class="timeline-content">
                    <h5 class="fw-bold mb-1"><?= e($t['title']) ?></h5>
                    <p class="text-muted small mb-0"><?= e($t['description']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ===== SISTER CONCERNS ===== -->
<?php if (!empty($sisters)): ?>
<section style="background: var(--navy-50);">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label"><i class="fas fa-link"></i> Sister Concerns</div>
            <h2 class="section-title">Our Group of Companies</h2>
        </div>
        <div class="row g-4 mt-4">
            <?php foreach ($sisters as $s): ?>
            <div class="col-md-4" data-aos="fade-up">
                <div class="p-4 bg-white rounded-4 shadow-sm text-center h-100">
                    <div class="premium-gradient d-inline-flex align-items-center justify-content-center rounded-3 mb-3" style="width: 56px; height: 56px;">
                        <i class="<?= e($s['icon'] ?: 'fas fa-building') ?> text-white"></i>
                    </div>
                    <h5 class="fw-bold"><?= e($s['name']) ?></h5>
                    <p class="small text-muted"><?= e($s['description']) ?></p>
                    <?php if ($s['website']): ?>
                    <a href="<?= e($s['website']) ?>" target="_blank" class="btn-outline-premium small py-1 px-3">Visit <i class="fas fa-external-link-alt ms-1"></i></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ===== TEAM ===== -->
<?php if (!empty($team)): ?>
<section class="bg-white">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label"><i class="fas fa-users"></i> Leadership</div>
            <h2 class="section-title">Meet Our Team</h2>
        </div>
        <div class="row g-4 mt-4">
            <?php foreach ($team as $m): ?>
            <div class="col-md-3 col-6" data-aos="fade-up">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <?php if ($m['image']): ?>
                        <img src="<?= getMediaUrl($m['image']) ?>" alt="<?= e($m['name']) ?>" class="team-img">
                        <?php else: ?>
                        <div style="height: 240px; background: var(--navy-100); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-tie" style="font-size: 3rem; color: var(--navy-300);"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-3 text-center">
                        <h6 class="fw-bold mb-0"><?= e($m['name']) ?></h6>
                        <p class="text-muted small"><?= e($m['designation']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ===== CERTIFICATES ===== -->
<?php if (!empty($certificates)): ?>
<section style="background: var(--navy-50);">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-label"><i class="fas fa-award"></i> Certifications</div>
            <h2 class="section-title">Our Certifications & Accreditations</h2>
        </div>
        <div class="row g-4 mt-4">
            <?php foreach ($certificates as $cert): ?>
            <div class="col-md-3 col-6" data-aos="fade-up">
                <div class="certificate-card text-center">
                    <div class="premium-gradient d-inline-flex align-items-center justify-content-center rounded-3 mb-3" style="width: 64px; height: 64px;">
                        <i class="fas fa-certificate text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h6 class="fw-bold small"><?= e($cert['title']) ?></h6>
                    <p class="text-muted small"><?= e($cert['issuer']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include __DIR__ . '/includes/service-modal.php'; ?>
<?php include __DIR__ . '/footer.php'; ?>
