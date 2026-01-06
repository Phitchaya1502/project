<?php
function is_logged_in(): bool {
  return isset($_SESSION['user']);
}
function require_guest() {
  if (is_logged_in()) { header('Location: index.php'); exit; }
}
function require_auth() {
  if (!is_logged_in()) { header('Location: login.php'); exit; }
}
function csrf_token(): string {
  if (empty($_SESSION['csrf'])) { $_SESSION['csrf'] = bin2hex(random_bytes(32)); }
  return $_SESSION['csrf'];
}
function verify_csrf($token): bool {
  return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], (string)$token);
}
/* ==== CART HELPERS ==== */
function cart_init() {
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = ['items' => []]; // [product_id => qty]
  }
}
function cart_add(int $product_id, int $qty = 1) {
  cart_init();
  if ($qty < 1) $qty = 1;
  $_SESSION['cart']['items'][$product_id] = ($_SESSION['cart']['items'][$product_id] ?? 0) + $qty;
}
function cart_set(int $product_id, int $qty) {
  cart_init();
  if ($qty < 1) { unset($_SESSION['cart']['items'][$product_id]); return; }
  $_SESSION['cart']['items'][$product_id] = $qty;
}
function cart_remove(int $product_id) {
  cart_init();
  unset($_SESSION['cart']['items'][$product_id]);
}
function cart_clear() {
  $_SESSION['cart'] = ['items'=>[]];
}
function cart_count(): int {
  cart_init();
  return array_sum($_SESSION['cart']['items']);
}

/* ดึงรายละเอียดสินค้าตามตะกร้า */
function cart_items_with_products(PDO $pdo): array {
  cart_init();
  $ids = array_keys($_SESSION['cart']['items']);
  if (!$ids) return ['rows'=>[], 'total'=>0];
  $in = implode(',', array_fill(0, count($ids), '?'));
  $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($in)");
  $stmt->execute($ids);
  $rows = [];
  $grand = 0;
  while ($p = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $qty = (int)($_SESSION['cart']['items'][$p['id']] ?? 0);
    $line_total = $qty * (float)$p['price'];
    $grand += $line_total;
    $rows[] = [
      'id' => $p['id'],
      'title' => $p['title'],
      'price' => (float)$p['price'],
      'qty' => $qty,
      'image_url' => $p['image_url'],
      'line_total' => $line_total,
      'category' => $p['category']
    ];
  }
  // เรียงตาม id เพื่อคงที่
  usort($rows, fn($a,$b)=>$a['id']<=>$b['id']);
  return ['rows'=>$rows, 'total'=>$grand];
}
