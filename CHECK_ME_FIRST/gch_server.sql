-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2023-04-22 03:51:01
-- 服务器版本： 10.4.27-MariaDB
-- PHP 版本： 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `gch_server`
--

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE `category` (
  `categories` varchar(50) NOT NULL,
  `info` varchar(200) NOT NULL DEFAULT 'catalog information not available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`categories`, `info`) VALUES
('BSG', 'Business simulation game'),
('FPS', 'First-person Shooter'),
('Horror', 'Horror game'),
('Music', 'Music game'),
('others', 'others'),
('Roguelike', 'plural rogueLikes'),
('RPG', 'Role-play game'),
('RTS', 'Real-time Strategy'),
('TBS', 'Turn-based Strategy'),
('TC', 'test category');

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `post_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `comments` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `comment`
--

INSERT INTO `comment` (`comment_id`, `item_id`, `user_id`, `post_time`, `comments`) VALUES
(1, 14, 1, '2023-04-05 16:59:36', 'can I comment now?'),
(2, 14, 1, '2023-04-05 16:59:46', 'what do you mean'),
(3, 14, 1, '2023-04-05 17:00:00', 'oh it is happening'),
(4, 14, 1, '2023-04-05 17:00:47', 'oh it is happening'),
(6, 14, 1, '2023-04-05 17:02:57', 'what do you mean'),
(7, 14, 1, '2023-04-05 17:55:03', 'what do you mean ah mean'),
(11, 14, 1, '2023-04-05 18:12:38', 'sdf ewr sdf'),
(14, 14, 8, '2023-04-05 18:12:55', 'user post comments'),
(15, 14, 1, '2023-04-14 04:48:30', 'new post, yes?'),
(19, 7, 8, '2023-04-21 05:42:01', 'yes'),
(20, 11, 8, '2023-04-21 05:43:27', 'nonono');

-- --------------------------------------------------------

--
-- 表的结构 `console`
--

CREATE TABLE `console` (
  `console_title` varchar(50) NOT NULL,
  `info` varchar(200) NOT NULL DEFAULT 'console information not available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `console`
--

INSERT INTO `console` (`console_title`, `info`) VALUES
('Atari', 'Real Old'),
('Nintendo Switch', 'console information not available'),
('others', 'console information not available'),
('PlayStation 4', 'console information not available'),
('PlayStation 5', 'console information not available'),
('Steam Deck', 'console information not available'),
('Test Console', 'test'),
('Xbox One', 'console information not available'),
('Xbox Series X/S', 'console information not available');

-- --------------------------------------------------------

--
-- 表的结构 `item`
--

CREATE TABLE `item` (
  `item_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `game` varchar(50) NOT NULL,
  `console` varchar(50) NOT NULL,
  `categories` varchar(50) NOT NULL,
  `area` varchar(50) NOT NULL,
  `current_condition` varchar(20) NOT NULL,
  `info` varchar(200) NOT NULL DEFAULT 'none',
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `img` varchar(50) NOT NULL DEFAULT 'NullImg.jpg',
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `item`
--

INSERT INTO `item` (`item_id`, `user_id`, `game`, `console`, `categories`, `area`, `current_condition`, `info`, `last_update`, `img`, `price`) VALUES
(5, 1, 'final fantasy XVI', 'PlayStation 5', 'RPG', 'Torlloern', 'DIGITAL_COPY_CODE', 'pre-ordered code, no longer want to keep it', '2023-04-21 21:47:24', 'NullImg.jpg', 149.99),
(6, 1, 'Guardian Tales', 'Nintendo Switch', 'TBS', 'Tokyo', 'DIGITAL_COPY_CODE', 'gacha game', '2023-04-21 21:48:07', 'NullImg.jpg', 1399),
(7, 1, 'testpricegame', 'others', 'RPG', 'Winterpeg', 'DIGITAL_COPY_CODE', 'price is wrong', '2023-04-21 21:48:32', 'NullImg.jpg', 1299),
(8, 1, 'wingspan', 'others', 'Roguelike', 'winnipeg', 'NEW', 'boardgame', '2023-04-21 21:49:07', 'NullImg.jpg', 6799),
(9, 1, 'BrianSaveMe', 'others', 'BSG', 'RRC', 'USED_NOT_LOOKING_PRE', 'This code has bug', '2023-04-21 21:49:16', 'NullImg.jpg', 123.99),
(11, 8, 'gameforuseronly', 'Nintendo Switch', 'BSG', 'Winterpeg', 'NEW', 'cool, very cool', '2023-04-21 21:49:25', 'NullImg.jpg', 3.99),
(14, 10, 'testergame', 'PlayStation 5', 'Music', 'Winterpeg', 'USED_LIKE_NEW', 'another!', '2023-04-21 21:49:35', 'NullImg.jpg', 32.98),
(17, 8, 'game', 'Atari', 'others', 'kakakakaka', 'USED_FAIR', 'img with it', '2023-04-21 21:49:58', 'NullImg.jpg', 12.98),
(18, 8, 'game', 'Atari', 'others', 'kakakakaka', 'USED_FAIR', 'img with it', '2023-04-21 21:50:06', 'NullImg.jpg', 12.98),
(19, 8, 'nahnahnah', 'Atari', 'BSG', 'asdasd', 'NEW', 'asdasdasdasd', '2023-04-21 21:50:13', 'NullImg.jpg', 13),
(34, 8, 'qwer', 'Atari', 'BSG', 'qwer', 'NEW', 'qwer', '2023-04-21 23:23:33', 'NullImg.jpg', 123.45),
(41, 1, 'testqwe', 'Atari', 'BSG', 'qwetest', 'NEW', 'qwetestewq', '2023-04-21 23:26:12', '64431b94916b26.02112481.jpg', 123.99);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `email` varchar(50) NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `info` varchar(200) NOT NULL DEFAULT 'Empty'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `name`, `password`, `role`, `email`, `register_date`, `info`) VALUES
(1, 'firstuser', 'firstpass', 'admin', 'first@email.com', '2023-03-24 00:57:24', 'do not try to e-mail me'),
(8, 'jad', 'jad2436', 'user', 'jad@hi.com', '2023-03-31 00:59:54', 'jad fu'),
(10, 'bob', 'tester', 'user', 'bob@mail.com', '2023-03-31 18:55:07', ''),
(13, 'ted', 'testing', 'user', 'ted@mail.com', '2023-04-14 18:51:26', ''),
(14, 'coolguy', 'socool', 'user', 'verycool@this.guy', '2023-04-22 01:44:22', 'I am just too cool');

--
-- 转储表的索引
--

--
-- 表的索引 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categories`);

--
-- 表的索引 `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `ITEMIDS` (`item_id`),
  ADD KEY `USERIDS` (`user_id`);

--
-- 表的索引 `console`
--
ALTER TABLE `console`
  ADD PRIMARY KEY (`console_title`);

--
-- 表的索引 `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `CATEGORY` (`categories`),
  ADD KEY `CONSOLETITLE` (`console`),
  ADD KEY `USERID` (`user_id`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用表AUTO_INCREMENT `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 限制导出的表
--

--
-- 限制表 `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `ITEMIDS` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `USERIDS` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `CATEGORY` FOREIGN KEY (`categories`) REFERENCES `category` (`categories`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `CONSOLETITLE` FOREIGN KEY (`console`) REFERENCES `console` (`console_title`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `USERID` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
