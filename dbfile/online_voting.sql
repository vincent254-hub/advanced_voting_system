-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2024 at 01:22 PM
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
-- Database: `online_voting`
--

-- --------------------------------------------------------

--
-- Table structure for table `administratortable`
--

CREATE TABLE `administratortable` (
  `admin_id` int(5) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `administratortable`
--

INSERT INTO `administratortable` (`admin_id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'john', 'doe', 'admin@example.com', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'admin', 'admin', 'admin@admin.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `candidatestable`
--

CREATE TABLE `candidatestable` (
  `candidate_id` int(5) NOT NULL,
  `candidate_name` varchar(45) NOT NULL,
  `candidate_position` varchar(45) NOT NULL,
  `candidateYOS` varchar(20) DEFAULT NULL,
  `candidate_votes` int(11) NOT NULL,
  `candidate_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `candidatestable`
--

INSERT INTO `candidatestable` (`candidate_id`, `candidate_name`, `candidate_position`, `candidateYOS`, `candidate_votes`, `candidate_img`) VALUES
(108, 'susan njoki', 'Student_ChairPerson', 'Year 1', 0, 'team-2.jpg'),
(109, 'mercy awino', 'Student_ChairPerson', 'year 2', 1, 'team-4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Vincent Khamala', 'vincentkhamala9@gmail.com', 'My test contact', 'hello can you see my message?', '2024-08-26 19:14:12'),
(2, 'Vincent Khamala', 'vincentkhamala9@gmail.com', 'test app message', 'hello there', '2024-08-27 11:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `mailer_settings`
--

CREATE TABLE `mailer_settings` (
  `id` int(11) NOT NULL,
  `smtp_host` varchar(255) NOT NULL,
  `smtp_port` int(11) NOT NULL,
  `smtp_username` varchar(255) NOT NULL,
  `smtp_password` varchar(255) NOT NULL,
  `from_email` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mailer_settings`
--

INSERT INTO `mailer_settings` (`id`, `smtp_host`, `smtp_port`, `smtp_username`, `smtp_password`, `from_email`, `from_name`) VALUES
(1, 'smtp.gmail.com', 465, 'vincentkhamala9@gmail.com', 'zymaxkbsuhbmwcus', 'vincentkhamala9@gmail.com', 'OVS');

-- --------------------------------------------------------

--
-- Table structure for table `positionstable`
--

CREATE TABLE `positionstable` (
  `position_id` int(5) NOT NULL,
  `position_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `positionstable`
--

INSERT INTO `positionstable` (`position_id`, `position_name`) VALUES
(52, 'Student_ChairPerson');

-- --------------------------------------------------------

--
-- Table structure for table `userstable`
--

CREATE TABLE `userstable` (
  `member_id` int(5) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `admno` varchar(25) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userstable`
--

INSERT INTO `userstable` (`member_id`, `first_name`, `last_name`, `email`, `admno`, `password`) VALUES
(58, 'Daniel', 'Brown', 'daniel.brown@example.com', 'ADM005', 'db0edd04aaac4506f7edab03ac855d56'),
(59, 'Terry', 'Jonnes', 'terryjonnes@gmail.com', 'HDIS120/234', '81dc9bdb52d04dc20036dbd8313ed055'),
(73, 'Developer', 'vincent', 'developervincent9@gmail.com', 'HDIS076/450', '219c991f23661db15bba557db1437197'),
(74, 'stephen', 'thuo', 'stephenthuo03@gmail.com', 'HDIS077/430', '4aeb25cf72d3c6522abb95b0b60f985a');

-- --------------------------------------------------------

--
-- Table structure for table `votestable`
--

CREATE TABLE `votestable` (
  `id` int(11) NOT NULL,
  `voter_id` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `candidateName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `votestable`
--

INSERT INTO `votestable` (`id`, `voter_id`, `position`, `candidateName`) VALUES
(86, 73, 'Student_ChairPerson', 'mercy awino');

-- --------------------------------------------------------

--
-- Table structure for table `voting_time`
--

CREATE TABLE `voting_time` (
  `id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voting_time`
--

INSERT INTO `voting_time` (`id`, `start_time`, `end_time`, `status`) VALUES
(8, '2024-08-23 17:22:00', '2024-08-23 17:24:00', 0),
(9, '2024-08-23 17:25:00', '2024-08-24 12:05:00', 0),
(10, '2024-08-24 12:10:00', '2024-08-24 12:15:00', 0),
(11, '2024-08-24 12:18:00', '2024-08-24 12:25:00', 0),
(12, '2024-08-24 12:27:00', '2024-08-24 12:35:00', 0),
(13, '2024-08-24 12:37:00', '2024-08-24 13:10:00', 0),
(14, '2024-08-25 00:00:00', '2024-08-26 00:00:00', 0),
(15, '2024-08-26 12:08:00', '2024-08-26 12:22:00', 0),
(16, '2024-08-26 12:21:00', '2024-08-26 12:40:00', 0),
(17, '2024-08-27 03:57:00', '2024-08-27 10:57:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administratortable`
--
ALTER TABLE `administratortable`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `candidatestable`
--
ALTER TABLE `candidatestable`
  ADD PRIMARY KEY (`candidate_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mailer_settings`
--
ALTER TABLE `mailer_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positionstable`
--
ALTER TABLE `positionstable`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `userstable`
--
ALTER TABLE `userstable`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `votestable`
--
ALTER TABLE `votestable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voter_id` (`voter_id`);

--
-- Indexes for table `voting_time`
--
ALTER TABLE `voting_time`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administratortable`
--
ALTER TABLE `administratortable`
  MODIFY `admin_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `candidatestable`
--
ALTER TABLE `candidatestable`
  MODIFY `candidate_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mailer_settings`
--
ALTER TABLE `mailer_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `positionstable`
--
ALTER TABLE `positionstable`
  MODIFY `position_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `userstable`
--
ALTER TABLE `userstable`
  MODIFY `member_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `votestable`
--
ALTER TABLE `votestable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `voting_time`
--
ALTER TABLE `voting_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `votestable`
--
ALTER TABLE `votestable`
  ADD CONSTRAINT `votestable_ibfk_1` FOREIGN KEY (`voter_id`) REFERENCES `userstable` (`member_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
