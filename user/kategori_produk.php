<?php

$koneksi = mysqli_connect("localhost", "root", "", "toko");

$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$query = "SELECT * FROM tb_produk WHERE kategori = '$kategori'";
$result = mysqli_query($koneksi, $query);


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kategori: <?= ucfirst($kategori) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFEDFA;
        }

        header {
            background-color: #AC1754;
            color: white;
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
        }

        .produk-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .produk-item {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s ease-in-out;
        }

        .produk-item:hover {
            transform: scale(1.03);
        }

        .produk-item img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .produk-info {
            padding: 15px;
            text-align: center;
        }

        .produk-info h3 {
            margin: 10px 0 5px;
            font-size: 18px;
            color: #333;
        }

        .produk-info p {
            color: #AC1754;
            font-weight: bold;
            font-size: 16px;
        }

        /* Styling untuk review */
        .reviews {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #ccc;
        }

        .review {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .review .rating {
            color: gold;
        }

        .review-form {
            margin-top: 20px;
        }

        .review-form textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .review-form select, .review-form button {
            padding: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<header>
    <h1>Kategori Produk : <?= ucfirst($kategori) ?></h1>
</header>

<div class="container">
    <div class="produk-grid">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <a href="detail_produk.php?id=<?= $row['id'] ?>" style="text-decoration: none; color: inherit;">
            <div class="produk-item">
                <img src="img/<?= $row['gambar'] ?>" alt="<?= $row['nama_produk'] ?>">
                <div class="produk-info">
                    <h3><?= $row['nama_produk'] ?></h3>
                    <p>Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
                    
                </div>
            </div>
        </a>

       
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>
