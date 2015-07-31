DELETE FROM `companies`;
INSERT INTO companies (id, `name`, `website`, `status`) 
VALUES 
(1, 'FTZ', 'FTZ.com',1);
DELETE FROM `configs`;
insert  into `configs`(`id`,`config_key`,`config_val`,`remarks`) 
values 
(1,'enablepplcode','0','0-manual,1-auto')
,(2,'enableautopplcode','1','0-manual,1-auto')
,(3,'enableautocustcode','1','0-manual,1-auto')
,(4,'enableautosplrcode','1','0-manual,1-auto')
,(5,'enablepplauxname','0',NULL)
,(6,'enablecontact','1',NULL)
,(7,'enablelocality','0','1 - enable 0 - disable')
,(8,'enablecity','0',NULL)
,(9,'enablestate','0',NULL)
,(10,'enablecountry','0',NULL)

,(11,'directorder','1',NULL)
,(12,'directinvoice','1',NULL)
,(13,'moperinvoice','0','0-singleorder/invoice, 1-multiple')
,(14,'daystocheckfordue','3',NULL)
,(15,'daystocheckforoverdue','7',NULL)

,(16,'enableautoordrid','0','0-manual,1-auto')
,(17,'enableordername','1','0 - false,1 true')
,(18,'enableordrdn','1','0-disable delivery note,1-enable')
,(19,'ordercostamountfrom','2','0-order,1-orderproduct,2-ordertask')
,(20,'sptype','0','0-directamount,1-percentage')
,(21,'enabletax','0','1-enable,0-disable')
,(22,'enablediscount','0',NULL)
,(23,'orderdiscfor','0','0-order,1-prd,2-task,3-orderandprd,4-orderandtask')
,(24,'discentry','0','0 direct, 1 by reduced amount')
,(25,'enableordrpeople','0','0 disable, 1 enable')

,(26,'enableordrprd','0',NULL)
,(27,'enablecategory','0',NULL)
,(28,'enableprdcode','0','0-manual,1-auto')
,(29,'enableautoprdcode','0','0-manual,1-auto')
,(30,'enableprdauxname','0',NULL)
,(31,'enablestock','0',NULL)
,(32,'enablepurchase','0',NULL)

,(33,'enableordrtasks','1',NULL)
,(34,'enableinlineotentry','1',NULL)
,(35,'enableexpctdstartdt','1','1 expected and actual st date ma')
,(36,'enableexpctdenddt','1','0 - expected end dt false,1 true')
,(37,'ordertaskcostamountfrom','0','0-ordertask,1-taskpeople')
,(38,'enableordrtaskpeople','0',NULL)
,(39,'taskppltax','0',NULL)

,(40,'enableordermilestones','1',NULL)
,(41,'enableinlinemsentry','0','0-no inline,1-inline')

,(42,'enableordrpayments','1',NULL)
,(43,'enableinlinepayments','0','1-enable,0-disable')
,(44,'accountamountfrom','0','0-from account,1-from order,2- from ordertask');

DELETE FROM `statusmasters`;
insert  into `statusmasters`(`id`,`ofwhich`,`name`,`display`,`desc`) 
values 
(1,1,'OPEN','OPEN','for orders')
,(2,1,'PENDING','PENDING','for orders')
,(3,1,'CLOSED','CLOSED','for orders')
,(4,2,'OPEN','OPEN','for ordertasks')
,(5,2,'PENDING','PENDING','for ordertasks')
,(6,2,'CLOSED','CLOSED','for ordertasks');