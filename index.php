<?php 
require 'config.php';
$conn = connectDB();
$brands = $conn->query("SELECT * FROM brands WHERE is_active = 1 ORDER BY sort_order ASC, created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - 专业医药连锁，守护您的健康</title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="hero">
        <div class="hero-content">
            <h1>甬时珍医药连锁</h1>
            <p>专业医药服务，守护您和家人的健康</p>
            <a href="#about" class="btn btn-primary">了解更多</a>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-medkit"></i>
                    <h3>专业药品</h3>
                    <p>严格筛选优质药品，确保用药安全</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-user-md"></i>
                    <h3>专业医师</h3>
                    <p>资深医师团队，提供专业咨询</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-shipping-fast"></i>
                    <h3>快速配送</h3>
                    <p>同城快速配送，急您所需</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>质量保证</h3>
                    <p>全程冷链，药品质量有保障</p>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>关于我们</h2>
                    <p>甬时珍医药连锁成立于2005年，是一家专注于医药零售的连锁企业。我们始终秉承"专业、诚信、贴心"的服务理念，为广大顾客提供优质的医药健康服务。</p>
                    <p>经过多年发展，我们已在全国拥有500多家连锁门店，专业药师团队超过2000人，是值得信赖的医药品牌。</p>
                    <a href="about.php" class="btn btn-secondary">查看详情</a>
                </div>
                <div class="about-image">
                    <img src="https://core-normal.trae.ai/api/ide/v1/text_to_image?prompt=modern%20pharmacy%20store%20interior%20with%20professional%20pharmacists&image_size=square_hd" alt="药店">
                </div>
            </div>
        </div>
    </section>

    <section class="brands-section">
        <div class="container">
            <h2 class="section-title" style="margin-bottom: 50px; font-size: 42px;">部分合作品牌</h2>
            <div class="brands-grid">
                <div class="brand-card">
                    <div class="brand-logo">
                        <img src="assets/images/0448ed71-468f-482b-a889-0c2ab116f623.png" alt="品牌">
                    </div>
                </div>
                <div class="brand-card">
                    <div class="brand-logo">
                        <img src="assets/images/38e285b3-fb2d-49a1-9463-1dcff05e29c3.png" alt="品牌">
                    </div>
                </div>
                <div class="brand-card">
                    <div class="brand-logo">
                        <img src="assets/images/551c4a8f-efe5-47dd-8e76-a6a5177899d8.png" alt="品牌">
                    </div>
                </div>
                <div class="brand-card">
                    <div class="brand-logo">
                        <img src="assets/images/80f0f95a-b87d-4ff5-a9fb-f56af3725ebc.png" alt="品牌">
                    </div>
                </div>
                <div class="brand-card">
                    <div class="brand-logo">
                        <img src="assets/images/b8f85d06-4d07-4cd9-8b18-d5085f1a55d1.png" alt="品牌">
                    </div>
                </div>
                <div class="brand-card">
                    <div class="brand-logo">
                        <img src="assets/images/c6e808f0-cb14-425e-81d2-5fd1051ec16d.png" alt="品牌">
                    </div>
                </div>
                <div class="brand-card">
                    <div class="brand-logo">
                        <img src="assets/images/c7a21f71-c310-42fe-b296-5d05756c77e5.png" alt="品牌">
                    </div>
                </div>
                <div class="brand-card">
                    <div class="brand-logo">
                        <img src="assets/images/cf2e0850-5f3a-448a-ab6a-3a5f994d8c10.png" alt="品牌">
                    </div>
                </div>
                <div class="brand-card">
                    <div class="brand-logo">
                        <img src="assets/images/dde1cc88-eed1-4c6c-85cc-15b8c0ba859f.png" alt="品牌">
                    </div>
                </div>
                <div class="brand-card">
                    <div class="brand-logo">
                        <img src="assets/images/ef34507f-246d-4afc-8fe7-5e3ca892d0b6.png" alt="品牌">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>加入我们，共创未来</h2>
                <p>成为甬时珍医药的一员，共同守护大众健康</p>
                <div class="cta-buttons">
                    <a href="jobs.php" class="btn btn-primary">加入我们</a>
                    <a href="franchise.php" class="btn btn-secondary">加盟合作</a>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>