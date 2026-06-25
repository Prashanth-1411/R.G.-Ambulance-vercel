<?php
require_once __DIR__ . '/includes/functions.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
if (empty($slug)) { header('Location: ' . BASE_URL . '/blog'); exit; }

$post = db()->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug 
    FROM blog_posts p LEFT JOIN blog_categories c ON p.category_id = c.id 
    WHERE p.slug = ? AND p.status = 1 LIMIT 1");
$post->execute([$slug]);
$postData = $post->fetch();

if (!$postData) { header('Location: ' . BASE_URL . '/blog'); exit; }

$seo = getSEOMeta('blog-post');
$seo['title'] = $postData['title'] . ' - ' . ($seo['title'] ?? 'Blog');

// Update view count
db()->prepare("UPDATE blog_posts SET views = views + 1 WHERE id = ?")->execute([$postData['id']]);

include __DIR__ . '/header.php';
?>

<section class="bg-white pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none" style="color: var(--brand-600);">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/blog" class="text-decoration-none" style="color: var(--brand-600);">Blog</a></li>
                        <li class="breadcrumb-item active"><?= e($postData['title']) ?></li>
                    </ol>
                </nav>
                
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <?php if ($postData['category_name']): ?>
                    <span class="badge" style="background: var(--brand-100); color: var(--brand-700);"><?= e($postData['category_name']) ?></span>
                    <?php endif; ?>
                    <span class="small text-muted"><i class="fas fa-calendar me-1"></i> <?= date('F d, Y', strtotime($postData['created_at'])) ?></span>
                    <span class="small text-muted"><i class="fas fa-clock me-1"></i> <?= $postData['reading_time'] ?: '5 min read' ?></span>
                    <span class="small text-muted"><i class="fas fa-eye me-1"></i> <?= number_format($postData['views']) ?> views</span>
                </div>
                
                <h1 class="fw-black display-5" style="font-family: var(--font-display); color: var(--navy-900);"><?= e($postData['title']) ?></h1>
                
                <?php if ($postData['image']): ?>
                <img src="<?= getMediaUrl($postData['image']) ?>" alt="<?= e($postData['title']) ?>" class="w-100 rounded-4 my-4" style="max-height: 500px; object-fit: cover;">
                <?php endif; ?>
                
                <div class="blog-content fs-6 lh-lg" style="color: var(--navy-700);">
                    <?= nl2br(e($postData['content'])) ?>
                </div>
                
                <?php if ($postData['tags']): ?>
                <div class="mt-4 pt-4 border-top">
                    <strong class="small text-uppercase">Tags:</strong>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <?php foreach (explode(',', $postData['tags']) as $tag): ?>
                        <span class="badge" style="background: var(--navy-100); color: var(--navy-700);"><?= e(trim($tag)) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Share -->
                <div class="d-flex align-items-center gap-3 mt-4 pt-4 border-top">
                    <span class="fw-bold small text-uppercase">Share:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(BASE_URL . '/blog/' . $slug) ?>" target="_blank" class="btn btn-sm rounded-3" style="background: #1877F2; color: #fff;"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode(BASE_URL . '/blog/' . $slug) ?>" target="_blank" class="btn btn-sm rounded-3" style="background: #1DA1F2; color: #fff;"><i class="fab fa-twitter"></i></a>
                    <a href="https://wa.me/?text=<?= urlencode(BASE_URL . '/blog/' . $slug) ?>" target="_blank" class="btn btn-sm rounded-3" style="background: #25D366; color: #fff;"><i class="fab fa-whatsapp"></i></a>
                    <a href="mailto:?subject=<?= urlencode($postData['title']) ?>&body=<?= urlencode(BASE_URL . '/blog/' . $slug) ?>" class="btn btn-sm rounded-3" style="background: var(--navy-100); color: var(--navy-700);"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
