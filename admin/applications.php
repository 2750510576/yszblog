<?php 
require '../config.php';
requireLogin();
$conn = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'delete') {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM job_applications WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($_POST['action'] === 'update_status') {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $stmt = $conn->prepare("UPDATE job_applications SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }
    header('Location: applications.php');
    exit;
}

$applications = $conn->query("
    SELECT ja.*, j.title as job_title 
    FROM job_applications ja 
    LEFT JOIN jobs j ON ja.job_id = j.id 
    ORDER BY ja.created_at DESC
")->fetchAll();

$viewItem = null;
if (isset($_GET['view'])) {
    $stmt = $conn->prepare("
        SELECT ja.*, j.title as job_title 
        FROM job_applications ja 
        LEFT JOIN jobs j ON ja.job_id = j.id 
        WHERE ja.id = ?
    ");
    $stmt->execute([intval($_GET['view'])]);
    $viewItem = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>求职申请管理 - <?php echo SITE_NAME; ?>后台</title>
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
                        <h1 class="page-title">申请详情</h1>
                        <a href="applications.php" class="btn btn-secondary">返回列表</a>
                    </div>
                    <div class="form-card">
                        <div class="detail-item">
                            <div class="detail-label">申请职位</div>
                            <div class="detail-value"><?php echo htmlspecialchars($viewItem['job_title'] ?? '职位已删除'); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">姓名</div>
                            <div class="detail-value"><?php echo htmlspecialchars($viewItem['name']); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">手机号</div>
                            <div class="detail-value"><?php echo htmlspecialchars($viewItem['phone']); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">电子邮箱</div>
                            <div class="detail-value"><?php echo htmlspecialchars($viewItem['email']); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">最高学历</div>
                            <div class="detail-value"><?php echo htmlspecialchars($viewItem['education']); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">工作经验</div>
                            <div class="detail-value"><?php echo htmlspecialchars($viewItem['experience']); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">简历</div>
                            <div class="detail-value">
                                <?php if ($viewItem['resume_path']): ?>
                                    <?php 
                                    $ext = strtolower(pathinfo($viewItem['resume_path'], PATHINFO_EXTENSION));
                                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
                                    if ($isImage): 
                                    ?>
                                        <div style="margin-bottom: 10px;">
                                            <img src="../<?php echo htmlspecialchars($viewItem['resume_path']); ?>" alt="简历图片" style="max-width: 100%; max-height: 500px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                        </div>
                                    <?php endif; ?>
                                    <a href="../<?php echo htmlspecialchars($viewItem['resume_path']); ?>" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i> 下载简历
                                    </a>
                                <?php else: ?>
                                    未上传简历
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">自我介绍</div>
                            <div class="detail-value"><?php echo nl2br(htmlspecialchars($viewItem['cover_letter'])); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">申请状态</div>
                            <div class="detail-value">
                                <form method="POST" style="display: flex; gap: 10px; align-items: center;">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="id" value="<?php echo $viewItem['id']; ?>">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="pending" <?php echo $viewItem['status'] === 'pending' ? 'selected' : ''; ?>>待处理</option>
                                        <option value="reviewing" <?php echo $viewItem['status'] === 'reviewing' ? 'selected' : ''; ?>>审核中</option>
                                        <option value="interview" <?php echo $viewItem['status'] === 'interview' ? 'selected' : ''; ?>>面试邀请</option>
                                        <option value="accepted" <?php echo $viewItem['status'] === 'accepted' ? 'selected' : ''; ?>>已录用</option>
                                        <option value="rejected" <?php echo $viewItem['status'] === 'rejected' ? 'selected' : ''; ?>>已拒绝</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">申请时间</div>
                            <div class="detail-value"><?php echo $viewItem['created_at']; ?></div>
                        </div>
                    </div>
                <?php else: ?>
                    <h1 class="page-title">求职申请管理</h1>
                    <div class="data-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>姓名</th>
                                    <th>申请职位</th>
                                    <th>电话</th>
                                    <th>学历</th>
                                    <th>状态</th>
                                    <th>时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($applications): ?>
                                    <?php foreach ($applications as $item): ?>
                                        <tr>
                                            <td><?php echo $item['id']; ?></td>
                                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                                            <td><?php echo htmlspecialchars($item['job_title'] ?? '职位已删除'); ?></td>
                                            <td><?php echo htmlspecialchars($item['phone']); ?></td>
                                            <td><?php echo htmlspecialchars($item['education']); ?></td>
                                            <td>
                                                <span class="status-badge <?php echo $item['status']; ?>">
                                                    <?php 
                                                    $statusMap = [
                                                        'pending' => '待处理',
                                                        'reviewing' => '审核中',
                                                        'interview' => '面试邀请',
                                                        'accepted' => '已录用',
                                                        'rejected' => '已拒绝'
                                                    ];
                                                    echo $statusMap[$item['status']] ?? $item['status'];
                                                    ?>
                                                </span>
                                            </td>
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
                                        <td colspan="8" class="empty-text">暂无求职申请</td>
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