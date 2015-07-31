<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
class Ctrl_Access_Card_View extends CI_Controller{
    public function index(){
        $this->load->view('CUSTOMER/Vw_Access_Card_View');
    }
    public function Initialdata(){
        $errorlist= $this->input->post('ErrorList');
        $this->load->model('Eilib/Common_function');
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);

        $this->load->model('Mdl_access_card_view');
        $query=$this->Mdl_access_card_view->Initial_data($ErrorMessage);
        echo json_encode($query);
    }
}