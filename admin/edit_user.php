<?php
include 'koneksi.php';

// Cek apakah ada ID user
if (isset($_GET['id'])) {
    $no_antrian = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Ambil data user dari database
    $query = "SELECT * FROM tb_users WHERE no_antrian = '$no_antrian'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "User tidak ditemukan.";
        exit();
    }
} else {
    echo "ID user tidak ditemukan.";
    exit();
}

// Proses update user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    
    $update = "UPDATE tb_users SET nama_pelanggan='$nama_pelanggan' WHERE no_antrian='$no_antrian'";
    
    if (mysqli_query($koneksi, $update)) {
        echo "<script>alert('Data user berhasil diupdate!'); window.location.href='users_admin.php';</script>";
    } else {
        echo "Gagal mengupdate user.";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User - The Cakery</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f4f4f4; 
            padding: 50px; 
        }

        .form-container { 
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            width: 400px; 
            margin: auto; 
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1); 
        }

        h1 { 
            color: #AC1754; 
        }

        label { 
            display: block; 
            margin: 10px 0 5px; 
        }

        input[type="text"], input[type="email"], input[type="tel"] {
            width: 100%; 
            padding: 8px; 
            margin-bottom: 15px; 
            border: 1px solid #ccc; 
            border-radius: 4px;
        }

        .btn-submit {
            background: #AC1754; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            width: 100%;
            border-radius: 5px; 
            font-size: 16px; 
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #8b1244;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Edit User</h1>
    <form method="POST" action="">
        <label>Nama</label>
        <input type="text" name="nama_pelanggan" value="<?php echo htmlspecialchars($user['nama_pelanggan']); ?>" required>

        <button type="submit" class="btn-submit">Simpan Perubahan</button>
    </form>
</div>

</body>
</html>
