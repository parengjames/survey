-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2023 at 04:23 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `miracle`
--

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(100) NOT NULL,
  `quiz_title` varchar(100) NOT NULL,
  `quiz_desc` varchar(100) NOT NULL,
  `totalPoints` int(11) NOT NULL,
  `totalQuestion` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_correct`
--

CREATE TABLE `quiz_correct` (
  `quizcorrect_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `quizitem_id` int(11) NOT NULL,
  `hintsuse` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `quizcorrect_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_mistakes`
--

CREATE TABLE `quiz_mistakes` (
  `mistake_id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `quizitem_id` int(100) NOT NULL,
  `quiz_id` int(100) NOT NULL,
  `mistakes` int(100) NOT NULL,
  `quizmistake_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `quiz_correct`
--
ALTER TABLE `quiz_correct`
  ADD PRIMARY KEY (`quizcorrect_id`);

--
-- Indexes for table `quiz_mistakes`
--
ALTER TABLE `quiz_mistakes`
  ADD PRIMARY KEY (`mistake_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_correct`
--
ALTER TABLE `quiz_correct`
  MODIFY `quizcorrect_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_mistakes`
--
ALTER TABLE `quiz_mistakes`
  MODIFY `mistake_id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
