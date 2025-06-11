<?php
include 'koneksi.php';

// Query untuk statistik
$jumlah_produk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_produk"))['total'];
$jumlah_pesanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_pesanan"))['total'];
$jumlah_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_users"))['total'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - The Cakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background: #FFEDFA; 
        }

        .header { 
            text-align: center; 
            margin-bottom: 30px; 
        }

        .cards { 
            display: flex; 
            justify-content: space-around; 
            flex-wrap: wrap; 
        }

        .card { 
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
            width: 250px; 
            margin: 10px; 
            text-align: center; 
        }

        .card h2 { 
            color: #AC1754; 
            font-size: 32px; 
        }

        .card p { 
            margin-top: 10px; 
            color: #555; 
        }

        .btn-nav { 
            background: #AC1754; 
            color: white; 
            padding: 10px 20px; 
            border-radius: 5px; 
            text-decoration: none; 
            margin-top: 20px; 
            display: inline-block; 
        }

        .btn-nav:hover { 
            background: #8a1243; 
        }
    </style>
</head>

<body>
    <?php include 'navmenu.php'; ?>

    <div class="header">
        <h1>Dashboard Admin</h1>
    </div>

    <div class="cards">
        <div class="card">
            <h2><?php echo $jumlah_produk; ?></h2>
            <p>Jumlah Produk</p>
        </div>
        <div class="card">
            <h2><?php echo $jumlah_pesanan; ?></h2>
            <p>Total Pesanan</p>
        </div>
        <div class="card">
            <h2><?php echo $jumlah_user; ?></h2>
            <p>Total User</p>
        </div>
    </div>

    <div style="text-align:center; margin-top:40px;">
        <a href="admin_laporan.php" class="btn-nav">Laporan</a>
    </div>

</body>
</html>

