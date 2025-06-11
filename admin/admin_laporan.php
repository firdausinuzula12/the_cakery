<?php
include 'koneksi.php';

// Query default (stok descending)
$query = "
    SELECT 
        tb_produk.id,
        tb_produk.nama_produk,
        tb_produk.harga,
        tb_produk.stok,
        COALESCE(SUM(tb_detailpes.jumlah), 0) AS total_terjual
    FROM 
        tb_produk
    LEFT JOIN 
        tb_detailpes 
    ON 
        tb_produk.nama_produk = tb_detailpes.nama_produk
    GROUP BY 
        tb_produk.id, tb_produk.nama_produk, tb_produk.harga, tb_produk.stok
";

// Filter
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];

    if ($filter === 'stok_terbanyak') {
        $query .= " ORDER BY tb_produk.stok DESC";
    } elseif ($filter === 'stok_tersedikit') {
        $query .= " ORDER BY tb_produk.stok ASC";
    } elseif ($filter === 'banyak_dibeli') {
        $query .= " ORDER BY total_terjual DESC";
    }
}

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Produk - The Cakery</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    body {
        background-color: #FFEDFA;
        padding: 20px;
        font-family: 'Arial', sans-serif;
    }
    h1 {
        text-align: center;
        color: #AC1754;
        margin-bottom: 20px;
    }
    .button-group {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 20px;
    }
    .button-group a {
        text-decoration: none;
        background-color: #AC1754;
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s;
    }
    .button-group a:hover {
        background-color: #8B1244;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    th, td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }
    th {
        background-color: #AC1754;
        color: white;
    }
    tr:hover {
        background-color: #f2f2f2;
    }
    .no-data {
        text-align: center;
        font-style: italic;
        color: gray;
    }
</style>
</head>
<body>

<?php include 'navmenu.php'; ?>

<h1>Laporan Produk</h1>

<div class="button-group">
    <a href="admin_laporan.php?filter=stok_terbanyak">Stok Terbanyak</a>
    <a href="admin_laporan.php?filter=stok_tersedikit">Stok Tersedikit</a>
    <a href="admin_laporan.php?filter=banyak_dibeli">Produk Banyak Dibeli</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID Produk</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Terjual</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".htmlspecialchars($data['id'])."</td>";
                echo "<td>".htmlspecialchars($data['nama_produk'])."</td>";
                echo "<td>Rp ".number_format($data['harga'], 0, ',', '.')."</td>";
                echo "<td>".htmlspecialchars($data['stok'])."</td>";
                echo "<td>".htmlspecialchars($data['total_terjual'])."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='no-data'>Tidak ada data produk tersedia.</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
