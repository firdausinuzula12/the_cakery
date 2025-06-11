<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pesanan - The Cakery</title>
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
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #AC1754;
            color: white;
        }
        tr:hover {
            background-color: #f9d7e0;
        }
    </style>
</head>

<body>

<?php include 'navmenu.php'; ?>

<div style="margin-top: 30px;">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pemesan</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal Pesanan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM tb_pesanan"; // Pastikan tabel 'tb_pesanan' sudah ada
            $result = mysqli_query($koneksi, $query);
            $no = 1;

            if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$no++."</td>";
                    echo "<td>".htmlspecialchars($data['nama_pelanggan'])."</td>";
                    echo "<td>".htmlspecialchars($data['nama_produk'])."</td>";
                    echo "<td>".htmlspecialchars($data['jumlah'])."</td>";
                    echo "<td>Rp ".number_format($data['total_harga'], 0, ',', '.')."</td>";
                    echo "<td>".htmlspecialchars(date('d-m-Y', strtotime($data['tanggal_pemesanan'])))."</td>";
                    echo "<td>".htmlspecialchars($data['status_pesanan'])."</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' style='text-align:center;'>Belum ada pesanan</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
