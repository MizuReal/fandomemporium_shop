-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2025 at 03:11 PM
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
-- Database: `fandomemporium`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'Philippines',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `full_name`, `phone`, `address_line1`, `address_line2`, `city`, `state`, `postal_code`, `country`, `is_default`, `created_at`, `updated_at`) VALUES
(2, 9, 'Kim Yebes', '09123456789', 'Test', 'test', '123', '123312', '1234', 'Philippines', 0, '2025-04-05 17:38:37', '2025-04-06 00:26:16'),
(3, 9, 'Kim Yebes', '09123456789', 'Test', 'test', '123', '123312', '1234', 'Philippines', 0, '2025-04-05 17:39:26', '2025-04-06 00:26:16'),
(4, 9, '1 2', '12345678901', '123 St.', '123', 'Taguig', 'state', '123', 'philippines', 0, '2025-04-05 21:58:28', '2025-04-06 00:26:16'),
(5, 9, '1 2', '12345678901', '123 St.', '123', 'Taguig', 'state', '123', 'philippines', 0, '2025-04-05 23:06:50', '2025-04-06 00:26:16'),
(6, 9, '1 2', '09876543211', '123 St.', '123', 'Taguig', 'state', '123', 'philippines', 0, '2025-04-05 23:10:33', '2025-04-06 00:26:16'),
(7, 9, '1 2', '12345678901', '123 St.', '123', 'Taguig', 'state', '123', 'philippines', 1, '2025-04-06 00:26:16', '2025-04-06 00:26:16'),
(8, 12, '1 2', '09876543211', '123 St.', '123', 'Taguig', 'state', '123', 'philippines', 0, '2025-04-06 03:33:12', '2025-04-06 03:51:07'),
(9, 12, '1 2', '12345678901', '123 St.', '123', 'Taguig', 'state', '123', 'philippines', 1, '2025-04-06 03:51:07', '2025-04-06 03:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=active, 1=inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`, `updated_at`, `created_by_id`) VALUES
(3, 'KeyChain', 1, '2025-04-04 17:48:26', '2025-04-04 17:48:37', 2),
(4, 'Tshirts', 1, '2025-04-04 17:53:32', '2025-04-04 17:53:32', 2),
(5, 'Hoodies', 1, '2025-04-04 17:53:55', '2025-04-04 17:53:58', 2),
(6, 'Vinyl', 1, '2025-04-04 17:54:25', '2025-04-05 18:19:08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_04_03_025707_add_is_admin_to_users_table', 2),
(6, '2025_04_04_231955_add_status_to_users_table', 3),
(7, '2025_04_04_235440_add_is_delete_to_users_table', 4),
(8, '2025_04_05_011110_create_categories_table', 5),
(9, '2025_04_05_013846_add_created_by_id_to_category_table', 6),
(10, '2025_04_05_020019_create_products_and_related_table', 7),
(11, '2025_04_05_022808_add_deleted_at_to_products_table', 8),
(12, '2025_04_05_045443_update_products_table_with_specific_image_fields', 9),
(13, '2025_04_05_090341_add_profile_picture_to_users_table', 10),
(14, '2025_04_06_011905_create_addresses_table', 11),
(15, '2025_04_06_012002_create_orders_table', 12),
(16, '2025_04_06_012100_create_order_items_table', 13),
(17, '2025_04_06_012147_create_order_status_history_table', 14),
(18, '2025_04_06_022856_update_order_status_enum_in_orders_table', 15),
(19, '2025_04_06_035117_update_orders_table_status_enum', 16),
(20, '2025_04_06_061306_create_product_review_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `address_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('processing','shipped','in_transit','delivered','cancelled') NOT NULL DEFAULT 'processing',
  `payment_method` varchar(255) NOT NULL DEFAULT 'Cash on Delivery',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `address_id`, `total_amount`, `status`, `payment_method`, `notes`, `created_at`, `updated_at`) VALUES
(2, 9, 'FE-2025-CWUHNJ', 2, 27.00, 'delivered', 'Cash on Delivery', '1', '2025-04-05 17:38:37', '2025-04-05 23:08:10'),
(3, 9, 'FE-2025-QNYZAL', 3, 2000.00, 'delivered', 'Cash on Delivery', 'A', '2025-04-05 17:39:26', '2025-04-05 19:57:52'),
(4, 9, 'FE-2025-BXBG3S', 4, 2000.00, 'processing', 'Cash on Delivery', 'note', '2025-04-05 21:58:28', '2025-04-05 21:58:28'),
(5, 9, 'FE-2025-FJRHRZ', 5, 10002.00, 'processing', 'Cash on Delivery', ':^)', '2025-04-05 23:06:50', '2025-04-05 23:06:50'),
(6, 9, 'FE-2025-D4GQ3X', 6, 25.00, 'delivered', 'Cash on Delivery', 'aaa', '2025-04-05 23:10:33', '2025-04-05 23:11:00'),
(7, 9, 'FE-2025-NU7RRW', 7, 250.00, 'delivered', 'Cash on Delivery', 'aaaaaaaaaaa', '2025-04-06 00:26:16', '2025-04-06 00:26:49'),
(8, 12, 'FE-2025-8R1IPY', 8, 250.00, 'delivered', 'Cash on Delivery', 'note', '2025-04-06 03:33:12', '2025-04-06 03:33:38'),
(9, 12, 'FE-2025-GGWMLS', 9, 2000.00, 'delivered', 'Cash on Delivery', 'a', '2025-04-06 03:51:07', '2025-04-06 03:51:19');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `size`, `color`, `created_at`, `updated_at`) VALUES
(3, 2, 5, 1, 25.00, 'M', 'Blue', '2025-04-05 17:38:37', '2025-04-05 17:38:37'),
(4, 2, 6, 1, 2.00, NULL, 'Black', '2025-04-05 17:38:37', '2025-04-05 17:38:37'),
(5, 3, 4, 1, 2000.00, 'S', 'Blue', '2025-04-05 17:39:26', '2025-04-05 17:39:26'),
(6, 4, 4, 1, 2000.00, 'S', 'Blue', '2025-04-05 21:58:28', '2025-04-05 21:58:28'),
(7, 5, 1, 1, 10000.00, 'M', 'Red', '2025-04-05 23:06:50', '2025-04-05 23:06:50'),
(8, 5, 6, 1, 2.00, NULL, 'Black', '2025-04-05 23:06:50', '2025-04-05 23:06:50'),
(9, 6, 5, 1, 25.00, 'M', 'Blue', '2025-04-05 23:10:33', '2025-04-05 23:10:33'),
(10, 7, 7, 1, 250.00, NULL, 'Black, Red, Yellow', '2025-04-06 00:26:16', '2025-04-06 00:26:16'),
(11, 8, 7, 1, 250.00, NULL, 'Black, Red, Yellow', '2025-04-06 03:33:12', '2025-04-06 03:33:12'),
(12, 9, 4, 1, 2000.00, 'S', 'Blue', '2025-04-06 03:51:07', '2025-04-06 03:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `order_status_history`
--

CREATE TABLE `order_status_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_by_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_status_history`
--

INSERT INTO `order_status_history` (`id`, `order_id`, `status`, `comment`, `created_by_id`, `created_at`) VALUES
(1, 2, 'processing', 'Order placed successfully', 9, NULL),
(2, 3, 'processing', 'Order placed successfully', 9, NULL),
(3, 3, 'delivered', 'Order status changed from processing to delivered', 1, NULL),
(4, 2, 'shipped', 'Order status changed from processing to shipped', 1, NULL),
(5, 3, 'cancelled', 'Order status changed from delivered to cancelled', 1, NULL),
(6, 3, 'delivered', 'Order status changed from cancelled to delivered', 1, NULL),
(7, 4, 'processing', 'Order placed successfully', 9, '2025-04-05 21:58:28'),
(8, 5, 'processing', 'Order placed successfully', 9, '2025-04-05 23:06:50'),
(9, 2, 'delivered', 'Order status changed from shipped to delivered', 1, '2025-04-05 23:08:10'),
(10, 6, 'processing', 'Order placed successfully', 9, '2025-04-05 23:10:33'),
(11, 6, 'delivered', 'Order status changed from processing to delivered', 1, '2025-04-05 23:11:00'),
(12, 7, 'processing', 'Order placed successfully', 9, '2025-04-06 00:26:16'),
(13, 7, 'delivered', 'Order status changed from processing to delivered', 1, '2025-04-06 00:26:49'),
(14, 8, 'processing', 'Order placed successfully', 12, '2025-04-06 03:33:12'),
(15, 8, 'delivered', 'Order status changed from processing to delivered', 1, '2025-04-06 03:33:38'),
(16, 9, 'processing', 'Order placed successfully', 12, '2025-04-06 03:51:07'),
(17, 9, 'delivered', 'Order status changed from processing to delivered', 1, '2025-04-06 03:51:19');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `new_price` decimal(10,2) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `additional_information` longtext DEFAULT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `image4` varchar(255) DEFAULT NULL,
  `status` enum('in_stock','out_of_stock') NOT NULL DEFAULT 'in_stock',
  `created_by_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `size`, `color`, `old_price`, `new_price`, `brand`, `short_description`, `description`, `additional_information`, `main_image`, `image1`, `image2`, `image3`, `image4`, `status`, `created_by_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Suisei Hoddie Cute', 5, 'M', 'Red', 5000.00, 10000.00, 'Hololive', 'Cute hoodie', 'Cute hoodie by hololive corporation', NULL, 'uploads/products/1743829041_2604.jpg', 'uploads/products/1743829108_8257.jpg', 'uploads/products/1743829099_6306.png', 'uploads/products/1743829099_5006.jpg', 'uploads/products/1743829099_6833.jpg', 'in_stock', 1, '2025-04-04 18:15:28', '2025-04-04 21:27:04', NULL),
(4, 'Suisei Keychain', 3, 'S', 'Blue', 5000.00, 2000.00, 'Hololive', 'Cute Keychain', 'Cute Keychain', NULL, 'uploads/products/1743829603_9656.jpg', NULL, NULL, NULL, NULL, 'in_stock', 1, '2025-04-04 20:07:54', '2025-04-04 21:09:46', NULL),
(5, 'Suisei Tshirt', 4, 'M', 'Blue', NULL, 25.00, 'Hololive', 'a', 'a', NULL, 'uploads/products/1743829714_7966.jpg', NULL, NULL, NULL, NULL, 'in_stock', 1, '2025-04-04 20:09:03', '2025-04-04 21:08:34', NULL),
(6, 'Vinyl', 6, NULL, 'Black', NULL, 2.00, 'Hololive', 'a', 'a', NULL, 'uploads/products/1743829690_2392.jpg', NULL, NULL, NULL, NULL, 'in_stock', 1, '2025-04-04 20:09:36', '2025-04-04 21:08:10', NULL),
(7, 'Persona 3 Vinyl', 6, NULL, 'Black, Red, Yellow', 300.00, 250.00, 'Persona', 'Persona 3 Vinyl', 'Persona 3 Vinyl', '3 Vinyls', 'uploads/products/1743924503_9137.jpg', 'uploads/products/1743924503_5797.jpg', 'uploads/products/1743924503_1134.jpg', NULL, NULL, 'in_stock', 1, '2025-04-05 23:28:23', '2025-04-05 23:28:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_review`
--

CREATE TABLE `product_review` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 0,
  `review` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_review`
--

INSERT INTO `product_review` (`id`, `product_id`, `order_id`, `user_id`, `rating`, `review`, `created_at`, `updated_at`) VALUES
(1, 4, 3, 9, 4, 'Test Review', '2025-04-05 23:05:23', '2025-04-06 02:07:22'),
(2, 5, 2, 9, 4, 'Test Review 2', '2025-04-05 23:08:29', '2025-04-06 01:50:04'),
(3, 6, 2, 9, 3, 'Test Review 3', '2025-04-05 23:08:41', '2025-04-06 01:49:56'),
(4, 5, 6, 9, 2, 'aaaa', '2025-04-06 00:27:39', '2025-04-06 01:49:48'),
(5, 7, 7, 9, 1, 'aaaaaa', '2025-04-06 00:27:52', '2025-04-06 01:43:27'),
(6, 7, 8, 12, 5, ':^D', '2025-04-06 03:49:07', '2025-04-06 03:49:54'),
(7, 4, 9, 12, 5, 'a', '2025-04-06 04:01:16', '2025-04-06 04:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `related_products`
--

CREATE TABLE `related_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `related_product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `related_products`
--

INSERT INTO `related_products` (`id`, `product_id`, `related_product_id`, `created_at`, `updated_at`) VALUES
(2, 7, 6, '2025-04-05 23:28:23', '2025-04-05 23:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = customer, 1 = admin',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: active, 1: inactive',
  `is_delete` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:not, 1:deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `profile_picture`, `password`, `remember_token`, `created_at`, `updated_at`, `is_admin`, `status`, `is_delete`) VALUES
(1, 'Christian Earl Tapit', 'christianearltapit@gmail.com', '2025-04-11 03:04:35', NULL, '$2y$12$biyvnMmTSvAzJIjTP1GwK.6fNVNO6qXtUCAjVB.oADJ7fMQHZh1ju', 'D3fhTGzBoJ8EzS08yCJBoCuBHORheal5tTXHzvoxWwXiiL54oK1hZddYcQtM', '2025-04-03 03:05:33', '2025-04-04 03:05:41', 1, 0, 0),
(2, 'test', 'testaccount@gmail.com', NULL, NULL, '$2y$12$DAGGjLoOxbeeaq5IR7jbzuUJsR6/sZBIqr8b89htL9muw..cSJ4QO', NULL, '2025-04-04 15:41:11', '2025-04-04 16:08:19', 1, 0, 0),
(3, 'test', 'testaccount1@gmail.com', NULL, NULL, '$2y$12$AHnR7UNbN8baBzA29dUl3OBfNNT2CXjeP5zPdPJixTFh9zv2VthVS', NULL, '2025-04-04 15:44:08', '2025-04-04 16:12:45', 1, 0, 0),
(4, 'Test Name', 'mizuthestar@gmail.com', NULL, NULL, '$2y$12$3/YptA2eQP8rlu49Gyvf0OU3m5.S6hptyJYRMUiUkzNUQ3WoDekwe', NULL, '2025-04-05 00:39:55', '2025-04-05 00:39:55', 0, 0, 0),
(5, 'Test Name', 'stockport@gmail.com', NULL, NULL, '$2y$12$ywBTPF5yWBP5iIc9ntFkdu26d/EFdtYFdybKDDbaAynZ6SxPhlA96', NULL, '2025-04-05 00:52:15', '2025-04-05 00:52:15', 0, 0, 0),
(6, 'Test Name', 'stockportwarehouse@gmail.com', '2025-04-05 00:55:29', NULL, '$2y$12$se928qL.QwTKEXMZVPezmO1GeTygwM46kzODtl3YKAdyiUnkTnBLG', NULL, '2025-04-05 00:53:15', '2025-04-05 00:55:29', 0, 0, 0),
(7, 'Test Not Verified', 'randomemailfortesting@gmail.com', NULL, NULL, '$2y$12$QKnBraH5IlNg/765/WMKF.5v5nd7ZjuWNe.5XrCmrUWVyhtcXwe.i', NULL, '2025-04-05 00:58:47', '2025-04-05 00:58:47', 0, 0, 0),
(8, 'Another Test Account', 'testaccountanother@gmail.com', NULL, NULL, '$2y$12$gtCRoPtQ7sX5H0ZbtHTW8OkxsvYqlGB0PXK7MfFKCWmvkdGwrOco2', NULL, '2025-04-05 01:01:05', '2025-04-05 01:01:05', 0, 0, 0),
(9, 'mofu', 'mofuuaoi@gmail.com', '2025-04-05 17:16:25', 'uploads/profile_pictures/profile_1743913501_9.jpg', '$2y$12$.E12QYHKq/8GksoKy1uDpuA5MvsfqAmVWTUtURngAhfREwHJKMMfO', NULL, '2025-04-05 17:15:58', '2025-04-05 20:25:01', 0, 0, 0),
(12, 'Tako', 'earlchristian448@gmail.com', '2025-04-06 03:31:49', 'uploads/profile_pictures/1743939026_ina and takodachi.jpg', '$2y$12$2XfanCsaOLvpLAbjTlpG6uhRBpBSeFrK2rvMEfrz9hMGWSOek2E0S', NULL, '2025-04-06 03:30:26', '2025-04-06 03:31:49', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_created_by_id_foreign` (`created_by_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_address_id_foreign` (`address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_status_history_order_id_foreign` (`order_id`),
  ADD KEY `order_status_history_created_by_id_foreign` (`created_by_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_created_by_id_foreign` (`created_by_id`);

--
-- Indexes for table `product_review`
--
ALTER TABLE `product_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_review_product_id_foreign` (`product_id`),
  ADD KEY `product_review_order_id_foreign` (`order_id`),
  ADD KEY `product_review_user_id_foreign` (`user_id`);

--
-- Indexes for table `related_products`
--
ALTER TABLE `related_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `related_products_product_id_related_product_id_unique` (`product_id`,`related_product_id`),
  ADD KEY `related_products_related_product_id_foreign` (`related_product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_review`
--
ALTER TABLE `product_review`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `related_products`
--
ALTER TABLE `related_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_created_by_id_foreign` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD CONSTRAINT `order_status_history_created_by_id_foreign` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `order_status_history_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_created_by_id_foreign` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_review`
--
ALTER TABLE `product_review`
  ADD CONSTRAINT `product_review_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_review_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_review_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `related_products`
--
ALTER TABLE `related_products`
  ADD CONSTRAINT `related_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `related_products_related_product_id_foreign` FOREIGN KEY (`related_product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
