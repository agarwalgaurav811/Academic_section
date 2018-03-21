

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";




CREATE TABLE IF NOT EXISTS `acad_user` (
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `image` varchar(500) NOT NULL,
  `post` varchar(100) NOT NULL,
  `department` varchar(10) NOT NULL,
  `localip` varchar(100) NOT NULL,
  `usertype` int(10) NOT NULL,
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



INSERT INTO `acad_user` (`username`, `password`, `name`, `phone`, `image`, `post`, `department`, `localip`, `usertype`) VALUES
('acad_admin_1', 'RandomFire', 'SWC', '+91-361-258-0000', '', 'Tester', '113', '10.18.0.71', 3);

