-- --------------------------------------------------------
-- Host:                         107.167.186.152
-- Server version:               5.5.43-0+deb7u1 - (Debian)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;



-- Dumping structure for table jhub.JP_CLIENT_DETAILS
DROP TABLE IF EXISTS `JP_CLIENT_DETAILS`;
CREATE TABLE IF NOT EXISTS `JP_CLIENT_DETAILS` (
  `CD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CD_QUOTATION_HEADER` text,
  `CD_COMPANY_ADDRESS` text NOT NULL,
  `CD_CONTACT_NO` varchar(10) NOT NULL,
  PRIMARY KEY (`CD_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_CLIENT_DETAILS: ~1 rows (approximately)
DELETE FROM `JP_CLIENT_DETAILS`;
/*!40000 ALTER TABLE `JP_CLIENT_DETAILS` DISABLE KEYS */;
INSERT INTO `JP_CLIENT_DETAILS` (`CD_ID`, `CD_QUOTATION_HEADER`, `CD_COMPANY_ADDRESS`, `CD_CONTACT_NO`) VALUES
	(1, 'Starhub SG50 Promo', '994 Bendemeer Rd #04-04 Singapore 339943', '62952082');
/*!40000 ALTER TABLE `JP_CLIENT_DETAILS` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_CONFIGURATION
DROP TABLE IF EXISTS `JP_CONFIGURATION`;
CREATE TABLE IF NOT EXISTS `JP_CONFIGURATION` (
  `CGN_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CNP_ID` int(11) NOT NULL,
  `CGN_TYPE` varchar(50) NOT NULL,
  `CGN_NON_IP_FLAG` char(1) DEFAULT NULL,
  PRIMARY KEY (`CGN_ID`),
  UNIQUE KEY `CGN_TYPE` (`CGN_TYPE`),
  KEY `CNP_ID` (`CNP_ID`),
  CONSTRAINT `JP_CONFIGURATION_ibfk_1` FOREIGN KEY (`CNP_ID`) REFERENCES `JP_CONFIGURATION_PROFILE` (`CNP_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_CONFIGURATION: ~9 rows (approximately)
DELETE FROM `JP_CONFIGURATION`;
/*!40000 ALTER TABLE `JP_CONFIGURATION` DISABLE KEYS */;
INSERT INTO `JP_CONFIGURATION` (`CGN_ID`, `CNP_ID`, `CGN_TYPE`, `CGN_NON_IP_FLAG`) VALUES
	(1, 3, 'SENDER', 'X'),
	(2, 3, 'TO', 'X'),
	(3, 3, 'CC', 'X'),
	(4, 3, 'EMAIL SERVER IP', 'X'),
	(5, 3, 'PORT NO', 'X'),
	(6, 3, 'USER NAME', 'X'),
	(7, 3, 'PASSWORD', 'X'),
	(8, 3, 'SMTP SECURE', 'X'),
	(9, 3, 'HOST', 'X');
/*!40000 ALTER TABLE `JP_CONFIGURATION` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_CONFIGURATION_PROFILE
DROP TABLE IF EXISTS `JP_CONFIGURATION_PROFILE`;
CREATE TABLE IF NOT EXISTS `JP_CONFIGURATION_PROFILE` (
  `CNP_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CNP_DATA` varchar(25) NOT NULL,
  PRIMARY KEY (`CNP_ID`),
  UNIQUE KEY `CNP_DATA` (`CNP_DATA`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_CONFIGURATION_PROFILE: ~3 rows (approximately)
DELETE FROM `JP_CONFIGURATION_PROFILE`;
/*!40000 ALTER TABLE `JP_CONFIGURATION_PROFILE` DISABLE KEYS */;
INSERT INTO `JP_CONFIGURATION_PROFILE` (`CNP_ID`, `CNP_DATA`) VALUES
	(2, 'ENQUIRY'),
	(1, 'GENERAL'),
	(3, 'USER RIGHTS');
/*!40000 ALTER TABLE `JP_CONFIGURATION_PROFILE` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_EMAIL_TEMPLATE
DROP TABLE IF EXISTS `JP_EMAIL_TEMPLATE`;
CREATE TABLE IF NOT EXISTS `JP_EMAIL_TEMPLATE` (
  `ET_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ET_EMAIL_SCRIPT` varchar(100) NOT NULL,
  PRIMARY KEY (`ET_ID`),
  UNIQUE KEY `ET_EMAIL_SCRIPT` (`ET_EMAIL_SCRIPT`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_EMAIL_TEMPLATE: ~1 rows (approximately)
DELETE FROM `JP_EMAIL_TEMPLATE`;
/*!40000 ALTER TABLE `JP_EMAIL_TEMPLATE` DISABLE KEYS */;
INSERT INTO `JP_EMAIL_TEMPLATE` (`ET_ID`, `ET_EMAIL_SCRIPT`) VALUES
	(1, 'USER ENQUIRY MAIL');
/*!40000 ALTER TABLE `JP_EMAIL_TEMPLATE` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_EMAIL_TEMPLATE_DETAILS
DROP TABLE IF EXISTS `JP_EMAIL_TEMPLATE_DETAILS`;
CREATE TABLE IF NOT EXISTS `JP_EMAIL_TEMPLATE_DETAILS` (
  `ETD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ET_ID` int(11) NOT NULL,
  `ETD_EMAIL_SUBJECT` text NOT NULL,
  `ETD_EMAIL_BODY` text NOT NULL,
  PRIMARY KEY (`ETD_ID`),
  KEY `ET_ID` (`ET_ID`),
  CONSTRAINT `JP_EMAIL_TEMPLATE_DETAILS_ibfk_1` FOREIGN KEY (`ET_ID`) REFERENCES `JP_EMAIL_TEMPLATE` (`ET_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_EMAIL_TEMPLATE_DETAILS: ~1 rows (approximately)
DELETE FROM `JP_EMAIL_TEMPLATE_DETAILS`;
/*!40000 ALTER TABLE `JP_EMAIL_TEMPLATE_DETAILS` DISABLE KEYS */;
INSERT INTO `JP_EMAIL_TEMPLATE_DETAILS` (`ETD_ID`, `ET_ID`, `ETD_EMAIL_SUBJECT`, `ETD_EMAIL_BODY`) VALUES
	(1, 1, 'USER ENQUIRY DETAILS', 'HELLO ADMIN, NEW ENQUIRY HAS CREATED BY THE USER [USERNAME] DATE: [ENQDATE] ENQUIRY ID:[ENQID]');
/*!40000 ALTER TABLE `JP_EMAIL_TEMPLATE_DETAILS` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_ENQUIRY_STATUS
DROP TABLE IF EXISTS `JP_ENQUIRY_STATUS`;
CREATE TABLE IF NOT EXISTS `JP_ENQUIRY_STATUS` (
  `ES_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ES_STATUS` varchar(50) NOT NULL,
  PRIMARY KEY (`ES_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_ENQUIRY_STATUS: ~5 rows (approximately)
DELETE FROM `JP_ENQUIRY_STATUS`;
/*!40000 ALTER TABLE `JP_ENQUIRY_STATUS` DISABLE KEYS */;
INSERT INTO `JP_ENQUIRY_STATUS` (`ES_ID`, `ES_STATUS`) VALUES
	(1, 'New'),
	(2, 'Quotation Updated'),
	(3, 'Confirmed Order'),
	(4, 'Cancelled'),
	(5, 'Delivered');
/*!40000 ALTER TABLE `JP_ENQUIRY_STATUS` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_ENQUIRY_TITLE
DROP TABLE IF EXISTS `JP_ENQUIRY_TITLE`;
CREATE TABLE IF NOT EXISTS `JP_ENQUIRY_TITLE` (
  `ETI_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ETI_PRODUCT_NAME` varchar(50) NOT NULL,
  `ULD_ID` int(11) NOT NULL,
  `ETI_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ETI_ID`),
  UNIQUE KEY `ETI_PRODUCT_NAME` (`ETI_PRODUCT_NAME`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `JP_ENQUIRY_TITLE_ibfk_1` FOREIGN KEY (`ULD_ID`) REFERENCES `JP_USER_LOGIN_DETAILS` (`ULD_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_ENQUIRY_TITLE: ~0 rows (approximately)
DELETE FROM `JP_ENQUIRY_TITLE`;
/*!40000 ALTER TABLE `JP_ENQUIRY_TITLE` DISABLE KEYS */;
/*!40000 ALTER TABLE `JP_ENQUIRY_TITLE` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_ERROR_MESSAGE_CONFIGURATION
DROP TABLE IF EXISTS `JP_ERROR_MESSAGE_CONFIGURATION`;
CREATE TABLE IF NOT EXISTS `JP_ERROR_MESSAGE_CONFIGURATION` (
  `EMC_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CNP_ID` int(11) NOT NULL,
  `EMC_CODE` int(11) NOT NULL,
  `EMC_DATA` text NOT NULL,
  `EMC_INITIALIZE_FLAG` char(1) DEFAULT NULL,
  `EMC_TITLE` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`EMC_ID`),
  KEY `CNP_ID` (`CNP_ID`),
  CONSTRAINT `JP_ERROR_MESSAGE_CONFIGURATION_ibfk_1` FOREIGN KEY (`CNP_ID`) REFERENCES `JP_CONFIGURATION_PROFILE` (`CNP_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_ERROR_MESSAGE_CONFIGURATION: ~17 rows (approximately)
DELETE FROM `JP_ERROR_MESSAGE_CONFIGURATION`;
/*!40000 ALTER TABLE `JP_ERROR_MESSAGE_CONFIGURATION` DISABLE KEYS */;
INSERT INTO `JP_ERROR_MESSAGE_CONFIGURATION` (`EMC_ID`, `CNP_ID`, `EMC_CODE`, `EMC_DATA`, `EMC_INITIALIZE_FLAG`, `EMC_TITLE`) VALUES
	(1, 2, 1, 'ENQUIRY DETAILS SAVED SUCCESSFULLY', 'X', NULL),
	(2, 2, 2, 'ENQUIRY DETAILS UPDATED SUCCESSFULLY', 'X', NULL),
	(3, 2, 3, 'QUOTATION GENERATED SUCCESSFULLY', 'X', NULL),
	(4, 3, 4, 'LOGIN CREATED SUCCESSFULLY', 'X', NULL),
	(5, 3, 5, 'LOGIN UPDATED SUCCESSFULLY', 'X', NULL),
	(6, 2, 6, 'ORDER CONFIRMED', 'X', NULL),
	(7, 2, 7, 'ALREADY YOU HAVE NEW QUOTATION CHECK IN ENQUIRY LIST', 'X', NULL),
	(8, 2, 8, 'QUOTATION DELIVERED', 'X', NULL),
	(9, 2, 9, 'QUOTATION CANCELLED', 'X', NULL),
	(10, 2, 10, 'USERNAME ALREADY EXISTS', 'X', NULL),
	(11, 2, 11, 'ENTER VALID EMAIL ID', 'X', NULL),
	(12, 2, 12, 'PDF (OR)JPEG(OR)PNG FILES ONLY SUPPORT', 'X', NULL),
	(13, 2, 13, 'JPEG (OR)PNG (OR) JPG FILES ONLY SUPPORT', 'X', NULL),
	(14, 3, 14, 'USERNAME OR PASSWORD IS INVALID', 'X', NULL),
	(15, 2, 15, 'PLZ,CHECK IF YOU HAVE KEY IN YOUR  PURCHASE ORDER NUMBER AND IF THERE ARE ANY ATTACHMENT REQUIRED.', NULL, 'PURCHASE ORDER NO CONFIRM MESSAGE'),
	(16, 2, 16, 'JOB REQUEST WILL BE PROCESS,PLZ REVIEW THE STATUS AGAIN 5 WORKING DAYS LATER.', NULL, 'CONFIRMED STATUS'),
	(17, 2, 17, 'JOB DELIVERED WITHIN 2-3  WORKING DAYS.', NULL, 'DELIVERED STATUS');
/*!40000 ALTER TABLE `JP_ERROR_MESSAGE_CONFIGURATION` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_INVOICE_DETAILS
DROP TABLE IF EXISTS `JP_INVOICE_DETAILS`;
CREATE TABLE IF NOT EXISTS `JP_INVOICE_DETAILS` (
  `INV_ID` int(11) NOT NULL AUTO_INCREMENT,
  `UED_ID` int(11) NOT NULL,
  `INVOICENO` varchar(20) NOT NULL,
  `INVOICE_ID` varchar(20) NOT NULL,
  `ULD_ID` int(11) NOT NULL,
  `PD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`INV_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  KEY `UED_ID` (`UED_ID`),
  CONSTRAINT `JP_INVOICE_DETAILS_ibfk_1` FOREIGN KEY (`ULD_ID`) REFERENCES `JP_USER_LOGIN_DETAILS` (`ULD_ID`),
  CONSTRAINT `JP_INVOICE_DETAILS_ibfk_2` FOREIGN KEY (`UED_ID`) REFERENCES `JP_USER_ENQUIRY_DETAILS` (`UED_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_INVOICE_DETAILS: ~0 rows (approximately)
DELETE FROM `JP_INVOICE_DETAILS`;
/*!40000 ALTER TABLE `JP_INVOICE_DETAILS` DISABLE KEYS */;
/*!40000 ALTER TABLE `JP_INVOICE_DETAILS` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_ITEM_DETAILS
DROP TABLE IF EXISTS `JP_ITEM_DETAILS`;
CREATE TABLE IF NOT EXISTS `JP_ITEM_DETAILS` (
  `ITD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SID_ID` int(11) NOT NULL,
  `ITD_ITEM` varchar(50) NOT NULL,
  `ITD_FLAG` char(1) DEFAULT NULL,
  `ULD_ID` int(11) NOT NULL,
  `ITD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ITD_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  KEY `SID_ID` (`SID_ID`),
  CONSTRAINT `JP_ITEM_DETAILS_ibfk_1` FOREIGN KEY (`ULD_ID`) REFERENCES `JP_USER_LOGIN_DETAILS` (`ULD_ID`),
  CONSTRAINT `JP_ITEM_DETAILS_ibfk_2` FOREIGN KEY (`SID_ID`) REFERENCES `JP_SUB_ITEM_DETAILS` (`SID_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_ITEM_DETAILS: ~80 rows (approximately)
DELETE FROM `JP_ITEM_DETAILS`;
/*!40000 ALTER TABLE `JP_ITEM_DETAILS` DISABLE KEYS */;
INSERT INTO `JP_ITEM_DETAILS` (`ITD_ID`, `SID_ID`, `ITD_ITEM`, `ITD_FLAG`, `ULD_ID`, `ITD_TIMESTAMP`) VALUES
	(1, 1, 'Business Cards', 'X', 1, '2015-07-21 07:40:06'),
	(2, 1, 'Flyers', 'X', 1, '2015-07-21 07:40:06'),
	(3, 1, 'Leaflets', 'X', 1, '2015-07-21 07:40:06'),
	(4, 1, 'Coupon', 'X', 1, '2015-07-21 07:40:06'),
	(5, 1, 'Brochures', 'X', 1, '2015-07-21 07:40:06'),
	(6, 1, 'Inserts', 'X', 1, '2015-07-21 07:40:06'),
	(7, 1, 'Posters', 'X', 1, '2015-07-21 07:40:06'),
	(8, 1, 'Booklets', 'X', 1, '2015-07-21 07:40:06'),
	(9, 1, 'Hardcover Book', 'X', 1, '2015-07-21 07:40:06'),
	(10, 1, 'Softcover Book', 'X', 1, '2015-07-21 07:40:06'),
	(11, 1, 'Magazine', 'X', 1, '2015-07-21 07:40:06'),
	(12, 1, 'Folder', 'X', 1, '2015-07-21 07:40:06'),
	(13, 1, 'Ring Files', 'X', 1, '2015-07-21 07:40:06'),
	(14, 1, 'Envelopes', 'X', 1, '2015-07-21 07:40:06'),
	(15, 1, 'Others', 'X', 1, '2015-07-21 07:40:06'),
	(16, 2, 'A6', 'X', 1, '2015-07-21 07:40:06'),
	(17, 2, 'A5', 'X', 1, '2015-07-21 07:40:06'),
	(18, 2, 'A4', 'X', 1, '2015-07-21 07:40:06'),
	(19, 2, 'A3', 'X', 1, '2015-07-21 07:40:06'),
	(20, 2, 'A2', 'X', 1, '2015-07-21 07:40:06'),
	(21, 2, 'A1 ', 'X', 1, '2015-07-21 07:40:06'),
	(22, 2, 'Custom', 'X', 1, '2015-07-21 07:40:06'),
	(23, 3, 'Glossy Art Paper', 'X', 1, '2015-07-21 07:40:06'),
	(24, 3, 'Glossy Art Card', 'X', 1, '2015-07-21 07:40:06'),
	(25, 3, 'Matt Art Paper', 'X', 1, '2015-07-21 07:40:06'),
	(26, 3, 'Matt Art Card', 'X', 1, '2015-07-21 07:40:06'),
	(27, 3, 'W/F Paper', 'X', 1, '2015-07-21 07:40:06'),
	(28, 3, 'W/F Card', 'X', 1, '2015-07-21 07:40:06'),
	(29, 3, 'NCR Paper', 'X', 1, '2015-07-21 07:40:06'),
	(30, 3, 'PP', 'X', 1, '2015-07-21 07:40:06'),
	(31, 3, 'Rigid Film', 'X', 1, '2015-07-21 07:40:06'),
	(32, 3, 'Decal', 'X', 1, '2015-07-21 07:40:06'),
	(33, 3, 'Banners', 'X', 1, '2015-07-21 07:40:06'),
	(34, 3, 'Canvas ', 'X', 1, '2015-07-21 07:40:06'),
	(35, 3, 'Others', 'X', 1, '2015-07-21 07:40:06'),
	(36, 4, '85gsm', 'X', 1, '2015-07-21 07:40:06'),
	(37, 4, '105gsm', 'X', 1, '2015-07-21 07:40:06'),
	(38, 4, '128gsm', 'X', 1, '2015-07-21 07:40:06'),
	(39, 4, '157gsm', 'X', 1, '2015-07-21 07:40:06'),
	(40, 4, '190gsm', 'X', 1, '2015-07-21 07:40:06'),
	(41, 4, '230gsm', 'X', 1, '2015-07-21 07:40:06'),
	(42, 4, '260gsm', 'X', 1, '2015-07-21 07:40:06'),
	(43, 4, '310gsm', 'X', 1, '2015-07-21 07:40:06'),
	(44, 4, '360gsm', 'X', 1, '2015-07-21 07:40:06'),
	(45, 4, '420gsm', 'X', 1, '2015-07-21 07:40:06'),
	(46, 5, 'Offset Printing', 'X', 1, '2015-07-21 07:40:06'),
	(47, 5, 'Digital Printing', 'X', 1, '2015-07-21 07:40:06'),
	(48, 5, 'UV Printing', 'X', 1, '2015-07-21 07:40:06'),
	(49, 5, 'Silkscreen Printing', 'X', 1, '2015-07-21 07:40:06'),
	(50, 5, 'Hot Foil Stamping', 'X', 1, '2015-07-21 07:40:06'),
	(51, 5, 'Serialized Numbering', 'X', 1, '2015-07-21 07:40:06'),
	(52, 6, '4c x 0c (1 side printng)', 'X', 1, '2015-07-21 07:40:06'),
	(53, 6, '4c x 4c  (2 sides printing)', 'X', 1, '2015-07-21 07:40:06'),
	(54, 6, 'Others', 'X', 1, '2015-07-21 07:40:06'),
	(55, 7, 'Gloss Lam', 'X', 1, '2015-07-21 07:40:06'),
	(56, 7, 'Matt Lam', 'X', 1, '2015-07-21 07:40:06'),
	(57, 7, 'Velvet Lam', 'X', 1, '2015-07-21 07:40:06'),
	(58, 7, 'UV  Varnish', 'X', 1, '2015-07-21 07:40:06'),
	(59, 7, 'Gloss Varnish', 'X', 1, '2015-07-21 07:40:06'),
	(60, 7, 'Matt Varnish', 'X', 1, '2015-07-21 07:40:06'),
	(61, 7, 'Spot UV', 'X', 1, '2015-07-21 07:40:06'),
	(62, 7, 'Effect Varnish', 'X', 1, '2015-07-21 07:40:06'),
	(63, 7, 'Others', 'X', 1, '2015-07-21 07:40:06'),
	(64, 8, 'Trim to size', 'X', 1, '2015-07-21 07:40:06'),
	(65, 8, 'Score line', 'X', 1, '2015-07-21 07:40:06'),
	(66, 8, 'Perforation', 'X', 1, '2015-07-21 07:40:06'),
	(67, 8, 'Die-cut', 'X', 1, '2015-07-21 07:40:06'),
	(68, 8, 'Pasteing', 'X', 1, '2015-07-21 07:40:06'),
	(69, 8, 'Collating', 'X', 1, '2015-07-21 07:40:06'),
	(70, 8, 'Others', 'X', 1, '2015-07-21 07:40:06'),
	(71, 9, 'Saddle Stitch', 'X', 1, '2015-07-21 07:40:06'),
	(72, 9, 'Loop Stitching', 'X', 1, '2015-07-21 07:40:06'),
	(73, 9, 'Perfect Bind', 'X', 1, '2015-07-21 07:40:06'),
	(74, 9, 'Thread Sewn', 'X', 1, '2015-07-21 07:40:06'),
	(75, 9, 'Notch Binding', 'X', 1, '2015-07-21 07:40:06'),
	(76, 9, 'Saddle Stitch', 'X', 1, '2015-07-21 07:40:06'),
	(77, 9, 'Pad-Form', 'X', 1, '2015-07-21 07:40:06'),
	(78, 9, 'Set-Form', 'X', 1, '2015-07-21 07:40:06'),
	(79, 9, 'Others', 'X', 1, '2015-07-21 07:40:06'),
	(80, 8, 'Folding', 'X', 1, '2015-07-21 07:40:06');
/*!40000 ALTER TABLE `JP_ITEM_DETAILS` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_QUOTATION_DETAILS
DROP TABLE IF EXISTS `JP_QUOTATION_DETAILS`;
CREATE TABLE IF NOT EXISTS `JP_QUOTATION_DETAILS` (
  `QD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `UED_ID` int(11) NOT NULL,
  `QD_QUOTATION_ID` varchar(30) NOT NULL,
  `ULD_ID` int(11) NOT NULL,
  `QD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`QD_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  KEY `UED_ID` (`UED_ID`),
  CONSTRAINT `JP_QUOTATION_DETAILS_ibfk_1` FOREIGN KEY (`ULD_ID`) REFERENCES `JP_USER_LOGIN_DETAILS` (`ULD_ID`),
  CONSTRAINT `JP_QUOTATION_DETAILS_ibfk_2` FOREIGN KEY (`UED_ID`) REFERENCES `JP_USER_ENQUIRY_DETAILS` (`UED_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_QUOTATION_DETAILS: ~0 rows (approximately)
DELETE FROM `JP_QUOTATION_DETAILS`;
/*!40000 ALTER TABLE `JP_QUOTATION_DETAILS` DISABLE KEYS */;
/*!40000 ALTER TABLE `JP_QUOTATION_DETAILS` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_ROLE_CREATION
DROP TABLE IF EXISTS `JP_ROLE_CREATION`;
CREATE TABLE IF NOT EXISTS `JP_ROLE_CREATION` (
  `RC_ID` int(11) NOT NULL AUTO_INCREMENT,
  `RC_NAME` varchar(15) NOT NULL,
  PRIMARY KEY (`RC_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_ROLE_CREATION: ~2 rows (approximately)
DELETE FROM `JP_ROLE_CREATION`;
/*!40000 ALTER TABLE `JP_ROLE_CREATION` DISABLE KEYS */;
INSERT INTO `JP_ROLE_CREATION` (`RC_ID`, `RC_NAME`) VALUES
	(1, 'ADMIN'),
	(2, 'USER');
/*!40000 ALTER TABLE `JP_ROLE_CREATION` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_SUB_ITEM_DETAILS
DROP TABLE IF EXISTS `JP_SUB_ITEM_DETAILS`;
CREATE TABLE IF NOT EXISTS `JP_SUB_ITEM_DETAILS` (
  `SID_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SID_ITEM` varchar(50) NOT NULL,
  `ULD_ID` int(11) NOT NULL,
  `SID_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`SID_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `JP_SUB_ITEM_DETAILS_ibfk_1` FOREIGN KEY (`ULD_ID`) REFERENCES `JP_USER_LOGIN_DETAILS` (`ULD_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_SUB_ITEM_DETAILS: ~9 rows (approximately)
DELETE FROM `JP_SUB_ITEM_DETAILS`;
/*!40000 ALTER TABLE `JP_SUB_ITEM_DETAILS` DISABLE KEYS */;
INSERT INTO `JP_SUB_ITEM_DETAILS` (`SID_ID`, `SID_ITEM`, `ULD_ID`, `SID_TIMESTAMP`) VALUES
	(1, 'Item', 1, '2015-07-21 07:40:06'),
	(2, 'Size', 1, '2015-07-21 07:40:06'),
	(3, 'Paper Type', 1, '2015-07-21 07:40:06'),
	(4, 'Paper Weight', 1, '2015-07-21 07:40:06'),
	(5, 'Printing Method', 1, '2015-07-21 07:40:06'),
	(6, 'Printing Process', 1, '2015-07-21 07:40:06'),
	(7, 'Treatment Process', 1, '2015-07-21 07:40:06'),
	(8, 'Finishing Process', 1, '2015-07-21 07:40:06'),
	(9, 'Binding Process', 1, '2015-07-21 07:40:06');
/*!40000 ALTER TABLE `JP_SUB_ITEM_DETAILS` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_USER_ENQUIRY_DETAILS
DROP TABLE IF EXISTS `JP_USER_ENQUIRY_DETAILS`;
CREATE TABLE IF NOT EXISTS `JP_USER_ENQUIRY_DETAILS` (
  `UED_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ULD_ID` int(11) NOT NULL,
  `UED_ENQUIRY_ID` varchar(30) NOT NULL,
  `QD_ID` int(11) DEFAULT NULL,
  `INV_ID` int(11) DEFAULT NULL,
  `UED_DATE` date NOT NULL,
  `UED_PRICE` decimal(12,2) DEFAULT '0.00',
  `ES_ID` int(11) NOT NULL,
  `ULD_POD_IMAGENAME` varchar(60) DEFAULT NULL,
  `ULD_UPLOAD_IMG_NAME` text,
  `UED_PURCHASE_ORDER_NO` varchar(50) DEFAULT NULL,
  `UED_USERSTAMP_ID` int(11) NOT NULL,
  `UED_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`UED_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  KEY `ES_ID` (`ES_ID`),
  CONSTRAINT `JP_USER_ENQUIRY_DETAILS_ibfk_1` FOREIGN KEY (`ULD_ID`) REFERENCES `JP_USER_LOGIN_DETAILS` (`ULD_ID`),
  CONSTRAINT `JP_USER_ENQUIRY_DETAILS_ibfk_2` FOREIGN KEY (`ES_ID`) REFERENCES `JP_ENQUIRY_STATUS` (`ES_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_USER_ENQUIRY_DETAILS: ~0 rows (approximately)
DELETE FROM `JP_USER_ENQUIRY_DETAILS`;
/*!40000 ALTER TABLE `JP_USER_ENQUIRY_DETAILS` DISABLE KEYS */;
/*!40000 ALTER TABLE `JP_USER_ENQUIRY_DETAILS` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_USER_LOGIN_DETAILS
DROP TABLE IF EXISTS `JP_USER_LOGIN_DETAILS`;
CREATE TABLE IF NOT EXISTS `JP_USER_LOGIN_DETAILS` (
  `ULD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ULD_USERNAME` varchar(40) NOT NULL,
  `ULD_PASSWORD` text NOT NULL,
  `ULD_EMAIL` varchar(50) NOT NULL,
  `ULD_NRICNO` varchar(10) DEFAULT NULL,
  `ULD_COMPANY_NAME` varchar(50) NOT NULL,
  `ULD_CONTACT_PERSON` varchar(50) NOT NULL,
  `RC_ID` int(11) NOT NULL,
  `ULD_IMAGE_NAME` varchar(50) DEFAULT NULL,
  `ULD_USERSTAMP_ID` int(11) NOT NULL,
  `ULD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ULD_ID`),
  UNIQUE KEY `ULD_USERNAME` (`ULD_USERNAME`),
  KEY `RC_ID` (`RC_ID`),
  CONSTRAINT `JP_USER_LOGIN_DETAILS_ibfk_1` FOREIGN KEY (`RC_ID`) REFERENCES `JP_ROLE_CREATION` (`RC_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_USER_LOGIN_DETAILS: ~2 rows (approximately)
DELETE FROM `JP_USER_LOGIN_DETAILS`;
/*!40000 ALTER TABLE `JP_USER_LOGIN_DETAILS` DISABLE KEYS */;
INSERT INTO `JP_USER_LOGIN_DETAILS` (`ULD_ID`, `ULD_USERNAME`, `ULD_PASSWORD`, `ULD_EMAIL`, `ULD_NRICNO`, `ULD_COMPANY_NAME`, `ULD_CONTACT_PERSON`, `RC_ID`, `ULD_IMAGE_NAME`, `ULD_USERSTAMP_ID`, `ULD_TIMESTAMP`) VALUES
	(1, 'admin', 'admin', 'abc@gmail.com', NULL, '', '', 1, NULL, 1, '2015-07-21 07:40:06'),
	(2, 'user', 'user', 'abc@gmail.com', NULL, '', '', 2, NULL, 1, '2015-07-21 07:40:06');
/*!40000 ALTER TABLE `JP_USER_LOGIN_DETAILS` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_USER_PRODUCT_DETAILS
DROP TABLE IF EXISTS `JP_USER_PRODUCT_DETAILS`;
CREATE TABLE IF NOT EXISTS `JP_USER_PRODUCT_DETAILS` (
  `PD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `UED_ID` int(11) NOT NULL,
  `PD_JOB_TITLE` varchar(100) DEFAULT NULL,
  `PD_DELIVERY_LOC` text,
  `PD_REQUIRED_DATE` date DEFAULT NULL,
  `ETI_ID` int(11) DEFAULT NULL,
  `PD_SIZE` int(11) DEFAULT NULL,
  `PD_PAPER_TYPE` int(11) DEFAULT NULL,
  `PD_PAPER_WEIGHT` int(11) DEFAULT NULL,
  `PD_PRINTING_METHOD` int(11) DEFAULT NULL,
  `PD_PRINTING_PROCESS` int(11) DEFAULT NULL,
  `PD_TREATMENT_PROCESS` int(11) DEFAULT NULL,
  `PD_FINISHING_PROCESS` int(11) DEFAULT NULL,
  `PD_BINDING_PROCESS` int(11) DEFAULT NULL,
  `PD_QUANTITY` int(11) DEFAULT NULL,
  `PD_PRICE` decimal(10,2) DEFAULT '0.00',
  `PD_DESCRIPTION` text,
  `ULD_ID` int(11) NOT NULL,
  `PD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PD_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  KEY `UED_ID` (`UED_ID`),
  CONSTRAINT `JP_USER_PRODUCT_DETAILS_ibfk_1` FOREIGN KEY (`ULD_ID`) REFERENCES `JP_USER_LOGIN_DETAILS` (`ULD_ID`),
  CONSTRAINT `JP_USER_PRODUCT_DETAILS_ibfk_2` FOREIGN KEY (`UED_ID`) REFERENCES `JP_USER_ENQUIRY_DETAILS` (`UED_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_USER_PRODUCT_DETAILS: ~0 rows (approximately)
DELETE FROM `JP_USER_PRODUCT_DETAILS`;
/*!40000 ALTER TABLE `JP_USER_PRODUCT_DETAILS` DISABLE KEYS */;
/*!40000 ALTER TABLE `JP_USER_PRODUCT_DETAILS` ENABLE KEYS */;


-- Dumping structure for table jhub.JP_USER_RIGHTS_CONFIGURATION
DROP TABLE IF EXISTS `JP_USER_RIGHTS_CONFIGURATION`;
CREATE TABLE IF NOT EXISTS `JP_USER_RIGHTS_CONFIGURATION` (
  `URC_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CGN_ID` int(11) NOT NULL,
  `URC_DATA` text NOT NULL,
  `URC_INITIALIZE_FLAG` char(1) DEFAULT NULL,
  PRIMARY KEY (`URC_ID`),
  KEY `CGN_ID` (`CGN_ID`),
  CONSTRAINT `JP_USER_RIGHTS_CONFIGURATION_ibfk_1` FOREIGN KEY (`CGN_ID`) REFERENCES `JP_CONFIGURATION` (`CGN_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table jhub.JP_USER_RIGHTS_CONFIGURATION: ~9 rows (approximately)
DELETE FROM `JP_USER_RIGHTS_CONFIGURATION`;
/*!40000 ALTER TABLE `JP_USER_RIGHTS_CONFIGURATION` DISABLE KEYS */;
INSERT INTO `JP_USER_RIGHTS_CONFIGURATION` (`URC_ID`, `CGN_ID`, `URC_DATA`, `URC_INITIALIZE_FLAG`) VALUES
	(1, 1, 'dhandapani.sattanathan@ssomens.com', 'X'),
	(2, 2, 'dhandapani.sattanathan@ssomens.com', 'X'),
	(3, 3, 'dhandapani.sattanathan@ssomens.com', 'X'),
	(4, 4, 'localhost', 'X'),
	(5, 5, '3306', 'X'),
	(6, 6, 'safiyullah84@gmail.com', 'X'),
	(7, 7, 'safi984151', 'X'),
	(8, 8, 'tls', 'X'),
	(9, 9, 'smtp.gmail.com', 'X');
/*!40000 ALTER TABLE `JP_USER_RIGHTS_CONFIGURATION` ENABLE KEYS */;


-- Dumping structure for procedure jhub.SP_ENQUIRY_INSERT_UPDATE
DROP PROCEDURE IF EXISTS `SP_ENQUIRY_INSERT_UPDATE`;
DELIMITER //
CREATE  PROCEDURE `SP_ENQUIRY_INSERT_UPDATE`(
SEARCH_OPTION INTEGER,
PDID INTEGER,
USERNAME VARCHAR(40),
ENQ_DATE DATE,
STATUS INTEGER,
PRODNAME VARCHAR(50),
J_PRICE  DECIMAL(12,2),
JPDESCRIPTION TEXT,
UPLOADIMAGE TEXT,
IMAGEDELETE TEXT,
TITLE  VARCHAR(100),
LOCATION TEXT,
SIZE  VARCHAR(50),
PAPERTYPE VARCHAR(50),
PAPERWEIGHT VARCHAR(50),
PRINTINGMETHOD  VARCHAR(50),
PRINTINGPROCESS VARCHAR(50),
TREATMENTPROCESS VARCHAR(50),
FINISHINGPROCESS VARCHAR(50),
BINDINGPROCESS VARCHAR(50),
QUANTITY VARCHAR(50),
REQDATE DATE,
PURCHASE_ORDER_NO VARCHAR(50),
JPUEDID INTEGER,
USERSTAMP VARCHAR(40),
OUT SUCCESS_FLAG TEXT,
OUT ENQ_ID TEXT,
OUT ENQUIRY_DATE DATE)
BEGIN
DECLARE PRODID INTEGER;
DECLARE UEDID INTEGER;
DECLARE ENQUIRYID VARCHAR(30);
DECLARE STATUS_ID INTEGER;
DECLARE MX_QDID TEXT;
DECLARE QDID INTEGER;
DECLARE TOTAL_PRICE DECIMAL(12,2);
DECLARE D_PDID TEXT;
DECLARE INVCOUNT INTEGER;
DECLARE INVID TEXT;
DECLARE MAX_RECVER INTEGER;
DECLARE UEDDATE DATE;
DECLARE REVISED_ENQID VARCHAR(30);
DECLARE R_UEDID INTEGER;
DECLARE OLD_IMG_NAME TEXT;
DECLARE IMG_NAME TEXT;
DECLARE FINAL_IMAGE TEXT;
DECLARE IMAGE1 TEXT;
DECLARE IMAGE2 TEXT;
DECLARE LEN INTEGER;
DECLARE SIZE_ID INTEGER;
DECLARE TYPE_ID INTEGER;
DECLARE WEIGHT_ID INTEGER;
DECLARE METHOD_ID INTEGER;
DECLARE PROCESS_ID INTEGER;
DECLARE TREATMENT_ID INTEGER;
DECLARE FINISHING_ID INTEGER;
DECLARE BINDING_ID INTEGER;
DECLARE QUANTITY_ID INTEGER;
DECLARE ULDID INTEGER;
DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
	ROLLBACK;
	SET SUCCESS_FLAG=0;
END;
START TRANSACTION;
SET AUTOCOMMIT=0;

SET SUCCESS_FLAG=0;

 IF UPLOADIMAGE='' THEN
 	SET UPLOADIMAGE=NULL;
 END IF;
 IF IMAGEDELETE='' THEN
 	SET IMAGEDELETE=NULL;
 END IF;

 SET ULDID=(SELECT ULD_ID FROM JP_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP);

-- NEW QUOTATION INSERT
	IF SEARCH_OPTION=1 THEN
		IF USERNAME IS NOT NULL AND ENQ_DATE IS NOT NULL AND STATUS=1  AND  USERSTAMP IS NOT NULL THEN
			SET ENQ_ID=(SELECT MAX(UED_ID) FROM JP_USER_ENQUIRY_DETAILS)+1;
			IF ENQ_ID IS NULL THEN
				SET ENQ_ID=1;
			END IF;

			IF LENGTH(ENQ_ID)=1 THEN
				SET ENQ_ID=(SELECT CONCAT('0000',ENQ_ID));
			ELSEIF LENGTH(ENQ_ID)=2 THEN
				SET ENQ_ID=(SELECT CONCAT('000',ENQ_ID));
			ELSEIF LENGTH(ENQ_ID)=3 THEN
				SET ENQ_ID=(SELECT CONCAT('00',ENQ_ID));
			ELSEIF LENGTH(ENQ_ID)=4 THEN
				SET ENQ_ID=(SELECT CONCAT('0',ENQ_ID));
			ELSE
				SET ENQ_ID=ENQ_ID;
			END IF;


			SET ENQ_ID=(SELECT CONCAT('ENQ-',ENQ_ID));

			INSERT INTO JP_USER_ENQUIRY_DETAILS(ULD_ID,UED_ENQUIRY_ID,UED_DATE,ES_ID,ULD_UPLOAD_IMG_NAME,UED_USERSTAMP_ID)VALUES
			((SELECT ULD_ID FROM JP_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERNAME),ENQ_ID,ENQ_DATE,STATUS,UPLOADIMAGE,
			ULDID);
			SET SUCCESS_FLAG=1;
			SET ENQUIRY_DATE=ENQ_DATE;

				SET UEDID=(SELECT UED_ID FROM JP_USER_ENQUIRY_DETAILS ORDER BY UED_ID DESC LIMIT 1);

			-- PRODUCT NAME
				IF PRODNAME='' THEN
					SET PRODNAME=NULL;
				END IF;
				IF PRODNAME IS NOT NULL THEN
					SET PRODID=(SELECT ITD_ID FROM JP_ITEM_DETAILS WHERE ITD_ITEM=PRODNAME AND SID_ID=1);
					IF PRODID IS NULL THEN
						INSERT INTO JP_ITEM_DETAILS(SID_ID,ITD_ITEM,ULD_ID)VALUES(1,PRODNAME,ULDID);
						SET PRODID=(SELECT MAX(ITD_ID) FROM JP_ITEM_DETAILS WHERE SID_ID=1);
					END IF;
				END IF;

			-- PRODUCT DESCRIPTION
				IF JPDESCRIPTION='' THEN
					SET JPDESCRIPTION=NULL;
				END IF;

			-- PRODUCT SIZE
				IF SIZE='' THEN
					SET SIZE=NULL;
				END IF;

				IF SIZE IS NOT NULL THEN
					SET SIZE_ID=(SELECT ITD_ID FROM JP_ITEM_DETAILS WHERE SID_ID=2 AND ITD_ITEM=SIZE);
					IF SIZE_ID IS NULL THEN
						INSERT INTO JP_ITEM_DETAILS(SID_ID,ITD_ITEM,ULD_ID)VALUES(2,SIZE,ULDID);
						SET SIZE_ID=(SELECT MAX(ITD_ID) FROM JP_ITEM_DETAILS WHERE SID_ID=2);
					END IF;
				END IF;

			-- PAPER TYPE
				IF PAPERTYPE='' THEN
					SET PAPERTYPE=NULL;
				END IF;

				IF PAPERTYPE IS NOT NULL THEN
					SET TYPE_ID=(SELECT ITD_ID FROM JP_ITEM_DETAILS WHERE SID_ID=3 AND ITD_ITEM=PAPERTYPE);
					IF TYPE_ID IS NULL THEN
						INSERT INTO JP_ITEM_DETAILS(SID_ID,ITD_ITEM,ULD_ID)VALUES(3,PAPERTYPE,ULDID);
						SET TYPE_ID=(SELECT MAX(ITD_ID) FROM JP_ITEM_DETAILS WHERE SID_ID=3);
					END IF;
				END IF;

			-- PAPER WEIGHT
				IF PAPERWEIGHT='' THEN
						SET PAPERWEIGHT=NULL;
				END IF;
				IF PAPERWEIGHT IS NOT NULL THEN
					SET WEIGHT_ID=(SELECT ITD_ID FROM JP_ITEM_DETAILS WHERE SID_ID=4 AND ITD_ITEM=PAPERWEIGHT);
				END IF;

				
			-- PRINTING METHOD
				IF PRINTINGMETHOD='' THEN
					SET PRINTINGMETHOD=NULL;
				END IF;
				IF PRINTINGMETHOD IS NOT NULL THEN
					SET METHOD_ID=(SELECT ITD_ID FROM JP_ITEM_DETAILS WHERE SID_ID=5 AND ITD_ITEM=PRINTINGMETHOD);
				END IF;

				
			-- PRINTING PROCESS
				IF PRINTINGPROCESS='' THEN
					SET PRINTINGPROCESS=NULL;
				END IF;
				IF PRINTINGPROCESS IS NOT NULL THEN
				SET PROCESS_ID=(SELECT ITD_ID FROM JP_ITEM_DETAILS WHERE SID_ID=6 AND ITD_ITEM=PRINTINGPROCESS);
					IF PROCESS_ID IS NULL THEN
						INSERT INTO JP_ITEM_DETAILS(SID_ID,ITD_ITEM,ULD_ID)VALUES(6,PRINTINGPROCESS,ULDID);
						SET PROCESS_ID=(SELECT MAX(ITD_ID) FROM JP_ITEM_DETAILS WHERE SID_ID=6);
					END IF;
				END IF;

				
			-- TREATMENT PROCESS
				IF TREATMENTPROCESS='' THEN
					SET TREATMENTPROCESS=NULL;
				END IF;
				IF TREATMENTPROCESS IS NOT NULL THEN
					SET TREATMENT_ID=(SELECT ITD_ID FROM JP_ITEM_DETAILS WHERE SID_ID=7 AND ITD_ITEM=TREATMENTPROCESS);
					IF TREATMENT_ID IS NULL THEN
						INSERT INTO JP_ITEM_DETAILS(SID_ID,ITD_ITEM,ULD_ID)VALUES(7,TREATMENTPROCESS,ULDID);
						SET TREATMENT_ID=(SELECT MAX(ITD_ID) FROM JP_ITEM_DETAILS WHERE SID_ID=7);
					END IF;
				END IF;

				
			-- FINISHING PROCESS
				IF FINISHINGPROCESS='' THEN
					SET FINISHINGPROCESS=NULL;
				END IF;
				IF FINISHINGPROCESS IS NOT NULL THEN
					SET FINISHING_ID=(SELECT ITD_ID FROM JP_ITEM_DETAILS WHERE SID_ID=8 AND ITD_ITEM=FINISHINGPROCESS);
					IF FINISHING_ID IS NULL THEN
						INSERT INTO JP_ITEM_DETAILS(SID_ID,ITD_ITEM,ULD_ID)VALUES(8,FINISHINGPROCESS,ULDID);
						SET FINISHING_ID=(SELECT MAX(ITD_ID) FROM JP_ITEM_DETAILS WHERE SID_ID=8);
					END IF;
				END IF;

				
			-- BINDING PROCESS
				IF BINDINGPROCESS='' THEN
					SET BINDINGPROCESS=NULL;
				END IF;
				IF BINDINGPROCESS IS NOT NULL THEN
					SET BINDING_ID=(SELECT ITD_ID FROM JP_ITEM_DETAILS WHERE SID_ID=9 AND ITD_ITEM=BINDINGPROCESS);
					IF BINDING_ID IS NULL THEN
						INSERT INTO JP_ITEM_DETAILS(SID_ID,ITD_ITEM,ULD_ID)VALUES(9,BINDINGPROCESS,ULDID);
						SET BINDING_ID=(SELECT MAX(ITD_ID) FROM JP_ITEM_DETAILS WHERE SID_ID=9);
					END IF;
				END IF;

			-- QUANTITY
				IF QUANTITY='' THEN
					SET QUANTITY=NULL;
				END IF;

			
			-- TITLE
				IF TITLE='' THEN
					SET TITLE=NULL;
				END IF;

			-- LOCATION
				IF LOCATION='' THEN
					SET LOCATION=NULL;
				END IF;

				
			-- REQDATE
				IF REQDATE='' THEN
					SET REQDATE=NULL;
				END IF;


			INSERT INTO JP_USER_PRODUCT_DETAILS(UED_ID,PD_JOB_TITLE,PD_DELIVERY_LOC,PD_REQUIRED_DATE,ETI_ID,PD_SIZE,PD_PAPER_TYPE,PD_PAPER_WEIGHT,PD_PRINTING_METHOD,PD_PRINTING_PROCESS,PD_TREATMENT_PROCESS,PD_FINISHING_PROCESS,PD_BINDING_PROCESS,PD_QUANTITY,PD_DESCRIPTION,ULD_ID)VALUES
			(UEDID,TITLE,LOCATION,REQDATE,PRODID,SIZE_ID,TYPE_ID,WEIGHT_ID,METHOD_ID,PROCESS_ID,TREATMENT_ID,FINISHING_ID,BINDING_ID,QUANTITY,JPDESCRIPTION,ULDID);
			SET SUCCESS_FLAG=1;

		END IF;
	END IF;

-- CONFORMED QUOTATION INSERT
IF SEARCH_OPTION=2 THEN
	
	
		IF STATUS=2 AND PDID IS NOT NULL AND J_PRICE IS NOT NULL   THEN

				UPDATE JP_USER_PRODUCT_DETAILS SET PD_PRICE=J_PRICE,ULD_ID=ULDID WHERE PD_ID=PDID;
				SET SUCCESS_FLAG=1;

				SET UEDID=(SELECT DISTINCT UED_ID FROM JP_USER_PRODUCT_DETAILS WHERE PD_ID IN (PDID));
				SET MX_QDID=(SELECT MAX(QD_ID) FROM JP_QUOTATION_DETAILS);
				IF MX_QDID IS NULL THEN
					SET MX_QDID=1;
				ELSE
					SET MX_QDID=MX_QDID+1;
				END IF;

				IF LENGTH(MX_QDID)=1 THEN
				SET MX_QDID=(SELECT CONCAT('0000',MX_QDID));
				ELSEIF LENGTH(MX_QDID)=2 THEN
				SET MX_QDID=(SELECT CONCAT('000',MX_QDID));
				ELSEIF LENGTH(MX_QDID)=3 THEN
				SET MX_QDID=(SELECT CONCAT('00',MX_QDID));
				ELSEIF LENGTH(MX_QDID)=4 THEN
				SET MX_QDID=(SELECT CONCAT('0',MX_QDID));
				ELSE
				SET MX_QDID=MX_QDID;
				END IF;

				SET MX_QDID=(SELECT CONCAT('QT-',MX_QDID));
		IF NOT EXISTS(SELECT UED_ID FROM JP_QUOTATION_DETAILS WHERE UED_ID=UEDID) THEN

			INSERT INTO JP_QUOTATION_DETAILS(UED_ID,QD_QUOTATION_ID,ULD_ID)VALUES(UEDID,MX_QDID,ULDID);
		END IF;

			SET QDID=(SELECT QD_ID FROM JP_QUOTATION_DETAILS WHERE QD_QUOTATION_ID=MX_QDID);
			SET TOTAL_PRICE=(SELECT SUM(PD_PRICE) FROM JP_USER_PRODUCT_DETAILS WHERE UED_ID=UEDID);

			UPDATE JP_USER_ENQUIRY_DETAILS SET QD_ID=QDID,UED_PRICE=TOTAL_PRICE,ES_ID=2,UED_USERSTAMP_ID=ULDID WHERE UED_ID=UEDID;
			SET SUCCESS_FLAG=1;
	
	END IF;
END IF;

IF SEARCH_OPTION=3 THEN
	
		IF STATUS=3 AND JPUEDID IS NOT NULL AND PURCHASE_ORDER_NO IS NOT NULL THEN 

			SET OLD_IMG_NAME=(SELECT ULD_UPLOAD_IMG_NAME FROM JP_USER_ENQUIRY_DETAILS WHERE UED_ID=JPUEDID);
			IF UPLOADIMAGE IS NOT NULL THEN
				IF OLD_IMG_NAME IS NOT NULL THEN
					SET UPLOADIMAGE=(SELECT CONCAT(OLD_IMG_NAME,'/',UPLOADIMAGE));
				END IF;
			END IF;
			IF UPLOADIMAGE IS NULL THEN

				SET UPLOADIMAGE=OLD_IMG_NAME;
			END IF; 
			IF IMAGEDELETE IS NOT NULL THEN
				SET UPLOADIMAGE=(SELECT REPLACE(UPLOADIMAGE,IMAGEDELETE,''));
				SET UPLOADIMAGE=(SELECT REPLACE(UPLOADIMAGE,'//','/'));
				SET IMAGE1=(SELECT SUBSTRING(UPLOADIMAGE,1,1));
				IF IMAGE1='/' THEN
					SET UPLOADIMAGE=(SELECT SUBSTRING(UPLOADIMAGE,2));
				END IF;
				SET IMAGE2=(SELECT SUBSTRING(UPLOADIMAGE,-1));
				IF IMAGE2='/' THEN
					SET LEN=(SELECT LENGTH(UPLOADIMAGE));
					SET UPLOADIMAGE=(SELECT SUBSTRING(UPLOADIMAGE,1,(LEN-1)));
				END IF;

			END IF;
			IF UPLOADIMAGE='' THEN
				SET UPLOADIMAGE=NULL;
			END IF;
			UPDATE JP_USER_ENQUIRY_DETAILS SET ES_ID=3,UED_PURCHASE_ORDER_NO=PURCHASE_ORDER_NO,ULD_UPLOAD_IMG_NAME=UPLOADIMAGE,ULD_ID=ULDID WHERE UED_ID=JPUEDID;
			SET SUCCESS_FLAG=1;
		END IF;
END IF;
COMMIT;
END//
DELIMITER ;


-- Dumping structure for procedure jhub.SP_JP_GET_SPECIAL_CHARACTER_SEPERATED_VALUES
DROP PROCEDURE IF EXISTS `SP_JP_GET_SPECIAL_CHARACTER_SEPERATED_VALUES`;
DELIMITER //
CREATE  PROCEDURE `SP_JP_GET_SPECIAL_CHARACTER_SEPERATED_VALUES`(IN SPECIAL_CHARACTER VARCHAR(30), IN INPUT_STRING_WITH_COMMAS TEXT, OUT VALUE TEXT, OUT REMAINING_STRING TEXT)
BEGIN
DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
ROLLBACK;
END;
START TRANSACTION;
SET @LENGTH = 1;
SET @TEMP = INPUT_STRING_WITH_COMMAS;
SET @SPECIAL_CHAR_LENGTH = LENGTH(SPECIAL_CHARACTER);

		SET @POSITION=(SELECT LOCATE(SPECIAL_CHARACTER, @TEMP,@LENGTH));
		IF @POSITION<=0 THEN
			SET VALUE = @TEMP;
		ELSE
			SELECT SUBSTRING(@TEMP,@LENGTH,@POSITION-1) INTO VALUE;
			SET REMAINING_STRING =(SELECT SUBSTRING(@TEMP,@POSITION+ @SPECIAL_CHAR_LENGTH ));
		END IF;
    
 COMMIT;   
END//
DELIMITER ;


-- Dumping structure for view jhub.VW_USER_PRODUCT_DETAILS
DROP VIEW IF EXISTS `VW_USER_PRODUCT_DETAILS`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `VW_USER_PRODUCT_DETAILS` (
	`UED_ID` INT(11) NOT NULL,
	`PD_ID` INT(11) NOT NULL,
	`PD_JOB_TITLE` VARCHAR(100) NULL COLLATE 'latin1_swedish_ci',
	`PRODUCT_NAME` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`SIZE` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`PAPER_TYPE` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`PAPER_WEIGHT` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`PRINTING_METHOD` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`PRINTING_PROCESS` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`TREATMENT_PROCESS` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`FINISHING_PROCESS` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`BINDING_PROCESS` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`PD_QUANTITY` INT(11) NULL,
	`PD_REQUIRED_DATE` DATE NULL,
	`PD_DELIVERY_LOC` TEXT NULL COLLATE 'latin1_swedish_ci',
	`PD_DESCRIPTION` TEXT NULL COLLATE 'latin1_swedish_ci',
	`PD_PRICE` DECIMAL(10,2) NULL,
	`UED_PRICE` DECIMAL(12,2) NULL
) ENGINE=MyISAM;


-- Dumping structure for view jhub.VW_USER_PRODUCT_DETAILS
DROP VIEW IF EXISTS `VW_USER_PRODUCT_DETAILS`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `VW_USER_PRODUCT_DETAILS`;
CREATE  VIEW `VW_USER_PRODUCT_DETAILS` AS select `UPD`.`UED_ID` AS `UED_ID`,`UPD`.`PD_ID` AS `PD_ID`,`UPD`.`PD_JOB_TITLE` AS `PD_JOB_TITLE`,`ID1`.`ITD_ITEM` AS `PRODUCT_NAME`,`ID2`.`ITD_ITEM` AS `SIZE`,`ID3`.`ITD_ITEM` AS `PAPER_TYPE`,`ID4`.`ITD_ITEM` AS `PAPER_WEIGHT`,`ID5`.`ITD_ITEM` AS `PRINTING_METHOD`,`ID6`.`ITD_ITEM` AS `PRINTING_PROCESS`,`ID7`.`ITD_ITEM` AS `TREATMENT_PROCESS`,`ID8`.`ITD_ITEM` AS `FINISHING_PROCESS`,`ID9`.`ITD_ITEM` AS `BINDING_PROCESS`,`UPD`.`PD_QUANTITY` AS `PD_QUANTITY`,`UPD`.`PD_REQUIRED_DATE` AS `PD_REQUIRED_DATE`,`UPD`.`PD_DELIVERY_LOC` AS `PD_DELIVERY_LOC`,`UPD`.`PD_DESCRIPTION` AS `PD_DESCRIPTION`,`UPD`.`PD_PRICE` AS `PD_PRICE`,`UED`.`UED_PRICE` AS `UED_PRICE` from ((((((((((`JP_USER_PRODUCT_DETAILS` `UPD` left join `JP_ITEM_DETAILS` `ID1` on((`UPD`.`ETI_ID` = `ID1`.`ITD_ID`))) left join `JP_ITEM_DETAILS` `ID2` on((`UPD`.`PD_SIZE` = `ID2`.`ITD_ID`))) left join `JP_ITEM_DETAILS` `ID3` on((`UPD`.`PD_PAPER_TYPE` = `ID3`.`ITD_ID`))) left join `JP_ITEM_DETAILS` `ID4` on((`UPD`.`PD_PAPER_WEIGHT` = `ID4`.`ITD_ID`))) left join `JP_ITEM_DETAILS` `ID5` on((`UPD`.`PD_PRINTING_METHOD` = `ID5`.`ITD_ID`))) left join `JP_ITEM_DETAILS` `ID6` on((`UPD`.`PD_PRINTING_PROCESS` = `ID6`.`ITD_ID`))) left join `JP_ITEM_DETAILS` `ID7` on((`UPD`.`PD_TREATMENT_PROCESS` = `ID7`.`ITD_ID`))) left join `JP_ITEM_DETAILS` `ID8` on((`UPD`.`PD_FINISHING_PROCESS` = `ID8`.`ITD_ID`))) left join `JP_ITEM_DETAILS` `ID9` on((`UPD`.`PD_BINDING_PROCESS` = `ID9`.`ITD_ID`))) join `JP_USER_ENQUIRY_DETAILS` `UED`) where (`UED`.`UED_ID` = `UPD`.`UED_ID`);
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
