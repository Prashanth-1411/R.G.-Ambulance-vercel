<?php
require_once __DIR__ . '/includes/functions.php';
$seo = getSEOMeta('contact');
$phone = getSetting('phone_primary') ?: '+91 95516 63530';
$email = getSetting('email') ?: 'info@rgambulanceservice.com';
$address = getSetting('address') ?: '';
$map_embed = getSetting('map_embed') ?: '';

include __DIR__ . '/header.php';
?>

<section class="page-hero" style="min-height: 50vh;">
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="position-absolute inset-0" style="background: linear-gradient(135deg, var(--navy-900), var(--navy-800));"></div>
    <div class="hero-grid"></div>
    <div class="container position-relative" style="z-index: 10;">
        <div class="row align-items-center g-5 py-4">
            <div class="col-lg-7">
                <span class="hero-badge"><i class="fas fa-headset"></i> 24/7 Support</span>
                <h1 class="hero-title mt-4">Get In <span class="text-gradient">Touch</span></h1>
                <p class="hero-subtitle mt-3">Have a question, need assistance, or want to provide feedback? Our support team is available around the clock to assist you.</p>
                <div class="hero-actions d-flex flex-wrap gap-3 mt-4">
                    <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="btn-premium"><i class="fas fa-phone-alt me-2"></i> <?= e($phone) ?></a>
                    <a href="mailto:<?= e($email) ?>" class="btn-outline-premium"><i class="fas fa-envelope me-2"></i> <?= e($email) ?></a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="position-relative">
                    <div style="background: linear-gradient(135deg, var(--brand-500), var(--brand-700)); border-radius: 24px; filter: blur(60px); opacity: 0.2; position: absolute; inset: 0;"></div>
                    <div class="position-relative rounded-4 overflow-hidden border border-white border-opacity-10">
                        <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=600&q=80" alt="Contact us" class="w-100" style="height: 400px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <div class="section-label"><i class="fas fa-map-pin"></i> Contact Information</div>
                <h2 class="fs-2 fw-black mb-4" style="font-family: var(--font-display);">Reach Out Anytime</h2>
                
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: var(--navy-50);">
                        <div class="premium-gradient d-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width: 48px; height: 48px;">
                            <i class="fas fa-phone-alt text-white"></i>
                        </div>
                        <div>
                            <p class="small text-muted mb-0">Phone (24/7)</p>
                            <p class="fw-bold mb-0"><?= e($phone) ?></p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: var(--navy-50);">
                        <div class="premium-gradient d-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width: 48px; height: 48px;">
                            <i class="fas fa-envelope text-white"></i>
                        </div>
                        <div>
                            <p class="small text-muted mb-0">Email</p>
                            <p class="fw-bold mb-0"><?= e($email) ?></p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: var(--navy-50);">
                        <div class="premium-gradient d-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width: 48px; height: 48px;">
                            <i class="fas fa-map-marker-alt text-white"></i>
                        </div>
                        <div>
                            <p class="small text-muted mb-0">Head Office</p>
                            <p class="fw-bold mb-0"><?= nl2br(e($address)) ?></p>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <?php foreach (['facebook','instagram','twitter','linkedin','youtube'] as $s): 
                        $val = getSetting($s);
                        if ($val): ?>
                    <a href="<?= e($val) ?>" target="_blank" class="d-flex align-items-center justify-content-center rounded-3" style="width: 48px; height: 48px; background: var(--navy-50); color: var(--navy-600); transition: all 0.3s;" onmouseover="this.style.background='var(--brand-500)'; this.style.color='#fff';" onmouseout="this.style.background='var(--navy-50)'; this.style.color='var(--navy-600)';">
                        <i class="fab fa-<?= e($s) ?>"></i>
                    </a>
                    <?php endif; endforeach; ?>
                </div>
            </div>
            
            <div class="col-lg-7">
                <div class="section-label"><i class="fas fa-paper-plane"></i> Send Message</div>
                <h2 class="fs-2 fw-black mb-4" style="font-family: var(--font-display);">We'd Love to Hear From You</h2>
                
                <form id="contactForm" class="form-premium">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required placeholder="Your full name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required placeholder="your@email.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" placeholder="Optional">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Subject</label>
                            <select name="subject" class="form-select" required>
                                <option value="">Select subject</option>
                                <option value="General Inquiry">General Inquiry</option>
                                <option value="Ambulance Booking">Ambulance Booking</option>
                                <option value="Funeral Service">Funeral Service</option>
                                <option value="Feedback">Feedback / Complaint</option>
                                <option value="Partnership">Partnership Opportunity</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="5" required placeholder="How can we help you?" style="resize: none;"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn-premium magnetic"><i class="fas fa-paper-plane me-2"></i> Send Message</button>
                        </div>
                    </div>
                </form>
                <div id="contactSuccess" class="text-center p-5 d-none">
                    <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    <h4 class="mt-3 fw-bold">Message Sent Successfully!</h4>
                    <p class="text-muted small">We will get back to you shortly.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($map_embed): ?>
<section>
    <div class="container-fluid p-0">
        <div style="height: 400px;">
            <?= $map_embed ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            fd.append('action', 'submit_contact');
            fetch('<?= BASE_URL ?>/admin/ajax/contact.php', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(d => {
                    if (d.success) { this.classList.add('d-none'); document.getElementById('contactSuccess').classList.remove('d-none'); }
                    else alert(d.message || 'Error');
                });
        });
    }
});
</script>

<?php include __DIR__ . '/footer.php'; ?>
