<?php
$current_page = basename($_SERVER['SCRIPT_NAME']);
$current_dir = basename(dirname($_SERVER['SCRIPT_NAME']));
$is_active = fn($pages) => in_array($current_page, (array)$pages) || in_array($current_dir, (array)$pages);
?>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="logo-icon bg-gradient rounded-2 d-flex align-items-center justify-content-center">
                <i class="ti ti-ambulance text-white"></i>
            </div>
            <div class="logo-text">
                <span class="fw-black"><?= e(getSetting('app_name') ?: 'RG') ?></span>
                <small class="text-muted">CMS Panel</small>
            </div>
        </div>
    </div>
    
    <div class="sidebar-body">
        <ul class="sidebar-nav">
            <li class="nav-label">Main</li>
            <li class="<?= $current_page === 'dashboard.php' ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/dashboard.php"><i class="ti ti-dashboard"></i><span>Dashboard</span></a>
            </li>
            
            <li class="nav-label">Content</li>
            <li class="<?= $is_active(['hero-slides.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/hero-slides.php"><i class="ti ti-slideshow"></i><span>Hero Slides</span></a>
            </li>
            <li class="<?= $is_active(['services.php', 'service-features.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/services.php"><i class="ti ti-truck"></i><span>Services</span></a>
            </li>
            <li class="<?= $is_active(['testimonials.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/testimonials.php"><i class="ti ti-message-star"></i><span>Testimonials</span></a>
            </li>
            <li class="<?= $is_active(['blog.php', 'blog-categories.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/blog.php"><i class="ti ti-news"></i><span>Blog Posts</span></a>
            </li>
            <li class="<?= $is_active(['gallery.php', 'albums.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/gallery.php"><i class="ti ti-photo"></i><span>Gallery</span></a>
            </li>
            <li class="<?= $is_active(['pages.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/pages.php"><i class="ti ti-file-text"></i><span>Static Pages</span></a>
            </li>
            
            <li class="nav-label">Modules</li>
            <li class="<?= $is_active(['bookings.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/bookings.php"><i class="ti ti-calendar-stats"></i><span>Bookings</span><span class="nav-badge" id="bookingBadge">0</span></a>
            </li>
            <li class="<?= $is_active(['inquiries.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/inquiries.php"><i class="ti ti-mail"></i><span>Inquiries</span><span class="nav-badge" id="inquiryBadge">0</span></a>
            </li>
            <li class="<?= $is_active(['team.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/team.php"><i class="ti ti-users"></i><span>Team</span></a>
            </li>
            <li class="<?= $is_active(['certificates.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/certificates.php"><i class="ti ti-certificate"></i><span>Certificates</span></a>
            </li>
            <li class="<?= $is_active(['timeline.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/timeline.php"><i class="ti ti-timeline"></i><span>Timeline</span></a>
            </li>
            <li class="<?= $is_active(['sister-concerns.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/sister-concerns.php"><i class="ti ti-building"></i><span>Sister Concerns</span></a>
            </li>
            <li class="<?= $is_active(['capabilities.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/capabilities.php"><i class="ti ti-chart-bar"></i><span>Capabilities</span></a>
            </li>
            <li class="<?= $is_active(['navigation.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/navigation.php"><i class="ti ti-menu-2"></i><span>Navigation</span></a>
            </li>
            <li class="<?= $is_active(['statistics.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/statistics.php"><i class="ti ti-numbers"></i><span>Statistics</span></a>
            </li>
            <li class="<?= $is_active(['seo.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/seo.php"><i class="ti ti-search"></i><span>SEO Meta</span></a>
            </li>
            
            <li class="nav-label">System</li>
            <li class="<?= $is_active(['footer-settings.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/footer-settings.php"><i class="ti ti-layout"></i><span>Footer Settings</span></a>
            </li>
            <li class="<?= $is_active(['settings.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/settings.php"><i class="ti ti-settings"></i><span>Settings</span></a>
            </li>
            <li class="<?= $is_active(['profile.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/profile.php"><i class="ti ti-user"></i><span>Profile</span></a>
            </li>
            <li class="<?= $is_active(['logs.php']) ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/admin/pages/logs.php"><i class="ti ti-activity"></i><span>Activity Logs</span></a>
            </li>
            <li>
                <a href="<?= BASE_URL ?>/admin/logout.php" class="text-danger"><i class="ti ti-logout"></i><span>Logout</span></a>
            </li>
        </ul>
    </div>
</aside>
