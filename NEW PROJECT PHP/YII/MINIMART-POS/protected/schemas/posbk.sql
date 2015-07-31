-- MySQL dump 10.13  Distrib 5.5.34, for Linux (x86_64)
--
-- Host: localhost    Database: pos
-- ------------------------------------------------------
-- Server version	5.5.34

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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pos` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `pos`;
--
-- Table structure for table `accountorders`
--

DROP TABLE IF EXISTS `accountorders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accountorders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Order Id default is dummy order id',
  `ordertask_id` int(10) unsigned NOT NULL DEFAULT '0',
  `addnlinfo` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'addnl like consignment number',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accountorders`
--

LOCK TABLES `accountorders` WRITE;
/*!40000 ALTER TABLE `accountorders` DISABLE KEYS */;
/*!40000 ALTER TABLE `accountorders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accountpurchases`
--

DROP TABLE IF EXISTS `accountpurchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accountpurchases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `purchase_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'purchase id',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accountpurchases`
--

LOCK TABLES `accountpurchases` WRITE;
/*!40000 ALTER TABLE `accountpurchases` DISABLE KEYS */;
/*!40000 ALTER TABLE `accountpurchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'INVOICE' COMMENT 'INVOICE, CREDIT, SERVICECHARGE',
  `acnt_date` datetime DEFAULT NULL COMMENT 'invoice date',
  `acnt_no` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT 'INVOICE Number',
  `accounttype` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT 'Receivables' COMMENT 'Receivables, Payables',
  `person_id` int(10) unsigned NOT NULL COMMENT 'employee id who created this record, id in person table',
  `party_id` int(10) unsigned NOT NULL COMMENT 'customer/contractor id, id in person table',
  `amount` decimal(10,2) NOT NULL COMMENT 'total amount + plus tax amount for order_id',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'bill discount',
  `scamount` decimal(10,2) DEFAULT '0.00' COMMENT 'surcharge',
  `paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'paid amount total of payments for this id',
  `status` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'PENDING' COMMENT 'PENDING,CLOSED',
  `remarks` varchar(256) COLLATE utf8_bin DEFAULT NULL COMMENT 'Remarks',
  `closed_at` datetime DEFAULT NULL COMMENT 'fully paid date',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL,
  `name` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'category name',
  `desc` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'description',
  `imagepath` varchar(1024) COLLATE utf8_bin DEFAULT NULL COMMENT 'image file path',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'status 1-active 0-inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,0,'Miscellaneous Category','Miscellaneous Category',NULL,1),(3,0,'Groceries','Groceries',NULL,1),(4,0,'Beverages','Beverages',NULL,1),(5,1,'General Category','General Category',NULL,1),(7,0,'Household Items','Household Items','',1),(8,3,'Snacks & Confections','Snacks & Confections','',1),(11,3,'Frozen Food','Frozen Food','',1),(12,4,'Dairy Products','Dairy Products','',1),(13,3,'Dairy Products','Dairy Products','',1),(16,3,'Sweets','Sweets','',1),(17,3,'Fruits','Fruits','',1),(18,3,'Grains','Grains','',1),(19,3,'Meat','Meat','',1),(20,3,'Vegetables','Vegetables','',1),(21,0,'Necessities','Necessities','',1),(22,21,'Toiletries','Toiletries','',1),(23,21,'Personal Care','Personal Care','',1),(24,7,'Washing Products','Washing Products','',1),(25,7,'Pest Control','Pest Control','',1),(26,0,'Medication','Medication','',1),(27,7,'Cleaning Products','Cleaning Products','',1),(28,7,'Hygiene Products','Hygiene Products','',1),(29,0,'Fabric Products','Fabric Products','',1),(30,4,'Can Drinks','Can Drinks','',1),(31,4,'Alcoholic Drinks','Alcoholic Drinks','',1),(32,4,'Bottle Drinks','Bottle Drinks','',1),(33,1,'Stationeries','Stationeries','',1),(34,1,'Toys','Toys','',1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `name` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'company name',
  `website` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'company website',
  `address` text COLLATE utf8_bin COMMENT 'company address',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'status 1-active 0-inactive',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`website`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'PoS','pos.com',NULL,1,'0000-00-00 00:00:00','2014-08-22 05:03:14');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configs`
--

DROP TABLE IF EXISTS `configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `config_key` varchar(128) NOT NULL,
  `config_val` varchar(64) NOT NULL,
  `remarks` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configs`
--

LOCK TABLES `configs` WRITE;
/*!40000 ALTER TABLE `configs` DISABLE KEYS */;
INSERT INTO `configs` VALUES (1,'enablepplcode','1','0-manual,1-auto'),(2,'enableautopplcode','1','0-manual,1-auto'),(3,'enableautocustcode','0','0-manual,1-auto'),(4,'enableautosplrcode','0','0-manual,1-auto'),(5,'enablepplauxname','0',NULL),(6,'enablecontact','0',NULL),(7,'enablelocality','0','1 - enable 0 - disable'),(8,'enablecity','0',NULL),(9,'enablestate','0',NULL),(10,'enablecountry','0',NULL),(11,'directorder','1',NULL),(12,'directinvoice','0',NULL),(13,'moperinvoice','0','0-singleorder/invoice, 1-multiple'),(14,'daystocheckfordue','3',NULL),(15,'daystocheckforoverdue','7',NULL),(16,'enableautoordrid','1','0-manual,1-auto'),(17,'enableordername','0','0 - false,1 true'),(18,'enableordrdn','0','0-disable delivery note,1-enable'),(19,'ordercostamountfrom','1',NULL),(20,'sptype','1','0-directamount,1-percentage'),(21,'enabletax','1','1-enable,0-disable'),(22,'enablediscount','1',NULL),(23,'orderdiscfor','3','0-order,1-prd,2-task,3-orderandprd,4-orderandtask'),(24,'discentry','0','0 direct, 1 by reduced amount'),(25,'enableordrpeople','0','0 disable, 1 enable'),(26,'enableordrprd','1',NULL),(27,'enablecategory','1',NULL),(28,'enableprdcode','1','0-manual,1-auto'),(29,'enableautoprdcode','0','0-manual,1-auto'),(30,'enableprdauxname','0',NULL),(31,'enablestock','1',NULL),(32,'enablepurchase','1',NULL),(33,'enableordrtasks','0',NULL),(34,'enableinlineotentry','0',NULL),(35,'enableexpctdstartdt','0','1 expected and actual st date ma'),(36,'enableexpctdenddt','0','0 - expected end dt false,1 true'),(37,'ordertaskcostamountfrom','0',NULL),(38,'enableordrtaskpeople','0',NULL),(39,'taskppltax','0',NULL),(40,'enableordermilestones','0',NULL),(41,'enableinlinemsentry','0','0-no inline,1-inline'),(42,'enableordrpayments','1',NULL),(43,'enableinlinepayments','0','1-enable,0-disable'),(44,'accountamountfrom','1','0-from account,1-from order,2- from ordertask');
/*!40000 ALTER TABLE `configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consignmentnotes`
--

DROP TABLE IF EXISTS `consignmentnotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consignmentnotes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `person_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `notes` varchar(50) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consignmentnotes`
--

LOCK TABLES `consignmentnotes` WRITE;
/*!40000 ALTER TABLE `consignmentnotes` DISABLE KEYS */;
/*!40000 ALTER TABLE `consignmentnotes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_details`
--

DROP TABLE IF EXISTS `customer_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_details` (
  `CUSTOMER_ID` varchar(16) COLLATE utf8_bin DEFAULT NULL,
  `FIRST_NAME` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `LAST_NAME` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `BLOCK` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `STREET` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `PINCODE` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `PHONE_NO` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `HAND_PHONE` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `FAX_NO` varchar(128) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_details`
--

LOCK TABLES `customer_details` WRITE;
/*!40000 ALTER TABLE `customer_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `geolocations`
--

DROP TABLE IF EXISTS `geolocations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `geolocations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `person_id` int(10) unsigned NOT NULL,
  `lng` decimal(10,6) NOT NULL,
  `lat` decimal(10,6) NOT NULL,
  `locname` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT 'Not Given',
  `captured_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `geolocations`
--

LOCK TABLES `geolocations` WRITE;
/*!40000 ALTER TABLE `geolocations` DISABLE KEYS */;
/*!40000 ALTER TABLE `geolocations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `idmasters`
--

DROP TABLE IF EXISTS `idmasters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `idmasters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `forwhat` varchar(16) COLLATE utf8_bin NOT NULL,
  `foryear` varchar(8) COLLATE utf8_bin NOT NULL,
  `formonth` varchar(8) COLLATE utf8_bin NOT NULL,
  `lastid` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `idmasters`
--

LOCK TABLES `idmasters` WRITE;
/*!40000 ALTER TABLE `idmasters` DISABLE KEYS */;
INSERT INTO `idmasters` VALUES (1,'Order','2014','08',1,'2014-08-23 09:50:15','2014-08-23 09:50:15');
/*!40000 ALTER TABLE `idmasters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `street` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'doorno and street',
  `locality` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'area/town/something',
  `city` varchar(32) COLLATE utf8_bin DEFAULT NULL COMMENT 'city',
  `state` varchar(32) COLLATE utf8_bin DEFAULT NULL COMMENT 'state',
  `country` varchar(32) COLLATE utf8_bin DEFAULT NULL COMMENT 'country',
  `pincode` varchar(12) COLLATE utf8_bin DEFAULT NULL COMMENT 'pincode',
  `remarks` varchar(64) COLLATE utf8_bin DEFAULT NULL COMMENT 'anything like landmark etc',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loginhistories`
--

DROP TABLE IF EXISTS `loginhistories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginhistories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `login_time` datetime DEFAULT NULL COMMENT 'login time',
  `logout_time` datetime DEFAULT NULL COMMENT 'logout time',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loginhistories`
--

LOCK TABLES `loginhistories` WRITE;
/*!40000 ALTER TABLE `loginhistories` DISABLE KEYS */;
INSERT INTO `loginhistories` VALUES (1,2,3,'2014-08-22 17:31:42','2014-08-23 13:55:45','2014-08-22 09:31:42','2014-08-23 05:55:45'),(2,2,3,'2014-08-23 13:52:37','2014-08-23 13:55:45','2014-08-23 05:52:37','2014-08-23 05:55:45'),(3,2,3,'2014-08-23 13:57:48','2014-08-25 15:44:25','2014-08-23 05:57:48','2014-08-25 07:44:25'),(4,2,3,'2014-08-23 17:44:34','2014-08-25 15:44:25','2014-08-23 09:44:34','2014-08-25 07:44:25'),(5,2,3,'2014-08-23 20:44:20','2014-08-25 15:44:25','2014-08-23 12:44:20','2014-08-25 07:44:25'),(6,2,3,'2014-08-25 11:22:07','2014-08-25 15:44:25','2014-08-25 03:22:07','2014-08-25 07:44:25'),(7,2,3,'2014-08-25 15:24:29','2014-08-25 15:44:25','2014-08-25 07:24:29','2014-08-25 07:44:25'),(8,2,3,'2014-08-25 15:27:56','2014-08-25 15:44:25','2014-08-25 07:27:56','2014-08-25 07:44:25'),(9,2,3,'2014-08-26 16:07:41','2014-08-27 09:55:49','2014-08-26 08:07:41','2014-08-27 01:55:49'),(10,2,3,'2014-08-26 16:54:37','2014-08-27 09:55:49','2014-08-26 08:54:37','2014-08-27 01:55:49'),(11,2,3,'2014-08-27 09:49:55','2014-08-27 09:55:49','2014-08-27 01:49:55','2014-08-27 01:55:49'),(12,2,3,'2014-08-27 12:03:02','2014-08-27 15:57:06','2014-08-27 04:03:02','2014-08-27 07:57:06'),(13,2,3,'2014-08-27 12:17:50','2014-08-27 15:57:06','2014-08-27 04:17:50','2014-08-27 07:57:06'),(14,2,3,'2014-08-27 12:30:32','2014-08-27 15:57:06','2014-08-27 04:30:32','2014-08-27 07:57:06'),(15,2,3,'2014-08-27 15:13:58','2014-08-27 15:57:06','2014-08-27 07:13:58','2014-08-27 07:57:06'),(16,2,3,'2014-08-27 16:02:47','2014-08-27 16:05:38','2014-08-27 08:02:47','2014-08-27 08:05:38'),(17,2,3,'2014-08-28 11:12:02','2014-08-28 12:26:23','2014-08-28 03:12:02','2014-08-28 04:26:23'),(18,2,3,'2014-08-28 12:26:28','2014-08-28 12:50:07','2014-08-28 04:26:28','2014-08-28 04:50:07'),(19,2,3,'2014-08-28 12:50:17','2014-08-28 12:52:49','2014-08-28 04:50:17','2014-08-28 04:52:49'),(20,2,3,'2014-08-28 13:50:19','2014-08-28 22:42:37','2014-08-28 05:50:19','2014-08-28 14:42:37'),(21,2,3,'2014-08-28 14:22:22','2014-08-28 22:42:37','2014-08-28 06:22:22','2014-08-28 14:42:37'),(22,2,3,'2014-08-28 15:12:53','2014-08-28 22:42:37','2014-08-28 07:12:53','2014-08-28 14:42:37'),(23,2,3,'2014-08-29 10:51:24','2014-08-29 11:39:10','2014-08-29 02:51:24','2014-08-29 03:39:10'),(24,2,3,'2014-08-29 11:02:52','2014-08-29 11:39:10','2014-08-29 03:02:52','2014-08-29 03:39:10');
/*!40000 ALTER TABLE `loginhistories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logins`
--

DROP TABLE IF EXISTS `logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `login` varchar(24) COLLATE utf8_bin NOT NULL COMMENT 'user login name',
  `pass` varchar(88) COLLATE utf8_bin NOT NULL COMMENT 'user password',
  `hash_id` varchar(88) COLLATE utf8_bin NOT NULL COMMENT 'user unique hash for mobile authenticating',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'users status 1-active 0-inactive',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logins`
--

LOCK TABLES `logins` WRITE;
/*!40000 ALTER TABLE `logins` DISABLE KEYS */;
INSERT INTO `logins` VALUES (1,'su','d033e22ae348aeb5660fc2140aec35850c4da997','d033e22ae348aeb5660fc2140aec35850c4da997',1,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(2,'admin','027a5a22d5890e87be8fcfe1d4ef2a98aa7f3133$d30bd965c0e92fae88258a8defa365ea415ed907','027a5a22d5890e87be8fcfe1d4ef2a98aa7f3133$d30bd965c0e92fae88258a8defa365ea415ed907',1,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(3,'register1','c2e46f81b8d45cc2e2a384b40dc2903f5ad6df34$d30bd965c0e92fae88258a8defa365ea415ed907','c2e46f81b8d45cc2e2a384b40dc2903f5ad6df34$d30bd965c0e92fae88258a8defa365ea415ed907',1,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(4,'register2','ec4f505f7ab3ac7605204113d8330f7f027fc800$d30bd965c0e92fae88258a8defa365ea415ed907','ec4f505f7ab3ac7605204113d8330f7f027fc800$d30bd965c0e92fae88258a8defa365ea415ed907',1,'2014-08-22 05:03:08','2014-08-22 05:03:08');
/*!40000 ALTER TABLE `logins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mailqueues`
--

DROP TABLE IF EXISTS `mailqueues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mailqueues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `event_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '0-general,1-newcompany,2-newemployee,etc.,',
  `mailids` text COLLATE utf8_bin COMMENT 'csv,mail ids',
  `subject` varchar(128) COLLATE utf8_bin NOT NULL,
  `mail_body` varchar(1024) COLLATE utf8_bin NOT NULL,
  `status` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'TBD' COMMENT 'TBD,SENT,FAILED',
  `attempts` tinyint(2) NOT NULL DEFAULT '0',
  `last_attempt_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'last attempt on',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mailqueues`
--

LOCK TABLES `mailqueues` WRITE;
/*!40000 ALTER TABLE `mailqueues` DISABLE KEYS */;
/*!40000 ALTER TABLE `mailqueues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `milestones`
--

DROP TABLE IF EXISTS `milestones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `milestones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(10) unsigned NOT NULL COMMENT 'employee id who entered this record',
  `order_id` int(10) unsigned NOT NULL,
  `details` varchar(1024) COLLATE utf8_bin NOT NULL,
  `remarks` varchar(256) COLLATE utf8_bin DEFAULT '' COMMENT 'Remarks',
  `start_at` datetime DEFAULT NULL COMMENT 'expected start date',
  `end_at` datetime DEFAULT NULL COMMENT 'expected end date',
  `alertbefore` int(10) NOT NULL DEFAULT '3' COMMENT 'alert # of days before start_at/end_at',
  `completed` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'completed %',
  `completed_at` datetime DEFAULT NULL COMMENT 'actual completed date',
  `completed_remarks` varchar(1024) COLLATE utf8_bin DEFAULT NULL COMMENT 'completed remarks',
  `mailids` text COLLATE utf8_bin COMMENT 'csv,mail ids',
  `mailcount` int(10) NOT NULL DEFAULT '0' COMMENT 'number of mails sent',
  `lastmailsent_at` datetime DEFAULT NULL COMMENT 'last mail sent date',
  `started_at` datetime DEFAULT NULL COMMENT 'actual started date',
  `closed_at` datetime DEFAULT NULL COMMENT 'actual closed date',
  `status` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'OPEN' COMMENT 'CREATED, PENDING, CLOSED',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `milestones`
--

LOCK TABLES `milestones` WRITE;
/*!40000 ALTER TABLE `milestones` DISABLE KEYS */;
/*!40000 ALTER TABLE `milestones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderactionhistories`
--

DROP TABLE IF EXISTS `orderactionhistories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderactionhistories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `modifiedemp_id` int(10) unsigned NOT NULL,
  `action` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'happened action',
  `action_time` datetime DEFAULT NULL COMMENT 'happened time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderactionhistories`
--

LOCK TABLES `orderactionhistories` WRITE;
/*!40000 ALTER TABLE `orderactionhistories` DISABLE KEYS */;
/*!40000 ALTER TABLE `orderactionhistories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderaddresses`
--

DROP TABLE IF EXISTS `orderaddresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderaddresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `name` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `mobile` varchar(16) COLLATE utf8_bin DEFAULT NULL,
  `type` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'From' COMMENT 'From/Pickup,Shipping/To/Delivery',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderaddresses`
--

LOCK TABLES `orderaddresses` WRITE;
/*!40000 ALTER TABLE `orderaddresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `orderaddresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderpeople`
--

DROP TABLE IF EXISTS `orderpeople`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderpeople` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `type` varchar(12) COLLATE utf8_bin NOT NULL COMMENT 'customer,employee, created, modified',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderpeople`
--

LOCK TABLES `orderpeople` WRITE;
/*!40000 ALTER TABLE `orderpeople` DISABLE KEYS */;
/*!40000 ALTER TABLE `orderpeople` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderproductdns`
--

DROP TABLE IF EXISTS `orderproductdns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderproductdns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `order_id` int(10) unsigned NOT NULL,
  `orderproduct_id` int(10) unsigned NOT NULL,
  `quantity` int(10) NOT NULL,
  `delivered_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderproductdns`
--

LOCK TABLES `orderproductdns` WRITE;
/*!40000 ALTER TABLE `orderproductdns` DISABLE KEYS */;
/*!40000 ALTER TABLE `orderproductdns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderproducts`
--

DROP TABLE IF EXISTS `orderproducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderproducts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `order_type` varchar(12) COLLATE utf8_bin NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `productprice_id` int(10) unsigned NOT NULL,
  `quantity` int(10) NOT NULL DEFAULT '1' COMMENT 'quantity',
  `delivered` int(10) NOT NULL DEFAULT '1' COMMENT 'delivered quantity',
  `unit_sp` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'unit_sp from products *  this quantity',
  `tax` decimal(10,2) DEFAULT '0.00' COMMENT 'tax % from products applied on this amount',
  `discper` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'discount %',
  `disc` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'discount amount',
  `description` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'for unknown products without id',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderproducts`
--

LOCK TABLES `orderproducts` WRITE;
/*!40000 ALTER TABLE `orderproducts` DISABLE KEYS */;
INSERT INTO `orderproducts` VALUES (1,2,'Order',1,1,6,1,6.00,0.00,36.00,0.00,0.00,0.00,NULL,'2014-08-23 09:50:15','2014-08-23 09:50:15');
/*!40000 ALTER TABLE `orderproducts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `type` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'Order' COMMENT 'Quote,Order, Invoice,Void',
  `qoi_id` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT 'quote/order/invoice id',
  `quote_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'quotation id if type is ORDER',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'order id if type is invoice',
  `quote_qoi_id` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT 'quotation id if type is ORDER',
  `order_qoi_id` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT 'order id if type is invoice',
  `name` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'job name',
  `desc` varchar(1024) COLLATE utf8_bin DEFAULT NULL COMMENT 'description',
  `addnlinfo` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'for addnlinfo if any like consignment',
  `addnlinfo1` datetime DEFAULT NULL COMMENT 'for addnlinfo like collection time',
  `addnlinfo2` datetime DEFAULT NULL COMMENT 'for addnlinfo like collection time',
  `addnlinfo3` varchar(32) COLLATE utf8_bin DEFAULT NULL COMMENT 'for addnlinfo like servicetype',
  `addnlinfo4` varchar(32) COLLATE utf8_bin DEFAULT NULL COMMENT 'for addnlinfo like deliverytype',
  `addnlinfo5` varchar(512) COLLATE utf8_bin DEFAULT NULL COMMENT 'for surcharge services',
  `start_at` datetime DEFAULT NULL COMMENT 'expected start date',
  `end_at` datetime DEFAULT NULL COMMENT 'expected end date',
  `budget` decimal(10,2) DEFAULT '0.00' COMMENT 'expected amount',
  `cost` decimal(10,2) DEFAULT '0.00' COMMENT 'total cost of all orderproducts',
  `amount` decimal(10,2) DEFAULT '0.00' COMMENT 'total amount of all orderproducts',
  `tax` decimal(10,2) DEFAULT '0.00' COMMENT 'total tax of all orderproducts',
  `disc` decimal(10,2) DEFAULT '0.00' COMMENT 'discount amount',
  `taxper` decimal(10,2) DEFAULT '0.00' COMMENT 'total taxpercent',
  `discper` decimal(10,2) DEFAULT '0.00' COMMENT 'discount %',
  `exchange` decimal(10,2) DEFAULT '0.00' COMMENT 'total amount of all orderproducts',
  `roundoff` decimal(10,2) DEFAULT '0.00' COMMENT 'total amount of all orderproducts',
  `getbackdiscount` decimal(10,2) DEFAULT '0.00' COMMENT 'revert discount on exchange',
  `tasks` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'total no of tasks, this order has',
  `completed` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'over all completed % of all tasks',
  `status` varchar(12) COLLATE utf8_bin DEFAULT NULL COMMENT 'OPEN,PENDING,CLOSED,VOID',
  `invstatus` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'UNINVOICED' COMMENT 'UNINVOICED,INVOICED',
  `remarks` varchar(256) COLLATE utf8_bin DEFAULT '' COMMENT 'Remarks',
  `paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'paid amount total of payments for this id',
  `qutcnvrtdate` datetime DEFAULT NULL COMMENT 'quote to order or void date',
  `ordcnvrtdate` datetime DEFAULT NULL COMMENT 'order to invoice or void date',
  `started_at` datetime DEFAULT NULL COMMENT 'actual started date',
  `closed_at` datetime DEFAULT NULL COMMENT 'actual end date',
  `delivered` tinyint(1) DEFAULT '0' COMMENT 'is fully delivered',
  `enableordername` tinyint(1) DEFAULT '0' COMMENT 'enable order name',
  `enableordrprd` tinyint(1) DEFAULT '0',
  `enableordrtasks` tinyint(1) DEFAULT '0',
  `enableordrtaskpeople` tinyint(1) DEFAULT '0',
  `enableordrpayments` tinyint(1) DEFAULT '0',
  `enableordermilestones` tinyint(1) DEFAULT '0' COMMENT 'milestones enable/disable',
  `ordercostamountfrom` tinyint(1) DEFAULT '0' COMMENT '0 inline amounts,1 from lis,2 from tasks',
  `ordertaskcostamountfrom` tinyint(1) DEFAULT '0' COMMENT '0 inline task amounts,1 from taskpeople',
  `enablediscount` tinyint(1) DEFAULT '0' COMMENT 'enable discount',
  `orderdiscfor` tinyint(1) DEFAULT '0' COMMENT '0 disc order level, 1 li level, 2 task level, 3 order and li, 4 order and task',
  `customer_id` int(10) unsigned DEFAULT NULL COMMENT 'person record with role customer.',
  `created_id` int(10) unsigned DEFAULT NULL COMMENT 'person record who has loggedin',
  `modified_id` int(10) unsigned DEFAULT NULL COMMENT 'person record who has loggedin',
  `createdemp_id` int(10) unsigned DEFAULT NULL COMMENT 'assigned person record with role employee.',
  `modifiedemp_id` int(10) unsigned DEFAULT NULL COMMENT 'assigned person record with role employee.',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'Order','dummy',0,0,'-1','-1','dummy','dummy','E',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0,0.00,'1','UNINVOICED','test',0.00,NULL,NULL,NULL,NULL,0,0,0,1,0,1,1,2,0,0,0,NULL,NULL,NULL,NULL,NULL,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(2,'Order','2014/08/ODR00001',0,0,'0','0','2014/08/ODR00001',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,0.00,36.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0,0.00,'3','UNINVOICED','',36.00,NULL,NULL,NULL,NULL,0,0,1,0,0,1,0,1,0,1,3,6,1,1,1,1,'2014-08-23 09:50:15','2014-08-23 09:50:15');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordertaskpeople`
--

DROP TABLE IF EXISTS `ordertaskpeople`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordertaskpeople` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `order_type` varchar(12) COLLATE utf8_bin NOT NULL COMMENT 'QUOTE, ORDER, INVOICE',
  `ordertask_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `efforts` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'efforts in hours ',
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(10,2) DEFAULT '0.00',
  `level` int(10) NOT NULL DEFAULT '0' COMMENT 'Level number in hierarchy like employee 0, incharge1 1, incharge2 2 etc.',
  `type` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'employee' COMMENT 'employee, incharge, created, modified, external',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordertaskpeople`
--

LOCK TABLES `ordertaskpeople` WRITE;
/*!40000 ALTER TABLE `ordertaskpeople` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordertaskpeople` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordertasks`
--

DROP TABLE IF EXISTS `ordertasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordertasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `order_type` varchar(12) COLLATE utf8_bin NOT NULL,
  `task_id` int(10) unsigned NOT NULL,
  `details` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `start_at` datetime DEFAULT NULL COMMENT 'expected start date',
  `end_at` datetime DEFAULT NULL COMMENT 'expected end date',
  `started_at` datetime DEFAULT NULL COMMENT 'actual started date',
  `closed_at` datetime DEFAULT NULL COMMENT 'actual closed date',
  `completed` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'completed %',
  `completed_at` datetime DEFAULT NULL COMMENT 'on what date this %',
  `completed_remarks` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `status` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'OPEN' COMMENT 'OPEN, PENDING, CLOSED',
  `invstatus` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'UNINVOICED' COMMENT 'UNINVOICED,INVOICED',
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'cost',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'amount, this task worths',
  `taxper` decimal(10,2) DEFAULT '0.00' COMMENT 'tax percentage',
  `tax` decimal(10,2) DEFAULT '0.00' COMMENT 'calculated tax amount',
  `alertbefore` int(10) NOT NULL DEFAULT '3' COMMENT 'alert # of days before start_at/end_at',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordertasks`
--

LOCK TABLES `ordertasks` WRITE;
/*!40000 ALTER TABLE `ordertasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordertasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `otprgrshistories`
--

DROP TABLE IF EXISTS `otprgrshistories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `otprgrshistories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `order_type` varchar(12) COLLATE utf8_bin NOT NULL,
  `ordertask_id` int(10) unsigned NOT NULL,
  `completed` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'completed %',
  `completed_at` datetime DEFAULT NULL,
  `remarks` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `otprgrshistories`
--

LOCK TABLES `otprgrshistories` WRITE;
/*!40000 ALTER TABLE `otprgrshistories` DISABLE KEYS */;
/*!40000 ALTER TABLE `otprgrshistories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paymentreceipts`
--

DROP TABLE IF EXISTS `paymentreceipts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paymentreceipts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `customer_id` int(10) unsigned NOT NULL COMMENT 'customer id',
  `amount` decimal(10,2) DEFAULT NULL,
  `details` varchar(256) COLLATE utf8_bin DEFAULT NULL COMMENT 'some details if any',
  `paid_date` datetime DEFAULT NULL COMMENT 'paid date',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paymentreceipts`
--

LOCK TABLES `paymentreceipts` WRITE;
/*!40000 ALTER TABLE `paymentreceipts` DISABLE KEYS */;
/*!40000 ALTER TABLE `paymentreceipts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `person_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'employee id who entered this record',
  `account_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'account id',
  `party_id` int(10) unsigned NOT NULL COMMENT 'customer/contractor id',
  `ordertask_id` int(10) unsigned NOT NULL COMMENT 'ordertask id',
  `order_id` int(10) unsigned NOT NULL COMMENT 'order id',
  `type` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'CASH' COMMENT 'CASH only supported',
  `amount` decimal(10,2) DEFAULT NULL,
  `tendered` decimal(10,2) DEFAULT NULL,
  `balreturned` decimal(10,2) DEFAULT NULL,
  `status` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'COLLECTED' COMMENT 'OPEN,COLLECTED',
  `details` varchar(256) COLLATE utf8_bin DEFAULT NULL COMMENT 'like cheque number,bank details',
  `payment_at` datetime DEFAULT NULL COMMENT 'payment date',
  `collected_at` datetime DEFAULT NULL COMMENT 'actual payment date if other than cash',
  `direction` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT 'Inwards' COMMENT 'Inwards, Outwards',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,0,6,0,2,'Cash',36.00,50.00,14.00,'COLLECTED','','2014-08-23 17:50:15','2014-08-23 17:50:15','Inwards','2014-08-23 09:50:15','2014-08-23 09:50:15');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `people` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `code` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT 'product code',
  `name` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'primary name',
  `auxname` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'auxiliary name in diff language',
  `firstname` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'contact''s first name',
  `lastname` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'contact''s last name',
  `mobile` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT 'user mobile/phone',
  `mail` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'user mail id',
  `website` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'web site address',
  `mobile_addnls` varchar(64) COLLATE utf8_bin DEFAULT NULL COMMENT 'user additional mobile/phone , seperated',
  `fax` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT 'fax',
  `did` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT 'did',
  `cost_center` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'cost center',
  `devicetoken` varchar(512) COLLATE utf8_bin DEFAULT NULL COMMENT 'device token',
  `commission` decimal(10,2) DEFAULT '0.00' COMMENT 'commission percentage',
  `mhcost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `mhrate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Man hour rate used in calculating order value',
  `geo_update_frq` tinyint(4) NOT NULL DEFAULT '15' COMMENT 'geo location update frequency in minutes',
  `work_hour_start` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'work start hour am for employee type',
  `work_hour_end` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'work end hour pm for employee type',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-enabled 0-disabled',
  `enablelogin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-login enabled 0-disabled',
  `enablepplcode` tinyint(1) DEFAULT '1' COMMENT 'enable code',
  `enablecontact` tinyint(1) DEFAULT '0' COMMENT 'contact enable [firstname,lastname fields]',
  `enablepplauxname` tinyint(1) DEFAULT '0' COMMENT 'enable auxname',
  `register_id` int(10) unsigned DEFAULT NULL COMMENT 'person record with role register.',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (1,NULL,'admin admin',NULL,'admin','admin','9000',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,0.00,0.00,15,0,0,1,1,1,0,0,NULL,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(2,NULL,'salesemp1 salesemp1',NULL,'salesemp1','salesemp1','9000',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,0.00,0.00,15,0,0,1,0,1,0,0,NULL,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(3,NULL,'salesemp2 salesemp2',NULL,'salesemp2','salesemp2','9000',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,0.00,0.00,15,0,0,1,0,1,0,0,NULL,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(4,NULL,'Register1',NULL,'Register1','Register1','9000',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,0.00,0.00,15,0,0,1,1,1,0,0,NULL,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(5,NULL,'Register2',NULL,'Register1','Register2','9000',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,0.00,0.00,15,0,0,1,1,1,0,0,NULL,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(6,NULL,'Walk-in Customer',NULL,'Walk-in Customer','Walk-in Customer','00000000',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,0.00,0.00,15,0,0,1,0,1,0,0,NULL,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(7,'','STN',NULL,'GSM',NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL,0.00,0.00,0.00,15,0,0,1,0,1,1,0,NULL,'2014-08-28 04:03:02','2014-08-28 04:03:02');
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personaddresses`
--

DROP TABLE IF EXISTS `personaddresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personaddresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `type` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'office' COMMENT 'office,residence,other',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personaddresses`
--

LOCK TABLES `personaddresses` WRITE;
/*!40000 ALTER TABLE `personaddresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `personaddresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personcompanyroles`
--

DROP TABLE IF EXISTS `personcompanyroles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personcompanyroles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `person_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `login_id` int(10) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'status 1-active 0-inactive',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personcompanyroles`
--

LOCK TABLES `personcompanyroles` WRITE;
/*!40000 ALTER TABLE `personcompanyroles` DISABLE KEYS */;
INSERT INTO `personcompanyroles` VALUES (1,0,0,1,1,1,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(2,1,1,3,2,1,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(3,2,1,6,0,1,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(4,3,1,6,0,1,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(5,4,1,6,3,1,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(6,5,1,6,4,1,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(7,6,1,7,0,1,'2014-08-22 05:03:08','2014-08-22 05:03:08'),(8,7,1,8,0,1,'2014-08-28 04:03:02','2014-08-28 04:03:02');
/*!40000 ALTER TABLE `personcompanyroles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persontimeslots`
--

DROP TABLE IF EXISTS `persontimeslots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persontimeslots` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `slotdate` datetime DEFAULT NULL COMMENT 'date',
  `person_id` int(10) unsigned NOT NULL,
  `ts1` int(10) unsigned DEFAULT NULL,
  `ts2` int(10) unsigned DEFAULT NULL,
  `ts3` int(10) unsigned DEFAULT NULL,
  `ts4` int(10) unsigned DEFAULT NULL,
  `ts5` int(10) unsigned DEFAULT NULL,
  `ts6` int(10) unsigned DEFAULT NULL,
  `ts7` int(10) unsigned DEFAULT NULL,
  `ts8` int(10) unsigned DEFAULT NULL,
  `ts9` int(10) unsigned DEFAULT NULL,
  `ts10` int(10) unsigned DEFAULT NULL,
  `ts11` int(10) unsigned DEFAULT NULL,
  `ts12` int(10) unsigned DEFAULT NULL,
  `ts13` int(10) unsigned DEFAULT NULL,
  `ts14` int(10) unsigned DEFAULT NULL,
  `ts15` int(10) unsigned DEFAULT NULL,
  `ts16` int(10) unsigned DEFAULT NULL,
  `ts17` int(10) unsigned DEFAULT NULL,
  `ts18` int(10) unsigned DEFAULT NULL,
  `ts19` int(10) unsigned DEFAULT NULL,
  `ts20` int(10) unsigned DEFAULT NULL,
  `ts21` int(10) unsigned DEFAULT NULL,
  `ts22` int(10) unsigned DEFAULT NULL,
  `ts23` int(10) unsigned DEFAULT NULL,
  `ts24` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persontimeslots`
--

LOCK TABLES `persontimeslots` WRITE;
/*!40000 ALTER TABLE `persontimeslots` DISABLE KEYS */;
/*!40000 ALTER TABLE `persontimeslots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productcategories`
--

DROP TABLE IF EXISTS `productcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productcategories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `productprice_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productcategories`
--

LOCK TABLES `productcategories` WRITE;
/*!40000 ALTER TABLE `productcategories` DISABLE KEYS */;
INSERT INTO `productcategories` VALUES (1,1,1,20),(2,3,2,30),(3,4,3,30),(4,26,24,5),(5,34,32,5),(7,36,34,32),(8,37,35,32),(9,38,36,8),(10,39,37,8),(11,40,38,11),(12,41,39,11),(13,42,40,16),(14,43,41,16),(15,44,42,17),(16,45,43,17),(17,46,44,33),(18,47,45,33),(19,48,46,31),(20,48,47,31),(21,49,48,31),(22,50,49,20),(23,51,50,20);
/*!40000 ALTER TABLE `productcategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productprices`
--

DROP TABLE IF EXISTS `productprices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productprices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `code` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT 'product code',
  `sku` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'sku',
  `supplier_id` int(10) unsigned NOT NULL,
  `unit_cp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'unit cost',
  `sptype` tinyint(1) DEFAULT '1' COMMENT '0-sp is directamount,1-percentage on cp',
  `unit_sp_per` decimal(10,2) DEFAULT '0.00' COMMENT 'gain percentage',
  `unit_sp` decimal(10,2) DEFAULT '0.00' COMMENT 'selling price ',
  `stock` int(10) DEFAULT '0',
  `stockvalue` decimal(10,2) DEFAULT '0.00' COMMENT 'total stock value as per cp',
  `rol` int(10) DEFAULT '0' COMMENT 're-order level quantity',
  `moq` int(10) DEFAULT '0' COMMENT 'minimum order quantity',
  `dontsyncwithstock` tinyint(1) DEFAULT '0' COMMENT '1- true 0- false',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'status 1-active 0-inactive',
  `tax` decimal(10,2) DEFAULT '0.00' COMMENT 'total tax amount',
  `disc` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'discount amount',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productprices`
--

LOCK TABLES `productprices` WRITE;
/*!40000 ALTER TABLE `productprices` DISABLE KEYS */;
INSERT INTO `productprices` VALUES (1,1,'nocode_439148007','nocode_439148007',1,0.00,1,0.00,0.00,0,0.00,0,0,1,1,0.00,0.00,'2014-08-13 10:42:59','2014-08-28 03:41:23'),(2,3,'','',7,0.40,1,150.00,1.00,100,40.00,24,48,2,1,0.07,0.00,'2014-08-28 04:03:48','2014-08-28 04:06:15'),(3,4,'','',7,0.40,1,175.00,1.10,100,40.00,24,48,2,1,0.08,0.00,'2014-08-28 04:04:45','2014-08-28 04:06:30'),(34,36,'','',7,0.80,1,87.50,1.50,100,80.00,30,60,2,1,0.00,0.00,'2014-08-29 02:53:08','2014-08-29 02:53:08'),(35,37,'','',7,0.90,1,66.67,1.50,100,90.00,30,60,2,1,0.00,0.00,'2014-08-29 02:55:14','2014-08-29 02:55:14'),(36,38,'','',7,1.00,1,80.00,1.80,20,20.00,10,40,2,1,0.00,0.00,'2014-08-29 02:58:43','2014-08-29 02:58:43'),(37,39,'','',7,1.20,1,108.33,2.50,NULL,0.00,0,0,2,1,0.00,0.00,'2014-08-29 03:00:24','2014-08-29 03:02:53'),(38,40,'nocode_215299142','nocode_215299142',7,2.50,1,64.00,4.10,0,0.00,0,0,1,1,0.00,0.00,'2014-08-29 03:04:57','2014-08-29 03:04:57'),(39,41,'nocode_878294513','nocode_878294513',7,3.80,1,39.47,5.30,0,0.00,0,0,1,1,0.00,0.00,'2014-08-29 03:06:24','2014-08-29 03:06:24'),(40,42,'','',7,2.00,1,75.00,3.50,10,20.00,5,10,2,1,0.00,0.00,'2014-08-29 03:11:38','2014-08-29 03:11:38'),(41,43,'','',7,1.00,1,100.00,2.00,14,14.00,5,15,2,1,0.00,0.00,'2014-08-29 03:12:39','2014-08-29 03:12:39'),(42,44,'','',7,0.20,1,150.00,0.50,50,10.00,30,100,2,1,0.00,0.00,'2014-08-29 03:13:32','2014-08-29 03:13:32'),(43,45,'','',7,0.25,1,140.00,0.60,46,11.50,30,100,2,1,0.00,0.00,'2014-08-29 03:14:15','2014-08-29 03:16:42'),(44,46,'','',7,0.80,1,87.50,1.50,10,8.00,5,20,2,1,0.00,0.00,'2014-08-29 03:19:16','2014-08-29 03:19:16'),(45,47,'','',7,1.50,1,46.67,2.20,30,45.00,20,30,2,1,0.00,0.00,'2014-08-29 03:20:10','2014-08-29 03:35:38'),(47,48,'','',7,2.00,1,95.00,3.90,40,80.00,20,24,2,1,0.00,0.00,'2014-08-29 03:23:14','2014-08-29 03:28:44'),(48,49,'','',7,2.20,1,93.18,4.25,20,44.00,12,24,2,1,0.00,0.00,'2014-08-29 03:33:32','2014-08-29 03:33:32'),(49,50,'nocode_987488221','nocode_987488221',7,0.50,1,100.00,1.00,0,0.00,0,0,1,1,0.00,0.00,'2014-08-29 03:34:31','2014-08-29 03:34:31'),(50,51,'nocode_74469677','nocode_74469677',7,0.40,1,100.00,0.80,0,0.00,0,0,1,1,0.00,0.00,'2014-08-29 03:35:04','2014-08-29 03:35:20');
/*!40000 ALTER TABLE `productprices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `enableprdcode` tinyint(1) DEFAULT '1' COMMENT 'enable code',
  `name` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'primary name',
  `desc` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'description',
  `remarks` text COLLATE utf8_bin COMMENT 'remarks',
  `enableprdauxname` tinyint(1) DEFAULT '0' COMMENT 'enable auxname',
  `auxname` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'auxiliary name in diff language',
  `manufacturer` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'manufacturer',
  `color` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'color',
  `size` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'size',
  `discper` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'discount %',
  `disc` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'discount amount',
  `taxrate_id` int(10) unsigned NOT NULL,
  `tax` decimal(10,2) DEFAULT '0.00' COMMENT 'total tax amount',
  `imagepath` varchar(1024) COLLATE utf8_bin DEFAULT NULL COMMENT 'image file path',
  `person_id` int(10) unsigned NOT NULL COMMENT 'employee id who entered this record',
  `code` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT 'product code',
  `sku` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'primary name',
  `supplier_id` int(10) unsigned NOT NULL DEFAULT '0',
  `unit_cp` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'unit cost',
  `sptype` tinyint(1) DEFAULT '1' COMMENT '0-sp is directamount,1-percentage on cp',
  `unit_sp_per` decimal(10,2) DEFAULT '0.00' COMMENT 'gain percentage',
  `unit_sp` decimal(10,2) DEFAULT '0.00' COMMENT 'selling price ',
  `stock` int(10) DEFAULT '0',
  `stockvalue` decimal(10,2) DEFAULT '0.00' COMMENT 'total stock value as per cp',
  `rol` int(10) DEFAULT '0' COMMENT 're-order level quantity',
  `moq` int(10) DEFAULT '0' COMMENT 'minimum order quantity',
  `dontsyncwithstock` tinyint(1) DEFAULT '0' COMMENT '1- true 0- false',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'status 1-active 0-inactive',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Vegetable','dummy product','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,NULL,1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-13 10:42:59','2014-08-28 03:41:23'),(3,1,'Coca-Cola (330ml)','Can Drinks','',0,NULL,NULL,NULL,NULL,0.00,0.00,3,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-28 04:03:48','2014-08-28 04:06:15'),(4,1,'Fanta Can Drink (Assorted) (330ml)','Can Drinks','',0,NULL,NULL,NULL,NULL,0.00,0.00,3,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-28 04:04:45','2014-08-28 04:06:30'),(36,1,'Coca-Cola (500ml)','Bottle Drink','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 02:53:08','2014-08-29 02:53:08'),(37,1,'Fanta Can Drink (Assorted) (500ml)','Bottle Drink','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 02:55:14','2014-08-29 02:55:14'),(38,1,'Jack&Jills Chips BBQ (70g)','J&J (70g)','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 02:58:43','2014-08-29 02:58:43'),(39,1,'Pringles (Assorted)(181g)','Pringles (181g)','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 03:00:24','2014-08-29 03:02:53'),(40,1,'Lean Meat (100g)','Frozen - Meat (100g)','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 03:04:57','2014-08-29 03:04:57'),(41,1,'Fish (40g)','Fish (40g)','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 03:06:24','2014-08-29 03:06:24'),(42,1,'Fox’s Crystal Clear Strawberry Candy ','Candy','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 03:11:38','2014-08-29 03:11:38'),(43,1,'Candy Mentos Fruit Jar 160\'s ','Candy','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 03:12:39','2014-08-29 03:12:39'),(44,1,'Apple','Fruit - Apple','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 03:13:32','2014-08-29 03:13:32'),(45,1,' Orange','Fruit - Orange','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 03:14:15','2014-08-29 03:16:42'),(46,1,'Scissors','Stationery','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 03:19:16','2014-08-29 03:19:16'),(47,1,'Pen (G2 Pilot)','Stationery','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 03:20:10','2014-08-29 03:35:38'),(48,1,'Tiger Beer (330ml)','Can Beer','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 03:22:46','2014-08-29 03:28:44'),(49,1,'ABC Beer (330ml)','Can Beer','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 03:33:32','2014-08-29 03:33:32'),(50,1,'Carrots ','Carrot','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 03:34:31','2014-08-29 03:34:31'),(51,1,'Cabbage','Cabbage','',0,NULL,NULL,NULL,NULL,0.00,0.00,1,0.00,'',1,NULL,NULL,0,0.00,1,0.00,0.00,0,0.00,0,0,0,1,'2014-08-29 03:35:04','2014-08-29 03:35:55');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productstockhistories`
--

DROP TABLE IF EXISTS `productstockhistories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productstockhistories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `productprice_id` int(10) unsigned NOT NULL,
  `updationdate` datetime DEFAULT NULL COMMENT 'stock update date',
  `beforeupdation` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'before updation',
  `updatedqnty` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'updated quantity',
  `afterupdation` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'before updation',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productstockhistories`
--

LOCK TABLES `productstockhistories` WRITE;
/*!40000 ALTER TABLE `productstockhistories` DISABLE KEYS */;
/*!40000 ALTER TABLE `productstockhistories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchaseproducts`
--

DROP TABLE IF EXISTS `purchaseproducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchaseproducts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `quantity` int(10) NOT NULL DEFAULT '1' COMMENT 'quantity',
  `unit_cp` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'unit_cp * quantity',
  `taxrate_id` int(10) unsigned NOT NULL,
  `tax` decimal(10,2) DEFAULT '0.00' COMMENT 'total tax amount',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchaseproducts`
--

LOCK TABLES `purchaseproducts` WRITE;
/*!40000 ALTER TABLE `purchaseproducts` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchaseproducts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_number` varchar(16) COLLATE utf8_bin NOT NULL COMMENT 'purchase number',
  `purchase_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'purchase date field',
  `supplier_id` int(10) unsigned NOT NULL,
  `remarks` varchar(1024) COLLATE utf8_bin DEFAULT NULL COMMENT 'remarks',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'total amount of all orderproducts',
  `tax` decimal(10,2) DEFAULT '0.00' COMMENT 'total tax amount',
  `paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'paid',
  `status` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'OPEN' COMMENT 'OPEN, PENDING, CLOSED',
  `invstatus` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'UNINVOICED' COMMENT 'UNINVOICED,INVOICED',
  `person_id` int(10) unsigned NOT NULL COMMENT 'employee id who entered this record',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registers`
--

DROP TABLE IF EXISTS `registers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'register name',
  `desc` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'description',
  `salesdate` datetime DEFAULT NULL COMMENT 'sales date',
  `login_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `open_time` datetime DEFAULT NULL COMMENT 'open time',
  `close_time` datetime DEFAULT NULL COMMENT 'close time',
  `op_balance` decimal(10,2) DEFAULT NULL,
  `cl_balance` decimal(10,2) DEFAULT NULL,
  `net_collection` decimal(10,2) DEFAULT NULL,
  `isdefault` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'status 1-default 0-not',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registers`
--

LOCK TABLES `registers` WRITE;
/*!40000 ALTER TABLE `registers` DISABLE KEYS */;
/*!40000 ALTER TABLE `registers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `role` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT 'employee' COMMENT 'superadmin,admin,employee etc.,',
  `desc` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'role description',
  `level` int(10) unsigned NOT NULL DEFAULT '1000' COMMENT 'level number 0 the greatest',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1-active 0-inactive',
  `iscompany` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1-company 0-non-company',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'SU','Super Admin',0,1,0,'2014-02-11 08:02:58','2014-02-11 08:03:00'),(2,'Non_su','Non - Super Admin',1,1,0,'2014-02-11 08:02:58','2014-02-11 08:03:00'),(3,'Admin','Admin',10,1,1,'2014-02-11 08:02:58','2014-02-11 08:03:00'),(4,'Manager','Manager',11,1,1,'2014-02-11 08:02:58','2014-02-11 08:03:00'),(5,'Employee','Employee',12,1,1,'2014-02-11 08:02:58','2014-02-11 08:03:00'),(6,'Sales','Sales',13,1,1,'2014-02-11 08:02:58','2014-02-11 08:03:00'),(7,'Customer','Customer',1000,1,1,'2014-02-11 08:02:58','2014-02-11 08:03:00'),(8,'Supplier','Supplier',1000,1,1,'2014-02-11 08:02:58','2014-02-11 08:03:00'),(9,'Contractor','Contractor',1000,1,1,'2014-02-11 08:02:58','2014-02-11 08:03:00');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statushistories`
--

DROP TABLE IF EXISTS `statushistories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statushistories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `ofwhich_id` int(10) unsigned NOT NULL,
  `status1dt` datetime DEFAULT NULL COMMENT 'datetime when it came to this status1',
  `status2dt` datetime DEFAULT NULL COMMENT 'datetime when it came to this status2',
  `status3dt` datetime DEFAULT NULL COMMENT 'datetime when it came to this status3',
  `status4dt` datetime DEFAULT NULL COMMENT 'datetime when it came to this status4',
  `status5dt` datetime DEFAULT NULL COMMENT 'datetime when it came to this status5',
  `status6dt` datetime DEFAULT NULL COMMENT 'datetime when it came to this status6',
  `status7dt` datetime DEFAULT NULL COMMENT 'datetime when it came to this status7',
  `status8dt` datetime DEFAULT NULL COMMENT 'datetime when it came to this status8',
  `status9dt` datetime DEFAULT NULL COMMENT 'datetime when it came to this status9',
  `status10dt` datetime DEFAULT NULL COMMENT 'datetime when it came to this status10',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statushistories`
--

LOCK TABLES `statushistories` WRITE;
/*!40000 ALTER TABLE `statushistories` DISABLE KEYS */;
/*!40000 ALTER TABLE `statushistories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statusmasters`
--

DROP TABLE IF EXISTS `statusmasters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statusmasters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ofwhich` int(10) unsigned NOT NULL COMMENT 'this row is a astatus for this field',
  `name` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'status name',
  `display` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'display string',
  `desc` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'description',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statusmasters`
--

LOCK TABLES `statusmasters` WRITE;
/*!40000 ALTER TABLE `statusmasters` DISABLE KEYS */;
INSERT INTO `statusmasters` VALUES (1,1,'OPEN','OPEN','for orders'),(2,1,'PENDING','PENDING','for orders'),(3,1,'CLOSED','CLOSED','for orders'),(4,1,'REFUNDOLD','REFUNDOLD','for orders'),(5,1,'REFUNDNEW','REFUNDNEW','for orders'),(6,1,'CANCELOLD','CANCELOLD','for orders'),(7,1,'CANCELNEW','CANCELNEW','for orders'),(8,1,'EXCHANGEOLD','EXCHANGEOLD','for orders'),(9,1,'EXCHANGENEW','EXCHANGENEW','for orders'),(10,1,'DELIVERED','DELIVERED','for orders'),(11,2,'OPEN','OPEN','for ordertasks'),(12,2,'PENDING','PENDING','for ordertasks'),(13,2,'CLOSED','CLOSED','for ordertasks');
/*!40000 ALTER TABLE `statusmasters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `name` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'category name',
  `desc` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'description',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (1,1,'Structural Work','Structural Work'),(2,1,'Piling','Piling'),(3,1,'Painting','Painting'),(4,1,'Interior Deco','Interior decoration');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxrates`
--

DROP TABLE IF EXISTS `taxrates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxrates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `taxname` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'tax name',
  `taxrate` decimal(10,2) DEFAULT '0.00' COMMENT 'either % or fixed',
  `taxtype` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'Percentage, Fixed',
  `remarks` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'remarks',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxrates`
--

LOCK TABLES `taxrates` WRITE;
/*!40000 ALTER TABLE `taxrates` DISABLE KEYS */;
INSERT INTO `taxrates` VALUES (1,'No Tax',0.00,'Percentage','No tax'),(2,'5%',5.00,'Percentage','5%'),(3,'7%',7.00,'Percentage','7%'),(4,'14%',14.00,'Percentage','14%');
/*!40000 ALTER TABLE `taxrates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timeslotstatuses`
--

DROP TABLE IF EXISTS `timeslotstatuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timeslotstatuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `slotdate` datetime DEFAULT NULL COMMENT 'date',
  `slot` varchar(8) COLLATE utf8_bin NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'status 1-saved 0-not saved',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`),
  UNIQUE KEY `day` (`slotdate`,`slot`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timeslotstatuses`
--

LOCK TABLES `timeslotstatuses` WRITE;
/*!40000 ALTER TABLE `timeslotstatuses` DISABLE KEYS */;
/*!40000 ALTER TABLE `timeslotstatuses` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-08-29  4:02:49
