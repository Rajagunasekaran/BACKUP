<?php
class Mdl_access_card_view extends CI_Model{
    public function Initial_data($ErrorMessage){
        $this->db->select('UNIT_NO');
        $this->db->from('UNIT');
        $this->db->order_by('UNIT_NO');
        $query1 = $this->db->get();
        $result1=[];
        foreach($query1->result_array() as $row){
            $result1[]=$row['UNIT_NO'];
        }
        $this->db->select('UASD.UASD_ACCESS_CARD');
        $this->db->from('UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U');
        $this->db->where('U.UNIT_ID=UASD.UNIT_ID AND UASD.UASD_ACCESS_CARD IS NOT NULL');
        $this->db->order_by('UASD.UASD_ACCESS_CARD');
        $query2 = $this->db->get();
        $result2=[];
        foreach($query2->result_array() as $row){
            $result2[]=$row['UASD_ACCESS_CARD'];
        }
        $this->db->select('CONCAT(`CCN_ID`,"_",`CCN_DATA`) AS DATA',FALSE);
        $this->db->from('CUSTOMER_CONFIGURATION');
        $this->db->where('CCN_ID IN (18,21,31,40)');
        $this->db->order_by('CCN_DATA');
        $query3 = $this->db->get();
        $result3=[];
        foreach($query3->result_array() as $row){
            $result3[]=$row['DATA'];
        }
        $this->db->select('DISTINCT CONCAT(C.CUSTOMER_FIRST_NAME,"  ",C.CUSTOMER_LAST_NAME) AS CUSTOMERNAME',FALSE);
        $this->db->from('CUSTOMER C');
        $this->db->group_by('C.CUSTOMER_FIRST_NAME');
        $this->db->group_by('C.CUSTOMER_ID');
        $query4 = $this->db->get();
        $result4=[];
        foreach($query4->result_array() as $row){
            if($row['CUSTOMERNAME']!=null){
                $result4[]=$row['CUSTOMERNAME'];
            }
        }
        $resultset=array($result1,$result2,$result3,$ErrorMessage,$result4);
        return $resultset;
    }
}