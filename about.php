<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>关于我们 - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="page-header">
        <div class="container">
            <h1>关于我们</h1>
        </div>
    </section>

    <section class="about-page">
        <div class="container">
            <div class="about-intro">
                <img src="https://core-normal.trae.ai/api/ide/v1/text_to_image?prompt=pharmaceutical%20company%20headquarters%20modern%20building&image_size=landscape_16_9" alt="公司总部">
                <div class="intro-text">
                    <h2>企业简介</h2>
                    <p>宁波甬时珍医药连锁有限公司成立于2005年，总部位于中国宁波，是一家专注于医药零售连锁的大型企业。经过十余年的发展，我们已在全国30多个省市自治区开设了500多家连锁门店，员工总数超过8000人。</p>
                    <p>我们始终坚持"专业、诚信、贴心"的企业理念，以"守护大众健康"为使命，致力于为每一位顾客提供专业、便捷、优质的医药健康服务。</p>
                </div>
            </div>

            <div class="milestones">
                <h2 class="section-title">发展历程</h2>
                <div class="milestone-grid">
                    <div class="milestone">
                        <div class="year">2005</div>
                        <h3>品牌创立</h3>
                        <p>第一家甬时珍医药门店在宁波开业</p>
                    </div>
                    <div class="milestone">
                        <div class="year">2010</div>
                        <h3>连锁扩张</h3>
                        <p>门店数量突破100家，覆盖华东地区</p>
                    </div>
                    <div class="milestone">
                        <div class="year">2015</div>
                        <h3>全国布局</h3>
                        <p>进入华北、华南市场，门店达300家</p>
                    </div>
                    <div class="milestone">
                        <div class="year">2020</div>
                        <h3>智慧药房</h3>
                        <p>推出线上服务，实现O2O全渠道运营</p>
                    </div>
                    <div class="milestone">
                        <div class="year">2025</div>
                        <h3>行业领先</h3>
                        <p>门店超500家，成为行业标杆企业</p>
                    </div>
                </div>
            </div>

            <div class="values">
                <h2 class="section-title">企业文化</h2>
                <p class="section-subtitle">我们的价值观，指引着我们不断前行</p>
                <div class="culture-grid">
                    <div class="culture-card">
                        <div class="culture-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>正念正直</h3>
                        <p>秉持正念，坚守正直，以诚信为立业之本</p>
                    </div>
                    <div class="culture-card">
                        <div class="culture-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h3>利他向上</h3>
                        <p>关爱他人，积极向上，共同成长</p>
                    </div>
                    <div class="culture-card">
                        <div class="culture-icon">
                            <i class="fas fa-fire"></i>
                        </div>
                        <h3>全力以赴</h3>
                        <p>全情投入，追求卓越，永不言弃</p>
                    </div>
                    <div class="culture-card">
                        <div class="culture-icon">
                            <i class="fas fa-sun"></i>
                        </div>
                        <h3>热爱生活</h3>
                        <p>热爱生命，享受生活，保持热情</p>
                    </div>
                    <div class="culture-card">
                        <div class="culture-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h3>认真工作</h3>
                        <p>认真负责，专业专注，精益求精</p>
                    </div>
                    <div class="culture-card">
                        <div class="culture-icon">
                            <i class="fas fa-smile"></i>
                        </div>
                        <h3>快乐生活</h3>
                        <p>乐观开朗，快乐工作，快乐生活</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>