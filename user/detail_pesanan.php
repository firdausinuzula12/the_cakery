<?php 
session_start();
$koneksi = new mysqli("localhost", "root", "", "toko");

// Cek sesi dan data keranjang
if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    echo "Keranjang belanja kosong. Tidak bisa melanjutkan pesanan.";
    exit();
}

if (!isset($_SESSION['nama_pelanggan']) || !isset($_SESSION['no_antrian'])) {
    echo "Data pelanggan tidak lengkap.";
    exit();
}

// Ambil data dari session
$nama_pelanggan = $_SESSION['nama_pelanggan'];
$no_antrian = $_SESSION['no_antrian'];
$keranjang = $_SESSION['keranjang'];
$totalHarga = 0;
foreach ($keranjang as $item) {
    $totalHarga += $item['harga'] * $item['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - The Cakery</title>
    <style>
        body {
            font-family: 'Verdana', sans-serif;
            background-color: #f9f9f9;
            color: #880E4F;
            text-align: center;
            padding: 40px;
        }
        h1 {
            color: #AC1754;
            font-size: 36px;
            margin-bottom: 20px;
        }
        form {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            margin: auto;
            text-align: left;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            color: #AC1754;
            font-size: 18px;
            margin-bottom: 5px;
            display: block;
        }

        .form-group p {
            font-size: 18px;
            color: #444;
            margin-top: 5px;
        }

        .total-harga {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
            padding: 10px;
            background-color: #FFF1F1;
            border-radius: 5px;
            color: #AC1754;
            text-align: center;
        }

        .metode, .status {
            background-color: #FFF1F1;
            padding: 12px;
            margin-top: 20px;
            border-radius: 5px;
            font-weight: bold;
            color: #880E4F;
            text-align: center;
        }

        .btn-pesanan {
            background-color: #AC1754;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-pesanan:hover {
            background-color: #880E4F;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #AC1754;
            text-align: center;
        }

        th {
            background-color: #AC1754;
            color: white;
        }

        .btn-pesanan {
            margin-top: 20px;
            background-color: #AC1754;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .btn-pesanan:hover {
            background-color: #880E4F;
        }

        /* Responsif untuk mobile */
        @media (max-width: 768px) {
            form {
                width: 95%;
                padding: 20px;
            }

            table {
                width: 100%;
                font-size: 14px;
            }

            .total-harga, .metode, .status {
                font-size: 16px;
            }

            .btn-pesanan {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

    <h1>Detail Pesanan</h1>

    <form method="POST" action="proses_pesanan.php">
        <!-- Nama Pelanggan -->
        <div class="form-group">
            <label for="nama_pelanggan">Nama Pelanggan</label>
            <p id="nama_pelanggan"><?php echo $nama_pelanggan; ?></p>
        </div>

        <!-- No Antrian -->
        <div class="form-group">
            <label for="no_antrian">No Antrian</label>
            <p id="no_antrian"><?php echo $no_antrian; ?></p>
        </div>

        <!-- Metode Pembayaran -->
        <div class="metode">
            Metode Pembayaran: <strong>Tunai</strong>
        </div>

        <!-- Tabel Keranjang Belanja -->
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Tampilkan produk yang ada di keranjang
                foreach ($keranjang as $item) {
                    $subtotal = $item['harga'] * $item['jumlah'];
                    echo "<tr>
                            <td>{$item['nama']}</td>
                            <td>Rp " . number_format($item['harga'], 0, ',', '.') . "</td>
                            <td>{$item['jumlah']}</td>
                            <td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Total Harga -->
        <div class="total-harga">
            Total Harga: Rp <?php echo number_format($totalHarga, 0, ',', '.'); ?>
        </div>

        <!-- Tombol untuk Melanjutkan ke Pembayaran -->
        <input type="hidden" name="metode_pembayaran" value="Tunai">
        <button type="submit" class="btn-pesanan">Konfirmasi Pesanan</button>
    </form>

</body>
</html>
