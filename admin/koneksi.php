<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'toko';

$koneksi = mysqli_connect($host, $username, $password, $dbname); 
 
if (!$koneksi) { 
    die("Koneksi gagal: " . mysqli_connect_error()); 
} 
?>