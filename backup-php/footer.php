<?php
// ============================================
// Site Footer
// ============================================
$navItems = getNavigation();
$phone = getSetting('phone_primary') ?: '+91 95516 63530';
$phone2 = getSetting('phone_secondary') ?: '+91 87784 81556';
$email = getSetting('email') ?: 'ebenezer.r@rgambulanceservice.com';
$address = getSetting('address') ?: '115/2a, Ambattur Road, Surapet, Soorapattu, Ambattur Taluka, Chennai - 600066';
$facebook = getSetting('facebook');
$twitter = getSetting('twitter');
$instagram = getSetting('instagram');
$linkedin = getSetting('linkedin');
$youtube = getSetting('youtube');
?>
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="site-footer">
        <div class="footer-top">
            <div class="container">
                <div class="row g-5">
                    <!-- Brand -->
                    <div class="col-lg-4">
                        <div class="footer-brand">
                            <div class="brand-icon">
                                <i class="fas fa-ambulance"></i>
                            </div>
                            <div>
                                <h5>R.G. <span class="text-brand">AMBULANCE</span></h5>
                                <span class="brand-tagline">Emergency Medical Services</span>
                            </div>
                        </div>
                        <p class="footer-desc">Advanced ICU ambulances, trained medical staff, and rapid emergency response across India. Trusted by thousands for emergency medical transport and dignified funeral services since 2014.</p>
                        <div class="footer-social">
                            <?php if ($facebook): ?>
                            <a href="<?= e($facebook) ?>" target="_blank" rel="noreferrer"><i class="fab fa-facebook-f"></i></a>
                            <?php endif; ?>
                            <?php if ($twitter): ?>
                            <a href="<?= e($twitter) ?>" target="_blank" rel="noreferrer"><i class="fab fa-twitter"></i></a>
                            <?php endif; ?>
                            <?php if ($instagram): ?>
                            <a href="<?= e($instagram) ?>" target="_blank" rel="noreferrer"><i class="fab fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if ($linkedin): ?>
                            <a href="<?= e($linkedin) ?>" target="_blank" rel="noreferrer"><i class="fab fa-linkedin-in"></i></a>
                            <?php endif; ?>
                            <?php if ($youtube): ?>
                            <a href="<?= e($youtube) ?>" target="_blank" rel="noreferrer"><i class="fab fa-youtube"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-2">
                        <h6 class="footer-heading">Quick Links</h6>
                        <ul class="footer-links">
                            <?php foreach ($navItems as $item): ?>
                            <li><a href="<?= BASE_URL . e($item['link']) ?>"><i class="fas fa-chevron-right"></i> <?= e($item['label']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Ambulance Fleet -->
                    <div class="col-lg-2">
                        <h6 class="footer-heading">Ambulance Fleet</h6>
                        <ul class="footer-links">
                            <?php
                            $stmt = db()->prepare("SELECT title, slug FROM services WHERE service_type = 'ambulance' AND status = 1 LIMIT 6");
                            $stmt->execute();
                            $fleetServices = $stmt->fetchAll();
                            foreach ($fleetServices as $svc):
                            ?>
                            <li><a href="<?= BASE_URL ?>/ambulance-services#<?= e($svc['slug']) ?>"><i class="fas fa-chevron-right"></i> <?= e($svc['title']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div class="col-lg-4">
                        <h6 class="footer-heading">Contact 24/7</h6>
                        <div class="footer-contact">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <span class="contact-label">Address</span>
                                    <p><?= e($address) ?></p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <span class="contact-label">Email</span>
                                    <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a>
                                </div>
                            </div>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div>
                                    <span class="contact-label">Emergency Hotline</span>
                                    <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="hotline"><?= e($phone) ?></a>
                                    <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone2)) ?>"><?= e($phone2) ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="footer-badge">
                            <i class="fas fa-heart text-danger"></i>
                            <span><strong>ISO 9001:2015 Certified</strong><br>Govt. Approved Emergency Services</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p>&copy; <?= date('Y') ?> <?= getSiteName() ?>. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p>Designed by <span class="text-brand fw-semibold">Prashath Web Tech</span></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- ===== FLOATING CTA ===== -->
    <div class="floating-cta">
        <a href="https://wa.me/<?= e(preg_replace('/[^0-9]/', '', getSetting('whatsapp') ?: '918778481556')) ?>?text=Emergency+Ambulance+Required" target="_blank" rel="noreferrer" class="cta-whatsapp" title="WhatsApp Us">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="cta-call" title="Call Now">
            <i class="fas fa-phone-alt"></i>
        </a>
    </div>

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/MotionPathPlugin.min.js"></script>
    
    <script src="<?= BASE_URL ?>/assets/js/main.js"></script>
    
    <script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100,
    });
    </script>
</body>
</html>
