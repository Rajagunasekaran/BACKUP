-- version:0.1 --sdate:20-06-2014 --edate:20-06-2014 --issue:593 --commentno#75 --desc:ecnid,CUSTOMERID,invoicedate validation --doneby:RL
DROP PROCEDURE IF EXISTS SP_TRG_BIZDLY_EXPUNIT_VALIDATION;
CREATE PROCEDURE SP_TRG_BIZDLY_EXPUNIT_VALIDATION(
IN EUID INTEGER,
IN UNITID INTEGER,
IN ECNID INTEGER,
IN CUSTOMERID INTEGER,
IN INVOICEDATE DATE,
IN PROCESS TEXT)
BEGIN
	DECLARE TODAYDATE DATE;
	DECLARE UNITSTARTDATE DATE;
	DECLARE UNITENDDATE DATE;
	DECLARE UNITMONTH INTEGER;
	DECLARE MINDATE DATE;
	DECLARE MAXDATE DATE;
	SET UNITSTARTDATE=(SELECT UD_START_DATE FROM UNIT_DETAILS WHERE UNIT_ID = UNITID);
	-- SET UNITMONTH=(SELECT ECN_DATA FROM EXPENSE_CONFIGURATION WHERE CGN_ID = (SELECT CGN_ID FROM CONFIGURATION WHERE CGN_TYPE='UNIT MONTH'));
	CALL SP_CONFIG_MONTH(UNITID,@CONFIGDATE);
	SET UNITENDDATE=@CONFIGDATE;
  
	SET TODAYDATE=CURDATE();
  
	IF (PROCESS='INSERT') OR (PROCESS='UPDATE') THEN
		IF INVOICEDATE > TODAYDATE THEN
			SIGNAL SQLSTATE '45000'
			SET MESSAGE_TEXT='EE_INVOICE_DATE SHOULD LESS THAN CURDATE';
		END IF;
    
		SET MINDATE=UNITSTARTDATE;
    
		IF UNITENDDATE<=CURDATE() THEN
			SET MAXDATE=UNITENDDATE;
		ELSE
			SET MAXDATE=CURDATE();
		END IF;
    
		IF INVOICEDATE NOT BETWEEN MINDATE AND MAXDATE THEN 
			SIGNAL SQLSTATE '45000'
			SET MESSAGE_TEXT='EU_INVOICE_DATE SHOULD BETWEEN UNIT STARTDATE AND ENDDATE';
		END IF;
		IF(ECNID IS NOT NULL)THEN
			IF NOT EXISTS(SELECT ECN_ID FROM EXPENSE_CONFIGURATION WHERE ECN_ID = ECNID AND CGN_ID = 20)THEN
				SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'GIVE ECN_ID IN BETWEEN 22 TO 24';
			END IF;
		END IF;
		IF(CUSTOMERID IS NOT NULL)THEN
			IF NOT EXISTS(SELECT CUSTOMER_ID FROM CUSTOMER WHERE CUSTOMER_ID = CUSTOMERID) THEN
				SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT = 'CUSTOMER_ID NOT IN CUSTOMER TABLE';
			END IF;
		END IF;
	END IF;
END;