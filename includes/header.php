<header class="header">
    <div class="container">
        <div class="header-content">
            <a href="index.php" class="logo">
                <i class="fas fa-heartbeat"></i>
                <span>甬时珍医药连锁</span>
            </a>
            <nav class="nav">
                <a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">首页</a>
                <a href="about.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">关于我们</a>
                <a href="products.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : ''; ?>">产品展示</a>
                <a href="jobs.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'jobs.php' ? 'active' : ''; ?>">加入我们</a>
                <a href="franchise.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'franchise.php' ? 'active' : ''; ?>">加盟合作</a>
                <a href="contact.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">联系我们</a>
            </nav>
            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</header>