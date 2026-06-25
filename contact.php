<?php 
require 'config.php';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connectDB();
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    $stmt = $conn->prepare("INSERT INTO messages (name, phone, email, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $phone, $email, $message]);
    
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>联系我们 - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="page-header">
        <div class="container">
            <h1>联系我们</h1>
        </div>
    </section>

    <section class="contact-section">
        <div class="container">
            <div class="contact-content">
                <div class="contact-info">
                    <h2>联系方式</h2>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>总部地址</h4>
                            <p>上海市浦东新区张江高科技园区科苑路88号</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h4>服务热线</h4>
                            <p>400-888-8888</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>电子邮箱</h4>
                            <p>service@kangjian.com</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h4>服务时间</h4>
                            <p>周一至周日 8:00 - 22:00</p>
                        </div>
                    </div>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-weixin"></i></a>
                        <a href="#"><i class="fab fa-weibo"></i></a>
                        <a href="#"><i class="fab fa-qq"></i></a>
                    </div>
                </div>
                <div class="contact-form-wrapper">
                    <h2>给我们留言</h2>
                    <?php if ($success): ?>
                        <div class="success-message">
                            <i class="fas fa-check-circle"></i>
                            <h4>留言提交成功！</h4>
                            <p>感谢您的留言，我们会尽快回复。</p>
                        </div>
                    <?php endif; ?>
                    <form class="contact-form" method="POST">
                        <div class="form-group">
                            <label>姓名 *</label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>联系电话 *</label>
                            <input type="tel" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label>电子邮箱</label>
                            <input type="email" name="email">
                        </div>
                        <div class="form-group">
                            <label>留言内容 *</label>
                            <textarea name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-large">提交留言</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>