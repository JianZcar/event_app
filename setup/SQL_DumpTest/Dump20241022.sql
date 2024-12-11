-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: event_app
-- ------------------------------------------------------
-- Server version	8.0.32

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

--
-- Table structure for table `admin_management`
--

DROP TABLE IF EXISTS `admin_management`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_management` (
  `id` int NOT NULL AUTO_INCREMENT,
  `set_name` varchar(48) DEFAULT NULL,
  `setting_name` text,
  `description` text,
  `toggle` tinyint(1) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_management`
--

LOCK TABLES `admin_management` WRITE;
/*!40000 ALTER TABLE `admin_management` DISABLE KEYS */;
INSERT INTO `admin_management` VALUES (1,'enable_user_registration','Enable User Registration','Enable ability for can user register by manual.',1,'0');
/*!40000 ALTER TABLE `admin_management` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_db`
--

DROP TABLE IF EXISTS `message_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message_db` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(48) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `sender` text,
  `receiver` text,
  `content` text,
  `attachment` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_db`
--

LOCK TABLES `message_db` WRITE;
/*!40000 ALTER TABLE `message_db` DISABLE KEYS */;
/*!40000 ALTER TABLE `message_db` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_infos`
--

DROP TABLE IF EXISTS `user_infos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_infos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bio` text,
  `profile_picture` blob,
  `profile_cover` blob,
  PRIMARY KEY (`id`),
  CONSTRAINT `user_infos_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_infos`
--

LOCK TABLES `user_infos` WRITE;
/*!40000 ALTER TABLE `user_infos` DISABLE KEYS */;
INSERT INTO `user_infos` VALUES (3,NULL,NULL,NULL),(12,NULL,NULL,NULL),(13,NULL,NULL,NULL),(14,NULL,NULL,NULL),(16,NULL,NULL,NULL),(17,NULL,NULL,NULL);
/*!40000 ALTER TABLE `user_infos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) DEFAULT NULL,
  `color` text,
  `bg_color` text,
  `alias` varchar(48) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (1,'Administrator','#007bff',NULL,NULL),(2,'Member','#76b5c5','#76b5c5',NULL);
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(48) DEFAULT NULL,
  `name` varchar(48) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `remarks` text,
  `user_role` int DEFAULT NULL,
  `passwd` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'aceday','Marc',1,NULL,NULL,NULL),(12,'ace1',NULL,0,NULL,1,'$2y$10$vzHPL6lmUkySYE0aP4VxAeaOhGUXY3ztpKrZerQmb4Tjb6W7pXnwa'),(13,'acedat1',NULL,1,NULL,1,'$2y$10$7thfz4pkdx9Xx7zX1XumquOiDpGjnOFJ4CQa/3j9yxmj/TBp7VVqe'),(14,'user','User',1,NULL,2,'$123'),(16,'alsaki',NULL,1,NULL,2,'$2y$10$Ub4Hb62UQBO1gPNRHQ/v3eag0pNY5Xq04GRZ.oVoamti3asYG/QtS'),(17,'integer',NULL,0,NULL,1,'$2y$10$KHvM5HwW50msu4NO.JgQ8.BHSNtAZGBRIZ9wu6t1WDiKI8HO3toDK');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-22 23:18:31
