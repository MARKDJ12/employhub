-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2024 at 04:50 PM
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
-- Database: `employhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'ricktomps');

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `job_id`, `username`, `full_name`, `email`, `users_id`, `company_name`) VALUES
(28, 8, 'wew', 'MARK DJ TUBIANO', 'manoymark@gmail.com', 1, 'Super Cell'),
(29, 9, 'wew', 'MARK DJ TUBIANO', 'manoymark@gmail.com', 1, 'MOBILE LEGENDS BANG BANG'),
(30, 16, 'wew', 'MARK DJ TUBIANO', 'manoymark@gmail.com', 1, 'YAMAHA');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `closing_date` date NOT NULL,
  `job_type` varchar(50) NOT NULL,
  `experience_required` varchar(50) NOT NULL,
  `job_description` text NOT NULL,
  `responsibilities` text NOT NULL,
  `requirements` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `salary` varchar(255) NOT NULL,
  `contact_details` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `company_name`, `job_title`, `city`, `country`, `category`, `closing_date`, `job_type`, `experience_required`, `job_description`, `responsibilities`, `requirements`, `published`, `salary`, `contact_details`) VALUES
(1, 'MOBILE LEGENDS BANG BANG', 'GAME DEVELOPER', 'GINGOOG, MISAMIS ORIENTAL', 'Philippines', 'Information Technology', '2024-05-27', 'FreeLance', '5 Years', 'NONE', 'NOEN', 'NONE', 1, '10000', ''),
(2, 'CALL OF DUTY MOBILE', 'GAME DEVELOPER', 'CLAVERIA, MISAMIS ORIENTAL', 'Philippines', 'Information Technology', '2024-05-06', 'FullTime', '4 Years', 'NONE', 'NONE', 'NONE', 1, '120000', ''),
(3, 'MOBILE LEGENDS BANG BANG', 'HELPER', 'GINGOOG, MISAMIS ORIENTAL', 'Philippines', 'Information Technology', '2024-05-25', 'FullTime', '4 Years', 'das', 'das', 'da', 1, '123312', ''),
(4, 'MOBILE LEGENDS BANG BANG', 'Developer', 'dasd', 'Indonesia', 'Manufacturing', '2024-05-24', 'FullTime', '1 Year', 'dsa', 'dsa', 'dasd', 1, '4223', ''),
(7, 'MOBILE LEGENDS BANG BANG', 'DEV', 'MIS-OR', 'Palestine', 'Information Technology', '2024-05-16', 'FullTime', '4 Years', 'wa', 'wa', 'dwada', 1, '12121', ''),
(8, 'Super Cell', 'Web Application Developer', 'ew', 'Georgia', 'Construction', '2024-06-21', 'FreeLance', '2 Years', 'as', 'as', 'sa', 1, '12', 'dsa'),
(9, 'MOBILE LEGENDS BANG BANG', 'PROGRAMMER', 'ew', 'Israel', 'Human Resources', '2024-06-13', 'PartTime', '3 Years', 'dsa', 'das', 'da', 1, '12', 'mobilelegends@gmail.com\r\n09263302992'),
(10, 'MLBB', 'WEW', 'wq', 'Japan', 'Media/Communication', '2024-05-23', 'FreeLance', '2 Years', 'xaz', 'sa', 'as', 1, '12,000.00 to 23.45', 'sa\r\n12'),
(11, 'MLBB', 'sad', 'asda', 'Armenia', 'Art/Design', '2024-05-16', 'FreeLance', '2 Years', 'das', 'das', 'das', 1, '121.35', 'mlbb@gmail.com\r\n09263302992'),
(12, 'Moonton', 'Application Designer', 'asd', 'Japan', 'Sales', '2024-05-21', 'PartTime', '2 Years', 'qwe', 'qwe', 'qwe', 1, '123.3', 'rick@gmail.com\r\n09123467895'),
(13, 'MOBILE LEGENDS BANG BANG', 'Full Stack', 'das', 'Japan', 'Manufacturing', '2024-05-21', 'FullTime', '3 Years', 'das', 'das', 'das', 1, '12', 'das'),
(14, 'Steam', 'Data Analyst', 'Tagoloan City', 'Indonesia', 'Information Technology', '2024-05-01', 'FullTime', '1 Year', 'No one left behind Basta KIta tanan mabaksak', 'Family Tas lima kabook maguwang', 'Trust Condum', 1, '80000', 'steam@gmail.com\r\n09123456782'),
(15, 'Jatr', 'tiltle', 'claveria', 'Jordan', 'Accounting/Finance', '2024-05-31', 'FullTime', '1 Year', 'sdhidds', 'sdfdf', 'sdfdf', 1, '1000', 'jatr@gmail.com\r\n90348384344'),
(16, 'YAMAHA', 'TIME KEEPER', 'GINGOOG, MISAMIS ORIENTAL', 'Mongolia', 'Construction', '2024-06-08', 'FullTime', '3 Years', 'dsa', 'das', 'sda', 1, '250.75', 'mitsubishi@gmail.com\r\n09123456789'),
(17, 'RICKTOMPS', 'programming', 'das', 'Israel', 'Media/Communication', '2024-06-01', 'PartTime', '2 Years', 'xz', 'xZ', 'xz', 1, '12', 'xZ'),
(18, 'USTP Claveria', 'Instructor I', 'Claveria', 'Philippines', 'Education/Training', '2024-06-30', 'FullTime', '1 Year', 'IT Faculty ', 'Teach etc ', 'PDS etc', 0, '29,000', 'kaishakim@gmail.com\r\n09700833100'),
(19, 'RICK', 'WALA', 'GINGOOG', 'Philippines', 'Human Resources', '2024-06-28', 'FullTime', '2 Years', 'wala', 'wala', 'wala', 0, '123,54', 'wala@gmail.com\r\n09263302992');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `educational_background` text DEFAULT NULL,
  `Skills` text DEFAULT NULL,
  `Experience` text DEFAULT NULL,
  `user_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `Address`, `phone_number`, `educational_background`, `Skills`, `Experience`, `user_picture`) VALUES
(1, 'wew', 'manoymark@gmail.com', '$2y$10$rujntBdEUFCYXuUDXe0PiO9xQPl54IHqJIPXkN4ilc7kpG1.7MjX2', 'MARK DJ TUBIANO', 'CLAVERIA,  MISAMIS ORIENTAL', '09856280917', 'UNDERGRADUATE', 'MAMAYUTAY', '3 years', 'uploads/wew_1717377587.jpg'),
(45, 'root', 'markdjtobiano6@gmail.com', '$2y$10$uqRIYDzamrVxblr.Setuiu.a8TD1/z4TuTymRFaS4nk3BLgV5DAj.', 'mark', 'claveria', '09103884479', 'professional', 'high end', 'senior dev', 'uploads/root_1714562150.jpg'),
(51, 'mark', 'mark123@gmail.com', '$2y$10$UwNW.l6/reuFGC2FnktFKudv4GS2QsGt7ezBPp/ME81fM4lowOpSK', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 'trisha', 'trisha.posadas@ustp.edu.ph', '$2y$10$TL3XNLi0w2RUSdpTxK4MXeX8JAEuHFSid84czemTLyeTzMCQMS2Lq', 'Trisha Posadas', 'Claveria', '09700833100', 'MSIT', 'Programming', '5 years', 'uploads/trisha_1717383332.jpg'),
(53, 'RICK', 'tomps@gmail.com', '$2y$10$b0gP.m9PYiUM4aXl6Xzxru/8ptAmc/w5KxxCzSEqNHnVZ6GYzZtZS', 'JOHN RICK TOMPONG', 'CLAVERIA', '09263302992', 'GRADUATE', 'Fullstack', '6years', 'uploads/RICK_1717421273.jpg'),
(54, 'manoy', 'manoy@gmail.com', '$2y$10$xeBsU8DY5uGIlAdzuUrGme/r156tRCpKSl6zVCUXgRlbZmHXPz4v.', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_id` (`users_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `fk_users_id` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
