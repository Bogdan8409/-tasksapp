-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: localhost:3306
-- Timp de generare: nov. 20, 2025 la 08:57 AM
-- Versiune server: 8.0.30
-- Versiune PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `2webtasks`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `title` text NOT NULL,
  `dates` date NOT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `notes` varchar(255) NOT NULL,
  `status` enum('open','done') NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Eliminarea datelor din tabel `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `dates`, `starttime`, `endtime`, `notes`, `status`) VALUES
(2, 'testing', '2025-11-11', '04:05:00', '04:05:00', 'test', 'open'),
(3, 'testin', '2025-11-11', '04:05:00', '04:05:00', 'test', 'open'),
(4, 'testin', '2025-11-11', '04:05:00', '04:05:00', 'test', 'open'),
(5, 'testin', '2025-11-11', '04:05:00', '04:05:00', 'test', 'open'),
(8, 'testing', '2025-11-11', '04:05:00', '04:05:00', 'test', 'open'),
(9, 'testing', '2025-11-11', '04:05:00', '04:05:00', 'test', 'open'),
(11, 'testing', '2025-11-11', '04:05:00', '04:05:00', 'test', 'open'),
(12, 'testing', '2025-11-11', '04:05:00', '04:05:00', 'test', 'open'),
(20, '55456546', '2025-05-05', '11:11:00', '11:01:00', 'test3', 'done'),
(21, '55', '2025-05-05', '11:11:00', '11:01:00', 'test2', 'open'),
(44, '567', '2025-09-03', '14:04:00', '04:04:00', 'super test', 'open'),
(45, '909', '2025-12-08', '14:55:00', '17:00:00', 'zuper', 'open'),
(46, '908', '2025-12-08', '14:55:00', '17:00:00', 'zuper', 'open'),
(47, '908', '2025-12-08', '14:55:00', '17:00:00', 'zuper', 'open');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
