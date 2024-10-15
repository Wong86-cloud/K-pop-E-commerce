-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 04:06 AM
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
-- Database: `kpop_e-commerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `celebrity_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `button_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`celebrity_id`, `name`, `image_url`, `button_img`) VALUES
(1, 'BTS', 'bts.jpeg\r\n', 'bts_logo.png'),
(2, 'BLACKPINK', 'blackpink2.jpg', 'blackpink_logo.jfif');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(255) NOT NULL,
  `outgoing_msg_id` int(255) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `file`) VALUES
(12, 1517014417, 1655463620, 'Hi Ella', NULL),
(13, 1655463620, 1517014417, 'Hi', NULL),
(23, 1655463620, 1517014417, '', 'assets/images/uploads/2ne1.jpg'),
(24, 1655463620, 1517014417, 'omg 2ne1 with Thunder and Mimi ', 'assets/images/uploads/'),
(25, 1655463620, 1517014417, '', 'assets/images/uploads/Drip.pdf'),
(27, 1655463620, 1517014417, 'Babymonster new album', ''),
(28, 1517014417, 1655463620, 'Oh woah that\\\'s very fantastic !!', ''),
(29, 1517014417, 1655463620, 'Luv it', ''),
(30, 1517014417, 1655463620, 'Yahoo', ''),
(31, 1517014417, 1655463620, 'how\\\'s your day', ''),
(47, 1655463620, 1517014417, 'great', NULL),
(48, 1655463620, 1517014417, 'how about u', ''),
(49, 1655463620, 1517014417, '@', ''),
(50, 1655463620, 1517014417, 'e', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_cost` decimal(10,2) NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `country_code` varchar(10) NOT NULL,
  `handphone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `city` varchar(100) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `shipping_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_cost`, `order_status`, `unique_id`, `country_code`, `handphone`, `address`, `postcode`, `city`, `order_date`, `shipping_id`) VALUES
(24, 22.51, 'Pending', 1655463620, '+81', '0335467689', 'Shibuya Ward, Jinnan 2-1-2-3 Shibuya Heights Room 101', '〒150-0041', 'Shibuya-ku, Tokyo-to', '2024-10-13 23:08:29', 3),
(27, 34.68, 'Pending', 1655463620, '+81', '0335467689', 'Shibuya Ward, Jinnan 2-1-2-3 Shibuya Heights Room 101', '〒150-0041', 'Shibuya-ku, Tokyo-to', '2024-10-14 12:56:31', 3);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `item_id` int(11) NOT NULL,
  `unique_id` int(200) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `product_id` int(11) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`item_id`, `unique_id`, `order_id`, `order_date`, `product_id`, `product_image`, `product_name`, `quantity`, `product_price`) VALUES
(13, 1655463620, 24, '2024-10-13 23:08:29', 1, 'merch1.png', 'Passport Cover', 1, 15.58),
(16, 1655463620, 27, '2024-10-14 12:56:31', 9, 'photobook3.png', 'SUGA ‘Wholly or Whole me’', 1, 27.06);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(19) NOT NULL,
  `post_id` bigint(19) NOT NULL,
  `unique_id` int(200) NOT NULL,
  `post` text NOT NULL,
  `post_image` varchar(500) NOT NULL,
  `post_comments` int(11) NOT NULL,
  `post_likes` int(11) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_category` varchar(50) NOT NULL,
  `celebrity` varchar(100) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_category`, `celebrity`, `product_image`, `product_name`, `product_price`, `product_description`) VALUES
(1, 'Merchandise', 'BTS', 'merch1.png', 'Passport Cover', 15.58, ''),
(2, 'Merchandise', 'BTS', 'merch2.png', 'Travel Pouch (Blue)', 23.78, 'Compact BTS travel pouch, perfect for organizing your accessories and essentials on the go.'),
(3, 'Merchandise', 'BTS', 'merch3.png', 'S/S T-Shirt (Ivory)', 40.18, ''),
(4, 'Album', 'BTS', 'album1.png', 'V (BTS) \'Layover\' LP', 42.64, ''),
(5, 'Album', 'BTS', 'album2.png', 'Jimin (BTS) \'FACE\' LP', 42.64, ''),
(6, 'Album', 'BTS', 'album3.png', 'Jimin (BTS) \'MUSE\' (Set)', 32.47, ''),
(7, 'Photobook', 'BTS', 'photobook1.png', 'Jin ‘Sea of JIN island’', 42.64, ''),
(8, 'Photobook', 'BTS', 'photobook2.png', 'BTS \'WE\' SET', 42.64, ''),
(9, 'Photobook', 'BTS', 'photobook3.png', 'SUGA ‘Wholly or Whole me’', 27.06, ''),
(10, 'Photocard', 'BTS', 'photocard1.png', 'BTS V layover POB PC', 7.00, ''),
(11, 'Photocard', 'BTS', 'photocard2.jpg', 'Photocard Set (BTS)', 15.58, ''),
(12, 'Photocard', 'BTS', 'photocard3.png', 'BTS V FRIENDS Photocards 2024', 20.68, ''),
(13, 'Album', 'BTS', 'album_bts.png', 'RM (BTS) \'Right Place, Wrong Person\' (Set)', 48.70, ''),
(15, 'Merchandise', 'BLACKPINK', 'merch4.png', 'OFFICIAL LIGHT STICK ver.2', 31.98, ''),
(24, 'Photocard', 'BLACKPINK', 'photocard4.png', '[ME] JISOO PHOTO CARD DECO KIT', 9.84, '');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_methods`
--

CREATE TABLE `shipping_methods` (
  `shipping_id` int(11) NOT NULL,
  `shipping_logo` varchar(255) NOT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `shipping_period` varchar(255) NOT NULL,
  `shipping_fee` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping_methods`
--

INSERT INTO `shipping_methods` (`shipping_id`, `shipping_logo`, `shipping_name`, `shipping_period`, `shipping_fee`) VALUES
(1, 'assets/images/shipping/dhl.png', 'DHL Express Worldwide', '1-3 business days', 12.00),
(2, 'assets/images/shipping/fedex.png', 'FedEx International Priority', '2-5 business days', 10.00),
(3, 'assets/images/shipping/usps.png', 'USPS Priority Mail International', '6-10 business days', 6.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `unique_id` int(200) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `country_code` varchar(10) DEFAULT NULL,
  `handphone` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `postcode` varchar(20) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(400) NOT NULL,
  `background_img` varchar(400) DEFAULT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `unique_id`, `fname`, `lname`, `gender`, `dob`, `country`, `country_code`, `handphone`, `email`, `address`, `postcode`, `city`, `password`, `img`, `background_img`, `status`) VALUES
(1, 1655463620, 'Anna', 'Tanaka', 'female', '2005-11-17', 'Japan', '+81', '0335467689', 'annajiang@gmail.com', 'Shibuya Ward, Jinnan 2-1-2-3 Shibuya Heights Room 101', '〒150-0041', 'Shibuya-ku, Tokyo-to', '$2y$10$wvbkPyqpjtGsNiInjrGrdOHvPkFl9dXHfee7rN0sGGuzVYkde/Tp2', 'anna.jpg', NULL, 'Active now'),
(2, 1517014417, 'Ella', 'Gross', NULL, NULL, NULL, NULL, NULL, 'ellagross@gmail.com', NULL, NULL, NULL, '$2y$10$z4c4QGT1D1cEcz.QtSj5pOtq8exHdFx12vbV8ujgR7477LqE6b7IK', 'ella.jpg', NULL, 'Active now');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `unique_id` int(200) NOT NULL,
  `product_id` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `unique_id`, `product_id`, `added_at`) VALUES
(18, 1517014417, 1, '2024-10-04 19:51:16'),
(21, 1517014417, 4, '2024-10-04 19:51:19'),
(22, 1517014417, 5, '2024-10-04 19:51:21'),
(24, 1517014417, 7, '2024-10-04 19:51:22'),
(58, 1655463620, 7, '2024-10-14 04:54:03'),
(59, 1655463620, 9, '2024-10-14 04:54:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`celebrity_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `unique_id` (`unique_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `unique_id` (`unique_id`),
  ADD KEY `fk_shipping_name` (`shipping_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unique_id` (`unique_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `celebrity` (`celebrity`);

--
-- Indexes for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD PRIMARY KEY (`shipping_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD UNIQUE KEY `unique_user_product` (`unique_id`,`product_id`),
  ADD KEY `unique_id` (`unique_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `celebrity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`unique_id`) REFERENCES `users` (`unique_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_shipping_name` FOREIGN KEY (`shipping_id`) REFERENCES `shipping_methods` (`shipping_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`unique_id`) REFERENCES `users` (`unique_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`unique_id`) REFERENCES `users` (`unique_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`celebrity`) REFERENCES `artists` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`unique_id`) REFERENCES `users` (`unique_id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
