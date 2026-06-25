<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>产品展示 - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="page-header">
        <div class="container">
            <h1>产品展示</h1>
        </div>
    </section>

    <section class="products-section">
        <div class="container">
            <div class="category-filter">
                <button class="category-btn active" data-category="all">全部</button>
                <button class="category-btn" data-category="vitamin">维生素</button>
                <button class="category-btn" data-category="herbal">中药饮片</button>
                <button class="category-btn" data-category="medical">医疗器械</button>
                <button class="category-btn" data-category="health">保健品</button>
            </div>

            <div class="products-grid">
                <div class="product-card" data-category="vitamin">
                    <img src="https://core-normal.trae.ai/api/ide/v1/text_to_image?prompt=vitamin%20supplements%20health%20products&image_size=square" alt="复合维生素">
                    <div class="product-info">
                        <h3>复合维生素片</h3>
                        <p class="category">维生素</p>
                        <p class="price">¥98.00</p>
                    </div>
                </div>
                <div class="product-card" data-category="vitamin">
                    <img src="https://core-normal.trae.ai/api/ide/v1/text_to_image?prompt=vitamin%20C%20tablets%20bottle&image_size=square" alt="维生素C">
                    <div class="product-info">
                        <h3>维生素C咀嚼片</h3>
                        <p class="category">维生素</p>
                        <p class="price">¥68.00</p>
                    </div>
                </div>
                <div class="product-card" data-category="herbal">
                    <img src="https://core-normal.trae.ai/api/ide/v1/text_to_image?prompt=herbal%20medicine%20traditional%20chinese&image_size=square" alt="中药材">
                    <div class="product-info">
                        <h3>精选中药材</h3>
                        <p class="category">中药饮片</p>
                        <p class="price">¥168.00</p>
                    </div>
                </div>
                <div class="product-card" data-category="herbal">
                    <img src="https://core-normal.trae.ai/api/ide/v1/text_to_image?prompt=chinese%20herbal%20tea%20health%20drink&image_size=square" alt="中药茶饮">
                    <div class="product-info">
                        <h3>养生中药茶</h3>
                        <p class="category">中药饮片</p>
                        <p class="price">¥88.00</p>
                    </div>
                </div>
                <div class="product-card" data-category="medical">
                    <img src="https://core-normal.trae.ai/api/ide/v1/text_to_image?prompt=blood%20pressure%20monitor%20medical%20device&image_size=square" alt="血压计">
                    <div class="product-info">
                        <h3>电子血压计</h3>
                        <p class="category">医疗器械</p>
                        <p class="price">¥299.00</p>
                    </div>
                </div>
                <div class="product-card" data-category="medical">
                    <img src="https://core-normal.trae.ai/api/ide/v1/text_to_image?prompt=thermometer%20digital%20medical&image_size=square" alt="体温计">
                    <div class="product-info">
                        <h3>红外体温计</h3>
                        <p class="category">医疗器械</p>
                        <p class="price">¥128.00</p>
                    </div>
                </div>
                <div class="product-card" data-category="health">
                    <img src="https://core-normal.trae.ai/api/ide/v1/text_to_image?prompt=probiotic%20supplements%20health%20product&image_size=square" alt="益生菌">
                    <div class="product-info">
                        <h3>益生菌粉</h3>
                        <p class="category">保健品</p>
                        <p class="price">¥198.00</p>
                    </div>
                </div>
                <div class="product-card" data-category="health">
                    <img src="https://core-normal.trae.ai/api/ide/v1/text_to_image?prompt=fish%20oil%20omega%203%20supplements&image_size=square" alt="鱼油">
                    <div class="product-info">
                        <h3>深海鱼油</h3>
                        <p class="category">保健品</p>
                        <p class="price">¥158.00</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>