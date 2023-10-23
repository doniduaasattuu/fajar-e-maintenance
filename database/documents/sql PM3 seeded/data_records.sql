-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2023 at 10:07 AM
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
(1, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 50, 79, 69, 70, 61, 0.78, 'Normal', 0.81, 'Normal', '2023-09-21 07:58:15', 'Doni Darmawan'),
(2, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 46, 53, 40, 41, 0.69, 'Normal', 0.54, 'Normal', '2023-09-21 07:58:15', 'Doni Darmawan'),
(3, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 50, 60, 68, 63, 61, 0.31, 'Normal', 0.53, 'Normal', '2023-09-22 07:58:15', 'Doni Darmawan'),
(4, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 67, 44, 41, 48, 0.78, 'Normal', 0.59, 'Normal', '2023-09-22 07:58:15', 'Doni Darmawan'),
(5, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 50, 70, 68, 74, 73, 0.94, 'Normal', 0.63, 'Normal', '2023-09-23 07:58:15', 'Doni Darmawan'),
(6, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 61, 70, 60, 59, 0.73, 'Normal', 0.49, 'Normal', '2023-09-23 07:58:15', 'Doni Darmawan'),
(7, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 80, 62, 69, 66, 70, 0.06, 'Normal', 0.32, 'Normal', '2023-09-24 07:58:15', 'Doni Darmawan'),
(8, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 59, 49, 61, 65, 0.63, 'Normal', 0.86, 'Normal', '2023-09-24 07:58:15', 'Doni Darmawan'),
(9, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 80, 79, 79, 78, 76, 0.25, 'Normal', 0.02, 'Normal', '2023-09-25 07:58:15', 'Doni Darmawan'),
(10, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 57, 67, 45, 50, 0.52, 'Normal', 0.55, 'Normal', '2023-09-25 07:58:15', 'Doni Darmawan'),
(11, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 80, 65, 64, 67, 75, 0.15, 'Normal', 0.71, 'Normal', '2023-09-26 07:58:15', 'Doni Darmawan'),
(12, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 67, 51, 50, 44, 0.46, 'Normal', 1.10, 'Normal', '2023-09-26 07:58:15', 'Doni Darmawan'),
(13, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 70, 73, 60, 70, 72, 0.29, 'Normal', 0.44, 'Normal', '2023-09-27 07:58:15', 'Doni Darmawan'),
(14, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 59, 48, 54, 49, 0.29, 'Normal', 0.81, 'Normal', '2023-09-27 07:58:15', 'Doni Darmawan'),
(15, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 50, 74, 79, 64, 70, 0.07, 'Normal', 0.92, 'Normal', '2023-09-28 07:58:15', 'Doni Darmawan'),
(16, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 41, 48, 68, 65, 0.73, 'Normal', 0.71, 'Normal', '2023-09-28 07:58:15', 'Doni Darmawan'),
(17, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 40, 80, 63, 63, 75, 0.56, 'Normal', 0.96, 'Normal', '2023-09-29 07:58:15', 'Doni Darmawan'),
(18, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 47, 53, 62, 49, 1.11, 'Normal', 0.76, 'Normal', '2023-09-29 07:58:15', 'Doni Darmawan'),
(19, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 80, 63, 69, 61, 72, 0.96, 'Normal', 0.06, 'Normal', '2023-09-30 07:58:15', 'Doni Darmawan'),
(20, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 57, 55, 47, 64, 1.08, 'Normal', 0.15, 'Normal', '2023-09-30 07:58:15', 'Doni Darmawan'),
(21, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 50, 75, 80, 74, 70, 0.29, 'Normal', 0.98, 'Normal', '2023-10-01 07:58:15', 'Doni Darmawan'),
(22, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 60, 44, 63, 47, 1.00, 'Normal', 0.32, 'Normal', '2023-10-01 07:58:15', 'Doni Darmawan'),
(23, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 40, 61, 71, 63, 70, 0.77, 'Normal', 0.17, 'Normal', '2023-10-02 07:58:15', 'Doni Darmawan'),
(24, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 45, 64, 66, 41, 0.64, 'Normal', 0.09, 'Normal', '2023-10-02 07:58:15', 'Doni Darmawan'),
(25, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 60, 66, 79, 76, 69, 0.37, 'Normal', 0.31, 'Normal', '2023-10-03 07:58:15', 'Doni Darmawan'),
(26, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 59, 61, 58, 54, 0.41, 'Normal', 1.09, 'Normal', '2023-10-03 07:58:15', 'Doni Darmawan'),
(27, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 40, 69, 69, 75, 65, 0.98, 'Normal', 0.31, 'Normal', '2023-10-04 07:58:15', 'Doni Darmawan'),
(28, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 59, 48, 69, 64, 0.22, 'Normal', 0.94, 'Normal', '2023-10-04 07:58:15', 'Doni Darmawan'),
(29, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 40, 76, 70, 71, 74, 0.42, 'Normal', 0.75, 'Normal', '2023-10-05 07:58:15', 'Doni Darmawan'),
(30, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 67, 56, 43, 58, 1.05, 'Normal', 0.06, 'Normal', '2023-10-05 07:58:15', 'Doni Darmawan'),
(31, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 80, 62, 75, 66, 67, 0.35, 'Normal', 0.92, 'Normal', '2023-10-06 07:58:15', 'Doni Darmawan'),
(32, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 65, 65, 49, 56, 1.07, 'Normal', 0.33, 'Normal', '2023-10-06 07:58:15', 'Doni Darmawan'),
(33, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 80, 70, 66, 80, 70, 0.79, 'Normal', 0.68, 'Normal', '2023-10-07 07:58:15', 'Doni Darmawan'),
(34, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 59, 70, 49, 61, 0.94, 'Normal', 0.10, 'Normal', '2023-10-07 07:58:15', 'Doni Darmawan'),
(35, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 60, 78, 68, 76, 64, 0.31, 'Normal', 0.41, 'Normal', '2023-10-08 07:58:15', 'Doni Darmawan'),
(36, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 58, 49, 60, 58, 0.96, 'Normal', 0.96, 'Normal', '2023-10-08 07:58:15', 'Doni Darmawan'),
(37, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 80, 68, 74, 60, 65, 0.54, 'Normal', 0.94, 'Normal', '2023-10-09 07:58:15', 'Doni Darmawan'),
(38, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 45, 69, 51, 50, 0.16, 'Normal', 0.91, 'Normal', '2023-10-09 07:58:15', 'Doni Darmawan'),
(39, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 60, 77, 69, 60, 65, 1.05, 'Normal', 0.75, 'Normal', '2023-10-10 07:58:15', 'Doni Darmawan'),
(40, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 43, 44, 51, 69, 0.67, 'Normal', 0.35, 'Normal', '2023-10-10 07:58:15', 'Doni Darmawan'),
(41, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 60, 65, 77, 71, 66, 0.68, 'Normal', 0.62, 'Normal', '2023-10-11 07:58:15', 'Doni Darmawan'),
(42, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 47, 56, 50, 69, 0.37, 'Normal', 1.00, 'Normal', '2023-10-11 07:58:15', 'Doni Darmawan'),
(43, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 50, 67, 67, 73, 61, 0.85, 'Normal', 0.61, 'Normal', '2023-10-12 07:58:15', 'Doni Darmawan'),
(44, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 56, 64, 53, 46, 0.44, 'Normal', 0.16, 'Normal', '2023-10-12 07:58:15', 'Doni Darmawan'),
(45, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 70, 65, 61, 80, 79, 0.90, 'Normal', 0.53, 'Normal', '2023-10-13 07:58:15', 'Doni Darmawan'),
(46, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 48, 55, 70, 68, 1.05, 'Normal', 0.32, 'Normal', '2023-10-13 07:58:15', 'Doni Darmawan'),
(47, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 40, 78, 67, 80, 66, 0.88, 'Normal', 0.44, 'Normal', '2023-10-14 07:58:15', 'Doni Darmawan'),
(48, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 63, 41, 58, 57, 0.91, 'Normal', 0.18, 'Normal', '2023-10-14 07:58:15', 'Doni Darmawan'),
(49, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 50, 71, 78, 63, 75, 0.81, 'Normal', 1.03, 'Normal', '2023-10-15 07:58:15', 'Doni Darmawan'),
(50, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 60, 46, 60, 56, 0.41, 'Normal', 1.00, 'Normal', '2023-10-15 07:58:15', 'Doni Darmawan'),
(51, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 40, 63, 78, 71, 63, 1.01, 'Normal', 0.29, 'Normal', '2023-10-16 07:58:15', 'Doni Darmawan'),
(52, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 45, 67, 45, 57, 0.85, 'Normal', 0.70, 'Normal', '2023-10-16 07:58:15', 'Doni Darmawan'),
(53, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 80, 62, 72, 73, 72, 0.87, 'Normal', 0.53, 'Normal', '2023-10-17 07:58:15', 'Doni Darmawan'),
(54, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 70, 45, 57, 41, 0.09, 'Normal', 0.16, 'Normal', '2023-10-17 07:58:15', 'Doni Darmawan'),
(55, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 80, 73, 73, 61, 64, 0.37, 'Normal', 0.66, 'Normal', '2023-10-18 07:58:15', 'Doni Darmawan'),
(56, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 69, 47, 64, 64, 0.29, 'Normal', 0.26, 'Normal', '2023-10-18 07:58:15', 'Doni Darmawan'),
(57, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 40, 74, 68, 72, 60, 0.42, 'Normal', 0.03, 'Normal', '2023-10-19 07:58:15', 'Doni Darmawan'),
(58, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 49, 51, 56, 61, 0.93, 'Normal', 0.94, 'Normal', '2023-10-19 07:58:15', 'Doni Darmawan'),
(59, 'FP-01-SP3-RJS-T092-P092', 'EMO000426', 'Running', 'Clean', 'Available', 40, 65, 72, 64, 66, 0.47, 'Normal', 1.10, 'Normal', '2023-10-20 07:58:15', 'Doni Darmawan'),
(60, 'FP-01-PM3-REL-PPRL-PRAR', 'MGM000481', 'Running', 'Clean', 'Not Available', NULL, 55, 50, 64, 70, 0.44, 'Normal', 0.66, 'Normal', '2023-10-20 07:58:15', 'Doni Darmawan');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

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
