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
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asc_assign`
--

LOCK TABLES `asc_assign` WRITE;
/*!40000 ALTER TABLE `asc_assign` DISABLE KEYS */;
INSERT INTO `asc_assign` VALUES (7,4,NULL,NULL,7,7,0,0,'2024-12-09 16:05:02'),(26,9,NULL,25,27,27,0,0,'2024-12-12 12:04:35'),(27,9,NULL,25,28,28,0,0,'2024-12-09 12:06:09'),(28,9,NULL,25,29,29,0,0,'2024-12-09 12:06:32'),(29,9,NULL,25,30,30,0,0,'2024-12-09 12:08:26'),(30,9,NULL,25,31,31,0,0,'2024-12-09 12:09:07'),(31,9,NULL,26,32,32,0,0,'2024-12-13 06:51:21'),(32,9,NULL,26,33,33,0,0,'2024-12-09 12:11:57'),(33,9,NULL,26,34,34,0,0,'2024-12-09 12:11:46'),(35,9,NULL,26,36,36,0,0,'2024-12-09 12:18:15'),(36,9,NULL,26,37,37,0,0,'2024-12-09 12:18:46'),(37,9,NULL,27,38,38,0,0,'2024-12-09 12:57:16'),(38,9,NULL,27,39,39,0,0,'2024-12-09 12:57:42'),(39,9,NULL,27,40,40,0,0,'2024-12-09 12:58:04'),(41,9,NULL,27,42,42,0,0,'2024-12-09 12:59:06'),(42,9,NULL,27,43,43,0,0,'2024-12-09 12:59:34'),(48,12,NULL,NULL,49,49,10,0,'2024-12-09 15:32:49'),(49,12,NULL,34,50,50,4,0,'2024-12-11 17:06:33'),(50,11,NULL,NULL,51,51,3,0,'2025-01-12 09:10:48'),(51,11,NULL,NULL,52,52,3,0,'2025-01-12 09:10:49'),(52,11,NULL,NULL,53,53,0,0,'2025-01-04 19:14:20'),(53,4,NULL,10,54,54,3,0,'2024-12-11 11:00:39'),(54,11,NULL,NULL,55,55,0,0,'2025-01-12 09:10:49'),(55,11,NULL,NULL,56,56,3,0,'2025-01-12 09:10:50'),(56,11,NULL,NULL,57,57,3,0,'2025-01-12 09:10:51'),(58,2,NULL,NULL,59,59,0,0,'2024-12-22 12:45:58'),(60,9,NULL,NULL,61,61,0,0,'2024-12-12 14:18:06'),(61,11,NULL,NULL,62,62,0,0,'2025-01-04 19:14:21'),(62,9,NULL,NULL,63,63,0,0,'2024-12-12 14:18:04'),(63,10,NULL,29,64,64,0,0,'2024-12-12 14:36:31'),(64,10,NULL,29,65,65,0,0,'2024-12-12 14:35:32'),(65,10,NULL,29,66,66,0,0,'2024-12-12 14:39:21'),(66,10,NULL,29,67,67,0,0,'2024-12-12 14:41:46'),(67,11,NULL,NULL,68,68,0,0,'2025-01-04 19:14:22'),(68,11,NULL,NULL,69,69,3,2,'2025-01-04 19:14:30'),(69,11,NULL,NULL,70,70,3,2,'2025-01-04 19:14:31'),(71,11,NULL,NULL,72,72,3,2,'2025-01-04 19:14:33'),(72,11,NULL,NULL,73,73,3,2,'2025-01-04 19:14:34'),(73,11,NULL,NULL,74,74,3,2,'2025-01-04 19:14:36'),(74,11,NULL,NULL,75,75,0,0,'2025-01-04 19:14:23'),(75,2,NULL,NULL,76,76,0,0,'2024-12-22 12:45:57'),(76,11,NULL,NULL,77,77,0,0,'2025-01-04 19:14:24'),(78,2,NULL,NULL,79,79,0,0,'2024-12-30 19:01:46'),(79,2,NULL,NULL,80,80,0,0,'2024-12-30 19:01:48'),(80,2,NULL,NULL,81,81,3,0,'2024-12-31 10:47:34'),(82,18,NULL,49,83,83,0,0,'2024-12-30 19:43:39'),(84,2,NULL,NULL,85,85,0,0,'2024-12-31 10:47:36'),(85,18,NULL,49,86,86,0,0,'2024-12-30 19:51:43'),(86,2,NULL,NULL,87,87,0,0,'2024-12-31 10:47:33'),(88,2,NULL,4,89,89,0,0,'2024-12-31 10:50:26'),(89,2,NULL,4,90,90,0,0,'2024-12-31 10:51:59'),(90,2,NULL,4,91,91,3,1,'2025-01-28 18:32:34'),(91,2,NULL,4,92,92,0,0,'2024-12-31 10:56:41'),(92,2,NULL,4,93,93,0,0,'2024-12-31 10:58:13'),(93,2,NULL,4,94,94,0,0,'2024-12-31 11:01:18'),(101,1,NULL,1,102,102,0,0,'2025-02-08 13:36:35'),(102,11,NULL,NULL,103,103,0,0,'2025-01-04 20:34:49'),(103,11,NULL,NULL,104,104,2,1,'2025-01-12 09:10:43'),(104,11,NULL,NULL,105,105,3,0,'2025-01-12 09:10:44'),(105,11,NULL,NULL,106,106,3,2,'2025-01-12 09:10:45'),(106,11,NULL,NULL,107,107,0,0,'2025-01-12 09:10:46'),(107,11,NULL,NULL,108,108,4,0,'2025-01-12 09:10:47'),(108,1,NULL,1,109,109,0,0,'2025-01-22 21:49:30'),(109,1,NULL,1,110,110,0,0,'2025-01-22 21:49:30'),(110,1,NULL,1,111,111,0,0,'2025-01-22 21:49:30'),(111,1,NULL,1,112,112,0,0,'2025-01-22 21:49:30'),(112,19,NULL,NULL,113,113,0,0,'2025-01-10 22:48:52'),(115,19,NULL,NULL,116,116,0,0,'2025-01-10 22:48:54'),(121,20,NULL,55,122,122,0,0,'2025-01-11 10:44:24'),(122,20,NULL,55,123,123,0,0,'2025-01-11 10:45:48'),(123,20,NULL,55,124,124,0,0,'2025-01-11 10:46:29'),(125,20,NULL,55,126,126,0,0,'2025-01-11 10:48:50'),(126,20,NULL,57,127,127,0,0,'2025-01-11 10:51:07'),(127,20,NULL,57,128,128,0,0,'2025-01-11 10:52:19'),(128,20,NULL,57,129,129,0,0,'2025-01-11 10:53:10'),(129,20,NULL,57,130,130,0,0,'2025-01-11 13:03:59'),(130,20,NULL,56,131,131,0,0,'2025-01-11 10:55:47'),(131,20,NULL,56,132,132,0,0,'2025-01-11 10:57:24'),(132,20,NULL,56,133,133,0,0,'2025-01-11 10:59:07'),(133,20,NULL,56,134,134,0,0,'2025-01-11 11:00:44'),(134,20,NULL,56,135,135,0,0,'2025-02-11 13:46:32'),(135,19,NULL,52,136,136,0,0,'2025-01-11 12:00:02'),(136,19,NULL,52,137,137,0,0,'2025-01-11 12:03:54'),(137,20,NULL,56,138,138,0,0,'2025-02-11 13:46:47'),(138,20,NULL,56,139,139,0,0,'2025-02-11 13:46:53'),(139,20,NULL,56,140,140,0,0,'2025-02-11 13:47:01'),(140,2,NULL,6,141,141,0,0,'2025-01-11 18:19:04'),(141,11,NULL,31,142,142,0,0,'2025-01-12 12:02:04'),(142,11,NULL,31,143,143,3,0,'2025-01-12 12:19:59'),(143,11,NULL,31,144,144,0,0,'2025-01-12 12:02:04'),(144,11,NULL,31,145,145,0,0,'2025-01-12 12:02:04'),(145,11,NULL,32,146,146,0,0,'2025-01-12 12:02:04'),(146,11,NULL,NULL,147,147,0,0,'2025-01-12 09:16:16'),(147,11,NULL,32,148,148,0,0,'2025-01-12 12:02:04'),(148,11,NULL,32,149,149,0,0,'2025-01-12 12:02:04'),(149,11,NULL,31,150,150,0,0,'2025-01-12 12:02:04'),(150,21,NULL,58,151,151,0,0,'2025-02-11 21:01:38'),(151,21,NULL,58,152,152,0,0,'2025-02-11 21:01:38'),(153,21,NULL,59,154,154,0,0,'2025-02-11 20:40:41'),(154,21,NULL,58,155,155,0,0,'2025-02-11 21:01:38'),(156,21,NULL,58,157,157,0,0,'2025-02-11 20:40:41'),(159,21,NULL,59,160,160,0,0,'2025-02-11 21:01:38'),(160,20,NULL,55,161,161,3,2,'2025-02-11 21:00:53'),(161,20,NULL,55,162,162,3,2,'2025-02-11 21:00:51'),(162,20,NULL,55,163,163,3,2,'2025-02-11 21:00:45'),(163,20,NULL,55,164,164,3,2,'2025-02-11 21:01:05'),(164,20,NULL,55,165,165,3,2,'2025-02-11 20:54:05'),(165,20,NULL,55,166,166,3,2,'2025-02-11 20:54:01');
/*!40000 ALTER TABLE `asc_assign` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asc_command`
--

LOCK TABLES `asc_command` WRITE;
/*!40000 ALTER TABLE `asc_command` DISABLE KEYS */;
INSERT INTO `asc_command` VALUES (2,15,1,'custom','Commandname','Commandbackground','2024-12-12 23:40:13'),(3,16,1,'custom','Commandname','Commandbackground','2024-12-17 14:58:26'),(4,17,3,'custom','Commandname','Commandbackground','2024-12-17 15:09:28'),(5,18,1,'custom','Commandname','Commandbackground','2024-12-30 19:06:30'),(6,19,13,'custom','Commandname','Commandbackground','2025-01-10 22:14:11'),(7,20,3,'custom','Commandname','Commandbackground','2025-01-10 22:15:42'),(8,21,8,'custom','Commandname','Commandbackground','2025-01-10 22:18:35'),(9,22,3,'custom','Commandname','Commandbackground','2025-01-12 01:36:59'),(10,23,12,'custom','Commandname','Commandbackground','2025-01-22 20:56:43');
/*!40000 ALTER TABLE `asc_command` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `asc_faction`
--

LOCK TABLES `asc_faction` WRITE;
/*!40000 ALTER TABLE `asc_faction` DISABLE KEYS */;
INSERT INTO `asc_faction` VALUES (1,'Clan Wolf','CLAN','CW.png','2024-11-29 07:49:35'),(2,'Lyran Alliance','IS','LA.png','2024-11-29 07:49:35'),(3,'ComStar','COMSTAR','CS.png','2024-11-29 07:49:35'),(4,'Draconis Combine','IS','DC.png','2024-11-29 07:49:35'),(5,'Clan Ghostbear','CLAN','CGB.png','2024-11-29 07:49:35'),(6,'Wolf\'s Dragoons','IS','WD.png','2024-11-29 07:49:35'),(7,'Lyran Commonwealth','IS','LC.png','2024-11-29 07:49:35'),(8,'Federated Suns','IS','FS.png','2024-11-29 07:49:35'),(9,'Clan Jade Falcon','CLAN','CJF.png','2024-11-29 07:49:35'),(10,'Free Worlds League','IS','FWL.png','2024-11-29 07:49:35'),(11,'Capellan Confederation','IS','CC.png','2024-11-29 07:49:35'),(12,'Clan Smoke Jaguar','CLAN','CSJ.png','2024-11-29 07:49:35'),(13,'Clan Wolf in Exile','CLAN','CWiE.png','2025-01-11 19:03:18'),(14,'Clan Snow Raven','CLAN','CSR.png','2024-11-29 07:49:35'),(15,'Clan Nova Cat','CLAN','CNC.png','2024-12-13 07:55:35');
/*!40000 ALTER TABLE `asc_faction` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asc_formation`
--

LOCK TABLES `asc_formation` WRITE;
/*!40000 ALTER TABLE `asc_formation` DISABLE KEYS */;
INSERT INTO `asc_formation` VALUES (1,1,NULL,'Command',1,'2024-11-30 21:31:55'),(2,1,NULL,'Striker',1,'2024-11-30 21:31:55'),(3,1,NULL,'Hunter',1,'2024-11-30 21:31:55'),(4,1,NULL,'Command',2,'2024-11-30 21:31:55'),(5,1,NULL,'Battle',2,'2024-11-30 21:31:55'),(6,1,NULL,'Striker',2,'2024-11-30 21:31:55'),(7,1,NULL,'Command',3,'2024-11-30 21:31:55'),(8,1,NULL,'Battle',3,'2024-11-30 21:31:55'),(9,1,NULL,'Striker',3,'2024-11-30 21:31:55'),(10,1,NULL,'Command',4,'2024-11-30 21:31:55'),(11,1,NULL,'Battle',4,'2024-11-30 21:31:55'),(12,1,NULL,'Striker',4,'2024-11-30 21:31:55'),(25,15,NULL,'Command',9,'2024-12-13 07:56:55'),(26,15,NULL,'Battle',9,'2024-12-13 07:56:55'),(27,15,NULL,'Striker',9,'2024-12-13 07:56:55'),(28,1,NULL,'Command',10,'2024-12-09 10:52:18'),(29,1,NULL,'Battle',10,'2024-12-09 10:52:18'),(30,1,NULL,'Striker',10,'2024-12-09 10:52:18'),(31,1,NULL,'Command',11,'2024-12-09 14:30:18'),(32,1,NULL,'Battle',11,'2024-12-09 14:30:18'),(33,1,NULL,'Striker',11,'2024-12-09 14:30:18'),(34,1,NULL,'Command',12,'2024-12-09 15:17:42'),(35,1,NULL,'Battle',12,'2024-12-09 15:17:42'),(36,1,NULL,'Striker',12,'2024-12-09 15:17:42'),(49,1,5,'Command',18,'2024-12-30 19:06:30'),(50,1,5,'Battle',18,'2024-12-30 19:06:30'),(51,1,5,'Striker',18,'2024-12-30 19:06:30'),(52,13,6,'Command',19,'2025-01-10 22:14:11'),(53,13,6,'Battle',19,'2025-01-10 22:14:11'),(54,13,6,'Striker',19,'2025-01-10 22:14:11'),(55,3,7,'Command',20,'2025-01-10 22:15:42'),(56,3,7,'Battle',20,'2025-01-10 22:15:42'),(57,3,7,'Striker',20,'2025-01-10 22:15:42'),(58,8,8,'Command',21,'2025-01-10 22:18:35'),(59,8,8,'Battle',21,'2025-01-10 22:18:35'),(60,8,8,'Striker',21,'2025-01-10 22:18:35'),(61,3,9,'Command',22,'2025-01-12 01:36:59'),(62,3,9,'Battle',22,'2025-01-12 01:36:59'),(63,3,9,'Striker',22,'2025-01-12 01:36:59');
/*!40000 ALTER TABLE `asc_formation` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `asc_game`
--

LOCK TABLES `asc_game` WRITE;
/*!40000 ALTER TABLE `asc_game` DISABLE KEYS */;
INSERT INTO `asc_game` VALUES (1,1,'Tallassias game','Tallassias game','SUCCESSION WARS','3030','4844',0,NULL,NULL,NULL,'2025-02-11 18:13:14'),(2,2,'Nimrods game','This planet will be mine','CLAN INVASION','3052','6529',0,NULL,NULL,NULL,'2025-01-22 22:41:43'),(3,4,'Eriks game','Fire and fury','CLAN INVASION','3052','0396',0,NULL,NULL,NULL,'2025-01-22 22:41:43'),(5,9,'Kharns game','Kharns game','CLAN INVASION','3052','6170',0,NULL,NULL,NULL,'2025-02-06 16:26:09'),(6,11,'NeoJyhads game','NeoJyhads game','CLAN INVASION','3052','0435',0,NULL,NULL,NULL,'2025-02-06 16:26:09'),(7,12,'Bobs game','Bobs game','CLAN INVASION','3052','5102',0,NULL,NULL,NULL,'2025-02-06 16:26:09'),(8,10,'Terrorbärs game','Terrorbärs game','CLAN INVASION','3052','0597',0,NULL,NULL,NULL,'2025-02-06 16:26:09'),(9,18,'Strongwinds game','Strongwinds game','CLAN INVASION','3052','0674',0,NULL,NULL,NULL,'2025-02-06 16:26:09'),(10,19,'Milambars game','Milambars game','CLAN INVASION','3052','6812',0,NULL,NULL,NULL,'2025-02-06 16:26:09'),(11,21,'Hangtimes game','Hangtimes game','CLAN INVASION','3052','0758',0,NULL,NULL,NULL,'2025-02-06 16:26:09'),(12,20,'Tallassias game','Tallassias game','CLAN INVASION','3052','8260',0,NULL,NULL,NULL,'2025-02-06 16:26:09'),(13,21,'Hangtimes game','Hangtimes game','CLAN INVASION','3052','1372',0,NULL,NULL,NULL,'2025-02-06 16:26:09');
/*!40000 ALTER TABLE `asc_game` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `asc_game_archiv`
--

LOCK TABLES `asc_game_archiv` WRITE;
/*!40000 ALTER TABLE `asc_game_archiv` DISABLE KEYS */;
/*!40000 ALTER TABLE `asc_game_archiv` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asc_options`
--

LOCK TABLES `asc_options` WRITE;
/*!40000 ALTER TABLE `asc_options` DISABLE KEYS */;
INSERT INTO `asc_options` VALUES (1,1,1,0,0,0,0,'2025-02-06 18:05:30'),(2,2,1,1,0,0,0,'2025-02-07 11:20:32'),(3,3,1,0,0,0,0,'2024-11-30 21:30:01'),(4,4,1,1,1,0,0,'2024-12-12 21:53:56'),(9,9,1,1,0,0,0,'2024-12-13 09:48:58'),(10,10,1,1,0,0,0,'2024-12-12 14:32:34'),(11,11,1,1,0,0,1,'2025-01-13 12:02:16'),(12,12,1,1,0,0,0,'2025-01-10 20:33:54'),(13,14,1,1,1,0,0,'2024-12-12 23:35:56'),(17,18,1,1,0,0,0,'2024-12-30 19:49:50'),(18,19,1,1,1,0,0,'2025-01-11 11:59:10'),(19,20,1,0,1,0,1,'2025-02-11 18:40:13'),(20,21,1,0,1,0,1,'2025-02-11 18:39:59'),(21,22,1,1,1,0,0,'2025-01-12 01:36:59');
/*!40000 ALTER TABLE `asc_options` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=167 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asc_pilot`
--

LOCK TABLES `asc_pilot` WRITE;
/*!40000 ALTER TABLE `asc_pilot` DISABLE KEYS */;
INSERT INTO `asc_pilot` VALUES (7,4,'Samara','MW','images/pilots/f_051.png','2024-12-03 00:57:38'),(27,9,'Drummond','SCol','images/pilots/m_131.png','2024-12-13 09:03:49'),(28,9,'Brian','MW','images/pilots/m_076.png','2024-12-09 12:06:09'),(29,9,'Justice','MW','images/pilots/m_083.png','2024-12-09 12:06:32'),(30,9,'Cash','MW','images/pilots/m_103.png','2024-12-09 12:08:26'),(31,9,'Nash','MW','images/pilots/m_010.png','2024-12-09 12:09:07'),(32,9,'Adelaide','SCom','images/pilots/f_048.png','2024-12-13 08:21:17'),(33,9,'Jalen','MW','images/pilots/m_109.png','2024-12-09 12:11:25'),(34,9,'Kingston','MW','images/pilots/m_002.png','2024-12-09 12:11:46'),(36,9,'Jayce','MW','images/pilots/m_156.png','2024-12-09 12:18:06'),(37,9,'Gianna','MW','images/pilots/f_014.png','2024-12-09 12:18:37'),(38,9,'Aidan','SCom','images/pilots/m_035.png','2024-12-13 08:20:39'),(39,9,'Jaxen','MW','images/pilots/m_075.png','2024-12-09 12:57:42'),(40,9,'Mack','MW','images/pilots/m_012.png','2024-12-09 12:58:04'),(42,9,'Oscar','MW','images/pilots/m_163.png','2024-12-09 12:59:06'),(43,9,'Arianna','MW','images/pilots/f_054.png','2024-12-09 12:59:34'),(49,12,'Shiloh','MW','images/pilots/f_056.png','2024-12-09 15:29:36'),(50,12,'Jasmine','MW','images/pilots/f_023.png','2024-12-09 15:33:24'),(51,11,'Adrian','MW','images/pilots/m_051.png','2024-12-09 15:59:27'),(52,11,'Kiara','MW','images/pilots/f_016.png','2024-12-09 16:00:49'),(53,11,'Reese','MW','images/pilots/f_007.png','2024-12-09 16:02:48'),(54,4,'Eden','MW','images/pilots/m_153.png','2024-12-09 16:05:12'),(55,11,'Juliet','MW','images/pilots/f_011.png','2024-12-09 16:05:27'),(56,11,'Maxwell','MW','images/pilots/m_125.png','2024-12-09 16:06:43'),(57,11,'Kamden','MW','images/pilots/m_141.png','2024-12-09 16:09:57'),(59,2,'Leandro','MW','images/pilots/m_161.png','2024-12-09 19:04:40'),(61,9,'Gracelynn','MW','images/pilots/f_042.png','2024-12-12 08:21:00'),(62,11,'Zayn','MW','images/pilots/m_084.png','2024-12-12 13:25:52'),(63,9,'Fletcher','MW','images/pilots/m_077.png','2024-12-12 14:17:34'),(64,10,'Garrett','MW','images/pilots/m_048.png','2024-12-12 14:34:42'),(65,10,'Finn','MW','images/pilots/m_083.png','2024-12-12 14:35:32'),(66,10,'Winter','MW','images/pilots/f_014.png','2024-12-12 14:39:21'),(67,10,'Cayden','MW','images/pilots/m_034.png','2024-12-12 14:41:46'),(68,11,'Azalea','MW','images/pilots/f_055.png','2024-12-13 11:37:36'),(69,11,'Lylah','MW','images/pilots/f_047.png','2024-12-13 11:38:04'),(70,11,'Gerardo','MW','images/pilots/m_011.png','2024-12-13 11:38:53'),(72,11,'Jagger','MW','images/pilots/m_054.png','2024-12-13 11:40:06'),(73,11,'Porter','MW','images/pilots/m_149.png','2024-12-13 11:40:28'),(74,11,'Raylan','MW','images/pilots/m_110.png','2024-12-13 11:42:00'),(75,11,'Kason','MW','images/pilots/m_133.png','2024-12-13 12:15:04'),(76,2,'Aaden','MW','images/pilots/m_086.png','2024-12-13 22:32:42'),(77,11,'Jairo','MW','images/pilots/m_054.png','2024-12-14 18:17:52'),(79,2,'Alaric Ward','MW','images/pilots/m_158.png','2024-12-22 12:48:14'),(80,2,'Ulises Raddick','MW','images/pilots/m_134.png','2024-12-22 15:26:01'),(81,2,'Steven','MW','images/pilots/m_132.png','2024-12-30 19:01:43'),(83,18,'Strongwind','MW','images/pilots/m_041.png','2024-12-30 19:11:19'),(85,2,'Jeffery','MW','images/pilots/m_094.png','2024-12-30 19:50:40'),(86,18,'Sascha','MW','images/pilots/m_057.png','2024-12-30 19:51:43'),(87,2,'Braylen','MW','images/pilots/m_062.png','2024-12-30 21:10:08'),(89,2,'Aniya Williamson','DemiPrecentor','images/pilots/f_058.png','2024-12-31 13:06:56'),(90,2,'Rocky Balboa','MW','images/pilots/m_138.png','2024-12-31 10:51:59'),(91,2,'Theo Weigl','MW','images/pilots/m_148.png','2024-12-31 10:55:12'),(92,2,'Troy Singer','MW','images/pilots/m_027.png','2024-12-31 10:56:41'),(93,2,'Sascha Bandit','MW','images/pilots/m_073.png','2024-12-31 12:45:39'),(94,2,'Micheal Noll','MW','images/pilots/m_018.png','2024-12-31 11:01:18'),(102,1,'Hayden','MW','images/pilots/m_041.png','2025-01-03 15:42:54'),(103,11,'Kenny','MW','images/pilots/m_047.png','2025-01-04 20:34:34'),(104,11,'Izaiah','MW','images/pilots/m_085.png','2025-01-04 20:39:22'),(105,11,'Finley','MW','images/pilots/m_086.png','2025-01-04 20:39:47'),(106,11,'Kyree','MW','images/pilots/m_164.png','2025-01-04 20:40:33'),(107,11,'Tristan','MW','images/pilots/m_161.png','2025-01-04 20:41:00'),(108,11,'Armando','MW','images/pilots/m_125.png','2025-01-04 20:41:49'),(109,1,'Dominique','MW','images/pilots/m_070.png','2025-01-10 20:01:49'),(110,1,'Kyler','MW','images/pilots/m_148.png','2025-01-10 20:10:09'),(111,1,'Amari','MW','images/pilots/f_062.png','2025-01-10 20:59:23'),(112,1,'Raina','MW','images/pilots/f_022.png','2025-01-10 21:07:06'),(113,19,'Aarav','MW','images/pilots/m_158.png','2025-01-10 22:31:00'),(116,19,'Adam','MW','images/pilots/m_115.png','2025-01-10 22:47:13'),(122,20,'Rayan','MW','images/pilots/m_017.png','2025-01-11 10:44:24'),(123,20,'Avalynn','MW','images/pilots/f_023.png','2025-01-11 10:45:48'),(124,20,'Paxton','MW','images/pilots/m_059.png','2025-01-11 10:46:29'),(126,20,'Martin','MW','images/pilots/m_029.png','2025-01-11 10:48:50'),(127,20,'Jasmine','MW','images/pilots/f_015.png','2025-01-11 10:51:07'),(128,20,'Nathan','MW','images/pilots/m_140.png','2025-01-11 10:52:19'),(129,20,'Zayn','MW','images/pilots/m_151.png','2025-01-11 10:53:10'),(130,20,'Atticus','MW','images/pilots/m_001.png','2025-01-11 10:54:34'),(131,20,'Lane','MW','images/pilots/m_175.png','2025-01-11 10:55:47'),(132,20,'London','MW','images/pilots/f_003.png','2025-01-11 10:57:24'),(133,20,'Asher','MW','images/pilots/m_154.png','2025-01-11 10:59:07'),(134,20,'Oliver','MW','images/pilots/m_104.png','2025-01-11 11:00:28'),(135,20,'Erica','MW','images/pilots/f_038.png','2025-01-11 11:02:52'),(136,19,'Zaylee','MW','images/pilots/f_007.png','2025-01-11 11:50:30'),(137,19,'Nevaeh','MW','images/pilots/f_004.png','2025-01-11 11:57:33'),(138,20,'Dimitri','MW','images/pilots/m_152.png','2025-01-11 16:20:39'),(139,20,'Markus','MW','images/pilots/m_024.png','2025-01-11 16:24:55'),(140,20,'Kimora','MW','images/pilots/f_067.png','2025-01-11 16:29:35'),(141,2,'Rocky','MW','images/pilots/m_162.png','2025-01-11 18:19:04'),(142,11,'Crosby','MW','images/pilots/m_082.png','2025-01-12 09:12:57'),(143,11,'Priscilla','MW','images/pilots/f_069.png','2025-01-12 09:13:35'),(144,11,'Brooks','MW','images/pilots/m_143.png','2025-01-12 09:14:04'),(145,11,'Patrick','MW','images/pilots/m_007.png','2025-01-12 09:14:30'),(146,11,'Kaeden','MW','images/pilots/m_072.png','2025-01-12 09:15:27'),(147,11,'Luca','MW','images/pilots/m_054.png','2025-01-12 09:16:10'),(148,11,'Reyansh','MW','images/pilots/m_168.png','2025-01-12 09:16:52'),(149,11,'Willow','MW','images/pilots/f_024.png','2025-01-12 09:18:00'),(150,11,'Moises','MW','images/pilots/m_015.png','2025-01-12 09:18:29'),(151,21,'Bryson','MW','images/pilots/m_054.png','2025-02-10 16:44:35'),(152,21,'Ari','MW','images/pilots/m_094.png','2025-02-10 16:45:29'),(154,21,'Raphael','MW','images/pilots/m_002.png','2025-02-10 16:46:57'),(155,21,'Coen','MW','images/pilots/m_155.png','2025-02-10 16:47:39'),(157,21,'Nickolas','MW','images/pilots/m_046.png','2025-02-10 16:48:44'),(160,21,'Pearl','MW','images/pilots/f_030.png','2025-02-10 16:52:02'),(161,20,'Chad','MW','images/pilots/m_175.png','2025-02-11 13:41:00'),(162,20,'Davian','MW','images/pilots/m_167.png','2025-02-11 13:41:31'),(163,20,'Joziah','MW','images/pilots/m_142.png','2025-02-11 13:42:38'),(164,20,'Iliana','MW','images/pilots/f_020.png','2025-02-11 13:43:56'),(165,20,'Alayah','MW','images/pilots/f_040.png','2025-02-11 13:44:28'),(166,20,'Camille','MW','images/pilots/f_036.png','2025-02-11 13:44:54');
/*!40000 ALTER TABLE `asc_pilot` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asc_player`
--

LOCK TABLES `asc_player` WRITE;
/*!40000 ALTER TABLE `asc_player` DISABLE KEYS */;
INSERT INTO `asc_player` VALUES (1,'Meldric','$2y$10$z3P1WITOeWVFPOunpYZ9p.s8IDC.43zrk2bgiCvPtvXVO0pkVuC9i',1,'Meldric.png',1,1,1,1,NULL,0,433,0,440,1,'2025-02-11 18:38:00','2025-02-11 18:38:00'),(2,'Nimrod','$2y$10$X/ZDKsJS3rnMJ7IGtiMOL.OVU.7Uvpv6z.bmnTMN9I3BL73SXXF66',0,'Nimrod.png',1,2,1,1,NULL,0,280,0,395,1,'2025-02-07 11:21:19','2025-02-07 11:21:19'),(3,'Liam','$2y$10$7pTyDkTBKu/I3R20Ixmt6.RjoAzGuwNUuJrAAaQi/qpdK6/S78l/2',0,'Liam.png',1,0,1,1,NULL,1,-1,0,-1,1,'2024-11-19 09:51:39','2025-02-06 12:17:19'),(4,'Erik','$2y$10$kPeqVdL2H4FuglwOWbfw1uU65jQeh0/Fyq66v/WImodiQQopVSo4m',0,'Erik.png',1,4,1,1,NULL,0,23,1,1,1,'2024-12-12 22:01:23','2025-02-11 18:14:08'),(9,'Kharn','$2y$10$VKPIHM9fPPDhrRih7cLVb.NiQo6dcGTOkicHDc8w3ZYwWokz6d8hy',0,'Kharn.png',15,5,1,1,NULL,0,774,0,825,1,'2024-12-13 09:53:50','2025-02-06 12:17:19'),(10,'Terrorbär','$2y$10$JCyUqhBESoCCq5rRbKZx9O21UB2.wuVUBiNYaRGjHpP26g8sU1laS',0,'Terrorbär.png',3,8,1,1,NULL,0,160,0,270,2,'2024-12-13 09:53:03','2025-02-06 12:17:19'),(11,'NeoJyhad','$2y$10$tcE9Et.kGOe4SF00ryw1cOiHV8rI5fCAWX6G6ovNAS4915dGpLWqm',0,'NeoJyhad.png',3,6,1,1,NULL,0,224,0,451,1,'2025-01-13 12:02:28','2025-02-06 12:17:19'),(12,'Bob','$2y$10$SWghyC/lBrcqoXdb2TkWtOBQjfwlpsfTFApMyBQl2wSpFGJ1HcUmS',0,'Bob.png',3,7,1,1,NULL,0,65,0,75,3,'2025-01-10 20:34:07','2025-02-06 12:17:19'),(18,'Strongwind','$2y$10$weJf.IUuah1nE5n6y5XSB.sJ3Rcki7fKmXPos5RAga5LkmQnYcbt6',0,'Strongwind.png',1,9,1,1,NULL,0,133,0,175,4,'2025-01-05 15:25:22','2025-02-06 12:17:19'),(19,'Milambar','$2y$10$Mi0qB2.ggy3qf94WFOFkRe3iN3KaNLikJAFcMb1p2i3fu9XMfxnYC',0,'Milambar.png',13,10,1,1,NULL,0,47,0,25,1,'2025-01-11 13:20:32','2025-02-06 12:17:19'),(20,'Tallassia','$2y$10$KxLH/sDhnPZ056NmI3uep.73f.h7cSUAA5/D9ufTLK71dl5gkrMM6',0,'Tallassia.png',3,12,1,1,NULL,0,250,0,390,6,'2025-02-11 20:41:50','2025-02-11 20:41:50'),(21,'Hangtime','$2y$10$3R5KYB.VKseRguQ0MtfgMeniHdF.AoI5SiFBzZ9wjvKRV.h3X7lC.',0,'Hangtime.png',8,13,1,1,NULL,0,247,0,405,7,'2025-02-11 21:01:40','2025-02-11 21:01:40'),(22,'MFG-Test','$2y$10$HBa8ZN06pjwZaU0fj46QHuM57P3EFG8bpqJxYlWLQ3ls2iwBuUBsu',0,'MFG-Test.png',3,14,1,1,NULL,0,-1,0,-1,1,NULL,'2025-02-06 12:17:19');
/*!40000 ALTER TABLE `asc_player` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=167 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asc_unit`
--

LOCK TABLES `asc_unit` WRITE;
/*!40000 ALTER TABLE `asc_unit` DISABLE KEYS */;
INSERT INTO `asc_unit` VALUES (7,4,7570,2,'32','Killer1',20,'images/units/Generic_Mech.gif','Baboon (Howler) 6',28,'BM',1,3,14,NULL,'Striker',3,2,0,2,0,0,0,0,0,0,2,2,0,'CASEII,SRM2/2,TUR(2/2/-,SRM2/2)','',0,0,'2024-12-13 09:25:51'),(27,9,2306,2,'1','test',70,'images/units/Nova%20Cat.png','Nova Cat Prime',62,'BM',3,1,8,NULL,'Sniper',2,5,0,5,0,5,0,0,0,1,7,4,0,'ENE,OMNI,OVL','',0,0,'2024-12-17 16:13:23'),(28,9,1981,2,'2','test',75,'images/units/Timberwolf.png','Mad Cat (Timber Wolf) D',61,'BM',3,2,10,NULL,'Skirmisher',3,5,0,5,0,3,0,0,0,1,8,4,0,'CASE,OMNI,REAR2/2/-','',0,0,'2024-12-17 16:13:23'),(29,9,496,2,'3','test',65,'images/units/Ebon%20Jaguar.png','Cauldron-Born (Ebon Jaguar) Prime',49,'BM',3,2,10,NULL,'Skirmisher',3,3,0,4,0,3,0,0,0,0,6,4,0,'CASE,FLK0&#42;/0&#42;/0&#42;,IF1,OMNI','',0,0,'2024-12-17 16:13:24'),(30,9,926,2,'4','test',40,'images/units/Generic_Mech.gif','Dragonfly (Viper) Prime',44,'BM',2,3,16,16,'Scout',3,3,0,3,0,0,0,0,0,0,4,2,0,'AMS,CASE,OMNI','',0,0,'2024-12-17 16:13:24'),(31,9,2289,2,'','test',50,'images/units/Huntsman.png','Nobori-nin (Huntsman) A',44,'BM',2,2,10,10,'Sniper',3,3,0,3,0,3,0,0,0,0,6,3,0,'CASE,FLK0&#42;/0&#42;/0&#42;,IF1,OMNI','',0,0,'2024-12-17 16:13:24'),(32,9,1206,2,'6','test',95,'images/units/Executioner.png','Gladiator (Executioner) D',86,'BM',4,2,10,8,'Skirmisher',2,7,0,7,0,2,0,0,0,1,9,5,0,'CASE,JMPW1,OMNI,SRM2/2','',0,0,'2024-12-17 16:13:24'),(33,9,2299,2,'6','test',70,'images/units/Nova%20Cat.png','Nova Cat A',52,'BM',3,1,8,8,'Sniper',3,5,0,5,0,5,0,0,0,0,7,4,0,'ENE,OMNI','',0,0,'2024-12-17 16:13:24'),(34,9,2299,2,'7','test',70,'images/units/Nova%20Cat.png','Nova Cat A',52,'BM',3,1,8,8,'Sniper',3,5,0,5,0,5,0,0,0,0,7,4,0,'ENE,OMNI','',0,0,'2024-12-17 16:13:24'),(36,9,2296,2,'10','test',50,'images/units/Huntsman.png','Nobori-nin (Huntsman) Prime',50,'BM',2,2,10,10,'Skirmisher',3,3,0,3,0,2,0,0,0,3,6,3,0,'AMS,CASE,IF1,OMNI,PRB,RCN,TAG','',0,0,'2024-12-17 16:13:24'),(37,9,273,2,'9','test',40,'images/units/Generic_Mech.gif','Battle Cobra Prime',37,'BM',2,2,12,NULL,'Sniper',3,3,0,3,0,3,0,0,0,0,4,3,0,'ENE,OMNI','',0,0,'2024-12-17 16:13:24'),(38,9,1293,2,'','test',45,'images/units/Generic_Mech.gif','Grendel (Mongrel) Prime',55,'BM',2,3,14,14,'Striker',3,4,0,4,0,1,0,0,0,1,5,2,0,'CASE,OMNI','',0,0,'2024-12-17 16:13:24'),(39,9,2892,2,'12','test',45,'images/units/Shadow%20Cat.png','Shadow Cat Prime',49,'BM',2,3,16,12,'Striker',3,3,0,3,0,2,0,0,0,0,4,2,0,'CASE,OMNI,PRB,RCN,JMPW1','',0,0,'2024-12-17 16:13:24'),(40,9,2598,2,'13','test',35,'images/units/Generic_Mech.gif','Puma (Adder) Prime',36,'BM',1,2,12,NULL,'Sniper',3,3,0,3,0,3,0,0,0,1,4,2,0,'ENE,OMNI,OVL','',0,0,'2024-12-17 16:13:24'),(42,9,2888,2,'14','test',45,'images/units/Shadow%20Cat.png','Shadow Cat B',61,'BM',2,3,16,12,'Missile Boat',3,4,0,4,0,3,0,0,0,0,4,2,0,'CASE,ECM,IF2,OMNI,PRB,RCN,JMPW1','',0,0,'2024-12-17 16:13:24'),(43,9,1384,2,'15','test',30,'images/units/Arctic%20Cheetah.png','Hankyu (Arctic Cheetah) Prime',36,'BM',1,3,16,12,'Striker',4,3,0,2,0,1,0,0,0,0,3,2,0,'CASE,ECM,IF1,OMNI,PRB,RCN,TAG,JMPW1','',0,0,'2024-12-17 16:13:24'),(49,12,8239,2,'','test',100,'images/units/Generic_Mech.gif','Amarok',64,'BM',4,1,8,NULL,'Juggernaut',3,5,0,5,0,4,0,0,0,1,11,5,0,'CASE,CR','',0,0,'2024-12-17 16:13:24'),(50,12,1985,2,'','test',75,'images/units/Timberwolf.png','Mad Cat (Timber Wolf) Prime',65,'BM',3,2,10,NULL,'Brawler',3,5,0,5,0,4,0,0,0,1,8,4,0,'CASE,IF2,LRM1/1/2,OMNI','',0,0,'2024-12-17 16:13:24'),(51,11,8353,2,'','test',50,'images/units/Generic_Mech.gif','Hunchback C',42,'BM',2,2,12,NULL,'Skirmisher',4,6,0,6,0,0,0,0,0,0,5,3,0,'CASE','',0,0,'2024-12-17 16:13:24'),(52,11,6272,2,'','test',60,'images/units/Maddog.png','Vulture Mk III (Mad Dog Mk III) A',47,'BM',3,2,10,NULL,'Skirmisher',4,6,0,6,0,2,0,0,0,0,6,3,0,'CASE,OMNI,SRM2/2','',0,0,'2024-12-17 16:13:24'),(53,11,9261,2,'','test',40,'images/units/Generic_Mech.gif','Pouncer G',37,'BM',2,2,12,10,'Striker',4,5,0,5,0,0,0,0,0,3,4,2,0,'CASEII,OMNI,SRM1/1','',0,0,'2024-12-17 16:13:24'),(54,4,8724,2,'','test',1,'images/units/Generic_Battlearmor.gif','Buraq Fast BA (Support) (Sqd5)',23,'BA',1,3,14,NULL,'Scout',3,1,0,1,0,0,0,0,0,0,1,2,0,'CAR5,LTAG','',0,0,'2024-12-17 16:13:24'),(55,11,9261,2,'','test',40,'images/units/Generic_Mech.gif','Pouncer G',37,'BM',2,2,12,10,'Striker',4,5,0,5,0,0,0,0,0,3,4,2,0,'CASEII,OMNI,SRM1/1','',0,0,'2024-12-17 16:13:24'),(56,11,7518,2,'','test',75,'images/units/Timberwolf.png','Mad Cat (Timber Wolf) W',66,'BM',3,2,12,NULL,'Juggernaut',3,7,0,7,0,0,0,0,0,0,8,4,0,'CASE,OMNI','',0,0,'2024-12-17 16:13:24'),(57,11,8165,2,'','test',50,'images/units/Nova.png','Black Hawk (Nova) G',55,'BM',2,2,10,10,'Skirmisher',3,7,0,7,0,0,0,0,0,0,5,3,0,'CASE,OMNI','',0,0,'2024-12-17 16:13:24'),(59,2,6571,2,'','test',75,'images/units/Generic_Mech.gif','Mad Cat Mk IV (Savage Wolf) A',66,'BM',3,2,10,NULL,'Skirmisher',3,6,0,5,0,4,0,0,0,2,9,3,0,'ARM,CASE,CR,OMNI','',0,0,'2024-12-17 16:13:24'),(61,9,342,2,'','test',50,'images/units/Nova.png','Black Hawk (Nova) Prime',49,'BM',2,2,10,10,'Skirmisher',3,5,0,5,0,0,0,0,0,4,5,3,0,'ENE,OMNI','',0,0,'2024-12-17 16:13:24'),(62,11,9397,3,'','test',80,'images/units/Generic_Mech.gif','Charger C',100,'BM',4,3,16,NULL,'Scout',3,6,0,6,0,0,0,0,0,0,10,4,0,'AECM,BH,CASE,CR,RCN','',0,0,'2024-12-17 16:13:24'),(63,9,818,2,'','test',100,'images/units/Direwolf.png','Daishi (Dire Wolf) Prime',67,'BM',4,1,6,NULL,'Juggernaut',3,6,0,6,0,4,0,0,0,4,10,5,0,'CASE,IF0&#42;,OMNI,OVL','',0,0,'2024-12-17 16:13:24'),(64,10,3486,1,'01','test',70,'images/units/Warhammer.png','Warhammer WHM-6K',38,'BM',3,1,8,NULL,'Brawler',3,3,0,3,0,2,0,0,0,1,5,6,0,'-','',0,0,'2024-12-17 16:13:24'),(65,10,7529,1,'02','test',75,'images/units/Generic_Mech.gif','Marauder MAD-5D-DC',42,'BM',3,1,8,8,'Brawler',3,3,0,3,0,2,0,0,0,2,7,3,0,'ENE,MHQ1','',0,0,'2024-12-17 16:13:24'),(66,10,2699,1,'03','test',60,'images/units/Rifleman.png','Rifleman RFL-5D',38,'BM',3,1,8,NULL,'Brawler',3,4,0,4,0,2,0,0,0,1,5,3,0,'ENE','',0,0,'2024-12-17 16:13:25'),(67,10,7431,1,'04','test',65,'images/units/Generic_Mech.gif','Thunderbolt TDR-5D',42,'BM',3,1,8,NULL,'Brawler',3,3,0,3,0,1,0,0,0,0,7,5,0,'AC2/2/-,IF1','',0,0,'2024-12-17 16:13:25'),(68,11,714,2,'','test',40,'images/units/Generic_Mech.gif','Coyotl Prime',58,'BM',2,3,14,NULL,'Striker',3,4,0,4,0,3,0,0,0,0,5,2,0,'CASE,IF1,OMNI','',0,0,'2024-12-17 16:13:25'),(69,11,7565,3,'','test',70,'images/units/Warhammer.png','Warhammer C 2',52,'BM',3,1,8,NULL,'Brawler',3,6,0,6,0,3,0,0,0,2,5,6,0,'-','',0,0,'2024-12-17 16:13:25'),(70,11,8357,2,'','test',90,'images/units/Cyclops.png','Cyclops C',64,'BM',4,1,6,NULL,'Brawler',3,5,0,5,0,3,0,0,0,0,11,7,0,'CASEII,CR','',0,0,'2024-12-17 16:13:25'),(72,11,8344,2,'','test',95,'images/units/Generic_Mech.gif','Mastodon B',74,'BM',4,1,6,NULL,'Juggernaut',3,8,0,8,0,2,0,0,0,0,10,10,0,'CASEII,FLK1/1/-,OMNI','',0,0,'2024-12-17 16:13:25'),(73,11,1786,2,'','test',90,'images/units/Generic_Mech.gif','Kingfisher Prime',65,'BM',4,1,8,NULL,'Brawler',3,6,0,6,0,3,0,0,0,1,9,7,0,'CASE,IF1,OMNI','',0,0,'2024-12-17 16:13:25'),(74,11,1333,2,'','test',70,'images/units/Generic_Mech.gif','Grizzly 2',50,'BM',3,1,8,8,'Skirmisher',3,5,0,4,0,4,0,0,0,0,7,6,0,'CASE','',0,0,'2024-12-17 16:13:25'),(75,11,926,2,'','test',40,'images/units/Generic_Mech.gif','Dragonfly (Viper) Prime',44,'BM',2,3,16,16,'Scout',3,3,0,3,0,0,0,0,0,0,4,2,0,'AMS,CASE,OMNI','',0,0,'2024-12-17 16:13:25'),(76,2,3654,2,'','test',35,'images/units/Generic_Tank.gif','Zorya Light Tank',22,'CV',1,1,8,NULL,'Missile Boat',3,2,0,2,0,2,0,0,0,0,2,2,0,'CASE,ECM,EE,FLK0&#42;/0&#42;/0&#42;,IF1,SRCH,TUR(2/2/2,IF1,FLK0&#42;/0&#42;/0&#42;)','t',0,0,'2024-12-17 16:13:25'),(77,11,8309,2,'','test',55,'images/units/Generic_Mech.gif','Rime Otter Prime',54,'BM',2,2,12,NULL,'Brawler',3,4,0,4,0,4,0,0,0,0,6,6,0,'CASEII,IF1,OMNI','',0,0,'2024-12-17 16:13:25'),(79,2,6571,2,'','',75,'images/units/Generic_Mech.gif','Mad Cat Mk IV (Savage Wolf) A',88,'BM',3,2,10,NULL,'Skirmisher',1,6,0,5,0,4,0,0,0,2,9,3,0,'ARM,CASE,CR,OMNI','',0,0,'2024-12-22 12:48:14'),(80,2,8440,3,'','',90,'images/units/Generic_Mech.gif','Alpha Wolf Prime',71,'BM',4,1,8,NULL,'Sniper',3,6,0,6,0,6,0,0,0,0,9,5,0,'CASE,ECM,IF2,LRM2/2/2,OMNI,STL','',0,0,'2024-12-22 15:26:01'),(81,2,72,2,'','',70,'images/units/Generic_Mech.gif','Archer (Wolf)',61,'BM',3,1,8,NULL,'Missile Boat',3,5,0,5,0,5,0,0,0,1,7,6,0,'AMS,CASE,ECM,IF2,OVL,REAR1/1/-','',0,0,'2024-12-30 19:01:43'),(83,18,1985,2,'','',75,'images/units/Timberwolf.png','Mad Cat (Timber Wolf) Prime',65,'BM',3,2,10,NULL,'Brawler',3,5,0,5,0,4,0,0,0,1,8,4,0,'CASE,IF2,LRM1/1/2,OMNI','',0,0,'2024-12-30 19:11:19'),(85,2,43,2,'','',100,'images/units/Annihilator.png','Annihilator C',68,'BM',4,1,6,NULL,'Sniper',3,6,0,6,0,6,0,0,0,3,9,8,0,'CASE','',0,0,'2024-12-30 19:50:40'),(86,18,43,2,'','',100,'images/units/Annihilator.png','Annihilator C',68,'BM',4,1,6,NULL,'Sniper',3,6,0,6,0,6,0,0,0,3,9,8,0,'CASE','',0,0,'2024-12-30 19:51:43'),(87,2,189,2,'','',20,'images/units/Generic_Mech.gif','Baboon (Howler)',24,'BM',1,3,14,NULL,'Missile Boat',3,1,0,1,0,1,0,0,0,0,2,2,0,'CASE,IF1','',0,0,'2024-12-30 21:10:08'),(89,2,2033,1,'129','',75,'images/units/Generic_Mech.gif','Marauder MAD-1R',51,'BM',3,1,8,NULL,'Sniper',2,2,0,3,0,3,0,0,0,1,7,6,0,'CASE','',0,0,'2024-12-31 10:50:26'),(90,2,1773,1,'126','',100,'images/units/Generic_Mech.gif','King Crab KGC-001',58,'BM',4,1,6,NULL,'Juggernaut',3,4,0,4,0,4,0,0,0,2,10,4,0,'CASE,IF1','',0,0,'2024-12-31 10:51:59'),(91,2,3574,1,'112','',55,'images/units/Wolverine.png','Wolverine WVR-7D',41,'BM',2,2,12,10,'Skirmisher',3,3,0,3,0,1,0,0,0,0,6,3,0,'CASE','',0,0,'2024-12-31 10:55:12'),(92,2,2902,1,'127','',55,'images/units/Generic_Mech.gif','Shadow Hawk SHD-2Hb',41,'BM',2,2,10,6,'Skirmisher',3,3,0,3,0,1,0,0,0,0,5,5,0,'CASE,FLK1/1/1,JMPW1','',0,0,'2024-12-31 10:56:41'),(93,2,2492,1,'128','',45,'images/units/Generic_Mech.gif','Phoenix Hawk PXH-1b &quot;Special&quot;',34,'BM',2,2,12,12,'Skirmisher',3,2,0,2,0,2,0,0,0,1,4,2,0,'CASE,ECM','',0,0,'2024-12-31 10:58:13'),(94,2,3010,1,'124','',30,'images/units/Generic_Mech.gif','Spider SDR-5V',25,'BM',1,3,16,16,'Scout',3,1,0,1,0,0,0,0,0,0,2,3,0,'ENE','',0,0,'2024-12-31 11:01:18'),(102,1,1985,2,'1','Timber Wolf Prime',75,'images/units/Timberwolf.png','Mad Cat (Timber Wolf) Prime',65,'BM',3,2,10,NULL,'Brawler',3,5,0,5,0,4,0,0,0,1,8,4,0,'CASE,IF2,LRM1/1/2,OMNI','',0,0,'2025-01-10 18:55:34'),(103,11,924,2,'','',40,'images/units/Generic_Mech.gif','Dragonfly (Viper) H',46,'BM',2,3,16,16,'Striker',3,3,0,3,0,0,0,0,0,1,4,2,0,'AMS,CASE,OMNI','',0,0,'2025-01-04 20:34:34'),(104,11,6840,2,'','',95,'images/units/Executioner.png','Gladiator (Executioner) I',58,'BM',4,2,12,8,'Skirmisher',4,6,0,6,0,0,0,0,0,0,9,5,0,'CASE,ECM,OMNI,JMPW1','',0,0,'2025-01-04 20:39:22'),(105,11,8352,2,'','',40,'images/units/Generic_Mech.gif','Kontio',52,'BM',2,3,18,NULL,'Striker',4,4,0,4,0,0,0,0,0,1,5,2,0,'ECM,ENE,MEL,STL,TSM','',0,0,'2025-01-04 20:39:47'),(106,11,714,2,'','',40,'images/units/Generic_Mech.gif','Coyotl Prime',48,'BM',2,3,14,NULL,'Striker',4,4,0,4,0,3,0,0,0,0,5,2,0,'CASE,IF1,OMNI','',0,0,'2025-01-04 20:40:33'),(107,11,6946,2,'','',20,'images/units/Dasher.png','Dasher (Fire Moth) G',42,'BM',1,4,30,NULL,'Striker',3,4,0,4,0,0,0,0,0,1,1,1,0,'CASE,OMNI','',0,0,'2025-01-04 20:41:00'),(108,11,920,2,'','',40,'images/units/Generic_Mech.gif','Dragonfly (Viper) D',50,'BM',2,3,16,16,'Striker',3,4,0,4,0,0,0,0,0,0,4,2,0,'CASE,IF0&#42;,OMNI','',0,0,'2025-01-04 20:41:49'),(109,1,3183,2,'23','Summoner',70,'images/units/Summoner.png','Thor (Summoner) Prime',52,'BM',3,2,10,10,'Sniper',3,4,0,4,0,4,0,0,0,0,6,4,0,'CASE,FLK1/1/1,IF1,OMNI','',0,0,'2025-01-10 20:01:49'),(110,1,1287,2,'565','Mongrel',45,'images/units/Generic_Mech.gif','Grendel (Mongrel) B',72,'BM',2,3,14,14,'Striker',1,4,0,4,0,1,0,0,0,0,5,2,0,'CASE,OMNI','',0,0,'2025-01-10 20:10:09'),(111,1,9390,2,'','',60,'images/units/Generic_Tank.gif','Eurus MBT A',55,'CV',3,2,12,NULL,'Skirmisher',3,7,0,7,0,0,0,0,0,0,6,3,0,'CASE,CR,OMNI,SRCH,TUR(7/7/-)','t',0,0,'2025-01-10 20:59:23'),(112,1,8966,2,'','',1,'images/units/Generic_Battlearmor.gif','Afreet Medium BA (Hell&apos;s Horses) (Sqd6)',18,'BA',1,1,8,8,'Scout',3,2,0,0,0,0,0,0,0,0,1,2,0,'AM,CAR6,MEC','',0,0,'2025-01-10 21:07:06'),(113,19,100,2,'1','Milam',40,'images/units/Generic_Mech.gif','Arctic Wolf 2',49,'BM',2,3,14,NULL,'Striker',3,4,0,4,0,2,0,0,0,1,3,2,0,'CASE,SNARC,SRM3/3','',0,0,'2025-01-10 22:31:00'),(116,19,8965,2,'2','',0,'images/units/Generic_Battlearmor.gif','Aerie PA(L) (Sqd6)',12,'BA',1,1,6,6,'Ambusher',3,1,0,0,0,0,0,0,0,0,0,2,0,'AM,CAR6,MEC,SOA,STL','',0,0,'2025-01-10 22:47:13'),(122,20,2782,1,'','',80,'images/units/Generic_Mech.gif','Salamander PPR-5S',55,'BM',4,1,8,NULL,'Missile Boat',3,3,0,5,0,4,0,0,0,0,8,4,0,'CASE,IF4,LRM2/3/4','',0,0,'2025-01-11 10:44:24'),(123,20,3473,2,'','',60,'images/units/Maddog.png','Vulture (Mad Dog) Prime',50,'BM',3,2,10,NULL,'Missile Boat',3,4,0,4,0,4,0,0,0,2,5,3,0,'CASE,IF2,LRM1/1/2,OMNI','',0,0,'2025-01-11 10:45:48'),(124,20,3644,1,'','',80,'images/units/Generic_Mech.gif','Zeus ZEU-9S',48,'BM',4,1,8,NULL,'Sniper',3,3,0,4,0,3,0,0,0,0,7,6,0,'CASE,IF1,REAR1/1/-','',0,0,'2025-01-11 10:46:29'),(126,20,247,1,'','',95,'images/units/Banshee.png','Banshee BNC-5S',42,'BM',4,1,8,NULL,'Sniper',4,4,0,4,0,4,0,0,0,1,8,4,0,'REAR1/1/-','',0,0,'2025-01-11 10:48:50'),(127,20,3563,1,'','',35,'images/units/Generic_Mech.gif','Wolfhound WLF-2',34,'BM',1,2,12,NULL,'Striker',3,3,0,3,0,1,0,0,0,0,4,3,0,'ENE,REAR1/1/-','',0,0,'2025-01-11 10:51:07'),(128,20,3462,1,'','',40,'images/units/Generic_Mech.gif','Vulcan VT-5S',29,'BM',2,3,16,12,'Striker',4,2,0,2,0,1,0,0,0,0,3,2,0,'CASE,JMPW1','',0,0,'2025-01-11 10:52:19'),(129,20,3426,1,'','',45,'images/units/Vindicator.png','Vindicator VND-3L',27,'BM',2,1,8,8,'Brawler',4,2,0,2,0,2,0,0,0,0,5,4,0,'CASE,IF0&#42;','',0,0,'2025-01-11 10:53:10'),(130,20,829,1,'','',25,'images/units/Generic_Mech.gif','Dart DRT-4S',23,'BM',1,3,18,NULL,'Scout',4,2,0,2,0,0,0,0,0,0,2,2,0,'ENE','',0,0,'2025-01-11 10:54:34'),(131,20,1033,1,'','',75,'images/units/Generic_Mech.gif','Falconer FLC-8R',48,'BM',3,2,10,10,'Skirmisher',3,3,0,4,0,3,0,0,0,1,6,3,0,'-','',0,0,'2025-01-11 10:55:47'),(132,20,450,1,'','',55,'images/units/Generic_Mech.gif','Bushwacker BSW-X1',33,'BM',2,2,10,NULL,'Skirmisher',4,3,0,3,0,2,0,0,0,0,5,3,0,'AC1/1/-,CASE,IF1','',0,0,'2025-01-11 10:57:24'),(133,20,275,1,'','',30,'images/units/Generic_Mech.gif','Battle Hawk BH-K305',24,'BM',1,2,10,10,'Striker',4,3,0,3,0,0,0,0,0,0,3,1,0,'AMS','',0,0,'2025-01-11 10:59:07'),(134,20,1536,1,'','',35,'images/units/Generic_Mech.gif','Hollander BZK-F3',24,'BM',1,2,10,NULL,'Sniper',3,2,0,2,0,2,0,0,0,0,2,3,0,'-','',0,0,'2025-01-11 11:00:28'),(135,20,3216,1,'','Ari 1',70,'images/units/Generic_Mech.gif','Thunder THR-3L',57,'BM',3,2,10,NULL,'Missile Boat',4,2,0,2,0,0,0,0,0,1,7,3,0,'ARTAIS-1,CASE,ECM,STL,TSM','',0,0,'2025-01-11 11:02:52'),(136,19,3673,2,'2','2',0,'images/units/Generic_Battlearmor.gif','Aerie PA(L) (Salvage) (Sqd4)',12,'BA',1,1,6,6,'Ambusher',3,0,0,0,0,0,0,0,0,0,0,2,0,'CAR4,SOA,STL','',0,0,'2025-01-11 11:50:30'),(137,19,5639,3,'2','3',25,'images/units/Generic_Mech.gif','Cephalus C',35,'BM',1,4,20,NULL,'Scout',3,0,0,0,0,0,0,0,0,0,3,1,0,'CR,ECM,ENE,HT1/1/1,MHQ1,NOVA,OMNI,PRB,RCN,STL','',0,0,'2025-01-11 11:57:33'),(138,20,3220,1,'','Ari 2',100,'images/units/Generic_Mech.gif','Thunder Hawk TDK-7KMA',59,'BM',4,1,6,NULL,'Missile Boat',4,5,0,5,0,3,0,0,0,0,10,4,0,'ARTAIS-1','',0,0,'2025-01-11 16:20:39'),(139,20,3300,1,'','Ari 3 - Tebu...',50,'images/units/Generic_Mech.gif','Trebuchet TBT-7M',37,'BM',2,2,10,10,'Missile Boat',3,3,0,3,0,2,0,0,0,0,4,2,0,'CASE,IF1,LRM1/1/1,SNARC','',0,0,'2025-01-11 16:24:55'),(140,20,2814,1,'','Ari 4 - Scar...',30,'images/units/Generic_Mech.gif','Scarabus SCB-9T',34,'BM',1,4,20,NULL,'Scout',3,2,0,1,0,0,0,0,0,0,3,1,0,'ECM,ENE,MEL,TAG,TSM','',0,0,'2025-01-11 16:29:35'),(141,2,2811,1,'','',35,'images/units/Generic_Tank.gif','Saxon APC',30,'CV',1,4,20,NULL,'Scout',3,0,0,0,0,0,0,0,0,0,5,2,0,'IT5,SRCH,TUR(0&#42;/-/-)','h',0,0,'2025-01-11 18:19:04'),(142,11,3452,1,'','',75,'images/units/Generic_Tank.gif','Von Luckner Heavy Tank VNL-K65N',36,'CV',3,1,6,NULL,'Juggernaut',3,5,0,4,0,0,0,0,0,0,6,4,0,'AC2/2/-,REAR0&#42;/1/1,SRCH,SRM2/2,TUR(4/4/-,SRM2/2,AC2/2/-)','t',0,0,'2025-01-12 09:12:57'),(143,11,3452,1,'','',75,'images/units/Generic_Tank.gif','Von Luckner Heavy Tank VNL-K65N',36,'CV',3,1,6,NULL,'Juggernaut',3,5,0,4,0,0,0,0,0,0,6,4,0,'AC2/2/-,REAR0&#42;/1/1,SRCH,SRM2/2,TUR(4/4/-,SRM2/2,AC2/2/-)','t',0,0,'2025-01-12 09:13:35'),(144,11,2021,1,'','',60,'images/units/Generic_Tank.gif','Manticore Heavy Tank',34,'CV',3,1,8,NULL,'Brawler',3,3,0,3,0,2,0,0,0,0,6,3,0,'IF1,SRCH,TUR(2/3/2,IF1)','t',0,0,'2025-01-12 09:14:04'),(145,11,2021,1,'','',60,'images/units/Generic_Tank.gif','Manticore Heavy Tank',34,'CV',3,1,8,NULL,'Brawler',3,3,0,3,0,2,0,0,0,0,6,3,0,'IF1,SRCH,TUR(2/3/2,IF1)','t',0,0,'2025-01-12 09:14:30'),(146,11,2827,1,'','',80,'images/units/Generic_Tank.gif','Schrek PPC Carrier',30,'CV',4,1,6,NULL,'Sniper',3,3,0,3,0,3,0,0,0,0,4,4,0,'ENE,SRCH,TUR(3/3/3)','t',0,0,'2025-01-12 09:15:27'),(147,11,2827,1,'','',80,'images/units/Generic_Tank.gif','Schrek PPC Carrier',30,'CV',4,1,6,NULL,'Sniper',3,3,0,3,0,3,0,0,0,0,4,4,0,'ENE,SRCH,TUR(3/3/3)','t',0,0,'2025-01-12 09:16:10'),(148,11,2827,1,'','',80,'images/units/Generic_Tank.gif','Schrek PPC Carrier',30,'CV',4,1,6,NULL,'Sniper',3,3,0,3,0,3,0,0,0,0,4,4,0,'ENE,SRCH,TUR(3/3/3)','t',0,0,'2025-01-12 09:16:52'),(149,11,3515,1,'','',21,'images/units/Generic_Tank.gif','Warrior Attack Helicopter H-7C',24,'CV',1,3,18,NULL,'Sniper',3,1,0,2,0,1,0,0,0,0,1,2,0,'ATMO,EE,IF1,SRCH','',0,0,'2025-01-12 09:18:00'),(150,11,3515,1,'','',21,'images/units/Generic_Tank.gif','Warrior Attack Helicopter H-7C',24,'CV',1,3,18,NULL,'Sniper',3,1,0,2,0,1,0,0,0,0,1,2,0,'ATMO,EE,IF1,SRCH','',0,0,'2025-01-12 09:18:29'),(151,21,74,1,'1','',70,'images/units/Generic_Mech.gif','Archer ARC-2R',39,'BM',3,1,8,NULL,'Missile Boat',4,2,0,3,0,3,0,0,0,1,7,6,0,'IF2,LRM1/2/2,REAR1/1/-','',0,0,'2025-02-10 16:44:35'),(152,21,140,1,'2','',100,'images/units/Generic_Mech.gif','Atlas AS7-D',62,'BM',4,1,6,NULL,'Juggernaut',3,5,0,5,0,2,0,0,0,0,10,8,0,'AC2/2/-,IF1,LRM1/1/1,REAR1/1/-','',0,0,'2025-02-10 16:45:29'),(154,21,388,1,'3','',45,'images/units/Generic_Mech.gif','Blackjack BJ-3',30,'BM',2,1,8,8,'Brawler',4,3,0,3,0,2,0,0,0,1,5,4,0,'ENE','',0,0,'2025-02-10 16:46:57'),(155,21,2332,1,'4','',75,'images/units/Generic_Mech.gif','Orion ON1-K',47,'BM',3,1,8,NULL,'Brawler',3,3,0,3,0,1,0,0,0,1,8,6,0,'IF1','',0,0,'2025-02-10 16:47:39'),(157,21,3485,1,'6','',70,'images/units/Warhammer.png','Warhammer WHM-6D',43,'BM',3,1,8,NULL,'Brawler',3,3,0,3,0,2,0,0,0,0,7,6,0,'ENE','',0,0,'2025-02-10 16:48:44'),(160,21,2491,1,'','',45,'images/units/Generic_Mech.gif','Phoenix Hawk PXH-1',26,'BM',2,2,12,12,'Skirmisher',4,2,0,2,0,0,0,0,0,0,4,4,0,'-','',0,0,'2025-02-10 16:52:02'),(161,20,1901,1,'','',20,'images/units/Generic_Mech.gif','Locust LCT-1V',18,'BM',1,3,16,NULL,'Scout',4,1,0,1,0,0,0,0,0,0,2,2,0,'-','',0,0,'2025-02-11 13:41:00'),(162,20,593,1,'','',40,'images/units/Cicada.png','Cicada CDA-3C',26,'BM',2,3,14,NULL,'Scout',3,2,0,1,0,1,0,0,0,0,2,3,0,'-','',0,0,'2025-02-11 13:41:31'),(163,20,3238,1,'','',65,'images/units/Generic_Mech.gif','Thunderbolt TDR-5S',43,'BM',3,1,8,NULL,'Brawler',3,3,0,3,0,1,0,0,0,1,7,5,0,'IF1','',0,0,'2025-02-11 13:42:38'),(164,20,3642,1,'','',80,'images/units/Generic_Mech.gif','Zeus ZEU-6S',42,'BM',4,1,8,NULL,'Sniper',3,3,0,3,0,2,0,0,0,0,6,6,0,'IF1,REAR1/1/-','',0,0,'2025-02-11 13:43:56'),(165,20,1936,1,'','',85,'images/units/Generic_Mech.gif','Longbow LGB-7Q',63,'BM',4,1,6,NULL,'Missile Boat',2,3,0,4,0,3,0,0,0,0,8,7,0,'IF3,LRM2/3/3','',0,0,'2025-02-11 13:44:28'),(166,20,147,1,'','',100,'images/units/Generic_Mech.gif','Atlas AS7-RS',58,'BM',4,1,6,NULL,'Juggernaut',3,3,0,4,0,1,0,0,0,1,10,8,0,'IF1','',0,0,'2025-02-11 13:44:54');
/*!40000 ALTER TABLE `asc_unit` ENABLE KEYS */;
UNLOCK TABLES;

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
  `currenttmm` int(11) DEFAULT NULL,
  `heat_PREP` int(11) DEFAULT 0,
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
  `active_bid` tinyint(1) NOT NULL DEFAULT 1,
  `active_narc` tinyint(5) DEFAULT 0,
  `narc_desc` varchar(100) DEFAULT 'NARC',
  `unit_status` varchar(100) DEFAULT 'fresh',
  `unit_statusimageurl` varchar(100) DEFAULT 'images/DD_BM_01.png',
  `mounted_unitid` int(11) DEFAULT 0,
  `mounted_on_unitid` int(11) DEFAULT 0,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`mechstatusid`),
  UNIQUE KEY `mechstatusid` (`mechstatusid`)
) ENGINE=InnoDB AUTO_INCREMENT=443 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asc_unitstatus`
--

LOCK TABLES `asc_unitstatus` WRITE;
/*!40000 ALTER TABLE `asc_unitstatus` DISABLE KEYS */;
INSERT INTO `asc_unitstatus` VALUES (7,1,7,4,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:33'),(46,1,27,9,1,1,1,0,0,0,0,0,0,0,1,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:33'),(47,1,28,9,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:33'),(48,1,29,9,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(49,1,30,9,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(50,1,31,9,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(51,1,32,9,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(52,1,33,9,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(53,1,34,9,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(55,1,36,9,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(56,1,37,9,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(57,1,38,9,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(58,1,39,9,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(59,1,40,9,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(61,1,42,9,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(62,1,43,9,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(68,1,49,12,1,1,3,3,0,0,0,0,0,0,0,NULL,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(69,1,50,12,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(82,1,53,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(83,1,54,4,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BA_01.png',0,0,'2025-02-06 12:20:34'),(88,1,59,2,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(94,1,51,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(95,1,52,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(96,1,55,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(97,1,56,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(98,1,57,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(120,1,61,9,1,1,1,0,0,0,0,0,0,0,4,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(125,1,62,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(126,1,63,9,1,1,1,0,0,0,0,0,0,0,4,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(127,1,64,10,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(128,1,65,10,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(129,1,66,10,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(130,1,67,10,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(136,1,68,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(137,1,69,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(138,1,70,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(140,1,72,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(141,1,73,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:34'),(142,1,74,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(143,1,75,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(144,1,76,2,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_CV_01.png',0,0,'2025-02-06 12:20:35'),(145,1,77,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(147,1,79,2,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(148,1,80,2,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(149,1,81,2,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(151,1,83,18,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(161,0,83,18,1,1,2,0,6,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-06 12:20:35'),(170,0,83,18,1,1,3,0,8,4,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','destroyed','images/DD_BM_04.png',0,0,'2025-02-06 12:20:35'),(180,0,83,18,1,1,4,0,8,4,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','destroyed','images/DD_BM_04.png',0,0,'2025-02-06 12:20:35'),(181,1,85,2,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(182,1,86,18,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(183,1,87,2,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(185,1,89,2,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(186,1,90,2,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(187,1,91,2,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'TAG','fresh','images/DD_BM_01.png',0,0,'2025-02-07 11:21:03'),(188,1,92,2,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(189,1,93,2,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(190,1,94,2,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(198,1,102,1,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'BOTH','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(199,1,103,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(200,1,104,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(201,1,105,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(202,1,106,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(203,1,107,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(204,1,108,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(215,1,109,1,1,1,1,0,1,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-06 18:13:02'),(216,1,110,1,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(220,1,111,1,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_CV_01.png',0,0,'2025-02-06 12:20:35'),(221,1,112,1,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BA_01.png',0,0,'2025-02-06 12:20:35'),(222,1,113,19,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'BOTH','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:35'),(225,1,116,19,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BA_01.png',0,0,'2025-02-06 12:20:35'),(231,1,122,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:36'),(232,1,123,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:36'),(233,1,124,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:36'),(235,1,126,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:36'),(236,1,127,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:36'),(237,1,128,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:36'),(238,1,129,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:36'),(239,1,130,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:36'),(240,1,131,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:36'),(241,1,132,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:36'),(242,1,133,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:36'),(243,1,134,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:36'),(244,1,135,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 13:48:20'),(245,1,136,19,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BA_01.png',0,0,'2025-02-06 12:20:36'),(246,1,137,19,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-06 12:20:36'),(247,1,138,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 13:48:23'),(248,1,139,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 13:48:26'),(249,1,140,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 13:48:28'),(250,1,141,2,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_CV_01.png',0,0,'2025-02-06 12:20:36'),(251,1,142,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_CV_01.png',0,0,'2025-02-06 12:20:36'),(252,1,143,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_CV_01.png',0,0,'2025-02-06 12:20:36'),(253,1,144,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_CV_01.png',0,0,'2025-02-06 12:20:36'),(254,1,145,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_CV_01.png',0,0,'2025-02-06 12:20:36'),(255,1,146,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_CV_01.png',0,0,'2025-02-06 12:20:36'),(256,1,147,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_CV_01.png',0,0,'2025-02-06 12:20:36'),(257,1,148,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_CV_01.png',0,0,'2025-02-06 12:20:36'),(258,1,149,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_CV_01.png',0,0,'2025-02-06 12:20:36'),(259,1,150,11,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_CV_01.png',0,0,'2025-02-06 12:20:36'),(281,1,151,21,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-10 17:01:25'),(282,1,152,21,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-10 16:45:29'),(284,1,154,21,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-10 16:54:40'),(285,1,155,21,1,1,1,1,3,0,1,0,0,0,0,NULL,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 18:33:16'),(287,1,157,21,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-10 16:48:44'),(290,1,160,21,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-10 16:52:02'),(291,1,161,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:14:08'),(292,1,162,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 13:41:31'),(293,1,163,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 13:42:38'),(294,1,164,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 13:43:56'),(295,1,165,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 13:44:28'),(296,1,166,20,1,1,1,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:34:51'),(297,0,122,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(298,0,123,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(299,0,124,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(300,0,126,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(301,0,127,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(302,0,128,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(303,0,129,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(304,0,130,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(305,0,131,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(306,0,132,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(307,0,133,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(308,0,134,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(309,0,135,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(310,0,138,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(311,0,139,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(312,0,140,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(313,0,161,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(314,0,162,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(315,0,163,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(316,0,164,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(317,0,165,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(318,0,166,20,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:02'),(319,0,151,21,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:06'),(320,0,152,21,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:06'),(321,0,154,21,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:06'),(322,0,155,21,1,1,2,1,3,0,1,0,0,0,0,NULL,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 19:09:33'),(323,0,157,21,1,1,2,0,1,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 19:00:47'),(324,0,160,21,1,1,2,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 18:38:06'),(325,0,151,21,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:25'),(326,0,152,21,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:25'),(327,0,154,21,1,1,3,0,5,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 19:37:11'),(328,0,155,21,1,1,3,2,3,0,1,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 19:12:25'),(329,0,157,21,1,1,3,0,1,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 19:12:25'),(330,0,160,21,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:25'),(331,0,122,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(332,0,123,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(333,0,124,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(334,0,126,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(335,0,127,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(336,0,128,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(337,0,129,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(338,0,130,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(339,0,131,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(340,0,132,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(341,0,133,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(342,0,134,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(343,0,135,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(344,0,138,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(345,0,139,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(346,0,140,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(347,0,161,20,1,1,3,0,1,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 19:38:11'),(348,0,162,20,1,1,3,0,1,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 19:38:50'),(349,0,163,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(350,0,164,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(351,0,165,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(352,0,166,20,1,1,3,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:12:36'),(353,0,122,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(354,0,123,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(355,0,124,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(356,0,126,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(357,0,127,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(358,0,151,21,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(359,0,128,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(360,0,152,21,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(361,0,129,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(362,0,130,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(363,0,154,21,1,1,4,0,5,3,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','crippled','images/DD_BM_03.png',0,0,'2025-02-11 20:08:54'),(364,0,155,21,1,1,4,1,5,0,1,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 20:09:57'),(365,0,131,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(366,0,132,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(367,0,157,21,1,1,4,0,7,1,0,0,0,0,0,NULL,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','critical','images/DD_BM_03.png',0,0,'2025-02-11 20:11:45'),(368,0,133,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(369,0,160,21,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(370,0,134,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(371,0,135,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(372,0,138,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(373,0,139,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(374,0,140,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(375,0,161,20,1,1,4,0,1,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 19:39:58'),(376,0,162,20,1,1,4,0,2,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 20:06:29'),(377,0,163,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(378,0,164,20,1,1,4,0,3,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 20:26:10'),(379,0,165,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 19:39:58'),(380,0,166,20,1,1,4,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:03:07'),(381,0,151,21,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:12:11'),(382,0,152,21,1,1,5,0,3,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 20:38:22'),(383,0,154,21,1,1,5,0,5,4,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','destroyed','images/DD_BM_04.png',0,0,'2025-02-11 20:31:36'),(384,0,155,21,1,1,5,1,7,0,1,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 20:32:02'),(385,0,157,21,1,1,5,0,7,6,0,0,0,1,0,NULL,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','destroyed','images/DD_BM_04.png',0,0,'2025-02-11 20:37:46'),(386,0,160,21,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:12:11'),(387,0,122,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(388,0,123,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(389,0,124,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(390,0,126,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(391,0,127,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(392,0,128,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(393,0,129,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(394,0,130,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(395,0,131,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(396,0,132,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(397,0,133,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(398,0,134,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(399,0,135,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(400,0,138,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(401,0,139,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(402,0,140,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(403,0,161,20,1,1,5,0,1,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 20:26:16'),(404,0,162,20,1,1,5,0,2,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 20:26:16'),(405,0,163,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(406,0,164,20,1,1,5,0,6,3,0,0,0,0,0,NULL,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','critical','images/DD_BM_03.png',0,0,'2025-02-11 20:28:59'),(407,0,165,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(408,0,166,20,1,1,5,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:26:16'),(409,0,151,21,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:40:41'),(410,0,152,21,1,1,6,0,10,8,0,0,0,0,0,NULL,0,0,0,0,2,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','destroyed','images/DD_BM_04.png',0,0,'2025-02-11 20:56:00'),(411,0,154,21,1,1,6,0,5,4,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','destroyed','images/DD_BM_04.png',0,0,'2025-02-11 20:40:41'),(412,0,155,21,1,1,6,1,7,0,1,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 20:40:41'),(413,0,157,21,1,1,6,0,7,6,0,1,0,1,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','destroyed','images/DD_BM_04.png',0,0,'2025-02-11 20:40:41'),(414,0,160,21,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:40:41'),(415,0,122,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(416,0,123,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(417,0,124,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(418,0,126,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(419,0,127,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(420,0,128,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(421,0,129,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(422,0,130,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(423,0,131,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(424,0,132,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(425,0,133,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(426,0,134,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(427,0,135,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(428,0,138,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(429,0,139,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(430,0,140,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(431,0,161,20,1,1,6,0,1,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 20:41:03'),(432,0,162,20,1,1,6,0,2,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 20:41:03'),(433,0,163,20,1,1,6,0,4,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 21:01:20'),(434,0,164,20,1,1,6,0,6,6,0,0,1,2,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','destroyed','images/DD_BM_04.png',0,0,'2025-02-11 20:59:27'),(435,0,165,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(436,0,166,20,1,1,6,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 20:41:03'),(437,0,151,21,1,1,7,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 21:01:38'),(438,0,152,21,1,1,7,0,10,8,0,0,0,2,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','destroyed','images/DD_BM_04.png',0,0,'2025-02-11 21:01:38'),(439,0,154,21,1,1,7,0,5,4,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','destroyed','images/DD_BM_04.png',0,0,'2025-02-11 21:01:38'),(440,0,155,21,1,1,7,1,7,0,1,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','damaged','images/DD_BM_02.png',0,0,'2025-02-11 21:01:38'),(441,0,157,21,1,1,7,0,7,6,0,1,0,1,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','destroyed','images/DD_BM_04.png',0,0,'2025-02-11 21:01:38'),(442,0,160,21,1,1,7,0,0,0,0,0,0,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,'NARC','fresh','images/DD_BM_01.png',0,0,'2025-02-11 21:01:38');
/*!40000 ALTER TABLE `asc_unitstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asc_unitstatus_archiv`
--

DROP TABLE IF EXISTS `asc_unitstatus_archiv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asc_unitstatus_archiv` (
  `mechstatusid` int(11) NOT NULL,
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
  `currenttmm` int(11) DEFAULT NULL,
  `heat_PREP` int(11) DEFAULT 0,
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
  `active_bid` tinyint(1) NOT NULL DEFAULT 1,
  `active_narc` tinyint(5) DEFAULT 0,
  `narc_desc` varchar(100) DEFAULT 'NARC',
  `unit_status` varchar(100) DEFAULT 'fresh',
  `unit_statusimageurl` varchar(100) DEFAULT 'images/DD_BM_01.png',
  `mounted_unitid` int(11) DEFAULT 0,
  `mounted_on_unitid` int(11) DEFAULT 0,
  `Updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asc_unitstatus_archiv`
--

LOCK TABLES `asc_unitstatus_archiv` WRITE;
/*!40000 ALTER TABLE `asc_unitstatus_archiv` DISABLE KEYS */;
/*!40000 ALTER TABLE `asc_unitstatus_archiv` ENABLE KEYS */;
UNLOCK TABLES;

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

-- Dump completed on 2025-02-11 23:35:40
