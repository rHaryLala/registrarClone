-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 01 oct. 2025 à 11:55
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
-- Structure de la table `course_mention`
--

CREATE TABLE `course_mention` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `mention_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `course_mention`
--

INSERT INTO `course_mention` (`id`, `course_id`, `mention_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 1, NULL, NULL),
(5, 5, 1, NULL, NULL),
(6, 6, 1, NULL, NULL),
(7, 7, 1, NULL, NULL),
(8, 8, 1, NULL, NULL),
(9, 9, 1, NULL, NULL),
(10, 10, 1, NULL, NULL),
(11, 11, 1, NULL, NULL),
(12, 12, 1, NULL, NULL),
(13, 13, 2, NULL, NULL),
(14, 14, 2, NULL, NULL),
(15, 15, 2, NULL, NULL),
(16, 16, 2, NULL, NULL),
(17, 17, 2, NULL, NULL),
(18, 18, 2, NULL, NULL),
(19, 19, 2, NULL, NULL),
(20, 20, 2, NULL, NULL),
(21, 21, 2, NULL, NULL),
(22, 22, 3, NULL, NULL),
(23, 23, 3, NULL, NULL),
(24, 24, 3, NULL, NULL),
(25, 14, 3, NULL, NULL),
(26, 25, 3, NULL, NULL),
(27, 26, 3, NULL, NULL),
(28, 27, 3, NULL, NULL),
(29, 28, 3, NULL, NULL),
(30, 29, 3, NULL, NULL),
(31, 30, 3, NULL, NULL),
(32, 31, 4, NULL, NULL),
(33, 32, 4, NULL, NULL),
(34, 33, 4, NULL, NULL),
(35, 34, 4, NULL, NULL),
(36, 35, 4, NULL, NULL),
(37, 36, 4, NULL, NULL),
(38, 37, 4, NULL, NULL),
(39, 38, 4, NULL, NULL),
(40, 39, 4, NULL, NULL),
(41, 40, 4, NULL, NULL),
(42, 41, 4, NULL, NULL),
(43, 42, 4, NULL, NULL),
(44, 43, 4, NULL, NULL),
(45, 44, 4, NULL, NULL),
(46, 14, 6, NULL, NULL),
(47, 45, 6, NULL, NULL),
(48, 46, 6, NULL, NULL),
(49, 47, 6, NULL, NULL),
(50, 48, 6, NULL, NULL),
(51, 49, 6, NULL, NULL),
(52, 50, 6, NULL, NULL),
(53, 51, 6, NULL, NULL),
(54, 52, 6, NULL, NULL),
(55, 14, 7, NULL, NULL),
(56, 53, 7, NULL, NULL),
(57, 54, 7, NULL, NULL),
(58, 55, 7, NULL, NULL),
(59, 56, 7, NULL, NULL),
(60, 57, 7, NULL, NULL),
(61, 58, 7, NULL, NULL),
(62, 59, 7, NULL, NULL),
(63, 60, 7, NULL, NULL),
(64, 61, 8, NULL, NULL),
(65, 62, 8, NULL, NULL),
(66, 63, 8, NULL, NULL),
(67, 64, 8, NULL, NULL),
(68, 65, 8, NULL, NULL),
(69, 66, 8, NULL, NULL),
(70, 67, 8, NULL, NULL),
(71, 68, 8, NULL, NULL),
(72, 69, 8, NULL, NULL),
(73, 70, 7, NULL, NULL),
(74, 14, 8, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `course_mention`
--
ALTER TABLE `course_mention`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_mention_course_id_mention_id_unique` (`course_id`,`mention_id`),
  ADD KEY `course_mention_mention_id_foreign` (`mention_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `course_mention`
--
ALTER TABLE `course_mention`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `course_mention`
--
ALTER TABLE `course_mention`
  ADD CONSTRAINT `course_mention_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_mention_mention_id_foreign` FOREIGN KEY (`mention_id`) REFERENCES `mentions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
