<?php
$koneksi = new mysqli("localhost", "root", "", "toko");

// Pastikan parameter id_pesanan dikirim
if (!isset($_GET['id'])) {
    die("ID pesanan tidak ditemukan.");
}

$id_pesanan = mysqli_real_escape_string($koneksi, $_GET['id']);

// Ambil data pesanan
$data_pesanan = mysqli_fetch_assoc($koneksi->query("SELECT * FROM tb_pesanan WHERE id_pesanan='$id_pesanan'"));

// Ambil data pembayaran
$data_bayar = mysqli_fetch_assoc($koneksi->query("SELECT * FROM tb_pembayaran WHERE id_pesanan='$id_pesanan'"));

// Ambil detail item pesanan
$items = $koneksi->query("SELECT * FROM tb_detailpes WHERE id_pesanan='$id_pesanan'");

// Update status pesanan menjadi 'Lunas'
$koneksi->query("UPDATE tb_pesanan SET status_pesanan='Lunas' WHERE id_pesanan='$id_pesanan'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Pembayaran</title>
    <style>
        /* === CSS UNTUK NOTA PEMBAYARAN === */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
        }

        .nota-container {
            max-width: 300px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .nota-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .nota-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .nota-header small {
            font-size: 12px;
            color: #777;
        }

        .nota-line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .nota-table {
            width: 100%;
        }

        .nota-table td {
            padding: 3px 0;
        }

        .nota-table td:first-child {
            font-weight: bold;
        }

        .nota-footer {
            margin-top: 10px;
        }

        .nota-footer .row {
    display: flex;
    justify-content: space-between;
    padding: 2px 0;
}

.nota-footer .row .label {
    text-align: left;
    flex: 1;
}

.nota-footer .row .value {
    text-align: right;
    flex: 0 0 auto;
    padding-left: 10px;
}


        .center {
            text-align: center;
        }

        .btn-print {
            display: block;
            margin: 20px auto 0;
            padding: 6px 12px;
            font-size: 14px;
            background-color: #AC1754;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn-print:hover {
            background-color: #AC1754;
        }

        @media print {
            .btn-print {
                display: none;
            }
            body {
                margin: 0;
            }
            .nota-container {
                border: none;
                border-radius: 0;
                box-shadow: none;
                padding: 0;
            }
        }
        /* === AKHIR CSS UNTUK NOTA PEMBAYARAN === */
    </style>
</head>
<body>
    <div class="nota-container">
        <!-- Header Nota -->
        <div class="nota-header">
            <h3>TOKO THECAKERY</h3>
            <small>Jl. Anggrek No.123, Telp. 0812-3456-7890</small>
        </div>

        <!-- Garis Pembatas -->
        <div class="nota-line"></div>

        <!-- Informasi Pesanan -->
        <p>ID: <?= $data_pesanan['id_pesanan'] ?><br>
           Tgl: <?= date('d-m-Y H:i', strtotime($data_bayar['tanggal_pembayaran'])) ?></p>

        <!-- Detail Pesanan -->
        <div class="nota-line"></div>
        <table class="nota-table">
            <?php while ($row = mysqli_fetch_assoc($items)): ?>
            <tr>
                <td><?= $row['nama_produk'] ?> x<?= $row['jumlah'] ?></td>
                <td style="text-align:right;">Rp <?= number_format($row['subtotal'], 0, ',', '.') ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <!-- Total, Dibayar, Kembalian -->
        <div class="nota-line"></div>
        <div class="nota-footer">
            <div class="row">
                <div class="label">Total</div>
                <div class="value">Rp <?= number_format($data_pesanan['total_harga'], 0, ',', '.') ?></div>
            </div>
            <div class="row">
                <div class="label">Dibayar</div>
                <div class="value">Rp <?= number_format($data_bayar['jumlah_bayar'], 0, ',', '.') ?></div>
            </div>
            <div class="row">
                <div class="label">Kembalian</div>
                <div class="value">Rp <?= number_format($data_bayar['kembalian'], 0, ',', '.') ?></div>
            </div>
        </div>

        <!-- Garis Pembatas -->
        <div class="nota-line"></div>

        <!-- Pesan Terima Kasih -->
        <p class="center"><strong>Terima kasih atas pembayaran Anda!</strong></p>

        <!-- QR Code Review -->
        <div class="center">
            <p>Scan untuk beri review:</p>
            <img src="../kasir/qrcodes/qrcode.png" alt="QR Code Review">
        </div>

        <!-- Tombol Cetak Nota -->
        <button class="btn-print" onclick="window.print()">Cetak Nota</button>
    </div>

    <script>
    document.querySelector('.btn-print').addEventListener('click', function() {
        setTimeout(function() {
            window.location.href = "index.php";
        }, 3000);
    });
    </script>
</body>
</html>
