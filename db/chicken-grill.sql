-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 18 juin 2021 à 17:52
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `chicken-grill`
--

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(55) NOT NULL,
  `product_description` text NOT NULL,
  `prix` double NOT NULL,
  `product_img_url` text NOT NULL,
  `prix_promo` double NOT NULL,
  `promo` enum('hors-promo','en-promo') NOT NULL,
  `resto_secteur` enum('resto1','resto2','resto3','resto4','resto5') NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  `admin_resto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_description`, `prix`, `product_img_url`, `prix_promo`, `promo`, `resto_secteur`, `date_enregistrement`, `admin_resto_id`) VALUES
(1, 'XXL Burger', 'XXL Burger de calité exelente', 9.55, 'photos/img-product/60ccb0287b6cc_about-us.jpg', 5.65, 'en-promo', 'resto1', '2021-06-18 17:50:31', 12);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `nom` varchar(155) NOT NULL,
  `email` varchar(155) NOT NULL,
  `mdp` text NOT NULL,
  `user_google_id` varchar(255) DEFAULT NULL,
  `user_facebook_id` varchar(255) DEFAULT NULL,
  `statut` enum('client','super-admin','admin-resto1','admin-resto2','admin-resto3','admin-resto4','admin-resto5') NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `nom`, `email`, `mdp`, `user_google_id`, `user_facebook_id`, `statut`, `date_enregistrement`) VALUES
(10, 'rod Coding', 'rodcoding@gmail.com', '$2y$10$gOPyIKakvPvAoqQFrWUtyOO6zvNI4XOB/ptBKUvvWFcWPeqipJ612', NULL, '105900371736594', 'client', '2021-06-18 14:26:34'),
(11, 'rod Coding', 'rodcoding@gmail.com', '$2y$10$DOeP79/ng9Ir1BRDgHNEBuBD.nsHzxy3XQL3RfXvj3k5DAr6Dq.0u', '114139676919264636726', NULL, 'client', '2021-06-18 14:26:34'),
(12, 'Daniel Nguel', 'daniel@gmail.com', '$2y$10$gGzyahnET4LnNeKCH6K10uqBkwIU1R4AyO30vukjaMjvYxPdjAA.6', NULL, NULL, 'admin-resto1', '2021-06-18 14:36:26');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
