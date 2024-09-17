-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2024 at 04:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `notepad`
--

-- --------------------------------------------------------

--
-- Table structure for table `archived`
--

CREATE TABLE `archived` (
  `archived_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note_title` varchar(50) NOT NULL,
  `note_content` varchar(200) NOT NULL,
  `archived_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archived`
--

INSERT INTO `archived` (`archived_id`, `user_id`, `note_title`, `note_content`, `archived_at`) VALUES
(1, 31, '', 'da', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note_id` int(11) NOT NULL,
  `note_title` varchar(50) NOT NULL,
  `note_content` varchar(200) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `note_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note_title` varchar(50) NOT NULL,
  `note_content` varchar(200) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`note_id`, `user_id`, `note_title`, `note_content`, `created_at`) VALUES
(1, 99, '', 'adasd', '2024-04-26'),
(24, 36, '', 'z', '2024-04-27'),
(25, 36, '', '', '2024-04-27'),
(26, 36, '', 'dad', '2024-04-27'),
(48, 31, 'aa', 'ada', '2024-04-27'),
(49, 31, 'adada', 'adad', '2024-04-27'),
(50, 31, '', 'dada', '2024-04-27');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `p_id` int(11) NOT NULL,
  `p_fname` varchar(200) NOT NULL,
  `p_lname` varchar(200) NOT NULL,
  `p_username` varchar(200) NOT NULL,
  `p_email` varchar(50) NOT NULL,
  `p_password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`p_id`, `p_fname`, `p_lname`, `p_username`, `p_email`, `p_password`) VALUES
(31, 'a', 'a', 'a', 'a@gmail.com', '$2y$10$O6eEsUB.6hNoJcy6x531vu3LkobzCMXWIaX3xvHhTlgAt0K36PI6y'),
(32, 'a', 'a', '1', '1@gmail.com', '$2y$10$UtjDdDiEUxRYKrDT9M9xTu0lg4tenMMf.5fB.ErmIClVaX73wexe.'),
(33, 'a', '1', '11', '1@gmail.com', '$2y$10$9mSV75dsqUXKF6eaLzhZ1.x9EpAR18/0uAJO3M0kKYXyCm0BPzkWC'),
(34, '1', '1', '1', '1@gmail.com', '$2y$10$6z4zzBihufR9ilyLM2VSEOR6fXrfpHLlYQAog8b73p/u./qSqPbRy'),
(35, 'ad', 'ada', 'dad', '2@gmail.com', '$2y$10$coS3efQ3LU4X6oVX7NcD3Ok7cqLTQlokjAwCMF7kq71KMGbTzZOwC'),
(36, 'a', 'a', 'z', 'z@gmail.com', '$2y$10$T2L95.jr2aadvybrW4xHaeDBwN8FJEMeqSSiBpIYLxgrJzQbvdiMW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archived`
--
ALTER TABLE `archived`
  ADD PRIMARY KEY (`archived_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `note_id` (`note_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`note_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`p_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archived`
--
ALTER TABLE `archived`
  MODIFY `archived_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
