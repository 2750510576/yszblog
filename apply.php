<?php 
require 'config.php';
$success = false;
$job = null;

// 获取职位信息
if (isset($_GET['job_id'])) {
    $job_id = intval($_GET['job_id']);
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ? AND is_active = 1");
    $stmt->execute([$job_id]);
    $job = $stmt->fetch();
}

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $job) {
    $conn = connectDB();
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $education = trim($_POST['education']);
    $experience = trim($_POST['experience']);
    $cover_letter = trim($_POST['cover_letter']);
    $resume_path = '';
    
    // 处理简历上传
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/uploads/resumes/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $ext = pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('resume_', true) . '.' . $ext;
        $upload_file = $upload_dir . $filename;
        
        if (move_uploaded_file($_FILES['resume']['tmp_name'], $upload_file)) {
            $resume_path = 'uploads/resumes/' . $filename;
        }
    }
    
    $stmt = $conn->prepare("
        INSERT INTO job_applications (
            job_id, name, phone, email, education, experience, resume_path, cover_letter
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $job['id'], $name, $phone, $email, $education, $experience, $resume_path, $cover_letter
    ]);
    
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $job ? '申请 ' . htmlspecialchars($job['title']) : '职位申请'; ?> - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="page-header">
        <div class="container">
            <h1>职位申请</h1>
        </div>
    </section>

    <section class="contact-section">
        <div class="container">
            <div class="contact-content">
                <?php if (!$job): ?>
                    <div class="success-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <h4>职位不存在</h4>
                        <p>您申请的职位不存在或已关闭。</p>
                    </div>
                    <div class="text-center mt-4">
                        <a href="jobs.php" class="btn btn-primary">返回职位列表</a>
                    </div>
                <?php elseif ($success): ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i>
                        <h4>申请提交成功！</h4>
                        <p>我们已收到您的申请，HR会尽快与您联系。</p>
                    </div>
                    <div class="text-center mt-4">
                        <a href="jobs.php" class="btn btn-primary">继续浏览职位</a>
                    </div>
                <?php else: ?>
                    <div class="contact-info">
                        <h2>申请职位</h2>
                        <div class="info-item">
                            <i class="fas fa-briefcase"></i>
                            <div>
                                <h4><?php echo htmlspecialchars($job['title']); ?></h4>
                                <p><?php echo htmlspecialchars($job['department']); ?> · <?php echo htmlspecialchars($job['location']); ?></p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <div>
                                <h4>薪资待遇</h4>
                                <p><?php echo htmlspecialchars($job['salary']); ?></p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-info-circle"></i>
                            <div>
                                <h4>职位描述</h4>
                                <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
                            </div>
                        </div>
                        <?php if ($job['requirements']): ?>
                            <div class="info-item">
                                <i class="fas fa-tasks"></i>
                                <div>
                                    <h4>任职要求</h4>
                                    <p><?php echo nl2br(htmlspecialchars($job['requirements'])); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="contact-form-wrapper">
                        <h2>填写申请信息</h2>
                        <form method="POST" class="contact-form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>姓名 <span style="color: var(--danger);">*</span></label>
                                <input type="text" name="name" required placeholder="请输入您的姓名">
                            </div>
                            <div class="form-group">
                                <label>手机号 <span style="color: var(--danger);">*</span></label>
                                <input type="tel" name="phone" required placeholder="请输入您的手机号">
                            </div>
                            <div class="form-group">
                                <label>电子邮箱</label>
                                <input type="email" name="email" placeholder="请输入您的电子邮箱">
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>最高学历</label>
                                    <select name="education">
                                        <option value="">请选择学历</option>
                                        <option value="高中及以下">高中及以下</option>
                                        <option value="大专">大专</option>
                                        <option value="本科">本科</option>
                                        <option value="硕士">硕士</option>
                                        <option value="博士及以上">博士及以上</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>工作年限</label>
                                    <select name="experience">
                                        <option value="">请选择工作经验</option>
                                        <option value="应届生">应届生</option>
                                        <option value="1-3年">1-3年</option>
                                        <option value="3-5年">3-5年</option>
                                        <option value="5-10年">5-10年</option>
                                        <option value="10年以上">10年以上</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>上传简历 <span style="color: var(--danger);">*</span></label>
                                <input type="file" name="resume" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif" required>
                                <small style="color: var(--text-muted);">支持 PDF、DOC、DOCX、JPG、JPEG、PNG、GIF 格式，文件大小不超过 10MB</small>
                            </div>
                            <div class="form-group">
                                <label>自我介绍</label>
                                <textarea name="cover_letter" placeholder="请简要介绍您的工作经历和技能特长..." rows="6"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-large btn-block">
                                <i class="fas fa-paper-plane"></i> 提交申请
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>