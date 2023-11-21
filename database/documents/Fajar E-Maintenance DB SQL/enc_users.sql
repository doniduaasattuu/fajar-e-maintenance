-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 21, 2023 at 10:34 AM
-- Server version: 10.6.15-MariaDB-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doni2484_fajar_e_maintenance`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `nik` varchar(8) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `department` enum('EI1','EI2','EI3','EI4','EI5','EI6','EI7') NOT NULL,
  `phone_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`nik`, `password`, `fullname`, `department`, `phone_number`) VALUES
('31701003', '12345', 'Dimas B. Penggalih', 'EI6', '1'),
('31810009', '1234', 'Antonius', 'EI7', '081315062972'),
('31811016', '1234', 'Prima Hendra Kusuma', 'EI5', '085159963630'),
('31903007', '1234', 'Yuan Lucky Prasetyo Winarno', 'EI5', '081383294790'),
('31903032', 'fajarpaper69', 'Tomy Setya Dianto', 'EI6', '08562827628'),
('31903034', '1234', 'Suprihatin', 'EI6', '0895383086548'),
('31907080', 'Akulahrajanya25', 'Donie Winata', 'EI6', '08561963585'),
('32007012', '1234', 'Ridwan Abdurahman', 'EI7', '08991544689'),
('32207007', '1234', 'Abdan Shobirin', 'EI6', '1'),
('32209003', '1234', 'Hadi Yulianto', 'EI5', '08117406866'),
('33000181', '1234', 'Shuhuf kholisdianto', 'EI6', '1'),
('33000185', '1234', 'Fransiskus Intan', 'EI6', '089503953597'),
('33000202', 'cintaku22', 'Budi Utomo', 'EI6', '089619328807'),
('33000203', 'pribadi02', 'Ilham pribadi', 'EI6', '081316234723'),
('33000204', '12345', 'Supriyatno', 'EI6', '085280024826'),
('33000205', 'inci200984', 'Muhammad rafi', 'EI6', '089520406935'),
('55000092', '1234', 'R. Much Arief S', 'EI2', '087879107392'),
('55000093', '1234', 'Saiful Bahri', 'EI2', '08982911546'),
('55000153', '1234', 'Jamal Mirdad', 'EI6', '085381243342'),
('55000154', '1234', 'Doni', 'EI2', '08983456945');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`nik`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
