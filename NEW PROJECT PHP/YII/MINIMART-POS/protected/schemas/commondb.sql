/*
SQLyog Community v11.27 (64 bit)
MySQL - 5.6.14 : Database - pos
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pos` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `pos`;

/*Table structure for table `accountorders` */

DROP TABLE IF EXISTS `accountorders`;

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

/*Table structure for table `accountpurchases` */

DROP TABLE IF EXISTS `accountpurchases`;

CREATE TABLE `accountpurchases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `purchase_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'purchase id',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `accounts` */

DROP TABLE IF EXISTS `accounts`;

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

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL,
  `name` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'category name',
  `desc` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'description',
  `imagepath` varchar(1024) COLLATE utf8_bin DEFAULT NULL COMMENT 'image file path',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'status 1-active 0-inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `companies` */

DROP TABLE IF EXISTS `companies`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `configs` */

DROP TABLE IF EXISTS `configs`;

CREATE TABLE `configs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `config_key` varchar(128) NOT NULL,
  `config_val` varchar(64) NOT NULL,
  `remarks` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `consignmentnotes` */

DROP TABLE IF EXISTS `consignmentnotes`;

CREATE TABLE `consignmentnotes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `person_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `notes` varchar(50) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `customer_details` */

DROP TABLE IF EXISTS `customer_details`;

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

/*Table structure for table `geolocations` */

DROP TABLE IF EXISTS `geolocations`;

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

/*Table structure for table `idmasters` */

DROP TABLE IF EXISTS `idmasters`;

CREATE TABLE `idmasters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `forwhat` varchar(16) COLLATE utf8_bin NOT NULL,
  `foryear` varchar(8) COLLATE utf8_bin NOT NULL,
  `formonth` varchar(8) COLLATE utf8_bin NOT NULL,
  `lastid` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `locations` */

DROP TABLE IF EXISTS `locations`;

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

/*Table structure for table `loginhistories` */

DROP TABLE IF EXISTS `loginhistories`;

CREATE TABLE `loginhistories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `login_time` datetime DEFAULT NULL COMMENT 'login time',
  `logout_time` datetime DEFAULT NULL COMMENT 'logout time',  
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


/*Table structure for table `logins` */

DROP TABLE IF EXISTS `logins`;

CREATE TABLE `logins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `login` varchar(24) COLLATE utf8_bin NOT NULL COMMENT 'user login name',
  `pass` varchar(88) COLLATE utf8_bin NOT NULL COMMENT 'user password',
  `hash_id` varchar(88) COLLATE utf8_bin NOT NULL COMMENT 'user unique hash for mobile authenticating',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'users status 1-active 0-inactive',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `mailqueues` */

DROP TABLE IF EXISTS `mailqueues`;

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

/*Table structure for table `milestones` */

DROP TABLE IF EXISTS `milestones`;

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

/*Table structure for table `orderactionhistories` */

DROP TABLE IF EXISTS `orderactionhistories`;

CREATE TABLE `orderactionhistories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `modifiedemp_id` int(10) unsigned NOT NULL,
  `action` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'happened action',
  `action_time` datetime DEFAULT NULL COMMENT 'happened time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `orderaddresses` */

DROP TABLE IF EXISTS `orderaddresses`;

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

/*Table structure for table `orderpeople` */

DROP TABLE IF EXISTS `orderpeople`;

CREATE TABLE `orderpeople` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `type` varchar(12) COLLATE utf8_bin NOT NULL COMMENT 'customer,employee, created, modified',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `orderproductdns` */

DROP TABLE IF EXISTS `orderproductdns`;

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

/*Table structure for table `orderproducts` */

DROP TABLE IF EXISTS `orderproducts`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `ordertaskpeople` */

DROP TABLE IF EXISTS `ordertaskpeople`;

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

/*Table structure for table `ordertasks` */

DROP TABLE IF EXISTS `ordertasks`;

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

/*Table structure for table `otprgrshistories` */

DROP TABLE IF EXISTS `otprgrshistories`;

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

/*Table structure for table `payments` */

DROP TABLE IF EXISTS `payments`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `paymentreceipts` */

DROP TABLE IF EXISTS `paymentreceipts`;

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

/*Table structure for table `people` */

DROP TABLE IF EXISTS `people`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `personaddresses` */

DROP TABLE IF EXISTS `personaddresses`;

CREATE TABLE `personaddresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `type` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'office' COMMENT 'office,residence,other',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `personcompanyroles` */

DROP TABLE IF EXISTS `personcompanyroles`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `persontimeslots` */

DROP TABLE IF EXISTS `persontimeslots`;

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

/*Table structure for table `productcategories` */

DROP TABLE IF EXISTS `productcategories`;

CREATE TABLE `productcategories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `productprice_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `productprices` */

DROP TABLE IF EXISTS `productprices`;

CREATE TABLE `productprices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` INT(10) UNSIGNED NOT NULL,
  `code` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT 'product code',
  `sku` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'sku',    
  `supplier_id` INT(10) UNSIGNED NOT NULL,
  `unit_cp` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT 'unit cost',
  `sptype` TINYINT(1) DEFAULT '1' COMMENT '0-sp is directamount,1-percentage on cp',
  `unit_sp_per` DECIMAL(10,2) DEFAULT '0.00' COMMENT 'gain percentage',
  `unit_sp` DECIMAL(10,2) DEFAULT '0.00' COMMENT 'selling price ',  
  `stock` int(10) DEFAULT '0',
  `stockvalue` decimal(10,2) DEFAULT '0.00' COMMENT 'total stock value as per cp',
  `rol` int(10) DEFAULT '0' COMMENT 're-order level quantity',
  `moq` int(10) DEFAULT '0' COMMENT 'minimum order quantity',  
  `dontsyncwithstock` TINYINT(1) DEFAULT '0' COMMENT '1- true 0- false',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'status 1-active 0-inactive',
  `tax` decimal(10,2) DEFAULT '0.00' COMMENT 'total tax amount',
  `disc` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'discount amount',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `productstockhistories` */

DROP TABLE IF EXISTS `productstockhistories`;

CREATE TABLE `productstockhistories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` INT(10) UNSIGNED NOT NULL,
  `productprice_id` INT(10) UNSIGNED NOT NULL,
  `updationdate` datetime DEFAULT NULL COMMENT 'stock update date',
  `beforeupdation` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'before updation',
  `updatedqnty` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'updated quantity',
  `afterupdation` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'before updation',    
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

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
  `taxrate_id` INT(10) UNSIGNED NOT NULL,
  `tax` decimal(10,2) DEFAULT '0.00' COMMENT 'total tax amount',
  `imagepath` varchar(1024) COLLATE utf8_bin DEFAULT NULL COMMENT 'image file path',
  `person_id` int(10) unsigned NOT NULL COMMENT 'employee id who entered this record',
  `code` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT 'product code',
  `sku` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'primary name',    
  `supplier_id` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `unit_cp` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT 'unit cost',
  `sptype` TINYINT(1) DEFAULT '1' COMMENT '0-sp is directamount,1-percentage on cp',
  `unit_sp_per` DECIMAL(10,2) DEFAULT '0.00' COMMENT 'gain percentage',
  `unit_sp` DECIMAL(10,2) DEFAULT '0.00' COMMENT 'selling price ',  
  `stock` int(10) DEFAULT '0',
  `stockvalue` decimal(10,2) DEFAULT '0.00' COMMENT 'total stock value as per cp',
  `rol` int(10) DEFAULT '0' COMMENT 're-order level quantity',
  `moq` int(10) DEFAULT '0' COMMENT 'minimum order quantity',  
  `dontsyncwithstock` TINYINT(1) DEFAULT '0' COMMENT '1- true 0- false',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'status 1-active 0-inactive',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `purchaseproducts` */

DROP TABLE IF EXISTS `purchaseproducts`;

CREATE TABLE `purchaseproducts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `quantity` int(10) NOT NULL DEFAULT '1' COMMENT 'quantity',
  `unit_cp` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'unit_cp * quantity',
  `taxrate_id` INT(10) UNSIGNED NOT NULL,
  `tax` decimal(10,2) DEFAULT '0.00' COMMENT 'total tax amount',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `purchases` */

DROP TABLE IF EXISTS `purchases`;

CREATE TABLE `purchases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_number` varchar(16) COLLATE utf8_bin NOT NULL COMMENT 'purchase number',
  `purchase_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'purchase date field',
  `supplier_id` INT(10) UNSIGNED NOT NULL,  
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

/*Table structure for table `registers` */

DROP TABLE IF EXISTS `registers`;

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

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `statushistories` */

DROP TABLE IF EXISTS `statushistories`;

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

/*Table structure for table `statusmasters` */

DROP TABLE IF EXISTS `statusmasters`;

CREATE TABLE `statusmasters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ofwhich` int(10) unsigned NOT NULL COMMENT 'this row is a astatus for this field',
  `name` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'status name',
  `display` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'display string',
  `desc` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'description',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `tasks` */

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `name` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'category name',
  `desc` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'description',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `taxrates` */

DROP TABLE IF EXISTS `taxrates`;

CREATE TABLE `taxrates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `taxname` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'tax name',
  `taxrate` decimal(10,2) DEFAULT '0.00' COMMENT 'either % or fixed',
  `taxtype` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'Percentage, Fixed',
  `remarks` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'remarks',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `timeslotstatuses` */

DROP TABLE IF EXISTS `timeslotstatuses`;

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

/* base data */

DELETE FROM `taxrates`;
insert  into `taxrates`(`id`,`taxname`,`taxrate`,`taxtype`,`remarks`) 
values 
(1,'No Tax',0,'Percentage','No tax')
,(2,'5%',5,'Percentage','5%')
,(3,'7%',7,'Percentage','7%')
,(4,'14%',14,'Percentage','14%');

DELETE FROM `categories`;
INSERT  INTO `categories`(`id`,`parent_id`,`name`,`desc`,`status`) 
VALUES 
(1,0,'General','General',1)
,(2,0,'Vegetables','Vegetables',1)
,(3,0,'Food','Food',1)
,(4,0,'Drinks','Drinks',1)
,(5,1,'General Category','General Category',1)
,(6,2,'Vegetables','Vegetables',1);
DELETE FROM `products`;
INSERT INTO `products` (`id`, `name`, `desc`, `taxrate_id`, 
 `status`, `person_id`, `created_at`, `updated_at`)
 VALUES (1, 'Vegetable', 'dummy product', 1, 1, 1, '2014-08-13 10:42:59', '2014-08-13 10:43:02'); 
DELETE FROM `productprices`;
INSERT INTO `productprices` (`id`, `product_id`, `code`, `sku`,
  `supplier_id`, `dontsyncwithstock`, `status`, `created_at`, `updated_at`)
 VALUES (1, 1, 'DUMMY_PRD', 'DUMMY_PRD',
 1, 1, 1, '2014-08-13 10:42:59', '2014-08-13 10:43:02'); 
 DELETE FROM `productcategories`;
INSERT  INTO `productcategories`(`id`,`product_id`,`productprice_id`,`category_id`) 
VALUES 
(1,1,1,6);

DELETE FROM `tasks`;
INSERT INTO tasks VALUES 
(1, 1,'Structural Work','Structural Work')
,(2, 1,'Piling','Piling')
,(3, 1,'Painting','Painting')
,(4, 1,'Interior Deco','Interior decoration');

DELETE FROM `roles`;
INSERT INTO roles VALUES 
(1, 'SU','Super Admin', 0, 1, 0, '2014-02-11 08:02:58','2014-02-11 08:03:00')
,(2, 'Non_su','Non - Super Admin', 1, 1, 0, '2014-02-11 08:02:58','2014-02-11 08:03:00')
,(3, 'Admin','Admin', 10, 1, 1, '2014-02-11 08:02:58','2014-02-11 08:03:00')
,(4, 'Manager','Manager', 11, 1, 1, '2014-02-11 08:02:58','2014-02-11 08:03:00')
,(5, 'Employee','Employee', 12, 1, 1, '2014-02-11 08:02:58','2014-02-11 08:03:00')
,(6, 'Sales','Sales', 13, 1, 1, '2014-02-11 08:02:58','2014-02-11 08:03:00')
,(7, 'Customer','Customer', 1000, 1, 1, '2014-02-11 08:02:58','2014-02-11 08:03:00')
,(8, 'Supplier','Supplier', 1000, 1, 1, '2014-02-11 08:02:58','2014-02-11 08:03:00')
,(9, 'Contractor','Contractor', 1000, 1, 1, '2014-02-11 08:02:58','2014-02-11 08:03:00');
DELETE FROM `people`;
INSERT  INTO `people`(`id`,`name`,`firstname`,`lastname`,`mobile`,`status`,`enablelogin`,`created_at`,`updated_at`) 
values 
(1,'admin admin','admin','admin','9000',1,1,null,null),
(2,'salesemp1 salesemp1','salesemp1','salesemp1','9000',1,0,null,null),
(3,'salesemp2 salesemp2','salesemp2','salesemp2','9000',1,0,null,null),
(4,'Register1','Register1','Register1','9000',1,1,null,null),
(5,'Register2','Register1','Register2','9000',1,1,null,null),
(6,'Walk-in Customer','Walk-in Customer','Walk-in Customer','00000000',1,0,null,null);
DELETE FROM `logins`;
insert  into `logins`(`id`,`login`,`pass`,`hash_id`,`status`,`created_at`,`updated_at`) 
values 
(1,'su','d033e22ae348aeb5660fc2140aec35850c4da997','d033e22ae348aeb5660fc2140aec35850c4da997',1,null,null)
,(2,'admin','027a5a22d5890e87be8fcfe1d4ef2a98aa7f3133$d30bd965c0e92fae88258a8defa365ea415ed907','027a5a22d5890e87be8fcfe1d4ef2a98aa7f3133$d30bd965c0e92fae88258a8defa365ea415ed907',1,null,null)
,(3,'register1','c2e46f81b8d45cc2e2a384b40dc2903f5ad6df34$d30bd965c0e92fae88258a8defa365ea415ed907','c2e46f81b8d45cc2e2a384b40dc2903f5ad6df34$d30bd965c0e92fae88258a8defa365ea415ed907',1,null,null)
,(4,'register2','ec4f505f7ab3ac7605204113d8330f7f027fc800$d30bd965c0e92fae88258a8defa365ea415ed907','ec4f505f7ab3ac7605204113d8330f7f027fc800$d30bd965c0e92fae88258a8defa365ea415ed907',1,null,null);
DELETE FROM `personcompanyroles`;
INSERT INTO personcompanyroles(`id`,`person_id`,`company_id`,`role_id`,`login_id`,`status`,`created_at`,`updated_at`) 
VALUES 
(1, 0, 0, 1, 1, 1, null, null)
,(2, 1, 1, 3, 2, 1, null, null)
,(3, 2, 1, 6, 0, 1, null, null)
,(4, 3, 1, 6, 0, 1, null, null)
,(5, 4, 1, 6, 3, 1, null, null)
,(6, 5, 1, 6, 4, 1, null, null)
,(7, 6, 1, 7, 0, 1, null, null);
DELETE FROM `orders`;
INSERT  INTO `orders`(`id`,`type`,`qoi_id`,`quote_id`,`order_id`,`quote_qoi_id`,`order_qoi_id`,`name`,`desc`,`addnlinfo`,`addnlinfo1`,`start_at`,`end_at`,`budget`,`cost`,`amount`,`taxper`,`tax`,`discper`,`disc`,`tasks`,`completed`,`status`,`remarks`,`paid`,`qutcnvrtdate`,`ordcnvrtdate`,`started_at`,`closed_at`,`enableordername`,`enableordrprd`,`enableordrtasks`,`enableordrtaskpeople`,`enableordrpayments`,`enableordermilestones`,`ordercostamountfrom`,`ordertaskcostamountfrom`,`enablediscount`,`orderdiscfor`,`created_at`,`updated_at`) 
VALUES (1,'Order','dummy',0,0,'-1','-1','dummy','dummy','E',NULL,NULL,NULL,'0.00','0.00','0.00','0.00','0.00','0.00','0.00',0,'0.00',1,'test','0.00',NULL,NULL,NULL,NULL,0,0,1,0,1,1,2,0,0,0,NULL,NULL);
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
