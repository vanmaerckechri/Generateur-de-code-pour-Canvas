-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 01 avr. 2018 à 14:46
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gen_code_canvas`
--

-- --------------------------------------------------------

--
-- Structure de la table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `mail` varchar(78) NOT NULL,
  `activateCode` varchar(64) DEFAULT NULL,
  `activate` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `members`
--

INSERT INTO `members` (`id`, `login`, `password`, `mail`, `activateCode`, `activate`) VALUES
(30, 'Chri', 'c8b01b536d6de8003d632a6efe97b9fd3e082c6e7727b284dab70610c667b407', 'cvm@cvm.com', '4ff2620b7e34188c97027d5722d1080cbdb0be83010b37eb0fa95ef140fc05d5', 1),
(31, 'test', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'a@a.com', '7dcb0cd247aa94896e665c337696a7be18d387a78d6d55b4854b7ff7d5925042', 1),
(33, 'Laokhoon', 'cdba8c5abc74b1d37371a4ac60e7fc11e2d3280f854c32a1009c3f8ed120a51d', 'laok@laok.com', '1c3041163ccfd74e643495533fb6d0dfe4ca99ec676f63f72559fed8298b2ae1', 1),
(34, 'Herbacha', '86dfb93aa6be06b8f8085d242c1aa2089026eb2890dfacbf2d815fa46433b37b', 'herba@c.com', '253448980a64915efdd55958f438808436fa4d7e9424da3d80eea05dfb668a24', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
