// ============================================
// R.G. Ambulance Service - Main JavaScript
// GSAP + Bootstrap + Custom
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    
    // ===== NAVBAR SCROLL EFFECT =====
    const navbar = document.getElementById('mainNav');
    const scrollProgress = document.getElementById('scrollProgress');
    
    window.addEventListener('scroll', function() {
        // Navbar
        if (window.scrollY > 40) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
        
        // Scroll progress
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        scrollProgress.style.width = scrolled + '%';
    });

    // ===== GSAP ANIMATIONS =====
    gsap.registerPlugin(ScrollTrigger);

    // Hero animations
    const heroTl = gsap.timeline({ defaults: { ease: 'power3.out' } });
    heroTl
        .from('.hero-badge', { opacity: 0, y: 30, duration: 0.6 })
        .from('.hero-title', { opacity: 0, y: 50, duration: 0.8 }, '-=0.3')
        .from('.hero-subtitle', { opacity: 0, y: 40, duration: 0.7 }, '-=0.4')
        .from('.hero-actions', { opacity: 0, y: 30, duration: 0.6 }, '-=0.3')
        .from('.hero-stats', { opacity: 0, y: 20, duration: 0.5 }, '-=0.2')
        .from('.hero-image-wrap', { opacity: 0, x: 80, duration: 0.9 }, '-=0.6');

    // Counters animation
    const counters = document.querySelectorAll('.stat-number');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target') || counter.textContent.replace(/[^0-9]/g, ''));
        const suffix = counter.getAttribute('data-suffix') || counter.textContent.replace(/[0-9]/g, '') || '+';
        
        ScrollTrigger.create({
            trigger: counter.closest('.stat-item'),
            start: 'top 85%',
            once: true,
            onEnter: () => {
                gsap.to(counter, {
                    textContent: target,
                    duration: 2,
                    ease: 'power2.out',
                    snap: { textContent: 1 },
                    onUpdate: function() {
                        // Keep the original text content structure
                    }
                });
            }
        });
    });

    // Fade up sections on scroll
    gsap.utils.toArray('.fade-section').forEach(section => {
        gsap.from(section, {
            scrollTrigger: {
                trigger: section,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            opacity: 0,
            y: 60,
            duration: 0.8,
            ease: 'power3.out'
        });
    });

    // Service cards stagger animation
    gsap.utils.toArray('.service-card-stagger').forEach((container, index) => {
        const cards = container.querySelectorAll('.service-card');
        gsap.from(cards, {
            scrollTrigger: {
                trigger: container,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            opacity: 0,
            y: 40,
            duration: 0.5,
            stagger: 0.1,
            ease: 'power2.out'
        });
    });

    // Feature items stagger
    gsap.utils.toArray('.feature-stagger').forEach(container => {
        const items = container.querySelectorAll('.feature-item');
        gsap.from(items, {
            scrollTrigger: {
                trigger: container,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            opacity: 0,
            x: -30,
            duration: 0.5,
            stagger: 0.1,
            ease: 'power2.out'
        });
    });

    // Blog cards stagger
    gsap.utils.toArray('.blog-stagger').forEach(container => {
        const cards = container.querySelectorAll('.blog-card');
        gsap.from(cards, {
            scrollTrigger: {
                trigger: container,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            opacity: 0,
            y: 40,
            duration: 0.5,
            stagger: 0.1,
            ease: 'power2.out'
        });
    });

    // Testimonial cards stagger
    gsap.utils.toArray('.testimonial-stagger').forEach(container => {
        const cards = container.querySelectorAll('.testimonial-card');
        gsap.from(cards, {
            scrollTrigger: {
                trigger: container,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            opacity: 0,
            y: 40,
            duration: 0.5,
            stagger: 0.1,
            ease: 'power2.out'
        });
    });

    // Location buttons stagger
    gsap.utils.toArray('.location-stagger').forEach(container => {
        const btns = container.querySelectorAll('.location-btn');
        gsap.from(btns, {
            scrollTrigger: {
                trigger: container,
                start: 'top 88%',
                toggleActions: 'play none none none'
            },
            opacity: 0,
            y: 20,
            duration: 0.3,
            stagger: 0.02,
            ease: 'power1.out'
        });
    });

    // ===== FILTER BUTTONS =====
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            const targetGrid = document.querySelector(this.getAttribute('data-target') || '.filter-grid');
            
            if (targetGrid) {
                const items = targetGrid.querySelectorAll('.filter-item');
                items.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.style.display = '';
                        gsap.from(item, { opacity: 0, y: 20, duration: 0.3, clearProps: 'opacity' });
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
        });
    });

    // ===== SERVICE DETAIL MODAL =====
    document.querySelectorAll('[data-open-modal]').forEach(btn => {
        btn.addEventListener('click', function() {
            const target = this.getAttribute('data-open-modal');
            const modal = document.getElementById(target);
            if (modal) {
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
                
                // Set service name in booking form if applicable
                const serviceName = this.getAttribute('data-service');
                const nameInput = modal.querySelector('[name="service_name"]');
                if (nameInput && serviceName) {
                    nameInput.value = serviceName;
                }
            }
        });
    });

    // ===== HERO SLIDER (if present) =====
    const heroCarousel = document.getElementById('heroCarousel');
    if (heroCarousel) {
        new bootstrap.Carousel(heroCarousel, {
            interval: 6000,
            ride: 'carousel',
            pause: false
        });
    }

    // ===== SMOOTH SCROLL FOR ANCHOR LINKS =====
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ===== MAGNETIC HOVER EFFECT =====
    document.querySelectorAll('.magnetic').forEach(el => {
        el.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            gsap.to(this, { x: x * 0.3, y: y * 0.3, duration: 0.3, ease: 'power2.out' });
        });
        
        el.addEventListener('mouseleave', function() {
            gsap.to(this, { x: 0, y: 0, duration: 0.5, ease: 'elastic.out(1, 0.3)' });
        });
    });
});
