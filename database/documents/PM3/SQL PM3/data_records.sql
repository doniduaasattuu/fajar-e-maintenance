-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2023 at 02:01 PM
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
-- Database: `fajar_e_maintenance`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_records`
--

CREATE TABLE `data_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `funcloc` varchar(150) NOT NULL,
  `emo` varchar(9) NOT NULL,
  `motor_status` enum('Running','Not Running') NOT NULL,
  `clean_status` enum('Clean','Dirty') NOT NULL,
  `nipple_grease` enum('Available','Not Available') NOT NULL,
  `number_of_greasing` tinyint(3) UNSIGNED DEFAULT NULL,
  `temperature_a` smallint(5) UNSIGNED NOT NULL,
  `temperature_b` smallint(5) UNSIGNED NOT NULL,
  `temperature_c` smallint(5) UNSIGNED NOT NULL,
  `temperature_d` smallint(5) UNSIGNED NOT NULL,
  `vibration_value_de` decimal(4,2) NOT NULL,
  `vibration_de` enum('Normal','Abnormal') DEFAULT NULL,
  `vibration_value_nde` decimal(4,2) NOT NULL,
  `vibration_nde` enum('Normal','Abnormal') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `checked_by` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_records`
--

INSERT INTO `data_records` (`id`, `funcloc`, `emo`, `motor_status`, `clean_status`, `nipple_grease`, `number_of_greasing`, `temperature_a`, `temperature_b`, `temperature_c`, `temperature_d`, `vibration_value_de`, `vibration_de`, `vibration_value_nde`, `vibration_nde`, `created_at`, `checked_by`) VALUES
(1, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 40, 76, 76, 68, 74, 1.01, 'Normal', 0.27, 'Normal', '2022-10-24 11:55:04', 'Doni Darmawan'),
(2, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 61, 68, 69, 54, 0.24, 'Normal', 0.36, 'Normal', '2022-10-24 11:55:04', 'Doni Darmawan'),
(3, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 80, 77, 65, 68, 61, 0.90, 'Normal', 0.32, 'Normal', '2022-11-24 11:55:04', 'Doni Darmawan'),
(4, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 63, 66, 54, 42, 0.08, 'Normal', 0.42, 'Normal', '2022-11-24 11:55:04', 'Doni Darmawan'),
(5, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 40, 79, 73, 64, 72, 0.18, 'Normal', 0.21, 'Normal', '2022-12-24 11:55:04', 'Doni Darmawan'),
(6, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 56, 43, 67, 48, 0.79, 'Normal', 0.48, 'Normal', '2022-12-24 11:55:04', 'Doni Darmawan'),
(7, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 70, 77, 71, 73, 78, 0.01, 'Normal', 0.08, 'Normal', '2023-01-24 11:55:04', 'Doni Darmawan'),
(8, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 48, 53, 50, 55, 0.24, 'Normal', 0.11, 'Normal', '2023-01-24 11:55:04', 'Doni Darmawan'),
(9, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 50, 62, 75, 68, 61, 0.15, 'Normal', 1.09, 'Normal', '2023-02-24 11:55:04', 'Doni Darmawan'),
(10, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 67, 60, 45, 61, 0.79, 'Normal', 0.41, 'Normal', '2023-02-24 11:55:04', 'Doni Darmawan'),
(11, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 50, 72, 75, 78, 67, 0.50, 'Normal', 0.51, 'Normal', '2023-03-24 11:55:04', 'Doni Darmawan'),
(12, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 67, 56, 51, 62, 0.04, 'Normal', 0.87, 'Normal', '2023-03-24 11:55:05', 'Doni Darmawan'),
(13, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 40, 80, 71, 67, 77, 0.67, 'Normal', 0.13, 'Normal', '2023-04-24 11:55:05', 'Doni Darmawan'),
(14, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 65, 68, 64, 67, 0.88, 'Normal', 0.94, 'Normal', '2023-04-24 11:55:05', 'Doni Darmawan'),
(15, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 50, 78, 70, 77, 77, 0.66, 'Normal', 0.80, 'Normal', '2023-05-24 11:55:05', 'Doni Darmawan'),
(16, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 57, 61, 45, 46, 0.24, 'Normal', 0.43, 'Normal', '2023-05-24 11:55:05', 'Doni Darmawan'),
(17, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 80, 79, 75, 80, 73, 0.54, 'Normal', 1.07, 'Normal', '2023-06-24 11:55:05', 'Doni Darmawan'),
(18, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 41, 60, 43, 68, 0.26, 'Normal', 0.60, 'Normal', '2023-06-24 11:55:05', 'Doni Darmawan'),
(19, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 80, 60, 79, 80, 78, 0.44, 'Normal', 0.99, 'Normal', '2023-07-24 11:55:05', 'Doni Darmawan'),
(20, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 45, 43, 40, 50, 0.70, 'Normal', 0.47, 'Normal', '2023-07-24 11:55:05', 'Doni Darmawan'),
(21, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 50, 72, 73, 66, 67, 0.32, 'Normal', 0.40, 'Normal', '2023-08-24 11:55:05', 'Doni Darmawan'),
(22, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 54, 44, 47, 66, 0.99, 'Normal', 0.27, 'Normal', '2023-08-24 11:55:05', 'Doni Darmawan'),
(23, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 40, 67, 64, 80, 79, 0.35, 'Normal', 0.60, 'Normal', '2023-09-24 11:55:05', 'Doni Darmawan'),
(24, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 45, 50, 51, 40, 0.13, 'Normal', 0.46, 'Normal', '2023-09-24 11:55:05', 'Doni Darmawan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_records`
--
ALTER TABLE `data_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_records_funcloc_foreign` (`funcloc`),
  ADD KEY `data_records_emo_foreign` (`emo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_records`
--
ALTER TABLE `data_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_records`
--
ALTER TABLE `data_records`
  ADD CONSTRAINT `data_records_emo_foreign` FOREIGN KEY (`emo`) REFERENCES `emos` (`id`),
  ADD CONSTRAINT `data_records_funcloc_foreign` FOREIGN KEY (`funcloc`) REFERENCES `function_locations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
