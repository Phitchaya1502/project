<?php
require 'config.php';
require_once 'functions.php';

/* -----------------------------
   รับพารามิเตอร์จากลิงก์
   รองรับทั้ง ?team=Liverpool FC หรือ ?series_id=2
--------------------------------*/
$team      = trim($_GET['team'] ?? '');
$series_id = (int)($_GET['series_id'] ?? 0);

/* -----------------------------
   ดึงข้อมูลซีรีส์จากตาราง `series`
--------------------------------*/
$series = null;

if ($series_id > 0) {
  $st = $pdo->prepare("SELECT id, club_name, description, image_url FROM series WHERE id = :id LIMIT 1");
  $st->execute([':id' => $series_id]);
  $series = $st->fetch(PDO::FETCH_ASSOC);
  // sync ชื่อทีมไว้ใช้กรองสินค้า
  if ($series && !$team) $team = $series['club_name'];
} elseif ($team !== '') {
  // match แบบยืดหยุ่นกับชื่อสโมสร
  $st = $pdo->prepare("SELECT id, club_name, description, image_url
                       FROM series
                       WHERE club_name LIKE :t
                       ORDER BY id ASC LIMIT 1");
  $st->execute([':t' => "%$team%"]);
  $series = $st->fetch(PDO::FETCH_ASSOC);
}

/* -----------------------------
   ตั้งชื่อหน้า
--------------------------------*/
$page_title = ($series['club_name'] ?? ($team ?: 'All Teams')) . ' | Shop Collection';
include 'header.php';

/* -----------------------------
   hero ด้านบนจากตาราง series (ถ้ามี)
--------------------------------*/
?>
<?php if ($series): ?>
  <section class="series-hero"
    style="
      position:relative;min-height:48vh;display:flex;align-items:center;
      background-image:url('<?= htmlspecialchars($series['image_url']) ?>');
      background-size:cover;background-position:center;background-repeat:no-repeat;
      color:#fff;overflow:hidden;">
    <div class="container" style="position:relative;z-index:1;padding:32px 16px;">
      <h1 class="section-title" style="font-size:46px;font-weight:800;margin:0;">
        <?= htmlspecialchars($series['club_name']) ?> Collection
      </h1>
      <?php if (!empty($series['description'])): ?>
        <p class="section-subtitle" style="margin-top:10px;color:#d0d0d0;">
          <?= htmlspecialchars($series['description']) ?>
        </p>
      <?php endif; ?>
    </div>
    <!-- เอา overlay ออกให้เห็นภาพชัด ถ้าต้องการใส่ความมืดเล็กน้อยให้ปรับ alpha ได้ -->
    <div aria-hidden="true" style="position:absolute;inset:0;background:rgba(0,0,0,0);"></div>
  </section>
<?php else: ?>
  <!-- ไม่มีข้อมูลใน series ก็ใช้หัวมาตรฐาน -->
  <section class="section container">
    <h2 class="section-title"><?= htmlspecialchars($team ?: 'All Teams') ?> Collection</h2>
    <p class="section-subtitle">Official merch and kits from your favourite club</p>
  </section>
<?php endif; ?>

<?php
/* -----------------------------
   โหลดสินค้า จากตาราง products
   กรองด้วย team หรือ category ให้ครอบคลุม
--------------------------------*/
$sql  = "SELECT * FROM products WHERE 1=1";
$args = [];

if ($team !== '') {
  $sql .= " AND (IFNULL(team,'') LIKE :t OR category LIKE :t)";
  $args[':t'] = "%$team%";
}

$sql .= " ORDER BY is_best_seller DESC, is_sale DESC, id DESC LIMIT 48";
$stmt  = $pdo->prepare($sql);
$stmt->execute($args);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="section container" style="padding-top:28px;">
  <?php if (!$items): ?>
    <div class="empty-note">No products found.</div>
  <?php else: ?>
    <div class="product-grid">
      <?php foreach ($items as $p): ?>
        <div class="product-card">
          <?php if (!empty($p['is_best_seller'])): ?>
            <div class="badge red">BEST SELLER</div>
          <?php endif; ?>
          <?php if (!empty($p['is_sale']) && !empty($p['sale_badge_text'])): ?>
            <div class="badge orange"><?= htmlspecialchars($p['sale_badge_text']) ?></div>
          <?php endif; ?>

          <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="<?= htmlspecialchars($p['title']) ?>">
          <div class="product-meta">
            <div class="category"><?= htmlspecialchars($p['team'] ?: $p['category']) ?></div>
            <a class="title" href="details.php?id=<?= (int)$p['id'] ?>"><?= htmlspecialchars($p['title']) ?></a>
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
  <?php endif; ?>
</section>

<?php include 'footer.php'; ?>
