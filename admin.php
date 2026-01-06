<?php
require 'config.php';
require 'functions.php';
$page_title = 'Admin | Football Store';
include 'header.php';
?>

<section class="section container">
  <h2 class="section-title">Quick Admin</h2>
  <p class="section-subtitle">DATA • MANAGEMENT • REPORTS</p>

  <div class="admin-grid">
    <div class="admin-card">
      <div class="admin-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="27" width="27">
  <g id="edit">
    <path id="Union" fill="#ffff" d="M15.0859 3.00024c0.7811 -0.78094 2.0471 -0.78094 2.8282 0L21 6.08618c0.7808 0.78104 0.7809 2.04714 0 2.82813L8.20703 21.7073c-0.18752 0.1874 -0.44187 0.2929 -0.70703 0.2929H3c-0.55221 0 -0.99988 -0.4478 -1 -1v-4.5l0.00488 -0.0986c0.02269 -0.2289 0.12401 -0.4443 0.28809 -0.6084zM4 16.9143v3.0859h3.08594l9.20706 -9.207 -3.086 -3.08592z" stroke-width="1"></path>
  </g>
</svg></div>
      <h4>Management</h4>
      <p>Add Data / Edit / Delete product list</p>
      <a href="admin_products.php">Go to page ›</a>
    </div>

    <div class="admin-card">
      <div class="admin-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="#ffff" class="bi bi-clipboard2-data" viewBox="0 0 16 16" id="Clipboard2-Data--Streamline-Bootstrap" height="26" width="26">
  <desc>
    Clipboard2 Data Streamline Icon: https://streamlinehq.com
  </desc>
  <path d="M9.5 0a0.5 0.5 0 0 1 0.5 0.5 0.5 0.5 0 0 0 0.5 0.5 0.5 0.5 0 0 1 0.5 0.5V2a0.5 0.5 0 0 1 -0.5 0.5h-5A0.5 0.5 0 0 1 5 2v-0.5a0.5 0.5 0 0 1 0.5 -0.5 0.5 0.5 0 0 0 0.5 -0.5 0.5 0.5 0 0 1 0.5 -0.5z" stroke-width="1"></path>
  <path d="M3 2.5a0.5 0.5 0 0 1 0.5 -0.5H4a0.5 0.5 0 0 0 0 -1h-0.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5 -1.5v-12A1.5 1.5 0 0 0 12.5 1H12a0.5 0.5 0 0 0 0 1h0.5a0.5 0.5 0 0 1 0.5 0.5v12a0.5 0.5 0 0 1 -0.5 0.5h-9a0.5 0.5 0 0 1 -0.5 -0.5z" stroke-width="1"></path>
  <path d="M10 7a1 1 0 1 1 2 0v5a1 1 0 1 1 -2 0zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1 -2 0zm4 -3a1 1 0 0 0 -1 1v3a1 1 0 1 0 2 0V9a1 1 0 0 0 -1 -1" stroke-width="1"></path>
</svg></div>
      <h4>Reports Sales</h4>
      <p>View Sales Summary and Top Items</p>
      <a href="admin_reports_sales.php">Go to page ›</a>
    </div>

    <div class="admin-card">
      <div class="admin-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14" id="Archive-Box--Streamline-Core" height="25" width="25">
  <desc>
    Archive Box Streamline Icon: https://streamlinehq.com
  </desc>
  <g id="archive-box--box-content-banker-archive-file">
    <path id="Subtract" fill="#ffff" fill-rule="evenodd" d="M0 2C0 1.17157 0.671573 0.5 1.5 0.5h11c0.8284 0 1.5 0.67157 1.5 1.5v1.5c0 0.82843 -0.6716 1.5 -1.5 1.5h-11C0.671573 5 0 4.32843 0 3.5V2Zm13 4.25H1V12c0 0.8284 0.67157 1.5 1.5 1.5h9c0.8284 0 1.5 -0.6716 1.5 -1.5V6.25ZM5.5 7.875c-0.34518 0 -0.625 0.27982 -0.625 0.625s0.27982 0.625 0.625 0.625h3c0.34518 0 0.625 -0.27982 0.625 -0.625s-0.27982 -0.625 -0.625 -0.625h-3Z" clip-rule="evenodd" stroke-width="1"></path>
  </g>
</svg></div>
      <h4>Reports Stock</h4>
      <p>Check Inventory by Category</p>
      <a href="admin_reports_stock.php">Go to page ›</a>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
