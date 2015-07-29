<?php
class Expense_staff_daily_entry_controller extends CI_Controller{
    public function index(){
        $this->load->view('Expense_staff_daily_entry_view');
    }
    public function Initialdata(){
        $this->load->model('Common');
        $errorlist= $this->input->post('ErrorList');
        $ErrorMessage= $this->Common->getErrorMessageList($errorlist);

        $this->load->model('Expense_staff_daily_entry_model');
        $query=$this->Expense_staff_daily_entry_model->Initial_data($ErrorMessage);
        echo json_encode($query);
    }
}