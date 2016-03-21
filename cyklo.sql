-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2016 at 06:01 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cyklo`
--

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE IF NOT EXISTS `request` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `college` varchar(64) NOT NULL,
  `number` varchar(16) NOT NULL,
  `email` varchar(64) NOT NULL,
  `cycle_number` int(11) NOT NULL,
  `request_done` tinyint(1) NOT NULL,
  `lock_state` tinyint(1) NOT NULL,
  `accepted` tinyint(4) NOT NULL,
  `cycle_type` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE IF NOT EXISTS `service` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `college` varchar(64) NOT NULL,
  `number` varchar(16) NOT NULL,
  `email` varchar(64) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `ongoing` tinyint(1) NOT NULL,
  `amount` int(4) NOT NULL,
  `cycle_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stands_normal`
--

CREATE TABLE IF NOT EXISTS `stands_normal` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(16) NOT NULL,
  `cycle_strength` int(4) NOT NULL,
  `cycles_available` int(4) NOT NULL,
  `cycles` varchar(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stands_normal`
--

INSERT INTO `stands_normal` (`id`, `name`, `cycle_strength`, `cycles_available`, `cycles`) VALUES
(1, 'alpha', 5, 5, '11111');

-- --------------------------------------------------------

--
-- Table structure for table `stands_premium`
--

CREATE TABLE IF NOT EXISTS `stands_premium` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(16) NOT NULL,
  `cycle_strength` int(4) NOT NULL,
  `cycles_available` int(4) NOT NULL,
  `cycles` varchar(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stands_premium`
--

INSERT INTO `stands_premium` (`id`, `name`, `cycle_strength`, `cycles_available`, `cycles`) VALUES
(1, 'alpha', 2, 2, '11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `request`
--
ALTER TABLE `request`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stands_normal`
--
ALTER TABLE `stands_normal`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stands_premium`
--
ALTER TABLE `stands_premium`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stands_normal`
--
ALTER TABLE `stands_normal`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stands_premium`
--
ALTER TABLE `stands_premium`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
