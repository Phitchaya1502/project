<?php
require 'config.php';
require_once 'functions.php';
// ถ้ามีไฟล์ฟังก์ชันและอยากใช้ CSRF ให้เปิดบรรทัดนี้ด้วย
// require 'functions.php';

$page_title = 'Contact | Football Store';

$success = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // ถ้ามี CSRF ให้เปิด 2 บรรทัดนี้
  // if (!verify_csrf($_POST['csrf'] ?? '')) { $errors[] = 'Invalid CSRF token.'; }

  // รับค่าจากฟอร์ม (ต้องตรงกับ name=... ใน HTML)
  $full_name = trim($_POST['full_name'] ?? '');
  $email     = trim($_POST['email'] ?? '');
  $message   = trim($_POST['message'] ?? '');

  // validate เบื้องต้น
  if ($full_name === '' || $email === '' || $message === '') {
    $errors[] = 'Please fill in all fields.';
  }
  if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format.';
  }

  // บันทึกลง DB
  if (!$errors) {
    $stmt = $pdo->prepare("
      INSERT INTO contacts (full_name, email, message)
      VALUES (:full_name, :email, :message)
    ");
    $stmt->execute([
      ':full_name' => $full_name,
      ':email'     => $email,
      ':message'   => $message,
    ]);

    // PRG pattern กันการกด refresh แล้วส่งซ้ำ
    header('Location: contact.php?sent=1');
    exit;
  }
}

// ถ้า redirect กลับมา
if (isset($_GET['sent']) && $_GET['sent'] == '1') {
  $success = 'Your message has been sent successfully!';
}

include 'header.php';
?>

<section class="section container">
  <h2 class="section-title">Contact Us</h2>
  <p class="section-subtitle">Get in Touch with Our Team</p>

  <div class="contact-grid">
    <div class="contact-card">
      <h3>Our Store</h3>
      <p><strong>Address</strong><br>123 Football Street, Bangkok, Thailand 10110</p>
      <p><strong>Phone</strong><br>+66 123 456 789</p>
      <p><strong>Email</strong><br>support@footballstore.com</p>
      <iframe src="https://maps.google.com/maps?q=Patpong%20Night%20Market&t=&z=13&ie=UTF8&iwloc=&output=embed"
              width="100%" height="220" style="border:0;border-radius:12px" allowfullscreen=""></iframe>
    </div>

    <div class="contact-card">
      <h3>Send Us a Message</h3>

      <?php if ($success): ?>
        <div class="alert success"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>

      <?php if ($errors): ?>
        <div class="alert"><?= implode('<br>', array_map('htmlspecialchars', $errors)) ?></div>
      <?php endif; ?>

      <form method="post" action="contact.php" novalidate>
        <label>Full Name</label>
        <input type="text" name="full_name" placeholder="Full Name" value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" required>

        <label>Email Address</label>
        <input type="email" name="email" placeholder="Email Address" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

        <label>Your Message</label>
        <textarea name="message" placeholder="Your Message..." required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>

        <?php // ถ้ามีระบบ CSRF:
        // echo '<input type="hidden" name="csrf" value="'.htmlspecialchars(csrf_token()).'">'; ?>

        <button type="submit" class="btn-primary">Send Message</button>
      </form>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
