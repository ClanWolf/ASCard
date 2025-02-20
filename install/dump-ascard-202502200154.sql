-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ascard
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
-- Table structure for table `asc_assign`
--

DROP TABLE IF EXISTS `asc_assign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_assign` (
  `assignid` int(11) NOT NULL AUTO_INCREMENT,
  `playerid` int(11) DEFAULT NULL,
  `commandid` int(11) DEFAULT NULL,
  `formationid` int(11) DEFAULT NULL,
  `unitid` int(11) DEFAULT NULL,
  `pilotid` int(11) DEFAULT NULL,
  `round_moved` int(11) DEFAULT 0,
  `round_fired` int(11) DEFAULT 0,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`assignid`),
  UNIQUE KEY `id` (`assignid`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_command`
--

DROP TABLE IF EXISTS `asc_command`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_command` (
  `commandid` int(11) NOT NULL AUTO_INCREMENT,
  `playerid` int(11) DEFAULT NULL,
  `factionid` int(11) DEFAULT NULL,
  `type` enum('official','custom') DEFAULT 'custom',
  `commandname` varchar(300) DEFAULT NULL,
  `commandbackground` varchar(500) DEFAULT NULL,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`commandid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_faction`
--

DROP TABLE IF EXISTS `asc_faction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_faction` (
  `factionid` int(11) NOT NULL AUTO_INCREMENT,
  `factionname` varchar(50) DEFAULT NULL,
  `factiontype` enum('IS','CLAN','COMSTAR') DEFAULT 'IS',
  `factionimage` varchar(11) DEFAULT NULL,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`factionid`),
  UNIQUE KEY `factionid` (`factionid`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_formation`
--

DROP TABLE IF EXISTS `asc_formation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_formation` (
  `formationid` int(11) NOT NULL AUTO_INCREMENT,
  `factionid` int(11) DEFAULT NULL,
  `commandid` int(11) DEFAULT NULL,
  `formationname` varchar(50) DEFAULT NULL,
  `playerid` int(11) DEFAULT NULL,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`formationid`),
  UNIQUE KEY `unitid` (`formationid`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
  `title` varchar(300) DEFAULT NULL,
  `background` varchar(255) DEFAULT NULL,
  `era` enum('STAR LEAGUE','SUCCESSION WARS','CLAN INVASION','CIVIL WAR','JIHAD','DARK AGE','ILCLAN') DEFAULT NULL,
  `yearInGame` varchar(4) DEFAULT NULL,
  `accessCode` varchar(10) NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `scheduled` timestamp NULL DEFAULT NULL,
  `started` timestamp NULL DEFAULT NULL,
  `finished` timestamp NULL DEFAULT NULL,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`gameid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_game_archiv`
--

DROP TABLE IF EXISTS `asc_game_archiv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_game_archiv` (
  `gameid` int(11) NOT NULL,
  `ownerPlayerId` int(11) NOT NULL,
  `title` varchar(300) DEFAULT NULL,
  `background` varchar(255) DEFAULT NULL,
  `era` enum('STAR LEAGUE','SUCCESSION WARS','CLAN INVASION','CIVIL WAR','JIHAD','DARK AGE','ILCLAN') DEFAULT NULL,
  `yearInGame` varchar(4) DEFAULT NULL,
  `accessCode` varchar(10) NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `scheduled` timestamp NULL DEFAULT NULL,
  `started` timestamp NULL DEFAULT NULL,
  `finished` timestamp NULL DEFAULT NULL,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_pilot`
--

DROP TABLE IF EXISTS `asc_pilot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_pilot` (
  `pilotid` int(11) NOT NULL AUTO_INCREMENT,
  `playerid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `rank` varchar(20) NOT NULL DEFAULT 'MW',
  `pilot_imageurl` varchar(100) DEFAULT NULL,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`pilotid`),
  UNIQUE KEY `pilotid` (`pilotid`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
  `admin` tinyint(4) DEFAULT NULL,
  `image` varchar(100) NOT NULL,
  `factionid` int(11) DEFAULT NULL,
  `hostedgameid` int(11) NOT NULL DEFAULT 0,
  `gameid` int(11) NOT NULL DEFAULT 0,
  `teamid` int(11) NOT NULL DEFAULT 1 COMMENT 'Replace the OpFor mechanic',
  `commandid` int(11) DEFAULT NULL,
  `opfor` tinyint(1) NOT NULL DEFAULT 0,
  `bid_pv` int(11) DEFAULT -1,
  `bid_winner` tinyint(1) NOT NULL DEFAULT 0,
  `bid_tonnage` int(11) DEFAULT -1,
  `round` int(11) DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`playerid`),
  UNIQUE KEY `playerid` (`playerid`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_unit`
--

DROP TABLE IF EXISTS `asc_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_unit` (
  `unitid` int(11) NOT NULL AUTO_INCREMENT,
  `playerid` int(11) DEFAULT NULL,
  `mulid` int(11) DEFAULT NULL,
  `tech` int(5) DEFAULT NULL,
  `unit_number` varchar(50) NOT NULL DEFAULT '--',
  `unit_name` varchar(25) DEFAULT '"-"',
  `unit_tonnage` int(11) DEFAULT NULL,
  `unit_imageurl` varchar(50) DEFAULT NULL,
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
  `as_mvtype` varchar(10) DEFAULT NULL,
  `commander` tinyint(4) DEFAULT 0,
  `subcommander` tinyint(4) DEFAULT 0,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`unitid`),
  UNIQUE KEY `mechid` (`unitid`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_unitstatus`
--

DROP TABLE IF EXISTS `asc_unitstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_unitstatus` (
  `mechstatusid` int(11) NOT NULL AUTO_INCREMENT,
  `initial_status` tinyint(1) DEFAULT 0,
  `unitid` int(11) DEFAULT NULL,
  `playerid` int(11) DEFAULT NULL,
  `gameid` int(11) DEFAULT NULL,
  `teamid` int(11) NOT NULL DEFAULT 1,
  `round` int(11) DEFAULT 1,
  `heat` int(11) DEFAULT NULL,
  `armor` int(11) DEFAULT NULL,
  `structure` int(11) DEFAULT NULL,
  `crit_engine` int(11) DEFAULT NULL,
  `crit_fc` int(11) DEFAULT NULL,
  `crit_mp` int(11) DEFAULT NULL,
  `crit_weapons` int(11) DEFAULT NULL,
  `usedoverheat` int(11) NOT NULL DEFAULT 0,
  `heat_PREP` int(11) DEFAULT 0,
  `current_tmm` int(11) DEFAULT NULL,
  `current_movement` int(11) DEFAULT NULL,
  `current_damage_SHORT` int(11) DEFAULT NULL,
  `current_damage_MEDIUM` int(11) DEFAULT NULL,
  `current_damage_LONG` int(11) DEFAULT NULL,
  `current_damage_EXTREME` int(11) DEFAULT NULL,
  `crit_engine_PREP` int(11) DEFAULT 0,
  `crit_fc_PREP` int(11) DEFAULT 0,
  `crit_mp_PREP` int(11) DEFAULT 0,
  `crit_weapons_PREP` int(11) DEFAULT 0,
  `crit_CV_engine` int(11) DEFAULT 0,
  `crit_CV_firecontrol` int(11) DEFAULT 0,
  `crit_CV_weapons` int(11) DEFAULT 0,
  `crit_CV_motiveA` int(11) DEFAULT 0,
  `crit_CV_motiveB` int(11) DEFAULT 0,
  `crit_CV_motiveC` int(11) DEFAULT 0,
  `crit_CV_engine_PREP` int(11) DEFAULT 0,
  `crit_CV_firecontrol_PREP` int(11) DEFAULT 0,
  `crit_CV_weapons_PREP` int(11) DEFAULT 0,
  `crit_CV_motiveA_PREP` int(11) DEFAULT 0,
  `crit_CV_motiveB_PREP` int(11) DEFAULT 0,
  `crit_CV_motiveC_PREP` int(11) DEFAULT 0,
  `narc_desc` varchar(100) DEFAULT 'NARC',
  `active_bid` tinyint(1) NOT NULL DEFAULT 1,
  `active_narc` tinyint(1) DEFAULT 0,
  `active_tag` tinyint(1) DEFAULT 0,
  `active_water` tinyint(1) DEFAULT 0,
  `active_routed` tinyint(1) DEFAULT 0,
  `unit_status` varchar(100) DEFAULT 'fresh',
  `unit_statusimageurl` varchar(100) DEFAULT 'images/DD_BM_01.png',
  `mounted_unitid` int(11) DEFAULT 0,
  `mounted_on_unitid` int(11) DEFAULT 0,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`mechstatusid`),
  UNIQUE KEY `mechstatusid` (`mechstatusid`)
) ENGINE=InnoDB AUTO_INCREMENT=624 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asc_unitstatus_archive`
--

DROP TABLE IF EXISTS `asc_unitstatus_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_unitstatus_archive` (
  `mechstatusarchiveid` int(11) NOT NULL AUTO_INCREMENT,
  `initial_status` tinyint(1) DEFAULT 0,
  `unitid` int(11) DEFAULT NULL,
  `playerid` int(11) DEFAULT NULL,
  `gameid` int(11) DEFAULT NULL,
  `teamid` int(11) NOT NULL DEFAULT 1,
  `round` int(11) DEFAULT 1,
  `heat` int(11) DEFAULT NULL,
  `armor` int(11) DEFAULT NULL,
  `structure` int(11) DEFAULT NULL,
  `crit_engine` int(11) DEFAULT NULL,
  `crit_fc` int(11) DEFAULT NULL,
  `crit_mp` int(11) DEFAULT NULL,
  `crit_weapons` int(11) DEFAULT NULL,
  `usedoverheat` int(11) NOT NULL DEFAULT 0,
  `heat_PREP` int(11) DEFAULT 0,
  `current_tmm` int(11) DEFAULT NULL,
  `current_movement` int(11) DEFAULT NULL,
  `current_damage_SHORT` int(11) DEFAULT NULL,
  `current_damage_MEDIUM` int(11) DEFAULT NULL,
  `current_damage_LONG` int(11) DEFAULT NULL,
  `current_damage_EXTREME` int(11) DEFAULT NULL,
  `crit_engine_PREP` int(11) DEFAULT 0,
  `crit_fc_PREP` int(11) DEFAULT 0,
  `crit_mp_PREP` int(11) DEFAULT 0,
  `crit_weapons_PREP` int(11) DEFAULT 0,
  `crit_CV_engine` int(11) DEFAULT 0,
  `crit_CV_firecontrol` int(11) DEFAULT 0,
  `crit_CV_weapons` int(11) DEFAULT 0,
  `crit_CV_motiveA` int(11) DEFAULT 0,
  `crit_CV_motiveB` int(11) DEFAULT 0,
  `crit_CV_motiveC` int(11) DEFAULT 0,
  `crit_CV_engine_PREP` int(11) DEFAULT 0,
  `crit_CV_firecontrol_PREP` int(11) DEFAULT 0,
  `crit_CV_weapons_PREP` int(11) DEFAULT 0,
  `crit_CV_motiveA_PREP` int(11) DEFAULT 0,
  `crit_CV_motiveB_PREP` int(11) DEFAULT 0,
  `crit_CV_motiveC_PREP` int(11) DEFAULT 0,
  `narc_desc` varchar(100) DEFAULT 'NARC',
  `active_bid` tinyint(1) NOT NULL DEFAULT 1,
  `active_narc` tinyint(1) DEFAULT 0,
  `active_tag` tinyint(1) DEFAULT 0,
  `active_water` tinyint(1) DEFAULT 0,
  `active_routed` tinyint(1) DEFAULT 0,
  `unit_status` varchar(100) DEFAULT 'fresh',
  `unit_statusimageurl` varchar(100) DEFAULT 'images/DD_BM_01.png',
  `mounted_unitid` int(11) DEFAULT 0,
  `mounted_on_unitid` int(11) DEFAULT 0,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`mechstatusarchiveid`),
  UNIQUE KEY `asc_unitstatus_archive_unique` (`mechstatusarchiveid`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'ascard'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-20  1:54:26
