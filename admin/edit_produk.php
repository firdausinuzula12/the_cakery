<?php
include 'koneksi.php';

// Cek apakah ada ID produk
if (!isset($_GET['id'])) {
    echo "ID produk tidak ditemukan.";
    exit;
}

$id_produk = $_GET['id'];

// Ambil data produk lama
$query = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE id = '$id_produk'");
if (mysqli_num_rows($query) == 0) {
    echo "Produk tidak ditemukan.";
    exit;
}
$produk = mysqli_fetch_assoc($query);

// Proses update produk
if (isset($_POST['update'])) {
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $harga = (int)$_POST['harga'];
    $stok = (int)$_POST['stok'];
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);

    // Cek apakah upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];

        // Simpan gambar ke folder uploads/
        move_uploaded_file($tmp, "uploads/" . $gambar);

        // Update dengan gambar baru
        $update = mysqli_query($koneksi, "UPDATE tb_produk SET 
            nama_produk = '$nama_produk', 
            deskripsi = '$deskripsi', 
            harga = $harga, 
            stok = $stok, 
            kategori = '$kategori', 
            gambar = '$gambar'
            WHERE id = '$id_produk'");
    } else {
        // Update tanpa mengganti gambar
        $update = mysqli_query($koneksi, "UPDATE tb_produk SET 
            nama_produk = '$nama_produk', 
            deskripsi = '$deskripsi', 
            harga = $harga, 
            stok = $stok, 
            kategori = '$kategori'
            WHERE id = '$id_produk'");
    }

    if ($update) {
        echo "<script>alert('Produk berhasil diupdate!'); window.location.href='index.php';</script>";
    } else {
        echo "Gagal update produk.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            margin: 0;
            padding: 0;
            background-color: #FFEDFA;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container { 
            width: 100%;
            max-width: 600px; 
            background: #fff; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
            text-align: left;
        }

        h2 {
            text-align: center;
            color: #AC1754;
            margin-bottom: 20px;
        }

        label { 
            display: block; 
            margin-top: 15px; 
            font-weight: bold;
            color: #AC1754;
            font-size: 14px;
        }

        input[type="text"], input[type="number"], textarea, input[type="file"] { 
            width: 100%; 
            padding: 10px; 
            margin-top: 8px; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            font-size: 14px;
            background-color: #f7f7f7;
        }

        textarea {
            resize: vertical;
        }

        button { 
            margin-top: 20px; 
            padding: 12px 24px; 
            background-color: #AC1754; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover { 
            background-color: #880E4F; 
        }

        small {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #888;
        }

        .form-container input[type="file"] {
            border: none;
            padding: 8px;
            background-color: transparent;
        }

        .form-container input[type="file"]:focus {
            outline: none;
            border: 1px solid #AC1754;
        }

        .form-container label[for="gambar"] {
            font-size: 14px;
        }

        /* Responsif untuk perangkat mobile */
        @media (max-width: 768px) {
            .form-container {
                padding: 15px;
                width: 90%;
            }
        }
    </style>
</head>
<body>
<?php include 'navmenu.php'; ?>

<div class="form-container">
    <h2>Edit Produk</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="nama_produk">Nama Produk</label>
        <input type="text" name="nama_produk" id="nama_produk" value="<?php echo htmlspecialchars($produk['nama_produk']); ?>" required>

        <label for="deskripsi">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" rows="4" required><?php echo htmlspecialchars($produk['deskripsi']); ?></textarea>

        <label for="harga">Harga</label>
        <input type="number" name="harga" id="harga" value="<?php echo $produk['harga']; ?>" required>

        <label for="stok">Stok</label>
        <input type="number" name="stok" id="stok" value="<?php echo $produk['stok']; ?>" required>

        <label for="kategori">Kategori</label>
        <input type="text" name="kategori" id="kategori" value="<?php echo htmlspecialchars($produk['kategori']); ?>" required>

        <label for="gambar">Gambar Produk (opsional)</label>
        <input type="file" name="gambar" id="gambar">

        <br><small>Gambar saat ini: <?php echo $produk['gambar']; ?></small>

        <button type="submit" name="update">Update Produk</button>
    </form>
</div>

</body>
</html>
