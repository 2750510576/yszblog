# 康健医药连锁官网

一个专业的医药连锁企业官网系统，包含前台展示和后台管理功能。

## 功能特性

### 前台功能
- 🏠 首页 - 企业形象展示
- 👥 关于我们 - 企业介绍和发展历程
- 💊 产品展示 - 药品和保健品展示
- 👔 加入我们 - 人才招聘
- 🤝 加盟合作 - 连锁加盟申请
- 📞 联系我们 - 在线留言

### 后台管理
- 📊 控制面板 - 数据统计概览
- 💼 职位管理 - 招聘信息发布
- 🤝 加盟管理 - 加盟申请审核
- 📧 留言管理 - 客户留言处理
- 🏷️ 产品管理 - 产品信息维护

## 技术栈

- 后端: PHP
- 数据库: SQLite
- 前端: HTML5, CSS3, JavaScript
- 图标: Font Awesome

## 安装步骤

### 1. 环境要求
- PHP 7.0+
- SQLite 3
- Apache/Nginx

### 2. 快速安装

1. 将项目文件上传到网站根目录
2. 访问网站首页，系统会自动初始化 SQLite 数据库
3. 数据库文件将自动创建在 `data/pharmacy_chain.db`

### 3. 默认账号

- 后台地址: `/admin/login.php`
- 用户名: `yongshizhen`
- 密码: `luyixiang4399`

## 项目结构

```
连锁官网/
├── admin/                 # 后台管理目录
│   ├── css/              # 后台样式
│   ├── includes/         # 后台公共文件
│   ├── dashboard.php     # 控制面板
│   ├── jobs.php          # 职位管理
│   ├── franchise.php     # 加盟管理
│   ├── messages.php      # 留言管理
│   ├── products.php      # 产品管理
│   ├── login.php         # 登录页面
│   └── logout.php        # 退出登录
├── assets/               # 前台资源
│   ├── css/              # 样式文件
│   └── js/               # 脚本文件
├── includes/             # 前台公共文件
├── config.php            # 配置文件
├── index.php             # 首页
├── about.php             # 关于我们
├── products.php          # 产品展示
├── jobs.php              # 加入我们
├── franchise.php         # 加盟合作
└── contact.php           # 联系我们
```

## 注意事项

1. 请及时修改后台管理员密码
2. 确保 `data/` 目录有写入权限
3. 建议配置 HTTPS 以确保数据安全

## 许可证

MIT License
