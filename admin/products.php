<?php 
require '../config.php';
requireLogin();
$conn = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add' || $_POST['action'] === 'edit') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $image = $_POST['image'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        
        if ($_POST['action'] === 'add') {
            $stmt = $conn->prepare("INSERT INTO products (name, description, image, price, category) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $description, $image, $price, $category]);
        } else {
            $id = $_POST['id'];
            $stmt = $conn->prepare("UPDATE products SET name=?, description=?, image=?, price=?, category=? WHERE id=?");
            $stmt->execute([$name, $description, $image, $price, $category, $id]);
        }
        header('Location: products.php');
        exit;
    } elseif ($_POST['action'] === 'delete') {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: products.php');
        exit;
    }
}

$products = $conn->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll();
$editProduct = null;
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([intval($_GET['edit'])]);
    $editProduct = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>产品管理 - <?php echo SITE_NAME; ?>后台</title>
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
                    <h1 class="page-title">产品管理</h1>
                    <button class="btn btn-primary" onclick="showForm()">
                        <i class="fas fa-plus"></i> 添加产品
                    </button>
                </div>

                <div class="form-card" id="productForm" style="display: <?php echo $editProduct ? 'block' : 'none'; ?>;">
                    <h3><?php echo $editProduct ? '编辑产品' : '添加产品'; ?></h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="<?php echo $editProduct ? 'edit' : 'add'; ?>">
                        <?php if ($editProduct): ?>
                            <input type="hidden" name="id" value="<?php echo $editProduct['id']; ?>">
                        <?php endif; ?>
                        <div class="form-group">
                            <label>产品名称 *</label>
                            <input type="text" name="name" value="<?php echo $editProduct ? htmlspecialchars($editProduct['name']) : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>产品分类 *</label>
                            <select name="category" required>
                                <option value="vitamin" <?php echo $editProduct && $editProduct['category'] === 'vitamin' ? 'selected' : ''; ?>>维生素</option>
                                <option value="herbal" <?php echo $editProduct && $editProduct['category'] === 'herbal' ? 'selected' : ''; ?>>中药饮片</option>
                                <option value="medical" <?php echo $editProduct && $editProduct['category'] === 'medical' ? 'selected' : ''; ?>>医疗器械</option>
                                <option value="health" <?php echo $editProduct && $editProduct['category'] === 'health' ? 'selected' : ''; ?>>保健品</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>价格 *</label>
                            <input type="number" step="0.01" name="price" value="<?php echo $editProduct ? htmlspecialchars($editProduct['price']) : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>产品图片URL</label>
                            <input type="text" name="image" value="<?php echo $editProduct ? htmlspecialchars($editProduct['image']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label>产品描述</label>
                            <textarea name="description" rows="4"><?php echo $editProduct ? htmlspecialchars($editProduct['description']) : ''; ?></textarea>
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
                                <th>ID</th>
                                <th>产品名称</th>
                                <th>分类</th>
                                <th>价格</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($products): ?>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo $product['id']; ?></td>
                                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                                        <td>
                                            <?php 
                                            $catMap = ['vitamin' => '维生素', 'herbal' => '中药饮片', 'medical' => '医疗器械', 'health' => '保健品'];
                                            echo $catMap[$product['category']] ?? $product['category'];
                                            ?>
                                        </td>
                                        <td>¥<?php echo number_format($product['price'], 2); ?></td>
                                        <td><?php echo $product['created_at']; ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="?edit=<?php echo $product['id']; ?>" class="btn btn-primary btn-sm">编辑</a>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('确定删除？')">删除</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="empty-text">暂无产品数据</td>
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
            document.getElementById('productForm').style.display = 'block';
            window.location.href = 'products.php';
        }
        function hideForm() {
            window.location.href = 'products.php';
        }
    </script>
</body>
</html>