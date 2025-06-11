<!-- hapus isi data nama_pelanggan : (2)DELETE FROM tb_users WHERE nama_pelanggan = ''; / 
        (1)UPDATE tb_users SET nama_pelanggan = ''; 
        DELETE FROM tb_users
WHERE no_antrian = 0 AND id_pesanan = 0 AND (nama_pelanggan = '' OR nama_pelanggan IS NULL);-->
        <?php
        
    include 'koneksi.php';
    //ambil data dari database
        $query ="select * from tb_produk";
        $cari = isset($_GET['cari']) ? $_GET['cari'] : '';
        $query = "SELECT * FROM tb_produk";
    if ($cari != '') {
        $query .= " WHERE nama_produk LIKE '%$cari%' OR deskripsi LIKE '%$cari%'";
    }
        $result = mysqli_query($koneksi, $query);


// Hitung jumlah item di keranjang
$jumlah_keranjang = 0;
if (isset($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $jumlah) {
        // Tapi kalau langsung angka, cukup seperti ini:
        if (is_array($item)) {
            $jumlah_keranjang += isset($item['qty']) ? $item['qty'] : 0;
        } else {
            $jumlah_keranjang += $item;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="The Cakery - Tempat terbaik untuk menikmati kue lezat dan segar.">
    <title>The Cakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body */
body {
    padding-top:80px;
    font-family: 'Arial', sans-serif;
    background-color: #FFEDFA;
    color: #333;
    line-height: 1.6;
    overflow-x: hidden; /* Prevent horizontal scrolling */
}
.cta-btn {
    background-color: #AC1754;
    color: white;
    padding: 15px 30px;
    font-size: 1.3em;
    text-decoration: none;
    border-radius: 50px;
    z-index: 1;
    transition: background-color 0.3s ease, transform 0.3s ease;
    opacity: 0;
    animation: fadeInUp 1s forwards 1.5s;
}

.cta-btn:hover {
    background-color: #AC1754; /* Slightly darker pink */
    transform: translateY(-5px); /* Hover effect */
}

/* Fade In Animation */
@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.category-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 50px; /*jarak antar kontainer */
  padding: 150px;
  margin: 16px;
}

.category-box {
  width: 150px;
  text-align: center;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  transition: transform 0.2s;
  background-color: white;
  cursor: pointer;
}

.category-box:hover {
  transform: scale(1.05);
}

.category-box img {
  width: 100%;
  height: 150px;
  object-fit: cover;
  display: block;
}

.category-box p {
  margin: 10px 0;
  font-weight: bold;
  color: #333;
  font-style:italic;
  text-decoration: none;
}

</style>
<body>
  <?php include 'navbar.php'; ?>

<div class="category-container">
  <a href="kategori_produk.php?kategori=Roti">
    <div class="category-box">
      <img src="img/bread.png" alt="roti">
      <p>Roti</p>
    </div>
  </a>
  <a href="kategori_produk.php?kategori=Donut">
    <div class="category-box">
      <img src="img/donut.png" alt="donat">
      <p>Donat</p>
    </div>
  </a>
  <a href="kategori_produk.php?kategori=Cake">
    <div class="category-box">
      <img src="img/cake.png" alt="cake">
      <p>Kue</p>
    </div>
  </a>
  <a href="kategori_produk.php?kategori=Cookies">
    <div class="category-box">
      <img src="img/cookies.png" alt="cookies">
      <p>kukis</p>
    </div>
  </a>
  <a href="kategori_produk.php?kategori=Pastry">
    <div class="category-box">
      <img src="img/pastry.png" alt="pastry">
      <p>Kue Kering</p>
    </div>
  </a>
</div>