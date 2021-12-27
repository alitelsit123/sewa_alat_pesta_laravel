-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2021 at 02:20 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mita_alat_pesta`
--

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `kode_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `id_kategori` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `kode_produk`, `nama_produk`, `gambar`, `keterangan`, `harga`, `stok`, `id_kategori`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, '61c86d422ca62', 'Tenda 6x6', 'mita_img_164052508361c86d1b4c971.jpg', '', 200000, 10, 1, '2021-12-26 06:24:43', '2021-12-26 06:25:22', NULL),
(10, '61c86dd5193f7', 'Tenda Plafon 6x6', 'mita_img_164052526961c86dd5177a3.jpg', '', 250000, 10, 1, '2021-12-26 06:27:49', '2021-12-26 06:27:49', NULL),
(11, '61c9ad977683e', 'Tenda 4x6', 'mita_img_164060712761c9ad97126e4.jpg', '', 150000, 10, 1, '2021-12-27 05:12:07', '2021-12-27 05:12:07', NULL),
(12, '61c9adbe76020', 'Tenda Plafon 4x6', 'mita_img_164060716661c9adbe741f2.jpg', '', 200000, 10, 1, '2021-12-27 05:12:46', '2021-12-27 05:12:46', NULL),
(13, '61c9ae0f7ef9b', 'Tenda 3x6', 'mita_img_164060724761c9ae0f7c9a2.jpg', '', 150000, 10, 1, '2021-12-27 05:14:07', '2021-12-27 05:14:07', NULL),
(14, '61c9ae4f52405', 'Tenda Plafon 3x6', 'mita_img_164060731161c9ae4f4fad4.jpg', '', 200000, 10, 1, '2021-12-27 05:15:11', '2021-12-27 05:15:11', NULL),
(15, '61c9ae6db27dc', 'Tenda 6x8', 'mita_img_164060734161c9ae6db034d.jpg', '', 300000, 10, 1, '2021-12-27 05:15:41', '2021-12-27 05:15:41', NULL),
(16, '61c9ae8cbb677', 'Tenda Plafon 6x8', 'mita_img_164060737261c9ae8cb97b7.jpg', '', 400000, 10, 1, '2021-12-27 05:16:12', '2021-12-27 05:16:12', NULL),
(17, '61c9af4415f04', 'Tenda Hias Sleyer 4x6', 'mita_img_164060755661c9af4412abf.jpg', '', 450000, 10, 1, '2021-12-27 05:19:16', '2021-12-27 05:19:16', NULL),
(18, '61c9af62b170b', 'Tenda Hias Sleyer 3x6', 'mita_img_164060758661c9af62af8ea.jpg', '', 350000, 10, 1, '2021-12-27 05:19:46', '2021-12-27 05:19:46', NULL),
(19, '61c9af8b2b8c7', 'Tenda Hias Sleyer 6x6', 'mita_img_164060762761c9af8b29116.jpg', '', 500000, 10, 1, '2021-12-27 05:20:27', '2021-12-27 05:20:27', NULL),
(20, '61c9afe02510c', 'Lampu', 'mita_img_164060771261c9afe021eb6.jpg', '', 35000, 10, 1, '2021-12-27 05:21:52', '2021-12-27 05:21:52', NULL),
(21, '61c9b2cc47ecc', 'Kursi Bangket', 'mita_img_164060846061c9b2cc44e21.jpg', '', 6000, 200, 3, '2021-12-27 05:34:20', '2021-12-27 05:34:20', NULL),
(22, '61c9b342219c8', 'Kursi Lipat', 'mita_img_164060853861c9b31aef292.jpg', '', 2000, 100, 3, '2021-12-27 05:35:38', '2021-12-27 05:36:18', NULL),
(23, '61c9b38b27412', 'Kursi Plastik', 'mita_img_164060865161c9b38b2386d.png', '', 1000, 100, 3, '2021-12-27 05:37:31', '2021-12-27 05:37:31', NULL),
(24, '61c9b4ffa9992', 'Kursi bangket + cover + pita', 'mita_img_164060896461c9b4c4be57f.jpg', '', 11000, 100, 3, '2021-12-27 05:42:44', '2021-12-27 05:43:43', NULL),
(25, '61c9b4f7df932', 'Kursi lipat + cover + pita', 'mita_img_164060901561c9b4f7dbf30.jpg', '', 7000, 100, 3, '2021-12-27 05:43:35', '2021-12-27 05:43:35', NULL),
(26, '61c9b557de768', 'Kursi VIP / Sofa', 'mita_img_164060911161c9b557db9b3.jpg', '', 50000, 100, 3, '2021-12-27 05:45:11', '2021-12-27 05:45:11', NULL),
(27, '61c9b5c361adb', 'Piring sanggo besar + sendok', 'mita_img_164060921961c9b5c35f14c.jpg', '', 700, 100, 4, '2021-12-27 05:46:59', '2021-12-27 05:46:59', NULL),
(28, '61c9b604d15ac', 'Piring sanggo kecil + sendok', 'mita_img_164060928461c9b604cef3d.jpg', '', 600, 100, 4, '2021-12-27 05:48:04', '2021-12-27 05:48:04', NULL),
(29, '61c9b66acb090', 'Mangkok bakso + sendok', 'mita_img_164060938661c9b66ac7f1f.jpg', '', 600, 100, 4, '2021-12-27 05:49:46', '2021-12-27 05:49:46', NULL),
(30, '61c9b6d0a4ef9', 'Mangkok sup', 'mita_img_164060948861c9b6d0a2df2.png', '', 500, 100, 4, '2021-12-27 05:51:28', '2021-12-27 05:51:28', NULL),
(31, '61c9b73640ba2', 'Mangkok pudding + sendok', 'mita_img_164060959061c9b7363e68d.jpeg', '', 600, 100, 4, '2021-12-27 05:53:10', '2021-12-27 05:53:10', NULL),
(32, '61c9b7c597fe6', 'Pemanas Kotak', 'mita_img_164060973361c9b7c5951c6.jpg', '', 20000, 30, 4, '2021-12-27 05:55:33', '2021-12-27 05:55:33', NULL),
(33, '61c9b80690f5a', 'Pemanas Bulat', 'mita_img_164060979861c9b8068dfe7.jpg', '', 20000, 30, 4, '2021-12-27 05:56:38', '2021-12-27 05:56:38', NULL),
(34, '61c9b8ef78422', 'Nampan / Lengser', 'mita_img_164061003161c9b8ef75a88.jpg', '', 5000, 40, 4, '2021-12-27 06:00:31', '2021-12-27 06:00:31', NULL),
(35, '61c9b9a2090cd', 'Meja Kecil', 'mita_img_164061021061c9b9a2054ad.jpg', '', 7000, 40, 2, '2021-12-27 06:03:30', '2021-12-27 06:03:30', NULL),
(36, '61c9b9ffa7a41', 'Meja bulat', 'mita_img_164061030361c9b9ffa59fb.jpg', '', 35000, 40, 2, '2021-12-27 06:05:03', '2021-12-27 06:05:03', NULL),
(37, '61c9ba5c68038', 'Meja sedang', 'mita_img_164061039661c9ba5c64f9c.jpg', '', 40000, 50, 2, '2021-12-27 06:06:36', '2021-12-27 06:06:36', NULL),
(38, '61c9bb454669a', 'Meja Prasmanan', 'mita_img_164061062961c9bb4543de3.JPG', '', 50000, 50, 2, '2021-12-27 06:10:29', '2021-12-27 06:10:29', NULL),
(39, '61c9bcd61b805', 'Panggung 4x6', 'mita_img_164061102161c9bccd4f0fc.jpg', '', 500000, 10, 5, '2021-12-27 06:17:01', '2021-12-27 06:17:10', NULL),
(41, '61c9bd70c2f8a', 'Sound system', 'mita_img_164061118461c9bd70c0881.jpg', '', 900000, 6, 5, '2021-12-27 06:19:44', '2021-12-27 06:19:44', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `produk_id_kategori_foreign` (`id_kategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
