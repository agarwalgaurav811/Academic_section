-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 20, 2018 at 1:32 PM
-- Server version: 5.5.57-0ubuntu0.16.04.1
-- PHP Version: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `saDb`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `acad_files` (
  `id` int(10) NOT NULL,
  `fileno` varchar(25) DEFAULT NULL,
  `filename` varchar(500) DEFAULT NULL,
  `applicant_webmail` varchar(100) NOT NULL,
  `fdate` varchar(50) DEFAULT NULL,
  `faddress` varchar(200) DEFAULT NULL,
  `filedesc` varchar(5000) DEFAULT NULL,
  `fdeal` varchar(200) DEFAULT NULL,
  `currentloc` varchar(200) DEFAULT NULL,
  `datecreate` varchar(50) DEFAULT NULL,
  `currentresponsible` varchar(200) DEFAULT NULL,
  `filepdf` varchar(500) DEFAULT NULL,
  `createby_dept` varchar(200) DEFAULT NULL,
  `createby_user` varchar(500) NOT NULL,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `fileno` (`fileno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `files`
--



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
