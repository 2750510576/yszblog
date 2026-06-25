<?php
// 直接初始化数据库并更新品牌数据
require 'config.php';

// 连接数据库会自动初始化
$conn = connectDB();

// 清空现有品牌数据
$conn->exec("DELETE FROM brands");

// 使用新上传的图片
$brandsData = [
    ['同仁堂', 'assets/images/0448ed71-468f-482b-a889-0c2ab116f623.png', 'https://www.tongrentang.com', '北京同仁堂，百年老字号', 1],
    ['云南白药', 'assets/images/38e285b3-fb2d-49a1-9463-1dcff05e29c3.png', 'https://www.yunnanbaiyao.com.cn', '云南白药集团股份有限公司', 2],
    ['修正药业', 'assets/images/551c4a8f-efe5-47dd-8e76-a6a5177899d8.png', 'https://www.china-xiuzheng.com', '修正药业集团', 3],
    ['九芝堂', 'assets/images/80f0f95a-b87d-4ff5-a9fb-f56af3725ebc.png', 'https://www.hnjzt.com', '九芝堂股份有限公司', 4],
    ['白云山', 'assets/images/b8f85d06-4d07-4cd9-8b18-d5085f1a55d1.png', 'http://www.gzbsy.com', '广州白云山医药集团', 5],
];

$stmt = $conn->prepare("INSERT INTO brands (name, logo_url, website_url, description, sort_order) VALUES (?, ?, ?, ?, ?)");
foreach ($brandsData as $brand) {
    $stmt->execute($brand);
}

echo "<!DOCTYPE html>";
echo "<html lang='zh-CN'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>品牌更新完成</title>";
echo "<style>";
echo "body { font-family: 'Microsoft YaHei', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }";
echo ".container { background: white; padding: 40px; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); text-align: center; }";
echo "h1 { color: #333; margin-bottom: 20px; }";
echo "p { color: #666; margin-bottom: 30px; font-size: 18px; }";
echo ".btn { display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: bold; transition: transform 0.2s; }";
echo ".btn:hover { transform: translateY(-2px); }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";
echo "<h1>✅ 品牌数据更新成功！</h1>";
echo "<p>已成功更新 5 个品牌，现在可以去首页查看效果了。</p>";
echo "<a href='index.php' class='btn'>前往首页查看</a>";
echo "</div>";
echo "</body>";
echo "</html>";
?>
