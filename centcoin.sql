-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 21, 2021 at 12:00 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `centcoin`
--

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE `deposit` (
  `id` int(11) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `package` text NOT NULL,
  `statuz` varchar(255) NOT NULL DEFAULT 'active',
  `amount` int(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deposit`
--

INSERT INTO `deposit` (`id`, `userid`, `package`, `statuz`, `amount`, `createdAt`) VALUES
(1, '60f40bcf225b1', 'undefined', 'active', 5000, '2021-07-19 18:38:14'),
(2, '60f40bcf225b1', 'undefined', 'active', 5000, '2021-07-19 18:40:00'),
(3, '60f40bcf225b1', 'undefined', 'active', 5000, '2021-07-19 18:41:00'),
(4, '60f40bcf225b1', 'undefined', 'active', 5000, '2021-07-19 18:42:29'),
(5, '60f5453fca2b7', 'undefined', 'active', 5000, '2021-07-19 18:43:09'),
(6, '60f5476c364ee', 'DEPOSIT PLAN', 'active', 2000, '2021-07-19 19:01:03');

-- --------------------------------------------------------

--
-- Table structure for table `logindetails`
--

CREATE TABLE `logindetails` (
  `id` int(11) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `hashvalue` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `fullname` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `messages` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `fullname`, `email`, `messages`, `createdAt`) VALUES
(1, 'emoney', 'mcmathbrian2@gmail.com', 'hello, i just made payment now', '2021-07-19 23:49:31'),
(2, 'richy', 'richard6@gmail.com', 'hello, i just made payment now', '2021-07-19 23:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `plan` text NOT NULL,
  `duration` int(10) NOT NULL,
  `percentages` text NOT NULL,
  `mindep` text NOT NULL,
  `maxdep` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `plan`, `duration`, `percentages`, `mindep`, `maxdep`) VALUES
(5, 'BASIC PLAN', 2, '4.5', '50', '1000'),
(6, 'SILVER PLAN', 4, '6.8', '1000', '5000'),
(7, 'DEPOSIT PLAN', 5, '10', '5000', 'unlimited'),
(8, 'PROMO PLAN', 2, '250', '300', 'unlimited');

-- --------------------------------------------------------

--
-- Table structure for table `paymentmethod`
--

CREATE TABLE `paymentmethod` (
  `id` int(11) NOT NULL,
  `bitcoin` varchar(255) NOT NULL,
  `ethereum` varchar(255) NOT NULL,
  `litecoin` varchar(255) NOT NULL,
  `paypal` varchar(255) NOT NULL,
  `venmo` varchar(255) NOT NULL,
  `zelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paymentmethod`
--

INSERT INTO `paymentmethod` (`id`, `bitcoin`, `ethereum`, `litecoin`, `paypal`, `venmo`, `zelle`) VALUES
(1, '3FZbgi29cpjq2GjdwV8eyHuJJnkLtktZc5', '0x71c7656ec7ab88b098defb751b7401b5f6d8976f', '3CDJNfdWX8m2NwuGUV3nhXHXEeLygMXoAj', 'example-email11@centcoin.com', 'example-email22@centcoin.com', 'example-email33@centcoin.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `fullname` text,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `isAdmin` varchar(10) NOT NULL DEFAULT 'false',
  `email` varchar(255) NOT NULL,
  `country` text,
  `plans` varchar(11) DEFAULT NULL,
  `accountbalance` int(255) DEFAULT '0',
  `currency` text,
  `referredby` varchar(255) DEFAULT NULL,
  `statuz` varchar(20) NOT NULL DEFAULT 'active',
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userid`, `fullname`, `username`, `pass`, `isAdmin`, `email`, `country`, `plans`, `accountbalance`, `currency`, `referredby`, `statuz`, `createdAt`) VALUES
(1, '60f40bcf225b1', 'emerald herold', 'emeranty', '12qw12', '', 'emerald@gmail.com', 'usd', 'basic plan', 14500, 'usd', '', 'active', '2021-07-18 12:09:03'),
(2, 'wer23dfr', 'herold main', 'heroldmoney', '12qw123', 'true', 'emeraldhycient@gmail.com', 'america', NULL, 0, NULL, NULL, 'active', '2021-07-18 18:11:35'),
(3, '60f5453fca2b7', 'emzy', 'emzy', 'Register1@', '', 'emzy@gmail.com', 'pound', 'basic', 5000, 'pound', '', 'active', '2021-07-19 10:26:23'),
(4, '60f5476c364ee', 'gotgoodname', 'gotgoodname', 'Kingking1@', 'false', 'gotgoodname@gmail.com', 'euro', 'silver', 2000, 'euro ', '', 'active', '2021-07-19 10:35:40');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal`
--

CREATE TABLE `withdrawal` (
  `id` int(11) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `wallet` varchar(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `statuz` varchar(30) NOT NULL DEFAULT 'pending',
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `withdrawal`
--

INSERT INTO `withdrawal` (`id`, `userid`, `wallet`, `amount`, `statuz`, `createdAt`) VALUES
(1, '60f40bcf225b1', 'secure-biz-bank', 5000, 'processed', '2021-07-18 22:35:04'),
(2, '60f40bcf225b1', 'gtb', 500, 'processed', '2021-07-18 23:14:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logindetails`
--
ALTER TABLE `logindetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paymentmethod`
--
ALTER TABLE `paymentmethod`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawal`
--
ALTER TABLE `withdrawal`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `logindetails`
--
ALTER TABLE `logindetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `paymentmethod`
--
ALTER TABLE `paymentmethod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `withdrawal`
--
ALTER TABLE `withdrawal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
