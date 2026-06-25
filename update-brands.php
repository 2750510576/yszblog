<?php
require 'config.php';
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

echo "品牌数据更新成功！";
echo "<br><br>";
echo "<a href='index.php'>返回首页</a>";
?>