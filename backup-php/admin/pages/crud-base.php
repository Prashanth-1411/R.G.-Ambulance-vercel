<?php
/**
 * Generic CRUD Page Handler
 * Include this in any admin CRUD page with a $module config array.
 * 
 * $module = [
 *   'table' => 'services',
 *   'title' => 'Services',
 *   'icon'  => 'ti-truck',
 *   'fields' => [
 *     ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
 *     ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
 *     ['name' => 'image', 'label' => 'Image', 'type' => 'file', 'path' => 'uploads/services/'],
 *     ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Active', 0 => 'Inactive']],
 *   ],
 *   'columns' => ['id', 'title', 'description', 'status', 'created_at'],
 *   'searchable' => ['title', 'description'],
 *   'order' => 'sort_order ASC, id DESC',
 *   'where' => ''
 * ];
 */
require_once __DIR__ . '/../partials/header.php';

if (!isset($module) || !is_array($module)) {
    die('Module configuration not defined');
}

$table = $module['table'];
$title = $module['title'] ?? ucfirst($table);
$icon  = $module['icon'] ?? 'ti-file';
$fields = $module['fields'] ?? [];
$columns = $module['columns'] ?? [];
$searchable = $module['searchable'] ?? [];
$order = $module['order'] ?? 'id DESC';
$where = $module['where'] ?? '';
$has_sort = $module['has_sort'] ?? false;

// Handle form submission
$editData = null;
$editId = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = new CSRFToken();
    if (!$csrf->verify($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token.';
    } else {
        try {
            $data = [];
            $filePaths = [];
            
            foreach ($fields as $f) {
                $name = $f['name'];
                if ($f['type'] === 'file' && isset($_FILES[$name]) && $_FILES[$name]['error'] === UPLOAD_ERR_OK) {
                    $uploadPath = $f['path'] ?? 'uploads/';
                    $result = uploadFile($_FILES[$name], $uploadPath);
                    if ($result['success']) {
                        $filePaths[$name] = $result['path'];
                    }
                } elseif ($f['type'] !== 'file') {
                    $data[$name] = $_POST[$name] ?? '';
                }
            }
            
            // Merge file paths
            foreach ($filePaths as $k => $v) {
                $data[$k] = $v;
            }
            
            if (!empty($_POST['id'])) {
                // Update
                $editId = (int)$_POST['id'];
                $sets = [];
                $params = [];
                foreach ($data as $k => $v) {
                    $sets[] = "$k = ?";
                    $params[] = $v;
                }
                $params[] = $editId;
                db()->prepare("UPDATE $table SET " . implode(', ', $sets) . " WHERE id = ?")->execute($params);
                logActivity($_SESSION['user']['id'] ?? 0, "updated $table", "ID: $editId");
                $success = 'Updated successfully.';
            } else {
                // Insert
                $cols = implode(', ', array_keys($data));
                $placeholders = implode(', ', array_fill(0, count($data), '?'));
                $stmt = db()->prepare("INSERT INTO $table ($cols, created_at) VALUES ($placeholders, NOW())");
                $stmt->execute(array_values($data));
                $newId = db()->lastInsertId();
                logActivity($_SESSION['user']['id'] ?? 0, "created $table", "ID: $newId");
                $success = 'Created successfully.';
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}

// Handle edit
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $stmt = db()->prepare("SELECT * FROM $table WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Count
$countSql = "SELECT COUNT(*) FROM $table";
if ($where) $countSql .= " WHERE $where";
$totalCount = db()->query($countSql)->fetchColumn();
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="ti <?= e($icon) ?> me-2"></i><?= e($title) ?></h4>
        <p class="text-muted small mb-0">Manage your <?= strtolower($title) ?>. Total: <strong><?= $totalCount ?></strong></p>
    </div>
    <button class="btn btn-gradient btn-sm" data-bs-toggle="modal" data-bs-target="#crudModal" onclick="resetForm()">
        <i class="ti ti-plus me-1"></i> Add New
    </button>
</div>

<?php if (isset($success)): ?>
<div class="alert alert-success bg-success bg-opacity-10 border border-success border-opacity-25 text-success small py-2"><?= e($success) ?></div>
<?php endif; ?>
<?php if (isset($error)): ?>
<div class="alert alert-danger bg-danger bg-opacity-10 border border-danger border-opacity-25 text-danger small py-2"><?= e($error) ?></div>
<?php endif; ?>

<div class="card-container">
    <div class="table-responsive">
        <table class="table data-table" id="crudTable">
            <thead>
                <tr>
                    <?php foreach ($columns as $col): ?>
                    <th><?= e(ucfirst(str_replace('_', ' ', $col))) ?></th>
                    <?php endforeach; ?>
                    <th style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM $table";
                if ($where) $sql .= " WHERE $where";
                $sql .= " ORDER BY $order";
                $rows = db()->query($sql)->fetchAll();
                ?>
                <?php foreach ($rows as $row): ?>
                <tr>
                    <?php foreach ($columns as $col): 
                        $val = $row[$col] ?? '';
                        if ($col === 'status') {
                            $active = (int)$val === 1;
                            echo '<td><span class="badge bg-' . ($active ? 'success' : 'secondary') . ' bg-opacity-10 text-' . ($active ? 'success' : 'secondary') . ' status-badge" onclick="toggleStatus(\'' . BASE_URL . '/admin/ajax/crud.php?action=toggle_status&table=' . $table . '\', this)" data-id="' . $row['id'] . '" style="cursor:pointer;">' . ($active ? 'Active' : 'Inactive') . '</span></td>';
                        } elseif ($col === 'image' || $col === 'icon') {
                            if ($val) {
                                echo '<td><img src="' . getMediaUrl($val) . '" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px;"></td>';
                            } else {
                                echo '<td><span class="text-muted">—</span></td>';
                            }
                        } elseif (in_array($col, ['created_at', 'updated_at']) && $val) {
                            echo '<td class="text-muted small">' . date('d M Y', strtotime($val)) . '</td>';
                        } elseif (strlen($val) > 80) {
                            echo '<td class="small">' . e(substr($val, 0, 80)) . '…</td>';
                        } else {
                            echo '<td class="small">' . e($val) . '</td>';
                        }
                    endforeach; ?>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="ti ti-pencil"></i></a>
                            <button class="btn btn-sm btn-outline-secondary" title="Delete" onclick="confirmDelete('<?= BASE_URL ?>/admin/ajax/crud.php?action=delete&table=<?= $table ?>', '<?= $row['id'] ?>')"><i class="ti ti-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- CRUD Modal -->
<div class="modal fade" id="crudModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= e((new CSRFToken())->generate()) ?>">
                <input type="hidden" name="id" id="editId" value="<?= $editData ? $editData['id'] : '' ?>">
                
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="ti <?= e($icon) ?> me-2"></i><span id="modalTitle"><?= e($title) ?></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <?php foreach ($fields as $f): 
                            $name = $f['name'];
                            $label = $f['label'] ?? ucfirst(str_replace('_', ' ', $name));
                            $type = $f['type'] ?? 'text';
                            $required = !empty($f['required']) ? 'required' : '';
                            $value = $editData[$name] ?? ($f['default'] ?? '');
                            $placeholder = $f['placeholder'] ?? '';
                        ?>
                        <div class="col-md-<?= $f['col'] ?? '12' ?>">
                            <label class="form-label"><?= e($label) ?></label>
                            <?php if ($type === 'textarea'): ?>
                            <textarea name="<?= e($name) ?>" class="form-control" <?= $required ?> rows="4" placeholder="<?= e($placeholder) ?>"><?= e($value) ?></textarea>
                            <?php elseif ($type === 'select' && isset($f['options'])): ?>
                            <select name="<?= e($name) ?>" class="form-select" <?= $required ?>>
                                <?php foreach ($f['options'] as $optVal => $optLabel): ?>
                                <option value="<?= e($optVal) ?>" <?= $value == $optVal ? 'selected' : '' ?>><?= e($optLabel) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php elseif ($type === 'file'): ?>
                            <input type="file" name="<?= e($name) ?>" class="form-control" data-preview="#preview_<?= e($name) ?>">
                            <?php if ($value): ?>
                            <div class="mt-2">
                                <img src="<?= getMediaUrl($value) ?>" id="preview_<?= e($name) ?>" class="upload-preview">
                                <input type="hidden" name="<?= e($name) ?>" value="<?= e($value) ?>">
                            </div>
                            <?php else: ?>
                            <img src="" id="preview_<?= e($name) ?>" class="upload-preview d-none">
                            <?php endif; ?>
                            <?php else: ?>
                            <input type="<?= e($type) ?>" name="<?= e($name) ?>" class="form-control" value="<?= e($value) ?>" <?= $required ?> placeholder="<?= e($placeholder) ?>">
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient"><i class="ti ti-device-floppy me-1"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function resetForm() {
    document.getElementById('editId').value = '';
    document.getElementById('modalTitle').textContent = 'Add New <?= e($title) ?>';
    document.querySelector('#crudModal form').reset();
    document.querySelectorAll('#crudModal form img.upload-preview').forEach(img => {
        img.classList.add('d-none');
    });
    document.querySelectorAll('#crudModal form input[type="hidden"]').forEach(h => {
        if (h.name !== 'csrf_token' && h.name !== 'id') h.value = '';
    });
}

<?php if ($editData): ?>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('modalTitle').textContent = 'Edit <?= e($title) ?>';
    const modal = new bootstrap.Modal(document.getElementById('crudModal'));
    modal.show();
});
<?php endif; ?>
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
