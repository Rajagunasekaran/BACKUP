<?php
class Mdl_access_card_assign extends CI_Model{
    public function Initial_data($ErrorMessage){
        $this->db->select('UNIT_ID,UNIT_NO,CED_REC_VER,CUSTOMER_ID,CUSTOMERNAME,DATE_FORMAT(CLP_STARTDATE,"%d-%m-%Y") as CLP_STARTDATE,DATE_FORMAT(CLP_ENDDATE,"%d-%m-%Y") as CLP_ENDDATE,DATE_FORMAT(CLP_PRETERMINATE_DATE,"%d-%m-%Y") as CLP_PRETERMINATE_DATE');
        $this->db->from('VW_CARDASSIGN');
        $this->db->order_by('UNIT_NO');
        $this->db->order_by('CUSTOMERNAME');
        $this->db->order_by('CED_REC_VER');
        $query = $this->db->get();
        $result1 = $query->result();
        $resultset=array($result1,$ErrorMessage);
        return $resultset;
    }
    public function Customer_details($CA_recver,$CA_unit,$CA_custid,$USERSTAMP){
        $flag=0;
        $prev_recver='';
        $this->db->select('CLP.UASD_ID');
        $this->db->from('CUSTOMER_LP_DETAILS CLP,CUSTOMER_ENTRY_DETAILS CED');
        $this->db->where('CLP.CUSTOMER_ID='.$CA_custid.' AND CED.CED_REC_VER='.($CA_recver-1).' and CLP.CUSTOMER_ID=CED.CUSTOMER_ID AND CLP.CED_REC_VER=CED.CED_REC_VER AND CED.CED_PRETERMINATE IS NOT NULL AND CLP.UASD_ID IS NULL AND CLP.CED_REC_VER IN (SELECT CED_REC_VER  FROM VW_CARDASSIGN)');
        $query = $this->db->get();
        $resultrow = $query->result();
        if(count($resultrow)>=1){
            $flag=1;
            $prev_recver=$CA_recver-1;
        }
        if($flag==1){
            $this->db->select('CLP.UASD_ID');
            $this->db->from('CUSTOMER_LP_DETAILS CLP,CUSTOMER_ENTRY_DETAILS CED');
            $this->db->where('CLP.CUSTOMER_ID='.$CA_custid.' AND CED.CED_REC_VER='.($prev_recver-1).' and CLP.CUSTOMER_ID=CED.CUSTOMER_ID AND CLP.CED_REC_VER=CED.CED_REC_VER AND CED.CED_PRETERMINATE IS NOT NULL AND CLP.UASD_ID IS NULL and CLP.CED_REC_VER in (select CED_REC_VER  FROM VW_CARDASSIGN)');
            $query = $this->db->get();
            $resultrow1 = $query->result();
            if(count($resultrow1)>=1){
                $prev_recver=$prev_recver-1;
            }
        }
        $CA_today_date=date('Y-M-d');
        $this->db->select('URTD.URTD_ROOM_TYPE');
        $this->db->from('UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD,CUSTOMER_ENTRY_DETAILS CED');
        $this->db->where('(CED.CUSTOMER_ID='.$CA_custid.') AND (CED.CED_REC_VER='.$CA_recver.') AND (UASD.UASD_ID=CED.UASD_ID) AND (UASD.URTD_ID=URTD.URTD_ID)');
        $roomtype = $this->db->get();
        $CA_roomtype = $roomtype->row()->URTD_ROOM_TYPE;
    // sp
        $callquery="CALL SP_CUSTOMER_CARD_ASSIGN_TEMP_FEE_DETAIL(".$CA_custid.",'".$USERSTAMP."',@CARD_FEETMPTBLNAM)";
        $this->db->query($callquery);
        $outparm_query = 'SELECT @CARD_FEETMPTBLNAM AS TEMP_TABLE';
        $outparm_result = $this->db->query($outparm_query);
        $tablename=$outparm_result->row()->TEMP_TABLE;
        $this->db->select();
        $this->db->from('CUSTOMER_ENTRY_DETAILS CED,NATIONALITY_CONFIGURATION NC,UNIT U');
        $this->db->join('CUSTOMER_COMPANY_DETAILS CCD', 'CED.CUSTOMER_ID=CCD.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER_LP_DETAILS CLP', 'CED.CUSTOMER_ID=CLP.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER_ACCESS_CARD_DETAILS CACD', 'CLP.CUSTOMER_ID=CACD.CUSTOMER_ID AND CLP.UASD_ID=CACD.UASD_ID' , 'left');
        $this->db->join('UNIT_ACCESS_STAMP_DETAILS UASD', 'CLP.UASD_ID=UASD.UASD_ID AND CACD.UASD_ID=UASD.UASD_ID' , 'left');
        $this->db->join($tablename.' CF', 'CED.CUSTOMER_ID=CF.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER C', 'CED.CUSTOMER_ID=C.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER_PERSONAL_DETAILS CPD', 'CED.CUSTOMER_ID=CPD.CUSTOMER_ID' , 'left');
        $this->db->where('U.UNIT_ID=CED.UNIT_ID AND CLP.CUSTOMER_ID=CED.CUSTOMER_ID AND CLP.CED_REC_VER=CED.CED_REC_VER AND CLP.CLP_TERMINATE IS NULL AND CACD.CACD_VALID_TILL IS NULL AND (CED.UNIT_ID=U.UNIT_ID) AND (CED.CUSTOMER_ID='.$CA_custid.') AND (CPD.NC_ID=NC.NC_ID) AND (CED.CED_REC_VER=CF.CUSTOMER_VER) AND (CED.CED_REC_VER='.$CA_recver.') AND CED.CED_REC_VER=CLP.CED_REC_VER');
        $this->db->order_by('CED.CED_REC_VER');
        $query = $this->db->get();
        $CA_guest_array=[];
        $CA_cardno='';
        foreach ($query->result_array() as $row)
        {
            $CA_cardno2 = $row["UASD_ACCESS_CARD"];
            if($CA_cardno2!=null){
                $CA_guestcardno = $row["CLP_GUEST_CARD"];
                if($CA_guestcardno!='X'){
                    $CA_cardno = $row["UASD_ACCESS_CARD"];
                    $CA_startdate = $row["CLP_STARTDATE"];
                    $CA_enddate = $row["CLP_ENDDATE"];
                }
                else {
                    $CA_cardno1 = $row["UASD_ACCESS_CARD"];
                    $CA_guest_array[]=$CA_cardno1;
                }
            }
            else{
                $CA_startdate = $row["CLP_STARTDATE"];
                $CA_enddate = $row["CLP_ENDDATE"];
            }
            $CA_company = $row["CCD_COMPANY_NAME"];
            $CA_firstname = $row["CUSTOMER_FIRST_NAME"];
            $CA_lastname = $row["CUSTOMER_LAST_NAME"];
            $CA_deposit = $row["CC_DEPOSIT"];
            $CA_rental = $row["CC_PAYMENT_AMOUNT"];
            $CA_electricitycap = $row["CC_ELECTRICITY_CAP"];
            $CA_airconfixedfee = $row["CC_AIRCON_FIXED_FEE"];
            $CA_airconquartelyfee = $row["CC_AIRCON_QUARTERLY_FEE"];
            $CA_epno = $row["CPD_EP_NO"];
            $CA_epdate = $row["CPD_EP_DATE"];
            $CA_passportno = $row["CPD_PASSPORT_NO"];
            $CA_passportdate = $row["CPD_PASSPORT_DATE"];
            $CA_drycleanfee = $row["CC_DRYCLEAN_FEE"];
            $CA_processingfee = $row["CC_PROCESSING_FEE"];
            $CA_checkoutcleaningfee = $row["CC_CHECKOUT_CLEANING_FEE"];
            $CA_noticeperiod = $row["CED_NOTICE_PERIOD"];
            $CA_noticedate = $row["CED_NOTICE_START_DATE"];
            $CA_nationality = $row["NC_DATA"];
            $CA_dob= $row["CPD_DOB"];
            $CA_lease=$row["CED_LEASE_PERIOD"];
            $CA_mobile = $row["CPD_MOBILE"];
            $CA_mobile1 = $row["CPD_INTL_MOBILE"];
            $CA_officeno = $row["CCD_OFFICE_NO"];
            $CA_email = $row["CPD_EMAIL"];
            $CA_extension= $row["CED_EXTENSION"];
            $CA_redver = $row["CED_REC_VER"];
            $CA_canceldate = $row["CED_CANCEL_DATE"];
            $CA_comments = $row["CPD_COMMENTS"];
            $CA_QUARTERS=$row["CED_QUARTERS"];
        }
        $CA_alldetails_array=array('firstname'=>$CA_firstname,'lastname'=>$CA_lastname,'email'=>$CA_email,'mobile1'=>$CA_mobile,'mobile2'=>$CA_mobile1,'officeno'=>$CA_officeno,'dob'=>$CA_dob,'passportno'=>$CA_passportno,'passportdate'=>$CA_passportdate,'epno'=>$CA_epno,'epdate'=>$CA_epdate,'roomtype'=>$CA_roomtype,'cardno'=>$CA_cardno,'startdate'=>$CA_startdate,'enddate'=>$CA_enddate,'lease'=>$CA_lease,'QUARTERS'=>$CA_QUARTERS,'noticeperiod'=>$CA_noticeperiod,'noticedate'=>$CA_noticedate,'electricitycap'=>$CA_electricitycap,'drycleanfee'=>$CA_drycleanfee,'checkoutcleaningfee'=>$CA_checkoutcleaningfee,'deposit'=>$CA_deposit,'rental'=>$CA_rental,'processingfee'=>$CA_processingfee,'comments'=>$CA_comments,'company'=>$CA_company,'nationality'=>$CA_nationality,'airconfixedfee'=>$CA_airconfixedfee,'airconquartelyfee'=>$CA_airconquartelyfee);
        $CA_available_cards=$this->CA_show_availablecards($CA_unit,$CA_firstname,$CA_lastname,$CA_recver,$CA_custid);
        $CA_alldata_array=array($CA_alldetails_array,$CA_guest_array,$CA_available_cards,$flag,$prev_recver);
        $drop_query = "DROP TABLE ".$tablename."";
        $this->db->query($drop_query);
        return ($CA_alldata_array);
    }
    public function CA_show_availablecards($CA_unit,$CA_firstname,$CA_lastname,$CA_recver,$CA_custid){
        $CA_returnarray=[];
        $CA_cust_cardarray=[];
        $CA_avail_cardarray=[];
        $CA_customername=$CA_firstname.' '.$CA_lastname;
        $CA_customername1=$CA_firstname.'_'.$CA_lastname;
        $CA_customername1=str_replace(' ',"__",$CA_customername1);
        $this->db->select();
        $this->db->distinct();
        $this->db->from('UNIT_ACCESS_STAMP_DETAILS UASD');
        $this->db->join('CUSTOMER_LP_DETAILS CLP', 'UASD.UASD_ID=CLP.UASD_ID' , 'left');
        $this->db->join('CUSTOMER C', 'CLP.CUSTOMER_ID=C.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER_ACCESS_CARD_DETAILS CACD', 'CLP.CUSTOMER_ID=CACD.CUSTOMER_ID AND UASD.UASD_ID=CACD.UASD_ID' , 'left');
        $this->db->where('(CLP.CUSTOMER_ID='.$CA_custid.') AND (CLP.CLP_TERMINATE IS NULL) AND CACD.ACN_ID IS NULL AND CLP.CED_REC_VER='.$CA_recver);
        $this->db->group_by('UASD_ACCESS_CARD');
        $this->db->order_by('CLP_GUEST_CARD');
        $CA_cust_access_card_rs = $this->db->get();
        $CA_cardno='';
        foreach ($CA_cust_access_card_rs->result_array() as $row)
        {
            $CA_cardno = $row["UASD_ACCESS_CARD"];
            $first_name=$row["CUSTOMER_FIRST_NAME"];
            $second_name=$row["CUSTOMER_LAST_NAME"];
            $guest_card=$row["CLP_GUEST_CARD"];
            $first_name=str_replace(' ',"__",$first_name);
            $second_name=str_replace(' ',"__",$second_name);
            if($CA_cardno=="")continue;
            else
            {
                if($guest_card!='X'){
                    $CA_cust_cardarray[]=$CA_cardno.'/'.$first_name.'_'.$second_name;
                }
                else{
                    $CA_cust_cardarray[]=$CA_cardno.'/'."GUEST";
                }
            }
        }
        $this->db->select('UASD_ACCESS_CARD');
        $this->db->from('UNIT_ACCESS_STAMP_DETAILS');
        $this->db->where('UNIT_ID IN (SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='.$CA_unit.') AND UASD_ACCESS_INVENTORY="X" AND UASD_ACCESS_CARD IS NOT NULL');
        $this->db->order_by('UASD_ACCESS_CARD');
        $CA_access_card = $this->db->get();
        foreach ($CA_access_card->result_array() as $row)
        {
            $CA_avail_cardarray[]=$row["UASD_ACCESS_CARD"];
        }
        if(count($CA_cust_cardarray)==0){
            $CA_cardlbl_array=[];
            for($i=0;$i<count($CA_avail_cardarray);$i++)
            {
                if($i==0)
                {
                    $CA_cardlbl_array[]=$CA_customername1;
                }
                else if($i>0)
                {
                    $CA_cardlbl_array[]="GUEST ".$i;
                }
                if($i>2)break;
            }
        }
        else {
            $CA_total_card_lenth=count($CA_cust_cardarray)+count($CA_avail_cardarray);
            $CA_cardlbl_array=[];
            for($k=0;$k<$CA_total_card_lenth;$k++)
            {
                if($k==0)
                {
                    $CA_cardlbl_array[]=$CA_customername1;
                }
                else if($k>0)
                {
                    $CA_cardlbl_array[]="GUEST ".$k;
                }
                if($k>2)break;
            }
        }
        $CA_returnarray=[$CA_cust_cardarray,$CA_avail_cardarray,$CA_cardlbl_array];
        return $CA_returnarray;
    }
}