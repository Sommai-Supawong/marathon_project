-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2025 at 05:32 AM
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
-- Database: `running`
--

-- --------------------------------------------------------

--
-- Table structure for table `age_group`
--

CREATE TABLE `age_group` (
  `group_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `min_age` int(11) DEFAULT NULL,
  `max_age` int(11) DEFAULT NULL,
  `label` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `reg_id` int(11) DEFAULT NULL,
  `total_amount` float NOT NULL,
  `payment_time` datetime DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` enum('Success','Failed') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `price_rate`
--

CREATE TABLE `price_rate` (
  `price_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `runner_type` varchar(50) DEFAULT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `price_rate`
--

INSERT INTO `price_rate` (`price_id`, `category_id`, `runner_type`, `amount`) VALUES
(10, 1, 'Standard', 1200),
(11, 2, 'Standard', 800),
(12, 3, 'Standard', 500),
(13, 4, 'Standard', 350);

-- --------------------------------------------------------

--
-- Table structure for table `race_category`
--

CREATE TABLE `race_category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `distance_km` float NOT NULL,
  `start_time` time DEFAULT NULL,
  `time_limit` time DEFAULT NULL,
  `giveaway_type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `race_category`
--

INSERT INTO `race_category` (`category_id`, `name`, `distance_km`, `start_time`, `time_limit`, `giveaway_type`) VALUES
(1, 'Full Marathon', 42.195, NULL, NULL, NULL),
(2, 'Half Marathon', 21.1, NULL, NULL, NULL),
(3, 'Mini Marathon', 10.5, NULL, NULL, NULL),
(4, 'Fun Run', 5, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `reg_id` int(11) NOT NULL,
  `runner_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `price_id` int(11) DEFAULT NULL,
  `shipping_id` int(11) DEFAULT NULL,
  `reg_date` date DEFAULT NULL,
  `shirt_size` varchar(10) DEFAULT NULL,
  `bib_number` varchar(20) DEFAULT NULL,
  `status` enum('Pending','Paid','Cancelled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`reg_id`, `runner_id`, `category_id`, `price_id`, `shipping_id`, `reg_date`, `shirt_size`, `bib_number`, `status`) VALUES
(3, 2, 1, NULL, 2, '2025-12-23', 'L', 'R-0002', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `runner`
--

CREATE TABLE `runner` (
  `runner_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `citizen_id` varchar(20) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `is_disabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `runner`
--

INSERT INTO `runner` (`runner_id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `citizen_id`, `phone`, `email`, `address`, `is_disabled`) VALUES
(2, 'Sommai', 'Supawong', '2025-12-05', 'Male', '0000000000000', '', 'admin@example.com', '85 Malaiman Road, Muang, Nakhon Pathom 73000 Thailand', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_option`
--

CREATE TABLE `shipping_option` (
  `shipping_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `cost` float DEFAULT 0,
  `detail` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `shipping_option`
--

INSERT INTO `shipping_option` (`shipping_id`, `type`, `cost`, `detail`) VALUES
(1, 'EMS Delivery', 80, 'จัดส่งเสื้อและ BIB ถึงบ้านทางไปรษณีย์'),
(2, 'Self Pickup', 0, 'รับเสื้อและ BIB ด้วยตัวเองที่หน้างาน (ฟรี)');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `full_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `full_name`) VALUES
(1, 'admin', 'admin123', 'user', 'สมหมาย ผู้ดูแลระบบ'),
(4, 'admin01', 'admin123', 'admin', 'สมหมาย ผู้ดูแลระบบ'),
(5, 'user01', 'user123', 'user', 'สมชาย นักวิ่ง');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `age_group`
--
ALTER TABLE `age_group`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `reg_id` (`reg_id`);

--
-- Indexes for table `price_rate`
--
ALTER TABLE `price_rate`
  ADD PRIMARY KEY (`price_id`),
  ADD KEY `price_rate_ibfk_1` (`category_id`);

--
-- Indexes for table `race_category`
--
ALTER TABLE `race_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`reg_id`),
  ADD KEY `runner_id` (`runner_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `price_id` (`price_id`),
  ADD KEY `shipping_id` (`shipping_id`);

--
-- Indexes for table `runner`
--
ALTER TABLE `runner`
  ADD PRIMARY KEY (`runner_id`),
  ADD UNIQUE KEY `citizen_id` (`citizen_id`);

--
-- Indexes for table `shipping_option`
--
ALTER TABLE `shipping_option`
  ADD PRIMARY KEY (`shipping_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `age_group`
--
ALTER TABLE `age_group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `price_rate`
--
ALTER TABLE `price_rate`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `race_category`
--
ALTER TABLE `race_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `reg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `runner`
--
ALTER TABLE `runner`
  MODIFY `runner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shipping_option`
--
ALTER TABLE `shipping_option`
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `age_group`
--
ALTER TABLE `age_group`
  ADD CONSTRAINT `age_group_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `race_category` (`category_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`reg_id`) REFERENCES `registration` (`reg_id`);

--
-- Constraints for table `price_rate`
--
ALTER TABLE `price_rate`
  ADD CONSTRAINT `price_rate_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `race_category` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `registration`
--
ALTER TABLE `registration`
  ADD CONSTRAINT `registration_ibfk_1` FOREIGN KEY (`runner_id`) REFERENCES `runner` (`runner_id`),
  ADD CONSTRAINT `registration_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `race_category` (`category_id`),
  ADD CONSTRAINT `registration_ibfk_3` FOREIGN KEY (`price_id`) REFERENCES `price_rate` (`price_id`),
  ADD CONSTRAINT `registration_ibfk_4` FOREIGN KEY (`shipping_id`) REFERENCES `shipping_option` (`shipping_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
