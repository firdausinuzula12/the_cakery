<?php
session_start();

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['keranjang']) || !is_array($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Proses tambah produk ke keranjang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['nama'], $_POST['harga'], $_POST['jumlah'], $_POST['gambar'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = (int)$_POST['harga'];
    $jumlah = (int)$_POST['jumlah'];
    $gambar = $_POST['gambar'];

    // Cari apakah produk sudah ada di keranjang
    $produkSudahAda = false;
    foreach ($_SESSION['keranjang'] as &$item) {
        if ($item['id'] == $id) {
            $item['jumlah'] += $jumlah;
            $produkSudahAda = true;
            break;
        }
    }
    unset($item); // Lepaskan referensi

    // Kalau belum ada, tambahkan produk baru
    if (!$produkSudahAda) {
        $_SESSION['keranjang'][] = [
            'id' => $id,
            'nama' => $nama,
            'harga' => $harga,
            'jumlah' => $jumlah,
            'gambar' => $gambar
        ];
    }
}

// Hitung total item untuk badge keranjang
$totalItem = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $totalItem += isset($item['jumlah']) ? (int)$item['jumlah'] : 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFEDFA;
            color: #333;
        }
        .cart-icon {
            position: relative;
            font-size: 24px;
            cursor: pointer;
        }
        .cart-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: yellowgreen;
            color: #fff;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: bold;
        }
        .container {
            max-width: 960px;
            margin: 150px auto;
            padding: 24px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 30px;
            color: #444;
        }
        .cart-item {
            display: flex;
            align-items: center;
            padding: 16px;
            border-bottom: 1px solid #ddd;
        }
        .cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 16px;
        }
        .cart-details {
            flex-grow: 1;
        }
        .cart-details h4 {
            margin: 0;
            font-size: 18px;
        }
        .cart-details p {
            margin: 4px 0;
        }
        .btn-hapus {
            padding: 6px 12px;
            background-color: #AC1754;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
        }
        .btn-hapus:hover {
            background-color: #9c1248;
        }
        .total-row {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #AC1754;
            margin-top: 20px;
        }
        .btn-tambah {
            display: inline-block;
            padding: 10px 20px;
            background-color: #AC1754;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            margin-right: 10px;
        }
        .btn-tambah:hover {
            background-color: #9c1248;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <h2>Keranjang Belanja Anda</h2>

    <?php if (empty($_SESSION['keranjang'])): ?>
        <p style="text-align:center;">Keranjang masih kosong.</p>
    <?php else: ?>
        <?php
        $totalHarga = 0;
        foreach ($_SESSION['keranjang'] as $item):
            $id = htmlspecialchars($item['id']);
            $nama = htmlspecialchars($item['nama']);
            $harga = (int)$item['harga'];
            $jumlah = (int)$item['jumlah'];
            $gambar = !empty($item['gambar']) ? $item['gambar'] : 'default.jpeg';
            $subtotal = $harga * $jumlah;
            $totalHarga += $subtotal;
        ?>
        <div class="cart-item">
            <img src="img/<?php echo htmlspecialchars($gambar); ?>" alt="<?php echo $nama; ?>">
            <div class="cart-details">
                <h4><?php echo $nama; ?></h4>
                <p>Harga: Rp<?php echo number_format($harga, 0, ',', '.'); ?></p>
                <p>Jumlah: <?php echo $jumlah; ?></p>
                <p>Subtotal: Rp<?php echo number_format($subtotal, 0, ',', '.'); ?></p>
            </div>
            <form method="post" action="hapus.php">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="submit" class="btn-hapus">Hapus</button>
            </form>
        </div>
        <?php endforeach; ?>

        <div class="total-row">
            Total Keseluruhan: Rp<?php echo number_format($totalHarga, 0, ',', '.'); ?>
        </div>

        <div style="margin-top: 20px;">
            <a href="jenis_produk.php" class="btn-tambah">+ Tambah Produk</a>
            <a href="detail_pesanan.php" class="btn-tambah">Buat Pesanan</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
