<!-- (1)UPDATE tb_users SET nama_pelanggan = '';
    (2)DELETE FROM tb_users WHERE nama_pelanggan = '';  -->
    
<?php
session_start();
include 'koneksi.php';

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$query = "SELECT * FROM tb_produk";
if ($cari != '') {
    $query .= " WHERE nama_produk LIKE '%$cari%' OR deskripsi LIKE '%$cari%'";
}
$result = mysqli_query($koneksi, $query);

$jumlah_keranjang = 0;
if (isset($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $item) {
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
    background-color: #f8f8f8;
    color: #333;
    line-height: 1.6;
    overflow-x: hidden; /* Prevent horizontal scrolling */
}

/* Hero Section with Parallax Effect */
.hero {
    background: url('hero.jpg') no-repeat center center/cover;
    color:white;
    text-align: center;
    padding: 170px 30px;
    position: relative;
    z-index: 1;
    overflow: hidden;
}

.hero::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4); /* Dark overlay */
    z-index: -1;
}

.hero h1 {
    font-size: 4em;
    margin-bottom: 20px;
    z-index: 1;
    letter-spacing: 3px;
    opacity: 0;
    transform: translateY(50px);
    animation: fadeInUp 1s forwards 0.5s;
}

.hero p {
    font-size: 1.5em;
    margin-bottom: 40px;
    z-index: 1;
    opacity: 0;
    transform: translateY(50px);
    animation: fadeInUp 1s forwards 1s;
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

</style>
<body>
    <?php include 'navbar.php'; ?>


    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Selamat datang di The Cakery</h1>
            <p>Tempat terbaik untuk menikmati kue lezat, segar, dan dibuat dengan cinta.</p>
            <a href="jenis_produk.php" class="cta-btn">Lihat Produk Kami</a>
        </div>
    </section>

   