-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2019 at 08:38 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `csy2028b`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `shipped_address` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_cart`
--

INSERT INTO `tbl_cart` (`cart_id`, `user_id`, `product_id`, `shipped_address`, `quantity`) VALUES
(1, 4, 4, 'Manang, Nepal', 1),
(2, 4, 4, 'Chitwan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`category_id`, `category_name`) VALUES
(1, 'TVs'),
(2, 'Computers'),
(3, 'Phones'),
(4, 'Gaming'),
(5, 'Cameras');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `shipped_address` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `shipped_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`order_id`, `user_id`, `product_id`, `shipped_address`, `quantity`, `shipped_status`) VALUES
(1, 4, 1, 'Biratnagar, Nepal', 2, 'shipped'),
(2, 4, 7, 'Kathmandu, Nepal', 1, 'shipped'),
(3, 4, 6, 'Rukum, Nepal', 1, 'not shipped');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `product_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `is_featured` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`product_id`, `title`, `price`, `manufacturer`, `description`, `is_featured`, `date_added`, `image`, `category_id`, `user_id`) VALUES
(1, 'Acer Nitro 5', 725, 'Acer', 'Great gaming budget laptop with powerful specs. Comes with Intel 8th gen processor.', 'no', '2018-12-01 12:50:20', 'acer_nitro_5.png', 4, 1),
(2, 'MSI GL63', 900, 'MSI', 'With Nvidia Geforce GTX 1050Ti ', 'yes', '2018-12-04 05:20:30', 'msigl63.jpg', 4, 1),
(3, 'Sony Bravia', 620, 'Sony Elec.', 'Full Quad HD tv with pleasant color effects and 4K display.', 'no', '2018-12-26 21:09:16', 'sonybravia.jpg', 1, 1),
(4, 'S9 Plus', 999, 'Samsung Electronics Ltd.', 'A great mobile device with good camera and clear screen', 'no', '2018-12-27 15:09:20', 's9plus.jpeg', 3, 1),
(6, 'Acer Gaming PC', 399, 'Acer', 'A powerful computer with great graphics card GTX 1070', 'no', '2018-12-17 11:10:13', 'acer_gaming_pc.jpg', 2, 1),
(7, 'Sony CoolPix P500', 850, 'Sony Electronics', 'DSLR with 50x zoom lens', 'yes', '2018-12-28 21:20:34', 'sony_dslr.jpg', 5, 1),
(8, 'Canon EOS Rebel', 670, 'Canon Corporations', 'With 2x Telephoto lens and 48GB internal storage ', 'yes', '2018-12-28 21:26:50', 'eos_rebel.jpg', 5, 1),
(11, 'LG ThinQ UHD TV', 775, 'LG Enterprises Ltd.', 'UHD TV with large screen', 'no', '2018-11-29 22:51:56', 'thinq.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reviews`
--

CREATE TABLE `tbl_reviews` (
  `review_id` int(11) NOT NULL,
  `review_text` varchar(255) NOT NULL,
  `review_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `review_status` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_reviews`
--

INSERT INTO `tbl_reviews` (`review_id`, `review_text`, `review_date`, `user_id`, `product_id`, `review_status`, `rating`) VALUES
(9, 'Cooling system is not well made', '2018-12-30 18:29:21', 4, 1, 'approved', 1),
(10, 'Best option among all the televisions on the market', '2018-12-30 20:25:26', 4, 3, 'approved', 5),
(11, 'LG is best of all', '2018-12-30 20:28:44', 4, 11, 'approved', 5),
(15, 'Keyboard travel distance is great', '2019-01-07 22:10:21', 4, 1, 'approved', 5),
(18, 'Great TV!', '2019-01-10 13:34:32', 8, 3, 'approved', 4),
(19, 'Small screen', '2019-01-13 07:40:07', 8, 11, 'approved', 1),
(20, 'bad keyboard', '2019-01-13 07:41:31', 8, 2, 'approved', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `firstname`, `lastname`, `email`, `username`, `password`, `user_type`) VALUES
(1, 'admin', '', 'admin@admin.com', 'admin', '$2y$10$1z8/4Tt57D95AVDHrcHK0eBi2GxG7ne7fo4cOfWMb2UKbweOF43E.', 'admin'),
(4, 'Hira', 'Kauchha', 'hirakauchha@gmail.com', 'hira', '$2y$10$.OYPwrYmqHFks0Vlu.wROux5/NMk.OZbxqkUjXsxH5T7etRgwCAqi', 'user'),
(8, 'Salon', 'Gurung', 'salon.gurung@gmail.com', 'salon', '$2y$10$1Dj63UumO4jx0xPRljrdhOc4RV.CP8v.smst8E/qqapmQ.x25L5IW', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_o_products` (`product_id`),
  ADD KEY `fk_o_users` (`user_id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `fk_r_users` (`user_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD CONSTRAINT `fk_c_products` FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_c_users` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `fk_o_products` FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_o_users` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD CONSTRAINT `fk_p_categories` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_p_users` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  ADD CONSTRAINT `fk_r_products` FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_r_users` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
