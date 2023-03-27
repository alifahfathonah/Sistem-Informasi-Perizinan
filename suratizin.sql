-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2023 at 09:11 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suratizin`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_bidang`
--

CREATE TABLE `tb_bidang` (
  `id_bidang` int(5) NOT NULL,
  `nama_bidang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_bidang`
--

INSERT INTO `tb_bidang` (`id_bidang`, `nama_bidang`) VALUES
(3001, 'Operasi'),
(3002, 'Pemeliharaan'),
(3003, 'Enjiniring'),
(3004, 'Administrasi');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jabatan`
--

CREATE TABLE `tb_jabatan` (
  `id_jabatan` int(5) NOT NULL,
  `nama_jabatan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_jabatan`
--

INSERT INTO `tb_jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(2001, 'Manager Operasi'),
(2002, 'Manager Pemeliharaan'),
(2003, 'Manager Enjiniring'),
(2004, 'Manager Administrasi'),
(2005, 'Senior Manager');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis_izin`
--

CREATE TABLE `tb_jenis_izin` (
  `id_jenis_izin` int(5) NOT NULL,
  `nama_izin` enum('Pribadi','Dinas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_jenis_izin`
--

INSERT INTO `tb_jenis_izin` (`id_jenis_izin`, `nama_izin`) VALUES
(1, 'Pribadi'),
(2, 'Dinas');

-- --------------------------------------------------------

--
-- Table structure for table `tb_karyawan`
--

CREATE TABLE `tb_karyawan` (
  `nip_karyawan` int(255) NOT NULL,
  `nama_karyawan` varchar(50) NOT NULL,
  `nip_atasan` int(255) NOT NULL,
  `id_jabatan` int(255) NOT NULL,
  `id_bidang` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_karyawan`
--

INSERT INTO `tb_karyawan` (`nip_karyawan`, `nama_karyawan`, `nip_atasan`, `id_jabatan`, `id_bidang`) VALUES
(1070, 'Aisaka Taiga', 177003, 2003, 3003),
(1111, 'Kobe Bryant', 2222, 2001, 3001),
(19771809, 'Koro Sensei', 1, 2005, 3003),
(20031901, 'Muhammad Akmal Firmansyah', 19771809, 2003, 3003);

-- --------------------------------------------------------

--
-- Table structure for table `tb_surat_izin`
--

CREATE TABLE `tb_surat_izin` (
  `id_surat_izin` int(25) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `tanggal` varchar(25) NOT NULL,
  `jam_pergi` varchar(25) NOT NULL,
  `jam_kembali` varchar(25) NOT NULL,
  `id_jenis_izin` int(255) NOT NULL,
  `keperluan` varchar(255) NOT NULL,
  `verifikasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `nip_user` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(25) NOT NULL,
  `status_user` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`nip_user`, `email`, `password`, `status_user`) VALUES
(19630208, 'superadmin@mail.com', '1234', 'superadmin'),
(19771809, 'koro@mail.com', '1234', 'atasan'),
(19981212, 'karyawan@mail.com', '1234', 'karyawan'),
(19990118, 'atasan@mail.com', '1234', 'atasan'),
(20031901, 'mfirmansyah@yahoo.co.id', '1234', 'karyawan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_bidang`
--
ALTER TABLE `tb_bidang`
  ADD PRIMARY KEY (`id_bidang`);

--
-- Indexes for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `tb_jenis_izin`
--
ALTER TABLE `tb_jenis_izin`
  ADD PRIMARY KEY (`id_jenis_izin`);

--
-- Indexes for table `tb_karyawan`
--
ALTER TABLE `tb_karyawan`
  ADD PRIMARY KEY (`nip_karyawan`);

--
-- Indexes for table `tb_surat_izin`
--
ALTER TABLE `tb_surat_izin`
  ADD PRIMARY KEY (`id_surat_izin`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`nip_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_bidang`
--
ALTER TABLE `tb_bidang`
  MODIFY `id_bidang` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3005;

--
-- AUTO_INCREMENT for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  MODIFY `id_jabatan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2007;

--
-- AUTO_INCREMENT for table `tb_jenis_izin`
--
ALTER TABLE `tb_jenis_izin`
  MODIFY `id_jenis_izin` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
