<?php
session_start();

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "toko");

// Ambil ID produk dari URL
$id = intval($_GET['id']);

// Query untuk ambil detail produk berdasarkan ID
$query = $koneksi->query("SELECT * FROM tb_produk WHERE id = $id");
$produk = $query->fetch_assoc();

// Kalau produk tidak ditemukan
if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit;
}

// Proses tambah ke keranjang atau beli sekarang
if (isset($_POST['tambah_keranjang']) || isset($_POST['beli_sekarang'])) {
    $jumlah = $_POST['jumlah'];

    // Jika keranjang belum ada, buat array baru
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    // Cek jika produk sudah ada di keranjang
    $found = false;
    foreach ($_SESSION['keranjang'] as &$item) {
        if ($item['id'] == $produk['id']) {
            $item['jumlah'] += $jumlah; // Update jumlah produk yang sudah ada
            $found = true;
            break;
        }
    }

    // Jika produk belum ada di keranjang, tambahkan produk baru
    if (!$found) {
        $_SESSION['keranjang'][] = [
            'id' => $produk['id'],
            'gambar' => $produk['gambar'],
            'nama' => $produk['nama_produk'],
            'harga' => $produk['harga'],
            'jumlah' => $jumlah
        ];
    }

    // Redirect sesuai dengan tombol yang ditekan
    if (isset($_POST['beli_sekarang'])) {
        header('Location: detail_pesanan.php');
        exit;
    } else {
        header('Location: keranjang.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Produk - <?php echo $produk['nama_produk']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #FFEDFA;
            color: #333;
        }

        .detail-container {
            display: flex;
            padding: 40px;
            gap: 40px;
            max-width: 1000px;
            margin: auto;
            background-color: #FFEDFA;
        }

        .detail-image img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            margin-top: 70px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .detail-info h2 {
            font-size: 26px;
            margin-bottom: 15px;
        }

        .detail-info p {
            font-size: 16px;
            margin: 6px 0;
            line-height: 1.4;
        }

        .detail-info p strong,
        .detail-info p span {
            color: #AC1754;
            font-weight: bold;
        }

        .qty-box {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .qty-box button {
            padding: 6px 14px;
            font-size: 16px;
            border: 1px solid #ccc;
            background: #f5f5f5;
            cursor: pointer;
        }

        .qty-box input {
            width: 50px;
            text-align: center;
            font-size: 16px;
            margin: 0 10px;
            padding: 5px;
        }

        .btn-group {
            margin-top: 20px;
        }

        .btn-group button {
            padding: 10px 18px;
            margin-right: 20px;
            border: none;
            background-color: #AC1754;
            color: white;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-group button:hover {
            background-color: #AC1754;
        }

        #total {
            color: #AC1754;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
    <script>
        function updateTotal(harga_satuan) {
            let qty = document.getElementById('qty').value;
            document.getElementById('total').innerText = 'Rp' + (harga_satuan * qty).toLocaleString('id-ID');
        }
        function plus(harga_satuan) {
            let qtyInput = document.getElementById('qty');
            qtyInput.value = parseInt(qtyInput.value) + 1;
            updateTotal(harga_satuan);
        }
        function minus(harga_satuan) {
            let qtyInput = document.getElementById('qty');
            if (qtyInput.value > 1) {
                qtyInput.value = parseInt(qtyInput.value) - 1;
                updateTotal(harga_satuan);
            }
        }
    </script>
</head>
<body>

<div class="detail-container">
    <div class="detail-image">
        <img src="img/<?php echo $produk['gambar']; ?>" alt="<?php echo $produk['nama_produk']; ?>">
    </div>

    <div class="detail-info">
        <h2><?php echo $produk['nama_produk']; ?></h2>
        <p><?php echo $produk['deskripsi']; ?></p>
        <p>Stok: <?php echo $produk['stok']; ?></p>
        <p>Kategori: <?php echo ucfirst($produk['kategori']); ?></p>
        <p>Harga Satuan: Rp<?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>

        <form method="post">
            <div class="qty-box">
                <button type="button" onclick="minus(<?php echo $produk['harga']; ?>)">-</button>
                <input type="number" name="jumlah" id="qty" value="1" min="1" max="<?php echo $produk['stok']; ?>" oninput="updateTotal(<?php echo $produk['harga']; ?>)">
                <button type="button" onclick="plus(<?php echo $produk['harga']; ?>)">+</button>
            </div>

            <p>Total Harga: <strong id="total">Rp<?php echo number_format($produk['harga'], 0, ',', '.'); ?></strong></p>

            <div class="btn-group">
                <button type="submit" name="tambah_keranjang">Tambah ke Keranjang</button>
                <button type="submit" name="beli_sekarang">Beli Sekarang</button>
            </div>
        </form>
    </div>
</div>

<script>
    updateTotal(<?php echo $produk['harga']; ?>);
</script>

</body>
</html>
