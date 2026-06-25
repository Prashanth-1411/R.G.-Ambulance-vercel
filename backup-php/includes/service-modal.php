<?php
// ============================================
// Service Detail Modal
// ============================================
$phone = getSetting('phone_primary') ?: '+91 95516 63530';
?>
<div class="modal fade premium-modal" id="serviceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="premium-gradient d-flex align-items-center justify-content-center rounded-2" style="width: 48px; height: 48px; box-shadow: var(--shadow-glow);">
                        <i class="fas fa-ambulance text-white" style="font-size: 1.25rem;"></i>
                    </div>
                    <div>
                        <span class="small text-uppercase fw-bold" style="color: var(--brand-600); letter-spacing: 0.05em; font-size: 0.6875rem;">Vehicle Details</span>
                        <h5 class="modal-title fw-black" id="serviceModalTitle" style="font-family: var(--font-display);">Service Name</h5>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="serviceModalContent">
                    <!-- Dynamic content loaded via JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade premium-modal" id="bookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="premium-gradient d-flex align-items-center justify-content-center rounded-2" style="width: 40px; height: 40px;">
                        <i class="fas fa-calendar-alt text-white"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold" id="bookingModalTitle" style="font-family: var(--font-display);">Book: Service</h5>
                        <p class="small text-muted mb-0">Fill the patient coordinates below</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="bookingModalForm" class="form-premium">
                    <?= csrf_field() ?>
                    <input type="hidden" name="service_name" id="bookingServiceName">
                    <div class="mb-3">
                        <label class="form-label">Contact Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="Enter name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Phone</label>
                        <input type="tel" name="phone" class="form-control" required placeholder="Enter phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pickup Location</label>
                        <input type="text" name="pickup" class="form-control" required placeholder="Enter pickup">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Destination</label>
                        <input type="text" name="destination" class="form-control" required placeholder="Enter destination">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label">Date</label>
                            <input type="date" name="booking_date" class="form-control" value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Notes</label>
                            <input type="text" name="notes" class="form-control" placeholder="Optional">
                        </div>
                    </div>
                    <button type="submit" class="btn-premium w-100">
                        <i class="fas fa-paper-plane me-2"></i> Submit Booking Request
                    </button>
                    <div id="bookingModalSuccess" class="text-center d-none mt-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                        <h5 class="mt-2 fw-bold">Booking Confirmed</h5>
                        <p class="small text-muted">Dispatch desk will telephone you shortly.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Service modal
    const serviceModal = document.getElementById('serviceModal');
    if (serviceModal) {
        serviceModal.addEventListener('show.bs.modal', function(e) {
            const btn = e.relatedTarget;
            const serviceName = btn.getAttribute('data-service');
            document.getElementById('serviceModalTitle').textContent = serviceName || 'Service';
            
            // Fetch service details
            if (serviceName) {
                fetch('<?= BASE_URL ?>/admin/ajax/services.php?action=get_service&title=' + encodeURIComponent(serviceName))
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.data) {
                            const s = data.data;
                            let html = '<div class="row g-4"><div class="col-md-6">';
                            if (s.image) {
                                html += '<img src="' + s.image + '" class="w-100 rounded-3" style="height: 200px; object-fit: cover;" alt="' + s.title + '">';
                            }
                            html += '</div><div class="col-md-6"><h6 class="text-uppercase fw-bold small" style="color: var(--brand-600); letter-spacing: 0.05em;">Service Overview</h6>';
                            html += '<p class="small" style="color: var(--navy-600);">' + (s.description || '') + '</p></div></div>';
                            
                            if (s.features && s.features.length) {
                                html += '<h6 class="text-uppercase fw-bold small mt-4" style="color: var(--brand-600); letter-spacing: 0.05em;">Equipment & Features</h6>';
                                html += '<div class="row g-2">';
                                s.features.forEach(function(f) {
                                    html += '<div class="col-6"><div class="d-flex align-items-center gap-2 p-2 rounded-2" style="background: var(--navy-50);"><i class="fas fa-shield-check" style="color: var(--brand-500); font-size: 0.75rem;"></i><span class="small fw-semibold" style="color: var(--navy-700);">' + f + '</span></div></div>';
                                });
                                html += '</div>';
                            }
                            
                            html += '<div class="d-flex gap-3 mt-4 pt-3 border-top"><a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="btn flex-fill py-2 fw-bold" style="background: #dc2626; color: #fff;"><i class="fas fa-phone-alt me-1"></i> Call Now</a>';
                            html += '<button class="btn-premium flex-fill py-2" onclick="openBookingModal(\'' + s.title.replace(/'/g, "\\'") + '\')"><i class="fas fa-calendar-alt me-1"></i> Request Booking</button></div>';
                            
                            document.getElementById('serviceModalContent').innerHTML = html;
                        }
                    });
            }
        });
    }
    
    // Booking modal form
    const bookingModalForm = document.getElementById('bookingModalForm');
    if (bookingModalForm) {
        bookingModalForm.addEventListener('submit', function(e) {
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
                    this.querySelector('button[type="submit"]').classList.add('d-none');
                    document.getElementById('bookingModalSuccess').classList.remove('d-none');
                } else {
                    alert(data.message || 'Error');
                }
            });
        });
    }
});

function openBookingModal(serviceName) {
    document.getElementById('bookingServiceName').value = serviceName || '';
    document.getElementById('bookingModalTitle').textContent = 'Book: ' + (serviceName || 'Service');
    const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
    modal.show();
}
</script>
