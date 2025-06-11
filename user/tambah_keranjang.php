<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '';
    $nama = isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '';
    $harga = isset($_POST['harga']) && is_numeric($_POST['harga']) ? (int)$_POST['harga'] : 0;
    $gambar = isset($_POST['gambar']) ? htmlspecialchars($_POST['gambar']) : 'default.jpeg';
    $jumlah = isset($_POST['jumlah']) && is_numeric($_POST['jumlah']) ? (int)$_POST['jumlah'] : 1;

    if ($id !== '' && $nama !== '' && $harga > 0 && $jumlah > 0) {
        if (!isset($_SESSION['keranjang']) || !is_array($_SESSION['keranjang'])) {
            $_SESSION['keranjang'] = [];
        }

        $produkSudahAda = false;

        foreach ($_SESSION['keranjang'] as &$item) {
            if ($item['id'] === $id) {
                $item['jumlah'] += $jumlah;
                $produkSudahAda = true;
                break;
            }
        }
        unset($item);

        if (!$produkSudahAda) {
            $_SESSION['keranjang'][] = [
                'id' => $id,
                'nama' => $nama,
                'harga' => $harga,
                'gambar' => $gambar,
                'jumlah' => $jumlah
            ];
        }

        header('Location: keranjang.php');
        exit();
    } else {
        header('Location: keranjang.php?error=invalid');
        exit();
    }
} else {
    header('Location: keranjang.php');
    exit();
}
?>
