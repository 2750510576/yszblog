<?php 
require '../config.php';
requireLogin();
$conn = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add' || $_POST['action'] === 'edit') {
        $name = $_POST['name'];
        $logo_url = $_POST['logo_url'];
        $website_url = $_POST['website_url'];
        $description = $_POST['description'];
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $sort_order = intval($_POST['sort_order']);
        
        if ($_POST['action'] === 'add') {
            // 获取最大的 sort_order 并 +1
            $maxSort = $conn->query("SELECT MAX(sort_order) as max FROM brands")->fetch()['max'];
            $sort_order = $maxSort ? $maxSort + 1 : 1;
            
            $stmt = $conn->prepare("INSERT INTO brands (name, logo_url, website_url, description, is_active, sort_order) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $logo_url, $website_url, $description, $is_active, $sort_order]);
        } else {
            $id = $_POST['id'];
            $stmt = $conn->prepare("UPDATE brands SET name=?, logo_url=?, website_url=?, description=?, is_active=?, sort_order=? WHERE id=?");
            $stmt->execute([$name, $logo_url, $website_url, $description, $is_active, $sort_order, $id]);
        }
        header('Location: brands.php');
        exit;
    } elseif ($_POST['action'] === 'delete') {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM brands WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: brands.php');
        exit;
    } elseif ($_POST['action'] === 'move_up' || $_POST['action'] === 'move_down') {
        $id = intval($_POST['id']);
        $currentBrand = $conn->query("SELECT * FROM brands WHERE id = $id")->fetch();
        $currentSort = $currentBrand['sort_order'];
        
        if ($_POST['action'] === 'move_up') {
            // 找比当前小的最大的那个
            $prevBrand = $conn->query("SELECT * FROM brands WHERE sort_order < $currentSort ORDER BY sort_order DESC LIMIT 1")->fetch();
            if ($prevBrand) {
                $conn->query("UPDATE brands SET sort_order = {$prevBrand['sort_order']} WHERE id = $id");
                $conn->query("UPDATE brands SET sort_order = $currentSort WHERE id = {$prevBrand['id']}");
            }
        } else {
            // 找比当前大的最小的那个
            $nextBrand = $conn->query("SELECT * FROM brands WHERE sort_order > $currentSort ORDER BY sort_order ASC LIMIT 1")->fetch();
            if ($nextBrand) {
                $conn->query("UPDATE brands SET sort_order = {$nextBrand['sort_order']} WHERE id = $id");
                $conn->query("UPDATE brands SET sort_order = $currentSort WHERE id = {$nextBrand['id']}");
            }
        }
        header('Location: brands.php');
        exit;
    }
}

$brands = $conn->query("SELECT * FROM brands ORDER BY sort_order ASC, created_at DESC")->fetchAll();
$editBrand = null;
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM brands WHERE id = ?");
    $stmt->execute([intval($_GET['edit'])]);
    $editBrand = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>品牌管理 - <?php echo SITE_NAME; ?>后台</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-page">
    <div class="admin-wrapper">
        <?php include 'includes/sidebar.php'; ?>
        <div class="admin-main">
            <?php include 'includes/header.php'; ?>
            <div class="admin-content">
                <div class="page-header-row">
                    <h1 class="page-title">品牌管理</h1>
                    <button class="btn btn-primary" onclick="showForm()">
                        <i class="fas fa-plus"></i> 添加品牌
                    </button>
                </div>

                <div class="form-card" id="brandForm" style="display: <?php echo $editBrand ? 'block' : 'none'; ?>;">
                    <h3><?php echo $editBrand ? '编辑品牌' : '添加品牌'; ?></h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="<?php echo $editBrand ? 'edit' : 'add'; ?>">
                        <?php if ($editBrand): ?>
                            <input type="hidden" name="id" value="<?php echo $editBrand['id']; ?>">
                        <?php endif; ?>
                        <div class="form-group">
                            <label>品牌名称 *</label>
                            <input type="text" name="name" value="<?php echo $editBrand ? htmlspecialchars($editBrand['name']) : ''; ?>" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Logo 地址</label>
                                <input type="text" name="logo_url" value="<?php echo $editBrand ? htmlspecialchars($editBrand['logo_url']) : ''; ?>" placeholder="图片 URL">
                            </div>
                            <div class="form-group">
                                <label>官网地址</label>
                                <input type="text" name="website_url" value="<?php echo $editBrand ? htmlspecialchars($editBrand['website_url']) : ''; ?>" placeholder="https://...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>品牌描述</label>
                            <textarea name="description" rows="3"><?php echo $editBrand ? htmlspecialchars($editBrand['description']) : ''; ?></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>排序值</label>
                                <input type="number" name="sort_order" value="<?php echo $editBrand ? htmlspecialchars($editBrand['sort_order']) : '0'; ?>" placeholder="数值越小越靠前">
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="is_active" <?php echo !$editBrand || $editBrand['is_active'] ? 'checked' : ''; ?>>
                                    启用该品牌
                                </label>
                            </div>
                        </div>
                        <div style="display: flex; gap: 15px;">
                            <button type="submit" class="btn btn-primary">保存</button>
                            <button type="button" class="btn btn-secondary" onclick="hideForm()">取消</button>
                        </div>
                    </form>
                </div>

                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>排序</th>
                                <th>ID</th>
                                <th>Logo</th>
                                <th>品牌名称</th>
                                <th>官网</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($brands): ?>
                                <?php foreach ($brands as $index => $brand): ?>
                                    <tr>
                                        <td>
                                            <div class="action-buttons">
                                                <?php if ($index > 0): ?>
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="action" value="move_up">
                                                        <input type="hidden" name="id" value="<?php echo $brand['id']; ?>">
                                                        <button type="submit" class="btn btn-primary btn-sm" title="上移">
                                                            <i class="fas fa-arrow-up"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <?php if ($index < count($brands) - 1): ?>
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="action" value="move_down">
                                                        <input type="hidden" name="id" value="<?php echo $brand['id']; ?>">
                                                        <button type="submit" class="btn btn-secondary btn-sm" title="下移">
                                                            <i class="fas fa-arrow-down"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <span style="color: var(--text-muted); font-size: 13px; margin-left: 8px;">#<?php echo htmlspecialchars($brand['sort_order']); ?></span>
                                            </div>
                                        </td>
                                        <td><?php echo $brand['id']; ?></td>
                                        <td>
                                            <?php if ($brand['logo_url']): ?>
                                                <img src="<?php echo htmlspecialchars($brand['logo_url']); ?>" alt="<?php echo htmlspecialchars($brand['name']); ?>" style="height: 40px; width: auto;">
                                            <?php else: ?>
                                                <i class="fas fa-industry" style="color: var(--primary); font-size: 24px;"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($brand['name']); ?></td>
                                        <td>
                                            <?php if ($brand['website_url']): ?>
                                                <a href="<?php echo htmlspecialchars($brand['website_url']); ?>" target="_blank" style="color: var(--primary);">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="status-badge <?php echo $brand['is_active'] ? 'approved' : 'rejected'; ?>">
                                                <?php echo $brand['is_active'] ? '启用' : '禁用'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="?edit=<?php echo $brand['id']; ?>" class="btn btn-primary btn-sm">编辑</a>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?php echo $brand['id']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('确定删除？')">删除</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="empty-text">暂无品牌数据</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showForm() {
            document.getElementById('brandForm').style.display = 'block';
            window.location.href = 'brands.php';
        }
        function hideForm() {
            window.location.href = 'brands.php';
        }
    </script>
</body>
</html>