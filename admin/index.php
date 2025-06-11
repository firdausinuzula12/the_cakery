<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Produk - The Cakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            background-color: #FFEDFA;
            padding: 100px 20px 20px;
        }
       
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .product-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            text-align: center;
            padding: 15px;
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .product-card h3 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #AC1754;
        }
        .product-card p {
            font-size: 16px;
            color: #AC1754;
            margin-bottom: 10px;
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        .button-group a {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .restok-btn {
            background-color:#AC1754;
            color: white;
        }
        .edit-btn {
            background-color: #AC1754;
            color: white;
        }
        .restok-btn:hover {
            background-color: #AC1754;
        }
        .edit-btn:hover {
            background-color: #AC1754;
        }
    </style>
</head>

<body>
<?php include 'navmenu.php'; ?>
    <div class="product-grid">
        <?php
        // Query untuk mengambil data produk
        $query = "SELECT * FROM tb_produk";
        $result = mysqli_query($koneksi, $query);

        // Cek apakah ada produk
        if (mysqli_num_rows($result) > 0) {
            // Loop melalui data produk
            while ($data = mysqli_fetch_assoc($result)) {
                // Mengambil nama file gambar dari kolom 'gambar'
                $gambar = htmlspecialchars($data['gambar']);
                // Pastikan gambar ada di folder img/
                $gambar_path = "img/" . $gambar;

                // Menampilkan card produk
                echo "<div class='product-card'>";
                echo "<img src='".$gambar_path."' alt='".htmlspecialchars($data['nama_produk'])."'>";
                echo "<h3>".htmlspecialchars($data['nama_produk'])."</h3>";
                echo "<p>Rp ".number_format($data['harga'], 0, ',', '.')."</p>";
                echo "<div class='button-group'>
                        <a href='restok_produk.php?id=".htmlspecialchars($data['id'])."' class='restok-btn'>Restok</a>
                        <a href='edit_produk.php?id=".htmlspecialchars($data['id'])."' class='edit-btn'>Edit</a>
                      </div>";
                echo "</div>";
            }
        } else {
            echo "<p>Tidak ada produk tersedia.</p>";
        }
        ?>
    </div>

</body>
</html>
