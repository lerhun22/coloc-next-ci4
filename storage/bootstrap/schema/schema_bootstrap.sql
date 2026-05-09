-- MySQL dump 10.13  Distrib 5.7.39, for osx10.12 (x86_64)
--
-- Host: localhost    Database: coloc
-- ------------------------------------------------------
-- Server version	5.7.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `competitions`
--

DROP TABLE IF EXISTS `competitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competitions` (
  `id` int(11) NOT NULL,
  `numero` smallint(6) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `urs_id` tinyint(4) DEFAULT NULL,
  `saison` year(4) NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_competition` date NOT NULL,
  `max_photos_club` int(11) NOT NULL,
  `max_photos_auteur` int(11) NOT NULL,
  `param_photos_club` int(11) NOT NULL,
  `param_photos_auteur` int(11) NOT NULL,
  `quota` int(11) NOT NULL DEFAULT '0',
  `note_min` tinyint(4) NOT NULL DEFAULT '6',
  `note_max` tinyint(4) NOT NULL DEFAULT '20',
  `nb_auteurs_ur_n2` tinyint(4) NOT NULL DEFAULT '3',
  `nb_clubs_ur_n2` tinyint(4) NOT NULL DEFAULT '7',
  `pte` tinyint(1) NOT NULL DEFAULT '0',
  `nature` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `competition_meta`
--

DROP TABLE IF EXISTS `competition_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competition_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `competition_id` int(11) NOT NULL,
  `saison` year(4) NOT NULL,
  `level` enum('REGIONAL','N2','N1','CDF','DIRECT') COLLATE utf8mb4_unicode_ci NOT NULL,
  `discipline` enum('MONOCHROME','COULEUR','NATURE','AUTEUR','QUADRIMAGE','AUDIOVISUEL','UNKNOWN') COLLATE utf8mb4_unicode_ci NOT NULL,
  `support` enum('PAPIER','IP','UNKNOWN') COLLATE utf8mb4_unicode_ci NOT NULL,
  `participants_type` enum('club','author') COLLATE utf8mb4_unicode_ci DEFAULT 'club',
  `is_official` tinyint(1) DEFAULT '1',
  `source_label` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `normalized_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_competition` (`competition_id`),
  KEY `idx_level` (`level`),
  KEY `idx_discipline` (`discipline`),
  KEY `idx_official` (`is_official`)
) ENGINE=InnoDB AUTO_INCREMENT=503 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `participants`
--

DROP TABLE IF EXISTS `participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participants` (
  `id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urs_id` tinyint(4) DEFAULT NULL,
  `clubs_id` smallint(6) DEFAULT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat_adhesion` tinyint(1) NOT NULL DEFAULT '1',
  `annee_cotisation` year(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `clubs`
--

DROP TABLE IF EXISTS `clubs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clubs` (
  `id` smallint(6) NOT NULL,
  `urs_id` tinyint(4) NOT NULL,
  `numero` smallint(6) NOT NULL,
  `nom` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `ean` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `competitions_id` int(11) NOT NULL,
  `participants_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` tinyint(4) NOT NULL DEFAULT '1',
  `place` smallint(6) NOT NULL DEFAULT '0',
  `note_totale` smallint(6) NOT NULL DEFAULT '0',
  `saisie` int(11) NOT NULL DEFAULT '0',
  `retenue` tinyint(1) NOT NULL DEFAULT '0',
  `medailles_id` int(11) DEFAULT NULL,
  `passage` int(11) NOT NULL,
  `disqualifie` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `competitions_id` (`competitions_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-08  8:07:09
