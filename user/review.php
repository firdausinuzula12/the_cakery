<?php
session_start();

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "toko");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$show_form = true;
$error = '';
$nama = '';
$id_pesanan = '';
$produk_dibeli = [];

// Cek jika form cek pesanan disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cek_pesanan'])) {
    $nama = $koneksi->real_escape_string($_POST['nama']);
    $id_pesanan = $koneksi->real_escape_string($_POST['id_pesanan']);

    $cek = $koneksi->query("SELECT * FROM tb_pesanan WHERE id_pesanan='$id_pesanan' AND nama_pelanggan='$nama'");
    if ($cek->num_rows > 0) {
        $produk = $koneksi->query("SELECT dp.id, p.nama_produk, dp.jumlah FROM tb_detailpes dp
                                    JOIN tb_produk p ON dp.id = p.id
                                    WHERE dp.id_pesanan='$id_pesanan'");
        while ($row = $produk->fetch_assoc()) {
            $produk_dibeli[] = [
                'id' => $row['id'],
                'nama_produk' => $row['nama_produk'],
                'jumlah' => $row['jumlah']
            ];
        }
        $show_form = false;
    } else {
        $error = "Data pesanan tidak ditemukan.";
    }
}

// Proses menyimpan review
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $nama = $koneksi->real_escape_string($_POST['nama']);
    $id_pesanan = $koneksi->real_escape_string($_POST['id_pesanan']);
    $id = $koneksi->real_escape_string($_POST['id']);
    $rating = (int) $_POST['rating'];
    $komentar = $koneksi->real_escape_string($_POST['komentar']);

    $cek_duplikat = $koneksi->query("SELECT * FROM tb_review WHERE id_pesanan='$id_pesanan' AND id='$id'");
    if ($cek_duplikat->num_rows > 0) {
        echo "<script>alert('Anda sudah memberikan review untuk produk ini dalam pesanan ini.'); window.location='review.php';</script>";
        exit();
    }

    $sql = "INSERT INTO tb_review (id_pesanan, id, nama_pelanggan, rating, komentar, waktu_review)
            VALUES ('$id_pesanan', '$id', '$nama', $rating, '$komentar', NOW())";

    if ($koneksi->query($sql) === TRUE) {
        echo "<script>alert('Terima kasih atas ulasannya!'); window.location='review.php';</script>";
        exit();
    } else {
        $error = "Gagal menyimpan ulasan: " . $koneksi->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ulasan Pelanggan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background: #FFEDFA;
            padding: 30px;
        }
        .card {
            background: #fff;
            padding: 30px;
            max-width: 700px;
            margin: auto;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in-out;
        }
        h2, h3 {
            color: #ac1754;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        .input-group input,
        .input-group textarea,
        .input-group select {
            width: 100%;
            padding: 12px;
            border: 1.5px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s ease;
            font-size: 14px;
        }
        .input-group input:focus,
        .input-group textarea:focus,
        .input-group select:focus {
            border-color: #ac1754;
            outline: none;
        }
        .btn {
            background: #ac1754;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
        }
        .btn:hover {
            background: #911346;
            transform: translateY(-2px);
        }
        .error {
            color: #c0392b;
            background: #ffe6e6;
            padding: 10px;
            border: 1px solid #ffb3b3;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        ul {
            padding-left: 20px;
        }
        ul li {
            margin-bottom: 10px;
            list-style-type: disc;
            font-size: 15px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<div class="card">
    <h2>Review Pesanan Anda</h2>

    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($show_form): ?>
        <form method="POST">
            <div class="input-group">
                <label>Nama Pelanggan</label>
                <input type="text" name="nama" required>
            </div>
            <div class="input-group">
                <label>ID Pesanan</label>
                <input type="text" name="id_pesanan" required>
            </div>
            <button type="submit" name="cek_pesanan" class="btn">Lanjutkan</button>
        </form>
    <?php else: ?>
        <p><strong>Nama:</strong> <?= htmlspecialchars($nama) ?></p>
        <p><strong>ID Pesanan:</strong> <?= htmlspecialchars($id_pesanan) ?></p>
        <p><strong>Produk Dibeli:</strong></p>
        <ul>
            <?php foreach ($produk_dibeli as $item): ?>
                <li>
                    <?= htmlspecialchars($item['nama_produk']) ?> (<?= $item['jumlah'] ?> pcs)
                    <button type="button" class="btn show-review-form"
                            data-id="<?= $item['id'] ?>"
                            data-nama_produk="<?= htmlspecialchars($item['nama_produk']) ?>">
                        Beri Ulasan
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Tempat munculnya form ulasan -->
        <div id="reviewFormContainer" style="margin-top: 30px;"></div>
    <?php endif; ?>
</div>

<!-- JavaScript untuk tampilkan form ulasan -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".show-review-form");
    const container = document.getElementById("reviewFormContainer");

    buttons.forEach(btn => {
        btn.addEventListener("click", function () {
            const id = this.dataset.id;
            const nama_produk = this.dataset.nama_produk;
            const nama = <?= json_encode($nama) ?>;
            const id_pesanan = <?= json_encode($id_pesanan) ?>;

            container.innerHTML = `
                <h3>Ulasan untuk: ${nama_produk}</h3>
                <form method="POST">
                    <input type="hidden" name="nama" value="${nama}">
                    <input type="hidden" name="id_pesanan" value="${id_pesanan}">
                    <input type="hidden" name="id" value="${id}">

                    <div class="input-group">
                        <label>Rating (1 - 5)</label>
                        <select name="rating" required>
                            <option value="">Pilih Rating</option>
                            ${[1, 2, 3, 4, 5].map(i => `<option value="${i}">${i}</option>`).join('')}
                        </select>
                    </div>
                    <div class="input-group">
                        <label>Komentar</label>
                        <textarea name="komentar" rows="4" required></textarea>
                    </div>
                    <button type="submit" name="submit_review" class="btn">Kirim Review</button>
                </form>
            `;
            container.scrollIntoView({ behavior: "smooth" });
        });
    });
});
</script>
</body>
</html>
