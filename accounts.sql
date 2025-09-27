-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2025 at 10:25 PM
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
-- Database: `accounts`
--

-- --------------------------------------------------------

--
-- Table structure for table `personal_data`
--

CREATE TABLE `personal_data` (
  `id` int(100) NOT NULL,
  `last_name` varchar(500) NOT NULL,
  `first_name` varchar(500) NOT NULL,
  `middle_name` varchar(500) NOT NULL,
  `flast` varchar(100) NOT NULL,
  `ffirst` varchar(100) NOT NULL,
  `fmiddle` varchar(100) NOT NULL,
  `mlast` varchar(100) NOT NULL,
  `mfirst` varchar(100) NOT NULL,
  `mmiddle` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(100) NOT NULL,
  `civil_status` varchar(100) NOT NULL,
  `otherStatus` varchar(100) NOT NULL,
  `nationality` varchar(100) NOT NULL,
  `religion` varchar(100) NOT NULL,
  `tin` int(100) NOT NULL,
  `unit` varchar(200) NOT NULL,
  `blk` varchar(200) NOT NULL,
  `street` varchar(300) NOT NULL,
  `subdivision` varchar(300) NOT NULL,
  `barangay` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `province` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `zip` int(100) NOT NULL,
  `unit2` varchar(100) NOT NULL,
  `blk2` varchar(200) NOT NULL,
  `street2` varchar(200) NOT NULL,
  `subdivision2` varchar(200) NOT NULL,
  `barangay2` varchar(200) NOT NULL,
  `city2` varchar(200) NOT NULL,
  `province2` varchar(200) NOT NULL,
  `country2` varchar(200) NOT NULL,
  `zip2` int(100) NOT NULL,
  `phone` int(200) NOT NULL,
  `tele` int(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `age` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `personal_data`
--
ALTER TABLE `personal_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `personal_data`
--
ALTER TABLE `personal_data`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
