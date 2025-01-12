-- MySQL dump 10.13  Distrib 8.0.40, for macos14 (arm64)
--
-- Host: localhost    Database: football_tracking_db
-- ------------------------------------------------------
-- Server version	9.1.0


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS DBfootball;
USE DBfootball;
--
-- Table structure for table `AGENT`
--

DROP TABLE IF EXISTS `AGENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `AGENT` (
  `agent_id` int NOT NULL,
  `agent_name` char(100) NOT NULL,
  `agent_nationality` char(100) DEFAULT NULL,
  PRIMARY KEY (`agent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AGENT`
--

LOCK TABLES `AGENT` WRITE;
/*!40000 ALTER TABLE `AGENT` DISABLE KEYS */;
/*!40000 ALTER TABLE `AGENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BROADCASTER`
--

DROP TABLE IF EXISTS `BROADCASTER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `BROADCASTER` (
  `b_name` char(100) NOT NULL,
  PRIMARY KEY (`b_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BROADCASTER`
--

LOCK TABLES `BROADCASTER` WRITE;
/*!40000 ALTER TABLE `BROADCASTER` DISABLE KEYS */;
/*!40000 ALTER TABLE `BROADCASTER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DEALS_DONE`
--

DROP TABLE IF EXISTS `DEALS_DONE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `DEALS_DONE` (
  `previous_team` char(100) DEFAULT NULL,
  `new_team` char(100) DEFAULT NULL,
  `player_name` char(100) DEFAULT NULL,
  `transfer_amount` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DEALS_DONE`
--

LOCK TABLES `DEALS_DONE` WRITE;
/*!40000 ALTER TABLE `DEALS_DONE` DISABLE KEYS */;
/*!40000 ALTER TABLE `DEALS_DONE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DEALS_LEAGUE_SPONSOR`
--

DROP TABLE IF EXISTS `DEALS_LEAGUE_SPONSOR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `DEALS_LEAGUE_SPONSOR` (
  `sponsor_name` char(100) NOT NULL,
  `league_name` char(100) NOT NULL,
  `amount_dollars` int DEFAULT NULL,
  `deal_date` date NOT NULL,
  PRIMARY KEY (`sponsor_name`,`league_name`,`deal_date`),
  KEY `league_name` (`league_name`),
  CONSTRAINT `deals_league_sponsor_ibfk_1` FOREIGN KEY (`sponsor_name`) REFERENCES `SPONSOR` (`sponsor_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `deals_league_sponsor_ibfk_2` FOREIGN KEY (`league_name`) REFERENCES `LEAGUE` (`league_name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DEALS_LEAGUE_SPONSOR`
--

LOCK TABLES `DEALS_LEAGUE_SPONSOR` WRITE;
/*!40000 ALTER TABLE `DEALS_LEAGUE_SPONSOR` DISABLE KEYS */;
/*!40000 ALTER TABLE `DEALS_LEAGUE_SPONSOR` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DEALS_TEAM_SPONSOR`
--

DROP TABLE IF EXISTS `DEALS_TEAM_SPONSOR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `DEALS_TEAM_SPONSOR` (
  `sponsor_name` char(100) NOT NULL,
  `team_name` char(100) NOT NULL,
  `amount_dollars` int DEFAULT NULL,
  `deal_date` date NOT NULL,
  PRIMARY KEY (`sponsor_name`,`team_name`,`deal_date`),
  KEY `team_name` (`team_name`),
  CONSTRAINT `deals_team_sponsor_ibfk_1` FOREIGN KEY (`sponsor_name`) REFERENCES `SPONSOR` (`sponsor_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `deals_team_sponsor_ibfk_2` FOREIGN KEY (`team_name`) REFERENCES `TEAM` (`team_name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DEALS_TEAM_SPONSOR`
--

LOCK TABLES `DEALS_TEAM_SPONSOR` WRITE;
/*!40000 ALTER TABLE `DEALS_TEAM_SPONSOR` DISABLE KEYS */;
/*!40000 ALTER TABLE `DEALS_TEAM_SPONSOR` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EMPLOYEE`
--

DROP TABLE IF EXISTS `EMPLOYEE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `EMPLOYEE` (
  `employee_id` int NOT NULL,
  `employee_age` int DEFAULT NULL,
  `employee_name` char(100) NOT NULL,
  `employee_salary` int DEFAULT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EMPLOYEE`
--

LOCK TABLES `EMPLOYEE` WRITE;
/*!40000 ALTER TABLE `EMPLOYEE` DISABLE KEYS */;
/*!40000 ALTER TABLE `EMPLOYEE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `FEDERATION`
--

DROP TABLE IF EXISTS `FEDERATION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `FEDERATION` (
  `fed_name` char(100) NOT NULL,
  `president` char(100) DEFAULT NULL,
  `country` char(100) DEFAULT NULL,
  PRIMARY KEY (`fed_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FEDERATION`
--

LOCK TABLES `FEDERATION` WRITE;
/*!40000 ALTER TABLE `FEDERATION` DISABLE KEYS */;
/*!40000 ALTER TABLE `FEDERATION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LEAGUE`
--

DROP TABLE IF EXISTS `LEAGUE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `LEAGUE` (
  `duration` int DEFAULT NULL,
  `team_number` int DEFAULT NULL,
  `league_name` char(100) NOT NULL,
  `fed_name` char(100) NOT NULL,
  PRIMARY KEY (`league_name`),
  KEY `fed_name` (`fed_name`),
  CONSTRAINT `league_ibfk_1` FOREIGN KEY (`fed_name`) REFERENCES `FEDERATION` (`fed_name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LEAGUE`
--

LOCK TABLES `LEAGUE` WRITE;
/*!40000 ALTER TABLE `LEAGUE` DISABLE KEYS */;
/*!40000 ALTER TABLE `LEAGUE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MANAGER`
--

DROP TABLE IF EXISTS `MANAGER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `MANAGER` (
  `manager_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `team_name` char(100) NOT NULL,
  PRIMARY KEY (`manager_id`),
  KEY `employee_id` (`employee_id`),
  KEY `team_name` (`team_name`),
  CONSTRAINT `manager_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `EMPLOYEE` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `manager_ibfk_2` FOREIGN KEY (`team_name`) REFERENCES `TEAM` (`team_name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MANAGER`
--

LOCK TABLES `MANAGER` WRITE;
/*!40000 ALTER TABLE `MANAGER` DISABLE KEYS */;
/*!40000 ALTER TABLE `MANAGER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PAYS`
--

DROP TABLE IF EXISTS `PAYS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PAYS` (
  `b_name` char(100) NOT NULL,
  `team_name` char(100) NOT NULL,
  `p_amount_dollars` int DEFAULT NULL,
  `p_date` date NOT NULL,
  PRIMARY KEY (`b_name`,`team_name`,`p_date`),
  KEY `team_name` (`team_name`),
  CONSTRAINT `pays_ibfk_1` FOREIGN KEY (`b_name`) REFERENCES `BROADCASTER` (`b_name`),
  CONSTRAINT `pays_ibfk_2` FOREIGN KEY (`team_name`) REFERENCES `TEAM` (`team_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PAYS`
--

LOCK TABLES `PAYS` WRITE;
/*!40000 ALTER TABLE `PAYS` DISABLE KEYS */;
/*!40000 ALTER TABLE `PAYS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PLAYER`
--

DROP TABLE IF EXISTS `PLAYER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PLAYER` (
  `player_id` int NOT NULL,
  `player_name` char(100) NOT NULL,
  `player_salary` int DEFAULT NULL,
  `player_age` int DEFAULT NULL,
  `min_transfer_cost` int DEFAULT NULL,
  `prefered_foot` char(100) DEFAULT NULL,
  `player_position` char(100) DEFAULT NULL,
  `team_name` char(100) DEFAULT NULL,
  `agent_id` int NOT NULL,
  PRIMARY KEY (`player_id`),
  KEY `agent_id` (`agent_id`),
  KEY `team_name` (`team_name`),
  CONSTRAINT `player_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `AGENT` (`agent_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `player_ibfk_2` FOREIGN KEY (`team_name`) REFERENCES `TEAM` (`team_name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PLAYER`
--

LOCK TABLES `PLAYER` WRITE;
/*!40000 ALTER TABLE `PLAYER` DISABLE KEYS */;
/*!40000 ALTER TABLE `PLAYER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PLAYER_TRANSFER_OFFER`
--

DROP TABLE IF EXISTS `PLAYER_TRANSFER_OFFER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PLAYER_TRANSFER_OFFER` (
  `agent_id` int NOT NULL,
  `manager_id` int NOT NULL,
  `player_id` int NOT NULL,
  `offer_amount_dollars` int DEFAULT NULL,
  `offer_date` date NOT NULL,
  PRIMARY KEY (`agent_id`,`manager_id`,`player_id`,`offer_date`),
  KEY `manager_id` (`manager_id`),
  KEY `player_id` (`player_id`),
  CONSTRAINT `player_transfer_offer_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `AGENT` (`agent_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `player_transfer_offer_ibfk_2` FOREIGN KEY (`manager_id`) REFERENCES `MANAGER` (`manager_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `player_transfer_offer_ibfk_3` FOREIGN KEY (`player_id`) REFERENCES `PLAYER` (`player_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PLAYER_TRANSFER_OFFER`
--

LOCK TABLES `PLAYER_TRANSFER_OFFER` WRITE;
/*!40000 ALTER TABLE `PLAYER_TRANSFER_OFFER` DISABLE KEYS */;
/*!40000 ALTER TABLE `PLAYER_TRANSFER_OFFER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SPONSOR`
--

DROP TABLE IF EXISTS `SPONSOR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SPONSOR` (
  `sponsor_name` char(100) NOT NULL,
  `country` char(20) DEFAULT NULL,
  `category` char(100) DEFAULT NULL,
  PRIMARY KEY (`sponsor_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SPONSOR`
--

LOCK TABLES `SPONSOR` WRITE;
/*!40000 ALTER TABLE `SPONSOR` DISABLE KEYS */;
/*!40000 ALTER TABLE `SPONSOR` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `STAFF`
--

DROP TABLE IF EXISTS `STAFF`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `STAFF` (
  `staff_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `team_name` char(100) NOT NULL,
  PRIMARY KEY (`staff_id`),
  KEY `employee_id` (`employee_id`),
  KEY `team_name` (`team_name`),
  CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `EMPLOYEE` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `staff_ibfk_2` FOREIGN KEY (`team_name`) REFERENCES `TEAM` (`team_name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `STAFF`
--

LOCK TABLES `STAFF` WRITE;
/*!40000 ALTER TABLE `STAFF` DISABLE KEYS */;
/*!40000 ALTER TABLE `STAFF` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TEAM`
--

DROP TABLE IF EXISTS `TEAM`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TEAM` (
  `team_name` char(100) NOT NULL,
  `league_name` char(100) NOT NULL,
  `city` char(100) NOT NULL,
  `team_player_count` int DEFAULT NULL,
  PRIMARY KEY (`team_name`),
  KEY `league_name` (`league_name`),
  CONSTRAINT `team_ibfk_1` FOREIGN KEY (`league_name`) REFERENCES `LEAGUE` (`league_name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TEAM`
--

LOCK TABLES `TEAM` WRITE;
/*!40000 ALTER TABLE `TEAM` DISABLE KEYS */;
/*!40000 ALTER TABLE `TEAM` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `VIEWED_IN`
--

DROP TABLE IF EXISTS `VIEWED_IN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `VIEWED_IN` (
  `league_name` char(100) NOT NULL,
  `b_name` char(100) NOT NULL,
  PRIMARY KEY (`league_name`,`b_name`),
  KEY `b_name` (`b_name`),
  CONSTRAINT `viewed_in_ibfk_1` FOREIGN KEY (`b_name`) REFERENCES `BROADCASTER` (`b_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `viewed_in_ibfk_2` FOREIGN KEY (`league_name`) REFERENCES `LEAGUE` (`league_name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `VIEWED_IN`
--

LOCK TABLES `VIEWED_IN` WRITE;
/*!40000 ALTER TABLE `VIEWED_IN` DISABLE KEYS */;
/*!40000 ALTER TABLE `VIEWED_IN` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-08 15:26:30
