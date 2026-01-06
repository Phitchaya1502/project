<?php
require 'config.php';
require_once 'functions.php';
$page_title = 'Series Collections | Football Store';
include 'header.php';
?>


<section class="section container">
  <h2 class="section-title">Series Collections</h2>
  <p class="section-subtitle">Explore Exclusive Team Collections</p>

  <div class="feature-grid">
    <a class="feature-card" href="collection.php?team=FC%20Barcelona"> 
      <img src="https://static1.cdn-subsidesports.com/2/media/catalog/product/cache/abbf5437a995fd7cabd85bbbc7fdfb0f/b/0/b0fec5b3dfe55e23c200e7658644748bc996e4e88c75d2c1f24a93880fba8652.jpeg" alt="FC Barcelona">
      <div class="feature-label">FC Barcelona</div>
      <span class="feature-link">Shop Collection ›</span>
    </a>

    <a class="feature-card" href="collection.php?team=Liverpool%20FC">
      <img src="https://thumblr.uniid.it/product/397049/5d41c492abc4.jpg?width=1920&format=webp&q=75" alt="Liverpool FC">
      <div class="feature-label">Liverpool FC</div>
      <span class="feature-link">Shop Collection ›</span>
    </a>

    <a class="feature-card" href="collection.php?team=Chelsea%20FC">
      <img src="https://www.sollymsports.com/wp-content/uploads/2025/07/IMG_1221.webp" alt="Chelsea FC">
      <div class="feature-label">Chelsea FC</div>
      <span class="feature-link">Shop Collection ›</span>
    </a>

    <a class="feature-card" href="collection.php?team=Paris%20Saint-Germain">
      <img src="https://minio.yalispor.com.tr/yalispor/images/nike-psg-paris-saint-germain-2025-26-ic-saha-erkek-forma-3.jpg" alt="PSG">
      <div class="feature-label">Paris Saint-Germain</div>
      <span class="feature-link">Shop Collection ›</span>
    </a>
  </div>
</section>

<style>
.feature-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 30px;
  margin-top: 40px;
}

.feature-card {
  position: relative;
  overflow: hidden;
  border-radius: 16px;
  background: #111;
  color: white;
  transition: all 0.4s ease;
  cursor: pointer;
}

.feature-card img {
  width: 100%;
  height: 260px;
  object-fit: cover;
  opacity: 0.8;
  transition: all 0.4s ease;
}

.feature-card:hover img {
  transform: scale(1.08);
  opacity: 1;
}

.feature-label {
  position: absolute;
  bottom: 50px;
  left: 20px;
  font-size: 20px;
  font-weight: 700;
  text-transform: uppercase;
  line-height: 1.3;
}

.feature-link {
  position: absolute;
  bottom: 20px;
  left: 20px;
  font-size: 14px;
  color: #ff7a00;
  transition: all 0.3s ease;
}

.feature-card:hover .feature-link {
  transform: translateX(5px);
  color: #fff;
}
</style>

<?php include 'footer.php'; ?>
