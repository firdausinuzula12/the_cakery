<?php
// Mulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Hitung jumlah produk di keranjang
$jumlah_keranjang = 0;
if (isset($_SESSION['keranjang']) && is_array($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $item) {
        $jumlah_keranjang += isset($item['jumlah']) ? $item['jumlah'] : 1;
    }
}
?>

<!-- Link Font Awesome (untuk ikon) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Navbar HTML -->
<header>
  <div class="navbar-container">
    <div class="logo">
      <img src="img/logo_toko.png" alt="Logo Toko">
      <span>The Cakery</span>
    </div>

    <nav>
      <ul class="nav-links">
        <li><a href="home.php">Home</a></li>
        <li><a href="aboutUs.php">About Us</a></li>
        <li><a href="jenis_produk.php">Products</a></li>
        <li><a href="review_pelanggan.php">Review Pelanggan</a></li>
      </ul>
    </nav>

    <div class="nav-actions">
      <div class="search-box">
        <form action="home.php" method="get">
          <input type="text" name="cari" placeholder="Cari produk..." autocomplete="off">
          <button type="submit"><i class="fas fa-search"></i></button>
        </form>
      </div>
      <div id="cart">
        <a href="keranjang.php">
          <i class="fas fa-shopping-cart"></i>
          <span><?= $jumlah_keranjang ?></span>
        </a>
      </div>
    </div>
  </div>
</header>

<!-- Script Interaktif Search -->
<script>
    const searchIcon = document.getElementById('searchIcon');
    const searchInput = document.getElementById('searchInput');

    searchIcon.addEventListener('click', function(e) {
        if (searchInput.style.display === 'none' || searchInput.style.display === '') {
            e.preventDefault();
            searchInput.style.display = 'inline';
            searchInput.focus();
        }
    });
</script>

<!-- Style Navbar -->
<style>
/* Header */
header {
    background-color: #AC1754;
    display: flex;
    align-items: center;
    padding-top: 0px;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
}

header .logo {
    display: flex;
    align-items: center;
    margin-right: 160px;
}

.logo span {
    font-size: 40px;
    font-weight: bold;
    color: white;
    font-family: align-self start;
}

header .logo img {
    margin-right: 30px;
    height: auto;
    width: 100px;
}

/* Header wrapper */
.navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    padding: 0.5px 35px;
}

/* Logo */
.logo {
    display: flex;
    align-items: center;
}
.logo img {
    width: 80px;
    margin-right: 10px;
}
.logo span {
    font-size: 28px;
    font-weight: bold;
    color: white;
}

/* Nav links */
nav .nav-links {
    display: flex;
    gap: 20px;
    list-style: none;
}
nav .nav-links li a {
    color: white;
    text-decoration: none;
    font-size: 22px;
    padding: 2px 0;
    border-bottom: 10px solid transparent;
}
nav .nav-links li a:hover {
    border-bottom: 2px solid #ffd1dc;
    color: #ffd1dc;
}

/* Search and Cart */
.nav-actions {
    display: flex;
    align-items: center;
    gap: 20px;
}

.search-box form {
    display: flex;
    align-items: center;
    background-color: white;
    border-radius: 20px;
    padding: 3px 10px;
}
.search-box input {
    border: none;
    outline: none;
    padding: 3px 3px;
    font-size: 14px;
    border-radius: 20px;
    width: 140px;
}
.search-box button {
    background: none;
    border: none;
    cursor: pointer;
}
.search-box i {
    color: #AC1754;
}

/* Cart */
#cart {
    position: relative;
}
#cart i {
    font-size: 20px;
    color: white;
}
#cart span {
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
    font-weight: bold;
    position: absolute;
    top: -8px;
    right: -10px;
}

</style>
