-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 01 avr. 2018 à 14:45
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
-- Structure de la table `dessins`
--

DROP TABLE IF EXISTS `dessins`;
CREATE TABLE IF NOT EXISTS `dessins` (
  `id_dessin` int(10) NOT NULL AUTO_INCREMENT,
  `nom_membre` varchar(32) NOT NULL,
  `titre` varchar(64) NOT NULL,
  `date` date NOT NULL,
  `points` int(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_dessin`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `dessins`
--

INSERT INTO `dessins` (`id_dessin`, `nom_membre`, `titre`, `date`, `points`) VALUES
(59, 'Chri', 'Woooooow', '2018-04-01', 0),
(58, 'Herbacha', 'Un Joli Chat', '2018-04-01', 0),
(57, 'Laokhoon', 'tapisserie', '2018-04-01', 0),
(56, 'Laokhoon', 'R2D2 pas content', '2018-04-01', 0),
(55, 'Herbacha', 'Chat Photorealiste', '2018-04-01', 0),
(53, 'Chri', 'Rose Chri', '2018-04-01', 0),
(52, 'Laokhoon', 'Koundelitch', '2018-04-01', 0),
(50, 'Chri', 'Des Spheres', '2018-04-01', 0),
(49, 'Herbacha', 'Particules', '2018-04-01', 0),
(48, 'Herbacha', 'Une Maison', '2018-04-01', 0),
(60, 'Laokhoon', 'labyrinthe', '2018-04-01', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
