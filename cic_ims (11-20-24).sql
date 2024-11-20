-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 06:30 AM
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
(32, 11, '314235', '4 Hardware', '3 IT Department', '1 Hardware and Softwares', 'Inten i5-120344K with Fan Cooler', 5, 5, '27 pcs', 9563, '3 5 years', '2024-07-03', '4 Serviceable', '2024-11-20 00:28:05');

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
  `username` varchar(20) NOT NULL,
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

INSERT INTO `end_user` (`id`, `username`, `first_name`, `middle_name`, `last_name`, `email`, `contact`, `designation`, `sex`, `birthday`, `status`, `date_registered`) VALUES
(8, 'ton', 'Anthonys', 'Silvanos', 'Calubags', 'ton@gmail.com', '9123456784', 3, 'female', '2001-04-11', 1, '2024-10-21'),
(13, 'nik', 'nik', 'nik', 'nik', 'nik@gmail.com', '9123456789', 3, 'Male', '2024-11-19', 1, '2024-11-19');

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
(352, 'inventory', 'INSERT', '202411191', 'Laptop', 1, '\'s has been added to the Inventory record.', '2024-11-19 13:35:05'),
(353, 'inventory', 'INSERT', '202411192', 'Laptop', 1, '\'s has been added to the Inventory record.', '2024-11-19 13:35:05'),
(354, 'assignment', 'INSERT', 'ton', 'ton', 1, ' have new <b>Inventory assignment</b>.', '2024-11-19 13:36:29'),
(355, 'end_user', 'INSERT', '202411191', 'Laptop', 1, '\'s  \'1 pcs\' has been assigned to <b>ton</b>.', '2024-11-19 13:37:11'),
(356, 'end_user', 'INSERT', '202411192', 'Laptop', 1, '\'s  \'1 pcs\' has been assigned to <b>ton</b>.', '2024-11-19 13:37:11'),
(357, 'assignment', 'INSERT', 'ton', 'ton', 1, ' have new <b>Inventory assignment</b>.', '2024-11-19 13:40:11'),
(358, 'inventory', 'UPDATE', '435426', 'DJI Battery 20v', 1, '\'s, \'2 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-11-19 13:41:03'),
(359, 'end_user', 'UPDATE', '8', 'DJI Battery 20v', 1, '\'s has been removed from 8 assignments.', '2024-11-19 13:41:03'),
(360, 'inventory', 'UPDATE', '202411191', 'Laptop', 1, '\'s, \'1 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-11-19 13:41:24'),
(361, 'end_user', 'UPDATE', '8', 'Laptop', 1, '\'s has been removed from 8 assignments.', '2024-11-19 13:41:24'),
(362, 'assignment', 'INSERT', 'ton', 'ton', 1, ' have new <b>Inventory assignment</b>.', '2024-11-19 13:42:09'),
(363, 'inventory', 'ARCHIVE', '8', 'epson projector', 1, 'has been moved to Inventory archived.', '2024-11-19 13:49:33'),
(364, 'inventory', 'UPDATE', '11', 'Inten i5-120344K with Fan Cooler', 1, '\'s information has been updated. Estimated useful life changed from \'5 years\' to \'1 YEAR\' , Remark changed from \'Serviceable\' to \'\' ', '2024-11-19 13:53:51'),
(365, 'inventory', 'INSERT', '111', 'sample', 1, '\'s has been added to the Inventory record.', '2024-11-19 14:51:55'),
(366, 'inventory', 'INSERT', '122', 'sample', 1, '\'s has been added to the Inventory record.', '2024-11-19 14:51:55'),
(367, 'inventory', 'ARCHIVE', '23', 'sample', 1, 'has been moved to Inventory archived.', '2024-11-19 14:59:37'),
(368, 'inventory', 'ARCHIVE', '22', 'sample', 1, 'has been moved to Inventory archived.', '2024-11-19 14:59:43'),
(369, 'inventory', 'INSERT', '111', 'test', 1, '\'s has been added to the Inventory record.', '2024-11-19 15:49:28'),
(370, 'inventory', 'INSERT', '222', 'test', 1, '\'s has been added to the Inventory record.', '2024-11-19 15:49:28'),
(371, 'inventory', 'ARCHIVE', '24', 'test', 1, 'has been moved to Inventory archived.', '2024-11-19 15:51:49'),
(372, 'inventory', 'ARCHIVE', '25', 'test', 1, 'has been moved to Inventory archived.', '2024-11-19 15:51:55'),
(373, 'inventory', 'INSERT', '111', 'test', 1, '\'s has been added to the Inventory record.', '2024-11-19 15:52:37'),
(374, 'inventory', 'INSERT', '222', 'test', 1, '\'s has been added to the Inventory record.', '2024-11-19 15:52:37'),
(375, 'inventory', 'ARCHIVE', '26', 'test', 1, 'has been moved to Inventory archived.', '2024-11-19 15:53:33'),
(376, 'inventory', 'ARCHIVE', '27', 'test', 1, 'has been moved to Inventory archived.', '2024-11-19 15:53:40'),
(377, 'inventory', 'INSERT', '111', 'test', 1, '\'s has been added to the Inventory record.', '2024-11-19 15:54:21'),
(378, 'inventory', 'INSERT', '222', 'test', 1, '\'s has been added to the Inventory record.', '2024-11-19 15:54:21'),
(379, 'inventory', 'ARCHIVE', '28', 'test', 1, 'has been moved to Inventory archived.', '2024-11-19 15:58:43'),
(380, 'inventory', 'ARCHIVE', '29', 'test', 1, 'has been moved to Inventory archived.', '2024-11-19 15:58:53'),
(381, 'inventory', 'INSERT', '111', 'laptop', 1, '\'s has been added to the Inventory record.', '2024-11-19 16:13:19'),
(382, 'inventory', 'INSERT', '222', 'laptop', 1, '\'s has been added to the Inventory record.', '2024-11-19 16:13:19'),
(383, 'inventory', 'ARCHIVE', '30', 'laptop', 1, 'has been moved to Inventory archived.', '2024-11-19 22:51:58'),
(384, 'inventory', 'ARCHIVE', '31', 'laptop', 1, 'has been moved to Inventory archived.', '2024-11-19 22:52:02'),
(385, 'inventory', 'INSERT', '111', 'test', 1, '\'s has been added to the Inventory record.', '2024-11-19 22:52:57'),
(386, 'inventory', 'INSERT', '222', 'test', 1, '\'s has been added to the Inventory record.', '2024-11-19 22:52:57'),
(387, 'inventory', 'ARCHIVE', '32', 'test', 1, 'has been moved to Inventory archived.', '2024-11-19 23:08:51'),
(388, 'inventory', 'ARCHIVE', '33', 'test', 1, 'has been moved to Inventory archived.', '2024-11-19 23:08:55'),
(389, 'inventory', 'INSERT', '111', 'test', 1, '\'s has been added to the Inventory record.', '2024-11-19 23:09:28'),
(390, 'inventory', 'INSERT', '222', 'test', 1, '\'s has been added to the Inventory record.', '2024-11-19 23:09:28'),
(391, 'inventory', 'ARCHIVE', '34', 'test', 1, 'has been moved to Inventory archived.', '2024-11-19 23:11:12'),
(392, 'inventory', 'ARCHIVE', '35', 'test', 1, 'has been moved to Inventory archived.', '2024-11-19 23:11:15'),
(393, 'inventory', 'INSERT', '111', 'test', 1, '\'s has been added to the Inventory record.', '2024-11-19 23:11:38'),
(394, 'inventory', 'INSERT', '222', 'test', 1, '\'s has been added to the Inventory record.', '2024-11-19 23:11:38'),
(395, 'inventory', 'INSERT', '333', 'test', 1, '\'s has been added to the Inventory record.', '2024-11-19 23:12:10'),
(396, 'inventory', 'INSERT', '444', 'test', 1, '\'s has been added to the Inventory record.', '2024-11-19 23:13:03'),
(397, 'inventory', 'ARCHIVE', '36', 'test', 1, 'has been moved to Inventory archived.', '2024-11-19 23:13:50'),
(398, 'inventory', 'ARCHIVE', '37', 'test', 1, 'has been moved to Inventory archived.', '2024-11-19 23:13:53'),
(399, 'inventory', 'ARCHIVE', '38', 'test', 1, 'has been moved to Inventory archived.', '2024-11-19 23:13:57'),
(400, 'inventory', 'ARCHIVE', '39', 'test', 1, 'has been moved to Inventory archived.', '2024-11-19 23:14:00'),
(401, 'end_user', 'INSERT', 'nik nik', 'nik nik', 1, '\'s has been added to <b>End user</b> records.', '2024-11-19 23:25:35'),
(402, 'assignment', 'ARCHIVE', '175', 'ton', 1, '\'s inventory assignment record has been archived.', '2024-11-19 23:25:46'),
(403, 'assignment', 'ARCHIVE', '163', 'ton', 1, '\'s inventory assignment record has been archived.', '2024-11-19 23:25:49'),
(404, 'assignment', 'INSERT', 'nik', 'nik', 1, ' have new <b>Inventory assignment</b>.', '2024-11-19 23:25:54'),
(405, 'end_user', 'INSERT', '202411191', 'Laptop', 1, '\'s  \'1 pcs\' has been assigned to <b>nik</b>.', '2024-11-19 23:26:06'),
(406, 'end_user', 'INSERT', '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s  \'1 pcs\' has been assigned to <b>nik</b>.', '2024-11-19 23:30:04'),
(407, 'inventory', 'UPDATE', '11', 'Inten i5-120344K with Fan Cooler', 1, '\'s information has been updated. Remark changed from \'Unserviceable\' to \'\' ', '2024-11-19 23:33:31'),
(408, 'inventory', 'UPDATE', '11', 'Inten i5-120344K with Fan Cooler', 1, '\'s information has been updated. Remark changed from \'Serviceable\' to \'24\' ', '2024-11-19 23:36:03'),
(409, 'inventory', 'UPDATE', '11', 'Inten i5-120344K with Fan Cooler', 1, '\'s information has been updated. Remark changed from \'Unserviceable\' to \'\' ', '2024-11-19 23:37:55'),
(410, 'inventory', 'UPDATE', '11', 'Inten i5-120344K with Fan Cooler', 1, '\'s information has been updated. Remark changed from \'Serviceable\' to \'Unserviceable\' ', '2024-11-19 23:38:21'),
(411, 'inventory', 'UPDATE', '11', 'Inten i5-120344K with Fan Cooler', 1, '\'s information has been updated. Remark changed from \'Unserviceable\' to \'Serviceable\' ', '2024-11-19 23:38:42'),
(412, 'inventory', 'UPDATE', '11', 'Inten i5-120344K with Fan Cooler', 1, '\'s information has been updated. Estimated useful life changed from \'1 YEAR\' to \'5 years\' , Remark changed from \'Serviceable\' to \'Unserviceable\' ', '2024-11-19 23:39:27'),
(413, 'inventory', 'UPDATE', '9', 'DJI Drone', 1, '\'s information has been updated. Remark changed from \'Serviceable\' to \'Unserviceable\' ', '2024-11-20 00:22:19'),
(414, 'inventory', 'UPDATE', '9', 'DJI Drone', 1, '\'s information has been updated. Remark changed from \'Unserviceable\' to \'Serviceable\' ', '2024-11-20 00:24:41'),
(415, 'inventory', 'UPDATE', '11', 'Inten i5-120344K with Fan Cooler', 1, '\'s information has been updated. Remark changed from \'Unserviceable\' to \'Serviceable\' ', '2024-11-20 00:27:06'),
(416, 'inventory', 'ARCHIVE', '11', 'Inten i5-120344K with Fan Cooler', 1, 'has been moved to Inventory archived.', '2024-11-20 00:28:05'),
(417, 'inventory', 'UPDATE', '435426', 'DJI Battery 20v', 1, '\'s, \'1 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-11-20 00:54:23'),
(418, 'end_user', 'UPDATE', '8', 'DJI Battery 20v', 1, '\'s has been removed from 8 assignments.', '2024-11-20 00:54:23'),
(419, 'end_user', 'INSERT', '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s  \'1 pcs\' has been assigned to <b>ton</b>.', '2024-11-20 01:07:33'),
(420, 'inventory', 'UPDATE', '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s, \'1 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-11-20 01:07:38'),
(421, 'end_user', 'UPDATE', '8', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s has been removed from 8 assignments.', '2024-11-20 01:07:38'),
(422, 'end_user', 'INSERT', '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s  \'1 pcs\' has been assigned to <b>ton</b>.', '2024-11-20 01:08:13'),
(423, 'inventory', 'UPDATE', '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s, \'1 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-11-20 01:08:17'),
(424, 'end_user', 'UPDATE', '8', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s has been removed from 8 assignments.', '2024-11-20 01:08:17'),
(425, 'end_user', 'INSERT', '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s  \'1 pcs\' has been assigned to <b>ton</b>.', '2024-11-20 01:08:57'),
(426, 'inventory', 'UPDATE', '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s, \'1 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-11-20 01:09:00'),
(427, 'end_user', 'UPDATE', '8', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s has been removed from 8 assignments.', '2024-11-20 01:09:00'),
(428, 'assignment', 'ARCHIVE', '169', 'ton', 1, '\'s inventory assignment record has been archived.', '2024-11-20 01:09:02'),
(429, 'inventory', 'UPDATE', '435426', 'DJI Battery 20v', 1, '\'s, \'1 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-11-20 01:09:20'),
(430, 'end_user', 'UPDATE', '8', 'DJI Battery 20v', 1, '\'s has been removed from 8 assignments.', '2024-11-20 01:09:20'),
(431, 'end_user', 'INSERT', '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s  \'1 pcs\' has been assigned to <b>ton</b>.', '2024-11-20 01:09:33'),
(432, 'inventory', 'UPDATE', '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s, \'1 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-11-20 01:09:44'),
(433, 'end_user', 'UPDATE', '8', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s has been removed from 8 assignments.', '2024-11-20 01:09:44'),
(434, 'assignment', 'ARCHIVE', '170', 'ton', 1, '\'s inventory assignment record has been archived.', '2024-11-20 01:09:51');

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
(9, '1142356', 4, 3, 1, 'DJI Drone', 2, 2, 27, 29000, 4, '2024-07-03', '2024-07-03 10:38:23', 4),
(10, '435426', 4, 3, 1, 'DJI Battery 20v', 5, 5, 27, 4000, 3, '2024-07-03', '2024-07-03 10:40:24', 4),
(12, '2415554', 2, 3, 1, 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 2, 1, 27, 47500, 3, '2024-05-01', '2024-07-03 10:44:25', 4),
(20, '202411191', 2, 6, 1, 'Laptop', 1, 0, 27, 20000, 3, '2024-11-19', '2024-11-19 13:35:05', 4),
(21, '202411192', 2, 6, 1, 'Laptop', 1, 0, 27, 20000, 3, '2024-11-19', '2024-11-19 13:35:05', 4);

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
(176, 13, NULL, '2024-11-19 23:25:54');

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
(67, 171, '11 ky', ' ', '2024-11-06 12:04:29', '2024-11-13 21:33:07'),
(68, 175, '8 ton', ' ', '2024-11-19 13:42:09', '2024-11-19 23:25:46'),
(69, 163, '8 ton', ' ', '2023-10-29 10:50:41', '2024-11-19 23:25:49'),
(70, 169, '8 ton', ' ', '2024-10-30 14:32:45', '2024-11-20 01:09:02'),
(71, 170, '8 ton', ' ', '2024-11-06 12:04:29', '2024-11-20 01:09:51');

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
(211, 173, '202411192', 'Laptop', 'Faculty Office', 'pcs', 1, 20000, 20000, '2024-11-19'),
(212, 176, '202411191', 'Laptop', 'Faculty Office', 'pcs', 1, 20000, 20000, '2024-11-19'),
(213, 176, '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 'IT Department', 'pcs', 1, 47500, 47500, '2024-05-01');

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
(1, 1, 'admin', '$2y$10$FMlDzqdB7EiXq2tiYBQprexcK89C2GvvjYTFSVFOUnJKBJDzSzYvu', '2024-01-20 22:31:22'),
(6, 2, 'ton', '$2y$10$EQxIGP5t4CyfVSZk8eyOI.1YbRYM1P5E5lPkYh60eH/D3C4Fzmd1G', '2024-10-21 12:50:08'),
(11, 2, 'nik', '$2y$10$sJDMJm7nhNX8kf/GB41FSOkBWHzhcPus4BNitW0FtlhorhONg3VBS', '2024-11-19 23:25:35');

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
  ADD KEY `username_fk` (`username`);

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
  ADD KEY `users_ibfk_1` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archive_inventory`
--
ALTER TABLE `archive_inventory`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `estimated_life`
--
ALTER TABLE `estimated_life`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `history_log`
--
ALTER TABLE `history_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=435;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inv_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `inventory_assignment`
--
ALTER TABLE `inventory_assignment`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `inventory_assignment_archive`
--
ALTER TABLE `inventory_assignment_archive`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `inventory_assignment_archive_items`
--
ALTER TABLE `inventory_assignment_archive_items`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `inventory_assignment_item`
--
ALTER TABLE `inventory_assignment_item`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

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
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `end_user`
--
ALTER TABLE `end_user`
  ADD CONSTRAINT `enduser_fk_designation` FOREIGN KEY (`designation`) REFERENCES `designation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `username_fk` FOREIGN KEY (`username`) REFERENCES `end_user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
