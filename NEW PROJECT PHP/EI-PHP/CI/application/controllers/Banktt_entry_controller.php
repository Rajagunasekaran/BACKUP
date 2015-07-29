<?php
class Banktt_entry_controller extends CI_Controller{
    public function Banktt_entryform(){
        $this->load->view('Banktt_entry_view');
    }
    public function Initialdata(){
        $this->load->model('Banktt_entry_model');
        $query=$this->Banktt_entry_model->Initial_data();
        echo json_encode($query);
    }
    public function Customername(){
        $unitno= $this->input->post('unitno');
        $this->load->model('Banktt_entry_model');
        $query=$this->Banktt_entry_model->Customer_name($unitno);
        echo json_encode($query);
    }
}