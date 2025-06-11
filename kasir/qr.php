<?php
// File ini hanya menampilkan QR Code yang sudah ada saja
// (tidak membuat file baru setiap kali).
// QR code review statis sudah dibuat sebelumnya.

if (!isset($_GET['id'])) {
    die("ID pesanan tidak ditemukan.");
}

// Ambil ID pesanan (opsional, hanya untuk validasi URL review)
$id_pesanan = $_GET['id'];

$url_review = "http://localhost/Toko_TheCakery/user/review.php";
 
// File QR Code statis (sudah tersedia di folder qrcodes)
$filename = "../kasir/qrcodes/qrcode.png";

// Tampilkan QR Code
echo "<h3>Scan QR untuk memberi review:</h3>";
echo "<img src='$filename' alt='QR Code Review'>";
?>
