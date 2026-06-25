<?php
// ============================================
// Site Header - Bootstrap 5 + GSAP
// ============================================
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/csrf.php';

// Start session for CSRF on frontend if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$navItems = getNavigation();
$logo = getSetting('logo');
$logoWidth = getSetting('logo_width') ?: 140;
$phone = getSetting('phone_primary') ?: '+91 95516 63530';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- SEO Meta -->
    <?php if (isset($seo) && $seo): ?>
    <title><?= e($seo['meta_title'] ?? getSiteName()) ?></title>
    <meta name="description" content="<?= e($seo['meta_description'] ?? '') ?>">
    <meta name="keywords" content="<?= e($seo['meta_keywords'] ?? '') ?>">
    <?php if (!empty($seo['og_title'])): ?>
    <meta property="og:title" content="<?= e($seo['og_title']) ?>">
    <meta property="og:description" content="<?= e($seo['og_description'] ?? '') ?>">
    <?php if (!empty($seo['og_image'])): ?>
    <meta property="og:image" content="<?= getMediaUrl($seo['og_image']) ?>">
    <?php endif; ?>
    <?php endif; ?>
    <?php else: ?>
    <title><?= getSiteName() ?></title>
    <?php endif; ?>
    
    <?php if (isset($canonical)): ?>
    <link rel="canonical" href="<?= e($canonical) ?>">
    <?php endif; ?>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= getMediaUrl(getSetting('favicon')) ?>">
    <link rel="apple-touch-icon" href="<?= getMediaUrl(getSetting('favicon')) ?>">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css?v=2">

    <!-- Structured Data -->
    <?php if (isset($seo) && !empty($seo['structured_data'])): ?>
    <script type="application/ld+json"><?= $seo['structured_data'] ?></script>
    <?php endif; ?>
</head>
<body>
    <!-- ===== SCROLL PROGRESS BAR ===== -->
    <div id="scrollProgress" class="scroll-progress"></div>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>/">
                <img src="<?= getMediaUrl($logo) ?>" alt="<?= getSiteName() ?>" height="<?= e($logoWidth) ?>" class="logo-img">
            </a>
            
            <div class="d-flex align-items-center gap-2 d-lg-none">
                <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="btn btn-emergency-sm" aria-label="Call emergency">
                    <i class="fas fa-phone-alt"></i>
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <?php foreach ($navItems as $item): ?>
                    <li class="nav-item">
                        <a class="nav-link<?= ($_SERVER['REQUEST_URI'] === $item['link'] || $_SERVER['REQUEST_URI'] === $item['link'] . '/') ? ' active' : '' ?>" href="<?= BASE_URL . e($item['link']) ?>">
                            <?= e($item['label']) ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div class="d-none d-lg-flex align-items-center">
                    <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>" class="btn btn-emergency">
                        <i class="fas fa-phone-alt me-2"></i>
                        24/7 Emergency: <?= e($phone) ?>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main id="mainContent">
