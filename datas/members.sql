-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: cvm.one.mysql:3306
-- Generation Time: Apr 15, 2018 at 09:15 PM
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
-- Table structure for table `gen_code_can_members`
--

CREATE TABLE IF NOT EXISTS `gen_code_can_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `mail` varchar(78) NOT NULL,
  `activateCode` varchar(64) DEFAULT NULL,
  `activate` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `gen_code_can_members`
--

INSERT INTO `gen_code_can_members` (`id`, `login`, `password`, `mail`, `activateCode`, `activate`) VALUES
(30, 'Chri', 'c8b01b536d6de8003d632a6efe97b9fd3e082c6e7727b284dab70610c667b407', 'cvm@cvm.com', '4ff2620b7e34188c97027d5722d1080cbdb0be83010b37eb0fa95ef140fc05d5', 1),
(33, 'Laokhoon', 'cdba8c5abc74b1d37371a4ac60e7fc11e2d3280f854c32a1009c3f8ed120a51d', 'laok@laok.com', '1c3041163ccfd74e643495533fb6d0dfe4ca99ec676f63f72559fed8298b2ae1', 1),
(34, 'Herbacha', '86dfb93aa6be06b8f8085d242c1aa2089026eb2890dfacbf2d815fa46433b37b', 'herba@c.com', '253448980a64915efdd55958f438808436fa4d7e9424da3d80eea05dfb668a24', 1),
(35, 'mdelcham', '903a8167c5869ada62062eaccdea3d87b8fc49558cad0f828ce7cc953dbca39f', 'delchambremaxime@gmail.com', 'cc93f9806f82c04f4a2e2b250ea724551b63fe6c0074845edc41c5ef6b487b3f', 1),
(36, 'louloune', '8afeed4b124b1d154ea9f497417a5b93e1632f61498fcad788e63a9e5c29c5a7', 'emily@becode.org', '8415d6516983d28f4010c2b1fe8db8c9e0e3a398646e1ab4475b09d628cf3eb3', 1),
(37, 'coco', 'cdb8233b196812e2929dc4b507b541af637874a3f0923682494c7d9374620858', 'noirot.co@gmail.com', 'e885cc862c448eff4888a56ae8020173c947035c18e761b88b1e1e6ef2c96ffb', 1),
(38, 'mike', '00ba465b035268dbc373c04792f961a8893fd71fb0a4d87721da1faff1a0b395', 'mickael.vc@gmail.com', '47f7c6d7df045f2a10e1592be92e46c5e318553096cd7f138100cfbdc482d5af', 1),
(39, 'Alex', '44e3545ca51e7de02d4293faaec0402f23018aa204049d4ee5b6e657f4f5f0e8', 'ralexmartin@hotmail.com', '5f901d15723203a78f11b5c3e47964306b8c5e9414ba43a3c7b695fac7ea1835', 1),
(40, 'Zombixel', 'cde0048e729f17c10bec09ba5ad3fe2b72cd5283e897452858a03624c9e4e8ee', 'gtk666@hotmail.com', '425fd0fe5c5ee299a4854f814c33fe4f68657cee5891a23406c89d3704faf993', 1),
(43, 'cvm', '5d7f15f2fce8ddb2dbef5c38be896c238ba7e0a432e396759030a853fa6b1151', 'christophe.vm@skynet.be', 'ba099da3ade5347af40f0c4e46d4363afbd4f2102fe1b6bc4438490de304a104', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
