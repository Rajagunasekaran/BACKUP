<?php
class Mdl_unit_creation_search_update extends CI_Model{
    public function Initial_data($ErrorMessage,$flag){
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
}
