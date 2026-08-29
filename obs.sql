-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2017 at 05:10 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `obs`
--

-- --------------------------------------------------------

--
-- Table structure for table `atm_cards`
--

CREATE TABLE `atm_cards` (
  `id` int(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `issued_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `atm_cards`
--

INSERT INTO `atm_cards` (`id`, `user_id`, `card_number`, `issued_at`, `status`, `created_at`, `expires_at`) VALUES
(1, 1987654321, '5573265105217923', '2017-05-08 12:06:00', 'active', '2017-05-08 12:05:11', '2019-05-08 12:06:00');

-- --------------------------------------------------------

--
-- Table structure for table `atm_requests`
--

CREATE TABLE `atm_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_name` varchar(100) NOT NULL,
  `recepient_name` varchar(100) NOT NULL,
  `recepient_id` int(11) NOT NULL,
  `amount` decimal(9,2) NOT NULL,
  `details` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `type`, `sender_id`, `sender_name`, `recepient_name`, `recepient_id`, `amount`, `details`, `created_at`) VALUES
(1, 'transfer', 25, 'Admin Owner', 'Peter gyamfi', 1987654321, '458.00', 'Money Transfer', '2017-05-08 12:10:30'),
(2, 'transfer', 25, 'Admin Owner', 'Keneddy Wilson', 20, '45.00', 'Money Transfer', '2017-05-08 12:11:00'),
(3, 'transfer', 20, 'Keneddy Wilson', 'Peter gyamfi', 1987654321, '23.00', 'Money Transfer', '2017-05-09 03:00:54'),
(4, 'transfer', 20, 'Keneddy Wilson', 'DSTV UTILITY', 22, '18.09', 'Utility Payment DSTV', '2017-05-09 03:03:16'),
(5, 'transfer', 20, 'Keneddy Wilson', 'ECG UTILITY', 23, '8.10', 'Utility Payment ECG', '2017-05-09 03:03:42'),
(6, 'transfer', 1987654321, 'Peter gyamfi', 'ECG UTILITY', 23, '27.14', 'Utility Payment ECG', '2017-05-09 03:08:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `verified_email` varchar(3) NOT NULL DEFAULT 'no',
  `balance` decimal(9,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_login_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `first_name`, `last_name`, `email`, `password`, `verified_email`, `balance`, `created_at`, `updated_at`, `last_login_at`) VALUES
(17, 'user', 'Anthony', 'Aboagye', 'tony@gmail.com', '7e071fd9b023ed8f18458a73613a0834f6220bd5cc50357ba3493c6040a9ea8c', 'no', '0.00', '2017-05-01 14:42:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'user', 'Kenedy', 'Wilson', 'kw@gmail.com', '21850913f16a77fc36fbebe178d41c54fcbd10d939e167a41ae86f6e9ea513da', 'no', '291.81', '2017-05-09 03:04:21', '2017-05-09 03:04:21', '0000-00-00 00:00:00'),
(22, 'user', 'DSTV', 'UTILITY', 'dstv@mail.com', '00d3a86470fd52a72e06bc7c0f060ddeecd97758ed98107f720fdb350dee9f84', 'no', '130.09', '2017-05-09 03:03:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'user', 'ECG', 'UTILITY', 'ecg@mail.com', '00d3a86470fd52a72e06bc7c0f060ddeecd97758ed98107f720fdb350dee9f84', 'no', '55.24', '2017-05-09 03:08:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'user', 'GWC', 'UTILITY', 'gwc@mail.com', '00d3a86470fd52a72e06bc7c0f060ddeecd97758ed98107f720fdb350dee9f84', 'no', '40.00', '2017-04-24 14:07:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'admin', 'Admin', 'Owner', 'admin@mail.com', '4194d1706ed1f408d5e02d672777019f4d5385c766a8c6ca8acba3167d36a7b9', 'no', '9999346.00', '2017-05-08 12:11:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(1987654321, 'user', 'Peter', 'gyamfi', 'pgyamfi@gmail.com', '21850913f16a77fc36fbebe178d41c54fcbd10d939e167a41ae86f6e9ea513da', 'no', '453.86', '2017-05-09 03:08:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atm_cards`
--
ALTER TABLE `atm_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `atm_requests`
--
ALTER TABLE `atm_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atm_cards`
--
ALTER TABLE `atm_cards`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `atm_requests`
--
ALTER TABLE `atm_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1987654322;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
