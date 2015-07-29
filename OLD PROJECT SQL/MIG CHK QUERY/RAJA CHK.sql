-- UNIT

-- SELECT*FROM UNIT_ACCESS_STAMP_DETAILS

SELECT DISTINCT SCU.UNIT_ACCESS_CARD,UAS.UASD_ACCESS_CARD FROM UNIT_ACCESS_STAMP_DETAILS UAS , SOURCE_04062014.UNIT_SCDB_FORMAT SCU WHERE UAS.UASD_ACCESS_CARD=SCU.UNIT_ACCESS_CARD

-- SELECT*FROM UNIT_ACCOUNT_DETAILS

SELECT*FROM UNIT_CONFIGURATION

SELECT SCU.`TIMESTAMP`,UC.UCN_TIMESTAMP FROM SOURCE_04062014.UNIT_SCDB_FORMAT SCU, UNIT_CONFIGURATION UC WHERE SCU.TIMESTAMP =UC.UCN_TIMESTAMP

-- SELECT *FROM UNIT_DETAILS

SELECT UD.UD_START_DATE,SCU.UNIT_START_DATE , UD.UDU_END_DATE,SCU.UNIT_END_DATE , UD.UD_OBSOLETE,SCU.UNIT_OBSOLETE FROM UNIT_DETAILS UD , SOURCE_04062014.UNIT_SCDB_FORMAT SCU WHERE UD.UD_START_DATE=SCU.UNIT_START_DATE AND UD.UD_END_DATE=SCU.UNIT_END_DATE AND UD.UD_OBSOLETE=SCU.UNIT_OBSOLETE

-- SELECT*FROM UNIT_STAMP_DUTY_TYPE

SELECT SCU.`TIMESTAMP`,USD.USDT_TIMESTAMP FROM SOURCE_04062014.UNIT_SCDB_FORMAT SCU, UNIT_STAMP_DUTY_TYPE USD WHERE SCU.`TIMESTAMP`=USD.USDT_TIMESTAMP

-- SELECT*FROM UNIT_LOGIN_DETAILS

SELECT*FROM UNIT

SELECT DISTINCT UD.UD_START_DATE,UD.UD_END_DATE FROM UNIT_DETAILS UD

-- DISTINCT UNIT

SELECT DISTINCT SCU.UNIT_ROOM_TYPE , RM.URTD_ROOM_TYPE FROM SOURCE_04062014.UNIT_SCDB_FORMAT SCU, UNIT_ROOM_TYPE_DETAILS RM WHERE SCU.UNIT_ROOM_TYPE = RM.URTD_ROOM_TYPE

SELECT DISTINCT SCU.UNIT_WEBPWD, LD.ULDTL_WEBPWD LD FROM SOURCE_04062014.UNIT_SCDB_FORMAT SCU, UNIT_LOGIN_DETAILS LD WHERE SCU.UNIT_WEBPWD=LD.ULDTL_WEBPWD

SELECT DISTINCT SCU.UNIT_START_DATE,UD.UD_START_DATE,  SCU.UNIT_END_DATE,UD.UD_END_DATE FROM SOURCE_04062014.UNIT_SCDB_FORMAT SCU , UNIT_DETAILS UD WHERE  SCU.UNIT_START_DATE=UD.UD_START_DATE AND  SCU.UNIT_END_DATE=UD.UD_END_DATE\

SELECT DISTINCT SCU.`TIMESTAMP`,ULD.ULDTL_TIMESTAMP FROM SOURCE_04062014.UNIT_SCDB_FORMAT SCU, UNIT_LOGIN_DETAILS ULD WHERE SCU.`TIMESTAMP`=ULD.ULDTL_TIMESTAMP

-- DISTINCT BIZ DILY

SELECT DISTINCT EA.EA_TIMESTAMP, SCE.`TIMESTAMP` FROM EXPENSE_AGENT EA, SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT SCE WHERE EA.EA_TIMESTAMP=SCE.`TIMESTAMP`

SELECT DISTINCT BDS.`TIMESTAMP`,EAS.EAS_TIMESTAMP FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT BDS, EXPENSE_AIRCON_SERVICE EAS WHERE BDS.`TIMESTAMP`=EAS.EAS_TIMESTAMP

SELECT DISTINCT EAS_TIMESTAMP FROM EXPENSE_AIRCON_SERVICE

SELECT DISTINCT BDS.EXP_SHB_ACCOUNT_NO ,EDS.EDSH_ACCOUNT_NO ,BDS.`TIMESTAMP`,EDS.EDSH_TIMESTAMP FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT BDS,EXPENSE_DETAIL_STARHUB EDS WHERE BDS.EXP_SHB_ACCOUNT_NO = EDS.EDSH_ACCOUNT_NO AND BDS.`TIMESTAMP`=EDS.EDSH_TIMESTAMP

SELECT DISTINCT CSF.CC_REC_VER,CED.CED_REC_VER FROM SOURCE_04062014.CUSTOMER_SCDB_FORMAT CSF, CUSTOMER_ENTRY_DETAILS CED WHERE CSF.CC_REC_VER=CED.CED_REC_VER

-- CHECKING CUSTOMER _SCDB_FORMAT AND CUSTOMER_PAYMENT_PROFILE HERE CUSTOMER PAYMENT PROFILE NOT MATCHING ANY DATA

SELECT DISTINCT SCF.`TIMESTAMP`,CPP.CPP_TIMESTAMP FROM SOURCE_04062014.CUSTOMER_SCDB_FORMAT SCF, CUSTOMER_PAYMENT_PROFILE CPP WHERE SCF.`TIMESTAMP`=CPP.CPP_TIMESTAMP

-- CHK FOR THE CUSTOMER SCDB FORMAT WITH CUSTOMER FEE DETAIL (ONLY 12 RECORDS ARE SAME IN BOTH RECORD)

SELECT DISTINCT SCF.CC_REC_VER, CFD.CED_REC_VER FROM SOURCE_04062014.CUSTOMER_SCDB_FORMAT SCF, CUSTOMER_FEE_DETAILS CFD WHERE SCF.CC_REC_VER=CFD.CED_REC_VER

SELECT DISTINCT CACD_TIMESTAMP FROM CUSTOMER_ACCESS_CARD_DETAILS WHERE  CACD_TIMESTAMP IS NOT NULL

-- ONLY  37 RECORD MATCHING IN SOURCE TABLE 127 NOT MATCHING IN DESTINATION TABLE 

SELECT DISTINCT  SCF.`TIMESTAMP`,ACD.CACD_TIMESTAMP FROM SOURCE_04062014.CUSTOMER_SCDB_FORMAT SCF, CUSTOMER_ACCESS_CARD_DETAILS ACD WHERE SCF.`TIMESTAMP`=ACD.CACD_TIMESTAMP

-- TO CHECK CUSTOMER_TERMINATION_DETAIL AND CUSTOMER_SCDB STARTDATE AND ENDDATE AND RECVER AND TIMESTAMP.

SELECT DISTINCT SCF.CC_STARTDATE , CTD.CTD_STARTDATE , SCF.CC_ENDDATE,CTD.CTD_ENDDATE , SCF.CC_REC_VER,CTD.CED_REC_VER , SCF.`TIMESTAMP`,CTD.CTD_TIMESTAMP FROM SOURCE_04062014.CUSTOMER_SCDB_FORMAT SCF, CUSTOMER_TERMINATION_DETAILS CTD WHERE SCF.CC_STARTDATE = CTD.CTD_STARTDATE AND SCF.CC_ENDDATE=CTD.CTD_ENDDATE AND SCF.CC_REC_VER=CTD.CED_REC_VER AND SCF.`TIMESTAMP`=CTD.CTD_TIMESTAMP

-- CUSTOMER_TIME _PROFILE THERE IS NO DATA IN TABLE

SELECT DISTINCT C.CUSTOMER_ID , SCF.CC_FIRST_NAME, C.CUSTOMER_FIRST_NAME FROM SOURCE_04062014.CUSTOMER_SCDB_FORMAT SCF, CUSTOMER C WHERE SCF.CC_FIRST_NAME= C.CUSTOMER_FIRST_NAME ORDER BY C.CUSTOMER_ID 

-- PAYMENT
-- 1.CHECK A RENTAL_SCDB_FORMAT AND PAYMENT_CONFIGURATION 
-- NOT MATCHING ANY DATA IN BOTH TABLES

SELECT  RF.TIMESTAMP, PC.PCN_TIMESTAMP FROM SOURCE_04062014.RENTAL_SCDB_FORMAT RF, PAYMENT_CONFIGURATION PC WHERE RF.`TIMESTAMP`= PC.PCN_TIMESTAMP

-- HERE WE CHECK A PAYMENT DETAIL AND RENTAL_SCDB_FORMAT MATCHING EACH DATA IN BOTH TABLE

SELECT DISTINCT RF.RENTAL_AMOUNT,PD.PD_AMOUNT , RF.RENTAL_PAID_DATE,PD.PD_PAID_DATE FROM SOURCE_04062014.RENTAL_SCDB_FORMAT RF, PAYMENT_DETAILS PD WHERE RF.RENTAL_AMOUNT=PD.PD_AMOUNT AND RF.RENTAL_PAID_DATE=PD.PD_PAID_DATE

---- EXPENCE DETAIL TABLE

-- THIS EXPENCE DETAIL STARHUB AND  BIZ DETAIL SCDB FORMAT TABLE MATCH EVERYTHING TIMESTAMP REC BUT NOT MATCHED EVEN ONE RECODR IN REC_VERSION

SELECT DISTINCT BDSF.`TIMESTAMP` , EDSH.EDSH_TIMESTAMP , BDSF.EXPD_REC_VER , EDSH.EDSH_REC_VER 
FROM SOURCE_04062014.BIZ_DETAIL_SCDB_FORMAT BDSF , EXPENSE_DETAIL_STARHUB EDSH 
WHERE BDSF.`TIMESTAMP` = EDSH.EDSH_TIMESTAMP OR BDSF.EXPD_REC_VER = EDSH.EDSH_REC_VER

-- ALL RECORD MATCHED IN EXPENSE DETAIL ELECTRICITY AND BIZ DETAIL NOT MATCHED IN REC_VERSION

SELECT DISTINCT BDSF.`TIMESTAMP`,EDE.EDE_TIMESTAMP , BDSF.EXPD_REC_VER, EDE.EDE_REC_VER 
FROM SOURCE_04062014.BIZ_DETAIL_SCDB_FORMAT BDSF , EXPENSE_DETAIL_ELECTRICITY EDE 
WHERE BDSF.`TIMESTAMP`=EDE.EDE_TIMESTAMP OR BDSF.EXPD_REC_VER= EDE.EDE_REC_VER

SELECT DISTINCT  EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB

SELECT DISTINCT  EDE_TIMESTAMP FROM EXPENSE_DETAIL_ELECTRICITY

-- ALL VALUES ARE MATCHED ON EXPENCE DIGITAL VOICE AND BIZ DETAIL 

SELECT DISTINCT BDSF.`TIMESTAMP`, EDDV.EDDV_TIMESTAMP ,BDSF.EXPD_DIGITAL_ACCOUNT_NO , EDDV.EDDV_DIGITAL_ACCOUNT_NO , BDSF.EXPD_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_VOICE_NO FROM SOURCE_04062014.BIZ_DETAIL_SCDB_FORMAT BDSF, EXPENSE_DETAIL_DIGITAL_VOICE EDDV WHERE BDSF.`TIMESTAMP` = EDDV.EDDV_TIMESTAMP AND BDSF.EXPD_DIGITAL_ACCOUNT_NO = EDDV.EDDV_DIGITAL_ACCOUNT_NO AND BDSF.EXPD_DIGITAL_VOICE_NO=EDDV.EDDV_DIGITAL_VOICE_NO

SELECT DISTINCT EDDV_TIMESTAMP, EDDV_DIGITAL_VOICE_NO, EDDV_DIGITAL_ACCOUNT_NO FROM EXPENSE_DETAIL_DIGITAL_VOICE

-- BIZ DETAIL HAVE 65 RECORDS.BUT HERE ONLY 29 RECORD ARE PRESENTED IN EXPENCE_DETAIL_AIRCON_SERVICE REMAIN 34 RECORD MISING .

SELECT DISTINCT BDSF.`TIMESTAMP`, DAS.EDAS_TIMESTAMP FROM SOURCE_04062014.BIZ_DETAIL_SCDB_FORMAT BDSF, EXPENSE_DETAIL_AIRCON_SERVICE DAS WHERE BDSF.`TIMESTAMP` = DAS.EDAS_TIMESTAMP

SELECT DISTINCT EDAS_TIMESTAMP FROM EXPENSE_DETAIL_AIRCON_SERVICE WHERE EDAS_TIMESTAMP='2014-02-13 11:18:57'

-- HERE MATCHING CAR NO FROM EXPENSE_DETAIL_CARPARK AND ONLY 6 DISTINCT RECORD MATCHING IN  BIZ_DETAIL_SCDB_FORMAT

SELECT  BDSF.EXPD_CAR_NO,EC.EDCP_CAR_NO, BDSF.`TIMESTAMP` , EC.EDCP_TIMESTAMP FROM SOURCE_04062014.BIZ_DETAIL_SCDB_FORMAT BDSF, EXPENSE_DETAIL_CARPARK EC WHERE BDSF.EXPD_CAR_NO=EC.EDCP_CAR_NO  AND BDSF.`TIMESTAMP` = EC.EDCP_TIMESTAMP

-- THE EXPENCE DETAIL STAFF SALAY VALUES NOT MATCHED WITH BIZ DETAIL 

SELECT DISTINCT BDSF.`TIMESTAMP`,DSS.EDSS_TIMESTAMP FROM SOURCE_04062014.BIZ_DETAIL_SCDB_FORMAT BDSF, EXPENSE_DETAIL_STAFF_SALARY DSS WHERE BDSF.`TIMESTAMP`=DSS.EDSS_TIMESTAMP

-- EXPENSE DAILY TABLE

SELECT *FROM EXPENSE_AIRCON_SERVICE_BY

-- THE EXPENCE AIRCON SERVICE BY DOES NOT MATCH ANY VALUE FROM THE SOURCE TABLE BIZ DAILY SCDB FORMAT

SELECT DISTINCT BIZ.`TIMESTAMP`,ESB.EASB_TIMESTAMP FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT BIZ , EXPENSE_AIRCON_SERVICE_BY ESB WHERE BIZ.`TIMESTAMP`=ESB.EASB_TIMESTAMP

SELECT  `TIMESTAMP` FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT WHERE `TIMESTAMP`='2012-03-17 09:04:00'

-- NOT MATCHED WITH EXPENSE AGENT WITH SOURCE BIZ DAILY TABLE

SELECT DISTINCT  BLSF.`TIMESTAMP` ,EAG.EA_TIMESTAMP FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT BLSF, EXPENSE_AGENT EAG WHERE BLSF.`TIMESTAMP` = EAG.EA_TIMESTAMP

-- 91 VALUES ARE MATCHED WITH EXPENSE AIRCON SERVICE AND BIZ DAILY 

SELECT DISTINCT BLSF.`TIMESTAMP`, EASE.EAS_TIMESTAMP FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT BLSF, EXPENSE_AIRCON_SERVICE EASE WHERE BLSF.`TIMESTAMP` = EASE.EAS_TIMESTAMP

SELECT DISTINCT EAS_TIMESTAMP FROM EXPENSE_AIRCON_SERVICE

-- IN THE EXPENSE ELECTRICITY DATAS FROM PERIOD DATA AND INVOICE DATA ARE SAME IN BIZ DAILY TABLE

SELECT DISTINCT EE.EE_INVOICE_DATE,BLSF.EXP_ELC_INVOICE_DATE , EE.EE_FROM_PERIOD, BLSF.EXP_ELC_FROM_PERIOD -- ,EE.EE_COMMENTS,BLSF.EXP_ELC_COMMENTS
FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT BLSF, EXPENSE_ELECTRICITY EE WHERE EE.EE_INVOICE_DATE=BLSF.EXP_ELC_INVOICE_DATE OR EE.EE_FROM_PERIOD= BLSF.EXP_ELC_FROM_PERIOD -- OR EE.EE_COMMENTS=BLSF.EXP_ELC_COMMENTS

-- ALL THE VALUES ARE MATCHED WITH BIZ DAILY AND EXPENCE DIGITAL VOICE

SELECT DISTINCT  EDV.EDV_INVOICE_DATE,BLSF.EXP_DIGITAL_INVOICE_DATE , EDV.EDV_FROM_PERIOD,BLSF.EXP_DIGITAL_FROM_PERIOD ,EDV.EDV_AMOUNT,BLSF.EXP_DIGITAL_AMOUNT
FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT BLSF, EXPENSE_DIGITAL_VOICE EDV WHERE EDV.EDV_INVOICE_DATE=BLSF.EXP_DIGITAL_INVOICE_DATE AND EDV.EDV_FROM_PERIOD=BLSF.EXP_DIGITAL_FROM_PERIOD OR EDV.EDV_AMOUNT=BLSF.EXP_DIGITAL_AMOUNT

-- ALL THE VALUES ARE MATCHED WITH BIZ DAILY AND EXPENSE FACULTY USE

SELECT DISTINCT  BLSF.EXP_FACILITY_INVOICE_DATE,EFU.EFU_INVOICE_DATE , BLSF.EXP_FACILITY_AMOUNT,EFU.EFU_AMOUNT , BLSF.`TIMESTAMP` , EFU.EFU_TIMESTAMP FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT BLSF, EXPENSE_FACILITY_USE EFU WHERE BLSF.EXP_FACILITY_INVOICE_DATE=EFU.EFU_INVOICE_DATE AND BLSF.EXP_FACILITY_AMOUNT=EFU.EFU_AMOUNT AND BLSF.`TIMESTAMP` = EFU.EFU_TIMESTAMP

-- ALL THE VALUES ARE MATCHED WITH BIZ DAILY AND EXPENSE CARPARK

SELECT DISTINCT ECP.ECP_INVOICE_DATE,BLSF.EXP_CAR_INVOICE_DATE , ECP.ECP_AMOUNT,BLSF.EXP_CAR_AMOUNT FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT BLSF, EXPENSE_CARPARK ECP WHERE ECP.ECP_INVOICE_DATE=BLSF.EXP_CAR_INVOICE_DATE AND ECP.ECP_AMOUNT=BLSF.EXP_CAR_AMOUNT

-- RECORD MATCHED WITH EXPENSE HOUSEKEEPING WITH SOURCE TABLE BIZ DAILY

SELECT DISTINCT EHK.EHK_WORK_DATE,BLSF.EXP_HK_WORK_DATE , EHK.EHK_DURATION,BLSF.EXP_HK_DURATION  FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT BLSF, EXPENSE_HOUSEKEEPING EHK WHERE EHK.EHK_WORK_DATE=BLSF.EXP_HK_WORK_DATE AND EHK.EHK_DURATION=BLSF.EXP_HK_DURATION

SELECT DISTINCT  EHK_DURATION FROM EXPENSE_HOUSEKEEPING

-- RECORDS ARE MATCHED WITH THE EXPENSE HOUSEKEEPING PAYMENT AND DAILY BIZ

SELECT DISTINCT  EHKP.EHKP_PAID_DATE,BLSF.EXP_HKP_PAID_DATE FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT BLSF, EXPENSE_HOUSEKEEPING_PAYMENT EHKP WHERE EHKP.EHKP_PAID_DATE=BLSF.EXP_HKP_PAID_DATE

SELECT DISTINCT EHKP_PAID_DATE,EHKP_FOR_PERIOD FROM EXPENSE_HOUSEKEEPING_PAYMENT 

-- ALL THE RECORDS ARE MATCHED WITH THE EXENSE HOUSEKEEPING UNIT AND BIZ DAILY

SELECT DISTINCT BLSF.EXP_HKP_UNIT_NO, EHKU.EHKU_UNIT_NO , BLSF.`TIMESTAMP`,EHKU.EHKU_TIMESTAMP FROM EXPENSE_HOUSEKEEPING_UNIT EHKU , SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT BLSF WHERE BLSF.EXP_HKP_UNIT_NO = EHKU.EHKU_UNIT_NO AND BLSF.`TIMESTAMP`=EHKU.EHKU_TIMESTAMP

-- ONLY 358 RECORDS ARE MATCHED ON BIZ DAILY AND EXPENCE PETTY CASH

SELECT DISTINCT BLSF.EXP_PETTY_DATE,EPC.EPC_DATE , EPC.EPC_BALANCE,BLSF.EXP_PETTY_CURRENT_BAL , EPC.EPC_COMMENTS,BLSF.EXP_PETTY_COMMENTS FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT BLSF, EXPENSE_PETTY_CASH EPC WHERE BLSF.EXP_PETTY_DATE=EPC.EPC_DATE AND EPC.EPC_BALANCE=BLSF.EXP_PETTY_CURRENT_BAL AND EPC.EPC_COMMENTS=BLSF.EXP_PETTY_COMMENTS

-- ALL RECORDS ARE MATCHED WITH BIZ DAILY AND EXPENSE PURCHASE NEW CARD

SELECT DISTINCT EPNC.EPNC_NUMBER,SRCC.EXP_CARD_NUMBER ,  EPNC.EPNC_AMOUNT ,SRCC.EXP_CARD_AMOUNT
 FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT SRCC, EXPENSE_PURCHASE_NEW_CARD EPNC WHERE EPNC.EPNC_NUMBER=SRCC.EXP_CARD_NUMBER AND EPNC.EPNC_AMOUNT =SRCC.EXP_CARD_AMOUNT

-- ALL VALUES ARE MATCHED WITH BIZ DAILY AND EXPENSE MOVING IN AND OUT

SELECT DISTINCT EMIO.EMIO_AMOUNT,STC.EXP_MOVI_IN_OUT_AMOUNT
, EMIO.EMIO_INVOICE_DATE,STC.EXP_MOVI_IN_OUT_INVOICE_DATE FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT STC, EXPENSE_MOVING_IN_AND_OUT EMIO WHERE EMIO.EMIO_AMOUNT=STC.EXP_MOVI_IN_OUT_AMOUNT
AND EMIO.EMIO_INVOICE_DATE=STC.EXP_MOVI_IN_OUT_INVOICE_DATE

-- ALL VALUES ARE MATCHED WITH BIZ DAILY AND EXPENSE STARHUB

SELECT DISTINCT ESH.ESH_AMOUNT,STCB.EXP_SHB_AMOUNT ,ESH.ESH_INVOICE_DATE,STCB.EXP_SHB_INVOICE_DATE FROM SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT STCB, EXPENSE_STARHUB ESH WHERE ESH.ESH_AMOUNT=STCB.EXP_SHB_AMOUNT AND ESH.ESH_INVOICE_DATE=STCB.EXP_SHB_INVOICE_DATE

SELECT DISTINCT ESH_AMOUNT, ESH_INVOICE_DATE FROM EXPENSE_STARHUB

-- 1471 VAULES ARE MATCHED WITH EXPENSE UNIT AND  BIZ DAILY

SELECT DISTINCT EUT.EU_INVOICE_DATE,SCB.EXP_UNIT_INVOICE_DATE ,EUT.EU_AMOUNT,SCB.EXP_UNIT_AMOUNT
 FROM  SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT SCB, EXPENSE_UNIT EUT 
 WHERE EUT.EU_INVOICE_DATE=SCB.EXP_UNIT_INVOICE_DATE AND EUT.EU_AMOUNT=SCB.EXP_UNIT_AMOUNT
-- ALL VALUES ARE MATCHED
SELECT DISTINCT EUT.EU_INVOICE_DATE,SCB.EXP_UNIT_INVOICE_DATE FROM  SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT SCB, EXPENSE_UNIT EUT WHERE EUT.EU_INVOICE_DATE=SCB.EXP_UNIT_INVOICE_DATE
-- ALL ARE MATCHED
SELECT DISTINCT EUT.EU_AMOUNT,SCB.EXP_UNIT_AMOUNT FROM  SOURCE_04062014.BIZ_DAILY_SCDB_FORMAT SCB, EXPENSE_UNIT EUT WHERE EUT.EU_AMOUNT=SCB.EXP_UNIT_AMOUNT


SELECT DISTINCT EU_AMOUNT FROM EXPENSE_UNIT
SELECT DISTINCT EU_INVOICE_DATE FROM EXPENSE_UNIT

-- PERSONAL TABLE

-- ALL THE VALUES ARE MATCHED WITH THE SOURCE PERSONAL SCDB FORMAT AND PERSONAL EXPENC

SELECT * FROM EXPENSE_PERSONAL
SELECT DISTINCT EP.EP_INVOICE_ITEMS,PSF.PE_PERSONAL_INVOICE_ITEMS
FROM SASI_SOURCE_SCHEMA.PERSONAL_SCDB_FORMAT PSF, EXPENSE_PERSONAL EP 
WHERE  EP.EP_INVOICE_ITEMS=PSF.PE_PERSONAL_INVOICE_ITEMS

SELECT DISTINCT EP.EP_INVOICE_DATE,PSF.PE_PERSONAL_INVOICE_DATE
FROM SASI_SOURCE_SCHEMA.PERSONAL_SCDB_FORMAT PSF, EXPENSE_PERSONAL EP WHERE EP.EP_INVOICE_DATE=PSF.PE_PERSONAL_INVOICE_DATE 

-- 1RECORD IS MISSING IN DESTINATION AMOUNT 7.354

SELECT DISTINCT EP.EP_AMOUNT,PSF.PE_PERSONAL_AMOUNT
FROM SASI_SOURCE_SCHEMA.PERSONAL_SCDB_FORMAT PSF, EXPENSE_PERSONAL EP WHERE  EP.EP_AMOUNT=PSF.PE_PERSONAL_AMOUNT 

SELECT DISTINCT EP.EP_AMOUNT,PSF.PE_PERSONAL_AMOUNT
FROM SASI_SOURCE_SCHEMA.PERSONAL_SCDB_FORMAT PSF LEFT JOIN EXPENSE_PERSONAL EP ON  EP.EP_AMOUNT=PSF.PE_PERSONAL_AMOUNT 

SELECT DISTINCT EP_AMOUNT FROM EXPENSE_PERSONAL WHERE EP_AMOUNT = 7.354
SELECT DISTINCT *FROM EXPENSE_PERSONAL WHERE EP_INVOICE_DATE='2013-02-27'

-- 4 RECORD MISSING IN INVOICE FROM (BY:MOS BURGER BY: , GOLDEN SHOE, WRITTEN IN CHINES CHARECTER, CLOTHING)

SELECT DISTINCT  EP. EP_INVOICE_FROM,PSF.PE_PERSONAL_INVOICE_FROM 
FROM SASI_SOURCE_SCHEMA.PERSONAL_SCDB_FORMAT PSF, EXPENSE_PERSONAL EP WHERE  EP. EP_INVOICE_FROM=PSF.PE_PERSONAL_INVOICE_FROM

SELECT DISTINCT  EP. EP_INVOICE_FROM,PSF.PE_PERSONAL_INVOICE_FROM  
FROM SASI_SOURCE_SCHEMA.PERSONAL_SCDB_FORMAT PSF LEFT JOIN EXPENSE_PERSONAL EP ON  EP. EP_INVOICE_FROM=PSF.PE_PERSONAL_INVOICE_FROM

-- BABY

-- 1RECORD IS MISSING IN DESTINATION EB_AMOUNT 6.504
 
SELECT DISTINCT EB.EB_AMOUNT,PSF.PE_BABY_AMOUNT 
FROM SASI_SOURCE_SCHEMA.PERSONAL_SCDB_FORMAT PSF, EXPENSE_BABY EB  WHERE EB.EB_AMOUNT=PSF.PE_BABY_AMOUNT  

SELECT DISTINCT EB.EB_AMOUNT,PSF.PE_BABY_AMOUNT 
FROM SASI_SOURCE_SCHEMA.PERSONAL_SCDB_FORMAT PSF LEFT JOIN EXPENSE_BABY EB  ON EB.EB_AMOUNT=PSF.PE_BABY_AMOUNT  

-- ALL ARE MATCH

SELECT DISTINCT EB.EB_INVOICE_ITEMS,PSF.PE_BABY_INVOICE_ITEMS 
FROM SASI_SOURCE_SCHEMA.PERSONAL_SCDB_FORMAT PSF, EXPENSE_BABY EB  WHERE EB.EB_INVOICE_ITEMS=PSF.PE_BABY_INVOICE_ITEMS  

-- ALL ARE MATCHED

SELECT DISTINCT PSF.PE_BABY_INVOICE_FROM,EB.EB_INVOICE_FROM 
FROM SASI_SOURCE_SCHEMA.PERSONAL_SCDB_FORMAT PSF, EXPENSE_BABY EB  WHERE PSF.PE_BABY_INVOICE_FROM=EB.EB_INVOICE_FROM 

-- ALL ARE MATCHED

SELECT DISTINCT PSF.PE_BABY_INVOICE_DATE,EB.EB_INVOICE_DATE  
FROM SASI_SOURCE_SCHEMA.PERSONAL_SCDB_FORMAT PSF, EXPENSE_BABY EB  WHERE PSF.PE_BABY_INVOICE_DATE=EB.EB_INVOICE_DATE 

-- CAR 

-- ALL ARE MATCHED

SELECT DISTINCT  PSF.PE_CAR_EXP_AMOUNT ,EC.EC_AMOUNT 
FROM SASI_SOURCE_SCHEMA.PERSONAL_SCDB_FORMAT PSF, EXPENSE_CAR EC  WHERE PSF.PE_CAR_EXP_AMOUNT = EC.EC_AMOUNT

-- ALL ARE MATCHED

SELECT DISTINCT  PSF.PE_CAR_EXP_INVOICE_DATE ,EC.EC_INVOICE_DATE  
FROM SASI_SOURCE_SCHEMA.PERSONAL_SCDB_FORMAT PSF, EXPENSE_CAR EC  WHERE PSF.PE_CAR_EXP_INVOICE_DATE =EC.EC_INVOICE_DATE

-- ALL ARE MATCHED

SELECT DISTINCT  PSF.PE_CAR_EXP_INVOICE_ITEMS ,EC.EC_INVOICE_ITEMS  
FROM SASI_SOURCE_SCHEMA.PERSONAL_SCDB_FORMAT PSF, EXPENSE_CAR EC  WHERE PSF.PE_CAR_EXP_INVOICE_ITEMS =EC.EC_INVOICE_ITEMS 

-- 1 RECORD MISSSING TAT IS COLD STORAGE

SELECT DISTINCT  PSF.PE_CAR_EXP_INVOICE_FROM ,EC.EC_INVOICE_FROM 
FROM SASI_SOURCE_SCHEMA.PERSONAL_SCDB_FORMAT PSF, EXPENSE_CAR EC  WHERE PSF.PE_CAR_EXP_INVOICE_FROM =EC.EC_INVOICE_FROM 

-- CAR LOAN

--


-- PETTY CASH
-- BIZ DAILY 
-- ALL ARE MATCHED
SELECT DISTINCT BDS.EXP_PETTY_DATE , PC.EPC_DATE FROM SASI_SOURCE_SCHEMA.BIZ_DAILY_SCDB_FORMAT BDS, EXPENSE_PETTY_CASH PC WHERE BDS.EXP_PETTY_DATE = PC.EPC_DATE
-- ALL ARE MATCHED
SELECT DISTINCT BDS.EXP_PETTY_INVOICE_ITEMS , PC.EPC_INVOICE_ITEMS FROM SASI_SOURCE_SCHEMA.BIZ_DAILY_SCDB_FORMAT BDS, EXPENSE_PETTY_CASH PC WHERE BDS.EXP_PETTY_INVOICE_ITEMS = PC.EPC_INVOICE_ITEMS
-- ALL ARE MATCHED
SELECT DISTINCT BDS.EXP_PETTY_CURRENT_BAL  , PC.EPC_BALANCE FROM SASI_SOURCE_SCHEMA.BIZ_DAILY_SCDB_FORMAT BDS, EXPENSE_PETTY_CASH PC WHERE  BDS.EXP_PETTY_CURRENT_BAL = PC.EPC_BALANCE
-- PRESENTED IN 1838 IN SOURCE AND 256 ARE MATCHED RECORD IN DESTINATION
SELECT DISTINCT BDS.`TIMESTAMP`, PC.EPC_TIMESTAMP FROM SASI_SOURCE_SCHEMA.BIZ_DAILY_SCDB_FORMAT BDS, EXPENSE_PETTY_CASH PC WHERE   BDS.`TIMESTAMP` = PC.EPC_TIMESTAMP


SELECT DISTINCT EB_INVOICE_ITEMS FROM EXPENSE_BABY WHERE  EB_INVOICE_ITEMS IS NOT NULL
SELECT DISTINCT EB_AMOUNT FROM EXPENSE_BABY WHERE EB_AMOUNT IS NOT NULL
SELECT DISTINCT EP_INVOICE_FROM   FROM EXPENSE_PERSONAL WHERE EP_INVOICE_FROM IS NOT NULL
SELECT DISTINCT EP_AMOUNT FROM EXPENSE_PERSONAL WHERE EP_AMOUNT IS NOT NULL
SELECT DISTINCT EP_INVOICE_DATE FROM EXPENSE_PERSONAL WHERE  EP_INVOICE_DATE IS NOT NULL 
SELECT DISTINCT EP_INVOICE_ITEMS FROM EXPENSE_PERSONAL WHERE EP_INVOICE_ITEMS IS NOT NULL
-- ALL THE VALUES ARE MATCHED WITH THE SOURCE PERSONAL SCDB FORMAT AND EXPENC CAR

SELECT DISTINCT ECAR.EC_AMOUNT,PER.PE_CAR_EXP_AMOUNT , ECAR.EC_TIMESTAMP,PER.`TIMESTAMP` FROM SOURCE_04062014.PERSONAL_SCDB_FORMAT PER, EXPENSE_CAR ECAR WHERE ECAR.EC_AMOUNT=PER.PE_CAR_EXP_AMOUNT AND ECAR.EC_TIMESTAMP=PER.`TIMESTAMP`

SELECT DISTINCT ECAR.EC_INVOICE_DATE ,PER.PE_CAR_EXP_INVOICE_DATE FROM SOURCE_04062014.PERSONAL_SCDB_FORMAT PER, EXPENSE_CAR ECAR WHERE ECAR.EC_INVOICE_DATE =PER.PE_CAR_EXP_INVOICE_DATE

-- ALL THE VALUES ARE MATCHED WITH THE SOURCE PERSONAL SCDB FORMAT AND ENPENC CAR LONE

SELECT DISTINCT  ECL.ECL_AMOUNT,SON.PE_CARLOAN_AMOUNT ,ECL.ECL_PAID_DATE,SON.PE_CARLOAN_PAID_DATE FROM SOURCE_04062014.PERSONAL_SCDB_FORMAT SON, EXPENSE_CAR_LOAN ECL WHERE ECL.ECL_AMOUNT= SON.PE_CARLOAN_AMOUNT AND ECL.ECL_PAID_DATE=SON.PE_CARLOAN_PAID_DATE

-- THERE ARE 327 RECORDS ARE MATCHED WITH EXPENC BABY AND PERSONAL SCBD FORMAT BUT SOURCE CONTAIN 328 DISTINCT VALUES

SELECT DISTINCT EXB.EB_TIMESTAMP , FON.`TIMESTAMP`, EXB.EB_INVOICE_DATE,FON.PE_BABY_INVOICE_DATE, EXB.EB_AMOUNT,FON.PE_BABY_AMOUNT FROM SOURCE_04062014.PERSONAL_SCDB_FORMAT FON, EXPENSE_BABY EXB WHERE EXB.EB_TIMESTAMP = FON.`TIMESTAMP` AND EXB.EB_INVOICE_DATE=FON.PE_BABY_INVOICE_DATE AND  EXB.EB_AMOUNT=FON.PE_BABY_AMOUNT

SELECT DISTINCT EB_INVOICE_DATE ,EB_TIMESTAMP FROM EXPENSE_BABY WHERE EB_INVOICE_DATE IS NOT NULL AND EB_TIMESTAMP IS NOT NULL 












