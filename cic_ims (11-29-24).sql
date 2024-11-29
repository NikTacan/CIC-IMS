-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 04:30 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cic_ims`
--

-- --------------------------------------------------------

--
-- Table structure for table `archive_inventory`
--

CREATE TABLE `archive_inventory` (
  `id` int(6) NOT NULL,
  `inv_id` int(6) NOT NULL,
  `property_no` varchar(18) NOT NULL,
  `category` varchar(30) NOT NULL,
  `location` varchar(30) NOT NULL,
  `article` varchar(30) NOT NULL,
  `description` longtext NOT NULL,
  `qty_pcard` int(7) NOT NULL,
  `qty_pcount` int(7) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `unit_cost` double NOT NULL,
  `est_life` varchar(30) NOT NULL,
  `acquisition_date` date NOT NULL,
  `remark` varchar(15) NOT NULL,
  `date_archived` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archive_inventory`
--

INSERT INTO `archive_inventory` (`id`, `inv_id`, `property_no`, `category`, `location`, `article`, `description`, `qty_pcard`, `qty_pcount`, `unit`, `unit_cost`, `est_life`, `acquisition_date`, `remark`, `date_archived`) VALUES
(33, 41, 'LPTP1001', '2 Computer', '5 Storage', '1 Hardware and Softwares', 'Vivo Laptop', 1, 1, '27 pcs', 35000, '3 5 years', '2024-11-28', '4 Serviceable', '2024-11-28 18:13:59');

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(4) NOT NULL,
  `article_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `article_name`) VALUES
(1, 'Hardware and Softwares');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(3) NOT NULL,
  `category_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`) VALUES
(2, 'Computer'),
(4, 'Hardware'),
(8, 'Vehicles'),
(10, 'Furnitures'),
(15, 'Supplies');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` int(3) NOT NULL,
  `designation_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `designation_name`) VALUES
(1, 'Faculty'),
(3, 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `end_user`
--

CREATE TABLE `end_user` (
  `id` int(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(15) NOT NULL,
  `middle_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(25) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `designation` int(3) NOT NULL,
  `sex` varchar(6) NOT NULL,
  `birthday` date DEFAULT NULL,
  `status` int(1) NOT NULL,
  `date_registered` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `end_user`
--

INSERT INTO `end_user` (`id`, `user_id`, `first_name`, `middle_name`, `last_name`, `email`, `contact`, `designation`, `sex`, `birthday`, `status`, `date_registered`) VALUES
(8, 6, 'Anthony', 'Silvano', 'Calubag', 'ton@gmail.com', '9123456784', 3, 'female', '2001-04-11', 1, '2024-10-21'),
(13, 11, 'nik', 'nik', 'nik', 'nik@gmail.com', '9123456789', 3, 'Male', '2024-11-19', 1, '2024-11-19'),
(17, 30, 'test', '', '', 'ascalubag@gmail.com', '9123456789', 3, 'male', '2024-11-28', 1, '2024-11-28'),
(18, 33, 'test1', '', '', 'ascalubag@gmail.com', '9123456789', 1, 'male', '2024-11-29', 1, '2024-11-29');

-- --------------------------------------------------------

--
-- Table structure for table `estimated_life`
--

CREATE TABLE `estimated_life` (
  `id` int(3) NOT NULL,
  `est_life` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estimated_life`
--

INSERT INTO `estimated_life` (`id`, `est_life`) VALUES
(2, '1 week'),
(4, '1 YEAR'),
(3, '5 years');

-- --------------------------------------------------------

--
-- Table structure for table `history_log`
--

CREATE TABLE `history_log` (
  `id` int(11) NOT NULL,
  `module` varchar(15) NOT NULL,
  `transaction_type` varchar(10) NOT NULL,
  `item_no` varchar(18) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `user_id` int(4) NOT NULL,
  `log_message` longtext NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_log`
--

INSERT INTO `history_log` (`id`, `module`, `transaction_type`, `item_no`, `description`, `user_id`, `log_message`, `date_time`) VALUES
(563, 'end_user', 'UPDATE', '178', 'DJI Battery 20v', 1, '\'s from <b>\'ton\' Inventory assignment</b> has been updated. Location:  \'IT Departments\' to \'IT Department\'.', '2024-11-29 11:00:58'),
(564, 'assignment', 'UPDATE', '178', 'DJI Battery 20v', 8, '\'s from <b>ton Inventory assignment</b> has been updated. From \'4 pcs\' to \'3 pcs\'.', '2024-11-29 11:12:21'),
(565, 'inventory', 'RETURNED', '435426', 'DJI Battery 20v', 1, '\'s, \'1 pcs\' has been returned to inventory record from <b>ton inventory assignment</b>.', '2024-11-29 11:12:21'),
(566, 'assignment', 'UPDATE', '178', 'DJI Battery 20v', 8, '\'s from <b>ton Inventory assignment</b> has been updated. Location:  \'IT Department\' to \'IT Departments\'.', '2024-11-29 11:14:01'),
(567, 'end_user', 'UPDATE', 'test1', 'test1', 1, ' end user\'s record has been updated. First name changed from \'test\' to \'test1\', Sex changed from \'Male\' to \'male\'', '2024-11-29 11:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inv_id` int(6) NOT NULL,
  `property_no` varchar(18) DEFAULT NULL,
  `category` int(3) DEFAULT NULL,
  `location` int(4) DEFAULT NULL,
  `article` int(4) DEFAULT NULL,
  `description` longtext NOT NULL,
  `qty_pcard` int(7) NOT NULL,
  `qty_pcount` int(7) NOT NULL,
  `unit` int(3) DEFAULT NULL,
  `unit_cost` double NOT NULL,
  `est_life` int(3) DEFAULT NULL,
  `acquisition_date` date DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `remark` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inv_id`, `property_no`, `category`, `location`, `article`, `description`, `qty_pcard`, `qty_pcount`, `unit`, `unit_cost`, `est_life`, `acquisition_date`, `date_added`, `remark`) VALUES
(9, '1142356', 4, 3, 1, 'DJI Drone', 2, 0, 27, 29000, 4, '2024-07-03', '2024-07-03 10:38:23', 4),
(10, '435426', 4, 3, 1, 'DJI Battery 20v', 5, 3, 27, 4000, 3, '2024-07-03', '2024-07-03 10:40:24', 4),
(12, '2415554', 2, 3, 1, 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 2, 0, 27, 47500, 3, '2024-05-01', '2024-07-03 10:44:25', 4),
(20, '202411191', 2, 6, 1, 'Laptop', 1, 1, 27, 20000, 3, '2024-11-19', '2024-11-19 13:35:05', 4),
(21, '202411192', 2, 6, 1, 'Laptop', 1, 1, 27, 20000, 3, '2024-11-19', '2024-11-19 13:35:05', 4),
(40, '111', 4, 6, 1, 'test', 1, 0, 27, 100, 4, '2024-11-26', '2024-11-26 15:29:12', 4),
(42, 'LPTP1002', 2, 5, 1, 'Vivo Laptop', 1, 1, 27, 35000, 3, '2024-11-28', '2024-11-28 09:58:37', 4),
(43, 'LPTP1003', 2, 5, 1, 'Vivo Laptop', 1, 1, 27, 40000, 3, '2024-11-28', '2024-11-28 09:58:37', 4),
(44, 'LPTP1004', 2, 5, 1, 'Vivo Laptop', 1, 1, 27, 50000, 3, '2024-11-28', '2024-11-28 09:58:37', 4),
(45, '314235', 4, 3, 1, 'Inten i5-120344K with Fan Cooler', 5, 5, 27, 9563, 3, '2024-07-03', '2024-11-28 10:07:06', 4);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_assignment`
--

CREATE TABLE `inventory_assignment` (
  `id` int(6) NOT NULL,
  `end_user` int(4) NOT NULL,
  `status` int(3) DEFAULT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_assignment`
--

INSERT INTO `inventory_assignment` (`id`, `end_user`, `status`, `date_added`) VALUES
(173, 8, NULL, '2024-11-19 13:36:29'),
(177, 8, NULL, '2024-11-26 14:36:44'),
(178, 8, NULL, '2024-11-26 14:52:15'),
(187, 8, NULL, '2023-11-26 16:30:24');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_assignment_archive`
--

CREATE TABLE `inventory_assignment_archive` (
  `id` int(6) NOT NULL,
  `assignment_id` int(6) NOT NULL,
  `end_user` varchar(20) NOT NULL,
  `status` varchar(15) DEFAULT NULL,
  `date_added` datetime NOT NULL,
  `date_archived` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_assignment_archive`
--

INSERT INTO `inventory_assignment_archive` (`id`, `assignment_id`, `end_user`, `status`, `date_added`, `date_archived`) VALUES
(68, 175, '8 ton', ' ', '2024-11-19 13:42:09', '2024-11-19 23:25:46'),
(69, 163, '8 ton', ' ', '2023-10-29 10:50:41', '2024-11-19 23:25:49'),
(70, 169, '8 ton', ' ', '2024-10-30 14:32:45', '2024-11-20 01:09:02'),
(71, 170, '8 ton', ' ', '2024-11-06 12:04:29', '2024-11-20 01:09:51'),
(72, 180, '8 ton', ' ', '2024-11-26 15:35:06', '2024-11-26 15:40:41'),
(73, 185, '13 nik', ' ', '2024-11-26 15:47:34', '2024-11-26 16:03:03'),
(74, 176, '13 nik', ' ', '2024-11-19 23:25:54', '2024-11-26 16:12:51'),
(75, 186, '8 ton', ' ', '2024-11-26 16:13:23', '2024-11-26 16:18:33'),
(76, 189, '13 nik', ' ', '2024-11-28 16:27:26', '2024-11-28 16:27:44'),
(79, 188, '13 nik', ' ', '2024-11-28 17:03:49', '2024-11-28 17:04:04');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_assignment_archive_items`
--

CREATE TABLE `inventory_assignment_archive_items` (
  `id` int(6) NOT NULL,
  `assignment_id` int(6) NOT NULL,
  `property_no` varchar(18) NOT NULL,
  `description` longtext NOT NULL,
  `unit` varchar(20) NOT NULL,
  `qty` int(7) NOT NULL,
  `unit_cost` double NOT NULL,
  `total_cost` double NOT NULL,
  `acquisition_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_assignment_item`
--

CREATE TABLE `inventory_assignment_item` (
  `id` int(6) NOT NULL,
  `assignment_id` int(6) NOT NULL,
  `property_no` varchar(18) NOT NULL,
  `description` longtext NOT NULL,
  `location` varchar(30) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `qty` int(7) NOT NULL,
  `unit_cost` double NOT NULL,
  `total_cost` double NOT NULL,
  `acquisition_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_assignment_item`
--

INSERT INTO `inventory_assignment_item` (`id`, `assignment_id`, `property_no`, `description`, `location`, `unit`, `qty`, `unit_cost`, `total_cost`, `acquisition_date`) VALUES
(218, 173, '1142356', 'DJI Drone', 'IT Departments', 'pcs', 2, 29000, 58000, '2024-07-03'),
(219, 177, '435426', 'DJI Battery 20v', 'IT Department', 'pcs', 2, 4000, 8000, '2024-07-03'),
(220, 178, '435426', 'DJI Battery 20v', 'IT Departments', 'pcs', 3, 4000, 12000, '2024-07-03'),
(224, 187, '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 'IT Department', 'pcs', 2, 47500, 95000, '2024-05-01'),
(229, 187, '111', 'test', 'Faculty Office', 'pcs', 1, 100, 100, '2024-11-26');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transfer`
--

CREATE TABLE `inventory_transfer` (
  `id` int(6) NOT NULL,
  `new_end_user` int(4) NOT NULL,
  `old_end_user` int(4) NOT NULL,
  `date_added` date NOT NULL,
  `date_transferred` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transfer_item`
--

CREATE TABLE `inventory_transfer_item` (
  `id` int(6) NOT NULL,
  `transfer_id` int(6) NOT NULL,
  `property_no` int(18) NOT NULL,
  `description` longtext NOT NULL,
  `location` varchar(30) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `qty` int(7) NOT NULL,
  `unit_cost` double NOT NULL,
  `total_cost` double NOT NULL,
  `acquisition_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(4) NOT NULL,
  `location_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `location_name`) VALUES
(6, 'Faculty Office'),
(3, 'IT Department'),
(5, 'Storage');

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `id` int(3) NOT NULL,
  `note_name` varchar(15) NOT NULL,
  `module` varchar(15) NOT NULL,
  `color` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`id`, `note_name`, `module`, `color`) VALUES
(4, 'Serviceable', 'inventory', '#5ADA86'),
(24, 'Unserviceable', 'inventory', 'red');

-- --------------------------------------------------------

--
-- Table structure for table `sub_admin`
--

CREATE TABLE `sub_admin` (
  `id` int(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(15) NOT NULL,
  `middle_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `sex` varchar(6) NOT NULL,
  `designation` int(3) NOT NULL,
  `status` int(1) NOT NULL,
  `date_registered` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_admin`
--

INSERT INTO `sub_admin` (`id`, `user_id`, `first_name`, `middle_name`, `last_name`, `contact`, `sex`, `designation`, `status`, `date_registered`) VALUES
(13, 27, 'sub', 'sub', 'sub', '9123456789', 'female', 3, 1, '2024-11-28'),
(14, 31, 'sub', 'sub', 'sub', '9123456789', 'Male', 3, 1, '2024-11-28');

-- --------------------------------------------------------

--
-- Table structure for table `system_content`
--

CREATE TABLE `system_content` (
  `id` int(3) NOT NULL,
  `sys_name` varchar(50) NOT NULL,
  `login_image` varchar(80) NOT NULL,
  `logo_file` varchar(80) NOT NULL,
  `address` varchar(50) NOT NULL,
  `theme` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_content`
--

INSERT INTO `system_content` (`id`, `sys_name`, `login_image`, `logo_file`, `address`, `theme`) VALUES
(1, 'CIC - IMS', 'login-image-background.65f3f1567e07b7.77560300.jpg', 'report-logo.65f3f09c793b32.90510276.png', 'Inigo St. Bo. Obrero, Davao City', 3);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(3) NOT NULL,
  `unit_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `unit_name`) VALUES
(24, 'bundle'),
(27, 'pcs'),
(26, 'rim');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(4) NOT NULL,
  `role_id` int(3) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `date_created`) VALUES
(1, 1, 'admin', '$2y$10$Ui7xjotkzkN475xwGlKSHOS0otw1GTeBU.w.khjVCybA4bSyMa/VC', '2024-01-20 22:31:22'),
(6, 3, 'ton', '$2y$10$l2agObbVLyAN.sHQVaSbjuTlbRZFOnWmGQB9BHgtZvvRYdYiBALGi', '2024-10-21 12:50:08'),
(11, 3, 'nik', '$2y$10$5xnYr7xBNiBnbaUHstNp0e7UL/dy1Ool78OI8rbW3T6pSfSvh4RFm', '2024-11-19 23:25:35'),
(27, 2, 'sub', '$2y$10$/a9Xt6wsnlp09vbk5nxX1.RJBPyXyhHST6hj5YK2nLmWF.tzfDUGe', '2024-11-28 15:05:10'),
(30, 3, 'test', '$2y$10$ps.5Znl.Q4MPJ9Exv1Zoae5x09yYU9JSc34zrygVWzxSVW7dggGkq', '2024-11-28 16:49:36'),
(31, 2, 'sub1', '$2y$10$pU1yZtDWOEI5LOeyfr0jgO26YxA1.lt8MVFLMJ7sMv4Fz7WYT9OAi', '2024-11-28 17:21:49'),
(33, 3, 'test1', '$2y$10$byQ/YPgqWD2r6VQDa.8RruaKiRCSc9P.7X5HvV9x.U5mzLAnpmRfC', '2024-11-29 10:49:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archive_inventory`
--
ALTER TABLE `archive_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `end_user`
--
ALTER TABLE `end_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enduser_fk_designation` (`designation`),
  ADD KEY `fk_end_user` (`user_id`);

--
-- Indexes for table `estimated_life`
--
ALTER TABLE `estimated_life`
  ADD PRIMARY KEY (`id`),
  ADD KEY `est_life` (`est_life`);

--
-- Indexes for table `history_log`
--
ALTER TABLE `history_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inv_id`),
  ADD KEY `category` (`category`),
  ADD KEY `inventory_fk_location` (`location`),
  ADD KEY `unit` (`unit`),
  ADD KEY `inventory_fk_unit` (`est_life`),
  ADD KEY `inventory_fk_remark` (`remark`),
  ADD KEY `inventory_fk_article` (`article`);

--
-- Indexes for table `inventory_assignment`
--
ALTER TABLE `inventory_assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `inventory_assignment_archive`
--
ALTER TABLE `inventory_assignment_archive`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assignment_id` (`assignment_id`);

--
-- Indexes for table `inventory_assignment_archive_items`
--
ALTER TABLE `inventory_assignment_archive_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_archive_fk_id` (`assignment_id`);

--
-- Indexes for table `inventory_assignment_item`
--
ALTER TABLE `inventory_assignment_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_fk_id` (`assignment_id`);

--
-- Indexes for table `inventory_transfer`
--
ALTER TABLE `inventory_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_transfer_item`
--
ALTER TABLE `inventory_transfer_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_fk_transfer_id` (`transfer_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_name` (`location_name`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `note_name` (`note_name`);

--
-- Indexes for table `sub_admin`
--
ALTER TABLE `sub_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subadmin_fk_designation` (`designation`),
  ADD KEY `fk_sub_admin` (`user_id`);

--
-- Indexes for table `system_content`
--
ALTER TABLE `system_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_id` (`id`),
  ADD KEY `unit_name` (`unit_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD KEY `users_ibfk_1` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archive_inventory`
--
ALTER TABLE `archive_inventory`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `end_user`
--
ALTER TABLE `end_user`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `estimated_life`
--
ALTER TABLE `estimated_life`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `history_log`
--
ALTER TABLE `history_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=568;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inv_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `inventory_assignment`
--
ALTER TABLE `inventory_assignment`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT for table `inventory_assignment_archive`
--
ALTER TABLE `inventory_assignment_archive`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `inventory_assignment_archive_items`
--
ALTER TABLE `inventory_assignment_archive_items`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `inventory_assignment_item`
--
ALTER TABLE `inventory_assignment_item`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT for table `inventory_transfer`
--
ALTER TABLE `inventory_transfer`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `inventory_transfer_item`
--
ALTER TABLE `inventory_transfer_item`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `sub_admin`
--
ALTER TABLE `sub_admin`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `system_content`
--
ALTER TABLE `system_content`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `end_user`
--
ALTER TABLE `end_user`
  ADD CONSTRAINT `enduser_fk_designation` FOREIGN KEY (`designation`) REFERENCES `designation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_end_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_fk_article` FOREIGN KEY (`article`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_fk_category` FOREIGN KEY (`category`) REFERENCES `category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_fk_location` FOREIGN KEY (`location`) REFERENCES `location` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_fk_remark` FOREIGN KEY (`remark`) REFERENCES `note` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_fk_unit` FOREIGN KEY (`est_life`) REFERENCES `estimated_life` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `unit` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `inventory_assignment_archive_items`
--
ALTER TABLE `inventory_assignment_archive_items`
  ADD CONSTRAINT `assignment_archive_fk_id` FOREIGN KEY (`assignment_id`) REFERENCES `inventory_assignment_archive` (`assignment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory_assignment_item`
--
ALTER TABLE `inventory_assignment_item`
  ADD CONSTRAINT `assignment_fk_id` FOREIGN KEY (`assignment_id`) REFERENCES `inventory_assignment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory_transfer_item`
--
ALTER TABLE `inventory_transfer_item`
  ADD CONSTRAINT `inventory_fk_transfer_id` FOREIGN KEY (`transfer_id`) REFERENCES `inventory_transfer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_admin`
--
ALTER TABLE `sub_admin`
  ADD CONSTRAINT `fk_sub_admin` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subadmin_fk_designation` FOREIGN KEY (`designation`) REFERENCES `designation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
