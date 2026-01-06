<?php
require 'config.php';
require 'functions.php';
require_once 'functions.php';
$page_title = 'Manage Products | Football Store';

/* -------- Helpers -------- */
function tag_to_flags(&$data) {
  $tags = strtolower($data['tags'] ?? '');
  $is_best = (strpos($tags, 'best') !== false) ? 1 : 0;
  $is_sale = (strpos($tags, 'sale') !== false) ? 1 : 0;
  $badge = $data['sale_badge_text'] ?? '';
  if ($is_sale && trim($badge) === '') $badge = 'SALE UP TO 40%';
  $data['is_best_seller'] = $is_best;
  $data['is_sale'] = $is_sale;
  $data['sale_badge_text'] = $badge;
}

/* -------- Actions (POST) -------- */
$errors = [];
$info = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf'] ?? '')) $errors[] = 'Invalid CSRF token.';
  $action = $_POST['action'] ?? '';

  if (!$errors && $action === 'create') {
    $data = [
      'title' => trim($_POST['title'] ?? ''),
      'category' => trim($_POST['category'] ?? ''),
      'price' => (float)($_POST['price'] ?? 0),
      'image_url' => trim($_POST['image_url'] ?? ''),
      'tags' => trim($_POST['tags'] ?? ''),
      'sale_badge_text' => trim($_POST['sale_badge_text'] ?? '')
    ];
    if ($data['title']==='' || $data['category']==='' || $data['price']<=0) $errors[]='Please fill in product name, category and valid price.';
    tag_to_flags($data);
    if (!$errors) {
      $stmt = $pdo->prepare("INSERT INTO products (title,category,price,image_url,tags,is_best_seller,is_sale,sale_badge_text) VALUES (:t,:c,:p,:img,:tags,:best,:sale,:badge)");
      $stmt->execute([
        ':t'=>$data['title'], ':c'=>$data['category'], ':p'=>$data['price'], ':img'=>$data['image_url'],
        ':tags'=>$data['tags'], ':best'=>$data['is_best_seller'], ':sale'=>$data['is_sale'], ':badge'=>$data['sale_badge_text']
      ]);
      $info = 'Product added.';
      header("Location: admin_products.php?notice=".urlencode($info)); exit;
    }
  }

  if (!$errors && $action === 'update') {
    $id = (int)($_POST['id'] ?? 0);
    $data = [
      'title' => trim($_POST['title'] ?? ''),
      'category' => trim($_POST['category'] ?? ''),
      'price' => (float)($_POST['price'] ?? 0),
      'image_url' => trim($_POST['image_url'] ?? ''),
      'tags' => trim($_POST['tags'] ?? ''),
      'sale_badge_text' => trim($_POST['sale_badge_text'] ?? '')
    ];
    if ($id<=0) $errors[]='Invalid item.';
    if ($data['title']==='' || $data['category']==='' || $data['price']<=0) $errors[]='Please fill in product name, category and valid price.';
    tag_to_flags($data);
    if (!$errors) {
      $stmt = $pdo->prepare("UPDATE products SET title=:t,category=:c,price=:p,image_url=:img,tags=:tags,is_best_seller=:best,is_sale=:sale,sale_badge_text=:badge WHERE id=:id");
      $stmt->execute([
        ':t'=>$data['title'], ':c'=>$data['category'], ':p'=>$data['price'], ':img'=>$data['image_url'],
        ':tags'=>$data['tags'], ':best'=>$data['is_best_seller'], ':sale'=>$data['is_sale'], ':badge'=>$data['sale_badge_text'],
        ':id'=>$id
      ]);
      $info = 'Product updated.';
      header("Location: admin_products.php?notice=".urlencode($info)); exit;
    }
  }

  if (!$errors && $action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id<=0) $errors[]='Invalid item.';
    if (!$errors) {
      $pdo->prepare("DELETE FROM products WHERE id=:id")->execute([':id'=>$id]);
      $info = 'Product deleted.';
      header("Location: admin_products.php?notice=".urlencode($info)); exit;
    }
  }
}

/* -------- List (GET) -------- */
$q = trim($_GET['q'] ?? '');
$cat = trim($_GET['cat'] ?? '');
$params = [];
$where = "WHERE 1=1";
if ($q !== '') {
  $where .= " AND (title LIKE :q OR category LIKE :q OR tags LIKE :q)";
  $params[':q'] = "%$q%";
}
if ($cat !== '' && $cat !== 'All') {
  $where .= " AND category = :cat";
  $params[':cat'] = $cat;
}
$sql = "SELECT * FROM products $where ORDER BY id ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$cats = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category ASC")->fetchAll(PDO::FETCH_COLUMN);

include 'header.php';
?>

<section class="section container">
  <h2 class="section-title">Manage Products</h2>
  <p class="section-subtitle">Add information • Edit • Delete</p>

  <?php if (isset($_GET['notice'])): ?>
    <div class="alert"><?= htmlspecialchars($_GET['notice']) ?></div>
  <?php endif; ?>
  <?php if ($errors): ?>
    <div class="alert"><?= implode('<br>', array_map('htmlspecialchars',$errors)) ?></div>
  <?php endif; ?>

  <div class="admin-toolbar">
    <a class="btn-primary" href="?action=add">+ Add Product</a>

    <form class="admin-search" method="get">
      <input type="text" name="q" placeholder="Search by name / category / tags..." value="<?= htmlspecialchars($q) ?>">
      <select name="cat">
        <option <?= $cat===''||$cat==='All'?'selected':''?>>All</option>
        <?php foreach($cats as $c): ?>
          <option <?= $cat===$c?'selected':''?>><?= htmlspecialchars($c) ?></option>
        <?php endforeach; ?>
      </select>
      <button class="btn-dark" type="submit">Search</button>
    </form>

    <div class="admin-counter"><?= count($rows) ?> items</div>
  </div>

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th style="width:60px">#</th>
          <th>Product name</th>
          <th style="width:120px">group</th>
          <th style="width:140px">price (THB)</th>
          <th style="width:120px">Tags</th>
          <th style="width:120px">manage</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($rows as $i=>$r): ?>
        <tr>
          <td><?= $i+1 ?></td>
          <td class="cell-product">
            <img class="thumb" src="<?= htmlspecialchars($r['image_url']) ?>" alt="" onerror="this.style.visibility='hidden'">
            <div>
              <div class="title-ellipsis"><?= htmlspecialchars($r['title']) ?></div>
              <div class="muted small"><?= htmlspecialchars($r['image_url']) ?></div>
            </div>
          </td>
          <td><span class="chip"><?= strtoupper(htmlspecialchars($r['category'])) ?></span></td>
          <td><?= number_format($r['price'],2) ?></td>
          <td><?= htmlspecialchars($r['tags'] ?? tag_str_from_flags($r ?? [])) ?></td>
          <td>
            <a class="link" href="?action=edit&id=<?= $r['id'] ?>">Edit</a>
            <a class="link danger" href="?action=delete&id=<?= $r['id'] ?>">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

<?php

function tag_str_from_flags($p){
  $t=[]; if(($p['is_best_seller']??0)==1)$t[]='best'; if(($p['is_sale']??0)==1)$t[]='sale'; return implode(',',$t);
}

$action = $_GET['action'] ?? '';
$modal_item = null;
if ($action==='edit' || $action==='delete') {
  $id = (int)($_GET['id'] ?? 0);
  if ($id>0) {
    $st = $pdo->prepare("SELECT * FROM products WHERE id=:id");
    $st->execute([':id'=>$id]);
    $modal_item = $st->fetch(PDO::FETCH_ASSOC);
    if ($modal_item && empty($modal_item['tags'])) $modal_item['tags'] = tag_str_from_flags($modal_item);
  }
}
?>

<?php if ($action==='add' || ($action==='edit' && $modal_item)): ?>
<div class="modal show">
  <div class="modal-card">
    <h3><?= $action==='add'?'Add Product':'Edit Product' ?></h3>
    <form method="post">
      <label>Product name</label>
      <input type="text" name="title" value="<?= htmlspecialchars($modal_item['title'] ?? '') ?>" placeholder="Product name">

      <div class="row-2">
        <div>
          <label>group</label>
          <select name="category">
            <?php
              $opts = ['Shirt','Cleats','Soccer Ball','Wishlist'];
              $cur = $modal_item['category'] ?? '';
              foreach($opts as $op){
                $sel = (strcasecmp($cur,$op)===0)?'selected':'';
                echo "<option $sel>$op</option>";
              }
            ?>
          </select>
        </div>
        <div>
          <label>price (THB)</label>
          <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($modal_item['price'] ?? '') ?>" placeholder="0.00">
        </div>
      </div>

      <label>picture (URL)</label>
      <input type="text" name="image_url" value="<?= htmlspecialchars($modal_item['image_url'] ?? '') ?>" placeholder="https://.../image.jpg">

      <div class="row-2">
        <div>
          <label>Tags</label>
          <input type="text" name="tags" value="<?= htmlspecialchars($modal_item['tags'] ?? '') ?>" placeholder="best,sale">
        </div>
        <div>
          <label>Sale badge text (optional)</label>
          <input type="text" name="sale_badge_text" value="<?= htmlspecialchars($modal_item['sale_badge_text'] ?? '') ?>" placeholder="SALE UP TO 40%">
        </div>
      </div>

      <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
      <?php if ($action==='edit'): ?>
        <input type="hidden" name="id" value="<?= (int)$modal_item['id'] ?>">
        <input type="hidden" name="action" value="update">
      <?php else: ?>
        <input type="hidden" name="action" value="create">
      <?php endif; ?>

      <div class="modal-actions">
        <a class="btn-dark" href="admin_products.php">Cancel</a>
        <button class="btn-primary" type="submit">Save</button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<?php if ($action==='delete' && $modal_item): ?>
<div class="modal show">
  <div class="modal-card small">
    <h3>Delete item</h3>
    <p>Confirm deletion of this item?</p>
    <form method="post">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
      <input type="hidden" name="id" value="<?= (int)$modal_item['id'] ?>">
      <input type="hidden" name="action" value="delete">
      <div class="modal-actions">
        <a class="btn-dark" href="admin_products.php">Cancel</a>
        <button class="btn-primary danger" type="submit">Delete</button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<?php include 'footer.php'; ?>
