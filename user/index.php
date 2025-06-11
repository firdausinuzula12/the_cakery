<?php
session_start(); // Memulai session

// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'toko';

$koneksi = new mysqli($host, $username, $password, $dbname);

unset($_SESSION['keranjang']); 

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil jumlah total antrian saat ini
$sql_count = "SELECT COUNT(*) AS total FROM tb_users";
$result = $koneksi->query($sql_count);
$row = $result->fetch_assoc();
$no_antrian = $row['total'] + 1; // urutan antrian
$id_pesanan = 'P' . str_pad($no_antrian, 4, '0', STR_PAD_LEFT);

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $koneksi->real_escape_string($_POST['nama_pelanggan']);
    $sql = "INSERT INTO tb_users (id_pesanan, nama_pelanggan, no_antrian) 
            VALUES ('$id_pesanan', '$nama', $no_antrian)";
            
    if ($koneksi->query($sql) === TRUE) {
        // Simpan data ke SESSION untuk digunakan di halaman lain
        $_SESSION['no_antrian'] = $no_antrian;
        $_SESSION['id_pesanan'] = $id_pesanan;
        $_SESSION['nama_pelanggan'] = $nama;

        // Redirect ke halaman berikutnya (misalnya home.php atau detail_pesanan.php)
        header('Location: home.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Cakery</title>
    <style>
        body {
            font-family: 'Verdana', sans-serif;
            background-image: url('img/Untitled design.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #880E4F;
            text-align: center;
            padding: 40px;
        }
        h1 {
            color: #AC1754;
            font-size: 36px;
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 250px;
            padding: 10px;
            margin: 15px 0;
            border: 2px solid #AC1754;
            border-radius: 5px;
            font-size: 16px;
        }
        .label-antrian {
            display: inline-block;
            margin: 20px 0;
            font-size: 24px;
            background: white;
            padding: 10px 20px;
            border: 2px solid #AC1754;
            border-radius: 5px;
            color: #880E4F;
        }
        button {
            background-color: #AC1754;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 15px;
        }
        button:hover {
            background-color: #880E4F;
        }
        img {
            width: 180px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- Logo -->
    <img src="img/logo_toko.png" alt="Logo Toko">

    <h1>THE CAKERY</h1>

    <!-- Form Input -->
    <form method="POST" action="">
        <input type="text" name="nama_pelanggan" placeholder="Masukkan Nama Anda" autocomplete="off" required>
        <br>
        <div class="label-antrian">
            <strong><?php echo $no_antrian; ?></strong>
        </div>
        <br>
        <button type="submit">Selanjutnya</button>
    </form>

</body>
</html>
