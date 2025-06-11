<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="The Cakery - Tempat terbaik untuk menikmati kue lezat dan segar.">
    <title>The Cakery - Tentang Kami</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
       /* Reset beberapa default styling */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Set font untuk seluruh halaman */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #fce4ec, #f3e5f5);
    color: #880E4F;
    padding-top: 70px;
    overflow-x: hidden;
    line-height: 1.6;
}

/* Container untuk konten About Us */
.container {
    width: 80%;
    margin: 100px auto;
    text-align: center;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    padding: 50px;
    animation: fadeIn 1.2s ease-in-out;
}

@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.container h2 {
    font-family: 'Berkshire Swash', cursive;
    font-size: 48px;
    color: #880E4F;
    margin-bottom: 30px;
    letter-spacing: 2px;
    text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
}

.container p {
    font-size: 20px;
    color: #880E4F;
    line-height: 1.8;
    margin-bottom: 20px;
    font-weight: 300;
    letter-spacing: 1px;
}

.container img {
    width: 250px;
    margin-top: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.container img:hover {
    transform: scale(1.05);
}



    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<!-- About Us Section -->
<div class="container">
    <h2>The Cakery!</h2>
    <p><strong>The Cakery</strong> adalah tempat yang menyajikan pengalaman baru dalam menikmati kue dan roti. Di sini, setiap gigitan kue kami membawa Anda pada perjalanan rasa yang luar biasa. Dibuat dengan bahan-bahan pilihan, kami berkomitmen memberikan produk terbaik untuk Anda.</p>
    <p>Dengan sistem pemesanan mandiri yang mudah, Anda bisa memilih langsung dari berbagai macam pilihan kue yang menggugah selera. Kami memastikan setiap produk yang kami sajikan memancarkan kehangatan dan keceriaan.</p>
    <p>Visi kami adalah menjadikan setiap momen Anda bersama The Cakery sebagai kenangan manis yang tidak terlupakan. Bergabunglah bersama kami dan rasakan kebahagiaan yang kami hadirkan, satu gigitan pada satu waktu!</p>
    
</div>

</body>
</html>
