-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: clanwolf
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.34-MariaDB-1:10.4.34+maria~ubu2004

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `asc_mech`
--

DROP TABLE IF EXISTS `asc_mech`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_mech` (
  `mechid` int(11) NOT NULL AUTO_INCREMENT,
  `mech_number` varchar(50) NOT NULL DEFAULT '--',
  `tech` int(5) DEFAULT NULL,
  `mulid` int(11) DEFAULT NULL,
  `mech_tonnage` int(11) DEFAULT NULL,
  `as_model` varchar(100) DEFAULT NULL,
  `as_pv` int(11) DEFAULT NULL,
  `as_tp` varchar(50) DEFAULT NULL,
  `as_sz` int(11) DEFAULT NULL,
  `as_tmm` int(11) DEFAULT NULL,
  `as_mv` int(11) DEFAULT NULL,
  `as_mvj` int(11) DEFAULT NULL,
  `as_role` varchar(100) DEFAULT NULL,
  `as_skill` int(11) DEFAULT NULL,
  `as_short` int(11) DEFAULT NULL,
  `as_short_min` int(11) DEFAULT NULL,
  `as_medium` int(11) DEFAULT NULL,
  `as_medium_min` int(11) DEFAULT NULL,
  `as_long` int(11) DEFAULT NULL,
  `as_long_min` int(11) DEFAULT NULL,
  `as_extreme` int(11) DEFAULT NULL,
  `as_extreme_min` int(11) DEFAULT NULL,
  `as_ov` int(11) DEFAULT NULL,
  `as_armor` int(11) DEFAULT NULL,
  `as_structure` int(11) DEFAULT NULL,
  `as_threshold` int(11) DEFAULT NULL,
  `as_specials` varchar(100) DEFAULT NULL,
  `mech_imageurl` varchar(50) DEFAULT NULL,
  `mech_status` varchar(50) DEFAULT 'fresh' COMMENT 'fresh, damaged, critical, crippled, destroyed',
  `mech_statusimageurl` varchar(50) DEFAULT 'images/DD_01.png',
  `active_bid` tinyint(1) NOT NULL DEFAULT 1,
  `playerid` int(11) DEFAULT NULL,
  `as_mvtype` varchar(10) DEFAULT NULL,
  `mounted_unitid` int(11) DEFAULT NULL,
  `mounted_on_unitid` int(11) DEFAULT NULL,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`mechid`),
  UNIQUE KEY `mechid` (`mechid`)
) ENGINE=InnoDB AUTO_INCREMENT=628 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_mechstatus`
--

DROP TABLE IF EXISTS `asc_mechstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_mechstatus` (
  `mechstatusid` int(11) NOT NULL AUTO_INCREMENT,
  `mechid` int(11) DEFAULT NULL,
  `heat` int(11) DEFAULT NULL,
  `armor` int(11) DEFAULT NULL,
  `structure` int(11) DEFAULT NULL,
  `crit_engine` int(11) DEFAULT NULL,
  `crit_fc` int(11) DEFAULT NULL,
  `crit_mp` int(11) DEFAULT NULL,
  `crit_weapons` int(11) DEFAULT NULL,
  `usedoverheat` int(11) NOT NULL DEFAULT 0,
  `currenttmm` int(11) DEFAULT NULL,
  `crit_engine_PREP` int(11) DEFAULT 0,
  `crit_fc_PREP` int(11) DEFAULT 0,
  `crit_mp_PREP` int(11) DEFAULT 0,
  `crit_weapons_PREP` int(11) DEFAULT 0,
  `heat_PREP` int(11) DEFAULT 0,
  `crit_CV_engine` int(11) DEFAULT NULL,
  `crit_CV_firecontrol` int(11) DEFAULT NULL,
  `crit_CV_weapons` int(11) DEFAULT NULL,
  `crit_CV_motiveA` int(11) DEFAULT NULL,
  `crit_CV_motiveB` int(11) DEFAULT NULL,
  `crit_CV_motiveC` int(11) DEFAULT NULL,
  `crit_CV_engine_PREP` int(11) DEFAULT 0,
  `crit_CV_firecontrol_PREP` int(11) DEFAULT 0,
  `crit_CV_weapons_PREP` int(11) DEFAULT 0,
  `crit_CV_motiveA_PREP` int(11) DEFAULT 0,
  `crit_CV_motiveB_PREP` int(11) DEFAULT 0,
  `crit_CV_motiveC_PREP` int(11) DEFAULT 0,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`mechstatusid`),
  UNIQUE KEY `mechstatusid` (`mechstatusid`)
) ENGINE=InnoDB AUTO_INCREMENT=628 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_game`
--

DROP TABLE IF EXISTS `asc_game`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_game` (
  `gameid` int(11) NOT NULL AUTO_INCREMENT,
  `ownerPlayerId` int(11) NOT NULL,
  `accessCode` varchar(10) NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`gameid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_pilot`
--

DROP TABLE IF EXISTS `asc_pilot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_pilot` (
  `pilotid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `rank` varchar(20) NOT NULL DEFAULT 'MW',
  `pilot_imageurl` varchar(100) DEFAULT NULL,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`pilotid`),
  UNIQUE KEY `pilotid` (`pilotid`)
) ENGINE=InnoDB AUTO_INCREMENT=629 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_assign`
--

DROP TABLE IF EXISTS `asc_assign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_assign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitid` int(11) DEFAULT NULL,
  `mechid` int(11) DEFAULT NULL,
  `pilotid` int(11) DEFAULT NULL,
  `round_moved` int(11) DEFAULT 0,
  `round_fired` int(11) DEFAULT 0,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=628 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_options`
--

DROP TABLE IF EXISTS `asc_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_options` (
  `optionid` int(11) NOT NULL AUTO_INCREMENT,
  `playerid` int(11) NOT NULL,
  `option1` tinyint(1) NOT NULL DEFAULT 1,
  `option2` tinyint(1) NOT NULL DEFAULT 0,
  `option3` tinyint(1) NOT NULL DEFAULT 1,
  `option4` tinyint(1) NOT NULL DEFAULT 0,
  `UseMULImages` tinyint(1) DEFAULT 0,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`optionid`),
  UNIQUE KEY `optionid` (`optionid`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_unit`
--

DROP TABLE IF EXISTS `asc_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_unit` (
  `unitid` int(11) NOT NULL AUTO_INCREMENT,
  `factionid` int(11) DEFAULT NULL,
  `forcename` varchar(50) DEFAULT NULL,
  `playerid` int(11) DEFAULT NULL,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`unitid`),
  UNIQUE KEY `unitid` (`unitid`)
) ENGINE=InnoDB AUTO_INCREMENT=260 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_faction`
--

DROP TABLE IF EXISTS `asc_faction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_faction` (
  `factionid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `faction_imageurl` varchar(11) DEFAULT NULL,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`factionid`),
  UNIQUE KEY `factionid` (`factionid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_player`
--

DROP TABLE IF EXISTS `asc_player`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_player` (
  `playerid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `password` char(60) NOT NULL,
  `image` varchar(100) NOT NULL,
  `bid_pv` int(11) DEFAULT -1,
  `bid_tonnage` int(11) DEFAULT -1,
  `bid_winner` tinyint(1) NOT NULL DEFAULT 0,
  `opfor` tinyint(1) NOT NULL DEFAULT 0,
  `gameid` int(11) DEFAULT 1,
  `round` int(11) DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`playerid`),
  UNIQUE KEY `playerid` (`playerid`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-18 18:02:41
