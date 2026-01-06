<?php
require 'config.php';
require 'functions.php';

$page_title = 'Order Successful | Football Store';
include 'header.php';
?>

<style>
/* ===============================
   Checkout Success Page Styling
   =============================== */
.success-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  height: 70vh;
  color: #fff;
}

.success-icon {
  font-size: 80px;
  color: #00d26a;
  margin-bottom: 20px;
  animation: pop 0.6s ease;
}

@keyframes pop {
  0% { transform: scale(0.5); opacity: 0; }
  100% { transform: scale(1); opacity: 1; }
}

.success-message {
  font-size: 1.8rem;
  font-weight: 700;
  margin-bottom: 10px;
}

.success-sub {
  font-size: 1rem;
  color: #ccc;
}

.back-note {
  margin-top: 25px;
  font-size: 0.95rem;
  color: #ffae42;
}

/* Optional loading dots */
.dots::after {
  content: " .";
  animation: dots 1.2s steps(5, end) infinite;
}

@keyframes dots {
  0%, 20% { color: rgba(255,255,255,0); text-shadow: .25em 0 0 rgba(255,255,255,0), .5em 0 0 rgba(255,255,255,0); }
  40% { color: #ff7a00; text-shadow: .25em 0 0 rgba(255,255,255,0), .5em 0 0 rgba(255,255,255,0); }
  60% { text-shadow: .25em 0 0 #ff7a00, .5em 0 0 rgba(255,255,255,0); }
  80%, 100% { text-shadow: .25em 0 0 #ff7a00, .5em 0 0 #ff7a00; }
}
</style>

<section class="success-container">
  <div class="success-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" id="Check--Streamline-Sharp" height="70" width="70">
  <desc>
    Check Streamline Icon: https://streamlinehq.com
  </desc>
  <g id="check--check-form-validation-checkmark-success-add-addition-tick">
    <path id="Vector 2356 (Stroke)" fill="#ffff" fill-rule="evenodd" d="M23.914 6.914 8.5 22.328 0.086 13.914l2.828 -2.828L8.5 16.672 21.086 4.086l2.828 2.828Z" clip-rule="evenodd" stroke-width="1"></path>
  </g>
</svg></div>
  <div class="success-message">Order placed successfully!</div>
  <div class="success-sub">Thank you for shopping with Football Store</div>
  <div class="back-note">
    Redirecting to Home<span class="dots"></span>
  </div>
</section>

<script>
// Redirect to home after 3 seconds
setTimeout(() => {
  window.location.href = 'index.php';
}, 3000);
</script>

<?php include 'footer.php'; ?>
