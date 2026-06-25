<?php 
require 'config.php';
$conn = connectDB();
$result = $conn->query("SELECT * FROM jobs WHERE is_active = 1 ORDER BY sort_order ASC, created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>加入我们 - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="page-header">
        <div class="container">
            <h1>加入我们</h1>
        </div>
    </section>

    <section class="jobs-section">
        <div class="container">
            <div class="jobs-intro">
                <h2>与我们一起，守护健康</h2>
                <p>甬时珍医药连锁提供广阔的职业发展空间、完善的培训体系和具有竞争力的薪酬福利。期待您的加入！</p>
            </div>

            <div class="benefits">
                <h3 class="section-title">我们为您提供</h3>
                <div class="benefits-grid">
                    <div class="benefit-item">
                        <i class="fas fa-money-bill-wave"></i>
                        <h4>有竞争力的薪资</h4>
                        <p>行业领先的薪酬待遇</p>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-shield-alt"></i>
                        <h4>完善的福利</h4>
                        <p>五险一金、带薪年假</p>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-graduation-cap"></i>
                        <h4>专业培训</h4>
                        <p>持续的学习与发展机会</p>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-chart-line"></i>
                        <h4>职业发展</h4>
                        <p>清晰的晋升通道</p>
                    </div>
                </div>
            </div>

            <h3 class="section-title">热招职位</h3>
            <div class="jobs-list">
                <?php if ($result): ?>
                    <?php foreach ($result as $job): ?>
                        <div class="job-card">
                            <div class="job-header">
                                <h4><?php echo htmlspecialchars($job['title']); ?></h4>
                                <span class="job-salary"><?php echo htmlspecialchars($job['salary']); ?></span>
                            </div>
                            <div class="job-meta">
                                <span><i class="fas fa-building"></i> <?php echo htmlspecialchars($job['department']); ?></span>
                                <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($job['location']); ?></span>
                            </div>
                            <div class="job-description">
                                <?php echo nl2br(htmlspecialchars($job['description'])); ?>
                            </div>
                            <a href="apply.php?job_id=<?php echo $job['id']; ?>" class="btn btn-primary">立即申请</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="job-card">
                        <div class="job-header">
                            <h4>执业药师</h4>
                            <span class="job-salary">8k-15k</span>
                        </div>
                        <div class="job-meta">
                            <span><i class="fas fa-building"></i> 门店运营</span>
                            <span><i class="fas fa-map-marker-alt"></i> 全国各门店</span>
                        </div>
                        <div class="job-description">
                            1. 负责门店药品质量管理<br>
                            2. 为顾客提供专业的用药咨询<br>
                            3. 持有执业药师资格证书<br>
                            4. 有相关工作经验者优先
                        </div>
                        <a href="apply.php?job_id=1" class="btn btn-primary">立即申请</a>
                    </div>
                    <div class="job-card">
                        <div class="job-header">
                            <h4>门店店长</h4>
                            <span class="job-salary">10k-20k</span>
                        </div>
                        <div class="job-meta">
                            <span><i class="fas fa-building"></i> 门店管理</span>
                            <span><i class="fas fa-map-marker-alt"></i> 全国各门店</span>
                        </div>
                        <div class="job-description">
                            1. 负责门店全面运营管理<br>
                            2. 制定并完成销售目标<br>
                            3. 团队管理与培训<br>
                            4. 2年以上零售管理经验
                        </div>
                        <a href="apply.php?job_id=2" class="btn btn-primary">立即申请</a>
                    </div>
                    <div class="job-card">
                        <div class="job-header">
                            <h4>医药销售代表</h4>
                            <span class="job-salary">6k-12k</span>
                        </div>
                        <div class="job-meta">
                            <span><i class="fas fa-building"></i> 市场部</span>
                            <span><i class="fas fa-map-marker-alt"></i> 各区域</span>
                        </div>
                        <div class="job-description">
                            1. 负责区域市场开发<br>
                            2. 客户关系维护<br>
                            3. 销售目标达成<br>
                            4. 有医药行业经验优先
                        </div>
                        <a href="apply.php?job_id=3" class="btn btn-primary">立即申请</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>