<?php
require 'config.php';
require_once 'functions.php';

$page_title = 'Search | Football Store';
include 'header.php';

/* รับพารามิเตอร์ */
$q = trim($_GET['q'] ?? '');
$p = max(1, (int)($_GET['p'] ?? 1));      // หน้าปัจจุบัน
$sort = $_GET['sort'] ?? 'relevance';     // relevance | price_asc | price_desc | newest

$per_page = 12;
$offset = ($p - 1) * $per_page;

/* ถ้าไม่พิมพ์อะไร แสดงข้อความชี้แนะ */
if ($q === ''): ?>
  <section class="section container">
    <h2 class="section-title">Search</h2>
    <p class="section-subtitle">Type something to find your items</p>
    <div class="hint-box">Try: <code>nike</code>, <code>shirt</code>, <code>best</code>, <code>chelsea</code></div>
  </section>
<?php include 'footer.php'; exit; endif;

/* สร้าง ORDER BY */
switch ($sort) {
  case 'price_asc':  $order = 'price ASC'; break;
  case 'price_desc': $order = 'price DESC'; break;
  case 'newest':     $order = 'id DESC'; break;
  default:           // relevance: เอาของที่ tag/หมวด/ชื่อ โดน match + เป็น best/sale มาก่อน
    $order = 'is_best_seller DESC, is_sale DESC, id DESC';
}

/* นับจำนวนทั้งหมด */
$sqlCount = "SELECT COUNT(*) FROM products
             WHERE title LIKE :q OR category LIKE :q OR IFNULL(tags,'') LIKE :q";
$stmt = $pdo->prepare($sqlCount);
$like = "%$q%";
$stmt->execute([':q'=>$like]);
$total = (int)$stmt->fetchColumn();

/* ดึงข้อมูลรายการ */
$sql = "SELECT * FROM products
        WHERE title LIKE :q OR category LIKE :q OR IFNULL(tags,'') LIKE :q
        ORDER BY $order
        LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':q', $like, PDO::PARAM_STR);
$stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ฟังก์ชันไฮไลต์คำค้น */
function hl($text, $q){
  if ($q==='') return htmlspecialchars($text);
  $pat = '/' . preg_quote($q, '/') . '/i';
  return preg_replace_callback($pat, function($m){
    return '<mark>'.$m[0].'</mark>';
  }, htmlspecialchars($text));
}

/* คำนวณหน้า */
$pages = max(1, (int)ceil($total / $per_page));
?>
<section class="section container">
  <h2 class="section-title">Search results for “<?= htmlspecialchars($q) ?>”</h2>
  <p class="section-subtitle"><?= number_format($total) ?> result<?= $total==1?'':'s' ?></p>

  <div class="search-controls">
    <form method="get" class="search-refine">
      <input type="hidden" name="q" value="<?= htmlspecialchars($q) ?>">
      <label>Sort by</label>
      <select name="sort" onchange="this.form.submit()">
        <option value="relevance"  <?= $sort==='relevance'?'selected':'' ?>>Relevance</option>
        <option value="newest"     <?= $sort==='newest'?'selected':'' ?>>Newest</option>
        <option value="price_asc"  <?= $sort==='price_asc'?'selected':'' ?>>Price: Low → High</option>
        <option value="price_desc" <?= $sort==='price_desc'?'selected':'' ?>>Price: High → Low</option>
      </select>
    </form>
  </div>

  <?php if (!$rows): ?>
    <div class="empty-note">No items found. Try different keywords.</div>
  <?php else: ?>
    <div class="product-grid">
      <?php foreach($rows as $p): ?>
        <div class="product-card">
          <?php if (!empty($p['is_best_seller'])): ?>
            <div class="badge red">BEST SELLER</div>
          <?php elseif (!empty($p['is_sale']) && !empty($p['sale_badge_text'])): ?>
            <div class="badge orange"><?= htmlspecialchars($p['sale_badge_text']) ?></div>
          <?php endif; ?>

          <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="">
          <div class="product-meta">
            <div class="category"><?= hl($p['category'], $q) ?></div>
            <a class="title" href="#"><?= hl($p['title'], $q) ?></a>
            <div class="price"><?= number_format((float)$p['price'], 2) ?> THB</div>

            <!-- ปุ่ม Add to Cart -->
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

    <!-- Pagination -->
    <?php if ($pages > 1): ?>
      <div class="pagination">
        <?php
          $base = 'search.php?q='.urlencode($q).'&sort='.urlencode($sort).'&p=';
          $prev = max(1, $p-1);
          $next = min($pages, $p+1);
        ?>
        <a class="pager <?= $p==1?'disabled':'' ?>" href="<?= $base.$prev ?>">‹ Prev</a>
        <?php
          // แสดงเลขหน้าแบบกระชับ
          $start = max(1, $p-2); $end = min($pages, $p+2);
          if ($start>1) echo '<span class="ellipsis">…</span>';
          for($i=$start;$i<=$end;$i++){
            echo '<a class="pager '.($i==$p?'active':'').'" href="'.$base.$i.'">'.$i.'</a>';
          }
          if ($end<$pages) echo '<span class="ellipsis">…</span>';
        ?>
        <a class="pager <?= $p==$pages?'disabled':'' ?>" href="<?= $base.$next ?>">Next ›</a>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</section>

<style>
  .hint-box{background:#fff;border:1px solid #eee;border-radius:12px;padding:16px;max-width:560px;margin:18px auto;text-align:center}
  mark{background:#ffecce;color:#000;padding:0 .15em;border-radius:.2em}
  .search-controls{display:flex;justify-content:flex-end;margin-bottom:12px}
  .search-refine{display:flex;align-items:center;gap:8px}
  .search-refine select{padding:10px;border-radius:10px;border:1px solid #e6e6e6;background:#fff}
  .empty-note{background:#fff;border:1px solid #eee;border-radius:14px;padding:24px;text-align:center;color:#777}
  .pagination{display:flex;gap:8px;justify-content:center;margin:22px 0}
  .pager{padding:8px 12px;border:1px solid #e6e6e6;border-radius:10px;background:#fff;text-decoration:none;color:#333}
  .pager.active{background:#ff7a00;border-color:#ff7a00;color:#fff;font-weight:700}
  .pager.disabled{pointer-events:none;opacity:.5}
  .ellipsis{display:flex;align-items:center;color:#999}
</style>

<?php include 'footer.php'; ?>
