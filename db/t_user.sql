-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 04 Janvier 2016 à 00:10
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
-- Structure de la table `t_user`
--

CREATE TABLE IF NOT EXISTS `t_user` (
`usr_id` int(11) NOT NULL,
  `usr_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `usr_password` varchar(88) COLLATE utf8_unicode_ci NOT NULL,
  `usr_salt` varchar(23) COLLATE utf8_unicode_ci NOT NULL,
  `usr_role` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `usr_mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usr_tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usr_adr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usr_ville` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `t_user`
--
ALTER TABLE `t_user`
 ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `t_user`
--
ALTER TABLE `t_user`
MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
