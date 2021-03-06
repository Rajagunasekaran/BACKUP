DROP PROCEDURE IF EXISTS SP_TRG_EMPLOEYEE_DETAILS_VALIDATION;
CREATE PROCEDURE SP_TRG_EMPLOEYEE_DETAILS_VALIDATION(
IN NEWEMPMOBILE VARCHAR(20),
IN PROCESS TEXT)
BEGIN
	DECLARE ERRORMSG TEXT;
	DECLARE MESSAGE_TEXT VARCHAR(50);
	IF ((PROCESS = 'INSERT') OR (PROCESS = 'UPDATE')) THEN  
		IF (NEWEMPMOBILE IS NOT NULL) THEN
			IF (LENGTH(NEWEMPMOBILE)<6) THEN
				SET ERRORMSG=(SELECT EMC_DATA FROM ERROR_MESSAGE_CONFIGURATION WHERE EMC_ID=339);
				SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT=ERRORMSG;
			END IF;
			IF (LENGTH(NEWEMPMOBILE)>10) THEN
				SET ERRORMSG=(SELECT EMC_DATA FROM ERROR_MESSAGE_CONFIGURATION WHERE EMC_ID=568);
				SIGNAL SQLSTATE '45000'
				SET MESSAGE_TEXT=ERRORMSG;
			END IF;
		END IF;
	END IF;
END;
