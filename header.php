<!-- header.php -->
<?php
require_once __DIR__ . '/functions.php';
if (!function_exists('is_logged_in')) {
  function is_logged_in(): bool { return isset($_SESSION['user']); }
}
?>

<?php if (!isset($page_title)) { $page_title = 'Football Store'; } ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($page_title) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="styles.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-dark">
  <div class="topbar">FREE STANDARD SHIPPING FOR ORDERS OVER 1,000 BAHT</div>
  <nav class="nav">
    <div class="brand">FOOTBALL<span>STORE</span></div>
    <ul class="menu">
      <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF'])==='index.php'?'active':'' ?>">Home</a></li>
      <li><a href="trending.php">Trending</a></li>
      <li><a href="series.php">Series</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="admin.php">Manages</a></li>
      
      
    </ul>
    <div class="nav-right">
  <form class="search-form" action="search.php" method="get">
    <input class="search" type="search" name="q" placeholder="Search"
           value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
  </form>
  <a class="icon-btn" href="cart.php" aria-label="cart" style="position:relative">

    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
      <path d="M6 6h15l-2 9H8L6 6z" stroke="currentColor" stroke-width="2" fill="none"/>
      <circle cx="9" cy="20" r="1.5" fill="currentColor"/>
      <circle cx="18" cy="20" r="1.5" fill="currentColor"/>
    </svg>

    <style>
  .search-form{ margin-right: 10px; }
  .search{ width: 300px; border-radius: 14px; padding: 12px 14px; }
  @media (max-width: 640px){ .search{ width: 200px; } }
</style>
    <?php $__cc = cart_count(); if ($__cc>0): ?>
      <span class="cart-badge"><?= $__cc ?></span>
    <?php endif; ?>
  </a>
  <style>
    .cart-badge{
      position:absolute; top:-6px; right:-6px;
      background:#0b0b1a; color:#fff; min-width:20px; height:20px;
      padding:0 6px; border-radius:999px; font-size:12px; font-weight:800;
      display:flex; align-items:center; justify-content:center;
      box-shadow:0 2px 8px rgba(0,0,0,.25);
    }
  </style>
      <?php if (is_logged_in()): ?>
        <span class="welcome">Hi, <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
        <a class="btn-outline" href="logout.php">Logout</a>
      <?php else: ?>
        <a class="icon-btn" href="login.php" aria-label="account">

          <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/>
            <path d="M4 21c1.8-3.5 5-5 8-5s6.2 1.5 8 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
          
        </a>

      <?php endif; ?>
      <div class="lang">EN ▾</div>
    </div>
  </nav>
  <main>
