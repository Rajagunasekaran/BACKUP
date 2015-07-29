DROP PROCEDURE IF EXISTS SP_ACCESS_CARD_UPDATE;
CREATE PROCEDURE SP_ACCESS_CARD_UPDATE(IN CUSTOMERID INTEGER,IN CARDNUMBER INTEGER,IN REASON TEXT,IN COMMENTS TEXT,IN USERSTAMP VARCHAR(50),OUT CARD_UPDATE_FLAG INTEGER)
BEGIN
DECLARE TICK_COMMENTS_OLD_VALUE TEXT;
DECLARE TICK_COMMENTS_NEW_VALUE TEXT;
DECLARE TICK_ACCESS_OLD_VALUE TEXT;
DECLARE TICK_ACCESS_NEW_VALUE TEXT;
DECLARE OLD_COMMENTS TEXT;
DECLARE USERSTAMP_ID INTEGER(2);
DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN 
ROLLBACK; 
END; 
START TRANSACTION;
SET CARD_UPDATE_FLAG=0;
CALL SP_CHANGE_USERSTAMP_AS_ULDID(USERSTAMP,@ULDID);
SET USERSTAMP_ID =(SELECT @ULDID);
SET OLD_COMMENTS=(SELECT CPD_COMMENTS FROM CUSTOMER_PERSONAL_DETAILS WHERE CUSTOMER_ID=CUSTOMERID);
IF(OLD_COMMENTS!=COMMENTS)THEN
SET TICK_COMMENTS_OLD_VALUE=(SELECT CONCAT('CPD_COMMENTS=',OLD_COMMENTS));
SET TICK_COMMENTS_NEW_VALUE=(SELECT CONCAT('CPD_COMMENTS=',COMMENTS));
INSERT INTO TICKLER_HISTORY(TP_ID,TTIP_ID,TH_OLD_VALUE,TH_NEW_VALUE,ULD_ID,CUSTOMER_ID)VALUES((SELECT TP_ID FROM TICKLER_PROFILE WHERE TP_TYPE='UPDATION'),(SELECT TTIP_ID FROM TICKLER_TABID_PROFILE WHERE TTIP_DATA='CUSTOMER_PERSONAL_DETAILS'),TICK_COMMENTS_OLD_VALUE,TICK_COMMENTS_NEW_VALUE,USERSTAMP_ID,CUSTOMERID);
END IF;
UPDATE CUSTOMER_PERSONAL_DETAILS SET CPD_COMMENTS=COMMENTS WHERE CUSTOMER_ID=CUSTOMERID; 
SET CARD_UPDATE_FLAG=1;
SET TICK_ACCESS_OLD_VALUE=(SELECT CONCAT('UASD_ID=',(SELECT UASD_ID FROM UNIT_ACCESS_STAMP_DETAILS WHERE UASD_ACCESS_CARD=CARDNUMBER),',ACN_ID=',(select ACN_ID from CUSTOMER_ACCESS_CARD_DETAILS where CUSTOMER_ID=CUSTOMERID AND UASD_ID IN (SELECT UASD_ID FROM UNIT_ACCESS_STAMP_DETAILS WHERE UASD_ACCESS_CARD=CARDNUMBER) AND  ACN_ID!=4 )));
SET TICK_ACCESS_NEW_VALUE=(SELECT CONCAT('ACN_ID=',(SELECT ACN_ID FROM ACCESS_CONFIGURATION WHERE ACN_DATA=REASON)));
INSERT INTO TICKLER_HISTORY(TP_ID,TTIP_ID,TH_OLD_VALUE,TH_NEW_VALUE,ULD_ID,CUSTOMER_ID)VALUES((SELECT TP_ID FROM TICKLER_PROFILE WHERE TP_TYPE='UPDATION'),(SELECT TTIP_ID FROM TICKLER_TABID_PROFILE WHERE TTIP_DATA='CUSTOMER_ACCESS_CARD_DETAILS'),TICK_ACCESS_OLD_VALUE,TICK_ACCESS_NEW_VALUE,USERSTAMP_ID,CUSTOMERID);
UPDATE CUSTOMER_ACCESS_CARD_DETAILS SET ACN_ID=(SELECT ACN_ID FROM ACCESS_CONFIGURATION WHERE ACN_DATA=REASON)WHERE UASD_ID=(SELECT UASD_ID FROM UNIT_ACCESS_STAMP_DETAILS WHERE UASD_ACCESS_CARD=CARDNUMBER)AND CUSTOMER_ID=CUSTOMERID AND ACN_ID!=4; 
SET CARD_UPDATE_FLAG=1;
COMMIT; 
END;