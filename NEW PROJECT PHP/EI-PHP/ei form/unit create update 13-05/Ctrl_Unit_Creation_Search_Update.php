<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
class Ctrl_Unit_Creation_Search_Update extends CI_Controller{
    public function index(){
        $this->load->view('UNIT/Vw_Unit_Creation_Search_Update');
    }
    public function Initialdata(){
        $errorlist= $this->input->post('ErrorList');
        $flag= $this->input->post('flag');
        $this->load->model('Eilib/Common_function');
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);

        $this->load->model('Mdl_unit_creation_search_update');
        $query=$this->Mdl_unit_creation_search_update->Initial_data($ErrorMessage,$flag);
        echo json_encode($query);
    }
    public function Check_existinginput(){
        $source= $this->input->post('source');
        $chkinput= $this->input->post('chkinput');
        $this->load->model('Mdl_unit_creation_search_update');
        $query=$this->Mdl_unit_creation_search_update->Check_existing_input($source,$chkinput);
        echo json_encode($query);
    }
}