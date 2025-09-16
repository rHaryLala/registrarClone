-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 16 sep. 2025 à 16:31
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `registrar_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_2024_finance_detail_licence`
--

CREATE TABLE `t_2024_finance_detail_licence` (
  `id` int(11) NOT NULL,
  `std_status` varchar(100) NOT NULL,
  `std_mention` varchar(70) NOT NULL,
  `frais_generaux` float NOT NULL,
  `ecolage` float NOT NULL,
  `laboratory` float NOT NULL,
  `dortoir` double NOT NULL,
  `nb_jours_semestre` int(11) NOT NULL,
  `nb_jours_semestre_L2` int(11) NOT NULL,
  `nb_jours_semestre_L3` int(11) NOT NULL,
  `cafeteria` float NOT NULL,
  `fond_depot` float NOT NULL,
  `frais_graduation` double NOT NULL,
  `frais_costume` float NOT NULL,
  `frais_voyage` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_2024_finance_detail_licence`
--

INSERT INTO `t_2024_finance_detail_licence` (`id`, `std_status`, `std_mention`, `frais_generaux`, `ecolage`, `laboratory`, `dortoir`, `nb_jours_semestre`, `nb_jours_semestre_L2`, `nb_jours_semestre_L3`, `cafeteria`, `fond_depot`, `frais_graduation`, `frais_costume`, `frais_voyage`) VALUES
(1, 'Interne', 'NURS', 290000, 19000, 0, 3000, 107, 80, 80, 8000, 80000, 150000, 0, 100000),
(2, 'Interne', 'COMM', 210000, 19000, 35000, 3000, 118, 118, 118, 8000, 80000, 150000, 0, 100000),
(3, 'Interne', 'DROI', 210000, 19000, 0, 3000, 118, 118, 118, 8000, 80000, 150000, 0, 100000),
(4, 'Interne', 'GEST', 210000, 19000, 0, 3000, 118, 118, 118, 8000, 80000, 150000, 0, 100000),
(5, 'Interne', 'THEO', 210000, 19000, 0, 3000, 118, 118, 118, 8000, 80000, 150000, 150000, 50000),
(6, 'Interne', 'INFO', 210000, 19000, 35000, 3000, 118, 118, 118, 8000, 80000, 150000, 0, 100000),
(7, 'Interne', 'LANG', 210000, 19000, 0, 3000, 118, 118, 118, 8000, 80000, 150000, 0, 100000),
(8, 'Interne', 'EDUC', 210000, 19000, 0, 3000, 118, 118, 118, 8000, 80000, 150000, 0, 100000),
(9, 'Bungalow', 'NURS', 290000, 19000, 0, 794.392523, 107, 80, 80, 8000, 0, 150000, 0, 100000),
(10, 'Bungalow', 'COMM', 210000, 19000, 35000, 720.338983, 118, 118, 118, 8000, 0, 150000, 0, 100000),
(11, 'Bungalow', 'DROI', 210000, 19000, 0, 720.338983, 118, 118, 118, 8000, 0, 150000, 0, 100000),
(12, 'Bungalow', 'GEST', 210000, 19000, 0, 720.338983, 118, 118, 118, 8000, 0, 150000, 0, 100000),
(13, 'Bungalow', 'THEO', 210000, 19000, 0, 720.338983, 118, 118, 118, 8000, 0, 150000, 150000, 50000),
(14, 'Bungalow', 'INFO', 210000, 19000, 35000, 720.338983, 118, 118, 118, 8000, 0, 150000, 0, 100000),
(15, 'Bungalow', 'LANG', 210000, 19000, 0, 720.338983, 118, 118, 118, 8000, 0, 150000, 0, 100000),
(16, 'Bungalow', 'EDUC', 210000, 19000, 0, 720.338983, 118, 118, 118, 8000, 0, 150000, 0, 100000),
(17, 'Externe', 'NURS', 290000, 19000, 0, 0, 107, 80, 80, 8000, 0, 150000, 0, 100000),
(18, 'Externe', 'COMM', 210000, 19000, 35000, 0, 118, 118, 118, 8000, 0, 150000, 0, 100000),
(19, 'Externe', 'DROI', 210000, 19000, 0, 0, 118, 118, 118, 8000, 0, 150000, 0, 100000),
(20, 'Externe', 'GEST', 210000, 19000, 0, 0, 118, 118, 118, 8000, 0, 150000, 0, 100000),
(21, 'Externe', 'THEO', 210000, 19000, 0, 0, 118, 118, 118, 8000, 0, 150000, 150000, 50000),
(22, 'Externe', 'INFO', 210000, 19000, 35000, 0, 118, 118, 118, 8000, 0, 150000, 0, 100000),
(23, 'Externe', 'LANG', 210000, 19000, 0, 0, 118, 118, 118, 8000, 0, 150000, 0, 100000),
(24, 'Externe', 'EDUC', 210000, 19000, 0, 0, 118, 118, 118, 8000, 0, 150000, 0, 100000);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `t_2024_finance_detail_licence`
--
ALTER TABLE `t_2024_finance_detail_licence`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `t_2024_finance_detail_licence`
--
ALTER TABLE `t_2024_finance_detail_licence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
