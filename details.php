<?php
require 'config.php';
require_once 'functions.php';

/* รับพารามิเตอร์ */
$id       = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$category = trim($_GET['category'] ?? '');

/* ดึงสินค้า: 1) จาก id  2) จาก category (ชิ้นแรกของหมวด) */
$product = null;

if ($id > 0) {
  $st = $pdo->prepare("SELECT * FROM products WHERE id = :id LIMIT 1");
  $st->execute([':id' => $id]);
  $product = $st->fetch(PDO::FETCH_ASSOC);
} elseif ($category !== '') {
  $st = $pdo->prepare("SELECT * FROM products WHERE category LIKE :c ORDER BY is_best_seller DESC, is_sale DESC, id DESC LIMIT 1");
  $st->execute([':c' => "%$category%"]);
  $product = $st->fetch(PDO::FETCH_ASSOC);
}

/* Fallback เป็นสินค้าล่าสุด 1 ชิ้น เพื่อกันหน้า blank */
if (!$product) {
  $st = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 1");
  $product = $st->fetch(PDO::FETCH_ASSOC);
}

/* ถ้าไม่มีจริง ๆ */
if (!$product) {
  $page_title = 'Product not found';
  include 'header.php'; ?>
  <section class="section container"><p>Product not found.</p></section>
  <?php include 'footer.php'; exit;
}

$page_title = $product['title'].' | Details';
include 'header.php';
?>
<section class="section container">
  <h2 class="section-title">Product Details</h2>
  <p class="section-subtitle"><?= htmlspecialchars($product['category']) ?></p>

  <div class="details-grid">
    <div class="details-image">
      <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="">
    </div>
    <div class="details-info">
      <h3><?= htmlspecialchars($product['title']) ?></h3>
      <p class="desc">
        <?= nl2br(htmlspecialchars($product['description'] ?? 'High-performance official product.')) ?>
      </p>

      <?php if (!empty($product['specs'])): ?>
        <ul class="spec">
          <?php foreach (explode("\n", trim($product['specs'])) as $line): ?>
            <?php if (trim($line) !== ''): ?>
              <li><?= htmlspecialchars($line) ?></li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <div class="price">Price : <?= number_format((float)$product['price'], 2) ?> THB</div>

      <form method="post" action="cart.php?action=add" class="add-cart-form">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
        <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
        <input type="hidden" name="qty" value="1">
        <button type="submit" class="btn-primary">Add to Cart</button>
      </form>
    </div>
  </div>
</section>

<style>
.details-grid{display:grid;grid-template-columns:1fr 1fr;gap:50px;align-items:center;margin-top:30px;}
.details-image img{width:100%;border-radius:18px;box-shadow:0 12px 35px rgba(0,0,0,.15);}
.details-info h3{font-size:28px;margin-bottom:10px;color:#fff;}
.details-info .desc{color:#555;margin-bottom:16px;line-height:1.6;}
.details-info .spec{list-style:disc;margin-left:20px;margin-bottom:16px;color:#444;}
.details-info .price{font-size:20px;font-weight:700;color:#ff7a00;margin-bottom:16px;}
@media(max-width:768px){.details-grid{grid-template-columns:1fr;}}
</style>
<?php include 'footer.php'; ?>
