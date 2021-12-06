-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 06 déc. 2021 à 02:12
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `l3_projet_picassouille`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_fichier_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_heure_enregistrement` datetime NOT NULL,
  `corps_article` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `titre`, `nom_fichier_image`, `date_heure_enregistrement`, `corps_article`) VALUES
(1, 'Nouvelle attaque Artfight', '1.png', '2021-07-30 09:43:08', 'Nouvelle oeuvre (friendly fire) sur Artfight'),
(2, 'Nouvelle attaque Artfight', '2.png', '2021-07-30 09:43:08', 'Nouvelle oeuvre (friendly fire) sur Artfight'),
(3, 'Nouvelle attaque Artfight', '3.png', '2021-07-30 09:43:08', 'Nouvelle oeuvre (revenge) sur Artfight'),
(4, 'Nouvelle attaque Artfight', '4.png', '2021-07-17 09:43:08', 'Nouvelle oeuvre (revenge) sur Artfight');

-- --------------------------------------------------------

--
-- Structure de la table `article_tag`
--

CREATE TABLE `article_tag` (
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article_tag`
--

INSERT INTO `article_tag` (`article_id`, `tag_id`) VALUES
(1, 2),
(1, 17),
(2, 2),
(2, 17),
(3, 2),
(3, 17),
(4, 2),
(4, 17);

-- --------------------------------------------------------

--
-- Structure de la table `atelier`
--

CREATE TABLE `atelier` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut` datetime NOT NULL,
  `duree` int(11) NOT NULL,
  `nb_place` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `atelier`
--

INSERT INTO `atelier` (`id`, `titre`, `description`, `date_debut`, `duree`, `nb_place`) VALUES
(1, 'Premiers pas dans le monde de l\'art', 'Premiers essai aux dessin, création de paysages et premiers croquis', '2017-04-26 09:43:08', 4, 22),
(2, 'Paysages simplistes', 'Analyse de paysage et retranscription des données', '2018-05-13 09:43:08', 6, 16);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20211008094109', '2021-11-10 09:42:13', 137),
('DoctrineMigrations\\Version20211008094827', '2021-11-10 09:42:20', 60),
('DoctrineMigrations\\Version20211008095713', '2021-11-10 09:42:23', 172),
('DoctrineMigrations\\Version20211125150815', '2021-11-25 16:08:27', 50),
('DoctrineMigrations\\Version20211204162656', '2021-12-04 17:27:51', 27);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `id` int(11) NOT NULL,
  `id_atelier_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id`, `id_atelier_id`, `nom`, `prenom`, `email`, `telephone`, `message`) VALUES
(1, 1, 'nom', 'prenom', 'prenom.nom@gmail.com', '0602060206', NULL),
(2, 1, 'test', 'test', 'test.test@gmail.com', '0602060202', 'Je souhaite rejoindre cet atelier');

-- --------------------------------------------------------

--
-- Structure de la table `mail_contact`
--

CREATE TABLE `mail_contact` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sujet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `reponse` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `oeuvre`
--

CREATE TABLE `oeuvre` (
  `id` int(11) NOT NULL,
  `id_type_id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `largeur` int(11) NOT NULL,
  `hauteur` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_fichier_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_publication` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `oeuvre`
--

INSERT INTO `oeuvre` (`id`, `id_type_id`, `titre`, `largeur`, `hauteur`, `description`, `nom_fichier_image`, `date_publication`) VALUES
(1, 2, 'Fatigue', 1080, 1080, 'Artfight 2021', '1.png', '2021-07-30 16:00:00'),
(2, 2, 'Colorful Hero', 1080, 1080, 'Artfight 2021', '2.png', '2021-07-30 09:00:00'),
(3, 2, 'Silence in the Winter Court', 1080, 1080, 'Artfight 2021', '3.png', '2021-07-30 04:00:00'),
(4, 2, 'Snowbelle', 1920, 1080, 'Artfight 2021', '4.png', '2021-07-17 14:00:00'),
(5, 2, 'Raspberry Cookie', 1920, 1080, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', '5.png', '0000-00-00 00:00:00'),
(8, 2, 'Bonne blague', 800, 800, 'Artfight 2021', '8.png', '2021-07-17 12:00:00'),
(9, 2, 'Fluo Rebel', 1920, 1080, 'Artfight 2021', '9.png', '2021-07-09 10:30:00'),
(16, 3, 'Logo Soirée Pizza', 2000, 2000, '<p>Un logo cr&eacute;&eacute; pour l&#39;association Soir&eacute;e Pizza, organisatrice d&#39;&eacute;v&egrave;nements</p>', 'soireepizza-16-06-2020.png', '2020-06-16 01:43:33');

-- --------------------------------------------------------

--
-- Structure de la table `oeuvre_tag`
--

CREATE TABLE `oeuvre_tag` (
  `oeuvre_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `oeuvre_tag`
--

INSERT INTO `oeuvre_tag` (`oeuvre_id`, `tag_id`) VALUES
(1, 7),
(1, 10),
(1, 13),
(1, 15),
(2, 7),
(2, 10),
(2, 13),
(2, 15),
(3, 7),
(3, 10),
(3, 13),
(3, 15),
(4, 7),
(4, 10),
(4, 16),
(5, 7),
(5, 10),
(5, 16),
(16, 13);

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tag`
--

INSERT INTO `tag` (`id`, `libelle`) VALUES
(1, 'atelier'),
(2, 'oeuvre'),
(3, 'news'),
(4, 'exposition'),
(5, 'commande'),
(6, 'monochrome'),
(7, 'couleur'),
(8, 'format paysage'),
(9, 'transparent'),
(10, 'personnage'),
(11, 'format portrait'),
(12, 'décor'),
(13, 'carré'),
(14, 'petite taille'),
(15, 'moyenne taille'),
(16, 'grande taille'),
(17, 'évènement');

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id`, `libelle`) VALUES
(1, 'Affiche'),
(2, 'Illustration'),
(3, 'Logo');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `login` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `login`, `roles`, `password`, `nom`, `prenom`) VALUES
(1, 'testadmin@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$fPKTMh4/BZpxDXu3qjAdKe9pKplLpL.ED0CYTbSmVeTszQkbmTmbq', 'ADMIN', 'Test');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `article_tag`
--
ALTER TABLE `article_tag`
  ADD PRIMARY KEY (`article_id`,`tag_id`),
  ADD KEY `IDX_919694F97294869C` (`article_id`),
  ADD KEY `IDX_919694F9BAD26311` (`tag_id`);

--
-- Index pour la table `atelier`
--
ALTER TABLE `atelier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5E90F6D627684FE2` (`id_atelier_id`);

--
-- Index pour la table `mail_contact`
--
ALTER TABLE `mail_contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `oeuvre`
--
ALTER TABLE `oeuvre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_35FE2EFE1BD125E3` (`id_type_id`);

--
-- Index pour la table `oeuvre_tag`
--
ALTER TABLE `oeuvre_tag`
  ADD PRIMARY KEY (`oeuvre_id`,`tag_id`),
  ADD KEY `IDX_C604AC1788194DE8` (`oeuvre_id`),
  ADD KEY `IDX_C604AC17BAD26311` (`tag_id`);

--
-- Index pour la table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1D1C63B3AA08CB10` (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `atelier`
--
ALTER TABLE `atelier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `mail_contact`
--
ALTER TABLE `mail_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `oeuvre`
--
ALTER TABLE `oeuvre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article_tag`
--
ALTER TABLE `article_tag`
  ADD CONSTRAINT `FK_919694F97294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_919694F9BAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `FK_5E90F6D627684FE2` FOREIGN KEY (`id_atelier_id`) REFERENCES `atelier` (`id`);

--
-- Contraintes pour la table `oeuvre`
--
ALTER TABLE `oeuvre`
  ADD CONSTRAINT `FK_35FE2EFE1BD125E3` FOREIGN KEY (`id_type_id`) REFERENCES `type` (`id`);

--
-- Contraintes pour la table `oeuvre_tag`
--
ALTER TABLE `oeuvre_tag`
  ADD CONSTRAINT `FK_C604AC1788194DE8` FOREIGN KEY (`oeuvre_id`) REFERENCES `oeuvre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_C604AC17BAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
