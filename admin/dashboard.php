<?php 
require '../config.php';
requireLogin();
$conn = connectDB();

$stats = [
    'jobs' => $conn->query("SELECT COUNT(*) as cnt FROM jobs WHERE is_active = 1")->fetch()['cnt'],
    'franchise' => $conn->query("SELECT COUNT(*) as cnt FROM franchise WHERE status = 'pending'")->fetch()['cnt'],
    'messages' => $conn->query("SELECT COUNT(*) as cnt FROM messages")->fetch()['cnt'],
    'products' => $conn->query("SELECT COUNT(*) as cnt FROM products")->fetch()['cnt'],
    'applications' => $conn->query("SELECT COUNT(*) as cnt FROM job_applications WHERE status = 'pending'")->fetch()['cnt']
];

$recentFranchise = $conn->query("SELECT * FROM franchise ORDER BY created_at DESC LIMIT 5");
$recentMessages = $conn->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>控制面板 - <?php echo SITE_NAME; ?>后台</title>
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
                <h1 class="page-title">控制面板</h1>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number"><?php echo $stats['jobs']; ?></div>
                            <div class="stat-label">在招职位</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number"><?php echo $stats['applications']; ?></div>
                            <div class="stat-label">待处理申请</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number"><?php echo $stats['franchise']; ?></div>
                            <div class="stat-label">待处理加盟</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number"><?php echo $stats['messages']; ?></div>
                            <div class="stat-label">留言总数</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon pink">
                            <i class="fas fa-capsules"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number"><?php echo $stats['products']; ?></div>
                            <div class="stat-label">产品总数</div>
                        </div>
                    </div>
                </div>

                <div class="admin-grid">
                    <div class="admin-card">
                        <div class="card-header">
                            <h3>最新加盟申请</h3>
                            <a href="franchise.php" class="view-all">查看全部</a>
                        </div>
                        <div class="card-body">
                            <?php $franchiseList = $recentFranchise->fetchAll(); if ($franchiseList): ?>
                                <table class="admin-table">
                                    <thead>
                                        <tr>
                                            <th>姓名</th>
                                            <th>电话</th>
                                            <th>城市</th>
                                            <th>状态</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($franchiseList as $item): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                                <td><?php echo htmlspecialchars($item['phone']); ?></td>
                                                <td><?php echo htmlspecialchars($item['city']); ?></td>
                                                <td>
                                                    <span class="status-badge <?php echo $item['status']; ?>">
                                                        <?php echo $item['status'] === 'pending' ? '待处理' : ($item['status'] === 'approved' ? '已通过' : '已拒绝'); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p class="empty-text">暂无加盟申请</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="admin-card">
                        <div class="card-header">
                            <h3>最新留言</h3>
                            <a href="messages.php" class="view-all">查看全部</a>
                        </div>
                        <div class="card-body">
                            <?php $messagesList = $recentMessages->fetchAll(); if ($messagesList): ?>
                                <table class="admin-table">
                                    <thead>
                                        <tr>
                                            <th>姓名</th>
                                            <th>电话</th>
                                            <th>内容</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($messagesList as $item): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                                <td><?php echo htmlspecialchars($item['phone']); ?></td>
                                                <td class="truncate"><?php echo htmlspecialchars(mb_substr($item['message'], 0, 20)); ?>...</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p class="empty-text">暂无留言</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>