-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2022 at 11:28 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
-- Table structure for table "administratortable"
--

CREATE TABLE `administratortable`(
  `admin_id` int(5) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table "administratortable"
--

INSERT INTO `administratortable` (`admin_id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'john', 'doe', 'admin@example.com', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'admin', 'admin', 'admin@admin.com', 'admin');


-- --------------------------------------------------------

--
-- Table structure for table "candidatestable"
--

CREATE TABLE `candidatestable` (
  `candidate_id` int(5) NOT NULL,
  `candidate_name` varchar(45) NOT NULL,
  `candidate_position` varchar(45) NOT NULL,
  `candidate_votes` int(11) NOT NULL,
  `candidate_img` varchar(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table "candidatestable"
--


INSERT INTO `candidatestable` (`candidate_id`, `candidate_name`, `candidate_position`, `candidate_votes`, `candidate_img`) VALUES
(26, 'Vincent Khamala', 'President', 5,0),
(27, 'stephen njunge', 'President', 0,0),
(28, 'john mbadi', 'Secretary-General', 0,0),
(29, 'Mercy Awino', 'Secretary-General', 3,0),
(30, 'Tom n Jerry', 'Director-Welfare', 0,0),
(31, 'Chris Toper', 'Director-Welfare', 1,0),
(32, 'Johny Doe', 'Treasurer-Union', 1,0),
(33, 'Willy Anko', 'Sports-Representative', 0,0),
(34, 'Dan Kiarie', 'Sports-Representative', 0,0),
(35, 'mathu Dingo', 'Director-Welfare', 0,0),
(37, 'pastor kinyash', 'Secretary-General', 0,0),
(38, 'kits kits', 'Director-Academics', 0,0),
(39, 'Samuel Mburu', 'Sports-Representative', 1,0),
(40, 'test staff', 'Director-Welfare', 0,0),
(44, 'isaac nganga', 'Director-Academics', 0,0);


-- --------------------------------------------------------

--
-- Table structure for table "positionstable"
--

CREATE TABLE `positionstable`(
  `position_id` int(5) NOT NULL,
  `position_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table "positionstable"
--


INSERT INTO  `positionstable` (`position_id`, `position_name`) VALUES
(12, 'President'),
(13, 'Secretary-General'),
(14, 'Director-Academics'),
(16, 'Director-Welfare'),
(17, 'Treasurer-Union'),
(19, 'Sports-Representative');

-- --------------------------------------------------------

--
-- Table structure for table "userstable"
--

CREATE TABLE `userstable` (
  `member_id` int(5) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `admno` varchar(25) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table "userstable"
--

-- INSERT INTO `userstable` (`member_id`, `first_name`, `last_name`, `email`, `admno`, `password`) VALUES
-- (5, 'aslay', 'mtanzania', 'aslay@test.com', 'HDIS069-22', '1234');



-- --------------------------------------------------------

--
-- Table structure for table "votestable"
--

CREATE TABLE `votestable` (
  `id` int(11) NOT NULL,
  `voter_id` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `candidateName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
-- Indexes for table `votestable`
--
ALTER TABLE `votestable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voter_id` (`voter_id`);

--
-- Indexes for table `userstable`
--
ALTER TABLE `userstable`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `positionstable`
--
ALTER TABLE `positionstable`
  ADD PRIMARY KEY (`position_id`);

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
  MODIFY `candidate_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `votestable`
--
ALTER TABLE `votestable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `userstable`
--
ALTER TABLE `userstable`
  MODIFY `member_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `positionstable`
--
ALTER TABLE `positionstable`
  MODIFY `position_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
