<?php
// Mulai session untuk menghapus session saat logout
session_start();

// Hancurkan session untuk logout
session_destroy();

// Redirect ke halaman login setelah logout
header("Location: index.php");
exit();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - The Cakery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #ffe6e6, #ffe6f0);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #AC1754;
            margin-bottom: 30px;
        }

        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #AC1754;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            color: white;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #9a1246;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Logout Berhasil</h2>
    <p>Anda telah berhasil logout. Klik tombol di bawah ini untuk kembali ke halaman login.</p>
    <a href="index.php"><button>Kembali ke Login</button></a>
</div>

</body>
</html>
