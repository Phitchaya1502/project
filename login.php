<?php
require 'config.php';
require 'functions.php';
require_once 'functions.php';
require_guest();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf'] ?? '')) { $errors[] = 'Invalid CSRF token.'; }
  $identity = trim($_POST['identity'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($identity === '' || $password === '') $errors[] = 'Please fill in all fields.';

  if (!$errors) {
    $sql = "SELECT * FROM users WHERE email = :id OR username = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $identity]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password_hash'])) {
      $_SESSION['user'] = [
        'id' => $user['id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'full_name' => $user['full_name']
      ];
      header('Location: index.php'); exit;
    } else {
      $errors[] = 'Username/Email or password is incorrect.';
    }
  }
}

$page_title = 'Login | Football Store';
include 'header.php';
?>
<div class="auth-wrap">
  <form method="post" class="auth-card">
    <h2>Welcome back</h2>
    <p class="muted">Log in to continue shopping</p>

    <?php if ($errors): ?>
      <div class="alert">
        <?= implode('<br>', array_map('htmlspecialchars', $errors)) ?>
      </div>
    <?php endif; ?>

    <label>Username / Email</label>
    <input type="text" name="identity" placeholder="yourname@email.com" value="<?= htmlspecialchars($_POST['identity'] ?? '') ?>">

    <label>Password</label>
    <input type="password" name="password" placeholder="••••••••">

    <div class="row-between">
      <label class="check"><input type="checkbox"> <span>Remember me</span></label>
      <a class="link" href="#">Forgot your password?</a>
    </div>

    <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
    <button class="btn-primary w-100" type="submit">Login</button>

    <div class="divider">or</div>

    <button class="btn-ghost w-100" type="button" id="btn-google">
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg" 
       alt="" style="width:18px;vertical-align:middle;margin-right:8px;">
  Sign in with Google
</button>

<button class="btn-ghost w-100" type="button" id="btn-apple">
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/apple/apple-original.svg" 
       alt="" style="width:18px;vertical-align:middle;margin-right:8px;">
  Sign in with Apple
</button>

<script>
function simulateLogin(button, providerName){
  button.disabled = true;
  button.innerHTML = `<span style="display:inline-flex;align-items:center;gap:8px;">
                        <span class="spinner"></span> Connecting to ${providerName}...
                      </span>`;
  setTimeout(()=>{
    alert(`Connected with ${providerName}`);
    location.reload();
  },1500);
}

document.getElementById('btn-google').addEventListener('click', function(){
  simulateLogin(this,'Google');
});
document.getElementById('btn-apple').addEventListener('click', function(){
  simulateLogin(this,'Apple');
});
</script>

<style>
/* ปุ่มแบบ Google/Apple */
.btn-ghost {
  display:flex;
  align-items:center;
  justify-content:center;
  gap:8px;
  width:100%;
  border:1px solid #ddd;
  border-radius:8px;
  padding:10px 16px;
  font-weight:600;
  cursor:pointer;
  transition:.2s;
  background:#fff;
  color:#222;
  box-shadow:0 1px 3px rgba(0,0,0,.05);
}
.btn-ghost:hover{
  box-shadow:0 2px 8px rgba(0,0,0,.12);
  transform:translateY(-1px);
}
.btn-ghost.w-100 + .btn-ghost.w-100 {
  margin-top: 12px;   /* ปรับเป็น 8–16px ตามความเหมาะสม */
}
/* สปินเนอร์จำลองโหลด */
.spinner{
  width:14px;height:14px;
  border:2px solid #666;border-top-color:transparent;
  border-radius:50%;display:inline-block;
  animation:spin 1s linear infinite;
}
@keyframes spin{ to{ transform:rotate(360deg); } }
</style>

    

    <p class="muted center">Don’t have an account yet? <a class="link" href="register.php">Register</a></p>
  </form>
</div>
<?php include 'footer.php'; ?>