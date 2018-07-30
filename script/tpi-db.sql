-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: laravel-database
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
-- Table structure for table `actor_episode`
--

DROP DATABASE IF EXISTS tpi_db;
CREATE DATABASE tpi_db;
USE tpi_db;


--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `rating` decimal(3,1) unsigned NOT NULL,
  `awards` int(10) unsigned NOT NULL DEFAULT '0',
  `release_date` datetime NOT NULL,
  `length` int(10) unsigned DEFAULT NULL,
  `genre_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `movies_genre_id_foreign` (`genre_id`),
  CONSTRAINT `movies_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movies`
--

LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;
INSERT INTO `movies` VALUES (1,NULL,NULL,'Avatar',7.9,3,'2010-10-04 00:00:00',120,5),(2,NULL,NULL,'Titanic',7.7,11,'1997-09-04 00:00:00',320,3),(3,NULL,NULL,'La Guerra de las galaxias: Episodio VI',9.1,7,'2004-07-04 00:00:00',NULL,5),(4,NULL,NULL,'La Guerra de las galaxias: Episodio VII',9.0,6,'2003-11-04 00:00:00',180,5),(5,NULL,NULL,'Parque Jurasico',8.3,5,'1999-01-04 00:00:00',270,5),(6,NULL,NULL,'Harry Potter y las Reliquias de la Muerte - Parte 2',9.0,2,'2008-07-04 00:00:00',190,6),(7,NULL,NULL,'Transformers: el lado oscuro de la luna',0.9,1,'2005-07-04 00:00:00',NULL,5),(8,NULL,NULL,'Harry Potter y la piedra filosofal',10.0,1,'2008-04-04 00:00:00',120,8),(9,NULL,NULL,'Harry Potter y la cámara de los secretos',3.5,2,'2009-08-04 00:00:00',200,8),(10,NULL,NULL,'El rey león',9.1,3,'2000-02-04 00:00:00',NULL,10),(11,NULL,NULL,'Alicia en el país de las maravillas',5.7,2,'2008-07-04 00:00:00',120,NULL),(12,NULL,NULL,'Buscando a Nemo',8.3,2,'2000-07-04 00:00:00',110,7),(13,NULL,NULL,'Toy Story',6.1,0,'2008-03-04 00:00:00',150,7),(14,NULL,NULL,'Toy Story 2',3.2,2,'2003-04-04 00:00:00',120,7),(15,NULL,NULL,'La vida es bella',8.3,5,'1994-10-04 00:00:00',NULL,3),(16,NULL,NULL,'Mi pobre angelito',3.2,1,'1989-01-04 00:00:00',120,1),(17,NULL,NULL,'Intensamente',9.0,2,'2008-07-04 00:00:00',120,7),(18,NULL,NULL,'Carrozas de fuego',9.9,7,'1980-07-04 00:00:00',180,NULL),(19,NULL,NULL,'Big',7.3,2,'1988-02-04 00:00:00',130,8),(20,NULL,NULL,'I am Sam',9.0,4,'1999-03-04 00:00:00',130,3),(21,NULL,NULL,'Hotel Transylvania',7.1,1,'2012-05-04 00:00:00',90,10);
/*!40000 ALTER TABLE `movies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `actors`
--

DROP TABLE IF EXISTS `actors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rating` decimal(3,1) DEFAULT NULL,
  `favorite_movie_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `actors_favorite_movie_id_foreign` (`favorite_movie_id`),
  CONSTRAINT `actors_favorite_movie_id_foreign` FOREIGN KEY (`favorite_movie_id`) REFERENCES `movies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actors`
--

LOCK TABLES `actors` WRITE;
/*!40000 ALTER TABLE `actors` DISABLE KEYS */;
INSERT INTO `actors` VALUES (1,NULL,NULL,'Sam','Worthington',7.5,1),(2,NULL,NULL,'Zoe','Saldana',5.5,2),(3,NULL,NULL,'Sigourney','Weaver',9.7,NULL),(4,NULL,NULL,'Leonardo','Di Caprio',3.5,4),(5,NULL,NULL,'Kate','Winslet',1.5,5),(6,NULL,NULL,'Billy','Zane',7.5,6),(7,NULL,NULL,'Mark','Hamill',6.5,7),(8,NULL,NULL,'Harrison','Ford',7.5,8),(9,NULL,NULL,'Carrie','Fisher',7.5,9),(10,NULL,NULL,'Sam','Neill',2.5,10),(11,NULL,NULL,'Laura','Dern',7.5,11),(12,NULL,NULL,'Jeff','Goldblum',4.5,NULL),(13,NULL,NULL,'Daniel','Radcliffe',7.5,13),(14,NULL,NULL,'Emma','Watson',2.5,14),(15,NULL,NULL,'Rupert','Grint',6.2,15),(16,NULL,NULL,'Shia','LaBeouf',9.5,16),(17,NULL,NULL,'Rosie','Huntington-Whiteley',1.5,17),(18,NULL,NULL,'Matthew','Broderick',6.1,18),(19,NULL,NULL,'James','Earl Jones',7.5,19),(20,NULL,NULL,'Jeremy','Irons',7.2,20),(21,NULL,NULL,'Johnny','Depp',1.5,21),(22,NULL,NULL,'Helena','Bonham Carter',7.5,1),(23,NULL,NULL,'Mia','Wasikowska',7.5,2),(24,NULL,NULL,'Albert','Brooks',2.5,3),(25,NULL,NULL,'Ellen','DeGeneres',2.6,4),(26,NULL,NULL,'Alexander','Gould',7.5,5),(27,NULL,NULL,'Tom','Hanks',4.4,6),(28,NULL,NULL,'Tim','Allen',7.5,7),(29,NULL,NULL,'Sean','Penn',9.2,8),(30,NULL,NULL,'Adam','Sandler',3.1,9),(31,NULL,NULL,'Renee','Zellweger',9.5,10),(32,NULL,NULL,'Emilia','Clarke',8.2,11),(33,NULL,NULL,'Peter','Dinklage',2.3,12),(34,NULL,NULL,'Kit','Harington',2.4,NULL),(35,NULL,NULL,'Jared','Padalecki',2.8,14),(36,NULL,NULL,'Jensen','Ackles',5.5,15),(37,NULL,NULL,'Jim','Beaver',2.6,16),(38,NULL,NULL,'Andrew','Lincoln',3.3,17),(39,NULL,NULL,'Jon','Bernthal',2.9,NULL),(40,NULL,NULL,'Sarah','Callies',2.4,19),(41,NULL,NULL,'Jim','Caviezel',1.9,20),(42,NULL,NULL,'Taraji','Henson',5.9,21),(43,NULL,NULL,'Kevin','Chapman',2.9,1),(44,NULL,NULL,'Johnny','Galecki',2.3,2),(45,NULL,NULL,'Jim','Parsons',6.9,3),(46,NULL,NULL,'Kaley','Cuoco',2.3,4),(47,NULL,NULL,'Bryan','Cranston',7.9,NULL),(48,NULL,NULL,'Aaron','Paul',5.9,6),(49,NULL,NULL,'Anna','Gunn',3.1,7);
/*!40000 ALTER TABLE `actors` ENABLE KEYS */;
UNLOCK TABLES;



