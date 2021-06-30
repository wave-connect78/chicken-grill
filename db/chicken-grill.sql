-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 30 juin 2021 à 17:49
-- Version du serveur : 10.4.19-MariaDB
-- Version de PHP : 8.0.7

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
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `commande_id` int(11) NOT NULL,
  `reference_id` varchar(155) NOT NULL,
  `user_id` int(11) NOT NULL,
  `commande_code` int(11) DEFAULT NULL,
  `commande_detail` text NOT NULL,
  `reference_commande` varchar(55) NOT NULL,
  `commande_statut` enum('en-cours','livré','reçu') NOT NULL,
  `resto` enum('asnieres','argenteuil','bezons','saint-denis','epinay-seine') NOT NULL,
  `commande_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`commande_id`, `reference_id`, `user_id`, `commande_code`, `commande_detail`, `reference_commande`, `commande_statut`, `resto`, `commande_date`) VALUES
(13, 'b552da03e5b82ead4c2fc06eae12048d00b9cfc7', 13, 2861, '13-Poulet plus riz plus boisson-2-menu-À emporter-fanta-normal-,16-Cheese plus frite plus boisson-3-menu-simple-À emporter-fanta-normal-,15-1 cuisse plus riz plus boisson-1-menu-À emporter-fanta-normal-', '2861-equipe_developpement', 'reçu', 'asnieres', '2021-06-30 15:47:58'),
(14, '9c89df95d81cc110b84e764d243bbddd59f3ecab', 13, 3154, '13-Poulet plus riz plus boisson-2-menu-À emporter-fanta-normal-,16-Cheese plus frite plus boisson-3-menu-simple-À emporter-fanta-normal-,15-1 cuisse plus riz plus boisson-1-menu-À emporter-fanta-normal-', '3154-equipe_developpement', 'reçu', 'asnieres', '2021-06-30 15:50:07');

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` text NOT NULL,
  `reference_id` varchar(155) NOT NULL,
  `amount` double NOT NULL,
  `payment_statut` varchar(50) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `payment_canal` varchar(50) NOT NULL,
  `resto` enum('asnieres','argenteuil','bezons','saint-denis','epinay-seine') NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `payment`
--

INSERT INTO `payment` (`payment_id`, `user_id`, `transaction_id`, `reference_id`, `amount`, `payment_statut`, `currency`, `payment_canal`, `resto`, `create_date`) VALUES
(1, 13, 'txn_1J7fu1GmpSPcezX3RTXl8dVa', '', 8.5, 'succeeded', 'eur', '', 'asnieres', '2021-06-29 14:18:57'),
(2, 13, 'txn_1J7gGTGmpSPcezX3bDyFW2pn', '', 8, 'succeeded', 'eur', '', 'asnieres', '2021-06-29 14:42:08'),
(3, 13, 'txn_1J7hBgGmpSPcezX3IR3La5gt', '', 12, 'succeeded', 'eur', '', 'asnieres', '2021-06-29 15:41:16'),
(4, 13, 'txn_1J7hGYGmpSPcezX3g0zwv45x', '', 3.5, 'succeeded', 'eur', '', 'asnieres', '2021-06-29 15:46:18'),
(5, 13, 'txn_1J7hSpGmpSPcezX3LBPjBHoz', '', 3.5, 'succeeded', 'eur', '', 'asnieres', '2021-06-29 15:58:58'),
(6, 13, 'txn_1J7hUsGmpSPcezX3Pfc2dQED', '', 3.5, 'succeeded', 'eur', '', 'asnieres', '2021-06-29 16:01:06'),
(7, 13, 'txn_1J7hWOGmpSPcezX3Zaqp6oQH', '', 3.5, 'succeeded', 'eur', '', 'asnieres', '2021-06-29 16:02:40'),
(8, 13, 'txn_1J7hgZGmpSPcezX3EArvdKjw', '', 3.5, 'succeeded', 'eur', '', 'asnieres', '2021-06-29 16:13:10'),
(9, 13, 'txn_1J7zYSGmpSPcezX3EfZXFpwG', '', 21, 'succeeded', 'eur', '', 'asnieres', '2021-06-30 11:18:00'),
(13, 13, 'txn_1J83ljGmpSPcezX3j2wYbKro', 'b552da03e5b82ead4c2fc06eae12048d00b9cfc7', 43, 'succeeded', 'eur', '', 'asnieres', '2021-06-30 15:47:59'),
(14, 13, 'txn_1J83noGmpSPcezX3hsWa7SJO', '9c89df95d81cc110b84e764d243bbddd59f3ecab', 43, 'succeeded', 'eur', '', 'asnieres', '2021-06-30 15:50:07');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(55) NOT NULL,
  `product_description` text NOT NULL,
  `prix` double NOT NULL,
  `stock` int(11) NOT NULL,
  `product_img_url` text NOT NULL,
  `prix_promo` double NOT NULL,
  `promo` enum('hors-promo','en-promo') NOT NULL,
  `produit_type` enum('aucun','menu','menu-simple','boisson','menu-doublé','dessert') NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  `admin_resto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_description`, `prix`, `stock`, `product_img_url`, `prix_promo`, `promo`, `produit_type`, `date_enregistrement`, `admin_resto_id`) VALUES
(1, 'XXL Burger', 'XXL Burger de calité exelente', 9.55, 0, 'photos/img-product/60ccb0287b6cc_about-us.jpg', 5.95, 'en-promo', 'aucun', '2021-06-23 17:21:07', 14),
(2, 'Poulet', 'Poulet fruit', 7.5, 12, 'photos/img-product/60d358fb8ab93_grilled-chicken.jpg', 0, 'hors-promo', 'aucun', '2021-06-23 17:53:31', 14),
(3, 'Demi-poulet', 'Demi-poulet fruit fait maison', 4, 15, 'photos/img-product/60d06e705fd99_about-us.jpg', 0, 'hors-promo', 'aucun', '2021-06-23 17:05:33', 14),
(4, 'Cuisse ', 'Une Cuisse de poulet', 2.5, 9, 'photos/img-product/60d06eb2ae955_about-us.jpg', 0, 'hors-promo', 'aucun', '2021-06-23 17:06:01', 14),
(5, '3 cuisses', '3 cuisse de poulet à un prix raisonable', 6, 6, 'photos/img-product/60d06f07c1df2_about-us.jpg', 0, 'hors-promo', 'aucun', '2021-06-23 17:06:42', 14),
(6, 'Riz thaï,curry ou forestier', 'Riz thaï,curry ou forestier', 4, 20, 'photos/img-product/60d06f52daa14_about-us.jpg', 0, 'hors-promo', 'aucun', '2021-06-23 17:07:07', 14),
(7, 'Frite maison,pomme sautée', 'Frite maison,pomme sautée', 2.5, 15, 'photos/img-product/60d06f875f7ae_about-us.jpg', 0, 'hors-promo', 'aucun', '2021-06-23 17:07:31', 14),
(8, 'cheese ', 'cheese ', 2.5, 18, 'photos/img-product/60d06fdc4aef7_about-us.jpg', 0, 'hors-promo', 'aucun', '2021-06-23 17:08:14', 14),
(9, 'double cheese', 'double cheese', 3.5, 20, 'photos/img-product/60d0709ecc4f3_about-us.jpg', 0, 'hors-promo', 'aucun', '2021-06-23 17:09:06', 14),
(10, 'le big', 'le big', 3.5, 19, 'photos/img-product/60d070e004d23_about-us.jpg', 0, 'hors-promo', 'aucun', '2021-06-23 17:09:28', 14),
(11, 'Chicken burger', 'Chicken burger', 3.5, 9, 'photos/img-product/60d071035b8ef_about-us.jpg', 0, 'hors-promo', 'aucun', '2021-06-21 12:59:15', 12),
(12, 'Fish ', 'Fish ', 3.5, 10, 'photos/img-product/60d0712dd46ce_about-us.jpg', 0, 'hors-promo', 'aucun', '2021-06-21 12:59:57', 12),
(13, 'Poulet plus riz plus boisson', 'Poulet avec riz et une boisson', 12, 11, 'photos/img-product/60d07176d6848_about-us.jpg', 0, 'hors-promo', 'menu', '2021-06-21 13:01:10', 12),
(14, 'Demi poulet plus riz plus boisson', 'Un demi poulet avec du riz et une à son choix boisson', 8.5, 25, 'photos/img-product/60d071d4eb33a_about-us.jpg', 0, 'hors-promo', 'menu', '2021-06-21 13:02:44', 12),
(15, '1 cuisse plus riz plus boisson', '1 cuisse de poulet plus du riz plus une boisson au choix', 7, 30, 'photos/img-product/60d0806898e45_about-us.jpg', 0, 'hors-promo', 'menu', '2021-06-21 14:04:56', 12),
(16, 'Cheese plus frite plus boisson', 'Cheese plus des frites plus une boisson au choix', 4, 25, 'photos/img-product/60d080c11b179_about-us.jpg', 0, 'hors-promo', 'menu-simple', '2021-06-21 14:06:25', 12),
(17, 'Double cheese plus  frite plus boisson', 'Un double cheese plus des frites plus une boisson au choix', 5, 18, 'photos/img-product/60d081323cffd_about-us.jpg', 0, 'hors-promo', 'menu-simple', '2021-06-21 14:08:18', 12),
(18, 'Le big plus frite plus boisson', 'Le big plus des frites plus une boisson au choix', 5, 20, 'photos/img-product/60d0818531f71_about-us.jpg', 0, 'hors-promo', 'menu-simple', '2021-06-21 14:09:41', 12),
(19, 'Chicken burger plus frite plus boisson', 'Chicken burger plus des frites plus une boisson au choix', 5, 22, 'photos/img-product/60d085e028d8e_about-us.jpg', 0, 'hors-promo', 'menu-simple', '2021-06-21 14:28:16', 12),
(20, 'Fish plus frite plus boisson', 'Fish plus des frites plus une boisson au choix', 5, 18, 'photos/img-product/60d0862dddc87_about-us.jpg', 0, 'hors-promo', 'menu-simple', '2021-06-21 14:29:33', 12),
(21, '2 cheese plus frite plus boisson', '2 cheese plus des frites plus une boisson au choix', 6, 9, 'photos/img-product/60d0868f48e57_about-us.jpg', 0, 'hors-promo', 'menu-doublé', '2021-06-21 14:31:11', 12),
(22, '2 double cheese plus frite plus boisson', '2 double cheese plus des frites plus une boisson au choix', 8, 16, 'photos/img-product/60d086ed0693f_about-us.jpg', 0, 'hors-promo', 'menu-doublé', '2021-06-21 14:32:45', 12),
(23, '2 big plus frite plus boisson', '2 big plus des frites plus une boisson au choix', 8, 15, 'photos/img-product/60d08763ae56e_about-us.jpg', 0, 'hors-promo', 'menu-doublé', '2021-06-21 14:34:43', 12),
(24, '2 chicken burger plus frite plus boisson', '2 chicken burger des frites plus une boisson au choix', 8, 19, 'photos/img-product/60d087b530a6c_about-us.jpg', 0, 'hors-promo', 'menu-doublé', '2021-06-21 14:36:05', 12),
(25, '2 fish plus frite plus boisson', '2 fish plus des frites plus une boisson au choix', 8, 17, 'photos/img-product/60d3550b74014_grilled-chicken.jpg', 0, 'hors-promo', 'menu-doublé', '2021-06-23 17:36:43', 14),
(26, 'Canette au choix', 'Canette au choix', 1, 22, 'photos/img-product/60d088b1a17b0_cola.jpg', 0, 'hors-promo', 'boisson', '2021-06-21 14:40:17', 12),
(27, 'Eau plus sirop au choix', 'Eau plus sirop au choix', 1, 16, 'photos/img-product/60d088ef6e5fb_cola.jpg', 0, 'hors-promo', 'boisson', '2021-06-21 14:41:19', 12),
(28, 'Bouteille au choix', 'Bouteille au choix', 2.5, 10, 'photos/img-product/60d0892157308_cola.jpg', 0, 'hors-promo', 'boisson', '2021-06-21 14:42:09', 12);

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
  `statut` enum('client','super-admin','admin-asnieres','admin-argenteuil','admin-bezons','admin-saint-denis','admin- epinay-seine') NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `nom`, `email`, `mdp`, `user_google_id`, `user_facebook_id`, `statut`, `date_enregistrement`) VALUES
(10, 'EQUIPE DEVELOPPEMENT', 'developpement@waveconnect.fr', '$2y$10$gOPyIKakvPvAoqQFrWUtyOO6zvNI4XOB/ptBKUvvWFcWPeqipJ612', NULL, '105900371736594', 'client', '2021-06-22 15:16:54'),
(11, 'EQUIPE DEVELOPPEMENT', 'developpement@waveconnect.fr', '$2y$10$DOeP79/ng9Ir1BRDgHNEBuBD.nsHzxy3XQL3RfXvj3k5DAr6Dq.0u', '114139676919264636726', NULL, 'client', '2021-06-22 15:16:54'),
(13, 'EQUIPE DEVELOPPEMENT', 'developpement@waveconnect.fr', '$2y$10$X1lk6WXRUksGAKhl5ruRoeRZP2B.sTAUF0hXQX3NaaM1u2efPvQa.', '112578999391782868308', NULL, 'client', '2021-06-30 15:50:50'),
(14, 'Daniel', 'daniel@gmail.com', '$2y$10$cBb8M1NW8.PpwTRXl3zIJe68kQfBE9eNbHu7vBQpCykHOvTvXLKk2', NULL, NULL, 'admin-asnieres', '2021-06-22 17:24:38');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`commande_id`);

--
-- Index pour la table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

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
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `commande_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
