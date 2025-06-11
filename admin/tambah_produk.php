<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];

    if ($gambar) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($gambar);

        if (move_uploaded_file($tmp_name, $target_file)) {
            $query = "INSERT INTO tb_produk (nama_produk, harga, stok, kategori, gambar, deskripsi) 
                      VALUES ('$nama_produk', '$harga', '$stok', '$kategori', '$gambar', '$deskripsi')";
            $result = mysqli_query($koneksi, $query);

            if ($result) {
                echo "<script>alert('Produk berhasil ditambahkan!'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Gagal menambahkan produk.');</script>";
            }
        } else {
            echo "<script>alert('Upload gambar gagal.');</script>";
        }
    } else {
        echo "<script>alert('Gambar wajib diupload.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk - The Cakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #FFEDFA;
            padding: 100px 20px 20px;
        }

        .form-container {
            max-width: 600px;
            background: white;
            margin: auto;
            margin-top: 30px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: #AC1754;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .form-group input[type="file"] {
            border: none;
        }

        .submit-btn {
            background-color: #AC1754;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #951346;
        }
    </style>
</head>
<body>

<?php include 'navmenu.php'; ?>

<div class="form-container">
    <h2>Tambah Produk Baru</h2>
    <form action="tambah_produk.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama_produk">Nama Produk</label>
            <input type="text" id="nama_produk" name="nama_produk" required>
        </div>
        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" id="harga" name="harga" required>
        </div>
        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" required>
        </div>
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Roti">Roti</option>
                <option value="Cake">Kue</option>
                <option value="Donut">Donat</option>
                <option value="Cookies">Kukis</option>
                <option value="Pastry">Kue Kering</option>
            </select>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="gambar">Upload Gambar</label>
            <input type="file" id="gambar" name="gambar" accept="image/*" required>
        </div>
        <button type="submit" class="submit-btn">Tambah Produk</button>
    </form>
</div>

</body>
</html>
