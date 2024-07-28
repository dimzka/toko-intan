-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2024 at 10:29 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pdintan`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id_cart`, `id_pelanggan`, `created_at`) VALUES
(2, 2, '2024-07-25 09:17:24'),
(5, 3, '2024-07-28 03:34:42');

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `id_cart_item` int(11) NOT NULL,
  `id_cart` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_item`
--

INSERT INTO `cart_item` (`id_cart_item`, `id_cart`, `id_produk`, `jumlah`) VALUES
(3, 2, 1, 1),
(4, 2, 2, 2),
(24, 5, 1, 2),
(25, 5, 2, 1),
(26, 5, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail_transaksi` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail_transaksi`, `id_transaksi`, `id_produk`, `jumlah`, `harga`) VALUES
(1, 1, 1, 2, 15000000),
(2, 1, 2, 3, 100000),
(3, 2, 1, 1, 15000000),
(4, 3, 1, 1, 10000),
(5, 3, 4, 1, 20000),
(6, 5, 1, 4, 10000),
(7, 5, 2, 1, 8000),
(8, 6, 1, 2, 10000),
(9, 6, 2, 5, 8000),
(10, 7, 1, 1, 10000),
(11, 7, 2, 2, 8000),
(12, 8, 1, 2, 10000),
(13, 8, 25, 1, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama`) VALUES
(1, 'Permen'),
(2, 'Snack'),
(3, 'Biskuit'),
(4, 'Sosis'),
(5, 'Mie Instan'),
(6, 'Wafer'),
(7, 'Roti'),
(8, 'Mashmallow'),
(9, 'Keju'),
(10, 'Kue Kering'),
(11, 'Cokelat'),
(12, 'Bubur Instan');

-- --------------------------------------------------------

--
-- Table structure for table `keluhan`
--

CREATE TABLE `keluhan` (
  `id_keluhan` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `saran` text DEFAULT NULL,
  `kritik` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keluhan`
--

INSERT INTO `keluhan` (`id_keluhan`, `id_pelanggan`, `id_pengguna`, `saran`, `kritik`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Layanan sangat baik', 'Pengiriman sedikit terlambat', '2024-07-25 09:17:54', '2024-07-25 09:17:54'),
(2, 2, 2, 'Produk bagus', 'Stok kurang banyak', '2024-07-25 09:17:54', '2024-07-25 09:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(5) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(16) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `email`, `password`, `alamat`, `no_telp`, `created_at`) VALUES
(1, 'Ahmad Santoso', 'ahmad@example.com', 'password123', 'Jl. Merpati No. 15, Jakarta', '081234567890', '2024-07-24 16:32:53'),
(2, 'Budi Wirawan', 'budi@example.com', 'password123', 'Jl. Kenanga No. 23, Bandung', '081298765432', '2024-07-24 16:32:53'),
(3, 'Citra Dewi', 'citra@example.com', 'password123', 'Jl. Melati No. 45, Surabaya', '081212345678', '2024-07-24 16:32:53'),
(4, 'bani', 'alb.dabba@gmail.com', '$2y$10$Ji2XQgBbH', 'jlsudirman', '081234561234', '2024-07-28 14:38:00');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(5) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(12) NOT NULL,
  `password` varchar(16) NOT NULL,
  `email` varchar(30) NOT NULL,
  `jabatan` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama`, `username`, `password`, `email`, `jabatan`, `created_at`) VALUES
(1, 'Admin User', 'admin', 'adminpassword', 'admin@example.com', 'admin', '2024-07-23 23:35:17'),
(2, 'Penjualan User', 'penjualan', 'penjualanpasswor', 'penjualan@example.com', 'penjualan', '2024-07-23 23:35:17'),
(3, 'Pemilik User', 'pemilik', 'pemilikpassword', 'pemilik@example.com', 'pemilik', '2024-07-23 23:35:17'),
(16, 'ikan', 'ikan', '$2y$10$zB.sieLpV', 'ikan@gmail.com', 'pemilik', '2024-07-27 19:13:35');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama`, `deskripsi`, `harga`, `stok`, `gambar`, `id_kategori`, `id_pengguna`, `created_at`) VALUES
(1, 'Chitato', 'Keripik kentang dengan rasa daging panggang', 10000, 40, 'chitato.jpeg', 2, 1, '2024-07-25 09:16:12'),
(2, 'Taro', 'Snack stik rasa rumput laut', 8000, 92, 'taro.jpg', 2, 1, '2024-07-25 09:16:12'),
(3, 'Oreo', 'Biskuit dengan krim vanila', 15000, 30, 'oreo.jpg', 3, 1, '2024-07-25 09:16:12'),
(4, 'SilverQueen', 'Cokelat batangan dengan kacang mete', 20000, 19, 'silverqueen.jpeg', 11, 2, '2024-07-25 09:16:12'),
(5, 'Indomie Goreng', 'Mie goreng instan', 3000, 200, 'indomie_goreng.jpg', 5, 2, '2024-07-25 09:16:12'),
(6, 'Malkist Crackers', 'Biskuit malkist dengan gula', 7000, 60, 'malkist_crackers.jpg', 3, 2, '2024-07-25 09:16:12'),
(7, 'Good Time', 'Kue kering dengan cokelat chip', 12000, 40, 'good_time.jpg', 10, 2, '2024-07-25 09:16:12'),
(8, 'Cheese Stick', 'Stick keju renyah', 15000, 25, 'crot.jpg', 4, 1, '2024-07-25 09:16:12'),
(25, 'ikan', 'ikan', 10000, 99, 'ngisibensin.jpg', 1, 2, '2024-07-26 07:47:53');

-- --------------------------------------------------------

--
-- Table structure for table `rekomendasi_produk`
--

CREATE TABLE `rekomendasi_produk` (
  `id_rekomendasi_produk` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `tanggal_rekomendasi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekomendasi_produk`
--

INSERT INTO `rekomendasi_produk` (`id_rekomendasi_produk`, `id_pelanggan`, `id_produk`, `tanggal_rekomendasi`) VALUES
(1, 1, 1, '2024-07-25'),
(2, 2, 2, '2024-07-25');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pelanggan`, `tanggal`, `total`, `status`) VALUES
(1, 1, '2024-07-25', 32000000, 'Completed'),
(2, 2, '2024-07-25', 15000000, 'Pending'),
(3, 3, '2024-07-28', 30000, 'Pending'),
(4, 3, '2024-07-28', 0, 'Pending'),
(5, 3, '2024-07-28', 48000, 'Pending'),
(6, 1, '2024-07-28', 60000, 'Pending'),
(7, 1, '2024-07-28', 26000, 'Pending'),
(8, 1, '2024-07-28', 30000, 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`id_cart_item`),
  ADD KEY `id_cart` (`id_cart`,`id_produk`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`),
  ADD KEY `id_transaksi` (`id_transaksi`,`id_produk`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `keluhan`
--
ALTER TABLE `keluhan`
  ADD PRIMARY KEY (`id_keluhan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`,`id_pengguna`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`,`id_pengguna`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `rekomendasi_produk`
--
ALTER TABLE `rekomendasi_produk`
  ADD PRIMARY KEY (`id_rekomendasi_produk`),
  ADD KEY `id_pelanggan` (`id_pelanggan`,`id_produk`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id_cart_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `keluhan`
--
ALTER TABLE `keluhan`
  MODIFY `id_keluhan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `rekomendasi_produk`
--
ALTER TABLE `rekomendasi_produk`
  MODIFY `id_rekomendasi_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`id_cart`) REFERENCES `cart` (`id_cart`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keluhan`
--
ALTER TABLE `keluhan`
  ADD CONSTRAINT `keluhan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `keluhan_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rekomendasi_produk`
--
ALTER TABLE `rekomendasi_produk`
  ADD CONSTRAINT `rekomendasi_produk_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rekomendasi_produk_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
