<header class="admin-header">
    <div class="header-left">
        <button class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="header-right">
        <div class="admin-user">
            <i class="fas fa-user-circle"></i>
            <span><?php echo $_SESSION['admin_username'] ?? 'Admin'; ?></span>
        </div>
        <a href="../index.php" class="home-link" target="_blank">
            <i class="fas fa-external-link-alt"></i>
            查看网站
        </a>
    </div>
</header>