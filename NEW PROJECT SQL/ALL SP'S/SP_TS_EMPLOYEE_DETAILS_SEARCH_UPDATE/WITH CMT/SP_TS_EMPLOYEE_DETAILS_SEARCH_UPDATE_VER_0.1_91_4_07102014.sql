-- VERSION 0.1 STARTDATE:06/10/2014 ENDDATE:07/10/2014 ISSUE NO:91 COMMENT NO:4 DESC:SP FOR UPDATE EMPLOYEE DETAILS FOLLOWED BY COMPANY PROPERTIES DETAILS. DONE BY: RAJA
DROP PROCEDURE IF EXISTS SP_TS_EMPLOYEE_DETAILS_SEARCH_UPDATE;
CREATE PROCEDURE SP_TS_EMPLOYEE_DETAILS_SEARCH_UPDATE(
IN EMPID INT,
IN FIRST_NAME CHAR(30),
IN LAST_NAME CHAR(30),
IN DOB DATE,
IN DESIGNATION VARCHAR(20),
IN MOBILE_NUMBER VARCHAR(10),
IN NEXT_KIN_NAME CHAR(30),
IN RELATIONHOOD CHAR(30),
IN ALT_MOBILE_NO VARCHAR(10),
IN LAPTOP_NUMBER VARCHAR(25),
IN CHARGER_NUMBER VARCHAR(25),
IN LAPTOP_BAG CHAR(1),
IN MOUSE CHAR(1),
IN DOOR_ACCESS CHAR(1),
IN ID_CARD CHAR(1),
IN HEADSET CHAR(1),
IN USERSTAMP VARCHAR(50),
OUT SUCCESS_FLAG INT)
BEGIN
	DECLARE USERSTAMP_ID INT;
	DECLARE CPDID INT;
	DECLARE OLDEMPID INT;
	DECLARE OLDFIRST_NAME CHAR(30);
	DECLARE OLDLAST_NAME CHAR(30);
	DECLARE OLDDOB DATE;
	DECLARE OLDDESIGNATION VARCHAR(20);
	DECLARE OLDMOBILE_NUMBER VARCHAR(10);
	DECLARE OLDNEXT_KIN_NAME CHAR(30);
	DECLARE OLDRELATIONHOOD CHAR(30);
	DECLARE OLDALT_MOBILE_NO VARCHAR(10);
	DECLARE OLDLAPTOP_NUMBER VARCHAR(25);
	DECLARE OLDCHARGER_NUMBER VARCHAR(25);
	DECLARE OLDLAPTOP_BAG CHAR(1);
	DECLARE OLDMOUSE CHAR(1);
	DECLARE OLDDOOR_ACCESS CHAR(1);
	DECLARE OLDID_CARD CHAR(1);
	DECLARE OLDHEADSET CHAR(1);
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;
		SET SUCCESS_FLAG=0;
	END;
	START TRANSACTION;
	IF(LAPTOP_NUMBER='')THEN
		SET LAPTOP_NUMBER=NULL;
	END IF;
	IF(CHARGER_NUMBER='')THEN
		SET CHARGER_NUMBER=NULL;
	END IF;
	IF(LAPTOP_BAG='')THEN
		SET LAPTOP_BAG=NULL;
	END IF;
	IF(MOUSE='')THEN
		SET MOUSE=NULL;
	END IF;
	IF(DOOR_ACCESS='')THEN
		SET DOOR_ACCESS=NULL;
	END IF;
	IF(ID_CARD='')THEN
		SET ID_CARD=NULL;
	END IF;
	IF(HEADSET='')THEN
		SET HEADSET=NULL;
	END IF;
	CALL SP_TS_CHANGE_USERSTAMP_AS_ULDID(USERSTAMP,@ULD_ID);
	SET USERSTAMP_ID=@ULD_ID;
	SET SUCCESS_FLAG=0;

	SET OLDFIRST_NAME=(SELECT EMP_FIRST_NAME FROM EMPLOYEE_DETAILS WHERE EMP_ID=EMPID);
	SET OLDLAST_NAME=(SELECT EMP_LAST_NAME FROM EMPLOYEE_DETAILS WHERE EMP_ID=EMPID);
	SET OLDDOB=(SELECT EMP_DOB FROM EMPLOYEE_DETAILS WHERE EMP_ID=EMPID);
	SET OLDDESIGNATION=(SELECT EMP_DESIGNATION FROM EMPLOYEE_DETAILS WHERE EMP_ID=EMPID);
	SET OLDMOBILE_NUMBER=(SELECT EMP_MOBILE_NUMBER FROM EMPLOYEE_DETAILS WHERE EMP_ID=EMPID);
	SET OLDNEXT_KIN_NAME=(SELECT EMP_NEXT_KIN_NAME FROM EMPLOYEE_DETAILS WHERE EMP_ID=EMPID);
	SET OLDRELATIONHOOD=(SELECT EMP_RELATIONHOOD FROM EMPLOYEE_DETAILS WHERE EMP_ID=EMPID);
	SET OLDALT_MOBILE_NO=(SELECT EMP_ALT_MOBILE_NO FROM EMPLOYEE_DETAILS WHERE EMP_ID=EMPID);
	-- FOR INSERT INTO EMPLOYEE_DETAILS  
	IF EXISTS(SELECT DISTINCT EMP_ID FROM EMPLOYEE_DETAILS WHERE EMP_ID=EMPID)THEN
		IF(OLDFIRST_NAME!=FIRST_NAME OR OLDLAST_NAME!=LAST_NAME OR OLDDOB!=DOB OR OLDDESIGNATION!=DESIGNATION OR OLDMOBILE_NUMBER!=MOBILE_NUMBER OR OLDNEXT_KIN_NAME!=NEXT_KIN_NAME OR OLDRELATIONHOOD!=RELATIONHOOD OR OLDALT_MOBILE_NO!=ALT_MOBILE_NO)THEN
			UPDATE EMPLOYEE_DETAILS SET EMP_FIRST_NAME=FIRST_NAME,EMP_LAST_NAME=LAST_NAME,EMP_DOB=DOB,EMP_DESIGNATION=DESIGNATION,EMP_MOBILE_NUMBER=MOBILE_NUMBER,
			EMP_NEXT_KIN_NAME=NEXT_KIN_NAME,EMP_RELATIONHOOD=RELATIONHOOD,EMP_ALT_MOBILE_NO=ALT_MOBILE_NO,EMP_USERSTAMP_ID=USERSTAMP_ID WHERE EMP_ID=EMPID;
			SET SUCCESS_FLAG=1;
		END IF;
		SELECT DISTINCT CPD_ID INTO CPDID FROM COMPANY_PROPERTIES_DETAILS WHERE EMP_ID=EMPID;    
	END IF;
  
	SET OLDEMPID=(SELECT EMP_ID FROM COMPANY_PROPERTIES_DETAILS WHERE EMP_ID=EMPID);
	SET OLDLAPTOP_NUMBER=(SELECT CPD_LAPTOP_NUMBER FROM COMPANY_PROPERTIES_DETAILS WHERE CPD_ID=CPDID);
	SET OLDCHARGER_NUMBER=(SELECT CPD_CHARGER_NUMBER FROM COMPANY_PROPERTIES_DETAILS WHERE CPD_ID=CPDID);
	SET OLDLAPTOP_BAG=(SELECT CPD_LAPTOP_BAG FROM COMPANY_PROPERTIES_DETAILS WHERE CPD_ID=CPDID);
	SET OLDMOUSE=(SELECT CPD_MOUSE FROM COMPANY_PROPERTIES_DETAILS WHERE CPD_ID=CPDID);
	SET OLDDOOR_ACCESS=(SELECT CPD_DOOR_ACCESS FROM COMPANY_PROPERTIES_DETAILS WHERE CPD_ID=CPDID);
	SET OLDID_CARD=(SELECT CPD_ID_CARD FROM COMPANY_PROPERTIES_DETAILS WHERE CPD_ID=CPDID);
	SET OLDHEADSET=(SELECT CPD_HEADSET FROM COMPANY_PROPERTIES_DETAILS WHERE CPD_ID=CPDID);  
	-- FOR INSERT INTO COMPANY_PROPERTIES_DETAILS
	IF EXISTS(SELECT DISTINCT CPD_ID FROM COMPANY_PROPERTIES_DETAILS WHERE EMP_ID=EMPID AND CPD_ID=CPDID)THEN
		IF(EMPID=OLDEMPID AND((LAPTOP_NUMBER IS NOT NULL AND OLDLAPTOP_NUMBER IS NULL)OR(LAPTOP_NUMBER IS NULL AND OLDLAPTOP_NUMBER IS NOT NULL)OR(LAPTOP_NUMBER!=OLDLAPTOP_NUMBER)
		OR(CHARGER_NUMBER IS NOT NULL AND OLDCHARGER_NUMBER IS NULL)OR(CHARGER_NUMBER IS NULL AND OLDCHARGER_NUMBER IS NOT NULL)OR(CHARGER_NUMBER!=OLDCHARGER_NUMBER)
		OR(LAPTOP_BAG IS NOT NULL AND OLDLAPTOP_BAG IS NULL)OR(LAPTOP_BAG IS NULL AND OLDLAPTOP_BAG IS NOT NULL)OR(MOUSE IS NOT NULL AND OLDMOUSE IS NULL)OR(MOUSE IS NULL AND OLDMOUSE IS NOT NULL)
		OR(DOOR_ACCESS IS NOT NULL AND OLDDOOR_ACCESS IS NULL)OR(DOOR_ACCESS IS NULL AND OLDDOOR_ACCESS IS NOT NULL)OR(ID_CARD IS NOT NULL AND OLDID_CARD IS NULL)OR(ID_CARD IS NULL AND OLDID_CARD IS NOT NULL)
		OR(HEADSET IS NOT NULL AND OLDHEADSET IS NULL)OR(HEADSET IS NULL AND OLDHEADSET IS NOT NULL)))THEN
			UPDATE COMPANY_PROPERTIES_DETAILS SET CPD_LAPTOP_NUMBER=LAPTOP_NUMBER,CPD_CHARGER_NUMBER=CHARGER_NUMBER,CPD_LAPTOP_BAG=LAPTOP_BAG,
			CPD_MOUSE=MOUSE,CPD_DOOR_ACCESS=DOOR_ACCESS,CPD_ID_CARD=ID_CARD,CPD_HEADSET=HEADSET,ULD_ID=USERSTAMP_ID WHERE CPD_ID=CPDID;
			SET SUCCESS_FLAG=1;
		END IF;
	END IF;
	COMMIT;
END;
/*
CALL SP_TS_EMPLOYEE_DETAILS_SEARCH_UPDATE(1,'SAFIYULLAH','MOHIDEEN','1988-03-04','PROGRAMMER','9876986573','SAFI','STAFF','8987666234',
'65TT57Y7R432W3','U987I8IUU7HY789','X','X','X','X','','safiyullah.mohideen@ssomens.com',@SUCCESS_FLAG);
SELECT @SUCCESS_FLAG;
*/