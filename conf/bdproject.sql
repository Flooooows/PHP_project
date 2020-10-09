-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 18 Mai 2017 à 12:25
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bdproject`
--

-- --------------------------------------------------------

--
-- Structure de la table `courses`
--

CREATE TABLE `courses` (
  `code` char(5) NOT NULL COMMENT 'course''s code',
  `name` varchar(255) NOT NULL,
  `term` varchar(3) NOT NULL,
  `ue_aa` varchar(5) DEFAULT NULL COMMENT 'Course unit / Learning activity',
  `ects` varchar(5) NOT NULL COMMENT 'Number of credits',
  `block` varchar(11) NOT NULL COMMENT 'year 1/2/3',
  `abbreviation` varchar(255) DEFAULT NULL COMMENT 'Name of the course, but shorter'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `presences`
--

CREATE TABLE `presences` (
  `student_mail` varchar(255) NOT NULL,
  `id_sheet` int(11) NOT NULL,
  `presence` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `presences_sheets`
--

CREATE TABLE `presences_sheets` (
  `presence_sheet_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `teacher_mail` varchar(255) NOT NULL,
  `week_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `programs`
--

CREATE TABLE `programs` (
  `serie_num` int(11) NOT NULL,
  `session_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `series`
--

CREATE TABLE `series` (
  `serie_num` int(11) NOT NULL,
  `block` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sessions_type`
--

CREATE TABLE `sessions_type` (
  `session_id` int(11) NOT NULL,
  `code` char(5) NOT NULL,
  `session_name` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `students`
--

CREATE TABLE `students` (
  `student_mail` varchar(255) NOT NULL,
  `serie_num` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `block` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_mail` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `responsability` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `teachers`
--

INSERT INTO `teachers` (`teacher_mail`, `name`, `first_name`, `responsability`) VALUES
('gregory.seront@vinci.be', 'Seront', 'Gregory', 'true');

-- --------------------------------------------------------

--
-- Structure de la table `weeks`
--

CREATE TABLE `weeks` (
  `week_id` int(11) NOT NULL,
  `start_date` varchar(15) NOT NULL,
  `term` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`code`);

--
-- Index pour la table `presences`
--
ALTER TABLE `presences`
  ADD PRIMARY KEY (`student_mail`,`id_sheet`),
  ADD KEY `id_sheet_constraint` (`id_sheet`);

--
-- Index pour la table `presences_sheets`
--
ALTER TABLE `presences_sheets`
  ADD PRIMARY KEY (`presence_sheet_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `teacher_mail` (`teacher_mail`),
  ADD KEY `week_id` (`week_id`);

--
-- Index pour la table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`serie_num`,`session_id`),
  ADD KEY `serie_num` (`serie_num`),
  ADD KEY `session_id` (`session_id`);

--
-- Index pour la table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`serie_num`,`block`),
  ADD KEY `block` (`block`),
  ADD KEY `serie_num` (`serie_num`),
  ADD KEY `block_2` (`block`);

--
-- Index pour la table `sessions_type`
--
ALTER TABLE `sessions_type`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `code` (`code`);

--
-- Index pour la table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_mail`),
  ADD KEY `serie_num` (`serie_num`),
  ADD KEY `block` (`block`),
  ADD KEY `bloc_serie` (`serie_num`,`block`);

--
-- Index pour la table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_mail`);

--
-- Index pour la table `weeks`
--
ALTER TABLE `weeks`
  ADD PRIMARY KEY (`week_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `presences_sheets`
--
ALTER TABLE `presences_sheets`
  MODIFY `presence_sheet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `presences`
--
ALTER TABLE `presences`
  ADD CONSTRAINT `id_sheet_constraint` FOREIGN KEY (`id_sheet`) REFERENCES `presences_sheets` (`presence_sheet_id`),
  ADD CONSTRAINT `mail_constraint` FOREIGN KEY (`student_mail`) REFERENCES `students` (`student_mail`);

--
-- Contraintes pour la table `presences_sheets`
--
ALTER TABLE `presences_sheets`
  ADD CONSTRAINT `PK_SESSION_ID` FOREIGN KEY (`session_id`) REFERENCES `sessions_type` (`session_id`),
  ADD CONSTRAINT `PK_TEACHER_MAIL` FOREIGN KEY (`teacher_mail`) REFERENCES `teachers` (`teacher_mail`),
  ADD CONSTRAINT `PK_WEEK_ID` FOREIGN KEY (`week_id`) REFERENCES `weeks` (`week_id`);

--
-- Contraintes pour la table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `serie_constraint` FOREIGN KEY (`serie_num`) REFERENCES `series` (`serie_num`),
  ADD CONSTRAINT `session_constraint` FOREIGN KEY (`session_id`) REFERENCES `sessions_type` (`session_id`);

--
-- Contraintes pour la table `sessions_type`
--
ALTER TABLE `sessions_type`
  ADD CONSTRAINT `PK_CODE` FOREIGN KEY (`code`) REFERENCES `courses` (`code`);

--
-- Contraintes pour la table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `bloc_serie` FOREIGN KEY (`serie_num`,`block`) REFERENCES `series` (`serie_num`, `block`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
