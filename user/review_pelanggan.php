<?php
// Koneksi database
$koneksi = new mysqli("localhost", "root", "", "toko");

// Ambil semua review dari tabel tb_review
$query = "SELECT * FROM tb_review ORDER BY waktu_review DESC";
$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Review Pelanggan | The Cakery</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #FFEDFA;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #b1004b;
            color: white;
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin: 0;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .review {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }

        .review:last-child {
            border-bottom: none;
        }

        .review .nama {
            font-weight: bold;
            color: #333;
        }

        .review .rating {
            color: #f39c12;
            font-size: 18px;
        }

        .review .komentar {
            margin: 5px 0;
        }

        .review .waktu {
            font-size: 12px;
            color: gray;
        }

        .btn-ulasan {
            display: inline-block;
            background-color: #b1004b;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 25px;
            margin-bottom: 20px;
            transition: background 0.3s;
        }

        .btn-ulasan:hover {
            background-color: #92003e;
        }

        .no-review {
            text-align: center;
            color: #666;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<header>
    <h1>Review Pelanggan</h1>
    <p>Lihat apa kata mereka tentang produk The Cakery!</p>
</header>

<div class="container">
    <a href="review.php" class="btn-ulasan">+ Beri Ulasan</a>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="review">
                <div class="nama"><?= htmlspecialchars($row['nama_pelanggan']) ?> (<?= $row['id_pesanan'] ?>)</div>
                <div class="rating">
                    <?php for ($i = 0; $i < $row['rating']; $i++) echo "⭐"; ?>
                </div>
                <div class="komentar"><?= htmlspecialchars($row['komentar']) ?></div>
                <div class="waktu">🕒 <?= date("d M Y, H:i", strtotime($row['waktu_review'])) ?></div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="no-review">Belum ada ulasan pelanggan untuk saat ini.</p>
    <?php endif; ?>
</div>

</body>
</html>
