-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql-server
-- Generation Time: May 14, 2025 at 09:17 AM
-- Server version: 8.0.41
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vipassana`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `answer_id` int NOT NULL,
  `evaluation_id` int DEFAULT NULL,
  `question_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `answer_value` text NOT NULL,
  `response_type` enum('rating','text') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificate`
--

CREATE TABLE `certificate` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `certificate`
--

INSERT INTO `certificate` (`id`, `user_id`, `name`, `created_at`) VALUES
(2, 2, 'พิชยะ สารเถื่อนแก้ว', '2025-03-24 02:51:15');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `thread_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `thread_id`, `user_id`, `content`, `created_at`) VALUES
(4, NULL, 1, 'ใต้ต้นโพธิ์', '2025-02-18 16:59:53'),
(5, NULL, 1, 'ใต้ต้นโพธิ์', '2025-02-18 17:00:10'),
(9, 2, 1, 'ที่ต่างประเทศ', '2025-03-01 15:20:12');

-- --------------------------------------------------------

--
-- Table structure for table `educationlevels`
--

CREATE TABLE `educationlevels` (
  `id` int NOT NULL,
  `education` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `educationlevels`
--

INSERT INTO `educationlevels` (`id`, `education`, `created_at`) VALUES
(1, 'ประถมศึกษา', '2025-02-03 08:19:52'),
(2, 'มัธยมศึกษาตอนต้น', '2025-02-03 08:19:52'),
(3, 'มัธยมศึกษาตอนปลาย', '2025-02-03 08:19:52'),
(4, 'ปริญญาตรี', '2025-02-03 08:19:52'),
(5, 'ปริญญาโท', '2025-02-03 08:19:52'),
(6, 'ปริญญาเอก', '2025-02-03 08:19:52');

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

CREATE TABLE `evaluations` (
  `evaluation_id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `evaluations`
--

INSERT INTO `evaluations` (`evaluation_id`, `name`, `description`) VALUES
(1, 'แบบประเมินทั่วไป', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `lesson_id` int NOT NULL,
  `lesson_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lesson_file` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ใช้เก็บไฟล์ PDF ที่เป็นเนื้อหา',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`lesson_id`, `lesson_title`, `lesson_file`, `created_at`, `update_at`) VALUES
(10, 'ประวัติพระพุทธศาสนา', 'ประวัติพระพุทธศาสนา.pdf', '2025-05-05 05:47:30', '2025-05-05 05:47:30'),
(11, 'ประวัติพระพุทธเจ้า', 'ประวัติพระพุทธเจ้า.pdf', '2025-05-05 07:08:16', '2025-05-05 07:08:16'),
(12, 'ทำไมเราต้องปฏิบัติวิปัสสนากรรมฐาน', 'ทำไมเราต้องปฏิบัติธรรม.pdf', '2025-05-05 07:08:50', '2025-05-05 07:08:50'),
(13, 'หัวใจสำคัญของการปฏิบัติ', 'หัวใจสำคัญของการปฏิบัติ.pdf', '2025-05-05 07:09:10', '2025-05-05 07:09:10'),
(14, 'อนิสงส์ของการปฏิบัติธรรม', 'อานิสงส์ของการปฏิบัติธรรม.pdf', '2025-05-05 07:09:30', '2025-05-06 09:27:45'),
(15, 'ทดสอบ', 'อานิสงส์ของการปฏิบัติธรรม.pdf', '2025-05-14 07:31:55', '2025-05-14 07:31:55');

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `status` enum('success','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `device_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `error_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `login_time` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_logs`
--

INSERT INTO `login_logs` (`id`, `user_id`, `status`, `ip_address`, `device_info`, `error_message`, `login_time`) VALUES
(26, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:134.0) Gecko/20100101 Firefox/134.0', NULL, '2025-02-04 09:38:21'),
(27, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:134.0) Gecko/20100101 Firefox/134.0', NULL, '2025-02-04 09:39:10'),
(28, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-04 09:40:58'),
(29, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-04 09:42:33'),
(30, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:134.0) Gecko/20100101 Firefox/134.0', 'Invalid email or username', '2025-02-04 09:45:03'),
(31, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:134.0) Gecko/20100101 Firefox/134.0', NULL, '2025-02-04 09:45:16'),
(32, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:134.0) Gecko/20100101 Firefox/134.0', NULL, '2025-02-04 09:48:46'),
(33, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:134.0) Gecko/20100101 Firefox/134.0', NULL, '2025-02-04 10:46:36'),
(35, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-04 10:52:49'),
(36, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:134.0) Gecko/20100101 Firefox/134.0', NULL, '2025-02-04 10:56:51'),
(38, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:134.0) Gecko/20100101 Firefox/134.0', NULL, '2025-02-04 11:03:37'),
(40, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:134.0) Gecko/20100101 Firefox/134.0', NULL, '2025-02-04 11:06:33'),
(42, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:134.0) Gecko/20100101 Firefox/134.0', NULL, '2025-02-04 14:48:20'),
(43, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-05 14:41:57'),
(44, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-06 06:14:02'),
(45, 1, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'Invalid password', '2025-02-06 11:16:32'),
(46, 1, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'Invalid password', '2025-02-06 11:16:43'),
(47, 1, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'Invalid password', '2025-02-06 11:16:53'),
(48, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-06 11:17:46'),
(49, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-06 13:52:17'),
(50, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-07 16:37:06'),
(51, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-08 16:03:35'),
(52, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-09 08:25:32'),
(53, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'Invalid email or username', '2025-02-09 11:30:47'),
(54, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'Invalid email or username', '2025-02-09 11:31:18'),
(55, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'Invalid email or username', '2025-02-09 11:31:34'),
(56, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'Invalid email or username', '2025-02-09 11:31:48'),
(57, 2, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'Invalid password', '2025-02-09 13:00:02'),
(58, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-09 13:00:07'),
(59, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-09 13:04:13'),
(60, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'Invalid email or username', '2025-02-09 13:34:55'),
(61, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-09 13:35:29'),
(62, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-09 17:45:23'),
(63, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-09 17:50:26'),
(64, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-09 18:03:50'),
(65, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-09 18:04:18'),
(66, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-09 18:16:54'),
(67, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-09 18:19:34'),
(68, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-09 18:30:25'),
(69, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-09 18:33:00'),
(70, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-09 18:49:00'),
(71, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-09 19:12:16'),
(72, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-09 19:16:34'),
(73, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-09 19:20:50'),
(74, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-09 19:20:55'),
(75, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-09 19:24:34'),
(76, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-09 19:25:26'),
(77, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-09 19:26:49'),
(78, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-09 19:27:58'),
(79, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-09 19:49:21'),
(80, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-10 06:30:05'),
(81, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-10 06:31:01'),
(82, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-10 06:52:57'),
(83, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-10 06:54:41'),
(84, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-10 08:28:46'),
(85, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-10 08:31:43'),
(86, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-10 08:36:18'),
(87, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-10 08:46:26'),
(88, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-10 09:31:55'),
(89, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-10 09:34:15'),
(90, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-10 09:34:37'),
(91, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-10 11:05:28'),
(92, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-10 11:37:13'),
(93, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-11 08:32:47'),
(94, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-11 08:34:14'),
(95, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-11 09:59:13'),
(96, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-11 10:00:43'),
(97, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-11 17:20:28'),
(98, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-11 18:00:27'),
(99, 1, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'Invalid password', '2025-02-12 06:18:25'),
(100, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-12 06:18:36'),
(101, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-12 06:19:46'),
(102, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-02-13 09:55:41'),
(103, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-02-13 09:56:36'),
(104, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'อีเมลหรือรหัสผ่าน ไม่ถูกต้อง!', '2025-02-13 09:56:48'),
(105, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-13 09:56:52'),
(106, 2, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'รหัสผ่านไม่ถูกต้อง!', '2025-02-13 09:57:37'),
(107, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-13 10:18:02'),
(108, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-13 11:44:09'),
(109, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-13 13:31:45'),
(110, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-13 13:50:54'),
(111, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-13 15:53:45'),
(112, 1, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'รหัสผ่านไม่ถูกต้อง!', '2025-02-13 16:21:06'),
(113, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-13 16:21:15'),
(114, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-13 23:27:16'),
(115, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-14 03:19:08'),
(116, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-14 07:53:04'),
(117, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-14 09:05:37'),
(118, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-15 15:11:52'),
(119, 1, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'รหัสผ่านไม่ถูกต้อง!', '2025-02-18 13:37:11'),
(120, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-18 13:37:27'),
(121, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-18 15:47:40'),
(122, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-18 17:33:34'),
(123, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-18 17:34:06'),
(124, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-19 07:13:23'),
(125, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, '2025-02-19 07:21:16'),
(126, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Linux; Android 11; SAMSUNG SM-G973U) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/14.2 Chrome/87.0.4280.141 Mobile Safari/537.36', NULL, '2025-02-21 10:19:56'),
(127, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', NULL, '2025-02-21 11:47:26'),
(128, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-22 08:39:00'),
(129, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-22 15:52:24'),
(130, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-22 15:55:12'),
(131, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', NULL, '2025-02-23 13:55:17'),
(132, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', NULL, '2025-02-23 18:34:09'),
(133, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', NULL, '2025-02-23 18:34:20'),
(134, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-23 19:15:36'),
(135, 9, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-23 19:16:39'),
(136, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-23 19:17:16'),
(137, 9, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-23 19:18:29'),
(138, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-23 19:19:54'),
(139, 9, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-23 19:25:20'),
(140, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-23 19:34:54'),
(141, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'อีเมลหรือรหัสผ่าน ไม่ถูกต้อง!', '2025-02-24 07:41:36'),
(142, 10, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-24 07:41:45'),
(143, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-24 08:02:28'),
(144, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'อีเมลหรือรหัสผ่าน ไม่ถูกต้อง!', '2025-02-24 08:03:51'),
(145, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'อีเมลหรือรหัสผ่าน ไม่ถูกต้อง!', '2025-02-24 08:03:59'),
(146, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'อีเมลหรือรหัสผ่าน ไม่ถูกต้อง!', '2025-02-24 08:04:09'),
(147, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'อีเมลหรือรหัสผ่าน ไม่ถูกต้อง!', '2025-02-24 08:04:17'),
(148, 9, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-24 08:04:28'),
(149, 2, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'รหัสผ่านไม่ถูกต้อง!', '2025-02-24 08:52:23'),
(150, 2, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'รหัสผ่านไม่ถูกต้อง!', '2025-02-24 08:52:32'),
(151, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-24 16:48:35'),
(152, 9, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-24 18:04:36'),
(153, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-24 18:05:48'),
(154, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-25 03:44:01'),
(155, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-25 15:33:35'),
(156, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-25 16:32:57'),
(157, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'อีเมลหรือรหัสผ่าน ไม่ถูกต้อง!', '2025-02-26 08:20:43'),
(158, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-26 08:20:53'),
(159, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', NULL, '2025-02-26 08:55:11'),
(160, 2, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'รหัสผ่านไม่ถูกต้อง!', '2025-02-26 09:11:17'),
(161, 2, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'รหัสผ่านไม่ถูกต้อง!', '2025-02-26 09:11:29'),
(162, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-02-26 09:17:17'),
(163, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-03-01 12:00:47'),
(164, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-03-01 12:00:55'),
(165, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-03-01 12:13:18'),
(166, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-03-01 12:13:21'),
(167, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-03-01 14:17:32'),
(168, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-03-01 14:46:43'),
(169, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-03-01 14:46:47'),
(170, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-03-01 14:54:53'),
(171, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-03-01 14:56:24'),
(172, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-03-01 14:56:35'),
(173, 1, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-03-01 15:13:22'),
(174, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-03-01 15:13:28'),
(175, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-03-03 05:39:44'),
(176, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-03-04 06:35:02'),
(177, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:135.0) Gecko/20100101 Firefox/135.0', NULL, '2025-03-08 07:40:53'),
(178, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-10 08:25:05'),
(179, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-11 15:48:20'),
(180, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-18 12:55:31'),
(181, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-20 13:43:16'),
(182, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-20 14:13:38'),
(183, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-20 15:11:42'),
(184, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-03-20 15:52:30'),
(185, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-20 15:52:32'),
(186, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-21 06:16:27'),
(187, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-03-23 13:54:10'),
(188, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-03-23 13:56:19'),
(189, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-03-23 14:05:22'),
(190, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-03-23 14:07:02'),
(191, NULL, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-03-23 14:07:25'),
(192, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-23 16:11:42'),
(193, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-23 16:23:09'),
(194, 11, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-24 02:40:20'),
(195, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-24 02:48:28'),
(196, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-24 02:52:50'),
(197, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-24 03:03:14'),
(198, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-24 08:03:05'),
(199, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-24 09:43:47'),
(200, 11, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-24 09:47:19'),
(201, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-24 09:47:29'),
(202, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-24 17:16:54'),
(203, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-24 19:24:13'),
(204, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-25 09:21:06'),
(205, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-26 17:05:29'),
(206, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-26 17:05:44'),
(207, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-27 00:56:17'),
(208, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-27 01:05:34'),
(209, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-27 12:57:13'),
(210, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-27 14:03:49'),
(211, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-28 13:43:22'),
(212, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-28 13:43:29'),
(213, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-28 14:43:35'),
(214, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-28 14:43:44'),
(216, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', NULL, '2025-03-31 03:49:45'),
(217, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-03-31 04:14:08'),
(218, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-04-02 12:19:26'),
(219, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-04-02 12:50:01'),
(220, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-04-02 13:14:41'),
(221, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-04-02 13:15:30'),
(222, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-04-02 14:51:14'),
(223, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-04-03 13:41:48'),
(224, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-04-03 13:42:54'),
(225, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-04-03 14:13:33'),
(226, 11, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-04-03 15:26:07'),
(227, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0', NULL, '2025-04-03 15:30:01'),
(228, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-04-04 12:28:09'),
(229, 11, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-04-06 15:53:13'),
(230, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-04-06 16:14:00'),
(231, 1, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-04-08 07:14:27'),
(232, 1, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-04-08 07:14:40'),
(233, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', NULL, '2025-04-08 07:14:59'),
(234, 1, 'failed', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', 'อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!', '2025-04-09 07:08:26'),
(235, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-04-09 07:08:46'),
(236, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-04-25 15:37:11'),
(237, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-04-26 14:35:21'),
(238, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-05-02 10:07:28'),
(239, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-05-02 10:09:33'),
(240, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-05-02 12:35:03'),
(241, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', NULL, '2025-05-02 12:36:06'),
(242, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-05-02 16:04:56'),
(243, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-05-02 16:05:06'),
(244, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-05-02 16:21:54'),
(245, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_4_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/135.0.7049.83 Mobile/15E148 Safari/604.1', NULL, '2025-05-02 17:19:41'),
(246, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-05-03 03:01:54'),
(247, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-05-03 03:08:07'),
(248, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-05-03 03:47:38'),
(249, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-05-03 05:19:51'),
(250, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-05-03 05:19:58'),
(251, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-05-03 08:12:32'),
(252, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-05-03 09:04:30'),
(253, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-05-03 09:05:07'),
(254, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', NULL, '2025-05-03 09:05:33'),
(255, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-03 09:17:32'),
(256, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-03 09:22:10'),
(257, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-05 05:11:08'),
(258, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-05 05:11:27'),
(259, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-05 05:14:53'),
(260, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-05 05:18:49'),
(261, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-05 05:47:45'),
(262, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-05 06:53:11'),
(263, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-05 06:55:36'),
(264, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-05 07:07:50'),
(265, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-05 07:09:45'),
(266, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-05 07:14:20'),
(267, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-05 07:30:19'),
(268, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-05 07:55:59'),
(269, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-05 07:56:05'),
(270, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-05 08:19:02'),
(271, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-05 08:19:43'),
(272, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-06 06:10:57'),
(273, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-06 08:40:13'),
(274, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-07 06:37:57'),
(275, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', NULL, '2025-05-07 06:42:54'),
(276, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-07 07:24:58'),
(277, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-08 06:49:47'),
(278, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-08 06:50:01'),
(279, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-08 08:23:56'),
(280, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-08 08:37:38'),
(281, 2, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-08 08:41:03'),
(282, 1, 'success', '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', NULL, '2025-05-14 05:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `practice`
--

CREATE TABLE `practice` (
  `practice_id` int NOT NULL,
  `practice_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `video_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `duration` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `practice`
--

INSERT INTO `practice` (`practice_id`, `practice_title`, `video_url`, `duration`, `created_at`, `update_at`) VALUES
(16, 'ญาณที่ 1 นามรูปปริจเฉทญาณ', 'https://www.youtube.com/watch?v=iku_uZoAQZk', 411, '2025-05-07 06:43:13', '2025-05-07 06:43:13'),
(17, 'ญาณที่ 2 ปัจจัย-ปริคคหญาณ', 'https://www.youtube.com/watch?v=FsmeIUqSfMY', 158, '2025-05-07 06:55:31', '2025-05-07 06:55:31'),
(18, 'ญาณที่ 3 สัมมสนญาณ', 'https://www.youtube.com/watch?v=vV2SQGEJswc', 48, '2025-05-07 06:55:52', '2025-05-07 06:55:52'),
(19, 'ญาณที 4 อุทยัพพยญาน', 'https://www.youtube.com/watch?v=PfTBps_Lmac', 95, '2025-05-07 06:56:08', '2025-05-07 06:56:08'),
(20, 'ญาณที่ 5 ภังคญาณ ', 'https://www.youtube.com/watch?v=MfRP-Bdv0xE', 214, '2025-05-07 06:56:30', '2025-05-07 06:56:30'),
(21, 'ญาณที่ 6 ภยญาณ ', 'https://www.youtube.com/watch?v=9AyWuH88a4U', 167, '2025-05-07 06:56:50', '2025-05-07 06:56:50'),
(22, 'ญาณที่ 7 อาทีนวญาณ ', 'https://www.youtube.com/watch?v=vRC_YfkVHGM', 120, '2025-05-07 06:57:10', '2025-05-07 06:57:10'),
(23, 'ญาณที่ 8 นิพพิทาญาณ', 'https://www.youtube.com/watch?v=2oaaEfRwRYw', 117, '2025-05-07 06:57:26', '2025-05-07 06:57:26'),
(24, 'ญาณที่ 9 มุญจิตุกามยตาญาณ', 'https://www.youtube.com/watch?v=I2Fg0S_IgQQ', 116, '2025-05-07 06:57:41', '2025-05-07 06:57:41');

-- --------------------------------------------------------

--
-- Table structure for table `question_evaluation`
--

CREATE TABLE `question_evaluation` (
  `question_id` int NOT NULL,
  `evaluation_id` int DEFAULT NULL,
  `section` varchar(100) DEFAULT NULL,
  `question_text` varchar(100) DEFAULT NULL,
  `question_type` enum('rating','text') DEFAULT NULL,
  `order_number` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `question_evaluation`
--

INSERT INTO `question_evaluation` (`question_id`, `evaluation_id`, `section`, `question_text`, `question_type`, `order_number`) VALUES
(1, 1, 'เนื้อหาสื่อบทเรียนออนไลน์', 'ความถูกต้องของเนื้อหา', 'rating', 1),
(2, 1, 'เนื้อหาสื่อบทเรียนออนไลน์', 'ความสมบูรณ์ของเนื้อหา', 'rating', 2),
(3, 1, 'เนื้อหาสื่อบทเรียนออนไลน์', 'สื่อมีความสอดคล้องกับเนื้อหา', 'rating', 3),
(4, 1, 'เนื้อหาสื่อบทเรียนออนไลน์', 'สามารถนำไปใช้ได้', 'rating', 4),
(9, 1, 'การนำเสนอด้านภาพและเสียง', 'ภาพประกอบเนื้อหา', 'rating', 1),
(10, 1, 'การนำเสนอด้านภาพและเสียง', 'ภาพประกอบสื่อความหมายตรงกับเนื้อหา', 'rating', 2),
(11, 1, 'การนำเสนอด้านภาพและเสียง', 'เสียงบรรยายที่ใช้ประกอบเนื้อหา', 'rating', 3),
(12, 1, 'การนำเสนอด้านภาพและเสียง', 'ดนตรีประกอบเนื้อหา', 'rating', 4),
(13, 1, 'การจัดการสื่อบทเรียนออนไลน์', 'ความง่ายต่อการใช้งานของระบบ', 'rating', 1),
(14, 1, 'การจัดการสื่อบทเรียนออนไลน์', 'มีความเสถียร สามารถเข้าใช้งานได้อย่างต่อเนื่อง', 'rating', 2),
(15, 1, 'การจัดการสื่อบทเรียนออนไลน์', 'มีความรวดเร็วในการแสดงผล ภาพ ตัวอักษร', 'rating', 3),
(16, 1, 'การจัดการสื่อบทเรียนออนไลน์', 'เทคนิคการนำเสนอบทเรียน', 'rating', 4);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int NOT NULL,
  `lesson_id` int NOT NULL,
  `type` enum('lessons','practice') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `numbers` int NOT NULL,
  `question` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `choice_a` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `choice_b` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `choice_c` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `choice_d` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `correct_answer` enum('a','b','c','d') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `lesson_id`, `type`, `numbers`, `question`, `choice_a`, `choice_b`, `choice_c`, `choice_d`, `correct_answer`, `created_at`, `updated_at`) VALUES
(29, 10, 'lessons', 1, 'พระนามเดิมของพระพุทธเจ้าคืออะไร', 'อโศก', 'สิทธัตถะ', 'โกณฑัญญะ', 'วิศวามิตร', 'b', '2025-05-05 07:28:19', '2025-05-06 09:18:08'),
(30, 10, 'lessons', 2, 'พระพุทธเจ้าประสูติที่ใด', 'กรุงกบิลพัสดุ์', 'กรุงเทวทหะ', 'สวนลุมพินีวัน', 'ตำบลรุมมินเด ประเทศอินเดีย', 'c', '2025-05-05 07:28:19', '2025-05-06 09:18:17'),
(31, 10, 'lessons', 3, 'ผู้ที่ทำนายว่าพระสิทธัตถะจะได้ตรัสรู้แน่นอนคือใคร', 'อสิตฤาษี', 'วิศวามิตร', 'โกณฑัญญะพราหมณ์', 'สุทโธทนะ', 'c', '2025-05-05 07:28:19', '2025-05-05 07:28:19'),
(32, 10, 'lessons', 4, 'พระราชมารดาของพระพุทธเจ้าคือใคร', 'พระนางพิมพา', 'พระนางสิริมหามายา', 'พระนางมหาปชาบดีโคตมี', 'พระนางอมิตา', 'b', '2025-05-05 07:28:19', '2025-05-05 07:28:19'),
(33, 10, 'lessons', 5, 'ใครเป็นผู้เลี้ยงดูพระสิทธัตถะหลังจากพระมารดาสวรรคต', 'พระเจ้าสุทโธทนะ', 'พระนางสิริมหามายา', 'พระนางพิมพา', 'พระนางมหาปชาบดีโคตมี', 'd', '2025-05-05 07:28:19', '2025-05-05 07:28:19'),
(34, 10, 'lessons', 6, 'พระสิทธัตถะได้รับการศึกษาจากใคร', 'อสิตฤาษี', 'วิศวามิตร', 'สุทโธทนะ', 'โกลิยวงศ์', 'b', '2025-05-05 07:28:19', '2025-05-05 07:28:19'),
(35, 10, 'lessons', 7, 'พระสิทธัตถะอภิเษกสมรสกับใคร', 'พระนางอมิตา', 'พระนางโคตมี', 'พระนางพิมพาหรือยโสธรา', 'พระนางสิริมหามายา', 'c', '2025-05-05 07:28:19', '2025-05-05 07:28:19'),
(36, 10, 'lessons', 8, 'ชื่อพระโอรสของพระสิทธัตถะคืออะไร', 'ราหุล', 'อานนท์', 'สุทโธทนะ', 'ยโสธรา', 'a', '2025-05-05 07:28:19', '2025-05-05 07:28:19'),
(37, 10, 'lessons', 9, 'พระสิทธัตถะตรัสว่าอย่างไรเมื่อทราบว่าพระโอรสประสูติ', 'ชีวิตใหม่เกิดแล้ว', ' เครื่องจองจำเกิดแล้ว', 'ความสุขมาถึงแล้ว', 'เจ้าชายแห่งธรรมเกิดแล้ว', 'b', '2025-05-05 07:28:19', '2025-05-05 07:28:19'),
(38, 10, 'lessons', 10, 'เหตุใดพระสิทธัตถะจึงออกบวช', 'เพื่อเป็นนักบวชผู้ยิ่งใหญ่', 'เพราะถูกพราหมณ์ทำนาย', 'เพราะไม่พอใจในชีวิตคฤหัสถ์', 'เพราะมารดาสวรรคต', 'c', '2025-05-05 07:28:19', '2025-05-05 07:28:19'),
(39, 11, 'lessons', 1, 'พระพุทธเจ้าทรงประสูติที่ใด', 'เมืองพาราณสี', 'เมืองราชคฤห์', 'สวนลุมพินีวัน', 'วัดเวฬุวัน', 'c', '2025-05-05 08:36:18', '2025-05-05 08:36:18'),
(40, 11, 'lessons', 2, 'พระนามเดิมของพระพุทธเจ้าคืออะไร', 'อโสก', 'ราหุล', 'สิทธัตถะ', 'โกณฑัญญะ', 'c', '2025-05-05 08:36:18', '2025-05-05 08:36:18'),
(41, 11, 'lessons', 3, 'พระมารดาของพระพุทธเจ้าคือใคร', 'พระนางพิมพา', 'พระนางปชาบดีโคตมี', 'พระนางสิริมหามายา', 'พระนางสุนันทา', 'c', '2025-05-05 08:36:18', '2025-05-05 08:36:18'),
(42, 11, 'lessons', 4, 'พราหมณ์คนใดที่ทำนายว่าพระสิทธัตถะจะได้ตรัสรู้เป็นพระพุทธเจ้าแน่นอน', 'อาฬารดาบส', 'โกณฑัญญะ', 'อุทกดาบส', 'ท้าวมหาพรหม', 'b', '2025-05-05 08:36:18', '2025-05-05 08:36:18'),
(43, 11, 'lessons', 5, 'เจ้าชายสิทธัตถะเสด็จออกบวชเมื่อพระชนมายุเท่าใด', '25 ปี', '29 ปี', '30 ปี', '35 ปี', 'b', '2025-05-05 08:36:18', '2025-05-05 08:36:18'),
(44, 11, 'lessons', 6, 'ชื่อของพระโอรสของเจ้าชายสิทธัตถะคืออะไร', 'โกณฑัญญะ', 'ราหุล', 'อานนท์', 'ยโสธรา', 'b', '2025-05-05 08:36:18', '2025-05-05 08:36:18'),
(45, 11, 'lessons', 7, 'เหตุการณ์ใดเป็นแรงบันดาลใจให้เจ้าชายสิทธัตถะออกบวช', 'การศึกษาธรรม', 'ความเบื่อหน่ายในวัง', 'การพบเทวทูต 4', 'ถูกกดดันจากพราหมณ์', 'c', '2025-05-05 08:36:18', '2025-05-05 08:36:18'),
(46, 11, 'lessons', 8, 'พระพุทธเจ้าทรงบำเพ็ญทุกรกิริยานานกี่ปี', '3 ปี', '5 ปี', '6 ปี', '10 ปี', 'c', '2025-05-05 08:36:18', '2025-05-05 08:36:18'),
(47, 11, 'lessons', 9, 'พระพุทธเจ้าทรงศึกษาวิชากับอาจารย์ใดก่อนจะตรัสรู้', 'พระโมคคัลลานะ', 'พระอานนท์', 'พระอาฬารดาบส และพระอุทกดาบส', 'พระสารีบุตร', 'c', '2025-05-05 08:36:18', '2025-05-05 08:36:18'),
(48, 11, 'lessons', 10, 'เมื่อพระพุทธเจ้าประสูติ พระองค์ได้ตรัสคำใด', 'เราคือธรรมราชา', 'เราจะปกครองโลกโดยธรรม', 'เราเป็นผู้เลิศในโลก เป็นผู้ประเสริฐสุดของโลกนี้ นี่คือการเกิดครั้งสุดท้าย', 'ธรรมจักรจักหมุนแล้ว', 'c', '2025-05-05 08:36:18', '2025-05-05 08:36:18'),
(49, 12, 'lessons', 1, 'หลวงพ่อชา สุภัทโท เปรียบการปฏิบัติธรรมเหมือนกับสิ่งใด', 'การออกกำลังกาย', 'การทำบุญ', 'การกินข้าว', 'การเดินจงกรม', 'c', '2025-05-06 09:06:08', '2025-05-06 09:06:08'),
(50, 12, 'lessons', 2, 'การปฏิบัติธรรมมีความสำคัญต่อชีวิตเพราะเหตุใด', 'ทำให้รวย', 'ช่วยให้รอดพ้นจากความจน', 'เป็นการบำรุงจิตใจ', 'ทำให้มีบุญมากกว่าผู้อื่น', 'c', '2025-05-06 09:06:08', '2025-05-06 09:06:08'),
(51, 12, 'lessons', 3, 'สาเหตุหนึ่งที่คนยุคใหม่ทุกข์ใจมาก แม้สภาพร่างกายจะสบาย คืออะไร', 'เพราะกินอาหารไม่เพียงพอ', 'เพราะใช้เทคโนโลยีมากเกินไป', 'เพราะไม่ฝึกฝนจิตใจ', 'เพราะทำงานหนัก', 'c', '2025-05-06 09:06:08', '2025-05-06 09:06:08'),
(52, 12, 'lessons', 4, 'ข้อใดต่อไปนี้เป็นความเข้าใจผิดเกี่ยวกับการปฏิบัติธรรม', 'คนป่วยหรือมีปัญหาจึงต้องปฏิบัติธรรม', 'การปฏิบัติธรรมคือการฝึกใจให้เข้มแข็ง', 'ทุกคนควรปฏิบัติธรรมเพื่อความสงบในใจ', 'การปฏิบัติธรรมเปรียบเสมือนการกินข้าว', 'a', '2025-05-06 09:06:08', '2025-05-06 09:06:08'),
(53, 12, 'lessons', 5, 'ข้อใดต่อไปนี้ไม่ใช่เหตุผลที่ควรปฏิบัติธรรม', 'เพื่อป้องกันความทุกข์ใจในอนาคต', 'เพื่อให้เป็นคนดีของสังคม', 'เพื่อหนีความรับผิดชอบในชีวิต', 'เพื่อเสริมความมั่นคงทางจิตใจ', 'c', '2025-05-06 09:06:08', '2025-05-06 09:06:08'),
(54, 12, 'lessons', 6, 'การที่คนบางคนคลุ้มคลั่งหรือฆ่าตัวตายเมื่อประสบปัญหา เป็นเพราะอะไร', 'ถูกผีเข้า', 'ไม่ได้ออกกำลังกาย', 'จิตใจไม่แข็งแรงเพราะไม่เคยฝึก', 'ไม่มีคนช่วยเหลือ', 'c', '2025-05-06 09:06:08', '2025-05-06 09:06:08'),
(55, 12, 'lessons', 7, 'คำถามของพระเซนจากญี่ปุ่นต่อหลวงพ่อชาเกี่ยวกับการปฏิบัติธรรมมีจุดประสงค์อะไร', 'เพื่อจะเปรียบเทียบกับศาสนาคริสต์', 'เพื่อดูว่าท่านรู้ธรรมะลึกซึ้งหรือไม่', 'เพื่อหาข้ออ้างไม่ต้องปฏิบัติ', 'เพื่อให้เข้าใจเหตุผลของการปฏิบัติธรรม', 'd', '2025-05-06 09:06:08', '2025-05-06 09:06:08'),
(56, 12, 'lessons', 8, 'สุภาษิตทิเบตกล่าวไว้ว่า “ระหว่างพรุ่งนี้กับชาติหน้า ไม่มีใครรู้ว่าอะไรจะมาก่อน” มีความหมายว่าอะไร', 'เราควรเตรียมตัวให้พร้อมเสมอ', 'ชาติหน้าสำคัญกว่าพรุ่งนี้', 'เราควรยึดติดกับอนาคต', 'ความตายไม่มีจริง', 'a', '2025-05-06 09:06:08', '2025-05-06 09:06:08'),
(57, 12, 'lessons', 9, 'หากเราขาดการปฏิบัติธรรมในชีวิตจะเกิดผลอย่างไร', 'ร่างกายเจ็บป่วย', 'ทำให้เรียนไม่เก่ง', 'อาจเสียศูนย์เมื่อเจอปัญหา', 'ไม่มีเพื่อน', 'c', '2025-05-06 09:06:08', '2025-05-06 09:06:08'),
(58, 12, 'lessons', 10, 'จากบทความ เราควรเริ่มปฏิบัติธรรมเมื่อใดจึงเหมาะสมที่สุด', 'เมื่ออายุมาก', 'เมื่อสุขภาพเริ่มแย่', 'เมื่อมีปัญหาชีวิต', 'ตอนที่ยังมีความสุข', 'd', '2025-05-06 09:06:08', '2025-05-06 09:06:08'),
(59, 13, 'lessons', 1, 'อะไรคือเหตุผลสำคัญที่ทำให้เด็กยุคก่อนคุ้นเคยกับพระและวัดมากกว่าเด็กยุคปัจจุบัน', 'เด็กยุคก่อนมีการศึกษามากกว่า', 'เด็กยุคก่อนถูกสอนธรรมะในโรงเรียน', 'เด็กยุคก่อนอยู่กับปู่ย่าตายายและถูกพาไปวัด', 'เด็กยุคก่อนมีเวลาว่างมากกว่า', 'c', '2025-05-06 09:10:32', '2025-05-06 09:10:32'),
(60, 13, 'lessons', 2, 'สิ่งใดคือหัวใจของการปฏิบัติธรรมตามแนวทางในเอกสาร', 'การไปวัดฟังธรรมเป็นประจำ', 'การทำบุญถวายภัตตาหาร', 'การมีสติรู้ตัวในชีวิตประจำวัน', 'การศึกษาพระไตรปิฎกอย่างละเอียด', 'c', '2025-05-06 09:10:32', '2025-05-06 09:10:32'),
(61, 13, 'lessons', 3, 'เพราะเหตุใดการภาวนาในชีวิตประจำวันจึงเป็นสิ่งที่ทำได้ตลอดเวลา', 'เพราะการภาวนาใช้เวลาน้อย', 'เพราะภาวนาไม่ต้องใช้คำภาวนา', 'เพราะทุกกิจกรรมสามารถฝึกสติได้', 'เพราะภาวนาไม่จำเป็นต้องนั่งสมาธิ', 'c', '2025-05-06 09:10:32', '2025-05-06 09:10:32'),
(62, 13, 'lessons', 4, 'เหตุใดคนยุคใหม่มักบอกว่า \"ไม่มีเวลา\" แม้เวลาในวันจะเท่าเดิม', 'เพราะมีกิจกรรมที่ไม่เกี่ยวข้องกับธรรมะมากเกินไป', 'เพราะวันในปัจจุบันสั้นลง', 'เพราะภาระงานเพิ่มขึ้นโดยไม่มีเทคโนโลยีช่วย', 'เพราะไม่รู้จักการจัดเวลา', 'a', '2025-05-06 09:10:32', '2025-05-06 09:10:32'),
(63, 13, 'lessons', 5, 'การรู้ว่า “เบื่อ” เมื่อเห็นอาหารในโรงอาหาร ถือว่าเป็นการปฏิบัติอย่างไร', 'เป็นการพิจารณาอาหาร', 'เป็นการฝึกสมาธิขั้นสูง', 'เป็นการมีสติรู้เท่าทันอารมณ์', 'เป็นการละเว้นการบริโภค', 'c', '2025-05-06 09:10:32', '2025-05-06 09:10:32'),
(64, 13, 'lessons', 6, 'พระพุทธเจ้าตรัสรู้ ณ สถานที่ใด', 'เมืองกบิลพัสดุ์', 'ต้นศรีมหาโพธิ์ พุทธคยา', 'สวนลุมพินีวัน', 'เมืองพาราณสี', 'b', '2025-05-06 09:10:32', '2025-05-06 09:10:32'),
(65, 13, 'lessons', 7, 'ในสมัยพุทธกาล กลุ่มบุคคลกลุ่มใดฟังธรรมแล้วบรรลุเป็นพระอริยบุคคลมากที่สุด', 'พ่อค้าและชาวบ้าน', 'พราหมณ์และฤๅษี', 'เจ้าขุนมูลนาย', 'กษัตริย์และนักรบ', 'b', '2025-05-06 09:10:32', '2025-05-06 09:10:32'),
(66, 13, 'lessons', 8, '“การชี้ปัญหาโดยไม่มีข้อมูลวิเคราะห์หรือแนวทางแก้ไข” ในมุมมองของธรรมะ ถือเป็นอย่างไร', 'การแสดงสัจธรรม', 'การวิจารณ์เพื่อพัฒนา', 'การแสดงความคิดเห็นทั่วไป', 'การพูดที่ไม่เกิดประโยชน์', 'd', '2025-05-06 09:10:32', '2025-05-06 09:10:32'),
(67, 13, 'lessons', 9, 'พระพุทธเจ้าทรงแสดงธรรมครั้งแรกแก่ใคร', 'พระเจ้าสุทโธทนะ', 'พราหมณ์ 3 คน', 'ปัญจวัคคีย์', 'พระอานนท์', 'c', '2025-05-06 09:10:32', '2025-05-06 09:10:32'),
(68, 13, 'lessons', 10, 'หลักธรรมสำคัญที่พระพุทธเจ้าทรงสอนในการปฏิบัติคืออะไร', 'ปฏิจจสมุปบาท', 'อิทธิบาท 4', 'อริยสัจ 4', 'พรหมวิหาร 4', 'c', '2025-05-06 09:10:32', '2025-05-06 09:10:32'),
(69, 14, 'lessons', 1, 'ข้อใดคือประโยชน์ของการนั่งสมาธิที่เด่นชัดที่สุด', 'ช่วยขับลมออกจากร่างกาย', 'ช่วยในการย่อยอาหาร', 'สภาวธรรมปรากฏชัดเจน', 'ทำให้เข้าใจขันธ์ ๕', 'c', '2025-05-06 09:15:32', '2025-05-06 09:15:32'),
(70, 14, 'lessons', 2, 'การเดินจงกรมช่วยในเรื่องใดต่อไปนี้', 'ลดความวิตกกังวลโดยตรง', 'ทำให้เข้าใจขันธ์ ๕ อย่างชัดเจน', 'ทำให้ท้องว่างเร็วขึ้น', 'อดทนต่อการเดินทางไกล', 'd', '2025-05-06 09:15:32', '2025-05-06 09:15:32'),
(71, 14, 'lessons', 3, 'การปฏิบัติวิปัสสนาตามสติปัฏฐาน ๔ ส่งผลต่อจิตใจอย่างไร', 'จิตใจเศร้าหมองและตื่นกลัว', 'จิตใจเบิกบาน เอิบอิ่ม แช่มชื่น', 'เกิดความลังเลสงสัยมากขึ้น', 'ไม่มีผลต่อจิตใจ', 'b', '2025-05-06 09:15:32', '2025-05-06 09:15:32'),
(72, 14, 'lessons', 4, 'ประโยชน์ของการยืนกำหนดคือข้อใด', 'ช่วยเพิ่มปัญญาอย่างรวดเร็ว', 'ทำให้ไม่ต้องเปลี่ยนอิริยาบถ', 'จิตเป็นสมาธิได้ค่อนข้างง่าย', 'ทำให้หลับสบาย', 'c', '2025-05-06 09:15:32', '2025-05-06 09:15:32'),
(73, 14, 'lessons', 5, 'ข้อใดคือข้อควรระวังในการนอนกำหนด', 'เสี่ยงเป็นโรคหัวใจ', 'ง่วงเหงา เซื่องซึม', 'ทำให้จิตไม่นิ่ง', 'หลงลืมความจริงของชีวิต', 'b', '2025-05-06 09:15:32', '2025-05-06 09:15:32'),
(74, 14, 'lessons', 6, 'การกำหนดอิริยาบถย่อยส่งผลอย่างไรต่อการฝึกปฏิบัติ', 'ทำให้ปฏิบัติง่ายขึ้นโดยไม่ต้องพิจารณา', 'ช่วยให้สมาธิเข้มแข็งแบบรวดเร็ว', 'ปิดช่องว่างการกำหนดอิริยาบถอื่น', 'ลดระยะเวลาในการบรรลุนิพพาน', 'c', '2025-05-06 09:15:32', '2025-05-06 09:15:32'),
(75, 14, 'lessons', 7, 'การปฏิบัติธรรมสามารถทำให้ผู้ปฏิบัติ...', 'ประสบความสำเร็จทางโลก', 'ปฏิเสธกิเลสได้ทั้งหมดทันที', 'ทำลายความโลภ ความโกรธ', 'ได้รับพลังพิเศษทางจิต', 'c', '2025-05-06 09:15:32', '2025-05-06 09:15:32'),
(76, 14, 'lessons', 8, 'การปฏิบัติธรรมต่อเนื่องไม่เกิน ๗ ปี จะมีโอกาสบรรลุอะไร', 'โสดาบัน', 'พระอรหันต์ หรืออนาคามี', 'พรหมโลก', 'สุคติภพ', 'b', '2025-05-06 09:15:32', '2025-05-06 09:15:32'),
(77, 14, 'lessons', 9, 'อานิสงส์ข้อใดช่วยในการดำเนินชีวิตประจำวันโดยตรง', 'สามารถแสดงธรรมได้เก่ง', 'จิตสงบจนไม่อยากพูดกับใคร', 'มีประสิทธิภาพในการทำหน้าที่ต่าง ๆ ดีขึ้น', 'ไม่ต้องหลับนอน', 'c', '2025-05-06 09:15:32', '2025-05-06 09:15:32'),
(78, 14, 'lessons', 10, 'การปฏิบัติธรรมตามแนวสติปัฏฐาน ๔ ช่วยในเรื่องใดได้ดีที่สุด', 'สร้างบารมีเพียงอย่างเดียว', 'พักผ่อนจากความเครียดชั่วคราว', 'เข้าใจสภาพที่แท้จริงของชีวิต', 'แก้ปัญหาทางการเงิน', 'c', '2025-05-06 09:15:32', '2025-05-06 09:15:32');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes_practice`
--

CREATE TABLE `quizzes_practice` (
  `id` int NOT NULL,
  `practice_id` int NOT NULL,
  `number` int NOT NULL,
  `quiz_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `choice_a` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `choice_b` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `choice_c` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `choice_d` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct_answer` enum('a','b','c','d','e') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `quizzes_practice`
--

INSERT INTO `quizzes_practice` (`id`, `practice_id`, `number`, `quiz_title`, `choice_a`, `choice_b`, `choice_c`, `choice_d`, `correct_answer`, `created_at`, `updated_at`) VALUES
(62, 16, 1, 'แบบนั่งกราบหญิง เป็นท่าใด', 'เทพธิดา', 'นั่งพับเพียบ', 'นั่งขัดสมาธิ', 'ถูกทุกข้อ', 'a', '2025-05-08 07:19:20', '2025-05-08 07:19:20'),
(63, 16, 2, 'จิตที่แนบแน่นอยู่กับการพอง การยุบ เป็นอะไร', 'เป็นตัวปัญญา', 'เป็นตัวศีล', 'เป็นตัวสมาธิ', 'เป็นตัวสติ', 'c', '2025-05-08 07:19:20', '2025-05-08 07:19:20'),
(64, 16, 3, 'ตัวที่เข้าไปรู้ว่าอาการท้องพอง อาการท้องยุบ คืออะไร', 'ตัวปัญญา', 'ตัวศีล', 'ตัวสมาธิ', 'ตัวสติ', 'a', '2025-05-08 07:19:20', '2025-05-08 07:19:20'),
(65, 16, 4, '“วิปัสสนา” คืออะไร', 'ปัญญาที่เห็นไตรลักษณ์อันให้ถอนความหลงผิดในสังขาร', 'การฝึกอบรมปัญญาให้เกิดความเห็นรู้แจ้งชัด สภาวะของสิ่งทั้งหลายตามที่เป็น', 'ความเห็นแจ้ง คือเห็นตรงต่อความเป็นจริงของสภาวธรรม', 'ถูกทุกข้อ', 'd', '2025-05-08 07:19:20', '2025-05-08 07:19:20'),
(66, 16, 5, '“ญาณ” คืออะไร', 'ความรู้', 'ความปรีชากําหนดรู้', 'ความรู้จากการปฏิบัติวิปัสสนากัมมัฏฐาน', 'ถูกทุกข้อ', 'd', '2025-05-08 07:19:20', '2025-05-08 07:19:20'),
(67, 16, 6, 'แบบนั่งกราบชาย เป็นท่าใด', 'เทพบุตร', 'เทพธิดา', 'นั่งขัดสมาธิ', 'ผิดทุกข้อ', 'a', '2025-05-08 07:19:20', '2025-05-08 07:19:20'),
(68, 16, 7, 'เมื่อเดินจงกรมไปสุดทางด้านใดด้านหนึ่ง ควรกําหนดว่าอย่างไร', 'ขวาย่างหนอ', 'ซ้ายย่างหนอ', 'อยากเดินหนอ', 'หยุดหนอ', 'd', '2025-05-08 07:19:20', '2025-05-08 07:19:20'),
(69, 16, 8, 'ในการเดินจงกรม ระยะที่ 1 ผู้ปฏิบัติควรปฏิบัติอย่างไร', 'เดินไปเรื่อย ๆ โดยไม่ต้องหยุด', 'เดินช้า ๆ กลับไปกลับมา และเมื่อถึงสุดทางให้ยืนเท้าชิดกัน', 'นั่งสมาธิก่อนแล้วจึงเดิน', 'เดินเร็ว ๆ เพื่อให้ร่างกายอบอุ่น', 'b', '2025-05-08 07:19:20', '2025-05-08 07:19:20'),
(70, 16, 9, 'ข้อใดถูกต้องเกี่ยวกับการนั่งสมาธิ', 'เวลาหายใจออก กําหนดว่า \"พองหนอ\"', 'เวลาหายใจเข้า กําหนดว่า \"ยุบหนอ\"', 'เวลาหายใจเข้า กําหนดว่า \"พองหนอ\" และเวลาหายใจออก กําหนดว่า \"ยุบหนอ\"', 'เวลาหายใจเข้าและออก กําหนดว่า \"พองหนอ\"', 'c', '2025-05-08 07:19:20', '2025-05-08 07:19:20'),
(71, 16, 10, 'ตําแหน่งที่ควรวางสติในขณะนั่งสมาธิคือที่ใด', 'ระหว่างคิ้ว', 'กลางฝ่ามือ', 'เหนือสะดือ 2 นิ้ว', 'กลางหน้าอก', 'c', '2025-05-08 07:19:20', '2025-05-08 07:19:20'),
(72, 17, 1, 'การยืนควรทอดสายตาไปเบื้องหน้าระยะประมาณเท่าไร', '๑ วาหรือ ๔ ศอก', '๑ วาหรือ ๓ ศอก', '๑ ฟุต', 'ถูกทุกข้อ', 'a', '2025-05-08 07:25:33', '2025-05-08 07:25:33'),
(73, 17, 2, 'วิธีการเดินจงกรม เมื่อกําหนดในใจว่า อยากเดินหนอๆๆ ๓ ครั้ง แล้วค่อยๆ ก้าวเท้าใดไปข้างหน้าก่อน', 'เท้าซ้าย', 'เท้าขวา', 'เท้าใดก่อนก็ได้', 'ถูกทุกข้อ', 'b', '2025-05-08 07:25:33', '2025-05-08 07:25:33'),
(74, 17, 3, 'การเดินจงกรม ให้เอาสติเพ่งพิจารณาอยู่ที่ไหน', 'เท้าขวา', 'เท้าซ้าย', 'เท้าใดก็ได้', 'เท้าทั้ง ๒ ข้าง', 'd', '2025-05-08 07:25:33', '2025-05-08 07:25:33'),
(75, 17, 4, '“สติปัฏฐาน ๔” แปลว่าอะไร', 'ธรรมอันเป็นที่ตั้งแห่งสติ ๔ อย่าง', 'อริยสัจ ๔', 'การตั้งสติกําหนดพิจารณาสิ่งทั้งหลายให้รู้เห็นเท่าทันความเป็นจริง', 'ข้อ ก. และ ค. ถูกต้อง', 'd', '2025-05-08 07:25:33', '2025-05-08 07:25:33'),
(76, 17, 5, '“สติปัฏฐาน ๔” หมายถึงอะไร', 'กายานุปัสสนาสติปัฏฐาน เป็นการใช้สติพิจารณากําหนดรู้อาการต่างๆ เช่น การเดิน นั่ง นอน', 'เวทนานุปัสสนาสติปัฏฐาน เป็นการใช้สติปัญญากําหนดรู้อาการต่างๆ ที่เกิดทางกาย เช่น อาการเจ็บ อาการปวด', 'จิตตานุปัสสนาสติปัฏฐาน เป็นการใช้สติกําหนดรู้อาการต่างๆ ที่ปรากฏทางธรรม เช่น ราคา โมหะ โทสะ', 'ข้อ ก. และ ข. ถูกต้อง', 'd', '2025-05-08 07:25:33', '2025-05-08 07:25:33'),
(77, 17, 6, 'ในการเดินจงกรมระยะที่ ๒ ผู้ปฏิบัติควรกําหนดท่าใดบ้าง', 'ขวาย่างหนอ ซ้ายย่างหนอ', 'ยกหนอ เหยียบหนอ', 'พองหนอ ยุบหนอ', 'ก้มหนอ เงยหนอ', 'a', '2025-05-08 07:25:33', '2025-05-08 07:25:33'),
(78, 17, 7, 'ก่อนเริ่มเดินจงกรมในระยะที่ ๒ ควรกําหนดในใจว่าอะไรเป็นลําดับแรก', 'ยกหนอ ๓ ครั้ง', 'เหยียบหนอ ๓ ครั้ง', 'ยืนหนอ ๓ ครั้ง', 'อยากเดินหนอ ๓ ครั้ง', 'd', '2025-05-08 07:25:33', '2025-05-08 07:25:33'),
(79, 17, 8, 'เมื่อเกิดอาการปวดเมื่อยระหว่างนั่งสมาธิ ควรทําอย่างไร', 'ลุกขึ้นทันที', 'เพ่งพิจารณาอาการแล้วกําหนดในใจว่า \"เจ็บหนอ ปวดหนอ เมื่อยหนอ คันหนอ\"', 'ขยับร่างกายเล็กน้อยเพื่อบรรเทาความปวด', 'กําหนด \"พองหนอ ยุบหนอ\" ต่อไปเรื่อยๆ', 'b', '2025-05-08 07:25:33', '2025-05-08 07:25:33'),
(80, 17, 9, 'เมื่อผู้ปฏิบัติต้องการเปลี่ยนอิริยาบถจากนั่งสมาธิเป็นเดินจงกรมควรกําหนดอย่างไร', 'ลุกขึ้นทันทีโดยไม่ต้องกําหนดอะไร', 'กําหนดในใจว่า \"ลุกหนอ ๓ ครั้ง\"', 'กําหนดว่า \"อยากเดินหนอ\" แล้วลุกขึ้น', 'หายใจเข้าลึก ๆ แล้วลุกขึ้นเดิน', 'b', '2025-05-08 07:25:33', '2025-05-08 07:25:33'),
(81, 17, 10, 'การยืนควรจะวางมือไว้จุดใด', 'ด้านหน้า', 'ด้านหลัง', 'ข้างลําตัว ซ้าย ขวา', 'ข้อ ก. และ ข้อ ข. ถูกต้อง', 'd', '2025-05-08 07:25:33', '2025-05-08 07:25:33'),
(82, 18, 1, 'ขณะที่นั่งสมาธิเมื่อกําหนดสติไปที่ท่านั่งพิจารณาดูรูปนั่งให้ชัดเจน โดยผู้ปฏิบัติพึงระลึกว่าตนเองกําลังนั่งอยู่ มิได้อยู่ในอริยบทอื่นให้กําหนดว่าอย่างไร', 'นั่งหนอ', 'พองหนอ', 'ยุบหนอ', 'ถูกทุกข้อ', 'a', '2025-05-08 07:30:37', '2025-05-08 07:30:37'),
(83, 18, 2, 'รูปนามเป็นสิ่งเดียวกันหรือไม่', 'ไม่ใช่', 'ใช่', 'ไม่ทราบ', 'ผิดทุกข้อ', 'a', '2025-05-08 07:30:37', '2025-05-08 07:30:37'),
(84, 18, 3, '“ฌาณ” คืออะไร', 'การเพ่งอารมณ์จนใจแน่วแน่เป็นอัปปนาสมาธิ', 'ภาวะที่จิตสงบประณีต', 'มีสมาธิเป็นองค์ธรรมหลัก', 'ถูกทุกข้อ', 'd', '2025-05-08 07:30:37', '2025-05-08 07:30:37'),
(85, 18, 4, 'บุคคลที่จะปฏิบัติธรรม พึงตัดความกังวล มีอะไรบ้าง', 'อาวาสปลิโพธ (ความกังวลเกี่ยวกับอาวาส)', 'กุลปลิโพธ (ความกังวลเกี่ยวกับตระกูลญาติ)', 'ลาภปลิโพธ (ความกังวลเกี่ยวกับลาภ)', 'ถูกทุกข้อ', 'd', '2025-05-08 07:30:37', '2025-05-08 07:30:37'),
(86, 18, 5, 'การบูชาใดต่อสมเด็จพระสัมมาสัมพุทธเจ้า ถือเป็นการบูชาสูงสุด', 'การปฏิบัติบูชา', 'การบูชาด้วยเครื่องสักการะ เช่น ดอกไม้ ธูปเทียน', 'การบูชาด้วยการกราบไหว้', 'การบูชาด้วยของหอม เช่น น้ําอบ น้ําปรุง', 'a', '2025-05-08 07:30:37', '2025-05-08 07:30:37'),
(87, 18, 6, 'ในญาณที่ ๓ (สัมมสนญาณ) ขณะนั่งสมาธิ ควรวางสติไว้ที่ใด', 'ระหว่างคิ้ว', 'กลางฝ่ามือ', 'เหนือสะดือ ๒ นิ้ว', 'กลางหน้าอก', 'c', '2025-05-08 07:30:37', '2025-05-08 07:30:37'),
(88, 18, 7, 'การกําหนดขณะนั่งสมาธิ ให้กําหนดข้อใด', 'พองหนอ ยุบหนอ นั่งหนอ', 'ยุบหนอ พองหนอ นั่งหนอ', 'นั่งหนอ พองหนอ ยุบหนอ', 'ถูกทุกข้อ', 'a', '2025-05-08 07:30:37', '2025-05-08 07:30:37'),
(89, 18, 8, 'ขณะที่นั่งสมาธิ ท้องพองให้กําหนดว่าอย่างไร', 'พองหนอ', 'ยุบหนอ', 'นั่งหนอ', 'ถูกทุกข้อ', 'a', '2025-05-08 07:30:37', '2025-05-08 07:30:37'),
(90, 18, 9, 'หลังจากนั่งสมาธิครบเวลา ผู้ปฏิบัติควรทําอย่างไรต่อไป', 'นั่งสมาธิต่อไปอีก', 'ลุกขั้นยืนพัก', 'นอนพักผ่อน', 'ลุกขึ้นเดินจงกรม ตามกําหนดเวลา', 'd', '2025-05-08 07:30:37', '2025-05-08 07:30:37'),
(91, 18, 10, 'ขณะที่นั่งสมาธิ ท้องยุบให้กําหนดว่าอย่างไร', 'นั่งหนอ', 'พองหนอ', 'ยุบหนอ', 'ถูกทุกข้อ', 'c', '2025-05-08 07:30:37', '2025-05-08 07:30:37'),
(92, 19, 1, 'การเดินจงกรมจะทําให้เกิดสมาธิที่ตั้งอยู่ได้นานใช่หรือไม่', 'ใช่', 'ไม่ใช่', 'บางครั้งใช่ บางครั้งไม่ใช่', 'ถูกทุกข้อ', 'a', '2025-05-08 07:47:57', '2025-05-08 07:47:57'),
(93, 19, 2, '“สติปัฏฐาน” คืออะไร', 'หลักการฝึกจิตให้มีสติสู่การรู้แจ้ง ตามความเป็นจริง', 'หลักการฝึกจิตให้นิ่งสงบ', 'หลักการฝึกจิตให้ไม่หลงๆ ลืมๆ', 'หลักการฝึกจิตให้เพิ่มความจํา', 'a', '2025-05-08 07:47:57', '2025-05-08 07:47:57'),
(94, 19, 3, 'หลักธรรมพละ ๕ ได้แก่ข้อใด', 'ศรัทธา, วิริยะ, สติ, สมาธิ, ปัญญา', 'ทาน, ศีล, ภาวนา, ปัญญา, สติ', 'ขันติ, เมตตา, สัจจะ, อุเบกขา, สมถะ', 'ศีล, สมาธิ, ปัญญา, วิริยะ, สติ', 'a', '2025-05-08 07:47:57', '2025-05-08 07:47:57'),
(95, 19, 4, 'จิตที่คอยระมัดระวังในการพอง การยุบ เป็นอะไร', 'เป็นตัวปัญญา', 'เป็นตัวสมาธิ', 'เป็นตัวศีล', 'ถูกทุกข้อ', 'c', '2025-05-08 07:47:57', '2025-05-08 07:47:57'),
(96, 19, 5, '“สมถะกัมมัฏฐาน” มุ่งเน้นอะไร', 'อิทธิฤทธิ์', 'ปาฏิหารย์', 'ความเงียบ', 'ความสงบ มุ่งเอาฌาณ เป็นความสงบทางโลกียะ เพื่อให้ได้โลกียอภิญญา อันมีพรหมภูมิเป็นสุงสุด', 'd', '2025-05-08 07:47:57', '2025-05-08 07:47:57'),
(97, 19, 6, 'ในการเดินจงกรมระยะที่ ๓ ผู้ปฏิบัติควรกําหนดท่าใดบ้าง', 'ขวาย่างหนอ ซ้ายย่างหนอ', 'ยกหนอ ย่างหนอ เหยียบหนอ', 'พองหนอ ยุบหนอ', 'นั่งหนอ ลุกหนอ ยืนหนอ', 'b', '2025-05-08 07:47:57', '2025-05-08 07:47:57'),
(98, 19, 7, 'การเดินจงกรม ๓ ระยะ คืออะไรบ้าง เรียงตามลําดับ', 'ยกหนอ ย่างหนอ เหยียบหนอ', 'ย่างหนอ เหยียบหนอ ยกหนอ', 'ยกหนอ เหยียบหนอ ย่างหนอ', 'เหยียบหนอ ยกหนอ ย่างหนอ', 'a', '2025-05-08 07:47:57', '2025-05-08 07:47:57'),
(99, 19, 8, 'เวลาวางเท้าลงขณะเดินจงกรมในระยะที่ ๓ ควรกําหนดอย่างไร', 'ยกหนอ', 'ย่างหนอ', 'เหยียบหนอ', 'หยุดหนอ', 'c', '2025-05-08 07:47:57', '2025-05-08 07:47:57'),
(100, 19, 9, 'การเดินจงกรมมีประโยชน์ ๕ ประการ คืออะไรบ้าง', 'อดทนต่อการเดินทางไกล', 'อดทนต่อการทําความเพียร', 'ช่วยย่อยอาหาร', 'ถูกทุกข้อ', 'd', '2025-05-08 07:47:57', '2025-05-08 07:47:57'),
(101, 19, 10, 'ในการเดินจงกรมระยะที่ ๓ ผู้ปฏิบัติควรเพ่งพิจารณาสติอยู่ที่ใด', 'ฝ่ามือทั้งสองข้าง', 'ศีรษะและไหล่', 'ลมหายใจเข้าออก', 'เท้าทั้งสองข้าง', 'd', '2025-05-08 07:47:57', '2025-05-08 07:47:57'),
(102, 20, 1, 'การนั่งสมาธิในบทนี้ ให้กําหนดในใจว่าอย่างไรตามลําดับ', 'ยุบหนอ พองหนอ นั่งหนอ ถูกหนอ', 'พองหนอ ยุบหนอ นั่งหนอ ถูกหนอ', 'นั่งหนอ พองหนอ ยุบหนอ ถูกหนอ', 'นั่งหนอ ยุบหนอ พองหนอ ถูกหนอ', 'b', '2025-05-08 07:52:06', '2025-05-08 07:52:06'),
(103, 20, 2, 'การนั่งสมาธิ ให้กําหนดขั้นตอนดังต่อไปนี้', 'พองหนอ ยุบหนอ นั่งหนอ เอาสติไปเพ่งพิจารณาที่สะโพกขวา พร้อมเพ่งพิจารณาวงกลมที่มีขนาด เท่าเหรียญสิบบาทให้ถูกบริเวณสะโพกขวาและกําหนดในใจว่า ถูกหนอ', 'พองหนอ ยุบหนอ นั่งหนอ พร้อมเพ่งพิจารณาวงกลมมีขนาดเท่าเหรียญสิบบาท ที่บริเวณสะโพกซ้าย พร้อมกําหนดในใจว่า ถูกหนอ', 'ขณะนั่งสมาธิให้เพ่งพิจารณาโดยใช้สติไปกําหนดที่ท้องเหนือสะดือ ๒ นิ้ว', 'ถูกทุกข้อ', 'd', '2025-05-08 07:52:06', '2025-05-08 07:52:06'),
(104, 20, 3, 'อาการที่ท้องพองและท้องยุบคืออะไร', 'นาม', 'รูป', 'ธรรม', 'ขันธ์ ๕', 'b', '2025-05-08 07:52:06', '2025-05-08 07:52:06'),
(105, 20, 4, 'ผู้ปฏิบัติจําเป็นต้องเจริญสติประคองจิตให้อยู่กับปัจจุบันธรรมอย่างต่อเนื่องตลอดเวลา โดยเจริญสติกําหนดดังนี้', 'ให้กําหนดดู กายส่วยย่อย ในกายส่วนใหญ่', 'ให้กําหนดดู เวทนาส่วนย่อย ในเวทนาส่วนใหญ่', 'ให้กําหนดดู จิตส่วนย่อย ในจิตส่วนใหญ่', 'ถูกทุกข้อ', 'd', '2025-05-08 07:52:07', '2025-05-08 07:52:07'),
(106, 20, 5, 'วิปัสสนากัมมัฏฐาน คืออะไร', 'มุ่งเน้นความสงบที่พ้นจากโลก', 'เป็นโลกุตตระ', 'มีพระนิพพานเป็นจุดหมายสูงสุด', 'ถูกทุกข้อ', 'd', '2025-05-08 07:52:07', '2025-05-08 07:52:07'),
(107, 20, 6, 'การเดินจงกรมระยะที่ ๔ มีการเพิ่มการกําหนดท่าใดเข้ามาจากระยะที่ ๓', 'ยกส้นหนอ', 'หยุดหนอ', 'นั่งหนอ', 'กลับหนอ', 'a', '2025-05-08 07:52:07', '2025-05-08 07:52:07'),
(108, 20, 7, 'ข้อใดเป็นลําดับที่ถูกต้องของการเดินจงกรมระยะที่ ๔', 'ยกหนอ - ย่างหนอ - เหยียบหนอ', 'ยกส้นหนอ - ยกหนอ - ย่างหนอ - เหยียบหนอ', 'ยืนหนอ - หยุดหนอ - เดินหนอ', 'ขวาย่างหนอ - ซ้ายย่างหนอ - หยุดหนอ', 'b', '2025-05-08 07:52:07', '2025-05-08 07:52:07'),
(109, 20, 8, 'เดินจงกลม ๔ ระยะ ให้กําหนดในใจว่าอย่างไรตามลําดับขั้นตอน', 'ยกหนอ - ยกส้นหนอ - ย่างหนอ - เหยียบหนอ', 'เหยียบหนอ - ยกหนอ - ยกส้นหนอ - ย่างหนอ', 'ยกส้นหนอ - ย่างหนอ - เหยียบหนอ - ยกหนอ', 'ยกส้นหนอ - ยกหนอ - ย่างหนอ - เหยียบหนอ', 'd', '2025-05-08 07:52:07', '2025-05-08 07:52:07'),
(110, 20, 9, 'ในการนั่งสมาธิของญาณที่ ๕ ควรกําหนดอะไรบ้าง', 'พองหนอ - ยุบหนอ - นั่งหนอ - ถูกหนอ', 'ยืนหนอ - เดินหนอ - นั่งหนอ - หยุดหนอ', 'พองหนอ - หยุดหนอ - ยืนหนอ - ย่างหนอ', 'คิดหนอ - พองหนอ - เหยียบหนอ - กลับหนอ', 'a', '2025-05-08 07:52:07', '2025-05-08 07:52:07'),
(111, 20, 10, 'ในการนั่งสมาธิของญาณที่ ๕ ผู้ปฏิบัติควรเพ่งพิจารณาบริเวณใดของร่างกาย', 'ฝ่ามือ', 'ศีรษะ', 'สะโพกขวาและสะโพกซ้าย', 'เท้าซ้าย', 'c', '2025-05-08 07:52:07', '2025-05-08 07:52:07'),
(112, 21, 1, 'ข้อใดไม่ใช่ประโยชน์ของการเดินจงกรม', 'อดทนต่อการเดินทางไกล', 'อดทนต่อการทําความเพียร', 'ทําให้เดินรวดเร็ว วิ่งได้เร็ว', 'ช่วยขับโรคลม', 'c', '2025-05-08 07:56:31', '2025-05-08 07:56:31'),
(113, 21, 2, 'อะไรเป็นสิ่งสําคัญในชีวิต', 'เงินทอง', 'ชื่อเสียง', 'ลาภ ยศ สรรเสริญ', 'สติปัญญา', 'd', '2025-05-08 07:56:31', '2025-05-08 07:56:31'),
(114, 21, 3, 'การภาวนา แปลว่าทําให้เจริญ มีอะไรบ้าง', 'กายภาวนา การพัฒนากาย คือการมีความสัมพันธ์ที่เกื้อกูลกับสิ่งแวดล้อมทางกายภาพ หรือทางวัตถุ', 'ศีลภาวนา การพัฒนาศีล คือการมีความสัมพันธ์เกื้อกูลกับสิ่งแวดล้อมทางสังคม คือเพื่อนมนุษย์', 'จิตภาวนา การพัฒนาจิต คือการทําจิตใจให้เจริญงอกงามในคุณธรรม ความดีงาม ความเข้มแข็งมั่นคง และความเบิกบานผ่องใสเป็นสุข', 'ถูกทุกข้อ', 'd', '2025-05-08 07:56:31', '2025-05-08 07:56:31'),
(115, 21, 4, '“สติ” แปลว่าอย่างไร', 'ความจําได้บ้าง ไม่ได้บ้าง', 'ความระลึกได้', 'ความไม่เผลอ ไม่เลินเล่อ ไม่ฟั่นเฟือนเลื่อนลอย', 'ข้อ ข. และ ข้อ ค. ถูก', 'd', '2025-05-08 07:56:31', '2025-05-08 07:56:31'),
(116, 21, 5, '“สมาธิ” แปลว่าอย่างไร', 'ความระลึกได้', 'ความตั้งมั่นของจิต', 'ความจําได้ หมายรู้', 'ความยึดมั่น ถือมั่น', 'b', '2025-05-08 07:56:31', '2025-05-08 07:56:31'),
(117, 21, 6, 'ก่อนเริ่มนั่งสมาธิในญาณที่ ๖ ผู้ปฏิบัติควรทําสิ่งใดก่อน', 'นั่งสมาธิทันที', 'เดินจงกรมระยะที่ ๓', 'กราบสติปัฏฐานก่อน', 'กําหนดลมหายใจ', 'c', '2025-05-08 07:56:31', '2025-05-08 07:56:31'),
(118, 21, 7, 'ลําดับขั้นตอนการปฏิบัติโดยทั่วไป มีดังนี้', 'กราบสติปัฏฐาน การเดินจงกรม การนั่งสาธิ', 'การนั่งสมาธิ กราบสติปัฏฐาน การเดินจงกรม', 'สวดมนต์ กราบสติปัฏฐาน การนั่งสมาธิ การเดินจงกรม', 'กราบสติปัฏฐาน สวดมนต์ การนั่งสมาธิ การเดินจงกรม', 'a', '2025-05-08 07:56:31', '2025-05-08 07:56:31'),
(119, 21, 8, 'ท่าที่ใช้ในการกําหนดขณะนั่งสมาธิของญาณที่ ๖ ได้แก่ข้อใด', 'พองหนอ - ยุบหนอ - นั่งหนอ - ถูกหนอ', 'ยืนหนอ - เดินหนอ - หยุดหนอ - นั่งหนอ', 'ขวาย่างหนอ - ซ้ายย่างหนอ - หยุดหนอ', 'ลุกหนอ - ยืนหนอ - คิดหนอ - พองหนอ', 'a', '2025-05-08 07:56:31', '2025-05-08 07:56:31'),
(120, 21, 9, 'การเดินจงกรมในบทที่ ๖ นี้ มีลําดับขั้นตอนอย่างไร', 'ยกหนอ - ยกส้นหนอ - ย่างหนอ - เหยียบหนอ', 'ยกส้นหนอ - ยกหนอ - ย่างหนอ - เหยียบหนอ', 'ยกหนอ - ย่างหนอ - เหยียบหนอ - ยกส้นหนอ', 'ยกส้นหนอ - ยกหนอ - เหยียบหนอ - ย่างหนอ', 'b', '2025-05-08 07:56:31', '2025-05-08 07:56:31'),
(121, 21, 10, 'ข้อใดไม่ใช่ประโยชน์ของการเดินจงกรม', 'อดทนต่อการเดินทางไกล', 'อดทนต่อการทําความเพียร', 'ทําให้เดินรวดเร็ว', 'ช่วยขับโรคลม', 'c', '2025-05-08 07:56:31', '2025-05-08 07:56:31'),
(122, 22, 1, '“สมาธิ” แบ่งได้กี่ระดับ', '๒ ระดับ คือ สมถะสมาธิ วิปัสสนาสมาธิ', '๑ ระดับ คือ ขณิกสมาธิ', '๒ ระดับ คือ สมาธิสั้น สมาธิยาว', '๓ ระดับ คือ ขณิกสมาธิ อุปจารสมาธิ อัปปนาสมาธิ', 'd', '2025-05-08 08:03:10', '2025-05-08 08:03:10'),
(123, 22, 2, 'ญาณที่เกิดแก่ผู้บําเพ็ญวิปัสสนาโดยลําดับมีกี่ญาณ', '๑๓ ญาณ', '๑๘ ญาณ', '๑๖ ญาณ', 'ผิดทุกข้อ', 'c', '2025-05-08 08:03:10', '2025-05-08 08:03:10'),
(124, 22, 3, '“วิปัสสนูกิเลส” หมายถึงอะไร', 'สภาวะที่ทําให้วิปัสสนากัมมัฏฐานมัวหมอง ขัดข้อง', 'สภาพน่าชื่นชม ซึ่งเกิดแก่ผู้เจริญวิปัสสนาในขั้นที่เป็นวิปัสสนาอย่างอ่อน แต่กลายเป็นโทษเครื่องเศร้า หมองแห่งวิปัสสนา', 'วิปัสสนูกิเลส เป็นโทษเครื่องเศร้าหมอง ทําให้เข้าใจผิดว่าตนบรรลุมรรคผลแล้ว จึงชะงักหยุดเสีย ไม่ ดําเนินก้าวหน้าต่อไปในวิปัสสนาญาณ', 'ถูกทุกข้อ', 'd', '2025-05-08 08:03:10', '2025-05-08 08:03:10'),
(125, 22, 4, 'ไตรลักษณ์ ๓ ประการ ได้แก่', 'ทุกขตา ความเป็นทุกข์ หรือความเป็นของคนทนอยู่มิได้', 'อนัตตา ความเป็นของมิใช่ตัวตน', 'อนิจจตา ความเป็นของไม่เที่ยง', 'ถูกทุกข้อ', 'd', '2025-05-08 08:03:10', '2025-05-08 08:03:10'),
(126, 22, 5, 'ลําดับขั้นตอนการปฏิบัติของแบบฝึกหัดที่ ๗ มีดังนี้', 'การกราบสติปัฏฐาน เดินจงกรม ๔ ระยะ นั่งสมาธิ', 'การกราบสติปัฏฐาน เดินจงกรม ๕ ระยะ นั่งสมาธิ', 'สวดมนต์ การกราบสติปัฏฐาน ๔ เดินจงกรม ๔ ระยะ', 'สวดมนต์ การกราบสติปัฏฐาน ๔ เดินจงกรม นั่งสมาธิ', 'a', '2025-05-08 08:03:10', '2025-05-08 08:03:10'),
(127, 22, 6, 'ลําดับการนั่งสมาธิของแบบฝึกหัดที่ ๗ มีดังนี้', 'พองหนอ ยุบหนอ นั่งหนอ ถูกหนอ ตาตุ่มด้านนอกขวา กําหนดว่า ถูกหนอ', 'พองหนอ ยุบหนอ นั่งหนอ ถูกหนอ ตาตุ่มด้านนอกซ้าย กําหนดว่า ถูกหนอ', 'พองหนอ ยุบหนอ นั่งหนอ ถูกหนอ ตาตุ่มด้านนอกขวา ตาตุ่มด้านนอกซ้าย', 'ข้อ ก. และ ข้อ ข. ถูกต้อง', 'd', '2025-05-08 08:03:10', '2025-05-08 08:03:10'),
(128, 22, 7, 'ท่าที่ใช้ในการเดินจงกรมระยะที่ ๔ ของญาณที่ ๗ คือข้อใด', 'ยกหนอ - ย่างหนอ - เหยียบหนอ', 'ยืนหนอ - เดินหนอ - หยุดหนอ', 'ยกส้นหนอ - ยกหนอ - ย่างหนอ - เหยียบหนอ', 'ก้าวขวาหนอ - ก้าวซ้ายหนอ - หยุดหนอ', 'c', '2025-05-08 08:03:10', '2025-05-08 08:03:10'),
(129, 22, 8, 'การเดินจงกรม ๔ ระยะ เรียงตามลําดับในแบบฝึกหัดที่ ๗ คือ', 'ยกส้นหนอ - ยกหนอ - ย่างหนอ - ถูกหนอ', 'ยกส้นหนอ - ยกหนอ - ย่างหนอ - กดหนอ', 'ยกหนอ - ยกส้นหนอ - ย่างหนอ - เหยียบหนอ', 'ยกส้นหนอ - ยกหนอ - ย่างหนอ - เหยียบหนอ', 'd', '2025-05-08 08:03:10', '2025-05-08 08:03:10'),
(130, 22, 9, 'การนั่งสมาธิให้เอามือไหนไว้ข้างบน', 'มือขวาทับมือซ้าย', 'มือซ้ายทับมือขวา', 'วางมือทั้งซ้ายและขวาบนขาซ้ายและขาขวา', 'ถูกทุกข้อ', 'd', '2025-05-08 08:03:10', '2025-05-08 08:03:10'),
(131, 22, 10, 'ขั้นตอนที่สองของการเดินจงกรม ๔ ระยะในแบบฝึกหัดที่ ๗ คืออะไร', 'ยกเท้า', 'ยกส้น', 'ก้าว', 'วาง', 'b', '2025-05-08 08:03:10', '2025-05-08 08:03:10'),
(132, 23, 1, '“กัมมัฏฐาน” แปลว่าอะไร', 'ที่ตั้งแห่งการงาน', 'อารมณ์เป็นที่ตั้งการงานของใจ', 'วิธีฝึกอบรมจิตใจและเจริญปัญญา', 'ถูกทุกข้อ', 'd', '2025-05-08 08:09:26', '2025-05-08 08:09:26'),
(133, 23, 2, 'อานิสงส์ของการปฏิบัติธรรม วิปัสสนากัมมัฏฐาน มีอะไรบ้าง', 'ทําลายกองกิเลส โลภะ โทสะ โมหะ', 'ปิดประตูอบาย', 'มีศรัทธาต่อพระรัตนตรัย', 'ถูกทุกข้อ', 'd', '2025-05-08 08:09:26', '2025-05-08 08:09:26'),
(134, 23, 3, '“นิวรณ์ ๕” คืออะไร', 'อุปสรรคขวางกั้นการปฏิบัติธรรม', 'การส่งสริมการปฏิบัติธรรม', 'ความรู้สึกอาลัยอาวรณ์', 'ความรู้สึกครุ่นคิดถึงอดีต', 'a', '2025-05-08 08:09:26', '2025-05-08 08:09:26'),
(135, 23, 4, '“นิวรณ์ ๕” มีกี่ประเภท ได้แก่อะไรบ้าง', ' มี 4 ประเภท ได้แก่ ฉันทะ, วิริยะ, จิตตะ, วิมังสา', 'มี 5 ประเภท ได้แก่ กามฉันทะ, พยาบาท, ถีนมิทธะ, อุทธัจจกุกกุจจะ, วิจิกิจฉา', 'มี 5 ประเภท ได้แก่ สัทธา, วิริยะ, สติ, สมาธิ, ปัญญา', 'มี 6 ประเภท ได้แก่ กามราคะ, โทสะ, โมหะ, มานะ, ทิฏฐิ, วิจิกิจฉา', 'b', '2025-05-08 08:09:26', '2025-05-08 08:09:26'),
(136, 23, 5, 'ทางสายเอกในอรรถกา หมายถึงอะไร', 'ทาน ศีล ภาวนา', 'มรรคมีองค์ ๘', 'อริยสัจ ๔', 'พรหมวิหาร ๔', 'b', '2025-05-08 08:09:26', '2025-05-08 08:09:26'),
(137, 23, 6, 'การเดินจงกรมในแบบฝึกหัดที่ ๘ มีกี่ระยะ', '๒ ระยะ', '๓ ระยะ', '๔ ระยะ', '๕ ระยะ', 'c', '2025-05-08 08:09:26', '2025-05-08 08:09:26'),
(138, 23, 7, 'การนั่งสมาธิตามลําดับขั้นในแบบฝึกหัดนี้ มีอย่างไรบ้าง', 'พองหนอ ยุบหนอ นั่งหนอ ถูกหนอ หลังเท้าขวา กําหนดถูกหนอ', 'พองหนอ ยุบหนอ นั่งหนอ ถูกหนอ หลังเท้าซ้าย กําหนดถูกหนอ', 'การกําหนดในใจว่าถูกหนอ ให้นึกภาพกําหนดลักษณะและขนาดจุดที่กําลังเพ่งพิจารณานั้นให้เป็น วงกลมที่มีขนาดเท่ากับเหรียญสิบ', 'ถูกทุกข้อ', 'd', '2025-05-08 08:09:26', '2025-05-08 08:09:26'),
(139, 23, 8, 'การนั่งสมาธิเอาสติไว้ที่ไหน', 'ท้องเหนือสะดือ ๒ นิ้ว', 'หน้าผาก', 'ปลายจมูก', 'กลางอก', 'a', '2025-05-08 08:09:26', '2025-05-08 08:09:26'),
(140, 23, 9, 'เวลาหายใจเข้า ท้องจะมีอาการอย่างไร', 'ท้องยุบ', 'ท้องพอง', 'ไม่มีอาการพองหรือยุบ', 'ไม่ทราบ', 'b', '2025-05-08 08:09:26', '2025-05-08 08:09:26'),
(141, 23, 10, 'เมื่อเริ่มหายใจเข้า ให้เอาสติเพ่งพิจารณาอาการท้องพองหรือยุบเพียงอย่างเดียว พร้อมบริกรรมในใจว่าอย่างไร', 'พองหนอ ยุบหนอ', 'ยุบหนอ พองหนอ', 'เฉยๆ หนอ', 'ถูกทุกข้อ', 'a', '2025-05-08 08:09:26', '2025-05-08 08:09:26'),
(142, 24, 1, '“ขันธ์ ๕” ได้แก่อะไรบ้าง', 'ศีล ๕', 'รูป เวทนา สัญญา สังขาร วิญญาณ', 'เบญจศีล', 'ชอบใจ ไม่ชอบใจ ง่วง ฟุ้ง สงสัย', 'b', '2025-05-08 08:22:25', '2025-05-08 08:22:25'),
(143, 24, 2, 'หัวใจของการปฏิบัติวิปัสสนา คือ', 'การทำสมาธิให้จิตสงบ', 'การมีสติระลึกรู้ปัจจุบันขณะ', 'การสวดมนต์ภาวนาอย่างต่อเนื่อง', 'การฝึกอานาปานสติเป็นหลัก', 'b', '2025-05-08 08:22:25', '2025-05-08 08:22:25'),
(144, 24, 3, 'หลักในการปฏิบัติวิปัสสนากัมมัฏฐาน ๓ อย่างมีอะไรบ้าง', 'อาตาปี - เพียรตั้งใจทําจริง', 'สมฺปชาโน - มีความรู้สึกตัวทั่วพร้อมทุกขณะ', 'สติมา - มีสติติดตามกําหนดให้ได้ปัจจุบันธรรม', 'ถูกทุกข้อ', 'd', '2025-05-08 08:22:25', '2025-05-08 08:22:25'),
(145, 24, 4, 'การหายใจที่ใช้ในการปฏิบัติสมถกรรมฐานตามแบบฝึกหัดที่ ๙ เรียกว่าอะไร', 'อานาปานสติ', 'อิริยาบถสติ', 'กายคตาสติ', 'มรณสติ', 'a', '2025-05-08 08:22:25', '2025-05-08 08:22:25'),
(146, 24, 5, 'เป้าหมายสูงสุดของการปฏิบัติวิปัสสนากัมมัฏฐานคืออะไร', 'การมีสุขภาพจิตที่ดี', 'การเข้าฌานลึกซึ้ง', 'การรู้แจ้งเห็นจริงตามความเป็นจริง', 'การมีสมาธิจิตที่มั่นคง', 'c', '2025-05-08 08:22:25', '2025-05-08 08:22:25'),
(147, 24, 6, 'ขั้นตอนการฝึกปฏิบัติตามแบบฝึกหัดที่ ๙ มีดังนี้', 'กราบสติปัฏฐาน ๔ การเดินจงกรม ๔ ระยะ การนั่งสมาธิ', 'สวดมนต์ กราบสติปัฏฐาน ๔ นั่งสมาธิ การเดินจงกรม ๔ ระยะ', 'การเดินจงกรม ๔ ระยะ การนั่งสมาธิ กราบสติปัฏฐาน ๔', 'กราบสติปัฏฐาน ๔ การนั่งสมาธิ การเดินจงกรม', 'a', '2025-05-08 08:22:25', '2025-05-08 08:22:25'),
(148, 24, 7, 'ขั้นตอนการนั่งสมาธิตามแบบฝึกหัดที่ ๙ มีดังนี้', 'พองหนอ ยุบหนอ นั่งหนอ หัวเข่าขวา ถูกหนอ', 'พองหนอ ยุบหนอ นั่งหนอ หัวเข่าซ้าย ถูกหนอ', 'พองหนอ ยุบหนอ นั่งหนอ ตาตุ่มขวา ถูกหนอ', 'ข้อ ก. และ ข้อ ข. ถูกต้อง', 'd', '2025-05-08 08:22:25', '2025-05-08 08:22:25'),
(149, 24, 8, '“กัมมัฏฐาน” มีกี่ประเภท', '๒ ประเภท คือ สมถกัมมัฏฐาน วิปัสสนากัมมัฏฐาน', '๑ ประเภท คือ สมถกัมมัฏฐาน', '๑ ประเภท คือ วิปัสสนากัมมัฏฐาน', 'ผิดทุกข้อ', 'a', '2025-05-08 08:22:25', '2025-05-08 08:22:25'),
(150, 24, 9, '“สมถกัมมัฏฐาน” หรือ “สมถภาวนา” คืออะไร', 'คือการฝึกอบรมจิตให้เกิดความสงบ หรือการฝึกสมาธิ', 'คือการฝึกอบรมให้เกิดปัญญา ความรู้แจ้งตามความจริง', 'คือการฝึกอบรมให้เกิดปัญญาเฉลียวฉลาด', 'ถูกทุกข้อ', 'a', '2025-05-08 08:22:25', '2025-05-08 08:22:25'),
(151, 24, 10, '“วิปัสสนากัมมัฏฐาน” หรือ “วิปัสนาภาวนา” คืออะไร', 'คือการฝึกอบรมจิตให้เกิดความสงบ หรือการฝึกสมาธิ', 'คือการฝึกอบรมให้เกิดปัญญา ความรู้แจ้งตามความจริง', 'คือการฝึกอบรมให้เกิดความเงียบในใจ', 'ถูกทุกข้อ', 'b', '2025-05-08 08:22:25', '2025-05-08 08:22:25');

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`id`, `title`, `content`, `user_id`, `created_at`) VALUES
(2, 'พระพุทธเจ้า', 'พระพุทธเจ้าทรงตรัทศรู้ที่ไหน', 2, '2025-02-14 10:13:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `fname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telephone` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `education_id` int NOT NULL,
  `vipassana` tinyint(1) NOT NULL DEFAULT '0',
  `role` enum('admin','student') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `path_profile` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '../assets/img/profile.jpg',
  `last_active` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reset_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_expires` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fname`, `lname`, `email`, `password`, `remember_token`, `telephone`, `education_id`, `vipassana`, `role`, `path_profile`, `last_active`, `reset_token`, `reset_expires`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '$2y$10$28dHhf7uLt0EKxfAwtjF/.U9uxVpRH1B6G7qCuteBQ5F0fPD7eVLO', NULL, '0623894070', 3, 0, 'admin', '../assets/img/profile.jpg', '2025-05-08 08:40:58', '', '2025-02-09 12:40:03', '2025-02-03 08:25:57', '2025-02-03 08:25:57'),
(2, 'พิชยะ', 'สารเถื่อนแก้ว', 'pabigmz@gmail.com', '$2y$10$VulHKSWyXqdXo5lJRVd12.tb4Vpb75y5UGDfkIddrzvG5zwOemki6', NULL, '0623894070', 3, 0, 'student', '../assets/uploads/profile/67c320cbb46df.jpg', '2025-05-08 08:42:41', '080e55dc7d02a3ab2db50526cc2e8b09d9072ffe7eee112c73e5400d8bc84ba4ac2cfcf710a903fc4641a26f10ea8d3ee467', '2025-02-27 11:39:43', '2025-02-03 08:27:47', '2025-02-03 08:27:47'),
(9, 'user01', 'user01', 'user01@user.com', '$2y$10$USR2blj7F6cVOlcZdoFmG.8DvmpNzewvG/zqftjHab9tGWecwUPYe', NULL, '0623894070', 5, 1, 'student', '../assets/img/profile.jpg', '2025-02-24 18:05:43', NULL, '2025-02-23 19:15:30', '2025-02-23 19:15:30', '2025-02-23 19:15:30'),
(10, 'สมปอง', 'ประสิทธิโชค', 'user02@user.com', '$2y$10$OlxjErkxB0g83z2iWK7Q4.1u6cKMf6jefGbOlTKRG.tV6buGIzVAS', NULL, '0123456789', 6, 1, 'student', '../assets/img/profile.jpg', '2025-02-24 08:02:18', NULL, '2025-02-24 07:41:23', '2025-02-24 07:41:23', '2025-02-24 07:41:23'),
(11, 'ตัวอย่าง', 'ระบบ', 'example@gmail.com', '$2y$10$h2HrCHJELED.s7gU.6IdKeHrH9kKor9J5BlPI7VCEXwAl2/OYNdfG', NULL, '0123456789', 4, 0, 'student', '../assets/img/profile.jpg', '2025-04-06 16:13:55', NULL, '2025-03-24 02:38:25', '2025-03-24 02:38:25', '2025-03-24 02:38:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_practice_progress`
--

CREATE TABLE `user_practice_progress` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `practice_id` int NOT NULL,
  `video_watch_time` int NOT NULL,
  `pre_time` int NOT NULL DEFAULT '0',
  `post_time` int NOT NULL DEFAULT '0',
  `score_pre` int DEFAULT NULL,
  `score_post` int DEFAULT NULL,
  `pre_completed` tinyint(1) NOT NULL DEFAULT '0',
  `is_completed` tinyint(1) NOT NULL DEFAULT '0',
  `post_completed` tinyint(1) NOT NULL DEFAULT '0',
  `progress` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE `user_progress` (
  `id` int NOT NULL,
  `lesson_id` int NOT NULL,
  `user_id` int NOT NULL,
  `time_pre_test` int DEFAULT NULL,
  `content_time` int DEFAULT NULL,
  `time_post_test` int DEFAULT NULL,
  `score_pre` int DEFAULT NULL,
  `score_post` int DEFAULT NULL,
  `pre_completed` tinyint(1) NOT NULL DEFAULT '0',
  `post_completed` tinyint(1) NOT NULL DEFAULT '0',
  `progress` int NOT NULL DEFAULT '0',
  `is_completed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `evaluation_id` (`evaluation_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thread_id` (`thread_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `educationlevels`
--
ALTER TABLE `educationlevels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`evaluation_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`lesson_id`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `practice`
--
ALTER TABLE `practice`
  ADD PRIMARY KEY (`practice_id`);

--
-- Indexes for table `question_evaluation`
--
ALTER TABLE `question_evaluation`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `evaluation_id` (`evaluation_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `quizzes_practice`
--
ALTER TABLE `quizzes_practice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `practice_id` (`practice_id`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `education_id` (`education_id`);

--
-- Indexes for table `user_practice_progress`
--
ALTER TABLE `user_practice_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `practice_id` (`practice_id`);

--
-- Indexes for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=616;

--
-- AUTO_INCREMENT for table `certificate`
--
ALTER TABLE `certificate`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `educationlevels`
--
ALTER TABLE `educationlevels`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `evaluation_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=283;

--
-- AUTO_INCREMENT for table `practice`
--
ALTER TABLE `practice`
  MODIFY `practice_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `question_evaluation`
--
ALTER TABLE `question_evaluation`
  MODIFY `question_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `quizzes_practice`
--
ALTER TABLE `quizzes_practice`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_practice_progress`
--
ALTER TABLE `user_practice_progress`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `user_progress`
--
ALTER TABLE `user_progress`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`evaluation_id`),
  ADD CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question_evaluation` (`question_id`),
  ADD CONSTRAINT `answer_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `certificate`
--
ALTER TABLE `certificate`
  ADD CONSTRAINT `certificate_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD CONSTRAINT `login_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `question_evaluation`
--
ALTER TABLE `question_evaluation`
  ADD CONSTRAINT `question_evaluation_ibfk_1` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`evaluation_id`);

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quizzes_practice`
--
ALTER TABLE `quizzes_practice`
  ADD CONSTRAINT `quizzes_practice_ibfk_1` FOREIGN KEY (`practice_id`) REFERENCES `practice` (`practice_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `threads`
--
ALTER TABLE `threads`
  ADD CONSTRAINT `threads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`education_id`) REFERENCES `educationlevels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_practice_progress`
--
ALTER TABLE `user_practice_progress`
  ADD CONSTRAINT `user_practice_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_practice_progress_ibfk_2` FOREIGN KEY (`practice_id`) REFERENCES `practice` (`practice_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
