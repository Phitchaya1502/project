<?php
require 'config.php';
require 'functions.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$page_title = 'Checkout | Football Store';

/* โหลดของในตะกร้า (ต้องมี cart_items_with_products, cart_clear ใน functions.php) */
$cart = cart_items_with_products($pdo);
if (empty($cart['rows'])) {
  header('Location: cart.php'); exit;
}

/* ค่าขนส่ง / คูปอง (ตัวอย่าง) */
$shipping_fee = 0.00; // ตั้งค่าตามต้องการ
$subtotal     = $cart['total'];
$grand_total  = $subtotal + $shipping_fee;

/* POST: บันทึกออเดอร์ */
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // ตรวจ CSRF ถ้ามี
  if (function_exists('verify_csrf') && !verify_csrf($_POST['csrf'] ?? '')) {
    $errors[] = 'Security check failed. Please refresh and try again.';
  }

  // เก็บฟอร์ม
  $full_name = trim($_POST['full_name'] ?? '');
  $email     = trim($_POST['email'] ?? '');
  $phone     = trim($_POST['phone'] ?? '');
  $address   = trim($_POST['address'] ?? '');
  $pay       = $_POST['payment_method'] ?? 'COD';

  if ($full_name === '' || $address === '') {
    $errors[] = 'Please fill in full name and address.';
  }
  if (!in_array($pay, ['COD','TRANSFER','CARD'], true)) {
    $pay = 'COD';
  }

  if (!$errors) {
    try {
      $pdo->beginTransaction();

      // 1) ลูกค้า
      $st = $pdo->prepare("INSERT INTO customers(full_name,email,phone,address) VALUES(:n,:e,:p,:a)");
      $st->execute([
        ':n' => $full_name,
        ':e' => $email,
        ':p' => $phone,
        ':a' => $address,
      ]);
      $customer_id = (int)$pdo->lastInsertId();

      // 2) ออเดอร์
      $order_number = 'FS'.date('ymdHis').random_int(100,999);
      $st = $pdo->prepare("INSERT INTO orders(customer_id,order_number,subtotal,shipping_fee,grand_total,payment_method,status)
                           VALUES(:cid,:num,:sub,:ship,:grand,:pay,'PENDING')");
      $st->execute([
        ':cid'  => $customer_id,
        ':num'  => $order_number,
        ':sub'  => $subtotal,
        ':ship' => $shipping_fee,
        ':grand'=> $grand_total,
        ':pay'  => $pay,
      ]);
      $order_id = (int)$pdo->lastInsertId();

      // 3) รายการสินค้า
      $sti = $pdo->prepare("INSERT INTO order_items(order_id,product_id,title,price,qty,line_total)
                            VALUES(:oid,:pid,:t,:pr,:q,:lt)");
      foreach ($cart['rows'] as $row) {
        $sti->execute([
          ':oid' => $order_id,
          ':pid' => (int)$row['id'],
          ':t'   => $row['title'],
          ':pr'  => $row['price'],
          ':q'   => (int)$row['qty'],
          ':lt'  => $row['line_total'],
        ]);
      }

      $pdo->commit();

      // ล้างตะกร้า
      cart_clear();

      // ไปหน้า success (หรือแสดงภายในไฟล์นี้)
      header('Location: checkout_success.php?order='.$order_number);
      exit;

    } catch (Throwable $e) {
      if ($pdo->inTransaction()) $pdo->rollBack();
      $errors[] = 'Cannot place order. Please try again.';
      // error_log($e->getMessage());
    }
  }
}

include 'header.php';
?>
<section class="section container">
  <h2 class="section-title">Checkout</h2>
  <p class="section-subtitle">Please fill in your delivery information</p>

  <?php if ($errors): ?>
    <div class="alert"><?= htmlspecialchars(implode(' ', $errors)) ?></div>
  <?php endif; ?>

  <div class="checkout-grid" style="display:grid;grid-template-columns:1.2fr .8fr;gap:24px;">
    <!-- ฟอร์มผู้รับ -->
    <form method="post" action="checkout.php" class="card" style="background:#fff;border-radius:14px;padding:20px;">
      <?php if (function_exists('csrf_token')): ?>
        <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
      <?php endif; ?>

      <div class="field">
        <label>Full name *</label>
        <input type="text" name="full_name" required>
      </div>
      <div class="field-row" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div class="field">
          <label>Email</label>
          <input type="email" name="email">
        </div>
        <div class="field">
          <label>Phone</label>
          <input type="text" name="phone">
        </div>
      </div>
      <div class="field">
        <label>Address *</label>
        <textarea name="address" rows="4" required></textarea>
      </div>
      <div class="field">
        <label>Payment</label>
        <select name="payment_method">
          <option value="COD">Cash on Delivery (COD)</option>
          <option value="TRANSFER">Bank Transfer</option>
          <option value="CARD">Credit/Debit Card (manual)</option>
        </select>
      </div>

      <button class="btn-primary" type="submit">Place Order</button>
    </form>

    <!-- สรุปออเดอร์ -->
    <div class="card" style="background:#fff;border-radius:14px;padding:20px;">
      <h4 style="margin:0 0 12px 0;">Order Summary</h4>
      <ul style="list-style:none;padding:0;margin:0 0 12px 0;">
        <?php foreach ($cart['rows'] as $row): ?>
          <li style="display:flex;justify-content:space-between;gap:12px;padding:8px 0;border-bottom:1px dashed #eee;">
            <span><?= htmlspecialchars($row['title']) ?> × <?= (int)$row['qty'] ?></span>
            <span><?= number_format($row['line_total'],2) ?> THB</span>
          </li>
        <?php endforeach; ?>
      </ul>
      <div style="display:flex;justify-content:space-between;margin-top:6px;">
        <span>Subtotal</span><strong><?= number_format($subtotal,2) ?> THB</strong>
      </div>
      <div style="display:flex;justify-content:space-between;margin-top:6px;">
        <span>Shipping</span><strong><?= number_format($shipping_fee,2) ?> THB</strong>
      </div>
      <hr style="border:none;border-top:1px solid #eee;margin:12px 0;">
      <div style="display:flex;justify-content:space-between;font-size:18px;">
        <span>Total</span><strong style="color:#ff7a00;"><?= number_format($grand_total,2) ?> THB</strong>
      </div>
    </div>
  </div>
</section>
<?php include 'footer.php'; ?>
