<?php
require 'config.php';
require 'functions.php';
require_once 'functions.php';
$page_title = 'Sales Summary | Football Store';

$total_items = (int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_value = (float)$pdo->query("SELECT COALESCE(SUM(price),0) FROM products")->fetchColumn();
$avg_price   = $total_items>0 ? $total_value/$total_items : 0.0;
$best_tagged = (int)$pdo->query("SELECT COUNT(*) FROM products WHERE is_best_seller=1")->fetchColumn();

$topItems = $pdo->query("SELECT * FROM products ORDER BY is_best_seller DESC, price DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>
<section class="section container">
  <h2 class="section-title">Sales Summary</h2>
  <p class="section-subtitle">OVERVIEW • KPI • TOP ITEMS</p>

  <div class="kpi-grid">
    <div class="kpi-card"><div class="kpi-title">Total Items</div><div class="kpi-value"><?= number_format($total_items) ?></div></div>
    <div class="kpi-card"><div class="kpi-title">Total Value (THB)</div><div class="kpi-value"><?= number_format($total_value,2) ?></div></div>
    <div class="kpi-card"><div class="kpi-title">Average Price</div><div class="kpi-value"><?= number_format($avg_price,2) ?></div></div>
    <div class="kpi-card"><div class="kpi-title">Best-tagged</div><div class="kpi-value"><?= number_format($best_tagged) ?></div></div>
  </div>

  <div class="table-wrap mt-20">
    <div class="table-title">Top Items</div>
    <table class="table">
      <thead>
        <tr>
          <th style="width:60px">#</th>
          <th>product</th>
          <th style="width:120px">group</th>
          <th style="width:120px">Tags</th>
          <th style="width:140px">price (THB)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($topItems as $i=>$r): ?>
        <tr>
          <td><?= $i+1 ?></td>
          <td class="cell-product">
            <img class="thumb" src="<?= htmlspecialchars($r['image_url']) ?>" alt="" onerror="this.style.visibility='hidden'">
            <div class="title-ellipsis"><?= htmlspecialchars($r['title']) ?></div>
          </td>
          <td><span class="chip"><?= strtoupper(htmlspecialchars($r['category'])) ?></span></td>
          <td><?= htmlspecialchars($r['tags'] ?? (($r['is_best_seller']?'best':'').($r['is_sale']?($r['is_best_seller']?',':'').'sale':''))) ?></td>
          <td><?= number_format($r['price'],2) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
<?php include 'footer.php'; ?>
