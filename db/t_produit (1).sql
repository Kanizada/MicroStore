-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 04 Janvier 2016 à 00:06
-- Version du serveur :  5.6.20-log
-- Version de PHP :  5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `microstore`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_produit`
--

CREATE TABLE IF NOT EXISTS `t_produit` (
`prod_id` int(11) NOT NULL,
  `prod_name` varchar(255) DEFAULT NULL,
  `prod_lib` varchar(255) DEFAULT NULL,
  `prod_prixK` int(11) DEFAULT NULL,
  `prod_image` varchar(255) NOT NULL,
  `prod_stock` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `t_produit`
--
ALTER TABLE `t_produit`
 ADD PRIMARY KEY (`prod_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `t_produit`
--
ALTER TABLE `t_produit`
MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
