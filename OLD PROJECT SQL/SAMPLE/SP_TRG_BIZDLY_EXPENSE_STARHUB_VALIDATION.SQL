DROP PROCEDURE IF EXISTS SP_TRG_BIZDLY_EXPENSE_STARHUB_VALIDATION;
CREATE PROCEDURE SP_TRG_BIZDLY_EXPENSE_STARHUB_VALIDATION(
IN ESHID INTEGER,
IN INVOICEDATE DATE,
IN FROMPERIOD DATE,
IN TOPERIOD DATE,
IN EDSHID INTEGER,
IN PROCESS TEXT
)
BEGIN
DECLARE TODAYDATE DATE;
DECLARE UNITID INTEGER;
DECLARE UNITSTARTDATE DATE;
DECLARE UNITMONTH INTEGER;
DECLARE MINDATE DATE;
DECLARE MAXDATE DATE;
DECLARE UNITENDDATE DATE;
DECLARE ECNID INTEGER;
DECLARE MESSAGE_TEXT TEXT;
DECLARE YEAR_INVDATE INTEGER;
DECLARE MONTHNAME VARCHAR(20);
DECLARE MONTH_YEAR VARCHAR(25);
DECLARE OLDINVDATE DATE;
DECLARE ERRORMSG TEXT;
DECLARE ERRORMSG1 TEXT;
DECLARE ERRORMSG2 TEXT;
DECLARE ERRORMSG3 TEXT;
DECLARE ERRORMSG4 TEXT;
DECLARE TO_PERIOD_ENDDATE DATE;
DECLARE MONTH_INVDATE INTEGER;
SET ERRORMSG1=(SELECT EMC_DATA FROM ERROR_MESSAGE_CONFIGURATION WHERE EMC_ID=474);
SET ERRORMSG2=(SELECT EMC_DATA FROM ERROR_MESSAGE_CONFIGURATION WHERE EMC_ID=475);
SET ERRORMSG3=(SELECT EMC_DATA FROM ERROR_MESSAGE_CONFIGURATION WHERE EMC_ID=476);
SET ERRORMSG4=(SELECT EMC_DATA FROM ERROR_MESSAGE_CONFIGURATION WHERE EMC_ID=477);
SET MONTH_INVDATE=(SELECT MONTH(INVOICEDATE));
SET YEAR_INVDATE=(SELECT YEAR(INVOICEDATE));
SET MONTHNAME=(SELECT UCASE(MONTHNAME(STR_TO_DATE(MONTH_INVDATE, '%m'))));
SET MONTH_YEAR=(SELECT CONCAT(MONTHNAME,'-',YEAR_INVDATE));
SET OLDINVDATE=(SELECT ESH_INVOICE_DATE FROM EXPENSE_STARHUB WHERE ESH_ID=ESHID);
SET ERRORMSG=(SELECT EMC_DATA FROM ERROR_MESSAGE_CONFIGURATION WHERE EMC_ID=472);
SET UNITID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_ID=(SELECT UNIT_ID FROM EXPENSE_DETAIL_STARHUB WHERE EDSH_ID=EDSHID)); 
SET TO_PERIOD_ENDDATE=(SELECT DATE_ADD(FROMPERIOD,INTERVAL 2 MONTH));
SET TO_PERIOD_ENDDATE=(SELECT LAST_DAY(TO_PERIOD_ENDDATE));
SET ERRORMSG=(SELECT REPLACE(ERRORMSG,'[UNITNO]',(SELECT UNIT_NO FROM UNIT WHERE UNIT_ID=UNITID)));
SET ERRORMSG=(SELECT REPLACE(ERRORMSG,'[MONTH]',MONTH_YEAR));
CALL SP_CONFIG_SDATE_EDATE(UNITID,@S_CONFIGDATE,@E_CONFIGDATE,@INVOICE_DATE);
SET UNITSTARTDATE=@S_CONFIGDATE;
SET UNITENDDATE=@E_CONFIGDATE;
SET MAXDATE=@INVOICE_DATE;
SET TODAYDATE=CURDATE();
IF TO_PERIOD_ENDDATE>UNITENDDATE THEN
SET TO_PERIOD_ENDDATE=UNITENDDATE;
END IF;
IF (PROCESS='INSERT') OR (PROCESS='UPDATE') THEN
IF (INVOICEDATE>TODAYDATE) THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT=ERRORMSG1;
END IF;
SET MINDATE=UNITSTARTDATE;
IF INVOICEDATE NOT BETWEEN MINDATE AND MAXDATE THEN 
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT=ERRORMSG2;
END IF;
IF FROMPERIOD NOT BETWEEN MINDATE AND UNITENDDATE THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT=ERRORMSG3;
END IF;
IF TOPERIOD NOT BETWEEN FROMPERIOD AND TO_PERIOD_ENDDATE THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT=ERRORMSG4;
END IF;
END IF;
IF (PROCESS='INSERT')THEN
		IF EXISTS(SELECT * FROM EXPENSE_STARHUB WHERE MONTH(ESH_INVOICE_DATE)=MONTH_INVDATE AND YEAR(ESH_INVOICE_DATE)=YEAR_INVDATE AND EDSH_ID IN(SELECT EDSH_ID FROM EXPENSE_DETAIL_STARHUB WHERE UNIT_ID=UNITID))THEN
			SIGNAL SQLSTATE '45000'
			SET MESSAGE_TEXT=ERRORMSG;
		END IF;
END IF;
IF (PROCESS='UPDATE')THEN
	IF EXISTS(SELECT * FROM EXPENSE_STARHUB WHERE MONTH(ESH_INVOICE_DATE)=MONTH_INVDATE AND YEAR(ESH_INVOICE_DATE)=YEAR_INVDATE AND EDSH_ID IN(SELECT EDSH_ID FROM EXPENSE_DETAIL_STARHUB WHERE UNIT_ID=UNITID)AND ESH_ID!=ESHID)THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT=ERRORMSG;
	END IF;
END IF;
END;