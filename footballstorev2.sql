-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2025 at 06:35 PM
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
-- Database: `footballstorev2`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(160) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `content` mediumtext NOT NULL,
  `hero_image_url` varchar(255) DEFAULT NULL,
  `related_product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `slug`, `excerpt`, `content`, `hero_image_url`, `related_product_id`, `created_at`) VALUES
(1, 'Kaká Autograph Frame', 'kaka-autograph-frame', 'Rare collectible signed by Kaká — museum-grade frame.', '<p>Signed by Kaká during his Real Madrid era. Numbered 1 of 100 worldwide, COA included.</p><ul><li>50×70 cm</li><li>UV-protected glass</li></ul>', 'images/learn/kaka.jpg', NULL, '2025-10-22 19:17:47'),
(2, 'Cole Palmer Autograph Frame', 'cole-palmer-autograph', 'A premium collectible celebrating Cole Palmer.', '<p>Celebrate the rise of Cole Palmer with a premium signed display. Limited to 100 pieces.</p>', 'images/learn/cole.jpg', NULL, '2025-10-22 19:17:47');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `full_name`, `email`, `message`, `created_at`) VALUES
(1, 'teem', 'teem12@gmail.com', 'hello', '2025-10-22 17:35:51'),
(2, 'teem', 'teem12@gmail.com', 'hello', '2025-10-22 20:40:48'),
(3, 'proud', 'proudproud@gmail.com', 'แอบชอบคนทำเว็บค่ะ', '2025-10-22 23:16:49');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `email` varchar(160) DEFAULT NULL,
  `phone` varchar(40) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `address`, `created_at`) VALUES
(1, 'teem', 'teem12@gmail.com', '0924233164', 'teem12@gmail.com', '2025-10-22 21:25:59'),
(2, 'Phitchaya', 'phitchaya1502@gmail.com', '0924233164', 'teem12@gmail.com', '2025-10-22 21:33:30'),
(3, 'mix', 'mix12@gmail.com', '0924233164', '41/2', '2025-10-22 21:46:18'),
(4, 'mix', 'mix12@gmail.com', '0924233164', 'teem12@gmail.com', '2025-10-22 21:50:54'),
(5, 'Phitchaya', 'phitchaya1502@gmail.com', '0924233164', '41/2', '2025-10-22 21:51:20'),
(6, 'Phitchaya', 'phitchaya1502@gmail.com', '0924233164', '248/14 ทับกวาง แก่งคอย สระบุรี 18260', '2025-10-22 22:14:23'),
(7, 'mix', 'mix12@gmail.com', '0924233164', '41/2', '2025-10-22 22:19:22'),
(8, 'proud', 'proudproud@gmail.com', '0871234569', '41/2', '2025-10-22 23:15:43'),
(9, 'proud', 'proudproud@gmail.com', '0871234569', '41/2', '2025-10-23 13:35:02'),
(10, 'Phitchaya', 'phitchaya1502@gmail.com', '0924233164', '41/2', '2025-10-23 15:11:00'),
(11, 'Phitchaya', 'phitchaya1502@gmail.com', '0924233164', '41/2', '2025-10-23 15:33:42'),
(12, 'Phitchaya', 'phitchaya1502@gmail.com', '0924233164', '41/2', '2025-10-23 15:35:14'),
(13, 'mix', 'mix12@gmail.com', '0924233164', '41/2', '2025-10-23 15:36:43');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_number` varchar(32) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` enum('COD','TRANSFER','CARD') DEFAULT 'COD',
  `status` enum('PENDING','PAID','SHIPPED','CANCELLED') DEFAULT 'PENDING',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_number`, `subtotal`, `shipping_fee`, `grand_total`, `payment_method`, `status`, `created_at`) VALUES
(1, 1, 'FS251022232559261', 4500.00, 0.00, 4500.00, 'COD', 'PENDING', '2025-10-22 21:25:59'),
(2, 2, 'FS251022233330572', 4890.00, 0.00, 4890.00, 'COD', 'PENDING', '2025-10-22 21:33:30'),
(3, 3, 'FS251022234618457', 21000.00, 0.00, 21000.00, 'COD', 'PENDING', '2025-10-22 21:46:18'),
(4, 4, 'FS251022235054593', 2900.00, 0.00, 2900.00, 'COD', 'PENDING', '2025-10-22 21:50:54'),
(5, 5, 'FS251022235120470', 6884.09, 0.00, 6884.09, 'COD', 'PENDING', '2025-10-22 21:51:20'),
(6, 6, 'FS251023001423108', 9200.00, 0.00, 9200.00, 'COD', 'PENDING', '2025-10-22 22:14:23'),
(7, 7, 'FS251023001922985', 2900.00, 0.00, 2900.00, 'COD', 'PENDING', '2025-10-22 22:19:22'),
(8, 8, 'FS251023011543387', 1990.00, 0.00, 1990.00, 'TRANSFER', 'PENDING', '2025-10-22 23:15:43'),
(9, 9, 'FS251023153502358', 2900.00, 0.00, 2900.00, 'COD', 'PENDING', '2025-10-23 13:35:02'),
(10, 10, 'FS251023171100471', 5800.00, 0.00, 5800.00, 'COD', 'PENDING', '2025-10-23 15:11:00'),
(11, 11, 'FS251023173342904', 8900.00, 0.00, 8900.00, 'COD', 'PENDING', '2025-10-23 15:33:42'),
(12, 12, 'FS251023173514244', 8900.00, 0.00, 8900.00, 'COD', 'PENDING', '2025-10-23 15:35:14'),
(13, 13, 'FS251023173643179', 37000.00, 0.00, 37000.00, 'COD', 'PENDING', '2025-10-23 15:36:43');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `line_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `title`, `price`, `qty`, `line_total`) VALUES
(1, 1, 7, 'UEFA Euro 2024 Match Ball', 4500.00, 1, 4500.00),
(2, 2, 4, 'Chelsea 2025/26 Stadium Third', 2900.00, 1, 2900.00),
(3, 2, 8, 'Liverpool Fan Pack (Scarf + Pins)', 1990.00, 1, 1990.00),
(4, 3, 4, 'Chelsea 2025/26 Stadium Third', 2900.00, 1, 2900.00),
(5, 3, 5, 'Nike Mercurial Vapor 15', 8900.00, 1, 8900.00),
(6, 3, 6, 'Nike Mercurial Superfly 9 Purple', 9200.00, 1, 9200.00),
(7, 4, 4, 'Chelsea 2025/26 Stadium Third', 2900.00, 1, 2900.00),
(8, 5, 2, 'LAMINE YAMAL | UCL Men’s Home Player Edition 25/26', 6884.09, 1, 6884.09),
(9, 6, 6, 'Nike Mercurial Superfly 9 Purple', 9200.00, 1, 9200.00),
(10, 7, 4, 'Chelsea 2025/26 Stadium Third', 2900.00, 1, 2900.00),
(11, 8, 8, 'Liverpool Fan Pack (Scarf + Pins)', 1990.00, 1, 1990.00),
(12, 9, 4, 'Chelsea 2025/26 Stadium Third', 2900.00, 1, 2900.00),
(13, 10, 4, 'Chelsea 2025/26 Stadium Third', 2900.00, 2, 5800.00),
(14, 11, 5, 'Nike Mercurial Vapor 15', 8900.00, 1, 8900.00),
(15, 12, 5, 'Nike Mercurial Vapor 15', 8900.00, 1, 8900.00),
(16, 13, 3, 'FC Barcelona x Travis Scott Jersey 24/25', 37000.00, 1, 37000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `category` varchar(60) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `tags` varchar(200) DEFAULT NULL,
  `image_url` varchar(500) NOT NULL,
  `is_best_seller` tinyint(1) DEFAULT 0,
  `is_sale` tinyint(1) DEFAULT 0,
  `sale_badge_text` varchar(40) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `specs` text DEFAULT NULL,
  `team` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `category`, `price`, `tags`, `image_url`, `is_best_seller`, `is_sale`, `sale_badge_text`, `created_at`, `description`, `specs`, `team`) VALUES
(1, 'NIKE Tottenham Hotspur Away Stadium 2025/26 Jersey', 'Shirt', 2900.00, 'best', 'https://scontent.fbkk12-3.fna.fbcdn.net/v/t39.30808-6/517583969_1288296782650512_6441785903454952352_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=127cfc&_nc_ohc=dZO2qlzdnCEQ7kNvwEAYBhS&_nc_oc=Adl8Mm-eDnGNDG-OzQwfJm2ELU5bFMEEGoA0-Dfcangswo39qxYqLT4-msWwu06wyyuKhONUItldWDSZ5PsES0Ry&_nc_zt=23&_nc_ht=scontent.fbkk12-3.fna&_nc_gid=Cm_PHTiaZM9xhKfOuN-htg&oh=00_AfeQwgtBRCmU7o22ew3O2FczKjhN5hImMPxqtXjKF-k-ng&oe=68FFF6A9', 1, 0, '', '2025-10-22 16:31:08', NULL, NULL, NULL),
(2, 'LAMINE YAMAL | UCL Men’s Home Player Edition 25/26', 'FOOTBALL SHIRT', 6884.09, NULL, 'https://store.fcbarcelona.com/cdn/shop/files/VO250728A21518_med.jpg?v=1757335050', 1, 0, NULL, '2025-10-22 16:31:08', NULL, NULL, NULL),
(3, 'FC Barcelona x Travis Scott Jersey 24/25', 'Shirt', 37000.00, 'best', 'https://www.soccerbible.com/media/169294/barca-23-min.jpg?', 1, 0, '', '2025-10-22 16:31:08', NULL, NULL, NULL),
(4, 'Chelsea 2025/26 Stadium Third', 'FOOTBALL SHIRT', 2900.00, NULL, 'https://store.chelseafc.com/content/ws/all/fcbcf4fc-5784-4c71-98fe-97cbb4d93aaa__2000X2000.png?w=570', 1, 0, NULL, '2025-10-22 16:31:08', NULL, NULL, NULL),
(5, 'Nike Mercurial Vapor 15', 'CLEATS', 8900.00, NULL, 'https://static.nike.com/a/images/t_web_pdp_535_v2/f_auto/d2e5b180-4f98-4c5f-89d0-eb79008b4519/ZOOM+VAPOR+15+ELITE+FG+AS.png', 0, 1, 'SALE UP TO 40%', '2025-10-22 16:31:08', NULL, NULL, NULL),
(6, 'Nike Mercurial Superfly 9 Purple', 'Cleats', 9200.00, 'sale', 'https://static.nike.com/a/images/t_web_pdp_535_v2/f_auto/6ffd36e1-c8aa-483f-9b1f-4b1f8777cc63/ZOOM+SUPERFLY+9+AM+PLUS+FG.png', 0, 1, 'SALE UP TO 40%', '2025-10-22 16:31:08', NULL, NULL, NULL),
(7, 'UEFA Euro 2024 Match Ball', 'SOCCER BALL', 4500.00, NULL, 'https://www.footballshirtculture.com/images/cwgallery/1761-adidas-fussballliebe-uefa-euro-2024-match-ball/1761_adidas_fussballliebe_uefa_euro_2024_match_ball_a1.jpg', 0, 1, 'SALE UP TO 40%', '2025-10-22 16:31:08', NULL, NULL, NULL),
(8, 'Liverpool Fan Pack (Scarf + Pins)', 'Wishlist', 1990.00, 'sale', 'https://store.liverpoolfc.com/media/catalog/product/cache/a8585741965541bd35c89e2a8929f2a6/a/2/a21fw16-569.jpg', 0, 1, 'SALE UP TO 40%', '2025-10-22 16:31:08', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `series`
--

CREATE TABLE `series` (
  `id` int(11) NOT NULL,
  `club_name` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `series`
--

INSERT INTO `series` (`id`, `club_name`, `description`, `image_url`) VALUES
(1, 'FC Barcelona', 'Exclusive FC Barcelona Collection', 'https://www.fcbarcelona.com/photo-resources/2025/10/21/c92c5ce5-a67c-4374-ab5d-b888d16d28bc/_MGA0544.jpg?width=1280&height=800'),
(2, 'Liverpool FC', 'Legendary Liverpool Collection', 'https://media.video-cdn.espn.com/motion/2025/1022/dm_251022_COM_SOC_Analysis_The_numbers_behind_LiverpoolE28099s_thrashing_of_Frankfurt__GLOBAL_2025-09-22/dm_251022_COM_SOC_Analysis_The_numbers_behind_LiverpoolE28099s_thrashing_of_Frankfurt__GLOBAL_2025-09-22.jpg'),
(3, 'Chelsea FC', 'Chelsea Home Collection', 'https://img.chelseafc.com/image/upload/f_auto,c_fill,g_faces,w_1440,h_856,q_90/editorial/match-reports/2025-26/Ajax%20(h)/Chelsea_celebrate_during_victory_over_Ajax.jpg'),
(4, 'Paris Saint-Germain', 'PSG Collection', 'https://usastore.psg.fr/content/ws/all/a00b103a-6d93-4fee-b117-d09d71123dc0__1600X900.png');

-- --------------------------------------------------------

--
-- Table structure for table `trending_items`
--

CREATE TABLE `trending_items` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `player` varchar(120) NOT NULL,
  `team` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `slug` varchar(160) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trending_items`
--

INSERT INTO `trending_items` (`id`, `title`, `player`, `team`, `description`, `image_url`, `created_at`, `slug`) VALUES
(1, 'Cole Palmer Autograph Frame', 'Cole Palmer', 'Chelsea FC', 'A premium collectible crafted for true football enthusiasts. Celebrates the rising legacy of Cole Palmer blending youthful brilliance, modern prestige, and passion.', 'https://img.chelseafc.com/image/upload/f_auto,w_1440,c_fill,g_faces,q_90/editorial/news/2025/06/20/cole-palmer-celebration-24-25.jpg', '2025-10-22 16:34:00', 'cole-palmer-autograph'),
(2, 'Kaká Autograph Frame', 'Kaká', 'Real Madrid', 'An exquisite collectible crafted for discerning football enthusiasts. Reflects both history and prestige.', 'https://i.pinimg.com/736x/a8/c0/9b/a8c09b29d73fccf06d0e2c3e2e9c36c9.jpg', '2025-10-22 16:34:00', 'kaka-autograph-frame');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `username` varchar(60) NOT NULL,
  `email` varchar(160) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `password_hash`, `created_at`) VALUES
(1, 'teem', 'teem', 'teem12@gmail.com', '$2y$10$Uh6iHYbaQ/1RUv/cnSs5lO9LhDOaNn1P26JEsWsE.qp78fa4o.a1e', '2025-10-22 17:05:53'),
(2, 'proud', 'proud', 'proudproud@gmail.com', '$2y$10$7r6FFGloVh2Z3bgzhkFWUeOxLcA0pKKx6PJS3SP46Ab.X33W9Nli2', '2025-10-22 23:14:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `related_product_id` (`related_product_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `idx_orders_status_created` (`status`,`created_at`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order_items_order` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_products_category` (`category`),
  ADD KEY `idx_products_is_best` (`is_best_seller`),
  ADD KEY `idx_products_is_sale` (`is_sale`);

--
-- Indexes for table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trending_items`
--
ALTER TABLE `trending_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trending_items`
--
ALTER TABLE `trending_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`related_product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
