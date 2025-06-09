-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2025 at 04:56 PM
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
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `invoiceno` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_price` int(11) DEFAULT NULL,
  `paymethod` varchar(10) DEFAULT NULL,
  `cashier` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`invoiceno`, `date`, `total_price`, `paymethod`, `cashier`) VALUES
(1, '2024-11-22 00:03:44', 201, 'CASH', 2),
(2, '2024-11-16 11:41:31', NULL, NULL, 2),
(3, '2024-11-24 23:56:24', 20, 'UPI', 2),
(14, '2024-11-22 02:23:23', 910, 'CARD', 2),
(15, '2024-11-24 17:56:48', NULL, NULL, 2),
(17, '2024-11-25 09:06:48', NULL, NULL, 2),
(18, '2024-11-25 09:18:45', 914, 'UPI', 2),
(19, '2024-12-23 22:48:03', NULL, NULL, 2),
(20, '2024-12-23 22:48:06', NULL, NULL, 2),
(21, '2024-12-25 01:42:08', NULL, NULL, 2),
(22, '2025-01-04 16:55:39', NULL, NULL, 2),
(24, '2025-01-05 23:31:55', 729, 'CARD', 2),
(25, '2025-01-06 09:19:34', NULL, NULL, 2),
(26, '2025-01-08 10:09:50', 180080, 'CARD', 2),
(28, '2025-04-15 22:12:30', 125, 'UPI', 2);

-- --------------------------------------------------------

--
-- Table structure for table `bill_archive`
--

CREATE TABLE `bill_archive` (
  `invoiceno` int(11) NOT NULL,
  `prodid` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `tprice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_archive`
--

INSERT INTO `bill_archive` (`invoiceno`, `prodid`, `qty`, `tprice`) VALUES
(1, 1, 6, 150),
(1, 2, 1, 10),
(2, 3, 1, 400),
(3, 2, 2, 20),
(2, 1, 3, 75),
(1, 17, 1, 30),
(1, 5, 1, 11),
(14, 1, 2, 50),
(14, 17, 2, 60),
(14, 3, 2, 800),
(15, 3, 6, 2400),
(17, 1, 3, 66),
(18, 1, 4, 92),
(18, 3, 2, 800),
(18, 5, 2, 22),
(21, 1, 2, 46),
(21, 19, 2, 20),
(24, 1, 23, 529),
(24, 4, 10, 200),
(22, 1, 1, 23),
(25, 3, 10, 4000),
(26, 41, 9, 180000),
(26, 2, 8, 80),
(28, 1, 5, 115),
(28, 2, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prodid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `modifiedon` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prodid`, `name`, `price`, `stock`, `description`, `modifiedon`) VALUES
(1, 'MILMA MILK', 23, 552, 'sweet milk ', '2025-04-15 22:12:30'),
(2, 'LIFEBUOY SOAP', 10, 985, 'Lifebuoy Soap, good for health :)', '2025-04-15 22:12:30'),
(3, 'LOGITECH KEYBOARD', 400, 495, 'Logitech Keyboard ', '2024-11-25 09:18:45'),
(4, 'PHILIPS LIGHT BULB 10W', 20, 1000, 'PHILIPS LIGHT BULB 20W', '2025-04-15 22:09:11'),
(5, 'KITKAT', 11, 15, 'KIT KAT bro what else there to explain here???', '2024-11-25 09:18:45'),
(17, 'Snickers Biscuits', 30, 6, 'biscuit', '2024-11-22 02:23:23'),
(18, 'GM Extension Box', 400, 600, 'Extension Box by GM 2.4A', '2024-12-24 01:52:18'),
(19, 'USB C CABLE', 10, 10, 'usb cable', '2024-12-24 00:51:24'),
(22, 'AXE SPRAY', 20, 100, 'axe body spray', '2024-12-24 01:57:28'),
(23, 'Classmate Notebook 100page', 50, 7, 'Classmate 100 page Notebook', '2024-12-25 17:43:47'),
(38, 'Cadbury Dairy Milk', 40, 100, 'Cadbury Dairy Milk', '2024-12-25 17:42:54'),
(40, 'chips', 10, 100, 'salty', '2025-01-04 17:20:29'),
(41, 'Laptop', 20000, 1, 'laptop', '2025-01-08 10:09:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(24) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `type` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `password`, `email`, `phone`, `address`, `type`) VALUES
(1, 'Admin', '$2y$10$.7p2GnQqG/AdY.CLz2TOWeHGlqtCgPA3uzJmhQRGh59eYBl2P5ahC', 'admin@gmail.com', '2446789900', 'admin', 'Admin'),
(2, 'Cashier', '$2y$10$WmucKBiVwn1qZsJygFtpZOPLUXbpGuHJ8kVkaHbXn2YsUGDs3CEGC', 'cashier@gmail.com', '3344221133', 'cashiers', 'Cashier'),
(5, 'Stocker', '$2y$10$k4s0rizyKjgcczNchRXvWeCgIyv4qy9hqEfFt7ufMDdgFHCD.v27.', 'stocoker@gmail.com', '1334455667', 'stockers', 'Stocker');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`invoiceno`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prodid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `invoiceno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prodid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
