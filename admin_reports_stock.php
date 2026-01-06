<?php
require 'config.php';
require 'functions.php';
require_once 'functions.php';
$page_title = 'Inventory by Category | Football Store';

$cats = $pdo->query("
  SELECT category,
         COUNT(*) AS cnt,
         COALESCE(SUM(price),0) AS total_value,
         COALESCE(AVG(price),0) AS avg_price
  FROM products GROUP BY category ORDER BY category
")->fetchAll(PDO::FETCH_ASSOC);

$category_count = count($cats);
$total_items = (int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_value = (float)$pdo->query("SELECT COALESCE(SUM(price),0) FROM products")->fetchColumn();
$top_category = '';
$maxCnt = -1;
foreach($cats as $c){ if($c['cnt']>$maxCnt){$maxCnt=$c['cnt']; $top_category=strtoupper($c['category']);} }

include 'header.php';
?>
<section class="section container">
  <h2 class="section-title">Inventory by Category</h2>
  <p class="section-subtitle">COUNT • VALUE • DISTRIBUTION</p>

  <div class="kpi-grid">
    <div class="kpi-card"><div class="kpi-title">Categories</div><div class="kpi-value"><?= number_format($category_count) ?></div></div>
    <div class="kpi-card"><div class="kpi-title">Total Items</div><div class="kpi-value"><?= number_format($total_items) ?></div></div>
    <div class="kpi-card"><div class="kpi-title">Total Value</div><div class="kpi-value"><?= number_format($total_value,2) ?></div></div>
    <div class="kpi-card"><div class="kpi-title">Top Category</div><div class="kpi-value"><?= htmlspecialchars($top_category) ?></div></div>
  </div>

  <div class="table-wrap mt-20">
    <div class="table-title">Summary by Category</div>
    <table class="table">
      <thead>
        <tr>
          <th style="width:60px">#</th>
          <th>group</th>
          <th style="width:220px">Number of products</th>
          <th style="width:220px">Total value (THB)</th>
          <th style="width:200px">Average price</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($cats as $i=>$c): ?>
          <tr>
            <td><?= $i+1 ?></td>
            <td><span class="chip"><?= strtoupper(htmlspecialchars($c['category'])) ?></span></td>
            <td><?= number_format($c['cnt']) ?></td>
            <td><?= number_format($c['total_value'],2) ?></td>
            <td><?= number_format($c['avg_price'],2) ?></td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</section>
<?php include 'footer.php'; ?>
