-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2025 at 04:00 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','kasir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id`, `username`, `password`, `role`) VALUES
(2, 'admin', 'admin99', 'admin'),
(3, 'kasir', 'kasir99', 'kasir');

-- --------------------------------------------------------

--
-- Table structure for table `tb_detailpes`
--

CREATE TABLE `tb_detailpes` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_detailpes`
--

INSERT INTO `tb_detailpes` (`id_detail`, `id_pesanan`, `id`, `nama_produk`, `jumlah`, `harga`, `subtotal`) VALUES
(25, 'P0001', 2, 'Roti Manis Kismis', 2, 19500, 39000),
(26, 'P0001', 25, 'Oatmeal Raisin Cookies', 3, 13000, 39000),
(27, 'P0003', 11, 'Brownies Panggang', 2, 25000, 50000),
(28, 'P0003', 70, 'Pain Suisse ', 2, 17000, 34000),
(29, 'P0003', 18, 'Focaccia', 2, 22000, 44000),
(30, 'P0003', 67, 'Donat Oreo', 2, 15000, 30000),
(31, 'P0003', 29, 'Double Chocolate Cookies', 2, 15000, 30000),
(32, 'P0005', 42, 'Black Forest', 1, 170000, 170000),
(33, 'P0005', 20, 'Roti Kukus Thailand', 5, 32000, 160000),
(34, 'P0005', 29, 'Double Chocolate Cookies', 8, 15000, 120000),
(35, 'P0005', 67, 'Donat Oreo', 8, 15000, 120000),
(36, 'P0005', 70, 'Pain Suisse ', 8, 17000, 136000),
(37, 'P0006', 53, 'Apple Turnover', 3, 19000, 57000),
(38, 'P0007', 16, 'Mango Cheesecake', 1, 56000, 56000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id_pesanan` varchar(50) NOT NULL,
  `metode_pembayaran` enum('Tunai') NOT NULL,
  `jumlah_bayar` decimal(10,0) NOT NULL,
  `kembalian` decimal(10,0) NOT NULL,
  `status_pembayaran` enum('Belum Dibayar','Lunas','Dibatalkan') NOT NULL,
  `tanggal_pembayaran` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`id_pesanan`, `metode_pembayaran`, `jumlah_bayar`, `kembalian`, `status_pembayaran`, `tanggal_pembayaran`) VALUES
('P0001', 'Tunai', 100000, 22000, 'Lunas', '2025-06-06 07:33:15.000000'),
('P0003', 'Tunai', 190000, 2000, 'Lunas', '2025-06-06 23:36:53.000000'),
('P0005', 'Tunai', 710000, 4000, 'Lunas', '2025-06-10 04:40:39.000000'),
('P0006', 'Tunai', 57000, 0, 'Lunas', '2025-06-10 20:35:39.000000'),
('P0007', 'Tunai', 60000, 4000, 'Lunas', '2025-06-11 01:57:30.000000');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pesanan`
--

CREATE TABLE `tb_pesanan` (
  `id_pesanan` varchar(10) NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` decimal(10,0) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `status_pesanan` enum('Pending','Lunas') NOT NULL,
  `tanggal_pemesanan` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pesanan`
--

INSERT INTO `tb_pesanan` (`id_pesanan`, `no_antrian`, `nama_pelanggan`, `nama_produk`, `jumlah`, `total_harga`, `metode_pembayaran`, `status_pesanan`, `tanggal_pemesanan`) VALUES
('P0001', 1, 'Ahmad Ali', 'Roti Manis Kismis, Oatmeal Raisin Cookies', 5, 78000, 'Tunai', 'Lunas', '2025-06-06 14:32:49.000000'),
('P0003', 3, 'Firdausi', 'Brownies Panggang, Pain Suisse , Focaccia, Donat Oreo, Double Chocolate Cookies', 10, 188000, 'Tunai', 'Lunas', '2025-06-07 06:35:31.000000'),
('P0005', 5, 'Santi', 'Black Forest, Roti Kukus Thailand, Double Chocolate Cookies, Donat Oreo, Pain Suisse', 30, 706000, 'Tunai', 'Lunas', '2025-06-10 11:33:44.000000'),
('P0006', 6, 'Robi', 'Apple Turnover', 3, 57000, 'Tunai', 'Lunas', '2025-06-11 03:26:47.000000'),
('P0007', 7, 'Sinta', 'Mango Cheesecake', 1, 56000, 'Tunai', 'Lunas', '2025-06-11 03:56:49.000000');

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `crated_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`id`, `nama_produk`, `deskripsi`, `harga`, `stok`, `gambar`, `kategori`, `crated_at`) VALUES
(1, 'Roti Coklat Keju', 'Roti dengan isian coklat dan keju yang lembut, cocok untuk sarapan atau cemilan.', 15000, 100, 'Roti Coklat Keju.jpg', 'Roti', '2025-06-06 12:39:00.239762'),
(2, 'Roti Manis Kismis', 'Roti manis dengan tambahan kismis di atasnya, memberikan rasa manis yang pas.', 19500, 100, 'Roti Manis Kismis.jpg', 'Roti', '2025-06-06 12:55:22.611109'),
(3, 'Bread Lemon Cake', 'Roti lemon yang lezat dengan rasa lemon yang kuat dan lapisan gula lemon di atasnya.', 7500, 100, 'Bread Lemon Cake.jpg', 'Roti', '2025-06-06 12:42:22.861879'),
(4, 'Cappucino Bread', 'Roti yang lembut dan aroma khas kopi dengan dipadukan cream mocha di atasnya.', 7000, 100, 'Cappucino Bread.jpg', 'Roti', '2025-06-06 12:42:39.848355'),
(5, 'Choco Beetle', 'Roti yang lembut dengan toping kacang yang gurih.', 7000, 100, 'Choco Beetle.jpg', 'Roti', '2025-06-06 12:43:32.685284'),
(6, 'Coconut Brown Sugar', 'Roti lembut yang terbuat dari kelapa dan gula merah. ', 19000, 100, 'Coconut Brown Sugar.png', 'cake', '2025-06-06 12:43:16.700534'),
(7, 'Brioche ', 'Brioche adalah roti lembut, sedikit manis, dan kaya rasa yang berasal dari Prancis. Brioche memiliki kulit gelap, emas, dan rapuh.', 21000, 100, 'Brioche.jpg', 'Roti', '2025-06-06 12:43:01.690873'),
(8, 'Ciabatta', 'Roti ciabatta adalah jenis roti asal Itali yang memiliki ciri khas kulit yang renyah, bagian dalam yang lembut dan salah satu roti yang populer dan memiliki karakteristik yang unik.', 17000, 100, 'Ciabatta.jpg', 'Roti', '2025-06-06 12:42:52.021403'),
(9, 'Croissant', 'Roti croissant adalah kue kering yang berbentuk bulan sabit dan memiliki tekstur berlapis. Croissant terkenal karena rasa gurih dan renyah diluar, serta lembut didalam.', 35000, 100, 'Croissant.jpg', 'pastry', '2025-06-06 12:43:43.116582'),
(10, 'Roti Bagel', 'Roti bagel memiliki tekstur padat dan kenyal didalam, serta kulit luarnya yang garing dan berwarna coklat muda.', 17000, 100, 'Bagel.jpg', 'Roti', '2025-06-06 12:43:55.263730'),
(11, 'Brownies Panggang', 'Brownies adalah kue coklat yang dipanggang dengan oven dan memiliki tekstur yang lembut didalam dan garing diluar.', 25000, 98, 'Brownies.jpeg', 'cake', '2025-06-07 04:35:31.766744'),
(12, 'Cheese cream Cake', 'Empuknya cake dipadu dengan gurihnya keju dipadu dengan lembutnya cream. ', 45000, 100, 'Cheese Cake.jpeg', 'cake', '2025-06-06 12:44:26.599394'),
(13, 'Coco Cake', 'Coco Cake hadir dengan ragam olahan cokelat yang melimpah. Lapisan buttercream coklat menyelimuti kelembutan kue spons cokelat yang moist di mulut.', 59000, 100, 'Coco Cake.jpeg', 'cake', '2025-06-06 12:45:08.042519'),
(14, 'Roti Canai', 'Roti canai adalah roti pipih yang berlapis-lapis, lembut didalam, dan renyah diluar. Roti canai merupakan makanan khas Malaysia yang populer.', 15000, 100, 'Canai.jpeg', 'Roti', '2025-06-06 12:44:57.047524'),
(15, 'Classic Opera', 'Classic opera adalah kue bolu almond yang rumit dengan isian dan lapisan gula kopi dan cokelat.', 120000, 100, 'Opera.jpeg', 'cake', '2025-06-06 12:44:47.941846'),
(16, 'Mango Cheesecake', 'Mango cheesecake adalah cheesecake yang dicampur dengan buah mangga segar ini diberi lapisan cookies crumble homemade dibagian pinggirnya.', 56000, 99, 'Mango Cheesecake.jpeg', 'cake', '2025-06-11 01:56:49.239633'),
(17, 'Roti Sobek', 'Roti lembut berbentuk potongan yang bisa disobek, biasanya polos.', 16000, 100, 'Sobek.jpeg', 'Roti', '2025-06-06 12:45:18.979644'),
(18, 'Focaccia', 'Roti datar khas Italia dengan toping minyak zaitun dan rempah.', 22000, 98, 'Focaccia.jpeg', 'Roti', '2025-06-07 04:35:31.778558'),
(19, 'Donat', 'Satu kotak berisi 6 donat lembut dengan beragam topping.', 36000, 100, 'Donat.jpeg', 'Donut', '2025-06-06 12:45:44.070780'),
(20, 'Roti Kukus Thailand', 'Roti kukus Thailand adalah kudapan yang memiliki tektur yang lembut dan empuk, disajikan dalam keadaan hangat dengan berbagai macam topping manis dan gurih.', 32000, 95, 'Roti Kukus.jpg', 'Roti', '2025-06-10 09:33:44.497010'),
(21, 'Roti Gambang', 'Roti gambang adalah roti berwarna coklat dengan teksturnya agak padat. Terus, beraroma rempah, seperti kayu manis, biji pala.', 15000, 100, 'Gambang.jpg', 'Roti', '2025-06-06 12:54:18.053020'),
(22, 'Roti Pumperckel', 'Roti pumpernickel adalah roti tradisional jepang yang terbuat dari tepung gamdum hitam yang digiling kasar. Roti ini memiliki tekstur padat dan kasar berwarna coklat tua, dan terkadang hampir hitam.', 35000, 100, 'Roti Pumpernickel.jpg', 'Roti', '2025-06-06 12:54:29.812374'),
(23, 'Chocolate Chip Cookies', 'Cookies klasik dengan potongan cokelat hitam yang meleleh di mulut.', 12000, 100, 'Chocolate Chip Cookies.jpeg', 'Cookies', '2025-06-06 12:53:24.480643'),
(24, 'Butter Cookies', 'Kue kering renyah berbahan dasar mentega premium dengan rasa lembut.', 10000, 100, 'Butter Cookies.jpeg', 'Cookies', '2025-06-06 12:54:47.479262'),
(25, 'Oatmeal Raisin Cookies', 'Perpaduan gamdum utuh dan kismis manis, cocok untuk cemilan sehat.', 13000, 100, 'Oatmeal Raisin Cookies.jpeg', 'Cookies', '2025-06-06 12:54:03.244566'),
(26, 'Peanut Butter Cookies', 'Cookies gurih dan manis dengan rasa khas selai kacang.', 12000, 100, 'Panut Butter Cookies.jpeg', 'Cookies', '2025-06-06 12:53:50.472458'),
(27, 'Matcha Cookies', 'Cookies dengan rasa matcha Jepang yang khas dan aroma teh hijau.', 14000, 100, 'Matcha Cookies.jpeg', 'Cookies', '2025-06-06 12:53:35.789993'),
(28, 'Almond Crunch Cookies', 'Kue kering dengan taburan kacang almond renyah di setiap gigitan.', 15000, 100, 'Almong Crunch Cookies.jpeg', 'Cookies', '2025-06-06 12:53:12.082466'),
(29, 'Double Chocolate Cookies', 'Cookies coklat dengan tambahan choco chip ekstra untuk pecinta coklat.', 15000, 90, 'Double Chocotate Cookies.jpeg', 'Cookies', '2025-06-10 09:33:44.505215'),
(30, 'Cornflakes Cookies', 'Cookies renyah dilapisi cornflakes, cocok untuk teman teh atau kopi.', 15000, 100, 'Cornflakes Cookies.jpeg', 'Cookies', '2025-06-06 12:52:46.444174'),
(31, 'Cheese Cookies', 'Perpaduan rasa manis dan asin dari keju cheddar yang dipanggang renyah.', 13000, 100, 'Cheese Cookies.jpeg', 'Cookies', '2025-06-06 12:52:33.832555'),
(32, 'Red Velvet Cookies', 'Kue berwarna merah elegan dengan isian coklat putih di tengahnya.', 16000, 100, 'Red Velvet Cookies.jpeg', 'Cookies', '2025-06-06 12:52:22.063061'),
(33, 'Choco Mint Cookies', 'Cookies coklat dengan sensasi segar mint, cocok untuk pecinta rasa unik.', 17000, 100, 'Choco Mint Cookies.jpeg', 'Cookies', '2025-06-06 12:51:25.406543'),
(34, 'Caramel Cashew Cookies', 'Cookies manis dengan lapisan karamel dan kacang mete panggang.', 15000, 100, 'Caramel Cashew Cookies.jpeg', 'Cookies', '2025-06-06 12:51:39.720073'),
(35, 'Mocha Coffee Cookies', 'Kue kering beraroma kopi dengan sentuhan cokelat, pas untuk pecinta kopi.', 16000, 100, 'Mocha Coffee Cookies.jpeg', 'Cookies', '2025-06-06 12:51:52.975451'),
(36, 'Cinnamon Sugar Cookies ', 'Cookies renyah dengan taburan gula dan kayu manis yang harum dan manis.', 15000, 100, 'Cinnamon Sugar Cookies.jpg', 'Cookies', '2025-06-06 12:52:06.350652'),
(37, 'Rainbow Spinkle Cookies', 'Cookies warna-warni dengan topping sprinkle ceria, disukai anak-anak.', 15000, 100, 'Rainbow Sprinkle Cookies.jpeg', 'Cookies', '2025-06-06 12:51:08.671247'),
(38, 'Donat Cokelat Glaze', 'Donat empuk dengan lpisan coklat leleh di atasnya.', 8000, 100, 'Donat Coklat Glaze.jpeg', 'Donut', '2025-06-06 12:50:53.585234'),
(39, 'Donat Gula Halus', 'Donat klasik yang dilapisi gula halus, favorit sepanjang masa.', 7000, 100, 'Donat Gula Halus.jpeg', 'Donut', '2025-06-06 12:50:40.507458'),
(40, 'Chocolate Fudge Cake', 'Kue coklat lembut dengan lapisan fudge dan topping coklat leleh.', 180000, 100, 'Chocolate Fudge Cake.jpeg', 'Cake', '2025-06-06 12:50:25.286264'),
(41, 'Red Velvet Cake', 'Kue merah dengan cream cheese frosting, lembut dan manis.', 200000, 100, 'Red Velvet Cake.jpeg', 'Cake', '2025-06-06 12:50:06.925331'),
(42, 'Black Forest', 'Kue coklat dengan krim, ceri, dan taburan coklat parut.', 170000, 99, 'Black Forest.jpeg', 'Cake', '2025-06-10 09:33:44.493109'),
(43, 'Tiramisu Cake', 'Kue kopi da krim mascarpone berlapis, dilapisi cocoa powder.', 190000, 100, 'Tiramisu Cake.jpeg', 'Cake', '2025-06-06 12:49:39.670246'),
(44, 'Rainbow Cake', 'Kue berlapis warna-warni dengan krim vanila yang lembut.', 160000, 100, 'Rainbow Cake.jpeg', 'Cake', '2025-06-06 12:49:19.199438'),
(45, 'Cheese Cake', 'Kue keju creamy dengan dasar biskuit, bisa topping buah.', 175000, 100, 'Cheese Cake.jpeg', 'Cake', '2025-06-06 12:49:03.347592'),
(46, 'Pandan Layer Cake', 'Kue lapis pandan dengan krim santan lembut khas Indonesia.', 160000, 100, 'Pandan Layer Cake.jpeg', 'Cake', '2025-06-06 12:48:48.326553'),
(47, 'Carrot Cake', 'Kue wortel dengan taburan kacang dan krim keju di atasnya.', 178000, 100, 'Carrot Cake.jpeg', 'Cake', '2025-06-06 12:48:33.575875'),
(48, 'Strawberry Shortcake', 'Kue vanila dengan whipped cream dan potongan stroberi segar.', 1880000, 100, 'Straw.jpeg', 'Cake', '2025-06-06 12:48:20.915215'),
(49, 'Mille Feuille', 'Lapis-lapis pastry renyah dengan krim vanila dan taburan gula halus.', 69000, 100, 'Mille Feuille.jpeg', 'pastry', '2025-06-06 12:47:33.059155'),
(50, 'Danish Blueberry', 'Roti lapis asal Prancis dengan tekstur renyah di luar dan lembut di dalam.', 20000, 100, 'DanishBlue.jpeg', 'Pastry', '2025-06-06 12:47:44.805690'),
(51, 'Pain au Chocolat', 'Pastry isi coklat batang khas prancis.', 22000, 100, 'Painau.jpeg', 'Pastry', '2025-06-06 12:47:56.230164'),
(52, 'Strawberry Cream Cheese Puff', 'Pastry berisi krim keju dan potongan stroberi segar.', 21500, 100, 'StrawberryCream.jpeg', 'Pastry', '2025-06-06 12:48:08.590627'),
(53, 'Apple Turnover', 'Pastry segitiga berisi apel manis dengan kayu manis dan gula.', 19000, 97, 'ApleTurnover.jpeg', 'Pastry', '2025-06-11 01:26:47.629557'),
(55, 'Cinnamon Roll', 'Roti gulung berisi kayu manis dan gula merah, diberi lapisan gula.', 18500, 100, 'CinnamonRoll.jpeg', 'Pastry', '2025-06-06 12:47:01.772908'),
(56, 'Lemon Tart', 'Tart kecil berisi custard lemon asam manis dengan crust renyah.', 20000, 100, 'LemonTart.jpeg', 'Pastry', '2025-06-06 12:46:52.379236'),
(66, 'Donat Bomboloni', 'Donat bomboloni dengan adonan lembut, diisi dengan selai cokelat leleh.', 16000, 100, 'Donat Bomboloni.jpeg', 'Donut', '2025-06-06 12:46:42.926124'),
(67, 'Donat Oreo', 'Donar dengan adonan rasa vanila, dilapisi dengan lapisan oreo dan taburan potongan oreo.', 15000, 90, 'Donat Oreo.jpeg', 'Donut', '2025-06-10 09:33:44.510939'),
(68, 'Donat Bomboloni Keju', 'Donat Bomboloni dengan adonan lembut, diisi dengan selai keju leleh.', 17000, 100, 'Donat Bomboloni Keju.jpeg', 'Donut', '2025-06-06 12:46:20.927026'),
(69, 'Donat Tiramisu', 'Donat dengan toping tiramisu dan taburan cokelat bubuk.', 14000, 100, 'Donat Tiramisu.jpeg', 'Donut', '2025-06-06 12:46:10.119797'),
(70, 'Pain Suisse ', 'Pastry asal Prancis ini serupa croissant, namun bisa diisi berbagai isian manis (cokelat, selai) atau asin (jamur).', 17000, 90, 'Pain Suisse.jpeg', 'Pastry', '2025-06-10 09:33:44.517620'),
(71, 'Kouign Amann', 'Pastry manis dan renyah asal Prancis, kaya mentega, dengan rasa manis yang khas.', 18000, 100, 'Kouign Amann.jpeg', 'Pastry', '2025-06-06 13:07:10.558371'),
(72, 'Flaky Pastry', 'Adonan pastry yang paling sederhana, mudah dibuat dan bisa diisi berbagai macam, cocok untuk eksperimen rasa.', 20000, 100, 'Flaky Pastry.jpeg', 'Pastry', '2025-06-06 13:09:10.879245'),
(73, 'Shortcrust Pastry', 'Adonan yang mudah dibuat dan tahan banting, sering digunakan untuk dasar pie atau tart.', 18000, 100, 'Shortcrust Pastry.jpeg', 'Pastry', '2025-06-06 13:11:44.389307'),
(74, 'Rough Puff Pastry', 'Perpaduan antara kue kering dan puff pastry, memberikan tekstur renyah dan gurih.', 20000, 100, 'Rough Puff Pastry.jpeg', 'Pastry', '2025-06-06 13:17:16.572643'),
(75, 'Phyllo Pastry', 'Pastry yang sangat tipis dan menyerupai kertas, bisa digunakan untuk berbagai macam hidangan, baik manis maupun asin.', 23000, 100, 'Phyllo Pastry.jpeg', 'Pastry', '2025-06-06 13:19:15.051573'),
(76, 'Beignet', 'Kue goreng lembut yang ditutupi gula halus, bisa disajikan dengan berbagai isian atau selai.', 15000, 100, 'Beignet.jpeg', 'Pastry', '2025-06-06 13:21:54.000188'),
(77, 'Madeleine', 'Kue sponge kecil yang khas dengan bentuk cangkang, cocok untuk hidangan penutup.', 15000, 100, 'Madeleine.jpeg', 'Pastry', '2025-06-06 13:27:20.679787'),
(78, ' Meringue', 'Kue kering yang dibuat dari putih telur dan gula, rasanya ringan dan manis.', 10000, 100, 'Meringue.jpeg', 'Pastry', '2025-06-06 13:29:53.169123'),
(79, 'Choux Pastry', 'Choux pastry adalah salah satu jenis pastry yang sudah sering kita jumpai dengan nama kue sus.', 10000, 100, 'Choux Pastry.jpeg', 'Pastry', '2025-06-06 13:32:11.314651'),
(80, 'Donat Ubi', 'Donat yang menggunakan adonan ubi ungu atau jala, memberikan rasa manis yang khas.', 7000, 100, 'Donat Ubi.jpeg', 'Donut', '2025-06-07 04:43:42.363943'),
(81, 'Donat Tape', 'Donat Tape dengan bahan berkualitas dan tentunya dengan tambahan tape yang bikin lembut sekali saat di gigit.', 7000, 100, 'Donat Tape.jpeg', 'Donut', '2025-06-07 04:47:33.335345'),
(82, 'Donat Crispy', 'Donat crispy adalah jenis donat yang memiliki tekstur renyah pada bagian luarnya, berbeda dengan donat biasa yang lebih lembut.', 7000, 100, 'Donat Crispy.jpeg', 'Donut', '2025-06-07 04:49:17.143705'),
(83, 'Roti Tawar Putih', 'Roti dasar yang banyak disukai, cocok untuk sandwich atau dioleskan selai.', 13000, 100, 'Roti Tawar.jpeg', 'Roti', '2025-06-07 04:53:14.126337'),
(84, 'Roti Gandum', 'Roti gandum lebih kaya serat dan gizi, cocok untuk sarapan sehat.', 13000, 100, 'Roti Gandum.jpeg', 'Roti', '2025-06-07 04:54:43.683577'),
(85, 'Roti Isi Cokelat', 'Roti lembut dengan isian cokelat leleh yang manis. ', 10000, 100, 'Roti Isi Coklat.jpeg', 'Roti', '2025-06-07 04:56:15.655686'),
(86, 'Roti Isi Keju', ' Roti dengan isian keju yang gurih dan lezat.', 12000, 100, 'Roti Isi Keju.jpeg', 'Roti', '2025-06-07 04:57:22.775048'),
(87, 'Roti Isi Abon', 'Roti dengan isian abon sapi yang gurih dan asin.', 13000, 100, 'Roti Isi Abon.jpeg', 'Roti', '2025-06-07 04:59:21.566157'),
(88, 'Roti Isi Kacang', ' Roti dengan isian kacang yang manis dan renyah. ', 12000, 100, 'Roti Isi Kacang.jpeg', 'Roti', '2025-06-07 05:00:17.857027'),
(89, 'Roti Srikaya', 'Roti manis dengan isian srikaya khas.', 21000, 100, 'Roti Srikaya.jpeg', 'Roti', '2025-06-07 05:01:17.853528'),
(90, 'Roti Susu', 'Roti yang empuk dan lembut, cocok untuk sarapan atau camilan. ', 12000, 100, 'Roti Susu.jpeg', 'Roti', '2025-06-07 05:02:26.251160'),
(91, 'Roti Isi Pisang', 'Roti dengan isian pisang yang manis dan lembut.', 14000, 100, 'Roti Isi Pisang.jpeg', 'Roti', '2025-06-07 05:05:04.140526'),
(92, 'Roti Isi Singkong', 'Roti dengan isian singkong yang manis dan gurih.', 13000, 100, 'Roti Isi Singkong.jpeg', 'Roti', '2025-06-07 05:06:16.630078'),
(93, 'Roti Bakar', 'Roti yang dipanggang dengan topping cokelat meleleh.', 17500, 100, 'Roti Bakar.jpeg', 'Roti', '2025-06-07 05:08:28.187688');

-- --------------------------------------------------------

--
-- Table structure for table `tb_review`
--

CREATE TABLE `tb_review` (
  `id_review` int(11) NOT NULL,
  `id_pesanan` varchar(20) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `komentar` text NOT NULL,
  `waktu_review` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_review`
--

INSERT INTO `tb_review` (`id_review`, `id_pesanan`, `nama_pelanggan`, `id`, `rating`, `komentar`, `waktu_review`) VALUES
(1, 'P0006', 'zula', 11, 5, 'Browniesnya enak, empuk, rasanya juga nggak yang manis banget sedenga. Browniesnya nggak bikin enekk', '2025-05-25 12:11:49'),
(2, 'P0002', 'Firdausi Nuzula', 41, 5, 'Kuenya enakk, aku suka tampilannya yang cantik ', '2025-05-31 19:43:15');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id_pesanan` varchar(255) NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id_pesanan`, `no_antrian`, `nama_pelanggan`) VALUES
('P0001', 1, 'Ahmad Ali'),
('P0002', 2, 'Amira Sunni'),
('P0003', 3, 'Firdausi'),
('P0004', 4, 'Aji'),
('P0005', 5, 'Santi'),
('P0006', 6, 'Robi'),
('P0007', 7, 'Sinta');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_detailpes`
--
ALTER TABLE `tb_detailpes`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_review`
--
ALTER TABLE `tb_review`
  ADD PRIMARY KEY (`id_review`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`no_antrian`,`id_pesanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_detailpes`
--
ALTER TABLE `tb_detailpes`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `tb_review`
--
ALTER TABLE `tb_review`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `no_antrian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
