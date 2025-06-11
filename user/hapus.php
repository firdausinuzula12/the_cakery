<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    foreach ($_SESSION['keranjang'] as $key => $item) {
        if ($item['id'] == $id) {
            unset($_SESSION['keranjang'][$key]);
            break;
        }
    }

    // Reset ulang index array
    $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
}

header('Location: keranjang.php');
exit;
