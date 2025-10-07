-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 06 oct. 2025 à 16:03
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
-- Structure de la table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mention_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sigle` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `credits` int(11) NOT NULL,
  `categorie` enum('général','majeur') NOT NULL DEFAULT 'général',
  `labo_info` tinyint(1) NOT NULL DEFAULT 0,
  `labo_comm` tinyint(1) NOT NULL DEFAULT 0,
  `labo_langue` tinyint(1) NOT NULL DEFAULT 0,
  `last_change_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_change_datetime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `courses`
--

INSERT INTO `courses` (`id`, `teacher_id`, `mention_id`, `sigle`, `nom`, `credits`, `categorie`, `labo_info`, `labo_comm`, `labo_langue`, `last_change_user_id`, `last_change_datetime`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 'GCOM 100', 'Techniques informatiques', 3, 'majeur', 1, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(2, NULL, 1, 'GCAS 100', 'Français soutien', 6, 'général', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(3, 1, 1, 'RELB 110', 'Connaissances bibliques', 3, 'général', 0, 0, 0, 1, '2025-10-01 09:52:43', '2025-09-30 10:36:45', '2025-10-01 09:52:43'),
(4, NULL, 1, 'CRAN 001', 'Anglais pour débutants', 3, 'général', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(5, 5, 1, 'RELR 201', 'Méthodes de recherche', 4, 'général', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(6, 39, 1, 'RELG 201', 'Français théologique', 3, 'général', 0, 0, 0, 1, '2025-10-01 09:49:34', '2025-09-30 10:36:45', '2025-10-01 09:49:34'),
(7, 1, 1, 'RELB 211', 'Introduction à la Bible', 5, 'majeur', 0, 0, 0, 1, '2025-10-01 09:53:06', '2025-09-30 10:36:45', '2025-10-01 09:53:06'),
(8, 3, 1, 'RELL 231', 'Grec I', 5, 'majeur', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(9, 6, 1, 'RELT 241', 'Doctrines bibliques', 5, 'majeur', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(10, NULL, 1, 'RELP 261', 'Colportage', 2, 'majeur', 0, 0, 0, 1, '2025-10-01 09:51:29', '2025-09-30 10:36:45', '2025-10-01 09:51:29'),
(11, 8, 1, 'RELP 281', 'Introduction au service pastoral', 3, 'majeur', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(12, 3, 1, 'RELP 291', 'Formation spirituelle', 3, 'majeur', 0, 0, 0, 1, '2025-10-01 09:53:31', '2025-09-30 10:36:45', '2025-10-01 09:53:31'),
(13, 13, 2, 'CGMR 201', 'Méthodes d\'études et de recherche', 4, 'général', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(14, NULL, 2, 'CRFR 001', 'Cours de soutien de FRS', 6, 'général', 0, 0, 0, 1, '2025-10-01 14:25:10', '2025-09-30 10:36:45', '2025-10-01 14:25:10'),
(15, 14, 2, 'CGFR 201', 'Français des affaires I', 3, 'général', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(16, 41, 2, 'CGAN 201', 'Anglais I', 3, 'général', 0, 0, 0, 1, '2025-10-01 09:54:58', '2025-09-30 10:36:45', '2025-10-01 09:54:58'),
(17, 15, 2, 'CGRE 201', 'Jésus, PDG', 3, 'général', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(18, 16, 2, 'CGIN 201', 'Informatique', 4, 'majeur', 1, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(19, 9, 2, 'GECO 211', 'Introduction à la comptabilité I', 5, 'majeur', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(20, 12, 2, 'GEMG 211', 'Principes de management', 4, 'majeur', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(21, 37, 2, 'GEMA 211', 'Mathématiques pour la gestion I', 4, 'majeur', 0, 0, 0, 1, '2025-10-01 09:46:35', '2025-09-30 10:36:45', '2025-10-01 09:46:35'),
(22, 4, 3, 'INAL 211', 'Logique et algorithmique sur Python', 4, 'majeur', 1, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(23, 17, 3, 'INEL 211', 'Outils bureautiques et internet', 3, 'majeur', 1, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(24, 41, 3, 'INEN 211', 'Anglais I', 3, 'général', 0, 0, 0, 1, '2025-10-01 09:55:38', '2025-09-30 10:36:45', '2025-10-01 09:55:38'),
(25, 14, 3, 'INFR 211', 'Français - Langue vivante', 3, 'général', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(26, 38, 3, 'INMA 211', 'Mathématiques générales et statistique', 4, 'majeur', 0, 0, 0, 1, '2025-10-01 09:47:41', '2025-09-30 10:36:45', '2025-10-01 09:47:41'),
(27, 13, 3, 'INMR 211', 'Méthode d\'Etude et de Recherche', 4, 'général', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(28, 15, 3, 'INRE 211', 'Vie et enseignement de Jésus', 3, 'général', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(29, 20, 3, 'INSE 211', 'Principes de fonctionnement des ordinateurs', 3, 'majeur', 0, 0, 0, 1, '2025-10-01 09:57:14', '2025-09-30 10:36:45', '2025-10-01 09:57:14'),
(30, 22, 3, 'INSE 212', 'Théories des systèmes d\'exploitation', 3, 'majeur', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(31, 13, 4, 'BIOM 4111', 'Structure et Fonction des biomolécules', 4, 'majeur', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(32, 27, 4, 'BIOC 4111', 'Tissus et Biologie cellulaire I', 4, 'majeur', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(33, 28, 4, 'PHYS 4111', 'Physiologie I', 5, 'majeur', 0, 0, 0, 1, '2025-10-01 09:57:55', '2025-09-30 10:36:45', '2025-10-01 09:57:55'),
(34, 23, 4, 'NRSP 4111', 'UE Spécifique I : Démarche de soins infirmiers I (SICM, SIP,SIGO)', 5, 'majeur', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(35, 27, 4, 'ANAT 4111', 'Anatomie I : Anatomie viscérale', 5, 'majeur', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(36, 24, 4, 'HYGI 4111', 'hygiène hospitalière', 2, 'majeur', 0, 0, 0, 1, '2025-10-01 09:58:26', '2025-09-30 10:36:45', '2025-10-01 09:58:26'),
(37, 14, 4, 'FREN 9111', 'Français courant', 1, 'général', 0, 0, 0, 1, '2025-09-30 17:02:18', '2025-09-30 10:36:45', '2025-09-30 17:02:18'),
(38, 28, 4, 'FREN 4111', 'Français médical', 1, 'majeur', 0, 0, 0, 1, '2025-09-30 17:02:49', '2025-09-30 10:36:45', '2025-09-30 17:02:49'),
(39, 13, 4, 'RELB 9111', 'Vie et enseignement de Jésus', 1, 'général', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(40, 21, 4, 'INSY 9111', 'Informatique (TIAC)', 1, 'général', 1, 0, 0, 1, '2025-10-01 09:59:44', '2025-09-30 10:36:45', '2025-10-01 09:59:44'),
(41, 27, 4, 'PERD 4111', 'Développement personnel I et méthodologie de travail', 1, 'majeur', 0, 0, 0, 1, '2025-10-01 10:00:31', '2025-09-30 10:36:45', '2025-10-01 10:00:31'),
(42, NULL, 4, 'CRFR 0011', 'Cours de soutien de FRS', 6, 'général', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(43, NULL, 4, 'CRAN 0011', 'Cours de soutien de ANG', 6, 'général', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(44, NULL, 4, 'CRSC 0011', 'Science générale', 6, 'général', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(45, 42, 6, 'COIJ 211', 'Initiation au journalisme', 4, 'majeur', 0, 0, 0, 1, '2025-10-01 10:02:30', '2025-09-30 10:36:45', '2025-10-01 10:02:30'),
(46, 16, 6, 'COMC 211', 'Média et culture de Madagascar', 3, 'majeur', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(47, 43, 6, 'COEN 211', 'Anglais: parlé et écrit', 4, 'général', 0, 0, 0, 1, '2025-10-01 10:04:47', '2025-09-30 10:36:45', '2025-10-01 10:04:47'),
(48, 31, 6, 'COMR 211', 'Méthodologie de travail universitaire', 4, 'général', 0, 0, 0, 1, '2025-10-01 10:05:29', '2025-09-30 10:36:45', '2025-10-01 10:05:29'),
(49, 44, 6, 'COIC 211', 'Introduction à la communication', 4, 'majeur', 0, 0, 0, 1, '2025-10-01 10:05:54', '2025-09-30 10:36:45', '2025-10-01 10:05:54'),
(50, 42, 6, 'COFR 211', 'Français: parlé et écrit', 4, 'majeur', 0, 0, 0, 1, '2025-10-01 10:06:10', '2025-09-30 10:36:45', '2025-10-01 10:06:10'),
(51, 33, 6, 'COIN 211', 'Informatique bureautique', 4, 'général', 1, 0, 0, 1, '2025-10-01 10:09:09', '2025-09-30 10:36:45', '2025-10-01 10:09:09'),
(52, 15, 6, 'CORE 211', 'Vie et enseignements de Jésus', 3, 'général', 0, 0, 0, 1, '2025-09-30 13:48:54', '2025-09-30 10:36:45', '2025-09-30 13:48:54'),
(53, 33, 7, 'GSIT 210', 'Fundamentals of Microcomputer+Keyboarding', 4, 'général', 1, 0, 0, 1, '2025-10-01 10:10:16', '2025-09-30 10:36:45', '2025-10-01 10:10:16'),
(54, 31, 7, 'GSRE 210', 'Study and Research Methods', 4, 'général', 0, 0, 0, 1, '2025-10-01 10:10:27', '2025-09-30 10:36:45', '2025-10-01 10:10:27'),
(55, 15, 7, 'GSRE 211', 'Life and Teaching of Jesus', 3, 'général', 0, 0, 0, 1, '2025-10-01 10:10:42', '2025-09-30 10:36:45', '2025-10-01 10:10:42'),
(56, 34, 7, 'FRLA 211', 'Intermediate French', 4, 'général', 0, 0, 0, 1, '2025-10-01 10:11:03', '2025-09-30 10:36:45', '2025-10-01 10:11:03'),
(57, NULL, 7, 'ENLA 212', 'Use of English', 4, 'général', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(58, 35, 7, 'ENLA 213', 'Auditory & Speaking Skills - I', 4, 'majeur', 0, 0, 0, 1, '2025-10-01 10:11:35', '2025-09-30 10:36:45', '2025-10-01 10:11:35'),
(59, 41, 7, 'ENLA 214', 'Introduction to phonetics and Phonology of English', 4, 'majeur', 0, 0, 0, 1, '2025-10-01 10:11:50', '2025-09-30 10:36:45', '2025-10-01 10:11:50'),
(60, NULL, 7, 'ENLA 215', 'American Civilization', 3, 'majeur', 0, 0, 0, NULL, '2025-09-30 10:36:45', '2025-09-30 10:36:45', '2025-09-30 10:36:45'),
(61, 47, 8, 'DRT 223', 'Relations internationales I', 4, 'majeur', 0, 0, 0, 1, '2025-10-01 10:18:56', '2025-09-30 10:36:45', '2025-10-01 10:18:56'),
(62, 36, 8, 'DRT 211', 'Droit civil I', 6, 'majeur', 0, 0, 0, 1, '2025-10-01 10:17:52', '2025-09-30 10:36:45', '2025-10-01 10:17:52'),
(63, 36, 8, 'DRT 231', 'Introduction à l\'étude du Droit I', 4, 'majeur', 0, 0, 0, 1, '2025-10-01 14:25:42', '2025-09-30 10:36:45', '2025-10-01 14:25:42'),
(64, 46, 8, 'DRT 221', 'Droit constitutionnel 1', 6, 'majeur', 0, 0, 0, 1, '2025-10-01 10:16:16', '2025-09-30 10:36:45', '2025-10-01 10:16:16'),
(65, 45, 8, 'DRT 234', 'Economie', 3, 'majeur', 0, 0, 0, 1, '2025-10-01 10:15:11', '2025-09-30 10:36:45', '2025-10-01 10:15:11'),
(66, 15, 8, 'DRTJ 211', 'Vie de Jesus', 3, 'général', 0, 0, 0, 1, '2025-10-01 14:24:13', '2025-09-30 10:36:45', '2025-10-01 14:24:13'),
(67, 14, 8, 'DRF 211', 'Français juridique I', 3, 'général', 0, 0, 0, 1, '2025-10-01 10:13:43', '2025-09-30 10:36:45', '2025-10-01 10:13:43'),
(68, 17, 8, 'DRTI 211', 'Informatique', 3, 'général', 1, 0, 0, 1, '2025-10-01 14:24:17', '2025-09-30 10:36:45', '2025-10-01 14:24:17'),
(69, 41, 8, 'DRA 211', 'Anglais I', 3, 'général', 0, 0, 0, 1, '2025-10-01 14:24:22', '2025-09-30 10:36:45', '2025-10-01 14:24:22'),
(70, NULL, 7, 'ENCR 111', 'English Fundation', 6, 'général', 0, 0, 0, 1, '2025-09-30 14:04:43', '2025-09-30 14:04:43', '2025-09-30 14:04:43');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_sigle_unique` (`sigle`),
  ADD KEY `courses_teacher_id_foreign` (`teacher_id`),
  ADD KEY `courses_mention_id_foreign` (`mention_id`),
  ADD KEY `courses_last_change_user_id_foreign` (`last_change_user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_last_change_user_id_foreign` FOREIGN KEY (`last_change_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `courses_mention_id_foreign` FOREIGN KEY (`mention_id`) REFERENCES `mentions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courses_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
