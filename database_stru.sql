-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 24, 2019 at 06:34 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `classified`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `addrsss_id` int(11) NOT NULL,
  `city` varchar(35) NOT NULL,
  `state` varchar(35) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`addrsss_id`, `city`, `state`, `ad_id`, `user_id`) VALUES
(3, 'long beach', 'CA', 3, 1),
(8, 'long beach', 'CA', 8, 1),
(9, 'long beach', 'CA', 9, 1),
(10, 'long beach', 'CA', 10, 1),
(11, 'long beach', 'CA', 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `ad_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(350) NOT NULL,
  `price` decimal(7,0) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`ad_id`, `user_id`, `name`, `description`, `price`, `date`) VALUES
(3, 1, 'tester', 'tttt', '100', '2019-02-23 00:14:23'),
(8, 1, 'Tester', 'Test', '10000', '2019-02-23 07:32:51'),
(9, 1, 'Tester', 'Test', '111', '2019-02-23 07:34:26'),
(10, 1, 'Tester', 'Test', '1000', '2019-02-23 07:36:25'),
(11, 1, 'Tester', 'Test', '11', '2019-02-23 07:37:05');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_Id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_make` varchar(35) NOT NULL,
  `car_model` varchar(35) NOT NULL,
  `car_mileage` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_Id`, `user_id`, `car_make`, `car_model`, `car_mileage`, `ad_id`) VALUES
(8, 1, 'Test', 'gg', 100, 3),
(13, 1, 'gggg', 'gg', 1000, 8),
(14, 1, 'gg', 'gg', 111, 9),
(15, 1, 'gg', 'gg', 100, 10),
(16, 1, 'ggg', 'gg', 111, 11);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `imge_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `surename` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(75) NOT NULL,
  `role` varchar(5) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `surename`, `email`, `password`, `role`) VALUES
(1, 'Demo', 'Hello World', 'Demo@de.com', '123', 'admin'),
(2, 'Tester', 'Al Test', 'al4@hotmail.com', '123', 'user'),
(5, 'Said Alhinai', 'Crash', 'said-alhinai1@hotmail.com', '123456', 'admin'),
(7, 'shathan', 'alhinai', 'rm05@hotmail.com', '123456789', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`addrsss_id`),
  ADD KEY `address_ibfk_1` (`ad_id`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_Id`),
  ADD KEY `cars_ibfk_1` (`ad_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_ibfk_1` (`ad_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `addrsss_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`ad_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`ad_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`ad_id`) ON DELETE CASCADE ON UPDATE CASCADE;
