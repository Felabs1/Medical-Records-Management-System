-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 07, 2021 at 08:15 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `favor`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `num_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `date_added`, `num_count`) VALUES
(5, 'Vaccine', '2021-05-29 11:24:32', 2),
(6, 'Antibiotics', '2021-05-29 11:24:43', 1),
(7, 'Prophylaxis', '2021-05-29 11:25:30', 0),
(8, 'releivers', '2021-05-29 11:29:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `med_name` varchar(40) NOT NULL,
  `chem_name` varchar(40) NOT NULL,
  `category` int(20) NOT NULL,
  `price` varchar(20) NOT NULL,
  `image` varchar(250) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity_left` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `med_name`, `chem_name`, `category`, `price`, `image`, `date_added`, `quantity_left`) VALUES
(7, 'Amoxil (500mg)', 'Trimox', 6, '50', '../images/uploads/amoxilin.jpeg', '2021-05-29 11:28:04', 2),
(8, 'amlopidin(5mg)', 'Norvasc', 8, '800', '../images/uploads/amlodipin.jpeg', '2021-05-29 11:30:24', 1),
(9, 'Cordeine(250ml)', 'Cordeine Diet', 1, '300', '../images/uploads/codeine.jpeg', '2021-05-29 12:01:29', 1),
(11, 'Astrazeneca', 'A<sub>2</sub>O', 5, '4000', '../images/uploads/astrazeneca.jpeg', '2021-06-05 19:26:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `serial_no` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `price` int(11) NOT NULL,
  `sold_to` varchar(40) NOT NULL,
  `date_sold` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `serial_no`, `name`, `price`, `sold_to`, `date_sold`) VALUES
(9, '1234', 'amlopidin', 800, 'Felabs', '2021-05-29 14:47:35'),
(10, '12346', 'Amoxil (500mg)', 50, 'Felix awere', '2021-05-31 14:10:39'),
(11, '673467764', 'Cordeine', 300, 'Asin', '2021-05-31 14:11:27'),
(12, '12345', 'Amoxil (500mg)', 50, '22', '2021-05-31 14:12:18'),
(13, '23454325', 'Astrazeneca', 4000, 'Felabs', '2021-06-01 12:40:45'),
(14, '23456787654', 'Cordeine', 300, 'Person x', '2021-06-01 12:41:49'),
(15, '67467467', 'amlopidin', 800, 'Test User 3', '2021-06-06 19:43:19'),
(16, '2345432', 'Cordeine(250ml)', 300, 'Asshole', '2021-06-07 17:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(10) UNSIGNED NOT NULL,
  `serial_no` varchar(55) NOT NULL,
  `stock_name` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'in_stock',
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `serial_no`, `stock_name`, `status`, `date_added`) VALUES
(16, '1234', 8, 'sold_out', '2021-05-29 14:47:26'),
(17, '12345', 7, 'sold_out', '2021-05-29 14:49:16'),
(18, '12346', 7, 'sold_out', '2021-05-29 14:51:49'),
(19, '673467764', 9, 'sold_out', '2021-05-31 14:11:13'),
(20, '23454325', 10, 'sold_out', '2021-06-01 12:40:19'),
(21, '234543267', 9, 'in_stock', '2021-06-01 12:41:17'),
(22, '23456787654', 9, 'sold_out', '2021-06-01 12:41:34'),
(23, '2345432', 9, 'sold_out', '2021-06-03 09:17:56'),
(24, '67467467', 8, 'sold_out', '2021-06-05 19:21:26'),
(25, 'nu785hf8', 8, 'in_stock', '2021-06-07 08:11:06'),
(26, 'dfghjbvcxz', 11, 'in_stock', '2021-06-07 09:35:13'),
(27, 'hfyduyh7587', 7, 'in_stock', '2021-06-07 17:25:56'),
(28, '784783hjcjhd', 7, 'in_stock', '2021-06-07 17:26:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(40) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(20) NOT NULL,
  `date_registered` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `phone`, `password`, `usertype`, `date_registered`, `last_login`) VALUES
(1, 'Admin', '0787654321', '$2y$10$HjShvT5as/JaCOKnb6DkS.W3BGpcPQUz2C8445WgNdMqy0YtdqRYS', 'admin', '2021-05-28 08:50:42', '2021-06-07 05:11:42'),
(2, 'Oduor Joel', '1234567890', '$2y$10$jldYOHLXk/mVdzCMoSv7XOZvBfPxXP0/qnVQvxwVYXra.2XlvKpmG', 'other', '2021-06-07 16:16:17', '2021-06-07 04:30:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
