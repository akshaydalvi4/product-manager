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
-- Table structure for table `wp_product`
--

CREATE TABLE `wp_product` (
  `id` mediumint(9) NOT NULL,
  `product_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_info` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_url` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_product`
--

INSERT INTO `wp_product` (`id`, `product_name`, `product_info`, `city_id`, `child_id`, `parent_id`, `product_url`, `product_image`, `status`) VALUES
(2, 'Stella Artois', 'This six-century-old Belgian brew comes with a whole set of pouring rituals – and a chalice – but the light, full-bodied taste is worth it. Nobody does it quite like the Belgians.', '', '9', '5', 'http://www.stellaartois.com/', '20160916054354Stella_Artois_Bottle.jpg', 'Active'),
(3, 'Hoegaarden', 'The creamy Belgian wheat beer hits a home run with its hints of orange peel, coriander and spice.', '', '10', '5', 'http://hoegaarden.com/', '20160916054319hoegaarden_thumbnail.png', 'Active'),
(4, 'Asahi', 'Clean and crisp, this dry beer is manufactured with yeast, ingredients and technology that all live up to impossibly high Japanese standards – naturally.', '', '11', '5', 'https://www.asahibeer.com/', '20160916054218Contact-Us.jpg', 'Active'),
(5, 'Kingfisher (beer)', 'Kingfisher is an Indian beer brewed by United Breweries Group, Bangalore. The brand was launched in 1978. With a market share of over 36% in India, it is also available in 52 other countries.[1] The Heineken Group holds 42.4% equity shares in United Breweries Lt', '', '12', '5', 'http://www.kingfisherworld.com/', '20160916054814download.jpg', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_product`
--
ALTER TABLE `wp_product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_product`
--
ALTER TABLE `wp_product`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
