-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 01 oct. 2025 à 13:24
-- Version du serveur : 11.8.3-MariaDB-log
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `u430393732_7Hb3d`
--

-- --------------------------------------------------------

--
-- Structure de la table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `diplome` varchar(255) DEFAULT NULL,
  `last_change_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_change_datetime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `email`, `telephone`, `diplome`, `last_change_user_id`, `last_change_datetime`, `created_at`, `updated_at`) VALUES
(1, 'Kancel Daniel', 'uaz.rector@zurcher.edu.mg', '038 07 731 38', 'PhD (Sciences de l\'antiquité)', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(2, 'Andrianasolo Tantely', 'uaz.dean@zurcher.edu.mg', '034 18 810 86', 'MBA, PhD en cours', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(3, 'Andriamanjato Bruno', 'randriamanjatob@zurcher.edu.mg ', '034 08 725 37', 'Master en théologie, MA (finance), PhD en cours', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(4, 'Rakotomahefa Andriamirindra', 'uaz.studentsaffairs@zurcher.edu.mg', '034 07 056 20', 'Doctorat (Sciences cognitives et applications)', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(5, 'Rakotoarisoa Tahina Hosea', 'tahinahosearak@zurcher.edu.mg ', '034 02 019 06', 'MDiv, en cours', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(6, 'Andriamiarintsoa Laurent', 'laurentandriamiarintsoa@gmail.com ', '034 67 914 82', 'PhD, en cours', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(7, 'Rajaonarison Velomanantsoa', 'rajaonarisonv@iou.adventist.org', '033 74 701 50', '', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(8, 'Ratsimbason Jacques', 'jacques.ratsimbason@yahoo.com', '034 05 147 77', 'DMin', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(9, 'Kancel Christelle', 'christelle.kancel@zurcher.edu.mg', '', 'MA (Economie)', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(10, 'Andriantiana Mahasetra', 'mahasetra.a@zurcher.edu.mg', '', 'MBA (Finance et Comptabilité)', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(11, 'Andriambahoaka Manda', 'andriamanda@zurcher.edu.mg', '', 'MA (Economie), PhD', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(12, 'Ranala Antra Miary Zo', 'rmiaryzo@gmail.com', '', '', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(13, 'Nomenjanahary Roger Francky', 'nomenjanahary.r@zurcher.edu.mg', '', '', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(14, 'Ravaonirina Jeanne Eléonore', '', '', '', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(15, 'Rabioarison Nomenjanahary Riault', 'rabioarison.n@zurcher.edu.mg', '034 91 519 06', '', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(16, 'Ranaivomanoelina Herisarobidy Seth', 'herisarobidyseth@gmail.com', '034 89 604 63', '', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(17, 'Rabeson Ariniaina Mamitiana ', 'rabeson.a@zurcher.edu.mg', '038 69 310 04', '', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(18, 'Andrianomenjanahary Ladina Sedera', 'ladina.sedera@zurcher.edu.mg', '034 11 104 72', '', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(19, 'Randrianasolo Misaela', 'randrianasolo.misaela@gmail.com', '034 99 729 88', '', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(20, 'Tafitarison Narindra', 'tafitarison@zurcher.edu.mg', '', '', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(21, 'Mahafoudhou Moussa Hamadi', 'hamadi.m@zurcher.edu.mg', '', '', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(22, 'Rakotonirina Alain Barnabé', 'rakotoalainb@zurcher.edu.mg', '034 76 649 57', 'Doctorat en informatique', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(23, 'Ravoninjatovo Sitraka', 'sitrakarsio@zurcher.edu.mg', '', 'MSN', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(24, 'Rasoanirina Elisoa', 'ravoninjatovoel@zurcher.edu.mg', '', 'Master en gestion hospitalière', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(25, 'Rabemanantsoa Holitiana', 'holitiana@zurcher.edu.mg', '', 'MA (Education), BSN (Sage-femme)', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(26, 'Andriatahiananirina Sarobidy', 'sarobidiniaina.h@zurcher.edu.mg', '', '', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(27, 'Ratsimbamialisoa Nasolo', 'ratsimbamialisoa.n@zurcher.edu.mg', '', '', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(28, 'Rasamy Martino Brunel', 'rasamybrunel@gmail.com', '', 'Doctorat en médecine', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(29, 'Rasolohery Sedra Nihoarana', 'email', '', 'Doctorat en médecine', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(30, 'Malalanirina Daniella', 'daniellamalalanirina@zurcher.edu.mg', '', 'Master en santé publique', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(31, 'Ravololomanana Nirisoa Sahondra', 'sahondra@zurcher.edu.mg', '', 'MA (Education)', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(32, 'Ranala Marc Arthur', 'marcarthurranala@gmail.com', '', 'MA (Leadership)', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(33, 'Ramahoherilalaina Jimmy Lovasoa', 'herilovas@zurcher.edu.mg', '', 'Master en informatique', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(34, 'Rakotondrainibe Dina', 'dina.rakoto.fle@zurcher.edu.mg', '', 'MA (Français langue étrangère)', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(35, 'Ranaivomanoelina Vonimboahirana Michée', 'vonimboahirana.mimiche@gmail.com', '', 'MA (Anglais)', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(36, 'Ramanantsialonina Malalaniaina', 'uaz.malalaniaina@zurcher.edu.mg', '', 'Master en informatique', NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(37, 'Mr. Benjanirina', 'benjanirina@zurcher.edu.mg', '-', '-', 1, '2025-10-01 09:54:38', '2025-10-01 09:40:14', '2025-10-01 09:54:38'),
(38, 'Nomenjanahary Sarobidy Luc', 'lucsarobidynomenjanahary@gmail.com', '-', '-', 1, '2025-10-01 09:47:24', '2025-10-01 09:47:24', '2025-10-01 09:47:24'),
(39, 'Mme Sarah', 'sarah@zurcher.edu.mg', '-', '-', 1, '2025-10-01 10:04:02', '2025-10-01 09:49:16', '2025-10-01 10:04:02'),
(40, 'Nahmias Enoch', 'nahmiase@fme.adventist.org', '-', '-', 1, '2025-10-01 09:50:55', '2025-10-01 09:50:55', '2025-10-01 09:50:55'),
(41, 'Mme Tantely', 'tantely@zurcher.edu.mg', '-', '-', 1, '2025-10-01 10:03:42', '2025-10-01 09:54:14', '2025-10-01 10:03:42'),
(42, 'Mme Volasoa', 'volasoa@zurcher.edu.mg', '-', '-', 1, '2025-10-01 10:03:52', '2025-10-01 10:01:25', '2025-10-01 10:03:52'),
(43, 'Mme Raminosoa', 'raminosoa@zurcher.edu.mg', '-', '-', 1, '2025-10-01 10:03:22', '2025-10-01 10:03:22', '2025-10-01 10:03:22'),
(44, 'Mme Sambatra', 'sambatra@zurcher.edu.mg', '-', '-', 1, '2025-10-01 10:04:26', '2025-10-01 10:04:26', '2025-10-01 10:04:26'),
(45, 'Mr Voahanginiaina', 'assgerdaa@gmail.com', '0342932351', '-', 1, '2025-10-01 10:14:57', '2025-10-01 10:14:57', '2025-10-01 10:14:57'),
(46, 'Mme Lalaina', 'lalainaerlhis@gmail.com', '0340583017', '-', 1, '2025-10-01 10:15:55', '2025-10-01 10:15:55', '2025-10-01 10:15:55'),
(47, 'Mme Haingo', 'haingodie@gmail.com', '0340675131', '-', 1, '2025-10-01 10:18:46', '2025-10-01 10:18:46', '2025-10-01 10:18:46');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_email_unique` (`email`),
  ADD KEY `teachers_last_change_user_id_foreign` (`last_change_user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_last_change_user_id_foreign` FOREIGN KEY (`last_change_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
