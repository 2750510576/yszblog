<aside class="admin-sidebar">
    <div class="sidebar-header">
        <a href="dashboard.php" class="sidebar-logo">
            <i class="fas fa-heartbeat"></i>
            <span>甬时珍医药</span>
        </a>
    </div>
    <nav class="sidebar-nav">
        <a href="dashboard.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <i class="fas fa-tachometer-alt"></i>
            <span>控制面板</span>
        </a>
        <a href="products.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : ''; ?>">
            <i class="fas fa-capsules"></i>
            <span>产品管理</span>
        </a>
        <a href="brands.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'brands.php' ? 'active' : ''; ?>">
            <i class="fas fa-industry"></i>
            <span>品牌管理</span>
        </a>
        <a href="jobs.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'jobs.php' ? 'active' : ''; ?>">
            <i class="fas fa-briefcase"></i>
            <span>职位管理</span>
        </a>
        <a href="applications.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'applications.php' ? 'active' : ''; ?>">
            <i class="fas fa-file-alt"></i>
            <span>求职申请</span>
        </a>
        <a href="franchise.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'franchise.php' ? 'active' : ''; ?>">
            <i class="fas fa-handshake"></i>
            <span>加盟管理</span>
        </a>
        <a href="messages.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'messages.php' ? 'active' : ''; ?>">
            <i class="fas fa-envelope"></i>
            <span>留言管理</span>
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="logout.php" class="nav-item logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>退出登录</span>
        </a>
    </div>
</aside>