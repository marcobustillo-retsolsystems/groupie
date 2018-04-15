-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2017 at 05:52 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `groupie`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `ID` varchar(10) NOT NULL,
  `user_type` int(1) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `password` varchar(15) NOT NULL,
  `contact_number` int(13) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `course` varchar(255) NOT NULL,
  `account_type` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`ID`, `user_type`, `first_name`, `last_name`, `password`, `contact_number`, `email_address`, `course`, `account_type`) VALUES
('1-12001002', 2, 'Emil Dizon', '', '1234567', 2147483647, 'emildizon@yahoo.com', '', ''),
('12-021-095', 1, 'Hey Now', '', 'password', 2147483647, 'heynow@yahoo.com', '', ''),
('12-027-013', 1, 'Marco Polo', 'Bustillo', 'marcopolo', 2147483647, 'marcobustillo21@gmail.com', 'BSCE', 'Student'),
('12-027-091', 1, 'Ross Decena', '', 'rossdecena', 2147483647, 'ross@yahoo.com', '', ''),
('12-027-092', 1, 'Alexander', 'Pascual', 'alexalexalex', 2147483647, 'boomshakeboom1@yahoo.com', '', ''),
('12-028-014', 1, 'marcopolo', '', 'marcopolo', 2147483647, 'marcobustillo21@gmail.com', '', ''),
('12-090-012', 1, 'jayvee javier', '', 'marcopolo112', 2147483647, 'jayveegayy@yahoo.com', 'BSCS', ''),
('123', 1, 'hehehe', '', '123', 1234566789, 'marcobustillo21@gmail.com', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_ID` int(10) NOT NULL,
  `groups_id` varchar(10) NOT NULL,
  `details` varchar(255) NOT NULL,
  `schedule` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_ID`, `groups_id`, `details`, `schedule`) VALUES
(1, '1', 'Practical Exam', '2015-10-21 00:00:00'),
(2, '1', 'Online Quiz', '2015-10-22 00:00:00'),
(3, '2', 'Final Examination', '2015-10-23 00:00:00'),
(4, '3', 'Project Defense', '2015-10-24 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_ID` varchar(10) NOT NULL,
  `group_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_ID`, `group_name`) VALUES
('1', 'Soft Eng.'),
('2', 'modeling and simulation'),
('3', 'Free Elective 1'),
('4', 'Free Elective 2'),
('5', 'Free Elective 3');

-- --------------------------------------------------------

--
-- Table structure for table `group_member`
--

CREATE TABLE `group_member` (
  `group_ID` varchar(10) NOT NULL,
  `ID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_member`
--

INSERT INTO `group_member` (`group_ID`, `ID`) VALUES
('1', '1-12001002'),
('1', '12-027-013'),
('1', '12-027-092'),
('1', '12-028-014'),
('2', '1-12001002'),
('2', '12-027-013'),
('3', '1-12001002'),
('3', '12-027-013'),
('3', '12-027-092'),
('4', '1-12001002'),
('4', '12-027-013'),
('5', '1-12001002'),
('5', '12-027-013');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(10) NOT NULL,
  `group_id` int(10) NOT NULL,
  `ID` varchar(10) NOT NULL,
  `post_content` varchar(255) NOT NULL,
  `post_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `group_id`, `ID`, `post_content`, `post_date`) VALUES
(1, 1, '12-027-092', 'ako si alex', '2015-10-10'),
(2, 2, '12-027-092', 'lorem alex ipsum', '2015-11-16'),
(3, 1, '12-027-013', 'Ako si marco', '2015-10-18'),
(4, 2, '12-027-013', 'Ikaw ba si marco?', '2015-10-18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_ID`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_ID`);

--
-- Indexes for table `group_member`
--
ALTER TABLE `group_member`
  ADD PRIMARY KEY (`group_ID`,`ID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
