-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2019 at 06:45 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `laravel_aq`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 2),
(3, '2019_01_08_034329_create_tbl_books', 2),
(4, '2019_01_08_034403_create_tbl_categories', 2),
(5, '2019_01_08_034429_create_tbl_book_categories', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ref_books`
--

CREATE TABLE IF NOT EXISTS `tbl_ref_books` (
  `book_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_keyword` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_price` double(19,4) NOT NULL,
  `book_penerbit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_stock` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_ref_books`
--

INSERT INTO `tbl_ref_books` (`book_id`, `book_name`, `book_description`, `book_keyword`, `book_price`, `book_penerbit`, `book_stock`, `created_at`, `updated_at`) VALUES
(2, 'Test2', 'asdas', 'ASDASD', 1212.0000, 'Gramed', 1212, '2019-01-07 22:30:19', '2019-01-07 22:42:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ref_categories`
--

CREATE TABLE IF NOT EXISTS `tbl_ref_categories` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_ref_categories`
--

INSERT INTO `tbl_ref_categories` (`cat_id`, `cat_name`, `created_at`, `updated_at`) VALUES
(3, 'interaksi', '2019-01-07 22:00:20', '2019-01-07 22:00:20'),
(4, 'Umum', '2019-01-07 22:32:16', '2019-01-07 22:32:16'),
(5, 'Remaja', '2019-01-07 22:32:27', '2019-01-07 22:32:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trx_book_categories`
--

CREATE TABLE IF NOT EXISTS `tbl_trx_book_categories` (
  `bc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bc_cat_id` int(11) NOT NULL,
  `bc_book_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`bc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_trx_book_categories`
--

INSERT INTO `tbl_trx_book_categories` (`bc_id`, `bc_cat_id`, `bc_book_id`, `created_at`, `updated_at`) VALUES
(5, 4, 2, '2019-01-07 22:42:37', '2019-01-07 22:42:37'),
(6, 5, 2, '2019-01-07 22:42:37', '2019-01-07 22:42:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'test@gmail.com', '$2y$10$7MpHAcTk6FQ9tckDcghrm..Z9Am4s6SRnXVkarMFuSKgVfExe8g.6', NULL, '2019-01-07 20:53:20', '2019-01-07 20:53:20');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
