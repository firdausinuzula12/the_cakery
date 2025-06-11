<?php
$koneksi = new mysqli("localhost", "root", "", "toko");

if (isset($_GET['id'])) {
    $id = $koneksi->real_escape_string($_GET['id']);
    $query = $koneksi->query("SELECT * FROM tb_pesanan WHERE id_pesanan='$id'");
    $pesanan = $query->fetch_assoc();

    if ($pesanan) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jumlah_uang = $_POST['jumlah_uang'];
            $total_harga = $pesanan['total_harga'];
            $metode_pembayaran = $pesanan['metode_pembayaran']; // PERBAIKAN: Ambil dari pesanan

            if ($jumlah_uang >= $total_harga) {
                $kembalian = $jumlah_uang - $total_harga;
                $status_pembayaran = 'Lunas';
                $tanggal_pembayaran = date('Y-m-d H:i:s');

                // Insert ke tb_pembayaran
                $sql_insert = "INSERT INTO tb_pembayaran 
                    (id_pesanan, metode_pembayaran, jumlah_bayar, kembalian, status_pembayaran, tanggal_pembayaran)
                    VALUES 
                    ('$id', '$metode_pembayaran', '$jumlah_uang', '$kembalian', '$status_pembayaran', NOW())";

                if ($koneksi->query($sql_insert)) {
                    header("Location: nota.php?id=$id");
                    exit();
                } else {
                    echo "<p>Terjadi kesalahan saat menyimpan pembayaran. Error: " . $koneksi->error . "</p>";
                }
            } else {
                $error = "Jumlah uang yang dibayar kurang dari total harga. Silakan periksa kembali.";
            }
        }
    } else {
        echo "<p>Pesanan tidak ditemukan.</p>";
        exit();
    }
} else {
    echo "<p>ID pesanan tidak ditemukan.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bayar Pesanan</title>
  <style>
    body { 
        font-family: Arial; 
        background: #f0f0f0; 
    }
    .container { 
        width: 45%; 
        margin: auto; 
        background: white; 
        padding: 83px; 
        margin-top: 75px; \\jarak dari atas 
        border-radius: 10px; 
    }
    h2 { 
        color: #AC1754; 
    }
    label, input[type=number], input[type=submit] { 
        display: block; 
        margin-top: 20px; 
        width: 100%; 
    }
    input[type=submit] { 
        background: #AC1754; 
        color: white; 
        border: none; 
        padding: 10px; 
        cursor: pointer; 
    }
    .error { 
        background: #fdd; 
        color: red; 
        padding: 10px; 
        margin-top: 10px; 
        border: 1px solid red; 
    }
  </style>
</head>
<body>
<div class="container">
  <h2>Pembayaran Tunai</h2>
  <p><strong>Nama:</strong> <?= htmlspecialchars($pesanan['nama_pelanggan']) ?></p>
  <p><strong>Produk:</strong> <?= htmlspecialchars($pesanan['nama_produk']) ?></p>
  <p><strong>Total Harga:</strong> Rp <?= number_format($pesanan['total_harga']) ?></p>

  <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

  <form action="bayar.php?id=<?= urlencode($pesanan['id_pesanan']) ?>" method="post">
    <input type="number" name="jumlah_uang" required min="<?= $pesanan['total_harga'] ?>" placeholder="Masukkan nominal uang dibayar">
    <input type="submit" value="Proses Pembayaran">
  </form>
</div>
</body>
</html>
