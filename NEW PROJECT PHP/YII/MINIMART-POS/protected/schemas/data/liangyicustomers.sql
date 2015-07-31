USE `liangyi`;
delete from `people` where `type` = 'customer';
insert  into `people`(`type`,`code`,`name`,`auxname`,`mobile`,`mobile_addnls`,`fax`,`enablepplauxname`,`created_at`,`updated_at`)
SELECT 'customer', CUSTOMER_ID, FIRST_NAME, NULL, PHONE_NO, HAND_PHONE, FAX_NO, 1, NULL, NULL
FROM `customer_details`;
/* CONCAT('Block : ',`BLOCK`,', ',`STREET`), PINCODE, */