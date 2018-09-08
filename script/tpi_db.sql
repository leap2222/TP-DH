-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: tpi_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.32-MariaDB

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


DROP DATABASE IF EXISTS tpi_db;
CREATE DATABASE tpi_db;
USE tpi_db;
--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (27,0,1,4,'hola estoy contento','0000-00-00 00:00:00'),(29,0,1,9,'hola, voy a asistir al evento !','0000-00-00 00:00:00'),(38,27,1,2,'quiero practicar chino y ruso','0000-00-00 00:00:00'),(39,27,1,1,'hola','0000-00-00 00:00:00'),(40,38,1,1,'buenas','0000-00-00 00:00:00'),(41,27,1,2,'Comentario','0000-00-00 00:00:00'),(42,0,1,3,'Otro comentario mas','0000-00-00 00:00:00'),(43,41,1,4,'Mas comentarios.','0000-00-00 00:00:00'),(44,41,1,1,'Otro mas.','0000-00-00 00:00:00'),(45,41,1,2,'Comentarios. Comentarios. Comentarios.','0000-00-00 00:00:00'),(46,43,1,3,'Comentario multilinea. Largo para evaluar como se comporta la vista de los comentarios multilineas.','0000-00-00 00:00:00'),(47,44,1,4,'Mas.','0000-00-00 00:00:00'),(48,41,1,4,'Siguen.','0000-00-00 00:00:00'),(49,42,1,6,'Otros.','0000-00-00 00:00:00'),(50,49,1,2,'Continuando.','0000-00-00 00:00:00'),(51,48,1,8,'Otro comment.','0000-00-00 00:00:00'),(52,47,1,9,'Comment.','0000-00-00 00:00:00'),(53,46,1,1,'Otro.','0000-00-00 00:00:00'),(54,45,1,2,'Mas.Mas.','0000-00-00 00:00:00'),(55,44,1,3,'Reply.','0000-00-00 00:00:00'),(56,44,1,4,'Texto.','0000-00-00 00:00:00'),(57,45,1,8,'Lorem.','0000-00-00 00:00:00'),(58,41,1,6,'Ipsu.','0000-00-00 00:00:00'),(59,0,1,8,'Ahora. 6/9/18.','0000-00-00 00:00:00'),(60,0,1,8,'kjjjjj','0000-00-00 00:00:00'),(61,0,1,8,'adsfadsf','0000-00-00 00:00:00'),(62,0,1,8,'adsfadsf','0000-00-00 00:00:00'),(63,0,1,2,'Ultimo comentario.','0000-00-00 00:00:00'),(64,39,1,8,'Ultimo.123.','0000-00-00 00:00:00'),(65,0,1,4,'qwe','0000-00-00 00:00:00'),(66,45,1,8,'qweqweqwe','0000-00-00 00:00:00'),(67,0,1,6,'asdfasdf','0000-00-00 00:00:00'),(68,0,1,8,'ewr3fsdf','2018-09-07 01:25:17'),(69,0,1,9,'3okohh3r','2018-09-06 20:27:41');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_status`
--

DROP TABLE IF EXISTS `event_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_status` (
  `status_id` int(11) NOT NULL,
  `value` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_status`
--

LOCK TABLES `event_status` WRITE;
/*!40000 ALTER TABLE `event_status` DISABLE KEYS */;
INSERT INTO `event_status` VALUES (1,'Activo'),(2,'Inactivo');
/*!40000 ALTER TABLE `event_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `event_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  UNIQUE KEY `event_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'Juntada en Plaza Francia','Plaza Francia','Francés y Aleman',1,NULL,NULL),(2,'BarBeer','Palermo','Ingles',1,NULL,NULL),(4,'Antares','Palermo','Frances y Aleman',1,NULL,NULL),(5,'Parque Patricios','Parque Patricios','Chino',1,NULL,NULL),(7,'Juntada en Parque Chacabuco','Parque Chacabuco','Inglés',NULL,NULL,NULL),(8,'Biblioteca','Recoleta','Inglés',NULL,NULL,NULL);
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscriptions`
--

DROP TABLE IF EXISTS `inscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inscriptions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `event_id` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_event_user_id_foreign` (`user_id`),
  KEY `user_event_event_id_foreign` (`event_id`),
  CONSTRAINT `user_event_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  CONSTRAINT `user_event_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscriptions`
--

LOCK TABLES `inscriptions` WRITE;
/*!40000 ALTER TABLE `inscriptions` DISABLE KEYS */;
INSERT INTO `inscriptions` VALUES (3,4,5,NULL,NULL),(4,4,8,NULL,NULL),(6,4,2,NULL,NULL),(7,4,4,NULL,NULL),(9,1,2,NULL,NULL),(11,8,1,NULL,NULL),(13,4,1,NULL,NULL),(14,1,1,NULL,NULL),(15,9,8,NULL,NULL),(17,2,1,NULL,NULL),(18,1,1,NULL,NULL),(19,1,1,NULL,NULL),(20,1,1,NULL,NULL),(21,1,1,NULL,NULL),(22,1,1,NULL,NULL);
/*!40000 ALTER TABLE `inscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matches_users`
--

DROP TABLE IF EXISTS `matches_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matches_users` (
  `match_id` int(10) NOT NULL AUTO_INCREMENT,
  `user1_id` int(10) NOT NULL,
  `user2_id` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`match_id`),
  KEY `user_match_user_id_foreign` (`match_id`),
  KEY `user_match_user1_id_foreign` (`user1_id`),
  KEY `user_match_user2_id_foreign` (`user2_id`),
  CONSTRAINT `user_match_user1_id_foreign` FOREIGN KEY (`user1_id`) REFERENCES `users` (`id`),
  CONSTRAINT `user_match_user2_id_foreign` FOREIGN KEY (`user2_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matches_users`
--

LOCK TABLES `matches_users` WRITE;
/*!40000 ALTER TABLE `matches_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `matches_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `replies`
--

DROP TABLE IF EXISTS `replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `replies` (
  `idreply` int(11) NOT NULL,
  `idcomment` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reply` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`idreply`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `replies`
--

LOCK TABLES `replies` WRITE;
/*!40000 ALTER TABLE `replies` DISABLE KEYS */;
/*!40000 ALTER TABLE `replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(10) NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Esteban Raffo','e.fraffo@gmail.com','$2y$10$B4c2nOJQkV7TDHA2lxBnS.PSdFAtvnB6K7nZaPg89XGJFS4mCa4dy',31,'01166880926','Argentina','http://www.facebook.com/e.fraffo','Busco gente para practicar inglés.','M','Inglés',2,NULL,NULL),(2,'Raul Perez','raul@hotmail.com','$2y$10$crKQdoCND6tHU5v459z5XOEDHChq7BgoKDuQc2Xgyy1.rYLCON5yG',25,'1122-3344','Argentina','http://www.facebook.com/raul','busco gente para practicar Italiano y Frances','M','Ruso',2,NULL,NULL),(3,'Cacho Castaña','cacho@hotmail.com','$2y$10$MpZh1jaTUq8uiTiXoSzL8upEKjVLaWsntQfc014Ex.nOlez22tdny',20,'1122-0033','Brasil','http://www.facebook.com/cacho','Busco gente para hablar ingles','O','Inglés',2,NULL,NULL),(4,'Rodolfo Perez','rodolfo@hotmail.com','$2y$10$YvHmgESp/rwYAATSoGIWmOPlBJNCZ/m4iZp7rcvGmAkuegJdWe8YS',6,'2233-4466','Colombia','http://www.facebook.com/rodolfo','Busco gente para practicar frances.','M','Frances',2,NULL,NULL),(6,'Mamarracho Perez','mamaracho@hotmail.com','$2y$10$ARJrzia0FZ3jil5FKTx2Ie466XN0nALtXP5ttUOcdRelVWEnhvYkW',88,'3344-5566','0','http://www.facebook.com/mamaracho','Hola que tal','M','Aleman',2,NULL,NULL),(8,'Administrador','admin@admin.com','$2y$10$CeFFG400yssdp70agHEqqODjHlqFLNbg2fwdAuIO3QFMSMaL9e/ue',30,'','Argentina','','','O','0',1,NULL,NULL),(9,'Myriam Bregman','myriam@hotmail.com','$2y$10$NklmuWbAQSvy7pXJhybD5uifj34goL7X//oqqvjLvD4a49HnFxMeG',40,'1122-0033','Argentina','http://www.facebook.com/myriam','myriam presidente !','F','Ruso',2,NULL,NULL),(10,'Nicolas Del CaÃ±o','nico@hotmail.com','$2y$10$HJq/YcM.nX1HGaiK4kit/OquedjJpSyc7uDow9hi2rAiwkI1Dr7PG',40,'2222-3333','Argentina','http://www.facebook.com/nico','hola','','',2,NULL,NULL);
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

-- Dump completed on 2018-09-07 13:28:26
