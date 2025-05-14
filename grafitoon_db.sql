-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 04:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `grafitoon_db`;
USE `grafitoon_db`;

-- --------------------------------------------------------

-- Table structure for table `activity_logs`
CREATE TABLE `activity_logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `activity` text DEFAULT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `cart`
CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`cart_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `cart_items`
CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`cart_item_id`),
  KEY `cart_id` (`cart_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `orders`
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) DEFAULT NULL,
  `STATUS` enum('pending','shipped','delivered','cancelled') DEFAULT 'pending',
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `order_items`
CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price_at_purchase` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `products`
CREATE TABLE `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `size_options` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `users`
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT 'images/placeholders/default_profile.png',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Insert sample data
INSERT INTO `products` (`product_id`, `NAME`, `description`, `price`, `size_options`, `category`, `image_path`, `stock_quantity`, `created_at`) VALUES
(6, 'Graffiti King Tee', 'A bold streetwear tee featuring classic graffiti art.', 29.99, 'S,M,L,XL', 'T-Shirts', 'images/products/graffiti_tee.jpg', 50, '2025-04-22 03:14:18'),
(7, 'Cartoon Vibes Hoodie', 'Cozy up in this warm hoodie with a splash of cartoon flavor.', 49.99, 'M,L,XL', 'Hoodies', 'images/products/cartoon_hoodie.jpg', 35, '2025-04-22 03:14:18'),
(8, 'Urban Sketch Joggers', 'Sleek joggers with urban sketch patterns for everyday wear.', 39.99, 'S,M,L', 'Pants', 'images/products/urban_joggers.jpg', 25, '2025-04-22 03:14:18'),
(9, 'Sprayground Backpack', 'Graffiti-inspired backpack with high storage and style.', 34.99, 'One Size', 'Accessories', 'images/products/sprayground_backpack.jpg', 15, '2025-04-22 03:14:18'),
(10, 'Graffiti Toon Cap', 'Cap featuring a mashup of graffiti and cartoon designs.', 19.99, 'One Size', 'Accessories', 'images/products/toon_cap.jpg', 40, '2025-04-22 03:14:18'),
(13, 'dJI Mavic Mini', 'A small but versatile Camera Drone fit for a professional that doesn\'t require a license to fly due to being less than the license required weight', 680.00, 'One Size', '0', '0', 58, '2025-05-03 03:29:58'),
(14, 'test3', 'test product', 650.00, '', '0', 'images/products/mavic_mini_68159c6619b57.png', 17, '2025-05-03 04:32:38');

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `created_at`, `profile_picture`) VALUES
(1, 'admin', 'admin@email.com', '$2y$10$q4c3Y165H9O/bQDzJMrcMO.DgSwKF8xs4vcgJBHD5umVUzOHat3/G', 'admin', '2025-04-20 05:02:34', 'images/placeholders/default_profile.png'),
(2, 'test2', 'test2@email.com', '$2y$10$JycY0vULRROhHlGVpJLHFemB7SsHOoOql3XPgFMWFj/U.Fqx8qWYO', 'customer', '2025-04-20 05:07:36', 'uploads/profile_pictures/profile_6808683b099494.31754865.png'),
(5, 'karena', 'karena@email.com', '$2y$10$SYzfEBL/A/sWG/df7Ou33ubmzU3NGn4kAEGxtMz5b3K2oqIqjv3Za', 'admin', '2025-05-01 19:26:26', 'images/placeholders/default_profile.png'),
(6, 'test3', 'test3@email.com', '$2y$10$aLkbwFtbD9lexB/oDoGEL.b8pt3P0NdwS9AHX2AWVJaNfssGOit0y', 'customer', '2025-05-01 19:27:46', 'images/placeholders/default_profile.png'),
(8, 'John Wick', 'jwick@email.com', '$2y$10$0MMts99HZqnTknq3dnjcgOxMHJxGO3qNUke7nXBc4ezhpM0BGc3Au', 'customer', '2025-05-03 02:19:22', 'images/placeholders/default_profile.png');

-- --------------------------------------------------------

-- Add foreign key constraints
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `fk_activity_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

ALTER TABLE `cart_items`
  ADD CONSTRAINT `fk_cart_items_cart` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

COMMIT;
