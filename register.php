<?php
require 'config.php';
require 'functions.php';
require_once 'functions.php';
require_guest();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf'] ?? '')) { $errors[] = 'Invalid CSRF token.'; }

  $full_name = trim($_POST['full_name'] ?? '');
  $email     = strtolower(trim($_POST['email'] ?? ''));
  $username  = trim($_POST['username'] ?? '');
  $password  = $_POST['password'] ?? '';
  $confirm   = $_POST['confirm_password'] ?? '';

  if ($full_name==='' || $email==='' || $username==='' || $password==='' || $confirm==='') {
    $errors[] = 'Please fill in all fields.';
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format.';
  if ($password !== $confirm) $errors[] = 'Passwords do not match.';
  if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';

  if (!$errors) {
    try {
      $stmt = $pdo->prepare("INSERT INTO users (full_name, username, email, password_hash) VALUES (:n,:u,:e,:p)");
      $stmt->execute([
        ':n'=>$full_name, ':u'=>$username, ':e'=>$email,
        ':p'=>password_hash($password, PASSWORD_DEFAULT)
      ]);
      // auto login
      $_SESSION['user'] = [
        'id'=>$pdo->lastInsertId(),
        'username'=>$username,
        'email'=>$email,
        'full_name'=>$full_name
      ];
      header('Location: index.php'); exit;
    } catch (PDOException $ex) {
      if ($ex->errorInfo[1] == 1062) {
        $errors[] = 'Username or Email already exists.';
      } else {
        $errors[] = 'Error: '.$ex->getMessage();
      }
    }
  }
}

$page_title = 'Register | Football Store';
include 'header.php';
?>
<div class="auth-wrap">
  <form method="post" class="auth-card">
    <h2>Create Account</h2>
    <p class="muted">Sign up to start your shopping experience.</p>

    <?php if ($errors): ?>
      <div class="alert">
        <?= implode('<br>', array_map('htmlspecialchars', $errors)) ?>
      </div>
    <?php endif; ?>

    <label>Full Name</label>
    <input type="text" name="full_name" placeholder="Full Name" value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">

    <label>Email</label>
    <input type="email" name="email" placeholder="example@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

    <label>Username</label>
    <input type="text" name="username" placeholder="yourusername" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">

    <label>Password</label>
    <input type="password" name="password" placeholder="••••••••">

    <label>Confirm Password</label>
    <input type="password" name="confirm_password" placeholder="••••••••">

    <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
    <button class="btn-primary w-100" type="submit">Register</button>

    <p class="muted center">Already have an account? <a class="link" href="login.php">Login</a></p>
  </form>
</div>
<?php include 'footer.php'; ?>
