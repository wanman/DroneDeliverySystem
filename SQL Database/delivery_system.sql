-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 03, 2018 at 05:26 PM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `delivery_system`
--
CREATE DATABASE IF NOT EXISTS `delivery_system` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `delivery_system`;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(255) NOT NULL,
  `client_location_lat` varchar(255) NOT NULL,
  `client_location_lng` varchar(255) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`client_id`, `client_name`, `client_location_lat`, `client_location_lng`) VALUES
(54, 'Christopher', '-34.07601994111767', '19.93671736283045\r\n'),
(55, 'Ryan', '-33.1795531182914', '18.53046736283045\r\n'),
(56, 'Ethan', '-34.094217824919625', '18.96992048783045\r\n'),
(57, 'John', '-33.27145598575542', '20.49702009720545\r\n'),
(58, 'Zoey', '-32.64461802662456', '19.06879744095545\r\n'),
(59, 'Sarah', '-33.142764946405855', '18.34369978470545\r\n'),
(60, 'Michelle', '-34.11241179713736', '20.69477400345545\r\n'),
(61, 'Samantha', '-32.97702735555622', '20.07953962845545\r\n'),
(62, 'Charles', '-34.25782263901437', '20.18940290970545\r\n'),
(63, 'Elsie', '-33.63809986894273', '18.49750837845545');

-- --------------------------------------------------------

--
-- Table structure for table `drones`
--

DROP TABLE IF EXISTS `drones`;
CREATE TABLE IF NOT EXISTS `drones` (
  `drone_id` int(11) NOT NULL AUTO_INCREMENT,
  `drone_name` varchar(255) NOT NULL,
  `drone_location_lat` varchar(255) NOT NULL,
  `drone_location_lng` varchar(255) NOT NULL,
  PRIMARY KEY (`drone_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drones`
--

INSERT INTO `drones` (`drone_id`, `drone_name`, `drone_location_lat`, `drone_location_lng`) VALUES
(1, 'Drone 1', '', ''),
(2, 'Drone 2', '', ''),
(3, 'Drone 3', '', ''),
(4, 'Drone 4', '', ''),
(5, 'Drone 5', '', ''),
(6, 'Drone 6', '', ''),
(7, 'Drone 7', '', ''),
(8, 'Drone 8', '', ''),
(9, 'Drone 9', '', ''),
(10, 'Drone 10', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_ref_drone` int(11) NOT NULL,
  `order_ref_client1` int(11) NOT NULL,
  `order_status_client_1` varchar(255) NOT NULL,
  `order_ref_client2` int(11) NOT NULL,
  `order_status_client_2` varchar(255) NOT NULL,
  `order_departure_time` datetime NOT NULL,
  `order_distance_client_1` varchar(255) NOT NULL,
  `order_distance_client_2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `order_ref_client2` (`order_ref_client2`),
  KEY `order_ref_client1` (`order_ref_client1`),
  KEY `order_ref_drone` (`order_ref_drone`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`order_ref_client1`) REFERENCES `client` (`client_id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`order_ref_client2`) REFERENCES `client` (`client_id`),
  ADD CONSTRAINT `order_ibfk_3` FOREIGN KEY (`order_ref_drone`) REFERENCES `drones` (`drone_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
