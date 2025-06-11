<?php
session_start();
include('koneksi.php'); // Pastikan file koneksi.php sudah ada dan terkoneksi dengan database

// Login Handling
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mengecek apakah username dan password cocok
    $query = "SELECT * FROM tb_admin WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        // Jika ditemukan data, buat session dan redirect ke profile
        $_SESSION['username'] = $username;
        header('Location: profile_admin.php');
    } else {
        // Jika username atau password salah
        echo "<script>alert('Username atau Password salah!');</script>";
    }
}

// Logout Handling
if (isset($_GET['logout'])) {
    session_destroy(); // Menghapus session
    header('Location: login_admin.php'); // Redirect ke halaman login
    exit();
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        /* Tampilan Dasar Body */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f0f2f5;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    padding: 0 15px;
}

/* Mengatur Tampilan Form Login dan Profile */
.login-container, .profile-container {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Hover Efek pada Container */
.login-container:hover, .profile-container:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

/* Judul */
h2 {
    color: #333;
    font-size: 28px;
    margin-bottom: 25px;
}

/* Label dan Input Field */
label {
    font-size: 16px;
    color: #666;
    text-align: left;
    display: block;
    margin-bottom: 5px;
}

input[type="text"], input[type="password"] {
    width: 100%;
    padding: 15px;
    margin: 12px 0 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    background-color: #fafafa;
    color: #333;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus, input[type="password"]:focus {
    border-color: #AC1754;
    outline: none;
}

/* Tombol */
button {
    width: 100%;
    padding: 15px;
    background-color: #AC1754;
    border: none;
    color: #fff;
    border-radius: 8px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

button:hover {
    background-color: #9a1246;
    transform: translateY(-5px);
}

/* Profile Image */
.profile-container img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
    border: 4px solid #AC1754;
}

/* Info Profile */
.profile-info {
    font-size: 18px;
    color: #555;
    margin-bottom: 25px;
}

/* Link Logout */
.profile-container a {
    display: inline-block;
    margin-top: 15px;
    text-decoration: none;
    font-size: 16px;
    color: #AC1754;
    font-weight: bold;
    transition: color 0.3s ease;
}

.profile-container a:hover {
    color: #9a1246;
    text-decoration: underline;
}

/* Responsif untuk Mobile */
@media (max-width: 480px) {
    .login-container, .profile-container {
        padding: 30px;
        width: 90%;
    }

    h2 {
        font-size: 24px;
    }

    button {
        font-size: 16px;
    }
}

    </style>
</head>
<body>

<?php if (!isset($_SESSION['username'])): ?>
    <!-- Login Form -->
    <div class="login-container">
        <h2>Login Admin</h2>
        <form method="POST" action="login_admin.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>
    </div>
<?php else: ?>
    <!-- Profile Admin -->
    <?php
    $username = $_SESSION['username'];

    // Query untuk mengambil data admin berdasarkan username
    $query = "SELECT * FROM tb_admin WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    ?>
    <div class="profile-container">
        <h2>Profile Admin</h2>
        <div class="profile-picture">
            <img src="img/user.png" alt="Profile Picture">
        </div>
        <div class="profile-info">
            <p>Username: <?php echo $row['username']; ?></p>
            <p>Password: <?php echo $row['password']; ?></p>
        </div>
        <a href="login_admin.php?logout=true">Logout</a>
    </div>
<?php endif; ?>

</body>
</html>
