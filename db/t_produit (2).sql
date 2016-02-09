-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 04 Janvier 2016 à 00:08
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

--
-- Contenu de la table `t_produit`
--

INSERT INTO `t_produit` (`prod_id`, `prod_name`, `prod_lib`, `prod_prixK`, `prod_image`, `prod_stock`) VALUES
(1, 'Pomme', 'C''est LA pomme de vos régions, une pomme cultivée dans nos terres françaises qui promet une qualité sans faille et un goût traditionnel. ', 2, 'pomme.jpg', 100),
(2, 'Poire bleue', 'La poire est récoltée depuis des siècles par nos agriculteurs locaux. Ces derniers travaille toujours mieux dans le but de vous offrir ce bien rempli de saveur.', 3, 'poire.jpg', 93),
(3, 'Cerise de Ceret', 'Une cargaison de cerise savoureuse de notre France rurale qui vous régalera dans chacun de vos repas.', 8, 'cerise.jpg', 100),
(4, 'Fraise Gariguette', 'C''est au tour de nos fraises régionales de vous émerveiller à chaque instant de la journée. Vous pourrez déguster cette douceur nature ou bien avec du sucre parmi tant d''autres recettes.', 4, 'fraise.jpg', 100),
(5, 'Chameau des marais', 'Un chameau tout neuf, le plein est fait et les jantes sont neuves.', 5, 'ki26yj4f56tx0rkn1wb95ddf30lsq4cmla9f6eg1jh7aejydlo04.jpg', 100),
(6, 'Phoque Homosexuel', 'Un phoque avec la joie de vivre.', 40, 'vnzoqzo24qijf5nmpaxno7il65gcqkmy9tkh36e33fibtci11h6b94d30989b52621a1767250773bd818ba3ebf77f912c3f7b1566019019f57b5.jpg', 100),
(11, 'Choucroute alsacienne', 'Une bonne choucroute bien consistante.', 20, 'xhcs2r2ljlfxu6e7rzq3b2xrpyiog1c4shf81tj1445gg7va4cchoucroute.jpg', 500);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
