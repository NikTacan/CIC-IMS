-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2024 at 06:30 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(4) NOT NULL,
  `article_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`) VALUES
(2, 'Computer'),
(4, 'Hardware'),
(8, 'Vehicle'),
(10, 'Furniture'),
(15, 'Supplies');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` int(3) NOT NULL,
  `designation_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `password` varchar(25) NOT NULL,
  `date_registered` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `end_user`
--

INSERT INTO `end_user` (`id`, `username`, `first_name`, `middle_name`, `last_name`, `email`, `contact`, `designation`, `sex`, `birthday`, `password`, `date_registered`) VALUES
(1, 'RON', 'Vincent Kar', 'DIEGO', 'Bunsay', 'Ron@gmail.com', '9291234567', 1, 'Male', '2024-05-26', '', '2024-06-03'),
(3, 'JUNA', 'JUNAMIE', 'ARTIGA', 'COSTAN', 'junnamieartiga@gmail.com', '9112454789', 1, 'male', '2024-06-03', '', '2024-06-05'),
(5, 'vince', 'Vincent Karl Jo', 'DIEGO', 'Bunsay', 'bunsaykarlskie@gmail.com', '9334021818', 1, 'Male', '2000-12-29', '1234', '2024-07-07');

-- --------------------------------------------------------

--
-- Table structure for table `estimated_life`
--

CREATE TABLE `estimated_life` (
  `id` int(3) NOT NULL,
  `est_life` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history_log`
--

INSERT INTO `history_log` (`id`, `module`, `transaction_type`, `item_no`, `description`, `user_id`, `log_message`, `date_time`) VALUES
(1, 'inventory', 'INSERT', '1', 'EPSON PROJECTOR ', 1, '\'s has been added to the Inventory record.', '2024-06-03 12:47:42'),
(2, 'assignment', 'INSERT', 'VINCET', 'VINCET', 1, ' have new <b>Inventory assignment</b>.', '2024-06-03 12:52:52'),
(3, 'end_user', 'INSERT', 'ICR-01-2019100001', 'EPSON PROJECTOR ', 1, '\'s  \'3 pcs\' has been assigned to <b>VINCET</b>.', '2024-06-03 12:53:00'),
(4, 'end_user', 'UPDATE', NULL, 'EPSON PROJECTOR ', 1, '\'s from VINCET <b>Inventory assignment</b> has been updated. \'3 pcs\' to \'0 pcs\'.', '2024-06-03 12:53:27'),
(5, 'inventory', 'UPDATE', 'ICR-01-2019100001', 'EPSON PROJECTOR ', 1, '\'s, \'3 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-06-03 12:53:27'),
(6, 'inventory', 'UPDATE', '1', 'EPSON PROJECTOR ', 1, '\'s information has been updated. Estimated useful life changed from \'5 years\' to \'1 YEAR\' ', '2024-06-03 12:54:42'),
(7, 'end_user', 'UPDATE', 'VINCET', 'EPSON PROJECTOR ', 1, '\'s \'2 pcs\' has been assigned to <b>VINCET</b>.', '2024-06-03 12:56:00'),
(8, 'end_user', 'UPDATE', NULL, 'EPSON PROJECTOR ', 1, '\'s from VINCET <b>Inventory assignment</b> has been updated. \'2 pcs\' to \'0 pcs\'.', '2024-06-03 13:12:01'),
(9, 'inventory', 'UPDATE', 'ICR-01-2019100001', 'EPSON PROJECTOR ', 1, '\'s, \'2 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-06-03 13:12:01'),
(10, 'inventory', 'ARCHIVE', '1', 'EPSON PROJECTOR ', 1, 'has been moved to Inventory archived.', '2024-06-03 13:14:36'),
(11, 'inventory', 'INSERT', NULL, '1', 1, '\'s has been added to the Inventory record.', '2024-06-03 13:17:48'),
(12, 'inventory', 'UPDATE', NULL, 'EPSON PROJECTOR ', 1, '\'s record has been restored. Archived last <span class=fw-bold> 2024-06-03 13:14:36</span> in Inventory archives.', '2024-06-03 13:17:48'),
(13, 'inventory', 'DELETE', NULL, NULL, 1, '\'s has been deleted from inventory archive.', '2024-06-03 13:17:48'),
(14, 'inventory', 'INSERT', ' 1234', 'ewgergaregare', 1, '\'s has been added to the Inventory record.', '2024-06-03 13:23:31'),
(15, 'inventory', 'ARCHIVE', '3', 'ewgergaregare', 1, 'has been moved to Inventory archived.', '2024-06-03 13:23:38'),
(16, 'inventory', 'INSERT', ' 1234', 'ewgergaregare', 1, '\'s has been added to the Inventory record.', '2024-06-03 13:23:57'),
(17, 'inventory', 'UPDATE', '3', 'ewgergaregare', 1, '\'s record has been restored. Archived last <span class=fw-bold> 2024-06-03 13:23:38</span> in Inventory archives.', '2024-06-03 13:23:57'),
(18, 'inventory', 'DELETE', '3', '3', 1, '\'s has been deleted from inventory archive.', '2024-06-03 13:23:57'),
(19, 'assignment', 'ARCHIVE', '147', 'VINCET', 1, '\'s inventory assignment record has been archived.', '2024-06-03 13:24:15'),
(20, 'assignment', 'INSERT', '147', 'VINCET', 1, '\'s inventory assignment record has been restored, where archived last <b>2024-06-03</b> in Inventory Assignment archives.', '2024-06-03 13:24:29'),
(21, 'inventory', 'ARCHIVE', '4', 'ewgergaregare', 1, 'has been moved to Inventory archived.', '2024-06-03 13:25:33'),
(22, 'inventory', 'INSERT', ' 1234', 'ewgergaregare', 1, '\'s has been added to the Inventory record.', '2024-06-03 13:26:14'),
(23, 'inventory', 'UPDATE', '4', 'ewgergaregare', 1, '\'s record has been restored. Archived last <span class=fw-bold> 2024-06-03 13:25:33</span> in Inventory archives.', '2024-06-03 13:26:14'),
(24, 'inventory', 'DELETE', '4', '4', 1, '\'s has been deleted from inventory archive.', '2024-06-03 13:26:14'),
(25, 'assignment', 'INSERT', 'VINCET', 'VINCET', 1, ' have new <b>Inventory assignment</b>.', '2024-06-03 13:27:41'),
(26, 'end_user', 'INSERT', ' 1234', 'ewgergaregare', 1, '\'s  \'5 rim\' has been assigned to <b>VINCET</b>.', '2024-06-03 13:27:44'),
(27, 'end_user', 'UPDATE', NULL, 'ewgergaregare', 1, '\'s from VINCET <b>Inventory assignment</b> has been updated. \'5 rim\' to \'0 rim\'.', '2024-06-03 13:44:01'),
(28, 'inventory', 'UPDATE', ' 1234', 'ewgergaregare', 1, '\'s, \'5 rim\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-06-03 13:44:01'),
(29, 'end_user', 'UPDATE', 'VINCET', 'ewgergaregare', 1, '\'s from <b> Inventory assignment</b> has been updated. Location:  \'Storage\' to \'\'.', '2024-06-03 13:44:01'),
(30, 'inventory', 'INSERT', '123432', 'fssefwr', 3, '\'s has been added to the Inventory record.', '2024-06-03 13:48:29'),
(31, 'inventory', 'ARCHIVE', '5', 'ewgergaregare', 1, 'has been moved to Inventory archived.', '2024-06-03 13:55:55'),
(32, 'inventory', 'ARCHIVE', '6', 'fssefwr', 1, 'has been moved to Inventory archived.', '2024-06-03 13:56:00'),
(33, 'inventory', 'INSERT', ' 1234', 'ewgergaregare', 1, '\'s has been added to the Inventory record.', '2024-06-03 13:59:13'),
(34, 'inventory', 'UPDATE', '5', 'ewgergaregare', 1, '\'s record has been restored. Archived last <span class=fw-bold> 2024-06-03 13:55:55</span> in Inventory archives.', '2024-06-03 13:59:13'),
(35, 'inventory', 'DELETE', '5', '5', 1, '\'s has been deleted from inventory archive.', '2024-06-03 13:59:13'),
(36, 'end_user', 'UPDATE', 'VINCET', 'ewgergaregare', 1, '\'s \'54 rim\' has been assigned to <b>VINCET</b>.', '2024-06-03 13:59:24'),
(37, 'end_user', 'UPDATE', NULL, 'ewgergaregare', 1, '\'s from VINCET <b>Inventory assignment</b> has been updated. \'54 rim\' to \'0 rim\'.', '2024-06-03 14:03:04'),
(38, 'inventory', 'UPDATE', ' 1234', 'ewgergaregare', 1, '\'s, \'54 rim\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-06-03 14:03:04'),
(39, 'end_user', 'UPDATE', 'VINCET', 'ewgergaregare', 1, '\'s from <b> Inventory assignment</b> has been updated. Location:  \'Storage\' to \'\'.', '2024-06-03 14:03:04'),
(40, 'end_user', 'DELETE', NULL, NULL, 1, '\'s has been deleted from <b>End user</b> records.', '2024-06-03 14:03:12'),
(41, 'end_user', 'DELETE', NULL, NULL, 1, '\'s has been deleted from <b>End user</b> records.', '2024-06-03 14:03:57'),
(42, 'end_user', 'DELETE', NULL, NULL, 1, '\'s has been deleted from <b>End user</b> records.', '2024-06-03 14:06:09'),
(43, 'end_user', 'DELETE', NULL, NULL, 1, '\'s has been deleted from <b>End user</b> records.', '2024-06-03 14:06:13'),
(44, 'end_user', 'DELETE', NULL, NULL, 1, '\'s has been deleted from <b>End user</b> records.', '2024-06-03 14:06:17'),
(45, 'end_user', 'DELETE', NULL, NULL, 1, '\'s has been deleted from <b>End user</b> records.', '2024-06-03 14:07:05'),
(46, 'end_user', 'DELETE', NULL, NULL, 1, '\'s has been deleted from <b>End user</b> records.', '2024-06-03 14:07:40'),
(47, 'assignment', 'ARCHIVE', '148', NULL, 1, '\'s inventory assignment record has been archived.', '2024-06-03 14:14:49'),
(48, 'end_user', 'DELETE', NULL, NULL, 1, '\'s has been deleted from <b>End user</b> records.', '2024-06-03 14:14:55'),
(49, 'end_user', 'DELETE', NULL, NULL, 1, '\'s has been deleted from <b>End user</b> records.', '2024-06-03 14:16:43'),
(50, 'end_user', 'DELETE', NULL, NULL, 1, '\'s has been deleted from <b>End user</b> records.', '2024-06-03 14:17:00'),
(51, 'end_user', 'DELETE', NULL, NULL, 1, '\'s has been deleted from <b>End user</b> records.', '2024-06-03 14:20:31'),
(52, 'inventory', 'UPDATE', '7', 'ewgergaregare', 1, '\'s information has been updated. Estimated useful life changed from \'5 years\' to \'1 YEAR\' ', '2024-06-03 14:23:01'),
(53, 'inventory', 'ARCHIVE', '7', 'ewgergaregare', 1, 'has been moved to Inventory archived.', '2024-06-03 14:24:04'),
(54, 'inventory', 'INSERT', '222324', 'epson projector', 1, '\'s has been added to the Inventory record.', '2024-06-03 14:30:35'),
(55, 'inventory', 'UPDATE', '8', 'epson projector', 1, '\'s information has been updated. Estimated useful life changed from \'5 years\' to \'1 YEAR\' ', '2024-06-03 14:31:08'),
(56, 'inventory', 'UPDATE', '8', 'epson projector', 1, '\'s information has been updated. Remark changed from \'Serviceable\' to \'\' ', '2024-06-03 14:45:13'),
(57, 'assignment', 'INSERT', 'RON', 'RON', 1, ' have new <b>Inventory assignment</b>.', '2024-06-03 15:07:31'),
(58, 'assignment', 'INSERT', 'RON', 'RON', 1, ' have new <b>Inventory assignment</b>.', '2024-06-03 15:08:18'),
(59, 'inventory', 'UPDATE', '8', 'epson projector', 1, '\'s information has been updated. Remark changed from \'Unserviceable\' to \'\' ', '2024-06-03 15:08:47'),
(60, 'assignment', 'INSERT', 'RON', 'RON', 1, ' have new <b>Inventory assignment</b>.', '2024-06-03 15:08:58'),
(61, 'end_user', 'INSERT', '222324', 'epson projector', 1, '\'s  \'2 pcs\' has been assigned to <b>RON</b>.', '2024-06-03 15:09:20'),
(62, 'assignment', 'INSERT', 'nmtacan', 'nmtacan', 1, ' have new <b>Inventory assignment</b>.', '2024-06-03 15:09:35'),
(63, 'end_user', 'INSERT', '222324', 'epson projector', 1, '\'s  \'2 pcs\' has been assigned to <b>nmtacan</b>.', '2024-06-03 15:09:43'),
(64, 'assignment', 'ARCHIVE', '149', 'RON', 1, '\'s inventory assignment record has been archived.', '2024-06-03 15:10:07'),
(65, 'end_user', 'DELETE', NULL, NULL, 1, '\'s has been deleted from <b>End user</b> records.', '2024-06-03 18:01:23'),
(66, 'end_user', 'UPDATE', NULL, 'epson projector', 1, '\'s from  <b>Inventory assignment</b> has been updated. \'2 pcs\' to \'0 pcs\'.', '2024-06-03 18:02:02'),
(67, 'inventory', 'UPDATE', '222324', 'epson projector', 1, '\'s, \'2 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-06-03 18:02:02'),
(68, 'assignment', 'ARCHIVE', '152', NULL, 1, '\'s inventory assignment record has been archived.', '2024-06-03 18:02:15'),
(69, 'inventory', 'UPDATE', '8', 'epson projector', 1, '\'s information has been updated. Remark changed from \'Serviceable\' to \'\' ', '2024-06-05 14:48:48'),
(70, 'assignment', 'INSERT', 'JUNA', 'JUNA', 1, ' have new <b>Inventory assignment</b>.', '2024-06-05 14:48:59'),
(71, 'inventory', 'UPDATE', '8', 'epson projector', 1, '\'s information has been updated. Remark changed from \'Unserviceable\' to \'\' ', '2024-06-05 14:49:17'),
(72, 'assignment', 'INSERT', 'JUNA', 'JUNA', 1, ' have new <b>Inventory assignment</b>.', '2024-06-05 14:49:24'),
(73, 'end_user', 'INSERT', '222324', 'epson projector', 1, '\'s  \'2 pcs\' has been assigned to <b>JUNA</b>.', '2024-06-05 14:49:26'),
(74, 'end_user', 'DELETE', NULL, NULL, 1, '\'s has been deleted from <b>End user</b> records.', '2024-06-21 19:01:48'),
(75, 'assignment', 'DELETE', NULL, NULL, 1, '\'s <b>inventory assignment archive</b> has been deleted.', '2024-06-21 19:02:12'),
(76, 'assignment', 'DELETE', NULL, NULL, 1, '\'s <b>inventory assignment archive</b> has been deleted.', '2024-06-21 19:02:17'),
(77, 'assignment', 'DELETE', NULL, NULL, 1, '\'s <b>inventory assignment archive</b> has been deleted.', '2024-06-21 19:02:21'),
(78, 'inventory', 'DELETE', NULL, NULL, 1, '\'s has been deleted from inventory archive.', '2024-06-21 19:02:30'),
(79, 'inventory', 'DELETE', NULL, NULL, 1, '\'s has been deleted from inventory archive.', '2024-06-21 19:02:35'),
(80, 'assignment', 'INSERT', 'JUNA', 'JUNA', 1, ' have new <b>Inventory assignment</b>.', '2024-06-21 21:03:53'),
(81, 'inventory', 'INSERT', '1142356', 'DJI Drone', 1, '\'s has been added to the Inventory record.', '2024-07-03 10:38:23'),
(82, 'inventory', 'INSERT', '435426', 'DJI Battery 20v', 1, '\'s has been added to the Inventory record.', '2024-07-03 10:40:24'),
(83, 'inventory', 'INSERT', '314235', 'Inten i5-120344K with Fan Cooler', 1, '\'s has been added to the Inventory record.', '2024-07-03 10:42:07'),
(84, 'inventory', 'INSERT', '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s has been added to the Inventory record.', '2024-07-03 10:44:25'),
(85, 'end_user', 'INSERT', '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s  \'1 pcs\' has been assigned to <b>JUNA</b>.', '2024-07-03 10:45:32'),
(86, 'end_user', 'UPDATE', NULL, 'epson projector', 1, '\'s from JUNA <b>Inventory assignment</b> has been updated. \'2 pcs\' to \'0 pcs\'.', '2024-07-03 10:45:46'),
(87, 'inventory', 'UPDATE', '222324', 'epson projector', 1, '\'s, \'2 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-07-03 10:45:46'),
(88, 'end_user', 'INSERT', '435426', 'DJI Battery 20v', 1, '\'s  \'1 pcs\' has been assigned to <b>JUNA</b>.', '2024-07-03 10:46:19'),
(89, 'end_user', 'INSERT', '1142356', 'DJI Drone', 1, '\'s  \'1 pcs\' has been assigned to <b>JUNA</b>.', '2024-07-03 10:46:31'),
(90, 'inventory', 'UPDATE', '222324', 'epson projector', 1, '\'s, \'0 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-07-03 10:49:04'),
(91, 'end_user', 'UPDATE', '3', 'epson projector', 1, '\'s has been removed from 3 assignments.', '2024-07-03 10:49:04'),
(92, 'end_user', 'UPDATE', NULL, 'DJI Battery 20v', 1, '\'s from JUNA <b>Inventory assignment</b> has been updated. \'1 pcs\' to \'0 pcs\'.', '2024-07-03 10:49:40'),
(93, 'inventory', 'UPDATE', '435426', 'DJI Battery 20v', 1, '\'s, \'1 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-07-03 10:49:40'),
(94, 'end_user', 'UPDATE', NULL, 'epson projector', 1, '\'s from RON <b>Inventory assignment</b> has been updated. \'2 pcs\' to \'0 pcs\'.', '2024-07-03 10:54:54'),
(95, 'inventory', 'UPDATE', '222324', 'epson projector', 1, '\'s, \'2 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-07-03 10:54:54'),
(96, 'end_user', 'UPDATE', 'RON', 'epson projector', 1, '\'s \'2 pcs\' has been assigned to <b>RON</b>.', '2024-07-03 10:56:08'),
(97, 'inventory', 'UPDATE', '435426', 'DJI Battery 20v', 1, '\'s, \'0 pcs\' has been returned to inventory record from <b> inventory assignment</b>.', '2024-07-03 11:06:56'),
(98, 'end_user', 'UPDATE', '3', 'DJI Battery 20v', 1, '\'s has been removed from 3 assignments.', '2024-07-03 11:06:56'),
(99, 'assignment', 'INSERT', 'JUNA', 'JUNA', 1, ' have new <b>Inventory assignment</b>.', '2024-07-07 09:17:22'),
(100, 'assignment', 'ARCHIVE', '156', 'JUNA', 1, '\'s inventory assignment record has been archived.', '2024-07-07 09:17:33'),
(101, 'assignment', 'INSERT', 'RON', 'RON', 1, ' have new <b>Inventory assignment</b>.', '2024-07-07 09:17:46'),
(102, 'assignment', 'INSERT', 'JUNA', 'JUNA', 1, ' have new <b>Inventory assignment</b>.', '2024-07-07 09:20:12'),
(103, 'assignment', 'INSERT', 'JUNA', 'JUNA', 1, ' have new <b>Inventory assignment</b>.', '2024-07-07 09:20:55'),
(104, 'end_user', 'UPDATE', 'JUNA', 'JUNA', 1, ' end user\'s record has been updated. First name changed from \'\' to \'JUNAMIE\', Middle name changed from \'\' to \'ARTIGA\', Last name changed from \'\' to \'COSTAN\', Birthday changed from \'\' to \'2024-06-03\', Sex changed from \'\' to \'male\', Email changed from \'\' to \'junnamieartiga@gmail.com\', Contact updated from \'\' to \'9112454789\', Designation updated from \'\' to \'1\'', '2024-07-07 09:22:44'),
(105, 'assignment', 'DELETE', NULL, NULL, 1, '\'s <b>inventory assignment archive</b> has been deleted.', '2024-07-07 09:34:01'),
(106, 'end_user', 'INSERT', '222324', 'epson projector', 1, '\'s  \'2 pcs\' has been assigned to <b>JUNA</b>.', '2024-07-07 09:42:25'),
(107, 'end_user', 'INSERT', 'Vincent Karl Joffe', 'Vincent Karl Jofferson Bunsay', 1, '\'s has been added to <b>End user</b> records.', '2024-07-07 10:49:53'),
(108, 'assignment', 'INSERT', 'vince', 'vince', 1, ' have new <b>Inventory assignment</b>.', '2024-07-07 10:52:13'),
(109, 'end_user', 'INSERT', '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 1, '\'s  \'9 pcs\' has been assigned to <b>vince</b>.', '2024-07-07 10:52:28'),
(110, 'end_user', 'INSERT', '314235', 'Inten i5-120344K with Fan Cooler', 1, '\'s  \'5 pcs\' has been assigned to <b>vince</b>.', '2024-07-07 10:52:28'),
(111, 'end_user', 'UPDATE', 'JUNA', 'JUNA', 1, ' end user\'s record has been updated. First name changed from \'\' to \'JUNAMIE\', Middle name changed from \'\' to \'ARTIGA\', Last name changed from \'\' to \'COSTAN\', Birthday changed from \'\' to \'2024-06-03\', Sex changed from \'\' to \'male\', Email changed from \'\' to \'junnamieartiga@gmail.com\', Contact updated from \'\' to \'9112454789\', Designation updated from \'\' to \'1\'', '2024-07-07 10:53:53');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inv_id`, `property_no`, `category`, `location`, `article`, `description`, `qty_pcard`, `qty_pcount`, `unit`, `unit_cost`, `est_life`, `acquisition_date`, `date_added`, `remark`) VALUES
(8, '222324', 4, 3, 1, 'epson projector', 4, 0, 27, 4000, 4, '2024-02-05', '2024-06-03 14:30:35', 4),
(9, '1142356', 4, 3, 1, 'DJI Drone', 2, 1, 27, 29000, 3, '2024-07-03', '2024-07-03 10:38:23', 4),
(10, '435426', 4, 3, 1, 'DJI Battery 20v', 5, 5, 27, 4000, 3, '2024-07-03', '2024-07-03 10:40:24', 4),
(11, '314235', 4, 3, 1, 'Inten i5-120344K with Fan Cooler', 5, 0, 27, 9563, 3, '2024-07-03', '2024-07-03 10:42:07', 4),
(12, '2415554', 2, 3, 1, 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 10, 0, 27, 47500, 3, '2024-05-01', '2024-07-03 10:44:25', 4);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_assignment`
--

CREATE TABLE `inventory_assignment` (
  `id` int(6) NOT NULL,
  `end_user` int(4) NOT NULL,
  `status` int(3) DEFAULT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory_assignment`
--

INSERT INTO `inventory_assignment` (`id`, `end_user`, `status`, `date_added`) VALUES
(151, 1, NULL, '2024-06-03 15:08:58'),
(154, 3, NULL, '2024-06-05 14:49:24'),
(160, 5, NULL, '2024-07-07 10:52:13');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory_assignment_item`
--

INSERT INTO `inventory_assignment_item` (`id`, `assignment_id`, `property_no`, `description`, `location`, `unit`, `qty`, `unit_cost`, `total_cost`, `acquisition_date`) VALUES
(179, 151, '222324', 'epson projector', 'IT Department', 'pcs', 2, 4000, 12000, '2024-02-05'),
(182, 154, '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 'IT Department', 'pcs', 1, 47500, 47500, '2024-05-01'),
(184, 154, '1142356', 'DJI Drone', 'IT Department', 'pcs', 1, 29000, 29000, '2024-07-03'),
(185, 154, '222324', 'epson projector', 'IT Department', 'pcs', 2, 4000, 8000, '2024-02-05'),
(186, 160, '2415554', 'Acer Predator VK85 - Intel i7-13435 16GB 240GB SSD', 'IT Department', 'pcs', 9, 47500, 427500, '2024-05-01'),
(187, 160, '314235', 'Inten i5-120344K with Fan Cooler', 'IT Department', 'pcs', 5, 9563, 47815, '2024-07-03');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(4) NOT NULL,
  `location_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`id`, `note_name`, `module`, `color`) VALUES
(4, 'Serviceable', 'inventory', '#5ADA86'),
(24, 'Unserviceable', 'inventory', 'red');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(3) NOT NULL,
  `module` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `module`) VALUES
(1, 'inventory'),
(2, 'assignment'),
(5, 'end_user'),
(7, 'categories'),
(8, 'report'),
(10, 'activity_log'),
(11, 'archives'),
(12, 'user'),
(13, 'role'),
(14, 'general_content'),
(15, 'components'),
(16, 'location'),
(17, 'article');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(4) NOT NULL,
  `role_id` int(3) NOT NULL,
  `permission_id` int(3) NOT NULL,
  `can_access` int(1) NOT NULL,
  `can_create` int(1) NOT NULL,
  `can_read` int(1) NOT NULL,
  `can_update` int(1) NOT NULL,
  `can_delete` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `role_id`, `permission_id`, `can_access`, `can_create`, `can_read`, `can_update`, `can_delete`) VALUES
(372, 4, 1, 1, 1, 1, 1, 1),
(373, 4, 2, 1, 1, 0, 1, 0),
(374, 4, 14, 1, 1, 1, 1, 1),
(375, 4, 15, 1, 1, 1, 1, 1),
(1679, 1, 10, 1, 1, 1, 1, 1),
(1680, 1, 1, 1, 1, 1, 1, 1),
(1681, 1, 5, 1, 1, 1, 1, 1),
(1682, 1, 7, 1, 1, 1, 1, 1),
(1683, 1, 16, 1, 1, 1, 1, 1),
(1684, 1, 2, 1, 1, 1, 1, 1),
(1685, 1, 17, 1, 1, 1, 1, 1),
(1686, 1, 12, 1, 1, 1, 1, 1),
(1687, 1, 13, 1, 1, 1, 1, 1),
(1688, 1, 14, 1, 0, 0, 1, 0),
(1689, 1, 15, 1, 1, 0, 0, 1),
(1690, 1, 8, 1, 1, 1, 0, 0),
(1691, 1, 11, 1, 1, 0, 0, 1),
(1716, 2, 1, 1, 1, 1, 1, 1),
(1717, 2, 2, 1, 1, 1, 1, 1),
(1718, 2, 10, 1, 0, 1, 0, 0),
(1719, 2, 16, 1, 1, 1, 1, 1),
(1720, 2, 8, 1, 1, 1, 0, 0),
(1721, 2, 11, 1, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(3) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `date_created`) VALUES
(1, 'Super Admin', 'Full administration', '2024-01-20 15:28:11'),
(2, 'Staff', 'staff', '2024-01-20 22:33:03'),
(4, 'users', 'user role', '2024-01-22 20:42:16');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `first_name` varchar(15) NOT NULL,
  `middle_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(25) DEFAULT NULL,
  `contact` varchar(11) DEFAULT NULL,
  `sex` varchar(6) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `first_name`, `middle_name`, `last_name`, `username`, `password`, `email`, `contact`, `sex`, `birthday`, `date_created`) VALUES
(1, 1, 'Anthony', 'Silvano', 'Calubag', 'admin', '$2y$10$s8QH67SEz9bfweGEmd.hou/7qbFfiTkgplwDGBa1Z0N210cqCEfS2', 'anthonycalubag@yahoo.com', '9165715516', 'Male', '2024-02-22', '2024-01-20 22:31:22'),
(3, 4, 'Nikkido', '', '', 'nikki', '$2y$10$/vAmS2Snu3/Mwb.rrGz0BefbiM97W4XgJd8k8wYtEGDo5r2xcsE0W', NULL, NULL, NULL, NULL, '2024-04-29 13:35:23'),
(4, 2, 'Bryl', '', '', 'bryl', '$2y$10$grLEH3hY9jlHJtsFVrk44Om/JYyJFZ516f6.2NVFkgmcqq64mY/W.', NULL, NULL, NULL, NULL, '2024-04-29 13:37:07');

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
  ADD KEY `cluster_name` (`first_name`),
  ADD KEY `enduser_fk_designation` (`designation`);

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
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `name` (`first_name`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `users_ibfk_1` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archive_inventory`
--
ALTER TABLE `archive_inventory`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `end_user`
--
ALTER TABLE `end_user`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `estimated_life`
--
ALTER TABLE `estimated_life`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `history_log`
--
ALTER TABLE `history_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inv_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `inventory_assignment`
--
ALTER TABLE `inventory_assignment`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `inventory_assignment_archive`
--
ALTER TABLE `inventory_assignment_archive`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `inventory_assignment_archive_items`
--
ALTER TABLE `inventory_assignment_archive_items`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `inventory_assignment_item`
--
ALTER TABLE `inventory_assignment_item`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

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
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1722;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `system_content`
--
ALTER TABLE `system_content`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Constraints for table `inventory_assignment`
--
ALTER TABLE `inventory_assignment`
  ADD CONSTRAINT `assignment_fk_status` FOREIGN KEY (`status`) REFERENCES `note` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
