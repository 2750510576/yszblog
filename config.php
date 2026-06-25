<?php
session_start();

define('DB_PATH', __DIR__ . '/data/pharmacy_chain.db');
define('SITE_NAME', '甬时珍医药连锁');
define('SITE_URL', 'http://localhost');

function connectDB() {
    $dbDir = dirname(DB_PATH);
    if (!is_dir($dbDir)) {
        mkdir($dbDir, 0777, true);
    }
    
    $conn = new PDO('sqlite:' . DB_PATH);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    initializeDB($conn);
    
    return $conn;
}

function initializeDB($conn) {
    $tables = $conn->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll();
    $tableNames = array_column($tables, 'name');
    
    if (!in_array('admins', $tableNames)) {
        $conn->exec("
            CREATE TABLE admins (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        $hashedPassword = password_hash('luyixiang4399', PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
        $stmt->execute(['yongshizhen', $hashedPassword]);
    }
    
    if (!in_array('products', $tableNames)) {
        $conn->exec("
            CREATE TABLE products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                description TEXT,
                image TEXT,
                price REAL,
                category TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }
    
    if (!in_array('jobs', $tableNames)) {
        $conn->exec("
            CREATE TABLE jobs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                department TEXT,
                location TEXT,
                salary TEXT,
                description TEXT,
                requirements TEXT,
                is_active INTEGER DEFAULT 1,
                sort_order INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        $stmt = $conn->prepare("INSERT INTO jobs (title, department, location, salary, description, requirements, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            '执业药师', '门店运营', '全国各门店', '8k-15k',
            "负责门店药品质量管理\n为顾客提供专业的用药咨询",
            "持有执业药师资格证书\n有相关工作经验者优先",
            1
        ]);
        $stmt->execute([
            '门店店长', '门店管理', '全国各门店', '10k-20k',
            "负责门店全面运营管理\n制定并完成销售目标",
            "2年以上零售管理经验",
            2
        ]);
        $stmt->execute([
            '医药销售代表', '市场部', '各区域', '6k-12k',
            "负责区域市场开发\n客户关系维护",
            "有医药行业经验优先",
            3
        ]);
    } else {
        // 检查并添加 sort_order 字段（如果已存在表但没有该字段）
        try {
            $conn->exec("ALTER TABLE jobs ADD COLUMN sort_order INTEGER DEFAULT 0");
        } catch (Exception $e) {
            // 字段已存在，忽略错误
        }
    }
    
    if (!in_array('franchise', $tableNames)) {
        $conn->exec("
            CREATE TABLE franchise (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                phone TEXT,
                email TEXT,
                city TEXT,
                message TEXT,
                status TEXT DEFAULT 'pending',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }
    
    if (!in_array('messages', $tableNames)) {
        $conn->exec("
            CREATE TABLE messages (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                phone TEXT,
                email TEXT,
                message TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }
    
    if (!in_array('news', $tableNames)) {
        $conn->exec("
            CREATE TABLE news (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                content TEXT,
                image TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }
    
    if (!in_array('job_applications', $tableNames)) {
        $conn->exec("
            CREATE TABLE job_applications (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                job_id INTEGER NOT NULL,
                name TEXT NOT NULL,
                phone TEXT NOT NULL,
                email TEXT,
                education TEXT,
                experience TEXT,
                resume_path TEXT,
                cover_letter TEXT,
                status TEXT DEFAULT 'pending',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    if (!in_array('brands', $tableNames)) {
        $conn->exec("
            CREATE TABLE brands (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                logo_url TEXT,
                website_url TEXT,
                description TEXT,
                is_active INTEGER DEFAULT 1,
                sort_order INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        // 插入一些知名药厂品牌数据
        $stmt = $conn->prepare("INSERT INTO brands (name, logo_url, website_url, description, sort_order) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(['同仁堂', 'https://img.logohistory.com/wp-content/uploads/2023/03/tongrentang-logo.jpg', 'https://www.tongrentang.com', '北京同仁堂，百年老字号', 1]);
        $stmt->execute(['云南白药', 'https://www.yunnanbaiyao.com.cn/images/logo.png', 'https://www.yunnanbaiyao.com.cn', '云南白药集团股份有限公司', 2]);
        $stmt->execute(['修正药业', 'https://www.china-xiuzheng.com/templates/default/images/logo.png', 'https://www.china-xiuzheng.com', '修正药业集团', 3]);
        $stmt->execute(['九芝堂', 'https://www.hnjzt.com/images/logo.png', 'https://www.hnjzt.com', '九芝堂股份有限公司', 4]);
        $stmt->execute(['白云山', 'https://www.gzbsy.com/images/logo.png', 'http://www.gzbsy.com', '广州白云山医药集团', 5]);
        $stmt->execute(['华润医药', 'https://www.crpharm.com/images/logo.png', 'https://www.crpharm.com', '华润医药集团', 6]);
        $stmt->execute(['恒瑞医药', 'https://www.hr-pharma.com/images/logo.png', 'https://www.hr-pharma.com', '江苏恒瑞医药股份有限公司', 7]);
        $stmt->execute(['复星医药', 'https://www.fosunpharma.com/images/logo.png', 'https://www.fosunpharma.com', '上海复星医药(集团)股份有限公司', 8]);
        $stmt->execute(['仁和药业', 'https://www.renhe.com/images/logo.png', 'https://www.renhe.com', '仁和药业股份有限公司', 9]);
        $stmt->execute(['哈药集团', 'https://www.hayao.com/images/logo.png', 'https://www.hayao.com', '哈药集团有限公司', 10]);
        $stmt->execute(['华北制药', 'https://www.ncpc.com/images/logo.png', 'https://www.ncpc.com', '华北制药股份有限公司', 11]);
        $stmt->execute(['康恩贝', 'https://www.conba.com/images/logo.png', 'https://www.conba.com', '浙江康恩贝制药股份有限公司', 12]);
    } else {
        // 检查并添加 sort_order 字段
        try {
            $conn->exec("ALTER TABLE brands ADD COLUMN sort_order INTEGER DEFAULT 0");
        } catch (Exception $e) {
            // 忽略字段已存在错误
        }
    }
}

function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /admin/login.php');
        exit;
    }
}
?>