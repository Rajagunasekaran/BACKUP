<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
$timeZoneFrmt=$timeZoneFormat;
class Ctrl_Unit_Creation_Search_Update extends CI_Controller{
    public function index(){
        $this->load->view('UNIT/Vw_Unit_Creation_Search_Update');
    }
    public function Initialdata(){
        $flag= $this->input->post('flag');
        $this->load->model('Mdl_unit_creation_search_update');
        $query=$this->Mdl_unit_creation_search_update->Initial_data($flag);
        echo json_encode($query);
    }
    public function Check_existinginput(){
        $source= $this->input->post('source');
        $chkinput= $this->input->post('chkinput');
        $this->load->model('Mdl_unit_creation_search_update');
        $query=$this->Mdl_unit_creation_search_update->Check_existing_input($source,$chkinput);
        echo json_encode($query);
    }
    public function Unitsaveprocess(){
        global $USERSTAMP;
        $UC_nonei= $this->input->post('UC_cb_nonEI');
        $UC_newroomtype = $this->input->post('UC_tb_newroomtype');
        $UC_newstamptype = $this->input->post('UC_tb_newstamptype');
        $UC_oldroomtype = $this->input->post('UC_lb_roomtype');
        $UC_oldstamptype = $this->input->post('UC_lb_stamptype');
        $this->load->model('Mdl_unit_creation_search_update');
        $query=$this->Mdl_unit_creation_search_update->Unit_saveprocess($UC_nonei,$UC_newroomtype,$UC_newstamptype,$UC_oldroomtype,$UC_oldstamptype,$USERSTAMP);
        echo json_encode($query);
    }
    //--------------------------------------------UNIT SEARCH AND UPDATE---------------------------------------------//
    public function USU_Initialdata(){
        $this->load->model('Mdl_unit_creation_search_update');
        $query=$this->Mdl_unit_creation_search_update->Usu_initial_data();
        echo json_encode($query);
    }
    public function USU_Searchbyoption(){
        $option = $this->input->post('option');
        $USU_parentfunc_load = $this->input->post('USU_parentfunc_load');
        $USU_not_load_lb = $this->input->post('USU_not_load_lb');
        $this->load->model('Mdl_unit_creation_search_update');
        $resultquery=$this->Mdl_unit_creation_search_update->Usu_searchby_option($option,$USU_parentfunc_load,$USU_not_load_lb);
        echo json_encode($resultquery);
    }
    public function USU_AlreadyExists(){
        global $USERSTAMP;
        $inventory_unitno = $this->input->post('inventory_unitno');
        $typeofcard = $this->input->post('typeofcard');
        $flag_card_unitno = $this->input->post('flag_card_unitno');
        $USU_parent_func = $this->input->post('USU_parent_func');
        $this->load->model('Mdl_unit_creation_search_update');
        $resultquery=$this->Mdl_unit_creation_search_update->USU_already_exists($inventory_unitno,$typeofcard,$flag_card_unitno,$USU_parent_func,$USERSTAMP);
        echo json_encode($resultquery);
    }
    public function USU_flexttable(){
        global $timeZoneFrmt;
        global $USERSTAMP;
        $USU_all_searchby='';
        $USU_unit_searchby = $this->input->post('USU_lb_searchby');
        $USU_dutyamt_fromamt = $this->input->post('USU_tb_dutyamt_fromamt');
        $USU_dutyamt_toamt = $this->input->post('USU_tb_dutyamt_toamt');
        $USU_payment_frmamt = $this->input->post('USU_tb_payment_fromamt');
        $USU_payment_toamt = $this->input->post('USU_tb_payment_toamt');
        $USU_frmdate = $this->input->post('USU_db_fromdate');
        $USU_enddate = $this->input->post('USU_db_todate');
        $USU_unino=$this->input->post('USU_lb_unitno');
        $USU_roomtype=$this->input->post('USU_lb_roomtype');
        $USU_accesscard = $this->input->post('USU_lb_cardno');
        if($USU_unino!='SELECT' && $USU_unino!=''){
            $USU_all_searchby=$USU_unino;
        }
        elseif($USU_roomtype!='SELECT' && $USU_roomtype!=''){
            $USU_all_searchby=$USU_roomtype;
        }
        $this->load->model('Mdl_unit_creation_search_update');
        $resultquery=$this->Mdl_unit_creation_search_update->Usu_flext_table($USU_unit_searchby,$USU_dutyamt_fromamt,$USU_dutyamt_toamt,$USU_payment_frmamt,$USU_payment_toamt,$USU_frmdate,$USU_enddate,$USU_all_searchby,$USU_accesscard,$timeZoneFrmt,$USERSTAMP);
        echo json_encode($resultquery);
    }
    public function USU_roomstamp_unitno(){
        $USU_unitno=$this->input->post("unitstamp_unitno");
        $this->load->model('Mdl_unit_creation_search_update');
        $resquery=$this->Mdl_unit_creation_search_update->USU_roomstampunitno($USU_unitno);
        echo json_encode($resquery);
    }
    public function USU_func_update(){
        global $USERSTAMP;
        $USU_obj_formvalues=$this->input->post("USU_obj_formvalues");
        $USU_obj_rowvalue=$this->input->post("USU_obj_rowvalue");
        $USU_obj_flex=$this->input->post("USU_obj_flex");
        $this->load->model('Mdl_unit_creation_search_update');
        $resltquery=$this->Mdl_unit_creation_search_update->USU_funcupdate($USU_obj_formvalues,$USU_obj_rowvalue,$USU_obj_flex,$USERSTAMP);
        echo json_encode($resltquery);
    }
}