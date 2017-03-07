-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2016 at 06:17 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plugins_development_in_wordpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_child`
--

CREATE TABLE `wp_child` (
  `childid` mediumint(9) NOT NULL,
  `parentid` int(11) NOT NULL,
  `child_name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_child`
--

INSERT INTO `wp_child` (`childid`, `parentid`, `child_name`, `status`) VALUES
(9, 5, 'Stella Artois', 'Active'),
(10, 5, 'Hoegaarden', 'Active'),
(11, 5, 'Asahi', 'Active'),
(12, 5, 'Kingfisher Ultra', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_child`
--
ALTER TABLE `wp_child`
  ADD PRIMARY KEY (`childid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_child`
--
ALTER TABLE `wp_child`
  MODIFY `childid` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
