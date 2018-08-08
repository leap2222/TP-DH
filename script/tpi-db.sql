-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: laravel-database
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP DATABASE IF EXISTS tpi_db;
CREATE DATABASE tpi_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tpi_db;


--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
/*- nombre: String
  - email: String
  - pass: String
  - edad: int
  - tel: String
  - pais: String
  - website: String
  - mensaje: String
  - sexo: String
  - idioma: String
*/
CREATE TABLE `users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` int(10) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `website` varchar(100) NOT NULL,
  `message` varchar(100) DEFAULT NULL,
  `sex` varchar(100) NOT NULL,
  `language` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_email_unique` (`email`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2017-06-12 10:09:28


--
-- Table structure for table `matches_users`
--

DROP TABLE IF EXISTS `matches_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `matches_users` (
  `match_id` int(10) NOT NULL AUTO_INCREMENT,
  `user1_id` int(10) NOT NULL,
  `user2_id` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`match_id`),
  KEY `user_match_user_id_foreign` (`match_id`),
  CONSTRAINT `user_match_user1_id_foreign` FOREIGN KEY (`user1_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `user_match_user2_id_foreign` FOREIGN KEY (`user2_id`) REFERENCES `users` (`user_id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matches_users`
--

LOCK TABLES `matches_users` WRITE;
/*!40000 ALTER TABLE `matches_users` DISABLE KEYS */;
-- INSERT INTO `matches_users` VALUES (1,NULL,NULL,1,1),(2,NULL,NULL,2,1),(3,NULL,NULL,3,1),(4,NULL,NULL,4,2),(5,NULL,NULL,5,2),(6,NULL,NULL,6,2),(7,NULL,NULL,7,3),(8,NULL,NULL,7,4),(9,NULL,NULL,8,3),(10,NULL,NULL,8,4),(11,NULL,NULL,9,3),(12,NULL,NULL,9,4),(13,NULL,NULL,10,5),(14,NULL,NULL,11,5),(15,NULL,NULL,12,5),(16,NULL,NULL,13,6),(17,NULL,NULL,13,8),(18,NULL,NULL,13,9),(19,NULL,NULL,14,6),(20,NULL,NULL,14,8),(21,NULL,NULL,14,9),(22,NULL,NULL,15,6),(23,NULL,NULL,15,8),(24,NULL,NULL,15,9),(25,NULL,NULL,16,7),(26,NULL,NULL,17,7),(27,NULL,NULL,18,7),(28,NULL,NULL,19,10),(29,NULL,NULL,20,10),(30,NULL,NULL,21,11),(31,NULL,NULL,22,11),(32,NULL,NULL,22,9),(33,NULL,NULL,23,11),(34,NULL,NULL,24,12),(35,NULL,NULL,25,12),(36,NULL,NULL,26,12),(37,NULL,NULL,27,13),(38,NULL,NULL,27,14),(39,NULL,NULL,27,19),(40,NULL,NULL,28,13),(41,NULL,NULL,28,14),(42,NULL,NULL,29,20),(43,NULL,NULL,30,21);
/*!40000 ALTER TABLE `matches_users` ENABLE KEYS */;
UNLOCK TABLES;



--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
/*- nombre: String
  - lugar: String
  - asistentes: Usuarios
  - idiomaPreferido: String
*/
CREATE TABLE `events` (
  `event_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(190) NOT NULL,
  `site` varchar(500) NOT NULL,
  `language` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  UNIQUE KEY `event_name_unique` (`name`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;

UNLOCK TABLES;



--
-- Table structure for table `event_users`
--

DROP TABLE IF EXISTS `event_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_users` (
  `reg_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `event_id` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`reg_id`),
  KEY `user_event_user_id_foreign` (`user_id`),
  KEY `user_event_event_id_foreign` (`event_id`),
  CONSTRAINT `user_event_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `user_event_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`)
);



--
-- Dumping data for table `event_users`
--

LOCK TABLES `event_users` WRITE;
/*!40000 ALTER TABLE `event_users` DISABLE KEYS */;
-- INSERT INTO `event_users` VALUES (1,NULL,NULL,1,1),(2,NULL,NULL,2,1),(3,NULL,NULL,3,1),(4,NULL,NULL,4,2),(5,NULL,NULL,5,2),(6,NULL,NULL,6,2),(7,NULL,NULL,7,3),(8,NULL,NULL,7,4),(9,NULL,NULL,8,3),(10,NULL,NULL,8,4),(11,NULL,NULL,9,3),(12,NULL,NULL,9,4),(13,NULL,NULL,10,5),(14,NULL,NULL,11,5),(15,NULL,NULL,12,5),(16,NULL,NULL,13,6),(17,NULL,NULL,13,8),(18,NULL,NULL,13,9),(19,NULL,NULL,14,6),(20,NULL,NULL,14,8),(21,NULL,NULL,14,9),(22,NULL,NULL,15,6),(23,NULL,NULL,15,8),(24,NULL,NULL,15,9),(25,NULL,NULL,16,7),(26,NULL,NULL,17,7),(27,NULL,NULL,18,7),(28,NULL,NULL,19,10),(29,NULL,NULL,20,10),(30,NULL,NULL,21,11),(31,NULL,NULL,22,11),(32,NULL,NULL,22,9),(33,NULL,NULL,23,11),(34,NULL,NULL,24,12),(35,NULL,NULL,25,12),(36,NULL,NULL,26,12),(37,NULL,NULL,27,13),(38,NULL,NULL,27,14),(39,NULL,NULL,27,19),(40,NULL,NULL,28,13),(41,NULL,NULL,28,14),(42,NULL,NULL,29,20),(43,NULL,NULL,30,21);
/*!40000 ALTER TABLE `event_users` ENABLE KEYS */;
UNLOCK TABLES;
