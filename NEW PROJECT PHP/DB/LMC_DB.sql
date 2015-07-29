-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.6.16 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for lmc
DROP DATABASE IF EXISTS `lmc`;
CREATE DATABASE IF NOT EXISTS `lmc` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `lmc`;


-- Dumping structure for table lmc_accident_report_details
DROP TABLE IF EXISTS `lmc_accident_report_details`;
CREATE TABLE IF NOT EXISTS `lmc_accident_report_details` (
  `ARD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ARD_DATE` date NOT NULL,
  `ARD_PLACE` varchar(50) NOT NULL,
  `ARD_TYPE_OF_INJURY` varchar(50) NOT NULL,
  `ARD_NATURE_OF_INJURY` varchar(50) NOT NULL,
  `ARD_TIME` time NOT NULL,
  `ARD_LOCATION` varchar(50) NOT NULL,
  `ARD_INJURED_PART` varchar(50) NOT NULL,
  `ARD_MACHINERY_TYPE` varchar(50) DEFAULT NULL,
  `ARD_LM_NO` varchar(25) DEFAULT NULL,
  `ARD_OPERATOR_NAME` char(30) DEFAULT NULL,
  `ARD_NAME` char(30) NOT NULL,
  `ARD_AGE` int(11) NOT NULL,
  `ARD_ADDRESS` text NOT NULL,
  `ARD_NRIC_NO` varchar(10) NOT NULL,
  `ARD_FIN_NO` varchar(10) NOT NULL,
  `ARD_WORK_PERMIT_NO` int(11) NOT NULL,
  `ARD_PASSPORT_NO` varchar(15) NOT NULL,
  `ARD_NATIONALITY` varchar(30) NOT NULL,
  `ARD_SEX` varchar(6) NOT NULL,
  `ARD_DOB` date NOT NULL,
  `ARD_MARTIAL_STATUS` varchar(10) NOT NULL,
  `ARD_DESIGNATION` varchar(25) NOT NULL,
  `ARD_LENGTH_OF_SERVICE` varchar(50) NOT NULL,
  `ARD_WORK_COMMENCEMENT` varchar(3) NOT NULL,
  `ARD_DESCRIPTION` text NOT NULL,
  `ULD_ID` int(11) NOT NULL,
  `ARD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ARD_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_accident_report_details_ibfk_1` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_accident_report_details: ~0 rows (approximately)
DELETE FROM `lmc_accident_report_details`;
/*!40000 ALTER TABLE `lmc_accident_report_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `lmc_accident_report_details` ENABLE KEYS */;


-- Dumping structure for table lmc_basic_menu_profile
DROP TABLE IF EXISTS `lmc_basic_menu_profile`;
CREATE TABLE IF NOT EXISTS `lmc_basic_menu_profile` (
  `BMP_ID` int(11) NOT NULL AUTO_INCREMENT,
  `URC_ID` int(11) NOT NULL,
  `MP_ID` int(11) NOT NULL,
  `ULD_ID` int(11) NOT NULL,
  `BMP_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`BMP_ID`),
  KEY `URC_ID` (`URC_ID`),
  KEY `MP_ID` (`MP_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_basic_menu_profile_ibfk_1` FOREIGN KEY (`URC_ID`) REFERENCES `lmc_user_rights_configuration` (`URC_ID`),
  CONSTRAINT `lmc_basic_menu_profile_ibfk_2` FOREIGN KEY (`MP_ID`) REFERENCES `lmc_menu_profile` (`MP_ID`),
  CONSTRAINT `lmc_basic_menu_profile_ibfk_3` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_basic_menu_profile: ~36 rows (approximately)
DELETE FROM `lmc_basic_menu_profile`;
/*!40000 ALTER TABLE `lmc_basic_menu_profile` DISABLE KEYS */;
INSERT INTO `lmc_basic_menu_profile` (`BMP_ID`, `URC_ID`, `MP_ID`, `ULD_ID`, `BMP_TIMESTAMP`) VALUES
	(1, 1, 1, 1, '2015-03-04 11:30:36'),
	(2, 1, 2, 1, '2015-03-04 11:30:36'),
	(3, 1, 3, 1, '2015-03-04 11:30:36'),
	(4, 1, 4, 1, '2015-03-04 11:30:36'),
	(5, 1, 5, 1, '2015-03-04 11:30:36'),
	(6, 1, 6, 1, '2015-03-04 11:30:36'),
	(7, 1, 7, 1, '2015-03-04 11:30:36'),
	(8, 1, 8, 1, '2015-03-04 11:30:36'),
	(9, 1, 9, 1, '2015-03-04 11:30:36'),
	(10, 1, 10, 1, '2015-03-04 11:30:36'),
	(11, 1, 11, 1, '2015-03-04 11:30:36'),
	(12, 1, 12, 1, '2015-03-04 11:30:36'),
	(13, 2, 1, 1, '2015-03-04 11:30:36'),
	(14, 2, 2, 1, '2015-03-04 11:30:36'),
	(15, 2, 3, 1, '2015-03-04 11:30:36'),
	(16, 2, 4, 1, '2015-03-04 11:30:36'),
	(17, 2, 5, 1, '2015-03-04 11:30:36'),
	(18, 2, 6, 1, '2015-03-04 11:30:36'),
	(19, 2, 7, 1, '2015-03-04 11:30:36'),
	(20, 2, 8, 1, '2015-03-04 11:30:36'),
	(21, 2, 9, 1, '2015-03-04 11:30:36'),
	(22, 2, 10, 1, '2015-03-04 11:30:36'),
	(23, 2, 11, 1, '2015-03-04 11:30:36'),
	(24, 2, 12, 1, '2015-03-04 11:30:36'),
	(25, 3, 1, 1, '2015-03-04 11:30:36'),
	(26, 3, 2, 1, '2015-03-04 11:30:36'),
	(27, 3, 3, 1, '2015-03-04 11:30:36'),
	(28, 3, 4, 1, '2015-03-04 11:30:36'),
	(29, 3, 5, 1, '2015-03-04 11:30:36'),
	(30, 3, 6, 1, '2015-03-04 11:30:36'),
	(31, 3, 7, 1, '2015-03-04 11:30:36'),
	(32, 3, 8, 1, '2015-03-04 11:30:36'),
	(33, 3, 9, 1, '2015-03-04 11:30:36'),
	(34, 3, 10, 1, '2015-03-04 11:30:36'),
	(35, 3, 11, 1, '2015-03-04 11:30:36'),
	(36, 3, 12, 1, '2015-03-04 11:30:36');
/*!40000 ALTER TABLE `lmc_basic_menu_profile` ENABLE KEYS */;


-- Dumping structure for table lmc_basic_role_profile
DROP TABLE IF EXISTS `lmc_basic_role_profile`;
CREATE TABLE IF NOT EXISTS `lmc_basic_role_profile` (
  `BRP_ID` int(11) NOT NULL AUTO_INCREMENT,
  `URC_ID` int(11) NOT NULL,
  `BRP_BR_ID` int(11) NOT NULL,
  `ULD_ID` int(11) NOT NULL,
  `BRP_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`BRP_ID`),
  KEY `URC_ID` (`URC_ID`),
  KEY `BRP_BR_ID` (`BRP_BR_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_basic_role_profile_ibfk_1` FOREIGN KEY (`URC_ID`) REFERENCES `lmc_user_rights_configuration` (`URC_ID`),
  CONSTRAINT `lmc_basic_role_profile_ibfk_2` FOREIGN KEY (`BRP_BR_ID`) REFERENCES `lmc_user_rights_configuration` (`URC_ID`),
  CONSTRAINT `lmc_basic_role_profile_ibfk_3` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_basic_role_profile: ~7 rows (approximately)
DELETE FROM `lmc_basic_role_profile`;
/*!40000 ALTER TABLE `lmc_basic_role_profile` DISABLE KEYS */;
INSERT INTO `lmc_basic_role_profile` (`BRP_ID`, `URC_ID`, `BRP_BR_ID`, `ULD_ID`, `BRP_TIMESTAMP`) VALUES
	(1, 1, 1, 1, '2015-03-04 11:30:35'),
	(2, 1, 2, 1, '2015-03-04 11:30:35'),
	(3, 1, 3, 1, '2015-03-04 11:30:35'),
	(4, 2, 1, 1, '2015-03-04 11:30:35'),
	(5, 2, 2, 1, '2015-03-04 11:30:35'),
	(6, 2, 3, 1, '2015-03-04 11:30:35'),
	(7, 3, 3, 1, '2015-03-04 11:30:35');
/*!40000 ALTER TABLE `lmc_basic_role_profile` ENABLE KEYS */;


-- Dumping structure for table lmc_configuration
DROP TABLE IF EXISTS `lmc_configuration`;
CREATE TABLE IF NOT EXISTS `lmc_configuration` (
  `CGN_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CNP_ID` int(11) NOT NULL,
  `CGN_TYPE` varchar(50) NOT NULL,
  `CGN_NON_IP_FLAG` char(2) DEFAULT NULL,
  PRIMARY KEY (`CGN_ID`),
  UNIQUE KEY `CGN_TYPE` (`CGN_TYPE`),
  KEY `CNP_ID` (`CNP_ID`),
  CONSTRAINT `lmc_configuration_ibfk_1` FOREIGN KEY (`CNP_ID`) REFERENCES `lmc_configuration_profile` (`CNP_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_configuration: ~11 rows (approximately)
DELETE FROM `lmc_configuration`;
/*!40000 ALTER TABLE `lmc_configuration` DISABLE KEYS */;
INSERT INTO `lmc_configuration` (`CGN_ID`, `CNP_ID`, `CGN_TYPE`, `CGN_NON_IP_FLAG`) VALUES
	(1, 3, 'ACCESS RIGHTS ROLES', 'XX'),
	(2, 3, 'SENDER', 'XX'),
	(3, 3, 'TO', 'XX'),
	(4, 3, 'CC', 'XX'),
	(5, 3, 'EMAIL SERVER IP', NULL),
	(6, 3, 'EMPLOYEE TYPE', NULL),
	(7, 3, 'COMPANY START DATE', 'XX'),
	(8, 3, 'IMAGE FOLDER NAME', 'XX'),
	(9, 3, 'DOCUMENT FOLDER NAME', 'XX'),
	(10, 3, 'PORT NO', NULL),
	(11, 2, 'TICKLER HISTORY SEARCH OPTION', NULL);
/*!40000 ALTER TABLE `lmc_configuration` ENABLE KEYS */;


-- Dumping structure for table lmc_configuration_profile
DROP TABLE IF EXISTS `lmc_configuration_profile`;
CREATE TABLE IF NOT EXISTS `lmc_configuration_profile` (
  `CNP_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CNP_DATA` varchar(25) NOT NULL,
  PRIMARY KEY (`CNP_ID`),
  UNIQUE KEY `CNP_DATA` (`CNP_DATA`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_configuration_profile: ~3 rows (approximately)
DELETE FROM `lmc_configuration_profile`;
/*!40000 ALTER TABLE `lmc_configuration_profile` DISABLE KEYS */;
INSERT INTO `lmc_configuration_profile` (`CNP_ID`, `CNP_DATA`) VALUES
	(1, 'GENERAL'),
	(2, 'REPORTS'),
	(3, 'USER RIGHTS');
/*!40000 ALTER TABLE `lmc_configuration_profile` ENABLE KEYS */;


-- Dumping structure for table lmc_email_template
DROP TABLE IF EXISTS `lmc_email_template`;
CREATE TABLE IF NOT EXISTS `lmc_email_template` (
  `ET_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ET_EMAIL_SCRIPT` varchar(100) NOT NULL,
  PRIMARY KEY (`ET_ID`),
  UNIQUE KEY `ET_EMAIL_SCRIPT` (`ET_EMAIL_SCRIPT`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_email_template: ~11 rows (approximately)
DELETE FROM `lmc_email_template`;
/*!40000 ALTER TABLE `lmc_email_template` DISABLE KEYS */;
INSERT INTO `lmc_email_template` (`ET_ID`, `ET_EMAIL_SCRIPT`) VALUES
	(4, 'ABSENT MAIL'),
	(11, 'ATTENDANCE MAIL'),
	(6, 'DAILY REPORT MAIL'),
	(2, 'EMPLOYEE DETAILS MAIL'),
	(3, 'INTRODUCTION MAIL'),
	(1, 'LOGIN CREATION'),
	(5, 'REMINDER MAIL'),
	(8, 'REMINDER MAIL ADMIN'),
	(7, 'REMINDER MAIL USER'),
	(9, 'REPORT UPDATE MAIL'),
	(10, 'TEMP TABLE DROP MAIL');
/*!40000 ALTER TABLE `lmc_email_template` ENABLE KEYS */;


-- Dumping structure for table lmc_email_template_details
DROP TABLE IF EXISTS `lmc_email_template_details`;
CREATE TABLE IF NOT EXISTS `lmc_email_template_details` (
  `ETD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ET_ID` int(11) NOT NULL,
  `ETD_EMAIL_SUBJECT` varchar(1000) NOT NULL,
  `ETD_EMAIL_BODY` text NOT NULL,
  `ULD_ID` int(11) NOT NULL,
  `ETD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ETD_ID`),
  KEY `ET_ID` (`ET_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_email_template_details_ibfk_1` FOREIGN KEY (`ET_ID`) REFERENCES `lmc_email_template` (`ET_ID`),
  CONSTRAINT `lmc_email_template_details_ibfk_2` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_email_template_details: ~11 rows (approximately)
DELETE FROM `lmc_email_template_details`;
/*!40000 ALTER TABLE `lmc_email_template_details` DISABLE KEYS */;
INSERT INTO `lmc_email_template_details` (`ETD_ID`, `ET_ID`, `ETD_EMAIL_SUBJECT`, `ETD_EMAIL_BODY`, `ULD_ID`, `ETD_TIMESTAMP`) VALUES
	(1, 1, 'WELCOME TO LIH MING CONSTRUCTION', 'Dear [LOGINID],^ Welcome to our  LIH MING CONSTRUCTION!^ At the outset, I would like to congratulate you for having fared so well in the interview process and for having made a definite impression in the minds of those who have interacted with you during the interviews. I am sure that going forward, this impression will only grow stronger.^ As a " [DES]", your role is critical in fulfilling the mission of the Information technology Department . We expect you to set an example of diligence, dedication and commitment and contribute your best efforts in making LIH MING CONSTRUCTION a leading organization.^ I hope the induction session you Under going through was informative, and has helped you understand and identify with LIH MING CONSTRUCTION technology better. Please feel free to get in touch with PROJECT MANAGER for any further information / clarifications you may need.You shld follow the rules & regulation,If youY fails any time LIH MING CONSTRUCTION  management will terminate you without any prior notice. ^Demo video link for LIH MING CONSTRUCTION TIME SHEET : [VLINK]', 1, '2015-03-04 11:31:03'),
	(2, 2, 'EMPLOYEE DETAILS', 'PERSONAL DETAILS:^ FIRST NAME: [FNAME]^ LAST NAME : [LNAME]^ TEAM NAME : [TEAMNAME]^ NRIC NO: [NRICNO]^ DOB: [DOB]^ GENDER: [GENDER]^DESIGNATION: [DESG]^ MOBILE NO: [MOBNO]^ NEXT KIN NAME:[KINNAME]^ RELATIONHOOD:[REL]^ ALTERNATE MOBILE NO:[ALTMOBNO]^ EMPLOYEE ADDRESS: [EMPADDRESS]^ BANK ACCOUNT DETAILS:^ BANK NAME:[BANKNAME]^ BRANCH NAME:[BRANCHNAME]^ ACCOUNT NAME:[ACCNAME]^ ACCOUNT NO:[ACCNO]^ IFSC CODE:[IFSCCODE]^ ACCOUNT TYPE:[ACCTYPE]^ BANK ADDRESS:[BANKADDRESS]^ Kindly Check your details,^ If any mistake immediately inform to PROJECT MANAGER. Also submit your AADHAR CARD and DEGREE CERTIFICATE photo copy to our Admin Executive. Wishing you luck for all your assignments and a long and rewarding career at LIH MING CONSTRUCTION.^ Warm Regards,^ ADMIN EXECUTIVE,^ LIH MING CONSTRUCTION .', 1, '2015-03-04 11:31:03'),
	(3, 3, 'INTRODUCTION MAIL', 'Dear all,^ I am pleased to introduce [employee name] who has joined LIH MING CONSTRUCTION as [designation].^ Please join me in extending a warm welcome to [employee name] and wishing him/her success in the new opportunities and challenges ahead.^ Mr/Ms [employee name] can be reached at: [emailid].^ Warm Regards,^ ADMIN EXECUTIVE,^ LIH MING CONSTRUCTION.', 1, '2015-03-04 11:31:03'),
	(4, 4, 'REPORT ENTRY MISSED TO ENTER ON [DATE]', 'HELLO [SADMIN], FOLLOWING EMPLOYEE(S) ARE MISSED TO ENTER THE REPORT', 1, '2015-03-04 11:31:04'),
	(5, 5, 'TIME SHEET REMINDER', 'HELLO [MAILID_USERNAME], PLEASE DO NOT FORGET TO ENTER [DATE] REPORT', 1, '2015-03-04 11:31:04'),
	(6, 6, 'TIME SHEET REPORT', 'HELLO [SADMIN], TIME SHEET REPORT FOR [UNAME] ON : [DATE]', 1, '2015-03-04 11:31:04'),
	(7, 7, 'TIME SHEET REPORT NOT ENTERED', 'HELLO [MAILID_USERNAME], TIME SHEET REPORT NOT ENTERED FOR THE FOLLOWING DAY(S):', 1, '2015-03-04 11:31:04'),
	(8, 8, 'TIME SHEET REPORT MISSING', 'HELLO [SADMIN], TIME SHEET REPORT NOT ENTERED FOR THE FOLLOWING EMPLOYEE(S):', 1, '2015-03-04 11:31:04'),
	(9, 9, 'TIME SHEET UPDATED REPORT', 'UPDATED REPORTS FOR [LOGINID]', 1, '2015-03-04 11:31:04'),
	(10, 10, 'LIST OF TEMPORARY TABLES ON OR BEFORE [CURRENTDATE]', 'PLZ FIND BELOW THE TEMPORARY TABLES LIST, WHICH HAVE BEEN DELETED, DATED ON OR BEFORE [CURRENTDATE]', 1, '2015-03-04 11:31:04'),
	(11, 11, ' LIH MING CONSTRUCTION! TIME SHEET REPORT- [MONTH]', 'HELLO [SADMIN],  LIH MING CONSTRUCTION! TIME SHEET REPORT FOR THE FOLLOWING EMPLOYEE(S) - [MONTH]:, TOTAL NO OF DAYS: [TDAY] DAYS, TOTAL NO OF WORKING DAYS: [WDAY] DAYS', 1, '2015-03-04 11:31:04');
/*!40000 ALTER TABLE `lmc_email_template_details` ENABLE KEYS */;


-- Dumping structure for table lmc_employee_details
DROP TABLE IF EXISTS `lmc_employee_details`;
CREATE TABLE IF NOT EXISTS `lmc_employee_details` (
  `EMP_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ULD_ID` int(11) NOT NULL,
  `EMP_FIRST_NAME` char(50) NOT NULL,
  `EMP_LAST_NAME` char(50) NOT NULL,
  `NRIC_NO` varchar(10) NOT NULL,
  `EMP_DESIGNATION` varchar(50) NOT NULL,
  `EMP_GENDER` varchar(6) NOT NULL,
  `EMP_MOBILE_NUMBER` varchar(8) NOT NULL,
  `EMP_DOB` date NOT NULL,
  `TC_ID` int(11) NOT NULL,
  `EMP_ADDRESS` text NOT NULL,
  `EMP_REMARKS` text,
  `EMP_NEXT_KIN_NAME` char(30) NOT NULL,
  `EMP_RELATIONHOOD` char(30) NOT NULL,
  `EMP_ALT_MOBILE_NO` varchar(8) NOT NULL,
  `EMP_BANK_NAME` varchar(50) NOT NULL,
  `EMP_BRANCH_NAME` varchar(50) NOT NULL,
  `EMP_ACCOUNT_NAME` varchar(50) NOT NULL,
  `EMP_ACCOUNT_NO` varchar(50) NOT NULL,
  `EMP_IFSC_CODE` varchar(50) NOT NULL,
  `EMP_ACCOUNT_TYPE` varchar(15) NOT NULL,
  `EMP_BRANCH_ADDRESS` text NOT NULL,
  `EMP_IMAGE_FOLDER_ID` text NOT NULL,
  `EMP_DOC_FOLDER_ID` text NOT NULL,
  `EMP_USERSTAMP_ID` int(11) NOT NULL,
  `EMP_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`EMP_ID`),
  KEY `TC_ID` (`TC_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  KEY `EMP_USERSTAMP_ID` (`EMP_USERSTAMP_ID`),
  CONSTRAINT `lmc_employee_details_ibfk_1` FOREIGN KEY (`TC_ID`) REFERENCES `lmc_team_creation` (`TC_ID`),
  CONSTRAINT `lmc_employee_details_ibfk_2` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`),
  CONSTRAINT `lmc_employee_details_ibfk_3` FOREIGN KEY (`EMP_USERSTAMP_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_employee_details: ~1 rows (approximately)
DELETE FROM `lmc_employee_details`;
/*!40000 ALTER TABLE `lmc_employee_details` DISABLE KEYS */;
INSERT INTO `lmc_employee_details` (`EMP_ID`, `ULD_ID`, `EMP_FIRST_NAME`, `EMP_LAST_NAME`, `NRIC_NO`, `EMP_DESIGNATION`, `EMP_GENDER`, `EMP_MOBILE_NUMBER`, `EMP_DOB`, `TC_ID`, `EMP_ADDRESS`, `EMP_REMARKS`, `EMP_NEXT_KIN_NAME`, `EMP_RELATIONHOOD`, `EMP_ALT_MOBILE_NO`, `EMP_BANK_NAME`, `EMP_BRANCH_NAME`, `EMP_ACCOUNT_NAME`, `EMP_ACCOUNT_NO`, `EMP_IFSC_CODE`, `EMP_ACCOUNT_TYPE`, `EMP_BRANCH_ADDRESS`, `EMP_IMAGE_FOLDER_ID`, `EMP_DOC_FOLDER_ID`, `EMP_USERSTAMP_ID`, `EMP_TIMESTAMP`) VALUES
	(1, 1, 'SATTANATHAN', 'DHANDAPANI', 'S6093155B', 'TEAM LEADER', 'MALE', '73738399', '1980-01-01', 1, 'SINGAPORE', NULL, 'DHANDAPANI', 'FATHER', '78967890', 'IOB', 'MUTHIALPET', 'SN', '638383983', '63738738', 'SAVINGS', 'MUTHIALEPT', 'SN_20150304_113033', 'SN_20150304_113033', 1, '2015-03-04 11:30:33');
/*!40000 ALTER TABLE `lmc_employee_details` ENABLE KEYS */;


-- Dumping structure for table lmc_equipment_usage_details
DROP TABLE IF EXISTS `lmc_equipment_usage_details`;
CREATE TABLE IF NOT EXISTS `lmc_equipment_usage_details` (
  `EUD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TRD_ID` int(11) NOT NULL,
  `EUD_EQUIPMENT` varchar(30) NOT NULL,
  `EUD_LORRY_NO` varchar(30) NOT NULL,
  `EUD_START_TIME` time NOT NULL,
  `EUD_END_TIME` time NOT NULL,
  `EUD_REMARK` text,
  `ULD_ID` int(11) NOT NULL,
  `EUD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`EUD_ID`),
  KEY `TRD_ID` (`TRD_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_equipment_usage_details_ibfk_1` FOREIGN KEY (`TRD_ID`) REFERENCES `lmc_team_report_details` (`TRD_ID`),
  CONSTRAINT `lmc_equipment_usage_details_ibfk_2` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_equipment_usage_details: ~0 rows (approximately)
DELETE FROM `lmc_equipment_usage_details`;
/*!40000 ALTER TABLE `lmc_equipment_usage_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `lmc_equipment_usage_details` ENABLE KEYS */;


-- Dumping structure for table lmc_error_message_configuration
DROP TABLE IF EXISTS `lmc_error_message_configuration`;
CREATE TABLE IF NOT EXISTS `lmc_error_message_configuration` (
  `EMC_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CNP_ID` int(11) NOT NULL,
  `EMC_CODE` int(11) NOT NULL,
  `EMC_DATA` text NOT NULL,
  `EMC_INITIALIZE_FLAG` char(1) DEFAULT NULL,
  `ULD_ID` int(11) NOT NULL,
  `EMC_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`EMC_ID`),
  KEY `CNP_ID` (`CNP_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_error_message_configuration_ibfk_1` FOREIGN KEY (`CNP_ID`) REFERENCES `lmc_configuration_profile` (`CNP_ID`),
  CONSTRAINT `lmc_error_message_configuration_ibfk_2` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_error_message_configuration: ~143 rows (approximately)
DELETE FROM `lmc_error_message_configuration`;
/*!40000 ALTER TABLE `lmc_error_message_configuration` DISABLE KEYS */;
INSERT INTO `lmc_error_message_configuration` (`EMC_ID`, `CNP_ID`, `EMC_CODE`, `EMC_DATA`, `EMC_INITIALIZE_FLAG`, `ULD_ID`, `EMC_TIMESTAMP`) VALUES
	(1, 1, 1, 'ALPHABETS ONLY', 'X', 1, '2015-03-04 11:30:25'),
	(2, 1, 2, 'NUMBERS ONLY', 'X', 1, '2015-03-04 11:30:25'),
	(3, 1, 3, 'REPORT SAVED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(4, 1, 4, 'REPORT UPDATED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(5, 1, 5, 'REPORT DELETED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(6, 1, 6, 'ALREADY [DATE] REPORT HAS BEEN ENTERED, PLZ USE UPDATE PAGE TO UPDATE IT FURTHER', 'X', 1, '2015-03-04 11:30:25'),
	(7, 1, 7, 'REPORT NOT SAVED', 'X', 1, '2015-03-04 11:30:25'),
	(8, 1, 8, 'REPORT NOT DELETED', 'X', 1, '2015-03-04 11:30:25'),
	(9, 3, 9, 'USER [LOGIN ID] RECORD IS UPDATED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(10, 3, 10, 'USER [LOGIN ID] TERMINATED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(11, 3, 11, 'USER [LOGIN ID] REJOINED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(12, 3, 12, 'NO USER AVAILABLE TO TERMINATE', 'X', 1, '2015-03-04 11:30:25'),
	(13, 3, 13, 'NO USER AVAILABLE TO REJOIN', 'X', 1, '2015-03-04 11:30:25'),
	(14, 3, 14, 'NO USER AVAILABLE TO UPDATE', 'X', 1, '2015-03-04 11:30:25'),
	(15, 3, 15, 'NO DATA AVAILABLE IN USER LOGIN DETAIL TABLE', 'X', 1, '2015-03-04 11:30:25'),
	(16, 1, 16, 'NO DATA AVAILABLE BETWEEN [SDATE] AND [EDATE]', 'X', 1, '2015-03-04 11:30:25'),
	(17, 1, 17, 'REPORT NOT UPDATED', 'X', 1, '2015-03-04 11:30:25'),
	(18, 1, 18, 'NO DATA AVAILABLE FOR [DATE]', 'X', 1, '2015-03-04 11:30:25'),
	(19, 1, 19, 'TEAM [NAME] ALREADY EXISTS', 'X', 1, '2015-03-04 11:30:25'),
	(20, 1, 20, 'AC_ID SHOULD BETWEEN 4 TO 8', 'X', 1, '2015-03-04 11:30:25'),
	(21, 1, 21, 'AC_ID SHOULD BETWEEN 1 TO 3', 'X', 1, '2015-03-04 11:30:25'),
	(22, 1, 22, 'REPORT ALREADY EXISTS', 'X', 1, '2015-03-04 11:30:25'),
	(23, 1, 23, 'BOTH REPORT AND REASON NOT NULL AT A SAME TIME', 'X', 1, '2015-03-04 11:30:25'),
	(24, 1, 24, 'BANDWIDTH SHOULD BE LESS THAN OR EQUAL TO 4 DIGITS', 'X', 1, '2015-03-04 11:30:25'),
	(25, 1, 25, 'BOTH REPORT AND REASON CANNOT BE NULL AT HALF-A-DAY ABSENT', 'X', 1, '2015-03-04 11:30:25'),
	(26, 1, 26, 'PD_ID CANNOT BE NULL FOR HALF-A-DAY PRESENT', 'X', 1, '2015-03-04 11:30:25'),
	(27, 1, 27, 'PD_ID CANNOT BE NULL FOR FULL DAY PRESENT', 'X', 1, '2015-03-04 11:30:25'),
	(28, 1, 28, 'FOR FULL DAY ABSENT PERMISSION SHOULD NOT BE ENTERED', 'X', 1, '2015-03-04 11:30:25'),
	(29, 1, 29, 'FOR ONDUTY PERMISSION SHOULD NOT BE ENTERED', 'X', 1, '2015-03-04 11:30:25'),
	(30, 1, 30, 'REPORT SHOULD BE ENTERED FOR FULL DAY PRESENT', 'X', 1, '2015-03-04 11:30:25'),
	(31, 1, 31, 'REASON SHOULD BE ENTERED FOR FULL DAY ABSENT', 'X', 1, '2015-03-04 11:30:25'),
	(32, 1, 32, 'PD_ID SHOULD NOT BE ENTERED FOR FULL DAY ABSENT', 'X', 1, '2015-03-04 11:30:25'),
	(33, 1, 33, 'PD_ID SHOULD NOT BE ENTERED FOR ON DUTY', 'X', 1, '2015-03-04 11:30:25'),
	(34, 1, 34, 'DESIGNATION SHOULD BE UPPERCASE ONLY', 'X', 1, '2015-03-04 11:30:25'),
	(35, 1, 35, 'DOB: [DOB] SHOULD BE GREATER THAN OR EQUAL TO 18 YEARS', 'X', 1, '2015-03-04 11:30:25'),
	(36, 1, 36, 'DOB: [DOB] SHOULD BE NOT BE GREATER THAN TODAY DATE [CURDATE]', 'X', 1, '2015-03-04 11:30:25'),
	(37, 1, 37, 'MOBILE NO: [MOB NO] SHOULD BE EQUAL TO 10 DIGITS', 'X', 1, '2015-03-04 11:30:25'),
	(38, 1, 38, 'PROJECT NAME SHOULD BE UPPERCASE ONLY', 'X', 1, '2015-03-04 11:30:25'),
	(39, 1, 39, 'PROJECT DESCRIPTION SHOULD BE UPPERCASE ONLY', 'X', 1, '2015-03-04 11:30:25'),
	(40, 3, 40, 'ENTER VALID E-MAIL ID', 'X', 1, '2015-03-04 11:30:25'),
	(41, 3, 41, 'NO USER AVAILABLE TO UPDATE', 'X', 1, '2015-03-04 11:30:25'),
	(42, 3, 42, 'EMAIL ID ALREADY EXISTS', 'X', 1, '2015-03-04 11:30:25'),
	(43, 3, 43, 'ROLE :[NAME] ALREADY EXISTS', 'X', 1, '2015-03-04 11:30:25'),
	(44, 3, 44, 'ROLE CREATED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(45, 3, 45, 'USER [NAME] CREATED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(46, 3, 46, 'USER [NAME] UPDATED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(47, 3, 47, 'ROLE UPDATED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(48, 3, 48, 'USER NAME :[NAME] ALREADY EXISTS', 'X', 1, '2015-03-04 11:30:25'),
	(49, 3, 49, 'NO ROLES AVAILABLE TO UPDATE', 'X', 1, '2015-03-04 11:30:25'),
	(50, 3, 50, 'NO BASIC ROLE AVAILABLE FOR [USERID]', 'X', 1, '2015-03-04 11:30:25'),
	(51, 3, 51, 'BASIC PROFILE ACCESS ALREADY GIVEN ,USE SEARCH AND UPDATE', 'X', 1, '2015-03-04 11:30:25'),
	(52, 3, 52, 'BASIC PROFILE CREATED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(53, 3, 53, 'BASIC PROFILE UPDATED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(54, 3, 54, 'NO DATA AVAILABLE FOR THE BASIC ROLE [NAME]', 'X', 1, '2015-03-04 11:30:25'),
	(55, 3, 55, 'ENTER VALID EMAIL ADDRESS OF SSOMENS.COM/GMAIL.COM', 'X', 1, '2015-03-04 11:30:25'),
	(56, 3, 56, 'RECORD NOT UPDATED', 'X', 1, '2015-03-04 11:30:25'),
	(57, 3, 57, 'CHECK CALENDER API ENABLED', 'X', 1, '2015-03-04 11:30:25'),
	(58, 3, 58, 'YOU DO NOT HAVE PERMISSION TO ACCESS THE FOLDER', 'X', 1, '2015-03-04 11:30:25'),
	(59, 3, 59, 'CALENDAR NAME / ID IS WRONG OR MISSING IN CONFIG TABLE.PLZ,CHECK IN CONFIGURATION TABLE.', 'X', 1, '2015-03-04 11:30:25'),
	(60, 3, 60, 'CALENDER/SITE OWNER ONLY CAN ABLE TO SHARE CALENDER/SITE', 'X', 1, '2015-03-04 11:30:25'),
	(61, 3, 61, 'NO ACCESS AVAILABLE FOR LOGIN ID : [LOGIN ID]', 'X', 1, '2015-03-04 11:30:25'),
	(62, 1, 62, 'PROJECT NAME ALREADY EXISTS', 'X', 1, '2015-03-04 11:30:25'),
	(63, 1, 63, 'PROJECT SAVED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(64, 3, 64, 'PAGE ACCESS REVOKED', 'X', 1, '2015-03-04 11:30:25'),
	(65, 3, 65, 'PAGE ACCESS GRANTED', 'X', 1, '2015-03-04 11:30:25'),
	(66, 2, 66, 'REPORTDATE- [RSDATE] SHOULD GREATER THAN [PROJECT NAME] PROJECT STARTDATE- [PSDATE]', 'X', 1, '2015-03-04 11:30:25'),
	(67, 2, 67, 'BANDWIDTH - [BW] MB SHOULD NOT BE GREATER THAN 1000 MB', 'X', 1, '2015-03-04 11:30:25'),
	(68, 2, 68, 'REPORT FOR THE DATE [DD/MM/YY] ALREADY EXISTS FOR THE LOGIN ID [LOGIN]', 'X', 1, '2015-03-04 11:30:25'),
	(69, 1, 69, 'EMPLOYEE RECORD SAVED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(70, 1, 70, 'CONTACT NO SHOULD BE 10 DIGITS', 'X', 1, '2015-03-04 11:30:25'),
	(71, 1, 71, 'RECORD NOT SAVED', 'X', 1, '2015-03-04 11:30:25'),
	(72, 1, 72, 'NO USER AVAILABLE TO ENTER THE DETAILS ,USE SEARCH/UPDATE FORM', 'X', 1, '2015-03-04 11:30:25'),
	(73, 2, 73, 'YOUR SEARCH NOT MATCH FOR ANY EMPLOYEE', 'X', 1, '2015-03-04 11:30:25'),
	(74, 2, 74, 'TICKLER HISTORY FOR EMPLOYEE: [LOGINID]', 'X', 1, '2015-03-04 11:30:25'),
	(75, 2, 75, 'NO DATA AVAILABLE FOR THIS EMPLOYEE NAME: [LOGINID]', 'X', 1, '2015-03-04 11:30:25'),
	(76, 1, 76, 'EMPLOYEE DETAILS RECORD UPDATED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(77, 1, 77, 'NO DATA AVAILABLE IN EMPLOYEE DETAILS', 'X', 1, '2015-03-04 11:30:25'),
	(78, 1, 78, 'DETAILS OF THE EMPLOYEE NAME : [NAME]', 'X', 1, '2015-03-04 11:30:25'),
	(79, 1, 79, 'PROJECT NOT SAVED', 'X', 1, '2015-03-04 11:30:25'),
	(80, 1, 80, 'PROJECT UPDATED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(81, 1, 81, 'PROJECT NOT UPDATED', 'X', 1, '2015-03-04 11:30:25'),
	(82, 2, 82, 'NO DATA AVAILABLE FOR THIS PROJECT: [NAME]', 'X', 1, '2015-03-04 11:30:25'),
	(83, 1, 83, 'NO DATA AVAILABLE', 'X', 1, '2015-03-04 11:30:25'),
	(84, 1, 84, 'REPORT ALREADY ENTERED FOR THIS WEEK,PLZ USE UPDATE PAGE TO UPDATE IT FURTHER', 'X', 1, '2015-03-04 11:30:25'),
	(85, 1, 85, 'EMAIL TEMPLATE RECORD SAVED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(86, 1, 86, 'SCRIPT NAME ALREADY EXISTS', 'X', 1, '2015-03-04 11:30:25'),
	(87, 1, 87, 'NO RECORDS AVAILABLE IN EMAIL TEMPLATE', 'X', 1, '2015-03-04 11:30:25'),
	(88, 1, 88, 'EMAIL TEMPLATE RECORD UPDATED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(89, 1, 89, 'DETAILS OF THE [SCRIPT]', 'X', 1, '2015-03-04 11:30:25'),
	(90, 1, 90, 'PATCH FILE [FILENAME] EXECUTED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(91, 1, 91, 'PATCH FILE [FILENAME] ALREADY EXECUTED.RUN SOME OTHER FILE', 'X', 1, '2015-03-04 11:30:25'),
	(92, 1, 92, 'PATCH FILE [FILENAME] HAVING ISSUE', 'X', 1, '2015-03-04 11:30:25'),
	(93, 1, 93, 'PUBLIC HOLIDAY SAVED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(94, 1, 94, 'ENTER VALID ID', 'X', 1, '2015-03-04 11:30:25'),
	(95, 3, 95, 'LOGIN ID [NAME] NOT CREATED', 'X', 1, '2015-03-04 11:30:25'),
	(96, 1, 96, 'PUBLIC HOLIDAY ALREADY ENTERED', 'X', 1, '2015-03-04 11:30:25'),
	(97, 1, 97, 'DOC / SS ID IS WRONG OR CHECK IN CONFIGURATION OR GET ACCESS', 'X', 1, '2015-03-04 11:30:25'),
	(98, 2, 98, 'REPORT FOR [LOGINID] BETWEEN [STARTDATE] AND [ENDDATE]', 'X', 1, '2015-03-04 11:30:25'),
	(99, 5, 99, 'DETAILS FOR ALL PROJECT(S)', 'X', 1, '2015-03-04 11:30:25'),
	(100, 2, 100, 'EMPLOYEE(S) BANDWIDTH USAGE FOR [MONTH]', 'X', 1, '2015-03-04 11:30:25'),
	(101, 2, 101, 'BANDWIDTH FOR [LOGINID] ON [MONTH]', 'X', 1, '2015-03-04 11:30:25'),
	(102, 2, 102, 'DOOR ACCESS DETAILS FOR EMPLOYEES', 'X', 1, '2015-03-04 11:30:25'),
	(103, 2, 103, 'ATTENDANCE REPORT FOR [EMPLOYEE] ON [MONTH]', 'X', 1, '2015-03-04 11:30:25'),
	(104, 2, 104, 'ATTENDANCE REPORT FOR [MONTH]', 'X', 1, '2015-03-04 11:30:25'),
	(105, 2, 105, 'REPORT ENTRY MISSED DETAILS FOR [MONTH]', 'X', 1, '2015-03-04 11:30:25'),
	(106, 2, 106, 'PROJECT REVENUE FOR [MONTH]', 'X', 1, '2015-03-04 11:30:25'),
	(107, 2, 107, 'PROJECT REVENUE FOR [MONTH] BETWEEN [STARTDATE] AND [ENDDATE]', 'X', 1, '2015-03-04 11:30:25'),
	(108, 2, 108, 'PROJECT REVENUE FOR [LOGINID] FOR [PROJECTNAME]', 'X', 1, '2015-03-04 11:30:25'),
	(109, 2, 109, 'REPORT(S) DETAILS FOR [DATE]', 'X', 1, '2015-03-04 11:30:25'),
	(110, 2, 110, 'WEEKLY REPORT DETAILS BETWEEN [STARTDATE] AND [ENDDATE]', 'X', 1, '2015-03-04 11:30:25'),
	(111, 2, 111, 'PROJECT REVENUE FOR [PROJECTNAME]', 'X', 1, '2015-03-04 11:30:25'),
	(112, 2, 112, 'PROJECT REVENUE FOR [LOGINID] BETWEEN [STARTDATE] AND [ENDDATE] IN [PROJECTNAME]', 'X', 1, '2015-03-04 11:30:25'),
	(113, 3, 113, 'YOU DO NOT HAVE PERMISSION TO SHARE/UNSHARE THE SS [SSID]', 'X', 1, '2015-03-04 11:30:25'),
	(114, 3, 114, 'YOU DO NOT HAVE PERMISSION TO CREATE EVENT IN THIS CALENDER', 'X', 1, '2015-03-04 11:30:25'),
	(115, 3, 115, 'NO PROJECT AVAILABLE', 'X', 1, '2015-03-04 11:30:25'),
	(116, 3, 116, '[LOGIN ID] HAVING REPORTS UPTO [DATE].SO NOT ABLE TO TERMINATE', 'X', 1, '2015-03-04 11:30:25'),
	(117, 3, 117, 'PROJECT ACCESS HAS GIVEN TO [LOGINID]', 'X', 1, '2015-03-04 11:30:25'),
	(118, 3, 118, 'PROJECT ACCESS UPDATED FOR [LOGIN ID]', 'X', 1, '2015-03-04 11:30:25'),
	(119, 1, 119, 'TODAY CLOCK IN TIME:[TIME]', 'X', 1, '2015-03-04 11:30:25'),
	(120, 1, 120, 'PLZ CLOCK IN TO ENTER PRESENT REPORT', 'X', 1, '2015-03-04 11:30:25'),
	(121, 1, 121, 'CLOCK IN/OUT DETAILS FOR [LOGINID] BETWEEN [STARTDATE] AND [ENDDATE]', 'X', 1, '2015-03-04 11:30:25'),
	(122, 1, 122, 'CLOCK IN/OUT DETAILS FOR [DATE]', 'X', 1, '2015-03-04 11:30:25'),
	(123, 2, 123, 'REPORT LOCATION CANNOT BE UNDEFINED', 'X', 1, '2015-03-04 11:30:25'),
	(124, 1, 124, 'ALLOW BROWSER TO SHARE LOCATION', 'X', 1, '2015-03-04 11:30:25'),
	(125, 1, 125, 'DETAILS OF SELECTED TYPE :[TYPE]', 'X', 1, '2015-03-04 11:30:25'),
	(126, 1, 126, 'CONFIGURATION RECORD FOR [MODULE NAME] UPDATED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(127, 1, 127, 'NO RECORD MATCH FOR THE SELECTED TYPE : [TYPE]', 'X', 1, '2015-03-04 11:30:25'),
	(128, 1, 128, 'CONFIGURATION RECORD FOR [MODULE NAME] DELETED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(129, 1, 129, 'CONFIGURATION RECORD CANNOT BE DELETED', 'X', 1, '2015-03-04 11:30:25'),
	(130, 1, 130, 'CONFIGURATION RECORD FOR [MODULE NAME] SAVED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(131, 1, 131, 'CONFIGURATION DATA FOR THE [TYPE] ALREADY EXISTS GIVE ANOTHER ONE', 'X', 1, '2015-03-04 11:30:25'),
	(132, 1, 132, 'YOU DO NOT HAVE PERMISSION TO ACCESS THE FOLDER [FID]', 'X', 1, '2015-03-04 11:30:25'),
	(133, 1, 133, 'PDF/JPEG/JPG/PNG FILES ARE ONLY ALLOWED!!!', 'X', 1, '2015-03-04 11:30:25'),
	(134, 1, 134, 'NO INPUT TYPE AVAILABLE FOR [MODULE NAME]', 'X', 1, '2015-03-04 11:30:25'),
	(135, 2, 135, 'THIS FOLDERID ALREADY CREATED FOR [LOGINID]', 'X', 1, '2015-03-04 11:30:25'),
	(136, 2, 136, 'REPORTDATE- [RSDATE] SHOULD LESS THAN [PROJECT NAME] PROJECT ENDDATE- [PEDATE]', 'X', 1, '2015-03-04 11:30:25'),
	(137, 2, 137, 'PROJECT [PROJECT] HAVING REPORT UPTO [EDATE].SO CANNOT ABLE TO UPDATE ENDDATE', 'X', 1, '2015-03-04 11:30:25'),
	(138, 3, 138, 'PASSWORD DOES NOT MATCH WITH CONFIRM PASSWORD', 'X', 1, '2015-03-04 11:30:25'),
	(139, 3, 139, 'PASSWORD MUST HAVE AT LEAST 8 CHARACTERS', 'X', 1, '2015-03-04 11:30:25'),
	(140, 3, 140, 'INCCORRECT USERNAME/PASSWORD', 'X', 1, '2015-03-04 11:30:25'),
	(141, 2, 141, 'FILE UPLOADED SUCCESSFULLY', 'X', 1, '2015-03-04 11:30:25'),
	(142, 2, 142, 'FILE NOT UPLOADED', 'X', 1, '2015-03-04 11:30:25'),
	(143, 2, 143, 'END TIME SHOULD GREATER THAN START TIME', 'X', 1, '2015-03-04 11:30:25');
/*!40000 ALTER TABLE `lmc_error_message_configuration` ENABLE KEYS */;


-- Dumping structure for table lmc_fitting_usage
DROP TABLE IF EXISTS `lmc_fitting_usage`;
CREATE TABLE IF NOT EXISTS `lmc_fitting_usage` (
  `FU_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FU_ITEMS` varchar(50) NOT NULL,
  PRIMARY KEY (`FU_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_fitting_usage: ~9 rows (approximately)
DELETE FROM `lmc_fitting_usage`;
/*!40000 ALTER TABLE `lmc_fitting_usage` DISABLE KEYS */;
INSERT INTO `lmc_fitting_usage` (`FU_ID`, `FU_ITEMS`) VALUES
	(1, 'COUPLER'),
	(2, 'ELBOW (22/45/90)'),
	(3, 'STUD FLANGE'),
	(4, 'REDUCER'),
	(5, 'END CAP'),
	(6, 'PE END VALUE'),
	(7, 'TAPPING TEE'),
	(8, 'ELECTRIC BALL MARKER'),
	(9, 'PVC WARNING SLAB');
/*!40000 ALTER TABLE `lmc_fitting_usage` ENABLE KEYS */;


-- Dumping structure for table lmc_fitting_usage_details
DROP TABLE IF EXISTS `lmc_fitting_usage_details`;
CREATE TABLE IF NOT EXISTS `lmc_fitting_usage_details` (
  `FUD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FU_ID` int(11) NOT NULL,
  `TRD_ID` int(11) NOT NULL,
  `FUD_SIZE` varchar(15) DEFAULT NULL,
  `FUD_QUANTITY` varchar(15) DEFAULT NULL,
  `FUD_REMARK` text,
  `ULD_ID` int(11) NOT NULL,
  `FUD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`FUD_ID`),
  KEY `FU_ID` (`FU_ID`),
  KEY `TRD_ID` (`TRD_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_fitting_usage_details_ibfk_1` FOREIGN KEY (`FU_ID`) REFERENCES `lmc_fitting_usage` (`FU_ID`),
  CONSTRAINT `lmc_fitting_usage_details_ibfk_2` FOREIGN KEY (`TRD_ID`) REFERENCES `lmc_team_report_details` (`TRD_ID`),
  CONSTRAINT `lmc_fitting_usage_details_ibfk_3` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_fitting_usage_details: ~0 rows (approximately)
DELETE FROM `lmc_fitting_usage_details`;
/*!40000 ALTER TABLE `lmc_fitting_usage_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `lmc_fitting_usage_details` ENABLE KEYS */;


-- Dumping structure for table lmc_machinery_equipment_transfer
DROP TABLE IF EXISTS `lmc_machinery_equipment_transfer`;
CREATE TABLE IF NOT EXISTS `lmc_machinery_equipment_transfer` (
  `MET_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TRD_ID` int(11) NOT NULL,
  `MET_FROM_LORRY_NO` varchar(20) NOT NULL,
  `MET_TO_LORRY_NO` varchar(20) NOT NULL,
  `MET_ITEM` varchar(30) NOT NULL,
  `MET_REMARK` text,
  `ULD_ID` int(11) NOT NULL,
  `MET_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`MET_ID`),
  KEY `TRD_ID` (`TRD_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_machinery_equipment_transfer_ibfk_1` FOREIGN KEY (`TRD_ID`) REFERENCES `lmc_team_report_details` (`TRD_ID`),
  CONSTRAINT `lmc_machinery_equipment_transfer_ibfk_2` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_machinery_equipment_transfer: ~0 rows (approximately)
DELETE FROM `lmc_machinery_equipment_transfer`;
/*!40000 ALTER TABLE `lmc_machinery_equipment_transfer` DISABLE KEYS */;
/*!40000 ALTER TABLE `lmc_machinery_equipment_transfer` ENABLE KEYS */;


-- Dumping structure for table lmc_machinery_usage
DROP TABLE IF EXISTS `lmc_machinery_usage`;
CREATE TABLE IF NOT EXISTS `lmc_machinery_usage` (
  `MCU_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MCU_MACHINERY_TYPE` varchar(30) NOT NULL,
  PRIMARY KEY (`MCU_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_machinery_usage: ~6 rows (approximately)
DELETE FROM `lmc_machinery_usage`;
/*!40000 ALTER TABLE `lmc_machinery_usage` DISABLE KEYS */;
INSERT INTO `lmc_machinery_usage` (`MCU_ID`, `MCU_MACHINERY_TYPE`) VALUES
	(1, 'TEAM LORRY'),
	(2, 'YK 2059'),
	(3, 'MINI EXCAVATOR'),
	(4, 'HYNDAI 145'),
	(5, 'KOMATSU 138'),
	(6, 'AIR COMPRESSOR 125');
/*!40000 ALTER TABLE `lmc_machinery_usage` ENABLE KEYS */;


-- Dumping structure for table lmc_machinery_usage_details
DROP TABLE IF EXISTS `lmc_machinery_usage_details`;
CREATE TABLE IF NOT EXISTS `lmc_machinery_usage_details` (
  `MAC_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TRD_ID` int(11) NOT NULL,
  `MCU_ID` int(11) NOT NULL,
  `MAC_START_TIME` time NOT NULL,
  `MAC_END_TIME` time NOT NULL,
  `MAC_REMARK` text,
  `ULD_ID` int(11) NOT NULL,
  `MAC_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`MAC_ID`),
  KEY `MCU_ID` (`MCU_ID`),
  KEY `TRD_ID` (`TRD_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_machinery_usage_details_ibfk_1` FOREIGN KEY (`MCU_ID`) REFERENCES `lmc_machinery_usage` (`MCU_ID`),
  CONSTRAINT `lmc_machinery_usage_details_ibfk_2` FOREIGN KEY (`TRD_ID`) REFERENCES `lmc_team_report_details` (`TRD_ID`),
  CONSTRAINT `lmc_machinery_usage_details_ibfk_3` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_machinery_usage_details: ~0 rows (approximately)
DELETE FROM `lmc_machinery_usage_details`;
/*!40000 ALTER TABLE `lmc_machinery_usage_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `lmc_machinery_usage_details` ENABLE KEYS */;


-- Dumping structure for table lmc_material_usage
DROP TABLE IF EXISTS `lmc_material_usage`;
CREATE TABLE IF NOT EXISTS `lmc_material_usage` (
  `MU_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MU_ITEMS` varchar(50) NOT NULL,
  PRIMARY KEY (`MU_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_material_usage: ~10 rows (approximately)
DELETE FROM `lmc_material_usage`;
/*!40000 ALTER TABLE `lmc_material_usage` DISABLE KEYS */;
INSERT INTO `lmc_material_usage` (`MU_ID`, `MU_ITEMS`) VALUES
	(1, 'PREMIX'),
	(2, 'Q/DUST'),
	(3, 'G-STONE'),
	(4, 'CONCRETE SAND'),
	(5, 'CEMENT'),
	(6, 'TOP-SOIL'),
	(7, 'TURF (GRASS)'),
	(8, 'MANHOLE (R/T)'),
	(9, 'CHAMBER (R/T)'),
	(10, 'DIESEL');
/*!40000 ALTER TABLE `lmc_material_usage` ENABLE KEYS */;


-- Dumping structure for table lmc_material_usage_details
DROP TABLE IF EXISTS `lmc_material_usage_details`;
CREATE TABLE IF NOT EXISTS `lmc_material_usage_details` (
  `MUD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MU_ID` int(11) NOT NULL,
  `TRD_ID` int(11) NOT NULL,
  `MUD_RECEIPT_NO` varchar(25) NOT NULL,
  `MUD_QUANTITY` int(11) NOT NULL,
  `ULD_ID` int(11) NOT NULL,
  `MUD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`MUD_ID`),
  KEY `MU_ID` (`MU_ID`),
  KEY `TRD_ID` (`TRD_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_material_usage_details_ibfk_1` FOREIGN KEY (`MU_ID`) REFERENCES `lmc_material_usage` (`MU_ID`),
  CONSTRAINT `lmc_material_usage_details_ibfk_2` FOREIGN KEY (`TRD_ID`) REFERENCES `lmc_team_report_details` (`TRD_ID`),
  CONSTRAINT `lmc_material_usage_details_ibfk_3` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_material_usage_details: ~0 rows (approximately)
DELETE FROM `lmc_material_usage_details`;
/*!40000 ALTER TABLE `lmc_material_usage_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `lmc_material_usage_details` ENABLE KEYS */;


-- Dumping structure for table lmc_menu_profile
DROP TABLE IF EXISTS `lmc_menu_profile`;
CREATE TABLE IF NOT EXISTS `lmc_menu_profile` (
  `MP_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MP_MNAME` varchar(25) NOT NULL,
  `MP_MSUB` varchar(50) NOT NULL,
  `MP_MSUBMENU` varchar(60) DEFAULT NULL,
  `MP_MFILENAME` varchar(100) NOT NULL,
  `MP_SCRIPT_FLAG` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`MP_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_menu_profile: ~12 rows (approximately)
DELETE FROM `lmc_menu_profile`;
/*!40000 ALTER TABLE `lmc_menu_profile` DISABLE KEYS */;
INSERT INTO `lmc_menu_profile` (`MP_ID`, `MP_MNAME`, `MP_MSUB`, `MP_MSUBMENU`, `MP_MFILENAME`, `MP_SCRIPT_FLAG`) VALUES
	(1, 'ACCESS RIGHTS', 'ACCESS RIGHTS-SEARCH/UPDATE', NULL, 'FORM_ACCESS_RIGHTS_ACCESS_RIGHTS-SEARCH_UPDATE', NULL),
	(2, 'ACCESS RIGHTS', 'TERMINATE-SEARCH/UPDATE', NULL, 'FORM_ACCESS_RIGHTS_TERMINATE-SEARCH_UPDATE', NULL),
	(3, 'ACCESS RIGHTS', 'USER SEARCH DETAILS', NULL, 'FORM_ACCESS_RIGHTS_USER_SEARCH_DETAIL', NULL),
	(4, 'ACCESS RIGHTS', 'SITE MAINTENANCE', NULL, 'FORM_ACCESS_RIGHTS_SITE_MAINTENANCE', NULL),
	(5, 'PERMITS', 'ENTRY', NULL, 'FORM_PERMITS_ENTRY', NULL),
	(6, 'PERMITS', 'SEARCH', NULL, 'FORM_PERMITS_SEARCH', NULL),
	(7, 'PERMITS', 'UPDATE', NULL, 'FORM_PERMITS_UPDATE', NULL),
	(8, 'AUDIT', 'AUDIT HISTORY', NULL, 'FORM_AUDIT_AUDIT_HISTORY', NULL),
	(9, 'EMAIL', 'ENTRY', NULL, 'FORM_EMAIL_ENTRY', NULL),
	(10, 'EMAIL', 'SEARCH/UPDATE', NULL, 'FORM_EMAIL_SEARCH_UPDATE', NULL),
	(11, 'ACCIDENT', 'ENTRY', NULL, 'FORM_ACCIDENT_ENTRY', NULL),
	(12, 'ACCIDENT', 'SEARCH UPDATE', NULL, 'FORM_ACCIDENT_SEARCH_UPDATE', NULL);
/*!40000 ALTER TABLE `lmc_menu_profile` ENABLE KEYS */;


-- Dumping structure for table lmc_rental_machinery_details
DROP TABLE IF EXISTS `lmc_rental_machinery_details`;
CREATE TABLE IF NOT EXISTS `lmc_rental_machinery_details` (
  `RMD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TRD_ID` int(11) NOT NULL,
  `RMD_LORRY_NO` varchar(20) NOT NULL,
  `RMD_THROWEARTH_STORE` int(11) NOT NULL,
  `RMD_THROWEARTH_OUTSIDE` int(11) NOT NULL,
  `RMD_START_TIME` time NOT NULL,
  `RMD_END_TIME` time NOT NULL,
  `RMD_REMARK` text,
  `ULD_ID` int(11) NOT NULL,
  `RMD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`RMD_ID`),
  KEY `TRD_ID` (`TRD_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_rental_machinery_details_ibfk_1` FOREIGN KEY (`TRD_ID`) REFERENCES `lmc_team_report_details` (`TRD_ID`),
  CONSTRAINT `lmc_rental_machinery_details_ibfk_2` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_rental_machinery_details: ~0 rows (approximately)
DELETE FROM `lmc_rental_machinery_details`;
/*!40000 ALTER TABLE `lmc_rental_machinery_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `lmc_rental_machinery_details` ENABLE KEYS */;


-- Dumping structure for table lmc_report_configuration
DROP TABLE IF EXISTS `lmc_report_configuration`;
CREATE TABLE IF NOT EXISTS `lmc_report_configuration` (
  `RC_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CGN_ID` int(11) NOT NULL,
  `RC_DATA` text NOT NULL,
  `RC_INITIALIZE_FLAG` char(1) DEFAULT NULL,
  `ULD_ID` int(11) NOT NULL,
  `RC_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`RC_ID`),
  KEY `CGN_ID` (`CGN_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_report_configuration_ibfk_1` FOREIGN KEY (`CGN_ID`) REFERENCES `lmc_configuration` (`CGN_ID`),
  CONSTRAINT `lmc_report_configuration_ibfk_2` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_report_configuration: ~2 rows (approximately)
DELETE FROM `lmc_report_configuration`;
/*!40000 ALTER TABLE `lmc_report_configuration` DISABLE KEYS */;
INSERT INTO `lmc_report_configuration` (`RC_ID`, `CGN_ID`, `RC_DATA`, `RC_INITIALIZE_FLAG`, `ULD_ID`, `RC_TIMESTAMP`) VALUES
	(1, 10, 'SEARCH BY EMPLOYEE', 'X', 1, '2015-03-04 11:30:27'),
	(2, 10, 'SEARCH BY TEAM', 'X', 1, '2015-03-04 11:30:27');
/*!40000 ALTER TABLE `lmc_report_configuration` ENABLE KEYS */;


-- Dumping structure for table lmc_role_creation
DROP TABLE IF EXISTS `lmc_role_creation`;
CREATE TABLE IF NOT EXISTS `lmc_role_creation` (
  `RC_ID` int(11) NOT NULL AUTO_INCREMENT,
  `URC_ID` int(11) NOT NULL,
  `RC_NAME` varchar(15) NOT NULL,
  `RC_USERSTAMP` varchar(50) NOT NULL,
  `RC_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`RC_ID`),
  UNIQUE KEY `RC_NAME` (`RC_NAME`),
  KEY `URC_ID` (`URC_ID`),
  CONSTRAINT `lmc_role_creation_ibfk_1` FOREIGN KEY (`URC_ID`) REFERENCES `lmc_user_rights_configuration` (`URC_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_role_creation: ~4 rows (approximately)
DELETE FROM `lmc_role_creation`;
/*!40000 ALTER TABLE `lmc_role_creation` DISABLE KEYS */;
INSERT INTO `lmc_role_creation` (`RC_ID`, `URC_ID`, `RC_NAME`, `RC_USERSTAMP`, `RC_TIMESTAMP`) VALUES
	(1, 1, 'ADMIN', 'lmc', '2015-03-04 11:30:22'),
	(2, 2, 'SUPER ADMIN', 'lmc', '2015-03-04 11:30:22'),
	(3, 3, 'USER', 'lmc', '2015-03-04 11:30:22');
/*!40000 ALTER TABLE `lmc_role_creation` ENABLE KEYS */;


-- Dumping structure for table lmc_site_visit_details
DROP TABLE IF EXISTS `lmc_site_visit_details`;
CREATE TABLE IF NOT EXISTS `lmc_site_visit_details` (
  `SVD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TRD_ID` int(11) NOT NULL,
  `SVD_NAME` char(50) NOT NULL,
  `SVD_DESIGNATION` varchar(50) NOT NULL,
  `SVD_START_TIME` time NOT NULL,
  `SVD_END_TIME` time NOT NULL,
  `SVD_REMARK` text,
  `ULD_ID` int(11) NOT NULL,
  `SVD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`SVD_ID`),
  KEY `TRD_ID` (`TRD_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_site_visit_details_ibfk_1` FOREIGN KEY (`TRD_ID`) REFERENCES `lmc_team_report_details` (`TRD_ID`),
  CONSTRAINT `lmc_site_visit_details_ibfk_2` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_site_visit_details: ~0 rows (approximately)
DELETE FROM `lmc_site_visit_details`;
/*!40000 ALTER TABLE `lmc_site_visit_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `lmc_site_visit_details` ENABLE KEYS */;


-- Dumping structure for table lmc_team_creation
DROP TABLE IF EXISTS `lmc_team_creation`;
CREATE TABLE IF NOT EXISTS `lmc_team_creation` (
  `TC_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TEAM_NAME` varchar(25) NOT NULL,
  `ULD_ID` int(11) NOT NULL,
  `TC_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`TC_ID`),
  UNIQUE KEY `TEAM_NAME` (`TEAM_NAME`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_team_creation: ~1 rows (approximately)
DELETE FROM `lmc_team_creation`;
/*!40000 ALTER TABLE `lmc_team_creation` DISABLE KEYS */;
INSERT INTO `lmc_team_creation` (`TC_ID`, `TEAM_NAME`, `ULD_ID`, `TC_TIMESTAMP`) VALUES
	(1, 'TEAM-1', 1, '2015-03-04 11:41:50');
/*!40000 ALTER TABLE `lmc_team_creation` ENABLE KEYS */;


-- Dumping structure for table lmc_team_employee_report_details
DROP TABLE IF EXISTS `lmc_team_employee_report_details`;
CREATE TABLE IF NOT EXISTS `lmc_team_employee_report_details` (
  `TERD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TRD_ID` int(11) NOT NULL,
  `EMP_ID` int(11) NOT NULL,
  `TERD_START_TIME` time NOT NULL,
  `TERD_END_TIME` time NOT NULL,
  `TERD_OT` decimal(3,1) DEFAULT NULL,
  `TERD_REMARK` text,
  `ULD_ID` int(11) NOT NULL,
  `TERD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`TERD_ID`),
  KEY `TRD_ID` (`TRD_ID`),
  KEY `EMP_ID` (`EMP_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_team_employee_report_details_ibfk_1` FOREIGN KEY (`TRD_ID`) REFERENCES `lmc_team_report_details` (`TRD_ID`),
  CONSTRAINT `lmc_team_employee_report_details_ibfk_2` FOREIGN KEY (`EMP_ID`) REFERENCES `lmc_employee_details` (`EMP_ID`),
  CONSTRAINT `lmc_team_employee_report_details_ibfk_3` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_team_employee_report_details: ~0 rows (approximately)
DELETE FROM `lmc_team_employee_report_details`;
/*!40000 ALTER TABLE `lmc_team_employee_report_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `lmc_team_employee_report_details` ENABLE KEYS */;


-- Dumping structure for table lmc_team_job
DROP TABLE IF EXISTS `lmc_team_job`;
CREATE TABLE IF NOT EXISTS `lmc_team_job` (
  `TJ_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TRD_ID` int(11) NOT NULL,
  `TJ_PIPE_LAID` varchar(20) NOT NULL,
  `TJ_SIZE` int(11) NOT NULL,
  `TJ_LENGTH` int(11) NOT NULL,
  `ULD_ID` int(11) NOT NULL,
  `TJ_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`TJ_ID`),
  KEY `TRD_ID` (`TRD_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_team_job_ibfk_1` FOREIGN KEY (`TRD_ID`) REFERENCES `lmc_team_report_details` (`TRD_ID`),
  CONSTRAINT `lmc_team_job_ibfk_2` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_team_job: ~0 rows (approximately)
DELETE FROM `lmc_team_job`;
/*!40000 ALTER TABLE `lmc_team_job` DISABLE KEYS */;
/*!40000 ALTER TABLE `lmc_team_job` ENABLE KEYS */;


-- Dumping structure for table lmc_team_report_details
DROP TABLE IF EXISTS `lmc_team_report_details`;
CREATE TABLE IF NOT EXISTS `lmc_team_report_details` (
  `TRD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `EMP_ID` int(11) NOT NULL,
  `TRD_DATE` date NOT NULL,
  `TRD_LOCATION` text NOT NULL,
  `TRD_CONTRACT_NO` int(11) NOT NULL,
  `TC_ID` int(11) NOT NULL,
  `TRD_REACH_SITE` time NOT NULL,
  `TRD_LEAVE_SITE` time NOT NULL,
  `TOJ_ID` varchar(12) DEFAULT NULL,
  `TRD_WEATHER_REASON` varchar(30) DEFAULT NULL,
  `TRD_WEATHER_FROM_TIME` time DEFAULT NULL,
  `TRD_WEATHER_TO_TIME` time DEFAULT NULL,
  `TRD_PIPE_TESTING` varchar(50) NOT NULL,
  `TRD_START_PRESSURE` text NOT NULL,
  `TRD_END_PRESSURE` text NOT NULL,
  `TRD_REMARK` text,
  `TRD_DOC_FILE_NAME` text,
  `TRD_IMG_FILE_NAME` text NOT NULL,
  `ULD_ID` int(11) NOT NULL,
  `TRD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`TRD_ID`),
  KEY `TC_ID` (`TC_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  KEY `EMP_ID` (`EMP_ID`),
  CONSTRAINT `lmc_team_report_details_ibfk_1` FOREIGN KEY (`TC_ID`) REFERENCES `lmc_team_creation` (`TC_ID`),
  CONSTRAINT `lmc_team_report_details_ibfk_2` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`),
  CONSTRAINT `lmc_team_report_details_ibfk_3` FOREIGN KEY (`EMP_ID`) REFERENCES `lmc_employee_details` (`EMP_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_team_report_details: ~0 rows (approximately)
DELETE FROM `lmc_team_report_details`;
/*!40000 ALTER TABLE `lmc_team_report_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `lmc_team_report_details` ENABLE KEYS */;


-- Dumping structure for table lmc_tickler_history
DROP TABLE IF EXISTS `lmc_tickler_history`;
CREATE TABLE IF NOT EXISTS `lmc_tickler_history` (
  `TH_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TP_ID` int(11) NOT NULL,
  `EMP_ID` int(11) DEFAULT NULL,
  `TTIP_ID` int(11) NOT NULL,
  `TH_OLD_VALUE` text NOT NULL,
  `TH_NEW_VALUE` text,
  `TH_USERSTAMP_ID` int(11) NOT NULL,
  `TH_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`TH_ID`),
  KEY `TP_ID` (`TP_ID`),
  KEY `TTIP_ID` (`TTIP_ID`),
  CONSTRAINT `lmc_tickler_history_ibfk_1` FOREIGN KEY (`TP_ID`) REFERENCES `lmc_tickler_profile` (`TP_ID`),
  CONSTRAINT `lmc_tickler_history_ibfk_2` FOREIGN KEY (`TTIP_ID`) REFERENCES `lmc_tickler_tabid_profile` (`TTIP_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_tickler_history: ~0 rows (approximately)
DELETE FROM `lmc_tickler_history`;
/*!40000 ALTER TABLE `lmc_tickler_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `lmc_tickler_history` ENABLE KEYS */;


-- Dumping structure for table lmc_tickler_profile
DROP TABLE IF EXISTS `lmc_tickler_profile`;
CREATE TABLE IF NOT EXISTS `lmc_tickler_profile` (
  `TP_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TP_TYPE` char(10) NOT NULL,
  PRIMARY KEY (`TP_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_tickler_profile: ~2 rows (approximately)
DELETE FROM `lmc_tickler_profile`;
/*!40000 ALTER TABLE `lmc_tickler_profile` DISABLE KEYS */;
INSERT INTO `lmc_tickler_profile` (`TP_ID`, `TP_TYPE`) VALUES
	(1, 'UPDATION'),
	(2, 'DELETION');
/*!40000 ALTER TABLE `lmc_tickler_profile` ENABLE KEYS */;


-- Dumping structure for table lmc_tickler_tabid_profile
DROP TABLE IF EXISTS `lmc_tickler_tabid_profile`;
CREATE TABLE IF NOT EXISTS `lmc_tickler_tabid_profile` (
  `TTIP_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TTIP_DATA` varchar(50) NOT NULL,
  PRIMARY KEY (`TTIP_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_tickler_tabid_profile: ~33 rows (approximately)
DELETE FROM `lmc_tickler_tabid_profile`;
/*!40000 ALTER TABLE `lmc_tickler_tabid_profile` DISABLE KEYS */;
INSERT INTO `lmc_tickler_tabid_profile` (`TTIP_ID`, `TTIP_DATA`) VALUES
	(1, 'LMC_MENU_PROFILE'),
	(2, 'LMC_ROLE_CREATION'),
	(3, 'LMC_USER_LOGIN_DETAILS'),
	(4, 'LMC_USER_MENU_DETAILS'),
	(5, 'LMC_USER_ACCESS'),
	(6, 'LMC_BASIC_ROLE_PROFILE'),
	(7, 'LMC_BASIC_MENU_PROFILE'),
	(8, 'LMC_CONFIGURATION_PROFILE'),
	(9, 'LMC_CONFIGURATION'),
	(10, 'LMC_ERROR_MESSAGE_CONFIGURATION'),
	(11, 'LMC_USER_RIGHTS_CONFIGURATION'),
	(12, 'LMC_EMAIL_TEMPLATE'),
	(13, 'LMC_EMAIL_TEMPLATE_DETAILS'),
	(14, 'LMC_EMPLOYEE_DETAILS'),
	(15, 'LMC_TICKLER_PROFILE'),
	(16, 'LMC_TICKLER_HISTORY'),
	(17, 'LMC_TICKLER_TABID_PROFILE'),
	(18, 'LMC_TEAM_CREATION'),
	(19, 'LMC_TYPE_OF_JOB'),
	(20, 'LMC_TEAM_REPORT_DETAILS'),
	(21, 'LMC_TEAM_JOB'),
	(22, 'LMC_TEAM_EMPLOYEE_REPORT_DETAILS'),
	(23, 'LMC_SITE_VISIT_DETAILS'),
	(24, 'LMC_MACHINERY_EQUIPMENT_TRANSFER'),
	(25, 'LMC_MACHINERY_USAGE'),
	(26, 'LMC_FITTING_USAGE'),
	(27, 'LMC_MATERIAL_USAGE'),
	(28, 'LMC_MACHINERY_USAGE_DETAILS'),
	(29, 'LMC_FITTING_USAGE_DETAILS'),
	(30, 'LMC_MATERIAL_USAGE_DETAILS'),
	(31, 'LMC_RENTAL_MACHINERY_DETAILS'),
	(32, 'LMC_EQUIPMENT_USAGE_DETAILS'),
	(33, 'LMC_ACCIDENT_REPORT_DETAILS');
/*!40000 ALTER TABLE `lmc_tickler_tabid_profile` ENABLE KEYS */;


-- Dumping structure for table lmc_type_of_job
DROP TABLE IF EXISTS `lmc_type_of_job`;
CREATE TABLE IF NOT EXISTS `lmc_type_of_job` (
  `TOJ_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TOJ_JOB` varchar(50) NOT NULL,
  `ULD_ID` int(11) NOT NULL,
  `TOJ_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`TOJ_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_type_of_job_ibfk_1` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_type_of_job: ~6 rows (approximately)
DELETE FROM `lmc_type_of_job`;
/*!40000 ALTER TABLE `lmc_type_of_job` DISABLE KEYS */;
INSERT INTO `lmc_type_of_job` (`TOJ_ID`, `TOJ_JOB`, `ULD_ID`, `TOJ_TIMESTAMP`) VALUES
	(1, 'LAYING', 1, '2015-03-04 11:30:28'),
	(2, 'RD CROSSING', 1, '2015-03-04 11:30:28'),
	(3, 'DRAIN CROSSING', 1, '2015-03-04 11:30:28'),
	(4, 'BULK EXCAVATION', 1, '2015-03-04 11:30:28'),
	(5, 'CONNECTION', 1, '2015-03-04 11:30:28'),
	(6, 'REINSTATEMENT', 1, '2015-03-04 11:30:28');
/*!40000 ALTER TABLE `lmc_type_of_job` ENABLE KEYS */;


-- Dumping structure for table lmc_user_access
DROP TABLE IF EXISTS `lmc_user_access`;
CREATE TABLE IF NOT EXISTS `lmc_user_access` (
  `UA_ID` int(11) NOT NULL AUTO_INCREMENT,
  `RC_ID` int(11) NOT NULL,
  `ULD_ID` int(11) NOT NULL,
  `UA_REC_VER` int(11) NOT NULL,
  `UA_JOIN_DATE` date NOT NULL,
  `UA_JOIN` char(1) DEFAULT NULL,
  `UA_END_DATE` date DEFAULT NULL,
  `UA_TERMINATE` char(1) DEFAULT NULL,
  `UA_REASON` text,
  `UA_EMP_TYPE` int(11) NOT NULL,
  `UA_FILE_NAME` text,
  `UA_USERSTAMP` varchar(50) NOT NULL,
  `UA_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`UA_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  KEY `RC_ID` (`RC_ID`),
  CONSTRAINT `lmc_user_access_ibfk_1` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`),
  CONSTRAINT `lmc_user_access_ibfk_2` FOREIGN KEY (`RC_ID`) REFERENCES `lmc_role_creation` (`RC_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_user_access: ~1 rows (approximately)
DELETE FROM `lmc_user_access`;
/*!40000 ALTER TABLE `lmc_user_access` DISABLE KEYS */;
INSERT INTO `lmc_user_access` (`UA_ID`, `RC_ID`, `ULD_ID`, `UA_REC_VER`, `UA_JOIN_DATE`, `UA_JOIN`, `UA_END_DATE`, `UA_TERMINATE`, `UA_REASON`, `UA_EMP_TYPE`, `UA_FILE_NAME`, `UA_USERSTAMP`, `UA_TIMESTAMP`) VALUES
	(1, 1, 1, 1, '2015-03-04', 'X', NULL, NULL, NULL, 4, NULL, 'lmc', '2015-03-04 11:30:32');
/*!40000 ALTER TABLE `lmc_user_access` ENABLE KEYS */;


-- Dumping structure for table lmc_user_login_details
DROP TABLE IF EXISTS `lmc_user_login_details`;
CREATE TABLE IF NOT EXISTS `lmc_user_login_details` (
  `ULD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ULD_USERNAME` varchar(40) NOT NULL,
  `ULD_PASSWORD` text NOT NULL,
  `ULD_USERSTAMP` varchar(50) NOT NULL,
  `ULD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ULD_ID`),
  UNIQUE KEY `ULD_USERNAME` (`ULD_USERNAME`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_user_login_details: ~1 rows (approximately)
DELETE FROM `lmc_user_login_details`;
/*!40000 ALTER TABLE `lmc_user_login_details` DISABLE KEYS */;
INSERT INTO `lmc_user_login_details` (`ULD_ID`, `ULD_USERNAME`, `ULD_PASSWORD`, `ULD_USERSTAMP`, `ULD_TIMESTAMP`) VALUES
	(1, 'lmc', '2dd0fb43933dc59cfd47b5a4b8ae1fbe', 'lmc', '2015-03-04 11:30:22');
/*!40000 ALTER TABLE `lmc_user_login_details` ENABLE KEYS */;


-- Dumping structure for table lmc_user_menu_details
DROP TABLE IF EXISTS `lmc_user_menu_details`;
CREATE TABLE IF NOT EXISTS `lmc_user_menu_details` (
  `UMD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MP_ID` int(11) NOT NULL,
  `RC_ID` int(11) NOT NULL,
  `ULD_ID` int(11) NOT NULL,
  `UMD_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`UMD_ID`),
  KEY `MP_ID` (`MP_ID`),
  KEY `RC_ID` (`RC_ID`),
  KEY `ULD_ID` (`ULD_ID`),
  CONSTRAINT `lmc_user_menu_details_ibfk_1` FOREIGN KEY (`MP_ID`) REFERENCES `lmc_menu_profile` (`MP_ID`),
  CONSTRAINT `lmc_user_menu_details_ibfk_2` FOREIGN KEY (`RC_ID`) REFERENCES `lmc_role_creation` (`RC_ID`),
  CONSTRAINT `lmc_user_menu_details_ibfk_3` FOREIGN KEY (`ULD_ID`) REFERENCES `lmc_user_login_details` (`ULD_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_user_menu_details: ~26 rows (approximately)
DELETE FROM `lmc_user_menu_details`;
/*!40000 ALTER TABLE `lmc_user_menu_details` DISABLE KEYS */;
INSERT INTO `lmc_user_menu_details` (`UMD_ID`, `MP_ID`, `RC_ID`, `ULD_ID`, `UMD_TIMESTAMP`) VALUES
	(1, 1, 1, 1, '2015-03-04 11:30:34'),
	(2, 2, 1, 1, '2015-03-04 11:30:35'),
	(3, 3, 1, 1, '2015-03-04 11:30:35'),
	(4, 4, 1, 1, '2015-03-04 11:30:35'),
	(5, 5, 1, 1, '2015-03-04 11:30:35'),
	(6, 6, 1, 1, '2015-03-04 11:30:35'),
	(7, 7, 1, 1, '2015-03-04 11:30:35'),
	(8, 8, 1, 1, '2015-03-04 11:30:35'),
	(9, 9, 1, 1, '2015-03-04 11:30:35'),
	(10, 10, 1, 1, '2015-03-04 11:30:35'),
	(11, 11, 1, 1, '2015-03-04 11:30:35'),
	(12, 12, 1, 1, '2015-03-04 11:30:35'),
	(13, 1, 2, 1, '2015-03-04 11:30:35'),
	(14, 2, 2, 1, '2015-03-04 11:30:35'),
	(15, 3, 2, 1, '2015-03-04 11:30:35'),
	(16, 4, 2, 1, '2015-03-04 11:30:35'),
	(17, 5, 2, 1, '2015-03-04 11:30:35'),
	(18, 6, 2, 1, '2015-03-04 11:30:35'),
	(19, 7, 2, 1, '2015-03-04 11:30:35'),
	(20, 8, 2, 1, '2015-03-04 11:30:35'),
	(21, 9, 2, 1, '2015-03-04 11:30:35'),
	(22, 10, 2, 1, '2015-03-04 11:30:35'),
	(23, 11, 2, 1, '2015-03-04 11:30:35'),
	(24, 12, 2, 1, '2015-03-04 11:30:35'),
	(25, 5, 3, 1, '2015-03-04 11:30:35'),
	(26, 6, 3, 1, '2015-03-04 11:30:35');
/*!40000 ALTER TABLE `lmc_user_menu_details` ENABLE KEYS */;


-- Dumping structure for table lmc_user_rights_configuration
DROP TABLE IF EXISTS `lmc_user_rights_configuration`;
CREATE TABLE IF NOT EXISTS `lmc_user_rights_configuration` (
  `URC_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CGN_ID` int(11) NOT NULL,
  `URC_DATA` text NOT NULL,
  `URC_INITIALIZE_FLAG` char(1) DEFAULT NULL,
  `URC_USERSTAMP` varchar(50) NOT NULL,
  `URC_TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`URC_ID`),
  KEY `CGN_ID` (`CGN_ID`),
  CONSTRAINT `lmc_user_rights_configuration_ibfk_1` FOREIGN KEY (`CGN_ID`) REFERENCES `lmc_configuration` (`CGN_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table lmc_user_rights_configuration: ~13 rows (approximately)
DELETE FROM `lmc_user_rights_configuration`;
/*!40000 ALTER TABLE `lmc_user_rights_configuration` DISABLE KEYS */;
INSERT INTO `lmc_user_rights_configuration` (`URC_ID`, `CGN_ID`, `URC_DATA`, `URC_INITIALIZE_FLAG`, `URC_USERSTAMP`, `URC_TIMESTAMP`) VALUES
	(1, 1, 'ADMIN', 'X', 'lmc', '2015-03-04 11:30:26'),
	(2, 1, 'SUPER ADMIN', 'X', 'lmc', '2015-03-04 11:30:26'),
	(3, 1, 'USER', 'X', 'lmc', '2015-03-04 11:30:26'),
	(4, 6, 'PERMANENT', 'X', 'lmc', '2015-03-04 11:30:26'),
	(5, 6, 'TEMPORARY', 'X', 'lmc', '2015-03-04 11:30:26'),
	(6, 6, 'TRAINEE', 'X', 'lmc', '2015-03-04 11:30:26'),
	(7, 7, '2014-01-01', 'X', 'lmc', '2015-03-04 11:30:26'),
	(8, 8, 'LMC_REPORT_IMAGE', 'X', 'lmc', '2015-03-04 11:30:26'),
	(9, 9, 'LMC_DOCUMENT', 'X', 'lmc', '2015-03-04 11:30:26'),
	(10, 5, '192.168.1.118', 'X', 'lmc', '2015-03-04 11:30:26'),
	(11, 10, '3306', 'X', 'lmc', '2015-03-04 11:30:26'),
	(12, 3, 'dhandapani.sattanathan@ssomens.com', 'X', 'lmc', '2015-03-04 11:30:26'),
	(13, 4, 'dhandapani.sattanathan@ssomens.com', 'X', 'lmc', '2015-03-04 11:30:26');
/*!40000 ALTER TABLE `lmc_user_rights_configuration` ENABLE KEYS */;


-- Dumping structure for procedure SP_LMC_CONFIGURATION_USER_RIGHTS_EMAIL_TICKLER_TABLE_CREATION
DROP PROCEDURE IF EXISTS `SP_LMC_CONFIGURATION_USER_RIGHTS_EMAIL_TICKLER_TABLE_CREATION`;
DELIMITER //
CREATE  PROCEDURE `SP_LMC_CONFIGURATION_USER_RIGHTS_EMAIL_TICKLER_TABLE_CREATION`(
OUT SUCCESS_MESSAGE TEXT)
BEGIN

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN 
		ROLLBACK;
		SET SUCCESS_MESSAGE = 0;
	END;
	START TRANSACTION;
	
		SET FOREIGN_KEY_CHECKS = 0;
		
-- CONFIGURATION_PROFILE TABLE CREATION QUERY
		DROP TABLE IF EXISTS LMC_CONFIGURATION_PROFILE;
		CREATE TABLE LMC_CONFIGURATION_PROFILE(
		CNP_ID INTEGER NOT NULL	AUTO_INCREMENT,
		CNP_DATA VARCHAR(25) UNIQUE	NOT NULL,
		PRIMARY KEY(CNP_ID));

		SET @ALTER_CONFIGURATION_PROFILE = (SELECT CONCAT('ALTER TABLE LMC_CONFIGURATION_PROFILE AUTO_INCREMENT = 0'));
		PREPARE ALTER_CONFIGURATION_PROFILE_STMT FROM @ALTER_CONFIGURATION_PROFILE;
		EXECUTE ALTER_CONFIGURATION_PROFILE_STMT;

-- CONFIGURATION TABLE CREATION
		DROP TABLE IF EXISTS LMC_CONFIGURATION;
		CREATE TABLE LMC_CONFIGURATION(
		CGN_ID INTEGER NOT NULL	AUTO_INCREMENT,
		CNP_ID INTEGER NOT NULL,
		CGN_TYPE VARCHAR(50) UNIQUE	NOT NULL,
		CGN_NON_IP_FLAG	CHAR(2) NULL,
		PRIMARY KEY(CGN_ID),
		FOREIGN KEY(CNP_ID) REFERENCES LMC_CONFIGURATION_PROFILE (CNP_ID));

		SET @ALTER_CONFIGURATION = (SELECT CONCAT('ALTER TABLE LMC_CONFIGURATION AUTO_INCREMENT = 0'));
		PREPARE ALTER_CONFIGURATION_STMT FROM @ALTER_CONFIGURATION;
		EXECUTE ALTER_CONFIGURATION_STMT;

-- ERROR_MESSAGE_CONFIGURATION TABLE CREATION
		DROP TABLE IF EXISTS LMC_ERROR_MESSAGE_CONFIGURATION;
		CREATE TABLE LMC_ERROR_MESSAGE_CONFIGURATION(
		EMC_ID INTEGER NOT NULL	AUTO_INCREMENT,
		CNP_ID INTEGER NOT NULL,
		EMC_CODE INTEGER NOT NULL,
		EMC_DATA TEXT NOT NULL,
		EMC_INITIALIZE_FLAG	CHAR(1) NULL,
		ULD_ID INTEGER NOT NULL,
		EMC_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(EMC_ID),
		FOREIGN KEY(CNP_ID) REFERENCES LMC_CONFIGURATION_PROFILE (CNP_ID), 
		FOREIGN KEY(ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));

		SET @ALTER_ERROR_MESSAGE_CONFIGURATION = (SELECT CONCAT('ALTER TABLE LMC_ERROR_MESSAGE_CONFIGURATION AUTO_INCREMENT = 0'));
		PREPARE ALTER_ERROR_MESSAGE_CONFIGURATION_STMT FROM @ALTER_ERROR_MESSAGE_CONFIGURATION;
		EXECUTE ALTER_ERROR_MESSAGE_CONFIGURATION_STMT;

-- USER_RIGHTS_CONFIGURATION TABLE CREATION
		DROP TABLE IF EXISTS LMC_USER_RIGHTS_CONFIGURATION;
		CREATE TABLE LMC_USER_RIGHTS_CONFIGURATION(
		URC_ID INTEGER NOT NULL	AUTO_INCREMENT,
		CGN_ID INTEGER NOT NULL,
		URC_DATA TEXT NOT NULL,
		URC_INITIALIZE_FLAG	CHAR(1) NULL,
		URC_USERSTAMP VARCHAR(50) NOT NULL,
		URC_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(URC_ID),
		FOREIGN KEY(CGN_ID) REFERENCES LMC_CONFIGURATION (CGN_ID));
		SET @ALTER_USER_RIGHTS_CONFIGURATION = (SELECT CONCAT('ALTER TABLE LMC_USER_RIGHTS_CONFIGURATION AUTO_INCREMENT = 0'));
		PREPARE ALTER_USER_RIGHTS_CONFIGURATION_STMT FROM @ALTER_USER_RIGHTS_CONFIGURATION;
		EXECUTE ALTER_USER_RIGHTS_CONFIGURATION_STMT;

		-- REPORT_CONFIGURATION TABLE CREATION
		DROP TABLE IF EXISTS LMC_REPORT_CONFIGURATION;
		CREATE TABLE LMC_REPORT_CONFIGURATION(
		RC_ID INTEGER NOT NULL	AUTO_INCREMENT,
		CGN_ID INTEGER NOT NULL,
		RC_DATA	TEXT NOT NULL,
		RC_INITIALIZE_FLAG CHAR(1) NULL,
		ULD_ID INTEGER NOT NULL,
		RC_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(RC_ID),
		FOREIGN KEY(CGN_ID) REFERENCES LMC_CONFIGURATION (CGN_ID),
		FOREIGN KEY(ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));

		SET @ALTER_REPORT_CONFIGURATION = (SELECT CONCAT('ALTER TABLE LMC_REPORT_CONFIGURATION AUTO_INCREMENT = 0'));
		PREPARE ALTER_REPORT_CONFIGURATION_STMT FROM @ALTER_REPORT_CONFIGURATION;
		EXECUTE ALTER_REPORT_CONFIGURATION_STMT;

		DROP TABLE IF EXISTS LMC_EMAIL_TEMPLATE;
		CREATE TABLE LMC_EMAIL_TEMPLATE(
		ET_ID INTEGER NOT NULL AUTO_INCREMENT,
		ET_EMAIL_SCRIPT	VARCHAR(100) UNIQUE	NOT NULL,
		PRIMARY KEY(ET_ID));
		SET @ALTER_EMAIL_TEMPLATE = (SELECT CONCAT('ALTER TABLE LMC_EMAIL_TEMPLATE AUTO_INCREMENT = 0'));
		PREPARE ALTER_EMAIL_TEMPLATE_STMT FROM @ALTER_EMAIL_TEMPLATE;
		EXECUTE ALTER_EMAIL_TEMPLATE_STMT;

		DROP TABLE IF EXISTS LMC_EMAIL_TEMPLATE_DETAILS;
		CREATE TABLE LMC_EMAIL_TEMPLATE_DETAILS(
		ETD_ID INTEGER NOT NULL AUTO_INCREMENT,
		ET_ID INTEGER NOT NULL,
		ETD_EMAIL_SUBJECT VARCHAR(1000) NOT NULL,
		ETD_EMAIL_BODY TEXT NOT NULL,
		ULD_ID INTEGER NOT NULL,
		ETD_TIMESTAMP TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(ETD_ID),
		FOREIGN KEY(ET_ID) REFERENCES LMC_EMAIL_TEMPLATE (ET_ID),
		FOREIGN KEY(ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));
		SET @ALTER_EMAIL_TEMPLATE_DETAILS = (SELECT CONCAT('ALTER TABLE LMC_EMAIL_TEMPLATE_DETAILS AUTO_INCREMENT = 0'));
		PREPARE ALTER_EMAIL_TEMPLATE_DETAILS_STMT FROM @ALTER_EMAIL_TEMPLATE_DETAILS;
		EXECUTE ALTER_EMAIL_TEMPLATE_DETAILS_STMT;

		DROP TABLE IF EXISTS LMC_TICKLER_PROFILE;
		CREATE TABLE LMC_TICKLER_PROFILE(
		TP_ID INTEGER NOT NULL AUTO_INCREMENT,
		TP_TYPE	CHAR(10) NOT NULL,
		PRIMARY KEY(TP_ID));
		SET @ALTER_TICKLER_PROFILE = (SELECT CONCAT('ALTER TABLE LMC_TICKLER_PROFILE AUTO_INCREMENT = 0'));
		PREPARE ALTER_TICKLER_PROFILE_STMT FROM @ALTER_TICKLER_PROFILE;
		EXECUTE ALTER_TICKLER_PROFILE_STMT;

		DROP TABLE IF EXISTS LMC_TICKLER_TABID_PROFILE;
		CREATE TABLE LMC_TICKLER_TABID_PROFILE(
		TTIP_ID INTEGER NOT NULL AUTO_INCREMENT,
		TTIP_DATA VARCHAR(50) NOT NULL,
		PRIMARY KEY(TTIP_ID));
		SET @ALTER_TICKLER_TABID_PROFILE = (SELECT CONCAT('ALTER TABLE LMC_TICKLER_TABID_PROFILE AUTO_INCREMENT = 0'));
		PREPARE ALTER_TICKLER_TABID_PROFILE_STMT FROM @ALTER_TICKLER_TABID_PROFILE;
		EXECUTE ALTER_TICKLER_TABID_PROFILE_STMT;

		DROP TABLE IF EXISTS LMC_TICKLER_HISTORY;
		CREATE TABLE LMC_TICKLER_HISTORY(
		TH_ID INTEGER NOT NULL AUTO_INCREMENT,
		TP_ID INTEGER NOT NULL,
		EMP_ID INTEGER NULL,
		TTIP_ID INTEGER NOT NULL,
		TH_OLD_VALUE TEXT NOT NULL,
		TH_NEW_VALUE TEXT NULL,
		TH_USERSTAMP_ID INTEGER NOT NULL,
		TH_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(TH_ID),
		FOREIGN KEY(TP_ID) REFERENCES LMC_TICKLER_PROFILE(TP_ID),
		FOREIGN KEY(TTIP_ID) REFERENCES LMC_TICKLER_TABID_PROFILE(TTIP_ID));
		SET @ALTER_TICKLER_HISTORY = (SELECT CONCAT('ALTER TABLE LMC_TICKLER_HISTORY AUTO_INCREMENT = 0'));
		PREPARE ALTER_TICKLER_HISTORY_STMT FROM @ALTER_TICKLER_HISTORY;
		EXECUTE ALTER_TICKLER_HISTORY_STMT;

		SET SUCCESS_MESSAGE = 1;
		SET FOREIGN_KEY_CHECKS = 1;

	COMMIT;
END//
DELIMITER ;


-- Dumping structure for procedure SP_LMC_EQUIPMENT_USAGE_DETAILS
DROP PROCEDURE IF EXISTS `SP_LMC_EQUIPMENT_USAGE_DETAILS`;
DELIMITER //
CREATE  PROCEDURE `SP_LMC_EQUIPMENT_USAGE_DETAILS`(
SEARCH_OPTION INTEGER,
EUDID TEXT,
TRDID INTEGER,
EQUIPMENT TEXT,
LORRYNO TEXT,
STARTTIME TEXT,
ENDTIME TEXT,
REMARK TEXT,
USERSTAMP VARCHAR(50),
OUT SUCCESS_MESSAGE TEXT)
BEGIN
DECLARE EUEQUIPMENT VARCHAR(30);
DECLARE EULORRYNO VARCHAR(30);
DECLARE EUSTARTTIME TIME;
DECLARE EUENDTIME TIME;
DECLARE EUREMARK TEXT;
DECLARE T_EUD_ID TEXT;
DECLARE LMC_EUDID INTEGER;
DECLARE T_EQUIPMENT VARCHAR(30);
DECLARE T_LORRYNO VARCHAR(30);
DECLARE T_START_TIME TIME;
DECLARE T_END_TIME TIME;
DECLARE T_REMARK TEXT;
DECLARE T_ULDID INTEGER;
DECLARE T_TIMESTAMP TIMESTAMP;
DECLARE OLDVALUE TEXT;

SET @EU_EQUIPMENT=EQUIPMENT;
SET @EU_LORRYNO=LORRYNO;
SET @EU_STARTTIME=STARTTIME;
SET @EU_ENDTIME=ENDTIME;
SET @EU_REMARK=REMARK;
SET @LMCEUDID=EUDID;
SET SUCCESS_MESSAGE=0;

IF SEARCH_OPTION=2 THEN
		SET T_EUD_ID=(SELECT REPLACE(EUDID,' ','0'));
		SET @SETLMC_EUDID=(SELECT CONCAT('SELECT GROUP_CONCAT(EUD_ID) INTO @L_EUD_ID FROM LMC_EQUIPMENT_USAGE_DETAILS WHERE TRD_ID=',TRDID,' AND EUD_ID NOT IN(',T_EUD_ID,')'));
		PREPARE SETLMC_EUDID_STMT FROM @SETLMC_EUDID;
		EXECUTE SETLMC_EUDID_STMT;

		SET T_EUD_ID= @L_EUD_ID;

		IF T_EUD_ID=' ' THEN
			SET T_EUD_ID=NULL;
		END IF;

	IF T_EUD_ID IS NOT NULL THEN
		SET @TICK_T_EUD_ID=T_EUD_ID;

		MAIN_LOOP : LOOP

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES(',',@TICK_T_EUD_ID,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_EUDID;
		SELECT @REMAINING_STRING INTO @TICK_T_EUD_ID;

		SET T_EQUIPMENT=(SELECT EUD_EQUIPMENT FROM LMC_EQUIPMENT_USAGE_DETAILS WHERE EUD_ID=LMC_EUDID);
		IF T_EQUIPMENT IS NULL  THEN
			SET T_EQUIPMENT='<NULL>';
		END IF;

		SET T_LORRYNO=(SELECT EUD_LORRY_NO FROM LMC_EQUIPMENT_USAGE_DETAILS WHERE EUD_ID=LMC_EUDID);
		IF T_LORRYNO IS NULL  THEN
			SET T_LORRYNO='<NULL>';
		END IF;
	
		SET T_START_TIME=(SELECT EUD_START_TIME FROM LMC_EQUIPMENT_USAGE_DETAILS WHERE EUD_ID=LMC_EUDID);
		IF T_START_TIME IS NULL THEN
			SET T_START_TIME='<NULL>';
		END IF;
		
		SET T_END_TIME=(SELECT EUD_END_TIME FROM  LMC_EQUIPMENT_USAGE_DETAILS WHERE EUD_ID=LMC_EUDID);
		IF T_END_TIME IS NULL THEN
			SET T_END_TIME='<NULL>';
		END IF;

		SET T_REMARK=(SELECT EUD_REMARK FROM LMC_EQUIPMENT_USAGE_DETAILS WHERE EUD_ID=LMC_EUDID);
		IF T_REMARK IS NULL THEN
			SET T_REMARK='<NULL>';
		END IF;
		
		
		SET T_ULDID=(SELECT ULD_ID FROM LMC_EQUIPMENT_USAGE_DETAILS WHERE EUD_ID=LMC_EUDID);
		SET T_TIMESTAMP=(SELECT EUD_TIMESTAMP FROM LMC_EQUIPMENT_USAGE_DETAILS WHERE EUD_ID=LMC_EUDID);

		SET OLDVALUE=(SELECT CONCAT('EUD_ID=',LMC_EUDID,',TRD_ID=',TRDID,',EUD_EQUIPMENT=',T_EQUIPMENT,',EUD_LORRY_NO=',T_LORRYNO,',EUD_START_TIME=',T_START_TIME,
		',EUD_END_TIME=',T_END_TIME,',EUD_REMARK=',T_REMARK,',ULD_ID=',T_ULDID,',EUD_TIMESTAMP=',T_TIMESTAMP));

		INSERT INTO LMC_TICKLER_HISTORY(TP_ID,EMP_ID,TTIP_ID,TH_OLD_VALUE,TH_USERSTAMP_ID)VALUES
		((SELECT TP_ID FROM LMC_TICKLER_PROFILE WHERE TP_TYPE='DELETION'),(SELECT EMP_ID FROM LMC_TEAM_REPORT_DETAILS WHERE TRD_ID=TRDID),
		(SELECT TTIP_ID FROM LMC_TICKLER_TABID_PROFILE WHERE TTIP_DATA='LMC_EQUIPMENT_USAGE_DETAILS'),OLDVALUE,
		(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
		DELETE FROM LMC_EQUIPMENT_USAGE_DETAILS WHERE  EUD_ID=LMC_EUDID;

		IF @TICK_T_EUD_ID IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;
	END LOOP;
	END IF;
END IF;

	MAIN_LOOP : LOOP
		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@EU_EQUIPMENT,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO EUEQUIPMENT;
		SELECT @REMAINING_STRING INTO @EU_EQUIPMENT;

		IF EUEQUIPMENT=' ' THEN
			SET EUEQUIPMENT=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@EU_LORRYNO,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO EULORRYNO;
		SELECT @REMAINING_STRING INTO @EU_LORRYNO;
		IF EULORRYNO=' ' THEN
			SET EULORRYNO=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@EU_STARTTIME,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO EUSTARTTIME;
		SELECT @REMAINING_STRING INTO @EU_STARTTIME;
		IF EUSTARTTIME=' ' THEN
			SET EUSTARTTIME=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@EU_ENDTIME,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO EUENDTIME;
		SELECT @REMAINING_STRING INTO @EU_ENDTIME;

		IF EUENDTIME=' ' THEN
			SET EUENDTIME=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@EU_REMARK,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO EUREMARK;
		SELECT @REMAINING_STRING INTO @EU_REMARK;

		IF EUREMARK='' THEN
			SET EUREMARK=NULL;
		END IF;

		IF SEARCH_OPTION=2 THEN
			CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES(',',@LMCEUDID,@VALUE,@REMAINING_STRING);
			SELECT @VALUE INTO LMC_EUDID;
			SELECT @REMAINING_STRING INTO @LMCEUDID;
		END IF;

		IF LMC_EUDID=' ' THEN
			SET LMC_EUDID=NULL;
		END IF; 

		IF SEARCH_OPTION=1 THEN
			IF EUEQUIPMENT IS NOT NULL AND EULORRYNO IS NOT NULL  AND EUSTARTTIME IS NOT NULL AND EUENDTIME IS NOT NULL THEN
				INSERT INTO LMC_EQUIPMENT_USAGE_DETAILS(TRD_ID,EUD_EQUIPMENT,EUD_LORRY_NO,EUD_START_TIME,EUD_END_TIME,EUD_REMARK,ULD_ID)VALUES 
				(TRDID,EUEQUIPMENT,EULORRYNO,EUSTARTTIME,EUENDTIME,EUREMARK,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
			END IF;
		END IF;

		IF SEARCH_OPTION=2 THEN
			IF LMC_EUDID IS NULL AND EUEQUIPMENT IS NOT NULL AND EULORRYNO IS NOT NULL  AND EUSTARTTIME IS NOT NULL AND EUENDTIME IS NOT NULL THEN
				INSERT INTO LMC_EQUIPMENT_USAGE_DETAILS(TRD_ID,EUD_EQUIPMENT,EUD_LORRY_NO,EUD_START_TIME,EUD_END_TIME,EUD_REMARK,ULD_ID)VALUES 
				(TRDID,EUEQUIPMENT,EULORRYNO,EUSTARTTIME,EUENDTIME,EUREMARK,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
			END IF;
			IF LMC_EUDID IS NOT NULL AND EUEQUIPMENT IS NOT NULL AND EULORRYNO IS NOT NULL  AND EUSTARTTIME IS NOT NULL AND EUENDTIME IS NOT NULL THEN
				UPDATE LMC_EQUIPMENT_USAGE_DETAILS SET TRD_ID=TRDID,EUD_EQUIPMENT=EUEQUIPMENT,EUD_LORRY_NO=EULORRYNO,EUD_START_TIME=EUSTARTTIME,EUD_END_TIME=EUENDTIME,
				EUD_REMARK=EUREMARK,ULD_ID=(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP) WHERE EUD_ID=LMC_EUDID;
			END IF;
		END IF;

		IF @EU_EQUIPMENT IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;

	END LOOP;
SET SUCCESS_MESSAGE=1;

END//
DELIMITER ;


-- Dumping structure for procedure SP_LMC_FITTING_USAGE_DETAILS
DROP PROCEDURE IF EXISTS `SP_LMC_FITTING_USAGE_DETAILS`;
DELIMITER //
CREATE  PROCEDURE `SP_LMC_FITTING_USAGE_DETAILS`(
SEARCH_OPTION INTEGER,
FUDID TEXT,
TRDID INTEGER,
ITEMS TEXT,
SIZE TEXT,
QUANTITY TEXT,
REMARK TEXT,
USERSTAMP VARCHAR(50),
OUT SUCCESS_MESSAGE TEXT)
BEGIN
DECLARE FDITEMS VARCHAR(50);
DECLARE FDSIZE INTEGER;
DECLARE FDQUANTITY INTEGER;
DECLARE FDREMARK TEXT;
DECLARE FUID INTEGER;
DECLARE T_FUD_ID TEXT;
DECLARE TICK_T_FUDID TEXT;
DECLARE LMC_FUDID INTEGER;
DECLARE T_FUID INTEGER;
DECLARE T_FUD_SIZE VARCHAR(15);
DECLARE T_FUD_QUANTITY VARCHAR(15);
DECLARE T_FUD_REMARK TEXT;
DECLARE T_ULDID INTEGER;
DECLARE T_TIMESTAMP TIMESTAMP;
DECLARE OLDVALUE TEXT;

SET @FD_ITEMS=ITEMS;
SET @FD_SIZE=SIZE;
SET @FD_QUANTITY=QUANTITY;
SET @FD_REMARK=REMARK;
SET @LMCFUDID=FUDID;

SET SUCCESS_MESSAGE=0;
IF SEARCH_OPTION=2 THEN
		SET T_FUD_ID=(SELECT REPLACE(FUDID,' ','0'));
		SET @SETLMC_FUID=(SELECT CONCAT('SELECT GROUP_CONCAT(FUD_ID) INTO @L_FUID FROM LMC_FITTING_USAGE_DETAILS WHERE TRD_ID=',TRDID,' AND FUD_ID NOT IN(',T_FUD_ID,')'));
		PREPARE SETLMC_FUID_STMT FROM @SETLMC_FUID;
		EXECUTE SETLMC_FUID_STMT;

		SET T_FUD_ID=@L_FUID;

		IF T_FUD_ID=' ' THEN
			SET T_FUD_ID=NULL;
		END IF;

	IF T_FUD_ID IS NOT NULL THEN
		SET @TICK_T_FUDID=T_FUD_ID;

		MAIN_LOOP : LOOP

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES(',',@TICK_T_FUDID,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_FUDID;
		SELECT @REMAINING_STRING INTO @TICK_T_FUDID;

		SET T_FUID=(SELECT FU_ID FROM LMC_FITTING_USAGE_DETAILS WHERE FUD_ID=LMC_FUDID);
		IF T_FUID IS NULL  THEN
			SET T_FUID='<NULL>';
		END IF;
		SET T_FUD_SIZE=(SELECT FUD_SIZE FROM LMC_FITTING_USAGE_DETAILS WHERE FUD_ID=LMC_FUDID);
		IF T_FUD_SIZE IS NULL THEN
			SET T_FUD_SIZE='<NULL>';
		END IF;
		SET T_FUD_QUANTITY=(SELECT FUD_QUANTITY FROM LMC_FITTING_USAGE_DETAILS WHERE FUD_ID=LMC_FUDID);
		IF T_FUD_QUANTITY IS NULL THEN
			SET T_FUD_QUANTITY='<NULL>';
		END IF;
		SET T_FUD_REMARK=(SELECT FUD_REMARK FROM LMC_FITTING_USAGE_DETAILS WHERE FUD_ID=LMC_FUDID);
		IF T_FUD_REMARK IS NULL THEN
			SET T_FUD_REMARK='<NULL>';
		END IF;
		SET T_ULDID=(SELECT ULD_ID FROM LMC_FITTING_USAGE_DETAILS WHERE FUD_ID=LMC_FUDID);
		SET T_TIMESTAMP=(SELECT FUD_TIMESTAMP FROM LMC_FITTING_USAGE_DETAILS WHERE FUD_ID=LMC_FUDID);

		SET OLDVALUE=(SELECT CONCAT('FUD_ID=',LMC_FUDID,',TRD_ID=',TRDID,',FU_ID=',T_FUID,',FUD_SIZE=',T_FUD_SIZE,',FUD_QUANTITY=',T_FUD_QUANTITY,
		',FUD_REMARK=',T_FUD_REMARK,',ULD_ID=',T_ULDID,',MET_TIMESTAMP=',T_TIMESTAMP));
		INSERT INTO LMC_TICKLER_HISTORY(TP_ID,EMP_ID,TTIP_ID,TH_OLD_VALUE,TH_USERSTAMP_ID)VALUES
		((SELECT TP_ID FROM LMC_TICKLER_PROFILE WHERE TP_TYPE='DELETION'),(SELECT EMP_ID FROM LMC_TEAM_REPORT_DETAILS WHERE TRD_ID=TRDID),
		(SELECT TTIP_ID FROM LMC_TICKLER_TABID_PROFILE WHERE TTIP_DATA='LMC_FITTING_USAGE_DETAILS'),OLDVALUE,
		(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
		DELETE FROM LMC_FITTING_USAGE_DETAILS WHERE  FUD_ID=LMC_FUDID;

		IF @TICK_T_FUDID IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;
	END LOOP;
	END IF;
END IF;

	MAIN_LOOP : LOOP
		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@FD_ITEMS,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO FDITEMS;
		SELECT @REMAINING_STRING INTO @FD_ITEMS;
		IF FDITEMS='' THEN
			SET FDITEMS=NULL;
		END IF;
		IF NOT EXISTS(SELECT FU_ID FROM LMC_FITTING_USAGE WHERE FU_ITEMS=FDITEMS)THEN
			INSERT INTO LMC_FITTING_USAGE(FU_ITEMS)VALUES(FDITEMS);
			SET FUID=(SELECT FU_ID FROM LMC_FITTING_USAGE WHERE FU_ITEMS=FDITEMS);
		ELSE
			SET FUID=(SELECT FU_ID FROM LMC_FITTING_USAGE WHERE FU_ITEMS=FDITEMS);
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@FD_SIZE,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO FDSIZE;
		SELECT @REMAINING_STRING INTO @FD_SIZE;
		IF FDSIZE='' THEN
			SET FDSIZE=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^', @FD_QUANTITY,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO FDQUANTITY;
		SELECT @REMAINING_STRING INTO @FD_QUANTITY;
		IF FDQUANTITY='' THEN
			SET FDQUANTITY=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@FD_REMARK,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO FDREMARK;
		SELECT @REMAINING_STRING INTO @FD_REMARK;
		IF FDREMARK='' THEN
			SET FDREMARK=NULL;
		END IF;
		IF SEARCH_OPTION=2 THEN
			CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES(',',@LMCFUDID,@VALUE,@REMAINING_STRING);
			SELECT @VALUE INTO LMC_FUDID;
			SELECT @REMAINING_STRING INTO @LMCFUDID;
		END IF;

		IF LMC_FUDID=' ' THEN
			SET LMC_FUDID=NULL;
		END IF; 

	IF SEARCH_OPTION=1 THEN

		IF FDITEMS IS NOT NULL  THEN

			IF NOT EXISTS(SELECT FUD_ID FROM LMC_FITTING_USAGE_DETAILS WHERE TRD_ID=TRDID AND FU_ID=FUID)THEN

				INSERT INTO LMC_FITTING_USAGE_DETAILS(TRD_ID,FU_ID,FUD_SIZE,FUD_QUANTITY,FUD_REMARK,ULD_ID)VALUES 
				(TRDID,(SELECT FU_ID FROM LMC_FITTING_USAGE WHERE FU_ITEMS=FDITEMS),FDSIZE,FDQUANTITY,FDREMARK,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
			END IF;	
		END IF;
	END IF;
	IF SEARCH_OPTION=2 THEN

		IF LMC_FUDID IS NULL AND FDITEMS IS NOT NULL  THEN
			IF NOT EXISTS(SELECT FUD_ID FROM LMC_FITTING_USAGE_DETAILS WHERE TRD_ID=TRDID AND FU_ID=FUID)THEN

				INSERT INTO LMC_FITTING_USAGE_DETAILS(TRD_ID,FU_ID,FUD_SIZE,FUD_QUANTITY,FUD_REMARK,ULD_ID)VALUES 
				(TRDID,(SELECT FU_ID FROM LMC_FITTING_USAGE WHERE FU_ITEMS=FDITEMS),FDSIZE,FDQUANTITY,FDREMARK,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
			END IF;	
		END IF;

		IF LMC_FUDID IS NOT NULL AND FDITEMS IS NOT NULL  THEN

				UPDATE LMC_FITTING_USAGE_DETAILS SET TRD_ID=TRDID,FU_ID=(SELECT FU_ID FROM LMC_FITTING_USAGE WHERE FU_ITEMS=FDITEMS),FUD_SIZE=FDSIZE,
				FUD_QUANTITY=FDQUANTITY,FUD_REMARK=FDREMARK,ULD_ID=(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP) WHERE FUD_ID=LMC_FUDID;
		END IF;	
	END IF;

		IF  @FD_ITEMS IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;

	END LOOP;
SET SUCCESS_MESSAGE=1;

END//
DELIMITER ;


-- Dumping structure for procedure SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES
DROP PROCEDURE IF EXISTS `SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES`;
DELIMITER //
CREATE  PROCEDURE `SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES`(IN SPECIAL_CHARACTER VARCHAR(30), IN INPUT_STRING_WITH_COMMAS TEXT, OUT VALUE TEXT, OUT REMAINING_STRING TEXT)
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


-- Dumping structure for procedure SP_LMC_INITAILIZATION_TABLE_INSERTION
DROP PROCEDURE IF EXISTS `SP_LMC_INITAILIZATION_TABLE_INSERTION`;
DELIMITER //
CREATE  PROCEDURE `SP_LMC_INITAILIZATION_TABLE_INSERTION`(
OUT SUCCESS_MESSAGE TEXT)
BEGIN	
-- QUERY FOR ROLLBACK COMMAND
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN 
		ROLLBACK;
		SET SUCCESS_MESSAGE = 0;
	END;

	START TRANSACTION;
	SET FOREIGN_KEY_CHECKS=0;
	SET SUCCESS_MESSAGE = 0;

	-- USER_LOGIN_DETAILS
	TRUNCATE LMC_USER_LOGIN_DETAILS;
	INSERT INTO LMC_USER_LOGIN_DETAILS(ULD_USERNAME,ULD_PASSWORD,ULD_USERSTAMP) VALUES ('lmc','2dd0fb43933dc59cfd47b5a4b8ae1fbe','lmc');

	TRUNCATE LMC_ROLE_CREATION;
	INSERT INTO LMC_ROLE_CREATION(RC_ID,URC_ID,RC_NAME,RC_USERSTAMP) VALUES ('1','1','ADMIN','lmc');
	INSERT INTO LMC_ROLE_CREATION(RC_ID,URC_ID,RC_NAME,RC_USERSTAMP) VALUES ('2','2','SUPER ADMIN','lmc');
	INSERT INTO LMC_ROLE_CREATION(RC_ID,URC_ID,RC_NAME,RC_USERSTAMP) VALUES ('3','3','USER','lmc');


	-- CONFIGURATION_PROFILE
	TRUNCATE LMC_CONFIGURATION_PROFILE;
	INSERT INTO LMC_CONFIGURATION_PROFILE(CNP_ID,CNP_DATA) VALUES ('1','GENERAL');
	INSERT INTO LMC_CONFIGURATION_PROFILE(CNP_ID,CNP_DATA) VALUES ('2','REPORTS');
	INSERT INTO LMC_CONFIGURATION_PROFILE(CNP_ID,CNP_DATA) VALUES ('3','USER RIGHTS');

	-- CONFIGURATION
	TRUNCATE LMC_CONFIGURATION;
	INSERT INTO LMC_CONFIGURATION(CGN_ID,CNP_ID,CGN_TYPE,CGN_NON_IP_FLAG) VALUES ('1','3','ACCESS RIGHTS ROLES','XX');
	INSERT INTO LMC_CONFIGURATION(CGN_ID,CNP_ID,CGN_TYPE,CGN_NON_IP_FLAG) VALUES ('2','3','SENDER','XX');
	INSERT INTO LMC_CONFIGURATION(CGN_ID,CNP_ID,CGN_TYPE,CGN_NON_IP_FLAG) VALUES ('3','3','TO','XX');
	INSERT INTO LMC_CONFIGURATION(CGN_ID,CNP_ID,CGN_TYPE,CGN_NON_IP_FLAG) VALUES ('4','3','CC','XX');
	INSERT INTO LMC_CONFIGURATION(CGN_ID,CNP_ID,CGN_TYPE,CGN_NON_IP_FLAG) VALUES ('5','3','EMAIL SERVER IP',null);
	INSERT INTO LMC_CONFIGURATION(CGN_ID,CNP_ID,CGN_TYPE,CGN_NON_IP_FLAG) VALUES ('6','3','EMPLOYEE TYPE',null);
	INSERT INTO LMC_CONFIGURATION(CGN_ID,CNP_ID,CGN_TYPE,CGN_NON_IP_FLAG) VALUES ('7','3','COMPANY START DATE','XX');
	INSERT INTO LMC_CONFIGURATION(CGN_ID,CNP_ID,CGN_TYPE,CGN_NON_IP_FLAG) VALUES ('8','3','IMAGE FOLDER NAME','XX');
	INSERT INTO LMC_CONFIGURATION(CGN_ID,CNP_ID,CGN_TYPE,CGN_NON_IP_FLAG) VALUES ('9','3','DOCUMENT FOLDER NAME','XX');
	INSERT INTO LMC_CONFIGURATION(CGN_ID,CNP_ID,CGN_TYPE,CGN_NON_IP_FLAG) VALUES ('10','3','PORT NO',null);
	INSERT INTO LMC_CONFIGURATION(CGN_ID,CNP_ID,CGN_TYPE,CGN_NON_IP_FLAG) VALUES ('11','2','TICKLER HISTORY SEARCH OPTION',null);

	TRUNCATE LMC_ERROR_MESSAGE_CONFIGURATION;

	INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('1','1','1','ALPHABETS ONLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('2','1','2','NUMBERS ONLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('3','1','3','REPORT SAVED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('4','1','4','REPORT UPDATED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('5','1','5','REPORT DELETED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('6','1','6','ALREADY [DATE] REPORT HAS BEEN ENTERED, PLZ USE UPDATE PAGE TO UPDATE IT FURTHER','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('7','1','7','REPORT NOT SAVED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('8','1','8','REPORT NOT DELETED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('9','3','9','USER [LOGIN ID] RECORD IS UPDATED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('10','3','10','USER [LOGIN ID] TERMINATED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('11','3','11','USER [LOGIN ID] REJOINED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('12','3','12','NO USER AVAILABLE TO TERMINATE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('13','3','13','NO USER AVAILABLE TO REJOIN','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('14','3','14','NO USER AVAILABLE TO UPDATE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('15','3','15','NO DATA AVAILABLE IN USER LOGIN DETAIL TABLE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('16','1','16','NO DATA AVAILABLE BETWEEN [SDATE] AND [EDATE]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('17','1','17','REPORT NOT UPDATED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('18','1','18','NO DATA AVAILABLE FOR [DATE]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('19','1','19','TEAM [NAME] ALREADY EXISTS','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('20','1','20','AC_ID SHOULD BETWEEN 4 TO 8','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('21','1','21','AC_ID SHOULD BETWEEN 1 TO 3','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('22','1','22','REPORT ALREADY EXISTS','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('23','1','23','BOTH REPORT AND REASON NOT NULL AT A SAME TIME','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('24','1','24','BANDWIDTH SHOULD BE LESS THAN OR EQUAL TO 4 DIGITS','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('25','1','25','BOTH REPORT AND REASON CANNOT BE NULL AT HALF-A-DAY ABSENT','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('26','1','26','PD_ID CANNOT BE NULL FOR HALF-A-DAY PRESENT','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('27','1','27','PD_ID CANNOT BE NULL FOR FULL DAY PRESENT','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('28','1','28','FOR FULL DAY ABSENT PERMISSION SHOULD NOT BE ENTERED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('29','1','29','FOR ONDUTY PERMISSION SHOULD NOT BE ENTERED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('30','1','30','REPORT SHOULD BE ENTERED FOR FULL DAY PRESENT','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('31','1','31','REASON SHOULD BE ENTERED FOR FULL DAY ABSENT','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('32','1','32','PD_ID SHOULD NOT BE ENTERED FOR FULL DAY ABSENT','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('33','1','33','PD_ID SHOULD NOT BE ENTERED FOR ON DUTY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('34','1','34','DESIGNATION SHOULD BE UPPERCASE ONLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('35','1','35','DOB: [DOB] SHOULD BE GREATER THAN OR EQUAL TO 18 YEARS','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('36','1','36','DOB: [DOB] SHOULD BE NOT BE GREATER THAN TODAY DATE [CURDATE]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('37','1','37','MOBILE NO: [MOB NO] SHOULD BE EQUAL TO 10 DIGITS','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('38','1','38','PROJECT NAME SHOULD BE UPPERCASE ONLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('39','1','39','PROJECT DESCRIPTION SHOULD BE UPPERCASE ONLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('40','3','40','ENTER VALID E-MAIL ID','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('41','3','41','NO USER AVAILABLE TO UPDATE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('42','3','42','EMAIL ID ALREADY EXISTS','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('43','3','43','ROLE :[NAME] ALREADY EXISTS','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('44','3','44','ROLE CREATED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('45','3','45','USER [NAME] CREATED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('46','3','46','USER [NAME] UPDATED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('47','3','47','ROLE UPDATED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('48','3','48','USER NAME :[NAME] ALREADY EXISTS','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('49','3','49','NO ROLES AVAILABLE TO UPDATE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('50','3','50','NO BASIC ROLE AVAILABLE FOR [USERID]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('51','3','51','BASIC PROFILE ACCESS ALREADY GIVEN ,USE SEARCH AND UPDATE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('52','3','52','BASIC PROFILE CREATED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('53','3','53','BASIC PROFILE UPDATED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('54','3','54','NO DATA AVAILABLE FOR THE BASIC ROLE [NAME]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('55','3','55','ENTER VALID EMAIL ADDRESS OF SSOMENS.COM/GMAIL.COM','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('56','3','56','RECORD NOT UPDATED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('57','3','57','CHECK CALENDER API ENABLED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('58','3','58','YOU DO NOT HAVE PERMISSION TO ACCESS THE FOLDER','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('59','3','59','CALENDAR NAME / ID IS WRONG OR MISSING IN CONFIG TABLE.PLZ,CHECK IN CONFIGURATION TABLE.','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('60','3','60','CALENDER/SITE OWNER ONLY CAN ABLE TO SHARE CALENDER/SITE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('61','3','61','NO ACCESS AVAILABLE FOR LOGIN ID : [LOGIN ID]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('62','1','62','PROJECT NAME ALREADY EXISTS','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('63','1','63','PROJECT SAVED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('64','3','64','PAGE ACCESS REVOKED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('65','3','65','PAGE ACCESS GRANTED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('66','2','66','REPORTDATE- [RSDATE] SHOULD GREATER THAN [PROJECT NAME] PROJECT STARTDATE- [PSDATE]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('67','2','67','BANDWIDTH - [BW] MB SHOULD NOT BE GREATER THAN 1000 MB','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('68','2','68','REPORT FOR THE DATE [DD/MM/YY] ALREADY EXISTS FOR THE LOGIN ID [LOGIN]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('69','1','69','EMPLOYEE RECORD SAVED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('70','1','70','CONTACT NO SHOULD BE 10 DIGITS','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('71','1','71','RECORD NOT SAVED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('72','1','72','NO USER AVAILABLE TO ENTER THE DETAILS ,USE SEARCH/UPDATE FORM','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('73','2','73','YOUR SEARCH NOT MATCH FOR ANY EMPLOYEE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('74','2','74','TICKLER HISTORY FOR EMPLOYEE: [LOGINID]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('75','2','75','NO DATA AVAILABLE FOR THIS EMPLOYEE NAME: [LOGINID]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('76','1','76','EMPLOYEE DETAILS RECORD UPDATED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('77','1','77','NO DATA AVAILABLE IN EMPLOYEE DETAILS','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('78','1','78','DETAILS OF THE EMPLOYEE NAME : [NAME]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('79','1','79','PROJECT NOT SAVED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('80','1','80','PROJECT UPDATED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('81','1','81','PROJECT NOT UPDATED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('82','2','82','NO DATA AVAILABLE FOR THIS PROJECT: [NAME]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('83','1','83','NO DATA AVAILABLE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('84','1','84','REPORT ALREADY ENTERED FOR THIS WEEK,PLZ USE UPDATE PAGE TO UPDATE IT FURTHER','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('85','1','85','EMAIL TEMPLATE RECORD SAVED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('86','1','86','SCRIPT NAME ALREADY EXISTS','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('87','1','87','NO RECORDS AVAILABLE IN EMAIL TEMPLATE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('88','1','88','EMAIL TEMPLATE RECORD UPDATED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('89','1','89','DETAILS OF THE [SCRIPT]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('90','1','90','PATCH FILE [FILENAME] EXECUTED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('91','1','91','PATCH FILE [FILENAME] ALREADY EXECUTED.RUN SOME OTHER FILE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('92','1','92','PATCH FILE [FILENAME] HAVING ISSUE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('93','1','93','PUBLIC HOLIDAY SAVED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('94','1','94','ENTER VALID ID','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('95','3','95','LOGIN ID [NAME] NOT CREATED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('96','1','96','PUBLIC HOLIDAY ALREADY ENTERED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('97','1','97','DOC / SS ID IS WRONG OR CHECK IN CONFIGURATION OR GET ACCESS','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('98','2','98','REPORT FOR [LOGINID] BETWEEN [STARTDATE] AND [ENDDATE]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('99','5','99','DETAILS FOR ALL PROJECT(S)','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('100','2','100','EMPLOYEE(S) BANDWIDTH USAGE FOR [MONTH]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('101','2','101','BANDWIDTH FOR [LOGINID] ON [MONTH]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('102','2','102','DOOR ACCESS DETAILS FOR EMPLOYEES','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('103','2','103','ATTENDANCE REPORT FOR [EMPLOYEE] ON [MONTH]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('104','2','104','ATTENDANCE REPORT FOR [MONTH]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('105','2','105','REPORT ENTRY MISSED DETAILS FOR [MONTH]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('106','2','106','PROJECT REVENUE FOR [MONTH]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('107','2','107','PROJECT REVENUE FOR [MONTH] BETWEEN [STARTDATE] AND [ENDDATE]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('108','2','108','PROJECT REVENUE FOR [LOGINID] FOR [PROJECTNAME]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('109','2','109','REPORT(S) DETAILS FOR [DATE]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('110','2','110','WEEKLY REPORT DETAILS BETWEEN [STARTDATE] AND [ENDDATE]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('111','2','111','PROJECT REVENUE FOR [PROJECTNAME]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('112','2','112','PROJECT REVENUE FOR [LOGINID] BETWEEN [STARTDATE] AND [ENDDATE] IN [PROJECTNAME]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('113','3','113','YOU DO NOT HAVE PERMISSION TO SHARE/UNSHARE THE SS [SSID]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('114','3','114','YOU DO NOT HAVE PERMISSION TO CREATE EVENT IN THIS CALENDER','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('115','3','115','NO PROJECT AVAILABLE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('116','3','116','[LOGIN ID] HAVING REPORTS UPTO [DATE].SO NOT ABLE TO TERMINATE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('117','3','117','PROJECT ACCESS HAS GIVEN TO [LOGINID]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('118','3','118','PROJECT ACCESS UPDATED FOR [LOGIN ID]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('119','1','119','TODAY CLOCK IN TIME:[TIME]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('120','1','120','PLZ CLOCK IN TO ENTER PRESENT REPORT','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('121','1','121','CLOCK IN/OUT DETAILS FOR [LOGINID] BETWEEN [STARTDATE] AND [ENDDATE]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('122','1','122','CLOCK IN/OUT DETAILS FOR [DATE]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('123','2','123','REPORT LOCATION CANNOT BE UNDEFINED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('124','1','124','ALLOW BROWSER TO SHARE LOCATION','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('125','1','125','DETAILS OF SELECTED TYPE :[TYPE]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('126','1','126','CONFIGURATION RECORD FOR [MODULE NAME] UPDATED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('127','1','127','NO RECORD MATCH FOR THE SELECTED TYPE : [TYPE]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('128','1','128','CONFIGURATION RECORD FOR [MODULE NAME] DELETED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('129','1','129','CONFIGURATION RECORD CANNOT BE DELETED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('130','1','130','CONFIGURATION RECORD FOR [MODULE NAME] SAVED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('131','1','131','CONFIGURATION DATA FOR THE [TYPE] ALREADY EXISTS GIVE ANOTHER ONE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('132','1','132','YOU DO NOT HAVE PERMISSION TO ACCESS THE FOLDER [FID]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('133','1','133','PDF/JPEG/JPG/PNG FILES ARE ONLY ALLOWED!!!','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('134','1','134','NO INPUT TYPE AVAILABLE FOR [MODULE NAME]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('135','2','135','THIS FOLDERID ALREADY CREATED FOR [LOGINID]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('136','2','136','REPORTDATE- [RSDATE] SHOULD LESS THAN [PROJECT NAME] PROJECT ENDDATE- [PEDATE]','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('137','2','137','PROJECT [PROJECT] HAVING REPORT UPTO [EDATE].SO CANNOT ABLE TO UPDATE ENDDATE','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('138','3','138','PASSWORD DOES NOT MATCH WITH CONFIRM PASSWORD','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('139','3','139','PASSWORD MUST HAVE AT LEAST 8 CHARACTERS','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('140','3','140','INCCORRECT USERNAME/PASSWORD','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('141','2','141','FILE UPLOADED SUCCESSFULLY','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('142','2','142','FILE NOT UPLOADED','1','X');
INSERT INTO LMC_ERROR_MESSAGE_CONFIGURATION(EMC_ID,CNP_ID,EMC_CODE,EMC_DATA,ULD_ID,EMC_INITIALIZE_FLAG) VALUES ('143','2','143','END TIME SHOULD GREATER THAN START TIME','1','X');

	TRUNCATE LMC_USER_RIGHTS_CONFIGURATION;
	INSERT INTO LMC_USER_RIGHTS_CONFIGURATION(URC_ID,CGN_ID,URC_DATA,URC_USERSTAMP,URC_INITIALIZE_FLAG) VALUES ('1','1','ADMIN','lmc','X');
INSERT INTO LMC_USER_RIGHTS_CONFIGURATION(URC_ID,CGN_ID,URC_DATA,URC_USERSTAMP,URC_INITIALIZE_FLAG) VALUES ('2','1','SUPER ADMIN','lmc','X');
INSERT INTO LMC_USER_RIGHTS_CONFIGURATION(URC_ID,CGN_ID,URC_DATA,URC_USERSTAMP,URC_INITIALIZE_FLAG) VALUES ('3','1','USER','lmc','X');
INSERT INTO LMC_USER_RIGHTS_CONFIGURATION(URC_ID,CGN_ID,URC_DATA,URC_USERSTAMP,URC_INITIALIZE_FLAG) VALUES ('4','6','PERMANENT','lmc','X');
INSERT INTO LMC_USER_RIGHTS_CONFIGURATION(URC_ID,CGN_ID,URC_DATA,URC_USERSTAMP,URC_INITIALIZE_FLAG) VALUES ('5','6','TEMPORARY','lmc','X');
INSERT INTO LMC_USER_RIGHTS_CONFIGURATION(URC_ID,CGN_ID,URC_DATA,URC_USERSTAMP,URC_INITIALIZE_FLAG) VALUES ('6','6','TRAINEE','lmc','X');
INSERT INTO LMC_USER_RIGHTS_CONFIGURATION(URC_ID,CGN_ID,URC_DATA,URC_USERSTAMP,URC_INITIALIZE_FLAG) VALUES ('7','7','2014-01-01','lmc','X');
INSERT INTO LMC_USER_RIGHTS_CONFIGURATION(URC_ID,CGN_ID,URC_DATA,URC_USERSTAMP,URC_INITIALIZE_FLAG) VALUES ('8','8','LMC_REPORT_IMAGE','lmc','X');
INSERT INTO LMC_USER_RIGHTS_CONFIGURATION(URC_ID,CGN_ID,URC_DATA,URC_USERSTAMP,URC_INITIALIZE_FLAG) VALUES ('9','9','LMC_DOCUMENT','lmc','X');
INSERT INTO LMC_USER_RIGHTS_CONFIGURATION(URC_ID,CGN_ID,URC_DATA,URC_USERSTAMP,URC_INITIALIZE_FLAG) VALUES ('10','5','192.168.1.118','lmc','X');
INSERT INTO LMC_USER_RIGHTS_CONFIGURATION(URC_ID,CGN_ID,URC_DATA,URC_USERSTAMP,URC_INITIALIZE_FLAG) VALUES ('11','10','3306','lmc','X');
INSERT INTO LMC_USER_RIGHTS_CONFIGURATION(URC_ID,CGN_ID,URC_DATA,URC_USERSTAMP,URC_INITIALIZE_FLAG) VALUES ('12','3','dhandapani.sattanathan@ssomens.com','lmc','X');
INSERT INTO LMC_USER_RIGHTS_CONFIGURATION(URC_ID,CGN_ID,URC_DATA,URC_USERSTAMP,URC_INITIALIZE_FLAG) VALUES ('13','4','dhandapani.sattanathan@ssomens.com','lmc','X');

	TRUNCATE LMC_REPORT_CONFIGURATION;
	INSERT INTO LMC_REPORT_CONFIGURATION(RC_ID,CGN_ID,RC_DATA,ULD_ID,RC_INITIALIZE_FLAG) VALUES ('1','10','SEARCH BY EMPLOYEE','1','X');
	INSERT INTO LMC_REPORT_CONFIGURATION(RC_ID,CGN_ID,RC_DATA,ULD_ID,RC_INITIALIZE_FLAG) VALUES ('2','10','SEARCH BY TEAM','1','X');

	TRUNCATE LMC_TICKLER_PROFILE;
	INSERT INTO LMC_TICKLER_PROFILE(TP_ID,TP_TYPE) VALUES ('1','UPDATION');
	INSERT INTO LMC_TICKLER_PROFILE(TP_ID,TP_TYPE) VALUES ('2','DELETION');	

	TRUNCATE LMC_TICKLER_TABID_PROFILE;
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('1','LMC_MENU_PROFILE');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('2','LMC_ROLE_CREATION');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('3','LMC_USER_LOGIN_DETAILS');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('4','LMC_USER_MENU_DETAILS');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('5','LMC_USER_ACCESS');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('6','LMC_BASIC_ROLE_PROFILE');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('7','LMC_BASIC_MENU_PROFILE');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('8','LMC_CONFIGURATION_PROFILE');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('9','LMC_CONFIGURATION');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('10','LMC_ERROR_MESSAGE_CONFIGURATION');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('11','LMC_USER_RIGHTS_CONFIGURATION');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('12','LMC_EMAIL_TEMPLATE');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('13','LMC_EMAIL_TEMPLATE_DETAILS');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('14','LMC_EMPLOYEE_DETAILS');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('15','LMC_TICKLER_PROFILE');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('16','LMC_TICKLER_HISTORY');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('17','LMC_TICKLER_TABID_PROFILE');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('18','LMC_TEAM_CREATION');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('19','LMC_TYPE_OF_JOB');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('20','LMC_TEAM_REPORT_DETAILS');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('21','LMC_TEAM_JOB');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('22','LMC_TEAM_EMPLOYEE_REPORT_DETAILS');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('23','LMC_SITE_VISIT_DETAILS');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('24','LMC_MACHINERY_EQUIPMENT_TRANSFER');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('25','LMC_MACHINERY_USAGE');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('26','LMC_FITTING_USAGE');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('27','LMC_MATERIAL_USAGE');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('28','LMC_MACHINERY_USAGE_DETAILS');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('29','LMC_FITTING_USAGE_DETAILS');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('30','LMC_MATERIAL_USAGE_DETAILS');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('31','LMC_RENTAL_MACHINERY_DETAILS');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('32','LMC_EQUIPMENT_USAGE_DETAILS');
	INSERT INTO LMC_TICKLER_TABID_PROFILE(TTIP_ID,TTIP_DATA) VALUES ('33','LMC_ACCIDENT_REPORT_DETAILS');

	SET FOREIGN_KEY_CHECKS=0;
	TRUNCATE LMC_TYPE_OF_JOB;
	INSERT INTO LMC_TYPE_OF_JOB(TOJ_JOB,ULD_ID)VALUES('LAYING',1),('RD CROSSING',1),('DRAIN CROSSING',1),('BULK EXCAVATION',1),
	('CONNECTION',1),('REINSTATEMENT',1);
	SET FOREIGN_KEY_CHECKS=0;
	TRUNCATE LMC_MACHINERY_USAGE;
	INSERT INTO LMC_MACHINERY_USAGE(MCU_MACHINERY_TYPE)VALUES('TEAM LORRY'),('YK 2059'),('MINI EXCAVATOR'),('HYNDAI 145'),('KOMATSU 138'),
	('AIR COMPRESSOR 125');
	SET FOREIGN_KEY_CHECKS=0;
	TRUNCATE LMC_FITTING_USAGE;
	INSERT INTO LMC_FITTING_USAGE(FU_ITEMS)VALUES('COUPLER'),('ELBOW (22/45/90)'),('STUD FLANGE'),('REDUCER'),('END CAP'),
	('PE END VALUE'),('TAPPING TEE'),('ELECTRIC BALL MARKER'),('PVC WARNING SLAB');
	SET FOREIGN_KEY_CHECKS=0;
	TRUNCATE LMC_MATERIAL_USAGE;
	INSERT INTO LMC_MATERIAL_USAGE(MU_ITEMS)VALUES('PREMIX'),('Q/DUST'),('G-STONE'),('CONCRETE SAND'),('CEMENT'),('TOP-SOIL'),
	('TURF (GRASS)'),('MANHOLE (R/T)'),('CHAMBER (R/T)'),('DIESEL');
	SET FOREIGN_KEY_CHECKS=0;

	
	SET FOREIGN_KEY_CHECKS=0;
	TRUNCATE LMC_USER_ACCESS;
	
	INSERT INTO LMC_USER_ACCESS(RC_ID,ULD_ID,UA_REC_VER,UA_JOIN_DATE,UA_JOIN,UA_EMP_TYPE,UA_USERSTAMP)VALUES
	(1,1,1,CURDATE(),'X',4,'lmc');
	

	TRUNCATE LMC_EMPLOYEE_DETAILS;
	INSERT INTO LMC_EMPLOYEE_DETAILS(ULD_ID,EMP_FIRST_NAME,EMP_LAST_NAME,NRIC_NO,EMP_DESIGNATION,EMP_MOBILE_NUMBER ,EMP_DOB,TC_ID,EMP_ADDRESS,EMP_IMAGE_FOLDER_ID,EMP_DOC_FOLDER_ID,EMP_GENDER,EMP_NEXT_KIN_NAME,EMP_RELATIONHOOD,EMP_ALT_MOBILE_NO,EMP_BANK_NAME,EMP_BRANCH_NAME,EMP_ACCOUNT_NAME,EMP_ACCOUNT_NO,EMP_IFSC_CODE,EMP_ACCOUNT_TYPE,EMP_BRANCH_ADDRESS,EMP_USERSTAMP_ID)VALUES
	(1,'SATTANATHAN','DHANDAPANI','S6093155B','TEAM LEADER','73738399','1980-01-01',1,'SINGAPORE',(SELECT CONCAT('SN_',CURDATE(),'_',CURTIME())),(SELECT CONCAT('SN_',CURDATE(),'_',CURTIME())),'MALE','DHANDAPANI','FATHER','78967890','IOB','MUTHIALPET','SN','638383983','63738738','SAVINGS','MUTHIALEPT',1);
	
	UPDATE LMC_EMPLOYEE_DETAILS SET EMP_DOC_FOLDER_ID=(SELECT REPLACE(EMP_DOC_FOLDER_ID,'-','')),EMP_IMAGE_FOLDER_ID=(SELECT REPLACE(EMP_DOC_FOLDER_ID,'-',''));
	UPDATE LMC_EMPLOYEE_DETAILS SET EMP_DOC_FOLDER_ID=(SELECT REPLACE(EMP_DOC_FOLDER_ID,':','')),EMP_IMAGE_FOLDER_ID=(SELECT REPLACE(EMP_DOC_FOLDER_ID,':',''));
  

	TRUNCATE LMC_MENU_PROFILE;

	INSERT INTO LMC_MENU_PROFILE(MP_ID,MP_MNAME,MP_MSUB,MP_MSUBMENU,MP_MFILENAME,MP_SCRIPT_FLAG) VALUES ('1','ACCESS RIGHTS','ACCESS RIGHTS-SEARCH/UPDATE',null,'FORM_ACCESS_RIGHTS_ACCESS_RIGHTS-SEARCH_UPDATE',null);
	INSERT INTO LMC_MENU_PROFILE(MP_ID,MP_MNAME,MP_MSUB,MP_MSUBMENU,MP_MFILENAME,MP_SCRIPT_FLAG) VALUES ('2','ACCESS RIGHTS','TERMINATE-SEARCH/UPDATE',null,'FORM_ACCESS_RIGHTS_TERMINATE-SEARCH_UPDATE',null);
	INSERT INTO LMC_MENU_PROFILE(MP_ID,MP_MNAME,MP_MSUB,MP_MSUBMENU,MP_MFILENAME,MP_SCRIPT_FLAG) VALUES ('3','ACCESS RIGHTS','USER SEARCH DETAILS',null,'FORM_ACCESS_RIGHTS_USER_SEARCH_DETAIL',null);
	INSERT INTO LMC_MENU_PROFILE(MP_ID,MP_MNAME,MP_MSUB,MP_MSUBMENU,MP_MFILENAME,MP_SCRIPT_FLAG) VALUES ('4','ACCESS RIGHTS','SITE MAINTENANCE',null,'FORM_ACCESS_RIGHTS_SITE_MAINTENANCE',null);
	INSERT INTO LMC_MENU_PROFILE(MP_ID,MP_MNAME,MP_MSUB,MP_MSUBMENU,MP_MFILENAME,MP_SCRIPT_FLAG) VALUES ('5','PERMITS','ENTRY',null,'FORM_PERMITS_ENTRY',null);
	INSERT INTO LMC_MENU_PROFILE(MP_ID,MP_MNAME,MP_MSUB,MP_MSUBMENU,MP_MFILENAME,MP_SCRIPT_FLAG) VALUES ('6','PERMITS','SEARCH',null,'FORM_PERMITS_SEARCH',null);
	INSERT INTO LMC_MENU_PROFILE(MP_ID,MP_MNAME,MP_MSUB,MP_MSUBMENU,MP_MFILENAME,MP_SCRIPT_FLAG) VALUES ('7','PERMITS','UPDATE',null,'FORM_PERMITS_UPDATE',null);
	INSERT INTO LMC_MENU_PROFILE(MP_ID,MP_MNAME,MP_MSUB,MP_MSUBMENU,MP_MFILENAME,MP_SCRIPT_FLAG) VALUES ('8','AUDIT','AUDIT HISTORY',null,'FORM_AUDIT_AUDIT_HISTORY',null);
	INSERT INTO LMC_MENU_PROFILE(MP_ID,MP_MNAME,MP_MSUB,MP_MSUBMENU,MP_MFILENAME,MP_SCRIPT_FLAG) VALUES ('9','EMAIL','ENTRY',null,'FORM_EMAIL_ENTRY',null);
	INSERT INTO LMC_MENU_PROFILE(MP_ID,MP_MNAME,MP_MSUB,MP_MSUBMENU,MP_MFILENAME,MP_SCRIPT_FLAG) VALUES ('10','EMAIL','SEARCH/UPDATE',null,'FORM_EMAIL_SEARCH_UPDATE',null);
	INSERT INTO LMC_MENU_PROFILE(MP_ID,MP_MNAME,MP_MSUB,MP_MSUBMENU,MP_MFILENAME,MP_SCRIPT_FLAG) VALUES ('11','ACCIDENT','ENTRY',null,'FORM_ACCIDENT_ENTRY',null);
	INSERT INTO LMC_MENU_PROFILE(MP_ID,MP_MNAME,MP_MSUB,MP_MSUBMENU,MP_MFILENAME,MP_SCRIPT_FLAG) VALUES ('12','ACCIDENT','SEARCH UPDATE',null,'FORM_ACCIDENT_SEARCH_UPDATE',null);

	TRUNCATE LMC_USER_MENU_DETAILS;
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('1','1','1','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('2','2','1','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('3','3','1','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('4','4','1','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('5','5','1','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('6','6','1','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('7','7','1','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('8','8','1','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('9','9','1','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('10','10','1','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('11','11','1','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('12','12','1','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('13','1','2','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('14','2','2','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('15','3','2','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('16','4','2','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('17','5','2','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('18','6','2','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('19','7','2','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('20','8','2','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('21','9','2','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('22','10','2','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('23','11','2','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('24','12','2','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('25','5','3','1');
	INSERT INTO LMC_USER_MENU_DETAILS(UMD_ID,MP_ID,RC_ID,ULD_ID) VALUES ('26','6','3','1');

	TRUNCATE LMC_BASIC_ROLE_PROFILE;
	INSERT INTO LMC_BASIC_ROLE_PROFILE(BRP_ID,URC_ID,BRP_BR_ID,ULD_ID) VALUES ('1','1','1','1');
	INSERT INTO LMC_BASIC_ROLE_PROFILE(BRP_ID,URC_ID,BRP_BR_ID,ULD_ID) VALUES ('2','1','2','1');
	INSERT INTO LMC_BASIC_ROLE_PROFILE(BRP_ID,URC_ID,BRP_BR_ID,ULD_ID) VALUES ('3','1','3','1');
	INSERT INTO LMC_BASIC_ROLE_PROFILE(BRP_ID,URC_ID,BRP_BR_ID,ULD_ID) VALUES ('4','2','1','1');
	INSERT INTO LMC_BASIC_ROLE_PROFILE(BRP_ID,URC_ID,BRP_BR_ID,ULD_ID) VALUES ('5','2','2','1');
	INSERT INTO LMC_BASIC_ROLE_PROFILE(BRP_ID,URC_ID,BRP_BR_ID,ULD_ID) VALUES ('6','2','3','1');
	INSERT INTO LMC_BASIC_ROLE_PROFILE(BRP_ID,URC_ID,BRP_BR_ID,ULD_ID) VALUES ('7','3','3','1');

	TRUNCATE LMC_BASIC_MENU_PROFILE;
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('1','1','1','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('2','1','2','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('3','1','3','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('4','1','4','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('5','1','5','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('6','1','6','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('7','1','7','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('8','1','8','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('9','1','9','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('10','1','10','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('11','1','11','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('12','1','12','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('13','2','1','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('14','2','2','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('15','2','3','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('16','2','4','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('17','2','5','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('18','2','6','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('19','2','7','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('20','2','8','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('21','2','9','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('22','2','10','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('23','2','11','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('24','2','12','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('25','3','1','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('26','3','2','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('27','3','3','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('28','3','4','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('29','3','5','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('30','3','6','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('31','3','7','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('32','3','8','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('33','3','9','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('34','3','10','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('35','3','11','1');
	INSERT INTO LMC_BASIC_MENU_PROFILE(BMP_ID,URC_ID,MP_ID,ULD_ID) VALUES ('36','3','12','1');
	SET SUCCESS_MESSAGE = 1;

	COMMIT;
END//
DELIMITER ;


-- Dumping structure for procedure SP_LMC_MACHINERY_EQUIPMENT_TRANSFER
DROP PROCEDURE IF EXISTS `SP_LMC_MACHINERY_EQUIPMENT_TRANSFER`;
DELIMITER //
CREATE  PROCEDURE `SP_LMC_MACHINERY_EQUIPMENT_TRANSFER`(
SEARCH_OPTION INTEGER,
METID TEXT,
TRDID INTEGER,
FROM_LORRYNO TEXT,
TO_LORRYNO TEXT,
ITEM TEXT,
REMARK TEXT,
USERSTAMP VARCHAR(50),
OUT SUCCESS_MESSAGE TEXT)
BEGIN
DECLARE MAC_FROM_LORRYNO VARCHAR(20);
DECLARE MAC_TO_LORRYNO VARCHAR(20);
DECLARE MAC_ITEM VARCHAR(30);
DECLARE MAC_REMARK TEXT;
DECLARE T_MET_ID TEXT;
DECLARE LMC_METID INTEGER;
DECLARE T_FROM_LORRY_NO VARCHAR(20);
DECLARE T_TO_LORRY_NO VARCHAR(20);
DECLARE T_ITEM VARCHAR(30);
DECLARE T_REMARK TEXT;
DECLARE T_ULDID INTEGER;
DECLARE T_TIMESTAMP TIMESTAMP;
DECLARE OLDVALUE TEXT;


SET @MACFROMLORRYNO=FROM_LORRYNO;
SET @MACTOLORRYNO=TO_LORRYNO;
SET @MACITEM=ITEM;
SET @MACHREMARK=REMARK;
SET @LMCMETID=METID;

SET SUCCESS_MESSAGE=0;

IF SEARCH_OPTION=2 THEN
		SET T_MET_ID=(SELECT REPLACE(METID,' ','0'));
		SET @SETLMC_METID=(SELECT CONCAT('SELECT GROUP_CONCAT(MET_ID) INTO @L_METID FROM LMC_MACHINERY_EQUIPMENT_TRANSFER WHERE TRD_ID=',TRDID,' AND MET_ID NOT IN(',T_MET_ID,')'));
		PREPARE SETLMC_METID_STMT FROM @SETLMC_METID;
		EXECUTE SETLMC_METID_STMT;

		SET T_MET_ID=@L_METID;

		IF T_MET_ID=' ' THEN
			SET T_MET_ID=NULL;
		END IF;

	IF T_MET_ID IS NOT NULL THEN
		SET @TICK_T_METID=T_MET_ID;

		MAIN_LOOP : LOOP

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES(',',@TICK_T_METID,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_METID;
		SELECT @REMAINING_STRING INTO @TICK_T_METID;

		SET T_FROM_LORRY_NO=(SELECT MET_FROM_LORRY_NO FROM LMC_MACHINERY_EQUIPMENT_TRANSFER WHERE MET_ID=LMC_METID);
		IF T_FROM_LORRY_NO IS NULL  THEN
			SET T_FROM_LORRY_NO='<NULL>';
		END IF;
		SET T_TO_LORRY_NO=(SELECT MET_TO_LORRY_NO FROM LMC_MACHINERY_EQUIPMENT_TRANSFER WHERE MET_ID=LMC_METID);
		IF T_TO_LORRY_NO IS NULL THEN
			SET T_TO_LORRY_NO='<NULL>';
		END IF;
		SET T_ITEM=(SELECT MET_ITEM FROM LMC_MACHINERY_EQUIPMENT_TRANSFER WHERE MET_ID=LMC_METID);
		IF T_ITEM IS NULL THEN
			SET T_ITEM='<NULL>';
		END IF;
		SET T_ULDID=(SELECT ULD_ID FROM LMC_MACHINERY_EQUIPMENT_TRANSFER WHERE MET_ID=LMC_METID);
		SET T_TIMESTAMP=(SELECT MET_TIMESTAMP FROM LMC_MACHINERY_EQUIPMENT_TRANSFER WHERE MET_ID=LMC_METID);

		SET OLDVALUE=(SELECT CONCAT('MET_ID=',LMC_METID,',TRD_ID=',TRDID,',MET_FROM_LORRY_NO=',T_FROM_LORRY_NO,',MET_TO_LORRY_NO=',T_TO_LORRY_NO,',MET_ITEM=',T_ITEM,
		',ULD_ID=',T_ULDID,',MET_TIMESTAMP=',T_TIMESTAMP));
		INSERT INTO LMC_TICKLER_HISTORY(TP_ID,EMP_ID,TTIP_ID,TH_OLD_VALUE,TH_USERSTAMP_ID)VALUES
		((SELECT TP_ID FROM LMC_TICKLER_PROFILE WHERE TP_TYPE='DELETION'),(SELECT EMP_ID FROM LMC_TEAM_REPORT_DETAILS WHERE TRD_ID=TRDID),
		(SELECT TTIP_ID FROM LMC_TICKLER_TABID_PROFILE WHERE TTIP_DATA='LMC_MACHINERY_EQUIPMENT_TRANSFER'),OLDVALUE,
		(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
		DELETE FROM LMC_MACHINERY_EQUIPMENT_TRANSFER WHERE  MET_ID=LMC_METID;

		IF @TICK_T_METID IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;
	END LOOP;
	END IF;
END IF;

	MAIN_LOOP : LOOP
		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@MACFROMLORRYNO,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO MAC_FROM_LORRYNO;
		SELECT @REMAINING_STRING INTO @MACFROMLORRYNO;

		IF MAC_FROM_LORRYNO=' ' THEN
			SET MAC_FROM_LORRYNO=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@MACTOLORRYNO,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO MAC_TO_LORRYNO;
		SELECT @REMAINING_STRING INTO @MACTOLORRYNO;

		IF MAC_TO_LORRYNO=' ' THEN
			SET MAC_TO_LORRYNO=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',  @MACITEM,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO MAC_ITEM;
		SELECT @REMAINING_STRING INTO @MACITEM;

		IF MAC_ITEM=' ' THEN
			SET MAC_ITEM=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@MACHREMARK,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO MAC_REMARK;
		SELECT @REMAINING_STRING INTO @MACHREMARK;

		IF MAC_REMARK='' THEN
			SET MAC_REMARK=NULL;
		END IF;

		IF SEARCH_OPTION=2 THEN
			CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES(',',@LMCMETID,@VALUE,@REMAINING_STRING);
			SELECT @VALUE INTO LMC_METID;
			SELECT @REMAINING_STRING INTO @LMCMETID;
		END IF;

		IF LMC_METID=' ' THEN
			SET LMC_METID=NULL;
		END IF;
	IF SEARCH_OPTION=1 THEN
		IF MAC_FROM_LORRYNO IS NOT NULL AND  MAC_TO_LORRYNO IS NOT NULL AND MAC_ITEM IS NOT NULL THEN

					INSERT INTO LMC_MACHINERY_EQUIPMENT_TRANSFER(TRD_ID,MET_FROM_LORRY_NO,MET_TO_LORRY_NO,MET_ITEM,MET_REMARK,ULD_ID)VALUES 
					(TRDID,MAC_FROM_LORRYNO,MAC_TO_LORRYNO,MAC_ITEM,MAC_REMARK,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
		END IF;
	END IF;
	IF SEARCH_OPTION=2 THEN
		IF LMC_METID IS NULL AND MAC_FROM_LORRYNO IS NOT NULL AND  MAC_TO_LORRYNO IS NOT NULL AND MAC_ITEM IS NOT NULL THEN
			INSERT INTO LMC_MACHINERY_EQUIPMENT_TRANSFER(TRD_ID,MET_FROM_LORRY_NO,MET_TO_LORRY_NO,MET_ITEM,MET_REMARK,ULD_ID)VALUES 
			(TRDID,MAC_FROM_LORRYNO,MAC_TO_LORRYNO,MAC_ITEM,MAC_REMARK,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
		END IF;
		IF LMC_METID IS NOT NULL AND MAC_FROM_LORRYNO IS NOT NULL AND  MAC_TO_LORRYNO IS NOT NULL AND MAC_ITEM IS NOT NULL THEN
			UPDATE LMC_MACHINERY_EQUIPMENT_TRANSFER SET TRD_ID=TRDID,MET_FROM_LORRY_NO=MAC_FROM_LORRYNO,MET_TO_LORRY_NO=MAC_TO_LORRYNO,MET_ITEM=MAC_ITEM,MET_REMARK=MAC_REMARK,ULD_ID=(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP) WHERE MET_ID=LMC_METID;
		END IF;
	END IF;

		IF  @MACFROMLORRYNO IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;

	END LOOP;
SET SUCCESS_MESSAGE=1;

END//
DELIMITER ;


-- Dumping structure for procedure SP_LMC_MACHINERY_USAGE_DETAILS
DROP PROCEDURE IF EXISTS `SP_LMC_MACHINERY_USAGE_DETAILS`;
DELIMITER //
CREATE  PROCEDURE `SP_LMC_MACHINERY_USAGE_DETAILS`(
SEARCH_OPTION INTEGER,
MACID TEXT,
TRDID INTEGER,
MACH_TYPE TEXT,
STARTTIME TEXT,
ENDTIME TEXT,
REMARK TEXT,
USERSTAMP VARCHAR(50),
OUT SUCCESS_MESSAGE TEXT)
BEGIN
DECLARE MACHTYPE VARCHAR(30);
DECLARE MACH_STARTTIME TIME;
DECLARE MACH_ENDTIME TIME;
DECLARE MACH_REMARK TEXT;
DECLARE MCUID INTEGER;
DECLARE T_MACID TEXT;
DECLARE LMC_MACID INTEGER;
DECLARE T_MCUID INTEGER;
DECLARE T_STARTTIME TIME;
DECLARE T_ENDTIME TIME;
DECLARE T_REMARK TEXT;
DECLARE T_ULDID INTEGER;
DECLARE T_TIMESTAMP TIMESTAMP;
DECLARE OLDVALUE TEXT;
SET @TYPE=MACH_TYPE;
SET @S_TIME=STARTTIME;
SET @E_TIME=ENDTIME;
SET @MACHREMARK=REMARK;
SET @LMCMACID=MACID;

SET SUCCESS_MESSAGE=0;
IF SEARCH_OPTION=2 THEN
		SET T_MACID=(SELECT REPLACE(MACID,' ','0'));
		SET @SETLMC_MACID=(SELECT CONCAT('SELECT GROUP_CONCAT(MAC_ID) INTO @L_MAC_ID FROM LMC_MACHINERY_USAGE_DETAILS WHERE TRD_ID=',TRDID,' AND MAC_ID NOT IN(',T_MACID,')'));
		PREPARE SETLMC_MACID_STMT FROM @SETLMC_MACID;
		EXECUTE SETLMC_MACID_STMT;

		SET T_MACID=@L_MAC_ID;

		IF T_MACID=' ' THEN
			SET T_MACID=NULL;
		END IF;

	IF T_MACID IS NOT NULL THEN
		SET @TICK_MACID=T_MACID;

		MAIN_LOOP : LOOP

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES(',',@TICK_MACID,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_MACID;
		SELECT @REMAINING_STRING INTO @TICK_MACID;

		SET T_MCUID=(SELECT MCU_ID FROM LMC_MACHINERY_USAGE_DETAILS WHERE MAC_ID=LMC_MACID);
		IF T_MCUID IS NULL  THEN
			SET T_MCUID='<NULL>';
		END IF;

		SET T_STARTTIME=(SELECT MAC_START_TIME FROM LMC_MACHINERY_USAGE_DETAILS WHERE MAC_ID=LMC_MACID);
		IF T_STARTTIME IS NULL  THEN
			SET T_STARTTIME='<NULL>';
		END IF;

		
		SET T_ENDTIME=(SELECT MAC_END_TIME FROM LMC_MACHINERY_USAGE_DETAILS WHERE MAC_ID=LMC_MACID);
		IF T_ENDTIME IS NULL THEN
			SET T_ENDTIME='<NULL>';
		END IF;

		SET T_REMARK=(SELECT MAC_REMARK FROM LMC_MACHINERY_USAGE_DETAILS WHERE MAC_ID=LMC_MACID);
		IF T_REMARK IS NULL THEN
			SET T_REMARK='<NULL>';
		END IF;
		
		
		SET T_ULDID=(SELECT ULD_ID FROM LMC_MACHINERY_USAGE_DETAILS WHERE MAC_ID=LMC_MACID);
		SET T_TIMESTAMP=(SELECT MAC_TIMESTAMP FROM LMC_MACHINERY_USAGE_DETAILS WHERE MAC_ID=LMC_MACID);

		SET OLDVALUE=(SELECT CONCAT('MAC_ID=',LMC_MACID,',TRD_ID=',TRDID,',MCU_ID=',T_MCUID,',MAC_START_TIME=',T_STARTTIME,',MAC_END_TIME=',T_ENDTIME
		,',MAC_REMARK=',T_REMARK,',ULD_ID=',T_ULDID,',MAC_TIMESTAMP=',T_TIMESTAMP));

		INSERT INTO LMC_TICKLER_HISTORY(TP_ID,EMP_ID,TTIP_ID,TH_OLD_VALUE,TH_USERSTAMP_ID)VALUES
		((SELECT TP_ID FROM LMC_TICKLER_PROFILE WHERE TP_TYPE='DELETION'),(SELECT EMP_ID FROM LMC_TEAM_REPORT_DETAILS WHERE TRD_ID=TRDID),
		(SELECT TTIP_ID FROM LMC_TICKLER_TABID_PROFILE WHERE TTIP_DATA='LMC_MACHINERY_USAGE_DETAILS'),OLDVALUE,
		(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
		DELETE FROM LMC_MACHINERY_USAGE_DETAILS WHERE  MAC_ID=LMC_MACID;

		IF @TICK_MACID IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;
	END LOOP;
	END IF;
END IF;

	MAIN_LOOP : LOOP
		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@TYPE,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO MACHTYPE;
		SELECT @REMAINING_STRING INTO @TYPE;
		IF NOT EXISTS(SELECT MCU_ID FROM LMC_MACHINERY_USAGE WHERE MCU_MACHINERY_TYPE=MACHTYPE)THEN
			INSERT INTO LMC_MACHINERY_USAGE(MCU_MACHINERY_TYPE)VALUES(MACHTYPE);
			SET MCUID=(SELECT MCU_ID FROM LMC_MACHINERY_USAGE WHERE MCU_MACHINERY_TYPE=MACHTYPE);
		ELSE
			SET MCUID=(SELECT MCU_ID FROM LMC_MACHINERY_USAGE WHERE MCU_MACHINERY_TYPE=MACHTYPE);
		END IF;


		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@S_TIME,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO MACH_STARTTIME;
		SELECT @REMAINING_STRING INTO @S_TIME;
		IF MACH_STARTTIME=' ' THEN
			SET MACH_STARTTIME=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^', @E_TIME,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO MACH_ENDTIME;
		SELECT @REMAINING_STRING INTO @E_TIME;
		IF MACH_ENDTIME= ' ' THEN
			SET MACH_ENDTIME=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@MACHREMARK,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO MACH_REMARK;
		SELECT @REMAINING_STRING INTO @MACHREMARK;
		IF MACH_REMARK='' THEN
			SET MACH_REMARK=NULL;
		END IF;
		IF SEARCH_OPTION=2 THEN
			CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES(',',@LMCMACID,@VALUE,@REMAINING_STRING);
			SELECT @VALUE INTO LMC_MACID;
			SELECT @REMAINING_STRING INTO @LMCMACID;
		END IF;

		IF LMC_MACID=' ' THEN
			SET LMC_MACID=NULL;
		END IF; 
	IF SEARCH_OPTION=1 THEN
		IF MACHTYPE IS NOT NULL AND  MACH_STARTTIME IS NOT NULL AND MACH_ENDTIME IS NOT NULL THEN
			IF NOT EXISTS(SELECT MAC_ID FROM LMC_MACHINERY_USAGE_DETAILS WHERE TRD_ID=TRDID AND MCU_ID=MCUID)THEN
				INSERT INTO LMC_MACHINERY_USAGE_DETAILS(TRD_ID,MCU_ID,MAC_START_TIME,MAC_END_TIME,MAC_REMARK,ULD_ID)VALUES 
				(TRDID,MCUID,MACH_STARTTIME,MACH_ENDTIME,MACH_REMARK,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
			END IF;
		END IF;
	END IF;

	IF SEARCH_OPTION=2 THEN
		IF LMC_MACID IS NULL AND MACHTYPE IS NOT NULL AND  MACH_STARTTIME IS NOT NULL AND MACH_ENDTIME IS NOT NULL THEN
			IF NOT EXISTS(SELECT MAC_ID FROM LMC_MACHINERY_USAGE_DETAILS WHERE TRD_ID=TRDID AND MCU_ID=MCUID)THEN
				INSERT INTO LMC_MACHINERY_USAGE_DETAILS(TRD_ID,MCU_ID,MAC_START_TIME,MAC_END_TIME,MAC_REMARK,ULD_ID)VALUES 
				(TRDID,MCUID,MACH_STARTTIME,MACH_ENDTIME,MACH_REMARK,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
			END IF;
		END IF;
		IF LMC_MACID IS NOT NULL AND MACHTYPE IS NOT NULL AND  MACH_STARTTIME IS NOT NULL AND MACH_ENDTIME IS NOT NULL THEN
				UPDATE LMC_MACHINERY_USAGE_DETAILS SET TRD_ID=TRDID,MCU_ID=MCUID,MAC_START_TIME=MACH_STARTTIME,MAC_END_TIME=MACH_ENDTIME,MAC_REMARK=MACH_REMARK,ULD_ID=(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP)
				WHERE MAC_ID=LMC_MACID;
		END IF;
	END IF;
		IF  @TYPE IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;

	END LOOP;
SET SUCCESS_MESSAGE=1;

END//
DELIMITER ;


-- Dumping structure for procedure SP_LMC_MATERAIL_USAGE_DETAILS
DROP PROCEDURE IF EXISTS `SP_LMC_MATERAIL_USAGE_DETAILS`;
DELIMITER //
CREATE  PROCEDURE `SP_LMC_MATERAIL_USAGE_DETAILS`(
SEARCH_OPTION INTEGER,
MUDID TEXT,
TRDID INTEGER,
ITEMS TEXT,
RECEIPTNO TEXT,
QUANTITY TEXT,
USERSTAMP VARCHAR(50),
OUT SUCCESS_MESSAGE TEXT)
BEGIN
DECLARE MUITEMS VARCHAR(50);
DECLARE MURECEIPTNO VARCHAR(25);
DECLARE MUQUANTITY INTEGER;
DECLARE MUID INTEGER;
DECLARE T_MUD_ID TEXT;
DECLARE TICK_T_MUDID TEXT;
DECLARE LMC_MUDID INTEGER;
DECLARE T_MUID INTEGER;
DECLARE T_RECEIPT_NO VARCHAR(25);
DECLARE T_QUANTITY INTEGER;
DECLARE T_ULDID INTEGER;
DECLARE T_TIMESTAMP TIMESTAMP;
DECLARE OLDVALUE TEXT;

SET @M_ITEMS=ITEMS;
SET @M_RECEIPTNO=RECEIPTNO;
SET @M_QUANTITY=QUANTITY;
SET @LMCMUDID=MUDID;
SET SUCCESS_MESSAGE=0;

IF SEARCH_OPTION=2 THEN
		SET T_MUD_ID=(SELECT REPLACE(MUDID,' ','0'));
		SET @SETLMC_MUD_ID=(SELECT CONCAT('SELECT GROUP_CONCAT(MUD_ID) INTO @L_MUDID FROM LMC_MATERIAL_USAGE_DETAILS WHERE TRD_ID=',TRDID,' AND MUD_ID NOT IN(',T_MUD_ID,')'));
		PREPARE SETLMC_MUD_ID_STMT FROM @SETLMC_MUD_ID;
		EXECUTE SETLMC_MUD_ID_STMT;

		SET T_MUD_ID=@L_MUDID;

		IF T_MUD_ID=' ' THEN
			SET T_MUD_ID=NULL;
		END IF;

	IF T_MUD_ID IS NOT NULL THEN
		SET @TICK_T_MUDID=T_MUD_ID;

		MAIN_LOOP : LOOP

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES(',',@TICK_T_MUDID,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_MUDID;
		SELECT @REMAINING_STRING INTO @TICK_T_MUDID;

		SET T_MUID=(SELECT MU_ID FROM LMC_MATERIAL_USAGE_DETAILS WHERE MUD_ID=LMC_MUDID);
		IF T_MUID IS NULL  THEN
			SET T_MUID='<NULL>';
		END IF;
		SET T_RECEIPT_NO=(SELECT MUD_RECEIPT_NO FROM LMC_MATERIAL_USAGE_DETAILS WHERE MUD_ID=LMC_MUDID);
		IF T_RECEIPT_NO IS NULL THEN
			SET T_RECEIPT_NO='<NULL>';
		END IF;
		SET T_QUANTITY=(SELECT MUD_QUANTITY FROM LMC_MATERIAL_USAGE_DETAILS WHERE MUD_ID=LMC_MUDID);
		IF T_QUANTITY IS NULL THEN
			SET T_QUANTITY='<NULL>';
		END IF;
		
		SET T_ULDID=(SELECT ULD_ID FROM LMC_MATERIAL_USAGE_DETAILS WHERE MUD_ID=LMC_MUDID);
		SET T_TIMESTAMP=(SELECT MUD_TIMESTAMP FROM LMC_MATERIAL_USAGE_DETAILS WHERE MUD_ID=LMC_MUDID);

		SET OLDVALUE=(SELECT CONCAT('MUD_ID=',LMC_MUDID,',TRD_ID=',TRDID,',MU_ID=',T_MUID,',MUD_RECEIPT_NO=',T_RECEIPT_NO,',MUD_QUANTITY=',T_QUANTITY,
		',ULD_ID=',T_ULDID,',MUD_TIMESTAMP=',T_TIMESTAMP));

		INSERT INTO LMC_TICKLER_HISTORY(TP_ID,EMP_ID,TTIP_ID,TH_OLD_VALUE,TH_USERSTAMP_ID)VALUES
		((SELECT TP_ID FROM LMC_TICKLER_PROFILE WHERE TP_TYPE='DELETION'),(SELECT EMP_ID FROM LMC_TEAM_REPORT_DETAILS WHERE TRD_ID=TRDID),
		(SELECT TTIP_ID FROM LMC_TICKLER_TABID_PROFILE WHERE TTIP_DATA='LMC_MATERIAL_USAGE_DETAILS'),OLDVALUE,
		(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
		DELETE FROM LMC_MATERIAL_USAGE_DETAILS WHERE  MUD_ID=LMC_MUDID;

		IF @TICK_T_MUDID IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;
	END LOOP;
	END IF;
END IF;
	MAIN_LOOP : LOOP
		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@M_ITEMS,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO MUITEMS;
		SELECT @REMAINING_STRING INTO @M_ITEMS;
		IF MUITEMS=' ' THEN
			SET MUITEMS=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@M_RECEIPTNO,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO MURECEIPTNO;
		SELECT @REMAINING_STRING INTO @M_RECEIPTNO;
		IF MURECEIPTNO=' ' THEN
			SET MURECEIPTNO=NULL;
		END IF;


		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@M_QUANTITY,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO MUQUANTITY;
		SELECT @REMAINING_STRING INTO @M_QUANTITY;
		
		IF MUQUANTITY=' ' THEN
			SET MUQUANTITY=NULL;
		END IF;


		IF NOT EXISTS(SELECT MU_ID FROM LMC_MATERIAL_USAGE WHERE MU_ITEMS=MUITEMS)THEN
			INSERT INTO LMC_MATERIAL_USAGE(MU_ITEMS)VALUES(MUITEMS);
			SET MUID=(SELECT MU_ID FROM LMC_MATERIAL_USAGE WHERE MU_ITEMS=MUITEMS);
		ELSE
			SET MUID=(SELECT MU_ID FROM LMC_MATERIAL_USAGE WHERE MU_ITEMS=MUITEMS);

		END IF;

		IF SEARCH_OPTION=2 THEN
			CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES(',',@LMCMUDID,@VALUE,@REMAINING_STRING);
			SELECT @VALUE INTO LMC_MUDID;
			SELECT @REMAINING_STRING INTO @LMCMUDID;
		END IF;

		IF LMC_MUDID=' ' THEN
			SET LMC_MUDID=NULL;
		END IF; 

	IF SEARCH_OPTION=1 THEN
		IF ITEMS IS NOT NULL AND RECEIPTNO IS NOT NULL AND QUANTITY IS NOT NULL THEN

			IF NOT EXISTS(SELECT MUD_ID FROM LMC_MATERIAL_USAGE_DETAILS WHERE TRD_ID=TRDID AND MU_ID=MUID)THEN

				INSERT INTO LMC_MATERIAL_USAGE_DETAILS(TRD_ID,MU_ID,MUD_RECEIPT_NO,MUD_QUANTITY,ULD_ID)VALUES 
				(TRDID,MUID,MURECEIPTNO,MUQUANTITY,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
			END IF;
	
		END IF;
	END IF;

	IF SEARCH_OPTION=2 THEN
		IF LMC_MUDID IS NULL AND ITEMS IS NOT NULL AND RECEIPTNO IS NOT NULL AND QUANTITY IS NOT NULL THEN
			IF NOT EXISTS(SELECT MUD_ID FROM LMC_MATERIAL_USAGE_DETAILS WHERE TRD_ID=TRDID AND MU_ID=MUID)THEN

				INSERT INTO LMC_MATERIAL_USAGE_DETAILS(TRD_ID,MU_ID,MUD_RECEIPT_NO,MUD_QUANTITY,ULD_ID)VALUES 
				(TRDID,MUID,MURECEIPTNO,MUQUANTITY,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
			END IF;
		END IF;
		IF LMC_MUDID IS NOT NULL AND ITEMS IS NOT NULL AND RECEIPTNO IS NOT NULL AND QUANTITY IS NOT NULL THEN
			UPDATE LMC_MATERIAL_USAGE_DETAILS SET TRD_ID=TRDID,MU_ID=MUID,MUD_RECEIPT_NO=MURECEIPTNO,MUD_QUANTITY=MUQUANTITY,ULD_ID=(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP) WHERE MUD_ID=LMC_MUDID;
		END IF;
	END IF;


		IF @M_ITEMS IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;

	END LOOP;
	SET SUCCESS_MESSAGE=1;
END//
DELIMITER ;


-- Dumping structure for procedure SP_LMC_RENTAL_MACHINERY_DETAILS
DROP PROCEDURE IF EXISTS `SP_LMC_RENTAL_MACHINERY_DETAILS`;
DELIMITER //
CREATE  PROCEDURE `SP_LMC_RENTAL_MACHINERY_DETAILS`( 
SEARCH_OPTION INTEGER, 
RMDID TEXT, 
TRDID INTEGER, 
LORRYNO TEXT, 
THROW_EARTH_STORE TEXT, 
THROW_EARTH_OUTSIDE TEXT,
STARTTIME TEXT, 
ENDTIME TEXT, 
REMARK TEXT, 
USERSTAMP VARCHAR(50), 
OUT SUCCESS_MESSAGE TEXT)
BEGIN 
DECLARE RMLORRYNO VARCHAR(20); 
DECLARE RMTHROW_EARTH_STORE INTEGER; 
DECLARE RMTHROW_EARTH_OUTSIDE INTEGER; 
DECLARE RMSTARTTIME TIME; 
DECLARE RMENDTIME TIME; 
DECLARE RMREMARK TEXT; 
DECLARE T_RMD_ID TEXT; 
DECLARE LMC_RMDID INTEGER; 
DECLARE T_LORRYNO VARCHAR(20);
DECLARE T_EARTH_STORE INTEGER;
DECLARE T_EARTH_OUTSIDE INTEGER;
DECLARE T_START_TIME TIME;
DECLARE T_END_TIME TIME;
DECLARE T_REMARK TEXT;
DECLARE T_ULDID INTEGER;
DECLARE T_TIMESTAMP TIMESTAMP;
DECLARE OLDVALUE TEXT;

SET @RM_LORRYNO=LORRYNO;
SET @RM_THROW_EARTH_STORE=THROW_EARTH_STORE;
SET @RM_THROW_EARTH_OUTSIDE=THROW_EARTH_OUTSIDE;
SET @RM_STARTTIME=STARTTIME;
SET @RM_ENDTIME=ENDTIME;
SET @RM_REMARK=REMARK;
SET @LMCRMDID=RMDID;
SET SUCCESS_MESSAGE=0;

IF SEARCH_OPTION=2 THEN
		SET T_RMD_ID=(SELECT REPLACE(RMDID,' ','0'));
		SET @SETLMC_RMD_ID=(SELECT CONCAT('SELECT GROUP_CONCAT(RMD_ID) INTO @L_RMDID FROM LMC_RENTAL_MACHINERY_DETAILS WHERE TRD_ID=',TRDID,' AND RMD_ID NOT IN(',T_RMD_ID,')'));
		PREPARE SETLMC_RMD_ID_STMT FROM @SETLMC_RMD_ID;
		EXECUTE SETLMC_RMD_ID_STMT;

		SET T_RMD_ID= @L_RMDID;

		IF T_RMD_ID=' ' THEN
			SET T_RMD_ID=NULL;
		END IF;

	IF T_RMD_ID IS NOT NULL THEN
		SET @TICK_T_RMDID=T_RMD_ID;

		MAIN_LOOP : LOOP

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES(',',@TICK_T_RMDID,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_RMDID;
		SELECT @REMAINING_STRING INTO @TICK_T_RMDID;

		SET T_LORRYNO=(SELECT RMD_LORRY_NO FROM LMC_RENTAL_MACHINERY_DETAILS WHERE RMD_ID=LMC_RMDID);
		IF T_LORRYNO IS NULL  THEN
			SET T_LORRYNO='<NULL>';
		END IF;
		SET T_EARTH_STORE=(SELECT RMD_THROWEARTH_STORE FROM LMC_RENTAL_MACHINERY_DETAILS WHERE RMD_ID=LMC_RMDID);
		IF T_EARTH_STORE IS NULL THEN
			SET T_EARTH_STORE='<NULL>';
		END IF;
		SET T_EARTH_OUTSIDE=(SELECT RMD_THROWEARTH_OUTSIDE FROM LMC_RENTAL_MACHINERY_DETAILS WHERE RMD_ID=LMC_RMDID);
		IF T_EARTH_OUTSIDE IS NULL THEN
			SET T_EARTH_OUTSIDE='<NULL>';
		END IF;
		SET T_START_TIME=(SELECT RMD_START_TIME FROM LMC_RENTAL_MACHINERY_DETAILS WHERE RMD_ID=LMC_RMDID);
		IF T_START_TIME IS NULL THEN
			SET T_START_TIME='<NULL>';
		END IF;
		
		SET T_END_TIME=(SELECT RMD_END_TIME FROM LMC_RENTAL_MACHINERY_DETAILS WHERE RMD_ID=LMC_RMDID);
		IF T_END_TIME IS NULL THEN
			SET T_END_TIME='<NULL>';
		END IF;

		SET T_REMARK=(SELECT RMD_REMARK FROM LMC_RENTAL_MACHINERY_DETAILS WHERE RMD_ID=LMC_RMDID);
		IF T_REMARK IS NULL THEN
			SET T_REMARK='<NULL>';
		END IF;
		
		
		SET T_ULDID=(SELECT ULD_ID FROM LMC_RENTAL_MACHINERY_DETAILS WHERE RMD_ID=LMC_RMDID);
		SET T_TIMESTAMP=(SELECT RMD_TIMESTAMP FROM LMC_RENTAL_MACHINERY_DETAILS WHERE RMD_ID=LMC_RMDID);

		SET OLDVALUE=(SELECT CONCAT('RMD_ID=',LMC_RMDID,',TRD_ID=',TRDID,',RMD_LORRY_NO=',T_LORRYNO,',RMD_THROWEARTH_STORE=',T_EARTH_STORE,',RMD_THROWEARTH_OUTSIDE=',T_EARTH_OUTSIDE,
		',RMD_START_TIME=',T_START_TIME,',RMD_END_TIME=',T_END_TIME,',RMD_REMARK=',T_REMARK,',ULD_ID=',T_ULDID,',RMD_TIMESTAMP=',T_TIMESTAMP));

		INSERT INTO LMC_TICKLER_HISTORY(TP_ID,EMP_ID,TTIP_ID,TH_OLD_VALUE,TH_USERSTAMP_ID)VALUES
		((SELECT TP_ID FROM LMC_TICKLER_PROFILE WHERE TP_TYPE='DELETION'),(SELECT EMP_ID FROM LMC_TEAM_REPORT_DETAILS WHERE TRD_ID=TRDID),
		(SELECT TTIP_ID FROM LMC_TICKLER_TABID_PROFILE WHERE TTIP_DATA='LMC_RENTAL_MACHINERY_DETAILS'),OLDVALUE,
		(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
		DELETE FROM LMC_RENTAL_MACHINERY_DETAILS WHERE  RMD_ID=LMC_RMDID;

		IF @TICK_T_RMDID IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;
	END LOOP;
	END IF;
END IF;

	MAIN_LOOP : LOOP
		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@RM_LORRYNO,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO RMLORRYNO;
		SELECT @REMAINING_STRING INTO @RM_LORRYNO;

		IF RMLORRYNO='' THEN
			SET RMLORRYNO=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@RM_THROW_EARTH_STORE,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO RMTHROW_EARTH_STORE;
		SELECT @REMAINING_STRING INTO @RM_THROW_EARTH_STORE;


		IF RMTHROW_EARTH_STORE='' THEN
			SET RMTHROW_EARTH_STORE=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@RM_THROW_EARTH_OUTSIDE,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO RMTHROW_EARTH_OUTSIDE;
		SELECT @REMAINING_STRING INTO @RM_THROW_EARTH_OUTSIDE;

		IF RMTHROW_EARTH_OUTSIDE='' THEN
			SET RMTHROW_EARTH_OUTSIDE=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@RM_STARTTIME,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO RMSTARTTIME;
		SELECT @REMAINING_STRING INTO @RM_STARTTIME;

		IF RMSTARTTIME='' THEN
			SET RMSTARTTIME=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@RM_ENDTIME,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO RMENDTIME;
		SELECT @REMAINING_STRING INTO @RM_ENDTIME;

		IF RMENDTIME='' THEN
			SET RMENDTIME=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@RM_REMARK,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO RMREMARK;
		SELECT @REMAINING_STRING INTO @RM_REMARK;

		IF RMREMARK='' THEN
			SET RMREMARK=NULL;
		END IF;

		IF SEARCH_OPTION=2 THEN
			CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES(',',@LMCRMDID,@VALUE,@REMAINING_STRING);
			SELECT @VALUE INTO LMC_RMDID;
			SELECT @REMAINING_STRING INTO @LMCRMDID;
		END IF;

		IF LMC_RMDID=' ' THEN
			SET LMC_RMDID=NULL;
		END IF; 

	IF SEARCH_OPTION=1 THEN
		IF RMLORRYNO IS NOT NULL AND RMTHROW_EARTH_STORE IS NOT NULL AND RMTHROW_EARTH_OUTSIDE IS NOT NULL AND RMSTARTTIME IS NOT NULL AND RMENDTIME IS NOT NULL THEN
			INSERT INTO LMC_RENTAL_MACHINERY_DETAILS(TRD_ID,RMD_LORRY_NO,RMD_THROWEARTH_STORE,RMD_THROWEARTH_OUTSIDE,RMD_START_TIME,RMD_END_TIME,RMD_REMARK,ULD_ID)VALUES 
			(TRDID,RMLORRYNO,RMTHROW_EARTH_STORE,RMTHROW_EARTH_OUTSIDE,RMSTARTTIME,RMENDTIME,RMREMARK,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
		END IF;
	END IF;

	IF SEARCH_OPTION=2 THEN
		IF LMC_RMDID IS NULL AND RMLORRYNO IS NOT NULL AND RMTHROW_EARTH_STORE IS NOT NULL AND RMTHROW_EARTH_OUTSIDE IS NOT NULL AND RMSTARTTIME IS NOT NULL AND RMENDTIME IS NOT NULL THEN
			INSERT INTO LMC_RENTAL_MACHINERY_DETAILS(TRD_ID,RMD_LORRY_NO,RMD_THROWEARTH_STORE,RMD_THROWEARTH_OUTSIDE,RMD_START_TIME,RMD_END_TIME,RMD_REMARK,ULD_ID)VALUES 
			(TRDID,RMLORRYNO,RMTHROW_EARTH_STORE,RMTHROW_EARTH_OUTSIDE,RMSTARTTIME,RMENDTIME,RMREMARK,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
		END IF;
		IF LMC_RMDID IS NOT NULL AND RMLORRYNO IS NOT NULL AND RMTHROW_EARTH_STORE IS NOT NULL AND RMTHROW_EARTH_OUTSIDE IS NOT NULL AND RMSTARTTIME IS NOT NULL AND RMENDTIME IS NOT NULL THEN
			UPDATE LMC_RENTAL_MACHINERY_DETAILS SET TRD_ID=TRDID,RMD_LORRY_NO=RMLORRYNO,RMD_THROWEARTH_STORE=RMTHROW_EARTH_STORE,RMD_THROWEARTH_OUTSIDE=RMTHROW_EARTH_OUTSIDE,RMD_START_TIME=RMSTARTTIME,RMD_END_TIME=RMENDTIME,RMD_REMARK=RMREMARK,ULD_ID=(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP) WHERE RMD_ID=LMC_RMDID;
		END IF;
	END IF;
		IF @RM_LORRYNO IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;

	END LOOP;
	SET SUCCESS_MESSAGE=1;

END//
DELIMITER ;


-- Dumping structure for procedure SP_LMC_REPORT_ENTRY_UPDATE_DELETE
DROP PROCEDURE IF EXISTS `SP_LMC_REPORT_ENTRY_UPDATE_DELETE`;
DELIMITER //
CREATE  PROCEDURE `SP_LMC_REPORT_ENTRY_UPDATE_DELETE`(
IN SEARCH_OPTION INTEGER,
IN TEAMNAME VARCHAR(25),
IN EMPID INTEGER,
IN REPORTDATE DATE,
IN LOCATION TEXT,
IN CONTRACTNO INTEGER,
IN REACH_SITE TIME,
IN LEAVE_SITE TIME,
IN TYPE_OF_JOB VARCHAR(50),
IN WEATHER_REASON VARCHAR(30),
IN WEATHER_FROM_TIME TIME,
IN WEATHER_TO_TIME TIME,
IN PIPE_TESTING VARCHAR(50),
IN START_PRESSURE INTEGER,
IN END_PRESSURE INTEGER,
IN TEAM_REMARK TEXT,
IN DOCFILENAME TEXT,
IN IMGFILENAME TEXT,
IN PIPE_LAID TEXT,
IN TJSIZE TEXT,
IN TJLENGTH TEXT,
IN EMP_START_TIME TEXT,
IN EMP_END_TIME TEXT,
IN EMP_OT TEXT,
IN EMP_REMARK TEXT,
IN SVDID TEXT,
IN SITE_VISIT_NAME TEXT,
IN SITE_VISIT_DESIG TEXT,
IN SITE_START_TIME TEXT,
IN SITE_END_TIME TEXT,
IN SITE_REMARK TEXT,
IN METID TEXT,
IN METFROMLORRYNO TEXT,
IN METTOLORRYNO TEXT,
IN METITEM TEXT,
IN METREMARK TEXT,
IN MACID TEXT,
IN MACHINERY_TYPE TEXT,
IN MACSTARTTIME TEXT,
IN MACENDTIME TEXT,
IN MACREMARK TEXT,
IN FUDID TEXT,
IN FUDITEMS TEXT,
IN FUDSIZE TEXT,
IN FUDQUANTITY TEXT,
IN FUDREMARK TEXT,
IN MUDID TEXT,
IN MUDITEMS TEXT,
IN MUDRECEIPTNO TEXT,
IN MUDQUANTITY TEXT,
IN RMDID TEXT,
IN RMDLORRYNO TEXT,
IN RMD_EARTHSTORE TEXT,
IN RMD_EARTHOUTSIDE TEXT,
IN RMDSTARTTIME TEXT,
IN RMDENDTIME TEXT,
IN RMDREMARK TEXT,
IN EUDID TEXT,
IN EUDEQUIPMENT TEXT,
IN EUDLORRYNO TEXT,
IN EUDSTARTTIME TEXT,
IN EUDENDTIME TEXT,
IN EUDREMARK TEXT,
IN USERSTAMP VARCHAR(50),
OUT SUCCESS_MESSAGE TEXT
)
BEGIN
DECLARE TRDID INTEGER;
DECLARE ERROR_MSG TEXT;
DECLARE REPORTCOUNT INTEGER;
DECLARE OLDDATE DATE;
DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
 ROLLBACK;
 IF SUCCESS_MESSAGE=' ' THEN
 SET SUCCESS_MESSAGE=0;
 END IF;
END;
START TRANSACTION;
SET AUTOCOMMIT=0;
SET SUCCESS_MESSAGE=' ';

IF SEARCH_OPTION=1 THEN
	SET REPORTCOUNT=(SELECT COUNT(*) FROM LMC_TEAM_REPORT_DETAILS WHERE TRD_DATE=REPORTDATE AND TC_ID=(SELECT TC_ID FROM LMC_TEAM_CREATION WHERE TEAM_NAME=TEAMNAME) AND EMP_ID=EMPID);

	IF REPORTCOUNT>0 THEN
		SET @CHECKFLAG=1;
			SET ERROR_MSG=(SELECT EMC_DATA FROM LMC_ERROR_MESSAGE_CONFIGURATION WHERE EMC_ID = 6);
		    SET ERROR_MSG=(SELECT REPLACE(ERROR_MSG,'[DATE]',REPORTDATE));
			SET SUCCESS_MESSAGE=(SELECT CONCAT(SUCCESS_MESSAGE,ERROR_MSG));
	END IF;
END IF;

IF SUCCESS_MESSAGE=' ' THEN
-- LMC_TEAM_REPORT_DETAILS
	IF EMPID IS NOT NULL AND TEAMNAME IS NOT NULL AND REPORTDATE IS NOT NULL AND LOCATION IS NOT NULL AND CONTRACTNO IS NOT NULL AND REACH_SITE IS NOT NULL AND LEAVE_SITE IS NOT NULL AND
		TYPE_OF_JOB IS NOT NULL AND PIPE_TESTING IS NOT NULL AND START_PRESSURE IS NOT NULL AND END_PRESSURE IS NOT NULL AND IMGFILENAME IS NOT NULL THEN
		IF SEARCH_OPTION=1 THEN
			INSERT INTO LMC_TEAM_REPORT_DETAILS(EMP_ID,TRD_DATE,TRD_LOCATION,TRD_CONTRACT_NO,TC_ID,TRD_REACH_SITE,TRD_LEAVE_SITE,TOJ_ID,TRD_WEATHER_REASON,TRD_WEATHER_FROM_TIME,TRD_WEATHER_TO_TIME,
			TRD_PIPE_TESTING,TRD_START_PRESSURE,TRD_END_PRESSURE,TRD_REMARK,TRD_DOC_FILE_NAME,TRD_IMG_FILE_NAME,ULD_ID)VALUES
			(EMPID,REPORTDATE,LOCATION,CONTRACTNO,(SELECT TC_ID FROM LMC_TEAM_CREATION WHERE TEAM_NAME=TEAMNAME),REACH_SITE,LEAVE_SITE,TYPE_OF_JOB,WEATHER_REASON,
			WEATHER_FROM_TIME,WEATHER_TO_TIME,PIPE_TESTING,START_PRESSURE,END_PRESSURE,TEAM_REMARK,DOCFILENAME,IMGFILENAME,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP)	);
			SET TRDID=(SELECT TRD_ID FROM LMC_TEAM_REPORT_DETAILS ORDER BY TRD_ID DESC LIMIT 1);

		END IF;
		IF SEARCH_OPTION=2 THEN
			UPDATE LMC_TEAM_REPORT_DETAILS SET EMP_ID=EMPID,TRD_DATE=REPORTDATE,TRD_LOCATION=LOCATION,TRD_CONTRACT_NO=CONTRACTNO,TC_ID=(SELECT TC_ID FROM LMC_TEAM_CREATION WHERE TEAM_NAME=TEAMNAME),
			TRD_REACH_SITE=REACH_SITE,TRD_LEAVE_SITE=LEAVE_SITE,TOJ_ID=TYPE_OF_JOB,TRD_WEATHER_REASON=WEATHER_REASON,TRD_WEATHER_FROM_TIME= WEATHER_FROM_TIME
			,TRD_WEATHER_TO_TIME=WEATHER_TO_TIME,TRD_PIPE_TESTING=PIPE_TESTING,TRD_START_PRESSURE=START_PRESSURE,TRD_END_PRESSURE=END_PRESSURE,TRD_REMARK=TEAM_REMARK,TRD_DOC_FILE_NAME=DOCFILENAME,
			TRD_IMG_FILE_NAME=IMGFILENAME,ULD_ID=(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP) WHERE EMP_ID=EMPID AND TRD_DATE=REPORTDATE;
		END IF;
		SET TRDID=(SELECT TRD_ID FROM LMC_TEAM_REPORT_DETAILS WHERE EMP_ID=EMPID AND TRD_DATE=REPORTDATE);
	END IF;


	-- LMC_TEAM_JOB
	IF PIPE_LAID=' ' THEN
		SET PIPE_LAID=NULL;
	END IF;
	IF TJSIZE='' THEN
		SET TJSIZE=NULL;
	END IF;
	IF TJLENGTH='' THEN
		SET TJLENGTH=NULL;
	END IF;
	IF PIPE_LAID IS NOT NULL AND TJSIZE IS NOT NULL AND TJLENGTH IS NOT NULL THEN

		CALL SP_LMC_TEAM_JOB(SEARCH_OPTION,TRDID,PIPE_LAID,TJSIZE,TJLENGTH,USERSTAMP,@SUCCESS_MESSAGE);
	END IF;

	IF EMPID='' THEN
		SET EMPID=NULL;
	END IF;
	IF EMP_START_TIME='' THEN
		SET EMP_START_TIME=NULL;
	END IF;
	IF EMP_END_TIME='' THEN
		SET EMP_END_TIME=NULL;
	END IF;

-- LMC_TEAM_EMPLOYEE_REPORT_DETAILS
		IF EMPID IS NOT NULL AND EMP_START_TIME IS NOT NULL AND EMP_END_TIME IS NOT NULL AND USERSTAMP IS NOT NULL THEN
			IF SEARCH_OPTION=1 THEN
				IF NOT EXISTS(SELECT TRD_ID FROM LMC_TEAM_EMPLOYEE_REPORT_DETAILS WHERE TRD_ID=TRDID) THEN
					INSERT INTO LMC_TEAM_EMPLOYEE_REPORT_DETAILS(TRD_ID,EMP_ID,TERD_START_TIME,TERD_END_TIME,TERD_OT,TERD_REMARK,ULD_ID)VALUES 
					(TRDID,EMPID,EMP_START_TIME,EMP_END_TIME,EMP_OT,EMP_REMARK,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
				END IF;
			END IF;
			IF SEARCH_OPTION=2 THEN
				UPDATE LMC_TEAM_EMPLOYEE_REPORT_DETAILS SET TRD_ID=TRDID,EMP_ID=EMPID,TERD_START_TIME=EMP_START_TIME,TERD_END_TIME=EMP_END_TIME,
				TERD_OT=EMP_OT,TERD_REMARK=EMP_REMARK,ULD_ID=(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP) WHERE EMP_ID=EMPID AND TRD_ID=TRDID;
			END IF;
		END IF;


	IF SITE_VISIT_NAME='' THEN
		SET SITE_VISIT_NAME=NULL;
	END IF;
	IF SITE_VISIT_DESIG='' THEN
		SET SITE_VISIT_DESIG=NULL;
	END IF;
	IF SITE_START_TIME='' THEN
		SET SITE_START_TIME=NULL;
	END IF;
	IF SITE_END_TIME='' THEN
		SET SITE_END_TIME=NULL;
	END IF;
	-- LMC_SITE_VISIT_DETAILS
	IF SITE_VISIT_NAME IS NOT NULL AND SITE_VISIT_DESIG IS NOT NULL AND SITE_START_TIME IS NOT NULL AND SITE_END_TIME IS NOT NULL AND USERSTAMP IS NOT NULL THEN
			CALL SP_LMC_SITE_VISIT_DETAILS(SEARCH_OPTION,TRDID,SVDID,SITE_VISIT_NAME,SITE_VISIT_DESIG,SITE_START_TIME,SITE_END_TIME,SITE_REMARK,USERSTAMP,@SUCCESS_MESSAGE);
	END IF;

	IF METFROMLORRYNO='' THEN
		SET METFROMLORRYNO=NULL;
	END IF;
	IF METTOLORRYNO='' THEN
		SET METTOLORRYNO=NULL;
	END IF;
	IF METITEM='' THEN
		SET METITEM=NULL;
	END IF;

	-- LMC_MACHINERY_EQUIPMENT_TRANSFER
		IF METFROMLORRYNO IS NOT NULL AND METTOLORRYNO IS NOT NULL AND METITEM IS NOT NULL AND USERSTAMP IS NOT NULL THEN
			CALL SP_LMC_MACHINERY_EQUIPMENT_TRANSFER(SEARCH_OPTION,METID,TRDID,METFROMLORRYNO,METTOLORRYNO,METITEM,METREMARK,USERSTAMP,@SUCCESS_MESSAGE);
		END IF;

	IF MACHINERY_TYPE='' THEN
		SET MACHINERY_TYPE=NULL;
	END IF;
	IF MACSTARTTIME='' THEN
		SET MACSTARTTIME=NULL;
	END IF;
	IF MACENDTIME=' ' THEN
		SET MACENDTIME=NULL;
	END IF;

	-- LMC_MACHINERY_USAGE_DETAILS
		IF MACHINERY_TYPE IS NOT NULL AND MACSTARTTIME IS NOT NULL AND MACENDTIME IS NOT NULL AND USERSTAMP IS NOT NULL THEN
			CALL SP_LMC_MACHINERY_USAGE_DETAILS(SEARCH_OPTION,MACID,TRDID,MACHINERY_TYPE,MACSTARTTIME,MACENDTIME,MACREMARK,USERSTAMP,@SUCCESS_MESSAGE);
		END IF;


	IF FUDITEMS='' THEN
		SET FUDITEMS=NULL;
	END IF;
	IF FUDSIZE='' THEN
		SET FUDSIZE=NULL;
	END IF;
	IF FUDQUANTITY='' THEN
		SET FUDQUANTITY=NULL;
	END IF;
	-- LMC_FITTING_USAGE_DETAILS
		IF FUDITEMS IS NOT NULL AND FUDSIZE IS NOT NULL AND FUDQUANTITY IS NOT NULL AND USERSTAMP IS NOT NULL THEN
			CALL SP_LMC_FITTING_USAGE_DETAILS(SEARCH_OPTION,FUDID,TRDID,FUDITEMS,FUDSIZE,FUDQUANTITY,FUDREMARK,USERSTAMP,@SUCCESS_MESSAGE);
		END IF;

	IF MUDITEMS='' THEN
		SET MUDITEMS=NULL;
	END IF;
	IF MUDRECEIPTNO='' THEN
		SET MUDRECEIPTNO=NULL;
	END IF;
	IF MUDQUANTITY='' THEN
		SET MUDQUANTITY=NULL;
	END IF;
	-- LMC_MATERIAL_USAGE_DETAILS
	IF MUDITEMS IS NOT NULL AND MUDRECEIPTNO IS NOT NULL AND MUDQUANTITY IS NOT NULL AND USERSTAMP IS NOT NULL THEN
			CALL SP_LMC_MATERAIL_USAGE_DETAILS(SEARCH_OPTION,MUDID,TRDID,MUDITEMS,MUDRECEIPTNO,MUDQUANTITY,USERSTAMP,@SUCCESS_MESSAGE);
	END IF;


	IF RMDLORRYNO=' ' THEN
		SET RMDLORRYNO=NULL;
	END IF;
	IF RMD_EARTHSTORE='' THEN
		SET RMD_EARTHSTORE=NULL;
	END IF;
	IF RMD_EARTHOUTSIDE='' THEN
		SET RMD_EARTHOUTSIDE=NULL;
	END IF;
	IF RMDSTARTTIME='' THEN
		SET RMDSTARTTIME=NULL;
	END IF;
	IF RMDENDTIME='' THEN
		SET RMDENDTIME=NULL;
	END IF;
	-- LMC_RENTAL_MACHINERY_DETAILS
		IF RMDLORRYNO IS NOT NULL AND RMD_EARTHSTORE IS NOT NULL AND RMD_EARTHOUTSIDE IS NOT NULL AND RMDSTARTTIME IS NOT NULL AND RMDENDTIME IS NOT NULL AND USERSTAMP IS NOT NULL THEN
			CALL SP_LMC_RENTAL_MACHINERY_DETAILS(SEARCH_OPTION,RMDID,TRDID,RMDLORRYNO,RMD_EARTHSTORE,RMD_EARTHOUTSIDE,RMDSTARTTIME,RMDENDTIME,RMDREMARK,USERSTAMP,@SUCCESS_MESSAGE);
		END IF;

	IF EUDEQUIPMENT='' THEN
		SET EUDEQUIPMENT=NULL;
	END IF;
	IF EUDLORRYNO=' ' THEN
		SET EUDLORRYNO=NULL;
	END IF;
	IF EUDSTARTTIME=' ' THEN
		SET EUDSTARTTIME=NULL;
	END IF;
	IF EUDENDTIME=' ' THEN
		SET EUDENDTIME=NULL;
	END IF;
	-- LMC_EQUIPMENT_USAGE_DETAILS
		IF EUDEQUIPMENT IS NOT NULL AND EUDLORRYNO IS NOT NULL AND EUDSTARTTIME IS NOT NULL AND EUDENDTIME IS NOT NULL AND USERSTAMP IS NOT NULL THEN
			CALL SP_LMC_EQUIPMENT_USAGE_DETAILS(SEARCH_OPTION,EUDID,TRDID,EUDEQUIPMENT,EUDLORRYNO,EUDSTARTTIME,EUDENDTIME,EUDREMARK,USERSTAMP,@SUCCESS_MESSAGE);
		END IF;
	
	SET SUCCESS_MESSAGE=1;
END IF;

COMMIT;

END//
DELIMITER ;


-- Dumping structure for procedure SP_LMC_REPORT_TABLE_CREATION
DROP PROCEDURE IF EXISTS `SP_LMC_REPORT_TABLE_CREATION`;
DELIMITER //
CREATE  PROCEDURE `SP_LMC_REPORT_TABLE_CREATION`(
OUT SUCCESS_MESSAGE TEXT)
BEGIN

	
-- QUERY FOR ROLLBACK COMMAND
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN 
		ROLLBACK;
		SET SUCCESS_MESSAGE =0;
	END;

	START TRANSACTION;
		SET FOREIGN_KEY_CHECKS=0;
		DROP TABLE IF EXISTS LMC_TYPE_OF_JOB;
		CREATE TABLE LMC_TYPE_OF_JOB(
		TOJ_ID INTEGER NOT NULL AUTO_INCREMENT,
		TOJ_JOB VARCHAR(50) NOT NULL,
		ULD_ID INTEGER NOT NULL,
		TOJ_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(TOJ_ID),
		FOREIGN KEY(ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));
		SET @ALTER_LMC_TYPE_OF_JOB = (SELECT CONCAT('ALTER TABLE LMC_TYPE_OF_JOB AUTO_INCREMENT = 0'));
		PREPARE ALTER_LMC_TYPE_OF_JOB_STMT FROM @ALTER_LMC_TYPE_OF_JOB;
		EXECUTE ALTER_LMC_TYPE_OF_JOB_STMT;

		DROP TABLE IF EXISTS LMC_TEAM_REPORT_DETAILS;
		CREATE TABLE LMC_TEAM_REPORT_DETAILS(
		TRD_ID INTEGER NOT NULL AUTO_INCREMENT,
		EMP_ID INTEGER NOT NULL,
		TRD_DATE DATE NOT NULL,
		TRD_LOCATION TEXT NOT NULL,
		TRD_CONTRACT_NO INTEGER NOT NULL,
		TC_ID INTEGER NOT NULL,
		TRD_REACH_SITE TIME NOT NULL,
		TRD_LEAVE_SITE TIME NOT NULL,
		TOJ_ID VARCHAR(12),
		TRD_WEATHER_REASON VARCHAR(30),
		TRD_WEATHER_FROM_TIME TIME,
		TRD_WEATHER_TO_TIME TIME,
		TRD_PIPE_TESTING VARCHAR(50) NOT NULL,
		TRD_START_PRESSURE TEXT NOT NULL,
		TRD_END_PRESSURE TEXT NOT NULL,
		TRD_REMARK TEXT,
		TRD_DOC_FILE_NAME TEXT,
		TRD_IMG_FILE_NAME TEXT NOT NULL,
		ULD_ID INTEGER NOT NULL,
		TRD_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(TRD_ID),
		FOREIGN KEY(TC_ID) REFERENCES LMC_TEAM_CREATION (TC_ID),
		FOREIGN KEY(ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID),
		FOREIGN KEY(EMP_ID) REFERENCES LMC_EMPLOYEE_DETAILS (EMP_ID));
		SET @ALTER_LMC_TEAM_REPORT_DETAILS = (SELECT CONCAT('ALTER TABLE LMC_TEAM_REPORT_DETAILS AUTO_INCREMENT = 0'));
		PREPARE ALTER_LMC_TEAM_REPORT_DETAILS_STMT FROM @ALTER_LMC_TEAM_REPORT_DETAILS;
		EXECUTE ALTER_LMC_TEAM_REPORT_DETAILS_STMT;


		DROP TABLE IF EXISTS LMC_TEAM_JOB;
		CREATE TABLE LMC_TEAM_JOB(
		TJ_ID INTEGER NOT NULL AUTO_INCREMENT,
		TRD_ID INTEGER NOT NULL,
		TJ_PIPE_LAID VARCHAR(20) NOT NULL,
		TJ_SIZE INTEGER NOT NULL,
		TJ_LENGTH INTEGER NOT NULL,
		ULD_ID INTEGER NOT NULL,
		TJ_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(TJ_ID),
		FOREIGN KEY(TRD_ID) REFERENCES LMC_TEAM_REPORT_DETAILS (TRD_ID),
		FOREIGN KEY(ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));
		SET @ALTER_LMC_TEAM_JOB = (SELECT CONCAT('ALTER TABLE LMC_TEAM_JOB AUTO_INCREMENT = 0'));
		PREPARE ALTER_LMC_TEAM_JOB_STMT FROM @ALTER_LMC_TEAM_JOB;
		EXECUTE ALTER_LMC_TEAM_JOB_STMT;

		DROP TABLE IF EXISTS LMC_TEAM_EMPLOYEE_REPORT_DETAILS;
		CREATE TABLE LMC_TEAM_EMPLOYEE_REPORT_DETAILS(
		TERD_ID INTEGER NOT NULL AUTO_INCREMENT,
		TRD_ID INTEGER NOT NULL,
		EMP_ID INTEGER NOT NULL,
		TERD_START_TIME TIME NOT NULL,
		TERD_END_TIME TIME NOT NULL,
		TERD_OT DECIMAL(3,1),
		TERD_REMARK TEXT,
		ULD_ID INTEGER NOT NULL,
		TERD_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(TERD_ID),
		FOREIGN KEY(TRD_ID) REFERENCES LMC_TEAM_REPORT_DETAILS (TRD_ID),
		FOREIGN KEY(EMP_ID) REFERENCES LMC_EMPLOYEE_DETAILS (EMP_ID),
		FOREIGN KEY(ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));
		SET @ALTER_LMC_TEAM_EMPLOYEE_REPORT_DETAILS = (SELECT CONCAT('ALTER TABLE LMC_TEAM_EMPLOYEE_REPORT_DETAILS AUTO_INCREMENT = 0'));
		PREPARE ALTER_LMC_TEAM_EMPLOYEE_REPORT_DETAILS_STMT FROM @ALTER_LMC_TEAM_EMPLOYEE_REPORT_DETAILS;
		EXECUTE ALTER_LMC_TEAM_EMPLOYEE_REPORT_DETAILS_STMT;

		DROP TABLE IF EXISTS LMC_SITE_VISIT_DETAILS;
		CREATE TABLE LMC_SITE_VISIT_DETAILS(
		SVD_ID INTEGER NOT NULL AUTO_INCREMENT,
		TRD_ID INTEGER NOT NULL,
		SVD_NAME CHAR(50) NOT NULL,
		SVD_DESIGNATION VARCHAR(50) NOT NULL,
		SVD_START_TIME TIME NOT NULL,
		SVD_END_TIME TIME NOT NULL,
		SVD_REMARK TEXT,
		ULD_ID INTEGER NOT NULL,
		SVD_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(SVD_ID),
		FOREIGN KEY(TRD_ID) REFERENCES LMC_TEAM_REPORT_DETAILS(TRD_ID),
		FOREIGN KEY(ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));
		SET @ALTER_LMC_SITE_VISIT_DETAILS = (SELECT CONCAT('ALTER TABLE LMC_SITE_VISIT_DETAILS AUTO_INCREMENT = 0'));
		PREPARE ALTER_LMC_SITE_VISIT_DETAILS_STMT FROM @ALTER_LMC_SITE_VISIT_DETAILS;
		EXECUTE ALTER_LMC_SITE_VISIT_DETAILS_STMT;


		DROP TABLE IF EXISTS LMC_MACHINERY_EQUIPMENT_TRANSFER;
		CREATE TABLE LMC_MACHINERY_EQUIPMENT_TRANSFER(
		MET_ID INTEGER NOT NULL AUTO_INCREMENT,
		TRD_ID INTEGER NOT NULL,
		MET_FROM_LORRY_NO VARCHAR(20) NOT NULL,
		MET_TO_LORRY_NO VARCHAR(20) NOT NULL,
		MET_ITEM VARCHAR(30) NOT NULL,
		MET_REMARK TEXT,
		ULD_ID INTEGER NOT NULL,
		MET_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(MET_ID),
		FOREIGN KEY(TRD_ID) REFERENCES LMC_TEAM_REPORT_DETAILS(TRD_ID),
		FOREIGN KEY(ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));
		SET @ALTER_LMC_MACHINERY_EQUIPMENT_TRANSFER = (SELECT CONCAT('ALTER TABLE LMC_MACHINERY_EQUIPMENT_TRANSFER AUTO_INCREMENT = 0'));
		PREPARE ALTER_LMC_MACHINERY_EQUIPMENT_TRANSFER_STMT FROM @ALTER_LMC_MACHINERY_EQUIPMENT_TRANSFER;
		EXECUTE ALTER_LMC_MACHINERY_EQUIPMENT_TRANSFER_STMT;

		DROP TABLE IF EXISTS LMC_MACHINERY_USAGE;
		CREATE TABLE LMC_MACHINERY_USAGE(
		MCU_ID INTEGER NOT NULL AUTO_INCREMENT,
		MCU_MACHINERY_TYPE VARCHAR(30) NOT NULL,
		PRIMARY KEY(MCU_ID));
		SET @ALTER_LMC_MACHINERY_USAGE = (SELECT CONCAT('ALTER TABLE LMC_MACHINERY_USAGE AUTO_INCREMENT = 0'));
		PREPARE ALTER_LMC_MACHINERY_USAGE_STMT FROM @ALTER_LMC_MACHINERY_USAGE;
		EXECUTE ALTER_LMC_MACHINERY_USAGE_STMT;


		DROP TABLE IF EXISTS LMC_FITTING_USAGE;
		CREATE TABLE LMC_FITTING_USAGE(
		FU_ID INTEGER NOT NULL AUTO_INCREMENT,
		FU_ITEMS VARCHAR(50) NOT NULL,
		PRIMARY KEY(FU_ID));
		SET @ALTER_LMC_FITTING_USAGE = (SELECT CONCAT('ALTER TABLE LMC_FITTING_USAGE AUTO_INCREMENT = 0'));
		PREPARE ALTER_LMC_FITTING_USAGE_STMT FROM @ALTER_LMC_FITTING_USAGE;
		EXECUTE ALTER_LMC_FITTING_USAGE_STMT;


		DROP TABLE IF EXISTS LMC_MATERIAL_USAGE;
		CREATE TABLE LMC_MATERIAL_USAGE(
		MU_ID INTEGER NOT NULL AUTO_INCREMENT, 
		MU_ITEMS VARCHAR(50) NOT NULL,
		PRIMARY KEY(MU_ID));
		SET @ALTER_LMC_MATERIAL_USAGE = (SELECT CONCAT('ALTER TABLE LMC_MATERIAL_USAGE AUTO_INCREMENT = 0'));
		PREPARE ALTER_LMC_MATERIAL_USAGE_STMT FROM @ALTER_LMC_MATERIAL_USAGE;
		EXECUTE ALTER_LMC_MATERIAL_USAGE_STMT;

		DROP TABLE IF EXISTS LMC_MACHINERY_USAGE_DETAILS;
		CREATE TABLE LMC_MACHINERY_USAGE_DETAILS(
		MAC_ID INTEGER NOT NULL AUTO_INCREMENT,
		TRD_ID INTEGER NOT NULL,
		MCU_ID INTEGER NOT NULL,
		MAC_START_TIME TIME NOT NULL,
		MAC_END_TIME TIME NOT NULL,
		MAC_REMARK TEXT NULL,	
		ULD_ID INTEGER NOT NULL,
		MAC_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(MAC_ID),
		FOREIGN KEY (MCU_ID) REFERENCES LMC_MACHINERY_USAGE(MCU_ID),
		FOREIGN KEY(TRD_ID) REFERENCES LMC_TEAM_REPORT_DETAILS(TRD_ID),
		FOREIGN KEY (ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));
		SET @ALTER_LMC_MACHINERY_USAGE_DETAILS = (SELECT CONCAT('ALTER TABLE LMC_MACHINERY_USAGE_DETAILS AUTO_INCREMENT = 0'));
		PREPARE ALTER_LMC_MACHINERY_USAGE_DETAILS_STMT FROM @ALTER_LMC_MACHINERY_USAGE_DETAILS;
		EXECUTE ALTER_LMC_MACHINERY_USAGE_DETAILS_STMT;

		DROP TABLE IF EXISTS LMC_FITTING_USAGE_DETAILS;
		CREATE TABLE LMC_FITTING_USAGE_DETAILS(
		FUD_ID INTEGER NOT NULL AUTO_INCREMENT,
		FU_ID INTEGER NOT NULL,
		TRD_ID INTEGER NOT NULL,
		FUD_SIZE VARCHAR(15) ,
		FUD_QUANTITY VARCHAR(15) ,
		FUD_REMARK TEXT NULL,	
		ULD_ID INTEGER NOT NULL,
		FUD_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(FUD_ID),
		FOREIGN KEY (FU_ID) REFERENCES LMC_FITTING_USAGE(FU_ID),
		FOREIGN KEY(TRD_ID) REFERENCES LMC_TEAM_REPORT_DETAILS(TRD_ID),
		FOREIGN KEY (ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));
		SET @ALTER_LMC_FITTING_USAGE_DETAILS = (SELECT CONCAT('ALTER TABLE LMC_FITTING_USAGE_DETAILS AUTO_INCREMENT = 0'));
		PREPARE ALTER_LMC_FITTING_USAGE_DETAILS_STMT FROM @ALTER_LMC_FITTING_USAGE_DETAILS;
		EXECUTE ALTER_LMC_FITTING_USAGE_DETAILS_STMT;

		DROP TABLE IF EXISTS LMC_MATERIAL_USAGE_DETAILS;
		CREATE TABLE LMC_MATERIAL_USAGE_DETAILS(
		MUD_ID INTEGER NOT NULL AUTO_INCREMENT,
		MU_ID INTEGER NOT NULL,
		TRD_ID INTEGER NOT NULL,
		MUD_RECEIPT_NO	VARCHAR(25) NOT NULL,
		MUD_QUANTITY INTEGER NOT NULL,
		ULD_ID INTEGER NOT NULL,
		MUD_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(MUD_ID),
		FOREIGN KEY (MU_ID) REFERENCES LMC_MATERIAL_USAGE (MU_ID),
		FOREIGN KEY(TRD_ID) REFERENCES LMC_TEAM_REPORT_DETAILS(TRD_ID),
		FOREIGN KEY (ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));
		SET @ALTER_LMC_MATERIAL_USAGE_DETAILS = (SELECT CONCAT('ALTER TABLE LMC_MATERIAL_USAGE_DETAILS AUTO_INCREMENT = 0'));
		PREPARE ALTER_LMC_MATERIAL_USAGE_DETAILS_STMT FROM @ALTER_LMC_MATERIAL_USAGE_DETAILS;
		EXECUTE ALTER_LMC_MATERIAL_USAGE_DETAILS_STMT;

		DROP TABLE IF EXISTS LMC_RENTAL_MACHINERY_DETAILS;
		CREATE TABLE LMC_RENTAL_MACHINERY_DETAILS(
		RMD_ID INTEGER NOT NULL AUTO_INCREMENT,
		TRD_ID INTEGER NOT NULL,
		RMD_LORRY_NO VARCHAR(20) NOT NULL,
		RMD_THROWEARTH_STORE INTEGER NOT NULL,
		RMD_THROWEARTH_OUTSIDE INTEGER	 NOT NULL,
		RMD_START_TIME TIME NOT NULL,
		RMD_END_TIME TIME NOT NULL,
		RMD_REMARK TEXT NULL,		
		ULD_ID INTEGER NOT NULL,
		RMD_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(RMD_ID),
		FOREIGN KEY(TRD_ID) REFERENCES LMC_TEAM_REPORT_DETAILS(TRD_ID),
		FOREIGN KEY (ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));
		SET @ALTER_LMC_RENTAL_MACHINERY_DETAILS = (SELECT CONCAT('ALTER TABLE LMC_RENTAL_MACHINERY_DETAILS AUTO_INCREMENT = 0'));
		PREPARE ALTER_LMC_RENTAL_MACHINERY_DETAILS_STMT FROM @ALTER_LMC_RENTAL_MACHINERY_DETAILS;
		EXECUTE ALTER_LMC_RENTAL_MACHINERY_DETAILS_STMT;

		DROP TABLE IF EXISTS LMC_EQUIPMENT_USAGE_DETAILS;
		CREATE TABLE LMC_EQUIPMENT_USAGE_DETAILS(
		EUD_ID INTEGER NOT NULL AUTO_INCREMENT,
		TRD_ID INTEGER NOT NULL,
		EUD_EQUIPMENT VARCHAR(30) NOT NULL,		
		EUD_LORRY_NO VARCHAR(30)  NOT NULL,
		EUD_START_TIME TIME  NOT NULL,	
		EUD_END_TIME TIME NOT NULL,	
		EUD_REMARK TEXT	 NULL,
		ULD_ID INTEGER NOT NULL,
		EUD_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(EUD_ID),
		FOREIGN KEY(TRD_ID) REFERENCES LMC_TEAM_REPORT_DETAILS(TRD_ID),
		FOREIGN KEY (ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));
		SET @ALTER_LMC_EQUIPMENT_USAGE_DETAILS = (SELECT CONCAT('ALTER TABLE LMC_EQUIPMENT_USAGE_DETAILS AUTO_INCREMENT = 0'));
		PREPARE ALTER_LMC_EQUIPMENT_USAGE_DETAILS_STMT FROM @ALTER_LMC_EQUIPMENT_USAGE_DETAILS;
		EXECUTE ALTER_LMC_EQUIPMENT_USAGE_DETAILS_STMT;


		DROP TABLE IF EXISTS LMC_ACCIDENT_REPORT_DETAILS;
		CREATE TABLE LMC_ACCIDENT_REPORT_DETAILS(
		ARD_ID INTEGER NOT NULL AUTO_INCREMENT,
		ARD_DATE DATE NOT NULL,
		ARD_PLACE VARCHAR(50) NOT NULL,
		ARD_TYPE_OF_INJURY VARCHAR(50) NOT NULL,
		ARD_NATURE_OF_INJURY VARCHAR(50) NOT NULL,
		ARD_TIME TIME NOT NULL,
		ARD_LOCATION VARCHAR(50) NOT NULL,
		ARD_INJURED_PART VARCHAR(50) NOT NULL,
		ARD_MACHINERY_TYPE VARCHAR(50),
		ARD_LM_NO VARCHAR(25),
		ARD_OPERATOR_NAME CHAR(30),
		ARD_NAME CHAR(30) NOT NULL,
		ARD_AGE INTEGER NOT NULL,
		ARD_ADDRESS TEXT NOT NULL,
		ARD_NRIC_NO VARCHAR(10) NOT NULL,
		ARD_FIN_NO VARCHAR(10) NOT NULL,
		ARD_WORK_PERMIT_NO INTEGER NOT NULL,
		ARD_PASSPORT_NO VARCHAR(15) NOT NULL,
		ARD_NATIONALITY VARCHAR(30) NOT NULL,
		ARD_SEX VARCHAR(6) NOT NULL,
		ARD_DOB DATE NOT NULL,
		ARD_MARTIAL_STATUS VARCHAR(10) NOT NULL,
		ARD_DESIGNATION VARCHAR(25) NOT NULL,
		ARD_LENGTH_OF_SERVICE VARCHAR(50) NOT NULL,
		ARD_WORK_COMMENCEMENT VARCHAR(3) NOT NULL,
		ARD_DESCRIPTION TEXT NOT NULL,
		ULD_ID INTEGER NOT NULL,
		ARD_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(ARD_ID),
		FOREIGN KEY (ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));
		SET @ALTER_LMC_ACCIDENT_REPORT_DETAILS = (SELECT CONCAT('ALTER TABLE LMC_ACCIDENT_REPORT_DETAILS AUTO_INCREMENT = 0'));
		PREPARE ALTER_ALTER_LMC_ACCIDENT_REPORT_DETAILS_STMT FROM @ALTER_LMC_ACCIDENT_REPORT_DETAILS;
		EXECUTE ALTER_ALTER_LMC_ACCIDENT_REPORT_DETAILS_STMT;

		SET SUCCESS_MESSAGE = 1;
		SET FOREIGN_KEY_CHECKS = 1;

	COMMIT;
END//
DELIMITER ;


-- Dumping structure for procedure SP_LMC_SITE_VISIT_DETAILS
DROP PROCEDURE IF EXISTS `SP_LMC_SITE_VISIT_DETAILS`;
DELIMITER //
CREATE  PROCEDURE `SP_LMC_SITE_VISIT_DETAILS`(
SEARCH_OPTION INTEGER,
TRDID INTEGER,
SVDID TEXT,
NAME TEXT,
DESIGNATION TEXT,
STARTTIME TEXT,
ENDTIME TEXT,
REMARK TEXT,
USERSTAMP VARCHAR(50),
OUT SUCCESS_MESSAGE TEXT)
BEGIN
DECLARE SV_NAME CHAR(50);
DECLARE SV_DESIGNATION VARCHAR(50);
DECLARE SV_STIME TIME;
DECLARE SV_ETIME TIME;
DECLARE SV_REMARK TEXT;
DECLARE LMC_SVDID INTEGER;
DECLARE LMSVDID INTEGER;
DECLARE T_SVDID INTEGER;
DECLARE T_TRD_ID INTEGER;
DECLARE T_SVD_NAME CHAR(50);
DECLARE T_SVD_DESIG VARCHAR(50);
DECLARE T_SVD_START_TIME TIME;
DECLARE T_SVD_END_TIME TIME;
DECLARE T_SVD_REMARK TEXT;
DECLARE T_ULD_ID INTEGER;
DECLARE T_SVD_TIMESTAMP TIMESTAMP;
DECLARE OLDVALUE TEXT;
DECLARE TICKSVIDID TEXT;
DECLARE TSVDID TEXT;
SET SUCCESS_MESSAGE=0;
IF SEARCH_OPTION=2 THEN
		SET TSVDID=(SELECT REPLACE(SVDID,' ','0'));
		SET @SETLMC_SVDID=(SELECT CONCAT('SELECT GROUP_CONCAT(SVD_ID) INTO @L_SVID FROM LMC_SITE_VISIT_DETAILS WHERE TRD_ID=',TRDID,' AND SVD_ID NOT IN(',TSVDID,')'));
		PREPARE SETLMC_SVDID_STMT FROM @SETLMC_SVDID;
		EXECUTE SETLMC_SVDID_STMT;

		SET TICKSVIDID=@L_SVID;
		IF TICKSVIDID=' ' THEN
			SET TICKSVIDID=NULL;
		END IF;
	IF TICKSVIDID IS NOT NULL THEN
		SET @TICK_SVDID=TICKSVIDID;

		MAIN_LOOP : LOOP

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES(',', @TICK_SVDID,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMSVDID;
		SELECT @REMAINING_STRING INTO @TICK_SVDID;
		SET T_SVDID=(SELECT SVD_ID FROM LMC_SITE_VISIT_DETAILS WHERE SVD_ID=LMSVDID);
		SET T_TRD_ID=(SELECT TRD_ID FROM LMC_SITE_VISIT_DETAILS WHERE SVD_ID=LMSVDID);
		SET T_SVD_NAME=(SELECT SVD_NAME FROM LMC_SITE_VISIT_DETAILS WHERE SVD_ID=LMSVDID);
		SET T_SVD_DESIG=(SELECT SVD_DESIGNATION FROM LMC_SITE_VISIT_DETAILS WHERE SVD_ID=LMSVDID);
		SET T_SVD_START_TIME=(SELECT SVD_START_TIME FROM LMC_SITE_VISIT_DETAILS WHERE SVD_ID=LMSVDID);
		SET T_SVD_END_TIME=(SELECT SVD_END_TIME FROM LMC_SITE_VISIT_DETAILS WHERE SVD_ID=LMSVDID);
		SET T_SVD_REMARK=(SELECT SVD_REMARK FROM LMC_SITE_VISIT_DETAILS WHERE SVD_ID=LMSVDID);
		SET T_ULD_ID=(SELECT ULD_ID FROM LMC_SITE_VISIT_DETAILS WHERE SVD_ID=LMSVDID);
		SET T_SVD_TIMESTAMP=(SELECT SVD_TIMESTAMP FROM LMC_SITE_VISIT_DETAILS WHERE SVD_ID=LMSVDID);

		IF T_SVD_REMARK IS NULL THEN
			SET T_SVD_REMARK='<NULL>';
		END IF;
		SET OLDVALUE=(SELECT CONCAT('SVD_ID=',T_SVDID,',TRD_ID=',T_TRD_ID,',SVD_NAME=',T_SVD_NAME,',SVD_DESIGNATION=',T_SVD_DESIG,',SVD_START_TIME=',T_SVD_START_TIME,
		'SVD_END_TIME=',T_SVD_END_TIME,',SVD_REMARK=',T_SVD_REMARK,',ULD_ID=',T_ULD_ID,',SVD_TIMESTAMP=',T_SVD_TIMESTAMP));
		DELETE FROM LMC_SITE_VISIT_DETAILS WHERE SVD_ID=LMSVDID;
		INSERT INTO LMC_TICKLER_HISTORY(TP_ID,EMP_ID,TTIP_ID,TH_OLD_VALUE,TH_USERSTAMP_ID)VALUES
		((SELECT TP_ID FROM LMC_TICKLER_PROFILE WHERE TP_TYPE='DELETION'),(SELECT EMP_ID FROM LMC_TEAM_REPORT_DETAILS WHERE TRD_ID=TRDID),
		(SELECT TTIP_ID FROM LMC_TICKLER_TABID_PROFILE WHERE TTIP_DATA='LMC_SITE_VISIT_DETAILS'),OLDVALUE,
		(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
		
		IF @TICK_SVDID IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;
	END LOOP;
	END IF;
END IF;

SET @SVNAME=NAME;
SET @SVDESIGNATION=DESIGNATION;
SET @SVSTIME=STARTTIME;
SET @SVETIME=ENDTIME;
SET @SVREMARK=REMARK;
SET @LMCSVDID=SVDID;
SET @COUNT=1;
MAIN_LOOP : LOOP
		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@SVNAME,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO SV_NAME;
		SELECT @REMAINING_STRING INTO @SVNAME;
		IF SV_NAME=' ' THEN
			SET SV_NAME=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@SVDESIGNATION,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO SV_DESIGNATION;
		SELECT @REMAINING_STRING INTO @SVDESIGNATION;
		IF SV_DESIGNATION=' ' THEN
			SET SV_DESIGNATION=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@SVSTIME,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO SV_STIME;
		SELECT @REMAINING_STRING INTO @SVSTIME;
		IF SV_STIME=' ' THEN
			SET SV_STIME=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@SVETIME,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO SV_ETIME;
		SELECT @REMAINING_STRING INTO @SVETIME;

		IF SV_ETIME=' ' THEN
			SET SV_ETIME=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^', @SVREMARK,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO SV_REMARK;
		SELECT @REMAINING_STRING INTO @SVREMARK;


		IF SV_REMARK=' ' THEN
			SET SV_REMARK=NULL;
		END IF;

		IF SEARCH_OPTION=2 THEN
			CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES(',',@LMCSVDID,@VALUE,@REMAINING_STRING);
			SELECT @VALUE INTO LMC_SVDID;
			SELECT @REMAINING_STRING INTO @LMCSVDID;
		END IF;

		IF LMC_SVDID=' ' THEN
			SET LMC_SVDID=NULL;
		END IF;
		
		IF SEARCH_OPTION=1 THEN
			IF LMC_SVDID IS NULL AND SV_NAME IS NOT NULL AND  SV_DESIGNATION IS NOT NULL AND SV_STIME IS NOT NULL AND SV_ETIME IS NOT NULL THEN

				INSERT INTO LMC_SITE_VISIT_DETAILS(TRD_ID,SVD_NAME,SVD_DESIGNATION,SVD_START_TIME,SVD_END_TIME,SVD_REMARK,ULD_ID)VALUES 
				(TRDID,SV_NAME,SV_DESIGNATION,SV_STIME,SV_ETIME,SV_REMARK,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
		
			END IF;
		END IF;
		IF SEARCH_OPTION=2 THEN
			IF LMC_SVDID IS NOT NULL AND SV_NAME IS NOT NULL AND  SV_DESIGNATION IS NOT NULL AND SV_STIME IS NOT NULL AND SV_ETIME IS NOT NULL THEN
				UPDATE LMC_SITE_VISIT_DETAILS SET TRD_ID=TRDID,SVD_NAME=SV_NAME,SVD_DESIGNATION=SV_DESIGNATION,SVD_START_TIME=SV_STIME,
				SVD_END_TIME=SV_ETIME,SVD_REMARK=SV_REMARK,ULD_ID=(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP) WHERE SVD_ID=LMC_SVDID;
			END IF;
			IF LMC_SVDID IS NULL AND SV_NAME IS NOT NULL AND  SV_DESIGNATION IS NOT NULL AND SV_STIME IS NOT NULL AND SV_ETIME IS NOT NULL THEN
				SET @INSERT_FLAG=1;
				INSERT INTO LMC_SITE_VISIT_DETAILS(TRD_ID,SVD_NAME,SVD_DESIGNATION,SVD_START_TIME,SVD_END_TIME,SVD_REMARK,ULD_ID)VALUES 
				(TRDID,SV_NAME,SV_DESIGNATION,SV_STIME,SV_ETIME,SV_REMARK,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
			END IF;
		END IF;

		IF  @SVNAME IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;
		SET @COUNT=@COUNT+1;

END LOOP;

SET SUCCESS_MESSAGE=1;

END//
DELIMITER ;


-- Dumping structure for procedure SP_LMC_TEAM_EMPLOYEE_REPORT_DETAILS
DROP PROCEDURE IF EXISTS `SP_LMC_TEAM_EMPLOYEE_REPORT_DETAILS`;
DELIMITER //
CREATE  PROCEDURE `SP_LMC_TEAM_EMPLOYEE_REPORT_DETAILS`(
TRDID INTEGER,
EMPID TEXT,
STARTTIME TEXT,
ENDTIME TEXT,
OT TEXT,
REMARK TEXT,
USERSTAMP VARCHAR(50),
OUT SUCCESS_MESSAGE TEXT)
BEGIN
DECLARE LMC_FNAME CHAR(50);
DECLARE LMC_LNAME CHAR(50);
DECLARE LMC_STIME TEXT;
DECLARE LMC_ETIME TEXT;
DECLARE LMC_OT DECIMAL(3,1);
DECLARE LMC_REMARK TEXT;
DECLARE LMC_EMPID INTEGER;


SET @LMCEMPID=EMPID;
SET @LMCSTIME=STARTTIME;
SET @LMCETIME=ENDTIME;
SET @LMCOT=OT;
SET @LMCREMARK=REMARK;

SET SUCCESS_MESSAGE=0;
	MAIN_LOOP : LOOP

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@LMCEMPID,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_EMPID;
		SELECT @REMAINING_STRING INTO @LMCEMPID;

		IF LMC_EMPID='' THEN
			SET LMC_EMPID=NULL;
		END IF;
	
		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@LMCSTIME,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_STIME;
		SELECT @REMAINING_STRING INTO @LMCSTIME;

		IF LMC_STIME='' THEN
			SET LMC_STIME=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',  @LMCETIME,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_ETIME;
		SELECT @REMAINING_STRING INTO @LMCETIME;

		IF LMC_ETIME='' THEN
			SET LMC_ETIME=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',  @LMCOT,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_OT;
		SELECT @REMAINING_STRING INTO  @LMCOT;
		IF LMC_OT='' THEN
			SET LMC_OT=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^', @LMCREMARK,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_REMARK;
		SELECT @REMAINING_STRING INTO @LMCREMARK;
		IF LMC_REMARK='' THEN
			SET LMC_REMARK=NULL;
		END IF;
		
		IF LMC_EMPID IS NOT NULL AND  LMC_STIME IS NOT NULL AND LMC_ETIME IS NOT NULL AND OT IS NOT NULL THEN
		IF NOT EXISTS(SELECT EMP_ID FROM LMC_TEAM_EMPLOYEE_REPORT_DETAILS WHERE TRD_ID=TRDID AND EMP_ID=LMC_EMPID)THEN
			INSERT INTO LMC_TEAM_EMPLOYEE_REPORT_DETAILS(TRD_ID,EMP_ID,TERD_START_TIME,TERD_END_TIME,TERD_OT,TERD_REMARK,ULD_ID)VALUES 
			(TRDID,LMC_EMPID,LMC_STIME,LMC_ETIME,LMC_OT,LMC_REMARK,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
		END IF;
		END IF;

		IF  @LMCEMPID IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;

	END LOOP;
SET SUCCESS_MESSAGE=1;

END//
DELIMITER ;


-- Dumping structure for procedure SP_LMC_TEAM_JOB
DROP PROCEDURE IF EXISTS `SP_LMC_TEAM_JOB`;
DELIMITER //
CREATE  PROCEDURE `SP_LMC_TEAM_JOB`(
SEARCH_OPTION INTEGER,
TRDID INTEGER,
PIPE_LAID TEXT,
SIZE TEXT,
LENGTH TEXT,
USERSTAMP VARCHAR(50),
OUT SUCCESS_MESSAGE TEXT)
BEGIN
DECLARE LMC_PIPE_LAID VARCHAR(20);
DECLARE LMC_SIZE INTEGER;
DECLARE LMC_LENGTH INTEGER;
DECLARE T_TJID TEXT;
DECLARE LMC_TJID INTEGER;
DECLARE T_PIPE_LAID VARCHAR(20);
DECLARE T_SIZE INTEGER;
DECLARE T_LENGTH INTEGER;
DECLARE T_ULDID INTEGER;
DECLARE T_TIMESTAMP TIMESTAMP;
DECLARE OLDVALUE TEXT;
DECLARE D_TJID TEXT;
DECLARE TJID TEXT;

SET @LMCPIPELAID=PIPE_LAID;
SET @PIPE_LAID=PIPE_LAID;
SET @LMCSIZE=SIZE;
SET @LMCLENGTH=LENGTH;
SET SUCCESS_MESSAGE=0;


IF SEARCH_OPTION=2 THEN
	SET D_TJID='';
	MAIN_LOOP : LOOP
		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@LMCPIPELAID,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_PIPE_LAID;
		SELECT @REMAINING_STRING INTO @LMCPIPELAID;
		IF LMC_PIPE_LAID IS NOT NULL THEN
			SET D_TJID=(SELECT CONCAT(D_TJID,(SELECT TJ_ID FROM LMC_TEAM_JOB WHERE TRD_ID=TRDID AND TJ_PIPE_LAID=LMC_PIPE_LAID)));
		END IF;
		IF @LMCPIPELAID IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;
		SET TJID=D_TJID;

	END LOOP;
		SET @CHECKFLAG=5;
		SET TJID=(SELECT TRIM(TJID));
		IF TJID IS NULL THEN
			SET TJID=0;
		END IF;
		SET @SETLMC_TJID=(SELECT CONCAT('SELECT GROUP_CONCAT(TJ_ID) INTO @L_TJID FROM LMC_TEAM_JOB WHERE TRD_ID=',TRDID,' AND TJ_ID NOT IN(',TJID,')'));
		PREPARE SETLMC_TJID_STMT FROM @SETLMC_TJID;
		EXECUTE SETLMC_TJID_STMT;
		SET @CHECKFLAG=6;

		SET T_TJID=@L_TJID;
		IF T_TJID=' ' THEN
			SET T_TJID=NULL;
		END IF;
	IF T_TJID IS NOT NULL THEN
		SET @TICK_T_TJID=T_TJID;
			SET @CHECKFLAG=2;
		MAIN_LOOP : LOOP

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES(',',@TICK_T_TJID,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_TJID;
		SELECT @REMAINING_STRING INTO @TICK_T_TJID;

			SET @CHECKFLAG=4;
		SET T_PIPE_LAID=(SELECT TJ_PIPE_LAID FROM LMC_TEAM_JOB WHERE TJ_ID=LMC_TJID);
		IF T_PIPE_LAID IS NULL  THEN
			SET T_PIPE_LAID='<NULL>';
		END IF;
		SET T_SIZE=(SELECT TJ_SIZE FROM LMC_TEAM_JOB WHERE TJ_ID=LMC_TJID);
		IF T_SIZE IS NULL THEN
			SET T_SIZE='<NULL>';
		END IF;
		SET T_LENGTH=(SELECT TJ_LENGTH FROM LMC_TEAM_JOB WHERE TJ_ID=LMC_TJID);
		IF T_LENGTH IS NULL THEN
			SET T_LENGTH='<NULL>';
		END IF;
		SET T_ULDID=(SELECT ULD_ID FROM LMC_TEAM_JOB WHERE TJ_ID=LMC_TJID);
		SET T_TIMESTAMP=(SELECT TJ_TIMESTAMP FROM LMC_TEAM_JOB WHERE TJ_ID=LMC_TJID);
			SET @CHECKFLAG=3;
		SET OLDVALUE=(SELECT CONCAT('TJ_ID=',LMC_TJID,',TRD_ID=',TRDID,',TJ_PIPE_LAID=',T_PIPE_LAID,',TJ_SIZE=',T_SIZE,',TJ_LENGTH=',T_LENGTH,
		',ULD_ID=',T_ULDID,',TJ_TIMESTAMP=',T_TIMESTAMP));
		INSERT INTO LMC_TICKLER_HISTORY(TP_ID,EMP_ID,TTIP_ID,TH_OLD_VALUE,TH_USERSTAMP_ID)VALUES
		((SELECT TP_ID FROM LMC_TICKLER_PROFILE WHERE TP_TYPE='DELETION'),(SELECT EMP_ID FROM LMC_TEAM_REPORT_DETAILS WHERE TRD_ID=TRDID),
		(SELECT TTIP_ID FROM LMC_TICKLER_TABID_PROFILE WHERE TTIP_DATA='LMC_TEAM_JOB'),OLDVALUE,
		(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
		DELETE FROM LMC_TEAM_JOB WHERE TJ_ID=LMC_TJID;

		IF @TICK_T_TJID IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;
	END LOOP;
	END IF;
END IF;


MAIN_LOOP : LOOP
		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@PIPE_LAID,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_PIPE_LAID;
		SELECT @REMAINING_STRING INTO @PIPE_LAID;
	
		IF LMC_PIPE_LAID=''  THEN
			SET LMC_PIPE_LAID=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@LMCSIZE,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_SIZE;
		SELECT @REMAINING_STRING INTO @LMCSIZE;

		IF LMC_SIZE='' THEN
			SET LMC_SIZE=NULL;
		END IF;

		CALL SP_LMC_GET_SPECIAL_CHARACTER_SEPERATED_VALUES('^',@LMCLENGTH,@VALUE,@REMAINING_STRING);
		SELECT @VALUE INTO LMC_LENGTH;
		SELECT @REMAINING_STRING INTO @LMCLENGTH;

		IF LMC_LENGTH='' THEN
			SET LMC_LENGTH=NULL;
		END IF;

		IF SEARCH_OPTION=2 THEN
			SET LMC_TJID=(SELECT TJ_ID FROM LMC_TEAM_JOB WHERE TRD_ID=TRDID AND TJ_PIPE_LAID=LMC_PIPE_LAID);
		END IF;

		

		IF SEARCH_OPTION=1 THEN
			IF LMC_PIPE_LAID IS NOT NULL AND  LMC_SIZE IS NOT NULL AND LMC_LENGTH IS NOT NULL THEN

					INSERT INTO LMC_TEAM_JOB(TRD_ID,TJ_PIPE_LAID,TJ_SIZE,TJ_LENGTH,ULD_ID)VALUES 
					(TRDID,LMC_PIPE_LAID,LMC_SIZE,LMC_LENGTH,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
			END IF;
		END IF;
		IF SEARCH_OPTION=2 THEN
			IF LMC_TJID IS NULL AND LMC_PIPE_LAID IS NOT NULL AND  LMC_SIZE IS NOT NULL AND LMC_LENGTH IS NOT NULL THEN
				INSERT INTO LMC_TEAM_JOB(TRD_ID,TJ_PIPE_LAID,TJ_SIZE,TJ_LENGTH,ULD_ID)VALUES 
				(TRDID,LMC_PIPE_LAID,LMC_SIZE,LMC_LENGTH,(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP));
			END IF;
			IF LMC_TJID IS NOT NULL AND LMC_PIPE_LAID IS NOT NULL AND  LMC_SIZE IS NOT NULL AND LMC_LENGTH IS NOT NULL THEN
				UPDATE LMC_TEAM_JOB SET TRD_ID=TRDID,TJ_PIPE_LAID=LMC_PIPE_LAID,TJ_SIZE=LMC_SIZE,TJ_LENGTH=LMC_LENGTH,ULD_ID=(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERSTAMP) WHERE TJ_ID=LMC_TJID; 
			END IF;
		END IF;

		IF  @PIPE_LAID IS NULL THEN
			LEAVE  MAIN_LOOP;
		END IF;
		SET LMC_TJID=NULL;

	END LOOP;
SET SUCCESS_MESSAGE=1;
END//
DELIMITER ;


-- Dumping structure for procedure SP_LMC_TS_USER_RIGHTS_TABLE_CREATION
DROP PROCEDURE IF EXISTS `SP_LMC_TS_USER_RIGHTS_TABLE_CREATION`;
DELIMITER //
CREATE  PROCEDURE `SP_LMC_TS_USER_RIGHTS_TABLE_CREATION`(
OUT SUCCESS_MESSAGE TEXT)
BEGIN
-- QUERY FOR ROLLBACK COMMAND
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN 
	SET SUCCESS_MESSAGE=0;
	END;
	START TRANSACTION;

	SET FOREIGN_KEY_CHECKS = 0;
	SET SUCCESS_MESSAGE=0;
	SET AUTOCOMMIT=0;
	DROP TABLE IF EXISTS LMC_MENU_PROFILE;
	CREATE TABLE LMC_MENU_PROFILE(
	MP_ID INTEGER NOT NULL AUTO_INCREMENT,
	MP_MNAME VARCHAR(25) NOT NULL,
	MP_MSUB VARCHAR(50) NOT NULL,
	MP_MSUBMENU	VARCHAR(60) NULL,
	MP_MFILENAME VARCHAR(100) NOT NULL,
	MP_SCRIPT_FLAG VARCHAR(1) NULL,
	PRIMARY KEY(MP_ID));

	SET @ALTER_MENU_PROFILE = (SELECT CONCAT('ALTER TABLE LMC_MENU_PROFILE AUTO_INCREMENT = 0'));
	PREPARE ALTER_MENU_PROFILE_STMT FROM @ALTER_MENU_PROFILE;
	EXECUTE ALTER_MENU_PROFILE_STMT;


	-- ROLE_CREATION TABLE CREATION
	DROP TABLE IF EXISTS LMC_ROLE_CREATION;
	CREATE TABLE LMC_ROLE_CREATION(
	RC_ID INTEGER NOT NULL AUTO_INCREMENT,
	URC_ID INTEGER NOT NULL,
	RC_NAME	VARCHAR(15)	UNIQUE	NOT NULL,
	RC_USERSTAMP VARCHAR(50) NOT NULL,
	RC_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(RC_ID),
	FOREIGN KEY(URC_ID) REFERENCES LMC_USER_RIGHTS_CONFIGURATION (URC_ID));

	SET @ALTER_ROLE_CREATION = (SELECT CONCAT('ALTER TABLE LMC_ROLE_CREATION AUTO_INCREMENT = 0'));
	PREPARE ALTER_ROLE_CREATION_STMT FROM @ALTER_ROLE_CREATION;
	EXECUTE ALTER_ROLE_CREATION_STMT;

	
-- USER_LOGIN_DETAILS TABLE CREATION
	DROP TABLE IF EXISTS LMC_USER_LOGIN_DETAILS;
	CREATE TABLE LMC_USER_LOGIN_DETAILS(
	ULD_ID INTEGER NOT NULL AUTO_INCREMENT,
	ULD_USERNAME	VARCHAR(40)	UNIQUE NOT NULL,
	ULD_PASSWORD TEXT NOT NULL,
	ULD_USERSTAMP VARCHAR(50) NOT NULL,
	ULD_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(ULD_ID));	

	SET @ALTER_USER_LOGIN_DETAILS = (SELECT CONCAT('ALTER TABLE LMC_USER_LOGIN_DETAILS AUTO_INCREMENT = 0'));
	PREPARE ALTER_USER_LOGIN_DETAILS_STMT FROM @ALTER_USER_LOGIN_DETAILS;
	EXECUTE ALTER_USER_LOGIN_DETAILS_STMT;	


	DROP TABLE IF EXISTS LMC_USER_ACCESS;
	CREATE TABLE LMC_USER_ACCESS(
	UA_ID INTEGER NOT NULL AUTO_INCREMENT,
	RC_ID INTEGER NOT NULL,
	ULD_ID INTEGER NOT NULL,
	UA_REC_VER INTEGER NOT NULL,
	UA_JOIN_DATE DATE NOT NULL,
	UA_JOIN CHAR(1),
	UA_END_DATE DATE,
	UA_TERMINATE CHAR(1),
	UA_REASON TEXT,
	UA_EMP_TYPE INTEGER NOT NULL,
	UA_FILE_NAME TEXT,
	UA_USERSTAMP VARCHAR(50) NOT NULL,
	UA_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(UA_ID),
	FOREIGN KEY(ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID),
	FOREIGN KEY(RC_ID) REFERENCES LMC_ROLE_CREATION (RC_ID));
	SET @ALTER_USER_ACCESS = (SELECT CONCAT('ALTER TABLE LMC_USER_ACCESS AUTO_INCREMENT = 0'));
	PREPARE ALTER_USER_ACCESS_STMT FROM @ALTER_USER_ACCESS;
	EXECUTE ALTER_USER_ACCESS_STMT;

	DROP TABLE IF EXISTS LMC_USER_MENU_DETAILS;
	CREATE TABLE LMC_USER_MENU_DETAILS(
	UMD_ID INTEGER NOT NULL AUTO_INCREMENT,
	MP_ID INTEGER NOT NULL,
	RC_ID INTEGER NOT NULL,
	ULD_ID INTEGER NOT NULL,
	UMD_TIMESTAMP TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(UMD_ID),
	FOREIGN KEY(MP_ID) REFERENCES LMC_MENU_PROFILE (MP_ID),
	FOREIGN KEY(RC_ID) REFERENCES LMC_ROLE_CREATION (RC_ID),
	FOREIGN KEY(ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));
	SET @ALTER_USER_MENU_DETAILS = (SELECT CONCAT('ALTER TABLE LMC_USER_MENU_DETAILS AUTO_INCREMENT = 0'));
	PREPARE ALTER_USER_MENU_DETAILS_STMT FROM @ALTER_USER_MENU_DETAILS;
	EXECUTE ALTER_USER_MENU_DETAILS_STMT;

	DROP TABLE IF EXISTS LMC_BASIC_ROLE_PROFILE;
	CREATE TABLE LMC_BASIC_ROLE_PROFILE(
	BRP_ID INTEGER NOT NULL AUTO_INCREMENT,
	URC_ID INTEGER NOT NULL,
	BRP_BR_ID INTEGER NOT NULL,
	ULD_ID INTEGER NOT NULL,
	BRP_TIMESTAMP TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(BRP_ID),
	FOREIGN KEY(URC_ID) REFERENCES LMC_USER_RIGHTS_CONFIGURATION (URC_ID),
	FOREIGN KEY(BRP_BR_ID) REFERENCES LMC_USER_RIGHTS_CONFIGURATION (URC_ID),
	FOREIGN KEY(ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));
	SET @ALTER_BASIC_ROLE_PROFILE = (SELECT CONCAT('ALTER TABLE LMC_BASIC_ROLE_PROFILE AUTO_INCREMENT = 0'));
	PREPARE ALTER_BASIC_ROLE_PROFILE_STMT FROM @ALTER_BASIC_ROLE_PROFILE;
	EXECUTE ALTER_BASIC_ROLE_PROFILE_STMT;

	DROP TABLE IF EXISTS LMC_BASIC_MENU_PROFILE;
	CREATE TABLE LMC_BASIC_MENU_PROFILE(
	BMP_ID INTEGER NOT NULL AUTO_INCREMENT,
	URC_ID INTEGER NOT NULL,
	MP_ID INTEGER NOT NULL,
	ULD_ID INTEGER NOT NULL,
	BMP_TIMESTAMP TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(BMP_ID),
	FOREIGN KEY(URC_ID) REFERENCES LMC_USER_RIGHTS_CONFIGURATION (URC_ID),
	FOREIGN KEY(MP_ID) REFERENCES LMC_MENU_PROFILE (MP_ID),
	FOREIGN KEY(ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));
	SET @ALTER_BASIC_MENU_PROFILE = (SELECT CONCAT('ALTER TABLE LMC_BASIC_MENU_PROFILE AUTO_INCREMENT = 0'));
	PREPARE ALTER_BASIC_MENU_PROFILE_STMT FROM @ALTER_BASIC_MENU_PROFILE;
	EXECUTE ALTER_BASIC_MENU_PROFILE_STMT;

	DROP TABLE IF EXISTS LMC_TEAM_CREATION;
	CREATE TABLE LMC_TEAM_CREATION(
	TC_ID INTEGER NOT NULL AUTO_INCREMENT,
	TEAM_NAME VARCHAR(25) NOT NULL UNIQUE,
	ULD_ID INTEGER NOT NULL,
	TC_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(TC_ID));
	SET @ALTER_TEAM_CREATION = (SELECT CONCAT('ALTER TABLE LMC_TEAM_CREATION AUTO_INCREMENT = 0'));
	PREPARE ALTER_TEAM_CREATIONSTMT FROM @ALTER_TEAM_CREATION;
	EXECUTE ALTER_TEAM_CREATIONSTMT;

	DROP TABLE IF EXISTS LMC_EMPLOYEE_DETAILS;
	CREATE TABLE LMC_EMPLOYEE_DETAILS(
	EMP_ID INTEGER NOT NULL AUTO_INCREMENT,
	ULD_ID INTEGER NOT NULL,
	EMP_FIRST_NAME CHAR(50) NOT NULL,
	EMP_LAST_NAME CHAR(50) NOT NULL,
	NRIC_NO VARCHAR(10) NOT NULL,
	EMP_DESIGNATION VARCHAR(50) NOT NULL,
	EMP_GENDER VARCHAR(6)NOT NULL,
	EMP_MOBILE_NUMBER VARCHAR(8) NOT NULL,
	EMP_DOB DATE NOT NULL,
	TC_ID INTEGER NOT NULL,
	EMP_ADDRESS TEXT NOT NULL,
	EMP_REMARKS TEXT,
	EMP_NEXT_KIN_NAME CHAR(30) NOT NULL,
	EMP_RELATIONHOOD CHAR(30) NOT NULL,
	EMP_ALT_MOBILE_NO VARCHAR(8) NOT NULL,
	EMP_BANK_NAME VARCHAR(50)NOT NULL,
	EMP_BRANCH_NAME VARCHAR(50) NOT NULL,
	EMP_ACCOUNT_NAME VARCHAR(50) NOT NULL,
	EMP_ACCOUNT_NO VARCHAR(50)NOT NULL,
	EMP_IFSC_CODE VARCHAR(50) NOT NULL,
	EMP_ACCOUNT_TYPE VARCHAR(15)NOT NULL,
	EMP_BRANCH_ADDRESS TEXT NOT NULL,
	EMP_IMAGE_FOLDER_ID TEXT NOT NULL,
	EMP_DOC_FOLDER_ID TEXT NOT NULL,
	EMP_USERSTAMP_ID INTEGER NOT NULL,
	EMP_TIMESTAMP TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(EMP_ID),
	FOREIGN KEY(TC_ID) REFERENCES LMC_TEAM_CREATION (TC_ID),
	FOREIGN KEY(ULD_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID),
	FOREIGN KEY(EMP_USERSTAMP_ID) REFERENCES LMC_USER_LOGIN_DETAILS (ULD_ID));

	SET @ALTER_EMPLOYEE_DETAILS = (SELECT CONCAT('ALTER TABLE LMC_EMPLOYEE_DETAILS AUTO_INCREMENT = 0'));
	PREPARE ALTER_EMPLOYEE_DETAILS_STMT FROM @ALTER_EMPLOYEE_DETAILS;
	EXECUTE ALTER_EMPLOYEE_DETAILS_STMT;
	SET SUCCESS_MESSAGE=1;
	
	COMMIT;
END//
DELIMITER ;


-- Dumping structure for procedure SP_TS_ACCESS_RIGHTS_SITE_MAINTENANCE
DROP PROCEDURE IF EXISTS `SP_TS_ACCESS_RIGHTS_SITE_MAINTENANCE`;
DELIMITER //
CREATE  PROCEDURE `SP_TS_ACCESS_RIGHTS_SITE_MAINTENANCE`(MENUID TEXT)
BEGIN
    DECLARE MENU_LENGTH INTEGER;
    DECLARE TEMP_MENU TEXT;
    DECLARE MENU INTEGER;
    DECLARE MENU_POSITION INTEGER;
    BEGIN 
        ROLLBACK; 
    END;
    SET AUTOCOMMIT=0;
    START TRANSACTION;
    IF (MENUID IS NOT NULL) THEN
        UPDATE LMC_MENU_PROFILE SET MP_SCRIPT_FLAG=NULL;
        SET TEMP_MENU=MENUID;
        SET MENU_LENGTH=1;
        loop_label : LOOP
            SET MENU_POSITION=(SELECT LOCATE(',', TEMP_MENU,MENU_LENGTH));
            IF (MENU_POSITION<=0) THEN
                SET MENU=TEMP_MENU;
            ELSE
                SELECT SUBSTRING(TEMP_MENU,MENU_LENGTH,MENU_POSITION-1) INTO MENU;
                SET TEMP_MENU=(SELECT SUBSTRING(TEMP_MENU,MENU_POSITION+1));
            END IF;
            -- UPDATE QUERY FOR LMC_MENU_PROFILE TABLE
            UPDATE LMC_MENU_PROFILE SET MP_SCRIPT_FLAG='X' WHERE MP_ID=MENU;
            IF (MENU_POSITION<=0) THEN
                LEAVE  loop_label;
            END IF;
        END LOOP;
    ELSE
        UPDATE LMC_MENU_PROFILE SET MP_SCRIPT_FLAG=NULL WHERE MP_SCRIPT_FLAG='X';
    END IF;
    COMMIT;
END//
DELIMITER ;


-- Dumping structure for procedure SP_TS_CHANGE_USERSTAMP_AS_ULDID
DROP PROCEDURE IF EXISTS `SP_TS_CHANGE_USERSTAMP_AS_ULDID`;
DELIMITER //
CREATE  PROCEDURE `SP_TS_CHANGE_USERSTAMP_AS_ULDID`(
IN USERSTAMP VARCHAR(50),
OUT ULDID INTEGER)
BEGIN
    SET ULDID = (SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME = USERSTAMP);
END//
DELIMITER ;


-- Dumping structure for procedure SP_TS_EMAIL_TEMPLATE_INSERT
DROP PROCEDURE IF EXISTS `SP_TS_EMAIL_TEMPLATE_INSERT`;
DELIMITER //
CREATE  PROCEDURE `SP_TS_EMAIL_TEMPLATE_INSERT`(
IN EMAIL_SCRIPT VARCHAR(100),
IN EMAIL_SUBJECT VARCHAR(1000),
IN EMAIL_BODY TEXT,
IN USERSTAMP VARCHAR(50),
OUT SUCCESS_FLAG INTEGER)
BEGIN
    DECLARE USERSTAMP_ID INTEGER(2);
    DECLARE ETID INTEGER;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN 
        ROLLBACK;
        SET SUCCESS_FLAG=0;
    END;
    START TRANSACTION;
    SET SUCCESS_FLAG=0;
    CALL SP_TS_CHANGE_USERSTAMP_AS_ULDID(USERSTAMP,@ULDID);
    SET USERSTAMP_ID=@ULDID;
    IF(EMAIL_SCRIPT IS NOT NULL AND EMAIL_SUBJECT IS NOT NULL AND EMAIL_BODY IS NOT NULL AND USERSTAMP IS NOT NULL)THEN
        IF NOT EXISTS(SELECT ET_EMAIL_SCRIPT FROM LMC_EMAIL_TEMPLATE WHERE ET_EMAIL_SCRIPT=EMAIL_SCRIPT)THEN
            INSERT INTO LMC_EMAIL_TEMPLATE(ET_EMAIL_SCRIPT)VALUES(EMAIL_SCRIPT);
            SET SUCCESS_FLAG=1;
        END IF;
        SET ETID=(SELECT ET_ID FROM LMC_EMAIL_TEMPLATE WHERE ET_EMAIL_SCRIPT=EMAIL_SCRIPT);
        IF NOT EXISTS(SELECT ET_ID FROM LMC_EMAIL_TEMPLATE_DETAILS WHERE ET_ID=ETID)THEN
            INSERT INTO LMC_EMAIL_TEMPLATE_DETAILS(ET_ID,ETD_EMAIL_SUBJECT,ETD_EMAIL_BODY,ULD_ID)VALUES(ETID,EMAIL_SUBJECT,EMAIL_BODY,USERSTAMP_ID);
            SET SUCCESS_FLAG=1;
        END IF;
    END IF;
    COMMIT;
END//
DELIMITER ;


-- Dumping structure for procedure SP_TS_LOGIN_CREATION_INSERT
DROP PROCEDURE IF EXISTS `SP_TS_LOGIN_CREATION_INSERT`;
DELIMITER //
CREATE  PROCEDURE `SP_TS_LOGIN_CREATION_INSERT`(
IN SEARCH_OPTION INTEGER,
IN USERNAME VARCHAR(40),
IN PASSWORD TEXT,
IN ULDID INTEGER,
IN ROLENAME VARCHAR(15),
IN JOINDATE DATE,
IN EMPTYPE TEXT,
IN FILENAME TEXT,
IN FIRST_NAME CHAR(30),
IN LAST_NAME CHAR(30),
IN NRICNO VARCHAR(10),
IN DESIGNATION VARCHAR(50),
IN GENDER VARCHAR(6),
IN MOBILE_NUMBER VARCHAR(10),
IN DOB DATE,
IN TEAMNAME VARCHAR(25),
IN DOCFOLDERID TEXT,
IN EMPADDRESS TEXT,
IN EMPREMARKS TEXT,
IN NEXT_KIN_NAME CHAR(30),
IN RELATIONHOOD CHAR(30),
IN ALT_MOBILE_NO VARCHAR(8),
IN BANKNAME VARCHAR(50),
IN BRANCHNAME VARCHAR(50),
IN ACCOUNTNAME VARCHAR(50),
IN ACCOUNTNO VARCHAR(50),
IN IFSC_CODE VARCHAR(50),
IN ACCOUNT_TYPE VARCHAR(15),
IN BRANCH_ADDRESS TEXT,
IN IMAGEFOLDERID TEXT,
IN USERSTAMP VARCHAR(50),
OUT SUCCESS_FLAG INTEGER)
BEGIN
	-- VARIABLE DECLARATION
	DECLARE RECVER INTEGER;
	DECLARE USERSTAMP_ID INT;
	DECLARE EMPID INT;
	DECLARE LOGIN_ULDID INTEGER;
	DECLARE TCID INTEGER;
	-- ROLLBACK COMMAND
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN 
	ROLLBACK; 
		SET SUCCESS_FLAG=0;
	END;
	START TRANSACTION;
	SET AUTOCOMMIT = 0;
	SET SUCCESS_FLAG=0;
	IF EMPREMARKS= '' THEN
		SET EMPREMARKS=NULL;
	END IF;
	IF USERNAME=' ' THEN
		SET USERNAME=NULL;
	END IF;
	SET RECVER=(SELECT MAX(UA_REC_VER) FROM LMC_USER_ACCESS WHERE ULD_ID=ULDID);
	IF SEARCH_OPTION=1 THEN
		IF NOT EXISTS(SELECT ULD_USERNAME FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERNAME) THEN
			IF (USERNAME IS NOT NULL AND PASSWORD IS NOT NULL) THEN
			-- INSERT QUERY FOR USER_LOGIN_DETAILS
				INSERT INTO LMC_USER_LOGIN_DETAILS(ULD_USERNAME,ULD_PASSWORD,ULD_USERSTAMP)VALUES(USERNAME,PASSWORD,USERSTAMP);
				SET SUCCESS_FLAG=1;
			END IF;
			IF (USERNAME IS NOT NULL AND ROLENAME IS NOT NULL AND JOINDATE IS NOT NULL AND USERSTAMP IS NOT 
			NULL AND EMPTYPE IS NOT NULL)THEN
				-- INSERT QUERY FOR USER ACCESS		
				INSERT INTO LMC_USER_ACCESS(RC_ID,ULD_ID,UA_REC_VER,UA_JOIN_DATE,UA_JOIN,UA_EMP_TYPE,UA_FILE_NAME,
				UA_USERSTAMP)VALUES((SELECT RC_ID FROM LMC_ROLE_CREATION WHERE RC_NAME=ROLENAME),
				(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERNAME),1,JOINDATE,'X',
				(SELECT URC_ID FROM LMC_USER_RIGHTS_CONFIGURATION WHERE CGN_ID=6 AND URC_DATA=EMPTYPE),FILENAME,USERSTAMP);
				SET SUCCESS_FLAG=1;
			END IF;
		END IF;	
	END IF;
	IF SEARCH_OPTION=2 THEN
		-- INSERT QUERY FOR  USER ACCESS REJOIN
		UPDATE LMC_USER_LOGIN_DETAILS SET ULD_PASSWORD=PASSWORD,ULD_USERSTAMP=USERSTAMP WHERE ULD_ID=ULDID;
		SET SUCCESS_FLAG=1;
		INSERT INTO LMC_USER_ACCESS(RC_ID,ULD_ID,UA_REC_VER,UA_JOIN_DATE,UA_JOIN,UA_EMP_TYPE,UA_FILE_NAME,UA_USERSTAMP)
		VALUES((SELECT RC_ID FROM LMC_ROLE_CREATION WHERE RC_NAME=ROLENAME),ULDID,(RECVER+1),JOINDATE,'X',
		(SELECT URC_ID FROM LMC_USER_RIGHTS_CONFIGURATION WHERE CGN_ID=6 AND URC_DATA=EMPTYPE),FILENAME,USERSTAMP);		
		SET SUCCESS_FLAG=1;
	END IF;	
	CALL SP_TS_CHANGE_USERSTAMP_AS_ULDID(USERSTAMP,@ULD_ID);
	SET USERSTAMP_ID=@ULD_ID;
	IF TEAMNAME IS NOT NULL THEN
			IF EXISTS(SELECT TEAM_NAME FROM LMC_TEAM_CREATION WHERE TEAM_NAME=TEAMNAME)THEN
				SET TCID=(SELECT TC_ID FROM LMC_TEAM_CREATION WHERE TEAM_NAME=TEAMNAME);
			ELSE 
				INSERT INTO LMC_TEAM_CREATION(TEAM_NAME,ULD_ID)VALUES(TEAMNAME,USERSTAMP_ID);
				SET  TCID=(SELECT TC_ID FROM LMC_TEAM_CREATION WHERE TEAM_NAME=TEAMNAME);
			END IF;
	END IF;
	IF SEARCH_OPTION=1 THEN
		CALL SP_TS_CHANGE_USERSTAMP_AS_ULDID(USERNAME,@ULD_ID);
		SET LOGIN_ULDID=@ULD_ID;
		
		IF (USERNAME IS NOT NULL AND FIRST_NAME IS NOT NULL AND LAST_NAME IS NOT NULL AND NRICNO IS NOT NULL AND  DESIGNATION IS NOT NULL AND GENDER IS NOT NULL
		AND   MOBILE_NUMBER IS NOT NULL AND DOB IS NOT NULL AND TCID IS NOT NULL AND EMPADDRESS IS NOT NULL AND NEXT_KIN_NAME IS NOT NULL AND 
		RELATIONHOOD IS NOT NULL AND ALT_MOBILE_NO IS NOT NULL AND BANKNAME IS NOT NULL AND BRANCHNAME IS 
		NOT NULL AND ACCOUNTNAME IS NOT NULL AND ACCOUNTNO IS NOT NULL AND  IFSC_CODE IS NOT NULL AND 
		ACCOUNT_TYPE IS NOT NULL AND  BRANCH_ADDRESS IS NOT NULL AND IMAGEFOLDERID IS NOT NULL AND DOCFOLDERID IS NOT NULL AND USERSTAMP IS NOT NULL)THEN
			IF NOT EXISTS(SELECT DISTINCT ULD_ID FROM LMC_EMPLOYEE_DETAILS WHERE ULD_ID=LOGIN_ULDID)THEN
				-- INSERT QUERY FOR EMPLOYEE_DETAILS 
				INSERT INTO LMC_EMPLOYEE_DETAILS (ULD_ID,EMP_FIRST_NAME,EMP_LAST_NAME,NRIC_NO,EMP_DESIGNATION,EMP_GENDER,EMP_MOBILE_NUMBER ,
				EMP_DOB,TC_ID,EMP_ADDRESS,EMP_REMARKS,EMP_NEXT_KIN_NAME,
				EMP_RELATIONHOOD,EMP_ALT_MOBILE_NO,EMP_BANK_NAME,EMP_BRANCH_NAME,EMP_ACCOUNT_NAME,
				EMP_ACCOUNT_NO,EMP_IFSC_CODE,EMP_ACCOUNT_TYPE,EMP_BRANCH_ADDRESS,EMP_IMAGE_FOLDER_ID,EMP_DOC_FOLDER_ID,
				EMP_USERSTAMP_ID) VALUES
				(LOGIN_ULDID,FIRST_NAME,LAST_NAME,NRICNO,DESIGNATION,GENDER,MOBILE_NUMBER,DOB,TCID,EMPADDRESS,EMPREMARKS,NEXT_KIN_NAME,RELATIONHOOD,
				ALT_MOBILE_NO,BANKNAME,BRANCHNAME,ACCOUNTNAME,ACCOUNTNO,IFSC_CODE,ACCOUNT_TYPE,BRANCH_ADDRESS,IMAGEFOLDERID,DOCFOLDERID,USERSTAMP_ID);   
				SET SUCCESS_FLAG=1; 
			END IF;
		END IF;
	END IF;
	IF SEARCH_OPTION=2 THEN
		IF (ULDID IS NOT NULL AND FIRST_NAME IS NOT NULL AND LAST_NAME IS NOT NULL AND NRICNO IS NOT NULL AND  DESIGNATION IS NOT NULL AND GENDER IS NOT NULL
		AND   MOBILE_NUMBER IS NOT NULL AND DOB IS NOT NULL AND TCID IS NOT NULL AND EMPADDRESS IS NOT NULL AND NEXT_KIN_NAME IS NOT NULL AND 
		RELATIONHOOD IS NOT NULL AND ALT_MOBILE_NO IS NOT NULL AND BANKNAME IS NOT NULL AND BRANCHNAME IS 
		NOT NULL AND ACCOUNTNAME IS NOT NULL AND ACCOUNTNO IS NOT NULL AND  IFSC_CODE IS NOT NULL AND 
		ACCOUNT_TYPE IS NOT NULL AND  BRANCH_ADDRESS IS NOT NULL AND USERSTAMP IS NOT NULL)THEN
			-- UPDATE QUERY FOR EMPLOYEE DETAILS REJOIN
			UPDATE LMC_EMPLOYEE_DETAILS SET EMP_FIRST_NAME=FIRST_NAME,EMP_LAST_NAME=LAST_NAME,NRIC_NO=NRICNO,EMP_DESIGNATION=DESIGNATION,EMP_GENDER=GENDER,
			EMP_MOBILE_NUMBER=MOBILE_NUMBER,EMP_DOB=DOB,TC_ID=TCID,EMP_ADDRESS=EMPADDRESS,EMP_REMARKS=EMPREMARKS,
			EMP_NEXT_KIN_NAME=NEXT_KIN_NAME,
			EMP_RELATIONHOOD=RELATIONHOOD,EMP_ALT_MOBILE_NO=ALT_MOBILE_NO,EMP_BANK_NAME=BANKNAME,
			EMP_BRANCH_NAME=BRANCHNAME,EMP_ACCOUNT_NAME=ACCOUNTNAME,EMP_ACCOUNT_NO=ACCOUNTNO,
			EMP_IFSC_CODE=IFSC_CODE,EMP_ACCOUNT_TYPE=ACCOUNT_TYPE,EMP_BRANCH_ADDRESS=BRANCH_ADDRESS,
			EMP_USERSTAMP_ID=USERSTAMP_ID WHERE ULD_ID=ULDID;
			SET SUCCESS_FLAG=1;
		END IF;
	END IF;
END//
DELIMITER ;


-- Dumping structure for procedure SP_TS_LOGIN_TERMINATE_SAVE
DROP PROCEDURE IF EXISTS `SP_TS_LOGIN_TERMINATE_SAVE`;
DELIMITER //
CREATE  PROCEDURE `SP_TS_LOGIN_TERMINATE_SAVE`(
IN ULDID INTEGER,
IN ENDDATE DATE,
IN REASON TEXT,
IN USERSTAMP VARCHAR(50),
OUT SUCCESS_FLAG INTEGER)
BEGIN
	-- variable declaration
	DECLARE RECVER INTEGER;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
  	ROLLBACK;
  	SET SUCCESS_FLAG=0;    
	END;
	SET AUTOCOMMIT = 0;
	START TRANSACTION;
	IF (ULDID IS NOT NULL AND ENDDATE IS NOT NULL AND REASON IS NOT NULL AND USERSTAMP IS NOT NULL) THEN
		SET RECVER=(SELECT MAX(UA_REC_VER) FROM LMC_USER_ACCESS WHERE ULD_ID = ULDID);
		-- update query for user access
		UPDATE LMC_USER_ACCESS SET UA_JOIN=NULL,UA_TERMINATE='X',UA_REASON=REASON,UA_END_DATE=ENDDATE,
        UA_USERSTAMP=USERSTAMP WHERE ULD_ID = ULDID AND UA_REC_VER=RECVER;
		SET SUCCESS_FLAG=1;		
	END IF;
END//
DELIMITER ;


-- Dumping structure for procedure SP_TS_LOGIN_UPDATE
DROP PROCEDURE IF EXISTS `SP_TS_LOGIN_UPDATE`;
DELIMITER //
CREATE  PROCEDURE `SP_TS_LOGIN_UPDATE`(
IN USERNAME VARCHAR(40),
IN ULDID INTEGER,
IN ROLENAME VARCHAR(15),
IN JOINDATE DATE,
IN EMPTYPE TEXT,
IN FILE_NAME TEXT,
IN FIRST_NAME CHAR(30),
IN LAST_NAME CHAR(30),
IN NRICNO VARCHAR(10),
IN DESIGNATION VARCHAR(50),
IN GENDER VARCHAR(6),
IN MOBILE_NUMBER VARCHAR(10),
IN DOB DATE,
IN TEAMNAME VARCHAR(25),
IN EMPADDRESS TEXT,
IN EMPREMARKS TEXT,
IN NEXT_KIN_NAME CHAR(30),
IN RELATIONHOOD CHAR(30),
IN ALT_MOBILE_NO VARCHAR(8),
IN BANKNAME VARCHAR(50),
IN BRANCHNAME VARCHAR(50),
IN ACCOUNTNAME VARCHAR(50),
IN ACCOUNTNO VARCHAR(50),
IN IFSC_CODE VARCHAR(50),
IN ACCOUNT_TYPE VARCHAR(15),
IN BRANCH_ADDRESS TEXT,
IN USERSTAMP VARCHAR(50),
OUT UR_FLAG INTEGER)
BEGIN
	-- VARAIBLE DECLARATION
	DECLARE RECVER INTEGER;
	DECLARE USERSTAMP_ID INT;
	DECLARE EMPID INTEGER;
	DECLARE TCID INTEGER;
	DECLARE OLD_UA_FILE_NAME TEXT;
	
	-- ROLLBACK COMMAND
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN 
		ROLLBACK;
		SET UR_FLAG=0;
	END;
	SET AUTOCOMMIT = 0;
	START TRANSACTION; 
	SET UR_FLAG=0;
	IF(EMPREMARKS='')THEN
		SET EMPREMARKS=NULL;
	END IF;	
	IF FILE_NAME='' THEN
		SET FILE_NAME=NULL;
	END IF;
	IF USERNAME IS NOT NULL THEN
		UPDATE LMC_USER_LOGIN_DETAILS SET ULD_USERNAME=USERNAME,ULD_USERSTAMP=USERSTAMP WHERE ULD_ID=ULDID;
	END IF;

	SET RECVER=(SELECT MAX(UA_REC_VER) FROM LMC_USER_ACCESS WHERE ULD_ID=(SELECT ULD_ID FROM LMC_USER_LOGIN_DETAILS 
	WHERE ULD_USERNAME=USERNAME));

	IF (USERNAME IS NOT NULL AND ROLENAME IS NOT NULL AND JOINDATE IS NOT NULL AND USERSTAMP IS NOT NULL 
	AND EMPTYPE IS NOT NULL)THEN
		-- UPDATE QUERY FOR USER_ACCESS
			SET OLD_UA_FILE_NAME=(SELECT UA_FILE_NAME FROM LMC_USER_ACCESS WHERE  ULD_ID=(SELECT ULD_ID FROM 
			LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERNAME)AND UA_REC_VER=RECVER);
			IF FILE_NAME IS NOT NULL THEN
				IF OLD_UA_FILE_NAME IS NOT NULL THEN
					SET FILE_NAME=(SELECT CONCAT(OLD_UA_FILE_NAME,'/',FILE_NAME));
				END IF;
			END IF;
			IF FILE_NAME IS NULL THEN
				SET FILE_NAME=OLD_UA_FILE_NAME;
			END IF;
		UPDATE LMC_USER_ACCESS SET RC_ID=(SELECT RC_ID FROM LMC_ROLE_CREATION WHERE RC_NAME=ROLENAME),
		UA_JOIN_DATE=JOINDATE,UA_USERSTAMP=USERSTAMP,UA_EMP_TYPE=(SELECT URC_ID FROM 
		LMC_USER_RIGHTS_CONFIGURATION WHERE CGN_ID=6 AND URC_DATA=EMPTYPE),UA_FILE_NAME=FILE_NAME WHERE ULD_ID=(SELECT ULD_ID FROM 
		LMC_USER_LOGIN_DETAILS WHERE ULD_USERNAME=USERNAME)AND UA_REC_VER=RECVER;
		SET UR_FLAG=1;
	END IF;
	-- QUERY FOR GETTING ULD_ID FOR USERSTAMP
	CALL SP_TS_CHANGE_USERSTAMP_AS_ULDID(USERSTAMP,@ULD_ID);
	SET USERSTAMP_ID=@ULD_ID;

	IF TEAMNAME IS NOT NULL THEN
			IF EXISTS(SELECT TEAM_NAME FROM LMC_TEAM_CREATION WHERE TEAM_NAME=TEAMNAME)THEN
				SET TCID=(SELECT TC_ID FROM LMC_TEAM_CREATION WHERE TEAM_NAME=TEAMNAME);
			ELSE 
				INSERT INTO LMC_TEAM_CREATION(TEAM_NAME,ULD_ID)VALUES(TEAMNAME,USERSTAMP_ID);
				SET  TCID=(SELECT TC_ID FROM LMC_TEAM_CREATION WHERE TEAM_NAME=TEAMNAME);
			END IF;
	END IF;

	-- QUERY FOR GETTING OLD VALUES
	SET EMPID=(SELECT EMP_ID FROM LMC_EMPLOYEE_DETAILS WHERE ULD_ID=ULDID);
		IF EXISTS(SELECT DISTINCT EMP_ID FROM LMC_EMPLOYEE_DETAILS WHERE EMP_ID=EMPID)THEN
			IF (ULDID IS NOT NULL AND FIRST_NAME IS NOT NULL AND LAST_NAME IS NOT NULL AND NRICNO IS NOT NULL AND  DESIGNATION IS NOT NULL AND GENDER IS NOT NULL
				AND   MOBILE_NUMBER IS NOT NULL AND DOB IS NOT NULL AND TCID IS NOT NULL AND EMPADDRESS IS NOT NULL AND NEXT_KIN_NAME IS NOT NULL AND 
				RELATIONHOOD IS NOT NULL AND ALT_MOBILE_NO IS NOT NULL AND BANKNAME IS NOT NULL AND BRANCHNAME IS 
				NOT NULL AND ACCOUNTNAME IS NOT NULL AND ACCOUNTNO IS NOT NULL AND  IFSC_CODE IS NOT NULL AND 
				ACCOUNT_TYPE IS NOT NULL AND  BRANCH_ADDRESS IS NOT NULL AND USERSTAMP IS NOT NULL) THEN
					UPDATE LMC_EMPLOYEE_DETAILS SET EMP_FIRST_NAME=FIRST_NAME,EMP_LAST_NAME=LAST_NAME,NRIC_NO=NRICNO,EMP_DESIGNATION=DESIGNATION,EMP_GENDER=GENDER,
					EMP_MOBILE_NUMBER=MOBILE_NUMBER,EMP_DOB=DOB,TC_ID=TCID,EMP_ADDRESS=EMPADDRESS,EMP_REMARKS=EMPREMARKS,
					EMP_NEXT_KIN_NAME=NEXT_KIN_NAME,
					EMP_RELATIONHOOD=RELATIONHOOD,EMP_ALT_MOBILE_NO=ALT_MOBILE_NO,EMP_BANK_NAME=BANKNAME,
					EMP_BRANCH_NAME=BRANCHNAME,EMP_ACCOUNT_NAME=ACCOUNTNAME,EMP_ACCOUNT_NO=ACCOUNTNO,
					EMP_IFSC_CODE=IFSC_CODE,EMP_ACCOUNT_TYPE=ACCOUNT_TYPE,EMP_BRANCH_ADDRESS=BRANCH_ADDRESS,
					EMP_USERSTAMP_ID=USERSTAMP_ID WHERE ULD_ID=ULDID;
					SET UR_FLAG=1;
			END IF;
		END IF;
 END//
DELIMITER ;


-- Dumping structure for procedure SP_TS_ROLE_CREATION_INSERT
DROP PROCEDURE IF EXISTS `SP_TS_ROLE_CREATION_INSERT`;
DELIMITER //
CREATE  PROCEDURE `SP_TS_ROLE_CREATION_INSERT`(
IN CUSTOM_ROLE VARCHAR(15),
IN BASIC_ROLE TEXT,
IN MENUID TEXT,
IN USERSTAMP VARCHAR(50),
OUT RC_FLAG INTEGER)
BEGIN
	DECLARE MENU_LENGTH INTEGER;
	DECLARE TEMP_MENU TEXT;
	DECLARE MENU INTEGER;
	DECLARE MENU_POSITION INTEGER;
	DECLARE USERSTAMP_ID INTEGER(2);
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN 
		ROLLBACK; 
		SET RC_FLAG=0;
	END;
	SET AUTOCOMMIT = 0;
	START TRANSACTION;
	CALL SP_TS_CHANGE_USERSTAMP_AS_ULDID(USERSTAMP,@ULDID);
	SET USERSTAMP_ID = (SELECT @ULDID);
	IF CUSTOM_ROLE IS NOT NULL AND BASIC_ROLE IS NOT NULL THEN
		IF NOT EXISTS (SELECT RC_ID FROM LMC_ROLE_CREATION WHERE RC_NAME = CUSTOM_ROLE) THEN
			-- INSERT QUERY FOR LMC_ROLE_CREATION TABLE
			INSERT INTO LMC_ROLE_CREATION(URC_ID,RC_NAME,RC_USERSTAMP) VALUES ((SELECT URC_ID FROM LMC_USER_RIGHTS_CONFIGURATION WHERE URC_DATA=BASIC_ROLE),CUSTOM_ROLE,USERSTAMP);
			SET RC_FLAG=1;
		END IF;
	END IF;
	IF MENUID IS NOT NULL THEN
    SET TEMP_MENU = MENUID;
    SET MENU_LENGTH = 1;
    loop_label : LOOP
  		SET MENU_POSITION=(SELECT LOCATE(',', TEMP_MENU,MENU_LENGTH));
  		IF (MENU_POSITION<=0) THEN
  			SET MENU=TEMP_MENU;
  		ELSE
  			SELECT SUBSTRING(TEMP_MENU,MENU_LENGTH,MENU_POSITION-1) INTO MENU;
  			SET TEMP_MENU=(SELECT SUBSTRING(TEMP_MENU,MENU_POSITION+1));
  		END IF;
      
		  -- INSERT QUERY FOR LMC_USER_MENU_DETAILS
  		INSERT INTO LMC_USER_MENU_DETAILS(MP_ID,RC_ID,ULD_ID)VALUES(MENU,(SELECT RC_ID FROM LMC_ROLE_CREATION WHERE RC_NAME=CUSTOM_ROLE),USERSTAMP_ID);
		  SET RC_FLAG=1;
		  IF (MENU_POSITION<=0) THEN
  			LEAVE  loop_label;
  		END IF;
  	END LOOP;
	END IF; 
	COMMIT;
END//
DELIMITER ;


-- Dumping structure for procedure SP_TS_ROLE_CREATION_UPDATE
DROP PROCEDURE IF EXISTS `SP_TS_ROLE_CREATION_UPDATE`;
DELIMITER //
CREATE  PROCEDURE `SP_TS_ROLE_CREATION_UPDATE`(
IN CUSTOM_ROLE VARCHAR(15),
IN BASIC_ROLE TEXT,
IN MENUID TEXT,
IN USERSTAMP VARCHAR(50),
OUT RC_FLAG INTEGER)
BEGIN
	DECLARE MENU_LENGTH INTEGER;
	DECLARE TEMP_MENU TEXT;
	DECLARE MENU INTEGER;
	DECLARE MENU_POSITION INTEGER;
	DECLARE REMOVE_MP_ID TEXT DEFAULT "'";
	DECLARE GRANT_MP_ID TEXT DEFAULT "'";
	DECLARE USERSTAMP_ID INTEGER(2);
	DECLARE TEMP_INSERT_MENU TEXT;
	DECLARE INSERT_MENU TEXT;
	DECLARE TEMP_REMOVE_MENU TEXT;
	DECLARE REMOVE_MENU TEXT;
	DECLARE RM_COUNT INT;
	DECLARE RM_MPID INT;
	DECLARE IM_COUNT INT;
	DECLARE IM_MPID INT;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;
		SET RC_FLAG=0;
		IF (TEMP_INSERT_MENU IS NOT NULL) THEN
		  SET @DROP_TEMP_INSERT_MENU=(SELECT CONCAT('DROP TABLE IF EXISTS ',TEMP_INSERT_MENU));
		  PREPARE DROP_TEMP_INSERT_MENU_STMT FROM @DROP_TEMP_INSERT_MENU;
		  EXECUTE DROP_TEMP_INSERT_MENU_STMT;
		END IF;
		IF (TEMP_REMOVE_MENU IS NOT NULL) THEN
		  SET @DROP_TEMP_REMOVE_MENU=(SELECT CONCAT('DROP TABLE IF EXISTS ',TEMP_REMOVE_MENU));
		  PREPARE DROP_TEMP_REMOVE_MENU_STMT FROM @DROP_TEMP_REMOVE_MENU;
		  EXECUTE DROP_TEMP_REMOVE_MENU_STMT;
		END IF;
	END;
	SET AUTOCOMMIT = 0;
	START TRANSACTION;
	SET RC_FLAG=0;
	CALL SP_TS_CHANGE_USERSTAMP_AS_ULDID(USERSTAMP,@ULDID);
	SET USERSTAMP_ID = (SELECT @ULDID);
	-- TEMP TABLE
	SET INSERT_MENU=(SELECT CONCAT('TEMP_INSERT_MENU',SYSDATE()));
	SET INSERT_MENU=(SELECT REPLACE(INSERT_MENU,' ',''));
	SET INSERT_MENU=(SELECT REPLACE(INSERT_MENU,'-',''));
	SET INSERT_MENU=(SELECT REPLACE(INSERT_MENU,':',''));
	SET TEMP_INSERT_MENU=(SELECT CONCAT(INSERT_MENU,'_',USERSTAMP_ID));
	SET REMOVE_MENU=(SELECT CONCAT('TEMP_REMOVE_MENU',SYSDATE()));
	SET REMOVE_MENU=(SELECT REPLACE(REMOVE_MENU,' ',''));
	SET REMOVE_MENU=(SELECT REPLACE(REMOVE_MENU,'-',''));
	SET REMOVE_MENU=(SELECT REPLACE(REMOVE_MENU,':',''));
	SET TEMP_REMOVE_MENU=(SELECT CONCAT(REMOVE_MENU,'_',USERSTAMP_ID));
	-- UPDATE ROLE CREATION TABLE
	IF (CUSTOM_ROLE IS NOT NULL AND BASIC_ROLE IS NOT NULL) THEN
		UPDATE LMC_ROLE_CREATION SET URC_ID=(SELECT URC_ID FROM LMC_USER_RIGHTS_CONFIGURATION WHERE URC_DATA=BASIC_ROLE)WHERE RC_NAME=CUSTOM_ROLE;
		SET RC_FLAG=1;
	END IF;
	SET @CREATE_TEMP_INSERT_MENU=(SELECT CONCAT('CREATE TABLE ',TEMP_INSERT_MENU,'(ID INT NOT NULL AUTO_INCREMENT, RC_ID INTEGER,MP_ID INTEGER, PRIMARY KEY (ID))'));
	PREPARE CREATE_TEMP_INSERT_MENU_STMT FROM @CREATE_TEMP_INSERT_MENU;
	EXECUTE CREATE_TEMP_INSERT_MENU_STMT;
	SET @CREATE_TEMP_REMOVE_MENU=(SELECT CONCAT('CREATE TABLE ',TEMP_REMOVE_MENU,'(ID INT NOT NULL AUTO_INCREMENT, RC_ID INTEGER,MP_ID INTEGER, PRIMARY KEY (ID))'));
	PREPARE CREATE_TEMP_REMOVE_MENU_STMT FROM @CREATE_TEMP_REMOVE_MENU;
	EXECUTE CREATE_TEMP_REMOVE_MENU_STMT;
	IF (MENUID IS NOT NULL) THEN
		SET TEMP_MENU = MENUID;
		SET MENU_LENGTH = 1;
		loop_label : LOOP
			SET MENU_POSITION = (SELECT LOCATE(',', TEMP_MENU,MENU_LENGTH));
			IF MENU_POSITION<=0 THEN
				SET MENU = TEMP_MENU;
			ELSE
				SELECT SUBSTRING(TEMP_MENU,MENU_LENGTH,MENU_POSITION-1) INTO MENU;
				SET TEMP_MENU=(SELECT SUBSTRING(TEMP_MENU,MENU_POSITION+1));
			END IF;		
			IF NOT EXISTS(SELECT MP_ID FROM LMC_USER_MENU_DETAILS WHERE MP_ID=MENU AND RC_ID=(SELECT RC_ID FROM LMC_ROLE_CREATION WHERE RC_NAME=CUSTOM_ROLE))THEN
				SET FOREIGN_KEY_CHECKS=0;
				-- INSERT QUERY FOR LMC_USER_MENU_DETAILS
				INSERT INTO LMC_USER_MENU_DETAILS(MP_ID,RC_ID,ULD_ID)VALUES(MENU,(SELECT RC_ID FROM LMC_ROLE_CREATION WHERE RC_NAME=CUSTOM_ROLE),USERSTAMP_ID);
				SET RC_FLAG=1;
			END IF;		
			SET @INSERT_TEMP_INSERT_MENU=(SELECT CONCAT('INSERT INTO ',TEMP_INSERT_MENU,'(RC_ID,MP_ID)VALUES((SELECT RC_ID FROM LMC_ROLE_CREATION WHERE RC_NAME=','"',CUSTOM_ROLE,'"','),',MENU,')'));
			PREPARE INSERT_TEMP_INSERT_MENU_STMT FROM @INSERT_TEMP_INSERT_MENU;
			EXECUTE INSERT_TEMP_INSERT_MENU_STMT;
			IF MENU_POSITION<=0 THEN
				LEAVE  loop_label;
			END IF;
		END LOOP;
	END IF;
	SET @INSERT_TEMP_REMOVE_MENU=(SELECT CONCAT('INSERT INTO ',TEMP_REMOVE_MENU,'(RC_ID, MP_ID)SELECT U.RC_ID,U.MP_ID FROM LMC_USER_MENU_DETAILS U LEFT JOIN ',TEMP_INSERT_MENU,' T ON U.MP_ID=T.MP_ID WHERE T.MP_ID IS NULL AND U.RC_ID=(SELECT RC_ID FROM LMC_ROLE_CREATION WHERE RC_NAME=','"',CUSTOM_ROLE,'"',')'));
	PREPARE INSERT_TEMP_REMOVE_MENU_STMT FROM @INSERT_TEMP_REMOVE_MENU;
	EXECUTE INSERT_TEMP_REMOVE_MENU_STMT;
	SET @RM_COUNT=NULL;
	SET @SELECT_RM_COUNT = (SELECT CONCAT('SELECT COUNT(*) INTO @RM_COUNT FROM ',TEMP_REMOVE_MENU));
	PREPARE SELECT_RM_COUNT_STMT FROM @SELECT_RM_COUNT;
	EXECUTE SELECT_RM_COUNT_STMT;
	SET RM_COUNT=(SELECT @RM_COUNT);
	WHILE (RM_COUNT > 0) DO
		SET @RM_MPID=NULL;
		SET @SELECT_RM_MPID = (SELECT CONCAT('SELECT MP_ID INTO @RM_MPID FROM ',TEMP_REMOVE_MENU,' WHERE ID = ',RM_COUNT));
		PREPARE SELECT_RM_MPID_STMT FROM @SELECT_RM_MPID;
		EXECUTE SELECT_RM_MPID_STMT;
		SET RM_MPID=(SELECT @RM_MPID);
		SET REMOVE_MP_ID = CONCAT (REMOVE_MP_ID,RM_MPID,''',''');
		SET RM_COUNT = RM_COUNT - 1;
	END WHILE;
	SET REMOVE_MP_ID = SUBSTRING(REMOVE_MP_ID,1,CHAR_LENGTH(REMOVE_MP_ID)-2);
	SET @IM_COUNT=NULL;
	SET @SELECT_IM_COUNT = (SELECT CONCAT('SELECT COUNT(*) INTO @IM_COUNT FROM ',TEMP_INSERT_MENU));
	PREPARE SELECT_IM_COUNT_STMT FROM @SELECT_IM_COUNT;
	EXECUTE SELECT_IM_COUNT_STMT;
	SET IM_COUNT=(SELECT @IM_COUNT);
	WHILE (IM_COUNT > 0) DO
		SET @IM_MPID=NULL;
		SET @SELECT_RM_MPID = (SELECT CONCAT('SELECT MP_ID INTO @IM_MPID FROM ',TEMP_INSERT_MENU,' WHERE ID = ',IM_COUNT));
		PREPARE SELECT_RM_MPID_STMT FROM @SELECT_RM_MPID;
		EXECUTE SELECT_RM_MPID_STMT;
		SET IM_MPID=(SELECT @IM_MPID);
		SET GRANT_MP_ID = CONCAT (GRANT_MP_ID,IM_MPID,''',''');
		SET IM_COUNT = IM_COUNT - 1;
	END WHILE;
	-- DELETE QUERY FOR LMC_USER_MENU_DETAILS
	SET GRANT_MP_ID = SUBSTRING(GRANT_MP_ID,1,CHAR_LENGTH(GRANT_MP_ID)-2);
	SET @DELETE_MENU=(SELECT CONCAT ('DELETE FROM LMC_USER_MENU_DETAILS WHERE MP_ID IN (SELECT MP_ID FROM ',TEMP_REMOVE_MENU,')AND RC_ID IN(SELECT RC_ID FROM ',TEMP_REMOVE_MENU,')'));
	PREPARE DELETE_MENU_STMT FROM @DELETE_MENU;
	EXECUTE DELETE_MENU_STMT;
  
	SET @DROP_TEMP_INSERT_MENU=(SELECT CONCAT('DROP TABLE IF EXISTS ',TEMP_INSERT_MENU));
	PREPARE DROP_TEMP_INSERT_MENU_STMT FROM @DROP_TEMP_INSERT_MENU;
	EXECUTE DROP_TEMP_INSERT_MENU_STMT;
	SET @DROP_TEMP_REMOVE_MENU=(SELECT CONCAT('DROP TABLE IF EXISTS ',TEMP_REMOVE_MENU));
	PREPARE DROP_TEMP_REMOVE_MENU_STMT FROM @DROP_TEMP_REMOVE_MENU;
	EXECUTE DROP_TEMP_REMOVE_MENU_STMT;
	COMMIT;
END//
DELIMITER ;


-- Dumping structure for procedure SP_TS_USER_RIGHTS_BASIC_PROFILE_SAVE
DROP PROCEDURE IF EXISTS `SP_TS_USER_RIGHTS_BASIC_PROFILE_SAVE`;
DELIMITER //
CREATE  PROCEDURE `SP_TS_USER_RIGHTS_BASIC_PROFILE_SAVE`(
IN USERSTAMP VARCHAR(50),
IN ROLE VARCHAR(255),
IN BASIC_ROLES VARCHAR(255),
IN MENUS VARCHAR(255),
OUT UR_FLAG INTEGER)
BEGIN
	DECLARE URCID INT;
	DECLARE STR_LEN INT DEFAULT 0;
	DECLARE SUBSTR_LEN INT DEFAULT 0;
	DECLARE MENUID INT;
	DECLARE BASICROLES_ID INT;
	DECLARE BASICROLE VARCHAR(255);
	DECLARE USERSTAMP_ID INTEGER(2);
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;
	END;
	SET AUTOCOMMIT = 0;
	START TRANSACTION;
	SET URCID = (SELECT URC_ID FROM LMC_USER_RIGHTS_CONFIGURATION WHERE URC_DATA = ROLE);
	CALL SP_TS_CHANGE_USERSTAMP_AS_ULDID(USERSTAMP,@ULDID);
	SET USERSTAMP_ID = (SELECT @ULDID);
	SET UR_FLAG=0;
  
	-- FOR BASIC ROLES
	IF (BASIC_ROLES IS NULL) THEN
		SET BASIC_ROLES = '';
	END IF;  
	DO_THIS_FIRST:
	LOOP
		SET STR_LEN = CHAR_LENGTH(BASIC_ROLES); 
		SET BASICROLE = SUBSTRING_INDEX(BASIC_ROLES,',',1); 
		SET BASICROLES_ID = (SELECT URC_ID FROM LMC_USER_RIGHTS_CONFIGURATION WHERE URC_DATA = BASICROLE);
		-- INSERTING EACH ROLES TABLE
		INSERT INTO LMC_BASIC_ROLE_PROFILE (URC_ID, BRP_BR_ID, ULD_ID) VALUES (URCID, BASICROLES_ID, USERSTAMP_ID);
		
		SET UR_FLAG=1;
		SET SUBSTR_LEN = CHAR_LENGTH(SUBSTRING_INDEX(BASIC_ROLES,',',1)) + 2;
		SET BASIC_ROLES = MID(BASIC_ROLES, SUBSTR_LEN, STR_LEN);    
		IF BASIC_ROLES = '' THEN
			LEAVE DO_THIS_FIRST;
		END IF;
	END LOOP DO_THIS_FIRST;
  
	-- FOR MENUS
	IF MENUS IS NULL THEN
		SET MENUS = '';
	END IF;
	DO_THIS:
	LOOP
		SET STR_LEN = CHAR_LENGTH(MENUS);
		SET MENUID = SUBSTRING_INDEX(MENUS,',',1);
		-- INSERTING EACH MENUS IN MENU_PROFILE TABLE
		INSERT INTO LMC_BASIC_MENU_PROFILE (URC_ID, MP_ID, ULD_ID) VALUES (URCID, MENUID, USERSTAMP_ID);   
		
		SET UR_FLAG=1;
		SET SUBSTR_LEN = CHAR_LENGTH(SUBSTRING_INDEX(MENUS,',',1)) + 2;
		SET MENUS = MID(MENUS, SUBSTR_LEN, STR_LEN);
		IF MENUS = '' THEN
		  LEAVE DO_THIS;
		END IF;
	END LOOP DO_THIS;
	COMMIT;
END//
DELIMITER ;


-- Dumping structure for procedure SP_TS_USER_RIGHTS_BASIC_PROFILE_UPDATE
DROP PROCEDURE IF EXISTS `SP_TS_USER_RIGHTS_BASIC_PROFILE_UPDATE`;
DELIMITER //
CREATE  PROCEDURE `SP_TS_USER_RIGHTS_BASIC_PROFILE_UPDATE`(
IN USERSTAMP VARCHAR(50), 
IN ROLE VARCHAR(255),
IN BASIC_ROLES VARCHAR(255),
IN MENUS TEXT(255),
OUT UR_FLAG INTEGER )
BEGIN
	-- VARIABLE DECLARATION
	DECLARE URCID INT;
	DECLARE STR_LEN1 INT DEFAULT 0;
	DECLARE STR_LEN2 INT DEFAULT 0;
	DECLARE STR_LEN3 INT DEFAULT 0;
	DECLARE SUBSTR_LEN1 INT DEFAULT 0;
	DECLARE SUBSTR_LEN2 INT DEFAULT 0;
	DECLARE SUBSTR_LEN3 INT DEFAULT 0;
	DECLARE MENUID INT;
	DECLARE COUNT_1 INT;
	DECLARE COUNT_2 INT;
	DECLARE BASICROLES_ID2 INT;
	DECLARE BASICROLES_ID1 INT;
	DECLARE BASICROLES_2 VARCHAR(255);  
	DECLARE BASICROLES_1 VARCHAR(255); 
	DECLARE BS_ID TEXT(100) DEFAULT '';
	DECLARE BASIC_ROLES1 VARCHAR(255);
	DECLARE BASIC_ROLES2 VARCHAR(255);
	DECLARE USERSTAMP_ID INTEGER(2);
	-- ROLLBACK COMMAND
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;
		SET UR_FLAG=0;
	END;
	SET AUTOCOMMIT = 0;
	START TRANSACTION;
	SET URCID = (SELECT URC_ID FROM LMC_USER_RIGHTS_CONFIGURATION WHERE URC_DATA = ROLE);
	-- SUB SP FOR CONVERTING USERSTAMP AS ULD_ID
	CALL SP_TS_CHANGE_USERSTAMP_AS_ULDID(USERSTAMP,@ULDID);
	SET USERSTAMP_ID = (SELECT @ULDID);
	SET UR_FLAG=0;
	IF BASIC_ROLES IS NULL THEN
		SET BASIC_ROLES = '';
	END IF;
	SET BASIC_ROLES1 = BASIC_ROLES;
	DO_THIS_DELETE:
	LOOP
		SET STR_LEN1 = CHAR_LENGTH(BASIC_ROLES1); 
		SET BASICROLES_1 = SUBSTRING_INDEX(BASIC_ROLES1, ',', 1); 
		SET BASICROLES_ID1 = (SELECT URC_ID FROM LMC_USER_RIGHTS_CONFIGURATION WHERE URC_DATA = BASICROLES_1);
		SET BS_ID = CONCAT (BS_ID,"'",BASICROLES_ID1,"',");
		SET SUBSTR_LEN1 = CHAR_LENGTH(SUBSTRING_INDEX(BASIC_ROLES1, ',', 1)) + 2;
		SET BASIC_ROLES1 = MID(BASIC_ROLES1, SUBSTR_LEN1, STR_LEN1);
		IF BASIC_ROLES1 = '' THEN
			LEAVE DO_THIS_DELETE;
		END IF;
	END LOOP DO_THIS_DELETE;
	SET BS_ID = SUBSTRING(BS_ID,1,(CHAR_LENGTH(BS_ID)-1) );
	-- DELETE QUERY FOR BASIC ROLE PROFILE
	SET @DELETE_BASIC_ROLE_PROFILE = CONCAT('DELETE FROM LMC_BASIC_ROLE_PROFILE WHERE BRP_BR_ID NOT IN (', BS_ID ,') AND URC_ID =',URCID);
	PREPARE DELETE_BASIC_ROLE_PROFILE_STMT FROM @DELETE_BASIC_ROLE_PROFILE;
	EXECUTE DELETE_BASIC_ROLE_PROFILE_STMT;
	SET UR_FLAG=1;
	DO_THIS_FIRST:
	LOOP
		SET STR_LEN2 = CHAR_LENGTH(BASIC_ROLES); 
		SET BASICROLES_2 = SUBSTRING_INDEX(BASIC_ROLES, ',', 1); 
		SET BASICROLES_ID2 = (SELECT URC_ID FROM LMC_USER_RIGHTS_CONFIGURATION WHERE URC_DATA = BASICROLES_2);
		SELECT COUNT(BRP_ID) INTO COUNT_1 FROM LMC_BASIC_ROLE_PROFILE WHERE BRP_BR_ID = BASICROLES_ID2 AND URC_ID = URCID;
		IF (COUNT_1 = 0) THEN
			INSERT INTO LMC_BASIC_ROLE_PROFILE (URC_ID, BRP_BR_ID, ULD_ID) VALUES (URCID, BASICROLES_ID2, USERSTAMP_ID);
		END IF;
		SET UR_FLAG=1;
		SET SUBSTR_LEN2 = CHAR_LENGTH(SUBSTRING_INDEX(BASIC_ROLES, ',', 1)) + 2;
		SET BASIC_ROLES = MID(BASIC_ROLES, SUBSTR_LEN2, STR_LEN2);
		IF BASIC_ROLES = '' THEN
			LEAVE DO_THIS_FIRST;
		END IF;
	END LOOP DO_THIS_FIRST;
	IF MENUS IS NULL THEN
		SET MENUS = '';
	END IF;
	-- DELETE QUERY FOR BASIC_MENU_PROFILE AND USER_MENU_DETAILS
	SET @DELETE_BASIC_MENU_PROFILE = CONCAT('DELETE FROM LMC_BASIC_MENU_PROFILE WHERE MP_ID NOT IN (',MENUS,') AND URC_ID =', URCID);
	PREPARE DELETE_BASIC_MENU_PROFILE_STMT FROM @DELETE_BASIC_MENU_PROFILE;
	EXECUTE DELETE_BASIC_MENU_PROFILE_STMT;
 	SET @DELETE_MENUS=(SELECT CONCAT('DELETE FROM LMC_USER_MENU_DETAILS WHERE RC_ID IN (SELECT RC_ID FROM LMC_ROLE_CREATION WHERE URC_ID=',URCID,') AND MP_ID NOT IN (',MENUS,')'));
  	PREPARE DELETE_MENUS_STMT FROM @DELETE_MENUS;
  	EXECUTE DELETE_MENUS_STMT;
	SET UR_FLAG=1;
	DO_THIS:
	LOOP
		SET STR_LEN3 = CHAR_LENGTH(MENUS);
		SET MENUID = SUBSTRING_INDEX(MENUS, ',', 1);
		SELECT COUNT(BMP_ID) INTO COUNT_2 FROM LMC_BASIC_MENU_PROFILE WHERE MP_ID = MENUID AND URC_ID = URCID;
		IF (COUNT_2 = 0) THEN
			-- INSERT QUERY FOR BASIC_MENU_PROFILE
			INSERT INTO LMC_BASIC_MENU_PROFILE (URC_ID, MP_ID, ULD_ID) VALUES (URCID, MENUID, USERSTAMP_ID);    
		END IF;
		SET UR_FLAG=1;
		SET SUBSTR_LEN3 = CHAR_LENGTH(SUBSTRING_INDEX(MENUS, ',', 1)) + 2;
		SET MENUS = MID(MENUS, SUBSTR_LEN3, STR_LEN3);
		IF MENUS = '' THEN
			LEAVE DO_THIS;
		END IF;
	END LOOP DO_THIS;
	COMMIT;
END//
DELIMITER ;


-- Dumping structure for view vw_access_rights_rejoin_loginid
DROP VIEW IF EXISTS `vw_access_rights_rejoin_loginid`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_access_rights_rejoin_loginid` (
	`ULD_USERNAME` VARCHAR(40) NOT NULL COLLATE 'latin1_swedish_ci',
	`UA_JOIN_DATE` DATE NOT NULL
) ENGINE=MyISAM;


-- Dumping structure for view vw_access_rights_terminate_loginid
DROP VIEW IF EXISTS `vw_access_rights_terminate_loginid`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_access_rights_terminate_loginid` (
	`ULD_USERNAME` VARCHAR(40) NOT NULL COLLATE 'latin1_swedish_ci',
	`URC_ID` INT(11) NOT NULL,
	`URC_DATA` TEXT NOT NULL COLLATE 'latin1_swedish_ci',
	`UA_JOIN_DATE` DATE NOT NULL
) ENGINE=MyISAM;


-- Dumping structure for view vw_sub_access_rights_maxrecver
DROP VIEW IF EXISTS `vw_sub_access_rights_maxrecver`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_sub_access_rights_maxrecver` (
	`ULD_ID` INT(11) NOT NULL,
	`RECVER` INT(11) NULL
) ENGINE=MyISAM;


-- Dumping structure for view vw_sub_ts_all_employee_details
DROP VIEW IF EXISTS `vw_sub_ts_all_employee_details`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_sub_ts_all_employee_details` (
	`EMPLOYEE_NAME` VARCHAR(101) NOT NULL COLLATE 'latin1_swedish_ci',
	`CNT` BIGINT(21) NOT NULL,
	`ULD_ID` INT(11) NOT NULL
) ENGINE=MyISAM;


-- Dumping structure for view vw_ts_all_active_employee_details
DROP VIEW IF EXISTS `vw_ts_all_active_employee_details`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_ts_all_active_employee_details` (
	`ULD_ID` INT(11) NOT NULL,
	`EMPLOYEE_NAME` VARCHAR(113) NOT NULL COLLATE 'latin1_swedish_ci',
	`ULD_USERNAME` VARCHAR(40) NOT NULL COLLATE 'latin1_swedish_ci',
	`URC_DATA` TEXT NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;


-- Dumping structure for view vw_ts_all_employee_details
DROP VIEW IF EXISTS `vw_ts_all_employee_details`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_ts_all_employee_details` (
	`ULD_ID` INT(11) NOT NULL,
	`EMPLOYEE_NAME` VARCHAR(113) NOT NULL COLLATE 'latin1_swedish_ci',
	`ULD_USERNAME` VARCHAR(40) NOT NULL COLLATE 'latin1_swedish_ci',
	`URC_DATA` TEXT NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;


-- Dumping structure for view vw_ts_all_non_active_employee_details
DROP VIEW IF EXISTS `vw_ts_all_non_active_employee_details`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_ts_all_non_active_employee_details` (
	`ULD_ID` INT(11) NOT NULL,
	`EMPLOYEE_NAME` VARCHAR(113) NOT NULL COLLATE 'latin1_swedish_ci',
	`ULD_USERNAME` VARCHAR(40) NOT NULL COLLATE 'latin1_swedish_ci',
	`URC_DATA` TEXT NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;


-- Dumping structure for view vw_ts_sub_all_employee_max_rec_ver
DROP VIEW IF EXISTS `vw_ts_sub_all_employee_max_rec_ver`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_ts_sub_all_employee_max_rec_ver` (
	`ULD_ID` INT(11) NOT NULL,
	`REC_VER` INT(11) NULL
) ENGINE=MyISAM;


-- Dumping structure for view vw_access_rights_rejoin_loginid
DROP VIEW IF EXISTS `vw_access_rights_rejoin_loginid`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_access_rights_rejoin_loginid`;
CREATE  VIEW `vw_access_rights_rejoin_loginid` AS SELECT ULD.ULD_USERNAME,UA.UA_JOIN_DATE FROM LMC_USER_LOGIN_DETAILS ULD,
		LMC_USER_ACCESS UA,VW_SUB_ACCESS_RIGHTS_MAXRECVER V WHERE ULD.ULD_ID=UA.ULD_ID AND UA.UA_REC_VER=V.RECVER AND V.ULD_ID=UA.ULD_ID AND 
		V.ULD_ID=ULD.ULD_ID AND UA.UA_TERMINATE IS NOT NULL GROUP BY ULD.ULD_ID ;


-- Dumping structure for view vw_access_rights_terminate_loginid
DROP VIEW IF EXISTS `vw_access_rights_terminate_loginid`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_access_rights_terminate_loginid`;
CREATE  VIEW `vw_access_rights_terminate_loginid` AS SELECT ULD.ULD_USERNAME,URCN.URC_ID,URCN.URC_DATA,UA.UA_JOIN_DATE FROM 
		LMC_USER_LOGIN_DETAILS ULD,LMC_USER_ACCESS UA,VW_SUB_ACCESS_RIGHTS_MAXRECVER V,LMC_USER_RIGHTS_CONFIGURATION URCN,LMC_ROLE_CREATION RC 
		WHERE ULD.ULD_ID=UA.ULD_ID AND UA.UA_REC_VER=V.RECVER AND V.ULD_ID=UA.ULD_ID AND V.ULD_ID=ULD.ULD_ID AND 
		UA.RC_ID=RC.RC_ID AND RC.URC_ID=URCN.URC_ID AND UA.UA_TERMINATE IS NULL GROUP BY ULD.ULD_ID ;


-- Dumping structure for view vw_sub_access_rights_maxrecver
DROP VIEW IF EXISTS `vw_sub_access_rights_maxrecver`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_sub_access_rights_maxrecver`;
CREATE  VIEW `vw_sub_access_rights_maxrecver` AS SELECT ULD_ID,MAX(UA_REC_VER) AS RECVER FROM 	LMC_USER_ACCESS GROUP BY ULD_ID ;


-- Dumping structure for view vw_sub_ts_all_employee_details
DROP VIEW IF EXISTS `vw_sub_ts_all_employee_details`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_sub_ts_all_employee_details`;
CREATE  VIEW `vw_sub_ts_all_employee_details` AS SELECT CONCAT(EMP_FIRST_NAME,' ',EMP_LAST_NAME) AS EMPLOYEE_NAME,COUNT(EMP_ID) AS CNT,ULD_ID from LMC_EMPLOYEE_DETAILS group by EMP_FIRST_NAME,EMP_LAST_NAME ;


-- Dumping structure for view vw_ts_all_active_employee_details
DROP VIEW IF EXISTS `vw_ts_all_active_employee_details`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_ts_all_active_employee_details`;
CREATE  VIEW `vw_ts_all_active_employee_details` AS SELECT V.ULD_ID AS ULD_ID, 
		IF(VSUB.CNT=1,CONCAT(EMP.EMP_FIRST_NAME,' ',EMP.EMP_LAST_NAME),CONCAT(EMP.EMP_FIRST_NAME,' ',EMP.EMP_LAST_NAME,' ',EMP.ULD_ID)) AS EMPLOYEE_NAME,ULD.ULD_USERNAME,U.URC_DATA AS URC_DATA FROM 
		VW_TS_SUB_ALL_EMPLOYEE_MAX_REC_VER V LEFT JOIN VW_SUB_TS_ALL_EMPLOYEE_DETAILS VSUB ON  VSUB.ULD_ID=V.ULD_ID,LMC_USER_ACCESS UA, LMC_USER_RIGHTS_CONFIGURATION U,LMC_ROLE_CREATION RC,LMC_USER_LOGIN_DETAILS ULD,LMC_EMPLOYEE_DETAILS EMP WHERE UA.ULD_ID = V.ULD_ID AND ULD.ULD_ID=UA.ULD_ID AND ULD.ULD_ID=V.ULD_ID
		AND UA.UA_REC_VER = V.REC_VER AND UA.RC_ID=RC.RC_ID AND U.URC_ID=RC.URC_ID AND EMP.ULD_ID AND ULD.ULD_ID AND EMP.ULD_ID=UA.ULD_ID AND UA.UA_TERMINATE IS NULL ;


-- Dumping structure for view vw_ts_all_employee_details
DROP VIEW IF EXISTS `vw_ts_all_employee_details`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_ts_all_employee_details`;
CREATE  VIEW `vw_ts_all_employee_details` AS SELECT V.ULD_ID AS ULD_ID, 
		 IF(VSUB.CNT=1,CONCAT(EMP.EMP_FIRST_NAME,' ',EMP.EMP_LAST_NAME),CONCAT(EMP.EMP_FIRST_NAME,' ',EMP.EMP_LAST_NAME,' ',EMP.ULD_ID)) AS EMPLOYEE_NAME,ULD.ULD_USERNAME,U.URC_DATA AS URC_DATA FROM 
		VW_TS_SUB_ALL_EMPLOYEE_MAX_REC_VER V LEFT JOIN VW_SUB_TS_ALL_EMPLOYEE_DETAILS VSUB ON  VSUB.ULD_ID=V.ULD_ID,LMC_USER_ACCESS UA, LMC_USER_RIGHTS_CONFIGURATION U,LMC_ROLE_CREATION RC,LMC_USER_LOGIN_DETAILS ULD,LMC_EMPLOYEE_DETAILS EMP WHERE UA.ULD_ID = V.ULD_ID AND ULD.ULD_ID=UA.ULD_ID AND ULD.ULD_ID=V.ULD_ID
		AND UA.UA_REC_VER = V.REC_VER AND UA.RC_ID=RC.RC_ID AND U.URC_ID=RC.URC_ID AND EMP.ULD_ID AND ULD.ULD_ID AND EMP.ULD_ID=UA.ULD_ID ;


-- Dumping structure for view vw_ts_all_non_active_employee_details
DROP VIEW IF EXISTS `vw_ts_all_non_active_employee_details`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_ts_all_non_active_employee_details`;
CREATE  VIEW `vw_ts_all_non_active_employee_details` AS SELECT V.ULD_ID AS ULD_ID, 
		IF(VSUB.CNT=1,CONCAT(EMP.EMP_FIRST_NAME,' ',EMP.EMP_LAST_NAME),CONCAT(EMP.EMP_FIRST_NAME,' ',EMP.EMP_LAST_NAME,' ',EMP.ULD_ID)) AS EMPLOYEE_NAME,ULD.ULD_USERNAME,U.URC_DATA AS URC_DATA FROM 
		VW_TS_SUB_ALL_EMPLOYEE_MAX_REC_VER V LEFT JOIN VW_SUB_TS_ALL_EMPLOYEE_DETAILS VSUB ON  VSUB.ULD_ID=V.ULD_ID,LMC_USER_ACCESS UA, LMC_USER_RIGHTS_CONFIGURATION U,LMC_ROLE_CREATION RC,LMC_USER_LOGIN_DETAILS ULD,LMC_EMPLOYEE_DETAILS EMP WHERE UA.ULD_ID = V.ULD_ID AND ULD.ULD_ID=UA.ULD_ID AND ULD.ULD_ID=V.ULD_ID
		AND UA.UA_REC_VER = V.REC_VER AND UA.RC_ID=RC.RC_ID AND U.URC_ID=RC.URC_ID AND EMP.ULD_ID AND ULD.ULD_ID AND EMP.ULD_ID=UA.ULD_ID AND UA.UA_TERMINATE IS NOT NULL ;


-- Dumping structure for view vw_ts_sub_all_employee_max_rec_ver
DROP VIEW IF EXISTS `vw_ts_sub_all_employee_max_rec_ver`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_ts_sub_all_employee_max_rec_ver`;
CREATE  VIEW `vw_ts_sub_all_employee_max_rec_ver` AS SELECT ULD_ID AS ULD_ID, MAX(UA_REC_VER) 
		AS REC_VER FROM LMC_USER_ACCESS GROUP BY ULD_ID ;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
