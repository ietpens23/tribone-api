-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2023 at 02:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tribone`
--

-- --------------------------------------------------------

--
-- Table structure for table `kas`
--

CREATE TABLE `kas` (
  `id` int(11) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `agustus` int(11) NOT NULL,
  `september` int(11) NOT NULL,
  `oktober` int(11) NOT NULL,
  `november` int(11) NOT NULL,
  `desember` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kas`
--

INSERT INTO `kas` (`id`, `nama`, `agustus`, `september`, `oktober`, `november`, `desember`) VALUES
(1, 'Muqsith Barru Pamungkas', 100000, 10000, 10000, 10000, 10000),
(2, 'Riski Gana Prasetya', 10000, 100000, 40000, 10000, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `kaskeluar`
--

CREATE TABLE `kaskeluar` (
  `id` int(11) NOT NULL,
  `rincian` text NOT NULL,
  `tanggal` varchar(32) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kaskeluar`
--

INSERT INTO `kaskeluar` (`id`, `rincian`, `tanggal`, `jumlah`) VALUES
(1, 'FOTO KOPI SAMPUL COVER \r\nPRAKTIKUM 500 LEMBAR', '10/11/2023', 180000);

-- --------------------------------------------------------

--
-- Table structure for table `piket`
--

CREATE TABLE `piket` (
  `id` int(11) NOT NULL,
  `hari` varchar(32) NOT NULL,
  `ruangan` varchar(32) NOT NULL,
  `nama` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `piket`
--

INSERT INTO `piket` (`id`, `hari`, `ruangan`, `nama`) VALUES
(10, 'Senin', 'Lab jj 303', 'Rayhan,Syauqi'),
(11, 'Senin', 'Lab E 106', 'Farhan, Akmal,Nofan'),
(12, 'Selasa', 'Lab E 305', 'Fahkri,Marcel,Bintang'),
(13, 'Selasa', 'Lab A 301', 'Angga,Riski,Daniel'),
(14, 'Rabu', 'Lab JJ 309', 'Adhe,Novaldi,Rahmat'),
(15, 'Rabu', 'Lab a 303', 'Dewa,Farhan fawwaz,Titan egi'),
(16, 'Kamis', 'Lab h101', 'Diwa,Raffi,Farchan'),
(17, 'Kamis', 'Lab a303', 'Muqsith,Rifan,leavis'),
(18, 'Jumat', 'Lab e 206', 'Mita,Aiko,Romadona');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `hari` varchar(32) NOT NULL,
  `matkul` varchar(32) NOT NULL,
  `dosen` varchar(32) NOT NULL,
  `ruang` varchar(32) NOT NULL,
  `jam` varchar(32) NOT NULL,
  `semester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `hari`, `matkul`, `dosen`, `ruang`, `jam`, `semester`) VALUES
(1, 'Senin', 'Praktikum Elektronika Digital 1', 'Mohamad Ridwan', 'JJ 303', '08:00 - 10:30', 1),
(2, 'Senin', 'Praktikum Sistem Komunikasi', 'Aries Pratiarso', 'E 106', '13:50-16:20', 1),
(3, 'Selasa', 'Praktikum Arsitektur Komputer', 'Norma Ningsih', 'E 305', '08:00-10:30', 1),
(4, 'Selasa', 'Algoritma dan Struktur Data', 'Mike Yuliana', 'A 301', '13:00 - 14:40', 1),
(5, 'Selasa', 'Arsitektur Komputer', 'Haryadi Amran Darwito', 'A 301', '14:40 - 16:20', 1),
(6, 'Rabu', 'Praktikum Algoritma dan Struktur', 'Mike Yuliana', 'JJ 309', '08:00-10:30', 1),
(7, 'Rabu', 'Elektronika Digital 1', 'Afifah Dwi Ramadhani', 'A 303', '11:20-13:50', 1),
(8, 'Kamis', 'Agama', 'Choliliyah Thoha', 'HH 101', '08:00-09:40', 1),
(9, 'Kamis', 'Sistem Komunikasi', 'Aries Pratiarso', 'A 303', '13:50-15:30', 1),
(10, 'Jumat', 'Workshop Teknologi Web dan Aplik', 'Norma Ningsih', 'E 206', '8:00-11:20', 1),
(11, 'Jumat', 'Matematika 1', 'Rini Satiti', 'A 301', '13:00-14:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nrp` varchar(32) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` char(60) NOT NULL,
  `profile` blob NOT NULL,
  `createAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kaskeluar`
--
ALTER TABLE `kaskeluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `piket`
--
ALTER TABLE `piket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kas`
--
ALTER TABLE `kas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kaskeluar`
--
ALTER TABLE `kaskeluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `piket`
--
ALTER TABLE `piket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
