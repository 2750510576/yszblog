<?php 
require 'config.php';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connectDB();
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $message = $_POST['message'];
    
    $stmt = $conn->prepare("INSERT INTO franchise (name, phone, email, city, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $phone, $email, $city, $message]);
    
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>加盟合作 - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="page-header">
        <div class="container">
            <h1>加盟合作</h1>
        </div>
    </section>

    <section class="franchise-section">
        <div class="container">
            <div class="franchise-intro">
                <div class="intro-text">
                    <h2>携手甬时珍，共创辉煌</h2>
                    <p>甬时珍医药连锁凭借成熟的运营模式、完善的供应链体系和强大的品牌影响力，为加盟商提供全方位的支持。加入我们，共享医药健康产业的发展红利！</p>
                </div>
                <div class="intro-image">
                    <img src="https://core-normal.trae.ai/api/ide/v1/text_to_image?prompt=business%20partnership%20handshake%20pharmacy%20store&image_size=square_hd" alt="加盟合作">
                </div>
            </div>

            <div class="franchise-advantages">
                <h3 class="section-title">加盟优势</h3>
                <div class="advantages-grid">
                    <div class="advantage-card">
                        <div class="icon">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h4>品牌优势</h4>
                        <p>十余年行业经验，知名医药连锁品牌</p>
                    </div>
                    <div class="advantage-card">
                        <div class="icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h4>供应链支持</h4>
                        <p>集中采购，降低成本，确保药品质量</p>
                    </div>
                    <div class="advantage-card">
                        <div class="icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h4>培训支持</h4>
                        <p>完善的培训体系，持续提升运营能力</p>
                    </div>
                    <div class="advantage-card">
                        <div class="icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4>运营支持</h4>
                        <p>专业团队全程指导，无忧开店</p>
                    </div>
                </div>
            </div>

            <div class="franchise-process">
                <h3 class="section-title">加盟流程</h3>
                <div class="process-steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <h4>咨询了解</h4>
                        <p>了解品牌和加盟政策</p>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <h4>提交申请</h4>
                        <p>填写加盟申请表</p>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <h4>资质审核</h4>
                        <p>总部评估审核</p>
                    </div>
                    <div class="step">
                        <div class="step-number">4</div>
                        <h4>签订合同</h4>
                        <p>正式签订加盟协议</p>
                    </div>
                    <div class="step">
                        <div class="step-number">5</div>
                        <h4>筹备开业</h4>
                        <p>装修、培训、铺货</p>
                    </div>
                    <div class="step">
                        <div class="step-number">6</div>
                        <h4>正式营业</h4>
                        <p>盛大开业，持续支持</p>
                    </div>
                </div>
            </div>

            <div class="franchise-form-section">
                <h3 class="section-title">申请加盟</h3>
                <?php if ($success): ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i>
                        <h4>申请提交成功！</h4>
                        <p>我们的工作人员会尽快与您联系。</p>
                    </div>
                <?php endif; ?>
                <form class="franchise-form" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>姓名 *</label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>联系电话 *</label>
                            <input type="tel" name="phone" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>电子邮箱</label>
                            <input type="email" name="email">
                        </div>
                        <div class="form-group">
                            <label>意向城市 *</label>
                            <input type="text" name="city" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>留言说明</label>
                        <textarea name="message" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-large">提交申请</button>
                </form>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>