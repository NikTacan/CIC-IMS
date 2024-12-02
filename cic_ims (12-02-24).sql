-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 07:04 AM
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
(13, 11, 'nik', 'nik', 'nik', 'nik@gmail.com', '9123456789', 3, 'Male', '2024-11-19', 1, '2024-11-19');

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
(586, 'inventory', 'INSERT', 'lptp20240212001', 'Vivo Laptop 16x RYZEN 5600', 1, '\'s has been added to the Inventory record.', '2024-12-02 13:19:37'),
(587, 'inventory', 'INSERT', 'lptp20240212002', 'Vivo Laptop 16x RYZEN 5600', 1, '\'s has been added to the Inventory record.', '2024-12-02 13:19:37'),
(588, 'assignment', 'INSERT', '190', 'ton', 1, ' have new <b>Inventory assignment</b>.', '2024-12-02 13:20:59'),
(589, 'inventory', 'INSERT', 'lptp20240212002', 'Vivo Laptop 16x RYZEN 5600', 8, '\'s  \'1 pcs\' has been assigned to <b>ton</b>.', '2024-12-02 13:21:07');

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
(50, 'lptp20240212001', 2, 6, 1, 'Vivo Laptop 16x RYZEN 5600', 1, 1, 27, 35000, 3, '2024-12-02', '2024-12-02 13:19:37', 4),
(51, 'lptp20240212002', 2, 6, 1, 'Vivo Laptop 16x RYZEN 5600', 1, 0, 27, 40000, 3, '2024-12-02', '2024-12-02 13:19:37', 4);

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
(190, 8, NULL, '2024-12-02 13:20:59');

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
(79, 188, '13 nik', ' ', '2024-11-28 17:03:49', '2024-11-28 17:04:04'),
(80, 178, '8 ton', ' ', '2024-11-26 14:52:15', '2024-11-29 15:42:29');

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
(232, 190, 'lptp20240212002', 'Vivo Laptop 16x RYZEN 5600', 'Faculty Office', 'pcs', 1, 40000, 40000, '2024-12-02');

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
(14, 31, 'Bryl', 'S', 'Agpalo', '9123456789', 'male', 3, 0, '2024-11-28');

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
(31, 2, 'bryl', '$2y$10$pupEYVXo3oONX64qt/dTj.uss9vqOsSK9VHpPHOuW4b8MGFKTq81W', '2024-11-28 17:21:49'),
(35, 2, 'test', '$2y$10$2C98REW613mD.lGWcpUsD.PTFyRZdBBKbBsQwI86Z5HorJz.f7E7W', '2024-12-02 13:34:19');

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
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `estimated_life`
--
ALTER TABLE `estimated_life`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `history_log`
--
ALTER TABLE `history_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=593;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inv_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `inventory_assignment`
--
ALTER TABLE `inventory_assignment`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `inventory_assignment_archive`
--
ALTER TABLE `inventory_assignment_archive`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `inventory_assignment_archive_items`
--
ALTER TABLE `inventory_assignment_archive_items`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `inventory_assignment_item`
--
ALTER TABLE `inventory_assignment_item`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

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
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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
-- Constraints for table `sub_admin`
--
ALTER TABLE `sub_admin`
  ADD CONSTRAINT `fk_sub_admin` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subadmin_fk_designation` FOREIGN KEY (`designation`) REFERENCES `designation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
