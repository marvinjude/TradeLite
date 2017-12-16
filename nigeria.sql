-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2017 at 03:41 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nigeria`
--

-- --------------------------------------------------------

--
-- Table structure for table `balance_brought_foward`
--

CREATE TABLE `balance_brought_foward` (
  `id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `balance_brought_foward`
--

INSERT INTO `balance_brought_foward` (`id`, `amount`, `date`) VALUES
(1, 567890, '2017-09-12'),
(2, 88888, '2017-10-14'),
(3, 777, '2017-10-08'),
(4, 89, '2017-10-15'),
(5, 89, '2017-10-15'),
(6, 899, '2017-10-27'),
(7, 688, '2017-10-20'),
(8, 9999999, '2017-10-22'),
(9, 1000000, '2017-10-07'),
(10, 34000, '2017-10-06'),
(11, 22000, '2017-10-10'),
(12, 4555, '2017-10-14'),
(13, 6789876, '2017-10-15'),
(14, 67657, '2017-10-15');

-- --------------------------------------------------------

--
-- Table structure for table `bank_deposits`
--

CREATE TABLE `bank_deposits` (
  `id` int(11) NOT NULL,
  `bank_name` text NOT NULL,
  `date_deposited` date NOT NULL,
  `amount_deposited` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank_deposits`
--

INSERT INTO `bank_deposits` (`id`, `bank_name`, `date_deposited`, `amount_deposited`) VALUES
(1, 'eco', '2017-09-12', 567890),
(2, 'diamond bank', '2017-10-08', 90000),
(3, 'FIRST BANK', '2017-10-10', 12000),
(4, 'UBA', '2017-10-10', 200),
(5, 'gt bank', '2017-10-14', 670),
(6, 'nolas', '2017-10-15', 7845),
(7, 'olando', '2017-10-15', 78765),
(8, 'jude', '2017-10-15', 78),
(9, 'first bank', '2017-10-15', 5600000);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(30) NOT NULL,
  `customer_phone` varchar(11) NOT NULL,
  `date_created` date NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_name`, `customer_phone`, `date_created`, `address`) VALUES
(50, 'jude parker', '07069149074', '2017-10-11', 'isolo'),
(51, 'jacob', '09067345627', '2017-10-13', 'Joke street, eleko'),
(52, 'kola', '0908756432', '2017-10-13', ''),
(54, 'Jude', '09045678966', '2017-12-07', ''),
(87, 'KEM ROY', '07039226020', '2017-12-07', ''),
(88, 'jui', '07066440077', '2017-12-07', '');

-- --------------------------------------------------------

--
-- Table structure for table `customer_deposits`
--

CREATE TABLE `customer_deposits` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount_deposited` int(11) NOT NULL,
  `date_deposited` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_deposits`
--

INSERT INTO `customer_deposits` (`id`, `customer_id`, `amount_deposited`, `date_deposited`) VALUES
(13, 11, 8998, '2017-09-12'),
(14, 0, 888, '2017-09-03'),
(15, 0, 8997, '2017-09-10'),
(16, 11, 89778, '2017-09-26'),
(17, 0, 999, '0000-00-00'),
(18, 10, 99000, '2017-10-08'),
(19, 42, 890, '2017-09-12'),
(20, 43, 50000, '2017-10-06'),
(21, 46, 13000, '2017-10-10'),
(22, 50, 54, '2017-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `debtors`
--

CREATE TABLE `debtors` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `invoice` int(11) DEFAULT NULL,
  `debt_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `debtors`
--

INSERT INTO `debtors` (`id`, `customer_id`, `amount`, `invoice`, `debt_date`) VALUES
(1, 50, 0, 1000, '2017-12-05'),
(2, 51, 0, NULL, '0000-00-00'),
(3, 51, 67, NULL, '0000-00-00'),
(4, 51, 67, NULL, '0000-00-00'),
(5, 51, 0, NULL, '0000-00-00'),
(6, 51, 67, NULL, '0000-00-00'),
(7, 51, 67, NULL, '0000-00-00'),
(8, 51, 0, NULL, '0000-00-00'),
(9, 50, 0, NULL, '0000-00-00'),
(10, 50, 0, NULL, '2017-12-21'),
(11, 50, 0, NULL, '2017-12-21'),
(12, 0, 0, NULL, '1970-01-01'),
(13, 50, 0, NULL, '2017-12-03'),
(14, 50, 0, NULL, '2017-12-23'),
(15, 0, 0, NULL, '1970-01-01'),
(16, 0, 0, NULL, '1970-01-01'),
(17, 0, 0, NULL, '1970-01-01'),
(18, 0, 0, NULL, '1970-01-01'),
(19, 0, 0, NULL, '1970-01-01'),
(20, 0, 0, NULL, '1970-01-01'),
(21, 0, 0, NULL, '1970-01-01'),
(22, 50, 0, NULL, '2017-12-02'),
(23, 52, 90, NULL, '2017-12-02'),
(24, 52, 888, NULL, '2017-12-09');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `expense_description` text NOT NULL,
  `expense_amount` int(11) NOT NULL,
  `expense_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expense_description`, `expense_amount`, `expense_date`) VALUES
(1, 'to to sa', 890, '2017-09-14'),
(2, 'IGBO', 10, '2017-09-09'),
(3, 'ERAN DIN DIN', 50, '2017-09-15'),
(4, 'GENERATOR FUEL', 4500, '2017-10-07'),
(5, 'TRANSPORTATION TO LAGOS', 2017, '2017-10-07'),
(6, 'fuel - big gen', 20000, '2017-10-06'),
(7, 'FUEL', 4000, '2017-10-10'),
(8, 'TRANSPORTATION', 11111, '2017-10-10'),
(9, 'smoke and drink', 30, '2017-10-14'),
(10, 'judo', 678999, '2017-10-15'),
(11, 'visa fee to london', 75000, '2017-10-15'),
(12, 'TRANSPORTATION TO LAGOS', 500, '2017-10-22');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `seller_id` varchar(100) NOT NULL,
  `sale_date` date NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `amount_paid` decimal(18,2) NOT NULL,
  `supply_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `seller_id`, `sale_date`, `invoice_number`, `total`, `amount_paid`, `supply_status`) VALUES
(8, 52, '', '2017-12-16', 1001, '269718.12', '269718.12', 0),
(9, 54, '', '2017-12-16', 1002, '2977078.98', '2977078.98', 1),
(10, 51, '', '2017-12-16', 1003, '83970.00', '83970.00', 0),
(11, 51, '', '2017-12-16', 1004, '117.77', '117.77', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `cost_per_ton` int(11) DEFAULT '0',
  `quantity_in_store` int(11) NOT NULL DEFAULT '0',
  `last_receive_date` date DEFAULT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `description`, `cost_per_ton`, `quantity_in_store`, `last_receive_date`, `date_created`) VALUES
(1, '20mm', 67890, 279916, '2017-09-24', '2017-09-24'),
(2, '10mm', 888, -3297, '2017-09-25', '2017-09-25'),
(3, '100mm', 6555, 76615, '2017-09-25', '2017-09-25'),
(5, '20MM IMPORTED', 30000, -187195, '2017-10-06', '2017-10-06'),
(6, '16mm local', 16000, -243, '2017-10-09', '2017-10-09'),
(7, '22mm tiger', 22000, 21921, '2017-10-09', '2017-10-09');

-- --------------------------------------------------------

--
-- Table structure for table `subsales`
--

CREATE TABLE `subsales` (
  `id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(18,2) NOT NULL,
  `selling_price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `price_per_ton` decimal(18,4) NOT NULL,
  `sale_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subsales`
--

INSERT INTO `subsales` (`id`, `stock_id`, `quantity`, `subtotal`, `selling_price`, `price_per_ton`, `sale_id`) VALUES
(259, 3, 12, '336.15', '28.01', '6555.0000', 199),
(260, 5, 34, '6104.89', '179.56', '8080.0000', 200),
(261, 7, 67, '27296.30', '407.41', '22000.0000', 201),
(262, 5, 50, '75268.82', '1505.38', '140000.0000', 202),
(263, 5, 899, '34710.42', '38.61', '30000.0000', 1),
(264, 3, 888, '654.91', '0.74', '6555.0000', 2),
(265, 3, 899, '6547.72', '7.28', '6555.0000', 3),
(266, 1, 999, '7630.75', '7.64', '67890.0000', 4),
(267, 5, 888, '2997.30', '3.38', '30000.0000', 5),
(268, 2, 89, '888.00', '9.98', '888.0000', 6),
(269, 3, 99, '6555.00', '66.21', '6555.0000', 7),
(270, 5, 88989, '269718.12', '3.03', '30000.0000', 8),
(271, 3, 89, '7479.42', '84.04', '6555.0000', 9),
(272, 5, 88989, '2969599.56', '33.37', '30000.0000', 9),
(273, 2, 90, '80.00', '0.89', '888.0000', 10),
(274, 1, 99, '67890.00', '685.76', '67890.0000', 10),
(275, 6, 999, '16000.00', '16.02', '16000.0000', 10),
(276, 2, 87, '117.77', '1.35', '888.0000', 11);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `type`, `date_created`) VALUES
(2, 'ALHAJI', 'MARVINJUDE', 2, '2017-09-23'),
(9, 'JUDE', '', 1, '2017-10-05'),
(11, 'CHARLES', 'TOBILOBA', 1, '2017-10-06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balance_brought_foward`
--
ALTER TABLE `balance_brought_foward`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_deposits`
--
ALTER TABLE `bank_deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_deposits`
--
ALTER TABLE `customer_deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `debtors`
--
ALTER TABLE `debtors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subsales`
--
ALTER TABLE `subsales`
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
-- AUTO_INCREMENT for table `balance_brought_foward`
--
ALTER TABLE `balance_brought_foward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `bank_deposits`
--
ALTER TABLE `bank_deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `customer_deposits`
--
ALTER TABLE `customer_deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `debtors`
--
ALTER TABLE `debtors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `subsales`
--
ALTER TABLE `subsales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
