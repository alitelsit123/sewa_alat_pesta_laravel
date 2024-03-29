-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2022 at 02:30 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

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
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id_chat` bigint(20) UNSIGNED NOT NULL,
  `id_chat_sesi` bigint(20) UNSIGNED NOT NULL,
  `pengirim` bigint(20) UNSIGNED NOT NULL,
  `chat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id_chat`, `id_chat_sesi`, `pengirim`, `chat`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, 8, 'dfsdfsdfsdf', '2022-01-08 10:10:46', '2022-01-08 12:31:03', '2022-01-08 12:31:03'),
(2, 4, 7, 'tes', '2022-01-08 10:59:35', '2022-01-08 12:31:03', '2022-01-08 12:31:03'),
(3, 4, 7, 'slkdjflsdf', '2022-01-08 11:01:33', '2022-01-08 12:31:03', '2022-01-08 12:31:03'),
(4, 4, 8, 'tes', '2022-01-08 11:50:53', '2022-01-08 12:31:03', '2022-01-08 12:31:03'),
(5, 4, 8, 'sdfsfe', '2022-01-08 11:52:13', '2022-01-08 12:31:03', '2022-01-08 12:31:03'),
(6, 4, 8, 'tes', '2022-01-08 12:04:23', '2022-01-08 12:31:03', '2022-01-08 12:31:03'),
(7, 4, 8, 'sdfsdf', '2022-01-08 12:09:05', '2022-01-08 12:31:03', '2022-01-08 12:31:03'),
(8, 4, 8, 'tesdf', '2022-01-08 12:10:53', '2022-01-08 12:31:03', '2022-01-08 12:31:03'),
(9, 4, 8, 'sdfsdf', '2022-01-08 12:23:37', '2022-01-08 12:31:03', '2022-01-08 12:31:03'),
(10, 4, 8, 'sdfsdf', '2022-01-08 12:30:16', '2022-01-08 12:31:03', '2022-01-08 12:31:03'),
(11, 5, 8, 'sdfsfd', '2022-01-08 12:39:05', '2022-01-08 12:54:34', '2022-01-08 12:54:34'),
(12, 5, 7, 'sldkf', '2022-01-08 12:52:33', '2022-01-08 12:54:34', '2022-01-08 12:54:34'),
(13, 5, 8, 'tes dong', '2022-01-08 12:52:52', '2022-01-08 12:54:34', '2022-01-08 12:54:34'),
(14, 5, 8, 'tes lagi', '2022-01-08 12:54:01', '2022-01-08 12:54:34', '2022-01-08 12:54:34'),
(15, 6, 8, 'tes bro', '2022-01-08 13:06:31', '2022-01-08 13:13:54', '2022-01-08 13:13:54'),
(16, 7, 8, 'tes', '2022-01-08 20:09:09', '2022-01-08 20:10:41', '2022-01-08 20:10:41'),
(17, 7, 8, 'hello', '2022-01-08 20:10:28', '2022-01-08 20:10:41', '2022-01-08 20:10:41'),
(18, 8, 8, 'tes', '2022-01-08 20:47:32', '2022-01-10 10:20:03', '2022-01-10 10:20:03'),
(19, 8, 8, 'sdf', '2022-01-08 20:48:40', '2022-01-10 10:20:03', '2022-01-10 10:20:03'),
(20, 8, 8, 'sdf', '2022-01-08 20:50:17', '2022-01-10 10:20:03', '2022-01-10 10:20:03'),
(21, 8, 8, 'hehe', '2022-01-08 20:50:24', '2022-01-10 10:20:03', '2022-01-10 10:20:03'),
(22, 8, 8, 'f', '2022-01-08 20:50:47', '2022-01-10 10:20:03', '2022-01-10 10:20:03'),
(23, 8, 8, 'sd', '2022-01-08 20:51:49', '2022-01-10 10:20:03', '2022-01-10 10:20:03'),
(24, 8, 8, 'sdf', '2022-01-08 20:52:00', '2022-01-10 10:20:03', '2022-01-10 10:20:03'),
(25, 8, 8, 'fd\\', '2022-01-08 20:54:39', '2022-01-10 10:20:03', '2022-01-10 10:20:03'),
(26, 8, 8, 'tes', '2022-01-10 10:19:44', '2022-01-10 10:20:03', '2022-01-10 10:20:03'),
(27, 9, 8, 'tes', '2022-01-10 10:25:28', '2022-01-10 10:29:36', '2022-01-10 10:29:36'),
(28, 12, 8, 'sdf', '2022-01-10 10:46:55', '2022-01-10 10:47:00', '2022-01-10 10:47:00'),
(29, 14, 8, 'tes', '2022-01-10 10:55:24', '2022-01-10 10:55:29', '2022-01-10 10:55:29'),
(30, 18, 7, 'tes', '2022-01-10 11:25:04', '2022-01-10 11:31:25', '2022-01-10 11:31:25'),
(31, 18, 8, 'hehe', '2022-01-10 11:31:18', '2022-01-10 11:31:25', '2022-01-10 11:31:25'),
(32, 25, 8, 'te', '2022-01-13 10:07:29', '2022-01-13 10:35:25', '2022-01-13 10:35:25'),
(33, 25, 8, 'tes lagi', '2022-01-13 10:28:10', '2022-01-13 10:35:25', '2022-01-13 10:35:25'),
(34, 25, 8, 'tes', '2022-01-13 10:29:49', '2022-01-13 10:35:25', '2022-01-13 10:35:25'),
(35, 24, 8, 'tes dong', '2022-01-13 10:33:47', '2022-01-13 10:35:14', '2022-01-13 10:35:14'),
(36, 24, 8, 'tes lagi', '2022-01-13 10:35:07', '2022-01-13 10:35:14', '2022-01-13 10:35:14'),
(37, 56, 8, 'chat', '2022-01-13 13:21:34', '2022-01-13 13:23:04', '2022-01-13 13:23:04'),
(38, 60, 7, 'tes min', '2022-01-13 13:42:50', '2022-01-13 13:54:17', '2022-01-13 13:54:17'),
(39, 60, 7, 'tes min', '2022-01-13 13:50:27', '2022-01-13 13:54:17', '2022-01-13 13:54:17'),
(40, 60, 7, 'tes lagi min', '2022-01-13 13:50:57', '2022-01-13 13:54:17', '2022-01-13 13:54:17'),
(41, 60, 7, 'tes min 2', '2022-01-13 13:52:10', '2022-01-13 13:54:17', '2022-01-13 13:54:17'),
(42, 60, 7, 'tes', '2022-01-13 13:53:39', '2022-01-13 13:54:17', '2022-01-13 13:54:17'),
(43, 60, 8, 'tes jugkkk', '2022-01-13 13:53:57', '2022-01-13 13:54:17', '2022-01-13 13:54:17'),
(44, 72, 8, 'halo', '2022-01-21 05:31:04', '2022-01-21 05:33:16', '2022-01-21 05:33:16'),
(45, 72, 8, 'hai', '2022-01-21 05:31:13', '2022-01-21 05:33:16', '2022-01-21 05:33:16'),
(46, 72, 8, 'apakah ada yang dibantu', '2022-01-21 05:31:27', '2022-01-21 05:33:16', '2022-01-21 05:33:16'),
(47, 72, 8, 'aku ingin memesan', '2022-01-21 05:32:54', '2022-01-21 05:33:16', '2022-01-21 05:33:16');

-- --------------------------------------------------------

--
-- Table structure for table `chat_bot`
--

CREATE TABLE `chat_bot` (
  `id_chat_bot` bigint(20) UNSIGNED NOT NULL,
  `prioritas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_bot`
--

INSERT INTO `chat_bot` (`id_chat_bot`, `prioritas`, `judul`, `chat`, `keyword`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '100', 'welcome', 'selamat datang ke mita kak :)', 'welcome bot', '2022-01-05 23:09:30', '2022-01-05 23:09:30', NULL),
(2, '100', 'automate after welcome', 'ada yang bisa dibantu ?', 'ada yang bisa dibantu', '2022-01-05 23:11:03', '2022-01-06 06:24:53', '2022-01-06 06:24:53'),
(3, NULL, NULL, 'Untuk menghubungi Costumer service klik tombol  \"Sambungkan ke costumer service\" di sebelah namaa', 'cs,costumer service,mau tanya,bertanya,tanya,/cs', '2022-01-05 23:42:27', '2022-01-07 03:09:26', NULL),
(4, NULL, NULL, '<p><b>Menu :&nbsp;</b></p><ul><li>/menu list command</li><li>/cs cara contact cs</li></ul>', '/help,/cmd,/command,/menu', '2022-01-07 03:14:53', '2022-01-19 14:03:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chat_sesi`
--

CREATE TABLE `chat_sesi` (
  `id_chat_sesi` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_admin` bigint(20) UNSIGNED NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1. tidak terkoneksi, 2. terkoneksi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_sesi`
--

INSERT INTO `chat_sesi` (`id_chat_sesi`, `id_user`, `id_admin`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 7, 8, '1', '2022-01-08 00:37:18', '2022-01-08 05:53:13', '2022-01-08 05:53:13'),
(3, 7, 8, '1', '2022-01-08 08:27:25', '2022-01-08 10:02:16', '2022-01-08 10:02:16'),
(4, 7, 8, '1', '2022-01-08 10:02:56', '2022-01-08 12:31:03', '2022-01-08 12:31:03'),
(5, 7, 8, '1', '2022-01-08 12:38:52', '2022-01-08 12:54:34', '2022-01-08 12:54:34'),
(6, 7, 8, '1', '2022-01-08 13:05:11', '2022-01-08 13:13:54', '2022-01-08 13:13:54'),
(7, 7, 8, '1', '2022-01-08 20:07:21', '2022-01-08 20:10:41', '2022-01-08 20:10:41'),
(8, 7, 8, '1', '2022-01-08 20:47:05', '2022-01-10 10:20:03', '2022-01-10 10:20:03'),
(9, 7, 8, '1', '2022-01-10 10:25:09', '2022-01-10 10:29:36', '2022-01-10 10:29:36'),
(10, 7, 8, '1', '2022-01-10 10:30:26', '2022-01-10 10:31:20', '2022-01-10 10:31:20'),
(11, 7, 8, '1', '2022-01-10 10:31:45', '2022-01-10 10:37:38', '2022-01-10 10:37:38'),
(12, 7, 8, '1', '2022-01-10 10:44:26', '2022-01-10 10:47:00', '2022-01-10 10:47:00'),
(13, 7, 8, '1', '2022-01-10 10:51:27', '2022-01-10 10:53:22', '2022-01-10 10:53:22'),
(14, 7, 8, '1', '2022-01-10 10:54:18', '2022-01-10 10:55:29', '2022-01-10 10:55:29'),
(15, 7, 8, '1', '2022-01-10 10:55:47', '2022-01-10 10:56:41', '2022-01-10 10:56:41'),
(16, 7, 8, '1', '2022-01-10 10:56:59', '2022-01-10 10:59:51', '2022-01-10 10:59:51'),
(17, 7, 8, '1', '2022-01-10 10:59:57', '2022-01-10 11:01:19', '2022-01-10 11:01:19'),
(18, 7, 8, '1', '2022-01-10 11:24:46', '2022-01-10 11:31:25', '2022-01-10 11:31:25'),
(19, 7, 8, '1', '2022-01-10 11:31:34', '2022-01-10 11:42:44', '2022-01-10 11:42:44'),
(20, 7, 8, '1', '2022-01-10 12:54:01', '2022-01-10 12:57:46', '2022-01-10 12:57:46'),
(21, 7, 8, '1', '2022-01-10 12:57:54', '2022-01-10 13:00:16', '2022-01-10 13:00:16'),
(22, 7, 8, '1', '2022-01-10 13:10:19', '2022-01-10 13:32:50', '2022-01-10 13:32:50'),
(23, 7, 8, '1', '2022-01-10 13:34:59', '2022-01-10 13:41:07', '2022-01-10 13:41:07'),
(24, 7, 8, '1', '2022-01-10 13:41:41', '2022-01-13 10:35:14', '2022-01-13 10:35:14'),
(25, 9, 8, '1', '2022-01-13 10:04:47', '2022-01-13 10:35:25', '2022-01-13 10:35:25'),
(26, 9, 8, '1', '2022-01-13 10:56:08', '2022-01-13 11:07:55', '2022-01-13 11:07:55'),
(27, 7, 8, '1', '2022-01-13 11:08:43', '2022-01-13 11:09:30', '2022-01-13 11:09:30'),
(28, 7, 8, '1', '2022-01-13 11:10:31', '2022-01-13 11:21:45', '2022-01-13 11:21:45'),
(29, 9, 8, '1', '2022-01-13 11:30:13', '2022-01-13 11:31:49', '2022-01-13 11:31:49'),
(30, 7, 8, '1', '2022-01-13 11:33:01', '2022-01-13 11:37:35', '2022-01-13 11:37:35'),
(31, 7, 8, '1', '2022-01-13 11:38:05', '2022-01-13 11:40:14', '2022-01-13 11:40:14'),
(32, 7, 8, '1', '2022-01-13 11:40:19', '2022-01-13 11:51:47', '2022-01-13 11:51:47'),
(33, 9, 8, '1', '2022-01-13 11:52:23', '2022-01-13 11:54:14', '2022-01-13 11:54:14'),
(34, 7, 8, '1', '2022-01-13 11:54:29', '2022-01-13 11:56:15', '2022-01-13 11:56:15'),
(35, 7, 8, '1', '2022-01-13 11:56:39', '2022-01-13 12:00:49', '2022-01-13 12:00:49'),
(36, 9, 8, '1', '2022-01-13 11:59:41', '2022-01-13 12:00:44', '2022-01-13 12:00:44'),
(37, 9, 8, '1', '2022-01-13 12:02:25', '2022-01-13 12:12:17', '2022-01-13 12:12:17'),
(38, 7, 8, '1', '2022-01-13 12:09:22', '2022-01-13 12:13:24', '2022-01-13 12:13:24'),
(39, 7, 8, '1', '2022-01-13 12:13:45', '2022-01-13 12:22:03', '2022-01-13 12:22:03'),
(40, 7, 8, '1', '2022-01-13 12:22:22', '2022-01-13 12:26:44', '2022-01-13 12:26:44'),
(41, 7, 8, '1', '2022-01-13 12:26:49', '2022-01-13 12:27:39', '2022-01-13 12:27:39'),
(42, 7, 8, '1', '2022-01-13 12:28:18', '2022-01-13 12:30:27', '2022-01-13 12:30:27'),
(43, 7, 8, '1', '2022-01-13 12:30:32', '2022-01-13 12:34:36', '2022-01-13 12:34:36'),
(44, 9, 8, '1', '2022-01-13 12:40:23', '2022-01-13 12:46:14', '2022-01-13 12:46:14'),
(45, 7, 8, '1', '2022-01-13 12:42:53', '2022-01-13 12:46:10', '2022-01-13 12:46:10'),
(46, 7, 8, '1', '2022-01-13 12:47:06', '2022-01-13 12:54:27', '2022-01-13 12:54:27'),
(47, 9, 8, '1', '2022-01-13 12:47:26', '2022-01-13 12:54:20', '2022-01-13 12:54:20'),
(48, 7, 8, '1', '2022-01-13 12:58:44', '2022-01-13 12:59:43', '2022-01-13 12:59:43'),
(49, 7, 8, '1', '2022-01-13 13:06:34', '2022-01-13 13:07:42', '2022-01-13 13:07:42'),
(50, 7, 8, '1', '2022-01-13 13:10:56', '2022-01-13 13:12:45', '2022-01-13 13:12:45'),
(51, 7, 8, '1', '2022-01-13 13:13:17', '2022-01-13 13:14:40', '2022-01-13 13:14:40'),
(52, 7, 8, '1', '2022-01-13 13:14:49', '2022-01-13 13:15:10', '2022-01-13 13:15:10'),
(53, 7, 8, '1', '2022-01-13 13:15:27', '2022-01-13 13:15:39', '2022-01-13 13:15:39'),
(54, 7, 8, '1', '2022-01-13 13:16:10', '2022-01-13 13:17:08', '2022-01-13 13:17:08'),
(55, 7, 8, '1', '2022-01-13 13:17:36', '2022-01-13 13:18:08', '2022-01-13 13:18:08'),
(56, 7, 8, '1', '2022-01-13 13:19:29', '2022-01-13 13:23:04', '2022-01-13 13:23:04'),
(57, 7, 8, '1', '2022-01-13 13:23:10', '2022-01-13 13:25:49', '2022-01-13 13:25:49'),
(58, 7, 8, '1', '2022-01-13 13:37:24', '2022-01-13 13:39:37', '2022-01-13 13:39:37'),
(59, 7, 8, '1', '2022-01-13 13:39:42', '2022-01-13 13:42:23', '2022-01-13 13:42:23'),
(60, 7, 8, '1', '2022-01-13 13:42:29', '2022-01-13 13:54:18', '2022-01-13 13:54:18'),
(61, 7, 8, '1', '2022-01-13 13:54:22', '2022-01-13 13:54:29', '2022-01-13 13:54:29'),
(62, 7, 8, '1', '2022-01-14 05:08:27', '2022-01-14 05:08:43', '2022-01-14 05:08:43'),
(63, 7, 8, '1', '2022-01-14 05:13:39', '2022-01-14 05:14:33', '2022-01-14 05:14:33'),
(64, 7, 8, '1', '2022-01-14 05:14:50', '2022-01-14 05:17:01', '2022-01-14 05:17:01'),
(65, 7, 8, '1', '2022-01-14 05:17:04', '2022-01-14 05:19:09', '2022-01-14 05:19:09'),
(66, 7, 8, '1', '2022-01-14 05:19:20', '2022-01-14 05:19:26', '2022-01-14 05:19:26'),
(67, 7, 8, '1', '2022-01-14 05:19:31', '2022-01-14 05:19:38', '2022-01-14 05:19:38'),
(68, 7, 8, '1', '2022-01-14 05:24:39', '2022-01-14 05:24:53', '2022-01-14 05:24:53'),
(69, 7, 8, '1', '2022-01-14 05:26:53', '2022-01-14 06:58:14', '2022-01-14 06:58:14'),
(70, 7, 8, '1', '2022-01-14 07:00:34', '2022-01-14 07:00:43', '2022-01-14 07:00:43'),
(71, 7, 8, '1', '2022-01-20 13:49:24', '2022-01-20 13:50:02', '2022-01-20 13:50:02'),
(72, 8, 8, '1', '2022-01-21 05:30:36', '2022-01-21 05:33:16', '2022-01-21 05:33:16');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail_pesanan` bigint(20) UNSIGNED NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `kode_pesanan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_harga` bigint(20) NOT NULL COMMENT 'kuantitas*harga',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail_pesanan`, `kuantitas`, `id_produk`, `kode_pesanan`, `total_harga`, `deleted_at`) VALUES
(56, 1, 9, 'OD-2022012961F53F5E108C5-0895355094422', 200000, NULL),
(57, 1, 13, 'OD-2022012961F54055391BE-0895355094422', 150000, NULL),
(58, 1, 9, 'OD-2022013061F6DBD30DDE4-0895355094422', 200000, NULL),
(59, 1, 11, 'OD-2022013061F6DBD30DDE4-0895355094422', 150000, NULL),
(60, 1, 10, 'OD-2022013061F6DBD30DDE4-0895355094422', 250000, NULL),
(61, 6, 10, 'OD-2022020261FA6088459C6-0895355094422', 1500000, NULL),
(62, 1, 11, 'OD-2022020261FA6088459C6-0895355094422', 150000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'TENDA', '2021-12-11 05:01:58', '2021-12-11 05:01:58', NULL),
(2, 'MEJA', '2021-12-26 02:17:19', '2021-12-26 02:17:19', NULL),
(3, 'KURSI', '2021-12-26 02:18:19', '2021-12-26 02:18:19', NULL),
(4, 'GERABAH', '2021-12-26 02:18:19', '2021-12-26 02:18:19', NULL),
(5, 'PANGGUNG & SOUND', '2021-12-26 02:18:19', '2021-12-26 02:18:19', NULL),
(8, 'PAKET', '2021-12-26 06:34:59', '2021-12-26 06:34:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kuantitas` int(11) NOT NULL DEFAULT 1,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id`, `kuantitas`, `id_user`, `id_produk`, `tanggal_mulai`, `tanggal_selesai`, `created_at`, `updated_at`) VALUES
(58, 3, 8, 9, NULL, NULL, '2022-01-21 04:49:54', '2022-01-21 05:44:46'),
(59, 2, 8, 10, NULL, NULL, '2022-01-21 04:50:43', '2022-01-21 05:44:46');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2021_12_05_091452_create_profiles_table', 2),
(7, '2021_12_05_125116_create_user_roles_table', 3),
(9, '2021_12_05_125832_create_user_roles_pivot_table', 4),
(10, '2021_12_11_094258_create_kategori_table', 5),
(11, '2021_12_11_094619_create_produk_table', 6),
(12, '2021_12_11_150102_unique_nama_kategori', 7),
(13, '2021_12_28_163544_create_keranjang_table', 8),
(17, '2021_12_31_144537_create_pesanan_table', 9),
(20, '2021_12_31_150032_create_pembayaran_table', 10),
(21, '2021_12_31_152924_create_detail_pesanan_table', 11),
(22, '2022_01_01_005134_add_duration', 12),
(23, '2022_01_01_020908_add_pending_bayar', 13),
(25, '2022_01_06_042508_create_chat_bot_table', 14),
(26, '2022_01_06_054140_add_column_judul_priority__chat_bot_table', 15),
(32, '2022_01_06_123813_create_chat_sesi_table', 16),
(33, '2022_01_06_124111_create_chat_table', 16),
(34, '2022_01_08_131432_add_user_column', 17),
(35, '2022_01_18_194701_create_sewa_table', 18),
(36, '2022_01_19_162334_create_notifications_table', 19),
(37, '2022_02_01_195236_add_duration_keranjang', 20);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0ea1d33a-cd57-4890-bc28-003f67775611', 'App\\Notifications\\Order\\PaymentVerifiedNotification', 'App\\Models\\User', 7, '{\"kode_pembayaran\":\"PAY-61F540553FB38-0895355094422-20220129\",\"text\":\"Yeay pembayaran <span class=\\\"tx-medium\\\">Full<\\/span> untuk pesanan OD-2022012961F54055391BE-0895355094422 diverifikasi.\"}', '2022-01-29 06:35:21', '2022-01-29 06:35:16', '2022-01-29 06:35:21'),
('3a5c54a6-bf49-4838-a247-d2ed469bb7a3', 'App\\Notifications\\Order\\ShipmentNotification', 'App\\Models\\User', 7, '{\"id_sewa\":13,\"text\":\"Pesananmu dikirim\"}', '2022-02-02 04:04:51', '2022-02-02 04:04:39', '2022-02-02 04:04:51'),
('614cec81-0e5f-49fe-814a-aed1d2ee153e', 'App\\Notifications\\Order\\ShipmentNotification', 'App\\Models\\User', 7, '{\"id_sewa\":11,\"text\":\"Pesananmu dikirim\"}', '2022-01-29 09:18:50', '2022-01-29 09:18:43', '2022-01-29 09:18:50'),
('729f85c9-6bcd-4c35-85a0-5f3f200de4e4', 'App\\Notifications\\Order\\ShipmentNotification', 'App\\Models\\User', 7, '{\"id_sewa\":11,\"text\":\"Pesananmu dikirim\"}', '2022-01-29 09:21:08', '2022-01-29 09:21:00', '2022-01-29 09:21:08'),
('74588ade-e708-4a84-8e07-4392ef099607', 'App\\Notifications\\Order\\PaymentVerifiedNotification', 'App\\Models\\User', 7, '{\"kode_pembayaran\":\"PAY-61F6DBD325CB9-0895355094422-20220130\",\"text\":\"Yeay pembayaran <span class=\\\"tx-medium\\\">Full<\\/span> untuk pesanan OD-2022013061F6DBD30DDE4-0895355094422 diverifikasi.\"}', '2022-01-30 11:49:40', '2022-01-30 11:49:36', '2022-01-30 11:49:40'),
('8cb8c2a4-89a9-420d-8364-4cb51c1e39bb', 'App\\Notifications\\Order\\PaymentVerifiedNotification', 'App\\Models\\User', 7, '{\"kode_pembayaran\":\"PAY-61FA60886DE58-0895355094422-20220202\",\"text\":\"Yeay pembayaran <span class=\\\"tx-medium\\\">Full<\\/span> untuk pesanan OD-2022020261FA6088459C6-0895355094422 diverifikasi.\"}', '2022-02-02 03:56:47', '2022-02-02 03:56:43', '2022-02-02 03:56:47'),
('91b37d1c-a5d7-4203-ba19-47547909998a', 'App\\Notifications\\Order\\ShipmentNotification', 'App\\Models\\User', 7, '{\"id_sewa\":11,\"text\":\"Pesananmu dikirim\"}', '2022-01-29 06:51:34', '2022-01-29 06:50:41', '2022-01-29 06:51:34'),
('be958e4c-6426-4d23-b07f-11b046b0e17c', 'App\\Notifications\\Order\\ShipmentNotification', 'App\\Models\\User', 7, '{\"id_sewa\":11,\"text\":\"Pesananmu dikirim\"}', '2022-01-29 06:51:33', '2022-01-29 06:51:28', '2022-01-29 06:51:33'),
('e3465652-bf34-4e9a-9157-e99cf15ee5a1', 'App\\Notifications\\Order\\PaymentVerifiedNotification', 'App\\Models\\User', 7, '{\"kode_pembayaran\":\"PAY-61EDBBBE01DD5-0895355094422-20220123\",\"text\":\"Yeay pembayaran <span class=\\\"tx-medium\\\">Full<\\/span> untuk pesanan OD-2022012361EDBBBDE910A-0895355094422 diverifikasi.\"}', '2022-01-29 06:04:47', '2022-01-29 06:04:34', '2022-01-29 06:04:47');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `kode_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `snap_token` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_bayar` bigint(20) NOT NULL,
  `jenis_pembayaran` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Bank, Official Store, dll.',
  `tipe_pembayaran` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=dp, 2=full',
  `status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=pending, 2=sukses, 3=kedaluarsa',
  `kode_pesanan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`kode_pembayaran`, `snap_token`, `total_bayar`, `jenis_pembayaran`, `tipe_pembayaran`, `status`, `kode_pesanan`, `created_at`, `updated_at`, `deleted_at`) VALUES
('PAY-61F53F5E15EB7-0895355094422-20220129', '', 0, NULL, '1', '2', 'OD-2022012961F53F5E108C5-0895355094422', '2022-01-29 06:21:34', '2022-01-29 06:21:34', NULL),
('PAY-61F53F5E1B0C0-0895355094422-20220129', '95d4ad5e-5735-4d94-94ea-718992500743', 200000, NULL, '2', '1', 'OD-2022012961F53F5E108C5-0895355094422', '2022-01-29 06:21:34', '2022-01-29 06:21:35', NULL),
('PAY-61F540553F750-0895355094422-20220129', '', 0, NULL, '1', '2', 'OD-2022012961F54055391BE-0895355094422', '2022-01-29 06:25:41', '2022-01-29 06:25:41', NULL),
('PAY-61F540553FB38-0895355094422-20220129', '0da0f5ab-ae21-4252-b4a2-be1b4957f15f', 150000, 'cstore', '2', '2', 'OD-2022012961F54055391BE-0895355094422', '2022-01-29 06:25:41', '2022-01-29 06:35:15', NULL),
('PAY-61F6DBD324931-0895355094422-20220130', '', 0, NULL, '1', '2', 'OD-2022013061F6DBD30DDE4-0895355094422', '2022-01-30 11:41:23', '2022-01-30 11:41:23', NULL),
('PAY-61F6DBD325CB9-0895355094422-20220130', '21ba6724-733a-4a18-a405-521f7a27e6c2', 600000, 'cstore', '2', '2', 'OD-2022013061F6DBD30DDE4-0895355094422', '2022-01-30 11:41:23', '2022-01-30 11:49:35', NULL),
('PAY-61FA608861335-0895355094422-20220202', '', 0, NULL, '1', '2', 'OD-2022020261FA6088459C6-0895355094422', '2022-02-02 03:44:24', '2022-02-02 03:44:24', NULL),
('PAY-61FA60886DE58-0895355094422-20220202', '8315a69d-2aca-4c59-a32e-26d2fb0c530c', 1650000, 'cstore', '2', '2', 'OD-2022020261FA6088459C6-0895355094422', '2022-02-02 03:44:24', '2022-02-02 03:56:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `kode_pesanan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `status` enum('1','2','3','4','5','6') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1=menunggu pembayaran, 2=pembayaran_dp, \r\n3=sukses, \r\n4=kadaluarsa,\r\n5=batal',
  `total_bayar` int(11) NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`kode_pesanan`, `tanggal_selesai`, `tanggal_mulai`, `status`, `total_bayar`, `id_user`, `created_at`, `updated_at`, `deleted_at`) VALUES
('OD-2022012961F53F5E108C5-0895355094422', '2022-02-09', '2022-02-03', '1', 200000, 7, '2022-01-29 06:21:34', '2022-01-29 06:21:34', NULL),
('OD-2022012961F54055391BE-0895355094422', '2022-02-22', '2022-02-15', '3', 150000, 7, '2022-01-29 06:25:41', '2022-01-29 06:35:15', NULL),
('OD-2022013061F6DBD30DDE4-0895355094422', '2022-02-05', '2022-02-02', '3', 600000, 7, '2022-01-30 11:41:23', '2022-01-30 11:49:35', NULL),
('OD-2022020261FA6088459C6-0895355094422', '2022-02-25', '2022-02-18', '3', 1650000, 7, '2022-02-02 03:44:24', '2022-02-02 03:56:42', NULL);

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
(9, '61c86d422ca62', 'Tenda 6x6', 'mita_img_164052508361c86d1b4c971.jpg', '', 200000, 2, 1, '2021-12-26 06:24:43', '2022-01-23 13:28:51', NULL),
(10, '61c86dd5193f7', 'Tenda Plafon 6x6', 'mita_img_164052526961c86dd5177a3.jpg', '', 250000, 8, 1, '2021-12-26 06:27:49', '2022-01-29 06:04:33', NULL),
(11, '61c9ad977683e', 'Tenda 4x6', 'mita_img_164060712761c9ad97126e4.jpg', '', 150000, 10, 1, '2021-12-27 05:12:07', '2021-12-27 05:12:07', NULL),
(12, '61c9adbe76020', 'Tenda Plafon 4x6', 'mita_img_164060716661c9adbe741f2.jpg', '', 200000, 10, 1, '2021-12-27 05:12:46', '2021-12-27 05:12:46', NULL),
(13, '61c9ae0f7ef9b', 'Tenda 3x6', 'mita_img_164060724761c9ae0f7c9a2.jpg', '', 150000, 9, 1, '2021-12-27 05:14:07', '2022-01-29 06:35:15', NULL),
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
(35, '61c9b9a2090cd', 'Meja Kecil', 'mita_img_164061021061c9b9a2054ad.jpg', '', 7000, 38, 2, '2021-12-27 06:03:30', '2022-01-19 10:35:32', NULL),
(36, '61c9b9ffa7a41', 'Meja bulat', 'mita_img_164061030361c9b9ffa59fb.jpg', '', 35000, 40, 2, '2021-12-27 06:05:03', '2021-12-27 06:05:03', NULL),
(37, '61c9ba5c68038', 'Meja sedang', 'mita_img_164061039661c9ba5c64f9c.jpg', '', 40000, 50, 2, '2021-12-27 06:06:36', '2021-12-27 06:06:36', NULL),
(38, '61c9bb454669a', 'Meja Prasmanan', 'mita_img_164061062961c9bb4543de3.JPG', '', 50000, 50, 2, '2021-12-27 06:10:29', '2021-12-27 06:10:29', NULL),
(39, '61c9bcd61b805', 'Panggung 4x6', 'mita_img_164061102161c9bccd4f0fc.jpg', '', 500000, 9, 5, '2021-12-27 06:17:01', '2022-01-19 10:32:18', NULL),
(41, '61c9bd70c2f8a', 'Sound system', 'mita_img_164061118461c9bd70c0881.jpg', '', 900000, 10, 5, '2021-12-27 06:19:44', '2022-01-19 10:28:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id_profile` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kodepos` int(11) DEFAULT NULL,
  `pekerjaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id_profile`, `nama`, `telepon`, `tanggal_lahir`, `alamat`, `kodepos`, `pekerjaan`, `photo`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 'moch reza', '0895355094422', '2022-01-04', 'sleman, Yogyakarta', 213123, 'prelancer', 'mita_user_img_164148958161d724adeaa65.jpeg', 7, '2021-12-01 15:19:27', '2022-01-06 10:19:42'),
(2, 'lia', '0976545756', '2022-01-19', 'lorem ipsum lorem ipsum lorem ipsum', 60273, 'mahasiswa', NULL, 8, '2021-12-01 15:19:27', '2022-01-21 05:14:08'),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, '2021-12-29 08:34:29', '2021-12-29 08:34:29'),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, '2022-01-06 06:27:31', '2022-01-06 06:27:31'),
(5, 'oni chan', NULL, NULL, NULL, NULL, NULL, NULL, 11, '2022-02-02 04:11:29', '2022-02-02 04:11:29'),
(6, 'Zakia', NULL, NULL, NULL, NULL, NULL, NULL, 12, '2022-02-02 05:44:37', '2022-02-02 05:44:37');

-- --------------------------------------------------------

--
-- Table structure for table `sewa`
--

CREATE TABLE `sewa` (
  `id_sewa` bigint(20) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL COMMENT '1. disiapkan, 2. dikirim, 3. disewa, 4. selesai',
  `kode_pesanan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_pengiriman` timestamp NULL DEFAULT NULL,
  `waktu_pengembalian` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sewa`
--

INSERT INTO `sewa` (`id_sewa`, `status`, `kode_pesanan`, `waktu_pengiriman`, `waktu_pengembalian`, `deleted_at`) VALUES
(11, 4, 'OD-2022012961F54055391BE-0895355094422', '2022-01-29 09:21:00', '2022-02-02 04:06:04', NULL),
(12, 4, 'OD-2022013061F6DBD30DDE4-0895355094422', NULL, '2022-02-02 04:09:32', NULL),
(13, 4, 'OD-2022020261FA6088459C6-0895355094422', '2022-02-02 04:04:39', '2022-02-02 04:09:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  `online` int(11) NOT NULL COMMENT '0. tidak online 1. online',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `email`, `email_verified_at`, `password`, `role`, `online`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 'hikmalkoko3@gmail.com', '2022-01-23 11:50:28', '$2y$10$UGctWTpm23g4tEtj5pFRQ.OOwteG2t2gsQrzBW8fXoxJ.zNWvAkFW', -1, 0, NULL, '2021-12-13 00:24:10', '2022-02-02 04:10:50', NULL),
(8, 'admin@admin', NULL, '$2y$10$gsJyvYk6ofp9lmUGE.Lco.3mG00JOkXenqk.pO95a5hrxAeHcUaVq', -1, 1, NULL, '2021-12-13 00:24:29', '2022-01-29 06:43:06', NULL),
(9, 'hikmalkoko4@gmail.com', NULL, '$2y$10$A0Pu3DS4U9hhN/lhNjH/DOY8FqdPWG9SkEwOBmhp2Glo6U8Jcjgii', -1, 1, NULL, '2021-12-29 08:34:29', '2021-12-29 08:34:37', NULL),
(10, 'admin2@admin', NULL, '$2y$10$x7AdJApje2fiMckXr60roeO0.eWxH8HSs9Y8aPPFCwrE7EAVod3im', -1, 0, NULL, '2022-01-06 06:27:31', '2022-01-21 05:21:39', NULL),
(11, 'hikmalkoko21@gmail.com', NULL, '$2y$10$Z3AzGaetJtlW.qm9uewVz.n1pjcgUh48Gkm95PR1vmgW3SKUSuFQm', -1, 0, NULL, '2022-02-02 04:11:29', '2022-02-02 04:28:30', NULL),
(12, 'aprilia10april@gmail.com', NULL, '$2y$10$z2ATp/2lXuXdH9n0QOOz6u4vUZrkLxBDTmLGydCS45ua9cX76gUS6', -1, 1, NULL, '2022-02-02 05:44:37', '2022-02-02 05:46:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id_role` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id_role`, `nama`, `tipe`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'dasar', '1', NULL, '0', NULL, NULL),
(2, 'admin', '2', NULL, '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles_pivot`
--

CREATE TABLE `user_roles_pivot` (
  `id_role_pivot` bigint(20) UNSIGNED NOT NULL,
  `id_role` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles_pivot`
--

INSERT INTO `user_roles_pivot` (`id_role_pivot`, `id_role`, `id_user`, `created_at`, `updated_at`) VALUES
(3, 1, 7, '2021-12-13 00:24:10', '2021-12-13 00:24:10'),
(4, 1, 8, '2021-12-13 00:24:29', '2021-12-13 00:24:29'),
(5, 2, 8, '2021-12-13 00:24:29', '2021-12-13 00:24:29'),
(6, 1, 9, '2021-12-29 08:34:29', '2021-12-29 08:34:29'),
(7, 1, 10, '2022-01-06 06:27:31', '2022-01-06 06:27:31'),
(8, 2, 10, '2022-01-06 13:28:25', '2022-01-06 13:28:25'),
(9, 1, 11, '2022-02-02 04:11:29', '2022-02-02 04:11:29'),
(10, 2, 9, '2022-02-02 04:36:32', '2022-02-02 04:36:32'),
(11, 1, 12, '2022-02-02 05:44:37', '2022-02-02 05:44:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `chat_id_chat_sesi_foreign` (`id_chat_sesi`);

--
-- Indexes for table `chat_bot`
--
ALTER TABLE `chat_bot`
  ADD PRIMARY KEY (`id_chat_bot`);

--
-- Indexes for table `chat_sesi`
--
ALTER TABLE `chat_sesi`
  ADD PRIMARY KEY (`id_chat_sesi`),
  ADD KEY `chat_sesi_id_user_foreign` (`id_user`),
  ADD KEY `chat_sesi_id_admin_foreign` (`id_admin`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail_pesanan`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keranjang_id_user_foreign` (`id_user`),
  ADD KEY `keranjang_id_produk_foreign` (`id_produk`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`kode_pembayaran`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`kode_pesanan`),
  ADD KEY `pesanan_id_user_foreign` (`id_user`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `produk_id_kategori_foreign` (`id_kategori`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id_profile`),
  ADD KEY `profiles_id_user_foreign` (`id_user`);

--
-- Indexes for table `sewa`
--
ALTER TABLE `sewa`
  ADD PRIMARY KEY (`id_sewa`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `user_roles_pivot`
--
ALTER TABLE `user_roles_pivot`
  ADD PRIMARY KEY (`id_role_pivot`),
  ADD KEY `user_roles_pivot_id_role_foreign` (`id_role`),
  ADD KEY `user_roles_pivot_id_user_foreign` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `chat_bot`
--
ALTER TABLE `chat_bot`
  MODIFY `id_chat_bot` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chat_sesi`
--
ALTER TABLE `chat_sesi`
  MODIFY `id_chat_sesi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail_pesanan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id_profile` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sewa`
--
ALTER TABLE `sewa`
  MODIFY `id_sewa` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id_role` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_roles_pivot`
--
ALTER TABLE `user_roles_pivot`
  MODIFY `id_role_pivot` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_id_chat_sesi_foreign` FOREIGN KEY (`id_chat_sesi`) REFERENCES `chat_sesi` (`id_chat_sesi`);

--
-- Constraints for table `chat_sesi`
--
ALTER TABLE `chat_sesi`
  ADD CONSTRAINT `chat_sesi_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `chat_sesi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`),
  ADD CONSTRAINT `keranjang_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON UPDATE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `user_roles_pivot`
--
ALTER TABLE `user_roles_pivot`
  ADD CONSTRAINT `user_roles_pivot_id_role_foreign` FOREIGN KEY (`id_role`) REFERENCES `user_roles` (`id_role`),
  ADD CONSTRAINT `user_roles_pivot_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
