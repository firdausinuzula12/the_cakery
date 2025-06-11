<?php
include 'koneksi.php';

// Ambil semua data user
$query = "SELECT * FROM tb_users";
$result = mysqli_query($koneksi, $query);

// Hitung jumlah user
$jumlah_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_users"))['total'];
?>

<!DOCTYPE html>
<html lang="no_antrian">
<head>
    <meta charset="UTF-8">
    <title>Kelola User - The Cakery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background:  #FFEDFA; 
        }

        h1 { 
            text-align: center; 
            color: #AC1754; 
        }

        .user-info { 
            margin-bottom: 20px; 
            text-align: center; 
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
            background: white; 
        }

        th, td { 
            padding: 12px; 
            border: 1px solid #ddd; 
            text-align: center; 
        }

        th { 
            background: #AC1754; 
            color: white; 
        }

        tr:hover { 
            background: #f1f1f1; 
        }

        .btn-action { 
            padding: 5px 10px; 
            border-radius: 5px; 
            text-decoration: none; 
            color: white; 
        }
        .btn-edit { 
            background: #AC1754; 
        }

        .btn-delete { 
            background: #AC1754; 
        }

        .btn-action:hover { 
            opacity: 0.8; 
        }

    </style>
</head>

<body>
    <?php include 'navmenu.php'; ?>

    <h1>Kelola Data User</h1>
    
    <div class="user-info">
        <p>Total User: <strong><?php echo $jumlah_user; ?></strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No Antrian</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['no_antrian']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $row['no_antrian']; ?>" class="btn-action btn-edit"><i class="fas fa-edit"></i> Edit</a>
                    <a href="hapus_user.php?id=<?php echo $row['no_antrian']; ?>" class="btn-action btn-delete" onclick="return confirm('Yakin ingin hapus user ini?');"><i class="fas fa-trash"></i> Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>
