<?php
include 'koneksi.php';

// Cek session admin (opsional, kalau perlu security)
// session_start();
// if (!isset($_SESSION['admin'])) {
//     header('Location: login.php');
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - The Cakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            background-color: #f4f6f8;
            padding-top: 80px; /* Biar tidak ketutup navbar */
        }
        header {
            background-color: #2C3E50;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 50px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .logo {
            display: flex;
            align-items: center;
        }
        .logo img {
            height: 40px;
            margin-right: 10px;
        }
        .logo span {
            font-size: 22px;
            font-weight: bold;
        }
        nav ul {
            list-style: none;
            display: flex;
            align-items: center;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: color 0.3s;
        }
        nav ul li a:hover {
            color: #18BC9C;
        }
        .container {
            margin: 30px auto;
            padding: 20px;
            max-width: 1200px;
            background: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            border-radius: 8px;
        }
        h1 {
            margin-bottom: 20px;
            color: #2C3E50;
        }
    </style>
</head>

<body>

    <!-- Header Admin -->
    <header>
        <div class="logo">
            <img src="img/logo_toko.png" alt="Logo Toko">
            <span>The Cakery Admin</span>
        </div>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="index.php">Data Produk</a></li>
                <li><a href="admin_pesanan.php">Data Pesanan</a></li>
                <li><a href="admin_users.php">Data User</a></li>
                <li><a href="logout.php" onclick="return confirm('Yakin mau logout?')">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Konten Admin -->
    <div class="container">
        <h1>Selamat Datang di Admin Panel</h1>
        <p>Gunakan menu di atas untuk mengelola data produk, pesanan, dan pengguna.</p>
        
        <!-- Contoh: Menampilkan data produk dari database -->
        <?php
        $query = "SELECT * FROM tb_produk";
        $result = mysqli_query($koneksi, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1' cellpadding='10' cellspacing='0' width='100%'>";
            echo "<tr style='background:#18BC9C;color:white;'>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                  </tr>";
            $no = 1;
            while ($data = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>".$no++."</td>
                        <td>".$data['nama_produk']."</td>
                        <td>".$data['deskripsi']."</td>
                        <td>Rp ".number_format($data['harga'])."</td>
                        <td>
                            <a href='edit_produk.php?id=".$data['id_produk']."' style='color:blue;'>Edit</a> | 
                            <a href='hapus_produk.php?id=".$data['id_produk']."' style='color:red;' onclick='return confirm(\"Yakin hapus produk?\")'>Hapus</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Tidak ada data produk.</p>";
        }
        ?>
    </div>

</body>
</html>
