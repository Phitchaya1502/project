<?php
require 'config.php';
require 'functions.php';
$page_title = 'Trending | Football Store';

$stmt = $pdo->query("SELECT * FROM trending_items ORDER BY id DESC");
$trend = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>

<section class="section container">
  <h2 class="section-title">Trending</h2>
  <p class="section-subtitle">Shop the hottest trends everyone’s raving about.</p>
</section>

<section class="trending-hero">
  <img src="https://brand.assets.adidas.com/video/upload/f_auto,q_auto/if_w_gt_1920,w_1920/global_aclubs_home_liverpool_football_ss25_launch_PDP_Banner_Hero_1_Storytab_d_f84f1dabff.jpg" alt="Trending background" class="trending-bg">
</section>

<style>
.trending-hero {
  position: relative;
  width: 100%;
  height: 90vh;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #fff;
  background-color: #0b0b0b; /* เผื่อภาพมีช่องว่าง */
}

.trending-bg {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: contain; /* ✅ แสดงครบทั้งภาพโดยไม่ตัด */
  object-position: center;
  z-index: 0;
}

.trending-hero h1 {
  position: relative;
  z-index: 1;
  font-size: 72px;
  font-weight: 900;
  letter-spacing: 2px;
  text-align: center;
}
</style>



<div class="container trend-section">
  <?php foreach($trend as $item): ?>
  <div class="trend-card">
    <div class="trend-left">
      <p class="breadcrumb">Trending › Rare item</p>
      <h3><?= htmlspecialchars($item['title']) ?></h3>
      <p><?= htmlspecialchars($item['description']) ?></p>
      <a class="link" href="#">Learn More ›</a>
    </div>
    <div class="trend-right">
      <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="">
      <div class="trend-player">
        <strong><?= htmlspecialchars($item['player']) ?></strong><br>
        <?= htmlspecialchars($item['team']) ?>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<section class="section container">
  <h2 class="section-title">Top Trending Items</h2>
  <p class="section-subtitle">Most Loved Right Now</p>
  <div class="product-grid">
    <?php
      $stmt2 = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 4");
      foreach($stmt2 as $p):
    ?>
    <div class="product-card">
      <img src="<?= htmlspecialchars($p['image_url']) ?>">
       <div class="product-meta">
    <div class="category"><?= htmlspecialchars($p['category']) ?></div>
    <a class="title" href="#"><?= htmlspecialchars($p['title']) ?></a>
    <div class="price"><?= number_format($p['price'], 2) ?> THB</div>

    <form method="post" action="cart.php?action=add" class="add-cart-form">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
      <input type="hidden" name="product_id" value="<?= (int)$p['id'] ?>">
      <input type="hidden" name="qty" value="1">
      <button type="submit" class="fab" title="Add to Cart">+</button>
    </form>
  </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<?php include 'footer.php'; ?>
