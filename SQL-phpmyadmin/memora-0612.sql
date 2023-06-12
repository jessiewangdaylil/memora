-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-06-12 15:57:09
-- 伺服器版本： 10.4.27-MariaDB
-- PHP 版本： 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `memora`
--

-- --------------------------------------------------------

--
-- 資料表結構 `auth_levels`
--

CREATE TABLE `auth_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(20) NOT NULL,
  `role_name` varchar(20) NOT NULL,
  `desc` varchar(200) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `auth_levels`
--

INSERT INTO `auth_levels` (`id`, `title`, `role_name`, `desc`, `enable`, `created_at`, `updated_at`) VALUES
(1, '已註冊', '時空旅人', '使用者驗證:\r\nname,email,password', 1, '2023-06-12 13:51:24', '2023-06-12 13:51:24'),
(2, '會員功能啟用', '時空導航家', '會員功能啟用驗證\r\nuser\r\nidentify,name,first_name,last_name.\r\nuseradvance\r\nauth_level_id,user_id\',country_id,city_id,town_id\',road_id', 1, '2023-06-12 13:52:01', '2023-06-12 13:52:01');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `auth_levels`
--
ALTER TABLE `auth_levels`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `auth_levels`
--
ALTER TABLE `auth_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
