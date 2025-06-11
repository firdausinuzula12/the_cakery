<?php
session_start();

// Periksa jika sesi data sudah ada
if (!isset($_SESSION['keranjang'], $_SESSION['no_antrian'], $_SESSION['id_pesanan'], $_SESSION['nama_pelanggan'])) {
    echo "Data pesanan tidak lengkap. Silakan coba lagi.";
    exit();
}

// Ambil data dari session
$no_antrian = $_SESSION['no_antrian'];
$id_pesanan = $_SESSION['id_pesanan'];
$nama_pelanggan = $_SESSION['nama_pelanggan'];
$keranjang = $_SESSION['keranjang'];

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "toko");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Hitung total harga
$totalHarga = 0;
foreach ($keranjang as $item) {
    $totalHarga += $item['harga'] * $item['jumlah'];
}

// Metode pembayaran diambil dari form POST
$metode_pembayaran = isset($_POST['metode_pembayaran']) ? $_POST['metode_pembayaran'] : 'Tunai';

// Status pesanan
$status_pesanan = 'Pending';
$tanggal_pemesanan = date('Y-m-d H:i:s');

// Cek apakah pesanan sudah ada
$cek = $koneksi->query("SELECT id_pesanan FROM tb_pesanan WHERE id_pesanan = '$id_pesanan'");
if ($cek->num_rows > 0) {
    echo "Pesanan dengan ID ini sudah pernah disimpan.";
    exit();
}

// Gabungkan nama produk (jika ingin disimpan di tb_pesanan)
$nama_produk = "";
$jumlah_produk = 0;
foreach ($keranjang as $item) {
    $nama_produk .= $item['nama'] . ", ";
    $jumlah_produk += $item['jumlah'];
}
$nama_produk = rtrim($nama_produk, ", ");

// Simpan pesanan ke tb_pesanan
$sql_pesanan = $koneksi->prepare("INSERT INTO tb_pesanan 
    (id_pesanan, nama_produk, jumlah, nama_pelanggan, no_antrian, metode_pembayaran, total_harga, status_pesanan, tanggal_pemesanan) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$sql_pesanan->bind_param(
    "ssissssss", 
    $id_pesanan, 
    $nama_produk, 
    $jumlah_produk, 
    $nama_pelanggan, 
    $no_antrian, 
    $metode_pembayaran, 
    $totalHarga, 
    $status_pesanan, 
    $tanggal_pemesanan
);

if ($sql_pesanan->execute()) {
    echo "Pesanan berhasil disimpan!<br>";

    // Simpan detail pesanan dan kurangi stok
    foreach ($keranjang as $item) {
        $id = $item['id'];
        $nama_produk_item = $koneksi->real_escape_string($item['nama']);
        $harga = (double) $item['harga'];
        $jumlah = (int) $item['jumlah'];
        $subtotal = $harga * $jumlah;

        // Insert detail pesanan
        $sql_detail = $koneksi->prepare("INSERT INTO tb_detailpes 
            (id_pesanan, id, nama_produk, harga, jumlah, subtotal) 
            VALUES (?, ?, ?, ?, ?, ?)");
        $sql_detail->bind_param("sisiii", $id_pesanan, $id, $nama_produk_item, $harga, $jumlah, $subtotal);

        if ($sql_detail->execute()) {
            // Kurangi stok
            $sql_stok = $koneksi->prepare("UPDATE tb_produk SET stok = stok - ? WHERE id = ?");
            $sql_stok->bind_param("ii", $jumlah, $id);
            if (!$sql_stok->execute()) {
                echo "Gagal mengurangi stok: " . $koneksi->error;
                exit();
            }
        } else {
            echo "Gagal simpan detail: " . $koneksi->error;
            exit();
        }
    }

    // Bersihkan keranjang
    unset($_SESSION['keranjang']);

    // Tampilkan pesan sukses
    echo "<script>
            alert('Silakan tunggu pemanggilan untuk proses pembayaran.');
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 5000);
          </script>";
} else {
    echo "Gagal menyimpan pesanan: " . $koneksi->error;
}

$koneksi->close();
?>
