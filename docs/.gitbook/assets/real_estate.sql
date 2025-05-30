CREATE DATABASE  IF NOT EXISTS `real_estate` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `real_estate`;
-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: real_estate
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

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
-- Table structure for table `apartment`
--

DROP TABLE IF EXISTS `apartment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint(20) unsigned DEFAULT NULL,
  `size` int(10) unsigned NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `age` int(10) unsigned DEFAULT NULL,
  `rooms` int(10) unsigned DEFAULT NULL,
  `bathrooms` int(10) unsigned DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `elevator` tinyint(1) NOT NULL DEFAULT 0,
  `balcony` tinyint(1) NOT NULL DEFAULT 0,
  `parking` tinyint(1) NOT NULL DEFAULT 0,
  `private_garden` tinyint(1) NOT NULL DEFAULT 0,
  `central_air_conditioning` tinyint(1) NOT NULL DEFAULT 0,
  `virtual_tour_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apartment_seller_id_foreign` (`seller_id`),
  CONSTRAINT `apartment_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartment`
--

LOCK TABLES `apartment` WRITE;
/*!40000 ALTER TABLE `apartment` DISABLE KEYS */;
INSERT INTO `apartment` VALUES (1,3,70,250000.00,'5th Avenue','New York',5,3,2,'5551559528','2023-08-16 13:03:40','2024-01-10 14:03:40',1,0,0,1,1,'tours/1'),(3,7,100,450000.00,'Market Street','San Francisco',2,4,2,'5556563190','2021-08-16 00:13:43','2022-07-12 00:13:43',0,1,1,0,0,'tours/3'),(4,2,80,350000.00,'Sunset Blvd','Los Angeles',8,3,2,'5559065021','2024-08-14 17:48:45','2024-10-09 17:48:45',1,1,0,0,1,'tours/4'),(5,3,120,550000.00,'Ocean Drive','Miami',3,4,3,'5551566853','2023-08-15 11:47:17','2024-01-10 12:47:17',1,0,0,1,1,'tours/5'),(6,5,65,200000.00,'Main Street','Houston',12,2,2,'5554068684','2022-08-15 04:58:49','2023-04-11 05:58:49',0,0,1,1,0,'tours/6'),(7,7,90,280000.00,'Central Ave','Phoenix',7,3,2,'5556570515','2021-08-14 22:33:51','2022-07-10 22:33:51',0,1,1,0,0,'tours/7'),(8,2,45,120000.00,'Chestnut St','Philadelphia',15,1,1,'5559072346','2024-08-13 16:08:53','2024-10-09 16:08:53',1,1,0,0,1,'tours/8'),(9,3,95,400000.00,'Pine Street','Seattle',4,3,2,'5551574177','2023-08-14 09:43:54','2024-01-09 10:43:54',1,0,0,1,1,NULL),(19,7,1200,720000.00,'200 Maple Ave','Ottawa',28,1,2,'5556592488','2025-03-11 12:47:49','2025-03-11 12:47:49',0,1,1,0,0,NULL),(20,2,950,850000.00,'300 Pine Rd','Vancouver',5,3,2,'5559094319','2024-08-10 11:09:15','2025-03-11 12:47:49',1,1,0,0,1,NULL),(21,3,1100,1200000.00,'400 Oak Dr','Calgary',13,4,3,'5551596150','2023-08-11 04:44:17','2025-03-11 12:47:49',1,0,0,1,1,NULL),(23,7,1000,750000.00,'600 Cedar Ct','Winnipeg',28,1,2,'5556599812','2021-08-10 15:54:21','2025-03-11 12:47:49',0,1,1,0,0,NULL),(24,2,950,635000.00,'700 Willow Way','Halifax',5,3,2,'5559101643','2024-08-09 09:29:23','2025-03-11 12:47:49',1,1,0,0,1,NULL),(25,3,1200,1100000.00,'800 Maple Crescent','Quebec City',13,4,3,'5551603474','2023-08-10 03:04:24','2025-03-11 12:47:49',1,0,0,1,1,NULL),(27,7,850,715000.00,'1000 Elm Lane','Kitchener',28,1,2,'5556607137','2021-08-09 14:14:28','2025-03-11 12:47:49',0,1,1,0,0,NULL),(28,2,1100,835000.00,'1100 Oak Place','Windsor',5,3,2,'5559108968','2024-08-08 07:49:30','2025-03-11 12:47:49',1,1,0,0,1,NULL),(29,3,1050,630000.00,'1200 Birch Terrace','Hamilton',13,4,3,'5551610799','2025-03-11 12:47:49','2025-03-11 12:47:49',1,0,0,1,1,NULL),(31,7,1000,765000.00,'1400 Willow Drive','Brampton',28,1,2,'5556614461','2021-08-08 12:34:36','2025-05-02 14:50:09',0,1,1,0,0,'tours/31'),(32,2,1200,1350000.00,'1500 Maple Grove','Markham',5,3,2,'5559116292','2024-08-07 06:09:38','2025-03-11 12:47:49',1,1,0,0,1,NULL),(33,3,950,710000.00,'1600 Pine Way','Surrey',13,4,3,'5551618123','2023-08-07 23:44:40','2025-03-11 12:47:49',1,0,0,1,1,NULL),(35,7,1000,1180000.00,'1800 Oakwood Blvd','Burnaby',28,1,2,'5556621785','2021-08-07 10:54:43','2025-03-11 12:47:49',0,1,1,0,0,NULL),(36,2,1100,580000.00,'1900 Birchwood Ct','Regina',5,3,2,'5559123616','2025-03-11 12:47:49','2025-03-11 12:47:49',1,1,0,0,1,NULL),(37,3,950,675000.00,'2000 Cedarwood Dr','Saskatoon',13,4,3,'5551625447','2023-08-06 22:04:47','2025-03-11 12:47:49',1,0,0,1,1,NULL),(39,7,2500,500000.00,'Sayed Hamdy','Cairo',3,5,3,'01002345678','2021-08-06 09:14:51','2025-03-12 10:40:45',0,1,1,0,0,NULL),(41,3,5000,1200000.00,'Maged Fady','Cairo',1,5,3,'5551632772','2023-08-05 20:24:54','2025-03-14 11:26:36',1,0,0,1,1,NULL),(42,7,20000,500000.00,'Ahmed street','Cairo',5,3,4,'0111111111','2025-05-02 14:51:20','2025-05-02 14:51:20',1,0,0,0,0,'tours/42');
/*!40000 ALTER TABLE `apartment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartment_images`
--

DROP TABLE IF EXISTS `apartment_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartment_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `apartment_id` bigint(20) unsigned NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apartment_id` (`apartment_id`),
  CONSTRAINT `apartment_images_ibfk_1` FOREIGN KEY (`apartment_id`) REFERENCES `apartment` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartment_images`
--

LOCK TABLES `apartment_images` WRITE;
/*!40000 ALTER TABLE `apartment_images` DISABLE KEYS */;
INSERT INTO `apartment_images` VALUES (1,1,'photo-1555636222-cae831e670b3.avif',NULL,NULL),(3,3,'photo-1416331108676-a22ccb276e35.avif',NULL,NULL),(4,4,'photo-1512915922686-57c11dde9b6b.avif',NULL,NULL),(5,5,'photo-1564013799919-ab600027ffc6.avif',NULL,NULL),(6,6,'photo-1570129477492-45c003edd2be.avif',NULL,NULL),(7,7,'photo-1580587771525-78b9dba3b914.avif',NULL,NULL),(8,8,'photo-1582268611958-ebfd161ef9cf.avif',NULL,NULL),(9,9,'photo-1592595896551-12b371d546d5.avif',NULL,NULL),(26,1,'photo-1555636222-cae831e670b3.avif',NULL,NULL),(28,3,'photo-1416331108676-a22ccb276e35.avif',NULL,NULL),(29,4,'photo-1512915922686-57c11dde9b6b.avif',NULL,NULL),(30,5,'photo-1564013799919-ab600027ffc6.avif',NULL,NULL),(31,6,'photo-1570129477492-45c003edd2be.avif',NULL,NULL),(32,7,'photo-1580587771525-78b9dba3b914.avif',NULL,NULL),(33,8,'photo-1582268611958-ebfd161ef9cf.avif',NULL,NULL),(34,9,'photo-1592595896551-12b371d546d5.avif',NULL,NULL),(42,41,'kitchen.jpg','2025-03-14 11:57:51','2025-03-14 11:57:51'),(53,39,'Screenshot 2024-11-08 125907.png','2025-03-14 23:51:20','2025-03-14 23:51:20'),(54,41,'maximizing-bathroom-space-hero-mobile_1.jpeg','2025-03-21 10:55:16','2025-03-21 10:55:16'),(55,42,'download (1).jpg','2025-05-02 14:51:20','2025-05-02 14:51:20');
/*!40000 ALTER TABLE `apartment_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `average_prices`
--

DROP TABLE IF EXISTS `average_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `average_prices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(255) NOT NULL,
  `avg_price_per_sqft` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `average_prices`
--

LOCK TABLES `average_prices` WRITE;
/*!40000 ALTER TABLE `average_prices` DISABLE KEYS */;
INSERT INTO `average_prices` VALUES (1,'Cairo',208.33,'2025-03-03 13:27:50','2025-03-03 13:27:50'),(2,'Chicago',2727.27,'2025-03-03 13:27:50','2025-03-03 13:27:50'),(3,'Dallas',2933.33,'2025-03-03 13:27:50','2025-03-03 13:27:50'),(4,'Houston',3076.92,'2025-03-03 13:27:50','2025-03-03 13:27:50'),(5,'Los Angeles',4375.00,'2025-03-03 13:27:50','2025-03-03 13:27:50'),(6,'Miami',4583.33,'2025-03-03 13:27:50','2025-03-03 13:27:50'),(7,'New York',3571.43,'2025-03-03 13:27:50','2025-03-03 13:27:50'),(8,'Philadelphia',2666.67,'2025-03-03 13:27:50','2025-03-03 13:27:50'),(9,'Phoenix',3111.11,'2025-03-03 13:27:50','2025-03-03 13:27:50'),(10,'San Francisco',4500.00,'2025-03-03 13:27:50','2025-03-03 13:27:50'),(11,'Seattle',4210.53,'2025-03-03 13:27:50','2025-03-03 13:27:50');
/*!40000 ALTER TABLE `average_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookmarks`
--

DROP TABLE IF EXISTS `bookmarks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookmarks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `apartment_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bookmarks_user_id_foreign` (`user_id`),
  KEY `bookmarks_apartment_id_foreign` (`apartment_id`),
  CONSTRAINT `bookmarks_apartment_id_foreign` FOREIGN KEY (`apartment_id`) REFERENCES `apartment` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookmarks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookmarks`
--

LOCK TABLES `bookmarks` WRITE;
/*!40000 ALTER TABLE `bookmarks` DISABLE KEYS */;
INSERT INTO `bookmarks` VALUES (171,3,1,'2025-03-17 13:25:43','2025-03-17 13:25:43'),(175,7,36,'2025-03-31 15:57:46','2025-03-31 15:57:46'),(176,7,4,'2025-03-31 19:34:43','2025-03-31 19:34:43');
/*!40000 ALTER TABLE `bookmarks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inquiries`
--

DROP TABLE IF EXISTS `inquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inquiries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint(20) unsigned DEFAULT NULL,
  `apartment_id` bigint(20) unsigned NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_inquiries_buyer_id` (`buyer_id`),
  KEY `fk_inquiries_apartment_id` (`apartment_id`),
  CONSTRAINT `fk_inquiries_apartment_id` FOREIGN KEY (`apartment_id`) REFERENCES `apartment` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_inquiries_buyer_id` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inquiries`
--

LOCK TABLES `inquiries` WRITE;
/*!40000 ALTER TABLE `inquiries` DISABLE KEYS */;
INSERT INTO `inquiries` VALUES (1,2,39,'Amr','amrahmed119@gmail.com','01151335569','I am interested in property ID: 39. Please provide more information.','2025-03-28 22:05:39','2025-03-28 22:05:39'),(2,2,39,'Amr','amrahmed119@gmail.com','01151335569','I am interested in property ID: 39. Please provide more information.','2025-03-28 22:07:40','2025-03-28 22:07:40'),(3,2,39,'Amr','amrahmed119@gmail.com','01151335569','I am interested in property ID: 39. Please provide more information.','2025-03-28 22:08:12','2025-03-28 22:08:12'),(4,2,39,'Amr','amrahmed119@gmail.com','213423542345','I am interested in property ID: 39. Please provide more information.','2025-03-28 22:23:52','2025-03-28 22:23:52'),(5,2,39,'Amr','amrahmed119@gmail.com','123456456','I am interested in property ID: 39. Please provide more information.','2025-03-28 22:39:34','2025-03-28 22:39:34'),(6,2,39,'Amr','amrahmed119@gmail.com','2345234653654','I am interested in property ID: 39. Please provide more information.','2025-03-28 22:42:26','2025-03-28 22:42:26'),(7,2,39,'Amr','amrahmed119@gmail.com','245633456','I am interested in property ID: 39. Please provide more information.','2025-03-29 09:39:21','2025-03-29 09:39:21'),(8,2,39,'Amr','amrahmed119@gmail.com','245633456','I am interested in property ID: 39. Please provide more information.','2025-03-29 09:42:13','2025-03-29 09:42:13'),(9,2,39,'Amr','amrahmed119@gmail.com','34563456734657','I am interested in property ID: 39. Please provide more information.','2025-03-29 09:42:36','2025-03-29 09:42:36'),(10,2,39,'Amr','amrahmed119@gmail.com','2343425634657','I am interested in property ID: 39. Please provide more information.','2025-03-29 09:46:26','2025-03-29 09:46:26'),(11,2,39,'Amr','amrahmed119@gmail.com','234563456','I am interested in property ID: 39. Please provide more information.','2025-03-29 09:48:28','2025-03-29 09:48:28'),(12,2,39,'Amr','amrahmed119@gmail.com','34535467','I am interested in property ID: 39. Please provide more information.','2025-03-29 09:52:30','2025-03-29 09:52:30'),(13,2,39,'Amr','amrahmed119@gmail.com','2345345634567','I am interested in property ID: 39. Please provide more information.','2025-03-29 09:53:22','2025-03-29 09:53:22'),(14,2,39,'Amr','amrahmed119@gmail.com','23452456657','I am interested in property ID: 39. Please provide more information.','2025-03-29 09:56:58','2025-03-29 09:56:58'),(15,2,39,'Amr','amrahmed119@gmail.com','34567547365467','I am interested in property ID: 39. Please provide more information.','2025-03-29 10:00:44','2025-03-29 10:00:44'),(16,2,39,'Amr','amrahmed119@gmail.com','345665433465','I am interested in property ID: 39. Please provide more information.','2025-03-29 10:21:52','2025-03-29 10:21:52'),(17,2,39,'Amr','amrahmed119@gmail.com','23456364535476','I am interested in property ID: 39. Please provide more information.','2025-03-29 13:10:41','2025-03-29 13:10:41'),(18,2,39,'Amr','amrahmed119@gmail.com','63345674657','I am interested in property ID: 39. Please provide more information.','2025-03-29 13:14:09','2025-03-29 13:14:09'),(19,2,39,'Amr','amrahmed119@gmail.com','436534653465435','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:12:31','2025-03-29 19:12:31'),(20,2,39,'Amr','amrahmed119@gmail.com','436534653465435','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:13:31','2025-03-29 19:13:31'),(21,2,39,'Amr','amrahmed119@gmail.com','436534653465435','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:14:23','2025-03-29 19:14:23'),(22,2,39,'Amr','amrahmed119@gmail.com','435643653465','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:14:35','2025-03-29 19:14:35'),(23,2,39,'Amr','amrahmed119@gmail.com','6666575764','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:15:10','2025-03-29 19:15:10'),(24,2,39,'Amr','amrahmed119@gmail.com','654334653654','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:22:28','2025-03-29 19:22:28'),(25,2,39,'Amr','amrahmed119@gmail.com','654334653654','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:25:01','2025-03-29 19:25:01'),(26,2,39,'Amr','amrahmed119@gmail.com','345643566435','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:31:43','2025-03-29 19:31:43'),(27,2,39,'Amr','amrahmed119@gmail.com','342554365643','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:32:23','2025-03-29 19:32:23'),(28,2,39,'Amr','amrahmed119@gmail.com','65454674657','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:35:44','2025-03-29 19:35:44'),(29,2,39,'Amr','amrahmed119@gmail.com','43653465736547','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:36:41','2025-03-29 19:36:41'),(30,2,39,'Amr','amrahmed119@gmail.com','43653465736547','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:37:06','2025-03-29 19:37:06'),(31,2,39,'Amr','amrahmed119@gmail.com','45365466547','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:42:48','2025-03-29 19:42:48'),(32,2,39,'Amr','amrahmed119@gmail.com','45365466547','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:43:11','2025-03-29 19:43:11'),(33,2,39,'Amr','amrahmed119@gmail.com','45365466547','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:45:50','2025-03-29 19:45:50'),(34,2,39,'Amr','amrahmed119@gmail.com','45365466547','I am interested in property ID: 39. Please provide more information.','2025-03-29 19:46:39','2025-03-29 19:46:39'),(35,2,39,'Amr','amrahmed119@gmail.com','665475476','I am interested in property ID: 39. Please provide more information.','2025-03-30 08:39:10','2025-03-30 08:39:10'),(36,2,39,'Amr','amrahmed119@gmail.com','3546346536542','I am interested in property ID: 39. Please provide more information.','2025-03-30 08:45:27','2025-03-30 08:45:27'),(37,2,39,'Amr','amrahmed119@gmail.com','25436664','I am interested in property ID: 39. Please provide more information.','2025-03-30 08:47:03','2025-03-30 08:47:03'),(38,2,39,'Amr','amrahmed119@gmail.com','4534654356','I am interested in property ID: 39. Please provide more information.','2025-03-30 08:49:25','2025-03-30 08:49:25'),(39,2,39,'Amr','amrahmed119@gmail.com','56745764576','I am interested in property ID: 39. Please provide more information.','2025-03-30 08:51:28','2025-03-30 08:51:28'),(40,2,39,'Amr','amrahmed119@gmail.com','3425326543465','I am interested in property ID: 39. Please provide more information.','2025-03-30 09:02:47','2025-03-30 09:02:47'),(41,2,39,'Amr','amrahmed119@gmail.com','3456364537654','I am interested in property ID: 39. Please provide more information.','2025-03-30 09:06:06','2025-03-30 09:06:06'),(42,2,39,'Amr','amrahmed119@gmail.com','3456364537654','I am interested in property ID: 39. Please provide more information.','2025-03-30 09:14:42','2025-03-30 09:14:42');
/*!40000 ALTER TABLE `inquiries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_02_20_195150_create_apartments_table',1),(5,'2025_02_21_000826_create_bookmarks_table',1),(6,'2025_02_28_212525_add_seller_id_to_apartment_table',2),(7,'2025_03_01_184409_add_role_to_users_table',3),(8,'2025_03_01_202314_add_phone_to_apartment_table',4),(9,'2025_03_02_140816_add_image_url_to_apartment_table',5),(10,'2025_03_03_130106_create_average_prices_table',6),(11,'2025_03_13_165705_add_update_at_to_apartment_images_table',7),(12,'2025_04_23_153134_add_virtual_tour_path_to_apartment_table',8),(13,'2025_05_01_132051_rename_virutal_tour_path_to_virtual_tour_path',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('Pe6U3xq4sU71z1aAXyaGxYAJsh80UFY2GF1NXCS2',7,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWW5pblExcmN6dE05Q1BKNnR0WkQ3VFl6NFhyTldzb3FNWjhRTWNFcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9wZXJ0eS80MiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==',1746208280);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'buyer',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@example.com','2025-02-27 17:48:47','$2y$12$9YAtVyVbNSu6c6neESKVpusbYH.0OiKUUMX2SmE3Uz5mp5fJW7MvG','seller','3SH5AZi98n','2025-02-27 17:48:47','2025-02-27 17:48:47'),(2,'Amr','amr@example.com',NULL,'$2y$12$PnFHZTxAnDOwXC9hrmPCUOXdtJxL01NbIXNgl8pUPTUOKnJZ8KIqW','seller',NULL,'2025-02-28 17:08:53','2025-02-28 17:08:53'),(3,'Sondos','amr1@example.com',NULL,'$2y$12$Q9bLQrOPSx/s23yxE3td5.WKX4gaB21pijDJC0/7i7E88fnwz0HxO','seller',NULL,'2025-03-01 19:50:33','2025-03-01 19:50:33'),(4,'Sayed','SayedAhmed1999@gmail.com',NULL,'$2y$12$SWftUnb.M2gvi3cvXHzdbOqD4s8.uhfnUDAVz/3v0YGtpxQXyZGvW','seller',NULL,'2025-03-03 17:57:19','2025-03-03 17:57:19'),(5,'Ahmed','ahmed@example.com',NULL,'$2y$12$KIObUEgZO3CMn5Q7TF06E..zVxalpSr6iIFoUCumXPDKFDor6.IZ6','seller',NULL,'2025-03-30 09:55:05','2025-03-30 09:55:05'),(6,'Maha','maha@example.com',NULL,'$2y$12$uRuggrgwvMamoc5W23mXZOcquzYwaDkUX2RRgeVfndKjyv2BxRW4.','seller',NULL,'2025-03-30 09:55:33','2025-03-30 09:55:33'),(7,'Marwa','marwa@example.com',NULL,'$2y$12$kmtsKoRT9Ts5SCWZtBxK3.GP7UBA6JDtJD48Khn7pkbzVi.OJEIk2','seller',NULL,'2025-03-30 09:55:58','2025-03-30 09:55:58');
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

-- Dump completed on 2025-05-03 19:06:15
