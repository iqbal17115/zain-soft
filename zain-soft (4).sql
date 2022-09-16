-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2022 at 01:11 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zain-soft`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_managers`
--

CREATE TABLE `account_managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('Debit','Credit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `dr_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cr_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receipt_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` double(20,4) DEFAULT 0.0000,
  `date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `note` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `payment_status` enum('Hold','Active','Inactive') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_managers`
--

INSERT INTO `account_managers` (`id`, `code`, `type`, `dr_account_id`, `cr_account_id`, `transaction_id`, `invoice_id`, `receipt_id`, `item_id`, `contact_id`, `amount`, `date`, `due_date`, `note`, `user_id`, `branch_id`, `company_id`, `status`, `payment_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Credit', 7, 6, NULL, NULL, NULL, NULL, 2, 34.0000, '2022-01-22', NULL, NULL, 1, NULL, NULL, 1, NULL, '2022-01-21 22:50:55', '2022-01-21 22:50:55', NULL),
(2, 'P001', 'Debit', 2, NULL, NULL, 4, NULL, NULL, 2, 12000.0000, '2022-01-22', NULL, 'Purchase', 1, NULL, NULL, 1, NULL, '2022-01-21 23:12:44', '2022-01-21 23:12:44', NULL),
(3, 'P001', 'Debit', 10, NULL, NULL, 4, NULL, NULL, 2, 1440.0000, '2022-01-22', NULL, 'INPUT VAT', 1, NULL, NULL, 1, NULL, '2022-01-21 23:12:44', '2022-01-21 23:12:44', NULL),
(4, 'P001', 'Credit', NULL, 6, NULL, 4, NULL, NULL, 2, 13440.0000, '2022-01-22', NULL, 'Payable', 1, NULL, NULL, 1, NULL, '2022-01-21 23:12:44', '2022-01-21 23:12:44', NULL),
(5, 'S005', 'Credit', NULL, 1, NULL, 5, NULL, NULL, 1, 150.0000, '2022-01-22', NULL, 'Sale', 1, NULL, NULL, 1, NULL, '2022-01-21 23:18:33', '2022-01-21 23:18:33', NULL),
(6, 'S005', 'Credit', NULL, 11, NULL, 5, NULL, NULL, 1, 18.0000, '2022-01-22', NULL, 'Output VAT', 1, NULL, NULL, 1, NULL, '2022-01-21 23:18:33', '2022-01-21 23:18:33', NULL),
(7, 'S005', 'Debit', 5, NULL, NULL, 5, NULL, NULL, 1, 168.0000, '2022-01-22', NULL, 'Payable', 1, NULL, NULL, 1, NULL, '2022-01-21 23:18:33', '2022-01-21 23:18:33', NULL),
(8, 'S006', 'Credit', NULL, 1, NULL, 6, NULL, NULL, 1, 150.0000, '2022-01-22', NULL, 'Sale', 1, NULL, NULL, 1, NULL, '2022-01-21 23:19:12', '2022-01-21 23:19:12', NULL),
(9, 'S006', 'Credit', NULL, 11, NULL, 6, NULL, NULL, 1, 18.0000, '2022-01-22', NULL, 'Output VAT', 1, NULL, NULL, 1, NULL, '2022-01-21 23:19:12', '2022-01-21 23:19:12', NULL),
(10, 'S006', 'Debit', 5, NULL, NULL, 6, NULL, NULL, 1, 168.0000, '2022-01-22', NULL, 'Payable', 1, NULL, NULL, 1, NULL, '2022-01-21 23:19:12', '2022-01-21 23:19:12', NULL),
(11, 'S007', 'Credit', NULL, 1, NULL, 7, NULL, NULL, 1, 150.0000, '2022-01-22', NULL, 'Sale', 1, NULL, NULL, 1, NULL, '2022-01-22 00:48:43', '2022-01-22 00:48:43', NULL),
(12, 'S007', 'Credit', NULL, 11, NULL, 7, NULL, NULL, 1, 18.0000, '2022-01-22', NULL, 'Output VAT', 1, NULL, NULL, 1, NULL, '2022-01-22 00:48:43', '2022-01-22 00:48:43', NULL),
(13, 'S007', 'Debit', 5, NULL, NULL, 7, NULL, NULL, 1, 168.0000, '2022-01-22', NULL, 'Payable', 1, NULL, NULL, 1, NULL, '2022-01-22 00:48:43', '2022-01-22 00:48:43', NULL),
(14, 'S008', 'Credit', NULL, 1, NULL, 8, NULL, NULL, 1, 150.0000, '2022-01-22', NULL, 'Sale', 1, NULL, NULL, 1, NULL, '2022-01-22 00:48:59', '2022-01-22 00:48:59', NULL),
(15, 'S008', 'Credit', NULL, 11, NULL, 8, NULL, NULL, 1, 18.0000, '2022-01-22', NULL, 'Output VAT', 1, NULL, NULL, 1, NULL, '2022-01-22 00:48:59', '2022-01-22 00:48:59', NULL),
(16, 'S008', 'Debit', 5, NULL, NULL, 8, NULL, NULL, 1, 168.0000, '2022-01-22', NULL, 'Payable', 1, NULL, NULL, 1, NULL, '2022-01-22 00:48:59', '2022-01-22 00:48:59', NULL),
(17, 'S009', 'Credit', NULL, 1, NULL, 9, NULL, NULL, 1, 150.0000, '2022-01-22', NULL, 'Sale', 1, NULL, NULL, 1, NULL, '2022-01-22 00:49:13', '2022-01-22 00:49:13', NULL),
(18, 'S009', 'Credit', NULL, 11, NULL, 9, NULL, NULL, 1, 18.0000, '2022-01-22', NULL, 'Output VAT', 1, NULL, NULL, 1, NULL, '2022-01-22 00:49:13', '2022-01-22 00:49:13', NULL),
(19, 'S009', 'Debit', 5, NULL, NULL, 9, NULL, NULL, 1, 168.0000, '2022-01-22', NULL, 'Payable', 1, NULL, NULL, 1, NULL, '2022-01-22 00:49:13', '2022-01-22 00:49:13', NULL),
(20, 'S010', 'Credit', NULL, 1, NULL, 10, NULL, NULL, 1, 150.0000, '2022-01-22', NULL, 'Sale', 1, NULL, NULL, 1, NULL, '2022-01-22 00:49:26', '2022-01-22 00:49:26', NULL),
(21, 'S010', 'Credit', NULL, 11, NULL, 10, NULL, NULL, 1, 18.0000, '2022-01-22', NULL, 'Output VAT', 1, NULL, NULL, 1, NULL, '2022-01-22 00:49:26', '2022-01-22 00:49:26', NULL),
(22, 'S010', 'Debit', 5, NULL, NULL, 10, NULL, NULL, 1, 168.0000, '2022-01-22', NULL, 'Payable', 1, NULL, NULL, 1, NULL, '2022-01-22 00:49:26', '2022-01-22 00:49:26', NULL),
(23, 'S011', 'Credit', NULL, 1, NULL, 11, NULL, NULL, 1, 150.0000, '2022-01-22', NULL, 'Sale', 1, NULL, NULL, 1, NULL, '2022-01-22 00:49:41', '2022-01-22 00:49:41', NULL),
(24, 'S011', 'Credit', NULL, 11, NULL, 11, NULL, NULL, 1, 18.0000, '2022-01-22', NULL, 'Output VAT', 1, NULL, NULL, 1, NULL, '2022-01-22 00:49:41', '2022-01-22 00:49:41', NULL),
(25, 'S011', 'Debit', 5, NULL, NULL, 11, NULL, NULL, 1, 168.0000, '2022-01-22', NULL, 'Payable', 1, NULL, NULL, 1, NULL, '2022-01-22 00:49:41', '2022-01-22 00:49:41', NULL),
(33, 'CP642918576', 'Debit', 16, 5, 35, NULL, NULL, NULL, 1, 134.0000, '2022-01-23', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-23 00:16:24', '2022-01-23 00:16:24', NULL),
(35, 'CP643516500', 'Debit', 9, 5, 37, NULL, NULL, NULL, 1, 0.0000, '2022-01-30', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 22:42:23', '2022-01-29 22:42:23', NULL),
(40, 'CP643519905', 'Debit', 9, 5, 42, NULL, NULL, NULL, 1, 0.0000, '2022-01-30', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:19:16', '2022-01-29 23:19:16', NULL),
(41, 'CP643519957', 'Debit', 16, 5, 43, NULL, NULL, NULL, 1, 0.0000, '2022-01-30', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:20:54', '2022-01-29 23:20:54', NULL),
(42, 'CP643520055', 'Debit', 16, 5, 44, NULL, NULL, NULL, 1, 1168.0000, '2022-01-12', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:21:34', '2022-01-29 23:21:34', NULL),
(43, 'CP643520095', 'Debit', 9, 5, 45, NULL, NULL, NULL, 1, 0.0000, '2022-01-30', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:22:50', '2022-01-29 23:22:50', NULL),
(44, 'CP643520171', 'Debit', 16, 5, 46, NULL, NULL, NULL, 1, 550.0000, '2022-01-30', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:24:23', '2022-01-29 23:24:23', NULL),
(45, 'CP643520264', 'Debit', 9, 5, 47, NULL, NULL, NULL, 1, 13440.0000, '2022-01-30', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:24:51', '2022-01-29 23:24:51', NULL),
(46, 'CP643520292', 'Debit', 9, 5, 48, NULL, NULL, NULL, 1, 500.0000, '2022-01-30', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:25:31', '2022-01-29 23:25:31', NULL),
(47, 'CP643520332', 'Debit', 9, 5, 49, NULL, NULL, NULL, 1, 0.0000, '2022-01-12', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:26:06', '2022-01-29 23:26:06', NULL),
(48, 'CP643520367', 'Debit', 16, 5, 50, NULL, NULL, NULL, 1, 0.0000, '2022-01-30', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:26:36', '2022-01-29 23:26:36', NULL),
(49, 'CP643520397', 'Debit', 16, 5, 51, NULL, NULL, NULL, 1, 0.0000, '2022-01-30', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:28:40', '2022-01-29 23:28:40', NULL),
(50, 'CP643520521', 'Debit', 9, 5, 52, NULL, NULL, NULL, 1, 0.0000, '2022-01-30', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:35:43', '2022-01-29 23:35:43', NULL),
(51, 'CP643520944', 'Debit', 16, 5, 53, NULL, NULL, NULL, 1, 0.0000, '2022-01-30', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:36:19', '2022-01-29 23:36:19', NULL),
(52, 'CP643520980', 'Debit', 9, 5, 54, NULL, NULL, NULL, 1, 0.0000, '2022-01-14', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:40:29', '2022-01-29 23:40:29', NULL),
(53, 'CP643521230', 'Debit', 9, 5, 55, NULL, NULL, NULL, 1, 0.0000, '2022-01-30', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:41:25', '2022-01-29 23:41:25', NULL),
(54, 'CP643521320', 'Debit', 9, 5, 56, NULL, NULL, NULL, 1, 0.0000, '2022-01-30', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:42:14', '2022-01-29 23:42:14', NULL),
(55, 'CP643521377', 'Debit', 16, 5, 57, NULL, NULL, NULL, 1, 0.0000, '2022-01-30', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:43:23', '2022-01-29 23:43:23', NULL),
(56, 'CP643521440', 'Debit', 9, 5, 58, NULL, NULL, NULL, 1, 0.0000, '2022-01-30', NULL, NULL, 1, 1, 1, 1, 'Active', '2022-01-29 23:44:13', '2022-01-29 23:44:13', NULL),
(57, 'I002', 'Debit', 2, 7, NULL, NULL, NULL, 2, NULL, 1250000.0000, '2022-02-13', NULL, NULL, 1, 1, 2, 1, NULL, '2022-02-13 04:29:31', '2022-02-13 04:29:31', NULL),
(58, 'TR644838187', 'Credit', NULL, 9, NULL, 13, NULL, NULL, 8, 10000.0000, '2022-02-14', NULL, 'R644838187', 1, 1, 2, 1, 'Active', '2022-02-14 05:30:23', '2022-02-14 05:30:23', NULL),
(59, 'P013', 'Debit', 2, NULL, NULL, 13, NULL, NULL, 8, 37500.0000, '2022-02-14', NULL, 'Purchase', 1, 1, 2, 1, NULL, '2022-02-14 05:30:23', '2022-02-14 05:30:23', NULL),
(60, 'P013', 'Credit', NULL, 13, NULL, 13, NULL, NULL, 8, 10.0000, '2022-02-14', NULL, 'Discount', 1, 1, 2, 1, NULL, '2022-02-14 05:30:23', '2022-02-14 05:30:23', NULL),
(61, 'P013', 'Debit', 15, NULL, NULL, 13, NULL, NULL, 8, 20.0000, '2022-02-14', NULL, 'Shipping Charge', 1, 1, 2, 1, NULL, '2022-02-14 05:30:23', '2022-02-14 05:30:23', NULL),
(62, 'P013', 'Debit', 10, NULL, NULL, 13, NULL, NULL, 8, 3750.0000, '2022-02-14', NULL, 'INPUT VAT', 1, 1, 2, 1, NULL, '2022-02-14 05:30:23', '2022-02-14 05:30:23', NULL),
(63, 'P013', 'Credit', NULL, 6, NULL, 13, NULL, NULL, 8, 31260.0000, '2022-02-14', NULL, 'Payable', 1, 1, 2, 1, NULL, '2022-02-14 05:30:23', '2022-02-14 05:30:23', NULL),
(64, 'TR644838656', 'Credit', 16, NULL, NULL, 14, NULL, NULL, 7, 10000.0000, '2022-02-14', NULL, 'R644838656', 1, 1, 2, 1, 'Active', '2022-02-14 05:38:55', '2022-02-14 05:38:55', NULL),
(65, 'S014', 'Credit', NULL, 1, NULL, 14, NULL, NULL, 7, 46000.0000, '2022-02-14', NULL, 'Sale', 1, 1, 2, 1, NULL, '2022-02-14 05:38:55', '2022-02-14 05:38:55', NULL),
(66, 'S014', 'Debit', 12, NULL, NULL, 14, NULL, NULL, 7, 10.0000, '2022-02-14', NULL, 'Discount', 1, 1, 2, 1, NULL, '2022-02-14 05:38:55', '2022-02-14 05:38:55', NULL),
(67, 'S014', 'Credit', NULL, 14, NULL, 14, NULL, NULL, 7, 10.0000, '2022-02-14', NULL, 'Shipping Charge', 1, 1, 2, 1, NULL, '2022-02-14 05:38:55', '2022-02-14 05:38:55', NULL),
(68, 'S014', 'Credit', NULL, 11, NULL, 14, NULL, NULL, 7, 4600.0000, '2022-02-14', NULL, 'Output VAT', 1, 1, 2, 1, NULL, '2022-02-14 05:38:55', '2022-02-14 05:38:55', NULL),
(69, 'S014', 'Debit', 5, NULL, NULL, 14, NULL, NULL, 7, 40600.0000, '2022-02-14', NULL, 'Payable', 1, 1, 2, 1, NULL, '2022-02-14 05:38:55', '2022-02-14 05:38:55', NULL),
(70, 'TR644841081', 'Credit', NULL, 9, NULL, 15, NULL, NULL, 7, 10000.0000, '2022-02-14', NULL, 'R644841081', 1, 1, 2, 1, 'Active', '2022-02-14 06:19:01', '2022-02-14 06:19:01', NULL),
(71, 'I015', 'Debit', 4, NULL, NULL, 15, NULL, NULL, 7, 11500.0000, '2022-02-14', NULL, 'Sale Return', 1, 1, 2, 1, NULL, '2022-02-14 06:19:01', '2022-02-14 06:19:01', NULL),
(72, 'I015', 'Debit', 11, NULL, NULL, 15, NULL, NULL, 7, 1150.0000, '2022-02-14', NULL, 'Output VAT Return', 1, 1, 2, 1, NULL, '2022-02-14 06:19:01', '2022-02-14 06:19:01', NULL),
(73, 'I015', 'Credit', NULL, 5, NULL, 15, NULL, NULL, 7, 2650.0000, '2022-02-14', NULL, 'ReceivaleReturnDue', 1, 1, 2, 1, NULL, '2022-02-14 06:19:01', '2022-02-14 06:19:01', NULL),
(74, 'P016', 'Debit', 2, NULL, NULL, 16, NULL, NULL, 8, 62500.0000, '2022-02-15', NULL, 'Purchase', 1, 1, 2, 1, NULL, '2022-02-15 01:56:52', '2022-02-15 01:56:52', NULL),
(75, 'P016', 'Debit', 10, NULL, NULL, 16, NULL, NULL, 8, 6250.0000, '2022-02-15', NULL, 'INPUT VAT', 1, 1, 2, 1, NULL, '2022-02-15 01:56:52', '2022-02-15 01:56:52', NULL),
(76, 'P016', 'Credit', NULL, 6, NULL, 16, NULL, NULL, 8, 68750.0000, '2022-02-15', NULL, 'Payable', 1, 1, 2, 1, NULL, '2022-02-15 01:56:52', '2022-02-15 01:56:52', NULL),
(77, 'S017', 'Credit', NULL, 1, NULL, 17, NULL, NULL, 7, 34400.0000, '2022-02-15', NULL, 'Sale', 1, 1, 2, 1, NULL, '2022-02-15 01:58:22', '2022-02-15 01:58:22', NULL),
(78, 'S017', 'Credit', NULL, 14, NULL, 17, NULL, NULL, 7, 200.0000, '2022-02-15', NULL, 'Shipping Charge', 1, 1, 2, 1, NULL, '2022-02-15 01:58:22', '2022-02-15 01:58:22', NULL),
(79, 'S017', 'Credit', NULL, 11, NULL, 17, NULL, NULL, 7, 3440.0000, '2022-02-15', NULL, 'Output VAT', 1, 1, 2, 1, NULL, '2022-02-15 01:58:22', '2022-02-15 01:58:22', NULL),
(80, 'S017', 'Debit', 5, NULL, NULL, 17, NULL, NULL, 7, 38040.0000, '2022-02-15', NULL, 'Payable', 1, 1, 2, 1, NULL, '2022-02-15 01:58:22', '2022-02-15 01:58:22', NULL),
(81, 'TR645592309', 'Debit', 9, NULL, NULL, 18, NULL, NULL, 8, 4000.0000, '2022-02-23', NULL, 'R645592309', 1, 1, 1, 1, 'Active', '2022-02-22 22:59:36', '2022-02-22 22:59:36', NULL),
(82, 'I018', 'Credit', NULL, 3, NULL, 18, NULL, NULL, 8, 12500.0000, '2022-02-23', NULL, 'Purchase Return', 1, 1, 1, 1, NULL, '2022-02-22 22:59:36', '2022-02-22 22:59:36', NULL),
(83, 'I018', 'Credit', NULL, 10, NULL, 18, NULL, NULL, 8, 1250.0000, '2022-02-23', NULL, 'Output VAT Return', 1, 1, 1, 1, NULL, '2022-02-22 22:59:36', '2022-02-22 22:59:36', NULL),
(84, 'I018', 'Debit', 6, NULL, NULL, 18, NULL, NULL, 8, 9750.0000, '2022-02-23', NULL, 'ReceivaleReturnDue', 1, 1, 1, 1, NULL, '2022-02-22 22:59:36', '2022-02-22 22:59:36', NULL),
(85, 'Txn125', 'Debit', 1, NULL, NULL, NULL, 1, NULL, 5, 5000.0000, '2022-02-23', NULL, NULL, 1, 1, 3, 1, NULL, '2022-02-22 23:53:21', '2022-02-22 23:53:21', NULL),
(86, 'Txn125', 'Credit', NULL, 1, NULL, NULL, 1, NULL, 5, 5000.0000, '2022-02-23', NULL, NULL, 1, 1, 3, 1, NULL, '2022-02-22 23:53:21', '2022-02-22 23:53:21', NULL),
(87, 'CP645598022', 'Debit', 9, 5, 1, NULL, NULL, NULL, 7, 0.0000, '2022-02-23', NULL, NULL, 1, 1, 3, 1, 'Active', '2022-02-23 00:33:57', '2022-02-23 00:33:57', NULL),
(88, 'S021', 'Credit', NULL, 1, NULL, 21, NULL, NULL, 3, 11500.0000, '2022-02-24', NULL, 'Sale', 1, 1, 3, 1, NULL, '2022-02-24 04:37:15', '2022-02-24 04:37:15', NULL),
(89, 'S021', 'Credit', NULL, 11, NULL, 21, NULL, NULL, 3, 1150.0000, '2022-02-24', NULL, 'Output VAT', 1, 1, 3, 1, NULL, '2022-02-24 04:37:15', '2022-02-24 04:37:15', NULL),
(90, 'S021', 'Debit', 5, NULL, NULL, 21, NULL, NULL, 3, 12650.0000, '2022-02-24', NULL, 'Payable', 1, 1, 3, 1, NULL, '2022-02-24 04:37:15', '2022-02-24 04:37:15', NULL),
(91, 'S022', 'Credit', NULL, 1, NULL, 22, NULL, NULL, 3, 57500.0000, '2022-02-24', NULL, 'Sale', 1, 1, 3, 1, NULL, '2022-02-24 04:49:51', '2022-02-24 04:49:51', NULL),
(92, 'S022', 'Credit', NULL, 11, NULL, 22, NULL, NULL, 3, 5750.0000, '2022-02-24', NULL, 'Output VAT', 1, 1, 3, 1, NULL, '2022-02-24 04:49:51', '2022-02-24 04:49:51', NULL),
(93, 'S022', 'Debit', 5, NULL, NULL, 22, NULL, NULL, 3, 63250.0000, '2022-02-24', NULL, 'Payable', 1, 1, 3, 1, NULL, '2022-02-24 04:49:51', '2022-02-24 04:49:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trn_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('with_header','with_out_header') COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `code`, `name`, `email`, `address`, `logo`, `telephone`, `web_address`, `trn_no`, `type`, `mobile`, `currency_id`, `user_id`, `company_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'B002', 'test name', 'testrestaurant@gmail.com', 'Dhaka', NULL, '123456', 'Dhaka', '14785', 'with_header', '0147852369', 2, 1, 2, 1, '2022-02-13 04:00:48', '2022-02-13 04:00:48', NULL),
(2, 'B002', 'Malibag branch', NULL, 'Malibag', NULL, '123456', NULL, NULL, 'with_header', '0123456789', NULL, 1, 3, 1, '2022-02-22 23:44:46', '2022-02-22 23:44:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `code`, `name`, `user_id`, `branch_id`, `company_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'B001', 'Brand', 1, NULL, 2, 1, '2022-01-21 22:24:43', '2022-01-21 22:24:43', NULL),
(2, 'B002', 'test brand', 1, 1, 2, 1, '2022-02-13 04:24:58', '2022-02-13 04:24:58', NULL),
(3, 'B003', 'testBrand', 1, 1, 3, 1, '2022-02-26 06:56:02', '2022-02-26 06:56:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `code`, `name`, `image`, `user_id`, `branch_id`, `company_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'C001', 'Category', NULL, 1, NULL, NULL, 1, '2022-01-21 22:24:13', '2022-01-21 22:24:13', NULL),
(2, 'C002', 'testone', NULL, 1, 1, 2, 1, '2022-02-13 04:21:19', '2022-02-13 04:21:19', NULL),
(3, 'C003', 'testCategory', NULL, 1, 1, 3, 1, '2022-02-26 06:55:46', '2022-02-26 06:55:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chart_of_accounts`
--

CREATE TABLE `chart_of_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('Debit','Credit') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opening_balance` double(10,2) DEFAULT 0.00,
  `chart_of_group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_cashbank` tinyint(4) DEFAULT NULL,
  `is_income_statement` tinyint(4) DEFAULT NULL,
  `is_balance_sheet` tinyint(4) DEFAULT NULL,
  `default_module` tinyint(4) DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chart_of_accounts`
--

INSERT INTO `chart_of_accounts` (`id`, `code`, `name`, `value`, `type`, `opening_balance`, `chart_of_group_id`, `is_cashbank`, `is_income_statement`, `is_balance_sheet`, `default_module`, `note`, `user_id`, `company_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '001', 'Sales', NULL, NULL, NULL, 2, NULL, 1, NULL, 1, NULL, 1, NULL, 1, '2021-11-03 12:39:43', '2021-11-03 12:40:09', NULL),
(2, '002', 'Purchase', NULL, NULL, NULL, 2, NULL, 1, NULL, 2, NULL, 1, NULL, 1, '2021-11-03 12:40:01', '2021-11-03 12:40:01', NULL),
(3, '003', 'Purchase Return', NULL, NULL, NULL, 2, NULL, NULL, NULL, 3, NULL, 1, NULL, 1, '2021-11-03 12:40:33', '2021-11-03 12:40:33', NULL),
(4, '004', 'Sales Return', NULL, NULL, NULL, 2, NULL, 1, NULL, 4, NULL, 1, NULL, 1, '2021-11-03 12:40:55', '2021-11-03 12:40:55', NULL),
(5, '005', 'Receiveable', NULL, NULL, NULL, 2, NULL, NULL, 1, 5, NULL, 1, NULL, 1, '2021-11-03 12:41:19', '2021-11-03 12:41:19', NULL),
(6, '006', 'Payable', NULL, NULL, NULL, 4, NULL, NULL, NULL, 6, NULL, 1, NULL, 1, '2021-11-03 12:41:50', '2021-11-03 12:41:50', NULL),
(7, '007', 'Opening Balance', NULL, 'Debit', 0.00, 5, NULL, NULL, NULL, 7, NULL, 1, NULL, 1, '2021-11-03 12:42:55', '2021-11-03 23:10:01', NULL),
(8, '008', 'Stationary', NULL, 'Debit', 2000.00, 6, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, '2021-11-03 23:29:36', '2021-11-03 23:29:36', NULL),
(9, 'CA009', 'DBBL', NULL, NULL, NULL, 2, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, '2021-11-04 07:02:02', '2021-11-04 07:02:02', NULL),
(10, 'CA010', 'Input VAT 5%', NULL, NULL, NULL, 4, NULL, NULL, 1, 9, NULL, 1, NULL, 1, '2021-11-08 05:09:00', '2021-11-10 10:48:07', NULL),
(11, 'CA011', 'Output VAT', NULL, NULL, NULL, 4, NULL, NULL, 1, 10, NULL, 1, NULL, 1, '2021-11-08 05:09:20', '2021-11-08 05:09:20', NULL),
(12, 'CA012', 'Sale Discount', NULL, NULL, NULL, 2, NULL, NULL, NULL, 11, NULL, 1, NULL, 1, '2021-11-08 05:12:19', '2021-11-08 05:12:19', NULL),
(13, 'CA013', 'Purchase Discount', NULL, NULL, NULL, 2, NULL, NULL, NULL, 12, NULL, 1, NULL, 1, '2021-11-08 05:12:40', '2021-11-08 05:12:40', NULL),
(14, 'CA014', 'Sale Shipping Charge', NULL, NULL, NULL, 2, NULL, 1, NULL, 13, NULL, 1, NULL, 1, '2021-11-08 05:13:48', '2021-11-08 05:13:48', NULL),
(15, 'CA015', 'Purchase Shipping Charge', NULL, NULL, NULL, 2, NULL, 0, NULL, 14, NULL, 1, NULL, 1, '2021-11-08 05:14:50', '2021-11-08 05:14:50', NULL),
(16, 'CA016', 'Bank Asia', NULL, 'Debit', 10000.00, 7, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, '2021-11-10 10:46:51', '2021-11-10 10:46:51', NULL),
(17, 'CA017', 'test', NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '2022-02-13 03:03:37', '2022-02-13 03:03:37', NULL),
(18, 'CA018', 'Mutual Trust Bank', NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, NULL, 1, 2, 1, '2022-02-14 22:27:13', '2022-02-14 22:27:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chart_of_groups`
--

CREATE TABLE `chart_of_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chart_of_section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chart_of_groups`
--

INSERT INTO `chart_of_groups` (`id`, `chart_of_section_id`, `code`, `name`, `user_id`, `company_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '001', 'Fixed Assets', 1, NULL, 1, '2021-11-03 12:29:25', '2021-11-03 12:29:25', NULL),
(2, 1, '002', 'Current Assets', 1, NULL, 1, '2021-11-03 12:29:41', '2021-11-03 12:29:41', NULL),
(3, 2, '003', 'Fixed Liabilities', 1, NULL, 1, '2021-11-03 12:30:00', '2021-11-03 12:30:16', NULL),
(4, 2, '004', 'Current Liabilities', 1, NULL, 1, '2021-11-03 12:30:32', '2021-11-03 12:30:32', NULL),
(5, 2, '005', 'Owners Equity', 1, NULL, 1, '2021-11-03 12:42:15', '2021-11-03 12:42:15', NULL),
(6, 4, '006', 'Office & Administrative Cost', 1, NULL, 1, '2021-11-03 23:10:38', '2021-11-03 23:10:38', NULL),
(7, 1, 'CG007', 'Cash Bank Accounts', 1, 1, 1, '2021-11-10 10:45:32', '2021-11-10 10:45:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chart_of_sections`
--

CREATE TABLE `chart_of_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chart_of_sections`
--

INSERT INTO `chart_of_sections` (`id`, `code`, `name`, `value`, `user_id`, `company_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '001', 'Assets', 'assets', 1, NULL, 1, '2021-11-03 12:24:16', '2021-11-03 12:24:16', NULL),
(2, '002', 'Liabilities', 'liabilities', 1, NULL, 1, '2021-11-03 12:24:24', '2021-11-03 12:38:19', NULL),
(3, '003', 'Income', 'income', 1, NULL, 1, '2021-11-03 12:24:32', '2021-11-03 12:24:32', NULL),
(4, '004', 'Expense', 'expense', 1, NULL, 1, '2021-11-03 12:24:40', '2021-11-03 12:24:40', NULL),
(5, 'CS005', 'test', 'test', 1, 1, 1, '2022-02-13 02:41:57', '2022-02-13 02:41:57', NULL),
(6, 'CS006', 'test', 'test', 1, 1, 1, '2022-02-13 02:48:06', '2022-02-13 02:48:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `code`, `name`, `address`, `telephone`, `mobile`, `email`, `trn`, `web_address`, `logo`, `user_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'C001', 'test', 'dhaka', '0147852369', '0147852369', 'testrestaurant@gmail.com', '12345', 'Dhaka', 'lzBbDrpGMvtoBmoKyBVV2uEXPwvy6U10bzbeKvbs.jpg', 1, 'Active', '2022-02-13 00:26:14', '2022-02-13 00:26:14', NULL),
(2, 'C002', 'company two', 'Dhaka', '0147852369', '0147852369', 'testrestaurant@gmail.com', '123', 'www.test.com', 'm3UaRcmWHyM7JYlE7hZb4XKAdVmc2jJsDg4ILqf2.jpg', 1, 'Active', '2022-02-13 03:38:56', '2022-02-13 03:38:56', NULL),
(3, 'C003', 'Company three', 'Dhaka', NULL, NULL, NULL, NULL, NULL, NULL, 4, 'Active', '2022-02-14 03:15:29', '2022-02-14 03:15:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_infos`
--

CREATE TABLE `company_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hotline` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privacy_policy` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_map_location` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terms_condition` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_us` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_policy` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Customer','Supplier','Staff','Others') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trn_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_commission` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_due_sale` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(4) DEFAULT NULL,
  `credit_limit` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `division` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_period` double(10,2) DEFAULT NULL,
  `vat_reg_type` enum('Registered','Unregistered') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_reg_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `bank_details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opening_balance` double(20,4) DEFAULT 0.0000,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `code`, `type`, `name`, `business_name`, `address`, `email`, `mobile`, `trn_no`, `sale_commission`, `is_due_sale`, `is_default`, `credit_limit`, `telephone`, `country`, `division`, `credit_period`, `vat_reg_type`, `vat_reg_date`, `due_date`, `bank_details`, `website`, `opening_balance`, `user_id`, `branch_id`, `company_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'C001', 'Customer', 'Md. Iqbal Hossain', 'Amin Traders', 'MMalibagh, Dhaka', 'demo@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'BD', 'Dhaka', NULL, NULL, NULL, '2022-01-18', NULL, NULL, NULL, 1, NULL, 3, 1, '2022-01-05 21:34:40', '2022-01-05 21:34:40', NULL),
(2, 'S002', 'Supplier', 'Supplier', '45757', 'MMalibagh, Dhaka', 'demo565@gmail.com', '54765', NULL, NULL, NULL, NULL, '434', '67', 'BD', NULL, 43.00, 'Unregistered', NULL, NULL, NULL, 'www.facebook.com', 34.0000, 1, NULL, 3, 1, '2022-01-21 22:50:55', '2022-01-21 22:50:55', NULL),
(3, 'C003', 'Customer', 'test customer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 3, 1, '2022-02-13 02:37:13', '2022-02-13 02:37:13', NULL),
(4, 'S004', 'Supplier', 'testSupplier', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 1, '2022-02-13 02:38:17', '2022-02-13 02:38:17', NULL),
(5, 'ST005', 'Staff', 'teststaff', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 3, 1, '2022-02-13 02:38:48', '2022-02-13 02:38:48', NULL),
(6, 'O006', 'Others', 'test others', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 1, '2022-02-13 02:39:35', '2022-02-13 02:39:35', NULL),
(7, 'C007', 'Customer', 'test customer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 3, 1, '2022-02-13 05:30:50', '2022-02-13 05:30:50', NULL),
(8, 'S008', 'Supplier', 'test supplier', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 1, '2022-02-13 05:31:03', '2022-02-13 05:31:03', NULL),
(9, 'ST009', 'Staff', 'test staff', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 3, 1, '2022-02-13 05:31:16', '2022-02-13 05:31:16', NULL),
(10, 'O010', 'Others', 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 2, 1, '2022-02-13 05:32:32', '2022-02-13 05:32:32', NULL),
(11, 'ST011', 'Staff', 'test staff', 'employee', 'Dhaka', 'staff@gmail.com', '0123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 3, 1, '2022-02-25 22:11:39', '2022-02-25 22:11:39', NULL),
(12, 'O012', 'Others', 'test one', 'test', 'Dhaka', 'test@gmail.com', '12345678', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 3, 1, '2022-02-25 22:13:30', '2022-02-25 22:13:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol_position` enum('Prefix','Surfix') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_word_prefix` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_word_surfix` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_word_prefix_position` enum('Prefix','Surfix') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_word_surfix_position` enum('Prefix','Surfix') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `code`, `title`, `symbol`, `symbol_position`, `in_word_prefix`, `in_word_surfix`, `in_word_prefix_position`, `in_word_surfix_position`, `user_id`, `branch_id`, `company_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'CU001', 'Taka', 'T', 'Prefix', 'only', 'fills', 'Surfix', 'Surfix', 1, 1, 1, 1, '2022-02-13 03:25:44', '2022-02-22 23:27:23', NULL),
(2, 'CU002', 'test taka', 'T', 'Prefix', 'only', 'fills', 'Surfix', 'Surfix', 1, 1, 2, 1, '2022-02-13 03:54:32', '2022-02-13 03:54:32', NULL),
(3, 'CU003', 'doller', '$', 'Prefix', 'only', 'fills', 'Surfix', 'Surfix', 1, 2, 3, 1, '2022-02-22 23:46:02', '2022-02-22 23:46:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `entry_types`
--

CREATE TABLE `entry_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prefix` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suffix` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `entry_types`
--

INSERT INTO `entry_types` (`id`, `name`, `description`, `prefix`, `suffix`, `status`, `user_id`, `company_id`, `branch_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test', NULL, 'test', 'test', 1, 1, 2, 1, '2022-02-13 04:16:23', '2022-02-13 04:16:23', NULL),
(2, 'testtwo', NULL, NULL, NULL, 1, 1, 2, 1, '2022-02-14 22:30:08', '2022-02-14 22:30:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `entry_type_account_lists`
--

CREATE TABLE `entry_type_account_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entry_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `chart_of_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `entry_type_account_lists`
--

INSERT INTO `entry_type_account_lists` (`id`, `entry_type_id`, `chart_of_account_id`, `status`, `user_id`, `company_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, 1, 2, '2022-02-14 23:23:58', '2022-02-14 23:23:58', NULL),
(2, 1, 2, 1, 1, 2, '2022-02-14 23:23:58', '2022-02-14 23:23:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `financial_years`
--

CREATE TABLE `financial_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_datetime` date DEFAULT NULL,
  `end_datetime` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `financial_years`
--

INSERT INTO `financial_years` (`id`, `name`, `start_datetime`, `end_datetime`, `status`, `user_id`, `branch_id`, `company_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test year', '2022-01-01', '2022-02-13', 1, 1, 1, 2, '2022-02-13 03:48:33', '2022-02-13 03:48:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `type` enum('Sales','Sales Return','Purchase','Purchase Return','Quotation','Requisition') COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `chalan_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `memo_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` double(20,4) DEFAULT NULL,
  `expired_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_vat` double(20,4) DEFAULT NULL,
  `shipping_charge` double(20,4) DEFAULT NULL,
  `subtotal` double(20,4) DEFAULT NULL,
  `amount_to_pay` double(20,4) DEFAULT NULL,
  `paid_amount` double(20,4) DEFAULT NULL,
  `due_amount` double(20,4) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `advance_amount` double(20,4) DEFAULT NULL,
  `payment_status` enum('Paid','Due','Advanced','Cancel') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `note` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `do_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lpo_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `code`, `date`, `type`, `contact_id`, `invoice_id`, `chalan_no`, `memo_no`, `header_content`, `footer_content`, `attachment`, `discount`, `expired_date`, `discount_value`, `total_vat`, `shipping_charge`, `subtotal`, `amount_to_pay`, `paid_amount`, `due_amount`, `due_date`, `advance_amount`, `payment_status`, `status`, `warehouse_id`, `user_id`, `branch_id`, `company_id`, `note`, `do_no`, `lpo_no`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'P001', '2022-01-22', 'Purchase', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1440.0000, 0.0000, 12000.0000, 13440.0000, 0.0000, 168.0000, NULL, NULL, 'Due', 1, NULL, 1, 1, 1, NULL, NULL, NULL, '2022-01-21 23:12:44', '2022-01-29 23:24:51', NULL),
(5, 'S005', '2022-01-22', 'Sales', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 18.0000, 0.0000, 150.0000, 168.0000, 1000.0000, 50.0000, NULL, NULL, 'Due', 1, NULL, 1, NULL, 3, NULL, NULL, NULL, '2022-01-21 23:18:33', '2022-01-29 23:41:25', NULL),
(6, 'S006', '2022-01-22', 'Sales', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 18.0000, 0.0000, 150.0000, 168.0000, 100.0000, 0.0000, NULL, NULL, 'Due', 1, NULL, 1, NULL, 3, NULL, NULL, NULL, '2022-01-21 23:19:12', '2022-01-29 23:40:29', NULL),
(7, 'S007', '2022-01-22', 'Sales', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 18.0000, 0.0000, 150.0000, 168.0000, 200.0000, 0.0000, NULL, NULL, 'Due', 1, NULL, 1, NULL, 3, NULL, NULL, NULL, '2022-01-22 00:48:43', '2022-01-29 23:40:29', NULL),
(8, 'S008', '2022-01-22', 'Sales', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 18.0000, 0.0000, 150.0000, 168.0000, 0.0000, 100.0000, NULL, NULL, 'Due', 1, NULL, 1, NULL, 3, NULL, NULL, NULL, '2022-01-22 00:48:59', '2022-01-29 23:28:40', NULL),
(9, 'S009', '2022-01-22', 'Sales', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 18.0000, 0.0000, 150.0000, 168.0000, 0.0000, 300.0000, NULL, NULL, 'Due', 1, NULL, 1, NULL, 3, NULL, NULL, NULL, '2022-01-22 00:49:13', '2022-01-29 23:35:43', NULL),
(10, 'S010', '2022-01-22', 'Sales', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 18.0000, 0.0000, 150.0000, 168.0000, 50.0000, 0.0000, NULL, NULL, 'Due', 1, NULL, 1, NULL, 3, NULL, NULL, NULL, '2022-01-22 00:49:26', '2022-01-29 23:44:13', NULL),
(11, 'S011', '2022-01-22', 'Sales', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 18.0000, 0.0000, 150.0000, 168.0000, 0.0000, 168.0000, NULL, NULL, 'Due', 1, NULL, 1, NULL, 3, NULL, NULL, NULL, '2022-01-22 00:49:41', '2022-01-29 23:25:31', NULL),
(12, 'Q012', '2022-02-13', 'Quotation', 7, NULL, NULL, NULL, 'test', 'test', NULL, NULL, '2022-02-13', '0', 1150.0000, 0.0000, 11500.0000, 12650.0000, NULL, NULL, NULL, NULL, 'Paid', 1, NULL, 1, 1, 2, NULL, NULL, NULL, '2022-02-13 05:37:16', '2022-02-13 05:37:16', NULL),
(13, 'P013', '2022-02-14', 'Purchase', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '10', 3750.0000, 20.0000, 37500.0000, 41260.0000, 10000.0000, 31260.0000, NULL, NULL, 'Due', 1, NULL, 1, 1, 2, NULL, NULL, NULL, '2022-02-14 05:30:23', '2022-02-14 05:30:23', NULL),
(14, 'S014', '2022-02-14', 'Sales', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '10', 4600.0000, 10.0000, 46000.0000, 50600.0000, 10000.0000, 40600.0000, '2022-02-14', NULL, 'Due', 1, NULL, 1, 1, 2, NULL, NULL, NULL, '2022-02-14 05:38:55', '2022-02-14 05:38:55', NULL),
(15, 'I015', '2022-02-14', 'Sales Return', 7, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, NULL, 11500.0000, 12650.0000, 10000.0000, 2650.0000, NULL, NULL, 'Due', 1, NULL, 1, 1, 2, NULL, NULL, NULL, '2022-02-14 06:19:01', '2022-02-14 06:19:01', NULL),
(16, 'P016', '2022-02-15', 'Purchase', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 6250.0000, 0.0000, 62500.0000, 68750.0000, 0.0000, 68750.0000, NULL, NULL, 'Due', 1, NULL, 1, 1, 1, NULL, NULL, NULL, '2022-02-15 01:56:52', '2022-02-15 01:56:52', NULL),
(17, 'S017', '2022-02-15', 'Sales', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 3440.0000, 200.0000, 34400.0000, 38040.0000, 0.0000, 38040.0000, NULL, NULL, 'Due', 1, NULL, 1, 1, 2, NULL, NULL, NULL, '2022-02-15 01:58:22', '2022-02-15 01:58:22', NULL),
(18, 'I018', '2022-02-23', 'Purchase Return', 8, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, NULL, 12500.0000, 13750.0000, 4000.0000, 9750.0000, NULL, NULL, 'Due', 1, NULL, 1, 1, 1, NULL, NULL, NULL, '2022-02-22 22:59:36', '2022-02-22 22:59:36', NULL),
(19, 'Q019', '2022-02-23', 'Quotation', 1, NULL, NULL, NULL, 'test', 'test', NULL, NULL, '2022-02-23', '50', 3450.0000, 0.0000, 34500.0000, 37900.0000, NULL, NULL, NULL, NULL, 'Paid', 1, NULL, 1, 1, 1, NULL, NULL, NULL, '2022-02-22 23:01:04', '2022-02-22 23:01:04', NULL),
(20, 'R020', '2022-02-23', 'Requisition', 4, NULL, NULL, NULL, 'test', 'test', NULL, NULL, '2022-02-23', '50', 3750.0000, 0.0000, 37500.0000, 41200.0000, NULL, NULL, NULL, NULL, 'Paid', 1, NULL, 1, 1, 1, NULL, NULL, NULL, '2022-02-22 23:09:22', '2022-02-22 23:09:22', NULL),
(21, 'S021', '2022-02-24', 'Sales', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 1150.0000, 0.0000, 11500.0000, 12650.0000, 0.0000, 12650.0000, NULL, NULL, 'Due', 1, NULL, 1, 1, 3, NULL, NULL, NULL, '2022-02-24 04:37:15', '2022-02-24 04:37:15', NULL),
(22, 'S022', '2022-02-24', 'Sales', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 5750.0000, 0.0000, 57500.0000, 63250.0000, 0.0000, 63250.0000, NULL, NULL, 'Due', 1, NULL, 1, 1, 3, NULL, NULL, NULL, '2022-02-24 04:49:51', '2022-02-24 04:49:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_settings`
--

CREATE TABLE `invoice_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('Invoice','Receipt') COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_header` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_footer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_reg_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_area_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_previous_due` tinyint(4) DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_paid_due_hide` tinyint(4) DEFAULT NULL,
  `is_memo_no_hide` tinyint(4) DEFAULT NULL,
  `is_chalan_no_hide` tinyint(4) DEFAULT NULL,
  `transaction` tinyint(4) DEFAULT NULL,
  `do_no` tinyint(4) DEFAULT NULL,
  `lpo_no` tinyint(4) DEFAULT NULL,
  `vat` tinyint(4) DEFAULT NULL,
  `rate` tinyint(4) DEFAULT NULL,
  `discount` tinyint(4) DEFAULT NULL,
  `amount_aed` tinyint(4) DEFAULT NULL,
  `texable_value` tinyint(4) DEFAULT NULL,
  `vat_aed` tinyint(4) DEFAULT NULL,
  `note` tinyint(4) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_settings`
--

INSERT INTO `invoice_settings` (`id`, `type`, `logo`, `invoice_header`, `invoice_title`, `invoice_footer`, `vat_reg_no`, `vat_area_code`, `vat_text`, `is_previous_due`, `currency_id`, `email`, `header_title`, `footer_title`, `is_paid_due_hide`, `is_memo_no_hide`, `is_chalan_no_hide`, `transaction`, `do_no`, `lpo_no`, `vat`, `rate`, `discount`, `amount_aed`, `texable_value`, `vat_aed`, `note`, `user_id`, `branch_id`, `company_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Invoice', 'rZxcGRhQ4dnGhkgR4rdPhmtFq7cL8SDzC81Rhfea.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, 1, '2022-02-15 02:05:57', '2022-02-15 02:05:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('Product','Material','Service') COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_price` double(20,4) DEFAULT NULL,
  `avg_pur_price` double(20,4) DEFAULT NULL,
  `opening_stock` double(20,4) DEFAULT NULL,
  `vat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount` double(20,4) DEFAULT NULL,
  `sale_price` double(20,4) DEFAULT NULL,
  `low_stock_alert` double(20,4) DEFAULT NULL,
  `is_stock_check` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whole_sale_price` double(20,2) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `type`, `category_id`, `brand_id`, `code`, `name`, `unit_id`, `purchase_price`, `avg_pur_price`, `opening_stock`, `vat_id`, `discount`, `sale_price`, `low_stock_alert`, `is_stock_check`, `whole_sale_price`, `user_id`, `branch_id`, `company_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Product', 1, 1, 'I001', 'item 1', 1, 120.0000, 120.0000, 22232.0000, 1, NULL, 150.0000, 10.0000, NULL, 140.00, 1, 1, NULL, 1, '2022-01-21 22:26:16', '2022-01-21 23:12:44', NULL),
(2, 'Product', 2, 2, 'I002', 'testname', 2, 12500.0000, 949.4746, 100.0000, 2, NULL, 11500.0000, 15.0000, '1', 10500.00, 1, 1, 2, 1, '2022-02-13 04:29:31', '2022-02-15 01:56:52', NULL),
(3, 'Service', 2, NULL, 'S003', 'test service', 2, NULL, NULL, NULL, 2, NULL, 12500.0000, NULL, NULL, NULL, 1, 1, 2, 1, '2022-02-13 04:36:56', '2022-02-13 04:36:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_invoices`
--

CREATE TABLE `item_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warranty` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_price` double(20,4) DEFAULT NULL,
  `sale_price` double(20,4) DEFAULT NULL,
  `discount_percent` double(20,4) DEFAULT NULL,
  `discount_value` double(20,4) DEFAULT NULL,
  `vat` double(20,4) DEFAULT NULL,
  `vat_subtotal` double(20,4) DEFAULT NULL,
  `subtotal` double(20,4) DEFAULT NULL,
  `batch_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_invoices`
--

INSERT INTO `item_invoices` (`id`, `code`, `date`, `item_id`, `invoice_id`, `category_id`, `unit_id`, `contact_id`, `warranty`, `serial`, `quantity`, `purchase_price`, `sale_price`, `discount_percent`, `discount_value`, `vat`, `vat_subtotal`, `subtotal`, `batch_no`, `expired_date`, `status`, `warehouse_id`, `user_id`, `branch_id`, `company_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'II001', '2022-02-13', 2, 12, 2, 2, 7, NULL, NULL, '1', NULL, 11500.0000, NULL, 0.0000, NULL, NULL, 11500.0000, NULL, NULL, 1, NULL, 1, 1, NULL, '2022-02-13 05:37:16', '2022-02-13 05:37:16', NULL),
(2, 'II002', '2022-02-23', 2, 19, 2, 2, 1, NULL, NULL, '3', NULL, 11500.0000, NULL, 0.0000, NULL, NULL, 34500.0000, NULL, NULL, 1, NULL, 1, 1, NULL, '2022-02-22 23:01:04', '2022-02-22 23:01:04', NULL),
(3, 'II003', '2022-02-23', 2, 20, 2, 2, 4, NULL, NULL, '3', 12500.0000, NULL, NULL, 0.0000, NULL, NULL, 37500.0000, NULL, NULL, 1, NULL, 1, 1, NULL, '2022-02-22 23:09:22', '2022-02-22 23:09:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2013_02_09_0000_create_types_table', 1),
(4, '2014_10_12_000000_create_users_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 1),
(6, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(7, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(8, '2020_05_21_100000_create_teams_table', 1),
(9, '2020_05_21_200000_create_team_user_table', 1),
(10, '2020_05_21_300000_create_team_invitations_table', 1),
(11, '2021_09_02_142854_create_sessions_table', 1),
(12, '2021_09_18_092815_create_contacts_table', 1),
(13, '2021_09_18_092905_create_chart_of_sections_table', 1),
(14, '2021_09_18_092923_create_chart_of_groups_table', 1),
(15, '2021_09_18_092938_create_chart_of_accounts_table', 1),
(16, '2021_09_18_093054_create_vats_table', 1),
(17, '2021_09_18_093109_create_currencies_table', 1),
(19, '2021_09_18_093213_create_warehouses_table', 1),
(20, '2021_09_18_093247_create_categories_table', 1),
(21, '2021_09_18_093259_create_units_table', 1),
(22, '2021_09_18_093310_create_brands_table', 1),
(23, '2021_09_18_093325_create_items_table', 1),
(24, '2021_09_18_093349_create_invoices_table', 1),
(25, '2021_09_19_070710_create_stock_managers_table', 1),
(26, '2021_09_19_071118_create_stock_adjustments_table', 1),
(27, '2021_09_19_180109_create_account_managers_table', 1),
(31, '2021_10_27_054847_create_receipts_table', 1),
(32, '2021_10_27_055429_create_entry_type_account_lists_table', 1),
(33, '2021_11_06_050918_create_item_invoices_table', 1),
(36, '2021_11_11_093439_create_tags_table', 1),
(37, '2022_01_03_053358_create_permission_tables', 1),
(38, '2022_01_03_055714_create_permission_categories_table', 1),
(39, '2021_10_27_054535_create_profile_settings_table', 2),
(40, '2014_10_10_000000_create_company_infos_table', 3),
(41, '2021_10_27_054340_create_companies_table', 4),
(42, '2021_11_06_095711_create_financial_years_table', 5),
(43, '2014_10_11_000000_create_branches_table', 6),
(44, '2021_10_27_041744_create_entry_types_table', 7),
(45, '2021_11_10_092802_create_transactions_table', 8),
(46, '2021_09_18_093130_create_invoice_settings_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 3),
(1, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(5, 'App\\Models\\User', 1),
(5, 'App\\Models\\User', 3),
(5, 'App\\Models\\User', 4),
(6, 'App\\Models\\User', 3),
(7, 'App\\Models\\User', 1),
(7, 'App\\Models\\User', 3),
(7, 'App\\Models\\User', 4),
(8, 'App\\Models\\User', 1),
(8, 'App\\Models\\User', 3),
(8, 'App\\Models\\User', 4),
(9, 'App\\Models\\User', 1),
(9, 'App\\Models\\User', 3),
(9, 'App\\Models\\User', 4),
(10, 'App\\Models\\User', 3),
(11, 'App\\Models\\User', 1),
(11, 'App\\Models\\User', 3),
(11, 'App\\Models\\User', 4),
(12, 'App\\Models\\User', 1),
(12, 'App\\Models\\User', 3),
(12, 'App\\Models\\User', 4),
(13, 'App\\Models\\User', 1),
(13, 'App\\Models\\User', 3),
(13, 'App\\Models\\User', 4),
(14, 'App\\Models\\User', 3),
(15, 'App\\Models\\User', 1),
(15, 'App\\Models\\User', 3),
(15, 'App\\Models\\User', 4),
(16, 'App\\Models\\User', 1),
(16, 'App\\Models\\User', 3),
(16, 'App\\Models\\User', 4),
(17, 'App\\Models\\User', 1),
(17, 'App\\Models\\User', 3),
(17, 'App\\Models\\User', 4),
(18, 'App\\Models\\User', 3),
(19, 'App\\Models\\User', 1),
(19, 'App\\Models\\User', 3),
(19, 'App\\Models\\User', 4),
(20, 'App\\Models\\User', 1),
(20, 'App\\Models\\User', 3),
(20, 'App\\Models\\User', 4),
(21, 'App\\Models\\User', 1),
(21, 'App\\Models\\User', 3),
(21, 'App\\Models\\User', 4),
(22, 'App\\Models\\User', 3),
(23, 'App\\Models\\User', 1),
(23, 'App\\Models\\User', 3),
(23, 'App\\Models\\User', 4),
(24, 'App\\Models\\User', 1),
(24, 'App\\Models\\User', 3),
(24, 'App\\Models\\User', 4),
(25, 'App\\Models\\User', 1),
(25, 'App\\Models\\User', 3),
(25, 'App\\Models\\User', 4),
(26, 'App\\Models\\User', 3),
(27, 'App\\Models\\User', 1),
(27, 'App\\Models\\User', 3),
(27, 'App\\Models\\User', 4),
(28, 'App\\Models\\User', 1),
(28, 'App\\Models\\User', 3),
(28, 'App\\Models\\User', 4),
(29, 'App\\Models\\User', 1),
(29, 'App\\Models\\User', 3),
(29, 'App\\Models\\User', 4),
(30, 'App\\Models\\User', 3),
(31, 'App\\Models\\User', 1),
(31, 'App\\Models\\User', 3),
(31, 'App\\Models\\User', 4),
(32, 'App\\Models\\User', 1),
(32, 'App\\Models\\User', 3),
(32, 'App\\Models\\User', 4),
(33, 'App\\Models\\User', 1),
(33, 'App\\Models\\User', 3),
(33, 'App\\Models\\User', 4),
(34, 'App\\Models\\User', 3),
(35, 'App\\Models\\User', 1),
(35, 'App\\Models\\User', 3),
(35, 'App\\Models\\User', 4),
(36, 'App\\Models\\User', 1),
(36, 'App\\Models\\User', 3),
(36, 'App\\Models\\User', 4),
(37, 'App\\Models\\User', 1),
(37, 'App\\Models\\User', 3),
(37, 'App\\Models\\User', 4),
(38, 'App\\Models\\User', 3),
(39, 'App\\Models\\User', 1),
(39, 'App\\Models\\User', 3),
(39, 'App\\Models\\User', 4),
(40, 'App\\Models\\User', 1),
(40, 'App\\Models\\User', 3),
(40, 'App\\Models\\User', 4),
(41, 'App\\Models\\User', 1),
(41, 'App\\Models\\User', 3),
(41, 'App\\Models\\User', 4),
(42, 'App\\Models\\User', 3),
(43, 'App\\Models\\User', 1),
(43, 'App\\Models\\User', 3),
(43, 'App\\Models\\User', 4),
(44, 'App\\Models\\User', 1),
(44, 'App\\Models\\User', 3),
(44, 'App\\Models\\User', 4),
(45, 'App\\Models\\User', 1),
(45, 'App\\Models\\User', 3),
(45, 'App\\Models\\User', 4),
(46, 'App\\Models\\User', 3),
(47, 'App\\Models\\User', 1),
(47, 'App\\Models\\User', 3),
(47, 'App\\Models\\User', 4),
(48, 'App\\Models\\User', 1),
(48, 'App\\Models\\User', 3),
(48, 'App\\Models\\User', 4),
(49, 'App\\Models\\User', 1),
(49, 'App\\Models\\User', 3),
(49, 'App\\Models\\User', 4),
(50, 'App\\Models\\User', 3),
(51, 'App\\Models\\User', 1),
(51, 'App\\Models\\User', 3),
(51, 'App\\Models\\User', 4),
(52, 'App\\Models\\User', 1),
(52, 'App\\Models\\User', 3),
(52, 'App\\Models\\User', 4),
(53, 'App\\Models\\User', 1),
(53, 'App\\Models\\User', 3),
(53, 'App\\Models\\User', 4),
(54, 'App\\Models\\User', 3),
(55, 'App\\Models\\User', 1),
(55, 'App\\Models\\User', 3),
(55, 'App\\Models\\User', 4),
(56, 'App\\Models\\User', 1),
(56, 'App\\Models\\User', 3),
(56, 'App\\Models\\User', 4),
(57, 'App\\Models\\User', 1),
(57, 'App\\Models\\User', 3),
(57, 'App\\Models\\User', 4),
(58, 'App\\Models\\User', 3),
(59, 'App\\Models\\User', 1),
(59, 'App\\Models\\User', 3),
(59, 'App\\Models\\User', 4),
(60, 'App\\Models\\User', 1),
(60, 'App\\Models\\User', 3),
(60, 'App\\Models\\User', 4),
(61, 'App\\Models\\User', 1),
(61, 'App\\Models\\User', 3),
(61, 'App\\Models\\User', 4),
(62, 'App\\Models\\User', 3),
(63, 'App\\Models\\User', 1),
(63, 'App\\Models\\User', 3),
(63, 'App\\Models\\User', 4),
(64, 'App\\Models\\User', 1),
(64, 'App\\Models\\User', 3),
(64, 'App\\Models\\User', 4),
(65, 'App\\Models\\User', 1),
(65, 'App\\Models\\User', 3),
(65, 'App\\Models\\User', 4),
(66, 'App\\Models\\User', 3),
(67, 'App\\Models\\User', 1),
(67, 'App\\Models\\User', 3),
(67, 'App\\Models\\User', 4),
(68, 'App\\Models\\User', 1),
(68, 'App\\Models\\User', 3),
(68, 'App\\Models\\User', 4),
(69, 'App\\Models\\User', 1),
(69, 'App\\Models\\User', 3),
(69, 'App\\Models\\User', 4),
(70, 'App\\Models\\User', 3),
(71, 'App\\Models\\User', 1),
(71, 'App\\Models\\User', 3),
(71, 'App\\Models\\User', 4),
(72, 'App\\Models\\User', 1),
(72, 'App\\Models\\User', 3),
(72, 'App\\Models\\User', 4),
(73, 'App\\Models\\User', 1),
(73, 'App\\Models\\User', 3),
(73, 'App\\Models\\User', 4),
(74, 'App\\Models\\User', 3),
(75, 'App\\Models\\User', 1),
(75, 'App\\Models\\User', 3),
(75, 'App\\Models\\User', 4),
(76, 'App\\Models\\User', 1),
(76, 'App\\Models\\User', 3),
(76, 'App\\Models\\User', 4),
(77, 'App\\Models\\User', 1),
(77, 'App\\Models\\User', 3),
(77, 'App\\Models\\User', 4),
(78, 'App\\Models\\User', 3),
(79, 'App\\Models\\User', 1),
(79, 'App\\Models\\User', 3),
(79, 'App\\Models\\User', 4),
(80, 'App\\Models\\User', 1),
(80, 'App\\Models\\User', 3),
(80, 'App\\Models\\User', 4),
(81, 'App\\Models\\User', 1),
(81, 'App\\Models\\User', 3),
(81, 'App\\Models\\User', 4),
(82, 'App\\Models\\User', 3),
(83, 'App\\Models\\User', 1),
(83, 'App\\Models\\User', 3),
(83, 'App\\Models\\User', 4),
(84, 'App\\Models\\User', 1),
(84, 'App\\Models\\User', 3),
(84, 'App\\Models\\User', 4),
(85, 'App\\Models\\User', 1),
(85, 'App\\Models\\User', 3),
(85, 'App\\Models\\User', 4),
(86, 'App\\Models\\User', 3),
(87, 'App\\Models\\User', 1),
(87, 'App\\Models\\User', 3),
(87, 'App\\Models\\User', 4),
(88, 'App\\Models\\User', 1),
(88, 'App\\Models\\User', 3),
(88, 'App\\Models\\User', 4),
(89, 'App\\Models\\User', 1),
(89, 'App\\Models\\User', 3),
(89, 'App\\Models\\User', 4),
(90, 'App\\Models\\User', 3),
(91, 'App\\Models\\User', 1),
(91, 'App\\Models\\User', 3),
(91, 'App\\Models\\User', 4),
(92, 'App\\Models\\User', 1),
(92, 'App\\Models\\User', 3),
(92, 'App\\Models\\User', 4),
(93, 'App\\Models\\User', 1),
(93, 'App\\Models\\User', 3),
(93, 'App\\Models\\User', 4),
(94, 'App\\Models\\User', 3),
(95, 'App\\Models\\User', 1),
(95, 'App\\Models\\User', 3),
(95, 'App\\Models\\User', 4),
(96, 'App\\Models\\User', 1),
(96, 'App\\Models\\User', 3),
(96, 'App\\Models\\User', 4),
(97, 'App\\Models\\User', 1),
(97, 'App\\Models\\User', 3),
(97, 'App\\Models\\User', 4),
(98, 'App\\Models\\User', 3),
(99, 'App\\Models\\User', 1),
(99, 'App\\Models\\User', 3),
(99, 'App\\Models\\User', 4),
(100, 'App\\Models\\User', 1),
(100, 'App\\Models\\User', 3),
(100, 'App\\Models\\User', 4),
(101, 'App\\Models\\User', 1),
(101, 'App\\Models\\User', 3),
(101, 'App\\Models\\User', 4),
(102, 'App\\Models\\User', 3),
(103, 'App\\Models\\User', 1),
(103, 'App\\Models\\User', 3),
(103, 'App\\Models\\User', 4),
(104, 'App\\Models\\User', 1),
(104, 'App\\Models\\User', 3),
(104, 'App\\Models\\User', 4),
(105, 'App\\Models\\User', 1),
(105, 'App\\Models\\User', 2),
(105, 'App\\Models\\User', 3),
(105, 'App\\Models\\User', 4),
(106, 'App\\Models\\User', 3),
(107, 'App\\Models\\User', 1),
(107, 'App\\Models\\User', 2),
(107, 'App\\Models\\User', 3),
(107, 'App\\Models\\User', 4),
(108, 'App\\Models\\User', 1),
(108, 'App\\Models\\User', 2),
(108, 'App\\Models\\User', 3),
(108, 'App\\Models\\User', 4),
(109, 'App\\Models\\User', 1),
(109, 'App\\Models\\User', 2),
(109, 'App\\Models\\User', 3),
(109, 'App\\Models\\User', 4),
(110, 'App\\Models\\User', 3),
(111, 'App\\Models\\User', 1),
(111, 'App\\Models\\User', 2),
(111, 'App\\Models\\User', 3),
(111, 'App\\Models\\User', 4),
(112, 'App\\Models\\User', 1),
(112, 'App\\Models\\User', 2),
(112, 'App\\Models\\User', 3),
(112, 'App\\Models\\User', 4),
(113, 'App\\Models\\User', 1),
(113, 'App\\Models\\User', 2),
(113, 'App\\Models\\User', 3),
(113, 'App\\Models\\User', 4),
(114, 'App\\Models\\User', 3),
(115, 'App\\Models\\User', 1),
(115, 'App\\Models\\User', 2),
(115, 'App\\Models\\User', 3),
(115, 'App\\Models\\User', 4),
(116, 'App\\Models\\User', 1),
(116, 'App\\Models\\User', 2),
(116, 'App\\Models\\User', 3),
(116, 'App\\Models\\User', 4),
(117, 'App\\Models\\User', 1),
(117, 'App\\Models\\User', 2),
(117, 'App\\Models\\User', 3),
(117, 'App\\Models\\User', 4),
(118, 'App\\Models\\User', 3),
(119, 'App\\Models\\User', 1),
(119, 'App\\Models\\User', 2),
(119, 'App\\Models\\User', 3),
(119, 'App\\Models\\User', 4),
(120, 'App\\Models\\User', 1),
(120, 'App\\Models\\User', 2),
(120, 'App\\Models\\User', 3),
(120, 'App\\Models\\User', 4),
(121, 'App\\Models\\User', 1),
(121, 'App\\Models\\User', 2),
(121, 'App\\Models\\User', 3),
(121, 'App\\Models\\User', 4),
(122, 'App\\Models\\User', 3),
(123, 'App\\Models\\User', 1),
(123, 'App\\Models\\User', 2),
(123, 'App\\Models\\User', 3),
(123, 'App\\Models\\User', 4),
(124, 'App\\Models\\User', 1),
(124, 'App\\Models\\User', 2),
(124, 'App\\Models\\User', 3),
(124, 'App\\Models\\User', 4),
(125, 'App\\Models\\User', 1),
(125, 'App\\Models\\User', 2),
(125, 'App\\Models\\User', 3),
(125, 'App\\Models\\User', 4),
(126, 'App\\Models\\User', 3),
(127, 'App\\Models\\User', 1),
(127, 'App\\Models\\User', 2),
(127, 'App\\Models\\User', 3),
(127, 'App\\Models\\User', 4),
(128, 'App\\Models\\User', 1),
(128, 'App\\Models\\User', 2),
(128, 'App\\Models\\User', 3),
(128, 'App\\Models\\User', 4),
(129, 'App\\Models\\User', 1),
(129, 'App\\Models\\User', 2),
(129, 'App\\Models\\User', 3),
(129, 'App\\Models\\User', 4),
(130, 'App\\Models\\User', 3),
(131, 'App\\Models\\User', 1),
(131, 'App\\Models\\User', 2),
(131, 'App\\Models\\User', 3),
(131, 'App\\Models\\User', 4),
(132, 'App\\Models\\User', 1),
(132, 'App\\Models\\User', 2),
(132, 'App\\Models\\User', 3),
(132, 'App\\Models\\User', 4),
(133, 'App\\Models\\User', 1),
(133, 'App\\Models\\User', 2),
(133, 'App\\Models\\User', 3),
(133, 'App\\Models\\User', 4),
(134, 'App\\Models\\User', 3),
(135, 'App\\Models\\User', 1),
(135, 'App\\Models\\User', 2),
(135, 'App\\Models\\User', 3),
(135, 'App\\Models\\User', 4),
(136, 'App\\Models\\User', 1),
(136, 'App\\Models\\User', 2),
(136, 'App\\Models\\User', 3),
(136, 'App\\Models\\User', 4),
(137, 'App\\Models\\User', 1),
(137, 'App\\Models\\User', 2),
(137, 'App\\Models\\User', 3),
(137, 'App\\Models\\User', 4),
(138, 'App\\Models\\User', 3),
(139, 'App\\Models\\User', 1),
(139, 'App\\Models\\User', 2),
(139, 'App\\Models\\User', 3),
(139, 'App\\Models\\User', 4),
(140, 'App\\Models\\User', 1),
(140, 'App\\Models\\User', 2),
(140, 'App\\Models\\User', 3),
(140, 'App\\Models\\User', 4),
(141, 'App\\Models\\User', 1),
(141, 'App\\Models\\User', 2),
(141, 'App\\Models\\User', 3),
(141, 'App\\Models\\User', 4),
(142, 'App\\Models\\User', 3),
(143, 'App\\Models\\User', 1),
(143, 'App\\Models\\User', 2),
(143, 'App\\Models\\User', 3),
(143, 'App\\Models\\User', 4),
(144, 'App\\Models\\User', 1),
(144, 'App\\Models\\User', 2),
(144, 'App\\Models\\User', 3),
(144, 'App\\Models\\User', 4),
(145, 'App\\Models\\User', 1),
(145, 'App\\Models\\User', 2),
(145, 'App\\Models\\User', 3),
(145, 'App\\Models\\User', 4),
(146, 'App\\Models\\User', 3),
(147, 'App\\Models\\User', 1),
(147, 'App\\Models\\User', 2),
(147, 'App\\Models\\User', 3),
(147, 'App\\Models\\User', 4),
(148, 'App\\Models\\User', 1),
(148, 'App\\Models\\User', 2),
(148, 'App\\Models\\User', 3),
(148, 'App\\Models\\User', 4),
(149, 'App\\Models\\User', 1),
(149, 'App\\Models\\User', 2),
(149, 'App\\Models\\User', 3),
(149, 'App\\Models\\User', 4),
(150, 'App\\Models\\User', 3),
(151, 'App\\Models\\User', 1),
(151, 'App\\Models\\User', 2),
(151, 'App\\Models\\User', 3),
(151, 'App\\Models\\User', 4),
(152, 'App\\Models\\User', 1),
(152, 'App\\Models\\User', 2),
(152, 'App\\Models\\User', 3),
(152, 'App\\Models\\User', 4),
(153, 'App\\Models\\User', 1),
(153, 'App\\Models\\User', 2),
(153, 'App\\Models\\User', 3),
(153, 'App\\Models\\User', 4),
(154, 'App\\Models\\User', 3),
(155, 'App\\Models\\User', 1),
(155, 'App\\Models\\User', 2),
(155, 'App\\Models\\User', 3),
(155, 'App\\Models\\User', 4),
(156, 'App\\Models\\User', 1),
(156, 'App\\Models\\User', 2),
(156, 'App\\Models\\User', 3),
(156, 'App\\Models\\User', 4),
(157, 'App\\Models\\User', 1),
(157, 'App\\Models\\User', 2),
(157, 'App\\Models\\User', 3),
(157, 'App\\Models\\User', 4),
(158, 'App\\Models\\User', 3),
(159, 'App\\Models\\User', 1),
(159, 'App\\Models\\User', 2),
(159, 'App\\Models\\User', 3),
(159, 'App\\Models\\User', 4),
(160, 'App\\Models\\User', 1),
(160, 'App\\Models\\User', 2),
(160, 'App\\Models\\User', 3),
(160, 'App\\Models\\User', 4),
(161, 'App\\Models\\User', 1),
(161, 'App\\Models\\User', 2),
(161, 'App\\Models\\User', 3),
(161, 'App\\Models\\User', 4),
(162, 'App\\Models\\User', 3),
(163, 'App\\Models\\User', 1),
(163, 'App\\Models\\User', 2),
(163, 'App\\Models\\User', 3),
(163, 'App\\Models\\User', 4),
(164, 'App\\Models\\User', 1),
(164, 'App\\Models\\User', 2),
(164, 'App\\Models\\User', 3),
(164, 'App\\Models\\User', 4),
(165, 'App\\Models\\User', 1),
(165, 'App\\Models\\User', 2),
(165, 'App\\Models\\User', 3),
(165, 'App\\Models\\User', 4),
(166, 'App\\Models\\User', 3),
(167, 'App\\Models\\User', 1),
(167, 'App\\Models\\User', 2),
(167, 'App\\Models\\User', 3),
(167, 'App\\Models\\User', 4),
(168, 'App\\Models\\User', 1),
(168, 'App\\Models\\User', 2),
(168, 'App\\Models\\User', 3),
(168, 'App\\Models\\User', 4),
(169, 'App\\Models\\User', 1),
(169, 'App\\Models\\User', 2),
(169, 'App\\Models\\User', 3),
(169, 'App\\Models\\User', 4),
(170, 'App\\Models\\User', 3),
(171, 'App\\Models\\User', 1),
(171, 'App\\Models\\User', 2),
(171, 'App\\Models\\User', 3),
(171, 'App\\Models\\User', 4),
(172, 'App\\Models\\User', 1),
(172, 'App\\Models\\User', 2),
(172, 'App\\Models\\User', 3),
(172, 'App\\Models\\User', 4),
(173, 'App\\Models\\User', 1),
(173, 'App\\Models\\User', 2),
(173, 'App\\Models\\User', 3),
(173, 'App\\Models\\User', 4),
(174, 'App\\Models\\User', 3),
(175, 'App\\Models\\User', 1),
(175, 'App\\Models\\User', 2),
(175, 'App\\Models\\User', 3),
(175, 'App\\Models\\User', 4),
(176, 'App\\Models\\User', 1),
(176, 'App\\Models\\User', 2),
(176, 'App\\Models\\User', 3),
(176, 'App\\Models\\User', 4),
(177, 'App\\Models\\User', 1),
(177, 'App\\Models\\User', 2),
(177, 'App\\Models\\User', 3),
(177, 'App\\Models\\User', 4),
(178, 'App\\Models\\User', 3),
(179, 'App\\Models\\User', 1),
(179, 'App\\Models\\User', 2),
(179, 'App\\Models\\User', 3),
(179, 'App\\Models\\User', 4),
(180, 'App\\Models\\User', 1),
(180, 'App\\Models\\User', 2),
(180, 'App\\Models\\User', 3),
(180, 'App\\Models\\User', 4);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view contact', 'web', '2022-01-04 22:18:19', '2022-01-04 22:18:19'),
(2, 'view_all contact', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(3, 'edit contact', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(4, 'delete contact', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(5, 'view company', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(6, 'view_all company', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(7, 'edit company', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(8, 'delete company', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(9, 'view chart_of_section', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(10, 'view_all chart_of_section', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(11, 'edit chart_of_section', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(12, 'delete chart_of_section', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(13, 'view chart_of_group', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(14, 'view_all chart_of_group', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(15, 'edit chart_of_group', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(16, 'delete chart_of_group', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(17, 'view chart_of_account', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(18, 'view_all chart_of_account', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(19, 'edit chart_of_account', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(20, 'delete chart_of_account', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(21, 'view vat', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(22, 'view_all vat', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(23, 'edit vat', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(24, 'delete vat', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(25, 'view currency', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(26, 'view_all currency', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(27, 'edit currency', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(28, 'delete currency', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(29, 'view financial_year', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(30, 'view_all financial_year', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(31, 'edit financial_year', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(32, 'delete financial_year', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(33, 'view invoice_setting', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(34, 'view_all invoice_setting', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(35, 'edit invoice_setting', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(36, 'delete invoice_setting', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(37, 'view branch', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(38, 'view_all branch', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(39, 'edit branch', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(40, 'delete branch', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(41, 'view tag', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(42, 'view_all tag', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(43, 'edit tag', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(44, 'delete tag', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(45, 'view warehouse', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(46, 'view_all warehouse', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(47, 'edit warehouse', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(48, 'delete warehouse', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(49, 'view entry_type', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(50, 'view_all entry_type', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(51, 'edit entry_type', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(52, 'delete entry_type', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(53, 'view category', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(54, 'view_all category', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(55, 'edit category', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(56, 'delete category', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(57, 'view unit', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(58, 'view_all unit', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(59, 'edit unit', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(60, 'delete unit', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(61, 'view brand', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(62, 'view_all brand', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(63, 'edit brand', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(64, 'delete brand', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(65, 'view item', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(66, 'view_all item', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(67, 'edit item', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(68, 'delete item', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(69, 'view service_name', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(70, 'view_all service_name', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(71, 'edit service_name', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(72, 'delete service_name', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(73, 'view purchase', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(74, 'view_all purchase', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(75, 'edit purchase', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(76, 'delete purchase', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(77, 'view sale', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(78, 'view_all sale', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(79, 'edit sale', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(80, 'delete sale', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(81, 'view quotation', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(82, 'view_all quotation', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(83, 'edit quotation', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(84, 'delete quotation', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(85, 'view requisition', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(86, 'view_all requisition', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(87, 'edit requisition', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(88, 'delete requisition', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(89, 'view customer_payment', 'web', '2022-01-04 22:18:20', '2022-01-04 22:18:20'),
(90, 'view_all customer_payment', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(91, 'edit customer_payment', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(92, 'delete customer_payment', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(93, 'view supplier_payment', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(94, 'view_all supplier_payment', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(95, 'edit supplier_payment', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(96, 'delete supplier_payment', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(97, 'view receipt', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(98, 'view_all receipt', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(99, 'edit receipt', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(100, 'delete receipt', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(101, 'view bank_reconsilation', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(102, 'view_all bank_reconsilation', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(103, 'edit bank_reconsilation', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(104, 'delete bank_reconsilation', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(105, 'view general_ledger_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(106, 'view_all general_ledger_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(107, 'edit general_ledger_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(108, 'delete general_ledger_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(109, 'view receivable_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(110, 'view_all receivable_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(111, 'edit receivable_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(112, 'delete receivable_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(113, 'view payable_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(114, 'view_all payable_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(115, 'edit payable_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(116, 'delete payable_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(117, 'view stock_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(118, 'view_all stock_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(119, 'edit stock_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(120, 'delete stock_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(121, 'view low_stock_alert_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(122, 'view_all low_stock_alert_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(123, 'edit low_stock_alert_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(124, 'delete low_stock_alert_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(125, 'view sale_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(126, 'view_all sale_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(127, 'edit sale_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(128, 'delete sale_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(129, 'view sale_detail_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(130, 'view_all sale_detail_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(131, 'edit sale_detail_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(132, 'delete sale_detail_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(133, 'view customer_ledger_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(134, 'view_all customer_ledger_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(135, 'edit customer_ledger_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(136, 'delete customer_ledger_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(137, 'view purchase_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(138, 'view_all purchase_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(139, 'edit purchase_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(140, 'delete purchase_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(141, 'view purchase_detail_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(142, 'view_all purchase_detail_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(143, 'edit purchase_detail_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(144, 'delete purchase_detail_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(145, 'view supplier_ledger_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(146, 'view_all supplier_ledger_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(147, 'edit supplier_ledger_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(148, 'delete supplier_ledger_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(149, 'view profit_loss_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(150, 'view_all profit_loss_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(151, 'edit profit_loss_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(152, 'delete profit_loss_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(153, 'view income_statement_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(154, 'view_all income_statement_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(155, 'edit income_statement_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(156, 'delete income_statement_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(157, 'view day_book_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(158, 'view_all day_book_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(159, 'edit day_book_report', 'web', '2022-01-04 22:18:21', '2022-01-04 22:18:21'),
(160, 'delete day_book_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(161, 'view bank_book_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(162, 'view_all bank_book_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(163, 'edit bank_book_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(164, 'delete bank_book_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(165, 'view trial_balance_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(166, 'view_all trial_balance_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(167, 'edit trial_balance_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(168, 'delete trial_balance_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(169, 'view balance_sheet_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(170, 'view_all balance_sheet_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(171, 'edit balance_sheet_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(172, 'delete balance_sheet_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(173, 'view vat_collection_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(174, 'view_all vat_collection_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(175, 'edit vat_collection_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(176, 'delete vat_collection_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(177, 'view vat_return_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(178, 'view_all vat_return_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(179, 'edit vat_return_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22'),
(180, 'delete vat_return_report', 'web', '2022-01-04 22:18:22', '2022-01-04 22:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `permission_categories`
--

CREATE TABLE `permission_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_categories`
--

INSERT INTO `permission_categories` (`id`, `title`, `name`, `type`, `status`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Contact', 'contact', 'ba', 'Active', 1, '2022-01-04 22:18:19', '2022-01-04 22:18:19', NULL),
(2, 'Create Company', 'company', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(3, 'Chart Of Section', 'chart_of_section', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(4, 'Chart Of Group', 'chart_of_group', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(5, 'Chart Of Account', 'chart_of_account', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(6, 'Vat', 'vat', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(7, 'Currency', 'currency', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(8, 'Financial Year', 'financial_year', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(9, 'Invoice Setting', 'invoice_setting', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(10, 'Branch', 'branch', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(11, 'Tag', 'tag', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(12, 'Warehouse', 'warehouse', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(13, 'Entry Type', 'entry_type', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(14, 'Category', 'category', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(15, 'Unit', 'unit', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(16, 'Brand', 'brand', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(17, 'Item', 'item', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(18, 'Service Name', 'service_name', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(19, 'Purchase', 'purchase', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(20, 'Sale', 'sale', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(21, 'Quotation', 'quotation', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(22, 'Requisition', 'requisition', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(23, 'Customer Payment', 'customer_payment', 'ba', 'Active', 1, '2022-01-04 22:18:20', '2022-01-04 22:18:20', NULL),
(24, 'Supplier Payment', 'supplier_payment', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(25, 'Receipt', 'receipt', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(26, 'Bank Reconsilation', 'bank_reconsilation', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(27, 'General Ledger Report', 'general_ledger_report', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(28, 'Receivable Report', 'receivable_report', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(29, 'Payable Report', 'payable_report', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(30, 'Stock Report', 'stock_report', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(31, 'Low Stock Alert Report', 'low_stock_alert_report', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(32, 'Sale Report', 'sale_report', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(33, 'Sale Detail Report', 'sale_detail_report', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(34, 'Customer Ledger Report', 'customer_ledger_report', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(35, 'Purchase Report', 'purchase_report', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(36, 'Purchase Detail Report', 'purchase_detail_report', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(37, 'Supplier Ledger Report', 'supplier_ledger_report', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(38, 'Profit Loss Report', 'profit_loss_report', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(39, 'Income Statement Report', 'income_statement_report', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(40, 'Day Book Report', 'day_book_report', 'ba', 'Active', 1, '2022-01-04 22:18:21', '2022-01-04 22:18:21', NULL),
(41, 'Bank Book Report', 'bank_book_report', 'ba', 'Active', 1, '2022-01-04 22:18:22', '2022-01-04 22:18:22', NULL),
(42, 'Trial Balance Report', 'trial_balance_report', 'ba', 'Active', 1, '2022-01-04 22:18:22', '2022-01-04 22:18:22', NULL),
(43, 'Balance Sheet Report', 'balance_sheet_report', 'ba', 'Active', 1, '2022-01-04 22:18:22', '2022-01-04 22:18:22', NULL),
(44, 'Vat Collection Report', 'vat_collection_report', 'ba', 'Active', 1, '2022-01-04 22:18:22', '2022-01-04 22:18:22', NULL),
(45, 'Vat Return Report', 'vat_return_report', 'ba', 'Active', 1, '2022-01-04 22:18:22', '2022-01-04 22:18:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profile_settings`
--

CREATE TABLE `profile_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trn_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profile_settings`
--

INSERT INTO `profile_settings` (`id`, `logo`, `profile_photo`, `business_name`, `name`, `email`, `mobile`, `telephone`, `trn_no`, `address`, `postal_code`, `city`, `country`, `website`, `user_id`, `company_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'M97b50YsEPqAHKRXwtV3fjEh4IuIZuNc9iCMRoWR.jpg', 'OJDtZTMi5c0osY4H2XMUhl8NENeK1u2WrYamn4zG.jpg', 'Amin Traders', 'Md. Iqbal Hossain', 'demo@gmail.com', '01408979487', '012325563', '4454', 'MMalibagh, Dhaka', '12345', 'Dhaka', 'BD', 'www.facebook.com', 1, NULL, '2022-01-21 22:35:43', '2022-02-15 02:00:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entry_type_id` tinyint(4) NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(20,2) DEFAULT 0.00,
  `contact_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_approved` timestamp NULL DEFAULT NULL,
  `checked_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_checked` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `date` datetime NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`id`, `entry_type_id`, `code`, `amount`, `contact_id`, `invoice_id`, `approved_id`, `is_approved`, `checked_id`, `is_checked`, `status`, `date`, `note`, `tag_id`, `user_id`, `branch_id`, `company_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'R001', 5000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-02-23 00:00:00', 'test', 1, 1, 1, 3, '2022-02-22 23:53:21', '2022-02-22 23:53:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'web', '2022-01-04 22:18:19', '2022-01-04 22:18:19'),
(2, 'admin', 'web', '2022-01-04 22:18:19', '2022-01-04 22:18:19'),
(3, 'user', 'web', '2022-01-04 22:18:19', '2022-01-04 22:18:19'),
(4, 'editor', 'web', '2022-01-04 22:18:19', '2022-01-04 22:18:19');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3nKVViOg7lyqi0sK8iyzHL9DEej7c7oRyGdPxxSR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:97.0) Gecko/20100101 Firefox/97.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMkNweHltVlpTSVZvaDQwdTcxbEI1ZEVodzlSUmk4Tm9WTkU5U2VpUiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NToiaHR0cDovLzEyNy4wLjAuMTo4MDI5L21lbWJlci9yZXBvcnRzL2RheS1ib29rIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAyOS9tZW1iZXIvcmVwb3J0cy9kYXktYm9vayI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1645953531),
('aXQbbPUndTDEdu7wws4RBmdUicfZ8HguQnV9p4Dc', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:97.0) Gecko/20100101 Firefox/97.0', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiSTU2RWUydlRUYk05aGN0TnRnSzdYMVE3SGp3elF6UEV5UDV5MUV4UCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjYxOiJodHRwOi8vMTI3LjAuMC4xOjgwMjkvbWVtYmVyL2FjY291bnRzLW1vZHVsZS9jdXN0b21lci1wYXltZW50Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJG9IS2MxU3ZOZ0NWLlJvU3F5cGpTV2U2Sm00VEhQRkRyaW9KSzdmWEo3VmFURDdPaXhqRzhpIjtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMCRvSEtjMVN2TmdDVi5Sb1NxeXBqU1dlNkptNFRIUEZEcmlvSks3ZlhKN1ZhVEQ3T2l4akc4aSI7fQ==', 1645954973),
('J9WuihOqVBmIlpV8XPe3EHXdlDVTSkynaYkzf9BB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:97.0) Gecko/20100101 Firefox/97.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVXpOTTN6akUwSWRObVhwdW5PRk55VFdpVXhSRWZ2N1hNdW1LSzA5ciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAyOS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1645953531);

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustments`
--

CREATE TABLE `stock_adjustments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `from_branch` bigint(20) DEFAULT NULL,
  `from_warehouse` bigint(20) DEFAULT NULL,
  `to_branch` bigint(20) DEFAULT NULL,
  `to_warehouse` bigint(20) DEFAULT NULL,
  `note` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('Transfer','Damage','Adjust') COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_managers`
--

CREATE TABLE `stock_managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `applicant_name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_opening_stock` tinyint(4) DEFAULT NULL,
  `flow` enum('In','Out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `warranty` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_price` double(20,4) DEFAULT NULL,
  `sale_price` double(20,4) DEFAULT NULL,
  `discount_percent` double(20,4) DEFAULT NULL,
  `discount_value` double(20,4) DEFAULT NULL,
  `vat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vat_subtotal` double(20,4) DEFAULT NULL,
  `purchase_subtotal` double(20,4) DEFAULT NULL,
  `sale_subtotal` double(20,4) DEFAULT NULL,
  `subtotal` double(20,4) DEFAULT NULL,
  `batch_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_no` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_managers`
--

INSERT INTO `stock_managers` (`id`, `code`, `date`, `applicant_name`, `passport_no`, `nationality`, `item_id`, `invoice_id`, `category_id`, `unit_id`, `contact_id`, `is_opening_stock`, `flow`, `warranty`, `serial`, `quantity`, `purchase_price`, `sale_price`, `discount_percent`, `discount_value`, `vat_id`, `vat_subtotal`, `purchase_subtotal`, `sale_subtotal`, `subtotal`, `batch_no`, `serial_no`, `expired_date`, `status`, `warehouse_id`, `user_id`, `branch_id`, `company_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'P001', '2022-01-22', NULL, NULL, NULL, 1, 4, 1, 1, 2, NULL, 'In', NULL, NULL, '100', 120.0000, 150.0000, NULL, NULL, 1, 1440.0000, 12000.0000, 15000.0000, 12000.0000, NULL, NULL, NULL, 1, NULL, 1, 1, NULL, '2022-01-21 23:12:44', '2022-01-21 23:12:44', NULL),
(2, 'SM002', '2022-01-22', NULL, NULL, NULL, 1, 5, 1, 1, 1, NULL, 'Out', NULL, NULL, '1', 120.0000, 150.0000, NULL, 0.0000, 1, 18.0000, 120.0000, 150.0000, 150.0000, NULL, NULL, NULL, 1, NULL, 1, 1, NULL, '2022-01-21 23:18:33', '2022-01-21 23:18:33', NULL),
(3, 'SM003', '2022-01-22', NULL, NULL, NULL, 1, 6, 1, 1, 1, NULL, 'Out', NULL, NULL, '1', 120.0000, 150.0000, NULL, 0.0000, 1, 18.0000, 120.0000, 150.0000, 150.0000, NULL, NULL, NULL, 1, NULL, 1, 1, NULL, '2022-01-21 23:19:12', '2022-01-21 23:19:12', NULL),
(4, 'SM004', '2022-01-22', NULL, NULL, NULL, 1, 7, 1, 1, 1, NULL, 'Out', NULL, NULL, '1', 120.0000, 150.0000, NULL, 0.0000, 1, 18.0000, 120.0000, 150.0000, 150.0000, NULL, NULL, NULL, 1, NULL, 1, 1, NULL, '2022-01-22 00:48:43', '2022-01-22 00:48:43', NULL),
(5, 'SM005', '2022-01-22', NULL, NULL, NULL, 1, 8, 1, 1, 1, NULL, 'Out', NULL, NULL, '1', 120.0000, 150.0000, NULL, 0.0000, 1, 18.0000, 120.0000, 150.0000, 150.0000, NULL, NULL, NULL, 1, NULL, 1, 1, NULL, '2022-01-22 00:48:59', '2022-01-22 00:48:59', NULL),
(6, 'SM006', '2022-01-22', NULL, NULL, NULL, 1, 9, 1, 1, 1, NULL, 'Out', NULL, NULL, '1', 120.0000, 150.0000, NULL, 0.0000, 1, 18.0000, 120.0000, 150.0000, 150.0000, NULL, NULL, NULL, 1, NULL, 1, 1, NULL, '2022-01-22 00:49:13', '2022-01-22 00:49:13', NULL),
(7, 'SM007', '2022-01-22', NULL, NULL, NULL, 1, 10, 1, 1, 1, NULL, 'Out', NULL, NULL, '1', 120.0000, 150.0000, NULL, 0.0000, 1, 18.0000, 120.0000, 150.0000, 150.0000, NULL, NULL, NULL, 1, NULL, 1, 1, NULL, '2022-01-22 00:49:26', '2022-01-22 00:49:26', NULL),
(8, 'SM008', '2022-01-22', NULL, NULL, NULL, 1, 11, 1, 1, 1, NULL, 'Out', NULL, NULL, '1', 120.0000, 150.0000, NULL, 0.0000, 1, 18.0000, 120.0000, 150.0000, 150.0000, NULL, NULL, NULL, 1, NULL, 1, 1, NULL, '2022-01-22 00:49:41', '2022-01-22 00:49:41', NULL),
(9, 'P012', '2022-02-02', NULL, NULL, 'Check', 1, 12, 1, 1, 2, NULL, 'In', NULL, NULL, '1', 120.0000, 150.0000, NULL, NULL, 1, 14.4000, 120.0000, 150.0000, 120.0000, NULL, NULL, NULL, 1, NULL, 1, 1, 1, '2022-02-01 23:28:34', '2022-02-01 23:28:34', NULL),
(10, 'SM011', '2022-02-02', 'Check', 'Check', 'Check', 1, 13, 1, 1, 1, NULL, 'Out', NULL, NULL, '1', 120.0000, 150.0000, NULL, 0.0000, 1, 18.0000, 120.0000, 150.0000, 150.0000, NULL, NULL, NULL, 1, NULL, 1, 1, 1, '2022-02-02 00:02:42', '2022-02-02 00:28:43', NULL),
(11, 'SM013', '2022-02-14', NULL, NULL, NULL, 2, 14, 2, 2, 7, 1, 'Out', NULL, NULL, '4', 451.6071, 11500.0000, NULL, 0.0000, 2, 4600.0000, 1806.4284, 46000.0000, 46000.0000, NULL, NULL, NULL, 1, NULL, 1, 1, 2, '2022-02-13 04:29:31', '2022-02-14 05:38:55', NULL),
(12, 'P013', '2022-02-14', NULL, NULL, NULL, 2, 13, 2, 2, 8, NULL, 'In', NULL, NULL, '3', 12500.0000, 11500.0000, NULL, NULL, 2, 3750.0000, 37500.0000, 34500.0000, 37500.0000, NULL, NULL, NULL, 1, NULL, 1, 1, 2, '2022-02-14 05:30:23', '2022-02-14 05:30:23', NULL),
(13, 'SM013', '2022-02-14', NULL, NULL, NULL, 2, 15, 2, 2, 7, NULL, 'In', NULL, NULL, '1', 451.6071, 11500.0000, NULL, NULL, 2, 1150.0000, 451.6071, 11500.0000, 11500.0000, NULL, NULL, NULL, 1, NULL, 1, 1, 2, '2022-02-14 06:19:01', '2022-02-14 06:19:01', NULL),
(14, 'P016', '2022-02-15', NULL, NULL, NULL, 2, 16, 2, 2, 8, NULL, 'In', NULL, NULL, '5', 12500.0000, 11500.0000, NULL, NULL, 2, 6250.0000, 62500.0000, 57500.0000, 62500.0000, NULL, NULL, NULL, 1, NULL, 1, 1, 2, '2022-02-15 01:56:52', '2022-02-15 01:56:52', NULL),
(15, 'SM015', '2022-02-15', NULL, NULL, NULL, 2, 17, 2, 2, 7, NULL, 'Out', NULL, NULL, '3', 949.4746, 11500.0000, NULL, 100.0000, 2, 3440.0000, 2848.4238, 34500.0000, 34500.0000, NULL, NULL, NULL, 1, NULL, 1, 1, 2, '2022-02-15 01:58:22', '2022-02-15 01:58:22', NULL),
(16, 'SM016', '2022-02-23', NULL, NULL, NULL, 2, 18, 2, 2, 8, NULL, 'Out', NULL, NULL, '1', 12500.0000, 11500.0000, NULL, NULL, 2, 1250.0000, 12500.0000, 11500.0000, 12500.0000, NULL, NULL, NULL, 1, NULL, 1, 1, 1, '2022-02-22 22:59:36', '2022-02-22 22:59:36', NULL),
(17, 'SM017', '2022-02-24', NULL, NULL, NULL, 2, 21, 2, 2, 3, NULL, 'Out', NULL, NULL, '1', 949.4746, 11500.0000, NULL, 0.0000, 2, 1150.0000, 949.4746, 11500.0000, 11500.0000, NULL, NULL, NULL, 1, NULL, 1, 1, 3, '2022-02-24 04:37:15', '2022-02-24 04:37:15', NULL),
(18, 'SM018', '2022-02-24', NULL, NULL, NULL, 2, 22, 2, 2, 3, NULL, 'Out', NULL, NULL, '5', 949.4746, 11500.0000, NULL, 0.0000, 2, 5750.0000, 4747.3730, 57500.0000, 57500.0000, NULL, NULL, NULL, 1, NULL, 1, 1, 3, '2022-02-24 04:49:51', '2022-02-24 04:49:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `code`, `name`, `user_id`, `branch_id`, `company_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'T001', 'test tag', 1, 1, 2, 1, '2022-02-13 04:02:30', '2022-02-13 04:02:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_team` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `user_id`, `name`, `personal_team`, `created_at`, `updated_at`) VALUES
(1, 1, 'Md.\'s Team', 1, '2022-01-04 22:19:14', '2022-01-04 22:19:14'),
(2, 4, 'test\'s Team', 1, '2022-02-14 02:25:05', '2022-02-14 02:25:05');

-- --------------------------------------------------------

--
-- Table structure for table `team_invitations`
--

CREATE TABLE `team_invitations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_user`
--

CREATE TABLE `team_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('Receive','Payment') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(20,2) DEFAULT 0.00,
  `chart_of_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_ids` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `note` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `date`, `code`, `codes`, `type`, `amount`, `chart_of_account_id`, `invoice_id`, `invoice_ids`, `contact_id`, `company_id`, `user_id`, `note`, `due_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2022-02-23 00:00:00', 'CP645598022', NULL, 'Receive', 0.00, 9, NULL, 14, 7, NULL, 1, NULL, NULL, '2022-02-23 00:33:57', '2022-02-23 00:33:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double(20,4) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `code`, `name`, `rate`, `user_id`, `branch_id`, `company_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'U001', 'Kg', NULL, 1, NULL, NULL, 1, '2022-01-21 22:24:32', '2022-01-21 22:24:32', NULL),
(2, 'U002', 'test', NULL, 1, 1, 2, 1, '2022-02-13 04:22:05', '2022-02-13 04:22:05', NULL),
(3, 'U003', 'test three', NULL, 1, 1, 2, 1, '2022-02-13 04:23:11', '2022-02-13 04:23:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `branch_id`, `company_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Md. Iqbal Hossain', '01408979487', 'admin@admin.com', NULL, '$2y$10$oHKc1SvNgCV.RoSqypjSWe6Jm4THPFDrioJK7fXJ7VaTD7OixjG8i', NULL, NULL, NULL, NULL, NULL, 1, 2, 1, '2022-01-04 22:19:14', '2022-02-27 03:18:33'),
(2, 'test', '12345678', 'test@gmail.com', NULL, '$2y$10$Buy/gBidc9SCCDu5xkyXJOd7/SlyY9XF2Fy28HEfMILMGJOQhR4TS', NULL, NULL, NULL, 1, NULL, 1, 3, 1, '2022-02-12 07:26:39', '2022-02-23 05:37:21'),
(3, 'kasem', '123456789', 'kasem@gmail.com', NULL, '$2y$10$BJ7g8M4xCHRb1KGpLXUagO35n3tyNZHGsaXbaMuNR1SrcYJLWr.qG', NULL, NULL, NULL, 1, NULL, 1, 2, 1, '2022-02-13 23:05:32', '2022-02-13 23:05:32'),
(4, 'test', '123456789', 'test@test.com', NULL, '$2y$10$Zk00prZRmGMod6FWPR8qOunOUgdXOkIDiShVSZOJux60w3MYn4tkG', NULL, NULL, NULL, NULL, NULL, 1, 3, 1, '2022-02-14 02:25:05', '2022-02-14 04:40:04');

-- --------------------------------------------------------

--
-- Table structure for table `vats`
--

CREATE TABLE `vats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate_percent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate_fixed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vats`
--

INSERT INTO `vats` (`id`, `code`, `name`, `rate_percent`, `rate_fixed`, `user_id`, `branch_id`, `company_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'V001', 'Vat', '12', '233', 1, NULL, NULL, 1, '2022-01-21 22:25:30', '2022-01-21 22:25:30', NULL),
(2, 'V002', 'test', '10', '10', 1, 1, 2, 1, '2022-02-13 04:28:30', '2022-02-13 04:28:30', NULL),
(3, 'V003', 'test40', '10', '10', 1, 1, 2, 1, '2022-02-13 22:17:52', '2022-02-13 22:17:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `code`, `name`, `address`, `user_id`, `branch_id`, `company_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'W001', 'test warehouse', 'Dhaka', 1, 1, 1, 1, '2022-02-12 23:59:22', '2022-02-12 23:59:22', NULL),
(2, 'W002', 'test ware house', 'Dhaka', 1, 1, 2, 1, '2022-02-13 04:07:16', '2022-02-13 04:07:16', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_managers`
--
ALTER TABLE `account_managers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_managers_invoice_id_foreign` (`invoice_id`),
  ADD KEY `account_managers_contact_id_foreign` (`contact_id`),
  ADD KEY `account_managers_user_id_foreign` (`user_id`),
  ADD KEY `account_managers_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brands_user_id_foreign` (`user_id`),
  ADD KEY `brands_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_user_id_foreign` (`user_id`),
  ADD KEY `categories_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chart_of_accounts_user_id_foreign` (`user_id`);

--
-- Indexes for table `chart_of_groups`
--
ALTER TABLE `chart_of_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chart_of_groups_user_id_foreign` (`user_id`);

--
-- Indexes for table `chart_of_sections`
--
ALTER TABLE `chart_of_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chart_of_sections_user_id_foreign` (`user_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_infos`
--
ALTER TABLE `company_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_user_id_foreign` (`user_id`),
  ADD KEY `contacts_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currencies_user_id_foreign` (`user_id`),
  ADD KEY `currencies_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `entry_types`
--
ALTER TABLE `entry_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entry_type_account_lists`
--
ALTER TABLE `entry_type_account_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financial_years`
--
ALTER TABLE `financial_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_contact_id_foreign` (`contact_id`),
  ADD KEY `invoices_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `invoices_user_id_foreign` (`user_id`),
  ADD KEY `invoices_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_settings_currency_id_foreign` (`currency_id`),
  ADD KEY `invoice_settings_user_id_foreign` (`user_id`),
  ADD KEY `invoice_settings_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `items_category_id_foreign` (`category_id`),
  ADD KEY `items_brand_id_foreign` (`brand_id`),
  ADD KEY `items_unit_id_foreign` (`unit_id`),
  ADD KEY `items_vat_id_foreign` (`vat_id`),
  ADD KEY `items_user_id_foreign` (`user_id`),
  ADD KEY `items_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `item_invoices`
--
ALTER TABLE `item_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_invoices_item_id_foreign` (`item_id`),
  ADD KEY `item_invoices_invoice_id_foreign` (`invoice_id`),
  ADD KEY `item_invoices_category_id_foreign` (`category_id`),
  ADD KEY `item_invoices_unit_id_foreign` (`unit_id`),
  ADD KEY `item_invoices_contact_id_foreign` (`contact_id`),
  ADD KEY `item_invoices_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `item_invoices_user_id_foreign` (`user_id`),
  ADD KEY `item_invoices_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `permission_categories`
--
ALTER TABLE `permission_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `profile_settings`
--
ALTER TABLE `profile_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_settings_user_id_foreign` (`user_id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_adjustments_user_id_foreign` (`user_id`),
  ADD KEY `stock_adjustments_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `stock_managers`
--
ALTER TABLE `stock_managers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_managers_item_id_foreign` (`item_id`),
  ADD KEY `stock_managers_invoice_id_foreign` (`invoice_id`),
  ADD KEY `stock_managers_category_id_foreign` (`category_id`),
  ADD KEY `stock_managers_unit_id_foreign` (`unit_id`),
  ADD KEY `stock_managers_contact_id_foreign` (`contact_id`),
  ADD KEY `stock_managers_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `stock_managers_user_id_foreign` (`user_id`),
  ADD KEY `stock_managers_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tags_user_id_foreign` (`user_id`),
  ADD KEY `tags_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_user_id_index` (`user_id`);

--
-- Indexes for table `team_invitations`
--
ALTER TABLE `team_invitations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `team_invitations_team_id_email_unique` (`team_id`,`email`);

--
-- Indexes for table `team_user`
--
ALTER TABLE `team_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `team_user_team_id_user_id_unique` (`team_id`,`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `types_name_unique` (`name`),
  ADD UNIQUE KEY `types_alias_unique` (`alias`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `units_user_id_foreign` (`user_id`),
  ADD KEY `units_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `vats`
--
ALTER TABLE `vats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vats_user_id_foreign` (`user_id`),
  ADD KEY `vats_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warehouses_user_id_foreign` (`user_id`),
  ADD KEY `warehouses_branch_id_foreign` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_managers`
--
ALTER TABLE `account_managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `chart_of_groups`
--
ALTER TABLE `chart_of_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `chart_of_sections`
--
ALTER TABLE `chart_of_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company_infos`
--
ALTER TABLE `company_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `entry_types`
--
ALTER TABLE `entry_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `entry_type_account_lists`
--
ALTER TABLE `entry_type_account_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `financial_years`
--
ALTER TABLE `financial_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `item_invoices`
--
ALTER TABLE `item_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `permission_categories`
--
ALTER TABLE `permission_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profile_settings`
--
ALTER TABLE `profile_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_managers`
--
ALTER TABLE `stock_managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `team_invitations`
--
ALTER TABLE `team_invitations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_user`
--
ALTER TABLE `team_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vats`
--
ALTER TABLE `vats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_managers`
--
ALTER TABLE `account_managers`
  ADD CONSTRAINT `account_managers_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `account_managers_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`),
  ADD CONSTRAINT `account_managers_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`),
  ADD CONSTRAINT `account_managers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `brands_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  ADD CONSTRAINT `chart_of_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chart_of_groups`
--
ALTER TABLE `chart_of_groups`
  ADD CONSTRAINT `chart_of_groups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chart_of_sections`
--
ALTER TABLE `chart_of_sections`
  ADD CONSTRAINT `chart_of_sections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `currencies`
--
ALTER TABLE `currencies`
  ADD CONSTRAINT `currencies_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `currencies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `invoices_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`),
  ADD CONSTRAINT `invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `invoices_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  ADD CONSTRAINT `invoice_settings_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `invoice_settings_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `invoice_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `items_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `items_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `items_vat_id_foreign` FOREIGN KEY (`vat_id`) REFERENCES `vats` (`id`);

--
-- Constraints for table `item_invoices`
--
ALTER TABLE `item_invoices`
  ADD CONSTRAINT `item_invoices_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `item_invoices_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `item_invoices_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`),
  ADD CONSTRAINT `item_invoices_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`),
  ADD CONSTRAINT `item_invoices_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `item_invoices_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `item_invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `item_invoices_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profile_settings`
--
ALTER TABLE `profile_settings`
  ADD CONSTRAINT `profile_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  ADD CONSTRAINT `stock_adjustments_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `stock_adjustments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `tags_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `team_invitations`
--
ALTER TABLE `team_invitations`
  ADD CONSTRAINT `team_invitations_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `units_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`);

--
-- Constraints for table `vats`
--
ALTER TABLE `vats`
  ADD CONSTRAINT `vats_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `vats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD CONSTRAINT `warehouses_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `warehouses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
