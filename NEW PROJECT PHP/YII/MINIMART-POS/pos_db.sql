-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2014 at 07:14 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pos`
--

DROP DATABASE IF EXISTS pos;

CREATE DATABASE pos;

USE `pos`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL,
  `name` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'category name',
  `desc` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'description',
  `imagepath` varchar(1024) COLLATE utf8_bin DEFAULT NULL COMMENT 'image file path',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'status 1-active 0-inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `name` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'company name',
  `website` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'company website',
  `address` text COLLATE utf8_bin COMMENT 'company address',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'status 1-active 0-inactive',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`website`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `website`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 'PoS', 'pos.com', NULL, 1, '0000-00-00 00:00:00', '2014-10-10 13:07:09');

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `config_key` varchar(128) NOT NULL,
  `config_val` varchar(64) NOT NULL,
  `remarks` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`id`, `config_key`, `config_val`, `remarks`) VALUES
(1, 'enablepplcode', '1', '0-manual,1-auto'),
(2, 'enableautopplcode', '1', '0-manual,1-auto'),
(3, 'enableautocustcode', '0', '0-manual,1-auto'),
(4, 'enableautosplrcode', '0', '0-manual,1-auto'),
(5, 'enablepplauxname', '0', NULL),
(6, 'enablecontact', '0', NULL),
(7, 'enablelocality', '0', '1 - enable 0 - disable'),
(8, 'enablecity', '0', NULL),
(9, 'enablestate', '0', NULL),
(10, 'enablecountry', '0', NULL),
(11, 'directorder', '1', NULL),
(12, 'directinvoice', '0', NULL),
(13, 'moperinvoice', '0', '0-singleorder/invoice, 1-multiple'),
(14, 'daystocheckfordue', '3', NULL),
(15, 'daystocheckforoverdue', '7', NULL),
(16, 'enableautoordrid', '1', '0-manual,1-auto'),
(17, 'enableordername', '0', '0 - false,1 true'),
(18, 'enableordrdn', '0', '0-disable delivery note,1-enable'),
(19, 'ordercostamountfrom', '1', NULL),
(20, 'sptype', '1', '0-directamount,1-percentage'),
(21, 'enabletax', '1', '1-enable,0-disable'),
(22, 'enablediscount', '1', NULL),
(23, 'orderdiscfor', '3', '0-order,1-prd,2-task,3-orderandprd,4-orderandtask'),
(24, 'discentry', '0', '0 direct, 1 by reduced amount'),
(25, 'enableordrpeople', '0', '0 disable, 1 enable'),
(26, 'enableordrprd', '1', NULL),
(27, 'enablecategory', '1', NULL),
(28, 'enableprdcode', '1', '0-manual,1-auto'),
(29, 'enableautoprdcode', '0', '0-manual,1-auto'),
(30, 'enableprdauxname', '0', NULL),
(31, 'enablestock', '1', NULL),
(32, 'enablepurchase', '1', NULL),
(33, 'enableordrtasks', '0', NULL),
(34, 'enableinlineotentry', '0', NULL),
(35, 'enableexpctdstartdt', '0', '1 expected and actual st date ma'),
(36, 'enableexpctdenddt', '0', '0 - expected end dt false,1 true'),
(37, 'ordertaskcostamountfrom', '0', NULL),
(38, 'enableordrtaskpeople', '0', NULL),
(39, 'taskppltax', '0', NULL),
(40, 'enableordermilestones', '0', NULL),
(41, 'enableinlinemsentry', '0', '0-no inline,1-inline'),
(42, 'enableordrpayments', '1', NULL),
(43, 'enableinlinepayments', '0', '1-enable,0-disable'),
(44, 'accountamountfrom', '1', '0-from account,1-from order,2- from ordertask');

-- --------------------------------------------------------

--
-- Table structure for table `idmasters`
--

CREATE TABLE IF NOT EXISTS `idmasters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `forwhat` varchar(16) COLLATE utf8_bin NOT NULL,
  `foryear` varchar(8) COLLATE utf8_bin NOT NULL,
  `formonth` varchar(8) COLLATE utf8_bin NOT NULL,
  `lastid` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `idmasters`
--

INSERT INTO `idmasters` (`id`, `forwhat`, `foryear`, `formonth`, `lastid`, `created_at`, `updated_at`) VALUES
(1, 'Order', '2014', '10', 12, '2014-10-11 11:56:28', '2014-10-30 12:32:42'),
(2, 'Order', '2014', '11', 0, '2014-11-01 10:25:16', '2014-11-09 06:10:54');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `loginhistories`
--

CREATE TABLE IF NOT EXISTS `loginhistories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `login_time` datetime DEFAULT NULL COMMENT 'login time',
  `logout_time` datetime DEFAULT NULL COMMENT 'logout time',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE IF NOT EXISTS `logins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `login` varchar(24) COLLATE utf8_bin NOT NULL COMMENT 'user login name',
  `pass` varchar(88) COLLATE utf8_bin NOT NULL COMMENT 'user password',
  `hash_id` varchar(88) COLLATE utf8_bin NOT NULL COMMENT 'user unique hash for mobile authenticating',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'users status 1-active 0-inactive',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`id`, `login`, `pass`, `hash_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'su', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, '2014-10-10 13:05:49', '2014-10-10 13:05:49'),
(2, 'admin', '027a5a22d5890e87be8fcfe1d4ef2a98aa7f3133$d30bd965c0e92fae88258a8defa365ea415ed907', '027a5a22d5890e87be8fcfe1d4ef2a98aa7f3133$d30bd965c0e92fae88258a8defa365ea415ed907', 1, '2014-10-10 13:05:49', '2014-10-10 13:05:49'),
(3, 'register1', 'c2e46f81b8d45cc2e2a384b40dc2903f5ad6df34$d30bd965c0e92fae88258a8defa365ea415ed907', 'c2e46f81b8d45cc2e2a384b40dc2903f5ad6df34$d30bd965c0e92fae88258a8defa365ea415ed907', 1, '2014-10-10 13:05:49', '2014-10-10 13:05:49'),
(4, 'register2', 'ec4f505f7ab3ac7605204113d8330f7f027fc800$d30bd965c0e92fae88258a8defa365ea415ed907', 'ec4f505f7ab3ac7605204113d8330f7f027fc800$d30bd965c0e92fae88258a8defa365ea415ed907', 1, '2014-10-10 13:05:49', '2014-10-10 13:05:49');

-- --------------------------------------------------------

--
-- Table structure for table `masterproductcategories`
--

CREATE TABLE IF NOT EXISTS `masterproductcategories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `productprice_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orderactionhistories`
--

CREATE TABLE IF NOT EXISTS `orderactionhistories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `modifiedemp_id` int(10) unsigned NOT NULL,
  `action` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'happened action',
  `action_time` datetime DEFAULT NULL COMMENT 'happened time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orderaddresses`
--

CREATE TABLE IF NOT EXISTS `orderaddresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `name` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `mobile` varchar(16) COLLATE utf8_bin DEFAULT NULL,
  `type` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'From' COMMENT 'From/Pickup,Shipping/To/Delivery',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orderpeople`
--

CREATE TABLE IF NOT EXISTS `orderpeople` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `type` varchar(12) COLLATE utf8_bin NOT NULL COMMENT 'customer,employee, created, modified',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orderproductdns`
--

CREATE TABLE IF NOT EXISTS `orderproductdns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `order_id` int(10) unsigned NOT NULL,
  `orderproduct_id` int(10) unsigned NOT NULL,
  `quantity` int(10) NOT NULL,
  `delivered_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orderproducts`
--

CREATE TABLE IF NOT EXISTS `orderproducts` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ordertaskpeople`
--

CREATE TABLE IF NOT EXISTS `ordertaskpeople` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ordertasks`
--

CREATE TABLE IF NOT EXISTS `ordertasks` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `otprgrshistories`
--

CREATE TABLE IF NOT EXISTS `otprgrshistories` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `paymentreceipts`
--

CREATE TABLE IF NOT EXISTS `paymentreceipts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `customer_id` int(10) unsigned NOT NULL COMMENT 'customer id',
  `amount` decimal(10,2) DEFAULT NULL,
  `details` varchar(256) COLLATE utf8_bin DEFAULT NULL COMMENT 'some details if any',
  `paid_date` datetime DEFAULT NULL COMMENT 'paid date',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE IF NOT EXISTS `people` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=16 ;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `code`, `name`, `auxname`, `firstname`, `lastname`, `mobile`, `mail`, `website`, `mobile_addnls`, `fax`, `did`, `cost_center`, `devicetoken`, `commission`, `mhcost`, `mhrate`, `geo_update_frq`, `work_hour_start`, `work_hour_end`, `status`, `enablelogin`, `enablepplcode`, `enablecontact`, `enablepplauxname`, `register_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 'admin admin', NULL, 'admin', 'admin', '9000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0.00', '0.00', 15, 0, 0, 1, 1, 1, 0, 0, NULL, '2014-10-10 13:05:49', '2014-10-10 13:05:49'),
(2, NULL, 'salesemp1 salesemp1', NULL, 'salesemp1', 'salesemp1', '9000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0.00', '0.00', 15, 0, 0, 1, 0, 1, 0, 0, NULL, '2014-10-10 13:05:49', '2014-10-10 13:05:49'),
(3, NULL, 'salesemp2 salesemp2', NULL, 'salesemp2', 'salesemp2', '9000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0.00', '0.00', 15, 0, 0, 1, 0, 1, 0, 0, NULL, '2014-10-10 13:05:49', '2014-10-10 13:05:49'),
(4, NULL, 'Register1', NULL, 'Register1', 'Register1', '9000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0.00', '0.00', 15, 0, 0, 1, 1, 1, 0, 0, NULL, '2014-10-10 13:05:49', '2014-10-10 13:05:49'),
(5, NULL, 'Register2', NULL, 'Register1', 'Register2', '9000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0.00', '0.00', 15, 0, 0, 1, 1, 1, 0, 0, NULL, '2014-10-10 13:05:49', '2014-10-10 13:05:49'),
(6, NULL, 'Walk-in Customer', NULL, 'abc', 'Walk-in Customer', '6000000', '', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0.00', '0.00', 15, 0, 0, 1, 0, 1, 1, 0, NULL, '2014-10-10 13:05:49', '2014-11-03 06:07:44');
-- --------------------------------------------------------

--
-- Table structure for table `personaddresses`
--

CREATE TABLE IF NOT EXISTS `personaddresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `type` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'office' COMMENT 'office,residence,other',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `personcompanyroles`
--

CREATE TABLE IF NOT EXISTS `personcompanyroles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `person_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `login_id` int(10) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'status 1-active 0-inactive',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'maintenance field',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'maintenance field',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=17 ;

--
-- Dumping data for table `personcompanyroles`
--

INSERT INTO `personcompanyroles` (`id`, `person_id`, `company_id`, `role_id`, `login_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 1, 1, 1, '2014-10-10 13:05:50', '2014-10-10 13:05:50'),
(2, 1, 1, 3, 2, 1, '2014-10-10 13:05:50', '2014-10-10 13:05:50'),
(3, 2, 1, 6, 0, 1, '2014-10-10 13:05:50', '2014-10-10 13:05:50'),
(4, 3, 1, 6, 0, 1, '2014-10-10 13:05:50', '2014-10-10 13:05:50'),
(5, 4, 1, 6, 3, 1, '2014-10-10 13:05:50', '2014-10-10 13:05:50'),
(6, 5, 1, 6, 4, 1, '2014-10-10 13:05:50', '2014-10-10 13:05:50'),
(7, 6, 1, 7, 0, 1, '2014-10-10 13:05:50', '2014-11-03 06:07:44');

-- --------------------------------------------------------

--
-- Table structure for table `poslogreport`
--

CREATE TABLE IF NOT EXISTS `poslogreport` (
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `previous_stock` int(11) NOT NULL,
  `current_stock` int(11) NOT NULL,
  `sold_out` int(11) NOT NULL,
  `today_purchase` int(11) NOT NULL,
  `rtn_product_quantity` INT NOT NULL DEFAULT '0',
  `stock_adjustment` INT NOT NULL DEFAULT '0',
  `current_aval_stock` int(11) NOT NULL,
  `log_status` int(11) NOT NULL,
  `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `productcategories`
--

CREATE TABLE IF NOT EXISTS `productcategories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `productprice_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `productprices`
--

CREATE TABLE IF NOT EXISTS `productprices` (
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
  `stockinhand` int(10) DEFAULT '0',
  `expdate` date DEFAULT NULL,
  `invno` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `invdate` date DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `productstockhistories`
--

CREATE TABLE IF NOT EXISTS `productstockhistories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `productprice_id` int(10) unsigned NOT NULL,
  `updationdate` datetime DEFAULT NULL COMMENT 'stock update date',
  `beforeupdation` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'before updation',
  `updatedqnty` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'updated quantity',
  `afterupdation` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'before updation',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseproducts`
--

CREATE TABLE IF NOT EXISTS `purchaseproducts` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE IF NOT EXISTS `purchases` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `registers`
--

CREATE TABLE IF NOT EXISTS `registers` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `desc`, `level`, `status`, `iscompany`, `created_at`, `updated_at`) VALUES
(1, 'SU', 'Super Admin', 0, 1, 0, '2014-02-11 02:32:58', '2014-02-11 02:33:00'),
(2, 'Non_su', 'Non - Super Admin', 1, 1, 0, '2014-02-11 02:32:58', '2014-02-11 02:33:00'),
(3, 'Admin', 'Admin', 10, 1, 1, '2014-02-11 02:32:58', '2014-02-11 02:33:00'),
(4, 'Manager', 'Manager', 11, 1, 1, '2014-02-11 02:32:58', '2014-02-11 02:33:00'),
(5, 'Employee', 'Employee', 12, 1, 1, '2014-02-11 02:32:58', '2014-02-11 02:33:00'),
(6, 'Sales', 'Sales', 13, 1, 1, '2014-02-11 02:32:58', '2014-02-11 02:33:00'),
(7, 'Customer', 'Customer', 1000, 1, 1, '2014-02-11 02:32:58', '2014-02-11 02:33:00'),
(8, 'Supplier', 'Supplier', 1000, 1, 1, '2014-02-11 02:32:58', '2014-02-11 02:33:00'),
(9, 'Contractor', 'Contractor', 1000, 1, 1, '2014-02-11 02:32:58', '2014-02-11 02:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `statushistories`
--

CREATE TABLE IF NOT EXISTS `statushistories` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `statusmasters`
--

CREATE TABLE IF NOT EXISTS `statusmasters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ofwhich` int(10) unsigned NOT NULL COMMENT 'this row is a astatus for this field',
  `name` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'status name',
  `display` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'display string',
  `desc` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'description',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=14 ;

--
-- Dumping data for table `statusmasters`
--

INSERT INTO `statusmasters` (`id`, `ofwhich`, `name`, `display`, `desc`) VALUES
(1, 1, 'OPEN', 'OPEN', 'for orders'),
(2, 1, 'PENDING', 'PENDING', 'for orders'),
(3, 1, 'CLOSED', 'CLOSED', 'for orders'),
(4, 1, 'REFUNDOLD', 'REFUNDOLD', 'for orders'),
(5, 1, 'REFUNDNEW', 'REFUNDNEW', 'for orders'),
(6, 1, 'CANCELOLD', 'CANCELOLD', 'for orders'),
(7, 1, 'CANCELNEW', 'CANCELNEW', 'for orders'),
(8, 1, 'EXCHANGEOLD', 'EXCHANGEOLD', 'for orders'),
(9, 1, 'EXCHANGENEW', 'EXCHANGENEW', 'for orders'),
(10, 1, 'DELIVERED', 'DELIVERED', 'for orders'),
(11, 2, 'OPEN', 'OPEN', 'for ordertasks'),
(12, 2, 'PENDING', 'PENDING', 'for ordertasks'),
(13, 2, 'CLOSED', 'CLOSED', 'for ordertasks');

-- --------------------------------------------------------

--
-- Table structure for table `subproductprices`
--

CREATE TABLE IF NOT EXISTS `subproductprices` (
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
  `initial_stock` int(11) NOT NULL DEFAULT '0',
  `imagepath` varchar(255) COLLATE utf8_bin NOT NULL,
  `invno` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `invdate` date DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `taxrates`
--

CREATE TABLE IF NOT EXISTS `taxrates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `taxname` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'tax name',
  `taxrate` decimal(10,2) DEFAULT '0.00' COMMENT 'either % or fixed',
  `taxtype` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'Percentage, Fixed',
  `remarks` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'remarks',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Dumping data for table `taxrates`
--

INSERT INTO `taxrates` (`id`, `taxname`, `taxrate`, `taxtype`, `remarks`) VALUES
(1, 'No Tax', '0.00', 'Percentage', 'No tax'),
(2, '5%', '5.00', 'Percentage', '5%'),
(3, '7%', '7.00', 'Percentage', '7%'),
(4, '14%', '14.00', 'Percentage', '14%');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


CREATE TABLE IF NOT EXISTS `stockadjustment`(sno int NOT NULL AUTO_INCREMENT PRIMARY KEY, referenceno varchar(30), dateofadjustment date, product_id int(5), code varchar(30), sku varchar(30), stock int default 0, stock_adjustment int default 0, Remarks text)

