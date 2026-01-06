<?php
require 'config.php';
require_once 'functions.php';

$page_title = 'Learn More | Football Store';

/* ===== DATA SOURCE (ปรับคอนเทนต์ได้เอง) ===== */
$articles = [
  'kaka-autograph-frame' => [
    'title' => 'Kaká Autograph Frame',
    'excerpt' => 'Rare collectible signed by Kaká — museum-grade frame.',
    'content' => "<p>Signed by Kaká during his Real Madrid era. Numbered 1 of 100 worldwide.</p><ul><li>50×70 cm</li><li>UV-protected glass</li><li>COA included</li></ul>",
    'hero' => 'images/learn/kaka.jpg',
    'related_product_id' => null,
  ],
  'cole-palmer-autograph' => [
    'title' => 'Cole Palmer Autograph Frame',
    'excerpt' => 'A premium collectible celebrating Cole Palmer.',
    'content' => "<p>Celebrate the rise of Cole Palmer with a premium signed display.</p>",
    'hero' => 'images/learn/cole.jpg',
    'related_product_id' => null,
  ],
];

$slug = $_GET['slug'] ?? null;
$id   = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$article = null;

if ($slug && isset($articles[$slug])) {
  $article = $articles[$slug];
} elseif ($id > 0) {
  // ตัวอย่าง mapping id → slug ถ้าต้องการ
  $map = [1=>'kaka-autograph-frame', 2=>'cole-palmer-autograph'];
  if (isset($map[$id]) && isset($articles[$map[$id]])) {
    $article = $articles[$map[$id]];
  }
}

if (!$article) { $page_title='Article not found'; include 'header.php'; ?>
  <section class="section container"><p>Article not found.</p></section>
  <?php include 'footer.php'; exit; }

$page_title = $article['title'].' | Learn More';
include 'header.php';
?>
<section class="section container">
  <h2 class="section-title"><?= htmlspecialchars($article['title']) ?></h2>
  <p class="section-subtitle"><?= htmlspecialchars($article['excerpt']) ?></p>

  <div class="collectible">
    <div class="collectible-text">
      <div class="content"><?= $article['content'] ?></div>

      <?php if (!empty($article['related_product_id'])):
        $rp = $pdo->prepare("SELECT id,title,price,image_url FROM products WHERE id=:id");
        $rp->execute([':id'=>$article['related_product_id']]);
        if ($prod = $rp->fetch(PDO::FETCH_ASSOC)): ?>
          <div class="related">
            <h4>Related product</h4>
            <div class="related-box">
              <img src="<?= htmlspecialchars($prod['image_url']) ?>" alt="">
              <div>
                <a class="title" href="details.php?id=<?= (int)$prod['id'] ?>"><?= htmlspecialchars($prod['title']) ?></a>
                <div class="price"><?= number_format((float)$prod['price'],2) ?> THB</div>
                <form method="post" action="cart.php?action=add" class="add-cart-form">
                  <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
                  <input type="hidden" name="product_id" value="<?= (int)$prod['id'] ?>">
                  <input type="hidden" name="qty" value="1">
                  <button type="submit" class="btn-primary">Add to Cart</button>
                </form>
              </div>
            </div>
          </div>
      <?php endif; endif; ?>
    </div>

    <div class="collectible-img">
      <img src="<?= htmlspecialchars($article['hero'] ?: 'images/placeholder.jpg') ?>" alt="">
    </div>
  </div>
</section>

<style>
.collectible{display:grid;grid-template-columns:1.2fr 1fr;align-items:start;gap:50px;}
.collectible-img img{width:100%;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,.2);}
.collectible-text .content{line-height:1.7;color:#444}
.related{margin-top:24px}
.related-box{display:flex;gap:16px;align-items:center;background:#fff;border:1px solid #eee;border-radius:14px;padding:14px}
.related-box img{width:90px;height:90px;object-fit:cover;border-radius:10px;border:1px solid #eee}
.title{font-weight:700}
.price{color:#ff7a00;font-weight:700}
@media(max-width:900px){.collectible{grid-template-columns:1fr}}
</style>
<?php include 'footer.php'; ?>
