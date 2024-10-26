-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2024 at 03:28 AM
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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `unique_id` int(200) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `admin_work_code` varchar(50) NOT NULL,
  `img` varchar(400) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Offline Now'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `unique_id`, `fname`, `lname`, `gender`, `email`, `admin_work_code`, `img`, `password`, `status`) VALUES
(1, 759044220, 'Zi Hao', '(Admin)', 'male', 'zihaowong@admin.com.my', '2818', 'admin.png', '$2y$10$SATLIdumA5a.xd5J119dEO9iwd8WYxLrgsrNYrgYZvnYyx3Ec1CQy', 'Offline now');

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

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `unique_id`, `product_id`, `quantity`, `product_name`, `product_image`, `product_price`) VALUES
(38, 1517014417, 15, 1, 'OFFICIAL LIGHT STICK ver.2', 'merch4.png', 31.98),
(46, 1517014417, 4, 1, 'V (BTS) \'Layover\' LP', 'album1.png', 42.64),
(47, 1517014417, 1, 2, 'Passport Cover', 'merch1.png', 15.58);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(6) UNSIGNED NOT NULL,
  `unique_id` int(200) NOT NULL,
  `question_1` varchar(255) NOT NULL,
  `question_2` varchar(255) NOT NULL,
  `question_3` text NOT NULL,
  `question_4` varchar(255) NOT NULL,
  `question_5` varchar(255) NOT NULL,
  `question_6` varchar(255) NOT NULL,
  `question_7` text NOT NULL,
  `question_8` varchar(255) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `unique_id`, `question_1`, `question_2`, `question_3`, `question_4`, `question_5`, `question_6`, `question_7`, `question_8`, `submitted_at`) VALUES
(41, 1517014417, '4', '4', 'Albums, Photocards', 'Easy', 'PayPal', 'No, everything was smooth', 'Discussion forums', '4', '2024-10-23 10:31:20');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `friend_id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `friend_unique_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`friend_id`, `unique_id`, `friend_unique_id`) VALUES
(7, 1655463620, 1517014417),
(11, 1517014417, 1655463620);

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
(99, 1655463620, 1517014417, '', 'assets/images/uploads/liampayne.jpg'),
(100, 1655463620, 1517014417, 'Liam Payne passed away So sad', ''),
(101, 1655463620, 1517014417, '😭😭😭', ''),
(102, 1655463620, 1517014417, 'halo?', '');

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
(24, 22.51, 'Received', 1655463620, '+81', '0335467689', 'Shibuya Ward, Jinnan 2-1-2-3 Shibuya Heights Room 101', '〒150-0041', 'Shibuya-ku, Tokyo-to', '2024-10-13 23:08:29', 3),
(27, 34.68, 'Pending', 1655463620, '+81', '0335467689', 'Shibuya Ward, Jinnan 2-1-2-3 Shibuya Heights Room 101', '〒150-0041', 'Shibuya-ku, Tokyo-to', '2024-10-14 12:56:31', 3),
(31, 116.91, 'Pending', 1655463620, '+81', '0335467689', 'Shibuya Ward, Jinnan 2-1-2-3 Shibuya Heights Room 101', '〒150-0041', 'Shibuya-ku, Tokyo-to', '2024-10-18 12:03:08', 2),
(32, 70.04, 'Pending', 1655463620, '+81', '0335467689', 'Shibuya Ward, Jinnan 2-1-2-3 Shibuya Heights Room 101', '〒150-0041', 'Shibuya-ku, Tokyo-to', '2024-10-22 02:01:43', 2);

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
(16, 1655463620, 27, '2024-10-14 12:56:31', 9, 'photobook3.png', 'SUGA ‘Wholly or Whole me’', 1, 27.06),
(20, 1655463620, 31, '2024-10-18 12:03:08', 1, 'merch1.png', 'Passport Cover', 1, 15.58),
(21, 1655463620, 31, '2024-10-18 12:03:08', 7, 'photobook1.png', 'Jin ‘Sea of JIN island’', 2, 42.64),
(22, 1655463620, 32, '2024-10-22 02:01:44', 7, 'photobook1.png', 'Jin ‘Sea of JIN island’', 1, 42.64),
(23, 1655463620, 32, '2024-10-22 02:01:44', 10, 'photocard1.png', 'BTS V layover POB PC', 2, 7.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_issues`
--

CREATE TABLE `order_issues` (
  `issue_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('pending','resolved') NOT NULL DEFAULT 'pending',
  `issue_description` text NOT NULL,
  `issue_image` varchar(400) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_issues`
--

INSERT INTO `order_issues` (`issue_id`, `order_id`, `user_id`, `status`, `issue_description`, `issue_image`, `created_at`) VALUES
(1, 31, 1655463620, 'resolved', 'Where is my passport cover?', 'missing.png\r\n', '2024-10-26 00:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `personal_photos`
--

CREATE TABLE `personal_photos` (
  `photo_id` int(11) NOT NULL,
  `unique_id` int(200) NOT NULL,
  `photo_url` varchar(255) NOT NULL,
  `upload_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_photos`
--

INSERT INTO `personal_photos` (`photo_id`, `unique_id`, `photo_url`, `upload_date`) VALUES
(12, 1655463620, 'assets/images/uploads/anna_pic1.png', '2024-10-19 14:38:54'),
(13, 1655463620, 'assets/images/uploads/anna_pic2.png', '2024-10-19 14:38:58'),
(15, 1655463620, 'assets/images/uploads/anna_pic4.jpg', '2024-10-19 14:40:00'),
(16, 1655463620, 'assets/images/uploads/anna_pic3.png', '2024-10-19 14:41:45'),
(19, 1655463620, 'assets/images/uploads/anna_pic5.png', '2024-10-21 13:40:51'),
(20, 1517014417, 'assets/images/uploads/ella2.jpg', '2024-10-25 12:03:04');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `room_id` int(11) DEFAULT NULL,
  `post_id` int(11) NOT NULL,
  `unique_id` int(200) NOT NULL,
  `post` text NOT NULL,
  `post_image` varchar(500) DEFAULT NULL,
  `post_comments` int(11) DEFAULT 0,
  `post_likes` int(11) DEFAULT 0,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `got_image` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`room_id`, `post_id`, `unique_id`, `post`, `post_image`, `post_comments`, `post_likes`, `post_date`, `got_image`) VALUES
(1, 1, 1655463620, 'ROSÉ finally released her new song! Luv it~', 'assets/images/uploads/APT..png', 0, 1, '2024-10-25 04:02:44', 1),
(2, 4, 1655463620, 'OMG😭! All of them looks so gorgeous✨!', 'assets/images/uploads/aespa.jpeg', 2, 2, '2024-10-22 05:01:56', 1),
(1, 6, 1517014417, 'Congrats😍 to our unnie who takes 1st win for \"Mantra\" on M Countdown.', 'assets/images/uploads/jennie-mcountdown.jpg', 1, 2, '2024-10-22 05:05:48', 1),
(NULL, 9, 1517014417, 'sjdjhshdhsdjhjhf🙈', '', 1, 1, '2024-10-25 04:02:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `unique_id` int(200) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`comment_id`, `post_id`, `unique_id`, `comment`, `comment_date`) VALUES
(24, 4, 1655463620, 'yessss😘', '2024-10-20 10:59:34'),
(27, 4, 1517014417, 'ATE💋', '2024-10-21 18:42:08'),
(32, 6, 1655463620, 'ATE!!', '2024-10-22 05:05:48'),
(33, 9, 1517014417, 'yay', '2024-10-25 04:02:11');

--
-- Triggers `post_comments`
--
DELIMITER $$
CREATE TRIGGER `decrement_post_comments` AFTER DELETE ON `post_comments` FOR EACH ROW BEGIN
    UPDATE posts
    SET post_comments = post_comments - 1
    WHERE post_id = OLD.post_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `like_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `unique_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`like_id`, `post_id`, `unique_id`) VALUES
(35, 1, 1517014417),
(31, 4, 1517014417),
(29, 4, 1655463620),
(32, 6, 1517014417),
(33, 6, 1655463620),
(34, 9, 1517014417);

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
(1, 'Merchandise', 'BTS', 'merch1.png', 'Passport Cover', 15.58, 'Stylish and durable, this BTS Passport Cover keeps your travel documents safe while showcasing your fandom.'),
(2, 'Merchandise', 'BTS', 'merch2.png', 'Travel Pouch (Blue)', 23.78, 'Compact BTS travel pouch, perfect for organizing your accessories and essentials on the go.'),
(3, 'Merchandise', 'BTS', 'merch3.png', 'S/S T-Shirt (Ivory)', 40.18, 'Comfortable and stylish, this ivory short sleeve T-shirt features a trendy BTS graphic for casual wear.'),
(4, 'Album', 'BTS', 'album1.png', 'V (BTS) \'Layover\' LP', 42.64, 'Enjoy V\'s soothing melodies with this \'Layover\' LP, a must-have for any music lover.'),
(5, 'Album', 'BTS', 'album2.png', 'Jimin (BTS) \'FACE\' LP', 42.64, 'Dive into Jimin\'s heartfelt songs with the \'FACE\' LP, perfect for spinning on your turntable.'),
(6, 'Album', 'BTS', 'album3.png', 'Jimin (BTS) \'MUSE\' (Set)', 32.47, 'Celebrate Jimin\'s artistry with this exclusive \'MUSE\' Set featuring stunning visuals and quotes.'),
(7, 'Photobook', 'BTS', 'photobook1.png', 'Jin ‘Sea of JIN island’', 42.64, 'Discover the enchanting world of Jin with this beautifully designed product reflecting his personality.'),
(8, 'Photobook', 'BTS', 'photobook2.png', 'BTS \'WE\' SET', 42.64, 'Celebrate unity with the \'WE\' SET, featuring items that embody the spirit of BTS.'),
(9, 'Photobook', 'BTS', 'photobook3.png', 'SUGA ‘Wholly or Whole me’', 27.06, 'Explore SUGA\'s introspective journey with this unique product reflecting his depth and artistry.'),
(10, 'Photocard', 'BTS', 'photocard1.png', 'BTS V layover POB PC', 7.00, 'Add to your collection with this stunning Proof of Purchase PC featuring V\'s charm.\r\n'),
(11, 'Photocard', 'BTS', 'photocard2.jpg', 'Photocard Set (BTS)', 15.58, 'This exclusive Photocard Set includes high-quality images of BTS members, perfect for fans.'),
(12, 'Photocard', 'BTS', 'photocard3.png', 'BTS V FRIENDS Photocards 2024', 20.68, 'Celebrate friendship with the BTS V FRIENDS Photocards 2024 set, capturing heartwarming moments.'),
(13, 'Album', 'BTS', 'album_bts.png', 'RM (BTS) \'Right Place, Wrong Person\' (Set)', 48.70, 'Explore RM\'s themes with the \'Right Place, Wrong Person\' Set, inspired by his insightful lyrics.'),
(15, 'Merchandise', 'BLACKPINK', 'merch4.png', 'OFFICIAL LIGHT STICK ver.2', 31.98, 'Illuminate your fandom with the OFFICIAL LIGHT STICK ver.2, perfect for concerts and events.'),
(24, 'Photocard', 'BLACKPINK', 'photocard4.png', '[ME] JISOO PHOTO CARD DECO KIT', 9.84, 'Get creative with the [ME] JISOO PHOTO CARD DECO KIT, featuring beautiful stickers and accessories.');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `hashtag` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name`, `hashtag`, `created_by`, `creation_date`) VALUES
(1, 'Blackpink 2024', '#Blackpink', 1517014417, '2024-10-22 02:38:22'),
(2, 'Whiplash', '#AESPA', 1517014417, '2024-10-22 04:42:53'),
(10, '10 Anniversary', '#BTS', 1655463620, '2024-10-22 05:07:12');

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
  `about_me` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(400) NOT NULL,
  `background_img` varchar(400) DEFAULT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `unique_id`, `fname`, `lname`, `gender`, `dob`, `country`, `country_code`, `handphone`, `email`, `address`, `postcode`, `city`, `about_me`, `password`, `img`, `background_img`, `status`) VALUES
(1, 1655463620, 'Anna', 'Tanaka', 'Female', '2005-11-17', 'Japan', '+81', '0335467689', 'annajiang@gmail.com', 'Shibuya Ward, Jinnan 2-1-2-3 Shibuya Heights Room 101', '〒150-0041', 'Shibuya-ku, Tokyo-to', '                        Hi! Nice to meet you! I\\\'m Anna😄. Let\\\'s make friends 👥💖~', '$2y$10$vbSuA.lItGccFHB9s1lpjus45es7rOeNbl0lG1P.8rTC5.baNm4/y', 'anna.jpg', 'anna_background.png', 'Offline now'),
(2, 1517014417, 'Ella', 'Gross', 'Female', '2008-11-25', 'United States', NULL, NULL, 'ellagross@gmail.com', NULL, NULL, NULL, '                        HELLO!                    ', '$2y$10$xwIug7rPETLcgheGO9bqEuX32K/nz0imhlKtzwU6oh8QhMNPiB/W2', 'ella.jpg', 'ella_background.png', 'Offline now');

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
(61, 1655463620, 10, '2024-10-17 04:53:19'),
(62, 1655463620, 1, '2024-10-18 04:02:00'),
(64, 1517014417, 6, '2024-10-21 18:40:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `admin_work_code` (`admin_work_code`);

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
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`friend_id`),
  ADD KEY `unique_id` (`unique_id`),
  ADD KEY `friend_unique_id` (`friend_unique_id`);

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
-- Indexes for table `order_issues`
--
ALTER TABLE `order_issues`
  ADD PRIMARY KEY (`issue_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `unique_id` (`user_id`);

--
-- Indexes for table `personal_photos`
--
ALTER TABLE `personal_photos`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `unique_id` (`unique_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `unique_id` (`unique_id`),
  ADD KEY `has_image` (`got_image`),
  ADD KEY `fk_room` (`room_id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `unique_id` (`unique_id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`like_id`),
  ADD UNIQUE KEY `unique_like` (`post_id`,`unique_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `unique_id` (`unique_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `celebrity` (`celebrity`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `hashtag` (`hashtag`),
  ADD KEY `created_by` (`created_by`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `celebrity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `friend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `order_issues`
--
ALTER TABLE `order_issues`
  MODIFY `issue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_photos`
--
ALTER TABLE `personal_photos`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

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
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`unique_id`) REFERENCES `users` (`unique_id`) ON DELETE CASCADE;

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`unique_id`) REFERENCES `users` (`unique_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_unique_id`) REFERENCES `users` (`unique_id`) ON DELETE CASCADE;

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
-- Constraints for table `order_issues`
--
ALTER TABLE `order_issues`
  ADD CONSTRAINT `order_issues_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_issues_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`unique_id`) ON DELETE CASCADE;

--
-- Constraints for table `personal_photos`
--
ALTER TABLE `personal_photos`
  ADD CONSTRAINT `personal_photos_ibfk_1` FOREIGN KEY (`unique_id`) REFERENCES `users` (`unique_id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`unique_id`) REFERENCES `users` (`unique_id`) ON DELETE CASCADE;

--
-- Constraints for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_comments_ibfk_2` FOREIGN KEY (`unique_id`) REFERENCES `users` (`unique_id`) ON DELETE CASCADE;

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`unique_id`) REFERENCES `users` (`unique_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`celebrity`) REFERENCES `artists` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`unique_id`) ON DELETE CASCADE;

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
