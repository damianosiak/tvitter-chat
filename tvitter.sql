-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2022 at 11:59 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tvitter`
--

-- --------------------------------------------------------

--
-- Table structure for table `dislikes`
--

CREATE TABLE `dislikes` (
  `post` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `dislikes`
--

INSERT INTO `dislikes` (`post`, `user`) VALUES
(15, 4);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `post` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `pid` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `content` varchar(512) COLLATE utf8_polish_ci NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `dislikes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`pid`, `user`, `date`, `content`, `likes`, `dislikes`) VALUES
(1, 3, '2022-11-12 16:22:04', 'test', 0, 0),
(2, 3, '2022-11-12 16:22:30', 'ba', 0, 0),
(3, 3, '2022-11-12 16:24:04', 'test', 0, 0),
(4, 3, '2022-11-12 16:38:44', 'blaakakakak', 0, 0),
(5, 3, '2022-11-12 16:39:38', 'drgrergtrdtg', 0, 0),
(6, 3, '2022-11-12 16:39:39', 'rdgdgr', 0, 0),
(7, 3, '2022-11-12 16:44:47', 'test', 0, 0),
(8, 3, '2022-11-12 17:23:39', 'ba abab aba', 0, 0),
(9, 4, '2022-11-13 13:50:41', 'test', 0, 0),
(13, 4, '2022-11-13 14:15:06', 't', 0, 0),
(14, 4, '2022-11-13 16:31:35', 'a', 0, 0),
(15, 4, '2022-11-13 16:34:28', 'Witam wszystkich bardzo serdecznie :-)', 0, 1),
(16, 4, '2022-11-14 19:10:22', 'test', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `sid` varchar(16) COLLATE utf8_polish_ci NOT NULL,
  `user` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`sid`, `user`, `date`) VALUES
('68NO4YTWIEJCUPM7', 4, '2022-11-14 19:10:19'),
('6KZ7XEANFOSBIML1', 4, '2022-11-14 19:19:08'),
('7GKYEJW405XHAC2R', 3, '2022-11-13 14:47:05'),
('L7T59SMBUHN2X6RD', 4, '2022-11-13 15:06:12'),
('P0XOH6EUIT7M2ZR8', 1, '2022-11-12 15:15:39'),
('PHE8TUGB9J3X26ZF', 2, '2022-11-12 15:16:57'),
('TFX4HJWD5RP691GZ', 4, '2022-11-13 20:27:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `login` varchar(32) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(96) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_polish_ci NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `login`, `password`, `email`, `locked`) VALUES
(1, 'user1', '$argon2i$v=19$m=65536,t=4,p=1$WnpLd1N2N09iRnZUOXpIQg$MlzFTigBP3aEGNRSt6K7Aw0jlmpa3nftYvZBjp+ESGY', 'user1@gmail.com', 0),
(2, 'user2', '$argon2i$v=19$m=65536,t=4,p=1$ekJJQ3d1bXg0TnhVT0ljYg$9PFExlj73CZUW4JNJUXetdNwgscU7WMqWu1bT0iXPqs', 'user2@gmail.com', 0),
(3, 'user5', '$argon2i$v=19$m=65536,t=4,p=1$RVY1d2dTUjlZaVlTay9OSg$+zkr/679xo2lAP+qaIT0pz35oR1KQaFREB3qUDPVYrs', 'user5@gmail.com', 0),
(4, 'user3', '$argon2i$v=19$m=65536,t=4,p=1$cFM1eE5hdHNZSnVUTVFCaA$9Cl0NDw/zObVSz1pg/D+1SNXuapEg0Vti9nqKUcxI1I', 'user3@gmail.com', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sid_unique` (`sid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
