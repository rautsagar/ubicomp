-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 15, 2013 at 09:08 PM
-- Server version: 5.6.12
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ubicomp`
--

-- --------------------------------------------------------

--
-- Table structure for table `practical_sessions`
--

CREATE TABLE IF NOT EXISTS `practical_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(10) NOT NULL,
  `class` varchar(10) NOT NULL,
  `batch_no` int(11) NOT NULL DEFAULT '0',
  `day` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `faculty_incharge` varchar(50) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lab_id` (`lab_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `practical_sessions`
--

INSERT INTO `practical_sessions` (`id`, `subject`, `class`, `batch_no`, `day`, `lab_id`, `faculty_incharge`, `start_time`, `end_time`) VALUES
(1, 'HCI', 'BE-Comps', 1, 4, 1, 'Allan Pinto', '15:00:00', '17:00:00'),
(2, 'HCI', 'BE-Comps', 2, 1, 1, 'Allan Pinto', '09:00:00', '11:00:00'),
(3, 'MSD', 'BE-Comps', 1, 2, 3, 'Steffi Monteiro', '14:00:00', '16:00:00'),
(4, 'MSD', 'BE-Comps', 2, 5, 3, 'Steffi Monteiro', '15:00:00', '17:00:00'),
(5, 'MSD', 'BE-Comps', 3, 4, 3, 'Steffi Monteiro', '11:15:00', '13:15:00'),
(6, 'DC', 'BE-Comps', 1, 4, 2, 'Nilakshi Joshi', '11:15:00', '13:15:00'),
(7, 'DC', 'BE-Comps', 2, 2, 2, 'Nilakshi Joshi', '14:00:00', '16:00:00'),
(8, 'DC', 'BE-Comps', 3, 5, 2, 'Nilakshi Joshi', '15:00:00', '17:00:00'),
(9, 'SA', 'BE-Comps', 1, 5, 1, 'Uma Sahu', '15:00:00', '17:00:00'),
(10, 'SA', 'BE-Comps', 2, 4, 1, 'Uma Sahu', '11:15:00', '13:15:00'),
(11, 'SA', 'BE-Comps', 3, 2, 1, 'Uma Sahu', '14:00:00', '16:00:00'),
(12, 'Project', 'BE-Comps', 0, 3, 5, 'Nilakshi Joshi', '09:00:00', '17:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `practical_sessions`
--
ALTER TABLE `practical_sessions`
  ADD CONSTRAINT `practical_sessions_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `laboratory` (`lab_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
