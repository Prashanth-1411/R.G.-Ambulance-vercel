<?php
$page_title = 'Dashboard';
require_once __DIR__ . '/partials/header.php';

// Stats
$stats = [
    'services' => db()->query("SELECT COUNT(*) FROM services WHERE status = 1")->fetchColumn(),
    'testimonials' => db()->query("SELECT COUNT(*) FROM testimonials WHERE status = 1")->fetchColumn(),
    'blog_posts' => db()->query("SELECT COUNT(*) FROM blog_posts WHERE status = 1")->fetchColumn(),
    'bookings' => db()->query("SELECT COUNT(*) FROM bookings WHERE DATE(created_at) = CURDATE()")->fetchColumn(),
    'inquiries' => db()->query("SELECT COUNT(*) FROM contact_inquiries WHERE status = 'unread'")->fetchColumn(),
    'total_bookings' => db()->query("SELECT COUNT(*) FROM bookings")->fetchColumn(),
];

// Chart data - bookings last 7 days
$chartData = [];
for ($i = 6; $i >= 0; $i--) {
    $day = date('Y-m-d', strtotime("-$i days"));
    $q = db()->prepare("SELECT COUNT(*) FROM bookings WHERE DATE(created_at) = ?");
    $q->execute([$day]);
    $chartData[] = ['date' => $day, 'count' => (int)$q->fetchColumn()];
}

// Recent activity
$activities = db()->query("SELECT * FROM activity_logs ORDER BY created_at DESC LIMIT 10")->fetchAll();

// Recent bookings
$recentBookings = db()->query("SELECT * FROM bookings ORDER BY created_at DESC LIMIT 5")->fetchAll();

// Notifications count
$notifCount = db()->query("SELECT COUNT(*) FROM notifications WHERE is_read = 0")->fetchColumn();
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1">Dashboard</h4>
        <p class="text-muted small mb-0">Welcome back, <?= e($_SESSION['user']['name'] ?? 'Admin') ?>! Here's what's happening today.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= BASE_URL ?>/admin/pages/bookings.php" class="btn btn-outline-secondary btn-sm"><i class="ti ti-calendar-stats me-1"></i> Bookings</a>
        <a href="<?= BASE_URL ?>/admin/pages/inquiries.php" class="btn btn-gradient btn-sm"><i class="ti ti-mail me-1"></i> Inquiries</a>
    </div>
</div>

<!-- Stat cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6"><div class="stat-card"><div class="stat-icon" style="background: rgba(59,130,246,0.1); color: var(--brand-400);"><i class="ti ti-truck"></i></div><div class="stat-info"><span class="stat-value" data-count="<?= $stats['services'] ?>"><?= $stats['services'] ?></span><span class="stat-label">Active Services</span></div></div></div>
    <div class="col-md-3 col-6"><div class="stat-card"><div class="stat-icon" style="background: rgba(16,185,129,0.1); color: #34d399;"><i class="ti ti-message-star"></i></div><div class="stat-info"><span class="stat-value" data-count="<?= $stats['testimonials'] ?>"><?= $stats['testimonials'] ?></span><span class="stat-label">Testimonials</span></div></div></div>
    <div class="col-md-3 col-6"><div class="stat-card"><div class="stat-icon" style="background: rgba(139,92,246,0.1); color: #a78bfa;"><i class="ti ti-news"></i></div><div class="stat-info"><span class="stat-value" data-count="<?= $stats['blog_posts'] ?>"><?= $stats['blog_posts'] ?></span><span class="stat-label">Blog Posts</span></div></div></div>
    <div class="col-md-3 col-6"><div class="stat-card"><div class="stat-icon" style="background: rgba(239,68,68,0.1); color: #ef4444;"><i class="ti ti-calendar-stats"></i></div><div class="stat-info"><span class="stat-value" data-count="<?= $stats['bookings'] ?>"><?= $stats['bookings'] ?></span><span class="stat-label">Today's Bookings</span></div></div></div>
</div>

<div class="row g-4">
    <!-- Chart -->
    <div class="col-lg-8">
        <div class="card-container">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0"><i class="ti ti-chart-line me-2"></i>Bookings (Last 7 Days)</h6>
                <span class="badge bg-secondary"><?= $stats['total_bookings'] ?> total</span>
            </div>
            <canvas id="bookingsChart" height="200"></canvas>
        </div>
        
        <!-- Recent bookings table -->
        <div class="card-container mt-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0"><i class="ti ti-list me-2"></i>Recent Bookings</h6>
                <a href="<?= BASE_URL ?>/admin/pages/bookings.php" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead><tr><th>Name</th><th>Service</th><th>Date</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php foreach ($recentBookings as $b): ?>
                        <tr>
                            <td class="fw-semibold"><?= e($b['name']) ?></td>
                            <td><span class="badge bg-info bg-opacity-10 text-info"><?= e($b['service_name']) ?></span></td>
                            <td class="text-muted small"><?= date('d M Y', strtotime($b['created_at'])) ?></td>
                            <td><span class="badge bg-<?= $b['status'] === 'confirmed' ? 'success' : ($b['status'] === 'pending' ? 'warning' : 'secondary') ?> bg-opacity-10 text-<?= $b['status'] === 'confirmed' ? 'success' : ($b['status'] === 'pending' ? 'warning' : 'secondary') ?>"><?= e($b['status']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($recentBookings)): ?>
                        <tr><td colspan="4" class="text-center text-muted small">No bookings yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Right sidebar -->
    <div class="col-lg-4">
        <!-- Inquiry alert -->
        <?php if ($stats['inquiries'] > 0): ?>
        <div class="alert alert-warning bg-warning bg-opacity-10 border border-warning border-opacity-25 d-flex align-items-center gap-2 small">
            <i class="ti ti-mail fs-4"></i>
            <div><strong><?= $stats['inquiries'] ?> unread</strong> inquiry<?= $stats['inquiries'] > 1 ? 'ies' : 'y' ?> — <a href="<?= BASE_URL ?>/admin/pages/inquiries.php" class="text-warning">Review now</a></div>
        </div>
        <?php endif; ?>
        
        <!-- Activity timeline -->
        <div class="card-container">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0"><i class="ti ti-activity me-2"></i>Recent Activity</h6>
            </div>
            <div class="activity-timeline">
                <?php foreach ($activities as $act): ?>
                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <div>
                        <p class="mb-0 small fw-semibold"><?= e($act['action']) ?></p>
                        <p class="mb-0 text-muted fs-11"><?= e($act['details'] ?? '') ?> · <?= timeAgo($act['created_at']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if (empty($activities)): ?>
                <div class="text-center text-muted small py-3">No recent activity.</div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Quick actions -->
        <div class="card-container mt-4">
            <h6 class="fw-bold mb-3"><i class="ti ti-bolt me-2"></i>Quick Actions</h6>
            <div class="d-flex flex-column gap-2">
                <a href="<?= BASE_URL ?>/admin/pages/services.php" class="btn btn-outline-secondary btn-sm text-start"><i class="ti ti-plus me-2"></i>Add Service</a>
                <a href="<?= BASE_URL ?>/admin/pages/blog.php" class="btn btn-outline-secondary btn-sm text-start"><i class="ti ti-plus me-2"></i>New Blog Post</a>
                <a href="<?= BASE_URL ?>/admin/pages/testimonials.php" class="btn btn-outline-secondary btn-sm text-start"><i class="ti ti-plus me-2"></i>Add Testimonial</a>
                <a href="<?= BASE_URL ?>/admin/pages/settings.php" class="btn btn-outline-secondary btn-sm text-start"><i class="ti ti-settings me-2"></i>Site Settings</a>
            </div>
        </div>
    </div>
</div>

<script>
const bookingChartData = <?= json_encode($chartData) ?>;
</script>

<?php
$extra_js = '<script>
$(document).ready(function() {
    const ctx = document.getElementById("bookingsChart").getContext("2d");
    new Chart(ctx, {
        type: "line",
        data: {
            labels: bookingChartData.map(d => d.date.slice(5)),
            datasets: [{
                label: "Bookings",
                data: bookingChartData.map(d => d.count),
                borderColor: "#3b82f6",
                backgroundColor: "rgba(59,130,246,0.1)",
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: "#3b82f6"
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } }, x: { grid: { display: false } } }
        }
    });
});
</script>';
include __DIR__ . '/partials/footer.php'; ?>
