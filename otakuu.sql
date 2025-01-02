-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 09:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `otak-otak`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Id_Admin` int(11) NOT NULL,
  `Nama_Admin` varchar(100) NOT NULL,
  `Email_Admin` varchar(100) NOT NULL,
  `Password_Admin` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Id_Admin`, `Nama_Admin`, `Email_Admin`, `Password_Admin`, `created_at`) VALUES
(52, 'admin', 'admin@admin', '$2y$10$kHo1KUT9fdy1hbFp8mjXJOKEB4joBAA7mrNhulf7.GtZfSOBvK4MG', '2024-12-18 05:18:48');

-- --------------------------------------------------------

--
-- Table structure for table `mitra`
--

CREATE TABLE `mitra` (
  `Id_Mitra` int(11) NOT NULL,
  `Nama_Mitra` varchar(100) NOT NULL,
  `Nik` varchar(50) NOT NULL,
  `Nama_Toko` varchar(100) NOT NULL,
  `Email_Mitra` varchar(100) NOT NULL,
  `Password_Mitra` varchar(255) NOT NULL,
  `Alamat_Mitra` text NOT NULL,
  `No_Hp_Mitra` varchar(15) NOT NULL,
  `Foto_Toko` blob DEFAULT NULL,
  `Status_Mitra` enum('menunggu','disetujui','ditolak') DEFAULT 'menunggu',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mitra`
--

INSERT INTO `mitra` (`Id_Mitra`, `Nama_Mitra`, `Nik`, `Nama_Toko`, `Email_Mitra`, `Password_Mitra`, `Alamat_Mitra`, `No_Hp_Mitra`, `Foto_Toko`, `Status_Mitra`, `created_at`) VALUES
(6, 'Bona', '1789273172300', 'Otak-Otak Mak Bona', 'rani123@mail.com', '$2y$10$TkaYN7xPRGIcGcm7bfK4h.dS7WubKBAMqgv7suMjoJPBpSo.LyG4y', 'Kijang Sungai 6', '0828888881818', 0x313733353733303638325f746f6b6f2e706e67, 'disetujui', '2025-01-01 11:24:42'),
(8, 'Intan', '178927317298', 'Otak-Otak Intan', 'rani123@gmail.com', '$2y$10$eUeI/hgVVh0sWvSXez7H5uAmBo5GY1kH0ilnKztExjEkZSRzQDqru', 'Kijang Sungai 6', '0828888884', 0x313733353733333534375f746f6b6f2e706e67, 'disetujui', '2025-01-01 12:12:27');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `Id_Pengguna` int(11) NOT NULL,
  `Nama_Pengguna` varchar(100) NOT NULL,
  `Email_Pengguna` varchar(100) NOT NULL,
  `Password_Pengguna` varchar(255) NOT NULL,
  `Alamat_Pengguna` text NOT NULL,
  `No_Hp_Pengguna` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`Id_Pengguna`, `Nama_Pengguna`, `Email_Pengguna`, `Password_Pengguna`, `Alamat_Pengguna`, `No_Hp_Pengguna`, `created_at`) VALUES
(6, 'Rani', 'rani@gmail.com', '$2y$10$1He8dopV5QNma28p5mrgcuM.C2ND64VkQo03.nkWREWX72.piPLze', 'kos oren', '0828888881818', '2025-01-01 08:53:10'),
(7, 'Saturn', 'rani123@gmail.com', '$2y$10$eF6BRKPRqfD.apI5Qg9emOFSVSFNUgfmb1UsiAXKwvnVAQYC0bUeK', 'kos oren1', '082888888123', '2025-01-01 10:31:58');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `Id_Produk` int(11) NOT NULL,
  `Id_Mitra` int(11) DEFAULT NULL,
  `Nama_Produk` varchar(100) DEFAULT NULL,
  `Foto_Produk` varchar(255) DEFAULT NULL,
  `Deskripsi` text DEFAULT NULL,
  `Harga` int(11) DEFAULT NULL,
  `Stok` int(11) DEFAULT NULL,
  `Status_Produk` enum('menunggu','terkonfirmasi','ditolak') DEFAULT 'menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`Id_Produk`, `Id_Mitra`, `Nama_Produk`, `Foto_Produk`, `Deskripsi`, `Harga`, `Stok`, `Status_Produk`) VALUES
(21, 6, 'Otak - Otak Bandeng', '1735731805_Otak-otak2.jpg', 'Tersedia Varian Ikan dan Sotong', 1500, 100, 'terkonfirmasi'),
(22, 8, 'Otak - Otak Bandeng Ikan', '1735733633_Otak-otak2.jpg', 'Rasanya Bervariasi Pedas Manis Asin dan Guruh', 1450, 100, 'terkonfirmasi'),
(23, 8, 'Otak - Otak Sotong', '1735787942_otak otak.jpg', 'No.Rek 2201029030330855', 1550, 100, 'terkonfirmasi');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `Id_Transaksi` int(11) NOT NULL,
  `Id_Pengguna` int(11) NOT NULL,
  `Id_Produk` int(11) NOT NULL,
  `Jumlah` decimal(10,2) NOT NULL,
  `Status_Pembayaran` enum('menunggu','terkonfirmasi','ditolak') DEFAULT 'menunggu',
  `Bukti_Pembayaran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Total_Harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`Id_Transaksi`, `Id_Pengguna`, `Id_Produk`, `Jumlah`, `Status_Pembayaran`, `Bukti_Pembayaran`, `created_at`, `Total_Harga`) VALUES
(10, 6, 21, 14.00, 'terkonfirmasi', '1735734804_Otak-otak2.jpg', '2025-01-01 12:33:24', 21000),
(14, 6, 21, 12.00, 'terkonfirmasi', '1735747167_Otak-otak2.jpg', '2025-01-01 15:59:27', 18000),
(15, 7, 21, 20.00, 'terkonfirmasi', '1735747269_Otak-otak2.jpg', '2025-01-01 16:01:09', 30000),
(16, 6, 23, 10.00, 'terkonfirmasi', '1735788158_Otak-otak2.jpg', '2025-01-02 03:22:38', 14500),
(17, 7, 23, 12.00, 'terkonfirmasi', '1735788297_toko.png', '2025-01-02 03:24:57', 17400),
(19, 7, 23, 12.00, 'ditolak', '1735793986_Otak-otak2.jpg', '2025-01-02 04:59:46', 18600),
(20, 7, 23, 8.00, 'terkonfirmasi', '1735794064_otak otak.jpg', '2025-01-02 05:01:04', 12400),
(21, 7, 23, 3.00, 'terkonfirmasi', '1735794425_otak otak.jpg', '2025-01-02 05:07:05', 4650),
(22, 7, 23, 3.00, 'terkonfirmasi', '1735795431_otak otak.jpg', '2025-01-02 05:23:51', 4650),
(23, 7, 23, 20.00, 'terkonfirmasi', '1735796174_Otak-otak2.jpg', '2025-01-02 05:36:14', 31000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Id_Admin`),
  ADD UNIQUE KEY `email` (`Email_Admin`);

--
-- Indexes for table `mitra`
--
ALTER TABLE `mitra`
  ADD PRIMARY KEY (`Id_Mitra`),
  ADD UNIQUE KEY `nik` (`Nik`),
  ADD UNIQUE KEY `email` (`Email_Mitra`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`Id_Pengguna`),
  ADD UNIQUE KEY `email` (`Email_Pengguna`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`Id_Produk`),
  ADD KEY `Id_Mitra` (`Id_Mitra`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`Id_Transaksi`),
  ADD KEY `id_pengguna` (`Id_Pengguna`),
  ADD KEY `id_produk` (`Id_Produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Id_Admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `mitra`
--
ALTER TABLE `mitra`
  MODIFY `Id_Mitra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `Id_Pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `Id_Produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `Id_Transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`Id_Mitra`) REFERENCES `mitra` (`Id_Mitra`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`Id_Pengguna`) REFERENCES `pengguna` (`Id_Pengguna`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`Id_Produk`) REFERENCES `produk` (`Id_Produk`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
