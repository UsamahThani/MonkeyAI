-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2024 at 10:02 AM
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
-- Database: `monkeyai`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`, `admin_img`) VALUES
(1, 'Usamah Thani', 'usamahsamah@gmail.com', '$2y$10$IJz4G9sOOUcF7UuvBrvw1OwvJ.5TgPAt/mJe6WoOQfnR4Xf8dU5hu', '66851b16729e0.png'),
(2, 'Haziq', 'test@gmail.com', '$2y$10$u9bIiX5qOWFVF.8KjZctueWXq9ust2v4DZu7R.1HuXpl7rgvqrGQK', '66883fd63e34f.png');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `report_id` int(10) NOT NULL,
  `report_location` varchar(255) NOT NULL,
  `report_date` date NOT NULL,
  `report_time` time NOT NULL,
  `report_context` varchar(500) NOT NULL,
  `report_admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`report_id`, `report_location`, `report_date`, `report_time`, `report_context`, `report_admin`) VALUES
(1, 'Block D', '2024-07-05', '08:49:00', 'atas keto bowoh keto', 'Usamah Thani'),
(2, 'Block A', '2024-07-05', '09:37:00', 'In classroom\\r\\ntest', 'Usamah Thani'),
(4, 'Block C', '2024-07-06', '05:28:03', 'test', 'sam'),
(5, 'Kolej TAR', '2024-07-07', '05:28:03', 'test', 'sam');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `student_num` varchar(255) DEFAULT '20XXXXXXXX',
  `user_name` varchar(255) DEFAULT NULL,
  `user_phonum` varchar(255) DEFAULT '01X-XXXXXXX',
  `user_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_email`, `user_pass`, `student_num`, `user_name`, `user_phonum`, `user_img`) VALUES
(1, 'usamahsamah@gmail.com', '$2y$10$nJLIS.bW3ieNA/Z8mRwuW.j.EKWNtJQoo1lQ4jUxdBklFRjWy76na', '2022907921', 'Mohamad Usamah Thani', '0179040690', '66885868bec31.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `report_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
