<?php
session_start();

// Ambil dari URL
$id_pesanan = isset($_GET['id_pesanan']) ? $_GET['id_pesanan'] : null;
$no_antrian = isset($_GET['no_antrian']) ? $_GET['no_antrian'] : '';
$nama_pelanggan = isset($_SESSION['nama_pelanggan']) ? $_SESSION['nama_pelanggan'] : '';

// Validasi ID Pesanan
if (!$id_pesanan) {
    echo "ID Pesanan tidak ditemukan.";
    exit;
}

// Koneksi database
$koneksi = new mysqli("localhost", "root", "", "toko");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil detail pesanan dari tb_detailpes
$sql_detail = "SELECT id, jumlah, harga, subtotal FROM tb_detailpes WHERE id_pesanan = ?";
$stmt = $koneksi->prepare($sql_detail);
if (!$stmt) {
    die("Prepare failed: " . $koneksi->error);
}
$stmt->bind_param("s", $id_pesanan);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $total += $row['subtotal'];
}

// Buat QR code
$qr_folder = "qrcodes";
if (!is_dir($qr_folder)) {
    mkdir($qr_folder, 0777, true);
}

require_once("lib/phpqrcode/qrlib.php");
$qr_path = "$qr_folder/qrcode.png"; // Ganti ke nama tetap
$url_review = "http://localhost/Toko_TheCakery/review.php?id_pesanan=" . urlencode($id_pesanan);

// Hapus QR lama jika ada, supaya tidak cache salah ID
if (file_exists($qr_path)) {
    unlink($qr_path);
}

QRcode::png($url_review, $qr_path, 'L', 4, 2);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Nota</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
            background: #fff;
            color: #000;
        }
        h2, p {
            text-align: center;
            margin: 2px 0;
        }
        hr {
            border: 1px dashed #000;
            margin: 10px 0;
        }
        table {
            width: 100%;
            font-size: 12px;
            border-collapse: collapse;
        }
        th, td {
            padding: 4px 0;
            text-align: left;
        }
        .right {
            text-align: right;
        }
        .center {
            text-align: center;
        }
        .total {
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
        }
        .btn-print {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            font-size: 16px;
            background: #AC1754;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        @media print {
            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<h2>The Cakery</h2>
<p>Jl. Roti Manis No.123, Anggrek</p>
<p>Telp: 021-5678-9876</p>
<hr>

<p>ID Pesanan : <strong><?= htmlspecialchars($id_pesanan) ?></strong></p>
<?php if ($no_antrian): ?>
<p>No. Antrian: <strong><?= htmlspecialchars($no_antrian) ?></strong></p>
<?php endif; ?>
<?php if ($nama_pelanggan): ?>
<p>Pelanggan: <?= htmlspecialchars($nama_pelanggan) ?></p>
<?php endif; ?>
<p>Tanggal: <?= date('d/m/Y H:i') ?></p>

<hr>

<table>
<thead>
<tr>
    <th>Item</th>
    <th class="right">Subtotal</th>
</tr>
</thead>
<tbody>
<?php foreach ($items as $item): ?>
<tr>
    <td>
       Produk: <?= htmlspecialchars($item['id']) ?><br>
       <small><?= $item['jumlah'] ?> x Rp<?= number_format($item['harga'], 0, ',', '.') ?></small> 
    </td>
    <td class="right">
       Rp<?= number_format($item['subtotal'], 0, ',', '.') ?>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<hr>
<p class="total right">Total: Rp<?= number_format($total, 0, ',', '.') ?></p>

<hr>
<p class="center"><strong>Silakan bayar ke kasir</strong></p>
<p class="center">-- Terima Kasih --</p>


<?php if (file_exists($qr_path)): ?>
<div class="center">
    <p>Scan untuk beri review:</p>
    <img src="<?= $qr_path ?>" alt="QR Code Review" style="width:120px; margin: 10px auto;">
</div>
<?php endif; ?>

<button class="btn-print" onclick="window.print()">Cetak Nota</button>

<script>
    document.querySelector('.btn-print').addEventListener('click', function() {
        setTimeout(function() {
            window.location.href = "index.php";
        }, 5000);
    });
</script>

</body>
</html>
