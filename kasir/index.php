<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "toko");

// Ambil semua pesanan dengan status 'Pending'
$pending = $koneksi->query("SELECT * FROM tb_pesanan WHERE status_pesanan='Pending'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kasir - Toko</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; }
        .container { width: 90%; margin: auto; }
        h2 { color: #AC1754; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #AC1754; color: white; }
        .btn-bayar { padding: 5px 10px; background:#AC1754; color: white; border: none; text-decoration: none; cursor: pointer; }
        .notif { background: red; color: white; padding: 10px; border-radius: 5px; margin-top: 10px; }
        .success { background: green; }
    </style>
</head>
<body>
<div class="container">
    <h2>Halaman Kasir</h2>

    <?php if (isset($_SESSION['sukses'])): ?>
        <div class="notif success"><strong>Sukses:</strong> <?= $_SESSION['sukses'] ?></div>
        <?php unset($_SESSION['sukses']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['gagal'])): ?>
        <div class="notif"><strong>Gagal:</strong> <?= $_SESSION['gagal'] ?></div>
        <?php unset($_SESSION['gagal']); ?>
    <?php endif; ?>

    <div class="notif">
        <strong>Notifikasi:</strong> Ada <?= $pending->num_rows ?> pesanan menunggu pembayaran.
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Produk</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        while ($row = $pending->fetch_assoc()) {
            echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama_pelanggan']}</td>
                <td>{$row['nama_produk']}</td>
                <td>Rp " . number_format($row['total_harga']) . "</td>
                <td>{$row['metode_pembayaran']}</td>
                <td>{$row['status_pesanan']}</td>
                <td>{$row['tanggal_pemesanan']}</td>
                <td><a href='bayar.php?id={$row['id_pesanan']}' class='btn-bayar'>Bayar</a></td>
            </tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
