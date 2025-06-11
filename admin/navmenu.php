
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
        header {
            background-color: #AC1754;
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
            color:rgb(243, 233, 237);
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">
            <img src="img/logo_toko.png" alt="Logo Toko">
            <span>The Cakery Admin</span>
        </div>
        <nav>
            <ul>
                <li><a href="dashboard_admin.php">Dashboard</a></li>
                <li><a href="tambah_produk.php">Tambah Produk</a></li>
                <li><a href="index.php">Data Produk</a></li>
                <li><a href="admin_pesanan.php">Data Pesanan</a></li>
                <li><a href="users_admin.php">Data User</a></li>
                <li><a href="logout.php" onclick="return confirm('Yakin mau logout?')">Logout</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
