<?php 
require '../config.php';
requireLogin();
$conn = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add' || $_POST['action'] === 'edit') {
        $title = $_POST['title'];
        $department = $_POST['department'];
        $location = $_POST['location'];
        $salary = $_POST['salary'];
        $description = $_POST['description'];
        $requirements = $_POST['requirements'];
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $sort_order = intval($_POST['sort_order']);
        
        if ($_POST['action'] === 'add') {
            // 获取最大的 sort_order 并 +1
            $maxSort = $conn->query("SELECT MAX(sort_order) as max FROM jobs")->fetch()['max'];
            $sort_order = $maxSort ? $maxSort + 1 : 1;
            
            $stmt = $conn->prepare("INSERT INTO jobs (title, department, location, salary, description, requirements, is_active, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $department, $location, $salary, $description, $requirements, $is_active, $sort_order]);
        } else {
            $id = $_POST['id'];
            $stmt = $conn->prepare("UPDATE jobs SET title=?, department=?, location=?, salary=?, description=?, requirements=?, is_active=?, sort_order=? WHERE id=?");
            $stmt->execute([$title, $department, $location, $salary, $description, $requirements, $is_active, $sort_order, $id]);
        }
        header('Location: jobs.php');
        exit;
    } elseif ($_POST['action'] === 'delete') {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: jobs.php');
        exit;
    } elseif ($_POST['action'] === 'move_up' || $_POST['action'] === 'move_down') {
        $id = intval($_POST['id']);
        $currentJob = $conn->query("SELECT * FROM jobs WHERE id = $id")->fetch();
        $currentSort = $currentJob['sort_order'];
        
        if ($_POST['action'] === 'move_up') {
            // 找比当前小的最大的那个
            $prevJob = $conn->query("SELECT * FROM jobs WHERE sort_order < $currentSort ORDER BY sort_order DESC LIMIT 1")->fetch();
            if ($prevJob) {
                $conn->query("UPDATE jobs SET sort_order = {$prevJob['sort_order']} WHERE id = $id");
                $conn->query("UPDATE jobs SET sort_order = $currentSort WHERE id = {$prevJob['id']}");
            }
        } else {
            // 找比当前大的最小的那个
            $nextJob = $conn->query("SELECT * FROM jobs WHERE sort_order > $currentSort ORDER BY sort_order ASC LIMIT 1")->fetch();
            if ($nextJob) {
                $conn->query("UPDATE jobs SET sort_order = {$nextJob['sort_order']} WHERE id = $id");
                $conn->query("UPDATE jobs SET sort_order = $currentSort WHERE id = {$nextJob['id']}");
            }
        }
        header('Location: jobs.php');
        exit;
    }
}

$jobs = $conn->query("SELECT * FROM jobs ORDER BY sort_order ASC, created_at DESC")->fetchAll();
$editJob = null;
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ?");
    $stmt->execute([intval($_GET['edit'])]);
    $editJob = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>职位管理 - <?php echo SITE_NAME; ?>后台</title>
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
                    <h1 class="page-title">职位管理</h1>
                    <button class="btn btn-primary" onclick="showForm()">
                        <i class="fas fa-plus"></i> 添加职位
                    </button>
                </div>

                <div class="form-card" id="jobForm" style="display: <?php echo $editJob ? 'block' : 'none'; ?>;">
                    <h3><?php echo $editJob ? '编辑职位' : '添加职位'; ?></h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="<?php echo $editJob ? 'edit' : 'add'; ?>">
                        <?php if ($editJob): ?>
                            <input type="hidden" name="id" value="<?php echo $editJob['id']; ?>">
                        <?php endif; ?>
                        <div class="form-row">
                            <div class="form-group">
                                <label>职位名称 *</label>
                                <input type="text" name="title" value="<?php echo $editJob ? htmlspecialchars($editJob['title']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>部门 *</label>
                                <input type="text" name="department" value="<?php echo $editJob ? htmlspecialchars($editJob['department']) : ''; ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>工作地点 *</label>
                                <input type="text" name="location" value="<?php echo $editJob ? htmlspecialchars($editJob['location']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>薪资范围 *</label>
                                <input type="text" name="salary" value="<?php echo $editJob ? htmlspecialchars($editJob['salary']) : ''; ?>" placeholder="如: 10k-15k" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>职位描述</label>
                            <textarea name="description" rows="4"><?php echo $editJob ? htmlspecialchars($editJob['description']) : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>任职要求</label>
                            <textarea name="requirements" rows="4"><?php echo $editJob ? htmlspecialchars($editJob['requirements']) : ''; ?></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>排序值</label>
                                <input type="number" name="sort_order" value="<?php echo $editJob ? htmlspecialchars($editJob['sort_order']) : '0'; ?>" placeholder="数值越小越靠前">
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="is_active" <?php echo !$editJob || $editJob['is_active'] ? 'checked' : ''; ?>>
                                    启用该职位
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
                                <th>职位名称</th>
                                <th>部门</th>
                                <th>地点</th>
                                <th>薪资</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($jobs): ?>
                                <?php foreach ($jobs as $index => $job): ?>
                                    <tr>
                                        <td>
                                            <div class="action-buttons">
                                                <?php if ($index > 0): ?>
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="action" value="move_up">
                                                        <input type="hidden" name="id" value="<?php echo $job['id']; ?>">
                                                        <button type="submit" class="btn btn-primary btn-sm" title="上移">
                                                            <i class="fas fa-arrow-up"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <?php if ($index < count($jobs) - 1): ?>
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="action" value="move_down">
                                                        <input type="hidden" name="id" value="<?php echo $job['id']; ?>">
                                                        <button type="submit" class="btn btn-secondary btn-sm" title="下移">
                                                            <i class="fas fa-arrow-down"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <span style="color: var(--text-muted); font-size: 13px; margin-left: 8px;">#<?php echo htmlspecialchars($job['sort_order']); ?></span>
                                            </div>
                                        </td>
                                        <td><?php echo $job['id']; ?></td>
                                        <td><?php echo htmlspecialchars($job['title']); ?></td>
                                        <td><?php echo htmlspecialchars($job['department']); ?></td>
                                        <td><?php echo htmlspecialchars($job['location']); ?></td>
                                        <td><?php echo htmlspecialchars($job['salary']); ?></td>
                                        <td>
                                            <span class="status-badge <?php echo $job['is_active'] ? 'approved' : 'rejected'; ?>">
                                                <?php echo $job['is_active'] ? '启用' : '禁用'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="?edit=<?php echo $job['id']; ?>" class="btn btn-primary btn-sm">编辑</a>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?php echo $job['id']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('确定删除？')">删除</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="empty-text">暂无职位数据</td>
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
            document.getElementById('jobForm').style.display = 'block';
            window.location.href = 'jobs.php';
        }
        function hideForm() {
            window.location.href = 'jobs.php';
        }
    </script>
</body>
</html>