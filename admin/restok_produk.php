<?php
include 'koneksi.php';

// Ambil produk berdasarkan id
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    $query = "SELECT * FROM tb_produk WHERE id = '$id_produk'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "Produk tidak ditemukan.";
        exit();
    }
} else {
    echo "ID produk tidak ditemukan.";
    exit();
}

// Tambah stok
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jumlah_restok'])) {
    $jumlah_restok = (int)$_POST['jumlah_restok'];

    if ($jumlah_restok > 0) {
        $stok_sekarang = (int)$data['stok'];
        $stok_baru = $stok_sekarang + $jumlah_restok;

        $update_query = "UPDATE tb_produk SET stok = $stok_baru WHERE id = '$id_produk'";
        if (mysqli_query($koneksi, $update_query)) {
            echo "<script>alert('Stok berhasil diperbarui!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui stok.');</script>";
        }
    } else {
        echo "<script>alert('Jumlah restok harus lebih dari 0.');</script>";
    }
}

// Hapus produk
if (isset($_POST['hapus_produk'])) {
    $delete_query = "DELETE FROM tb_produk WHERE id = '$id_produk'";
    if (mysqli_query($koneksi, $delete_query)) {
        echo "<script>alert('Produk berhasil dihapus!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus produk.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Produk - The Cakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            background-color: #FFEDFA;
            padding: 80px 20px 20px;
        }
        .container {
            background: white;
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        h1 {
            color: #2C3E50;
            margin-bottom: 20px;
            text-align: center;
        }
        .product-detail p {
            margin-bottom: 10px;
            font-size: 16px;
        }
        .product-detail img {
            max-width: 50%;
            height: auto;
            margin-bottom: 5px;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-top: 20px;
            font-weight: bold;
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn {
            background-color: #AC1754;
            color: white;
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            display: inline-block;
            width: 48%;
            text-align: center;
        }
        .btn:hover {
            background-color: #AC1754;
        }
        .btn-danger {
            background-color: #AC1754;
        }
        .btn-danger:hover {
            background-color: #AC1754;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 30px;
        }
    </style>
</head>

<body>

 <?php include 'navmenu.php'; ?>

<div class="container">
    <h1>Kelola Produk</h1>

    <div class="product-detail">
        <p><strong>Nama Produk:</strong> <?php echo htmlspecialchars($data['nama_produk']); ?></p>
        <p><strong>Harga:</strong> Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></p>
        <p><strong>Stok Sekarang:</strong> <?php echo htmlspecialchars($data['stok']); ?></p>
        <p><img src="img/<?php echo htmlspecialchars($data['gambar']); ?>" alt="Gambar Produk"></p>
    </div>

    <form action="" method="POST">
        <label for="jumlah_restok">Tambah Stok:</label>
        <input type="number" name="jumlah_restok" id="jumlah_restok" required min="1" placeholder="Masukkan jumlah stok">
        <div class="btn-container">
            <button type="submit" class="btn">Simpan Stok</button>
            <button type="submit" name="hapus_produk" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus Produk</button>
        </div>
    </form>
</div>

</body>
</html>
