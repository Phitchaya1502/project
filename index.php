<?php
require 'config.php';
require_once 'functions.php';

$page_title = 'Home | Football Store';

$stmtBest = $pdo->query("SELECT * FROM products WHERE is_best_seller=1 ORDER BY id DESC LIMIT 8");
$best = $stmtBest->fetchAll(PDO::FETCH_ASSOC);

$stmtSale = $pdo->query("SELECT * FROM products WHERE is_sale=1 ORDER BY id DESC LIMIT 8");
$sales = $stmtSale->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>
<section class="hero">
  <div class="hero-content">
    <h1>READY <br> FOR</h1>
    <p>ANY CHALLENGE WEAR YOUR STYLE</p>
    <a href="collection.php" class="btn-shop">SHOP NOW</a>
  </div>
</section>

<style>
  .hero {
    position: relative;
    height: 80vh;
    display: flex;
    align-items: center;
    background-image: url('https://i.ytimg.com/vi/6gSd6FomF1Q/maxresdefault.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    color: #fff;
    padding-left: 10%;
    filter: brightness(1.2);
  }
  .hero {
  position: relative;
  height: 90vh;
  display: flex;
  align-items: center;
  color: #fff;
  padding-left: 10%;
  overflow: hidden;
  background-color: #000;
  }
  .hero-bg {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: contain;
  object-position: center bottom;
}
.hero-content {
  position: relative;
  z-index: 1;
}
  .hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0);
    backdrop-filter: none;
  }

  .hero-content {
    position: relative;
    z-index: 1;
  }

  .hero h1 {
    font-size: 72px;
    font-weight: 900;
    margin: 0;
    line-height: 1;
  }

  .hero p {
    margin: 16px 0 28px;
    letter-spacing: 1px;
    font-size: 16px;
  }

  .btn-shop {
    background: #ff7a00;
    color: #fff;
    text-decoration: none;
    padding: 12px 28px;
    border-radius: 6px;
    font-weight: bold;
    transition: .3s;
  }
  .btn-shop:hover { background: #ff951a; }
</style>


<section class="feature-grid container">
  <a class="feature-card" href="details.php?category=Shirt">
    <img
      src="https://img.chelseafc.com/image/upload/f_auto,w_1400,q_90/editorial/match-reports/2025-26/Ajax%20(h)/GettyImages-2242623277.jpg"
      alt="Football Shirt">
      <div class="feature-label">FOOTBALL<br>SHIRT</div>
    <span class="feature-link">Details ›</span>
  </a>

  <a class="feature-card" href="details.php?category=Cleats">
    <img
      src="https://static.nike.com/a/images/w_1920,c_limit,f_auto,q_auto/88f1dedb-6ab6-47bc-8f47-f919c64ec2d5/image.jpg"
      alt="Cleats">
      <div class="feature-label">CLEATS</div>
    <span class="feature-link">Details ›</span>
  </a>

  <a class="feature-card" href="details.php?category=Soccer%20Ball">
    <img
      src="https://mainstand.co.th/storage/news/405_Puma001.jpg"
      alt="Soccer Ball">
       <div class="feature-label">SOCCER<br>BALL</div>
      <span class="feature-link">Details ›</span>
  </a>

  <a class="feature-card" href="details.php?category=Wishlist">
    <img
      src="https://store.liverpoolfc.com/media/catalog/product/cache/a8585741965541bd35c89e2a8929f2a6/2/p/2p4a4944_1_3.jpg"
      alt="Wishlist">
      <div class="feature-label">WISHLIST</div>
    <span class="feature-link">Details ›</span>
  </a>
</section>

<section class="section container">
  <h2 class="section-title">BEST SELLER</h2>
  <p class="section-subtitle">RECOMMEND</p>
  <div class="product-grid">
    <?php foreach ($best as $p): ?>
      <div class="product-card">
        <div class="badge red">BEST SELLER</div>
        <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="">
        <div class="product-meta">
          <div class="category"><?= htmlspecialchars($p['category']) ?></div>
          <a class="title" href="#"><?= htmlspecialchars($p['title']) ?></a>
          <div class="price"><?= number_format((float)$p['price'], 2) ?> THB</div>

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

<section class="section container">
  <h2 class="section-title">SALE 40%</h2>
  <p class="section-subtitle">RECOMMEND</p>
  <div class="product-grid">
    <?php foreach ($sales as $p): ?>
      <div class="product-card">
        <?php if (!empty($p['sale_badge_text'])): ?>
          <div class="badge orange"><?= htmlspecialchars($p['sale_badge_text']) ?></div>
        <?php endif; ?>
        <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="">
        
        <div class="product-meta">
          <div class="category"><?= htmlspecialchars($p['category']) ?></div>
  
          <a class="title" href="details.php?id=<?= (int)$p['id'] ?>">
            <?= htmlspecialchars($p['title']) ?>
          </a>

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
