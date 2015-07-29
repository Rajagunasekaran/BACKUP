/*
SQLyog Ultimate v9.30 
MySQL - 5.5.27 : Database - alliancecr
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`alliancecr` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `alliancecr`;

DELETE FROM `categories`;
insert  into `categories`(`id`,`parent_id`,`name`,`desc`) 
values 
(1,0,'General','General')
,(2,0,'veg','Vegitarian')
,(3,0,'non-veg','Non-Vegitarian');
DELETE FROM `tasks`;
INSERT INTO tasks VALUES 
(1, 1,'Structural Work','Structural Work')
,(2, 1,'Piling','Piling')
,(3, 1,'Painting','Painting')
,(4, 1,'Interior Deco','Interior decoration');
DELETE FROM `roles`;
INSERT INTO roles VALUES 
(1, 'SU','Super Admin', 0, 1, 1,'2014-02-11 08:02:58','2014-02-11 08:03:00')
,(2, 'Non_su','Non - Super Admin', 1, 1,'2014-02-11 08:02:58','2014-02-11 08:03:00')
,(3, 'Admin','Admin', 10, 1, 1,'2014-02-11 08:02:58','2014-02-11 08:03:00')
,(4, 'Manager','Manager', 11, 1, 1,'2014-02-11 08:02:58','2014-02-11 08:03:00')
,(5, 'Employee','Employee', 12, 1, 1,'2014-02-11 08:02:58','2014-02-11 08:03:00')
,(6, 'Customer','Customer', 1000, 1, 1,'2014-02-11 08:02:58','2014-02-11 08:03:00')
,(7, 'Supplier','Supplier', 1000, 1, 1,'2014-02-11 08:02:58','2014-02-11 08:03:00')
,(8, 'Contractor','Contractor', 1000, 1, 1,'2014-02-11 08:02:58','2014-02-11 08:03:00');
DELETE FROM `people`;
INSERT  INTO `people`(`id`,`name`,`firstname`,`lastname`,`mobile`,`status`,`enablelogin`,`created_at`,`updated_at`) 
values 
(1,'admin admin','admin','admin','9000',1,1,null,null);
DELETE FROM `logins`;
insert  into `logins`(`id`,`login`,`pass`,`hash_id`,`status`,`created_at`,`updated_at`) 
values 
(1,'su','d033e22ae348aeb5660fc2140aec35850c4da997','d033e22ae348aeb5660fc2140aec35850c4da997',1,null,null)
,(2,'admin','027a5a22d5890e87be8fcfe1d4ef2a98aa7f3133$d30bd965c0e92fae88258a8defa365ea415ed907','027a5a22d5890e87be8fcfe1d4ef2a98aa7f3133$d30bd965c0e92fae88258a8defa365ea415ed907',1,null,null);
DELETE FROM `personcompanyroles`;
INSERT INTO personcompanyroles(`id`,`person_id`,`company_id`,`role_id`,`login_id`,`status`,`created_at`,`updated_at`) 
VALUES 
(1, 0, 0, 1, 1, 1, null, null)
,(2, 1, 1, 3, 2, 1, null, null);
DELETE FROM `orders`;
INSERT  INTO `orders`(`id`,`type`,`qoi_id`,`quote_id`,`order_id`,`quote_qoi_id`,`order_qoi_id`,`name`,`desc`,`addnlinfo`,`addnlinfo1`,`start_at`,`end_at`,`budget`,`cost`,`amount`,`taxper`,`tax`,`discper`,`disc`,`tasks`,`completed`,`status`,`remarks`,`paid`,`qutcnvrtdate`,`ordcnvrtdate`,`started_at`,`closed_at`,`enableordername`,`enableordrprd`,`enableordrtasks`,`enableordrtaskpeople`,`enableordrpayments`,`enableordermilestones`,`ordercostamountfrom`,`ordertaskcostamountfrom`,`enablediscount`,`orderdiscfor`,`created_at`,`updated_at`) 
VALUES (1,'Order','dummy',0,0,'-1','-1','dummy','dummy','E',NULL,NULL,NULL,'0.00','0.00','0.00','0.00','0.00','0.00','0.00',0,'0.00',1,'test','0.00',NULL,NULL,NULL,NULL,0,0,1,0,1,1,2,0,0,0,NULL,NULL);
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
