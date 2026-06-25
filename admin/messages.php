<?php 
require '../config.php';
requireLogin();
$conn = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: messages.php');
    exit;
}

$messages = $conn->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();
$viewItem = null;
if (isset($_GET['view'])) {
    $stmt = $conn->prepare("SELECT * FROM messages WHERE id = ?");
    $stmt->execute([intval($_GET['view'])]);
    $viewItem = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言管理 - <?php echo SITE_NAME; ?>后台</title>
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
                <?php if ($viewItem): ?>
                    <div class="page-header-row">
                        <h1 class="page-title">留言详情</h1>
                        <a href="messages.php" class="btn btn-secondary">返回列表</a>
                    </div>
                    <div class="form-card">
                        <div class="detail-item">
                            <div class="detail-label">姓名</div>
                            <div class="detail-value"><?php echo htmlspecialchars($viewItem['name']); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">联系电话</div>
                            <div class="detail-value"><?php echo htmlspecialchars($viewItem['phone']); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">电子邮箱</div>
                            <div class="detail-value"><?php echo htmlspecialchars($viewItem['email']); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">留言内容</div>
                            <div class="detail-value"><?php echo htmlspecialchars($viewItem['message']); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">留言时间</div>
                            <div class="detail-value"><?php echo $viewItem['created_at']; ?></div>
                        </div>
                    </div>
                <?php else: ?>
                    <h1 class="page-title">留言管理</h1>
                    <div class="data-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>姓名</th>
                                    <th>电话</th>
                                    <th>邮箱</th>
                                    <th>留言预览</th>
                                    <th>时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($messages): ?>
                                    <?php foreach ($messages as $item): ?>
                                        <tr>
                                            <td><?php echo $item['id']; ?></td>
                                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                                            <td><?php echo htmlspecialchars($item['phone']); ?></td>
                                            <td><?php echo htmlspecialchars($item['email']); ?></td>
                                            <td class="truncate"><?php echo htmlspecialchars(mb_substr($item['message'], 0, 30)); ?>...</td>
                                            <td><?php echo $item['created_at']; ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="?view=<?php echo $item['id']; ?>" class="btn btn-primary btn-sm">查看</a>
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('确定删除？')">删除</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="empty-text">暂无留言</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>