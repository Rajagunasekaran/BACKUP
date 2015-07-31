<?php
class Mdl_unit_creation_search_update extends CI_Model{
    public function Initial_data($flag){
        $this->db->select('URTD_ROOM_TYPE');
        $this->db->distinct();
        $this->db->from('UNIT_ROOM_TYPE_DETAILS');
        $this->db->where('URTD_ROOM_TYPE IS NOT NULL');
        $this->db->order_by('URTD_ROOM_TYPE');
        $query1 = $this->db->get();
        $result1=[];
        foreach($query1->result_array() as $row){
            $result1[]=$row['URTD_ROOM_TYPE'];
        }
        $this->db->select('USDT_DATA');
        $this->db->distinct();
        $this->db->from('UNIT_STAMP_DUTY_TYPE');
        $this->db->where('USDT_DATA IS NOT NULL');
        $this->db->order_by('USDT_DATA');
        $query2 = $this->db->get();
        $result2=[];
        foreach($query2->result_array() as $row){
            $result2[]=$row['USDT_DATA'];
        }
        $this->load->model('Eilib/Common_function');
        $ErrorMessage= $this->Common_function->getErrorMessageList('1,2,7,8,9,10,11,30,308,400,458,463,464,466,467');
        $UC_result=array($result1,$result2,$ErrorMessage,$flag);
        return $UC_result;
    }
    public function Check_existing_input($UC_source,$UC_chkinput){
        $this->load->model('Eilib/Common_function');
        $UC_flag=[];
        if($UC_source=="UC_tb_unitno"){
            $UC_flag=$this->Common_function->CheckUnitnoExists($UC_chkinput);
        }
        elseif($UC_source=="UC_tb_accesscard"){
            $UC_flag=$this->Common_function->Check_ExistsCard($UC_chkinput);
        }
        elseif($UC_source=="UC_tb_newroomtype") {
            $UC_chkroomtype='';
            $UC_chkroomtype=$this->db->escape_like_str($UC_chkinput);
            $UC_flag=$this->Common_function->Check_ExistsRmType($UC_chkroomtype);
        }
        elseif($UC_source=="UC_tb_newstamptype") {
            $UC_chkstamptype='';
            $UC_chkstamptype=$this->db->escape_like_str($UC_chkinput);
            $UC_flag=$this->Common_function->Check_ExistsStampduty($UC_chkstamptype);
        }
        elseif(($UC_source=="UNIT_tb_doorcode")||($UC_source=="UNIT_tb_weblogin")){
            $UC_flag[0]=1;
            $UC_flag=$this->Common_function->Check_ExistsDoorcodeLogin($UC_chkinput,$UC_source);
        }
        return $UC_flag;
    }
    public function Unit_saveprocess($nonei,$newroomtype,$newstamptype,$oldroomtype,$oldstamptype,$UserStamp){
        try{
            $UC_unitnumber = $_POST['UC_tb_unitno'];
            $UC_unitrental = $_POST['UC_tb_unitrentalamt'];
            $UC_startdate = $_POST['UC_db_startdate'];
            $UC_enddate = $_POST['UC_db_enddate'];
            $UC_unitdeposite = $_POST['UC_tb_unitdeposite'];
            $UC_accesscard = $_POST['UC_tb_accesscard'];
            $UC_stampdutydate = $_POST['UC_db_stampdutydate'];
            $UC_stampamount = $_POST['UC_tb_stampamount'];
            $UC_doorcode = $_POST['UNIT_tb_doorcode'];
            $UC_weblogin = $_POST['UNIT_tb_weblogin'];
            $UC_webpass = $_POST['UC_tb_webpass'];
            $UC_comments =$_POST['UC_ta_comments'];
            $UC_accntnumber = $_POST['UC_tb_accntnumber'];
            $UC_accntname = $_POST['UC_tb_accntname'];
            $UC_bankcode = $_POST['UC_tb_bankcode'];
            $UC_branchcode = $_POST['UC_tb_branchcode'];
            $UC_bankaddrs = $_POST['UC_ta_address'];
            $UC_nonei=$nonei; $UC_newroomtype=$newroomtype; $UC_newstamptype=$newstamptype;
            $UC_oldroomtype=$oldroomtype; $UC_oldstamptype=$oldstamptype;
            if($UC_comments!='')
                $UC_comments=$this->db->escape_like_str($UC_comments);
            if($UC_accntname!='')
                $UC_accntname=$this->db->escape_like_str($UC_accntname);
            if($UC_bankaddrs!='')
                $UC_bankaddrs=$this->db->escape_like_str($UC_bankaddrs);
            $UC_finalroomtype='';$UC_finalstamptype='';
            $UC_alreadyexist_flag_room='';
            if($UC_newroomtype!=''){
                $UC_finalroomtype=$UC_newroomtype;
                $UC_alreadyexist_flag_room=$this->Check_existing_input('UC_tb_newroomtype',$UC_finalroomtype);
            }
            elseif($UC_oldroomtype!=''){
                $UC_finalroomtype=$UC_oldroomtype;
            }
            $UC_alreadyexist_flag_stamp='';
            if($UC_newstamptype!=''){
                $UC_finalstamptype =$UC_newstamptype;
                $UC_alreadyexist_flag_stamp=$this->Check_existing_input('UC_tb_newstamptype',$UC_finalstamptype);
            }
            elseif($UC_oldstamptype!=''){
                $UC_finalstamptype =$UC_oldstamptype;
            }
            if($UC_nonei=='X'){
                $UC_nonei="'X'";
            }
            else{
                $UC_nonei='null';
            }
            if($UC_stampdutydate==""){
                $UC_stampdutydate='null';
            }
            else
            {
                $UC_stampdutydate = date('Y-m-d',strtotime($UC_stampdutydate));
                $UC_stampdutydate="'".$UC_stampdutydate."'";
            }
            if($UC_finalroomtype=='SELECT'){
                $UC_finalroomtype='null';
            }
            else{
                $UC_finalroomtype=$this->db->escape_like_str($UC_finalroomtype);
                $UC_finalroomtype="'".$UC_finalroomtype."'";
            }
            if($UC_finalstamptype=='SELECT'){
                $UC_finalstamptype='null';
            }
            else{
                $UC_finalstamptype=$this->db->escape_like_str($UC_finalstamptype);
                $UC_finalstamptype="'".$UC_finalstamptype."'";
            }
            $UC_alreadyexist_flag_unit='';
            $UC_alreadyexist_flag_card='';
            $UC_alreadyexist_flag_unit=$this->Check_existing_input('UC_tb_unitnumber',$UC_unitnumber);
            if($UC_accesscard==''){
                $UC_accesscard='null';
            }
            else{
                $UC_alreadyexist_flag_card=$this->Check_existing_input('UC_tb_accesscard',$UC_accesscard);
            }
            if($UC_unitdeposite==''){
                $UC_unitdeposite='null';
            }
            if($UC_stampamount==''){
                $UC_stampamount='null';
            }
            $UC_startdate = date('Y-m-d',strtotime($UC_startdate));
            $UC_enddate = date('Y-m-d',strtotime($UC_enddate));
            if(($UC_alreadyexist_flag_unit==true)||($UC_alreadyexist_flag_card=='true')||($UC_alreadyexist_flag_stamp=='true')||($UC_alreadyexist_flag_room=='true')){
                $UC_alreadyexist_flag=true;
                return array('','','',$UC_alreadyexist_flag);
            }
            $this->db->trans_begin();
            $UC_creatstmt ="CALL SP_UNIT_CREATION_INSERT(".$UC_unitnumber.",".$UC_unitrental.",'".$UC_startdate."','".$UC_enddate."',".$UC_nonei.",".$UC_unitdeposite.",'".$UserStamp."',".$UC_accesscard.",".$UC_finalroomtype.",".$UC_stampdutydate.",".$UC_finalstamptype.",".$UC_stampamount.",'".$UC_comments."','".$UC_doorcode."','".$UC_weblogin."','".$UC_webpass."','".$UC_accntnumber."','".$UC_accntname."','".$UC_bankcode."','".$UC_branchcode."','".$UC_bankaddrs."',@FLAG)";
            $this->db->query($UC_creatstmt);
            $outparm_query = 'SELECT @FLAG AS FLAG';
            $outparm_result = $this->db->query($outparm_query);
            $UC_flag_save=$outparm_result->row()->FLAG;
            if($UC_flag_save==1){
                $UC_flag_created='UC_flag_created';
            }
            else{
                $UC_flag_created=0;
            }
            if($UC_flag_save==1){

            }
            $UC_getroomstamp=$this->Initial_data($UC_flag_created);
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
            }
            else{
                $this->db->trans_commit();
            }
            return $UC_getroomstamp;
        }
        catch(Exception $e){
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
            }
            else{
                $this->db->trans_rollback();
            }
            if($UC_flag_save==1){

            }
            log_message('error:',$e->getMessage());
            return;
        }
    }
    //--------------------------------------------UNIT SEARCH AND UPDATE---------------------------------------------//
    public function Usu_initial_data(){
        $this->db->select();
        $this->db->from('UNIT');
        $this->db->order_by('UNIT_NO');
        $query1 = $this->db->get();
        $result1=[];
        foreach($query1->result_array() as $row){
            $result1[]=$row['UNIT_NO'];
        }
        if($result1!=''){
            $this->db->select();
            $this->db->from('UNIT_CONFIGURATION');
            $this->db->where('UCN_ID IN (1,2,3,4,5,6,7,8,9,10,11,12)');
            $this->db->order_by('UCN_DATA');
            $query2 = $this->db->get();
            $result2=array();
            foreach($query2->result_array() as $row){
                $uid=$row['UCN_ID'];
                $udata=$row['UCN_DATA'];
                $result2[]=(object)['unitid'=>$uid,'unitdata'=>$udata];
            }
        }
        $this->load->model('Eilib/Common_function');
        $ErrorMessage= $this->Common_function->getErrorMessageList('1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,45,52,98,248,307,308,317,318,319,322,323,324,325,326,333,334,401,101,402,403,457,458');
        $UC_result=array($result1,$result2,$ErrorMessage);
        return $UC_result;
    }
    public function Usu_searchby_option($USU_unit_optionfetch,$USU_parentfunc,$USU_load_lb){
        $loaddta=[];
        $this->load->model('Eilib/Common_function');
        if(($USU_unit_optionfetch==9)||($USU_unit_optionfetch==8)||($USU_unit_optionfetch==5))
        {
            if($USU_unit_optionfetch==9){//ROOM TYPE WITH UNIT
                $USU_select_query_roomtype = "SELECT URTD_ROOM_TYPE FROM UNIT_ROOM_TYPE_DETAILS WHERE URTD_ID IN(SELECT URTD_ID FROM UNIT_ACCESS_STAMP_DETAILS) ORDER BY URTD_ROOM_TYPE ASC";
                $USU_separate_roomtype_rs = $this->db->query($USU_select_query_roomtype);
                foreach($USU_separate_roomtype_rs->result_array() as $row){
                    $roomtype=$row['URTD_ROOM_TYPE'];
                    $loaddta[]=($roomtype);
                }
            }
            elseif($USU_unit_optionfetch==8){//STAMP TYPE
                $USU_select_query_duty = "SELECT USDT_DATA FROM UNIT_STAMP_DUTY_TYPE WHERE USDT_DATA IS NOT NULL ORDER BY USDT_DATA ASC";
                $USU_separate_duty_rs = $this->db->query($USU_select_query_duty);
                foreach($USU_separate_duty_rs->result_array() as $row){
                    $dutydatatype=$row['USDT_DATA'];
                    $loaddta[]=($dutydatatype);
                }
            }
            elseif($USU_unit_optionfetch==5){//ROOM TYPE
                $USU_select_query_roomtypedata = "SELECT URTD_ROOM_TYPE FROM UNIT_ROOM_TYPE_DETAILS WHERE URTD_ROOM_TYPE IS NOT NULL ORDER BY URTD_ROOM_TYPE ASC";
                $USU_separate_room_rs = $this->db->query($USU_select_query_roomtypedata);
                foreach($USU_separate_room_rs->result_array() as $row){
                    $roomdatatype=$row['URTD_ROOM_TYPE'];
                    $loaddta[]=($roomdatatype);
                }
            }
        }
        elseif(($USU_unit_optionfetch==1)||($USU_unit_optionfetch==7))
        {
            if($USU_unit_optionfetch==1){
                $loaddta=$this->Common_function->GetActiveUnit();
            }
            elseif($USU_unit_optionfetch==7){
                $arraydata=$this->USU_Initial_data();
                $loaddta=$arraydata[0];
            }
        }
        $resultobject=array();
        $resultobject[]=(object)["USU_loaddata_searchby"=>$loaddta,"USU_flag"=>$USU_unit_optionfetch,"USU_parentfunc_obj"=>$USU_parentfunc,"USU_loadlb_obj"=>$USU_load_lb];
        return $resultobject;
    }
    public function USU_already_exists($USU_inventory_unitno,$USU_typeofcard,$USU_flag_card_unitno,$USU_parent_func,$UserStamp){
        $USU_cardarray=[];
        $USU_loadunitno=[];
        $USU_flag_unitno=false;
        $USU_arr_custexpense=[];
        $this->load->model('Eilib/Common_function');
        if(($USU_flag_card_unitno==5)||($USU_flag_card_unitno==8)||($USU_flag_card_unitno=='USU_flag_check_accesscard')){
            if($USU_flag_card_unitno==5) //SEARCH BY ROOM TYPE
                $USU_flag_unitno=$this->Common_function->Check_ExistsRmType($USU_inventory_unitno);
            elseif($USU_flag_card_unitno==8)//SEARCH BY STAMP TYPE
                $USU_flag_unitno=$this->Common_function->Check_ExistsStampduty($USU_inventory_unitno);
            elseif($USU_flag_card_unitno=='USU_flag_check_accesscard')
                $USU_flag_unitno=$this->Common_function->Check_ExistsCard($USU_inventory_unitno);
        }
        else{
            if($USU_flag_card_unitno=='USU_flag_check_unitno'){
                $USU_cardunitno_query="SELECT * FROM UNIT WHERE UNIT_NO=".$USU_inventory_unitno."";
            }
            elseif($USU_flag_card_unitno=='USU_flag_check_cardunitno'){
                $USU_twodim_card=array(10=>['UASD.UASD_ACCESS_ACTIVE'],11=>['UASD.UASD_ACCESS_LOST'],12=>['UASD.UASD_ACCESS_INVENTORY']);
                $USU_cardunitno_query = "SELECT DISTINCT UASD.UASD_ACCESS_CARD FROM UNIT_ACCESS_STAMP_DETAILS UASD, UNIT U, UNIT_DETAILS UD WHERE (U.UNIT_ID = UD.UNIT_ID) AND (U.UNIT_ID = UASD.UNIT_ID) AND ".$USU_twodim_card[$USU_typeofcard][0]." ='X' AND U.UNIT_ID = (SELECT UNIT_ID FROM UNIT WHERE UNIT_NO =".$USU_inventory_unitno.") ORDER BY UASD.UASD_ACCESS_CARD ASC";
            }
            elseif($USU_flag_card_unitno=='USU_transac_check_accesscard'){
                $USU_cardunitno_query="SELECT UASD_ACCESS_CARD FROM UNIT_ACCESS_STAMP_DETAILS WHERE UASD_ID IN (SELECT UASD_ID FROM CUSTOMER_ACCESS_CARD_DETAILS WHERE UASD_ID=(SELECT UASD_ID FROM UNIT_ACCESS_STAMP_DETAILS WHERE UASD_ACCESS_CARD='".$USU_inventory_unitno."'))OR UASD_ID IN (SELECT UASD_ID FROM CUSTOMER_LP_DETAILS WHERE UASD_ID=(SELECT UASD_ID FROM UNIT_ACCESS_STAMP_DETAILS WHERE UASD_ACCESS_CARD='".$USU_inventory_unitno."'))OR UASD_ACCESS_CARD IN (SELECT EPNC_NUMBER FROM EXPENSE_PURCHASE_NEW_CARD WHERE EPNC_NUMBER='".$USU_inventory_unitno."')OR UASD_ID IN (SELECT UASD_ID FROM EMPLOYEE_CARD_DETAILS WHERE UASD_ID=(SELECT UASD_ID FROM UNIT_ACCESS_STAMP_DETAILS WHERE UASD_ACCESS_CARD='".$USU_inventory_unitno."'))";
            }
            elseif($USU_flag_card_unitno=='USU_transac_check_roomtype'){
                $USU_cardunitno_query="SELECT * FROM CUSTOMER_ENTRY_DETAILS WHERE UASD_ID IN (SELECT UASD_ID FROM UNIT_ACCESS_STAMP_DETAILS WHERE UASD_ACCESS_CARD='".$USU_inventory_unitno."')";
            }
            elseif(($USU_flag_card_unitno=='USU_flag_transac_check_enddate')||($USU_flag_card_unitno=='USU_flag_transac_check_unitno')){
                if($USU_flag_card_unitno=='USU_flag_transac_check_unitno'){
                    $arraydata=$this->USU_Initial_data();
                    $USU_loadunitno=$arraydata[0];
                }
                $USU_enddate_query="CALL SP_UNIT_CHECK_TRANSACTION((SELECT UNIT_ID FROM UNIT WHERE UNIT_NO=".$USU_inventory_unitno."),'".$UserStamp."',@SDATE,@EDATE,@TEMP_CHKTRANS,@TEMP_CUST,@TEMP_CUSTLP)";
                $this->db->query($USU_enddate_query);
                $USU_cardunitno_query = 'SELECT @SDATE AS SDATE,@EDATE AS EDATE,@TEMP_CHKTRANS AS TEMP_CHKTRANS,@TEMP_CUST AS TEMP_CUST,@TEMP_CUSTLP AS TEMP_CUSTLP';
            }
            $USU_card_rs = $this->db->query($USU_cardunitno_query);
//            $USU_flag_results=array();
            if ($USU_card_rs->num_rows() > 0)
            {
                foreach($USU_card_rs->result_array() as $row){
                    $USU_flag_unitno=true;
                    $USU_cardarray[]=$USU_card_rs->row(1);
                    if(($USU_flag_card_unitno=='USU_flag_transac_check_enddate')||($USU_flag_card_unitno=='USU_flag_transac_check_unitno')){
                        $USU_arr_custexpense[]=$USU_card_rs.row(1);
                        $USU_arr_custexpense[]=$USU_card_rs.row(2);
                        $drop_query = "DROP TABLE ".$USU_card_rs.row(3);
                        $this->db->query($drop_query);
                        $drop_query = "DROP TABLE ".$USU_card_rs.row(4);
                        $this->db->query($drop_query);
                        $drop_query = "DROP TABLE ".$USU_card_rs.row(5);
                        $this->db->query($drop_query);
                    }
                }
            }
        }
        $USU_flag_results[]=(object)["USU_obj_loadunitno"=>$USU_loadunitno,"USU_flag_check"=>$USU_flag_card_unitno,"USU_loaddata_searchby"=>$USU_cardarray,"USU_truefalse_flag"=>$USU_flag_unitno,"USU_loadlb_obj"=>'USU_loadlb_inventory',"USU_parentfunc_obj"=>$USU_parent_func,"USU_objarr_custexpense"=>$USU_arr_custexpense];
        return $USU_flag_results;
    }
    public function Usu_flext_table($USU_unit_searchby,$USU_dutyamt_fromamt,$USU_dutyamt_toamt,$USU_payment_frmamt,$USU_payment_toamt,$USU_frmdate,$USU_enddate,$USU_all_searchby,$USU_accesscard,$timeZoneFormat,$USERSTAMP){
        $USU_parent_updation='';$j=0;$USU_stamp_rowarray_val=[];
        if(($USU_frmdate!='')&&($USU_enddate!=''))
        {
            $USU_frmdate = date('Y-m-d',strtotime($USU_frmdate));
            $USU_enddate = date('Y-m-d',strtotime($USU_enddate));
        }
        if(($USU_unit_searchby==2)||($USU_unit_searchby==1)||($USU_unit_searchby==9))
        {
            if($USU_unit_searchby==2)//SEARCH BY STAMP DUTY AMOUNT
            {
                $USU_select_dutyamt_room_inventory ="SELECT U.UNIT_NO,U.UNIT_ID,URTD.URTD_ID,URTD.URTD_ROOM_TYPE,UASD.UASD_ID,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(UASD.UASD_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP,UASD.UASD_COMMENTS,UASD.UASD_ACCESS_CARD,UASD.UASD_ACCESS_ACTIVE,UASD.UASD_ACCESS_INVENTORY,UASD.UASD_ACCESS_LOST, DATE_FORMAT(UASD.UASD_STAMPDUTYDATE,'%d-%m-%Y') AS UASD_STAMPDUTYDATE,UASD.UASD_STAMPDUTYAMT,USDT.USDT_DATA FROM UNIT_ACCESS_STAMP_DETAILS UASD LEFT JOIN UNIT_ROOM_TYPE_DETAILS URTD ON (UASD.URTD_ID = URTD.URTD_ID) LEFT JOIN UNIT_STAMP_DUTY_TYPE USDT ON (USDT.USDT_ID = UASD.USDT_ID),UNIT U,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=UASD.ULD_ID AND (U.UNIT_ID = UASD.UNIT_ID) AND (UASD.UASD_STAMPDUTYAMT  BETWEEN ".$USU_dutyamt_fromamt." AND ".$USU_dutyamt_toamt.") ORDER BY U.UNIT_NO,UASD.UASD_STAMPDUTYAMT";
            }
            elseif($USU_unit_searchby==1){//SEARCH BY INVENTORY CARD
                $USU_select_dutyamt_room_inventory ="SELECT U.UNIT_NO,U.UNIT_ID,URTD.URTD_ID,URTD.URTD_ROOM_TYPE,UASD.UASD_ID,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(UASD.UASD_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP,UASD.UASD_COMMENTS,UASD.UASD_ACCESS_CARD,UASD.UASD_ACCESS_ACTIVE,UASD.UASD_ACCESS_INVENTORY,UASD.UASD_ACCESS_LOST,DATE_FORMAT(UASD.UASD_STAMPDUTYDATE,'%d-%m-%Y') AS UASD_STAMPDUTYDATE,UASD.UASD_STAMPDUTYAMT,USDT.USDT_DATA FROM UNIT_ACCESS_STAMP_DETAILS UASD LEFT JOIN UNIT_ROOM_TYPE_DETAILS URTD ON (UASD.URTD_ID = URTD.URTD_ID) LEFT JOIN UNIT_STAMP_DUTY_TYPE USDT ON (USDT.USDT_ID = UASD.USDT_ID),UNIT U ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=UASD.ULD_ID AND  (U.UNIT_ID = UASD.UNIT_ID) AND (UASD.UASD_ACCESS_CARD=".$USU_accesscard.")";
            }
            elseif($USU_unit_searchby==9){//SEARCH BY ROOMTYPE WITH UNIT
                $USU_select_dutyamt_room_inventory = "SELECT U.UNIT_NO,U.UNIT_ID,URTD.URTD_ID,URTD.URTD_ROOM_TYPE,UASD.UASD_ID,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(UASD.UASD_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP,UASD.UASD_COMMENTS,UASD.UASD_ACCESS_CARD,UASD.UASD_ACCESS_ACTIVE,UASD.UASD_ACCESS_INVENTORY,UASD.UASD_ACCESS_LOST,DATE_FORMAT(UASD.UASD_STAMPDUTYDATE,'%d-%m-%Y') AS UASD_STAMPDUTYDATE,UASD.UASD_STAMPDUTYAMT,USDT.USDT_DATA,USDT.USDT_ID FROM UNIT U,UNIT_ACCESS_STAMP_DETAILS UASD LEFT JOIN UNIT_ROOM_TYPE_DETAILS URTD  ON UASD.URTD_ID = URTD.URTD_ID  LEFT JOIN UNIT_STAMP_DUTY_TYPE USDT ON USDT.USDT_ID = UASD.USDT_ID ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=UASD.ULD_ID AND  U.UNIT_ID = UASD.UNIT_ID AND URTD.URTD_ROOM_TYPE ='".$USU_all_searchby."' ORDER BY U.UNIT_NO,URTD.URTD_ROOM_TYPE";
            }
            $USU_row_result=$this->db->query($USU_select_dutyamt_room_inventory);
            $USU_flex_twodimens_arr=array();
            if ($USU_row_result->num_rows() > 0)
            {
                foreach($USU_row_result->result_array() as $row){
                    $USU_flex_arr=[];
                    $USU_flex_arr[]=$row["UASD_ID"];
                    $USU_flex_arr[]=$row["UNIT_NO"];
                    $USU_flex_arr[]=$row["UASD_ACCESS_CARD"];
                    $USU_flex_arr[]=$row["UASD_ACCESS_ACTIVE"];
                    $USU_flex_arr[]=$row["UASD_ACCESS_INVENTORY"];
                    $USU_flex_arr[]=$row["UASD_ACCESS_LOST"];
                    $USU_flex_arr[]=$row["URTD_ROOM_TYPE"];
                    $USU_flex_arr[]=$row["UASD_STAMPDUTYDATE"];
                    $USU_flex_arr[]=$row["USDT_DATA"];
                    $USU_flex_arr[]=$row["UASD_STAMPDUTYAMT"];
                    $USU_flex_arr[]=$row["UASD_COMMENTS"];
                    $USU_flex_arr[]=$row["ULD_LOGINID"];
                    $USU_flex_arr[]=$row["TIMESTAMP"];
                    $USU_flex_twodimens_arr[]=($USU_flex_arr);
                }
            }
        }
        elseif(($USU_unit_searchby==3)||($USU_unit_searchby==6)||($USU_unit_searchby==4)||($USU_unit_searchby==7))
        {
            if($USU_unit_searchby==3)//SEARCH BY ENDDATE
            {
                $USU_select_unit_startenddate = "SELECT U.UNIT_NO,U.UNIT_ID, UAD.UACD_ACC_NO, UAD.UACD_ACC_NAME, UAD.UACD_BANK_CODE, UAD.UACD_BRANCH_CODE,UAD.UACD_BANK_ADDRESS,DATE_FORMAT(CONVERT_TZ(UD.UD_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP, ULD.ULD_LOGINID,UD.UD_NON_EI,DATE_FORMAT(UD.UD_START_DATE,'%d-%m-%Y') AS UD_START_DATE,DATE_FORMAT(UD.UD_END_DATE,'%d-%m-%Y') AS UD_END_DATE,UD.UD_OBSOLETE,UD.UD_PAYMENT, UD.UD_DEPOSIT,UD.UD_COMMENTS FROM UNIT U LEFT JOIN UNIT_ACCOUNT_DETAILS UAD ON (U.UNIT_ID = UAD.UNIT_ID) LEFT JOIN UNIT_DETAILS UD ON (U.UNIT_ID = UD.UNIT_ID),USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=UD.ULD_ID AND  UD.UD_END_DATE BETWEEN '".$USU_frmdate."' AND '".$USU_enddate."' ORDER BY U.UNIT_NO,UD.UD_END_DATE";
            }
            elseif($USU_unit_searchby==6){// SEARCH BY START DATE
                $USU_select_unit_startenddate = "SELECT U.UNIT_NO,U.UNIT_ID, UAD.UACD_ACC_NO, UAD.UACD_ACC_NAME, UAD.UACD_BANK_CODE, UAD.UACD_BRANCH_CODE,UAD.UACD_BANK_ADDRESS,DATE_FORMAT(CONVERT_TZ(UD.UD_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP, ULD.ULD_LOGINID,UD.UD_NON_EI,DATE_FORMAT(UD.UD_START_DATE,'%d-%m-%Y') AS UD_START_DATE,DATE_FORMAT(UD.UD_END_DATE,'%d-%m-%Y') AS UD_END_DATE,UD.UD_OBSOLETE,UD.UD_PAYMENT, UD.UD_DEPOSIT,UD.UD_COMMENTS FROM UNIT U LEFT JOIN UNIT_ACCOUNT_DETAILS UAD ON (U.UNIT_ID = UAD.UNIT_ID) LEFT JOIN UNIT_DETAILS UD ON (U.UNIT_ID = UD.UNIT_ID) ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=UD.ULD_ID AND  UD.UD_START_DATE BETWEEN '".$USU_frmdate."' AND '".$USU_enddate."' ORDER BY U.UNIT_NO,UD.UD_START_DATE";
            }
            elseif($USU_unit_searchby==7){//SEARCH BY UNIT
                $USU_select_unit_startenddate = "SELECT U.UNIT_NO,U.UNIT_ID, UAD.UACD_ACC_NO, UAD.UACD_ACC_NAME, UAD.UACD_BANK_CODE, UAD.UACD_BRANCH_CODE,UAD.UACD_BANK_ADDRESS,DATE_FORMAT(CONVERT_TZ(UD.UD_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP, ULD.ULD_LOGINID,UD.UD_NON_EI,DATE_FORMAT(UD.UD_START_DATE,'%d-%m-%Y') AS UD_START_DATE,DATE_FORMAT(UD.UD_END_DATE,'%d-%m-%Y') AS UD_END_DATE,UD.UD_OBSOLETE,UD.UD_PAYMENT, UD.UD_DEPOSIT,UD.UD_COMMENTS FROM UNIT U LEFT JOIN UNIT_ACCOUNT_DETAILS UAD ON (U.UNIT_ID = UAD.UNIT_ID) LEFT JOIN UNIT_DETAILS UD ON (U.UNIT_ID = UD.UNIT_ID) ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=UD.ULD_ID AND U.UNIT_NO =".$USU_all_searchby."" ;
                $USU_select_unit_stampdetail="SELECT UASD.UASD_ACCESS_CARD,UASD.UASD_ACCESS_ACTIVE,UASD.UASD_ACCESS_INVENTORY,UASD.UASD_ACCESS_LOST,URTD.URTD_ROOM_TYPE,DATE_FORMAT(UASD.UASD_STAMPDUTYDATE,'%d-%m-%Y') AS UASD_STAMPDUTYDATE,UASD.UASD_STAMPDUTYAMT,USDT.USDT_DATA,UASD.UASD_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(UASD.UASD_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP FROM  UNIT_ACCESS_STAMP_DETAILS UASD LEFT JOIN UNIT_ROOM_TYPE_DETAILS URTD ON (UASD.URTD_ID = URTD.URTD_ID) LEFT JOIN UNIT_STAMP_DUTY_TYPE USDT ON (USDT.USDT_ID = UASD.USDT_ID),UNIT U ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=UASD.ULD_ID AND (UASD.UNIT_ID = U.UNIT_ID) AND (U.UNIT_NO=".$USU_all_searchby.")";
                $USU_rs_unit_stampdetail=$this->db->query($USU_select_unit_stampdetail);
                if ($USU_rs_unit_stampdetail->num_rows() > 0)
                {
                    foreach($USU_rs_unit_stampdetail->result_array() as $row){
                        $j=$j+1;
                        for ($x=1; $x<=11; $x++){
                            $USU_stamp_rowarray_val[]=($USU_rs_unit_stampdetail->row($x));
                        }
                    }
                }
            }
            elseif($USU_unit_searchby==4){//SEARCH BY PAYMENT
                $USU_select_unit_startenddate = "SELECT U.UNIT_NO,U.UNIT_ID, UAD.UACD_ACC_NO, UAD.UACD_ACC_NAME, UAD.UACD_BANK_CODE, UAD.UACD_BRANCH_CODE,UAD.UACD_BANK_ADDRESS,DATE_FORMAT(CONVERT_TZ(UD.UD_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP, ULD.ULD_LOGINID,UD.UD_NON_EI,DATE_FORMAT(UD.UD_START_DATE,'%d-%m-%Y') AS UD_START_DATE,DATE_FORMAT(UD.UD_END_DATE,'%d-%m-%Y') AS UD_END_DATE,UD.UD_OBSOLETE,UD.UD_PAYMENT, UD.UD_DEPOSIT,UD.UD_COMMENTS FROM UNIT U LEFT JOIN UNIT_ACCOUNT_DETAILS UAD ON (U.UNIT_ID = UAD.UNIT_ID) LEFT JOIN UNIT_DETAILS UD ON (U.UNIT_ID = UD.UNIT_ID) ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=UD.ULD_ID AND  UD.UD_PAYMENT BETWEEN ".$USU_payment_frmamt." and ".$USU_payment_toamt." ORDER BY U.UNIT_NO,UD.UD_PAYMENT";
            }
            $USU_rs_startend_unitno=$this->db->query($USU_select_unit_startenddate);
            if ($USU_rs_startend_unitno->num_rows() > 0)
            {
                foreach($USU_rs_startend_unitno->result_array() as $row){
                    $USU_flex_arr=[];
                    $USU_flex_arr[]=$row["UNIT_ID"];
                    $USU_flex_arr[]=$row["UNIT_NO"];
                    $USU_flex_arr[]=$row["UD_START_DATE"];
                    $USU_flex_arr[]=$row["UD_END_DATE"];
                    $USU_flex_arr[]=$row["UD_OBSOLETE"];
                    $USU_flex_arr[]=$row["UD_NON_EI"];
                    $USU_flex_arr[]=$row["UD_PAYMENT"];
                    $USU_flex_arr[]=$row["UD_DEPOSIT"];
                    $USU_flex_arr[]=$row["UACD_ACC_NO"];
                    $USU_flex_arr[]=$row["UACD_ACC_NAME"];
                    $USU_flex_arr[]=$row["UACD_BANK_CODE"];
                    $USU_flex_arr[]=$row["UACD_BRANCH_CODE"];
                    $USU_flex_arr[]=$row["UACD_BANK_ADDRESS"];
                    $USU_flex_arr[]=$row["UD_COMMENTS"];
                    $USU_flex_arr[]=$row["ULD_LOGINID"];
                    $USU_flex_arr[]=$row["TIMESTAMP"];
                    $USU_flex_twodimens_arr[]=($USU_flex_arr);
                }
            }
        }
        else if($USU_unit_searchby==8)//SEARCH BY STAMP TYPE
        {
            $USU_select_stamptype = "SELECT USDT.USDT_ID,USDT.USDT_DATA,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(USDT.USDT_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP FROM UNIT_STAMP_DUTY_TYPE USDT,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=USDT.ULD_ID ORDER BY USDT.USDT_DATA ASC";
            $USU_rs_stamptype=$this->db->query($USU_select_stamptype);
            if ($USU_rs_stamptype->num_rows() > 0)
            {
                foreach($USU_rs_stamptype->result_array() as $row){
                    $USU_flex_arr=[];
                    $USU_stamp_id=$row["USDT_ID"];
                    $USU_stamp_type=$row["USDT_DATA"];
                    $USU_userstamp_stamp=$row["ULD_LOGINID"];
                    $USU_timestamp_stamp=$row["TIMESTAMP"];
                    $USU_flex_arr[]=($USU_stamp_id);
                    $USU_flex_arr[]=($USU_stamp_type);
                    $USU_flex_arr[]=($USU_userstamp_stamp);
                    $USU_flex_arr[]=($USU_timestamp_stamp);
                    $USU_flex_twodimens_arr[]=($USU_flex_arr);
                }
            }
        }
        else if($USU_unit_searchby==5)//SEARCH BY ROOM TYPE
        {
            $USU_select_roomtype = "SELECT URTD.URTD_ID,URTD.URTD_ROOM_TYPE,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(URTD.URTD_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP FROM UNIT_ROOM_TYPE_DETAILS URTD,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=URTD.ULD_ID ORDER BY URTD.URTD_ROOM_TYPE ASC";
            $USU_rs_roomtype=$this->db->query($USU_select_roomtype);
            if ($USU_rs_roomtype->num_rows() > 0)
            {
                foreach($USU_rs_roomtype->result_array() as $row){
                    $USU_flex_arr=[];
                    $USU_flex_arr[]=$row["URTD_ID"];
                    $USU_flex_arr[]=$row["URTD_ROOM_TYPE"];
                    $USU_flex_arr[]=$row["ULD_LOGINID"];
                    $USU_flex_arr[]=$row["TIMESTAMP"];
                    $USU_flex_twodimens_arr[]=($USU_flex_arr);
                }
            }
        }
        $USU_flex_result =(object)["USU_flag"=>$USU_unit_searchby,"USU_flex_values"=>$USU_flex_twodimens_arr,"USU_parentfunc_obj"=>$USU_parent_updation,"USU_obj_stamp_rowarray_val"=>[$USU_stamp_rowarray_val,$j]];
        return $USU_flex_result;
    }
}
