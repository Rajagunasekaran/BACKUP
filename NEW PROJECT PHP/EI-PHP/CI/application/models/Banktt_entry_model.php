<?php
class Banktt_entry_model extends CI_Model {
    public function Initial_data()
    {
        $this->db->select('BCN_DATA');
        $this->db->from('BANKTT_CONFIGURATION');
        $this->db->where('CGN_ID=69');
        $this->db->order_by('BCN_DATA');
        $query = $this->db->get();
        $result1 = $query->result();

        $this->db->select('BTM_DATA');
        $this->db->from('BANK_TRANSFER_MODELS');
        $this->db->where('BTM_OBSOLETE IS NULL');
        $this->db->order_by('BTM_DATA');
        $query = $this->db->get();
        $result2 = $query->result();

        $this->db->select('UNIT_NO');
        $this->db->from('UNIT');
        $this->db->order_by('UNIT_NO');
        $query = $this->db->get();
        $result3 = $query->result();

        $this->db->select('BCN_DATA');
        $this->db->from('BANKTT_CONFIGURATION');
        $this->db->where('CGN_ID=71');
        $this->db->order_by('BCN_DATA');
        $query = $this->db->get();
        $result4 = $query->result();

        $this->db->select('EMC_DATA');
        $this->db->from('ERROR_MESSAGE_CONFIGURATION');
        $this->db->where('EMC_ID IN (1,2,3,6,247,248,400)');
        $query = $this->db->get();
        $result5 = $query->result();

        return $result[]=array($result1,$result2,$result3,$result4,$result5);
    }
    public function Customer_name($unit)
    {
        $this->db->select('DISTINCT C.CUSTOMER_ID,CONCAT(CUSTOMER_FIRST_NAME," ",CUSTOMER_LAST_NAME) AS CUSTOMER_NAME',FALSE);
        $this->db->from('UNIT U,CUSTOMER_ENTRY_DETAILS CED,CUSTOMER C');
        $this->db->where('C.CUSTOMER_ID=CED.CUSTOMER_ID AND CED.UNIT_ID=U.UNIT_ID AND U.UNIT_NO='.$unit);
        $this->db->order_by('C.CUSTOMER_FIRST_NAME','ASC');
        $query = $this->db->get();
        $customers = $query->result();
        return $customers;

    }
}