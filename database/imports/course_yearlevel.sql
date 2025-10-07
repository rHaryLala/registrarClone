-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 06 oct. 2025 à 16:04
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
-- Structure de la table `course_yearlevel`
--

CREATE TABLE `course_yearlevel` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `year_level_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `course_yearlevel`
--

INSERT INTO `course_yearlevel` (`id`, `course_id`, `year_level_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 1, NULL, NULL),
(5, 5, 1, NULL, NULL),
(6, 5, 2, NULL, NULL),
(7, 6, 2, NULL, NULL),
(8, 7, 2, NULL, NULL),
(9, 8, 2, NULL, NULL),
(10, 9, 2, NULL, NULL),
(11, 10, 2, NULL, NULL),
(12, 11, 2, NULL, NULL),
(13, 12, 2, NULL, NULL),
(14, 13, 1, NULL, NULL),
(15, 13, 2, NULL, NULL),
(16, 14, 1, NULL, NULL),
(17, 15, 2, NULL, NULL),
(18, 16, 1, NULL, NULL),
(19, 16, 2, NULL, NULL),
(20, 17, 2, NULL, NULL),
(21, 18, 1, NULL, NULL),
(22, 18, 2, NULL, NULL),
(23, 19, 1, NULL, NULL),
(24, 19, 2, NULL, NULL),
(25, 20, 2, NULL, NULL),
(26, 21, 2, NULL, NULL),
(27, 22, 1, NULL, NULL),
(28, 22, 2, NULL, NULL),
(29, 23, 1, NULL, NULL),
(30, 23, 2, NULL, NULL),
(31, 24, 1, NULL, NULL),
(32, 24, 2, NULL, NULL),
(33, 25, 2, NULL, NULL),
(34, 26, 2, NULL, NULL),
(35, 27, 1, NULL, NULL),
(36, 27, 2, NULL, NULL),
(37, 28, 1, NULL, NULL),
(38, 28, 2, NULL, NULL),
(39, 29, 2, NULL, NULL),
(40, 30, 2, NULL, NULL),
(41, 31, 2, NULL, NULL),
(42, 32, 2, NULL, NULL),
(43, 33, 2, NULL, NULL),
(44, 34, 2, NULL, NULL),
(45, 35, 2, NULL, NULL),
(46, 36, 1, NULL, NULL),
(47, 36, 2, NULL, NULL),
(48, 37, 2, NULL, NULL),
(49, 38, 2, NULL, NULL),
(50, 39, 1, NULL, NULL),
(51, 39, 2, NULL, NULL),
(52, 40, 1, NULL, NULL),
(53, 40, 2, NULL, NULL),
(54, 41, 1, NULL, NULL),
(55, 41, 2, NULL, NULL),
(56, 42, 1, NULL, NULL),
(57, 43, 1, NULL, NULL),
(58, 44, 1, NULL, NULL),
(59, 45, 2, NULL, NULL),
(60, 46, 2, NULL, NULL),
(61, 47, 1, NULL, NULL),
(62, 47, 2, NULL, NULL),
(63, 48, 1, NULL, NULL),
(64, 48, 2, NULL, NULL),
(65, 49, 1, NULL, NULL),
(66, 49, 2, NULL, NULL),
(67, 50, 2, NULL, NULL),
(68, 51, 1, NULL, NULL),
(69, 51, 2, NULL, NULL),
(71, 52, 2, NULL, NULL),
(72, 53, 1, NULL, NULL),
(73, 53, 2, NULL, NULL),
(74, 54, 1, NULL, NULL),
(75, 54, 2, NULL, NULL),
(76, 55, 1, NULL, NULL),
(77, 55, 2, NULL, NULL),
(78, 56, 2, NULL, NULL),
(79, 57, 2, NULL, NULL),
(80, 58, 2, NULL, NULL),
(81, 59, 1, NULL, NULL),
(82, 59, 2, NULL, NULL),
(83, 60, 1, NULL, NULL),
(84, 60, 2, NULL, NULL),
(85, 61, 2, NULL, NULL),
(86, 62, 2, NULL, NULL),
(87, 63, 2, NULL, NULL),
(88, 64, 2, NULL, NULL),
(89, 65, 2, NULL, NULL),
(90, 66, 2, NULL, NULL),
(91, 67, 2, NULL, NULL),
(92, 68, 2, NULL, NULL),
(93, 69, 2, NULL, NULL),
(94, 1, 2, NULL, NULL),
(95, 70, 1, NULL, NULL),
(96, 66, 1, NULL, NULL),
(97, 68, 1, NULL, NULL),
(98, 69, 1, NULL, NULL),
(99, 63, 1, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `course_yearlevel`
--
ALTER TABLE `course_yearlevel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_yearlevel_course_id_year_level_id_unique` (`course_id`,`year_level_id`),
  ADD KEY `course_yearlevel_year_level_id_foreign` (`year_level_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `course_yearlevel`
--
ALTER TABLE `course_yearlevel`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `course_yearlevel`
--
ALTER TABLE `course_yearlevel`
  ADD CONSTRAINT `course_yearlevel_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_yearlevel_year_level_id_foreign` FOREIGN KEY (`year_level_id`) REFERENCES `year_levels` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
