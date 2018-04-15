-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: cvm.one.mysql:3306
-- Generation Time: Apr 15, 2018 at 09:16 PM
-- Server version: 10.1.30-MariaDB-1~xenial
-- PHP Version: 5.4.45-0+deb7u13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cvm_one`
--

-- --------------------------------------------------------

--
-- Table structure for table `gen_code_can_dessins`
--

CREATE TABLE IF NOT EXISTS `gen_code_can_dessins` (
  `id_dessin` int(10) NOT NULL AUTO_INCREMENT,
  `nom_membre` varchar(32) NOT NULL,
  `titre` varchar(64) NOT NULL,
  `date` date NOT NULL,
  `points` int(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_dessin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=91 ;

--
-- Dumping data for table `gen_code_can_dessins`
--

INSERT INTO `gen_code_can_dessins` (`id_dessin`, `nom_membre`, `titre`, `date`, `points`) VALUES
(59, 'Chri', 'WOOOOOW', '2018-04-01', 0),
(58, 'Herbacha', 'UN JOLI CHAT', '2018-04-01', 0),
(57, 'Laokhoon', 'TAPISSERIE', '2018-04-01', 0),
(56, 'Laokhoon', 'R2D2 PAS CONTENT', '2018-04-01', 0),
(55, 'Herbacha', 'CHAT PHOTOREALISTES', '2018-04-01', 0),
(52, 'Laokhoon', 'KOUNDELITCH', '2018-04-01', 0),
(50, 'Chri', 'DES SPHERES', '2018-04-01', 0),
(49, 'Herbacha', 'PARTICULES', '2018-04-01', 0),
(48, 'Herbacha', 'UNE MAISON', '2018-04-01', 0),
(62, 'louloune', 'LAST TRIANGLE WAS SHITTY', '2018-04-06', 0),
(64, 'louloune', 'MSG DE L AMOUR', '2018-04-06', 0),
(65, 'coco', 'CARRE BLANC SUR FOND BLANC', '2018-04-06', 0),
(66, 'coco', 'IL ETAIT UNE FOIS UNE MOUCHE', '2018-04-06', 0),
(68, 'coco', 'MOI COCO', '2018-04-06', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
