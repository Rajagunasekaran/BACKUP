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
    public function Cardnodetails(){
        global $USERSTAMP;
        $unitno= $this->input->post('unitno');
        $cardno= $this->input->post('cardno');
        $option= $this->input->post('option');
        $this->load->model('Mdl_access_card_view');
        $cardquery=$this->Mdl_access_card_view->Cardno_details($unitno,$cardno,$option,$USERSTAMP);
        echo json_encode($cardquery);
    }
    public function Customerid(){
        $custname= $this->input->post('CV_name');
        $this->load->model('Mdl_access_card_view');
        $custquery=$this->Mdl_access_card_view->Customer_id($custname);
        echo json_encode($custquery);
    }
    public function Customervalues(){
        global $USERSTAMP;
        $custid= $this->input->post('CV_cid');
        $this->load->model('Mdl_access_card_view');
        $custdtlquery=$this->Mdl_access_card_view->Customer_values($custid,$USERSTAMP);
        echo json_encode($custdtlquery);
    }
}