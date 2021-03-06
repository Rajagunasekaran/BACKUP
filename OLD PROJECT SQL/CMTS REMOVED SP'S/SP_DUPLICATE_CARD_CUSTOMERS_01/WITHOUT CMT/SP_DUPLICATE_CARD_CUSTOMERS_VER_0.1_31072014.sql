DROP PROCEDURE IF EXISTS SP_DUPLICATE_CARD_CUSTOMERS;
CREATE PROCEDURE SP_DUPLICATE_CARD_CUSTOMERS(
IN DESTSCHEMA TEXT,
OUT TEMP_DUPLICATE_CARDS TEXT)
BEGIN
	DECLARE SDATE DATE;
	DECLARE EDATE DATE;
	DECLARE PREDATE DATE;
	DECLARE MINID INT;
	DECLARE MAXID INT;
	DECLARE MAXIMUMID INT;
	DECLARE MINIMUMID INT;
	DECLARE T_UASDID INT;
	DECLARE UASDID TEXT;
	DECLARE CARDS TEXT;
	DECLARE DUPLICATE_CARDS TEXT;
	DECLARE TEMP_UASDID TEXT;
	DECLARE TEMP_CARD TEXT;
	DECLARE DUPLICATECARDS TEXT;
	DECLARE TEMP_DUPLICATECARDS_ID TEXT;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;
		IF(TEMP_CARD IS NOT NULL)THEN
			SET @DROP_TEMP_CARD=(SELECT CONCAT('DROP TABLE IF EXISTS ',TEMP_CARD));
			PREPARE DROP_TEMP_CARD_STMT FROM @DROP_TEMP_CARD;
			EXECUTE DROP_TEMP_CARD_STMT;
		END IF;
		IF(TEMP_UASDID IS NOT NULL)THEN
			SET @DROP_TEMP_UASDID=(SELECT CONCAT('DROP TABLE IF EXISTS ',TEMP_UASDID));
			PREPARE DROP_TEMP_UASDID_STMT FROM @DROP_TEMP_UASDID;
			EXECUTE DROP_TEMP_UASDID_STMT;
		END IF;
		IF(TEMP_DUPLICATECARDS_ID IS NOT NULL)THEN
			SET @DROP_TEMP_DUPLICATECARDS_ID=(SELECT CONCAT('DROP TABLE IF EXISTS ',TEMP_DUPLICATECARDS_ID));
			PREPARE DROP_TEMP_DUPLICATECARDS_ID_STMT FROM @DROP_TEMP_DUPLICATECARDS_ID;
			EXECUTE DROP_TEMP_DUPLICATECARDS_ID_STMT;
		END IF;
	END;
	SET UASDID=(SELECT CONCAT('TEMP_UASDID','_',SYSDATE()));
	SET UASDID=(SELECT REPLACE(UASDID,' ',''));
	SET UASDID=(SELECT REPLACE(UASDID,'-',''));
	SET UASDID=(SELECT REPLACE(UASDID,':',''));
	SET TEMP_UASDID=UASDID;  
	SET @CREATE_TEMP_UASDID=(SELECT CONCAT('CREATE TABLE ',TEMP_UASDID,' (ID INT(11) AUTO_INCREMENT PRIMARY KEY, UASD_ID INT(11))'));
	PREPARE CREATE_TEMP_UASDID_STMT FROM @CREATE_TEMP_UASDID;
	EXECUTE CREATE_TEMP_UASDID_STMT;
	SET @INSERT_TEMP_UASDID=(SELECT CONCAT('INSERT INTO ',TEMP_UASDID,' (UASD_ID) (SELECT DISTINCT(UASD_ID)FROM ',DESTSCHEMA,'.CUSTOMER_LP_DETAILS WHERE UASD_ID IS NOT NULL ORDER BY UASD_ID)'));
	PREPARE INSERT_TEMP_UASDID_STMT FROM @INSERT_TEMP_UASDID;
	EXECUTE INSERT_TEMP_UASDID_STMT;
	SET @MIN_ID = (SELECT CONCAT('SELECT MIN(ID) INTO @MINID FROM ',TEMP_UASDID));
	PREPARE MIN_ID_STMT FROM @MIN_ID;
	EXECUTE MIN_ID_STMT;	
	SET @MAX_ID = (SELECT CONCAT('SELECT MAX(ID) INTO @MAXID FROM ',TEMP_UASDID));
	PREPARE MAX_ID_STMT FROM @MAX_ID;
	EXECUTE MAX_ID_STMT;	
	SET MINID = @MINID;
	SET MAXID = @MAXID;
	SET DUPLICATECARDS=(SELECT CONCAT('TEMP_DUPLICATECARDS_ID','_',SYSDATE()));
	SET DUPLICATECARDS=(SELECT REPLACE(DUPLICATECARDS,' ',''));
	SET DUPLICATECARDS=(SELECT REPLACE(DUPLICATECARDS,'-',''));
	SET DUPLICATECARDS=(SELECT REPLACE(DUPLICATECARDS,':',''));
	SET TEMP_DUPLICATECARDS_ID=DUPLICATECARDS;  
	SET @CREATE_TEMP_DUPLICATECARDS_ID=(SELECT CONCAT('CREATE TABLE ',TEMP_DUPLICATECARDS_ID,'(CLP_ID INT(11),CUSTOMER_ID INT(11),UASD_ID INT(11))'));
	PREPARE CREATE_TEMP_DUPLICATECARDS_ID_STMT FROM @CREATE_TEMP_DUPLICATECARDS_ID;
	EXECUTE CREATE_TEMP_DUPLICATECARDS_ID_STMT;
	SET DUPLICATE_CARDS=(SELECT CONCAT('TEMP_DUPLICATE_CARDS','_',SYSDATE()));
	SET DUPLICATE_CARDS=(SELECT REPLACE(DUPLICATE_CARDS,' ',''));
	SET DUPLICATE_CARDS=(SELECT REPLACE(DUPLICATE_CARDS,'-',''));
	SET DUPLICATE_CARDS=(SELECT REPLACE(DUPLICATE_CARDS,':',''));
	SET TEMP_DUPLICATE_CARDS=DUPLICATE_CARDS;  
	SET @CREATE_TEMP_DUPLICATE_CARDS=(SELECT CONCAT('CREATE TABLE ',TEMP_DUPLICATE_CARDS,' (CLP_ID INT(11),CUSTOMER_ID INT(11),REC_VER INT(11),UASD_ID INT(11),STARTDATE DATE,ENDDATE DATE,PRETERMINATE DATE,TERMINATE CHAR(5),GUEST_CARD CHAR(5))'));
	PREPARE CREATE_TEMP_DUPLICATE_CARDS_STMT FROM @CREATE_TEMP_DUPLICATE_CARDS;
	EXECUTE CREATE_TEMP_DUPLICATE_CARDS_STMT;
	WHILE (MINID <= MAXID)DO 	
		SET CARDS=(SELECT CONCAT('TEMP_CARD','_',SYSDATE()));
		SET CARDS=(SELECT REPLACE(CARDS,' ',''));
		SET CARDS=(SELECT REPLACE(CARDS,'-',''));
		SET CARDS=(SELECT REPLACE(CARDS,':',''));
		SET TEMP_CARD=(SELECT CONCAT(CARDS,'_',MINID));  
		SET @CREATE_TEMP_CARD=(SELECT CONCAT('CREATE TABLE ',TEMP_CARD,' (ID INT(11) AUTO_INCREMENT PRIMARY KEY,CLP_ID INT(11),CUSTOMER_ID INT(11),REC_VER INT(11),UASD_ID INT(11),STARTDATE DATE,ENDDATE DATE,PRETERMINATE DATE,TERMINATE CHAR(5),GUEST_CARD CHAR(5))'));
		PREPARE CREATE_TEMP_CARD_STMT FROM @CREATE_TEMP_CARD;
		EXECUTE CREATE_TEMP_CARD_STMT;
		SET @INSERT_TEMP_CARD=(SELECT CONCAT('INSERT INTO ',TEMP_CARD,' (CLP_ID,CUSTOMER_ID ,REC_VER,UASD_ID ,STARTDATE ,ENDDATE,PRETERMINATE,TERMINATE,GUEST_CARD) (SELECT CLP_ID ,CUSTOMER_ID,CED_REC_VER, UASD_ID,CLP_STARTDATE,CLP_ENDDATE,CLP_PRETERMINATE_DATE,CLP_TERMINATE,CLP_GUEST_CARD FROM ',DESTSCHEMA,'.CUSTOMER_LP_DETAILS WHERE UASD_ID = (SELECT UASD_ID FROM ',TEMP_UASDID,' WHERE ID = ',MINID,') ORDER BY CLP_STARTDATE)'));
		PREPARE INSERT_TEMP_CARD_STMT FROM @INSERT_TEMP_CARD;
		EXECUTE INSERT_TEMP_CARD_STMT;
		SET @MINMUM_ID = (SELECT CONCAT('SELECT MIN(ID) INTO @MINIMUMID FROM ',TEMP_CARD));
		PREPARE MINMUM_ID_STMT FROM @MINMUM_ID;
		EXECUTE MINMUM_ID_STMT;	
		SET @MAXIMUM_ID = (SELECT CONCAT('SELECT MAX(ID) INTO @MAXIMUMID FROM ',TEMP_CARD));
		PREPARE MAXIMUM_ID_STMT FROM @MAXIMUM_ID;
		EXECUTE MAXIMUM_ID_STMT;
		SET MINIMUMID = @MINIMUMID;
		SET MAXIMUMID = @MAXIMUMID;
		WHILE (MINIMUMID < MAXIMUMID)DO        
			SET @TUASD_ID=(SELECT CONCAT('SELECT UASD_ID INTO @T_UASDID FROM ',TEMP_UASDID,' WHERE ID = ',MINID));
			PREPARE TUASD_ID_STMT FROM @TUASD_ID;
			EXECUTE TUASD_ID_STMT;    
			SET T_UASDID= @T_UASDID;
			SET @STARTDATE= (SELECT CONCAT('SELECT STARTDATE INTO @SDATE FROM ',TEMP_CARD,' WHERE ID = ',MINIMUMID));
			PREPARE STARTDATE_STMT FROM @STARTDATE;
			EXECUTE STARTDATE_STMT;
			SET SDATE = @SDATE;     
			SET @ENDDATE= (SELECT CONCAT('SELECT ENDDATE INTO @EDATE FROM ',TEMP_CARD,' WHERE ID = ',MINIMUMID));
			PREPARE ENDDATE_STMT FROM @ENDDATE;
			EXECUTE ENDDATE_STMT;    
			SET @PRETERMINATEDATE= (SELECT CONCAT('SELECT PRETERMINATE INTO @PREDATE FROM ',TEMP_CARD,' WHERE ID = ',MINIMUMID));
			PREPARE PRETERMINATEDATE_STMT FROM @PRETERMINATEDATE;
			EXECUTE PRETERMINATEDATE_STMT;
			SET PREDATE= @PREDATE;
			IF (PREDATE IS NOT NULL) THEN       
				SET EDATE = @PREDATE;    
			ELSE       
				SET EDATE = @EDATE;      
			END IF;
			SET @INSERT_TEMP_DUPLICATECARDS_ID=(SELECT CONCAT('INSERT INTO ',TEMP_DUPLICATECARDS_ID,' (SELECT CLP_ID,CUSTOMER_ID,UASD_ID FROM ',TEMP_CARD,' WHERE UASD_ID=',T_UASDID,' AND ((STARTDATE BETWEEN DATE_SUB(''',SDATE,''', INTERVAL 1 DAY) AND DATE_SUB(''',EDATE,''', INTERVAL 1 DAY)) OR (ENDDATE BETWEEN DATE_SUB(''',SDATE,''', INTERVAL 1 DAY) AND DATE_SUB(''',EDATE,''', INTERVAL 1 DAY))) AND ID > ',MINIMUMID,')'));
			PREPARE INSERT_TEMP_DUPLICATECARDS_ID_STMT FROM @INSERT_TEMP_DUPLICATECARDS_ID;
			EXECUTE INSERT_TEMP_DUPLICATECARDS_ID_STMT;
			SET MINIMUMID=MINIMUMID+1;
		END WHILE; 
		SET @DROP_TEMP_CARD=(SELECT CONCAT('DROP TABLE IF EXISTS ',TEMP_CARD));
		PREPARE DROP_TEMP_CARD_STMT FROM @DROP_TEMP_CARD;
		EXECUTE DROP_TEMP_CARD_STMT;
		SET MINID=MINID+1;
	END WHILE;
	SET @DISTINCT_TEMP_DUPLICATE_CARDS=(SELECT CONCAT('INSERT INTO ',TEMP_DUPLICATE_CARDS,' (SELECT DISTINCT CLD.CLP_ID,CLD.CUSTOMER_ID,CLD.CED_REC_VER,CLD.UASD_ID,CLD.CLP_STARTDATE,CLD.CLP_ENDDATE,CLD.CLP_PRETERMINATE_DATE,CLD.CLP_TERMINATE,CLD.CLP_GUEST_CARD FROM ',DESTSCHEMA,'.CUSTOMER_LP_DETAILS CLD,',TEMP_DUPLICATECARDS_ID,' TDI WHERE CLD.CLP_ID=TDI.CLP_ID AND CLD.CUSTOMER_ID=TDI.CUSTOMER_ID AND CLD.UASD_ID=TDI.UASD_ID)'));
	PREPARE DISTINCT_TEMP_DUPLICATE_CARDS_STMT FROM @DISTINCT_TEMP_DUPLICATE_CARDS;
	EXECUTE DISTINCT_TEMP_DUPLICATE_CARDS_STMT;  
	SET @DROP_TEMP_UASDID=(SELECT CONCAT('DROP TABLE IF EXISTS ',TEMP_UASDID));
	PREPARE DROP_TEMP_UASDID_STMT FROM @DROP_TEMP_UASDID;
	EXECUTE DROP_TEMP_UASDID_STMT;
	SET @DROP_TEMP_DUPLICATECARDS_ID=(SELECT CONCAT('DROP TABLE IF EXISTS ',TEMP_DUPLICATECARDS_ID));
	PREPARE DROP_TEMP_DUPLICATECARDS_ID_STMT FROM @DROP_TEMP_DUPLICATECARDS_ID;
	EXECUTE DROP_TEMP_DUPLICATECARDS_ID_STMT;
	COMMIT;
END;
/*
CALL SP_DUPLICATE_CARD_CUSTOMERS('dest_17072014',@TEMP_DUPLICATE_CARDS);
*/