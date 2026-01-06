<?php
require 'config.php';
require 'functions.php';
$page_title = 'My Account | Football Store';
include 'header.php';

$user = [
  'name' => 'Phitchaya',
  'email' => 'Phitchaya1502@gmail.com',
  'phone' => '+66 999 999 999',
  'address' => '123 Football Street, Bangkok 10110',
  'avatar' => 'https://cdn-icons-png.flaticon.com/512/149/149071.png'
];
?>

<section class="account-section container">
  <div class="account-card">
    <div class="account-header">
      <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="avatar" class="avatar">
      <div>
        <h2>Hi, <?= htmlspecialchars($user['name']) ?></h2>
        <p class="muted"><?= htmlspecialchars($user['email']) ?></p>
      </div>
    </div>

    <div class="account-info">
      <h3>Account Details</h3>
      <ul>
        <li><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></li>
        <li><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
        <li><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></li>
        <li><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></li>
      </ul>

      <div class="account-actions">
        <a href="edit_profile.php" class="btn-secondary">Edit Profile</a>
        <a href="logout.php" class="btn-primary">Logout</a>
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
