<?php
require_once __DIR__ . '/includes/functions.php';
$seo = getSEOMeta('gallery');

// Get albums with images
$albums = db()->query("SELECT a.*, GROUP_CONCAT(g.image ORDER BY g.sort_order ASC SEPARATOR '||') as images 
    FROM albums a LEFT JOIN gallery_images g ON a.id = g.album_id 
    WHERE a.status = 1 GROUP BY a.id ORDER BY a.sort_order ASC")->fetchAll();

include __DIR__ . '/header.php';
?>

<section class="page-hero" style="min-height: 50vh;">
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="position-absolute inset-0" style="background: linear-gradient(135deg, var(--navy-900), var(--navy-800));"></div>
    <div class="hero-grid"></div>
    <div class="container position-relative" style="z-index: 10;">
        <div class="row align-items-center g-5 py-4">
            <div class="col-lg-8 mx-auto text-center">
                <span class="hero-badge"><i class="fas fa-images"></i> Our Gallery</span>
                <h1 class="hero-title mt-4">Our Fleet <span class="text-gradient">& Operations</span></h1>
                <p class="hero-subtitle mt-3">A visual journey through our fleet of modern ambulances, state-of-the-art equipment, and our dedicated team in action.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="container">
        <?php if (empty($albums)): ?>
        <div class="text-center py-5"><h4>Gallery coming soon.</h4></div>
        <?php else: ?>
        <?php foreach ($albums as $album): 
            $images = !empty($album['images']) ? explode('||', $album['images']) : [];
        ?>
        <div class="mb-5" data-aos="fade-up">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="fw-bold mb-1" style="font-family: var(--font-display); color: var(--navy-900);"><?= e($album['title']) ?></h3>
                    <?php if ($album['description']): ?>
                    <p class="text-muted small mb-0"><?= e($album['description']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if (!empty($images)): ?>
            <div class="row g-3">
                <?php foreach ($images as $img): ?>
                <div class="col-md-4 col-6">
                    <a href="<?= getMediaUrl($img) ?>" class="gallery-item" data-fancybox="gallery-<?= e($album['slug'] ?? $album['id']) ?>" data-caption="<?= e($album['title']) ?>">
                        <img src="<?= getMediaUrl($img) ?>" alt="<?= e($album['title']) ?>" class="w-100 rounded-3" style="height: 220px; object-fit: cover;">
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="text-muted small">No images in this album.</p>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
