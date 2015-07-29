SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ALEX_FLOCH' AND RENTAL_FOR_PERIOD='2014-03-01';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='CIARON_PATRICK MCKINLEY' AND RENTAL_FOR_PERIOD='2013-07-01';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ETSUKO' AND RENTAL_FOR_PERIOD='2011-10-01';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='MATTHEW_KERR' AND RENTAL_FOR_PERIOD='2013-08-01';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='MIKE_DELA CUESTA' AND RENTAL_FOR_PERIOD='2012-05-01';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='OLIVER' AND RENTAL_FOR_PERIOD='2013-05-01';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='RAJNEESH_JHAWAR' AND RENTAL_FOR_PERIOD='2012-12-01';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='SAPIENT CONSULTING_GUNJAN DUA' AND RENTAL_FOR_PERIOD='2013-03-01';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='SAPIENT CONSULTING_GUNJAN DUA' AND RENTAL_FOR_PERIOD='2013-02-01';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='TOMOKO_NASUHO' AND RENTAL_FOR_PERIOD='2013-10-01';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='NIRAJ_NAGPAL' AND RENTAL_FOR_PERIOD='2014-02-01';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='SAPIENT CONSULTING' AND RENTAL_FOR_PERIOD='2012-04-01';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='MIKE'  AND RENTAL_FOR_PERIOD='2011-04-01';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='MT_MARINE'  AND RENTAL_FOR_PERIOD='2013-05-01';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ELEONORA_FALCONE'  AND RENTAL_FOR_PERIOD IN ('2013-12-01');
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='RAE MUN_ONG'  AND RENTAL_FOR_PERIOD =('2013-12-01');

SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='JONATHAN_ZUO';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='MARCEL';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='RICHARD_WU';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='SAPIENT CONSULTING_EMILY';
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='YOGESH'; 
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='LISA_MAHTANI'; 
SELECT*FROM SCDB_SOURCE_23062014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='SAPIENT CONSULTING_EMILY'; 


SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=361;
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=129;
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=169;
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=225;
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=230;
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=249;
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=295;
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=364;

DELETE FROM RENTAL_SCDB_FORMAT WHERE RENTAL_ID=752;
DELETE FROM RENTAL_SCDB_FORMAT WHERE RENTAL_ID=2434;
DELETE FROM RENTAL_SCDB_FORMAT WHERE RENTAL_ID=3197;

UPDATE RENTAL_SCDB_FORMAT SET RENTAL_PROCESSING_FEE=1200 WHERE RENTAL_ID=738;
UPDATE RENTAL_SCDB_FORMAT SET RENTAL_DEPOSIT =3300 WHERE RENTAL_ID=980;
UPDATE RENTAL_SCDB_FORMAT SET RENTAL_DEPOSIT =NULL, RENTAL_AMOUNT=4300 WHERE RENTAL_ID=3262;

SELECT*FROM CUSTOMER_LP_DETAILS WHERE CUSTOMER_ID=440;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='RAE MUN_ONG';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=440;

SELECT*FROM CUSTOMER_LP_DETAILS WHERE CUSTOMER_ID=364;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='LISA_MAHTANI';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=364;

SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=1;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='AARTI';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=465;
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=2;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ABBHINAV';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=3;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='DAIMLER_ADINA';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=6;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='AKHIL_DUTT';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=7;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='AKIMA';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=8;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ALAGAPPAN_MEENAKSHISUNDARAM';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=9;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ALESSANDRO';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=10;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ALEX_FLOCH';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=11;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ALEX';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=12;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ALEX_SMALL';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=13;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ALEXANDER_BRUNOW';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=14;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ALEXANDRA_LAMBERT';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=15;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ALI';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=16;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ALI_SAFRAZ';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=18;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='AMBER';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=19;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='AMIT';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=20;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='AMY_MORRIS';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=22;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ANDRE_METHOD';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=23;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ANDY_CHI';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=124;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='JIKEE_KUK';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=172;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='MARK';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=180;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='MATTHEW_KERR';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=252;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='SAPIENT CONSULTING_GUNJAN DUA';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=278;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='THOMAS_SAILORS';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=282;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='TOBIAS';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=283;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='TOMOKO_NASUHO';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=473;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='CROSS_BARRY MARTIN';
SELECT*FROM PAYMENT_DETAILS WHERE CUSTOMER_ID=479;
SELECT*FROM SOURCE_07072014.RENTAL_SCDB_FORMAT WHERE RENTAL_CUSTOMER='ANDREAS_KLEINER';

--

SELECT*FROM EXPENSE_PETTY_CASH WHERE EPC_ID IN (450);
SELECT*FROM EXPENSE_UNIT WHERE EU_ID=84;
SELECT*FROM SOURCE_28062014.BIZ_DAILY_SCDB_FORMAT WHERE EXPENSE_ID IN (5677,5720);
SELECT*FROM EXPENSE_UNIT;
SELECT*FROM EXPENSE_STARHUB;

SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=32;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=44;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=60;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=79;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=144;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=202;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=218;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=282;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=375;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=503;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=659;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=897;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=898;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=935;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=969;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=981;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=1029;
SELECT*FROM EXPENSE_STARHUB WHERE ESH_ID=1057;

--

DROP TABLE OCBC_BANK_RECORDS;
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE OCBC_CONFIGURATION;

--

SELECT*FROM UNIT_DETAILS;
SELECT U.UNIT_NO,UD.UNIT_ID, UD.UD_START_DATE,UD.UD_END_DATE 
FROM UNIT U, UNIT_DETAILS UD WHERE U.UNIT_ID = UD.UD_ID;

UPDATE UNIT_DETAILS SET UD_START_DATE = '2011-04-01' WHERE UNIT_ID = 3;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2012-11-09' WHERE UNIT_ID = 4;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2010-11-01' WHERE UNIT_ID = 5;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2011-07-01' WHERE UNIT_ID = 6;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2010-08-02' WHERE UNIT_ID = 7;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2010-06-01' WHERE UNIT_ID = 8;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2012-02-01' WHERE UNIT_ID = 10;

UPDATE UNIT_DETAILS SET UD_START_DATE = '2010-04-03' WHERE UNIT_ID = 11;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2012-07-01' WHERE UNIT_ID = 13;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2011-04-09' WHERE UNIT_ID = 14;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2010-02-10' WHERE UNIT_ID = 15;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2010-03-23' WHERE UNIT_ID = 16;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2011-12-24' WHERE UNIT_ID = 17;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2010-02-01' WHERE UNIT_ID = 18;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2009-12-01' WHERE UNIT_ID = 19;

UPDATE UNIT_DETAILS SET UD_START_DATE = '2009-12-01' WHERE UNIT_ID = 21;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2010-09-01' WHERE UNIT_ID = 22;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2009-02-01' WHERE UNIT_ID = 23;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2013-04-29' WHERE UNIT_ID = 24;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2010-01-01' WHERE UNIT_ID = 25;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2009-02-01' WHERE UNIT_ID = 26;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2011-05-19' WHERE UNIT_ID = 27;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2011-07-13' WHERE UNIT_ID = 28;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2010-03-01' WHERE UNIT_ID = 30;

UPDATE UNIT_DETAILS SET UD_START_DATE = '2010-02-01' WHERE UNIT_ID = 31;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2010-03-08' WHERE UNIT_ID = 32;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2010-02-01' WHERE UNIT_ID = 33;
UPDATE UNIT_DETAILS SET UD_END_DATE = '2014-10-31' WHERE UNIT_ID = 34;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2008-07-28' WHERE UNIT_ID = 35;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2011-01-01' WHERE UNIT_ID = 36;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2011-11-19' WHERE UNIT_ID = 39;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2012-05-11' WHERE UNIT_ID = 40;

UPDATE UNIT_DETAILS SET UD_START_DATE = '2010-03-11' WHERE UNIT_ID = 41;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2011-04-10' WHERE UNIT_ID = 42;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2010-06-01' WHERE UNIT_ID = 43;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2012-06-21' WHERE UNIT_ID = 44;
UPDATE UNIT_DETAILS SET UD_START_DATE = '2013-04-15' WHERE UNIT_ID = 45;
UPDATE UNIT_DETAILS SET UD_START_DATE = '1969-11-19',UD_END_DATE='2020-12-31' WHERE UNIT_ID = 46;

--

SELECT*FROM OCBC_BANK_RECORDS;

INSERT INTO `OCBC_BANK_RECORDS` (`OBR_ID`, `OBR_ACCOUNT_NUMBER`, `OBR_CURRENCY`, `OBR_PREVIOUS_BALANCE`, `OBR_OPENING_BALANCE`, `OBR_CLOSING_BALANCE`, `OBR_LAST_BALANCE`, `OBR_NO_OF_CREDITS`, `OBR_OLD_BALANCE`, `OBR_NO_OF_DEBITS`, `OBR_TRANS_DATE`, `OBR_D_AMOUNT`, `OBR_POST_DATE`, `OBR_VALUE_DATE`, `OBR_DEBIT_AMOUNT`, `OBR_CREDIT_AMOUNT`, `OCN_ID`, `OBR_CLIENT_REFERENCE`, `OBR_TRANSACTION_DESC_DETAILS`, `OBR_BANK_REFERENCE`, `OBR_TRX_TYPE`, `OBR_REF_ID`, `OBR_REFERENCE`, `ULD_ID`, `OBR_TIMESTAMP`) VALUES
	(4275, 3, 2, 255087.58, 252837.58, 252837.58, 8050.00, 5, 10300.00, 0.00, '2013-04-15', 2, '2013-04-15', '2013-04-15', 0.00, 500.00, 6, 'AARON 1218-PF', 'CASH DEPOSIT', 'NONREF', NULL, NULL, 'X', 3, '2013-04-16 04:43:10'),
	(4276, 3, 2, 185436.39, 194561.99, 194561.99, 12326.00, 6, 3200.40, 0.00, '2012-11-27', 4, '2012-11-27', '2012-11-27', 0.00, 2600.00, 6, '- SAIL 29-18', 'SI                                                                GIRO-IBG', 'AUSTIN SIMON JOH', NULL, NULL, NULL, 2, '2013-03-18 01:58:00');

UPDATE OCBC_BANK_RECORDS SET OBR_ACCOUNT_NUMBER=3,OBR_CURRENCY=2,OBR_PREVIOUS_BALANCE=87,OCN_ID=7 WHERE OBR_ID=4276;