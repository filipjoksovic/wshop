-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2021 at 05:18 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `category` varchar(100) NOT NULL,
  `seller` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `category`, `seller`) VALUES
(4, 'Haljina', NULL, 8000, 2, 'odeca', 'petarmarkovic'),
(5, 'Converse ranac', NULL, 3500, 2, 'ranac', 'petarmarkovic'),
(9, 'Test proizvod', 'Test', 4000, 0, 'test', 'petarmarkovic');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `product_id` int(11) NOT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`product_id`, `path`) VALUES
(4, './media/14-20-5d62040ak042_green_1b.webp'),
(4, './media/14-54-cfd558d4k042_green_2b.webp'),
(4, './media/14-60-fe81b47cK042_ZIELONY.webp'),
(5, './media/1-f2-e475391d71027403_xxl.webp'),
(5, './media/71027403_xxl_a1.webp'),
(9, './media/14-4d-f6eefba7k042_green_1L.webp');

-- --------------------------------------------------------

--
-- Table structure for table `product_orders`
--

CREATE TABLE `product_orders` (
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `zip_code` varchar(50) NOT NULL,
  `payment_option` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_orders`
--

INSERT INTO `product_orders` (`product_id`, `quantity`, `username`, `first_name`, `last_name`, `country`, `city`, `address`, `zip_code`, `payment_option`, `order_date`, `status`) VALUES
(4, 3, 'filipjoksovic', 'Filip', 'Joksovic', 'Srbija', 'Kragujevac', 'Episkopa Save 17', '31000', 0, '2021-08-26 01:05:51', 0),
(5, 1, 'filipjoksovic', 'Filip', 'Joksovic', 'Srbija', 'Kragujevac', 'Episkopa Save 17', '31000', 0, '2021-08-26 01:05:51', 0),
(5, 2, 'filipjoksovic', 'Filip', 'Joksovic', 'Srbija', 'Kragujevac', 'Episkopa Save 17', '31000', 0, '2021-08-26 03:19:57', 0),
(4, 1, 'filipjoksovic', 'Filip', 'Joksovic', 'Srbija', 'Kragujevac', 'Episkopa Save 17', '31000', 0, '2021-08-26 03:19:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `product_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `grade` int(11) NOT NULL,
  `review` varchar(255) NOT NULL,
  `review_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`product_id`, `username`, `grade`, `review`, `review_date`) VALUES
(4, 'filipjoksovic', 3, 'Meh', '2021-08-26 04:19:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `first_name`, `last_name`, `email`, `password`, `type`) VALUES
('admin', 'Admin', 'Admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
('filipjoksovic', 'Filip', 'Joksovic', 'filipjoksovic1@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'kupac'),
('petarmarkovic', 'Petar', 'Markovic', 'petarmarkovic@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'admiprodavac');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller` (`seller`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_orders`
--
ALTER TABLE `product_orders`
  ADD KEY `username` (`username`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_orders`
--
ALTER TABLE `product_orders`
  ADD CONSTRAINT `product_orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_orders_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_reviews_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
