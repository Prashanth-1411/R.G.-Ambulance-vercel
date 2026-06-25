<?php
$page_title = 'Activity Logs';
require_once __DIR__ . '/../partials/header.php';

$page = max(1, (int)($_GET['page'] ?? 1));
$per_page = 50;
$offset = ($page - 1) * $per_page;

$total = db()->query("SELECT COUNT(*) FROM activity_logs")->fetchColumn();
$total_pages = ceil($total / $per_page);

$logs = db()->query("SELECT al.*, u.name as user_name FROM activity_logs al LEFT JOIN users u ON al.user_id = u.id ORDER BY al.created_at DESC LIMIT $per_page OFFSET $offset")->fetchAll();
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ti ti-activity me-2"></i>Activity Logs</h4>
        <p class="text-muted small mb-0">Track all administrative actions. Total entries: <strong><?= $total ?></strong></p>
    </div>
</div>

<div class="card-container">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>ID</th><th>User</th><th>Action</th><th>Details</th><th>IP</th><th>Date</th></tr></thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                <tr>
                    <td class="text-muted">#<?= $log['id'] ?></td>
                    <td class="fw-semibold"><?= e($log['user_name'] ?? 'System') ?></td>
                    <td><span class="badge bg-info bg-opacity-10 text-info"><?= e($log['action']) ?></span></td>
                    <td class="small text-muted"><?= e($log['details'] ?? '—') ?></td>
                    <td class="text-muted small"><?= e($log['ip_address'] ?? '—') ?></td>
                    <td class="text-muted small"><?= date('d M Y H:i', strtotime($log['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($logs)): ?>
                <tr><td colspan="6" class="text-center text-muted">No activity logs yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if ($total_pages > 1): ?>
    <nav class="mt-3">
        <ul class="pagination pagination-sm justify-content-center mb-0">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
