<?php
require 'config.php';
require 'functions.php';
$page_title = 'Your Cart | Football Store';

/* ---- Actions ---- */
$action = $_GET['action'] ?? '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  // ป้องกัน CSRF ถ้ามี
  if (!verify_csrf($_POST['csrf'] ?? '')) {
    header('Location: cart.php?error=csrf'); exit;
  }

  if ($action==='add') {
    $pid = (int)($_POST['product_id'] ?? 0);
    $qty = (int)($_POST['qty'] ?? 1);
    // ตรวจว่ามีสินค้าอยู่จริง
    $st = $pdo->prepare("SELECT id FROM products WHERE id=:id LIMIT 1");
    $st->execute([':id'=>$pid]);
    if ($st->fetchColumn()) {
      cart_add($pid, max(1,$qty));
      header('Location: cart.php?added=1'); exit;
    } else {
      header('Location: cart.php?notfound=1'); exit;
    }
  }

  if ($action==='update') {
    foreach (($_POST['qty'] ?? []) as $pid => $q) {
      cart_set((int)$pid, (int)$q);
    }
    header('Location: cart.php?updated=1'); exit;
  }

  if ($action==='remove') {
    cart_remove((int)($_POST['product_id'] ?? 0));
    header('Location: cart.php?removed=1'); exit;
  }

  if ($action==='clear') {
    cart_clear();
    header('Location: cart.php?cleared=1'); exit;
  }
}

/* ---- Load items ---- */
$cart = cart_items_with_products($pdo);
include 'header.php';
?>
<section class="section container">
  <h2 class="section-title">Shopping Cart</h2>
  <p class="section-subtitle">Review your selected items before checkout</p>

  <?php if (isset($_GET['added'])): ?><div class="alert success">Added to cart.</div><?php endif; ?>
  <?php if (isset($_GET['updated'])): ?><div class="alert success">Cart updated.</div><?php endif; ?>
  <?php if (isset($_GET['removed'])): ?><div class="alert">Item removed.</div><?php endif; ?>
  <?php if (isset($_GET['cleared'])): ?><div class="alert">Cart cleared.</div><?php endif; ?>

  <?php if (empty($cart['rows'])): ?>
    <p style="text-align:center;color:#777;">Your cart is empty.</p>
  <?php else: ?>
  <div class="cart-table">
    <form method="post" action="cart.php?action=update">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
      <table>
        <thead>
        <tr>
          <th>Product</th>
          <th>Price (THB)</th>
          <th>Qty</th>
          <th>Total</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($cart['rows'] as $row): ?>
          <tr>
            <td class="product-info">
              <img src="<?= htmlspecialchars($row['image_url']) ?>" class="product-thumb" alt="">
              <span><?= htmlspecialchars($row['title']) ?></span>
            </td>
            <td><?= number_format($row['price'],2) ?></td>
            <td style="min-width:110px">
              <input type="number" name="qty[<?= (int)$row['id'] ?>]" value="<?= (int)$row['qty'] ?>" min="1">
            </td>
            <td><?= number_format($row['line_total'],2) ?></td>
            <td>
              <form method="post" action="cart.php?action=remove" style="display:inline">
                <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
                <input type="hidden" name="product_id" value="<?= (int)$row['id'] ?>">
                <button class="btn-remove" title="Remove">✕</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>

      <div class="cart-summary">
        <h4>Total: <span><?= number_format($cart['total'],2) ?> THB</span></h4>
        <div class="cart-actions">
  <form method="post" action="cart.php?action=update">
    <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
    <button class="btn-secondary" type="submit">Update Cart</button>
  </form>

  <form method="post" action="cart.php?action=clear">
    <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
    <button class="btn-secondary" type="submit">Clear</button>
  </form>

  <a href="checkout.php" class="btn-checkout">Checkout</a>
</div>

      </div>
  </div>
  <?php endif; ?>
</section>
<?php include 'footer.php'; ?>
