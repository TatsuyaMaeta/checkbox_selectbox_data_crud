-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2023 年 1 月 03 日 17:55
-- サーバのバージョン： 10.4.27-MariaDB
-- PHP のバージョン: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `checkbox_data_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `checkbox_data_table`
--

CREATE TABLE `checkbox_data_table` (
  `id` int(12) NOT NULL,
  `text` text DEFAULT NULL,
  `chkbx` text DEFAULT NULL,
  `status_emoji` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `checkbox_data_table`
--

INSERT INTO `checkbox_data_table` (`id`, `text`, `chkbx`, `status_emoji`, `date`) VALUES
(13, 'コナン', 'html,python,dart', 'emoji_2', '2023-01-03 16:50:42'),
(14, 'ほげ2', 'css', 'emoji_1', '2023-01-03 16:24:04'),
(17, 'ドラえもん', 'js,php,html,css,python,dart', 'emoji_5', '2023-01-03 16:32:42');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `checkbox_data_table`
--
ALTER TABLE `checkbox_data_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `checkbox_data_table`
--
ALTER TABLE `checkbox_data_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
