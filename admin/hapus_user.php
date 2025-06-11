<?php
include 'koneksi.php';

// Pastikan ada ID user
if (isset($_GET['id'])) {
    $no_antrian = intval($_GET['id']); // Pastikan ini angka, lebih aman

    // Hapus user dari database
    $delete = "DELETE FROM tb_users WHERE no_antrian = $no_antrian";

    if (mysqli_query($koneksi, $delete)) {
        echo "<script>alert('User berhasil dihapus!'); window.location.href='users_admin.php';</script>";
    } else {
        echo "Gagal menghapus user.";
    }
} else {
    echo "ID user tidak ditemukan.";
}
?>
