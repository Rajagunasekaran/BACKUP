<?php
class sample extends CI_Controller{
    public function sample1(){
        $this->load->view('test');
    }
    public function saveuser(){
        $data = array(
            'employee_name' => $this->input->post('employee'),
            'username' =>  $this->input->post('username'),
            'password' =>$this->input->post('password'),
            'email' => $this->input->post('useremail'),
            'rc_id' => $this->input->post('userrole'),
        );
        $this->load->model('testmodel');
        $this->testmodel->insert_entry( $data);
    }
    public function initialdata(){
        $this->load->model('testmodel');
        $query=$this->testmodel->initial_data();
        echo json_encode($query);
    }
}