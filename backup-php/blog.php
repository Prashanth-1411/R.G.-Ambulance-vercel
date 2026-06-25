<?php
require_once __DIR__ . '/includes/functions.php';
$seo = getSEOMeta('blog');

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$per_page = 6;

$countQ = db()->query("SELECT COUNT(*) FROM blog_posts WHERE status = 1");
$total = $countQ->fetchColumn();
$total_pages = ceil($total / $per_page);
$offset = ($page - 1) * $per_page;

$posts = db()->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug 
    FROM blog_posts p LEFT JOIN blog_categories c ON p.category_id = c.id 
    WHERE p.status = 1 ORDER BY p.created_at DESC LIMIT ? OFFSET ?");
$posts->execute([$per_page, $offset]);
$postList = $posts->fetchAll();

$categories = db()->query("SELECT * FROM blog_categories WHERE status = 1 ORDER BY name")->fetchAll();

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
                <span class="hero-badge"><i class="fas fa-newspaper"></i> Our Blog</span>
                <h1 class="hero-title mt-4">Latest <span class="text-gradient">Insights</span></h1>
                <p class="hero-subtitle mt-3">Stay informed with the latest in emergency medical services, patient care tips, and community health initiatives.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-5" data-aos="fade-up">
            <a href="<?= BASE_URL ?>/blog" class="filter-btn active" data-filter="all" data-target=".blogGrid"><i class="fas fa-th-large"></i> All</a>
            <?php foreach ($categories as $cat): ?>
            <a href="<?= BASE_URL ?>/blog?category=<?= e($cat['slug']) ?>" class="filter-btn" data-filter="<?= e($cat['slug']) ?>" data-target=".blogGrid">
                <i class="fas fa-folder"></i> <?= e($cat['name']) ?>
            </a>
            <?php endforeach; ?>
        </div>
        
        <?php if (empty($postList)): ?>
        <div class="text-center py-5"><h4>No posts yet.</h4></div>
        <?php else: ?>
        <div class="row g-4 blogGrid">
            <?php foreach ($postList as $post): 
                $excerpt = strip_tags($post['content']);
                $excerpt = mb_substr($excerpt, 0, 150) . (mb_strlen($excerpt) > 150 ? '...' : '');
            ?>
            <div class="col-md-4 filter-item" data-category="<?= e($post['category_slug'] ?? 'uncategorized') ?>">
                <div class="blog-card">
                    <div class="card-img">
                        <img src="<?= getMediaUrl($post['image']) ?>" alt="<?= e($post['title']) ?>">
                        <?php if ($post['category_name']): ?>
                        <span class="blog-badge"><?= e($post['category_name']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 small text-muted mb-2">
                            <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($post['created_at'])) ?>
                            <span class="mx-1">·</span>
                            <i class="fas fa-clock"></i> <?= $post['reading_time'] ?: '5 min read' ?>
                        </div>
                        <h5 class="fw-bold mb-2"><a href="<?= BASE_URL ?>/blog/<?= e($post['slug']) ?>" class="text-decoration-none" style="color: var(--navy-900);"><?= e($post['title']) ?></a></h5>
                        <p class="small text-muted"><?= e($excerpt) ?></p>
                        <a href="<?= BASE_URL ?>/blog/<?= e($post['slug']) ?>" class="fw-bold small" style="color: var(--brand-600); text-decoration: none;">
                            Read More <i class="fas fa-arrow-right ms-1" style="transition: transform 0.3s;"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if ($total_pages > 1): ?>
        <nav class="mt-5" data-aos="fade-up">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                    <a class="page-link" href="<?= BASE_URL ?>/blog?page=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
