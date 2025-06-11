<?php
session_start();
include('koneksi.php'); // koneksi ke database

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = "SELECT * FROM tb_admin WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Jika kamu belum pakai password_hash(), gunakan perbandingan biasa
        // Gunakan password_verify() jika sudah hash
        if ($password === $row['password']) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Redirect sesuai role
            if ($row['role'] === 'admin') {
                header('Location: admin/index.php');
            } elseif ($row['role'] === 'kasir') {
                header('Location: kasir/index.php');
            } else {
                echo "<script>alert('Role tidak dikenal.'); window.location.href='index.php';</script>";
            }
            exit();
        } else {
            echo "<script>alert('Password salah!'); window.location.href='index.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!'); window.location.href='index.php';</script>";
        exit();
    }
}

// Logout jika ada
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - The Cakery</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #FFEDFA;
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
        label {
            font-size: 14px;
            color: #555;
            float: left;
            margin-bottom: 5px;
            margin-top: 15px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #fafafa;
            font-size: 16px;
            box-sizing: border-box;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #AC1754;
            outline: none;
        }
        button {
            width: 100%;
            margin-top: 25px;
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
    <h2>Login Admin</h2>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>

